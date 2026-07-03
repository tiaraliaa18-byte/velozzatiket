<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penumpang - Velozza</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardpenumpang.css') }}"> 
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
 
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
          <select id="input-asal" onchange="filterJadwal()">
            <option value="Bandung">Bandung</option>
          </select>
        </div>

        <button class="swap-btn" onclick="swapSt()" title="Tukar stasiun">→<i class="ti ti-arrows-exchange"></i></button>

        <div class="sf" style="min-width:220px">
          <label>Ke</label>
          <select id="input-tujuan" onchange="filterJadwal()">
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
                 onchange="filterJadwal()"
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
          <select id="input-kelas" onchange="filterJadwal()">
            <option value="semua">Semua Kelas</option>
            <option value="eksekutif">Eksekutif</option>
            <option value="bisnis">Bisnis</option>
            <option value="ekonomi">Ekonomi</option>
          </select>
        </div>

        <div class="sf" style="justify-content: flex-end; min-width: 120px;">
          <label style="visibility: hidden;">Aksi</label>
          <button type="button" 
                id="btn-pilih-kereta" 
                onclick="filterJadwal()" 
                style="background: #e04f26; color: white; border: none; padding: 0 25px; border-radius: 12px; font-weight: bold; cursor: pointer; height: 42px; font-size: 14px; white-space: nowrap; transition: background 0.2s; margin-top: auto; margin-bottom: 2px;">
          Cari Tiket
        </button>
        </div>

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
<div class="train-list-wrapper">
    
    <div id="train-list-container">
          @foreach($daftarJadwal as $jadwal)
            @php
                $jamMenit = \Carbon\Carbon::parse($jadwal->waktu_keberangkatan)->format('H:i:s');
                $waktuDinamis = \Carbon\Carbon::today()->setTimeFromTimeString($jamMenit);
                
                $totalMenit = $jadwal->durasi ?? 300; 
                
                $tampilanJam = floor($totalMenit / 60);
                $tampilanMenit = $totalMenit % 60;
                $teksDurasi = $tampilanJam . "j " . str_pad($tampilanMenit, 2, "0", STR_PAD_LEFT) . "m";
                
                $waktuTiba = $waktuDinamis->copy()->addMinutes($totalMenit)->format('H:i');
            @endphp

            <div class="train-card" 
                 data-asal="{{ strtolower($jadwal->asal) }}" 
                 data-tujuan="{{ strtolower($jadwal->tujuan) }}" 
                 data-tanggal="{{ $jadwal->tanggal_berangkat }}" 
                 data-class="{{ strtolower($jadwal->kelas) }}" 
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

        <div id="btn-pilih-kursi-container" style="display: none;">
            <button type="button" id="btn-pilih-kursi" onclick="gulingKeKursi()">
                Pilih Kursi
            </button>
        </div>

