<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penumpang - Velozza</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans">
 
<!-- TOPBAR -->
<div class="topbar" id="topbar">
  <a href="#" class="logo">
    VELOZZA
  </a>
  <div class="topbar-steps">
    <div class="tstep active" id="s2">
        <div class="tstep-num">1</div>Pilih Kereta
    </div>
    <div class="tstep-sep">›</div>
    
    <div class="tstep" id="s3">
        <div class="tstep-num">2</div>Pilih Kursi
    </div>
    <div class="tstep-sep">›</div>
    
    <div class="tstep" id="s4">
        <div class="tstep-num">3</div>Penumpang
    </div>
    <div class="tstep-sep">›</div>
    
    <div class="tstep" id="s5">
        <div class="tstep-num">4</div>Konfirmasi
    </div>
</div>
</div>
 
<!-- HERO SEARCH -->
<div class="hero" id="hero-section">
  <div style="max-width:1200px;margin:0 auto">
    <div class="hero-title">Pesan Tiket Kereta</div>
    <div class="hero-sub">Temukan jadwal terbaik untuk perjalanan Anda</div>

    <div class="search-card">
      <div class="search-row">

        <div class="sf" style="min-width:220px">
          <label>Dari</label>
          <select id="input-asal">
            <option value="Bandung">Bandung</option>
          </select>
        </div>

        <button class="swap-btn" onclick="swapSt()" title="Tukar stasiun">→<i class="ti ti-arrows-exchange"></i></button>

        <div class="sf" style="min-width:220px">
          <label>Ke</label>
          <select id="input-tujuan">
            <option value="Jakarta">Jakarta</option>
            <option value="Yogyakarta">Yogyakarta</option>
            <option value="Malang">Malang</option>
          </select>
        </div>

        <div class="sf">
          <label>Tanggal</label>
          <input type="date" 
                 id="input-tanggal" 
                 value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" 
                 style="width:160px">
        </div>

        <div class="sf" style="min-width: 120px; flex: 0 0 auto;">
          <label>Penumpang</label>
            <div class="pax-counter">
                <button id="pax-kurang" class="btn-pax">-</button>
                <span id="pax-val">1</span>
                <button id="pax-tambah" class="btn-pax">+</button>
            </div>
        </div>

        <div class="sf" style="min-width:130px">
          <label>Kelas</label>
          <select id="input-kelas">
            <option value="semua">Semua Kelas</option>
            <option value="eksekutif">Eksekutif</option>
            <option value="bisnis">Bisnis</option>
            <option value="ekonomi">Ekonomi</option>
          </select>
        </div>

        <button class="btn-search" onclick="filterTiket()">Cari Tiket</button>
      </div>
    </div>
  </div>
</div>
 
<div class="main">
 
<!-- PAGE 2: RESULTS -->
  <div class="layout-2col">
    <div>
        <div class="filter-sort-wrapper">
            <div class="filter-tabs">
                <div class="gtab active" onclick="filterClass(this, 'all')">Semua</div>
                <div class="gtab" onclick="filterClass(this, 'eksekutif')">Eksekutif</div>
                <div class="gtab" onclick="filterClass(this, 'bisnis')">Bisnis</div>
                <div class="gtab" onclick="filterClass(this, 'ekonomi')">Ekonomi</div>
            </div>

            <div class="gtab sort-tab" onclick="triggerSortPrice(this, 'low-to-high')">
                Harga Terendah
            </div>
        </div>

      <!-- Train cards -->
<div id="train-list-container" style="display: flex; flex-direction: column; gap: 15px; width: 100%;">

      @foreach($daftarJadwal as $jadwal)
  @php
      // 1. Mengambil jam & menit keberangkatan dari database
      $jamMenit = \Carbon\Carbon::parse($jadwal->waktu_keberangkatan)->format('H:i:s');
      $waktuDinamis = \Carbon\Carbon::today()->setTimeFromTimeString($jamMenit);
      
      // 2. Mengambil total durasi menit dari database (jika kosong, default 5 jam = 300 menit)
      $totalMenit = $jadwal->durasi ?? 300; 
      
      // 3. Pecah total menit menjadi Jam dan Menit untuk tampilan teks
      $tampilanJam = floor($totalMenit / 60);
      $tampilanMenit = $totalMenit % 60;
      $teksDurasi = $tampilanJam . "j " . str_pad($tampilanMenit, 2, "0", STR_PAD_LEFT) . "m";
      
      // 4. Hitung waktu tiba secara dinamis
      $waktuTiba = $waktuDinamis->copy()->addMinutes($totalMenit)->format('H:i');
  @endphp

