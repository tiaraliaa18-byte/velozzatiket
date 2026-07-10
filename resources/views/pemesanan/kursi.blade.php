<x-app-layout>

    <x-booking.steps :current="2" />

    <div class="max-w-3xl mx-auto px-6 py-8">
        <form method="POST" action="{{ route('pemesanan.simpanKursi') }}" id="form-kursi">
            @csrf
            <input type="hidden" name="kursi_terpilih" id="input-kursi-terpilih">

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Pilih Kursi</h2>

                <div class="flex items-center gap-2 bg-blue-50 text-blue-700 text-sm rounded-xl px-4 py-3 mb-4">
                    Pilih <b>{{ $pax }}</b> kursi untuk penumpang Anda
                </div>

                <div class="text-sm font-semibold text-gray-600 mb-4">
                    {{ $jadwal->nama_kereta }} · {{ $jadwal->kelas }}
                </div>

                {{-- Header kolom kursi --}}
                <div class="flex items-center gap-2 mb-2 pl-8">
                    <span class="w-9 text-center text-xs font-bold text-gray-400">A</span>
                    <span class="w-9 text-center text-xs font-bold text-gray-400">B</span>
                    <span class="w-6"></span>
                    <span class="w-9 text-center text-xs font-bold text-gray-400">C</span>
                    <span class="w-9 text-center text-xs font-bold text-gray-400">D</span>
                </div>

                <div id="seat-map" class="space-y-2 mb-6"></div>

                {{-- Legenda --}}
                <div class="flex items-center gap-6 text-sm text-gray-500 border-t border-gray-100 pt-4 mb-6">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-white border border-gray-300"></span>Tersedia
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-primary"></span>Dipilih
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-gray-300"></span>Terisi
                    </div>
                </div>

                {{-- Info kursi terpilih --}}
                <div class="flex items-center justify-between border-t border-gray-100 pt-4 mb-4 text-sm">
                    <span class="text-gray-500">Kursi terpilih</span>
                    <span class="font-bold text-gray-800" id="s-seats">—</span>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('pemesanan.cari') }}" class="flex-1 text-center py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                        Kembali
                    </a>
                    <button type="submit" id="btn-lanjut-kursi" disabled
                            class="flex-1 py-2.5 rounded-xl bg-gray-300 text-white font-semibold transition disabled:cursor-not-allowed enabled:bg-primary enabled:hover:bg-primary-dark">
                        Lanjut
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const pax = {{ $pax }};
        const taken = @json($kursiTerisi ?? []);
        let selSeats = [];

        function buildSeats() {
            const map = document.getElementById('seat-map');
            map.innerHTML = '';
            for (let n = 1; n <= 8; n++) {
                const row = document.createElement('div');
                row.className = 'flex items-center gap-2';

                const lbl = document.createElement('div');
                lbl.className = 'w-6 text-xs font-semibold text-gray-400 text-center';
                lbl.textContent = n;
                row.appendChild(lbl);

                ['A', 'B'].forEach(c => row.appendChild(buatKursi(n + c)));

                const aisle = document.createElement('div');
                aisle.className = 'w-6';
                row.appendChild(aisle);

                ['C', 'D'].forEach(c => row.appendChild(buatKursi(n + c)));

                map.appendChild(row);
            }
            updateSeatUI();
        }

        function buatKursi(id) {
            const s = document.createElement('div');
            s.className = 'w-9 h-9 flex items-center justify-center rounded-lg text-xs font-bold cursor-pointer transition select-none';

            if (taken.indexOf(id) >= 0) {
                s.className += ' bg-gray-200 text-gray-400 cursor-not-allowed';
                s.textContent = '✕';
            } else if (selSeats.indexOf(id) >= 0) {
                s.className += ' bg-primary text-white';
                s.textContent = id;
            } else {
                s.className += ' bg-white border border-gray-300 text-gray-600 hover:border-primary hover:text-primary';
                s.textContent = id;
            }
            s.onclick = () => toggleSeat(id);
            return s;
        }

        function toggleSeat(id) {
            if (taken.indexOf(id) >= 0) return;
            const idx = selSeats.indexOf(id);
            if (idx >= 0) {
                selSeats.splice(idx, 1);
            } else {
                if (selSeats.length >= pax) selSeats.shift();
                selSeats.push(id);
            }
            buildSeats();
        }

        function updateSeatUI() {
            const txt = selSeats.length > 0 ? selSeats.join(', ') : '—';
            document.getElementById('s-seats').textContent = txt;
            document.getElementById('input-kursi-terpilih').value = selSeats.join(',');
            document.getElementById('btn-lanjut-kursi').disabled = (selSeats.length !== pax);
        }

        buildSeats();
    </script>
</x-app-layout>