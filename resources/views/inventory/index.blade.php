<x-app-layout>
    <x-slot name="title">Stok Barang</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
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
            <symbol id="ic-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>
            </symbol>
            <symbol id="ic-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16.5 9.4l-9-5.19M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .inventory-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .inventory-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        .inventory-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

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

        /* ===== STAT STRIP ===== */
        .stat-strip{
            display:flex; background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius-md); margin-bottom:24px; overflow:hidden;
        }
        .stat-item{
            flex:1; padding:20px 24px; border-right:1px solid var(--border);
            transition:all .2s ease;
        }
        .stat-item:last-child{ border-right:none; }
        .stat-item:hover{ background:var(--surface-hover); }
        .stat-item .k{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-faint); font-weight:600; margin-bottom:6px;
            display:flex; align-items:center; gap:6px;
        }
        .stat-item .k .icon{ width:14px; height:14px; color:var(--text-muted); }
        .stat-item .v{
            font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:700;
            color:var(--text);
        }
        .stat-item.warning .v{ color:var(--warning); }
        .stat-item.danger .v{ color:var(--danger); }
        .stat-item.success .v{ color:var(--emerald); }

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

        /* ===== CARD GRID ===== */
        .card-grid{
            display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));
            gap:18px; margin-bottom:20px;
        }
        .item-card{
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius-md); padding:22px;
            transition:all .25s cubic-bezier(.16,1,.3,1);
            display:flex; flex-direction:column;
        }
        .item-card:hover{
            border-color:var(--border-hover);
            transform:translateY(-4px);
            box-shadow:0 8px 30px rgba(0,0,0,0.12);
        }
        .item-card-top{
            display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;
        }
        .item-category{
            font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
            padding:4px 10px; border-radius:100px;
            background:var(--surface-hover); color:var(--text-muted);
        }
        .item-category.low{
            background:rgba(var(--danger-rgb),0.12); color:var(--danger);
            animation:pulseGlow 1.6s ease-in-out infinite;
        }
        .item-category .icon{ width:12px; height:12px; vertical-align:middle; margin-right:4px; }

        .item-name{
            font-size:16px; font-weight:600; color:var(--text); margin-bottom:2px;
        }
        .item-sku{
            font-family:'IBM Plex Mono', monospace; font-size:11.5px; color:var(--text-faint);
        }

        .stock-row{
            display:flex; align-items:baseline; gap:6px; margin:14px 0 6px;
        }
        .stock-number{
            font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700;
            color:var(--text);
        }
        .stock-unit{
            font-size:12px; color:var(--text-muted);
        }

        .bar-track{
            height:6px; border-radius:100px; background:var(--surface-hover);
            overflow:hidden; margin-bottom:14px;
        }
        .bar-fill{
            height:100%; border-radius:100px;
            background:linear-gradient(90deg, var(--accent-dim), var(--accent));
            transition:width .6s ease;
        }
        .bar-fill.low{
            background:linear-gradient(90deg, #b8443f, var(--danger));
        }

        .price-row{
            display:flex; justify-content:space-between; font-size:12px;
            color:var(--text-muted); padding:12px 0; border-top:1px solid var(--border);
            margin-top:auto;
        }
        .price-row b{
            color:var(--text); font-weight:600;
        }

        .card-actions{
            display:flex; gap:8px; margin-top:12px;
        }
        .card-actions a,
        .card-actions button{
            flex:1; text-align:center; padding:8px 0;
            border-radius:var(--radius-sm); font-size:12px; font-weight:600;
            border:1px solid var(--border); background:var(--surface-hover);
            color:var(--text); cursor:pointer; text-decoration:none;
            transition:all .15s ease;
            display:inline-flex; align-items:center; justify-content:center; gap:4px;
        }
        .card-actions a .icon,
        .card-actions button .icon{
            width:14px; height:14px;
        }
        .card-actions a:hover{
            border-color:var(--border-hover); background:var(--surface-strong);
        }
        .card-actions button.danger{
            color:var(--danger); border-color:rgba(var(--danger-rgb),0.2);
        }
        .card-actions button.danger:hover{
            background:rgba(var(--danger-rgb),0.08);
            border-color:rgba(var(--danger-rgb),0.3);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state{
            grid-column:1/-1; text-align:center; padding:70px 20px;
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
        @media (max-width: 700px){
            .stat-strip{ flex-direction:column; }
            .stat-item{ border-right:none; border-bottom:1px solid var(--border); }
            .stat-item:last-child{ border-bottom:none; }
            .stat-item .v{ font-size:18px; }
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .filter-bar form{ flex-direction:column; align-items:stretch; }
            .search-wrap{ min-width:unset; }
            .filter-bar select{ min-width:unset; width:100%; }
            .filter-actions{ justify-content:stretch; }
            .filter-actions .btn{ flex:1; }
            .card-grid{ grid-template-columns:1fr; }
            .pagination-bar{ flex-direction:column; align-items:center; text-align:center; }
            .modal-box{ padding:24px 20px; }
        }
        @media (max-width: 480px){
            .page-head h1{ font-size:22px; }
            .stock-number{ font-size:22px; }
        }
    </style>

    <div class="inventory-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>Stok Barang</h1>
                <p>Pantau jumlah stok, nilai barang, dan barang yang perlu segera diisi ulang.</p>
            </div>
            <div class="head-actions">
                <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Barang
                </a>
            </div>
        </div>

        {{-- ===== STAT STRIP ===== --}}
        <div class="stat-strip animate-in" style="animation-delay:.10s;">
            <div class="stat-item success">
                <div class="k">
                    <svg class="icon"><use href="#ic-package"/></svg>
                    Total SKU
                </div>
                <div class="v">{{ $stats['total_sku'] ?? 0 }}</div>
            </div>
            <div class="stat-item">
                <div class="k">
                    <svg class="icon"><use href="#ic-dollar"/></svg>
                    Total Nilai Stok
                </div>
                <div class="v mono">Rp{{ number_format($stats['total_value'] ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="stat-item {{ ($stats['low_stock'] ?? 0) > 0 ? 'danger' : '' }}">
                <div class="k">
                    <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                    Stok Menipis
                </div>
                <div class="v">{{ $stats['low_stock'] ?? 0 }} barang</div>
            </div>
        </div>

        {{-- ===== FILTER ===== --}}
        <div class="filter-bar animate-in" style="animation-delay:.15s;">
            <form method="GET" action="{{ route('inventory.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Cari nama atau SKU barang..." autocomplete="off">
                </div>
                <select name="category" id="categorySelect">
                    <option value="">Semua Kategori</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    @if(request()->anyFilled(['q','category']))
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline btn-sm">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ===== CARD GRID ===== --}}
        <div class="card-grid animate-in" style="animation-delay:.20s;">
            @forelse($items as $item)
                <div class="item-card">
                    <div class="item-card-top">
                        <span class="item-category {{ $item->is_low_stock ? 'low' : '' }}">
                            @if($item->is_low_stock)
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                            @endif
                            {{ $item->is_low_stock ? 'Stok Menipis' : ($item->category ?? 'Umum') }}
                        </span>
                    </div>
                    <div class="item-name">{{ $item->name }}</div>
                    <div class="item-sku">{{ $item->sku }}</div>

                    <div class="stock-row">
                        <span class="stock-number">{{ $item->stock_quantity }}</span>
                        <span class="stock-unit">{{ $item->unit ?? 'pcs' }}</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill {{ $item->is_low_stock ? 'low' : '' }}" style="width:{{ $item->stock_percent ?? 0 }}%"></div>
                    </div>

                    <div class="price-row">
                        <span>Harga Pokok: <b>Rp{{ number_format($item->cost_price ?? 0, 0, ',', '.') }}</b></span>
                        <span>Harga Jual: <b>Rp{{ number_format($item->selling_price ?? 0, 0, ',', '.') }}</b></span>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('inventory.edit', $item) }}">
                            <svg class="icon"><use href="#ic-edit"/></svg>
                            Edit
                        </a>
                        <button type="button" class="danger" onclick="openDeleteModal('{{ $item->id }}', '{{ $item->name }}')">
                            <svg class="icon"><use href="#ic-trash"/></svg>
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg class="icon"><use href="#ic-inbox"/></svg>
                    </div>
                    <h3>Belum ada barang</h3>
                    <p>Tambahkan barang pertama untuk mulai melacak stok inventaris.</p>
                    <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                        <svg class="icon"><use href="#ic-plus"/></svg>
                        Tambah Barang Pertama
                    </a>
                </div>
            @endforelse
        </div>

        {{-- ===== PAGINATION ===== --}}
        @if(isset($items) && method_exists($items, 'total') && $items->total() > 0)
            <div class="pagination-bar">
                <div class="pg-info">
                    Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ $items->total() }} barang
                </div>
                <div>
                    {{ $items->onEachSide(1)->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
            </div>
            <h3>Hapus Barang Ini?</h3>
            <p>Barang <br><b id="deleteItemName">—</b></p>
            <p style="margin-top:4px;">akan dihapus permanen dari inventaris.</p>
            <div class="modal-warn">⚠️ Data stok yang terhapus tidak bisa dikembalikan.</div>
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
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').action = '{{ url("inventory") }}/' + id;
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
            var categorySelect = document.getElementById('categorySelect');
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

            // Category: langsung submit saat berubah
            if (categorySelect) {
                categorySelect.addEventListener('change', function() {
                    if (submitTimeout) {
                        clearTimeout(submitTimeout);
                    }
                    form.submit();
                });
            }
        });
    </script>
</x-app-layout>