<x-app-layout>
  <x-slot name="title">Integrasi</x-slot>

  <style>
    .ig-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
    .ig-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:20px;display:flex;flex-direction:column;gap:12px;transition:border-color .15s ease;}
    .ig-card:hover{border-color:var(--border-hover);}
    .ig-top{display:flex;justify-content:space-between;align-items:flex-start;}
    .ig-icon{width:44px;height:44px;border-radius:12px;background:var(--surface-strong);display:flex;align-items:center;justify-content:center;font-weight:700;}
    .ig-badge{font-size:11px;padding:4px 10px;border-radius:100px;font-weight:600;}
    .badge-connected{background:rgba(var(--emerald-rgb),0.12);color:var(--emerald);}
    .badge-disconnected{background:var(--surface-strong);color:var(--text-mute);}
    .badge-error{background:rgba(232,90,122,0.12);color:var(--danger);}
    .ig-name{font-size:15px;font-weight:700;}
    .ig-type{font-size:11.5px;color:var(--text-faint);text-transform:uppercase;letter-spacing:.04em;}
    .ig-desc{font-size:12.5px;color:var(--text-mute);line-height:1.5;flex:1;}
    .ig-foot{display:flex;gap:8px;}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:9px 14px;border-radius:11px;font-size:12.5px;font-weight:600;cursor:pointer;border:none;flex:1;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
  </style>

  <div class="page-head">
    <div><h1>Integrasi</h1><p>Hubungkan layanan pihak ketiga untuk memperluas fungsi sistem.</p></div>
  </div>

  <div class="ig-grid">
    @foreach($providers as $key => $p)
      @php $item = $connected->get($key); @endphp
      <div class="ig-card">
        <div class="ig-top">
          <div class="ig-icon">{{ strtoupper(substr($p['label'],0,2)) }}</div>
          @if($item)
            <span class="ig-badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
          @else
            <span class="ig-badge badge-disconnected">Belum Terhubung</span>
          @endif
        </div>
        <div>
          <div class="ig-name">{{ $p['label'] }}</div>
          <div class="ig-type">{{ $p['type'] }}</div>
        </div>
        <div class="ig-desc">{{ $p['desc'] }}</div>
        <div class="ig-foot">
          @if($item)
            <a href="{{ route('integrations.edit', $item) }}" class="btn btn-outline">Kelola</a>
          @else
            <a href="{{ route('integrations.create', ['provider' => $key]) }}" class="btn btn-primary">Hubungkan</a>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</x-app-layout>