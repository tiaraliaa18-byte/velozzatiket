<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Helvetica, Arial, sans-serif; color: #333; padding: 20px;">

    <h2 style="color: #dc2626;">VELOZZA</h2>

    <p>Halo,</p>
    <p>Mohon maaf, pembayaran Anda untuk pemesanan dengan kode booking
        <strong>{{ $pesanan->kode_booking }}</strong> tidak dapat kami verifikasi.</p>

    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; margin: 16px 0;">
        <p style="margin: 0; color: #991b1b;">
            Kemungkinan penyebab: bukti transfer tidak jelas/tidak sesuai, nominal tidak sesuai, atau bukti pembayaran tidak valid.
        </p>
    </div>

    <table style="width: 100%; margin-top: 16px;">
        <tr>
            <td style="padding: 6px 0; color: #888;">Kereta</td>
            <td style="padding: 6px 0; font-weight: bold;">{{ $pesanan->jadwal->nama_kereta ?? '-' }} · {{ $pesanan->jadwal->kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #888;">Rute</td>
            <td style="padding: 6px 0; font-weight: bold;">{{ $pesanan->jadwal->asal ?? '-' }} → {{ $pesanan->jadwal->tujuan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #888;">Total Pembayaran</td>
            <td style="padding: 6px 0; font-weight: bold;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">Silakan lakukan pemesanan ulang dan pastikan bukti transfer yang diunggah jelas dan sesuai.</p>

    <p style="margin-top: 20px;">Jika ada pertanyaan atau butuh bantuan, hubungi customer service kami melalui WhatsApp:</p>

    @php
        $nomorCS = '6282177895773'; // ganti dengan nomor WA CS Velozza (format 62xxxxxxxxxx, tanpa + atau 0 di depan)
        $pesanWa = 'Halo Velozza, saya ingin bertanya mengenai pemesanan dengan kode booking ' . $pesanan->kode_booking . ' yang pembayarannya ditolak.';
        $linkWa = 'https://wa.me/' . $nomorCS . '?text=' . urlencode($pesanWa);
    @endphp

    <div style="text-align: center; margin: 24px 0;">
        <a href="{{ $linkWa }}"
           style="background-color: #25D366; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; display: inline-block;">
            💬 Hubungi via WhatsApp
        </a>
    </div>

    <p style="margin-top: 30px; font-size: 12px; color: #999;">Email ini dikirim otomatis, mohon tidak membalas.</p>
</body>
</html>