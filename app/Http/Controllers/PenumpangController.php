<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;

class PenumpangController extends Controller
{
    // Fungsi untuk mengatur halaman utama dashboard pelanggan
    public function index()
    {
        // 1. Ambil data pengguna yang sedang login saat ini
        $user = Auth::user();

        // 2. Kirim data pengguna tersebut ke file view dashboard pelanggan
        return view('dashboardpenumpang', compact('user'));
    }

    // Fungsi baru untuk memproses kiriman bukti pembayaran
    public function kirimPembayaran(Request $request)
    {
        // 1. Validasi input form penumpang (Disesuaikan dengan kolom database asli)
        $request->validate([
            'id_pemesanan'     => 'required',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal file 2MB
        ]);

        // 2. Proses upload file gambar ke folder public/uploads
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            // Membuat nama file unik berdasarkan waktu
            $namaFile = time() . '_' . $file->getClientOriginalName();
            // Pindahkan file fisik ke folder public/uploads
            $file->move(public_path('uploads'), $namaFile);
        }

        // 3. Simpan data barunya ke tabel pembayaran di database (Hanya kolom yang ada di phpMyAdmin)
        Pembayaran::create([
            'id_pemesanan'       => $request->id_pemesanan,
            'metode_pembayaran'  => 'Transfer Bank',
            'tanggal_pembayaran' => now()->toDateString(), // Mengisi tanggal hari ini otomatis
            'bukti_pembayaran'   => $namaFile ?? null,
        ]);

        // 4. Kembalikan penumpang ke halaman dashboard dengan pesan sukses
        return redirect('/dashboard')->with('success', 'Bukti transfer berhasil dikirim! Menunggu konfirmasi admin.');
    }
}