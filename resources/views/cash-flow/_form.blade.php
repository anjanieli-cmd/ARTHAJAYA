@php
    $old = fn($field, $default = null) => old($field, isset($item) ? $item->$field : $default);
    $bulanList = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
        7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
    ];
@endphp

<div class="field-grid">
    <div class="field">
        <label>Aktivitas <span class="req">*</span></label>
        <select name="activity_type" required>
            <option value="">Pilih aktivitas</option>
            <option value="operasional" {{ $old('activity_type')==='operasional' ? 'selected':'' }}>Operasional</option>
            <option value="investasi" {{ $old('activity_type')==='investasi' ? 'selected':'' }}>Investasi</option>
            <option value="pendanaan" {{ $old('activity_type')==='pendanaan' ? 'selected':'' }}>Pendanaan</option>
        </select>
        @error('activity_type')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Arah Kas <span class="req">*</span></label>
        <select name="direction" required>
            <option value="">Pilih arah</option>
            <option value="masuk" {{ $old('direction')==='masuk' ? 'selected':'' }}>Kas Masuk</option>
            <option value="keluar" {{ $old('direction')==='keluar' ? 'selected':'' }}>Kas Keluar</option>
        </select>
        @error('direction')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Kategori <span class="req">*</span></label>
        <input type="text" name="category" value="{{ $old('category') }}" list="cfCategoryList" placeholder="mis. Penerimaan dari Klien" required>
        <datalist id="cfCategoryList">
            <option value="Penerimaan dari Klien">
            <option value="Pembayaran ke Pemasok">
            <option value="Pembayaran Gaji">
            <option value="Pembelian Aset Tetap">
            <option value="Penjualan Aset">
            <option value="Pinjaman Bank">
            <option value="Pembayaran Cicilan">
            <option value="Setoran Modal">
        </datalist>
        @error('category')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Nama Transaksi <span class="req">*</span></label>
        <input type="text" name="name" value="{{ $old('name') }}" placeholder="mis. Pelunasan Faktur INV-0032" required>
        @error('name')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Jumlah (Rp) <span class="req">*</span></label>
        <input type="number" name="amount" value="{{ $old('amount') }}" step="0.01" min="0" placeholder="0" required>
        @error('amount')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Bulan <span class="req">*</span></label>
        <select name="period_month" required>
            @foreach($bulanList as $num => $label)
                <option value="{{ $num }}" {{ (string) $old('period_month', now()->month) === (string) $num ? 'selected':'' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('period_month')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Tahun <span class="req">*</span></label>
        <input type="number" name="period_year" value="{{ $old('period_year', now()->year) }}" min="2000" max="2100" required>
        @error('period_year')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Catatan <span class="opt">(opsional)</span></label>
        <textarea name="notes" placeholder="Catatan tambahan...">{{ $old('notes') }}</textarea>
        @error('notes')<div class="field-error">{{ $message }}</div>@enderror
    </div>
</div>