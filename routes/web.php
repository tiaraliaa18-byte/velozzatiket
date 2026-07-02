<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminJadwalController;
use App\Http\Controllers\JadwalController; // Controller untuk jadwal dashboard penumpang
use App\Http\Controllers\PenumpangController; // Controller untuk handling pembayaran penumpang

// 1. Jalur Utama & Login
Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ========================================================
// JALUR AKSES DASHBOARD PENUMPANG (SUDAH DIPROTEKSI LOGIN)
// ========================================================
Route::middleware(['auth'])->group(function () {
    // Dashboard Penumpang (Menggunakan JadwalController agar data jadwal dinamis)
    Route::get('/dashboard', [JadwalController::class, 'index'])->name('dashboard');

    // Jalur untuk memproses kiriman form bukti transfer dari penumpang
    Route::post('/pembayaran/kirim', [PenumpangController::class, 'kirimPembayaran']);
});


// ========================================================
// JALUR AKSES DASHBOARD ADMIN (VELOZZA)
// ========================================================

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return "<h1>Halaman Dashboard Admin Velozza Berhasil Terbuka!</h1>";
});

// Kelola Jadwal Kereta (Sisi Admin)
Route::get('/admin/jadwal', [AdminJadwalController::class, 'index']);
Route::post('/admin/jadwal', [AdminJadwalController::class, 'store']);
Route::delete('/admin/jadwal/{id}', [AdminJadwalController::class, 'destroy']);
Route::put('/admin/jadwal/{id}', [AdminJadwalController::class, 'update']);

// Jalur untuk melihat data pembayaran/tiket dan mengubah statusnya
Route::get('/admin/pembayaran', [AdminJadwalController::class, 'pembayaranIndex']);
Route::patch('/admin/pembayaran/{id}', [AdminJadwalController::class, 'updateStatusPembayaran']);                                                                                                                                                                       