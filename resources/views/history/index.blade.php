<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Aktivitas — Arvessa</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
  :root{
    --bg: #070B13;
    --surface: rgba(255,255,255,0.04);
    --surface-strong: rgba(255,255,255,0.08);
    --border: rgba(255,255,255,0.09);
    --border-hover: rgba(52,224,161,0.35);
    --emerald: #34E0A1;
    --emerald-dim: #1E8F6B;
    --text: #EAF0F6;
    --text-mute: #8A96AE;
    --text-faint: #545E73;
    --radius: 20px;
    --danger: #E8637A;
    --gold: #F0C05A;
    --blue: #4E8FF0;
  }
  *{ margin:0; padding:0; box-sizing:border-box; }
  body{
    background: var(--bg); color: var(--text); font-family:'Inter', sans-serif;
    line-height:1.5; min-height:100vh;
  }
  h1,h2,h3{ font-family:'Space Grotesk', sans-serif; letter-spacing:-0.02em; }
  a{ text-decoration:none; color:inherit; }
  .icon{ width:1em; height:1em; }

  .bg-glow{ position:fixed; top:-25%; right:-10%; width:900px; height:900px; background:radial-gradient(circle, rgba(52,224,161,0.11) 0%, transparent 70%); pointer-events:none; z-index:0; }

  .wrap{ position:relative; z-index:1; max-width:840px; margin:0 auto; padding:40px 24px 80px; }

  .page-head{ margin-bottom:28px; }
  .page-head .tag{ font-size:12.5px; color:var(--emerald); font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-bottom:8px; }
  .page-head h1{ font-size:28px; margin-bottom:6px; }
  .page-head p{ font-size:14px; color:var(--text-mute); }

  .filter-bar{
    display:flex; gap:10px; flex-wrap:wrap; align-items:center;
    background:var(--surface); border:1px solid var(--border); border-radius:16px;
    padding:14px 16px; margin-bottom:24px;
  }
  .filter-bar select, .filter-bar input[type=date]{
    background:var(--surface-strong); border:1px solid var(--border); border-radius:10px;
    color:var(--text); font-family:'Inter'; font-size:13px; padding:8px 12px; outline:none;
  }
  .filter-bar select:focus, .filter-bar input:focus{ border-color:var(--border-hover); }
  .filter-bar button{
    background:var(--emerald); color:#052117; border:none; border-radius:10px;
    padding:8px 16px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter';
  }
  .filter-bar .clear-link{ font-size:12.5px; color:var(--text-faint); }
  .filter-bar .clear-link:hover{ color:var(--text); }

  .timeline{ position:relative; }
  .timeline::before{
    content:''; position:absolute; left:19px; top:8px; bottom:8px; width:1.5px;
    background:var(--border);
  }

  .entry{ display:flex; gap:16px; padding:16px 0; position:relative; }
  .entry-dot{
    width:40px; height:40px; border-radius:50%; background:var(--surface-strong);
    border:1.5px solid var(--border); display:flex; align-items:center; justify-content:center;
    flex-shrink:0; position:relative; z-index:1; color:var(--emerald);
  }
  .entry-dot .icon{ width:17px; height:17px; }
  .entry-body{
    flex:1; background:var(--surface); border:1px solid var(--border); border-radius:14px;
    padding:14px 16px; transition:border-color .2s ease;
  }
  .entry-body:hover{ border-color:var(--border-hover); }
  .entry-desc{ font-size:14px; color:var(--text); margin-bottom:4px; }
  .entry-meta{ font-size:12px; color:var(--text-faint); display:flex; gap:10px; flex-wrap:wrap; }
  .entry-badge{
    display:inline-flex; align-items:center; font-size:10.5px; font-weight:600;
    padding:2px 8px; border-radius:100px; background:rgba(52,224,161,0.12); color:var(--emerald);
    text-transform:uppercase; letter-spacing:.03em;
  }

  .empty-state{
    text-align:center; padding:60px 20px; color:var(--text-faint);
  }
  .empty-state .icon{ width:36px; height:36px; margin-bottom:12px; opacity:.5; }
  .empty-state p{ font-size:14px; }

  .pagination-wrap{ margin-top:28px; display:flex; justify-content:center; }
  .pagination-wrap nav > div { display:flex; gap:6px; align-items:center; justify-content:center; flex-wrap:wrap; }
  .pagination-wrap a, .pagination-wrap span{
    font-size:13px; padding:7px 12px; border-radius:8px; color:var(--text-mute);
    border:1px solid var(--border); background:var(--surface);
  }
  .pagination-wrap a:hover{ border-color:var(--border-hover); color:var(--text); }

  @media (max-width:600px){
    .wrap{ padding:24px 16px 60px; }
    .filter-bar{ flex-direction:column; align-items:stretch; }
  }
</style>
</head>
<body>

<div class="bg-glow"></div>

<div class="wrap">
  <div class="page-head">
    <div class="tag">Riwayat Aktivitas</div>
    <h1>Aktivitas kamu</h1>
    <p>Semua yang sudah kamu lakukan di akun ini, dari awal daftar sampai sekarang.</p>
  </div>

  <form method="GET" class="filter-bar">
    <select name="action" onchange="this.form.submit()">
      <option value="">Semua jenis aktivitas</option>
      @foreach($actionTypes as $type)
        <option value="{{ $type }}" @selected(request('action')===$type)>{{ ucwords(str_replace('_',' ',$type)) }}</option>
      @endforeach
    </select>
    <input type="date" name="from" value="{{ request('from') }}" placeholder="Dari tanggal">
    <input type="date" name="to" value="{{ request('to') }}" placeholder="Sampai tanggal">
    <button type="submit">Terapkan</button>
    @if(request('action') || request('from') || request('to'))
      <a href="{{ request()->url() }}" class="clear-link">Reset filter</a>
    @endif
  </form>

  @if($activities->isEmpty())
    <div class="empty-state">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 16 14"/></svg>
      <p>Belum ada aktivitas yang tercatat.</p>
    </div>
  @else
    <div class="timeline">
      @foreach($activities as $item)
        <div class="entry">
          <div class="entry-dot">
            @php
              $icon = match(true) {
                str_contains($item->action, 'balance') => 'M21 12V7H5a2 2 0 0 1 0-4h14v4 M3 5v14a2 2 0 0 0 2 2h16v-5 M18 12a2 2 0 0 0 0 4h4v-4Z',
                str_contains($item->action, 'company') => 'M4 3h16v18l-3-2-3 2-3-2-3 2V3z',
                str_contains($item->action, 'invoice') => 'M6 2h12v20l-3-2-3 2-3-2-3 2V2z M9 7h6M9 11h6M9 15h3',
                default => 'M12 8v4l3 3 M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z',
              };
            @endphp
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="{{ $icon }}"/>
            </svg>
          </div>
          <div class="entry-body">
            <div class="entry-desc">{{ $item->description }}</div>
            <div class="entry-meta">
              <span class="entry-badge">{{ ucwords(str_replace('_',' ',$item->action)) }}</span>
              <span>{{ $item->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
              <span>{{ $item->created_at->diffForHumans() }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="pagination-wrap">
      {{ $activities->links() }}
    </div>
  @endif
</div>

</body>
</html>