<div class="train-card" 
     data-asal="{{ strtolower($jadwal->asal) }}" 
     data-tujuan="{{ strtolower($jadwal->tujuan) }}" 
     data-tanggal="{{ $jadwal->tanggal_berangkat }}" 
     data-kelas="{{ strtolower($jadwal->kelas) }}" 
     data-price="{{ $jadwal->harga_tiket }}" 
     onclick="selTrain(this, '{{ $jadwal->nama_kereta }}', '{{ $jadwal->kelas }}', '{{ $waktuDinamis->format('H:i') }}', '{{ $waktuTiba }}', '{{ $jadwal->harga_tiket }}', '{{ $teksDurasi }}', 'langsung')">
    <div class="tc-main">
      <div class="tc-name-block">
        <div class="tc-name">{{ $jadwal->nama_kereta }}</div>
        <span class="tc-class-pill @if($jadwal->kelas == 'Eksekutif') pill-exec @elseif($jadwal->kelas == 'Bisnis') pill-biz @else pill-eco @endif">
          {{ $jadwal->kelas }}
        </span>
      </div>
      <div>
        <div class="tc-time">{{ $waktuDinamis->format('H:i') }}</div>
        <div class="tc-sta">{{ $jadwal->asal }}</div>
      </div>
      <div class="tc-mid">
        <div class="tc-dur">{{ $teksDurasi }}</div>
        <div class="tc-line"></div>
        <div class="tc-stops">Langsung</div>
      </div>
      <div>
        <div class="tc-time">{{ $waktuTiba }}</div>
        <div class="tc-sta">{{ $jadwal->tujuan }}</div>
      </div>
      <div class="tc-price">
        <div class="tc-price-amt">Rp {{ number_format($jadwal->harga_tiket, 0, ',', '.') }}</div>
        <div class="tc-price-per">/orang</div>
      </div>
    </div>
  </div>
@endforeach

</div> 

<div style="margin-top: 20px; width: 100%;">
  <button id="btn-pilih-kereta" class="btn-pilih-kursi-kamu" onclick="goPage('page-seats', 2)" disabled>
    Pilih Kursi
  </button>
</div>
 
<!-- PAGE 3: SEAT -->
<div class="page" id="page-seats" style="display: none;">
  <div class="layout-sidebar">
    <div>
      <div class="card">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-armchair"></i>Pilih Kursi</div>
          <div class="notice notice-info" style="margin-bottom:16px">
            <i class="ti ti-users"></i>Pilih <b id="notice-pax-count">1</b> kursi untuk penumpang Anda
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
            <div style="font-size:13px;font-weight:600;color:var(--text-mid)" id="seat-train-lbl">Argo Bromo Anggrek · Eksekutif</div>
            <div class="gerbong-tabs">
              <div class="gtab active" onclick="switchGerbong(this,4)">Gerbong 4</div>
              <div class="gtab" onclick="switchGerbong(this,5)">5</div>
              <div class="gtab" onclick="switchGerbong(this,6)">6</div>
              <div class="gtab" onclick="switchGerbong(this,7)">7</div>
            </div>
          </div>
          <div class="seat-section">
            <div style="display:flex;gap:5px;align-items:center;margin-bottom:4px">
              <div style="width:24px"></div>
              <div class="seat-col-header" style="width:34px">A</div>
              <div class="seat-col-header" style="width:34px">B</div>
              <div style="width:20px"></div>
              <div class="seat-col-header" style="width:34px">C</div>
              <div class="seat-col-header" style="width:34px">D</div>
            </div>
            <div class="seat-map" id="seat-map"></div>
            <div class="seat-legend">
              <div class="leg-item"><div class="leg-box leg-avail"></div>Tersedia</div>
              <div class="leg-item"><div class="leg-box leg-sel"></div>Dipilih</div>
              <div class="leg-item"><div class="leg-box leg-taken"></div>Terisi</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div>
      <div class="summary-card">
        <div class="summary-header">
          <div class="summary-header-title"><i class="ti ti-receipt" style="margin-right:6px"></i>Ringkasan Pemesanan</div>
        </div>
        <div class="summary-body">
          <div class="sum-row"><span class="sum-label">Kereta</span><span class="sum-val" id="s-train">Argo Bromo</span></div>
          <div class="sum-row"><span class="sum-label">Kursi</span><span class="sum-val" id="s-seats">—</span></div>
          <div class="sum-row"><span class="sum-label">Harga/orang</span><span class="sum-val" id="s-price">Rp 580.000</span></div>
          <div class="sum-row"><span class="sum-label">Penumpang</span><span class="sum-val" id="s-pax">1 orang</span></div>
          <div class="sum-total"><span>Total</span><span class="sum-total-amt" id="s-total">Rp 1.160.000</span></div>
          
          <button class="btn-primary" id="btn-lanjut-kursi" disabled onclick="goPage('page-passenger', 3)" style="margin-top:14px">
            Data Penumpang <i class="ti ti-arrow-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- PAGE 4: PASSENGER -->
