@php
    $old = fn($field, $default = null) => old($field, isset($item) ? $item->$field : $default);
@endphp

<div class="field-grid">
    <div class="field">
        <label>Jenis Pos <span class="req">*</span></label>
        <select name="type" required>
            <option value="">Pilih jenis</option>
            <option value="aset" {{ $old('type')==='aset' ? 'selected':'' }}>Aset</option>
            <option value="kewajiban" {{ $old('type')==='kewajiban' ? 'selected':'' }}>Kewajiban</option>
            <option value="modal" {{ $old('type')==='modal' ? 'selected':'' }}>Modal</option>
        </select>
        @error('type')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Kategori <span class="req">*</span></label>
        <input type="text" name="category" value="{{ $old('category') }}" list="categoryListNeraca" placeholder="mis. Aset Lancar" required>
        <datalist id="categoryListNeraca">
            <option value="Aset Lancar">
            <option value="Aset Tetap">
            <option value="Kewajiban Lancar">
            <option value="Kewajiban Jangka Panjang">
            <option value="Modal Pemilik">
            <option value="Laba Ditahan">
        </datalist>
        @error('category')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Nama Pos <span class="req">*</span></label>
        <input type="text" name="name" value="{{ $old('name') }}" placeholder="mis. Kas & Bank" required>
        @error('name')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Jumlah (Rp) <span class="req">*</span></label>
        <input type="number" name="amount" value="{{ $old('amount') }}" step="0.01" min="0" placeholder="0" required>
        @error('amount')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Per Tanggal <span class="req">*</span></label>
        <input type="date" name="as_of_date" value="{{ $old('as_of_date', $old('as_of_date') ?: (isset($item) ? $item->as_of_date->format('Y-m-d') : now()->format('Y-m-d'))) }}" required>
        @error('as_of_date')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Catatan <span class="opt">(opsional)</span></label>
        <textarea name="notes" placeholder="Catatan tambahan...">{{ $old('notes') }}</textarea>
        @error('notes')<div class="field-error">{{ $message }}</div>@enderror
    </div>
</div>