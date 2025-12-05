<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JamOperasionalController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\UserManagementController;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    $lapangan = Lapangan::all();
    return view('pages.customer.index', compact('lapangan'));
})->name('index');


Route::get('login-admin', [AuthController::class, 'showLoginAdminForm'])->name('login');
Route::post('login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin');

Route::get('login-customer', [AuthController::class, 'showLoginCustomerForm'])->name('login.customer.form');
Route::post('login-customer', [AuthController::class, 'loginCustomer'])->name('login.customer');

Route::get('/register', [CustomerController::class, 'registerForm'])->name('register.form');



Route::middleware('admin.auth')->group(function(){
    Route::get('/admin', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');
    Route::resource('user', controller: UserManagementController::class);
    Route::resource('lapangan', controller: LapanganController::class);
    Route::get('lapangan/{id}/status', [LapanganController::class, 'status'])->name('lapangan.status');
    Route::get('/customer/{id}/activate-member', [CustomerController::class, 'activateMember'])->name('activate.member');
    Route::get('/customer/{id}/deactivate-member', [CustomerController::class, 'deactivateMember'])->name('deactivate.member');
    Route::get('customer/{id}/status', [CustomerController::class, 'status'])->name('customer.status');
    Route::resource('customer', controller: CustomerController::class);
    Route::resource('jam-operasional', controller: JamOperasionalController::class)->only('index');
    Route::put('/jam-operasional/update-batch', [JamOperasionalController::class, 'updateBatch'])->name('jam-operasional.update-batch');



});

Route::middleware('customer.auth')->group(function (){
    Route::get('/profile/{id}/edit',  [CustomerController::class, 'editProfileCustomer'])->name('edit.profile.customer');
    Route::put('/profile/{customer}', [CustomerController::class, 'updateProfileCustomer'])->name('edit.profile');
});








Route::get('/logout', function (Request $request) {

    if (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login-admin');
    }

    if (Auth::guard('customer')->check()) {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login-customer');
    }

    return redirect('/');
})->name('logout');