<div class="page" id="page-passenger">
  <div class="layout-sidebar">
    <div>
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-users"></i>Data Penumpang</div>
          <div class="pax-section-header">
            <div class="pax-avatar">P1</div>
            <div>
              <div class="pax-section-label">Penumpang 1</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p1-seat">4A</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field"><label>Nama Lengkap (sesuai KTP)</label><input type="text" placeholder="Cth: Budi Santoso"></div>
            <div class="form-field"><label>Nomor KTP / Paspor</label><input type="text" placeholder="16 digit NIK"></div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="pax-section-header">
            <div class="pax-avatar">P2</div>
            <div>
              <div class="pax-section-label">Penumpang 2</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p2-seat">4B</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field"><label>Nama Lengkap (sesuai KTP)</label><input type="text" placeholder="Cth: Siti Rahayu"></div>
            <div class="form-field"><label>Nomor KTP / Paspor</label><input type="text" placeholder="16 digit NIK"></div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-mail"></i>Kontak Pemesan</div>
          <div class="form-grid">
            <div class="form-field"><label>Alamat Email</label><input type="email" placeholder="email@contoh.com"></div>
            <div class="form-field"><label>Nomor HP Pemesan</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
          <div class="notice notice-info">
            <i class="ti ti-send"></i>E-tiket akan dikirim ke email dan nomor HP ini
          </div>
          <div style="display:flex;gap:12px;margin-top:16px">
            <button class="btn-outline" onclick="goPage('page-seat',3)"><i class="ti ti-arrow-left"></i>Kembali</button>
            <button class="btn-primary" onclick="goPage('page-confirm',5)">Lanjut ke Konfirmasi <i class="ti ti-arrow-right"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="summary-card">
        <div class="summary-header">
          <div class="summary-header-title"><i class="ti ti-receipt" style="margin-right:6px"></i>Ringkasan</div>
        </div>
        <div class="summary-body">
          <div class="sum-row"><span class="sum-label">Rute</span><span class="sum-val">GMR → YK</span></div>
          <div class="sum-row"><span class="sum-label">Tanggal</span><span class="sum-val">15 Jun 2026</span></div>
          <div class="sum-row"><span class="sum-label">Kereta</span><span class="sum-val" id="s2-train">Argo Bromo</span></div>
          <div class="sum-row"><span class="sum-label">Kursi</span><span class="sum-val" id="s2-seats">4A, 4B</span></div>
          <div class="sum-row"><span class="sum-label">2 × Rp 580.000</span><span class="sum-val">Rp 1.160.000</span></div>
          <div class="sum-row"><span class="sum-label">Biaya layanan</span><span class="sum-val">Rp 20.000</span></div>
          <div class="sum-total"><span>Total</span><span class="sum-total-amt">Rp 1.180.000</span></div>
        </div>
      </div>
    </div>
  </div>
</div>
 
