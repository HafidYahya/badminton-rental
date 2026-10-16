<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\HariLibur;
use App\Models\JamOperasional;
use App\Models\Lapangan;
use App\Models\Order;
use App\Models\Peminjaman;
use App\Services\PakasirService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
            'lapangan_id' => 'required|integer|exists:lapangan,l_id',
            'jam_booking' => 'required|array|min:1',
            'jam_booking.*' => 'required|date_format:H:i|distinct',
            'tanggal_booking' => 'required|date_format:Y-m-d|after_or_equal:today',
            'payment_method' => 'required|in:qris',
        ]);
        $jamBooking = collect($request->jam_booking)->sort()->values();

        if (!$this->isJamBerurutan($jamBooking->all())) {
            throw ValidationException::withMessages([
                'jam_booking' => 'Jam yang dipilih harus berurutan, misalnya 08:00, 09:00, 10:00.',
            ]);
        }

        $jamMulai = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->tanggal_booking . ' ' . $jamBooking->first(),
            config('app.timezone')
        );

        $jamSelesai = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->tanggal_booking . ' ' . $jamBooking->last(),
            config('app.timezone')
        )->addHour();

        $totalJam = count($jamBooking);
        $tanggal = Carbon::parse($request->tanggal_booking, config('app.timezone'));
        $customerId = Auth::guard('customer')->id();

        $booking = DB::transaction(function () use ($request, $jamBooking, $jamMulai, $jamSelesai, $totalJam, $tanggal, $customerId) {
            $this->expirePendingBookings();

            // Lock the court row so simultaneous requests cannot reserve the same time range.
            $lapangan = Lapangan::where('l_id', $request->lapangan_id)->lockForUpdate()->firstOrFail();
            if ($lapangan->l_status !== 'active') {
                throw ValidationException::withMessages(['lapangan_id' => 'Lapangan ini sedang tidak tersedia.']);
            }

            [$jamBuka, $jamTutup] = $this->getOperationalHours($tanggal);
            foreach ($jamBooking as $slot) {
                if ($slot < $jamBuka || $slot >= $jamTutup) {
                    throw ValidationException::withMessages(['jam_booking' => 'Jam yang dipilih berada di luar jam operasional.']);
                }
            }

            $conflict = Peminjaman::where('p_lapangan_id', $lapangan->l_id)
                ->whereDate('p_tanggal', $tanggal->toDateString())
                ->whereIn('p_status', ['PENDING', 'DIBAYAR', 'RUNNING'])
                ->where('p_jam_mulai', '<', $jamSelesai)
                ->where('p_jam_selesai', '>', $jamMulai)
                ->exists();

            if ($conflict) {
                throw ValidationException::withMessages(['jam_booking' => 'Salah satu jam yang dipilih sudah dipesan. Silakan pilih jam lain.']);
            }

            $hargaPerJam = (int) round((float) $lapangan->l_harga);
            $totalHarga = $hargaPerJam * $totalJam;
            if ($totalHarga < 500 || $totalHarga > 10_000_000) {
                throw ValidationException::withMessages([
                    'jam_booking' => 'Total transaksi QRIS harus antara Rp500 dan Rp10.000.000.',
                ]);
            }
            $booking = Peminjaman::create([
                'p_customer_id' => $customerId,
                'p_lapangan_id' => $lapangan->l_id,
                'p_harga_per_jam' => $hargaPerJam,
                'p_diskon' => null,
                'p_total_harga' => $totalHarga,
                'p_tanggal' => $tanggal->toDateString(),
                'p_jam_mulai' => $jamMulai,
                'p_jam_selesai' => $jamSelesai,
                'p_total_jam' => $totalJam,
                'p_alasan_cancel' => null,
            ]);

            $slug = config('services.pakasir.slug');
            if (!$slug) {
                throw new \RuntimeException('Konfigurasi proyek Pakasir belum lengkap.');
            }

            $booking->orders()->create([
                'order_id' => 'BD-' . Str::upper((string) Str::uuid()),
                'project_slug' => $slug,
                'is_sandbox' => (bool) config('services.pakasir.is_sandbox'),
                'payment_method' => $request->payment_method,
                'amount' => $totalHarga,
                'fee' => 0,
                'total_payment' => $totalHarga,
                'status' => 'initiating',
            ]);

            return $booking;
        }, 3);

        Swal::fire([
            'icon' => 'success',
            'title' => 'Pemesanan Berhasil',
            'text' => 'Silakan selesaikan pembayaran untuk mengonfirmasi pemesanan Anda.',
            'showConfirmButton' => true,
        ]);
        return redirect()->route('payment', ['id' => $booking->p_id]);
    }

    private function getOperationalHours(Carbon $tanggal): array
    {
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
        $libur = HariLibur::where('is_active', 1)
            ->whereDate('hl_tanggal_mulai', '<=', $tanggal)
            ->whereDate('hl_tanggal_selesai', '>=', $tanggal)
            ->exists();
        $operasional = JamOperasional::where('jo_hari', $hari)->first();

        if ($libur || !$operasional || $operasional->jo_is_hari_libur) {
            throw ValidationException::withMessages(['tanggal_booking' => 'Lapangan tidak beroperasi pada tanggal yang dipilih.']);
        }

        return [substr($operasional->jo_jam_buka, 0, 5), substr($operasional->jo_jam_tutup, 0, 5)];
    }

    private function expirePendingBookings(): void
    {
        DB::transaction(function () {
            $expiredBookingIds = Order::whereIn('status', ['legacy', 'pending'])
                ->whereNull('pakasir_txn_id')
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', Carbon::now())
                ->pluck('peminjaman_id');

            if ($expiredBookingIds->isEmpty()) {
                return;
            }

            Order::whereIn('peminjaman_id', $expiredBookingIds)
                ->whereIn('status', ['legacy', 'pending'])
                ->whereNull('pakasir_txn_id')
                ->where('expires_at', '<=', Carbon::now())
                ->update(['status' => 'canceled', 'updated_at' => now()]);

            Peminjaman::whereIn('p_id', $expiredBookingIds)
                ->where('p_status', 'PENDING')
                ->update(['p_status' => 'EXPIRED', 'updated_at' => now()]);
        }, 3);
    }

    public function checkJam(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lapangan_id' => 'required'
        ]);

        $this->expirePendingBookings();

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

        if (!$operasional || $operasional->jo_is_hari_libur || $libur) {
            return response()->json([
                'libur' => true
            ]);
        }

        // Jam terbooking
        $jamTerbooking = [];

        $peminjaman = Peminjaman::where('p_lapangan_id', $request->lapangan_id)
            ->whereIn('p_status', ['PENDING', 'DIBAYAR', 'RUNNING'])
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
        // Auto-expire transaksi pending yang sudah lewat batas waktu
        $this->expirePendingBookings();

        $peminjaman = Peminjaman::with(['customer', 'lapangan', 'latestOrder'])
            ->where('p_customer_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
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

        $peminjaman = Peminjaman::with('latestOrder')
            ->where('p_id', $id)
            ->where('p_customer_id', Auth::guard('customer')->id())
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

        $order = $peminjaman->latestOrder;
        if ($order && $order->status === 'pending' && $order->pakasir_txn_id) {
            try {
                app(PakasirService::class)->cancelTransaction($order);
            } catch (\Throwable $exception) {
                report($exception);
                Swal::fire([
                    'icon' => 'error',
                    'title' => 'Pembatalan gagal',
                    'text' => 'Transaksi pembayaran belum berhasil dibatalkan. Silakan coba kembali.',
                ]);

                return redirect()->route('riwayat.booking', $peminjaman->p_customer_id);
            }
        }

        DB::transaction(function () use ($peminjaman, $request, $order) {
            $lockedBooking = Peminjaman::whereKey($peminjaman->p_id)->lockForUpdate()->firstOrFail();
            if (!in_array($lockedBooking->p_status, ['PENDING', 'RUNNING'], true)) {
                return;
            }

            if ($order) {
                $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->first();
                if ($lockedOrder && $lockedOrder->status === 'pending') {
                    $lockedOrder->update(['status' => 'canceled']);
                }
            }

            $lockedBooking->update([
                'p_status' => 'CANCEL',
                'p_alasan_cancel' => $request->alasan_cancel,
            ]);
        }, 3);

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
        // Auto-expire transaksi pending yang sudah lewat batas waktu
        $this->expirePendingBookings();

        $peminjaman = Peminjaman::with(['customer', 'lapangan'])
            ->when($request->p_status, function ($q) use ($request) {
                $q->where('p_status', $request->p_status);
            })
            ->orderByRaw("FIELD(p_status, 'DIBAYAR', 'RUNNING', 'PENDING', 'FINISH', 'CANCEL', 'EXPIRED') ASC")
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
