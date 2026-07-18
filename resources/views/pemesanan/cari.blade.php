<x-app-layout title="Dashboard Penumpang - Velozza">
    <x-booking.steps :current="1" />

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-primary-deep via-primary to-primary-light px-6 pt-10 pb-20">
            {{-- BAGIAN TEKS (Posisi di atas) --}}
            <div class="max-w-6xl mx-auto mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white">Pesan Tiket Kereta</h1>
                <p class="text-white/90 mt-2">Temukan jadwal terbaik untuk perjalanan Anda</p>
            </div>

            {{-- SEARCH CARD (Berada di luar div flex yang tadi, dan di-centerkan dengan mx-auto) --}}
            <div class="max-w-6xl mx-auto relative z-10">
                <form method="GET" action="{{ route('pemesanan.cari') }}"
                    class="bg-white rounded-2xl shadow-lg p-6 flex flex-wrap items-end gap-4">

                            <div class="flex-1 min-w-[140px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Dari</label>
                                <select name="asal" class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                                    <option value="Bandung" {{ request('asal') == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                                </select>
                            </div>

                            <button type="button" onclick="swapSt()" class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-50 hover:bg-orange-100 text-primary transition shrink-0 mb-0.5">
                                →
                            </button>

                            <div class="flex-1 min-w-[140px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ke</label>
                                <select name="tujuan" class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                                    <option value="Jakarta" {{ request('tujuan') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                                    <option value="Jogja" {{ request('tujuan') == 'Jogja' ? 'selected' : '' }}>Jogja</option>
                                    <option value="Malang" {{ request('tujuan') == 'Malang' ? 'selected' : '' }}>Malang</option>
                                </select>
                            </div>

                            <div class="min-w-[160px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ request('tanggal', \Carbon\Carbon::today()->format('Y-m-d')) }}" class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                            </div>

                            <div class="min-w-[110px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Penumpang</label>
                                <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden">
                                    <button type="button" id="pax-kurang" class="px-3 py-2.5 bg-gray-50 hover:bg-orange-50 hover:text-primary transition">-</button>
                                    <span id="pax-val" class="flex-1 text-center font-bold text-gray-800">{{ request('pax', 1) }}</span>
                                    <button type="button" id="pax-tambah" class="px-3 py-2.5 bg-gray-50 hover:bg-orange-50 hover:text-primary transition">+</button>
                                </div>
                            </div>

                            <div class="min-w-[150px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kelas</label>
                                <select id="input-kelas" onchange="jalankanPenyaringanTotal()" class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                                    <option value="semua">Semua Kelas</option>
                                    <option value="eksekutif">Eksekutif</option>
                                    <option value="bisnis">Bisnis</option>
                                    <option value="ekonomi">Ekonomi</option>
                                </select>
                            </div>

                           <button type="submit" class="bg-primary text-white font-bold px-8 py-2.5 rounded-xl hover:bg-primary-dark transition shadow-sm shadow-orange-200">
                                Cari Tiket
                            </button>
        </form>
    </div>
</div>

    {{-- DAFTAR KERETA --}}
    <div class="max-w-6xl mx-auto px-6 pt-8 pb-16">

        {{-- FILTER TABS --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div class="flex items-center gap-2">
                <button type="button" onclick="filterClass(this, 'all')" class="gtab active px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white transition">Semua</button>
                <button type="button" onclick="filterClass(this, 'eksekutif')" class="gtab px-4 py-2 rounded-full text-sm font-semibold border border-gray-300 text-gray-600 hover:border-primary hover:text-primary transition">Eksekutif</button>
                <button type="button" onclick="filterClass(this, 'bisnis')" class="gtab px-4 py-2 rounded-full text-sm font-semibold border border-gray-300 text-gray-600 hover:border-primary hover:text-primary transition">Bisnis</button>
                <button type="button" onclick="filterClass(this, 'ekonomi')" class="gtab px-4 py-2 rounded-full text-sm font-semibold border border-gray-300 text-gray-600 hover:border-primary hover:text-primary transition">Ekonomi</button>
            </div>
            <button type="button" onclick="triggerSortPrice(this)" class="px-4 py-2 rounded-full text-sm font-semibold border border-gray-300 text-gray-600 hover:border-primary hover:text-primary transition">
                Harga Terendah
            </button>
        </div>

        <form method="GET" action="{{ route('pemesanan.kursi') }}" id="form-pilih-jadwal">
            <input type="hidden" name="id_jadwal" id="selected_id_jadwal">
            <input type="hidden" name="pax" id="selected_pax" value="{{ request('pax', 1) }}">
            <input type="hidden" name="tanggal" id="selected_tanggal" value="{{ request('tanggal', \Carbon\Carbon::today('Asia/Jakarta')->format('Y-m-d')) }}">

            <div class="space-y-4" id="train-list-container">
                @forelse($daftarJadwal as $jadwal)
                    @php
                        $waktuTiba = \Carbon\Carbon::parse($jadwal->waktu_keberangkatan)->addMinutes($jadwal->durasi);
                        $jam = floor($jadwal->durasi / 60);
                        $menit = $jadwal->durasi % 60;
                    @endphp
                    <div class="train-card group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-primary/40 transition-all cursor-pointer p-6 flex items-center justify-between gap-6"
                         data-class="{{ strtolower($jadwal->kelas) }}"
                         data-price="{{ $jadwal->harga_tiket }}"
                         onclick="pilihKereta(this, '{{ $jadwal->id_jadwal }}')">

                        <div class="w-40 shrink-0">
                            <h3 class="font-bold text-lg text-gray-900">{{ $jadwal->nama_kereta }}</h3>
                            <span class="inline-block mt-1 text-[11px] font-bold tracking-wide px-2 py-0.5 rounded-full uppercase {{ match(strtolower($jadwal->kelas)) { 'eksekutif' => 'bg-primary/10 text-primary-dark', 'bisnis' => 'bg-orange-100 text-orange-700', 'ekonomi' => 'bg-blue-100 text-blue-700', default => 'bg-gray-100 text-gray-700' } }}">
                                {{ $jadwal->kelas }}
                            </span>
                        </div>

                        <div class="flex-1 flex items-center gap-4">
                            <div class="text-left">
                                <p class="text-2xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($jadwal->waktu_keberangkatan)->format('H:i') }}</p>
                                <p class="text-sm text-gray-500">{{ $jadwal->asal }}</p>
                            </div>

                            <div class="flex-1 flex flex-col items-center px-2">
                                <span class="text-xs text-gray-400 mb-1">{{ $jam }}j {{ str_pad($menit, 2, '0', STR_PAD_LEFT) }}m</span>
                                <div class="w-full h-[2px] bg-gradient-to-r from-primary/30 to-primary relative">
                                    <span class="absolute right-0 -top-[3px] w-2 h-2 rounded-full bg-primary"></span>
                                </div>
                                <span class="text-xs text-gray-400 mt-1">Langsung</span>
                            </div>

                            <div class="text-left">
                                <p class="text-2xl font-bold text-gray-900">{{ $waktuTiba->format('H:i') }}</p>
                                <p class="text-sm text-gray-500">{{ $jadwal->tujuan }}</p>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="text-primary font-bold text-xl">Rp {{ number_format($jadwal->harga_tiket, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">/orang</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white rounded-2xl border border-gray-200 text-gray-500">
                        ⚠️ Maaf, jadwal tidak ditemukan.
                    </div>
                @endforelse
            </div>
        </form>
    </div>

    <script>
        document.getElementById('pax-tambah').addEventListener('click', () => {
            let el = document.getElementById('pax-val');
            let v = parseInt(el.textContent);
            if (v < 6) { el.textContent = v + 1; document.getElementById('selected_pax').value = v + 1; }
        });
        document.getElementById('pax-kurang').addEventListener('click', () => {
            let el = document.getElementById('pax-val');
            let v = parseInt(el.textContent);
            if (v > 1) { el.textContent = v - 1; document.getElementById('selected_pax').value = v - 1; }
        });

        function swapSt() {
            var f = document.querySelector('select[name="asal"]');
            var t = document.querySelector('select[name="tujuan"]');
            var tmp = f.value; f.value = t.value; t.value = tmp;
        }

        function pilihKereta(el, idJadwal) {
            document.getElementById('selected_id_jadwal').value = idJadwal;
            document.getElementById('form-pilih-jadwal').submit();
        }

        function jalankanPenyaringanTotal() {
            const kelasUser = document.getElementById('input-kelas')?.value.toLowerCase().trim() || "semua";
            document.querySelectorAll('.train-card').forEach(kartu => {
                const dataKelas = kartu.getAttribute('data-class') || '';
                kartu.style.display = (kelasUser === 'semua' || dataKelas === kelasUser) ? '' : 'none';
            });
        }

        function filterClass(el, className) {
            const dropdown = document.getElementById('input-kelas');
            if (dropdown) dropdown.value = (className === 'all') ? 'semua' : className;

            document.querySelectorAll('.gtab').forEach(btn => {
                btn.classList.remove('active', 'bg-primary', 'text-white');
                btn.classList.add('border', 'border-gray-300', 'text-gray-600');
            });
            el.classList.add('active', 'bg-primary', 'text-white');
            el.classList.remove('border', 'border-gray-300', 'text-gray-600');

            jalankanPenyaringanTotal();
        }

        function triggerSortPrice(el) {
            const container = document.getElementById('train-list-container');
            const cards = Array.from(container.querySelectorAll('.train-card'));
            cards.sort((a, b) => parseInt(a.dataset.price) - parseInt(b.dataset.price));
            cards.forEach(card => container.appendChild(card));
        }
    </script>
</x-app-layout>