<!-- PAGE 5: CONFIRMATION -->
<div class="page" id="page-confirm">
  <div class="layout-sidebar">
    <div>
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-ticket"></i>Detail Tiket</div>
          <div class="ticket">
            <div class="ticket-top">
              <div>
                <div class="ticket-train-name" id="tck-train">Argo Bromo Anggrek</div>
                <div class="ticket-class">Eksekutif · 15 Juni 2026</div>
              </div>
              <i class="ti ti-train ticket-icon"></i>
            </div>
            <div class="ticket-body">
              <div class="ticket-route">
                <div class="ticket-city">GMR</div>
                <div class="ticket-line">
                  <div class="ticket-dur" style="text-align:center;font-size:11px;color:var(--text-mute);margin-bottom:3px" id="tck-dur">5j 05m</div>
                  <div class="ticket-line-inner"></div>
                </div>
                <div class="ticket-city">YK</div>
              </div>
              <div class="ticket-meta">
                <div class="tm-item"><small>Berangkat</small><span id="tck-dep">07:00</span></div>
                <div class="tm-item"><small>Tiba</small><span id="tck-arr">12:05</span></div>
                <div class="tm-item"><small>Kursi</small><span id="tck-seats">4A, 4B</span></div>
                <div class="tm-item"><small>Penumpang</small><span>2 orang</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
 
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-credit-card"></i>Metode Pembayaran</div>
          <div class="payment-option selected" onclick="selPay(this)">
            <div class="pay-icon"><i class="ti ti-building-bank"></i></div>
            <div>
              <div class="pay-title">Transfer Bank</div>
              <div class="pay-sub">BCA · Mandiri · BRI · BNI · BSI</div>
            </div>
            <div class="pay-radio"></div>
          </div>
          <div class="payment-option" onclick="selPay(this)">
            <div class="pay-icon"><i class="ti ti-device-mobile"></i></div>
            <div>
              <div class="pay-title">Dompet Digital</div>
              <div class="pay-sub">GoPay · OVO · Dana · ShopeePay</div>
            </div>
            <div class="pay-radio"></div>
          </div>
          <div class="payment-option" onclick="selPay(this)">
            <div class="pay-icon"><i class="ti ti-qrcode"></i></div>
            <div>
              <div class="pay-title">QRIS</div>
              <div class="pay-sub">Scan QR dari semua aplikasi e-wallet</div>
            </div>
            <div class="pay-radio"></div>
          </div>
        </div>
      </div>
 
      <div class="card">
        <div class="card-body">
          <div class="sum-row" style="font-size:13px"><span class="sum-label">Subtotal (2 tiket)</span><span class="sum-val">Rp 1.160.000</span></div>
          <div class="sum-row" style="font-size:13px"><span class="sum-label">Biaya layanan</span><span class="sum-val">Rp 20.000</span></div>
          <div class="sum-total" style="padding-top:14px"><span>Total Pembayaran</span><span class="sum-total-amt">Rp 1.180.000</span></div>
          <div style="display:flex;gap:12px;margin-top:16px">
            <button class="btn-outline" onclick="goPage('page-passenger',4)"><i class="ti ti-arrow-left"></i>Kembali</button>
            <button class="btn-primary" onclick="showSuccess()">
              <i class="ti ti-lock"></i>Bayar — Rp 1.180.000
            </button>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="summary-card">
        <div class="summary-header">
          <div class="summary-header-title"><i class="ti ti-clock" style="margin-right:6px"></i>Batas Waktu Pembayaran</div>
        </div>
        <div class="summary-body">
          <div class="countdown-box">
            <div class="countdown-num" id="cdnum">01:29:47</div>
            <div class="countdown-label">sebelum pesanan dibatalkan</div>
            <div class="countdown-bar"><div class="countdown-progress" id="cdprog"></div></div>
          </div>
          <div class="notice notice-warn" style="margin-top:4px">
            <i class="ti ti-alert-triangle"></i>Segera selesaikan pembayaran
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
<!-- PAGE SUCCESS -->
<div class="page" id="page-success">
  <div class="success-wrap">
    <div class="success-icon"><i class="ti ti-circle-check"></i></div>
    <div class="success-title">Pemesanan Berhasil!</div>
    <div class="success-sub">Tiket Anda sudah dikonfirmasi. Kode pemesanan:</div>
    <div class="booking-code">KAI-2026-08412</div>
    <div class="notice notice-ok" style="margin-bottom:24px;text-align:left">
      <i class="ti ti-mail-check"></i>E-tiket telah dikirim ke email dan WhatsApp Anda. Tunjukkan e-tiket saat boarding di stasiun.
    </div>
    <div class="success-actions">
      <button class="btn-outline"><i class="ti ti-download"></i>Unduh E-Tiket</button>
      <button class="btn-primary" style="width:auto;padding:0 24px" onclick="goPage('page-results',2)">
        <i class="ti ti-search"></i>Pesan Lagi
      </button>
    </div>
  </div>
