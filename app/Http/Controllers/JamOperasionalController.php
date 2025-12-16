<?php

namespace App\Http\Controllers;

use App\Models\JamOperasional;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;

class JamOperasionalController extends Controller
{
    public function index()
    {
        $jamOperasional = JamOperasional::all();
        return view('pages.admin.JamOperasional.index', compact('jamOperasional'));
    }
    public function updateBatch(Request $request)
    {
        $jamBuka = $request->input('jam_buka'); // array [id => jam_buka]
        $jamTutup = $request->input('jam_tutup'); // array [id => jam_tutup]
        $hariLibur = $request->input('hari_libur', []); // array [id => 1]

        foreach ($jamBuka as $id => $buka) {
            $jo = JamOperasional::find($id);
            $jo->jo_jam_buka = $buka;
            $jo->jo_jam_tutup = $jamTutup[$id];
            $jo->jo_is_hari_libur = isset($hariLibur[$id]) ? 1 : 0;
            $jo->save();
        }
        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Jam operasional berhasil diubah',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);

        return redirect()->back();
    }
}
