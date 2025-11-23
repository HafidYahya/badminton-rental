<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* ROUTE DEFAULT
Jika user belum login maka diarahkan ke login, sedangkan jika sudah login diarahkan ke dashboard
*/
Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard')->middleware('auth');

/* ROUTE LOGIN
Keterangan:
get: untuk menampilkan view lewat URL
post untuk eksekusi form
Logic diarahkan ke AuthController.php
*/
Route::get('login-admin', [AuthController::class, 'showLoginAdminForm'])->name('login')->middleware('guest');
Route::post('login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin')->middleware('guest');

/* ROUTE USER MANAGEMENT
Keterangan:
resource dengan otomatis membuat 7 name route (uri.create, uri.index, uri.destroy{$id}, uri.show{$id}, uri.update)
*/
Route::resource('user', controller: UserManagementController::class)->middleware('auth');
// Resource Lapangan
Route::resource('lapangan', controller: LapanganController::class)->middleware('auth');
Route::get('lapangan/{id}/status', [LapanganController::class, 'status'])->name('lapangan.status');

// ROUTE LOGOUT
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login-admin');    
})->middleware('auth')->name('logout');