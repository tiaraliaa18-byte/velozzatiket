<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenumpangController;
use App\Http\Controllers\AdminJadwalController;

// Halaman awal
Route::get('/', [AuthController::class, 'showLogin']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Penumpang
Route::get('/dashboard', [PenumpangController::class, 'index']);

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return "<h1>Halaman Dashboard Admin Velozza Berhasil Terbuka!</h1>";
});

// Kelola Jadwal Kereta
Route::get('/admin/jadwal', [AdminJadwalController::class, 'index']);
Route::post('/admin/jadwal', [AdminJadwalController::class, 'store']);
Route::delete('/admin/jadwal/{id}', [AdminJadwalController::class, 'destroy']);