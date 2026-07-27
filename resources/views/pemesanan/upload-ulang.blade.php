<x-app-layout>

    <div class="max-w-xl mx-auto px-6 py-16">

        <h1 class="text-2xl font-bold text-gray-900 mb-2 text-center">Upload Ulang Bukti Pembayaran</h1>
        <p class="text-gray-500 mb-6 text-center">Kode pemesanan:</p>

        <div class="inline-block bg-gray-100 text-gray-800 font-bold text-lg tracking-wide px-6 py-3 rounded-xl mb-6 mx-auto block w-fit">
            {{ $pesanan->kode_booking }}
        </div>

        <div class="bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3 mb-6">
            Bukti pembayaran sebelumnya tidak dapat diverifikasi. Silakan unggah bukti pembayaran yang baru dan jelas untuk diproses ulang oleh admin.
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3 mb-6">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('pemesanan.prosesUploadUlang', $pesanan->kode_booking) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran Baru</label>
                <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required
                       class="block w-full text-sm text-gray-600 border border-gray-300 rounded-xl px-4 py-2.5">
                <p class="text-xs text-gray-400 mt-1">Format JPG, PNG, atau PDF. Maks 2MB.</p>
            </div>

            <button type="submit"
                    class="w-full px-6 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition">
                Kirim Bukti Pembayaran
            </button>
        </form>

    </div>
</x-app-layout>