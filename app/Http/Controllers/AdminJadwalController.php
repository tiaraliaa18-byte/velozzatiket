<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\DB; // 支持 Query Builder

class AdminJadwalController extends Controller
{
    // 1. Menampilkan semua jadwal kereta ke panel admin
    public function index()
    {
        // Menggunakan DB::table agar konsisten dan menghindari error Eloquent
        $jadwal = DB::table('jadwal')->get();
        return view('admin.admin', compact('jadwal'));
    }

    // 2. Memproses simpan data jadwal dari modal pop-up (Create)
    public function store(Request $request)
    {
        // Validasi data input dari form HTML
        $request->validate([
            'nama_kereta'        => 'required',
            'kelas'              => 'required|in:eksekutif,bisnis,ekonomi', 
            'asal'               => 'required',
            'tujuan'             => 'required',
            'waktu_keberangkatan'=> 'required',
            'durasi'             => 'required|numeric',
            'harga_tiket'        => 'required|numeric',
        ]);

        // ✔️ DIUBAH: Menggunakan Query Builder (DB::table) langsung untuk bypass error Model Eloquent
        DB::table('jadwal')->insert([
            'nama_kereta'        => $request->nama_kereta,
            'kelas'              => $request->kelas, 
            'asal'               => $request->asal,
            'tujuan'             => $request->tujuan,
            'waktu_keberangkatan'=> str_replace('T', ' ', $request->waktu_keberangkatan), // Format datetime-local ke format standar DB
            'durasi'             => $request->durasi,
            'harga_tiket'        => $request->harga_tiket,
        ]);

        return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // 3. Menghapus data jadwal kereta (Delete)
    public function destroy($id)
    {
        // Menggunakan Query Builder langsung ke tabel
        DB::table('jadwal')->where('id_jadwal', $id)->delete();

        return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }

    // 4. Memproses update data jadwal (Update)
    public function update(Request $request, $id)
    {
        // Validasi data yang diedit
        $request->validate([
            'nama_kereta'        => 'required',
            'kelas'              => 'required|in:eksekutif,bisnis,ekonomi', 
            'asal'               => 'required',
            'tujuan'             => 'required',
            'waktu_keberangkatan'=> 'required',
            'durasi'             => 'required|numeric',
            'harga_tiket'        => 'required|numeric',
        ]);

        // ✔️ DIUBAH: Menggunakan Query Builder langsung untuk proses update data
        DB::table('jadwal')->where('id_jadwal', $id)->update([
            'nama_kereta'        => $request->nama_kereta,
            'kelas'              => $request->kelas, 
            'asal'               => $request->asal,
            'tujuan'             => $request->tujuan,
            'waktu_keberangkatan'=> str_replace('T', ' ', $request->waktu_keberangkatan),
            'durasi'             => $request->durasi,
            'harga_tiket'        => $request->harga_tiket,
        ]);

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