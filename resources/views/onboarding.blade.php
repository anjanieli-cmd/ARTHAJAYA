<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Siapkan Akun Bisnismu — Arthajaya</title>

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logos.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logos.png') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

<script>
  (function(){
    try{
      var t = localStorage.getItem('aj-theme') || 'dark';
      var a = localStorage.getItem('aj-accent') || 'emerald';
      document.documentElement.setAttribute('data-theme', t);
      document.documentElement.setAttribute('data-accent', a);
    }catch(e){}
  })();
</script>

<style>
  :root{
    --bg: #070B13;
    --surface: rgba(255,255,255,0.04);
    --surface-strong: rgba(255,255,255,0.08);
    --border: rgba(255,255,255,0.09);
    --border-hover: rgba(var(--emerald-rgb),0.35);
    --emerald: #34E0A1;
    --emerald-dim: #1E8F6B;
    --text: #EAF0F6;
    --text-mute: #8A96AE;
    --text-faint: #545E73;
    --radius: 20px;
    --modal-bg: linear-gradient(160deg, #0F1520, #0A0D14 60%);
    --star-op: 1;
    --emerald-rgb: 52,224,161;
    --glow1-a: 0.16;
    --glow2-a: 0.11;
    --danger: #E8637A;
  }
  [data-theme="light"]{
    --bg: #F4F6FA;
    --surface: rgba(15,25,40,0.035);
    --surface-strong: rgba(15,25,40,0.07);
    --border: rgba(15,25,40,0.10);
    --border-hover: rgba(var(--emerald-rgb),0.45);
    --emerald-dim: #17A374;
    --text: #131A26;
    --text-mute: #565F72;
    --text-faint: #838C9E;
    --modal-bg: linear-gradient(160deg, #FFFFFF, #F2F5F9 60%);
    --star-op: 0;
    --glow1-a: 0.22;
    --glow2-a: 0.16;
  }
  [data-accent="blue"]{ --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; }
  [data-accent="purple"]{ --emerald:#9B7BE0; --emerald-dim:#6E4FBE; --emerald-rgb:155,123,224; }
  [data-accent="orange"]{ --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; }
  [data-accent="pink"]{ --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; }

  *{ margin:0; padding:0; box-sizing:border-box; }
  html{ color-scheme: dark; }
  html[data-theme="light"]{ color-scheme: light; }
  body{
    background: var(--bg); color: var(--text); font-family:'Inter', sans-serif;
    line-height:1.5; min-height:100vh; transition: background .35s ease, color .35s ease;
  }
  h1,h2,h3,.display{ font-family:'Space Grotesk', sans-serif; letter-spacing:-0.02em; }
  a{ text-decoration:none; color:inherit; }
  svg{ display:block; }
  .icon{ width:1em; height:1em; }
  button{ font-family:inherit; }

  #starfield{ position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; opacity: var(--star-op); transition: opacity .35s ease; }
  .star{ position:absolute; border-radius:50%; background:#fff; animation: twinkle 3s ease-in-out infinite; }
  @keyframes twinkle{ 0%,100%{opacity:.15;} 50%{opacity:.9;} }
  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow1-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }
  .bg-glow-2{ position:fixed; bottom:-15%; left:-15%; width:700px; height:700px; background:radial-gradient(circle, rgba(var(--emerald-rgb),var(--glow2-a)) 0%, transparent 70%); pointer-events:none; z-index:0; }

  .topbar{ position:relative; z-index:5; display:flex; align-items:center; justify-content:space-between; padding:22px 32px; max-width:760px; margin:0 auto; }
  .logo{ display:flex; align-items:center; gap:10px; font-family:'Space Grotesk'; font-weight:700; font-size:18px; }
  .logo-mark{ width:30px; height:30px; border-radius:9px; background:var(--surface-strong); border:1px solid var(--border-hover); display:flex; align-items:center; justify-content:center; overflow:hidden; padding:3px; }
  .logo-mark img{ width:100%; height:100%; object-fit:contain; }
  .logo .dot{ color:var(--emerald); }
  .exit-link{ font-size:13.5px; color:var(--text-mute); display:flex; align-items:center; gap:7px; transition: color .2s ease; background:none; border:none; cursor:pointer; }
  .exit-link:hover{ color:var(--text); }
  .exit-link .icon{ width:14px; height:14px; }

  .wrap{ position:relative; z-index:2; max-width:760px; margin:0 auto; padding:10px 32px 80px; }

  .intro{ margin-bottom:26px; }
  .intro .tag{ font-size:12.5px; color:var(--emerald); font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-bottom:10px; display:block; }
  .intro h1{ font-size:27px; margin-bottom:8px; }
  .intro p{ font-size:14px; color:var(--text-mute); max-width:520px; }

  .panel{ background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:36px 40px; backdrop-filter:blur(10px); }

  .section{ margin-bottom:32px; }
  .section:last-of-type{ margin-bottom:0; }
  .section-head{ display:flex; align-items:baseline; gap:10px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid var(--border); }
  .section-head .num{ width:22px; height:22px; border-radius:50%; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); font-family:'IBM Plex Mono'; font-size:11.5px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
  .section-head h3{ font-size:15.5px; font-weight:600; }
  .section-head .opt-tag{ font-size:11.5px; color:var(--text-faint); font-weight:400; margin-left:auto; }

  .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
  .field-grid .full{ grid-column: 1 / -1; }
  .field{ display:flex; flex-direction:column; gap:7px; }
  .field label{ font-size:12.5px; color:var(--text-mute); font-weight:500; }
  .field label .opt{ color:var(--text-faint); font-weight:400; }
  .field input[type=text], .field input[type=number], .field select{
    width:100%; padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
    color:var(--text); font-family:'Inter'; font-size:14px; outline:none; transition: border-color .2s ease, background .2s ease;
    appearance:none;
  }
  .field select{
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
    background-repeat:no-repeat; background-position: right 14px center; background-size:14px; padding-right:38px;
  }
  .field input:focus, .field select:focus{ border-color: var(--border-hover); background:var(--surface); }
  .field-hint{ font-size:11.5px; color:var(--text-faint); margin-top:6px; }
  .field-error{ font-size:12px; color:var(--danger); margin-top:2px; }

  .logo-upload{ display:flex; align-items:center; gap:14px; margin-bottom:18px; }
  .logo-drop{ width:56px; height:56px; border-radius:14px; border:1.5px dashed var(--border); background:var(--surface-strong); display:flex; align-items:center; justify-content:center; color:var(--text-faint); flex-shrink:0; overflow:hidden; cursor:pointer; transition: border-color .2s ease; }
  .logo-drop:hover{ border-color:var(--border-hover); }
  .logo-drop img{ width:100%; height:100%; object-fit:cover; display:none; }
  .logo-drop .icon{ width:18px; height:18px; }
  .logo-upload-copy{ font-size:12.5px; color:var(--text-mute); }
  .logo-upload-copy button{ margin-top:6px; padding:7px 12px; font-size:12px; }

  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 24px; border-radius:12px; font-size:14.5px; font-weight:600; cursor:pointer; border:none; transition:all .25s ease; font-family:'Inter'; }
  .btn .icon{ width:16px; height:16px; transition: transform .25s ease; }
  .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 24px rgba(var(--emerald-rgb),0.35); width:100%; padding:14px; font-size:15px; }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 32px rgba(var(--emerald-rgb),0.5); }
  .btn-primary:hover .icon{ transform: translateX(3px); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); border-color: var(--border-hover); }
  .btn:disabled{ opacity:.4; cursor:not-allowed; }

  .submit-row{ margin-top:32px; }
  .submit-hint{ text-align:center; font-size:12px; color:var(--text-faint); margin-top:12px; }

  .success-screen{ display:none; position:relative; z-index:2; max-width:520px; margin:70px auto; text-align:center; padding:0 24px; }
  .success-screen.active{ display:block; }
  .success-check{ width:80px; height:80px; border-radius:50%; background:rgba(var(--emerald-rgb),0.12); border:1.5px solid rgba(var(--emerald-rgb),0.4); display:flex; align-items:center; justify-content:center; margin:0 auto 24px; color:var(--emerald); animation: popIn .5s cubic-bezier(.34,1.56,.64,1); }
  .success-check .icon{ width:34px; height:34px; }
  @keyframes popIn{ 0%{ transform:scale(0); opacity:0; } 100%{ transform:scale(1); opacity:1; } }
  .success-screen h1{ font-size:28px; margin-bottom:12px; }
  .success-screen p{ font-size:15px; color:var(--text-mute); margin-bottom:30px; }
  .success-recap{ display:flex; justify-content:center; gap:26px; margin-bottom:34px; flex-wrap:wrap; }
  .success-recap .item{ text-align:left; }
  .success-recap .lbl{ font-size:11.5px; color:var(--text-faint); margin-bottom:4px; }
  .success-recap .val{ font-size:14px; font-weight:600; font-family:'Space Grotesk'; }

  .settings-fab{ position:fixed; right:22px; bottom:22px; z-index:150; width:50px; height:50px; border-radius:50%; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--text); box-shadow:0 10px 30px rgba(0,0,0,0.35); backdrop-filter:blur(10px); transition: transform .25s ease, border-color .25s ease; }
  .settings-fab:hover{ transform: translateY(-3px) rotate(20deg); border-color:var(--border-hover); }
  .settings-fab .icon{ width:20px; height:20px; }
  .settings-panel{ position:fixed; right:22px; bottom:82px; z-index:150; width:230px; background:var(--modal-bg); border:1px solid var(--border); border-radius:18px; padding:18px; box-shadow:0 30px 70px rgba(0,0,0,0.45); opacity:0; visibility:hidden; transform: translateY(10px) scale(.97); transition: opacity .22s ease, transform .22s ease, visibility .22s; }
  .settings-panel.open{ opacity:1; visibility:visible; transform: translateY(0) scale(1); }
  .settings-panel h4{ font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:10px; }
  .settings-block{ margin-bottom:16px; }
  .settings-block:last-child{ margin-bottom:0; }
  .theme-toggle-row{ display:flex; gap:8px; }
  .theme-opt{ flex:1; display:flex; flex-direction:column; align-items:center; gap:5px; padding:9px 6px; border-radius:12px; border:1px solid var(--border); background:var(--surface); color:var(--text-mute); font-size:11px; cursor:pointer; transition: all .2s ease; }
  .theme-opt .icon{ width:14px; height:14px; }
  .theme-opt.active{ color:var(--emerald); border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
  .accent-row{ display:flex; gap:9px; }
  .accent-dot{ width:24px; height:24px; border-radius:50%; cursor:pointer; border:2px solid transparent; transition: transform .2s ease; }
  .accent-dot:hover{ transform: scale(1.1); }
  .accent-dot.active{ border-color: var(--text); }

  @media (max-width: 640px){
    .topbar, .wrap{ padding-left:20px; padding-right:20px; }
    .panel{ padding:26px 20px; }
    .field-grid{ grid-template-columns:1fr; }
    .success-recap{ gap:16px; }
  }
</style>
</head>
<body>

<div id="starfield"></div>
<div class="bg-glow"></div>
<div class="bg-glow-2"></div>

<svg width="0" height="0" style="position:absolute">
<defs>
  <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
  <symbol id="ic-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></symbol>
  <symbol id="ic-image" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></symbol>
  <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></symbol>
  <symbol id="ic-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/></symbol>
  <symbol id="ic-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5a8.5 8.5 0 1 1-9.5-11.4 7 7 0 0 0 9.5 11.4z"/></symbol>
</defs>
</svg>

<div class="settings-fab" id="settingsFab" aria-label="Pengaturan tampilan"><svg class="icon"><use href="#ic-gear"/></svg></div>
<div class="settings-panel" id="settingsPanel">
  <div class="settings-block">
    <h4>Tampilan</h4>
    <div class="theme-toggle-row">
      <div class="theme-opt" data-theme-opt="dark"><svg class="icon"><use href="#ic-moon"/></svg><span>Gelap</span></div>
      <div class="theme-opt" data-theme-opt="light"><svg class="icon"><use href="#ic-sun"/></svg><span>Terang</span></div>
    </div>
  </div>
  <div class="settings-block">
    <h4>Warna tema</h4>
    <div class="accent-row">
      <div class="accent-dot" data-accent-opt="emerald" style="background:#34E0A1"></div>
      <div class="accent-dot" data-accent-opt="blue" style="background:#4E8FF0"></div>
      <div class="accent-dot" data-accent-opt="purple" style="background:#9B7BE0"></div>
      <div class="accent-dot" data-accent-opt="orange" style="background:#F0A25A"></div>
      <div class="accent-dot" data-accent-opt="pink" style="background:#E85A9C"></div>
    </div>
  </div>
</div>

<div class="topbar">
  <div class="logo"><span class="logo-mark"><img src="{{ asset('logos.png') }}" alt="Arthajaya"></span>Artha<span class="dot">jaya</span></div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="exit-link"><svg class="icon"><use href="#ic-logout"/></svg> Simpan &amp; keluar</button>
  </form>
</div>

@if(session('completed'))
  {{-- ============ SUCCESS SCREEN ============ --}}
  <div class="success-screen active">
    <div class="success-check"><svg class="icon"><use href="#ic-check"/></svg></div>
    <h1>Setup selesai, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
    <p>Akun bisnis <b>{{ $company->name ?? 'perusahaanmu' }}</b> sudah siap dipakai. Dashboard keuanganmu sudah menunggu.</p>
    <div class="success-recap">
      <div class="item"><div class="lbl">Perusahaan</div><div class="val">{{ $company->name ?? '—' }}</div></div>
      <div class="item"><div class="lbl">Mata Uang</div><div class="val">{{ $company->currency ?? '—' }}</div></div>
      <div class="item"><div class="lbl">Saldo Awal</div><div class="val">{{ $company->currency_symbol ?? 'Rp' }}{{ number_format($company?->accounts?->first()?->initial_balance ?? 0, 0, ',', '.') }}</div></div>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="width:auto;display:inline-flex;">Masuk ke Dashboard <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
  </div>

@else
  {{-- ============ FORM SATU HALAMAN ============ --}}
  <div class="wrap">
    <div class="intro">
      <span class="tag">Setup Akun Bisnis</span>
      <h1>Siapkan data perusahaanmu</h1>
      <p>Cukup isi sekali. Data ini jadi dasar laporan keuangan, faktur, dan saldo awal di Arthajaya — bisa diubah kapan saja lewat menu Pengaturan.</p>
    </div>

    <form id="onboardingForm" method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="panel">

        {{-- 1. PROFIL PERUSAHAAN --}}
        <div class="section">
          <div class="section-head"><span class="num">1</span><h3>Profil Perusahaan</h3></div>

          <div class="logo-upload">
            <div class="logo-drop" id="logoDrop"><svg class="icon"><use href="#ic-image"/></svg><img id="logoPreview" alt=""></div>
            <div class="logo-upload-copy">
              <div>Logo perusahaan <span class="opt">(opsional)</span></div>
              <button type="button" class="btn btn-outline" onclick="document.getElementById('logoInput').click()">Pilih File</button>
              <input type="file" name="logo" id="logoInput" accept="image/*" style="display:none;">
            </div>
          </div>

          <div class="field-grid">
            <div class="field full">
              <label>Nama perusahaan</label>
              <input type="text" name="company_name" id="f-company" value="{{ old('company_name') }}" placeholder="cth. PT Andalas Maju Bersama">
              @error('company_name') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="field">
              <label>Jenis industri</label>
              <select name="industry" id="f-industry">
                <option value="">Pilih industri</option>
                @foreach(['Retail & E-commerce','Jasa & Konsultasi','Manufaktur','Teknologi / Software','F&B / Kuliner','Logistik & Distribusi','Konstruksi & Properti','Lainnya'] as $opt)
                  <option value="{{ $opt }}" @selected(old('industry')===$opt)>{{ $opt }}</option>
                @endforeach
              </select>
            </div>
            <div class="field">
              <label>Kota <span class="opt">(untuk faktur)</span></label>
              <input type="text" name="city" id="f-city" value="{{ old('city') }}" placeholder="cth. Surabaya">
            </div>
          </div>
        </div>

        {{-- 2. PENGATURAN KEUANGAN --}}
        <div class="section">
          <div class="section-head"><span class="num">2</span><h3>Pengaturan Keuangan</h3></div>
          <div class="field-grid">
            <div class="field">
              <label>Mata uang utama</label>
              <select name="currency" id="f-currency">
                <option value="IDR">IDR — Rupiah Indonesia</option>
                <option value="USD">USD — Dolar Amerika</option>
                <option value="SGD">SGD — Dolar Singapura</option>
                <option value="MYR">MYR — Ringgit Malaysia</option>
              </select>
            </div>
            <div class="field">
              <label>Tahun buku aktif</label>
              @php($currentYear = date('Y'))
              <select name="fiscal_year" id="f-fiscalyear">
                <option>{{ $currentYear }}</option>
                <option>{{ $currentYear + 1 }}</option>
              </select>
            </div>
            <div class="field full">
              <label>Bulan mulai tahun fiskal</label>
              <select name="fiscal_start_month" id="f-fiscalstart">
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                  <option @selected(old('fiscal_start_month')===$m)>{{ $m }}</option>
                @endforeach
              </select>
              <div class="field-hint">Kebanyakan bisnis di Indonesia pakai Januari–Desember.</div>
            </div>
          </div>
        </div>

        {{-- 3. REKENING AWAL --}}
        <div class="section">
          <div class="section-head"><span class="num">3</span><h3>Rekening Awal</h3><span class="opt-tag">Untuk perhitungan arus kas</span></div>
          <div class="field-grid">
            <div class="field">
              <label>Nama bank</label>
              <select name="bank_name" id="f-bank">
                <option value="">Pilih bank</option>
                <option>BCA</option><option>BRI</option><option>BNI</option><option>Mandiri</option>
                <option>CIMB Niaga</option><option>Kas Tunai (tanpa bank)</option><option>Lainnya</option>
              </select>
            </div>
            <div class="field">
              <label>Saldo awal (Rp)</label>
              <input type="number" name="initial_balance" id="f-balance" value="{{ old('initial_balance', 0) }}" min="0">
              <div class="field-hint">Belum tahu pastinya? Isi 0 dulu, sesuaikan nanti.</div>
            </div>
          </div>
        </div>

        <div class="submit-row">
          <button type="submit" class="btn btn-primary">Selesaikan Setup <svg class="icon"><use href="#ic-arrow-right"/></svg></button>
          <div class="submit-hint">Semua data bisa diubah kapan saja lewat menu Pengaturan.</div>
        </div>

      </div>
    </form>
  </div>
@endif

<script>
  // starfield
  const field = document.getElementById('starfield');
  if(field){
    for(let i=0;i<70;i++){
      const s = document.createElement('div');
      s.className = 'star';
      const size = Math.random()*2 + 0.5;
      s.style.width = size+'px'; s.style.height = size+'px';
      s.style.top = Math.random()*100+'%'; s.style.left = Math.random()*100+'%';
      s.style.animationDelay = (Math.random()*3)+'s';
      s.style.animationDuration = (2 + Math.random()*3)+'s';
      field.appendChild(s);
    }
  }

  // settings widget (theme/accent)
  (function(){
    const root = document.documentElement;
    const fab = document.getElementById('settingsFab');
    const panel = document.getElementById('settingsPanel');
    function getSaved(key, fb){ try{ return localStorage.getItem(key) || fb; }catch(e){ return fb; } }
    function save(key, val){ try{ localStorage.setItem(key, val); }catch(e){} }
    let theme = getSaved('aj-theme','dark');
    let accent = getSaved('aj-accent','emerald');
    function applyTheme(t){ theme=t; root.setAttribute('data-theme',t); save('aj-theme',t);
      document.querySelectorAll('.theme-opt').forEach(el=>el.classList.toggle('active', el.dataset.themeOpt===t)); }
    function applyAccent(a){ accent=a; root.setAttribute('data-accent',a); save('aj-accent',a);
      document.querySelectorAll('.accent-dot').forEach(el=>el.classList.toggle('active', el.dataset.accentOpt===a)); }
    applyTheme(theme); applyAccent(accent);
    if(fab){
      fab.addEventListener('click', e=>{ e.stopPropagation(); panel.classList.toggle('open'); });
      document.addEventListener('click', e=>{ if(panel.classList.contains('open') && !panel.contains(e.target) && e.target!==fab) panel.classList.remove('open'); });
    }
    document.querySelectorAll('.theme-opt').forEach(el=>el.addEventListener('click', ()=>applyTheme(el.dataset.themeOpt)));
    document.querySelectorAll('.accent-dot').forEach(el=>el.addEventListener('click', ()=>applyAccent(el.dataset.accentOpt)));
  })();

  @if(!session('completed'))
  // logo upload preview
  const logoDrop = document.getElementById('logoDrop');
  const logoInput = document.getElementById('logoInput');
  const logoPreview = document.getElementById('logoPreview');
  if(logoDrop){
    logoDrop.addEventListener('click', ()=> logoInput.click());
    logoInput.addEventListener('change', ()=>{
      const file = logoInput.files[0];
      if(file){
        const reader = new FileReader();
        reader.onload = e=>{ logoPreview.src = e.target.result; logoPreview.style.display='block'; };
        reader.readAsDataURL(file);
      }
    });
  }
  @endif
</script>
</body>
</html>