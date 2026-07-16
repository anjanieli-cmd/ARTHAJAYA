<x-app-layout>
    <x-slot name="title">Klien</x-slot>

<style>
    .page-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:26px; flex-wrap:wrap; }
    .page-head h1{ font-size:26px; margin-bottom:6px; }
    .page-head p{ font-size:14px; color:var(--text-mute); }
    .head-actions{ display:flex; gap:10px; }

    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; white-space:nowrap; }
    .btn .icon{ width:15px; height:15px; }
    .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
    .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 8px 26px rgba(var(--emerald-rgb),0.45); }
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); border-color:var(--border-hover); }
    .btn-sm{ padding:8px 14px; font-size:12.5px; }

    .stat-row{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:26px; }
    .stat-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:20px 22px; }
    .stat-card .sk{ display:flex; align-items:center; gap:8px; font-size:12.5px; color:var(--text-mute); margin-bottom:12px; }
    .stat-card .sk .icon{ width:14px; height:14px; }
    .stat-card .sv{ font-family:'Space Grotesk', sans-serif; font-size:24px; font-weight:600; }
    .stat-card .sc{ font-size:12px; color:var(--text-faint); margin-top:4px; }
    .stat-card.acc-emerald{ border-color: rgba(var(--emerald-rgb),0.25); }
    .stat-card.acc-emerald .sk{ color: var(--emerald); }
    .stat-card.acc-info .sk{ color: var(--info); }
    .stat-card.acc-warning .sk{ color: var(--warning); }
    .stat-card.acc-danger .sk{ color: var(--danger); }

    /* ===== FILTER BAR (samain kaya quotes) ===== */
    .filter-bar{
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .filter-bar input{
        padding: 10px 14px;
        border-radius: 12px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }
    .filter-bar input:focus{
        border-color: var(--border-hover);
        background: var(--surface-strong);
    }
    .filter-bar input{ flex: 1; min-width: 200px; }
    .flex{ display:flex; }
    .gap-2{ gap:8px; }
    .items-center{ align-items:center; }
    .w-full{ width:100%; }
    .min-w-200{ min-width:200px; }

    .table-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
    .table-scroll{ overflow-x:auto; }
    table{ width:100%; border-collapse:collapse; min-width:760px; }
    thead th{
        text-align:left; font-size:11.5px; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint);
        font-weight:600; padding:14px 18px; border-bottom:1px solid var(--border); white-space:nowrap;
    }
    tbody tr{ border-bottom:1px solid var(--border); transition: background .15s ease; }
    tbody tr:last-child{ border-bottom:none; }
    tbody tr:hover{ background:var(--surface-strong); }
    tbody td{ padding:14px 18px; font-size:13.5px; vertical-align:middle; }
    .client-cell{ display:flex; align-items:center; gap:10px; }
    .client-avatar{ width:34px; height:34px; border-radius:9px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:12.5px; font-weight:600; color:var(--text-mute); flex-shrink:0; }
    .client-name{ font-weight:600; font-size:13.5px; }
    .client-sub{ font-size:11.5px; color:var(--text-faint); }
    .mono{ font-family:'IBM Plex Mono', monospace; }
    .text-right{ text-align:right; }

    .empty-state{ text-align:center; padding:70px 30px; }
    .empty-ic{ width:64px; height:64px; border-radius:18px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-faint); margin:0 auto 18px; }
    .empty-ic .icon{ width:28px; height:28px; }
    .empty-state h3{ font-size:17px; margin-bottom:6px; }
    .empty-state p{ font-size:13.5px; color:var(--text-mute); max-width:340px; margin:0 auto 20px; }

    .pagination-bar{ display:flex; align-items:center; justify-content:space-between; padding:16px 18px; border-top:1px solid var(--border); flex-wrap:wrap; gap:12px; }
    .pg-info{ font-size:12.5px; color:var(--text-faint); }

    @media (max-width: 1100px){
        .stat-row{ grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width: 560px){
        .stat-row{ grid-template-columns:1fr; }
        .page-head{ flex-direction:column; }
        .head-actions{ width:100%; }
        .head-actions .btn{ flex:1; }
    }
</style>

{{-- ===== PAGE HEADER ===== --}}
<div class="page-head">
    <div>
        <h1>Daftar Klien</h1>
        <p>Kelola semua klien yang terdaftar di {{ $company->name ?? 'perusahaanmu' }}.</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('clients.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Tambah Klien</a>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="stat-row">
    <div class="stat-card acc-emerald">
        <div class="sk"><svg class="icon"><use href="#ic-users"/></svg> Total Klien</div>
        <div class="sv mono">{{ $stats['total_count'] ?? 0 }}</div>
        <div class="sc">Klien terdaftar</div>
    </div>
    <div class="stat-card acc-info">
        <div class="sk"><svg class="icon"><use href="#ic-invoice"/></svg> Ada Transaksi</div>
        <div class="sv mono">{{ $stats['with_invoices_count'] ?? 0 }}</div>
        <div class="sc">Pernah dibuatkan faktur</div>
    </div>
    <div class="stat-card acc-warning">
        <div class="sk"><svg class="icon"><use href="#ic-alert"/></svg> Piutang Berjalan</div>
        <div class="sv mono">Rp{{ number_format($stats['outstanding_amount'] ?? 0, 0, ',', '.') }}</div>
        <div class="sc">Belum dibayar</div>
    </div>
    <div class="stat-card acc-emerald">
        <div class="sk"><svg class="icon"><use href="#ic-activity"/></svg> Klien Baru</div>
        <div class="sv mono">{{ $stats['new_this_month'] ?? 0 }}</div>
        <div class="sc">Bulan ini</div>
    </div>
</div>

{{-- ===== FILTER (samain kaya quotes) ===== --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('clients.index') }}" class="flex items-center gap-2 w-full">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama klien, perusahaan, atau email..." class="min-w-200">
        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
        @if(request()->anyFilled(['q']))
            <a href="{{ route('clients.index') }}" class="btn btn-outline btn-sm">Reset</a>
        @endif
    </form>
</div>

{{-- ===== TABLE ===== --}}
<div class="table-card">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Nama Klien</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th class="text-right">Total Faktur</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td>
                        <div class="client-cell">
                            <div class="client-avatar">{{ strtoupper(substr($client->name ?? '?', 0, 1)) }}</div>
                            <div>
                                <div class="client-name">{{ $client->name }}</div>
                                @if($client->company_name)
                                    <div class="client-sub">{{ $client->company_name }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $client->email ?? '—' }}</td>
                    <td>{{ $client->phone ?? '—' }}</td>
                    <td class="text-right mono">{{ $client->invoices_count ?? 0 }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2" style="justify-content:flex-end;">
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Hapus klien ini?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm" style="color:var(--danger);">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                            <h3>Belum ada klien</h3>
                            <p>Klien yang kamu tambahkan akan muncul di sini. Mulai dengan menambahkan klien pertamamu.</p>
                            <a href="{{ route('clients.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Tambah Klien Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($clients) && method_exists($clients, 'total') && $clients->total() > 0)
        <div class="pagination-bar">
            <div class="pg-info">
                Menampilkan {{ $clients->firstItem() }}–{{ $clients->lastItem() }} dari {{ $clients->total() }} klien
            </div>
            <div>
                {{ $clients->onEachSide(1)->links('pagination::simple-default') }}
            </div>
        </div>
    @endif
</div>
</x-app-layout>