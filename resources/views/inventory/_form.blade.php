{{-- Partial form dipakai bareng oleh inventory/create.blade.php & inventory/edit.blade.php --}}
<div class="inv-field-grid">
  <div class="inv-field">
    <label>SKU / Kode Barang <span class="req">*</span></label>
    <input type="text" name="sku" value="{{ old('sku', $item->sku ?? '') }}" class="inv-input mono" placeholder="BRG-001" required>
    @error('sku') <div class="inv-error">{{ $message }}</div> @enderror
  </div>

  <div class="inv-field">
    <label>Nama Barang <span class="req">*</span></label>
    <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" class="inv-input" required>
    @error('name') <div class="inv-error">{{ $message }}</div> @enderror
  </div>

  <div class="inv-field">
    <label>Kategori <span class="opt">(opsional)</span></label>
    <input type="text" name="category" value="{{ old('category', $item->category ?? '') }}" class="inv-input" placeholder="mis. Bahan Baku, Elektronik">
  </div>

  <div class="inv-field">
    <label>Satuan</label>
    <select name="unit" class="inv-input">
      @foreach(['pcs'=>'Pcs','kg'=>'Kg','liter'=>'Liter','box'=>'Box','unit'=>'Unit','pack'=>'Pack'] as $val => $label)
        <option value="{{ $val }}" {{ old('unit', $item->unit ?? 'pcs') === $val ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
  </div>

  <div class="inv-field">
    <label>Jumlah Stok <span class="req">*</span></label>
    <input type="number" name="stock_quantity" min="0" value="{{ old('stock_quantity', $item->stock_quantity ?? 0) }}" class="inv-input" required>
    @error('stock_quantity') <div class="inv-error">{{ $message }}</div> @enderror
  </div>

  <div class="inv-field">
    <label>Batas Stok Minimum</label>
    <input type="number" name="reorder_level" min="0" value="{{ old('reorder_level', $item->reorder_level ?? 5) }}" class="inv-input" id="reorderInput">
    <div class="inv-hint">Peringatan stok menipis muncul kalau stok ≤ angka ini</div>
  </div>

  <div class="inv-field">
    <label>Harga Pokok / Beli (Rp) <span class="req">*</span></label>
    <input type="number" name="cost_price" min="0" step="0.01" value="{{ old('cost_price', $item->cost_price ?? 0) }}" class="inv-input mono" id="costInput" required>
    @error('cost_price') <div class="inv-error">{{ $message }}</div> @enderror
  </div>

  <div class="inv-field">
    <label>Harga Jual (Rp) <span class="req">*</span></label>
    <input type="number" name="selling_price" min="0" step="0.01" value="{{ old('selling_price', $item->selling_price ?? 0) }}" class="inv-input mono" id="sellInput" required>
    @error('selling_price') <div class="inv-error">{{ $message }}</div> @enderror
  </div>

  <div class="inv-field full">
    <label>Deskripsi <span class="opt">(opsional)</span></label>
    <textarea name="description" class="inv-input" placeholder="Catatan tambahan tentang barang ini...">{{ old('description', $item->description ?? '') }}</textarea>
  </div>
</div>