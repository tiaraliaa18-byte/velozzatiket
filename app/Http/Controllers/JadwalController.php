<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Tiket;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil jadwal, filter berdasarkan input pencarian (asal & tujuan)
        $query = Jadwal::query();

        if ($request->filled('asal')) {
            $query->where('asal', $request->asal);
        }

        if ($request->filled('tujuan')) {
            $query->where('tujuan', $request->tujuan);
        }

        $daftarJadwal = $query->get();

        // 1b. Kalau tanggal yang dicari HARI INI, sembunyikan jadwal yang jam keberangkatannya sudah lewat
        $tanggalDicari = $request->filled('tanggal') ? $request->tanggal : Carbon::today('Asia/Jakarta')->format('Y-m-d');  

        if ($tanggalDicari === Carbon::today()->format('Y-m-d')) {
            $sekarang = Carbon::now('Asia/Jakarta')->format('H:i:s');

            $daftarJadwal = $daftarJadwal->filter(function ($jadwal) use ($sekarang) {
                return $jadwal->waktu_keberangkatan >= $sekarang;
            })->values();
        }

        // 2. Tangkap ID Jadwal dari request (jika ada)
        $idJadwal = $request->query('id_jadwal');

        // 3. Ambil kursi terisi hanya jika id_jadwal tersedia
        $kursiTerisi = [];
        if ($idJadwal) {
            $kursiTerisi = DB::table('tiket')
                ->join('pemesanan', 'tiket.id_pemesanan', '=', 'pemesanan.id_pemesanan')
                ->where('pemesanan.id_jadwal', $idJadwal)
                ->pluck('tiket.no_kursi')
                ->toArray();
        }

        // 4. Ambil tiket milik user yang sedang login dengan relasi yang rapi
        $idUser = auth()->id();
        $tikets = Tiket::whereHas('pemesanan', function ($query) use ($idUser) {
            $query->where('id_user', $idUser);
        })->get();

        // 5. Kirim data ke view
        return view('pemesanan.cari', compact('daftarJadwal', 'kursiTerisi', 'tikets', 'idJadwal'));
    }
}