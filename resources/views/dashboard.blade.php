<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Velozza</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardpenumpang.css') }}">
</head>

<body>
 
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
        <div class="sf sf-station">
          <label>Dari</label>
          <input type="text" id="from-inp" value="Jakarta Gambir">
        </div>
        <button class="swap-btn" onclick="swapSt()" title="Tukar stasiun"><i class="ti ti-arrows-exchange"></i></button>
        <div class="sf sf-station">
          <label>Ke</label>
          <input type="text" id="to-inp" value="Yogyakarta">
        </div>
        <div class="sf">
          <label>Tanggal</label>
          <input type="date" value="2026-06-15" style="width:160px">
        </div>
        <div class="sf" style="min-width:auto;flex:0">
          <label>Penumpang</label>
          <div class="pax-counter">
            <button class="pax-btn" onclick="chgPax(-1)">−</button>
            <span class="pax-val" id="pax-val">2</span>
            <button class="pax-btn" onclick="chgPax(1)">+</button>
          </div>
        </div>
        <div class="sf" style="min-width:130px">
          <label>Kelas</label>
          <select>
            <option>Semua Kelas</option>
            <option>Eksekutif</option>
            <option>Bisnis</option>
            <option>Ekonomi</option>
          </select>
        </div>
        <button class="btn-search" onclick="goPage('page-results',2)">
          <i class="ti ti-search"></i>Cari Tiket
        </button>
      </div>
    </div>
  </div>
</div>
 
<div class="main">
 
