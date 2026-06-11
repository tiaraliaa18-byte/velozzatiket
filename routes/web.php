<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenumpangController;
use App\Http\Controllers\AdminJadwalController;

// 1. Jalur Utama (Jika akses http://127.0.0.1:8000/ langsung diarahkan ke halaman login)
Route::get('/', [AuthController::class, 'showLogin']);

// 2. Jalur Halaman Form Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// 3. Jalur Proses Tombol Masuk Di-klik (Menjalankan fungsi login)
Route::post('/login', [AuthController::class, 'login']);

// 4. Jalur Proses Keluar Akun (Logout)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ========================================================
// JALUR AKSES DASHBOARD (KITA BEBASKAN DULU TANPA SATPAM)
// ========================================================

// Jalur Dashboard Penumpang/Passenger
Route::get('/dashboard', [PenumpangController::class, 'index'])->middleware('auth');

// ⬇️ TAMBAHKAN BARIS INI TEPAT DI SINI ⬇️
// Jalur untuk memproses kiriman form bukti transfer dari penumpang
Route::post('/pembayaran/kirim', [PenumpangController::class, 'kirimPembayaran'])->middleware('auth');


// Jalur Dashboard Admin (Jaga-jaga jika login sebagai admin)
Route::get('/admin/dashboard', function () {
    return "<h1>Halaman Dashboard Admin Velozza Berhasil Terbuka!</h1>";
});

// Jalur khusus untuk mengelola jadwal kereta api (Admin)
Route::get('/admin/jadwal', [AdminJadwalController::class, 'index']);
Route::post('/admin/jadwal', [AdminJadwalController::class, 'store']);
Route::delete('/admin/jadwal/{id}', [AdminJadwalController::class, 'destroy']);
Route::put('/admin/jadwal/{id}', [AdminJadwalController::class, 'update']);

// Jalur untuk melihat data pembayaran/tiket dan mengubah statusnya
Route::get('/admin/pembayaran', [AdminJadwalController::class, 'pembayaranIndex']);
Route::patch('/admin/pembayaran/{id}', [AdminJadwalController::class, 'updateStatusPembayaran']);