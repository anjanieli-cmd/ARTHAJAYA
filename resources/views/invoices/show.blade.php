<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Faktur {{ $invoice->invoice_number }} — Arthajaya</title>
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
    --radius:20px; --emerald-rgb:52,224,161; --danger:#E8637A; --danger-rgb:232,90,122; --info:#4E8FF0; --info-rgb:78,143,240;
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
  .mono{ font-family:'IBM Plex Mono',monospace; }
  a{ text-decoration:none; color:inherit; } svg{ display:block; } .icon{ width:1em; height:1em; }
  .app-shell{ display:flex; min-height:100vh; }
  .main{ flex:1; min-width:0; }
  .topbar{ display:flex; align-items:center; justify-content:space-between; padding:18px 32px; border-bottom:1px solid var(--border); }
  .topbar-title{ font-size:15px; font-weight:600; color:var(--text-mute); }
  .topbar-title b{ color:var(--text); }
  .content{ padding:30px 32px 60px; max-width:820px; }
  .page-head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:14px; }
  .page-head h1{ font-size:24px; margin-bottom:6px; }
  .page-head p{ font-size:13.5px; color:var(--text-mute); }
  .head-actions{ display:flex; gap:10px; }
  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
  .btn .icon{ width:15px; height:15px; }
  .btn-primary{ background:var(--emerald); color:#052117; }
  .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .btn-outline:hover{ background:var(--surface-strong); }
  .panel{ background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:32px; margin-bottom:20px; }
  .panel-title{ font-size:11.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:18px; }
  .status-badge{ display:inline-flex; align-items:center; gap:6px; padding:6px 13px; border-radius:100px; font-size:12.5px; font-weight:600; }
  .status-badge .sdot{ width:6px; height:6px; border-radius:50%; }
  .status-draft{ background:var(--surface-strong); color:var(--text-mute); } .status-draft .sdot{ background:var(--text-faint); }
  .status-sent{ background:rgba(var(--info-rgb),0.12); color:var(--info); } .status-sent .sdot{ background:var(--info); }
  .status-paid{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); } .status-paid .sdot{ background:var(--emerald); }
  .status-overdue{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); } .status-overdue .sdot{ background:var(--danger); }
  .status-cancelled{ background:var(--surface-strong); color:var(--text-faint); text-decoration:line-through; } .status-cancelled .sdot{ background:var(--text-faint); }
  .detail-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px 24px; }
  .detail-grid .item .k{ font-size:11.5px; color:var(--text-faint); margin-bottom:4px; }
  .detail-grid .item .v{ font-size:14.5px; font-weight:600; }
  .amount-hero{ font-family:'Space Grotesk'; font-size:32px; font-weight:700; margin:6px 0 2px; }
  .notes-box{ background:var(--surface-strong); border:1px solid var(--border); border-radius:12px; padding:16px; font-size:13.5px; color:var(--text-mute); margin-top:4px; }
  @media (max-width:900px){ .sidebar{ display:none; } .content{ padding:22px 18px 50px; } .detail-grid{ grid-template-columns:1fr; } }
</style>
</head>
<body>
<div class="app-shell">
  @include('layouts.navigation')
  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Penjualan / Semua Faktur / <b>{{ $invoice->invoice_number }}</b></div>
    </div>
    <div class="content">

      @php
        $statusMap = [
          'draft'     => ['label' => 'Draft', 'class' => 'status-draft'],
          'sent'      => ['label' => 'Terkirim', 'class' => 'status-sent'],
          'paid'      => ['label' => 'Lunas', 'class' => 'status-paid'],
          'cancelled' => ['label' => 'Dibatalkan', 'class' => 'status-cancelled'],
        ];
        $isOverdue = $invoice->status === 'sent' && $invoice->due_date && $invoice->due_date->isPast();
        $st = $isOverdue ? ['label' => 'Jatuh Tempo', 'class' => 'status-overdue'] : ($statusMap[$invoice->status] ?? $statusMap['draft']);
      @endphp

      <div class="page-head">
        <div>
          <h1>Faktur {{ $invoice->invoice_number }}</h1>
          <p>Dibuat untuk {{ $invoice->client->name ?? 'klien terhapus' }}</p>
        </div>
        <div class="head-actions">
          <a href="{{ route('invoices.index') }}" class="btn btn-outline">Kembali</a>
          <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">Edit Faktur</a>
        </div>
      </div>

      <div class="panel">
        <span class="status-badge {{ $st['class'] }}"><span class="sdot"></span>{{ $st['label'] }}</span>
        <div class="amount-hero mono">Rp{{ number_format($invoice->total, 0, ',', '.') }}</div>

        <div class="detail-grid" style="margin-top:24px;">
          <div class="item"><div class="k">Klien</div><div class="v">{{ $invoice->client->name ?? '—' }}</div></div>
          <div class="item"><div class="k">Perusahaan klien</div><div class="v">{{ $invoice->client->company_name ?? '—' }}</div></div>
          <div class="item"><div class="k">Tanggal terbit</div><div class="v">{{ $invoice->issue_date->translatedFormat('d M Y') }}</div></div>
          <div class="item"><div class="k">Jatuh tempo</div><div class="v">{{ $invoice->due_date->translatedFormat('d M Y') }}</div></div>
          <div class="item"><div class="k">Subtotal</div><div class="v mono">Rp{{ number_format($invoice->subtotal, 0, ',', '.') }}</div></div>
          <div class="item"><div class="k">Pajak</div><div class="v mono">Rp{{ number_format($invoice->tax_amount, 0, ',', '.') }}</div></div>
        </div>

        @if($invoice->notes)
          <div class="panel-title" style="margin-top:24px;">Catatan</div>
          <div class="notes-box">{{ $invoice->notes }}</div>
        @endif
      </div>

    </div>
  </div>
</div>
</body>
</html>