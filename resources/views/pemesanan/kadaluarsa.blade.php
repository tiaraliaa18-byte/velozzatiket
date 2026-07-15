<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-24 text-center">
        <div class="text-6xl mb-6">⏰</div>

        <h1 class="text-3xl font-bold text-gray-900 mb-3">Pesanan Dibatalkan</h1>
        <p class="text-gray-500 mb-2">Batas waktu pembayaran untuk pesanan Anda telah habis. Kode pemesanan:</p>

        <div class="inline-block bg-gray-100 rounded-xl px-6 py-3 my-4">
            <span class="text-xl font-bold text-gray-800 font-mono">{{ $pesanan->kode_booking }}</span>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4 my-6 text-sm text-red-700">
            Kursi yang sebelumnya dipesan sudah dilepas kembali dan bisa dipesan oleh penumpang lain.
            Silakan lakukan pemesanan ulang jika masih ingin melakukan perjalanan ini.
        </div>

        <div class="flex items-center justify-center gap-3 mt-8">
            <a href="{{ url('/') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                Keluar
            </a>
            <a href="{{ route('pemesanan.cari') }}" class="px-6 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition">
                Pesan Ulang
            </a>
        </div>
    </div>
</x-app-layout>