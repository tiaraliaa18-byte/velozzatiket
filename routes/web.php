<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, JadwalController, PemesananController, PenumpangController, AdminJadwalController};
use App\Models\Jadwal;

// 1. PUBLIC ROUTES (Login)
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'showLogin');
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// 2. DASHBOARD PENUMPANG (Middleware Auth)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('pemesanan.cari', [
            'daftarJadwal' => \App\Models\Jadwal::all()
        ]);
    })->name('dashboard');

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

    Route::controller(AdminJadwalController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('jadwal.index');
        Route::post('/jadwal', 'store')->name('jadwal.store');
        Route::put('/jadwal/{id}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{id}', 'destroy')->name('jadwal.destroy');

        Route::get('/pembayaran', 'pembayaranIndex')->name('pembayaran.index');
        Route::patch('/pembayaran/{id}', 'updateStatusPembayaran')->name('pembayaran.update');
    });
});