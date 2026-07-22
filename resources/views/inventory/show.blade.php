<x-app-layout>
    <x-slot name="title">Barang {{ $item->name }}</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
            <symbol id="ic-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>
            </symbol>
            <symbol id="ic-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16.5 9.4l-9-5.19M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-percent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>
            </symbol>
            <symbol id="ic-ruler" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 21H3v-7h18v7zM3 10h18v4H3zM3 6h18v4H3z"/>
            </symbol>
        </defs>
    </svg>

    @php
        $isLowStock = $item->is_low_stock ?? ($item->stock_quantity <= $item->reorder_level);
        $stockPercent = min(100, max(0, ($item->stock_quantity / ($item->reorder_level * 3)) * 100));
        $marginPercent = $item->cost_price > 0 ? round((($item->selling_price - $item->cost_price) / $item->cost_price) * 100) : 0;
    @endphp

    <style>
        .item-detail-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .item-detail-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        @keyframes expandWidth{ from{ width:0; } to{ width:var(--target-width); } }
        .item-detail-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== BREADCRUMB ===== */
        .breadcrumb{
            display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); margin-bottom:20px;
        }
        .breadcrumb a{ color:var(--text-secondary); text-decoration:none; transition:color .2s ease; }
        .breadcrumb a:hover{ color:var(--text); }
        .breadcrumb .sep{ color:var(--text-faint); }
        .breadcrumb .current{ color:var(--text); font-weight:600; }

        /* ===== HEADER ===== */
        .page-head{
            display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:28px;
        }
        .page-head-left{ flex:1; min-width:200px; }
        .page-head h1{
            font-size:28px; font-weight:700; margin:0 0 4px; letter-spacing:-.02em;
            display:flex; align-items:center; gap:12px; flex-wrap:wrap;
        }
        .page-head h1 .item-sku-badge{
            font-family:'IBM Plex Mono', monospace;
            background:var(--surface-hover); padding:2px 14px; border-radius:8px;
            font-size:16px; color:var(--text-secondary);
        }
        .page-head p{
            font-size:14px; color:var(--text-muted); margin:0;
            display:flex; align-items:center; gap:8px;
        }
        .page-head p .sep{ color:var(--text-faint); }

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
        .btn-danger{
            background:var(--danger); color:#fff; border:1px solid var(--danger);
        }
        .btn-danger:hover{
            background:var(--danger-hover); transform:translateY(-2px); box-shadow:0 8px 22px rgba(var(--danger-rgb),0.35);
        }
        .btn-sm{ padding:8px 16px; font-size:12.5px; }

        /* ===== MAIN CARD ===== */
        .main-card{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .main-card-header{
            padding:24px 32px; border-bottom:1px solid var(--border);
            display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;
        }
        .main-card-header .left{ display:flex; align-items:center; gap:14px; }
        .main-card-header .left .icon-wrap{
            width:44px; height:44px; border-radius:12px;
            background:var(--accent-soft); color:var(--accent);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .main-card-header .left .icon-wrap .icon{ width:20px; height:20px; }
        .main-card-header .left h2{
            font-size:16px; font-weight:600; color:var(--text); margin:0;
        }
        .main-card-header .left p{
            font-size:13px; color:var(--text-muted); margin:2px 0 0;
        }

        .main-card-body{ padding:32px; }

        /* ===== STATUS BADGE ===== */
        .status-badge{
            display:inline-flex; align-items:center; gap:8px;
            padding:6px 16px; border-radius:100px; font-size:12.5px; font-weight:700; letter-spacing:.02em;
        }
        .status-badge .sdot{
            width:8px; height:8px; border-radius:50%; flex-shrink:0;
        }
        .status-ok{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
        .status-ok .sdot{ background:var(--emerald); }
        .status-low{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
        .status-low .sdot{ background:var(--danger); animation:pulseGlow 1.6s ease-in-out infinite; }

        /* ===== STOCK SECTION ===== */
        .stock-section{
            display:flex; align-items:center; gap:32px; flex-wrap:wrap;
            padding:20px 24px; background:var(--surface-hover);
            border-radius:var(--radius-md); margin-bottom:24px;
        }
        .stock-item{ flex:1; min-width:120px; }
        .stock-item .label{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-faint); font-weight:600; margin-bottom:4px;
        }
        .stock-item .value{
            font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:700;
            color:var(--text);
        }
        .stock-item .value .unit{
            font-size:14px; font-weight:400; color:var(--text-muted);
        }
        .stock-bar-wrap{ flex:2; min-width:200px; }
        .stock-bar-wrap .bar-label{
            display:flex; justify-content:space-between; font-size:12px;
            color:var(--text-muted); margin-bottom:6px;
        }
        .stock-bar-track{
            height:8px; border-radius:100px; background:var(--surface-strong);
            overflow:hidden;
        }
        .stock-bar-fill{
            height:100%; border-radius:100px;
            background:linear-gradient(90deg, var(--accent-dim), var(--accent));
            transition:width .8s cubic-bezier(.16,1,.3,1);
            width:0;
        }
        .stock-bar-fill.low{
            background:linear-gradient(90deg, #b8443f, var(--danger));
        }
        .stock-bar-fill.animate{
            animation: expandWidth .8s cubic-bezier(.16,1,.3,1) forwards;
        }

        /* ===== AMOUNT HERO ===== */
        .amount-hero{
            font-family:'Space Grotesk', sans-serif; font-size:36px; font-weight:700;
            letter-spacing:-.02em; color:var(--text); margin:4px 0 2px;
        }
        .amount-hero .currency{ font-size:24px; color:var(--text-muted); margin-right:4px; }

        /* ===== DETAIL GRID ===== */
        .detail-grid{
            display:grid; grid-template-columns:repeat(3,1fr); gap:20px 28px; margin-top:24px;
        }
        .detail-item{
            padding:14px 16px; background:var(--surface-hover); border-radius:var(--radius-sm);
            border:1px solid var(--border); transition:all .2s ease;
        }
        .detail-item:hover{ border-color:var(--border-hover); }
        .detail-item .k{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-muted); font-weight:600; margin-bottom:4px;
            display:flex; align-items:center; gap:6px;
        }
        .detail-item .k .icon{ width:13px; height:13px; color:var(--text-muted); }
        .detail-item .v{
            font-size:14.5px; font-weight:600; color:var(--text);
        }
        .detail-item .v.mono{ font-family:'IBM Plex Mono', monospace; }
        .detail-item .v .sub{
            font-size:12px; font-weight:400; color:var(--text-muted);
        }
        .detail-item .v .highlight{
            color:var(--emerald); font-weight:700;
        }
        .detail-item .v .highlight.danger{
            color:var(--danger);
        }

        /* ===== DESCRIPTION ===== */
        .desc-section{ margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
        .desc-section .label{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-muted); font-weight:600; margin-bottom:8px;
            display:flex; align-items:center; gap:6px;
        }
        .desc-section .label .icon{ width:14px; height:14px; }
        .desc-box{
            background:var(--surface-hover); border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:16px 20px;
            font-size:14px; color:var(--text-secondary); line-height:1.7;
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
        .modal-ic{
            width:56px; height:56px; border-radius:50%;
            background:rgba(var(--danger-rgb),0.12); color:var(--danger);
            display:flex; align-items:center; justify-content:center; margin:0 auto 16px;
        }
        .modal-ic .icon{ width:26px; height:26px; }
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
            .detail-grid{ grid-template-columns:1fr 1fr; }
            .stock-section{ flex-direction:column; align-items:stretch; gap:16px; }
            .stock-item{ min-width:unset; }
            .amount-hero{ font-size:28px; }
        }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .main-card-header{ flex-direction:column; align-items:stretch; }
            .main-card-body{ padding:20px; }
            .detail-grid{ grid-template-columns:1fr; gap:12px; }
            .amount-hero{ font-size:24px; }
            .modal-box{ padding:24px 20px; }
            .page-head h1{ font-size:22px; flex-direction:column; align-items:flex-start; }
            .page-head h1 .item-sku-badge{ font-size:14px; }
        }
        @media (max-width: 480px){
            .main-card-header .left{ flex-wrap:wrap; }
            .stock-item .value{ font-size:18px; }
        }
    </style>

    <div class="item-detail-wrap">

        {{-- ===== BREADCRUMB ===== --}}
        <div class="breadcrumb animate-in" style="animation-delay:.02s;">
            <a href="{{ route('inventory.index') }}">Stok Barang</a>
            <span class="sep">›</span>
            <span class="current">{{ $item->name }}</span>
        </div>

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>
                    <span>Detail Barang</span>
                    <span class="item-sku-badge">{{ $item->sku }}</span>
                </h1>
                <p>
                    <svg class="icon" style="width:14px;height:14px;color:var(--text-muted);"><use href="#ic-tag"/></svg>
                    {{ $item->category ?? 'Tanpa Kategori' }}
                    @if($item->category)
                        <span class="sep">·</span>
                        @endif
                    {{ $item->unit ?? 'pcs' }}
                </p>
            </div>
            <div class="head-actions">
                <a href="{{ route('inventory.index') }}" class="btn btn-outline btn-sm">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <a href="{{ route('inventory.edit', $item) }}" class="btn btn-primary btn-sm">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
                <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('deleteModal').classList.add('open')">
                    <svg class="icon"><use href="#ic-trash"/></svg>
                    Hapus
                </button>
            </div>
        </div>

        {{-- ===== MAIN CARD ===== --}}
        <div class="main-card animate-in" style="animation-delay:.10s;">

            {{-- Card Header --}}
            <div class="main-card-header">
                <div class="left">
                    <div class="icon-wrap">
                        <svg class="icon"><use href="#ic-package"/></svg>
                    </div>
                    <div>
                        <h2>Informasi Stok</h2>
                        <p>Detail lengkap barang #{{ $item->sku }}</p>
                    </div>
                </div>
                <div>
                    <span class="status-badge {{ $isLowStock ? 'status-low' : 'status-ok' }}">
                        <span class="sdot"></span>
                        {{ $isLowStock ? 'Stok Menipis' : 'Stok Aman' }}
                    </span>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="main-card-body">

                {{-- Stock Section --}}
                <div class="stock-section">
                    <div class="stock-item">
                        <div class="label">Stok Saat Ini</div>
                        <div class="value">
                            {{ number_format($item->stock_quantity, 0, ',', '.') }}
                            <span class="unit">{{ $item->unit ?? 'pcs' }}</span>
                        </div>
                    </div>
                    <div class="stock-item">
                        <div class="label">Batas Reorder</div>
                        <div class="value">
                            {{ number_format($item->reorder_level, 0, ',', '.') }}
                            <span class="unit">{{ $item->unit ?? 'pcs' }}</span>
                        </div>
                    </div>
                    <div class="stock-bar-wrap">
                        <div class="bar-label">
                            <span>Level Stok</span>
                            <span>{{ round($stockPercent) }}%</span>
                        </div>
                        <div class="stock-bar-track">
                            <div class="stock-bar-fill {{ $isLowStock ? 'low' : '' }} animate" 
                                 style="--target-width: {{ $stockPercent }}%; width: {{ $stockPercent }}%;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Amount Hero --}}
                <div class="amount-hero">
                    <span class="currency">Rp</span>{{ number_format($item->stock_value ?? 0, 0, ',', '.') }}
                </div>
                <div style="font-size:12.5px; color:var(--text-faint); margin-top:-2px;">Total nilai stok saat ini</div>

                {{-- Detail Grid --}}
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-dollar"/></svg> Harga Pokok</div>
                        <div class="v mono">Rp{{ number_format($item->cost_price ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-dollar"/></svg> Harga Jual</div>
                        <div class="v mono">Rp{{ number_format($item->selling_price ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-percent"/></svg> Margin</div>
                        <div class="v">
                            <span class="{{ $marginPercent > 30 ? 'highlight' : ($marginPercent > 15 ? '' : 'highlight danger') }}">
                                {{ $marginPercent }}%
                            </span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-package"/></svg> Satuan</div>
                        <div class="v">{{ $item->unit ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-tag"/></svg> Kategori</div>
                        <div class="v">{{ $item->category ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-box"/></svg> SKU</div>
                        <div class="v mono">{{ $item->sku }}</div>
                    </div>
                </div>

                {{-- Description --}}
                @if($item->description)
                    <div class="desc-section">
                        <div class="label">
                            <svg class="icon"><use href="#ic-file-text"/></svg>
                            Deskripsi
                        </div>
                        <div class="desc-box">{{ $item->description }}</div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-ic">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
            </div>
            <h3>Hapus Barang Ini?</h3>
            <p>Barang <br><b>{{ $item->name }}</b></p>
            <p style="margin-top:4px;">akan dihapus permanen dan tidak bisa dikembalikan.</p>
            <div class="modal-warn">⚠️ Semua data stok yang terkait akan ikut terhapus.</div>
            <form method="POST" action="{{ route('inventory.destroy', $item) }}">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal').classList.remove('open')">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ===== Modal =====
        document.getElementById('deleteModal').addEventListener('click', function(e){
            if(e.target === this) this.classList.remove('open');
        });

        // ===== ESC =====
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape'){
                document.getElementById('deleteModal').classList.remove('open');
            }
        });

        // ===== Animate stock bar on load =====
        document.addEventListener('DOMContentLoaded', function() {
            var bars = document.querySelectorAll('.stock-bar-fill.animate');
            bars.forEach(function(bar) {
                var targetWidth = bar.style.getPropertyValue('--target-width');
                if (targetWidth) {
                    setTimeout(function() {
                        bar.style.width = targetWidth;
                    }, 100);
                }
            });
        });
    </script>
</x-app-layout>