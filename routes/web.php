<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminJadwalController;
use App\Http\Controllers\JadwalController; // Controller untuk jadwal dashboard penumpang
use App\Http\Controllers\PemesananController;

// Halaman awal
Route::get('/', [AuthController::class, 'showLogin']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Penumpang (SUDAH DIPERBAIKI: Menggunakan JadwalController agar data dinamis)
Route::get('/dashboard', [JadwalController::class, 'index'])->name('dashboard');

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return "<h1>Halaman Dashboard Admin Velozza Berhasil Terbuka!</h1>";
});

// Kelola Jadwal Kereta (Sisi Admin)
Route::get('/admin/jadwal', [AdminJadwalController::class, 'index']);
Route::post('/admin/jadwal', [AdminJadwalController::class, 'store']);
Route::delete('/admin/jadwal/{id}', [AdminJadwalController::class, 'destroy']);

// kirimkan ke fungsi 'store' di PemesananController"
Route::post('/pesan-tiket', [PemesananController::class, 'store']);