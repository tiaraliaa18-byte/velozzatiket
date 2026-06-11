<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran; // Pastikan kamu sudah membuat model Pembayaran

class PenumpangController extends Controller
{
    // Fungsi untuk mengatur halaman utama dashboard pelanggan
    public function index()
    {
        // 1. Ambil data pengguna yang sedang login saat ini
        $user = Auth::user();

        // 2. Kirim data pengguna tersebut ke file view dashboard pelanggan
        // 📄 PERUBAHAN 1: Diubah ke 'dashboardpenumpang' sesuai nama file blade kamu
        return view('dashboardpenumpang', compact('user'));
    }

    // Fungsi baru untuk memproses kiriman bukti pembayaran
    public function kirimPembayaran(Request $request)
    {
        // 1. Validasi input form penumpang
        $request->validate([
            'id_pemesanan'     => 'required',
            'bank_asal'        => 'required|string|max:50',
            'nama_rekening'    => 'required|string|max:100',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal file 2MB
        ]);

        // 2. Proses upload file gambar ke folder public/uploads
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            // Membuat nama file unik berdasarkan waktu, contoh: 1718000000_bukti.jpg
            $namaFile = time() . '_' . $file->getClientOriginalName();
            // Pindahkan file fisik ke folder public/uploads di Laravel kamu
            $file->move(public_path('uploads'), $namaFile);
        }

        // 3. Simpan data barunya ke tabel pembayaran di database
        Pembayaran::create([
            'id_pemesanan'       => $request->id_pemesanan,
            'metode_pembayaran'  => 'Transfer Bank',
            'tanggal_pembayaran' => now()->toDateString(), // Mengisi tanggal hari ini otomatis
            'bukti_pembayaran'   => $namaFile ?? null,
            'bank_asal'          => $request->bank_asal,
            'nama_rekening'      => $request->nama_rekening,
        ]);

        // 4. Kembalikan penumpang ke halaman dashboard dengan pesan sukses
        // 📄 PERUBAHAN 2: Diarahkan kembali ke rute '/dashboard' agar halaman merefresh dengan aman
        return redirect('/dashboard')->with('success', 'Bukti transfer berhasil dikirim! Menunggu konfirmasi admin.');
    }
}