<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal; 
use Illuminate\Support\Facades\DB; 

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua data jadwal untuk ditampilkan di kartu kereta
        $daftarJadwal = Jadwal::all();
        
        // 2. Tangkap ID Jadwal yang dikirim saat user memilih/mencari kereta
        $idJadwal = $request->input('id_jadwal'); 

        // 3. Query simpel & aman: Ambil no_kursi dari tabel pemesanan berdasarkan id_jadwal
        $kursiTerisi = DB::table('pemesanan') 
            ->where('id_jadwal', $idJadwal)
            ->pluck('no_kursi') // Mengambil kolom no_kursi sesuai phpMyAdmin kamu
            ->toArray();

        // 4. Kirim data ke blade
        return view('dashboard', compact('daftarJadwal', 'kursiTerisi'));
    }
}