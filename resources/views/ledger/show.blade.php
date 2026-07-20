<x-app-layout>
    <x-slot name="title">Detail Transaksi Buku Besar</x-slot>

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

    .slip{ max-width:560px; background:var(--surface); border:1px solid var(--border); border-radius:20px; overflow:hidden; }
    .slip-header{ padding:22px 28px; border-bottom:1px dashed var(--border); display:flex; justify-content:space-between; align-items:center; }
    .slip-header .acc-code{ font-family:'IBM Plex Mono', monospace; font-size:12px; color:var(--text-faint); }
    .slip-header .acc-name{ font-family:'Space Grotesk', sans-serif; font-size:16px; font-weight:700; }
    .slip-date{ font-size:12.5px; color:var(--text-mute); text-align:right; }

    .slip-body{ padding:26px 28px; }
    .slip-desc{ font-size:14.5px; font-weight:600; margin-bottom:20px; }

    .slip-amounts{ display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px; }
    .slip-amount-box{ border-radius:14px; padding:16px 18px; text-align:center; }
    .slip-amount-box.debit{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); }
    .slip-amount-box.credit{ background:rgba(var(--danger-rgb),0.1); border:1px solid rgba(var(--danger-rgb),0.3); }
    .slip-amount-box .lbl{ font-size:11.5px; color:var(--text-mute); margin-bottom:4px; }
    .slip-amount-box .val{ font-family:'IBM Plex Mono', monospace; font-size:18px; font-weight:700; }
    .slip-amount-box.debit .val{ color:var(--emerald); }
    .slip-amount-box.credit .val{ color:var(--danger); }

    .slip-row{ display:flex; justify-content:space-between; padding:11px 0; border-top:1px solid var(--border); font-size:13px; }
    .slip-row .k{ color:var(--text-faint); }
    .slip-row .v{ font-weight:600; }
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

    @media (max-width:560px){ .slip-amounts{ grid-template-columns:1fr; } }
</style>

<div class="page-head">
    <div>
        <h1>Transaksi #{{ $item->id }}</h1>
        <p>Detail transaksi buku besar akun {{ $item->account_name }}</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('ledger.index', ['account' => $item->account_code]) }}" class="btn btn-outline">Kembali</a>
        <a href="{{ route('ledger.edit', $item) }}" class="btn btn-primary">Edit</a>
        <button type="button" class="btn btn-danger-ghost" onclick="document.getElementById('deleteModal').classList.add('open')">Hapus</button>
    </div>
</div>

<div class="slip">
    <div class="slip-header">
        <div>
            <div class="acc-name">{{ $item->account_name }}</div>
            <div class="acc-code">{{ $item->account_code }}</div>
        </div>
        <div class="slip-date">{{ $item->transaction_date->translatedFormat('d M Y') }}</div>
    </div>
    <div class="slip-body">
        <div class="slip-desc">{{ $item->description }}</div>

        <div class="slip-amounts">
            <div class="slip-amount-box debit">
                <div class="lbl">Debit</div>
                <div class="val">{{ $item->debit > 0 ? 'Rp'.number_format($item->debit, 0, ',', '.') : '—' }}</div>
            </div>
            <div class="slip-amount-box credit">
                <div class="lbl">Kredit</div>
                <div class="val">{{ $item->credit > 0 ? 'Rp'.number_format($item->credit, 0, ',', '.') : '—' }}</div>
            </div>
        </div>

        <div class="slip-row">
            <span class="k">Kode Akun</span>
            <span class="v">{{ $item->account_code }}</span>
        </div>
        <div class="slip-row">
            <span class="k">Tanggal Transaksi</span>
            <span class="v">{{ $item->transaction_date->translatedFormat('d F Y') }}</span>
        </div>
        <div class="slip-row">
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
        <p>Transaksi ini akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <form method="POST" action="{{ route('ledger.destroy', $item) }}">
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