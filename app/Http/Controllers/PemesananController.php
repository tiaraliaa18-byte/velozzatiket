<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penumpang;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Tiket;
use App\Models\Jadwal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\TiketPemesanan;
use Illuminate\Support\Facades\Mail;

class PemesananController extends Controller
{
    public function create($id)
    {
        $jadwal = Jadwal::find($id);
        return view('dashboard', compact('jadwal'));
    }

    // STEP 2: Tampilkan halaman pilih kursi
    public function pilihKursi(Request $request)
    {
        $id_jadwal = $request->query('id_jadwal');
        $pax = (int) $request->query('pax', 1);
        $tanggal = $request->query('tanggal', now('Asia/Jakarta')->format('Y-m-d'));

        $jadwal = Jadwal::findOrFail($id_jadwal);

        session(['id_jadwal' => $id_jadwal, 'pax' => $pax, 'tanggal' => $tanggal]);

        $kursiTerisi = Tiket::whereHas('pemesanan', function ($q) use ($id_jadwal, $tanggal) {
                $q->where('id_jadwal', $id_jadwal)
                ->where('tanggal_keberangkatan', $tanggal);
            })->pluck('no_kursi')->toArray();

        return view('pemesanan.kursi', compact('jadwal', 'pax', 'kursiTerisi'));
    }

    // STEP 2 -> 3: Simpan kursi yang dipilih, lanjut ke form penumpang
    public function simpanKursi(Request $request)
    {
        $request->validate([
            'kursi_terpilih' => 'required|string',
        ]);

        $seats = explode(',', $request->kursi_terpilih);

        $id_jadwal = session('id_jadwal');
        $pax = session('pax', 1);

        $jadwal = Jadwal::findOrFail($id_jadwal);
        $subtotal = $jadwal->harga_tiket * $pax;
        $total = $subtotal + 20000;

        session([
            'seats' => $seats,
            'subtotal' => $subtotal,
            'total_harga' => $total,
        ]);

        return redirect()->route('pemesanan.penumpang');
    }

    // STEP 3: Tampilkan form data penumpang
    public function penumpang()
    {
        $id_jadwal = session('id_jadwal');
        $pax = session('pax', 1);
        $seats = session('seats', []);
        $subtotal = session('subtotal', 0);
        $total = session('total_harga', 0);

        if (!$id_jadwal) {
            return redirect()->route('pemesanan.cari')->with('error', 'Silakan pilih jadwal terlebih dahulu.');
        }

        $jadwal = Jadwal::findOrFail($id_jadwal);

        return view('pemesanan.penumpang', compact('jadwal', 'pax', 'seats', 'subtotal', 'total'));
    }

    // STEP 3 -> 4: Simpan data penumpang, buat pemesanan & tiket
    public function simpanPenumpang(Request $request)
    {
        $request->validate([
            'penumpang' => 'required|array',
            'email_pemesan' => 'required|email',
            'hp_pemesan' => 'required',
        ]);

        $id_jadwal = session('id_jadwal');
        $kursi_terpilih = session('seats');
        $total_harga = session('total_harga');

        $jadwal = Jadwal::findOrFail($id_jadwal);

        DB::beginTransaction();
        try {
            $pesanan = Pemesanan::create([
                'kode_booking'          => $this->generateUniqueCode(),
                'id_user'               => auth()->id(),
                'id_jadwal'             => $id_jadwal,
                'tanggal_keberangkatan' => session('tanggal'),   // ← tambah baris ini
                'total_harga'           => $total_harga,
                'email_pemesan'         => $request->email_pemesan,
                'hp_pemesan'            => $request->hp_pemesan,
                'status_pembayaran'     => 'pending',
                'metode_pembayaran'     => 'Transfer Bank',
                'tanggal_pemesanan'     => now(),
                'expired_at'            => now()->addMinutes(30),
            ]);

            foreach ($request->penumpang as $index => $data) {
                $penumpang = Penumpang::create([
                    'nama_lengkap'  => $data['nama'],
                    'nik_ktp'       => $data['nik'],
                    'no_telfon'     => $data['hp'] ?? '-',
                    'jenis_kelamin' => $data['gender'] === 'Laki-laki' ? 'laki-laki' : 'perempuan',
                    'tgl_lahir'     => $data['tgl_lahir'],
                ]);

                Tiket::create([
                    'id_pemesanan' => $pesanan->id_pemesanan,
                    'id_penumpang' => $penumpang->id_penumpang,
                    'no_kursi'     => $kursi_terpilih[$index],
                    'kode_tiket'   => 'TKT-' . strtoupper(Str::random(8)),
                    'harga_satuan' => $jadwal->harga_tiket,
                    'kelas_kursi'  => $jadwal->kelas,
                ]);
            }

            DB::commit();

            return redirect()->route('pemesanan.konfirmasi', $pesanan->id_pemesanan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    // STEP 4: Tampilkan detail tiket + form pembayaran
    public function konfirmasi($id)
    {
        $pesanan = Pemesanan::with(['tiket.penumpang', 'jadwal'])->findOrFail($id);

        $sisaDetik = $pesanan->expired_at
            ? max((int) now()->diffInSeconds($pesanan->expired_at, false), 0)
            : 1800;

        $totalDetikBatas = 1800;

        return view('pemesanan.pembayaran', compact('pesanan', 'sisaDetik', 'totalDetikBatas'));
    }

    // STEP 4: Proses upload bukti bayar
    public function bayar(Request $request, $kode_booking)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pesanan = Pemesanan::with(['tiket.penumpang', 'jadwal'])
            ->where('kode_booking', $kode_booking)
            ->firstOrFail();

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        Pembayaran::create([
            'id_pemesanan'       => $pesanan->id_pemesanan,
            'metode_pembayaran'  => 'Transfer Bank',
            'tanggal_pembayaran' => now(),
            'bukti_pembayaran'   => $path,
        ]);

        $pesanan->update(['status_pembayaran' => 'menunggu_konfirmasi']);

        Mail::to($pesanan->email_pemesan)->send(new TiketPemesanan($pesanan));   // ← baris baru

        return redirect()->route('pemesanan.sukses', $pesanan->id_pemesanan);
    }

    // STEP 5: Halaman sukses
    public function sukses($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        return view('pemesanan.sukses', compact('pesanan'));
    }

    public function unduhTiket($kode_booking)
    {
        $pesanan = Pemesanan::with(['tiket.penumpang', 'jadwal'])
            ->where('kode_booking', $kode_booking)
            ->firstOrFail();

        $pdf = \PDF::loadView('pemesanan.tiket-pdf', compact('pesanan'));

        return $pdf->download('e-tiket-' . $pesanan->kode_booking . '.pdf');
    }

    private function generateUniqueCode()
    {
        do {
            $kode = 'VLZ-' . strtoupper(Str::random(6));
        } while (Pemesanan::where('kode_booking', $kode)->exists());
        return $kode;
    }
}