<x-app-layout>
    <x-slot name="title">Arus Kas</x-slot>

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

    /* ===== SUMMARY STRIP ===== */
    .cf-summary{ display:grid; grid-template-columns:repeat(3,1fr); gap:14px; max-width:920px; margin-bottom:26px; }
    .cf-summary-card{ background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:16px 18px; }
    .cf-summary-card .lbl{ font-size:12px; color:var(--text-mute); margin-bottom:6px; }
    .cf-summary-card .val{ font-family:'Space Grotesk', sans-serif; font-size:19px; font-weight:700; }
    .cf-summary-card.masuk .val{ color:var(--emerald); }
    .cf-summary-card.keluar .val{ color:var(--danger); }
    .cf-summary-card.net .val{ color:var(--info); }

    /* ===== TIMELINE LAYOUT ===== */
    .cf-timeline{ max-width:920px; position:relative; padding-left:28px; }
    .cf-timeline::before{ content:''; position:absolute; left:9px; top:6px; bottom:6px; width:2px; background:var(--border); }

    .cf-activity{ position:relative; margin-bottom:30px; }
    .cf-activity-dot{
        position:absolute; left:-28px; top:2px; width:20px; height:20px; border-radius:50%;
        background:var(--bg); border:2px solid var(--border); display:flex; align-items:center; justify-content:center;
    }
    .cf-activity-dot .icon{ width:10px; height:10px; }
    .cf-activity.operasional .cf-activity-dot{ border-color:var(--emerald); color:var(--emerald); }
    .cf-activity.investasi .cf-activity-dot{ border-color:var(--info); color:var(--info); }
    .cf-activity.pendanaan .cf-activity-dot{ border-color:var(--warning); color:var(--warning); }

    .cf-activity-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; gap:10px; flex-wrap:wrap; }
    .cf-activity-head h3{ font-family:'Space Grotesk', sans-serif; font-size:15.5px; }
    .cf-activity-net{ font-family:'IBM Plex Mono', monospace; font-size:13.5px; font-weight:600; padding:4px 12px; border-radius:100px; }
    .cf-activity.operasional .cf-activity-net{ background:rgba(var(--emerald-rgb),0.1); color:var(--emerald); }
    .cf-activity.investasi .cf-activity-net{ background:rgba(var(--info-rgb),0.1); color:var(--info); }
    .cf-activity.pendanaan .cf-activity-net{ background:rgba(var(--warning-rgb),0.1); color:var(--warning); }

    .cf-card{ background:var(--surface); border:1px solid var(--border); border-radius:14px; overflow:hidden; }
    .cf-row{ display:flex; align-items:center; gap:12px; padding:12px 16px; border-bottom:1px solid var(--border); flex-wrap:wrap; }
    .cf-row:last-child{ border-bottom:none; }
    .cf-row-icon{ width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .cf-row.masuk .cf-row-icon{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
    .cf-row.keluar .cf-row-icon{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
    .cf-row-icon .icon{ width:14px; height:14px; }
    .cf-row-body{ flex:1; min-width:120px; }
    .cf-row-name{ font-size:13.5px; font-weight:600; }
    .cf-row-cat{ font-size:11.5px; color:var(--text-faint); }
    .cf-row-amount{ font-family:'IBM Plex Mono', monospace; font-size:13.5px; font-weight:600; white-space:nowrap; }
    .cf-row.masuk .cf-row-amount{ color:var(--emerald); }
    .cf-row.keluar .cf-row-amount{ color:var(--danger); }
    .cf-empty{ padding:18px 16px; font-size:12.5px; color:var(--text-faint); text-align:center; }

    .cf-final{ max-width:920px; margin-top:10px; padding:20px 24px; border-radius:14px; display:flex; align-items:center; justify-content:space-between; }
    .cf-final.positive{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); }
    .cf-final.negative{ background:rgba(var(--danger-rgb),0.1); border:1px solid rgba(var(--danger-rgb),0.3); }
    .cf-final-label{ font-size:14px; font-weight:600; }
    .cf-final-value{ font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:700; }
    .cf-final.positive .cf-final-value{ color:var(--emerald); }
    .cf-final.negative .cf-final-value{ color:var(--danger); }

    /* ===== ACTION BUTTONS (baru, lebih jelas) ===== */
    .cf-row-actions{ display:flex; gap:5px; flex-shrink:0; }
    .row-action-btn{
        display:inline-flex; align-items:center; justify-content:center; padding:5px 10px; border-radius:7px;
        font-size:11px; font-weight:600; text-decoration:none; border:1px solid var(--border);
        background:var(--surface-strong); color:var(--text-mute); transition:all .15s ease; cursor:pointer; white-space:nowrap;
    }
    .row-action-btn:hover{ background:var(--surface); border-color:var(--border-hover); color:var(--text); }
    .row-action-btn.view:hover{ color:var(--info); border-color:rgba(var(--info-rgb),0.4); }
    .row-action-btn.edit:hover{ color:var(--emerald); border-color:rgba(var(--emerald-rgb),0.4); }
    .row-action-btn.delete{ color:var(--danger); border-color:rgba(var(--danger-rgb),0.25); }
    .row-action-btn.delete:hover{ background:rgba(var(--danger-rgb),0.1); border-color:rgba(var(--danger-rgb),0.4); }

    @media (max-width:640px){
        .cf-summary{ grid-template-columns:1fr; }
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
        <h1>Laporan Arus Kas</h1>
        <p>Pergerakan kas {{ $company->name ?? 'perusahaanmu' }} berdasarkan aktivitas operasional, investasi, dan pendanaan.</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('cash-flow.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Tambah Transaksi</a>
    </div>
</div>

<form method="GET" action="{{ route('cash-flow.index') }}" class="period-filter">
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

<div class="cf-summary">
    <div class="cf-summary-card masuk">
        <div class="lbl">Total Kas Masuk</div>
        <div class="val">Rp{{ number_format($totalMasuk, 0, ',', '.') }}</div>
    </div>
    <div class="cf-summary-card keluar">
        <div class="lbl">Total Kas Keluar</div>
        <div class="val">Rp{{ number_format($totalKeluar, 0, ',', '.') }}</div>
    </div>
    <div class="cf-summary-card net">
        <div class="lbl">Arus Kas Bersih</div>
        <div class="val">Rp{{ number_format($netCashFlow, 0, ',', '.') }}</div>
    </div>
</div>

<div class="cf-timeline">
    @foreach($groups as $key => $group)
        <div class="cf-activity {{ $key }}">
            <div class="cf-activity-dot">
                <svg class="icon"><use href="#{{ $key === 'operasional' ? 'ic-activity' : ($key === 'investasi' ? 'ic-trending' : 'ic-bank') }}"/></svg>
            </div>
            <div class="cf-activity-head">
                <h3>{{ $group['label'] }}</h3>
                <span class="cf-activity-net">Net: Rp{{ number_format($group['net'], 0, ',', '.') }}</span>
            </div>
            <div class="cf-card">
                @forelse($group['items'] as $item)
                    <div class="cf-row {{ $item->direction }}">
                        <div class="cf-row-icon">
                            <svg class="icon"><use href="#{{ $item->direction === 'masuk' ? 'ic-trending' : 'ic-trending-down' }}"/></svg>
                        </div>
                        <div class="cf-row-body">
                            <div class="cf-row-name">{{ $item->name }}</div>
                            <div class="cf-row-cat">{{ $item->category }}</div>
                        </div>
                        <div class="cf-row-amount">{{ $item->direction === 'masuk' ? '+' : '-' }}Rp{{ number_format($item->amount, 0, ',', '.') }}</div>
                        <div class="cf-row-actions">
                            <a href="{{ route('cash-flow.show', $item) }}" class="row-action-btn view">Lihat</a>
                            <a href="{{ route('cash-flow.edit', $item) }}" class="row-action-btn edit">Edit</a>
                            <form method="POST" action="{{ route('cash-flow.destroy', $item) }}" onsubmit="return confirm('Hapus transaksi ini?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action-btn delete">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="cf-empty">Belum ada transaksi {{ strtolower($group['label']) }} untuk periode ini.</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

<div class="cf-final {{ $netCashFlow >= 0 ? 'positive' : 'negative' }}">
    <span class="cf-final-label">{{ $netCashFlow >= 0 ? 'Kenaikan Kas Bersih' : 'Penurunan Kas Bersih' }}</span>
    <span class="cf-final-value">Rp{{ number_format(abs($netCashFlow), 0, ',', '.') }}</span>
</div>
</x-app-layout>