<!-- PAGE 2: RESULTS -->
<div class="page active" id="page-results">
  <div class="result-header">
    <div class="rh-route">
      <i class="ti ti-map-pin"></i>Jakarta
      <i class="ti ti-arrow-right"></i>
      <i class="ti ti-map-pin"></i>Bandung
    </div>
    <div class="rh-date">Senin, 15 Juni 2026</div>
    <span class="badge badge-orange">2 penumpang</span>
    <button class="btn-sm" onclick="scrollToSearch()" style="margin-left:auto">
      <i class="ti ti-pencil"></i>Ubah
    </button>
  </div>
 
  <div class="layout-2col">
    <div>
      <div class="filter-tabs">
        <div class="ftab active">Semua (8)</div>
        <div class="ftab">Eksekutif</div>
        <div class="ftab">Bisnis</div>
        <div class="ftab">Ekonomi</div>
        <div class="ftab" style="margin-left:auto">
          <i class="ti ti-arrows-sort" style="font-size:12px;vertical-align:-1px"></i> Harga Terendah
        </div>
      </div>
 
      <!-- Train cards -->
      <div class="train-card" onclick="selTrain(this,'Argo Bromo Anggrek','Eksekutif','07:00','12:05','580000','5j 05m','langsung')">
        <div class="tc-main">
          <div class="tc-name-block">
            <div class="tc-name">Argo Bromo Anggrek</div>
            <span class="tc-class-pill pill-exec">Eksekutif</span>
          </div>
          <div>
            <div class="tc-time">07:00</div>
            <div class="tc-sta">GMR</div>
          </div>
          <div class="tc-mid">
            <div class="tc-dur">5j 05m</div>
            <div class="tc-line"></div>
            <div class="tc-stops">Langsung</div>
          </div>
          <div>
            <div class="tc-time">12:05</div>
            <div class="tc-sta">YK</div>
          </div>
          <div class="tc-price">
            <div class="tc-price-amt">Rp 580.000</div>
            <div class="tc-price-per">/orang</div>
          </div>
        </div>
        <div class="tc-footer">
          <span class="badge badge-green"><i class="ti ti-armchair" style="font-size:11px"></i> 24 kursi</span>
          <span class="badge badge-blue">Makan</span>
          <span class="badge badge-blue">WiFi</span>
          <button class="btn-sm" style="margin-left:auto" onclick="showRoute(event,'Argo Bromo Anggrek')">
            <i class="ti ti-route"></i>Rute
          </button>
        </div>
      </div>
 
      <div class="train-card" onclick="selTrain(this,'Taksaka Pagi','Eksekutif','08:30','14:00','520000','5j 30m','langsung')">
        <div class="tc-main">
          <div class="tc-name-block">
            <div class="tc-name">Taksaka Pagi</div>
            <span class="tc-class-pill pill-exec">Eksekutif</span>
          </div>
          <div>
            <div class="tc-time">08:30</div>
            <div class="tc-sta">GMR</div>
          </div>
          <div class="tc-mid">
            <div class="tc-dur">5j 30m</div>
            <div class="tc-line"></div>
            <div class="tc-stops">Langsung</div>
          </div>
          <div>
            <div class="tc-time">14:00</div>
            <div class="tc-sta">YK</div>
          </div>
          <div class="tc-price">
            <div class="tc-price-amt">Rp 520.000</div>
            <div class="tc-price-per">/orang</div>
          </div>
        </div>
        <div class="tc-footer">
          <span class="badge badge-orange"><i class="ti ti-armchair" style="font-size:11px"></i> 8 kursi</span>
          <span class="badge badge-blue">WiFi</span>
          <button class="btn-sm" style="margin-left:auto" onclick="showRoute(event,'Taksaka Pagi')">
            <i class="ti ti-route"></i>Rute
          </button>
        </div>
      </div>
 
      <div class="train-card" onclick="selTrain(this,'Senja Utama YK','Bisnis','10:15','16:20','290000','6j 05m','1 pemberhentian')">
        <div class="tc-main">
          <div class="tc-name-block">
            <div class="tc-name">Senja Utama YK</div>
            <span class="tc-class-pill pill-biz">Bisnis</span>
          </div>
          <div>
            <div class="tc-time">10:15</div>
            <div class="tc-sta">GMR</div>
          </div>
          <div class="tc-mid">
            <div class="tc-dur">6j 05m</div>
            <div class="tc-line"></div>
            <div class="tc-stops">1 pemberhentian</div>
          </div>
          <div>
            <div class="tc-time">16:20</div>
            <div class="tc-sta">YK</div>
          </div>
          <div class="tc-price">
            <div class="tc-price-amt">Rp 290.000</div>
            <div class="tc-price-per">/orang</div>
          </div>
        </div>
        <div class="tc-footer">
          <span class="badge badge-red"><i class="ti ti-armchair" style="font-size:11px"></i> 3 kursi</span>
          <button class="btn-sm" style="margin-left:auto" onclick="showRoute(event,'Senja Utama YK')">
            <i class="ti ti-route"></i>Rute
          </button>
        </div>
      </div>
 
      <div class="train-card" onclick="selTrain(this,'Lodaya Pagi','Bisnis','06:00','14:30','260000','8j 30m','2 pemberhentian')">
        <div class="tc-main">
          <div class="tc-name-block">
            <div class="tc-name">Lodaya Pagi</div>
            <span class="tc-class-pill pill-biz">Bisnis</span>
          </div>
          <div>
            <div class="tc-time">06:00</div>
            <div class="tc-sta">GMR</div>
          </div>
          <div class="tc-mid">
            <div class="tc-dur">8j 30m</div>
            <div class="tc-line"></div>
            <div class="tc-stops">2 pemberhentian</div>
          </div>
          <div>
            <div class="tc-time">14:30</div>
            <div class="tc-sta">YK</div>
          </div>
          <div class="tc-price">
            <div class="tc-price-amt">Rp 260.000</div>
            <div class="tc-price-per">/orang</div>
          </div>
        </div>
        <div class="tc-footer">
          <span class="badge badge-green"><i class="ti ti-armchair" style="font-size:11px"></i> 42 kursi</span>
          <button class="btn-sm" style="margin-left:auto" onclick="showRoute(event,'Lodaya Pagi')">
            <i class="ti ti-route"></i>Rute
          </button>
        </div>
      </div>
 
      <div class="train-card" onclick="selTrain(this,'Gajayana','Eksekutif','14:00','19:45','610000','5j 45m','langsung')">
        <div class="tc-main">
          <div class="tc-name-block">
            <div class="tc-name">Gajayana</div>
            <span class="tc-class-pill pill-exec">Eksekutif</span>
          </div>
          <div>
            <div class="tc-time">14:00</div>
            <div class="tc-sta">GMR</div>
          </div>
          <div class="tc-mid">
            <div class="tc-dur">5j 45m</div>
            <div class="tc-line"></div>
            <div class="tc-stops">Langsung</div>
          </div>
          <div>
            <div class="tc-time">19:45</div>
            <div class="tc-sta">YK</div>
          </div>
          <div class="tc-price">
            <div class="tc-price-amt">Rp 610.000</div>
            <div class="tc-price-per">/orang</div>
          </div>
        </div>
        <div class="tc-footer">
          <span class="badge badge-green"><i class="ti ti-armchair" style="font-size:11px"></i> 18 kursi</span>
          <span class="badge badge-blue">Makan</span>
          <span class="badge badge-blue">WiFi</span>
          <button class="btn-sm" style="margin-left:auto" onclick="showRoute(event,'Gajayana')">
            <i class="ti ti-route"></i>Rute
          </button>
        </div>
      </div>
 
      <div style="margin-top:16px">
        <button class="btn-primary" id="btn-pilih-kereta" disabled onclick="goPage('page-seat',3)">
          Pilih Kursi <i class="ti ti-arrow-right"></i>
        </button>
      </div>
    </div>
 
    <!-- Route sidebar -->
    <div id="route-sidebar" style="display:none">
      <div class="route-panel">
        <div class="route-header">
          <div class="route-header-title" id="route-train-name">Detail Rute</div>
          <div class="route-close" onclick="document.getElementById('route-sidebar').style.display='none'">
            <i class="ti ti-x" style="font-size:14px"></i>
          </div>
        </div>
        <div class="route-body">
          <div class="stop-list" id="stop-list"></div>
          <div class="notice notice-info" style="margin-top:14px">
            <i class="ti ti-info-circle"></i>Estimasi jarak ±570 km
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
<!-- PAGE 3: SEAT -->
<div class="page" id="page-seat">
  <div class="layout-sidebar">
    <div>
      <div class="card">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-armchair"></i>Pilih Kursi</div>
          <div class="notice notice-info" style="margin-bottom:16px">
            <i class="ti ti-users"></i>Pilih 2 kursi untuk penumpang Anda
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
          <div class="sum-row"><span class="sum-label">Penumpang</span><span class="sum-val">2 orang</span></div>
          <div class="sum-total"><span>Total</span><span class="sum-total-amt" id="s-total">Rp 1.160.000</span></div>
          <button class="btn-primary" id="btn-lanjut-kursi" disabled onclick="goPage('page-passenger',4)" style="margin-top:14px">
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
var pax=2, selPrice=580000, selSeats=[], selTrainName='Argo Bromo Anggrek';
var taken=['1C','2A','2D','3B','3C','4C','5A','5D','6B','7A','7C'];
var cdSecs=5387, cdTotal=5387;
 
