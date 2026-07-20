<x-app-layout>
    <x-slot name="title">Barang {{ $item->name }}</x-slot>

<style>
    .page-head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:14px; }
    .page-head h1{ font-size:24px; margin-bottom:6px; }
    .page-head p{ font-size:13.5px; color:var(--text-mute); }
    .head-actions{ display:flex; gap:10px; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
    .btn .icon{ width:15px; height:15px; }
    .btn-primary{ background:var(--emerald); color:#052117; }
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); }
    .btn-danger-ghost{ background:none; border:1px solid rgba(var(--danger-rgb),0.3); color:var(--danger); }
    .btn-danger-ghost:hover{ background:rgba(var(--danger-rgb),0.1); }
    .panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:32px; margin-bottom:20px; max-width:820px; }
    .panel-title{ font-size:11.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:18px; }
    .status-badge{ display:inline-flex; align-items:center; gap:6px; padding:6px 13px; border-radius:100px; font-size:12.5px; font-weight:600; }
    .status-badge .sdot{ width:6px; height:6px; border-radius:50%; }
    .status-ok{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); } .status-ok .sdot{ background:var(--emerald); }
    .status-low{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); } .status-low .sdot{ background:var(--danger); }
    .detail-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px 24px; }
    .detail-grid .item .k{ font-size:11.5px; color:var(--text-faint); margin-bottom:4px; }
    .detail-grid .item .v{ font-size:14.5px; font-weight:600; }
    .amount-hero{ font-family:'Space Grotesk', sans-serif; font-size:32px; font-weight:700; margin:6px 0 2px; }
    .amount-hero-sub{ font-size:12.5px; color:var(--text-faint); }
    .notes-box{ background:var(--surface-strong); border:1px solid var(--border); border-radius:12px; padding:16px; font-size:13.5px; color:var(--text-mute); margin-top:4px; }
    .mono{ font-family:'IBM Plex Mono', monospace; }

    .stock-bar-track{ width:100%; height:8px; border-radius:100px; background:var(--surface-strong); overflow:hidden; margin-top:8px; }
    .stock-bar-fill{ height:100%; border-radius:100px; background:var(--emerald); }
    .stock-bar-fill.low{ background:var(--danger); }

    .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; padding:20px; }
    .modal-overlay.open{ display:flex; }
    .modal-box{ background:var(--modal-bg, var(--surface)); border:1px solid var(--border); border-radius:20px; padding:28px; max-width:400px; width:100%; box-shadow:0 40px 90px rgba(0,0,0,0.5); }
    .modal-ic{ width:52px; height:52px; border-radius:14px; background:rgba(var(--danger-rgb),0.12); color:var(--danger); display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
    .modal-ic .icon{ width:24px; height:24px; }
    .modal-box h3{ font-size:17px; margin-bottom:8px; }
    .modal-box p{ font-size:13.5px; color:var(--text-mute); margin-bottom:22px; }
    .modal-box p b{ color:var(--text); }
    .modal-actions{ display:flex; gap:10px; justify-content:flex-end; }

    @media (max-width:900px){ .detail-grid{ grid-template-columns:1fr; } }
</style>

<div class="page-head">
    <div>
        <h1>{{ $item->name }}</h1>
        <p>SKU: <span class="mono">{{ $item->sku }}</span> @if($item->category)&middot; {{ $item->category }}@endif</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('inventory.index') }}" class="btn btn-outline">Kembali</a>
        <a href="{{ route('inventory.edit', $item) }}" class="btn btn-primary">Edit Barang</a>
        <button type="button" class="btn btn-danger-ghost" onclick="document.getElementById('deleteModal').classList.add('open')">Hapus</button>
    </div>
</div>

<div class="panel">
    <span class="status-badge {{ $item->is_low_stock ? 'status-low' : 'status-ok' }}">
        <span class="sdot"></span>{{ $item->is_low_stock ? 'Stok Menipis' : 'Stok Aman' }}
    </span>

    <div class="amount-hero mono">Rp{{ number_format($item->stock_value, 0, ',', '.') }}</div>
    <div class="amount-hero-sub">Total nilai stok saat ini</div>

    <div class="stock-bar-track">
        <div class="stock-bar-fill {{ $item->is_low_stock ? 'low' : '' }}" style="width:{{ $item->stock_percent }}%"></div>
    </div>

    <div class="detail-grid" style="margin-top:24px;">
        <div class="item"><div class="k">Stok saat ini</div><div class="v">{{ number_format($item->stock_quantity, 0, ',', '.') }} {{ $item->unit }}</div></div>
        <div class="item"><div class="k">Batas reorder</div><div class="v">{{ number_format($item->reorder_level, 0, ',', '.') }} {{ $item->unit }}</div></div>
        <div class="item"><div class="k">Harga pokok</div><div class="v mono">Rp{{ number_format($item->cost_price, 0, ',', '.') }}</div></div>
        <div class="item"><div class="k">Harga jual</div><div class="v mono">Rp{{ number_format($item->selling_price, 0, ',', '.') }}</div></div>
        <div class="item"><div class="k">Margin</div><div class="v">{{ $item->margin_percent }}%</div></div>
        <div class="item"><div class="k">Satuan</div><div class="v">{{ $item->unit }}</div></div>
    </div>

    @if($item->description)
        <div class="panel-title" style="margin-top:24px;">Deskripsi</div>
        <div class="notes-box">{{ $item->description }}</div>
    @endif
</div>

{{-- ===== DELETE CONFIRM MODAL ===== --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-ic"><svg class="icon"><use href="#ic-alert"/></svg></div>
        <h3>Hapus barang ini?</h3>
        <p>Barang <b>{{ $item->name }}</b> akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <form method="POST" action="{{ route('inventory.destroy', $item) }}">
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