</div>
 
</div><!-- .main -->
 
<script>
// Biarkan variabel global ini polosan dulu, nanti diisi saat DOM siap atau saat kereta diklik
var pax = 2; 
var selPrice = 580000, selSeats = [], selTrainName = 'Argo Bromo Anggrek';
var taken = ['1C','2A','2D','3B','3C','4C','5A','5D','6B','7A','7C'];
var cdSecs = 5387, cdTotal = 5387;

document.addEventListener("DOMContentLoaded", function() {
    var btnKurang = document.getElementById('pax-kurang');
    var btnTambah = document.getElementById('pax-tambah');
    var txtPax = document.getElementById('pax-val');

    // Set nilai awal variabel global pax dari text HTML saat halaman pertama beres dimuat
    if (txtPax) {
        pax = parseInt(txtPax.textContent) || 2;
    }

    // Fungsi update otomatis ketika tombol + atau - diklik
    function sinkronisasiManual() {
        var currentPax = parseInt(txtPax.textContent) || 1;
        pax = currentPax; // Update variabel global pax aplikasi Velozza

        // 1. Update Teks Penumpang di Ringkasan (Panah Biru)
        var txtRingkasanPax = document.getElementById('s-pax'); 
        if (txtRingkasanPax) {
            txtRingkasanPax.textContent = currentPax + ' orang';
        }

        // 2. Update Teks Notice Pilih Kursi (Kotak Kiri)
        var txtNoticePax = document.getElementById('notice-pax-count');
        if (txtNoticePax) {
            txtNoticePax.textContent = currentPax;
        }

        // 3. Hitung ulang total harga secara real-time
        if (typeof selPrice !== 'undefined' && selPrice > 0) {
            var totalHarga = selPrice * currentPax;
            var elTotal = document.getElementById('s-total');
            if (elTotal) {
                elTotal.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
            }
        }

        // 4. Reset kursi terpilih karena jumlah kapasitas penumpang berubah
        selSeats = [];
        buildSeats();
    }

    if (btnKurang && btnTambah && txtPax) {
        // Aksi ketika tombol MINUS diklik
        btnKurang.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); 
            
            var currentPax = parseInt(txtPax.textContent) || 1;
            if (currentPax > 1) {
                var newPax = currentPax - 1;
                txtPax.textContent = newPax;
                sinkronisasiManual(); // Jalankan fungsi update
            }
        });

        // Aksi ketika tombol PLUS diklik
        btnTambah.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); 
            
            var currentPax = parseInt(txtPax.textContent) || 1;
            if (currentPax < 6) {
                var newPax = currentPax + 1;
                txtPax.textContent = newPax;
                sinkronisasiManual(); // Jalankan fungsi update
            }
        });
    }
});

