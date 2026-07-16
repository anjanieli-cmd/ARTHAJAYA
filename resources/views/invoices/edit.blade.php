<x-app-layout>
    <x-slot name="title">Edit Faktur</x-slot>

<style>
    .page-head{ margin-bottom:24px; }
    .page-head h1{ font-size:24px; margin-bottom:6px; }
    .page-head p{ font-size:14px; color:var(--text-mute); }
    .panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:32px; max-width:820px; }
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
    @media (max-width:900px){ .field-grid{ grid-template-columns:1fr; } }
</style>

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
</x-app-layout>