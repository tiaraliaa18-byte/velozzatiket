<?php

namespace App\Http\Controllers;

use App\Models\Jadwal; // Pastikan model Jadwal dipanggil
use Illuminate\Http\Request;

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