function filterTiket() {
    // 1. Ambil nilai input dari form atas (sudah huruf kecil semua)
    const asalUser = document.getElementById('input-asal').value.toLowerCase().trim();
    const tujuanUser = document.getElementById('input-tujuan').value.toLowerCase().trim();
    const kelasUser = document.getElementById('input-kelas').value.toLowerCase().trim();

    // 2. Ambil semua elemen kartu kereta
    const semuaKartu = document.querySelectorAll('.train-card');
    let tiketDitemukan = false;

    semuaKartu.forEach(kartu => {
        // Ambil data atribut dari kartu
        const dataAsal = (kartu.getAttribute('data-asal') || '').toLowerCase().trim();
        const dataTujuan = (kartu.getAttribute('data-tujuan') || '').toLowerCase().trim();
        const dataKelas = (kartu.getAttribute('data-kelas') || '').toLowerCase().trim();

        // 3. LOGIKA JAUH LEBIH LONGGAR (Menggunakan .includes() bukan ===)
        // Jadi kalau dataAsal isinya "stasiun bandung", dia akan tetap lolos jika asalUser "bandung"
        const cocokAsal = (dataAsal.includes(asalUser) || asalUser === "");
        const cocokTujuan = (dataTujuan.includes(tujuanUser) || tujuanUser === "");
        const cocokKelas = (kelasUser === "semua" || kelasUser === "" || dataKelas.includes(kelasUser));

        // 4. Tampilkan jika semua kriteria COCOK
        if (cocokAsal && cocokTujuan && cocokKelas) {
            kartu.style.display = ""; 
            tiketDitemukan = true;
        } else {
            kartu.style.display = "none";
        }   
    });

    // 5. Atur Pesan Error Jika Tidak Ada Sama Sekali yang Cocok
    const container = document.getElementById('train-list-container');
    let pesanKosong = document.getElementById('no-ticket-message');

    if (!tiketDitemukan) {
        if (!pesanKosong) {
            pesanKosong = document.createElement('div');
            pesanKosong.id = 'no-ticket-message';
            pesanKosong.style.cssText = 'text-align: center; padding: 40px; color: #888; font-weight: 500; background: #fff; border-radius: 8px; margin-top: 15px; width: 100%;';
            pesanKosong.innerHTML = '⚠️ Maaf, jadwal perjalanan kereta tidak ditemukan.';
            container.appendChild(pesanKosong);
        }
    } else {
        if (pesanKosong) {
            pesanKosong.remove();
        }
    }
}

function triggerSortPrice(el, order) {
    // 1. Matikan status 'active' pada tombol filter kelas (Semua/Eksekutif/dll) jika ada,
    // atau sesama tombol sorting agar tidak bentrok visualnya.
    document.querySelectorAll('.filter-tabs .gtab, .sort-tab').forEach(btn => {
        btn.classList.remove('active');
    });

    // 2. Nyalakan status 'active' (warna merah menyala) pada tombol "Harga Terendah" yang diklik
    if (el) {
        el.classList.add('active');
    }

    // 3. Panggil fungsi inti untuk mengurutkan harga kartu kereta
    if (typeof sortPrice === 'function') {
        sortPrice(order);
    } else {
        console.error("Fungsi sortPrice(order) tidak ditemukan di dalam script!");
    }
}

function sortPrice(order) {
    var container = document.getElementById('train-list-container');
    if (!container) return;

    // Ambil semua kartu kereta (.train-card) di dalam kontainer
    var cards = Array.from(container.querySelectorAll('.train-card'));

    // 1. Deteksi filter kelas apa yang saat ini sedang aktif (Semua / Eksekutif / Bisnis / Ekonomi)
    var activeFilterTab = document.querySelector('.filter-tabs .gtab.active');
    var currentClassFilter = activeFilterTab ? activeFilterTab.textContent.trim().toLowerCase() : 'all';
    if (currentClassFilter === 'semua') currentClassFilter = 'all';

    // 2. Urutkan susunan array kartu berdasarkan isi atribut data-price HTML
    cards.sort(function(a, b) {
        var priceA = parseInt(a.getAttribute('data-price')) || 0;
        var priceB = parseInt(b.getAttribute('data-price')) || 0;

        if (order === 'low-to-high') {
            return priceA - priceB; // Urutan dari termurah ke termahal
        }
        return 0;
    });

    // 3. Masukkan kembali susunan kartu baru ke HTML sembari menjaga aturan filter kelas
    cards.forEach(function(card) {
        container.appendChild(card);

        var cardClass = card.getAttribute('data-class') || '';

        // Jika filter kelas aktif selain 'all' dan tidak cocok dengan kartu ini, sembunyikan!
        if (currentClassFilter !== 'all' && cardClass !== currentClassFilter) {
            card.style.display = 'none';
        } else {
            card.style.display = 'block';
        }
    });
}

