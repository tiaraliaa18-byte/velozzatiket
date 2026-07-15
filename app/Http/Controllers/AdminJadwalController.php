<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Mail\TiketPemesanan;
use App\Mail\TiketDitolak;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminJadwalController extends Controller
{
    // 1. Menampilkan semua jadwal kereta ke panel admin
    public function index()
    {
        $jadwal = DB::table('jadwal')->get();
        return view('admin.admin', compact('jadwal'));
    }

    // 2. Memproses simpan data jadwal dari modal pop-up (Create)
    public function store(Request $request)
    {
        $request->validate([
            'nama_kereta'        => 'required',
            'kelas'              => 'required|in:eksekutif,bisnis,ekonomi',
            'asal'               => 'required',
            'tujuan'             => 'required',
            'waktu_keberangkatan'=> 'required',
            'durasi'             => 'required|numeric',
            'harga_tiket'        => 'required|numeric',
        ]);

        DB::table('jadwal')->insert([
            'nama_kereta'        => $request->nama_kereta,
            'kelas'              => $request->kelas,
            'asal'               => $request->asal,
            'tujuan'             => $request->tujuan,
            'waktu_keberangkatan'=> str_replace('T', ' ', $request->waktu_keberangkatan),
            'durasi'             => $request->durasi,
            'harga_tiket'        => $request->harga_tiket,
        ]);

        return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // 3. Menghapus data jadwal kereta (Delete)
    public function destroy($id)
    {
        DB::table('jadwal')->where('id_jadwal', $id)->delete();

        return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }

    // 4. Memproses update data jadwal (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kereta'        => 'required',
            'kelas'              => 'required|in:eksekutif,bisnis,ekonomi',
            'asal'               => 'required',
            'tujuan'             => 'required',
            'waktu_keberangkatan'=> 'required',
            'durasi'             => 'required|numeric',
            'harga_tiket'        => 'required|numeric',
        ]);

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

    // 5. Halaman daftar pembayaran yang MASIH DIPROSES (menunggu konfirmasi)
    public function pembayaranIndex()
    {
        $tiket = Pembayaran::with(['pemesanan.tiket.penumpang', 'pemesanan.jadwal'])
            ->whereHas('pemesanan', function ($q) {
                $q->where('status_pembayaran', 'menunggu_konfirmasi');
            })
            ->get();

        return view('admin.pembayaran', compact('tiket'));
    }

    // 5b. Halaman riwayat pembayaran yang SUDAH DIPROSES (lunas / ditolak)
    public function riwayatPembayaran()
    {
        $tiket = Pembayaran::with(['pemesanan.tiket.penumpang', 'pemesanan.jadwal'])
            ->whereHas('pemesanan', function ($q) {
                $q->whereIn('status_pembayaran', ['lunas', 'ditolak']);
            })
            ->orderByDesc('id_pembayaran')
            ->get();

        return view('admin.riwayat', compact('tiket'));
    }

    // 6. Fungsi untuk approve/reject pembayaran
    public function updateStatusPembayaran(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:menunggu_konfirmasi,lunas,ditolak'
        ]);

        $pembayaran = Pembayaran::with(['pemesanan.tiket.penumpang', 'pemesanan.jadwal'])->findOrFail($id);
        $pesanan = $pembayaran->pemesanan;

        $pesanan->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        if ($request->status_pembayaran === 'lunas') {
            Mail::to($pesanan->email_pemesan)->send(new TiketPemesanan($pesanan));
        } elseif ($request->status_pembayaran === 'ditolak') {
            Mail::to($pesanan->email_pemesan)->send(new TiketDitolak($pesanan));
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}