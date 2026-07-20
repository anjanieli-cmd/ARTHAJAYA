<x-app-layout>
    <x-slot name="title">HPP {{ $entry->item_name }}</x-slot>

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
    .status-linked{ background:rgba(var(--info-rgb),0.12); color:var(--info); } .status-linked .sdot{ background:var(--info); }
    .status-manual{ background:var(--surface-strong); color:var(--text-mute); } .status-manual .sdot{ background:var(--text-faint); }
    .detail-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px 24px; }
    .detail-grid .item .k{ font-size:11.5px; color:var(--text-faint); margin-bottom:4px; }
    .detail-grid .item .v{ font-size:14.5px; font-weight:600; }
    .amount-hero{ font-family:'Space Grotesk', sans-serif; font-size:32px; font-weight:700; margin:6px 0 2px; }
    .amount-hero-sub{ font-size:12.5px; color:var(--text-faint); }
    .notes-box{ background:var(--surface-strong); border:1px solid var(--border); border-radius:12px; padding:16px; font-size:13.5px; color:var(--text-mute); margin-top:4px; }
    .mono{ font-family:'IBM Plex Mono', monospace; }

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
        <h1>{{ $entry->item_name }}</h1>
        <p>Dijual pada {{ $entry->sale_date->translatedFormat('d M Y') }}</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('cogs.index') }}" class="btn btn-outline">Kembali</a>
        <a href="{{ route('cogs.edit', $entry) }}" class="btn btn-primary">Edit Catatan</a>
        <button type="button" class="btn btn-danger-ghost" onclick="document.getElementById('deleteModal').classList.add('open')">Hapus</button>
    </div>
</div>

<div class="panel">
    <span class="status-badge {{ $entry->inventoryItem ? 'status-linked' : 'status-manual' }}">
        <span class="sdot"></span>{{ $entry->inventoryItem ? 'Terhubung ke Inventaris' : 'Input Manual' }}
    </span>

    <div class="amount-hero mono">Rp{{ number_format($entry->total_cogs, 0, ',', '.') }}</div>
    <div class="amount-hero-sub">Total harga pokok penjualan</div>

    <div class="detail-grid" style="margin-top:24px;">
        <div class="item"><div class="k">Nama barang</div><div class="v">{{ $entry->item_name }}</div></div>
        <div class="item"><div class="k">Barang di inventaris</div>
            <div class="v">
                @if($entry->inventoryItem)
                    <a href="{{ route('inventory.show', $entry->inventoryItem) }}" style="color:var(--emerald);">{{ $entry->inventoryItem->name }}</a>
                @else
                    &mdash;
                @endif
            </div>
        </div>
        <div class="item"><div class="k">Jumlah terjual</div><div class="v">{{ number_format($entry->quantity_sold, 0, ',', '.') }} unit</div></div>
        <div class="item"><div class="k">Harga pokok per unit</div><div class="v mono">Rp{{ number_format($entry->unit_cost, 0, ',', '.') }}</div></div>
        <div class="item"><div class="k">Tanggal jual</div><div class="v">{{ $entry->sale_date->translatedFormat('d M Y') }}</div></div>
        <div class="item"><div class="k">Dicatat pada</div><div class="v">{{ $entry->created_at->translatedFormat('d M Y, H:i') }}</div></div>
    </div>

    @if($entry->notes)
        <div class="panel-title" style="margin-top:24px;">Catatan</div>
        <div class="notes-box">{{ $entry->notes }}</div>
    @endif
</div>

{{-- ===== DELETE CONFIRM MODAL ===== --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-ic"><svg class="icon"><use href="#ic-alert"/></svg></div>
        <h3>Hapus catatan HPP ini?</h3>
        <p>Catatan untuk <b>{{ $entry->item_name }}</b> akan dihapus permanen.
            @if($entry->inventoryItem) Stok barang terkait akan dikembalikan otomatis. @endif
        </p>
        <form method="POST" action="{{ route('cogs.destroy', $entry) }}">
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