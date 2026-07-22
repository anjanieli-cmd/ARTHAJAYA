<x-app-layout>
    <x-slot name="title">Klien</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </symbol>
            <symbol id="ic-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .clients-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .clients-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        .clients-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== HEADER ===== */
        .page-head{
            display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:28px;
        }
        .page-head-left{ flex:1; min-width:200px; }
        .page-head h1{
            font-size:28px; font-weight:700; margin:0 0 4px; letter-spacing:-.02em;
            background:linear-gradient(135deg, var(--text) 55%, var(--accent)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
        }
        .page-head p{ font-size:14px; color:var(--text-muted); margin:0; }

        .head-actions{ display:flex; gap:10px; flex-wrap:wrap; }

        /* ===== BUTTONS ===== */
        .btn{
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:11px 22px; border-radius:var(--radius-sm); font-size:13.5px; font-weight:600;
            cursor:pointer; border:none; transition:all .22s cubic-bezier(.16,1,.3,1);
            white-space:nowrap; text-decoration:none; position:relative; overflow:hidden;
        }
        .btn .icon{ width:16px; height:16px; flex-shrink:0; }
        .btn-primary{
            background:linear-gradient(135deg, var(--accent), var(--accent-dim));
            color:#052117; box-shadow:0 4px 18px var(--accent-glow);
        }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 28px var(--accent-glow); }
        .btn-primary::after{
            content:''; position:absolute; top:-50%; left:-50%; width:200%; height:200%;
            background:linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform:rotate(45deg) translateX(-100%); transition:transform .6s ease;
        }
        .btn-primary:hover::after{ transform:rotate(45deg) translateX(100%); }
        .btn-outline{
            background:var(--surface); border:1px solid var(--border); color:var(--text);
        }
        .btn-outline:hover{
            background:var(--surface-strong); border-color:var(--border-hover); transform:translateY(-2px);
        }
        .btn-sm{ padding:8px 14px; font-size:12.5px; }
        .btn-danger-ghost{ background:none; color:var(--danger); }
        .btn-danger-ghost:hover{ background:rgba(var(--danger-rgb),0.1); }

        /* ===== STAT CARDS ===== */
        .stat-row{
            display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;
        }
        .stat-card{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md);
            padding:20px 22px; position:relative; overflow:hidden; transition:all .25s ease;
        }
        .stat-card::before{
            content:''; position:absolute; top:0; left:0; right:0; height:2px;
            background:linear-gradient(90deg, transparent, currentColor, transparent);
            opacity:0; transition:opacity .3s ease;
        }
        .stat-card:hover{ transform:translateY(-3px); border-color:var(--border-hover); }
        .stat-card:hover::before{ opacity:.6; }
        .stat-card .sk{
            display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;
        }
        .stat-card .sk-label{
            font-size:11.5px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.06em; font-weight:600;
        }
        .stat-icon{
            width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .stat-icon .icon{ width:16px; height:16px; }
        .stat-card.c-emerald{ color:var(--emerald); }
        .stat-card.c-emerald .stat-icon{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .stat-card.c-info{ color:var(--info); }
        .stat-card.c-info .stat-icon{ background:rgba(var(--info-rgb),.14); color:var(--info); }
        .stat-card.c-warning{ color:var(--warning); }
        .stat-card.c-warning .stat-icon{ background:rgba(var(--warning-rgb),.14); color:var(--warning); }
        .stat-card .sv{
            font-family:'Space Grotesk', sans-serif; font-size:23px; font-weight:700; letter-spacing:-.01em;
            color:var(--text);
        }
        .stat-card .sc{ font-size:12px; color:var(--text-faint); margin-top:5px; }

        /* ===== FILTER BAR ===== */
        .filter-bar{
            display:flex; align-items:center; gap:12px; margin-bottom:18px; flex-wrap:wrap;
            background:var(--surface); padding:16px 20px; border-radius:var(--radius-md);
            border:1px solid var(--border);
        }
        .filter-bar form{
            display:flex; align-items:center; gap:12px; flex-wrap:wrap; width:100%;
        }
        .search-wrap{
            position:relative; flex:1; min-width:220px;
        }
        .search-wrap .icon{
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:var(--text-muted); pointer-events:none;
        }
        .filter-bar input[type=text]{
            width:100%; padding:10px 16px 10px 42px; border-radius:var(--radius-sm);
            background:var(--surface-hover); border:1px solid var(--border);
            color:var(--text); font-size:13px; outline:none;
            transition:border-color .15s ease, box-shadow .15s ease;
        }
        .filter-bar input[type=text]:focus{
            border-color:var(--accent); background:var(--surface);
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1);
        }
        .filter-bar input[type=text]::placeholder{ color:var(--text-muted); }

        .filter-actions{ display:flex; gap:8px; align-items:center; }

        /* ===== TABLE ===== */
        .table-card{
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius-lg); overflow:hidden;
            box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .table-scroll{ overflow-x:auto; }
        table{ width:100%; border-collapse:collapse; min-width:860px; }
        thead th{
            text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-faint); font-weight:700; padding:15px 18px;
            border-bottom:2px solid var(--border); white-space:nowrap;
            background:var(--surface-hover);
        }
        tbody tr{ border-bottom:1px solid var(--border); transition:background .18s ease; position:relative; }
        tbody tr:last-child{ border-bottom:none; }
        tbody tr:hover{ background:var(--surface-strong); }
        tbody tr.row-accent td:first-child{
            box-shadow: inset 3px 0 0 0 var(--row-color, transparent);
        }
        tbody td{ padding:15px 18px; font-size:13.5px; vertical-align:middle; }

        .client-cell{ display:flex; align-items:center; gap:12px; }
        .client-avatar{
            width:38px; height:38px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk', sans-serif; font-size:14px; font-weight:700; color:#fff; flex-shrink:0;
        }
        .client-name{ font-weight:600; font-size:13.5px; color:var(--text); }
        .client-sub{ font-size:11.5px; color:var(--text-faint); margin-top:1px; }
        .client-email{ color:var(--text-mute); font-size:13px; display:flex; align-items:center; gap:6px; }
        .client-email .icon{ width:14px; height:14px; color:var(--text-muted); }
        .client-phone{ color:var(--text-mute); font-size:13px; display:flex; align-items:center; gap:6px; }
        .client-phone .icon{ width:14px; height:14px; color:var(--text-muted); }
        .amount-cell{
            font-family:'Space Grotesk', sans-serif; font-weight:700; color:var(--text);
        }

        /* ===== ROW ACTIONS ===== */
        .row-actions{
            display:flex; align-items:center; gap:6px; justify-content:flex-end;
        }
        .icon-action{
            width:32px; height:32px; border-radius:9px;
            display:inline-flex; align-items:center; justify-content:center;
            background:var(--surface); border:1px solid var(--border); color:var(--text-faint);
            cursor:pointer; transition:all .18s ease; position:relative; text-decoration:none;
        }
        .icon-action .icon{ width:15px; height:15px; }
        .icon-action:hover{ transform:translateY(-2px); }
        .icon-action.view:hover{
            background:var(--accent-soft); border-color:var(--accent); color:var(--accent);
        }
        .icon-action.edit:hover{
            background:rgba(var(--info-rgb),.14); border-color:var(--info); color:var(--info);
        }
        .icon-action.delete:hover{
            background:rgba(var(--danger-rgb),.14); border-color:var(--danger); color:var(--danger);
        }

        .icon-action[data-tip]::after{
            content:attr(data-tip); position:absolute; bottom:calc(100% + 8px); left:50%;
            transform:translateX(-50%) translateY(4px);
            background:var(--surface); color:var(--text); font-size:11px; font-weight:600;
            padding:5px 9px; border-radius:7px; white-space:nowrap;
            opacity:0; visibility:hidden; transition:all .16s ease;
            pointer-events:none; box-shadow:0 6px 18px rgba(0,0,0,.35); border:1px solid var(--border);
        }
        .icon-action[data-tip]::before{
            content:''; position:absolute; bottom:calc(100% + 3px); left:50%; transform:translateX(-50%);
            border:5px solid transparent; border-top-color:var(--surface);
            opacity:0; visibility:hidden; transition:all .16s ease;
        }
        .icon-action[data-tip]:hover::after,
        .icon-action[data-tip]:hover::before{
            opacity:1; visibility:visible; transform:translateX(-50%) translateY(0);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state{ text-align:center; padding:64px 30px; }
        .empty-ic{
            width:60px; height:60px; border-radius:16px;
            background:var(--accent-soft); border:1px solid var(--accent-glow);
            display:flex; align-items:center; justify-content:center;
            color:var(--accent); margin:0 auto 18px;
        }
        .empty-ic .icon{ width:26px; height:26px; }
        .empty-state h3{
            font-family:'Space Grotesk', sans-serif; font-size:17px;
            margin-bottom:6px; color:var(--text);
        }
        .empty-state p{ font-size:13.5px; color:var(--text-mute); max-width:340px; margin:0 auto 22px; }

        /* ===== PAGINATION ===== */
        .pagination-bar{
            display:flex; align-items:center; justify-content:space-between;
            padding:16px 18px; border-top:1px solid var(--border);
            flex-wrap:wrap; gap:12px;
        }
        .pg-info{ font-size:12.5px; color:var(--text-faint); }
        .pagination-bar nav{
            display:flex; gap:4px;
        }
        .pagination-bar nav a,
        .pagination-bar nav span{
            padding:6px 14px; border-radius:8px; font-size:13px;
            color:var(--text-secondary); text-decoration:none; transition:all .2s ease;
        }
        .pagination-bar nav a:hover{
            background:var(--surface-hover); color:var(--text);
        }
        .pagination-bar nav .active{
            background:var(--accent); color:#052117; font-weight:600;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px){ .stat-row{ grid-template-columns:repeat(2,1fr); } }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .stat-row{ grid-template-columns:1fr 1fr; gap:12px; }
            .stat-card .sv{ font-size:19px; }
            .filter-bar form{ flex-direction:column; align-items:stretch; }
            .search-wrap{ min-width:unset; }
            .filter-actions{ justify-content:stretch; }
            .filter-actions .btn{ flex:1; }
            .pagination-bar{ flex-direction:column; align-items:center; text-align:center; }
        }
        @media (max-width: 480px){
            .stat-row{ grid-template-columns:1fr; }
            .page-head h1{ font-size:22px; }
            .row-actions{ gap:2px; }
            .icon-action{ width:30px; height:30px; }
            .icon-action .icon{ width:14px; height:14px; }
        }
    </style>

    <div class="clients-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>Daftar Klien</h1>
                <p>Kelola semua klien yang terdaftar di {{ $company->name ?? 'perusahaanmu' }}.</p>
            </div>
            <div class="head-actions">
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Klien
                </a>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="stat-row">
            <div class="stat-card c-emerald animate-in" style="animation-delay:.10s;">
                <div class="sk">
                    <span class="sk-label">Total Klien</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-users"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total_count'] ?? 0 }}</div>
                <div class="sc">Klien terdaftar</div>
            </div>
            <div class="stat-card c-info animate-in" style="animation-delay:.15s;">
                <div class="sk">
                    <span class="sk-label">Ada Transaksi</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-file-text"/></svg></span>
                </div>
                <div class="sv">{{ $stats['with_invoices_count'] ?? 0 }}</div>
                <div class="sc">Pernah dibuatkan faktur</div>
            </div>
            <div class="stat-card c-warning animate-in" style="animation-delay:.20s;">
                <div class="sk">
                    <span class="sk-label">Piutang Berjalan</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-alert-triangle"/></svg></span>
                </div>
                <div class="sv mono">Rp{{ number_format($stats['outstanding_amount'] ?? 0, 0, ',', '.') }}</div>
                <div class="sc">Belum dibayar</div>
            </div>
            <div class="stat-card c-emerald animate-in" style="animation-delay:.25s;">
                <div class="sk">
                    <span class="sk-label">Klien Baru</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-activity"/></svg></span>
                </div>
                <div class="sv">{{ $stats['new_this_month'] ?? 0 }}</div>
                <div class="sc">Bulan ini</div>
            </div>
        </div>

        {{-- ===== FILTER ===== --}}
        <div class="filter-bar animate-in" style="animation-delay:.28s;">
            <form method="GET" action="{{ route('clients.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Cari nama klien, perusahaan, atau email..." autocomplete="off">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    @if(request()->anyFilled(['q']))
                        <a href="{{ route('clients.index') }}" class="btn btn-outline btn-sm">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="table-card animate-in" style="animation-delay:.32s;">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Klien</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th style="text-align:right;">Total Faktur</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            @php
                                $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                                $avColor = $colors[$loop->index % count($colors)];
                            @endphp
                            <tr>
                                <td>
                                    <div class="client-cell">
                                        <div class="client-avatar" style="background:{{ $avColor }};">
                                            {{ strtoupper(substr($client->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="client-name">{{ $client->name }}</div>
                                            @if($client->company_name)
                                                <div class="client-sub">{{ $client->company_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($client->email)
                                        <span class="client-email">
                                            <svg class="icon"><use href="#ic-mail"/></svg>
                                            {{ $client->email }}
                                        </span>
                                    @else
                                        <span style="color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($client->phone)
                                        <span class="client-phone">
                                            <svg class="icon"><use href="#ic-phone"/></svg>
                                            {{ $client->phone }}
                                        </span>
                                    @else
                                        <span style="color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td class="amount-cell" style="text-align:right;">
                                    {{ $client->invoices_count ?? 0 }}
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('clients.show', $client) }}" class="icon-action view" data-tip="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('clients.edit', $client) }}" class="icon-action edit" data-tip="Edit Klien">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Hapus klien ini?')" class="inline" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="icon-action delete" data-tip="Hapus">
                                                <svg class="icon"><use href="#ic-trash"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-ic">
                                            <svg class="icon"><use href="#ic-inbox"/></svg>
                                        </div>
                                        <h3>Belum ada klien</h3>
                                        <p>Klien yang kamu tambahkan akan muncul di sini. Mulai dengan menambahkan klien pertamamu.</p>
                                        <a href="{{ route('clients.create') }}" class="btn btn-primary">
                                            <svg class="icon"><use href="#ic-plus"/></svg>
                                            Tambah Klien Pertama
                                        </a>
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
                        {{ $clients->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // ===== LIVE SEARCH =====
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('filterForm');
            var searchInput = document.getElementById('searchInput');
            var submitTimeout = null;

            // Search: submit dengan debounce 300ms
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (submitTimeout) {
                        clearTimeout(submitTimeout);
                    }
                    submitTimeout = setTimeout(function() {
                        form.submit();
                    }, 300);
                });
            }
        });
    </script>
</x-app-layout>