</div>
        
 
<!-- PAGE 3: SEAT -->
<div class="page" id="page-seats">
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
      <div class="card" id="passenger-form-1" style="margin-bottom:16px">
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
            <div class="form-field">
                <label>Nama Lengkap (sesuai KTP)</label>
                <input type="text" class="input-pax" placeholder="Cth: Budi Santoso">
            </div>
            <div class="form-field">
                <label>Nomor KTP / Paspor</label>
                <input type="text" class="input-pax" placeholder="16 digit NIK">
            </div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>

      <div class="card" id="passenger-form-2" style="margin-bottom:16px; display:none;">
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
            <div class="form-field">
              <label>Nama Lengkap (sesuai KTP)</label>
              <input type="text" class="input-pax" placeholder="Cth: Budi Santoso">
          </div>
          <div class="form-field">
              <label>Nomor KTP / Paspor</label>
              <input type="text" class="input-pax" placeholder="16 digit NIK">
          </div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>

      <div class="card" id="passenger-form-3" style="margin-bottom:16px; display:none;">
        <div class="card-body">
          <div class="pax-section-header">
            <div class="pax-avatar">P3</div>
            <div>
              <div class="pax-section-label">Penumpang 3</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p3-seat">—</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field">
                <label>Nama Lengkap (sesuai KTP)</label>
                <input type="text" class="input-pax" placeholder="Cth: Budi Santoso">
            </div>
            <div class="form-field">
                <label>Nomor KTP / Paspor</label>
                <input type="text" class="input-pax" placeholder="16 digit NIK">
            </div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>

      <div class="card" id="passenger-form-4" style="margin-bottom:16px; display:none;">
        <div class="card-body">
          <div class="pax-section-header">
            <div class="pax-avatar">P4</div>
            <div>
              <div class="pax-section-label">Penumpang 4</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p4-seat">—</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field">
              <label>Nama Lengkap (sesuai KTP)</label>
              <input type="text" class="input-pax" placeholder="Cth: Budi Santoso">
          </div>
          <div class="form-field">
              <label>Nomor KTP / Paspor</label>
              <input type="text" class="input-pax" placeholder="16 digit NIK">
          </div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>

      <div class="card" id="passenger-form-5" style="margin-bottom:16px; display:none;">
        <div class="card-body">
          <div class="pax-section-header">
            <div class="pax-avatar">P5</div>
            <div>
              <div class="pax-section-label">Penumpang 5</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p5-seat">—</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field">
              <label>Nama Lengkap (sesuai KTP)</label>
              <input type="text" class="input-pax" placeholder="Cth: Budi Santoso">
          </div>
          <div class="form-field">
              <label>Nomor KTP / Paspor</label>
              <input type="text" class="input-pax" placeholder="16 digit NIK">
          </div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>

      <div class="card" id="passenger-form-6" style="margin-bottom:16px; display:none;">
        <div class="card-body">
          <div class="pax-section-header">
            <div class="pax-avatar">P6</div>
            <div>
              <div class="pax-section-label">Penumpang 6</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p6-seat">—</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field">
              <label>Nama Lengkap (sesuai KTP)</label>
              <input type="text" class="input-pax" placeholder="Cth: Budi Santoso">
          </div>
          <div class="form-field">
              <label>Nomor KTP / Paspor</label>
              <input type="text" class="input-pax" placeholder="16 digit NIK">
          </div>
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
            <div class="form-field">
              <label>Alamat Email</label>
              <input type="email" class="input-pax" placeholder="email@contoh.com">
          </div>
          <div class="form-field">
              <label>Nomor HP Pemesan</label>
              <input type="text" class="input-pax" placeholder="+62 812 xxxx xxxx">
          </div>
          </div>
          <div class="notice notice-info">
            <i class="ti ti-send"></i>E-tiket akan dikirim ke email dan nomor HP ini
          </div>
          <div style="display:flex;gap:12px;margin-top:16px">
            <button class="btn-outline" onclick="goPage('page-seats',3)"><i class="ti ti-arrow-left"></i>Kembali</button>
            <button class="btn-primary" onclick="validasiDanLanjut()">
                Lanjut ke Konfirmasi <i class="ti ti-arrow-right"></i>
            </button>
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
          <div class="sum-row"><span class="sum-label">Rute</span><span class="sum-val" id="s2-rute">GMR → YK</span></div>
          <div class="sum-row"><span class="sum-label">Tanggal</span><span class="sum-val" id="s2-tanggal">15 Jun 2026</span></div>
          <div class="sum-row"><span class="sum-label">Kereta</span><span class="sum-val" id="s2-train">Argo Bromo</span></div>
          <div class="sum-row"><span class="sum-label">Kursi</span><span class="sum-val" id="s2-seats">4A, 4B</span></div>
          <div class="sum-row"><span class="sum-label" id="s2-skema">2 × Rp 580.000</span><span class="sum-val" id="s2-subtotal">Rp 1.160.000</span></div>
          <div class="sum-row"><span class="sum-label">Biaya layanan</span><span class="sum-val">Rp 20.000</span></div>
          <div class="sum-total"><span>Total</span><span class="sum-total-amt" id="s2-total">Rp 1.180.000</span></div>
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
                <div class="ticket-class" id="cnf-class-date">Eksekutif · 15 Juni 2026</div>
              </div>
              <i class="ti ti-train ticket-icon"></i>
            </div>
            <div class="ticket-body">
              <div class="ticket-route">
                <div class="ticket-city" id="cnf-station-origin">GMR</div>
                <div class="ticket-line">
                  <div class="ticket-dur" style="text-align:center;font-size:11px;color:var(--text-mute);margin-bottom:3px" id="tck-dur">5j 05m</div>
                  <div class="ticket-line-inner"></div>
                </div>
                <div class="ticket-city" id="cnf-station-dest">YK</div>
              </div>
              <div class="ticket-meta">
                <div class="tm-item"><small>Berangkat</small><span id="tck-dep">07:00</span></div>
                <div class="tm-item"><small>Tiba</small><span id="tck-arr">12:05</span></div>
                <div class="tm-item"><small>Kursi</small><span id="tck-seats">4A, 4B</span></div>
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
          <div class="sum-row" style="font-size:13px">
            <span class="sum-label" id="cnf-subtotal-label">Subtotal</span>
            <span class="sum-val" id="cnf-subtotal-val">Rp 1.160.000</span>
          </div>
          <div class="sum-row" style="font-size:13px">
            <span class="sum-label">Biaya layanan</span>
            <span class="sum-val">Rp 20.000</span>
          </div>
          <div class="sum-total" style="padding-top:14px">
            <span>Total Pembayaran</span>
            <span class="sum-total-amt" id="cnf-total-val">Rp 1.180.000</span>
          </div>
          <div style="display:flex;gap:12px;margin-top:16px">
            <button class="btn-outline" onclick="goPage('page-passenger',4)"><i class="ti ti-arrow-left"></i>Kembali</button>
            <button class="btn-primary" id="cnf-btn-pay" onclick="showSuccess()">
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
      <button class="btn-primary" style="width:auto;padding:0 24px" onclick="pesanLagi()">
        <i class="ti ti-search"></i>Pesan Lagi
      </button>
    </div>
  </div>
