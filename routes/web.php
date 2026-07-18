<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, JadwalController, PemesananController, PenumpangController, AdminJadwalController};
use App\Models\Jadwal;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ForgotPasswordController;

// 1. PUBLIC ROUTES (Login & Register)
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'showLogin');
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Rute untuk menampilkan form reset password
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

    // Rute untuk memproses perubahan password
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// 2. DASHBOARD PENUMPANG (Middleware Auth)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [JadwalController::class, 'index'])->name('dashboard');

    // Alur Pemesanan
    Route::prefix('pemesanan')->name('pemesanan.')->group(function () {
        Route::get('/cari', [JadwalController::class, 'index'])->name('cari');

        Route::get('/kursi', [PemesananController::class, 'pilihKursi'])->name('kursi');
        Route::post('/kursi', [PemesananController::class, 'simpanKursi'])->name('simpanKursi');

        Route::get('/penumpang', [PemesananController::class, 'penumpang'])->name('penumpang');
        Route::post('/penumpang', [PemesananController::class, 'simpanPenumpang'])->name('simpanPenumpang');

        Route::get('/konfirmasi/{id}', [PemesananController::class, 'konfirmasi'])->name('konfirmasi');
        Route::post('/bayar/{kode_booking}', [PemesananController::class, 'bayar'])->name('bayar');

        Route::get('/sukses/{id}', [PemesananController::class, 'sukses'])->name('sukses');
        Route::get('/unduh-tiket/{kode_booking}', [PemesananController::class, 'unduhTiket'])->name('unduhTiket');
    });
});

// 3. DASHBOARD ADMIN
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => "<h1>Dashboard Admin Velozza</h1>");

    // Grup khusus AdminJadwalController
    Route::controller(AdminJadwalController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('jadwal.index');
        Route::post('/jadwal', 'store')->name('jadwal.store');
        Route::put('/jadwal/{id}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{id}', 'destroy')->name('jadwal.destroy');
    });

    // Grup khusus PembayaranController
    Route::controller(PembayaranController::class)->group(function () {
        Route::get('/pembayaran', 'index')->name('pembayaran.index');
        Route::patch('/pembayaran/{id_pembayaran}', 'updateStatus')->name('pembayaran.update');
        Route::get('/riwayat', 'riwayat')->name('riwayat.index');
    });

});