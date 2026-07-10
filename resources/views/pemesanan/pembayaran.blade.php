<x-app-layout>

    <x-booking.steps :current="4" />

    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- KIRI: DETAIL TIKET + PEMBAYARAN --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- DETAIL TIKET --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Detail Tiket</h2>

                    <div class="bg-gray-50 rounded-xl px-4 py-3 mb-4">
                        <p class="font-semibold text-gray-800">Kode Booking: <span class="text-primary">{{ $pesanan->kode_booking }}</span></p>
                        <p class="text-sm text-gray-500 mt-1">Status: <span class="font-semibold">{{ ucfirst($pesanan->status_pembayaran) }}</span></p>
                    </div>

                    @foreach ($pesanan->tiket as $tiket)
                        <div class="border border-gray-200 rounded-xl p-4 mb-3 last:mb-0">
                            <p class="font-semibold text-gray-800 mb-2">Tiket: {{ $tiket->kode_tiket }}</p>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                <p><span class="text-gray-400">Penumpang:</span> {{ $tiket->penumpang->nama_lengkap ?? '-' }}</p>
                                <p><span class="text-gray-400">NIK:</span> {{ $tiket->penumpang->nik_ktp ?? '-' }}</p>
                                <p><span class="text-gray-400">Kursi:</span> {{ $tiket->no_kursi }}</p>
                                <p><span class="text-gray-400">Kelas:</span> {{ $tiket->kelas_kursi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- METODE PEMBAYARAN --}}
                <form action="{{ route('pemesanan.bayar', $pesanan->kode_booking) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Metode Pembayaran</h2>

                        <div class="flex items-center gap-4 border border-primary bg-primary/5 rounded-xl p-4 mb-4">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                🏦
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Transfer Bank</p>
                                <p class="text-sm text-gray-500">Silakan transfer ke: <strong>BCA 1234567890 a/n PT Velozza</strong></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran"
                                   class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                   accept="image/*,.pdf" required>
                            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG atau PDF (Maks. 2MB)</p>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <a href="{{ route('pemesanan.penumpang') }}" class="flex-1 text-center py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                                Kembali
                            </a>
                            <button type="submit"
                                    class="flex-1 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition">
                                Bayar — Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- KANAN: RINGKASAN + COUNTDOWN --}}
            <div class="space-y-4">

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden sticky top-6">
                    <div class="bg-gray-50 px-5 py-4 border-b border-gray-100 font-bold text-gray-800">
                        Ringkasan
                    </div>
                    <div class="p-5 space-y-3 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-semibold text-gray-800">Rp {{ number_format($pesanan->total_harga - 20000, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Biaya layanan</span><span class="font-semibold text-gray-800">Rp 20.000</span></div>

                        <div class="flex justify-between border-t border-gray-100 pt-3 text-base">
                            <span class="font-bold text-gray-900">Total Pembayaran</span>
                            <span class="font-bold text-primary">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-5 py-4 border-b border-gray-100 font-bold text-gray-800">
                        Batas Waktu Pembayaran
                    </div>
                    <div class="p-5 text-center">
                        <p class="text-3xl font-bold text-primary" id="cdnum">00:30:00</p>
                        <p class="text-xs text-gray-400 mt-1 mb-3">sebelum pesanan dibatalkan</p>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-primary transition-all" id="cdprog" style="width:100%"></div>
                        </div>
                        <div class="flex items-center justify-center gap-2 bg-yellow-50 text-yellow-700 text-xs rounded-lg px-3 py-2 mt-4">
                            Segera selesaikan pembayaran
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let cdSecs = {{ $sisaDetik ?? 1800 }};
        const cdTotal = {{ $totalDetikBatas ?? 1800 }};

        setInterval(function () {
            if (cdSecs <= 0) return;
            cdSecs--;
            const h = Math.floor(cdSecs / 3600), m = Math.floor((cdSecs % 3600) / 60), s = cdSecs % 60;
            document.getElementById('cdnum').textContent =
                (h ? String(h).padStart(2, '0') + ':' : '') + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            document.getElementById('cdprog').style.width = Math.round(cdSecs / cdTotal * 100) + '%';
        }, 1000);
    </script>
</x-app-layout>