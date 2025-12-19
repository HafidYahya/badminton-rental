<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\HariLibur;
use App\Models\JamOperasional;
use App\Models\Lapangan;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SweetAlert2\Laravel\Swal;

class PeminjamanController extends Controller
{
    public function index($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('pages.customer.peminjaman', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_booking' => 'required|array|min:1',
            'jam_booking.*' => 'required',
            'tanggal_booking' => 'required|date',
            'bukti_pembayaran' => 'required|mimes:png,jpg,webp,jpeg|max:3000'
        ], [
            'bukti_pembayaran.mimes' => 'Harap kirim file .PNG, .JPG, .JPEG, .WEBP',
            'bukti_pembayaran.max' => 'Ukuran maksimal 3 MB',
        ]);
        $jam = $request->jam_booking;

        if (!$this->isJamBerurutan($jam)) {
            Swal::fire([
                'icon' => 'error',
                'title' => 'Jam Tidak Berurutan',
                'text' => 'Jam yang dipilih harus berurutan. Contoh: 08:00, 09:00, 10:00',
            ]);
            return back();
        }
        // Tangani Foto Bukti Pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti-pembayaran'), $fileName);
        }
        $jamBooking = $request->jam_booking; // ['08:00','09:00','10:00']

        sort($jamBooking);

        $jamBooking = collect($request->jam_booking)->sort()->values();

        $jamMulai = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->tanggal_booking . ' ' . $jamBooking->first()
        );

        $jamSelesai = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->tanggal_booking . ' ' . $jamBooking->last()
        )->addHour();


        $totalJam = count($jamBooking);
        $totalHarga = $request->harga_per_jam * $totalJam;

        DB::table('peminjaman')->insert([
            'p_customer_id' => $request->customer_id,
            'p_lapangan_id' => $request->lapangan_id,
            'p_harga_per_jam' => $request->harga_per_jam,
            'p_diskon' => null,
            'p_total_harga' => $totalHarga,
            'p_tanggal' => $request->tanggal_booking,
            'p_jam_mulai' => $jamMulai,
            'p_jam_selesai' => $jamSelesai,
            'p_total_jam' => $totalJam,
            'p_bukti_pembayaran' => $fileName,
            'p_alasan_cancel' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Swal::fire([
            'icon' => 'success',
            'title' => 'Pemesanan Berhasil',
            'text' => 'Silahkan cek riwayat pemesanan untuk melihat status pemesanan anda',
            'showConfirmButton' => true,
        ]);
        return back();
    }

    public function checkJam(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lapangan_id' => 'required'
        ]);

        $tanggal = Carbon::parse($request->tanggal);

        // Mapping hari
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $hari = $days[$tanggal->format('l')];

        // Cek hari libur
        $libur = HariLibur::where('is_active', 1)
            ->whereDate('hl_tanggal_mulai', '<=', $tanggal)
            ->whereDate('hl_tanggal_selesai', '>=', $tanggal)
            ->exists();

        // Jam operasional
        $operasional = JamOperasional::where('jo_hari', $hari)->first();

        if (!$operasional || $operasional->jo_is_hari_libur) {
            return response()->json([
                'libur' => true
            ]);
        }

        // Jam terbooking
        $jamTerbooking = [];

        $peminjaman = Peminjaman::where('p_lapangan_id', $request->lapangan_id)
            ->where('p_status', 'RUNNING')
            ->whereDate('p_tanggal', $tanggal)
            ->get();

        foreach ($peminjaman as $p) {
            $start = Carbon::parse($p->p_jam_mulai);
            $end   = Carbon::parse($p->p_jam_selesai);

            while ($start < $end) {
                $jamTerbooking[] = $start->format('H:i');
                $start->addHour();
            }
        }

        return response()->json([
            'libur' => false,
            'jam_buka' => substr($operasional->jo_jam_buka, 0, 5),
            'jam_tutup' => substr($operasional->jo_jam_tutup, 0, 5),
            'jam_terbooking' => $jamTerbooking
        ]);
    }

    // FUNGSI LOGIC
    private function isJamBerurutan($jamArray)
    {
        // Urutkan array jam
        sort($jamArray);

        // Loop cek apakah setiap jam berselisih 1 jam dari jam sebelumnya
        for ($i = 0; $i < count($jamArray) - 1; $i++) {
            $jamSekarang = (int) str_replace(':00', '', $jamArray[$i]);
            $jamBerikutnya = (int) str_replace(':00', '', $jamArray[$i + 1]);

            // Jika selisihnya bukan 1 jam, berarti tidak berurutan
            if ($jamBerikutnya - $jamSekarang !== 1) {
                return false;
            }
        }

        return true;
    }

    public function riwayat($id)
    {
        $peminjaman = Peminjaman::with(['customer', 'lapangan'])->where('p_customer_id', $id)->orderBy('created_at', 'desc')->get();
        return view('pages.customer.riwayat', compact('peminjaman'));
    }
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'alasan_cancel' => 'required|min:5'
        ], [
            'alasan_cancel.required' => 'Alasan pembatalan wajib diisi',
            'alasan_cancel.min' => 'Minimal 5 karakter'
        ]);

        $peminjaman = Peminjaman::where('p_id', $id)
            ->whereIn('p_status', ['PENDING', 'RUNNING'])
            ->firstOrFail();

        $diff = Carbon::today()->diffInDays(
            Carbon::parse($peminjaman->p_tanggal),
            false
        );

        if ($diff <= 1) {
            Swal::fire([
                'icon' => 'error',
                'title' => 'Pembatalan pesanan gagal',
                'text' => 'Maaf, pemesanan tidak bisa dibatalkan pada H-1 atau hari H',
                'showConfirmButton' => true
            ]);
            return redirect()->route('riwayat.booking', $peminjaman->p_customer_id);
        }

        $peminjaman->p_status = 'CANCEL';
        $peminjaman->p_alasan_cancel = $request->alasan_cancel;
        $peminjaman->save();

        Swal::fire([
            'icon' => 'success',
            'title' => 'Berhasil',
            'text' => 'Pemesanan berhasil dibatalkan',
        ]);

        return redirect()->route('riwayat.booking', $peminjaman->p_customer_id);
    }



    // ADMIN
    public function transaksi(Request $request)
    {
        $peminjaman = Peminjaman::with(['customer', 'lapangan'])
            ->when($request->status, function ($q) use ($request) {
                $q->where('p_status', $request->status);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();
        return view('pages.admin.peminjaman.index', compact('peminjaman'));
    }

    public function proses(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->p_status = $request->status;
        $peminjaman->save();
        Swal::fire([
            'icon' => 'success',
            'title' => 'Proses Berhasil',
            'text' => 'Status: ' . $peminjaman->p_status,
            'showConfirmButton' => true,
        ]);
        return back();
    }
}
