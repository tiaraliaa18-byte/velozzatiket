<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route bawaan beranda awal (biarkan saja jika sudah ada)
Route::get('/', function () {
    return view('welcome');
});

//Route untuk menampilkan halaman form login (Method: GET)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

//Route untuk memproses data saat tombol "Login" diklik (Method: POST)
Route::post('/login', [AuthController::class, 'login']);

//Route untuk keluar dari aplikasi / Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');