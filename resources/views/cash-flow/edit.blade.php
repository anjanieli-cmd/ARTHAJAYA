<x-app-layout>
    <x-slot name="title">Edit Transaksi Arus Kas</x-slot>

<style>
    .page-head{ margin-bottom:24px; }
    .page-head h1{ font-size:24px; margin-bottom:6px; }
    .page-head p{ font-size:14px; color:var(--text-mute); }
    .panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:32px; max-width:760px; position:relative; overflow:hidden; }
    .panel::before{ content:''; position:absolute; top:0; left:0; width:4px; height:100%; background:var(--warning); }
    .panel-icon-row{ display:flex; align-items:center; gap:10px; margin-bottom:22px; }
    .panel-icon{ width:38px; height:38px; border-radius:10px; background:rgba(var(--warning-rgb),0.12); color:var(--warning); display:flex; align-items:center; justify-content:center; }
    .panel-icon .icon{ width:18px; height:18px; }
    .panel-icon-row span{ font-size:13px; color:var(--text-mute); }
    .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .field-grid .full{ grid-column:1/-1; }
    .field{ display:flex; flex-direction:column; gap:7px; }
    .field label{ font-size:12.5px; color:var(--text-mute); font-weight:500; }
    .field label .req{ color:var(--danger); }
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
    .field-error{ font-size:12px; color:var(--danger); margin-top:2px; }
    .panel-actions{ margin-top:28px; padding-top:24px; border-top:1px solid var(--border); display:flex; justify-content:space-between; gap:10px; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
    .btn-primary{ background:var(--emerald); color:#052117; }
    .btn-primary:hover{ transform:translateY(-1px); }
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); }
    .btn-danger-ghost{ background:none; color:var(--danger); border:1px solid rgba(var(--danger-rgb),0.3); }
    @media (max-width:900px){ .field-grid{ grid-template-columns:1fr; } }
</style>

<div class="page-head">
    <h1>Edit Transaksi Arus Kas</h1>
    <p>Perbarui data transaksi "{{ $item->name }}".</p>
</div>

<form method="POST" action="{{ route('cash-flow.update', $item) }}">
    @csrf
    @method('PUT')
    <div class="panel">
        <div class="panel-icon-row">
            <div class="panel-icon"><svg class="icon"><use href="#ic-edit"/></svg></div>
            <span>Perubahan akan memengaruhi laporan arus kas periode {{ $item->period_label }}.</span>
        </div>
        @include('cash-flow._form')
        <div class="panel-actions">
            <button type="button" class="btn btn-danger-ghost" onclick="document.getElementById('deleteFormCf').submit()">Hapus Transaksi</button>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('cash-flow.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('cash-flow.destroy', $item) }}" id="deleteFormCf" onsubmit="return confirm('Hapus transaksi ini?')" style="display:none;">
    @csrf
    @method('DELETE')
</form>
</x-app-layout>