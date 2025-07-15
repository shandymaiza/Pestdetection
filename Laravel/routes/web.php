<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeteksiTanamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminTanamanController;
use App\Http\Controllers\AdminHamaController;
use App\Http\Controllers\InformasiTanamanController;
use App\Http\Controllers\InformasiHamaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('pricing', [PricingController::class, 'pricing']);

// Rute untuk login dan registrasi
Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest.only');
Route::post('login', [AuthController::class, 'login_post'])->name('login.post')->middleware('guest.only');
Route::get('daftar', [AuthController::class, 'daftar'])->name('daftar')->middleware('guest.only');
Route::post('daftar', [AuthController::class, 'daftar_post'])->name('daftar.post')->middleware('guest.only');



// Rute untuk admin
Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin.only');
//Route::get('admin/dashboard', [DashboardController::class, 'informasi'])->name('admin.informasi')->middleware('admin.only');
Route::get('admin/pengguna', [PenggunaController::class, 'pengguna'])->name('admin.pengguna')->middleware('admin.only');
Route::get('admin/pengguna', [PenggunaController::class, 'informasi'])->name('admin.informasi')->middleware('admin.only');
Route::resource('admin/mengelolatanaman', AdminTanamanController::class)->middleware('admin.only');
Route::resource('admin/mengelolahama', AdminHamaController::class)->middleware('admin.only');

// Rute untuk user
// Route::get('/user/halamandeteksi', [DeteksiTanamanController::class, 'index'])->name('deteksi.index')->middleware('user.only');
// Route::post('/user/d/upload', [DeteksiTanamanController::class, 'upload'])->name('deteksi.upload')->middleware('user.only');
Route::get('/user/d', [DeteksiTanamanController::class, 'index'])->name('deteksi.index')->middleware('user.only');
Route::post('/user/d/upload', [DeteksiTanamanController::class, 'upload'])->name('deteksi.upload')->middleware('user.only');
Route::resource('user/informasitanaman', InformasiTanamanController::class)->middleware('user.only');
Route::resource('user/informasihama', InformasiHamaController::class)->middleware('user.only');
Route::post('/payment', [PaymentController::class, 'createTransaction'])->name('payment.create')->middleware('user.only');
Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('midtrans.notification')->middleware('user.only');
Route::post('/update-subscription', [SubscriptionController::class, 'updateSubscription'])->name('update.subscription')->middleware('user.only');


// Logout tanpa middleware
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
