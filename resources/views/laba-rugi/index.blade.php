<x-app-layout>
    <x-slot name="title">Laba Rugi</x-slot>

<style>
    .page-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:22px; flex-wrap:wrap; }
    .page-head h1{ font-size:26px; margin-bottom:6px; }
    .page-head p{ font-size:14px; color:var(--text-mute); }
    .head-actions{ display:flex; gap:10px; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; white-space:nowrap; }
    .btn .icon{ width:15px; height:15px; }
    .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
    .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 8px 26px rgba(var(--emerald-rgb),0.45); }

    .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

    .period-filter{ display:flex; align-items:center; gap:10px; margin-bottom:24px; flex-wrap:wrap; }
    .period-filter select{
        padding:10px 14px; border-radius:12px; background:var(--surface); border:1px solid var(--border);
        color:var(--text); font-size:13px; outline:none;
        background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
        background-repeat:no-repeat; background-position:right 12px center; background-size:13px; padding-right:34px; appearance:none;
    }

    /* ===== 2-COLUMN LAYOUT ===== */
    .lr-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start; }
    .lr-col{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px 28px; }

    .lr-col-header{ display:flex; align-items:center; gap:10px; margin-bottom:18px; padding-bottom:16px; border-bottom:1px dashed var(--border); }
    .lr-col-header .ic{ width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .lr-col-header .ic .icon{ width:17px; height:17px; }
    .lr-col.pendapatan .ic{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
    .lr-col.beban .ic{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
    .lr-col-header h3{ font-family:'Space Grotesk', sans-serif; font-size:16px; }

    .lr-group-title{ font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:.04em; color:var(--text-faint); margin:16px 0 6px; }
    .lr-group-title:first-of-type{ margin-top:0; }

    /* ROW dengan hover actions */
    .lr-row{
        display:flex; align-items:center; padding:9px 10px;
        border-radius:10px; gap:10px; font-size:13.5px;
        transition: background .15s ease; position:relative;
    }
    .lr-row:hover{ background:var(--surface-strong); }
    .lr-row-name{ flex:1; min-width:0; }
    .lr-amount{ font-family:'IBM Plex Mono', monospace; white-space:nowrap; font-size:13px; }

    /* Actions tersembunyi, muncul saat hover */
    .lr-row-actions{
        display:flex; gap:4px; flex-shrink:0;
        opacity:0; pointer-events:none;
        transition: opacity .15s ease;
    }
    .lr-row:hover .lr-row-actions{ opacity:1; pointer-events:all; }

    .lra-btn{
        display:inline-flex; align-items:center; justify-content:center;
        width:28px; height:28px; border-radius:7px; border:1px solid var(--border);
        background:var(--surface); color:var(--text-faint);
        cursor:pointer; text-decoration:none; transition:all .15s ease;
    }
    .lra-btn .icon{ width:13px; height:13px; }
    .lra-btn.view:hover{ color:var(--info); border-color:rgba(var(--info-rgb),0.4); background:rgba(var(--info-rgb),0.08); }
    .lra-btn.edit:hover{ color:var(--emerald); border-color:rgba(var(--emerald-rgb),0.4); background:rgba(var(--emerald-rgb),0.08); }
    .lra-btn.del{ color:var(--danger); border-color:rgba(var(--danger-rgb),0.2); }
    .lra-btn.del:hover{ background:rgba(var(--danger-rgb),0.1); border-color:rgba(var(--danger-rgb),0.4); }
    .lra-btn button{ all:unset; display:flex; align-items:center; justify-content:center; width:100%; height:100%; cursor:pointer; }

    .lr-subtotal{ display:flex; justify-content:space-between; padding:7px 10px; font-size:12.5px; color:var(--text-mute); font-weight:600; }
    .lr-empty{ font-size:12.5px; color:var(--text-faint); padding:8px 10px 14px; }

    .lr-col-total{ display:flex; justify-content:space-between; margin-top:10px; padding:14px 10px; border-top:1px solid var(--border); font-size:14.5px; font-weight:700; border-radius:0 0 10px 10px; }
    .lr-col.pendapatan .lr-col-total{ color:var(--emerald); background:rgba(var(--emerald-rgb),0.06); }
    .lr-col.beban .lr-col-total{ color:var(--danger); background:rgba(var(--danger-rgb),0.06); }

    /* ===== SUMMARY BAR ===== */
    .lr-summary{ margin-top:18px; padding:20px 28px; border-radius:16px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
    .lr-summary.positive{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); }
    .lr-summary.negative{ background:rgba(var(--danger-rgb),0.1); border:1px solid rgba(var(--danger-rgb),0.3); }
    .lr-summary-left{ display:flex; flex-direction:column; gap:4px; }
    .lr-summary-label{ font-size:13px; font-weight:600; color:var(--text-mute); }
    .lr-summary-sublabel{ font-size:12px; color:var(--text-faint); }
    .lr-summary-value{ font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; }
    .lr-summary.positive .lr-summary-value{ color:var(--emerald); }
    .lr-summary.negative .lr-summary-value{ color:var(--danger); }
    .lr-summary-detail{ display:flex; gap:28px; }
    .lr-summary-item{ text-align:right; }
    .lr-summary-item .k{ font-size:11.5px; color:var(--text-faint); margin-bottom:2px; }
    .lr-summary-item .v{ font-family:'IBM Plex Mono', monospace; font-size:13.5px; font-weight:600; }
    .lr-summary-item .v.green{ color:var(--emerald); }
    .lr-summary-item .v.red{ color:var(--danger); }

    @media (max-width:900px){
        .lr-grid{ grid-template-columns:1fr; }
        .lr-row-actions{ opacity:1; pointer-events:all; }
        .page-head{ flex-direction:column; }
        .head-actions .btn{ flex:1; }
    }
</style>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="page-head">
    <div>
        <h1>Laporan Laba Rugi</h1>
        <p>Ringkasan pendapatan dan beban {{ $company->name ?? 'perusahaanmu' }} per periode.</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('laba-rugi.create') }}" class="btn btn-primary">
            <svg class="icon"><use href="#ic-plus"/></svg> Tambah Pos
        </a>
    </div>
</div>

<form method="GET" action="{{ route('laba-rugi.index') }}" class="period-filter">
    <svg class="icon" style="width:15px;height:15px;color:var(--text-faint);"><use href="#ic-calendar"/></svg>
    <select name="month" onchange="this.form.submit()">
        @php $bulanList=[1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; @endphp
        @foreach($bulanList as $num => $label)
            <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <select name="year" onchange="this.form.submit()">
        @for($y = now()->year; $y >= now()->year - 5; $y--)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
    </select>
</form>

{{-- ===== 2-COLUMN GRID ===== --}}
<div class="lr-grid">

    {{-- KIRI: PENDAPATAN --}}
    <div class="lr-col pendapatan">
        <div class="lr-col-header">
            <div class="ic"><svg class="icon"><use href="#ic-trending"/></svg></div>
            <h3>Pendapatan</h3>
        </div>

        @forelse($pendapatan as $category => $groupItems)
            <div class="lr-group-title">{{ $category }}</div>
            @foreach($groupItems as $item)
                <div class="lr-row">
                    <span class="lr-row-name">{{ $item->name }}</span>
                    <span class="lr-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                    <div class="lr-row-actions">
                        <a href="{{ route('laba-rugi.show', $item) }}" class="lra-btn view" title="Lihat">
                            <svg class="icon"><use href="#ic-eye"/></svg>
                        </a>
                        <a href="{{ route('laba-rugi.edit', $item) }}" class="lra-btn edit" title="Edit">
                            <svg class="icon"><use href="#ic-edit"/></svg>
                        </a>
                        <form method="POST" action="{{ route('laba-rugi.destroy', $item) }}" onsubmit="return confirm('Hapus pos ini?')" style="display:contents;">
                            @csrf @method('DELETE')
                            <span class="lra-btn del" title="Hapus">
                                <button type="submit"><svg class="icon"><use href="#ic-trash"/></svg></button>
                            </span>
                        </form>
                    </div>
                </div>
            @endforeach
            <div class="lr-subtotal">
                <span>Subtotal {{ $category }}</span>
                <span class="lr-amount">Rp{{ number_format($groupItems->sum('amount'), 0, ',', '.') }}</span>
            </div>
        @empty
            <div class="lr-empty">Belum ada pos pendapatan untuk periode ini.</div>
        @endforelse

        <div class="lr-col-total">
            <span>Total Pendapatan</span>
            <span class="lr-amount">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- KANAN: BEBAN --}}
    <div class="lr-col beban">
        <div class="lr-col-header">
            <div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div>
            <h3>Beban</h3>
        </div>

        @forelse($beban as $category => $groupItems)
            <div class="lr-group-title">{{ $category }}</div>
            @foreach($groupItems as $item)
                <div class="lr-row">
                    <span class="lr-row-name">{{ $item->name }}</span>
                    <span class="lr-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                    <div class="lr-row-actions">
                        <a href="{{ route('laba-rugi.show', $item) }}" class="lra-btn view" title="Lihat">
                            <svg class="icon"><use href="#ic-eye"/></svg>
                        </a>
                        <a href="{{ route('laba-rugi.edit', $item) }}" class="lra-btn edit" title="Edit">
                            <svg class="icon"><use href="#ic-edit"/></svg>
                        </a>
                        <form method="POST" action="{{ route('laba-rugi.destroy', $item) }}" onsubmit="return confirm('Hapus pos ini?')" style="display:contents;">
                            @csrf @method('DELETE')
                            <span class="lra-btn del" title="Hapus">
                                <button type="submit"><svg class="icon"><use href="#ic-trash"/></svg></button>
                            </span>
                        </form>
                    </div>
                </div>
            @endforeach
            <div class="lr-subtotal">
                <span>Subtotal {{ $category }}</span>
                <span class="lr-amount">Rp{{ number_format($groupItems->sum('amount'), 0, ',', '.') }}</span>
            </div>
        @empty
            <div class="lr-empty">Belum ada pos beban untuk periode ini.</div>
        @endforelse

        <div class="lr-col-total">
            <span>Total Beban</span>
            <span class="lr-amount">Rp{{ number_format($totalBeban, 0, ',', '.') }}</span>
        </div>
    </div>

</div>

{{-- ===== SUMMARY BAR ===== --}}
<div class="lr-summary {{ $labaBersih >= 0 ? 'positive' : 'negative' }}">
    <div class="lr-summary-left">
        <div class="lr-summary-label">{{ $labaBersih >= 0 ? '📈 Laba Bersih' : '📉 Rugi Bersih' }}</div>
        <div class="lr-summary-sublabel">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }} — {{ $company->name ?? 'Perusahaan' }}</div>
        <div class="lr-summary-value">Rp{{ number_format(abs($labaBersih), 0, ',', '.') }}</div>
    </div>
    <div class="lr-summary-detail">
        <div class="lr-summary-item">
            <div class="k">Total Pendapatan</div>
            <div class="v green">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="lr-summary-item">
            <div class="k">Total Beban</div>
            <div class="v red">Rp{{ number_format($totalBeban, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

</x-app-layout>