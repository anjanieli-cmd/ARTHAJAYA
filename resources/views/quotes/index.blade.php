<x-app-layout>
    <x-slot name="title">Penawaran</x-slot>

    {{-- ===== SVG ICONS LENGKAP ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
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
            <symbol id="ic-chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
            </symbol>
            <symbol id="ic-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
        </defs>
    </svg>

    @php
        $statusLabels = [
            'draft' => 'Draft',
            'sent' => 'Terkirim',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'expired' => 'Kadaluwarsa',
        ];
        
        $statusMeta = [
            'draft' => ['label' => 'Draft', 'class' => 'st-draft'],
            'sent' => ['label' => 'Terkirim', 'class' => 'st-sent'],
            'accepted' => ['label' => 'Diterima', 'class' => 'st-accepted'],
            'rejected' => ['label' => 'Ditolak', 'class' => 'st-rejected'],
            'expired' => ['label' => 'Kadaluwarsa', 'class' => 'st-expired'],
        ];
    @endphp

    <style>
        .quotes-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .quotes-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        .quotes-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

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
        .stat-card.c-danger{ color:var(--danger); }
        .stat-card.c-danger .stat-icon{ background:rgba(var(--danger-rgb),.14); color:var(--danger); }
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

        .filter-bar select{
            padding:10px 38px 10px 16px; border-radius:var(--radius-sm);
            background:var(--surface-hover); border:1px solid var(--border);
            color:var(--text); font-size:13px; outline:none; min-width:180px;
            cursor:pointer; transition:border-color .15s ease, box-shadow .15s ease;
            appearance:none; -webkit-appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 12px center; background-size:12px;
            color-scheme:dark;
        }
        .filter-bar select:focus{
            border-color:var(--accent); background-color:var(--surface);
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1);
        }
        .filter-bar select:hover{ border-color:var(--border-hover); }
        .filter-bar select option{
            background-color:#1a1f2e; color:#e8edf5; padding:10px 14px; font-size:14px;
        }
        .filter-bar select option:checked,
        .filter-bar select option:hover{
            background-color:#0d2a1f; color:#34d399;
        }

        .filter-actions{ display:flex; gap:8px; align-items:center; }

        /* ===== TABLE ===== */
        .table-card{
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius-lg); overflow:hidden;
            box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .table-scroll{ overflow-x:auto; }
        table{ width:100%; border-collapse:collapse; min-width:960px; }
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

        .quote-no{
            font-family:'IBM Plex Mono', monospace; font-size:12.5px; color:var(--text);
            font-weight:600;
        }
        .client-cell{
            display:flex; align-items:center; gap:10px;
        }
        .client-avatar{
            width:34px; height:34px; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk', sans-serif; font-size:13px; font-weight:700; color:#fff; flex-shrink:0;
        }
        .client-name{ font-weight:600; font-size:13.5px; color:var(--text); }
        .client-sub{ font-size:11.5px; color:var(--text-faint); margin-top:1px; }
        .amount-cell{
            font-family:'Space Grotesk', sans-serif; font-weight:700; color:var(--text);
        }
        .date-cell{ color:var(--text-mute); font-size:13px; }

        /* ===== STATUS BADGE ===== */
        .status-badge{
            display:inline-flex; align-items:center; gap:6px;
            padding:5px 12px; border-radius:100px; font-size:11.5px; font-weight:700; letter-spacing:.01em;
        }
        .status-badge .sdot{ width:6px; height:6px; border-radius:50%; }
        .st-draft{ background:var(--surface-strong); color:var(--text-mute); }
        .st-draft .sdot{ background:var(--text-faint); }
        .st-sent{ background:rgba(var(--info-rgb),.14); color:var(--info); }
        .st-sent .sdot{ background:var(--info); }
        .st-accepted{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .st-accepted .sdot{ background:var(--emerald); }
        .st-rejected{ background:rgba(var(--danger-rgb),.14); color:var(--danger); }
        .st-rejected .sdot{ background:var(--danger); }
        .st-expired{ background:rgba(var(--warning-rgb),.14); color:var(--warning); }
        .st-expired .sdot{ background:var(--warning); animation:pulseGlow 1.6s ease-in-out infinite; }

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
            .filter-bar select{ min-width:unset; width:100%; }
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

    <div class="quotes-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>Daftar Penawaran</h1>
                <p>Kelola semua penawaran atau quotation yang telah dibuat untuk klien.</p>
            </div>
            <div class="head-actions">
                <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Buat Penawaran
                </a>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="stat-row">
            <div class="stat-card c-emerald animate-in" style="animation-delay:.10s;">
                <div class="sk">
                    <span class="sk-label">Total</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-file"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total_count'] ?? 0 }}</div>
                <div class="sc">Total penawaran</div>
            </div>
            <div class="stat-card c-info animate-in" style="animation-delay:.15s;">
                <div class="sk">
                    <span class="sk-label">Terkirim</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-send"/></svg></span>
                </div>
                <div class="sv">{{ $stats['sent_count'] ?? 0 }}</div>
                <div class="sc">Menunggu respon</div>
            </div>
            <div class="stat-card c-emerald animate-in" style="animation-delay:.20s;">
                <div class="sk">
                    <span class="sk-label">Diterima</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-check-circle"/></svg></span>
                </div>
                <div class="sv">{{ $stats['accepted_count'] ?? 0 }}</div>
                <div class="sc">Disetujui klien</div>
            </div>
            <div class="stat-card c-warning animate-in" style="animation-delay:.25s;">
                <div class="sk">
                    <span class="sk-label">Kadaluwarsa</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-alert-triangle"/></svg></span>
                </div>
                <div class="sv">{{ $stats['expired_count'] ?? 0 }}</div>
                <div class="sc">Melewati masa berlaku</div>
            </div>
        </div>

        {{-- ===== FILTER ===== --}}
        <div class="filter-bar animate-in" style="animation-delay:.28s;">
            <form method="GET" action="{{ route('quotes.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Cari nomor penawaran atau nama klien..." autocomplete="off">
                </div>
                <select name="status" id="statusSelect">
                    <option value="">Semua Status</option>
                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    @if(request()->anyFilled(['q','status']))
                        <a href="{{ route('quotes.index') }}" class="btn btn-outline btn-sm">Reset</a>
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
                            <th>No. Penawaran</th>
                            <th>Klien</th>
                            <th>Tanggal</th>
                            <th>Berlaku Sampai</th>
                            <th style="text-align:right;">Total</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $quote)
                            @php
                                $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                                $avColor = $colors[$loop->index % count($colors)];
                                $st = $statusMeta[$quote->status] ?? $statusMeta['draft'];
                            @endphp
                            <tr>
                                <td><span class="quote-no">{{ $quote->quote_number }}</span></td>
                                <td>
                                    <div class="client-cell">
                                        <div class="client-avatar" style="background:{{ $avColor }};">
                                            {{ strtoupper(substr($quote->client->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="client-name">{{ $quote->client->name ?? '—' }}</div>
                                            @if($quote->client->company_name ?? null)
                                                <div class="client-sub">{{ $quote->client->company_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="date-cell">{{ optional($quote->issue_date)->translatedFormat('d M Y') ?? '—' }}</td>
                                <td class="date-cell">{{ optional($quote->valid_until)->translatedFormat('d M Y') ?? '—' }}</td>
                                <td class="amount-cell" style="text-align:right;">
                                    Rp{{ number_format($quote->total ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="status-badge {{ $st['class'] }}">
                                        <span class="sdot"></span>
                                        {{ $st['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('quotes.show', $quote) }}" class="icon-action view" data-tip="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('quotes.edit', $quote) }}" class="icon-action edit" data-tip="Edit Penawaran">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <form action="{{ route('quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Hapus penawaran ini?')" class="inline" style="display:inline;">
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
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-ic">
                                            <svg class="icon"><use href="#ic-inbox"/></svg>
                                        </div>
                                        <h3>Belum ada penawaran</h3>
                                        <p>Buat penawaran pertama untuk klienmu sekarang!</p>
                                        <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                                            <svg class="icon"><use href="#ic-plus"/></svg>
                                            Buat Penawaran
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($quotes) && method_exists($quotes, 'total') && $quotes->total() > 0)
                <div class="pagination-bar">
                    <div class="pg-info">
                        Menampilkan {{ $quotes->firstItem() }}–{{ $quotes->lastItem() }} dari {{ $quotes->total() }} penawaran
                    </div>
                    <div>
                        {{ $quotes->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // ===== LIVE SEARCH & FILTER =====
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('filterForm');
            var searchInput = document.getElementById('searchInput');
            var statusSelect = document.getElementById('statusSelect');
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

            // Status: langsung submit saat berubah
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    if (submitTimeout) {
                        clearTimeout(submitTimeout);
                    }
                    form.submit();
                });
            }
        });
    </script>
</x-app-layout>