</div>
 
</div><!-- .main -->
 
<script>
// Variabel global utama untuk melacak status pemesanan tiket
var pax = 1; 
var selPrice = 0, selSeats = [], selTrainName = '';
var taken = @json($kursiTerisi ?? []); 
var cdSecs = 5387, cdTotal = 5387;

document.addEventListener("DOMContentLoaded", function() {
    var btnKurang = document.getElementById('pax-kurang');
    var btnTambah = document.getElementById('pax-tambah');
    var txtPax = document.getElementById('pax-val');

    // Ambil inisialisasi awal jumlah penumpang langsung dari teks elemen jika ada
    if (txtPax) {
        pax = parseInt(txtPax.textContent) || 1;
    }

    // Fungsi sinkronisasi manual saat jumlah penumpang ditambah/dikurang oleh user
    function sinkronisasiManual() {
        var currentPax = parseInt(txtPax.textContent) || 1;
        pax = currentPax; 

        var txtRingkasanPax = document.getElementById('s-pax'); 
        if (txtRingkasanPax) {
            txtRingkasanPax.textContent = currentPax + ' orang';
        }

        var txtNoticePax = document.getElementById('notice-pax-count');
        if (txtNoticePax) {
            txtNoticePax.textContent = currentPax;
        }

        if (typeof selPrice !== 'undefined' && selPrice > 0) {
            var totalHarga = selPrice * currentPax;
            var elTotal = document.getElementById('s-total');
            if (elTotal) {
                elTotal.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
            }
        }

        selSeats = [];
        buildSeats();
    }

    if (btnKurang && btnTambah && txtPax) {
        btnKurang.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); 
            
            var currentPax = parseInt(txtPax.textContent) || 1;
            if (currentPax > 1) {
                var newPax = currentPax - 1;
                txtPax.textContent = newPax;
                sinkronisasiManual(); 
            }
        });

        btnTambah.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); 
            
            var currentPax = parseInt(txtPax.textContent) || 1;
            if (currentPax < 6) {
                var newPax = currentPax + 1;
                txtPax.textContent = newPax;
                sinkronisasiManual(); 
            }
        });
    }
});

let kelasAktif = 'all';
var tiketDitemukan = true;

