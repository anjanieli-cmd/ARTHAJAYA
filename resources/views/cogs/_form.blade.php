{{-- Partial form dipakai bareng oleh cogs/create.blade.php & cogs/edit.blade.php --}}
<div class="cg-field">
  <label>Barang dari Inventaris <span class="opt">(opsional)</span></label>
  <select name="inventory_item_id" class="cg-input" id="itemSelect">
    <option value="">— Input manual (barang tidak ada di inventaris) —</option>
    @foreach($items as $inv)
      <option value="{{ $inv->id }}"
        data-cost="{{ $inv->cost_price }}"
        {{ old('inventory_item_id', $entry->inventory_item_id ?? null) == $inv->id ? 'selected' : '' }}>
        {{ $inv->name }} ({{ $inv->sku }}) — stok: {{ $inv->stock_quantity }} {{ $inv->unit }}
      </option>
    @endforeach
  </select>
  <div class="cg-hint">Kalau dipilih, harga pokok otomatis terisi dan stok akan berkurang sesuai jumlah terjual.</div>
</div>

<div class="cg-field" id="manualNameField" style="{{ old('inventory_item_id', $entry->inventory_item_id ?? null) ? 'display:none;' : '' }}">
  <label>Nama Barang (manual)</label>
  <input type="text" name="item_name" value="{{ old('item_name', $entry->item_name ?? '') }}" class="cg-input" placeholder="Nama barang yang tidak ada di inventaris">
  @error('item_name') <div class="cg-error">{{ $message }}</div> @enderror
</div>

<div class="cg-grid-2">
  <div class="cg-field">
    <label>Jumlah Terjual <span class="req">*</span></label>
    <input type="number" name="quantity_sold" min="1" value="{{ old('quantity_sold', $entry->quantity_sold ?? 1) }}" class="cg-input" id="qtyInput" required>
    @error('quantity_sold') <div class="cg-error">{{ $message }}</div> @enderror
  </div>

  <div class="cg-field">
    <label>Harga Pokok / Unit (Rp) <span class="req">*</span></label>
    <input type="number" name="unit_cost" min="0" step="0.01" value="{{ old('unit_cost', $entry->unit_cost ?? 0) }}" class="cg-input mono" id="costInput" required>
    @error('unit_cost') <div class="cg-error">{{ $message }}</div> @enderror
  </div>

  <div class="cg-field">
    <label>Tanggal Penjualan <span class="req">*</span></label>
    <input type="date" name="sale_date" value="{{ old('sale_date', isset($entry) ? $entry->sale_date->format('Y-m-d') : now()->format('Y-m-d')) }}" class="cg-input" required>
    @error('sale_date') <div class="cg-error">{{ $message }}</div> @enderror
  </div>
</div>

<div class="cg-field">
  <label>Catatan <span class="opt">(opsional)</span></label>
  <textarea name="notes" class="cg-input" placeholder="Referensi faktur, keterangan tambahan...">{{ old('notes', $entry->notes ?? '') }}</textarea>
</div>

<script>
  (function(){
    var itemSelect = document.getElementById('itemSelect');
    var manualField = document.getElementById('manualNameField');
    var costInput = document.getElementById('costInput');

    function syncFields(){
      var opt = itemSelect.options[itemSelect.selectedIndex];
      if(itemSelect.value){
        manualField.style.display = 'none';
        var cost = opt.getAttribute('data-cost');
        if(cost) costInput.value = parseFloat(cost).toFixed(2);
      } else {
        manualField.style.display = '';
      }
    }
    itemSelect.addEventListener('change', syncFields);
  })();
</script>