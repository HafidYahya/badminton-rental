<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index($id){
        $lapangan = Lapangan::findOrFail($id);
        return view('pages.customer.peminjaman', compact('lapangan'));
    }
}