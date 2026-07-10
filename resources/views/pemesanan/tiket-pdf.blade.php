<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #333; padding: 20px; }
        .header { border-bottom: 3px solid #e04f26; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { color: #e04f26; margin: 0; font-size: 22px; }
        .kode-booking { font-size: 13px; color: #666; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 8px 0; font-size: 13px; }
        .label { color: #888; width: 40%; }
        .value { font-weight: bold; }
        .ticket-box { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-top: 16px; }
        .ticket-box h3 { margin: 0 0 10px 0; font-size: 15px; color: #e04f26; }
        .footer { margin-top: 30px; font-size: 11px; color: #999; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>VELOZZA</h1>
        <div class="kode-booking">Kode Booking: {{ $pesanan->kode_booking }}</div>
    </div>

    <table>
        <tr>
            <td class="label">Kereta</td>
            <td class="value">{{ $pesanan->jadwal->nama_kereta }} · {{ $pesanan->jadwal->kelas }}</td>
        </tr>
        <tr>
            <td class="label">Rute</td>
            <td class="value">{{ $pesanan->jadwal->asal }} → {{ $pesanan->jadwal->tujuan }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="value">{{ \Carbon\Carbon::parse($pesanan->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}</td>
        </tr>
        <tr>
            <td class="label">Jam Berangkat</td>
            <td class="value">{{ \Carbon\Carbon::parse($pesanan->jadwal->waktu_keberangkatan)->format('H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Total Pembayaran</td>
            <td class="value">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    @foreach ($pesanan->tiket as $tiket)
        <div class="ticket-box">
            <h3>Tiket {{ $tiket->kode_tiket }}</h3>
            <table>
                <tr>
                    <td class="label">Nama Penumpang</td>
                    <td class="value">{{ $tiket->penumpang->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">NIK</td>
                    <td class="value">{{ $tiket->penumpang->nik_ktp ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Nomor Kursi</td>
                    <td class="value">{{ $tiket->no_kursi }}</td>
                </tr>
            </table>
        </div>
    @endforeach

    <div class="footer">
        Tunjukkan e-tiket ini saat boarding di stasiun keberangkatan.
    </div>

</body>
</html>