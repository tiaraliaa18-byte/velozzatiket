<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal; // Memanggil model Jadwal agar bisa terhubung ke database

class AdminJadwalController extends Controller
{
    // 1. Menampilkan semua jadwal kereta ke panel admin
    public function index()
    {
        $jadwal = Jadwal::all();
        return view('admin.index', compact('jadwal'));
    }

    // 2. Memproses simpan data dari modal pop-up
    public function store(Request $request)
    {
    $request->validate([
        'nama_kereta'     => 'required',
        'kelas'           => 'required',
        'stasiun_asal'    => 'required',
        'stasiun_tujuan'  => 'required',
        'waktu_berangkat' => 'required',
        'harga'           => 'required|numeric',
    ]);

    Jadwal::create([
        'nama_kereta'     => $request->nama_kereta,
        'kelas'           => $request->kelas,
        'asal'            => $request->stasiun_asal,     // Masuk ke kolom 'asal'
        'tujuan'          => $request->stasiun_tujuan,   // Masuk ke kolom 'tujuan'
        'waktu_berangkat' => $request->waktu_berangkat,  // Masuk ke kolom 'waktu_berangkat'
        'harga_ticket'    => $request->harga,            // Masuk ke kolom 'harga_ticket'
    ]);

    return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
}

    // 3. Menghapus data jadwal kereta
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect('/Velozza/public/admin/jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}