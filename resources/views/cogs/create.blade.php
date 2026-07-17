<x-app-layout>
  <x-slot name="title">Catat HPP</x-slot>

<style>
  .cg-page-head{ text-align:center; max-width:560px; margin:0 auto 24px; }
  .cg-page-head h1{ font-size:24px; margin-bottom:6px; }
  .cg-page-head p{ font-size:13.5px; color:var(--text-mute); }

  .cg-wrap{ max-width:560px; margin:0 auto; }

  .cg-total-ticker{
    background: linear-gradient(160deg, rgba(var(--emerald-rgb),0.12), var(--surface) 60%);
    border:1px solid rgba(var(--emerald-rgb),0.25); border-radius:16px; padding:20px 24px; text-align:center; margin-bottom:20px;
  }
  .cg-total-ticker .lbl{ font-size:11.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); margin-bottom:6px; }
  .cg-total-ticker .amt{ font-family:'Space Grotesk'; font-size:32px; font-weight:700; }
  .cg-total-ticker .sub{ font-size:12px; color:var(--text-mute); margin-top:4px; }

  .cg-panel{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:26px; }
  .cg-field{ margin-bottom:16px; }
  .cg-field label{ display:block; font-size:12.5px; font-weight:600; color:var(--text); margin-bottom:6px; }
  .cg-field label .req{ color:var(--danger); }
  .cg-field label .opt{ color:var(--text-faint); font-weight:400; }
  .cg-input{
    width:100%; padding:11px 13px; border-radius:11px; background:var(--surface-strong); border:1px solid var(--border);
    color:var(--text); font-family:inherit; font-size:13.5px; outline:none; transition:all .2s ease;
  }
  .cg-input:focus{ border-color:var(--border-hover); background:var(--surface); }
  textarea.cg-input{ resize:vertical; min-height:70px; }
  .cg-hint{ font-size:11px; color:var(--text-faint); margin-top:5px; }
  .cg-error{ font-size:11.5px; color:var(--danger); margin-top:5px; }
  .cg-grid-2{ display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
  @media (max-width:600px){ .cg-grid-2{ grid-template-columns:1fr; } }

  .cg-actions{ display:flex; gap:10px; margin-top:20px; padding-top:20px; border-top:1px solid var(--border); }
  .cg-btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; border-radius:11px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; flex:1; }
  .cg-btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
  .cg-btn-primary:hover{ transform:translateY(-1px); }
  .cg-btn-outline{ background:var(--surface-strong); border:1px solid var(--border); color:var(--text); }
</style>

<div class="cg-page-head">
  <h1>Catat Harga Pokok Penjualan</h1>
  <p>Catat HPP dari transaksi penjualan barang. Total otomatis dihitung dari jumlah × harga pokok.</p>
</div>

<div class="cg-wrap">
  <div class="cg-total-ticker">
    <div class="lbl">Total HPP Transaksi Ini</div>
    <div class="amt mono" id="totalTicker">Rp0</div>
    <div class="sub" id="totalSub">0 unit × Rp0</div>
  </div>

  <div class="cg-panel">
    <form method="POST" action="{{ route('cogs.store') }}" id="cogsForm">
      @csrf
      @include('cogs._form')
      <div class="cg-actions">
        <button type="submit" class="cg-btn cg-btn-primary">Simpan Catatan</button>
        <a href="{{ route('cogs.index') }}" class="cg-btn cg-btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>

<script>
  function fmtRupiah(n){
    n = isNaN(n) ? 0 : n;
    return 'Rp' + n.toLocaleString('id-ID', {maximumFractionDigits:0});
  }
  function updateTicker(){
    var qty = parseFloat(document.getElementById('qtyInput')?.value) || 0;
    var cost = parseFloat(document.getElementById('costInput')?.value) || 0;
    document.getElementById('totalTicker').textContent = fmtRupiah(qty * cost);
    document.getElementById('totalSub').textContent = qty + ' unit × ' + fmtRupiah(cost);
  }
  document.getElementById('cogsForm').addEventListener('input', updateTicker);
  setTimeout(updateTicker, 50);
</script>
</x-app-layout>