function goPage(id, step){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  document.querySelectorAll('.tstep').forEach((s,i)=>{
    s.classList.remove('active','done');
    if(i+1<step) s.classList.add('done');
    else if(i+1===step) s.classList.add('active');
  });
  window.scrollTo(0,0);
}
 
function swapSt(){
  var f=document.getElementById('from-inp'), t=document.getElementById('to-inp');
  var tmp=f.value; f.value=t.value; t.value=tmp;
}
 
function chgPax(d){
  pax=Math.max(1,Math.min(6,pax+d));
  document.getElementById('pax-val').textContent=pax;
}
 
function scrollToSearch(){ window.scrollTo(0,0); }
 
function selTrain(el,name,cls,dep,arr,price,dur,stops){
  document.querySelectorAll('.train-card').forEach(c=>c.classList.remove('selected'));
  el.classList.add('selected');
  selTrainName=name; selPrice=parseInt(price);
  document.getElementById('btn-pilih-kereta').disabled=false;
  document.getElementById('seat-train-lbl').textContent=name+' · '+cls;
  document.getElementById('s-train').textContent=name.split(' ').slice(0,2).join(' ');
  document.getElementById('s2-train').textContent=name.split(' ').slice(0,2).join(' ');
  document.getElementById('s-price').textContent='Rp '+parseInt(price).toLocaleString('id-ID');
  document.getElementById('s-total').textContent='Rp '+(parseInt(price)*2).toLocaleString('id-ID');
  document.getElementById('tck-train').textContent=name;
  document.getElementById('tck-dep').textContent=dep;
  document.getElementById('tck-arr').textContent=arr;
  document.getElementById('tck-dur').textContent=dur;
  selSeats=[];
  buildSeats();
}
 
