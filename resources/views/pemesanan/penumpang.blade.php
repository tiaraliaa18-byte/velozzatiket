<x-app-layout>

    <x-booking.steps :current="3" />
    @if ($errors->any())
    <div class="max-w-3xl mx-auto px-6 mt-4">
        <div class="bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="max-w-3xl mx-auto px-6 mt-4">
        <div class="bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3">
            {{ session('error') }}
        </div>
    </div>
@endif

    <div class="max-w-3xl mx-auto px-6 py-8">
        <form action="{{ route('pemesanan.simpanPenumpang') }}" method="POST" id="form-pemesanan">
            @csrf

            <div class="space-y-4">

                @for ($i = 0; $i < $pax; $i++)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        @if($i == 0)
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Data Penumpang</h2>
                        @endif

                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-sm shrink-0">
                                P{{ $i + 1 }}
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800">Penumpang {{ $i + 1 }}</div>
                                <div class="text-xs text-gray-400">Dewasa</div>
                            </div>
                            <div class="text-xs font-semibold bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                                Kursi {{ $seats[$i] ?? '—' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (sesuai KTP)</label>
                                <input type="text" name="penumpang[{{ $i }}][nama]" placeholder="Cth: Budi Santoso" required
                                       class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor KTP / Paspor</label>
                                <input type="text" name="penumpang[{{ $i }}][nik]" placeholder="16 digit NIK" required
                                       class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select name="penumpang[{{ $i }}][gender]"
                                        class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="penumpang[{{ $i }}][tgl_lahir]"
                                       class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                <input type="text" name="penumpang[{{ $i }}][hp]" placeholder="+62 812 xxxx xxxx"
                                       class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                            </div>
                        </div>
                    </div>
                @endfor

                {{-- KONTAK PEMESAN --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Kontak Pemesan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" name="email_pemesan" placeholder="email@contoh.com" required
                                   class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP Pemesan</label>
                            <input type="text" name="hp_pemesan" placeholder="+62 812 xxxx xxxx" required
                                   class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-blue-50 text-blue-700 text-sm rounded-xl px-4 py-3 mb-4">
                        E-tiket akan dikirim ke email dan nomor HP ini
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('pemesanan.kursi', ['id_jadwal' => session('id_jadwal'), 'pax' => session('pax'), 'tanggal' => session('tanggal')]) }}" class="flex-1 text-center py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                            Kembali
                        </a>
                        <button type="submit"
                                class="flex-1 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition">
                            Lanjut ke Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>