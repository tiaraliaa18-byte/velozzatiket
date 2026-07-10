<?php

namespace App\Http\Controllers;

use App\Models\Tiket; // Pastikan model Tiket sudah di-import
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function showETiket($id_pemesanan) 
    {
        // Mengambil tiket beserta data pemesanannya
        $tiket = Tiket::with('pemesanan.jadwal')->where('id_pemesanan', $id_pemesanan)->get();
        
        if ($tiket->isEmpty()) {
            return redirect()->back()->with('error', 'Tiket tidak ditemukan.');
        }

        // Mengambil data pemesanan untuk detail utama (seperti kode booking)
        $pesanan = $tiket->first()->pemesanan;

        return view('e-tiket', compact('pesanan'));
    }
}
