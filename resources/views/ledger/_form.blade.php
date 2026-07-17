@php
    $old = fn($field, $default = null) => old($field, isset($item) ? $item->$field : $default);
@endphp

<div class="field-grid">
    <div class="field">
        <label>Kode Akun <span class="req">*</span></label>
        <input type="text" name="account_code" value="{{ $old('account_code') }}" list="accountCodeList" placeholder="mis. 1101" required>
        <datalist id="accountCodeList">
            <option value="1101">Kas & Bank</option>
            <option value="1201">Piutang Usaha</option>
            <option value="2101">Utang Usaha</option>
            <option value="3101">Modal Pemilik</option>
            <option value="4101">Pendapatan Jasa</option>
            <option value="5101">Beban Operasional</option>
        </datalist>
        @error('account_code')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Nama Akun <span class="req">*</span></label>
        <input type="text" name="account_name" value="{{ $old('account_name') }}" placeholder="mis. Kas & Bank" required>
        @error('account_name')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Tanggal Transaksi <span class="req">*</span></label>
        <input type="date" name="transaction_date" value="{{ $old('transaction_date', isset($item) ? $item->transaction_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        @error('transaction_date')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Keterangan <span class="req">*</span></label>
        <input type="text" name="description" value="{{ $old('description') }}" placeholder="mis. Penerimaan pembayaran faktur INV-0032" required>
        @error('description')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Debit (Rp) <span class="opt">(kosongkan jika 0)</span></label>
        <input type="number" name="debit" value="{{ $old('debit') }}" step="0.01" min="0" placeholder="0">
        @error('debit')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Kredit (Rp) <span class="opt">(kosongkan jika 0)</span></label>
        <input type="number" name="credit" value="{{ $old('credit') }}" step="0.01" min="0" placeholder="0">
        @error('credit')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Catatan <span class="opt">(opsional)</span></label>
        <textarea name="notes" placeholder="Catatan tambahan...">{{ $old('notes') }}</textarea>
        @error('notes')<div class="field-error">{{ $message }}</div>@enderror
    </div>
</div>