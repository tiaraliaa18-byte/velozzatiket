<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    // Menampilkan semua data pemesanan beserta status pembayarannya (untuk admin)
    public function index()
    {
        $pemesanan = Pemesanan::with('pembayaran')->get();

        return view('admin.pembayaran', compact('pemesanan'));
    }

    // Memproses pembayaran
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}