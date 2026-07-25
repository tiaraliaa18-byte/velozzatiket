<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Mail\TiketPemesanan;
use App\Mail\TiketDitolak;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

        $emailTerkirim = true;

        if ($request->status_pembayaran === 'lunas') {
            $pesanan->load(['tiket.penumpang', 'jadwal']);
            $emailTerkirim = $this->kirimEmailAman(
                fn () => Mail::to($pesanan->email_pemesan)->send(new TiketPemesanan($pesanan)),
                $pesanan
            );
        } elseif ($request->status_pembayaran === 'ditolak') {
            $emailTerkirim = $this->kirimEmailAman(
                fn () => Mail::to($pesanan->email_pemesan)->send(new TiketDitolak($pesanan)),
                $pesanan
            );
        }

        if (!$emailTerkirim) {
            return redirect()->back()->with(
                'warning',
                'Status pembayaran berhasil diperbarui, tetapi email notifikasi gagal terkirim ke pelanggan. Silakan cek kembali nanti.'
            );
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Kirim email dengan aman, tidak melempar exception ke request.
     * Mengembalikan true kalau berhasil, false kalau gagal (dan dicatat ke log).
     */
    private function kirimEmailAman(callable $callback, Pemesanan $pesanan): bool
    {
        try {
            $callback();
            return true;
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email notifikasi pemesanan', [
                'id_pemesanan' => $pesanan->id,
                'email_tujuan' => $pesanan->email_pemesan,
                'pesan_error'  => $e->getMessage(),
            ]);
            return false;
        }
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