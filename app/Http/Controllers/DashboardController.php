<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Lapangan;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalLapangan = Lapangan::count();
        $totalPelanggan = Customer::count();
        $totalTransaksi = Peminjaman::where('p_status', 'FINISH')->count();
        $totalTransaksiBulanIni = Peminjaman::where('p_status', 'FINISH')->whereMonth('p_tanggal', Carbon::now()->month)->whereYear('p_tanggal', Carbon::now()->year)->count();
        $totalTransaksiHariIni = Peminjaman::where('p_status', 'FINISH')->whereDate('p_tanggal', Carbon::today())->count();

        $bulanDipilih = $request->input('bulan', Carbon::now()->month);
        $tahunDipilih = $request->input('tahun', Carbon::now()->year);

        $totalTransaksiBulanDipilih = Peminjaman::where('p_status', 'FINISH')
            ->whereMonth('p_tanggal', $bulanDipilih)
            ->whereYear('p_tanggal', $tahunDipilih)
            ->count();

        return view('pages.admin.dashboard', compact(
            'totalLapangan',
            'totalPelanggan',
            'totalTransaksi',
            'totalTransaksiBulanIni',
            'totalTransaksiHariIni',
            'totalTransaksiBulanDipilih',
            'bulanDipilih',
            'tahunDipilih'
        ));
    }
}
