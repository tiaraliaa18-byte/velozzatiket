<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Mail\TiketPemesanan;
use App\Mail\TiketDitolak;
use Illuminate\Support\Facades\Mail;

class PembayaranController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::where('status_pembayaran', 'menunggu_konfirmasi')
            ->with(['pembayaran', 'jadwal', 'tiket.penumpang'])
            ->get();

        return view('admin.pembayaran', compact('pemesanan'));
    }

    public function updateStatus(Request $request, $id_pembayaran)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:menunggu_konfirmasi,lunas,ditolak',
        ]);

        $pembayaran = Pembayaran::findOrFail($id_pembayaran);
        $pesanan = $pembayaran->pemesanan;

        $pesanan->update([
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        if ($request->status_pembayaran === 'lunas') {
            $pesanan->load(['tiket.penumpang', 'jadwal']);
            Mail::to($pesanan->email_pemesan)->send(new TiketPemesanan($pesanan));
        } elseif ($request->status_pembayaran === 'ditolak') {
            Mail::to($pesanan->email_pemesan)->send(new TiketDitolak($pesanan));
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function riwayat()
    {
        $riwayat = Pemesanan::whereIn('status_pembayaran', ['lunas', 'ditolak'])
            ->with(['tiket.penumpang', 'jadwal', 'pembayaran'])
            ->orderBy('tanggal_pemesanan', 'desc')
            ->get();

        return view('admin.riwayat', compact('riwayat'));
    }
}