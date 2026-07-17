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
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); }
    .btn-xs{ padding:5px 10px; font-size:11.5px; border-radius:8px; }

    .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

    .period-filter{ display:flex; align-items:center; gap:10px; margin-bottom:24px; flex-wrap:wrap; }
    .period-filter select{
        padding:10px 14px; border-radius:12px; background:var(--surface); border:1px solid var(--border);
        color:var(--text); font-size:13px; outline:none;
        background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
        background-repeat:no-repeat; background-position:right 12px center; background-size:13px; padding-right:34px; appearance:none;
    }

    /* ===== STATEMENT LAYOUT (beda dari table) ===== */
    .statement{ max-width:820px; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:36px 40px; }
    .statement-header{ text-align:center; margin-bottom:30px; padding-bottom:20px; border-bottom:1px dashed var(--border); }
    .statement-header h2{ font-family:'Space Grotesk', sans-serif; font-size:19px; margin-bottom:4px; }
    .statement-header p{ font-size:13px; color:var(--text-mute); }

    .stmt-section-title{ display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin:26px 0 12px; }
    .stmt-section-title.pendapatan{ color:var(--emerald); }
    .stmt-section-title.beban{ color:var(--danger); }
    .stmt-section-title .icon{ width:15px; height:15px; }

    .stmt-group{ margin-bottom:14px; }
    .stmt-group-title{ font-size:12.5px; color:var(--text-faint); margin-bottom:6px; padding-left:2px; }
    .stmt-row{ display:flex; align-items:center; justify-content:space-between; padding:8px 2px 8px 14px; font-size:13.5px; border-bottom:1px solid var(--border); gap:10px; }
    .stmt-row-name{ flex:1; }
    .stmt-row-actions{ display:flex; gap:4px; opacity:0; transition:opacity .15s ease; }
    .stmt-row:hover .stmt-row-actions{ opacity:1; }
    .stmt-row-actions a, .stmt-row-actions button{ font-size:11px; color:var(--text-faint); background:none; border:none; cursor:pointer; padding:2px 6px; }
    .stmt-row-actions a:hover{ color:var(--emerald); }
    .stmt-row-actions button:hover{ color:var(--danger); }
    .stmt-amount{ font-family:'IBM Plex Mono', monospace; font-weight:500; }
    .stmt-subtotal{ display:flex; justify-content:space-between; padding:8px 2px; font-size:13px; font-weight:600; color:var(--text-mute); }
    .stmt-subtotal .stmt-amount{ font-family:'IBM Plex Mono', monospace; }

    .stmt-grand{ display:flex; justify-content:space-between; padding:14px 2px; margin-top:8px; border-top:1px solid var(--border); font-size:14.5px; font-weight:700; }
    .stmt-grand.pendapatan{ color:var(--emerald); }
    .stmt-grand.beban{ color:var(--danger); }

    .stmt-final{ margin-top:26px; padding:20px 22px; border-radius:14px; display:flex; align-items:center; justify-content:space-between; }
    .stmt-final.positive{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); }
    .stmt-final.negative{ background:rgba(var(--danger-rgb),0.1); border:1px solid rgba(var(--danger-rgb),0.3); }
    .stmt-final-label{ font-size:14px; font-weight:600; }
    .stmt-final-value{ font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:700; }
    .stmt-final.positive .stmt-final-value{ color:var(--emerald); }
    .stmt-final.negative .stmt-final-value{ color:var(--danger); }

    .stmt-empty{ text-align:center; padding:24px; color:var(--text-faint); font-size:13px; }

    @media (max-width:640px){
        .statement{ padding:24px 20px; }
        .page-head{ flex-direction:column; }
        .head-actions{ width:100%; }
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
        <a href="{{ route('laba-rugi.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Tambah Pos</a>
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

<div class="statement">
    <div class="statement-header">
        <h2>Laporan Laba Rugi</h2>
        <p>{{ $company->name ?? 'Perusahaan' }} — Periode {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</p>
    </div>

    <div class="stmt-section-title pendapatan"><svg class="icon"><use href="#ic-trending"/></svg> Pendapatan</div>
    @forelse($pendapatan as $category => $groupItems)
        <div class="stmt-group">
            <div class="stmt-group-title">{{ $category }}</div>
            @foreach($groupItems as $item)
                <div class="stmt-row">
                    <span class="stmt-row-name">{{ $item->name }}</span>
                    <span class="stmt-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                    <span class="stmt-row-actions">
                        <a href="{{ route('laba-rugi.edit', $item) }}">Edit</a>
                        <form method="POST" action="{{ route('laba-rugi.destroy', $item) }}" onsubmit="return confirm('Hapus pos ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </span>
                </div>
            @endforeach
            <div class="stmt-subtotal">
                <span>Subtotal {{ $category }}</span>
                <span class="stmt-amount">Rp{{ number_format($groupItems->sum('amount'), 0, ',', '.') }}</span>
            </div>
        </div>
    @empty
        <div class="stmt-empty">Belum ada pos pendapatan untuk periode ini.</div>
    @endforelse
    <div class="stmt-grand pendapatan">
        <span>Total Pendapatan</span>
        <span class="stmt-amount">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
    </div>

    <div class="stmt-section-title beban"><svg class="icon"><use href="#ic-trending-down"/></svg> Beban</div>
    @forelse($beban as $category => $groupItems)
        <div class="stmt-group">
            <div class="stmt-group-title">{{ $category }}</div>
            @foreach($groupItems as $item)
                <div class="stmt-row">
                    <span class="stmt-row-name">{{ $item->name }}</span>
                    <span class="stmt-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                    <span class="stmt-row-actions">
                        <a href="{{ route('laba-rugi.edit', $item) }}">Edit</a>
                        <form method="POST" action="{{ route('laba-rugi.destroy', $item) }}" onsubmit="return confirm('Hapus pos ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </span>
                </div>
            @endforeach
            <div class="stmt-subtotal">
                <span>Subtotal {{ $category }}</span>
                <span class="stmt-amount">Rp{{ number_format($groupItems->sum('amount'), 0, ',', '.') }}</span>
            </div>
        </div>
    @empty
        <div class="stmt-empty">Belum ada pos beban untuk periode ini.</div>
    @endforelse
    <div class="stmt-grand beban">
        <span>Total Beban</span>
        <span class="stmt-amount">Rp{{ number_format($totalBeban, 0, ',', '.') }}</span>
    </div>

    <div class="stmt-final {{ $labaBersih >= 0 ? 'positive' : 'negative' }}">
        <span class="stmt-final-label">{{ $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}</span>
        <span class="stmt-final-value">Rp{{ number_format(abs($labaBersih), 0, ',', '.') }}</span>
    </div>
</div>
</x-app-layout>