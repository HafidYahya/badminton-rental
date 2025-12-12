<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
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
        ]);
        $jam = $request->jam_booking;

        if (!$this->isJamBerurutan($jam)) {
            Swal::fire([
                'icon' => 'error',
                'title' => 'Jam Tidak Berurutan',
                'text' => 'Jam yang dipilih harus berurutan. Contoh: 08:00, 09:00, 10:00',
            ]);
            return back()->withInput();
        }
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
