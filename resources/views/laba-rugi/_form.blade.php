@php
    $old = fn($field, $default = null) => old($field, isset($item) ? $item->$field : $default);
    $bulanList = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
        7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
    ];
@endphp

<div class="field-grid">
    <div class="field">
        <label>Jenis Pos <span class="req">*</span></label>
        <select name="type" required>
            <option value="">Pilih jenis</option>
            <option value="pendapatan" {{ $old('type')==='pendapatan' ? 'selected':'' }}>Pendapatan</option>
            <option value="beban" {{ $old('type')==='beban' ? 'selected':'' }}>Beban</option>
        </select>
        @error('type')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Kategori <span class="req">*</span></label>
        <input type="text" name="category" value="{{ $old('category') }}" list="categoryList" placeholder="mis. Pendapatan Operasional" required>
        <datalist id="categoryList">
            <option value="Pendapatan Operasional">
            <option value="Pendapatan Lain-lain">
            <option value="Beban Operasional">
            <option value="Beban Administrasi & Umum">
            <option value="Beban Pemasaran">
            <option value="Beban Lain-lain">
        </datalist>
        @error('category')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field full">
        <label>Nama Pos <span class="req">*</span></label>
        <input type="text" name="name" value="{{ $old('name') }}" placeholder="mis. Penjualan Jasa Konsultasi" required>
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