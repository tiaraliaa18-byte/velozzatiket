<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Str;

class PemesananController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'id_jadwal' => 'required',
            'no_kursi' => 'required',
            // tambahkan validasi lain sesuai field yang dikirim
        ]);

        // 2. Generate Kode Booking unik
        $kodeBooking = $this->generateUniqueCode();

        // 3. Simpan ke database
        $pesanan = new Pemesanan();
        $pesanan->kode_booking = $kodeBooking;
        $pesanan->id_user = auth()->id();
        $pesanan->id_jadwal = $request->id_jadwal;
        $pesanan->id_penumpang = $request->id_penumpang; // pastikan ini ada
        $pesanan->no_kursi = $request->no_kursi;
        $pesanan->total_harga = $request->total_harga;
        $pesanan->tanggal_pemesanan = now();
        $pesanan->status_pembayaran = 'pending';
        
        $pesanan->save();

        // 4. Kirim respon balik ke frontend
        return response()->json([
            'status' => 'success',
            'kode_booking' => $kodeBooking
        ]);
    }

    private function generateUniqueCode()
    {
        do {
            $kode = 'VLZ-' . strtoupper(Str::random(6));
        } while (Pemesanan::where('kode_booking', $kode)->exists());

        return $kode;
    }
}