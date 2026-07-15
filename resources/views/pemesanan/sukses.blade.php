<x-app-layout>

    <div class="max-w-xl mx-auto px-6 py-16 text-center">

        @if ($pesanan->status_pembayaran === 'lunas')

            {{-- SUDAH DI-APPROVE ADMIN --}}
            <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-6 text-3xl">
                ✓
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Pemesanan Berhasil!</h1>
            <p class="text-gray-500 mb-4">Tiket Anda sudah dikonfirmasi. Kode pemesanan:</p>

            <div class="inline-block bg-gray-100 text-gray-800 font-bold text-lg tracking-wide px-6 py-3 rounded-xl mb-6">
                {{ $pesanan->kode_booking }}
            </div>

            <div class="flex items-start gap-2 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3 mb-8 text-left">
                <span>E-tiket telah dikirim ke email Anda. Tunjukkan e-tiket saat boarding di stasiun.</span>
            </div>

            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('pemesanan.unduhTiket', $pesanan->kode_booking) }}"
                   class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                    Unduh E-Tiket
                </a>
                <a href="{{ route('pemesanan.cari') }}"
                   class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition">
                    Pesan Lagi
                </a>
            </div>

        @elseif ($pesanan->status_pembayaran === 'ditolak')

            {{-- DITOLAK ADMIN --}}
            <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-6 text-3xl">
                ✕
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Ditolak</h1>
            <p class="text-gray-500 mb-4">Kode pemesanan:</p>

            <div class="inline-block bg-gray-100 text-gray-800 font-bold text-lg tracking-wide px-6 py-3 rounded-xl mb-6">
                {{ $pesanan->kode_booking }}
            </div>

            <div class="flex items-start gap-2 bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3 mb-8 text-left">
                <span>Bukti pembayaran Anda tidak dapat diverifikasi. Silakan hubungi customer service atau lakukan pemesanan ulang.</span>
            </div>

            <a href="{{ route('pemesanan.cari') }}"
               class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition">
                Pesan Lagi
            </a>

        @else

            {{-- MASIH MENUNGGU KONFIRMASI ADMIN --}}
            <div class="w-16 h-16 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mx-auto mb-6 text-3xl">
                ⏳
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Menunggu Konfirmasi</h1>
            <p class="text-gray-500 mb-4">Bukti pembayaran Anda sedang diverifikasi. Kode pemesanan:</p>

            <div class="inline-block bg-gray-100 text-gray-800 font-bold text-lg tracking-wide px-6 py-3 rounded-xl mb-6">
                {{ $pesanan->kode_booking }}
            </div>

            <div class="flex items-start gap-2 bg-yellow-50 text-yellow-700 text-sm rounded-xl px-4 py-3 mb-8 text-left">
                <span>E-tiket akan dikirim ke email Anda setelah pembayaran dikonfirmasi oleh admin. Proses ini biasanya memakan waktu beberapa saat.</span>
            </div>

            <a href="{{ route('pemesanan.cari') }}"
               class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                Kembali ke Beranda
            </a>

        @endif
    </div>
</x-app-layout>