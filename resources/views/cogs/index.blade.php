<x-app-layout>
    <x-slot name="title">Harga Pokok Penjualan</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
            <symbol id="ic-trending-up" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
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
            <symbol id="ic-chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cogs-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .cogs-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        .cogs-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

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
        .btn-danger{ background:var(--danger); color:#fff; }
        .btn-danger:hover{ background:var(--danger-hover); transform:translateY(-2px); }
        .btn-sm{ padding:8px 14px; font-size:12.5px; }

        /* ===== STAT CARDS ===== */
        .stat-row{
            display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;
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
            width:40px; height:40px; border-radius:50%;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .stat-icon .icon{ width:18px; height:18px; }
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
            display:flex; align-items:center; gap:12px; margin-bottom:20px; flex-wrap:wrap;
            background:var(--surface); padding:16px 20px; border-radius:var(--radius-md);
            border:1px solid var(--border);
        }
        .filter-bar form{
            display:flex; align-items:center; gap:12px; flex-wrap:wrap; width:100%;
        }
        .search-wrap{
            position:relative; flex:1; min-width:200px;
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

        .filter-bar input[type=month]{
            padding:10px 14px; border-radius:var(--radius-sm);
            background:var(--surface-hover); border:1px solid var(--border);
            color:var(--text); font-size:13px; outline:none;
            min-width:170px; transition:all .2s ease;
        }
        .filter-bar input[type=month]:focus{
            border-color:var(--accent); background:var(--surface);
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1);
        }

        .filter-actions{ display:flex; gap:8px; align-items:center; }

        /* ===== TIMELINE ===== */
        .timeline{ position:relative; padding-left:6px; }
        .day-group{ margin-bottom:28px; }
        .day-label{
            display:flex; align-items:center; gap:12px; margin-bottom:14px;
        }
        .day-dot{
            width:12px; height:12px; border-radius:50%;
            background:var(--accent); flex-shrink:0;
            box-shadow:0 0 0 4px rgba(var(--emerald-rgb),0.15);
        }
        .day-label b{
            font-size:14px; font-weight:600; color:var(--text);
        }
        .day-label span{
            font-size:12px; color:var(--text-faint);
        }

        .entries{
            margin-left:6px; padding-left:24px;
            border-left:2px solid var(--border);
            display:flex; flex-direction:column; gap:10px;
        }
        .entry{
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:14px 18px;
            display:flex; align-items:center; gap:14px;
            position:relative; transition:all .2s ease;
        }
        .entry:hover{
            border-color:var(--border-hover);
            transform:translateX(4px);
        }
        .entry::before{
            content:''; position:absolute; left:-28px; top:50%;
            transform:translateY(-50%);
            width:10px; height:10px; border-radius:50%;
            background:var(--text-faint); border:2px solid var(--surface);
        }
        .entry-main{ flex:1; min-width:0; }
        .entry-name{
            font-size:13.5px; font-weight:600; color:var(--text);
            margin-bottom:2px;
        }
        .entry-meta{
            font-size:11.5px; color:var(--text-faint);
        }
        .entry-total{
            font-family:'IBM Plex Mono', monospace; font-size:14px; font-weight:700;
            color:var(--accent); white-space:nowrap;
        }
        .entry-actions{
            display:flex; gap:4px; flex-shrink:0;
        }
        .icon-action-sm{
            width:30px; height:30px; border-radius:8px;
            display:inline-flex; align-items:center; justify-content:center;
            background:transparent; border:1px solid transparent;
            color:var(--text-faint); cursor:pointer; text-decoration:none;
            transition:all .15s ease;
        }
        .icon-action-sm .icon{ width:14px; height:14px; }
        .icon-action-sm:hover{
            background:var(--surface-strong); color:var(--text);
            border-color:var(--border);
        }
        .icon-action-sm.danger:hover{
            color:var(--danger); background:rgba(var(--danger-rgb),0.08);
            border-color:rgba(var(--danger-rgb),0.2);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state{
            text-align:center; padding:70px 20px;
        }
        .empty-icon{
            width:64px; height:64px; border-radius:16px;
            background:var(--accent-soft); border:1px solid var(--accent-glow);
            display:flex; align-items:center; justify-content:center;
            color:var(--accent); margin:0 auto 18px;
        }
        .empty-icon .icon{ width:28px; height:28px; }
        .empty-state h3{
            font-family:'Space Grotesk', sans-serif; font-size:17px;
            margin-bottom:6px; color:var(--text);
        }
        .empty-state p{
            font-size:13.5px; color:var(--text-mute); max-width:340px; margin:0 auto 20px;
        }

        /* ===== PAGINATION ===== */
        .pagination-bar{
            display:flex; align-items:center; justify-content:space-between;
            padding:16px 4px; border-top:1px solid var(--border);
            flex-wrap:wrap; gap:12px; margin-top:12px;
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

        /* ===== MODAL ===== */
        .modal-overlay{
            position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(8px);
            z-index:999; display:none; align-items:center; justify-content:center; padding:20px;
        }
        .modal-overlay.open{ display:flex; }
        @keyframes modalSlideUp{
            from{ opacity:0; transform:translateY(24px) scale(.96);}
            to{ opacity:1; transform:translateY(0) scale(1);}
        }
        .modal-box{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            padding:32px 36px; max-width:420px; width:100%;
            box-shadow:0 40px 90px rgba(0,0,0,0.5);
            animation:modalSlideUp .3s cubic-bezier(.16,1,.3,1); text-align:center;
        }
        .modal-icon{
            width:56px; height:56px; border-radius:50%;
            background:rgba(var(--danger-rgb),0.12); color:var(--danger);
            display:flex; align-items:center; justify-content:center; margin:0 auto 16px;
        }
        .modal-icon .icon{ width:26px; height:26px; }
        .modal-box h3{
            font-size:18px; font-weight:700; margin-bottom:8px; color:var(--text);
        }
        .modal-box p{
            font-size:13.5px; color:var(--text-muted); margin-bottom:6px; line-height:1.6;
        }
        .modal-box p b{
            color:var(--text); font-family:'IBM Plex Mono', monospace;
            background:var(--surface-hover); padding:2px 12px; border-radius:6px; display:inline-block; margin-top:4px;
        }
        .modal-warn{
            font-size:12.5px; color:var(--danger); font-weight:600;
            margin-top:14px; padding:10px 16px;
            background:rgba(var(--danger-rgb),0.08); border-radius:10px; display:inline-block;
        }
        .modal-actions{ display:flex; gap:10px; justify-content:center; margin-top:22px; }
        .modal-actions .btn{ flex:1; justify-content:center; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px){ 
            .stat-row{ grid-template-columns:1fr 1fr; }
        }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .stat-row{ grid-template-columns:1fr; }
            .filter-bar form{ flex-direction:column; align-items:stretch; }
            .search-wrap{ min-width:unset; }
            .filter-bar input[type=month]{ min-width:unset; width:100%; }
            .filter-actions{ justify-content:stretch; }
            .filter-actions .btn{ flex:1; }
            .entry{ flex-wrap:wrap; gap:8px; }
            .entry-total{ margin-left:auto; }
            .pagination-bar{ flex-direction:column; align-items:center; text-align:center; }
            .modal-box{ padding:24px 20px; }
            .page-head h1{ font-size:22px; }
        }
        @media (max-width: 480px){
            .entry-actions{ margin-left:auto; }
        }
    </style>

    <div class="cogs-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>Harga Pokok Penjualan</h1>
                <p>Riwayat HPP dari setiap transaksi penjualan, diurutkan berdasarkan tanggal.</p>
            </div>
            <div class="head-actions">
                <a href="{{ route('cogs.create') }}" class="btn btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Catat HPP
                </a>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="stat-row animate-in" style="animation-delay:.10s;">
            <div class="stat-card c-emerald">
                <div class="sk">
                    <span class="sk-label">Total HPP Bulan Ini</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-dollar"/></svg></span>
                </div>
                <div class="sv mono">Rp{{ number_format($stats['total_cogs_month'] ?? 0, 0, ',', '.') }}</div>
                <div class="sc">Total biaya pokok penjualan</div>
            </div>
            <div class="stat-card c-info">
                <div class="sk">
                    <span class="sk-label">Unit Terjual Bulan Ini</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-box"/></svg></span>
                </div>
                <div class="sv">{{ number_format($stats['total_qty_month'] ?? 0, 0, ',', '.') }} unit</div>
                <div class="sc">Total unit terjual</div>
            </div>
            <div class="stat-card c-warning">
                <div class="sk">
                    <span class="sk-label">Rata-rata Biaya / Unit</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-trending-up"/></svg></span>
                </div>
                <div class="sv mono">Rp{{ number_format($stats['avg_unit_cost'] ?? 0, 0, ',', '.') }}</div>
                <div class="sc">Rata-rata per unit</div>
            </div>
        </div>

        {{-- ===== FILTER ===== --}}
        <div class="filter-bar animate-in" style="animation-delay:.15s;">
            <form method="GET" action="{{ route('cogs.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Cari nama barang..." autocomplete="off">
                </div>
                <input type="month" name="month" id="monthInput" value="{{ request('month') }}" placeholder="Pilih bulan">
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    @if(request()->anyFilled(['q','month']))
                        <a href="{{ route('cogs.index') }}" class="btn btn-outline btn-sm">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ===== TIMELINE ===== --}}
        @if(isset($entries) && $entries->count() > 0)
            <div class="timeline animate-in" style="animation-delay:.20s;">
                @foreach($groupedEntries ?? [] as $date => $dayEntries)
                    <div class="day-group">
                        <div class="day-label">
                            <span class="day-dot"></span>
                            <b>{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</b>
                            <span>{{ $dayEntries->count() }} transaksi</span>
                        </div>
                        <div class="entries">
                            @foreach($dayEntries as $entry)
                                <div class="entry">
                                    <div class="entry-main">
                                        <div class="entry-name">{{ $entry->item_name }}</div>
                                        <div class="entry-meta">{{ $entry->quantity_sold }} unit × Rp{{ number_format($entry->unit_cost, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="entry-total">Rp{{ number_format($entry->total_cogs, 0, ',', '.') }}</div>
                                    <div class="entry-actions">
                                        <a href="{{ route('cogs.edit', $entry) }}" class="icon-action-sm" title="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="icon-action-sm danger" title="Hapus" onclick="openDeleteModal('{{ $entry->id }}', '{{ $entry->item_name }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ===== PAGINATION ===== --}}
            @if(method_exists($entries, 'total') && $entries->total() > 0)
                <div class="pagination-bar">
                    <div class="pg-info">
                        Menampilkan {{ $entries->firstItem() }}–{{ $entries->lastItem() }} dari {{ $entries->total() }} transaksi
                    </div>
                    <div>
                        {{ $entries->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="empty-state animate-in" style="animation-delay:.20s;">
                <div class="empty-icon">
                    <svg class="icon"><use href="#ic-inbox"/></svg>
                </div>
                <h3>Belum ada catatan HPP</h3>
                <p>Catat transaksi penjualan pertama untuk mulai melacak harga pokok penjualan.</p>
                <a href="{{ route('cogs.create') }}" class="btn btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Catat HPP Pertama
                </a>
            </div>
        @endif
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
            </div>
            <h3>Hapus Catatan Ini?</h3>
            <p>Catatan HPP untuk <br><b id="deleteEntryName">—</b></p>
            <p style="margin-top:4px;">akan dihapus permanen dan tidak bisa dikembalikan.</p>
            <div class="modal-warn">⚠️ Stok barang akan dikembalikan jika terhubung ke inventaris.</div>
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ===== DELETE MODAL =====
        function openDeleteModal(id, name){
            document.getElementById('deleteEntryName').textContent = name;
            document.getElementById('deleteForm').action = '{{ url("cogs") }}/' + id;
            document.getElementById('deleteModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal(){
            document.getElementById('deleteModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        document.getElementById('deleteModal').addEventListener('click', function(e){
            if(e.target === this) closeDeleteModal();
        });

        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape') closeDeleteModal();
        });

        // ===== LIVE SEARCH & FILTER =====
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('filterForm');
            var searchInput = document.getElementById('searchInput');
            var monthInput = document.getElementById('monthInput');
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

            // Month: langsung submit saat berubah
            if (monthInput) {
                monthInput.addEventListener('change', function() {
                    if (submitTimeout) {
                        clearTimeout(submitTimeout);
                    }
                    form.submit();
                });
            }
        });
    </script>
</x-app-layout>