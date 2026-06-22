<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 🛠️ TAMBAHKAN BARIS INI BIAR MODEL JADWAL DIKENAL OLEH LARAVEL:
use App\Models\Jadwal; 

class JadwalController extends Controller
{
    public function index()
    {
        // Ambil semua data jadwal dari database MySQL
        $daftarJadwal = Jadwal::all();
        
        // Kirim data tersebut ke halaman dashboard penumpang kamu
        return view('dashboard', compact('daftarJadwal'));
    }
}