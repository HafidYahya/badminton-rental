<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SweetAlert2\Laravel\Swal;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::all();
        return view('pages.admin.lapangan.index', compact('lapangan'));
    }

    public function create()
    {
        return view('pages.admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|unique:lapangan,l_label',
            'harga' => 'required|numeric|min:0',
            'foto_lapangan' => 'nullable|mimes:png,jpg,jpeg,heic,webp|max:3000',
            'deskripsi' => 'nullable',
        ], [
            'label.required' => 'Label tidak boleh kosong',
            'label.unique' => 'Label lapangan ini sudah digunakan',
            'harga.required' => 'Harga tidak boleh kosong',
            'harga.min' => 'Harga tidak boleh diisi angka minus',
            'foto_lapangan.mimes' => 'Format file harus JPG, JPEG, PNG, WEBP, atau HEIC',
            'foto_lapangan.max' => 'Maksimal size 3 MB'
        ]);

        $fileName = 'lapangan-default.jpg';
        if ($request->hasFile('foto_lapangan')) {

            $file = $request->file('foto_lapangan');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/lapangan'), $fileName);
        }

        DB::table('lapangan')->insert([
            'l_label' => $request->label,
            'l_foto' => $fileName,
            'l_deskripsi' => $request->deskripsi,
            'l_harga' => $request->harga,
            'l_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Lapangan baru berhasil ditambahkan',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);
        return redirect()->route('lapangan.index');
    }


    public function destroy($id)
    {
        $lapangan = Lapangan::find($id);
        if ($lapangan->l_foto && File::exists(public_path('uploads/lapangan/' . $lapangan->l_foto))) {
            if ($lapangan->l_foto !== 'lapangan-default.jpg') {
                File::delete(public_path('uploads/lapangan/' . $lapangan->l_foto));
            }
        }
        $lapangan->delete();
        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Lapangan berhasil dihapus',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);
        return redirect()->route('lapangan.index');
    }

    public function status($id)
    {
        $lapangan = Lapangan::find($id);
        $lapangan->l_status = $lapangan->l_status === 'active' ? 'inactive' : 'active';
        $lapangan->save();
        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Status lapangan diubah menjadi ' . $lapangan->l_status,
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);
        return back();
    }

    public function edit(Lapangan $lapangan)
    {
        return view('pages.admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'label' => 'required|unique:lapangan,l_label,' . $lapangan->l_id . ',l_id',
            'harga' => 'required|numeric|min:0',
            'foto_lapangan' => 'nullable|mimes:png,jpg,jpeg,heic,webp|max:3000',
            'deskripsi' => 'nullable',
        ], [
            'label.required' => 'Label tidak boleh kosong',
            'label.unique' => 'Label lapangan ini sudah digunakan',
            'harga.required' => 'Harga tidak boleh kosong',
            'harga.min' => 'Harga tidak boleh diisi angka minus',
            'foto_lapangan.mimes' => 'Format file harus JPG, JPEG, PNG, WEBP, atau HEIC',
            'foto_lapangan.max' => 'Maksimal size 3 MB'
        ]);

        $lapangan->l_label = $request->label;
        $lapangan->l_harga = $request->harga;
        $lapangan->l_deskripsi = $request->deskripsi;

        if ($request->hasFile('foto_lapangan')) {
            if ($lapangan->l_foto && File::exists(public_path('uploads/lapangan/' . $lapangan->l_foto))) {
                if ($lapangan->l_foto !== 'lapangan-default.jpg') {
                    File::delete(public_path('uploads/lapangan/' . $lapangan->l_foto));
                }
            }

            $file = $request->file('foto_lapangan');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/lapangan'), $fileName);
            $lapangan->l_foto = $fileName;
        }
        $lapangan->save();
        Swal::fire([
            'toast' => true,
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Data lapangan berhasil diubah',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);
        return redirect()->route('lapangan.index');
    }
}