var routeData = {
  'Argo Bromo Anggrek': [
    {name:'Jakarta Gambir',time:'07:00 · Berangkat',type:'start'},
    {name:'Cirebon',time:'09:05 · Transit 3 menit',type:'mid'},
    {name:'Purwokerto',time:'10:45 · Transit 3 menit',type:'mid'},
    {name:'Yogyakarta',time:'12:05 · Tiba',type:'end'}
  ],
  'Taksaka Pagi': [
    {name:'Jakarta Gambir',time:'08:30 · Berangkat',type:'start'},
    {name:'Yogyakarta',time:'14:00 · Tiba',type:'end'}
  ],
  'Senja Utama YK': [
    {name:'Jakarta Gambir',time:'10:15 · Berangkat',type:'start'},
    {name:'Cirebon',time:'12:20 · Transit 5 menit',type:'mid'},
    {name:'Yogyakarta',time:'16:20 · Tiba',type:'end'}
  ],
  'Lodaya Pagi': [
    {name:'Jakarta Gambir',time:'06:00 · Berangkat',type:'start'},
    {name:'Bandung',time:'08:30 · Transit 5 menit',type:'mid'},
    {name:'Tasikmalaya',time:'10:10 · Transit 3 menit',type:'mid'},
    {name:'Yogyakarta',time:'14:30 · Tiba',type:'end'}
  ],
  'Gajayana': [
    {name:'Jakarta Gambir',time:'14:00 · Berangkat',type:'start'},
    {name:'Cirebon',time:'16:05 · Transit 3 menit',type:'mid'},
    {name:'Yogyakarta',time:'19:45 · Tiba',type:'end'}
  ]
};
 
function showRoute(e,name){
  e.stopPropagation();
  var sb=document.getElementById('route-sidebar');
  sb.style.display='block';
  document.getElementById('route-train-name').textContent=name;
  var stops=routeData[name]||[];
  var html='';
  stops.forEach(function(s,i){
    var dotClass=s.type==='start'||s.type==='end'?'stop-dot':'stop-dot mid';
    html+='<div class="stop-item"><div class="'+dotClass+'"></div>';
    html+='<div class="stop-name">'+s.name+'</div>';
    html+='<div class="stop-time">'+s.time+'</div></div>';
  });
  document.getElementById('stop-list').innerHTML=html;
}
 
function buildSeats(){
  var map=document.getElementById('seat-map');
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
  if(idx>=0){selSeats.splice(idx,1);}
  else{
    if(selSeats.length>=2) selSeats.shift();
    selSeats.push(id);
  }
  buildSeats();
}
 
function updateSeatUI(){
  var txt=selSeats.length>0?selSeats.join(', '):'—';
  document.getElementById('s-seats').textContent=txt;
  document.getElementById('s2-seats').textContent=txt;
  document.getElementById('tck-seats').textContent=txt;
  if(selSeats[0]) document.getElementById('p1-seat').textContent=selSeats[0];
  if(selSeats[1]) document.getElementById('p2-seat').textContent=selSeats[1];
  var btn=document.getElementById('btn-lanjut-kursi');
  btn.disabled=selSeats.length!==2;
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
 
setInterval(function(){
  if(cdSecs<=0) return;
  cdSecs--;
  var h=Math.floor(cdSecs/3600), m=Math.floor((cdSecs%3600)/60), s=cdSecs%60;
  var el=document.getElementById('cdnum');
  if(el) el.textContent=(h?String(h).padStart(2,'0')+':':'')+String(m).padStart(2,'0')+':'+String(s).padStart(2,'0');
  var prog=document.getElementById('cdprog');
  if(prog) prog.style.width=Math.round(cdSecs/cdTotal*100)+'%';
},1000);
 
buildSeats();
</script>
</body>
</html>