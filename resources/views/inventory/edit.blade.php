<x-app-layout>
  <x-slot name="title">Edit Barang</x-slot>

<style>
  .inv-page-head{ margin-bottom: 24px; }
  .inv-page-head h1{ font-size: 25px; margin-bottom: 6px; }
  .inv-page-head p{ font-size: 13.5px; color: var(--text-mute); }

  .inv-layout{ display:grid; grid-template-columns: 1.5fr 1fr; gap: 20px; align-items:start; }
  @media (max-width: 980px){ .inv-layout{ grid-template-columns: 1fr; } }

  .inv-panel{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:26px; }
  .inv-field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
  .inv-field.full{ grid-column:1/-1; }
  .inv-field label{ display:block; font-size:12.5px; font-weight:600; color:var(--text); margin-bottom:6px; }
  .inv-field label .req{ color:var(--danger); }
  .inv-field label .opt{ color:var(--text-faint); font-weight:400; }
  .inv-input{
    width:100%; padding:11px 13px; border-radius:11px; background:var(--surface-strong); border:1px solid var(--border);
    color:var(--text); font-family:inherit; font-size:13.5px; outline:none; transition:all .2s ease;
  }
  .inv-input:focus{ border-color:var(--border-hover); background:var(--surface); }
  textarea.inv-input{ resize:vertical; min-height:70px; }
  .inv-hint{ font-size:11px; color:var(--text-faint); margin-top:5px; }
  .inv-error{ font-size:11.5px; color:var(--danger); margin-top:5px; }

  .inv-actions{ display:flex; gap:10px; margin-top:22px; padding-top:20px; border-top:1px solid var(--border); }
  .inv-btn{ display:inline-flex; align-items:center; gap:8px; padding:11px 22px; border-radius:11px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
  .inv-btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
  .inv-btn-primary:hover{ transform:translateY(-1px); }
  .inv-btn-outline{ background:var(--surface-strong); border:1px solid var(--border); color:var(--text); }

  .preview-card{
    background: linear-gradient(160deg, rgba(var(--emerald-rgb),0.10), var(--surface) 60%);
    border:1px solid rgba(var(--emerald-rgb),0.25); border-radius:18px; padding:24px; position:sticky; top:90px;
  }
  .preview-label{ font-size:11px; text-transform:uppercase; letter-spacing:.07em; color:var(--text-faint); margin-bottom:16px; }
  .preview-stat{ margin-bottom:18px; }
  .preview-stat .k{ font-size:12px; color:var(--text-mute); margin-bottom:4px; }
  .preview-stat .v{ font-family:'Space Grotesk'; font-size:22px; font-weight:700; }
  .preview-divider{ height:1px; background:var(--border); margin:18px 0; }
  .preview-row{ display:flex; justify-content:space-between; font-size:13px; color:var(--text-mute); padding:6px 0; }
  .preview-row b{ color:var(--text); font-family:'IBM Plex Mono'; }
  .margin-badge{ display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:100px; font-size:12px; font-weight:700; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
</style>

<div class="inv-page-head">
  <h1>Edit Barang</h1>
  <p>Perbarui data <b>{{ $item->name }}</b> ({{ $item->sku }}).</p>
</div>

<div class="inv-layout">
  <div class="inv-panel">
    <form method="POST" action="{{ route('inventory.update', $item) }}" id="invForm">
      @csrf
      @method('PUT')
      @include('inventory._form')
      <div class="inv-actions">
        <button type="submit" class="inv-btn inv-btn-primary">Simpan Perubahan</button>
        <a href="{{ route('inventory.index') }}" class="inv-btn inv-btn-outline">Batal</a>
      </div>
    </form>
  </div>

  <div class="preview-card">
    <div class="preview-label">Pratinjau Nilai Stok</div>
    <div class="preview-stat">
      <div class="k">Total Nilai Stok</div>
      <div class="v mono" id="previewValue">Rp0</div>
    </div>
    <div class="preview-divider"></div>
    <div class="preview-row"><span>Harga pokok / unit</span><b id="previewCost">Rp0</b></div>
    <div class="preview-row"><span>Harga jual / unit</span><b id="previewSell">Rp0</b></div>
    <div class="preview-row"><span>Estimasi margin</span><span class="margin-badge" id="previewMargin">0%</span></div>
  </div>
</div>

<script>
  function fmtRupiah(n){
    n = isNaN(n) ? 0 : n;
    return 'Rp' + n.toLocaleString('id-ID', {maximumFractionDigits:0});
  }
  function updatePreview(){
    var qty = parseFloat(document.querySelector('[name="stock_quantity"]')?.value) || 0;
    var cost = parseFloat(document.getElementById('costInput')?.value) || 0;
    var sell = parseFloat(document.getElementById('sellInput')?.value) || 0;

    document.getElementById('previewValue').textContent = fmtRupiah(qty * cost);
    document.getElementById('previewCost').textContent = fmtRupiah(cost);
    document.getElementById('previewSell').textContent = fmtRupiah(sell);

    var margin = sell > 0 ? ((sell - cost) / sell) * 100 : 0;
    document.getElementById('previewMargin').textContent = margin.toFixed(1) + '%';
  }
  document.getElementById('invForm').addEventListener('input', updatePreview);
  updatePreview();
</script>
</x-app-layout>