// ==========================================
// 2. FUNGSI FILTER JADWAL UTAMA (CARI TIKET)
// ==========================================
function jalankanPenyaringanTotal() {
    const asalUser = document.getElementById('input-asal')?.value.toLowerCase().trim() || "";
    const tujuanUser = document.getElementById('input-tujuan')?.value.toLowerCase().trim() || "";
    const kelasUser = document.getElementById('input-kelas')?.value.toLowerCase().trim() || "semua";
    
    const semuaKartu = document.querySelectorAll('.train-card');

    semuaKartu.forEach(kartu => {
        const dataAsal = (kartu.getAttribute('data-asal') || kartu.innerText || '').toLowerCase().trim();
        const dataTujuan = (kartu.getAttribute('data-tujuan') || kartu.innerText || '').toLowerCase().trim();
        const dataKelas = (kartu.getAttribute('data-class') || kartu.innerText || '').toLowerCase().trim();

        const cocokAsal = (dataAsal.includes(asalUser) || asalUser === "");
        const cocokTujuan = (dataTujuan.includes(tujuanUser) || tujuanUser === "");
        const cocokKelas = (kelasUser === 'semua' || kelasUser === '' || dataKelas.includes(kelasUser));

        if (cocokAsal && cocokTujuan && cocokKelas) {
            kartu.style.display = ""; 
        } else {
            kartu.style.display = "none";
        }   
    });
    cekPesanKosong(); // Ini sudah memanggil updateTombolPilihKursi
}

function updateTombolPilihKursi() {
    var btn = document.getElementById('btn-pilih-kursi');
    if (!btn) return;

    const visibleCards = Array.from(document.querySelectorAll('.train-card')).filter(c => c.style.display !== 'none');
    
    if (visibleCards.length > 0) {
        btn.disabled = false;
        btn.style.opacity = "1";
        btn.style.cursor = "pointer";
    } else {
        btn.disabled = true;
        btn.style.opacity = "0.5";
        btn.style.cursor = "not-allowed";
    }
}

function filterJadwal() {
    jalankanPenyaringanTotal();
}

function filterTiket() {
    const kelasTerpilih = document.getElementById('input-kelas')?.value || "semua";

    document.querySelectorAll('.gtab, .tab-item').forEach(btn => {
        if (!btn.textContent.includes('Harga') && !btn.textContent.includes('Gerbong')) {
            btn.classList.remove('active');
            if (kelasTerpilih === 'semua' && btn.textContent.trim().toLowerCase() === 'semua') {
                btn.classList.add('active');
            } else if (btn.textContent.trim().toLowerCase() === kelasTerpilih) {
                btn.classList.add('active');
            }
        }
    });

    jalankanPenyaringanTotal();
}

function filterClass(el, className) {
    const targetClass = className.toLowerCase().trim();

    const dropdownKelas = document.getElementById('input-kelas');
    if (dropdownKelas) {
        dropdownKelas.value = targetClass === 'all' ? 'semua' : targetClass;
    }

    document.querySelectorAll('.gtab, .tab-item').forEach(btn => {
        if (!btn.textContent.includes('Harga') && !btn.textContent.includes('Gerbong')) {
            btn.classList.remove('active');
        }
    });
    if (el) el.classList.add('active');

    jalankanPenyaringanTotal();
    updateTombolPilihKursi(); 
}

function cekPesanKosong() {
    const container = document.getElementById('train-list-container') || document.querySelector('.search-card')?.parentElement;
    let pesanKosong = document.getElementById('no-ticket-message');
    
    // Cek apakah ada kartu yang muncul
    const kartuKereta = document.querySelectorAll('.train-card');
    const adaTiket = Array.from(kartuKereta).some(card => card.style.display !== 'none');

    // Handle Tampilan Pesan Kosong
    if (!adaTiket) {
        if (!pesanKosong && container) {
            pesanKosong = document.createElement('div');
            pesanKosong.id = 'no-ticket-message';
            pesanKosong.style.cssText = 'text-align: center; padding: 40px; color: #888; font-weight: 500; background: #fff; border-radius: 8px; margin-top: 15px; width: 100%;';
            pesanKosong.innerHTML = '⚠️ Maaf, jadwal perjalanan kereta tidak ditemukan.';
            container.appendChild(pesanKosong);
        }
    } else {
        if (pesanKosong) pesanKosong.remove();
    }

    // Panggil fungsi update tombol setiap kali pengecekan dilakukan
    updateTombolPilihKursi();
}

function filterTabs(namaKelas) {
    const target = namaKelas.toLowerCase() === 'semua' ? 'all' : namaKelas;
    let elemenBtn = Array.from(document.querySelectorAll('.gtab, .tab-item')).find(btn => btn.textContent.trim().toLowerCase() === namaKelas.toLowerCase());
    filterClass(elemenBtn, target);
}