function filterClass(el, className) {
    // Matikan lampu 'active' pada tab filter kelas sesama komponennya
    document.querySelectorAll('.filter-tabs .gtab').forEach(btn => {
        btn.classList.remove('active');
    });
    if (el) el.classList.add('active');

    var cards = document.querySelectorAll('.train-card');
    cards.forEach(card => {
        var cardClass = card.getAttribute('data-class');
        
        if (className === 'all') {
            card.style.display = 'block';
        } else {
            if (cardClass === className.toLowerCase()) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        }
    });
}
 
function swapSt(){
  var f=document.getElementById('from-inp'), t=document.getElementById('to-inp');
  var tmp=f.value; f.value=t.value; t.value=tmp;
}
 
function selTrain(el,name,cls,dep,arr,price,dur,stops){
  document.querySelectorAll('.train-card').forEach(c => c.classList.remove('selected'));
  
  el.classList.add('selected');
  
  selTrainName=name; 
  selPrice=parseInt(price);
  
  var txtPax = document.getElementById('pax-val');
  var jumlahPenumpang = txtPax ? parseInt(txtPax.textContent) : 1;
  pax = jumlahPenumpang; // Set ke variabel global aplikasi Velozza

  // Hitung total harga sesuai jumlah penumpang asli
  var totalHarga = selPrice * jumlahPenumpang;

var btnPilih = document.getElementById('btn-pilih-kereta');
  if (btnPilih) {
      btnPilih.disabled = false;
  }
  
  if(document.getElementById('seat-train-lbl')) document.getElementById('seat-train-lbl').textContent=name+' · '+cls;
  if(document.getElementById('s-train')) document.getElementById('s-train').textContent=name.split(' ').slice(0,2).join(' ');
  if(document.getElementById('s2-train')) document.getElementById('s2-train').textContent=name.split(' ').slice(0,2).join(' ');
  if(document.getElementById('s-price')) document.getElementById('s-price').textContent='Rp '+selPrice.toLocaleString('id-ID');
  
  // Update total harga ke ringkasan bawah
  if(document.getElementById('s-total')) document.getElementById('s-total').textContent='Rp '+totalHarga.toLocaleString('id-ID');
  
  // Update teks jumlah penumpang di ringkasan kanan
  var txtRingkasanPax = document.getElementById('s-pax'); 
  if (txtRingkasanPax) {
      txtRingkasanPax.textContent = jumlahPenumpang + ' orang';
  }

  // Update teks info sisa kursi di kotak kiri pilih kursi
  var txtNoticePax = document.getElementById('notice-pax-count');
  if (txtNoticePax) {
      txtNoticePax.textContent = jumlahPenumpang;
  }

  if(document.getElementById('tck-train')) document.getElementById('tck-train').textContent=name;
  if(document.getElementById('tck-dep')) document.getElementById('tck-dep').textContent=dep;
  if(document.getElementById('tck-arr')) document.getElementById('tck-arr').textContent=arr;
  if(document.getElementById('tck-dur')) document.getElementById('tck-dur').textContent=dur;
  
  selSeats=[];
  
  if (typeof buildSeats === "function") {
      buildSeats();
  }
}
 
function buildSeats(){
  var map=document.getElementById('seat-map');
  if(!map) return; // Mencegah error jika element belum ada
  map.innerHTML='';
  for(var n=1;n<=8;n++){
    var row=document.createElement('div');
    row.className='seat-row';
    var lbl=document.createElement('div');
    lbl.className='seat-row-lbl';
    lbl.textContent=n;
    row.appendChild(lbl);
    ['A','B'].forEach(function(c){
      var id=n+c;
      var s=document.createElement('div');
      s.className='seat';
      if(taken.indexOf(id)>=0){s.classList.add('taken');s.innerHTML='<i class="ti ti-x" style="font-size:10px"></i>';}
      else if(selSeats.indexOf(id)>=0){s.classList.add('selected');s.textContent=id;}
      else{s.textContent=id;}
      s.onclick=(function(sid,el){return function(){toggleSeat(sid,el);};})(id,s);
      row.appendChild(s);
    });
    var aisle=document.createElement('div');
    aisle.className='seat-aisle';
    row.appendChild(aisle);
    ['C','D'].forEach(function(c){
      var id=n+c;
      var s=document.createElement('div');
      s.className='seat';
      if(taken.indexOf(id)>=0){s.classList.add('taken');s.innerHTML='<i class="ti ti-x" style="font-size:10px"></i>';}
      else if(selSeats.indexOf(id)>=0){s.classList.add('selected');s.textContent=id;}
      else{s.textContent=id;}
      s.onclick=(function(sid,el){return function(){toggleSeat(sid,el);};})(id,s);
      row.appendChild(s);
    });
    map.appendChild(row);
  }
  updateSeatUI();
}
 
