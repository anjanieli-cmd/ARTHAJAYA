<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Faktur — Arthajaya</title>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
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
    --bg:#070B13; --surface:rgba(255,255,255,0.04); --surface-strong:rgba(255,255,255,0.08);
    --border:rgba(255,255,255,0.09); --border-hover:rgba(var(--emerald-rgb),0.35);
    --emerald:#34E0A1; --emerald-dim:#1E8F6B; --text:#EAF0F6; --text-mute:#8A96AE; --text-faint:#545E73;
    --radius:20px; --emerald-rgb:52,224,161; --danger:#E8637A;
  }
  [data-theme="light"]{
    --bg:#F4F6FA; --surface:rgba(15,25,40,0.035); --surface-strong:rgba(15,25,40,0.07);
    --border:rgba(15,25,40,0.10); --border-hover:rgba(var(--emerald-rgb),0.45); --emerald-dim:#17A374;
    --text:#131A26; --text-mute:#565F72; --text-faint:#838C9E;
  }
  [data-accent="blue"]{ --emerald:#4E8FF0; --emerald-dim:#3465C4; --emerald-rgb:78,143,240; }
  [data-accent="purple"]{ --emerald:#9B7BE0; --emerald-dim:#6E4FBE; --emerald-rgb:155,123,224; }
  [data-accent="orange"]{ --emerald:#F0A25A; --emerald-dim:#C97A2E; --emerald-rgb:240,162,90; }
  [data-accent="pink"]{ --emerald:#E85A9C; --emerald-dim:#B83A78; --emerald-rgb:232,90,156; }
  *{ margin:0; padding:0; box-sizing:border-box; }
  html{ color-scheme:dark; } html[data-theme="light"]{ color-scheme:light; }
  body{ background:var(--bg); color:var(--text); font-family:'Inter',sans-serif; line-height:1.5; min-height:100vh; }
  h1,h2{ font-family:'Space Grotesk',sans-serif; letter-spacing:-0.02em; }
  a{ text-decoration:none; color:inherit; } svg{ display:block; } .icon{ width:1em; height:1em; }
  .app-shell{ display:flex; min-height:100vh; }
  .main{ flex:1; min-width:0; }
  .topbar{ display:flex; align-items:center; justify-content:space-between; padding:18px 32px; border-bottom:1px solid var(--border); }
  .topbar-title{ font-size:15px; font-weight:600; color:var(--text-mute); }
  .topbar-title b{ color:var(--text); }
  .content{ padding:30px 32px 60px; max-width:820px; }
  .page-head{ margin-bottom:24px; }
  .page-head h1{ font-size:24px; margin-bottom:6px; }
  .page-head p{ font-size:14px; color:var(--text-mute); }
  .panel{ background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:32px; }
  .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px; }
  .field-grid .full{ grid-column:1/-1; }
  .field{ display:flex; flex-direction:column; gap:7px; }
  .field label{ font-size:12.5px; color:var(--text-mute); font-weight:500; }
  .field label .opt{ color:var(--text-faint); font-weight:400; }
  .field input, .field select, .field textarea{
    width:100%; padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
    color:var(--text); font-family:'Inter'; font-size:14px; outline:none; transition:all .2s ease;
  }
  .field select{
    background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
    background-repeat:no-repeat; background-position:right 14px center; background-size:14px; padding-right:38px; appearance:none;
  }
  .field input:focus, .field select:focus, .field textarea:focus{ border-color:var(--border-hover); background:var(--surface); }
  .field textarea{ resize:vertical; min-height:80px; }
  .field-hint{ font-size:11.5px; color:var(--text-faint); }
  .field-error{ font-size:12px; color:var(--danger); margin-top:2px; }
  .panel-actions{ margin-top:28px; padding-top:24px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:10px; }
  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
  .btn-primary{ background:var(--emerald); color:#052117; }
  .btn-primary:hover{ transform:translateY(-1px); }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); }
  @media (max-width:900px){ .sidebar{ display:none; } .content{ padding:22px 18px 50px; } .field-grid{ grid-template-columns:1fr; } }
</style>
</head>
<body>
<div class="app-shell">
  @include('layouts.navigation')
  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Penjualan / Semua Faktur / <b>Edit Faktur</b></div>
    </div>
    <div class="content">
      <div class="page-head">
        <h1>Edit Faktur</h1>
        <p>Perbarui detail faktur {{ $invoice->invoice_number }}.</p>
      </div>
      <form method="POST" action="{{ route('invoices.update', $invoice) }}">
        @csrf
        @method('PUT')
        <div class="panel">
          @include('invoices._form')
          <div class="panel-actions">
            <a href="{{ route('invoices.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>