// ==========================================
// 3. FUNGSI URUT HARGA TERENDAH (SANGAT AMAN)
// ==========================================
function triggerSortPrice(el, order) {
    // 1. Atur status aktif pada tab filter/sort
    document.querySelectorAll('.filter-tabs .gtab, .sort-tab, .tab-item').forEach(btn => btn.classList.remove('active'));
    if (el) el.classList.add('active');

    // 2. Cari kartu kereta pertama untuk mendeteksi kontainer induknya
    const kartuAcuan = document.querySelector('.train-card');
    if (!kartuAcuan) return;
    const container = kartuAcuan.parentElement;

    // 3. Ambil HANYA elemen yang memiliki class '.train-card' (Tombol Pilih Kursi tidak akan ikut)
    const cards = Array.from(container.querySelectorAll('.train-card'));
    if (cards.length === 0) return;

    // 4. Lakukan pengurutan array kartu berdasarkan data-price atau teks nominal Rp
    cards.sort((a, b) => {
        let priceA = parseInt(a.getAttribute('data-price'));
        let priceB = parseInt(b.getAttribute('data-price'));

        if (!priceA) {
            const matchA = a.innerText.match(/Rp\s?([\d.]+)/);
            priceA = matchA ? parseInt(matchA[1].replace(/\./g, '')) : 0;
        }
        if (!priceB) {
            const matchB = b.innerText.match(/Rp\s?([\d.]+)/);
            priceB = matchB ? parseInt(matchB[1].replace(/\./g, '')) : 0;
        }

        return priceA - priceB;
    });

    // 5. Masukkan kembali kartu kereta yang sudah terurut ke posisi sebelum tombol "Pilih Kursi"
    cards.forEach(card => {
        container.appendChild(card);
    });
    
    // 6. Pindahkan kembali tombol "Pilih Kursi" (atau pembungkusnya) ke urutan paling bawah
    const btnPilih = document.getElementById('btn-pilih-kursi');
    if (btnPilih) {
        const btnWrapper = btnPilih.closest('#btn-pilih-kursi-container') || btnPilih;
        if (btnWrapper && btnWrapper.parentElement === container) {
            container.appendChild(btnWrapper);
        }
    }

    updateTombolPilihKursi(); 
}

function urutHargaTerendah() {
    let btnHarga = Array.from(document.querySelectorAll('.gtab, .tab-item')).find(btn => btn.textContent.includes('Harga'));
    triggerSortPrice(btnHarga, 'asc');
}

// ==========================================
// 4. FUNGSI SWAP STASIUN
// ==========================================
function swapSt(){
  var f = document.getElementById('input-asal'), t = document.getElementById('input-tujuan');
  if (f && t) {
      var tmp = f.value; 
      f.value = t.value; 
      t.value = tmp;
      jalankanPenyaringanTotal();
  }
}
 
