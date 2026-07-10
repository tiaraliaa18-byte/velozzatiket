<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Helvetica, Arial, sans-serif; color: #333; padding: 20px;">

    <h2 style="color: #e04f26;">VELOZZA</h2>

    <p>Halo,</p>
    <p>Terima kasih telah memesan tiket kereta bersama Velozza. Pemesanan Anda dengan kode booking
        <strong>{{ $pesanan->kode_booking }}</strong> telah kami terima.</p>

    <table style="width: 100%; margin-top: 16px;">
        <tr>
            <td style="padding: 6px 0; color: #888;">Kereta</td>
            <td style="padding: 6px 0; font-weight: bold;">{{ $pesanan->jadwal->nama_kereta }} · {{ $pesanan->jadwal->kelas }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #888;">Rute</td>
            <td style="padding: 6px 0; font-weight: bold;">{{ $pesanan->jadwal->asal }} → {{ $pesanan->jadwal->tujuan }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #888;">Tanggal</td>
            <td style="padding: 6px 0; font-weight: bold;">{{ \Carbon\Carbon::parse($pesanan->tanggal_keberangkatan)->translatedFormat('d M Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #888;">Total Pembayaran</td>
            <td style="padding: 6px 0; font-weight: bold;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">E-tiket lengkap terlampir dalam format PDF. Tunjukkan e-tiket ini saat boarding di stasiun keberangkatan.</p>

    <p style="margin-top: 30px; font-size: 12px; color: #999;">Email ini dikirim otomatis, mohon tidak membalas.</p>
</body>
</html>