function toggleSeat(id,el){
  if(el.classList.contains('taken')) return;
  var idx=selSeats.indexOf(id);
  if(idx>=0){
    selSeats.splice(idx,1);
  }
  else{
    // Batas pilih kursi mengikuti jumlah variabel 'pax' secara dinamis
    if(selSeats.length >= pax) selSeats.shift();
    selSeats.push(id);
  }
  buildSeats();
}
 
function updateSeatUI(){
  var txt=selSeats.length>0?selSeats.join(', '):'—';
  
  var elSSeats = document.getElementById('s-seats');
  var elS2Seats = document.getElementById('s2-seats');
  var elTckSeats = document.getElementById('tck-seats');
  
  if(elSSeats) elSSeats.textContent=txt;
  if(elS2Seats) elS2Seats.textContent=txt;
  if(elTckSeats) elTckSeats.textContent=txt;
  
  var elP1 = document.getElementById('p1-seat');
  var elP2 = document.getElementById('p2-seat');
  
  if(selSeats[0] && elP1) elP1.textContent=selSeats[0];
  if(selSeats[1] && elP2) elP2.textContent=selSeats[1];
  
  // Tombol lanjut baru aktif jika jumlah kursi yang dipilih PAS dengan jumlah pax
  var btn=document.getElementById('btn-lanjut-kursi');
  if (btn) {
      btn.disabled = (selSeats.length !== pax);
  }
}
 
function switchGerbong(el,n){
  document.querySelectorAll('.gtab').forEach(g=>g.classList.remove('active'));
  el.classList.add('active');
  buildSeats();
}
 
function selPay(el){
  document.querySelectorAll('.payment-option').forEach(p=>p.classList.remove('selected'));
  el.classList.add('selected');
}
 
function showSuccess(){
  goPage('page-success',5);
  document.querySelectorAll('.tstep').forEach(s=>{s.classList.remove('active');s.classList.add('done');});
}

function goPage(pageId, stepNumber) {
    // 1. Paksa sembunyikan halaman tiket utama
    var ticketPage = document.getElementById('page-tickets');
    if (ticketPage) {
        ticketPage.style.display = 'none';
    }

    // 2. Paksa sembunyikan semua elemen pembungkus ber-class .page
    document.querySelectorAll('.page').forEach(page => {
        page.style.display = 'none';
    });

    // 3. Paksa sembunyikan tombol "Pilih Kursi" jingga itu sendiri agar tidak ikut terbawa
    var mainBtn = document.getElementById('btn-pilih-kereta');
    if (mainBtn && mainBtn.parentElement) {
        mainBtn.parentElement.style.display = 'none'; 
    }

    // 4. Tampilkan halaman tujuan (page-seats)
    var targetPage = document.getElementById(pageId);
    if (targetPage) {
        targetPage.style.display = 'block'; // Diubah menjadi block penuh
    } else {
        console.error("Halaman dengan ID '" + pageId + "' tidak ditemukan!");
    }

    // 5. Gambar ulang denah kursi
    if (pageId === 'page-seats' && typeof buildSeats === 'function') {
        buildSeats();
    }

    // 6. Update indikator step di bagian atas bar
    document.querySelectorAll('.tstep').forEach((step, index) => {
        if (index < stepNumber) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

setInterval(function(){
    if(cdSecs <= 0) return;
    cdSecs--;
    var h = Math.floor(cdSecs/3600), m = Math.floor((cdSecs%3600)/60), s = cdSecs%60;
    var el = document.getElementById('cdnum');
    if(el) el.textContent = (h ? String(h).padStart(2,'0')+':' : '') + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
}, 1000);
</script>
</body>
</html>