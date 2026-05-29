<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenumpangController extends Controller
{
    // Fungsi untuk mengatur halaman utama dashboard pelanggan
    public function index()
    {
        // 1. Ambil data pengguna yang sedang login saat ini
        $user = Auth::user();

        // 2. Kirim data pengguna tersebut ke file view dashboard pelanggan
        // (File view 'dashboard.blade.php' akan kita buat setelah backend ini selesai)
        return view('dashboard', compact('user'));
    }
}