function selTrain(el, name, cls, dep, arr, price, dur, stops) {
    // 1. Reset tampilan kartu lain
    document.querySelectorAll('.train-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    
    // 2. Update data global
    selTrainName = name; 
    selPrice = parseInt(price);
    
    var txtPax = document.getElementById('pax-val');
    var jumlahPenumpang = txtPax ? parseInt(txtPax.textContent) : 1;
    pax = jumlahPenumpang; 
    var totalHarga = selPrice * jumlahPenumpang;

    // 3. LOGIKA TOMBOL "Pilih Kursi"
    var btnPilih = document.getElementById('btn-pilih-kursi');
    var containerBtn = document.getElementById('btn-pilih-kursi-container');

    if (btnPilih) {
        btnPilih.removeAttribute('disabled');
        btnPilih.disabled = false;
        btnPilih.style.cursor = 'pointer';
        btnPilih.style.opacity = '1';
        btnPilih.style.display = 'block';
    }

    if (containerBtn) {
        containerBtn.style.display = 'block';
    }
    
    // 4. Update Teks UI
    if (document.getElementById('seat-train-lbl')) document.getElementById('seat-train-lbl').textContent = name + ' · ' + cls;
    if (document.getElementById('s-train')) document.getElementById('s-train').textContent = name.split(' ').slice(0, 2).join(' ');
    if (document.getElementById('s2-train')) document.getElementById('s2-train').textContent = name.split(' ').slice(0, 2).join(' ');
    if (document.getElementById('s-price')) document.getElementById('s-price').textContent = 'Rp ' + selPrice.toLocaleString('id-ID');
    if (document.getElementById('s-total')) document.getElementById('s-total').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
    
    var txtRingkasanPax = document.getElementById('s-pax'); 
    if (txtRingkasanPax) txtRingkasanPax.textContent = jumlahPenumpang + ' orang';

    var txtNoticePax = document.getElementById('notice-pax-count');
    if (txtNoticePax) txtNoticePax.textContent = jumlahPenumpang;

    if (document.getElementById('tck-train')) document.getElementById('tck-train').textContent = name;
    if (document.getElementById('tck-dep')) document.getElementById('tck-dep').textContent = dep;
    if (document.getElementById('tck-arr')) document.getElementById('tck-arr').textContent = arr;
    if (document.getElementById('tck-dur')) document.getElementById('tck-dur').textContent = dur;
    
    // 5. Build Seat Map
    selSeats = [];
    if (typeof buildSeats === "function") {
        buildSeats();
    }
}

function gulingKeKursi() {
  if (typeof goPage === 'function') {
      goPage('page-seats', 2);
  }

  setTimeout(function() {
      const areaKursi = document.getElementById('page-seats');
      if (areaKursi) {
          areaKursi.scrollIntoView({ 
              behavior: 'smooth', 
              block: 'start' 
          });
      }
  }, 50);
}
 
function buildSeats(){
  var map=document.getElementById('seat-map');
  if(!map) return; 
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
  
  for (var i = 1; i <= 6; i++) {
      var elP = document.getElementById('p' + i + '-seat');
      if (elP) {
          elP.textContent = selSeats[i - 1] ? selSeats[i - 1] : '—';
      }
  }
  
  var btn=document.getElementById('btn-lanjut-kursi') || document.getElementById('btn-lanjut-penumpang');
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

function pesanLagi(){
  document.querySelectorAll('.page').forEach(page => { page.style.display = 'none'; });
  document.querySelectorAll('.tstep').forEach(s=>{s.classList.remove('active');s.classList.remove('done');});
  document.getElementById('s2') && document.getElementById('s2').classList.add('active');
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ==========================================
// 5. NAVIGASI HALAMAN & SINKRONISASI WIZARD
// ==========================================
function goPage(pageId, stepNumber) {
    var ticketPage = document.getElementById('page-tickets');
    if (ticketPage) ticketPage.style.display = 'none';

    document.querySelectorAll('.page').forEach(page => {
        page.style.display = 'none';
    });

    var targetPage = document.getElementById(pageId);
    if (targetPage) {
        targetPage.style.display = 'block'; 
    }

    if (pageId === 'page-seats' && typeof buildSeats === 'function') {
        buildSeats();
    }

    // ⭐ SINKRONISASI 1: DATA PENUMPANG
    if (pageId === 'page-passenger') {
        var txtPax = document.getElementById('pax-val');
        if (txtPax) {
            pax = parseInt(txtPax.textContent) || 1;
        }

        var inputAsal = document.getElementById('input-asal')?.value || "GMR";
        var inputTujuan = document.getElementById('input-tujuan')?.value || "YK";
        var inputTanggal = document.getElementById('input-tanggal')?.value || "15 Jun 2026";
        
        if (document.getElementById('s2-rute')) {
            document.getElementById('s2-rute').textContent = inputAsal + ' → ' + inputTujuan;
        }
        if (document.getElementById('s2-tanggal')) {
            document.getElementById('s2-tanggal').textContent = inputTanggal;
        }

        if (typeof selPrice !== 'undefined' && selPrice > 0) {
            var subTotal = selPrice * pax;
            var totalAkhir = subTotal + 20000; 

            if (document.getElementById('s2-skema')) {
                document.getElementById('s2-skema').textContent = pax + ' × Rp ' + selPrice.toLocaleString('id-ID');
            }
            if (document.getElementById('s2-subtotal')) {
                document.getElementById('s2-subtotal').textContent = 'Rp ' + subTotal.toLocaleString('id-ID');
            }
            if (document.getElementById('s2-total')) {
                document.getElementById('s2-total').textContent = 'Rp ' + totalAkhir.toLocaleString('id-ID');
            }
        }

        for (var i = 1; i <= 6; i++) {
            var containerPassenger = document.getElementById('passenger-form-' + i);
            if (containerPassenger) {
                if (i <= pax) {
                    containerPassenger.style.display = 'block';
                } else {
                    containerPassenger.style.display = 'none';
                }
            }
        }

        setTimeout(function() {
            if (targetPage) targetPage.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 80);
        return; 
    }

    // ⭐ SINKRONISASI 2: KONFIRMASI PEMBAYARAN
    if (pageId === 'page-confirm') {
        var inputAsal = document.getElementById('input-asal')?.value || "GMR";
        var inputTujuan = document.getElementById('input-tujuan')?.value || "YK";
        var inputTanggal = document.getElementById('input-tanggal')?.value || "15 Jun 2026";
        
        var namaKereta = document.getElementById('s2-train')?.textContent || "Utama";
        var listKursi = document.getElementById('s2-seats')?.textContent || "—";
        var teksSkema = document.getElementById('s2-skema')?.textContent || "1 × Rp 0";
        var subTotalVal = document.getElementById('s2-subtotal')?.textContent || "Rp 0";
        var totalFinalVal = document.getElementById('s2-total')?.textContent || "Rp 0";

        var txtPax = document.getElementById('pax-val');
        if (txtPax) {
            pax = parseInt(txtPax.textContent) || 1;
        }

        if (document.getElementById('cnf-station-origin')) document.getElementById('cnf-station-origin').textContent = inputAsal;
        if (document.getElementById('cnf-station-dest')) document.getElementById('cnf-station-dest').textContent = inputTujuan;
        if (document.getElementById('cnf-class-date')) document.getElementById('cnf-class-date').textContent = "Eksekutif · " + inputTanggal;
        if (document.getElementById('tck-train')) document.getElementById('tck-train').textContent = namaKereta;
        if (document.getElementById('tck-seats')) document.getElementById('tck-seats').textContent = listKursi;
        if (document.getElementById('cnf-pax-count')) document.getElementById('cnf-pax-count').textContent = pax + " orang";
        
        if (document.getElementById('cnf-subtotal-label')) document.getElementById('cnf-subtotal-label').textContent = "Subtotal (" + teksSkema + ")";
        if (document.getElementById('cnf-subtotal-val')) document.getElementById('cnf-subtotal-val').textContent = subTotalVal;
        if (document.getElementById('cnf-total-val')) document.getElementById('cnf-total-val').textContent = totalFinalVal;
        if (document.getElementById('cnf-btn-pay')) {
            document.getElementById('cnf-btn-pay').innerHTML = '<i class="ti ti-lock"></i>Bayar — ' + totalFinalVal;
        }

        setTimeout(function() {
            if (targetPage) targetPage.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 80);
        return;
    }

    document.querySelectorAll('.tstep').forEach((step, index) => {
        if (index < stepNumber) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Countdown timer booking sistem
setInterval(function(){
    if(cdSecs <= 0) return;
    cdSecs--;
    var h = Math.floor(cdSecs/3600), m = Math.floor((cdSecs%3600)/60), s = cdSecs%60;
    var el = document.getElementById('cdnum');
    if(el) el.textContent = (h ? String(h).padStart(2,'0')+':' : '') + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    var prog = document.getElementById('cdprog');
    if(prog) prog.style.width = Math.round(cdSecs/cdTotal*100)+'%';
}, 1000);
 
buildSeats();

function validasiDanLanjut() {
    // Ambil semua input dan select dengan class 'input-pax'
    var allInputs = document.querySelectorAll('.input-pax');
    var isFormValid = true;

    allInputs.forEach(function(input) {
        var isVisible = (input.offsetWidth > 0 && input.offsetHeight > 0); 
        
        if (isVisible) {
            if (input.value.trim() === "") {
                isFormValid = false;
                input.style.borderColor = "red";
            } else {
                input.style.borderColor = "#ccc";
            }
        }
    });

    if (!isFormValid) {
        alert("Mohon lengkapi semua data penumpang dan kontak pemesan yang terlihat!");
        return false;
    }

    goPage('page-confirm', 4);
}

function kirimDataPemesanan() {
    let formData = {
        id_jadwal: document.getElementById('id_jadwal')?.value,
        no_kursi: selSeats.join(','),
        total_harga: selPrice * pax,
        _token: '{{ csrf_token() }}'
    };

    fetch('/pesan-tiket', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            window.location.href = '/konfirmasi/' + data.kode_booking;
        } else {
            alert("Gagal melakukan pemesanan!");
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
</body>
</html>