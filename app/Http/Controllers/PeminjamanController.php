<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
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
}
