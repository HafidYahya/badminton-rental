<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Arr; // Tambahkan ini

class HariLiburController extends Controller
{
    public function index()
    {
        return view('pages.admin.HariLibur.index');
    }

    public function data()
    {
        $data= HariLibur::where('is_active', true)->get()->map(function($item){
            return[
                'id' => $item->hl_id,
                'title' => $item->keterangan,
                'start' => $item->hl_tanggal_mulai,
                'end' => date('Y-m-d', strtotime($item->hl_tanggal_selesai . ' +1 day')),
                'color' => '#dc3545',
            ];
        });
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'hl_tanggal_mulai' => 'required|date',
                'hl_tanggal_selesai' => 'required|date|after_or_equal:hl_tanggal_mulai',
                'keterangan' => 'required|string|max:255',
            ],[
                'hl_tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai'
            ]);

            HariLibur::create([
                'hl_tanggal_mulai' => $request->hl_tanggal_mulai,
                'hl_tanggal_selesai' => $request->hl_tanggal_selesai,
                'keterangan' => $request->keterangan,
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Hari libur berhasil ditambahkan'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', Arr::flatten($e->errors())) 
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'hl_tanggal_mulai' => 'required|date',
                'hl_tanggal_selesai' => 'required|date|after_or_equal:hl_tanggal_mulai',
                'keterangan' => 'required|string|max:255',
            ],[
                'hl_tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai'
            ]);

            HariLibur::findOrFail($id)->update([
                'hl_tanggal_mulai' => $request->hl_tanggal_mulai,
                'hl_tanggal_selesai' => $request->hl_tanggal_selesai,
                'keterangan' => $request->keterangan,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Hari libur berhasil diupdate'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', Arr::flatten($e->errors())) // Gunakan Arr::flatten
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $hariLibur = HariLibur::findOrFail($id);
            $hariLibur->update(['is_active' => false]);
            
            return response()->json([
                'success' => true,
                'message' => 'Hari libur berhasil dihapus'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}