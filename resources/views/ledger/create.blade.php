<x-app-layout>
    <x-slot name="title">Tambah Transaksi Buku Besar</x-slot>

<style>
    .page-head{ margin-bottom:24px; }
    .page-head h1{ font-size:24px; margin-bottom:6px; }
    .page-head p{ font-size:14px; color:var(--text-mute); }
    .panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:36px 40px; position:relative; overflow:hidden; }
    .panel::before{ content:''; position:absolute; top:0; left:0; width:4px; height:100%; background:var(--emerald); }
    .panel-icon-row{ display:flex; align-items:center; gap:10px; margin-bottom:24px; }
    .panel-icon{ width:38px; height:38px; border-radius:10px; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .panel-icon .icon{ width:18px; height:18px; }
    .panel-icon-row span{ font-size:13px; color:var(--text-mute); }
    .field-grid{ display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; }
    .field-grid .full{ grid-column:1/-1; }
    .field{ display:flex; flex-direction:column; gap:7px; }
    .field label{ font-size:12.5px; color:var(--text-mute); font-weight:500; }
    .field label .req{ color:var(--danger); }
    .field label .opt{ color:var(--text-faint); font-weight:400; }
    .field input, .field select, .field textarea{
        width:100%; padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
        color:var(--text); font-family:'Inter'; font-size:14px; outline:none; transition:all .2s ease;
    }
    .field input:focus, .field select:focus, .field textarea:focus{ border-color:var(--border-hover); background:var(--surface); }
    .field textarea{ resize:vertical; min-height:110px; }
    .field-error{ font-size:12px; color:var(--danger); margin-top:2px; }
    .panel-actions{ margin-top:32px; padding-top:26px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:10px; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 26px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
    .btn-primary{ background:var(--emerald); color:#052117; }
    .btn-primary:hover{ transform:translateY(-1px); }
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); }
    @media (max-width:1200px){ .field-grid{ grid-template-columns:1fr 1fr; } }
    @media (max-width:700px){ .field-grid{ grid-template-columns:1fr; } .panel{ padding:24px 20px; } }
</style>

<div class="page-head">
    <h1>Tambah Transaksi Buku Besar</h1>
    <p>Catat transaksi debit/kredit untuk akun tertentu.</p>
</div>

<form method="POST" action="{{ route('ledger.store') }}">
    @csrf
    <div class="panel">
        <div class="panel-icon-row">
            <div class="panel-icon"><svg class="icon"><use href="#ic-invoice"/></svg></div>
            <span>Isi salah satu kolom Debit atau Kredit sesuai jenis transaksi.</span>
        </div>
        @include('ledger._form')
        <div class="panel-actions">
            <a href="{{ route('ledger.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </div>
    </div>
</form>
</x-app-layout>