<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Http\Controllers\Controller; 

class AdminJadwalController extends Controller
{
    // 1. Menampilkan semua jadwal kereta ke panel admin
    public function index()
    {
        $jadwal = Jadwal::all();
        return view('admin.admin', compact('jadwal'));
    }

    // 2. Memproses simpan data jadwal dari modal pop-up (Create)
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

    // 3. Menghapus data jadwal kereta (Delete)
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }

    // 4. Memproses update data jadwal (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kereta' => 'required',
            'stasiun_asal' => 'required',
            'stasiun_tujuan' => 'required',
            'waktu_berangkat' => 'required',
            'harga' => 'required|numeric',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    // 5. Fungsi menampilkan halaman daftar pembayaran tiket admin
    public function pembayaranIndex()
    {
        $tiket = Pembayaran::with('pemesanan.penumpang', 'pemesanan.jadwal')->get();
        return view('admin.pembayaran', compact('tiket'));
    }

    // 6. Fungsi untuk mengubah status pembayaran (menunggu, valid, ditolak)
    public function updateStatusPembayaran(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:menunggu,valid,ditolak'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return redirect('/admin/pembayaran')->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}