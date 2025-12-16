<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\JamOperasionalController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserManagementController;
use App\Models\HariLibur;
use App\Models\JamOperasional;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $lapangan = Lapangan::all();

    $today = Carbon::today();

    // Cek apakah hari ini libur di tabel hari_libur
    $isHoliday = HariLibur::where('is_active', 1)->whereDate('hl_tanggal_mulai', '<=', $today)
        ->whereDate('hl_tanggal_selesai', '>=', $today)
        ->exists();


    $days = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu',
    ];

    $hariIni = $days[$today->format('l')]; // Misal: "Rabu"

    // Atau cek kolom is_hari_libur di jam_operasional
    $operasional = JamOperasional::where('jo_hari', $hariIni)->first();
    $isOperationalHoliday = $operasional ? $operasional->jo_is_hari_libur : false;

    // Gabungkan kedua kondisi
    $isTodayHoliday = $isHoliday || $isOperationalHoliday;

    return view('pages.customer.index', compact('lapangan', 'isTodayHoliday'));
})->name('index');


Route::get('login-admin', [AuthController::class, 'showLoginAdminForm'])->name('login');
Route::post('login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin');

Route::get('/login-customer', [AuthController::class, 'showLoginCustomerForm'])->name('login.customer.form');
Route::post('login-customer', [AuthController::class, 'loginCustomer'])->name('login.customer');

Route::get('/register', [CustomerController::class, 'registerForm'])->name('register.form');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.register');



Route::middleware('admin.auth')->group(function () {
    Route::get('/admin', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');
    Route::resource('user', controller: UserManagementController::class);
    Route::resource('lapangan', controller: LapanganController::class);
    Route::get('/lapangan/{id}/status', [LapanganController::class, 'status'])->name('lapangan.status');
    Route::get('/customer/{id}/activate-member', [CustomerController::class, 'activateMember'])->name('activate.member');
    Route::get('/customer/{id}/deactivate-member', [CustomerController::class, 'deactivateMember'])->name('deactivate.member');
    Route::get('customer/{id}/status', [CustomerController::class, 'status'])->name('customer.status');
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::resource('jam-operasional', controller: JamOperasionalController::class)->only('index');
    Route::put('/jam-operasional/update-batch', [JamOperasionalController::class, 'updateBatch'])->name('jam-operasional.update-batch');
    Route::get('/hari-libur', [HariLiburController::class, 'index'])->name('hari.libur.index');
    Route::get('/hari-libur/data', [HariLiburController::class, 'data']);
    Route::post('/hari-libur', [HariLiburController::class, 'store']);
    Route::put('/hari-libur/{id}', [HariLiburController::class, 'update']);
    Route::delete('/hari-libur/{id}', [HariLiburController::class, 'destroy']);
    Route::get('/admin/booking', [PeminjamanController::class, 'transaksi'])->name('transaksi.booking');
    Route::put('/booking/{id}/proses', [PeminjamanController::class, 'proses'])->name('proses.booking');
});

Route::middleware('customer.auth')->group(function () {
    Route::get('/profile/{id}/edit',  [CustomerController::class, 'editProfileCustomer'])->name('edit.profile.customer');
    Route::put('/profile/{customer}', [CustomerController::class, 'updateProfileCustomer'])->name('edit.profile');
    Route::put('/booking/{id}/cancel', [PeminjamanController::class, 'cancel'])->name('cancel.booking');
    Route::get('/booking/check-jam', [PeminjamanController::class, 'checkJam'])->name('booking.check-jam');
    Route::get('/booking/riwayat/{id}', [PeminjamanController::class, 'riwayat'])->name('riwayat.booking');
    Route::get('/booking/{id}', [PeminjamanController::class, 'index'])->name('booking.index');
    Route::post('/booking', [PeminjamanController::class, 'store'])->name('booking.store');
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
