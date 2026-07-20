<x-app-layout>
    <x-slot name="title">Detail Transaksi Arus Kas</x-slot>

<style>
    .page-head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:14px; }
    .page-head h1{ font-size:24px; margin-bottom:6px; }
    .page-head p{ font-size:13.5px; color:var(--text-mute); }
    .head-actions{ display:flex; gap:10px; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
    .btn-primary{ background:var(--emerald); color:#052117; }
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); }
    .btn-danger-ghost{ background:none; border:1px solid rgba(var(--danger-rgb),0.3); color:var(--danger); }
    .btn-danger-ghost:hover{ background:rgba(var(--danger-rgb),0.1); }

    .cf-detail{ max-width:640px; }
    .cf-hero{ display:flex; align-items:center; gap:16px; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px 30px; margin-bottom:16px; }
    .cf-hero-icon{ width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .cf-hero-icon .icon{ width:22px; height:22px; }
    .cf-hero.masuk .cf-hero-icon{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
    .cf-hero.keluar .cf-hero-icon{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
    .cf-hero-amount{ font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; }
    .cf-hero.masuk .cf-hero-amount{ color:var(--emerald); }
    .cf-hero.keluar .cf-hero-amount{ color:var(--danger); }
    .cf-hero-sub{ font-size:12.5px; color:var(--text-faint); margin-top:2px; }

    .detail-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:28px; }
    .detail-row{ display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid var(--border); gap:16px; }
    .detail-row:last-child{ border-bottom:none; }
    .detail-row .k{ font-size:12.5px; color:var(--text-faint); }
    .detail-row .v{ font-size:13.5px; font-weight:600; text-align:right; }
    .activity-tag{ display:inline-flex; padding:3px 10px; border-radius:100px; font-size:11px; font-weight:600; }
    .activity-tag.operasional{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
    .activity-tag.investasi{ background:rgba(var(--info-rgb),0.12); color:var(--info); }
    .activity-tag.pendanaan{ background:rgba(var(--warning-rgb),0.12); color:var(--warning); }
    .notes-box{ background:var(--surface-strong); border:1px solid var(--border); border-radius:12px; padding:16px; font-size:13.5px; color:var(--text-mute); margin-top:16px; }

    .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; padding:20px; }
    .modal-overlay.open{ display:flex; }
    .modal-box{ background:var(--modal-bg, var(--surface)); border:1px solid var(--border); border-radius:20px; padding:28px; max-width:400px; width:100%; box-shadow:0 40px 90px rgba(0,0,0,0.5); }
    .modal-ic{ width:52px; height:52px; border-radius:14px; background:rgba(var(--danger-rgb),0.12); color:var(--danger); display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
    .modal-ic .icon{ width:24px; height:24px; }
    .modal-box h3{ font-size:17px; margin-bottom:8px; }
    .modal-box p{ font-size:13.5px; color:var(--text-mute); margin-bottom:22px; }
    .modal-box p b{ color:var(--text); }
    .modal-actions{ display:flex; gap:10px; justify-content:flex-end; }
</style>

<div class="page-head">
    <div>
        <h1>{{ $item->name }}</h1>
        <p>Detail transaksi arus kas — {{ $item->period_label }}</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('cash-flow.index', ['month' => $item->period_month, 'year' => $item->period_year]) }}" class="btn btn-outline">Kembali</a>
        <a href="{{ route('cash-flow.edit', $item) }}" class="btn btn-primary">Edit</a>
        <button type="button" class="btn btn-danger-ghost" onclick="document.getElementById('deleteModal').classList.add('open')">Hapus</button>
    </div>
</div>

<div class="cf-detail">
    <div class="cf-hero {{ $item->direction }}">
        <div class="cf-hero-icon">
            <svg class="icon"><use href="#{{ $item->direction === 'masuk' ? 'ic-trending' : 'ic-trending-down' }}"/></svg>
        </div>
        <div>
            <div class="cf-hero-amount">{{ $item->direction === 'masuk' ? '+' : '-' }}Rp{{ number_format($item->amount, 0, ',', '.') }}</div>
            <div class="cf-hero-sub">{{ $item->direction === 'masuk' ? 'Kas Masuk' : 'Kas Keluar' }}</div>
        </div>
    </div>

    <div class="detail-panel">
        <div class="detail-row">
            <span class="k">Nama Transaksi</span>
            <span class="v">{{ $item->name }}</span>
        </div>
        <div class="detail-row">
            <span class="k">Kategori</span>
            <span class="v">{{ $item->category }}</span>
        </div>
        <div class="detail-row">
            <span class="k">Aktivitas</span>
            <span class="v"><span class="activity-tag {{ $item->activity_type }}">{{ ucfirst($item->activity_type) }}</span></span>
        </div>
        <div class="detail-row">
            <span class="k">Periode</span>
            <span class="v">{{ $item->period_label }}</span>
        </div>
        <div class="detail-row">
            <span class="k">Dibuat pada</span>
            <span class="v">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
        </div>
        @if($item->notes)
            <div class="notes-box">{{ $item->notes }}</div>
        @endif
    </div>
</div>

<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-ic"><svg class="icon"><use href="#ic-alert"/></svg></div>
        <h3>Hapus transaksi ini?</h3>
        <p>Transaksi <b>{{ $item->name }}</b> akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <form method="POST" action="{{ route('cash-flow.destroy', $item) }}">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn" style="background:var(--danger); color:#fff;">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('deleteModal').addEventListener('click', function(e){
        if(e.target === this) this.classList.remove('open');
    });
</script>
</x-app-layout>