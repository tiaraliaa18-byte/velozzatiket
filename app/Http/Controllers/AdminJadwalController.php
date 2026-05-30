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
            'nama_kereta' => 'required',
            'stasiun_asal' => 'required',
            'stasiun_tujuan' => 'required',
            'waktu_berangkat' => 'required',
            'harga' => 'required|numeric',
        ]);

        Jadwal::create($request->all());

        return redirect('/Velozza/public/admin/jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // 3. Menghapus data jadwal kereta
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect('/Velozza/public/admin/jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}