<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SweetAlert2\Laravel\Swal;


class HariLiburController extends Controller
{
    public function index(Request $request)
    {
        // Nonaktifkan hari libur yang tanggal selesainya sudah lewat
        HariLibur::where('is_active', true)
            ->whereDate('hl_tanggal_selesai', '<', today())
            ->update([
                'is_active' => false
            ]);

        // Mode edit
        $editHariLibur = $request->filled('edit') ? HariLibur::findOrFail($request->query('edit')) : null;

        $hari_libur = HariLibur::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $riwayat_hari_libur = HariLibur::where('is_active', false)->orderBy('created_at', 'desc')->get();
        return view('pages.admin.HariLibur.index', compact('hari_libur', 'riwayat_hari_libur', 'editHariLibur'));
    }

    public function store(Request $request)
    {
        DB::table('hari_libur')->insert([
            'hl_tanggal_mulai' => $request->tanggal_mulai,
            'hl_tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
            'is_active' => true
        ]);
        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Hari libur berhasil ditambahkan',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);
        return redirect()->route('hari.libur.index');
    }

    public function update(Request $request, int $id)
    {
        $hari_libur = HariLibur::findOrFail($id);

        $hari_libur->update([
            'hl_tanggal_mulai' => $request->tanggal_mulai,
            'hl_tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan
        ]);
        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Data hari libur berhasil diubah',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);

        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $hari_libur = HariLibur::findOrFail($id);
        $hari_libur->delete();

        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Data hari libur berhasil dihapus',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);

        return redirect()->route('hari.libur.index');
    }

    public function resolve(int $id)
    {
        $hari_libur = HariLibur::findOrFail($id);

        $hari_libur->update(['is_active' => false]);

        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Hari libur selesai',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);

        return redirect()->route('hari.libur.index');
    }

    public function restore(int $id)
    {
        $hari_libur = HariLibur::findOrFail($id);

        $hari_libur->update(['is_active' => true]);

        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Hari libur kembali aktif',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);

        return redirect()->route('hari.libur.index');
    }
}
