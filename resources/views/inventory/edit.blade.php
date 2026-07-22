<x-app-layout>
    <x-slot name="title">Edit Barang</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-save" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
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
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </symbol>
            <symbol id="ic-percent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>
            </symbol>
            <symbol id="ic-ruler" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 21H3v-7h18v7zM3 10h18v4H3zM3 6h18v4H3z"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .item-edit-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .item-edit-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        .item-edit-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

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
            font-size:18px; color:var(--text-secondary);
        }
        .page-head p{
            font-size:14px; color:var(--text-muted); margin:0;
        }

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
        .btn-sm{ padding:8px 16px; font-size:12.5px; }

        /* ===== LAYOUT ===== */
        .form-layout{
            display:grid; grid-template-columns:1.6fr 1fr; gap:24px; align-items:start;
        }

        /* ===== FORM PANEL ===== */
        .form-panel{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .form-panel-header{
            padding:24px 32px; border-bottom:1px solid var(--border);
            display:flex; align-items:center; gap:12px;
        }
        .form-panel-header .icon-wrap{
            width:40px; height:40px; border-radius:12px;
            background:var(--accent-soft); color:var(--accent);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .form-panel-header .icon-wrap .icon{ width:20px; height:20px; }
        .form-panel-header h2{
            font-size:16px; font-weight:600; color:var(--text); margin:0;
        }
        .form-panel-header p{
            font-size:13px; color:var(--text-muted); margin:2px 0 0;
        }

        .form-body{ padding:32px; }

        /* ===== INFO BOX ===== */
        .info-box{
            display:flex; align-items:center; justify-content:space-between;
            background:var(--surface-hover); border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:14px 20px; margin-bottom:24px;
            flex-wrap:wrap; gap:10px;
        }
        .info-box .left{ display:flex; align-items:center; gap:12px; }
        .info-box .left .icon{
            width:18px; height:18px; color:var(--text-muted);
        }
        .info-box .label{
            font-size:11.5px; color:var(--text-muted); font-weight:500;
        }
        .info-box .value{
            font-size:16px; font-weight:700; font-family:'IBM Plex Mono', monospace;
            color:var(--text);
        }

        /* ===== FORM GRID ===== */
        .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .field-grid .full{ grid-column:1/-1; }

        .field-group{ display:flex; flex-direction:column; gap:6px; }
        .field-group label{
            font-size:12.5px; font-weight:600; color:var(--text-secondary);
            display:flex; align-items:center; gap:6px;
        }
        .field-group label .opt{
            font-weight:400; color:var(--text-muted); font-size:11.5px;
        }
        .field-group label .required{
            color:var(--danger); font-size:14px;
        }

        .field-group .input-wrap{
            position:relative;
        }
        .field-group .input-wrap .icon{
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:var(--text-muted); pointer-events:none;
        }
        .field-group input,
        .field-group select,
        .field-group textarea{
            width:100%; padding:11px 16px; border-radius:var(--radius-sm);
            background:var(--surface-hover); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none;
            transition:all .2s ease; font-family:inherit;
        }
        .field-group input.has-icon{ padding-left:42px; }
        .field-group input:focus,
        .field-group select:focus,
        .field-group textarea:focus{
            border-color:var(--accent); background:var(--surface);
            box-shadow:0 0 0 4px rgba(var(--emerald-rgb),0.08);
        }
        .field-group input::placeholder{
            color:var(--text-muted);
        }
        .field-group select{
            padding-right:38px;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 14px center; background-size:12px;
            appearance:none; -webkit-appearance:none;
            color-scheme:dark;
        }
        .field-group select option{
            background:#1a1f2e; color:#e8edf5; padding:10px 14px; font-size:14px;
        }
        .field-group select option:checked,
        .field-group select option:hover{
            background:#0d2a1f; color:#34d399;
        }
        @media (prefers-color-scheme: light) {
            .field-group select{ color-scheme:light; }
            .field-group select option{ background:#ffffff; color:#1a1f2e; }
            .field-group select option:checked,
            .field-group select option:hover{ background:#e6f9f1; color:#059669; }
        }
        .field-group textarea{
            resize:vertical; min-height:80px; padding:12px 16px; font-size:13.5px; line-height:1.6;
        }
        .field-group .field-hint{
            font-size:11.5px; color:var(--text-muted); margin-top:4px;
        }
        .field-group .field-error{
            font-size:12px; color:var(--danger); margin-top:4px; display:flex; align-items:center; gap:4px;
        }

        /* ===== FORM DIVIDER ===== */
        .form-divider{
            display:flex; align-items:center; gap:16px; margin:24px 0 20px;
        }
        .form-divider::before,
        .form-divider::after{
            content:''; flex:1; height:1px; background:var(--border);
        }
        .form-divider span{
            font-size:11.5px; text-transform:uppercase; letter-spacing:.08em;
            color:var(--text-muted); font-weight:600; white-space:nowrap;
        }

        /* ===== PREVIEW CARD ===== */
        .preview-card{
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius-lg); padding:24px;
            position:sticky; top:90px; box-shadow:0 4px 24px rgba(0,0,0,0.06);
            border-left:3px solid var(--accent);
        }
        .preview-label{
            font-size:11px; text-transform:uppercase; letter-spacing:.07em;
            color:var(--text-faint); font-weight:600; margin-bottom:16px;
            display:flex; align-items:center; gap:8px;
        }
        .preview-label .icon{ width:14px; height:14px; color:var(--accent); }
        .preview-stat{
            padding:16px; background:var(--surface-hover); border-radius:var(--radius-sm);
            margin-bottom:16px; border:1px solid var(--border);
        }
        .preview-stat .k{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-muted); font-weight:600; margin-bottom:4px;
        }
        .preview-stat .v{
            font-family:'Space Grotesk', sans-serif; font-size:24px; font-weight:700;
            color:var(--text);
        }
        .preview-divider{ height:1px; background:var(--border); margin:16px 0; }
        .preview-row{
            display:flex; justify-content:space-between; font-size:13px;
            color:var(--text-muted); padding:6px 0;
        }
        .preview-row b{
            color:var(--text); font-family:'IBM Plex Mono', monospace; font-weight:600;
        }
        .margin-badge{
            display:inline-flex; align-items:center; gap:6px;
            padding:4px 12px; border-radius:100px; font-size:12px; font-weight:700;
            background:rgba(var(--emerald-rgb),0.12); color:var(--emerald);
        }
        .margin-badge.low{
            background:rgba(var(--danger-rgb),0.12); color:var(--danger);
        }

        /* ===== FORM ACTIONS ===== */
        .form-actions{
            display:flex; justify-content:flex-end; gap:12px; padding-top:24px;
            border-top:1px solid var(--border); margin-top:8px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1000px){ .form-layout{ grid-template-columns:1fr; } }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .field-grid{ grid-template-columns:1fr; gap:16px; }
            .form-body{ padding:20px; }
            .form-panel-header{ padding:18px 20px; flex-wrap:wrap; }
            .form-panel-header .icon-wrap{ width:32px; height:32px; }
            .form-panel-header .icon-wrap .icon{ width:16px; height:16px; }
            .form-actions{ flex-direction:column-reverse; }
            .form-actions .btn{ flex:1; justify-content:center; }
            .page-head h1{ font-size:22px; flex-direction:column; align-items:flex-start; }
            .page-head h1 .item-sku-badge{ font-size:16px; }
            .preview-card{ position:relative; top:0; }
            .preview-stat .v{ font-size:20px; }
            .info-box{ flex-direction:column; align-items:flex-start; }
        }
        @media (max-width: 480px){
            .form-panel-header h2{ font-size:15px; }
            .form-panel-header p{ font-size:12px; }
        }
    </style>

    <div class="item-edit-wrap">

        {{-- ===== BREADCRUMB ===== --}}
        <div class="breadcrumb animate-in" style="animation-delay:.02s;">
            <a href="{{ route('inventory.index') }}">Stok Barang</a>
            <span class="sep">›</span>
            <a href="{{ route('inventory.show', $item) }}">{{ $item->name }}</a>
            <span class="sep">›</span>
            <span class="current">Edit</span>
        </div>

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>
                    <span>Edit Barang</span>
                    <span class="item-sku-badge">{{ $item->sku }}</span>
                </h1>
                <p>
                    Perbarui data barang <strong>{{ $item->name }}</strong>
                </p>
            </div>
            <div class="head-actions">
                <a href="{{ route('inventory.show', $item) }}" class="btn btn-outline btn-sm">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali ke Detail
                </a>
            </div>
        </div>

        {{-- ===== FORM LAYOUT ===== --}}
        <div class="form-layout animate-in" style="animation-delay:.10s;">

            {{-- FORM --}}
            <div class="form-panel">
                {{-- Panel Header --}}
                <div class="form-panel-header">
                    <div class="icon-wrap">
                        <svg class="icon"><use href="#ic-edit"/></svg>
                    </div>
                    <div>
                        <h2>Edit Informasi Barang</h2>
                        <p>Perbarui data barang {{ $item->name }}</p>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="form-body">
                    <form method="POST" action="{{ route('inventory.update', $item) }}" id="invForm">
                        @csrf
                        @method('PUT')

                        {{-- Info Box --}}
                        <div class="info-box">
                            <div class="left">
                                <svg class="icon"><use href="#ic-info"/></svg>
                                <div>
                                    <div class="label">ID Barang</div>
                                    <div class="value">#{{ $item->id }}</div>
                                </div>
                            </div>
                            <div style="font-size:12px; color:var(--text-muted);">
                                <svg class="icon" style="width:14px;height:14px;display:inline;vertical-align:middle;"><use href="#ic-box"/></svg>
                                Stok saat ini: {{ number_format($item->stock_quantity, 0, ',', '.') }} {{ $item->unit ?? 'pcs' }}
                            </div>
                        </div>

                        {{-- Baris 1: Nama & SKU --}}
                        <div class="field-grid">
                            <div class="field-group">
                                <label>
                                    Nama Barang
                                    <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-box"/></svg>
                                    <input type="text" name="name" class="has-icon" value="{{ old('name', $item->name) }}" placeholder="Masukkan nama barang..." required>
                                </div>
                                @error('name')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Nama barang yang akan ditampilkan di inventaris.</div>
                            </div>

                            <div class="field-group">
                                <label>
                                    SKU
                                    <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-tag"/></svg>
                                    <input type="text" name="sku" class="has-icon" value="{{ old('sku', $item->sku) }}" placeholder="Masukkan SKU..." required>
                                </div>
                                @error('sku')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Kode unik untuk identifikasi barang.</div>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="form-divider">
                            <span>Stok & Harga</span>
                        </div>

                        {{-- Baris 2: Stok, Reorder, Unit --}}
                        <div class="field-grid">
                            <div class="field-group">
                                <label>
                                    Stok Saat Ini
                                    <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-package"/></svg>
                                    <input type="number" name="stock_quantity" id="stockInput" class="has-icon" value="{{ old('stock_quantity', $item->stock_quantity) }}" step="1" min="0" required>
                                </div>
                                @error('stock_quantity')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Jumlah stok barang saat ini.</div>
                            </div>

                            <div class="field-group">
                                <label>
                                    Batas Reorder
                                    <span class="opt">(opsional)</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                    <input type="number" name="reorder_level" class="has-icon" value="{{ old('reorder_level', $item->reorder_level) }}" step="1" min="0">
                                </div>
                                @error('reorder_level')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Batas minimum stok sebelum perlu restock.</div>
                            </div>
                        </div>

                        {{-- Baris 3: Harga Pokok, Harga Jual, Unit --}}
                        <div class="field-grid">
                            <div class="field-group">
                                <label>
                                    Harga Pokok
                                    <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-dollar"/></svg>
                                    <input type="number" name="cost_price" id="costInput" class="has-icon" value="{{ old('cost_price', $item->cost_price) }}" step="0.01" min="0" required>
                                </div>
                                @error('cost_price')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Harga beli atau modal per unit.</div>
                            </div>

                            <div class="field-group">
                                <label>
                                    Harga Jual
                                    <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-dollar"/></svg>
                                    <input type="number" name="selling_price" id="sellInput" class="has-icon" value="{{ old('selling_price', $item->selling_price) }}" step="0.01" min="0" required>
                                </div>
                                @error('selling_price')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Harga jual per unit.</div>
                            </div>
                        </div>

                        {{-- Baris 4: Kategori & Unit --}}
                        <div class="field-grid">
                            <div class="field-group">
                                <label>
                                    Kategori
                                    <span class="opt">(opsional)</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-tag"/></svg>
                                    <input type="text" name="category" class="has-icon" value="{{ old('category', $item->category) }}" placeholder="Masukkan kategori...">
                                </div>
                                @error('category')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Kategori untuk mengelompokkan barang.</div>
                            </div>

                            <div class="field-group">
                                <label>
                                    Satuan
                                    <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <svg class="icon"><use href="#ic-ruler"/></svg>
                                    <input type="text" name="unit" class="has-icon" value="{{ old('unit', $item->unit) }}" placeholder="Masukkan satuan..." required>
                                </div>
                                @error('unit')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Satuan barang (pcs, kg, box, dll).</div>
                            </div>
                        </div>

                        {{-- Baris 5: Deskripsi (full width) --}}
                        <div class="field-grid" style="margin-top:8px;">
                            <div class="field-group full">
                                <label>
                                    Deskripsi
                                    <span class="opt">(opsional)</span>
                                </label>
                                <textarea name="description" placeholder="Tambahkan deskripsi atau catatan untuk barang ini...">{{ old('description', $item->description) }}</textarea>
                                @error('description')
                                    <div class="field-error">
                                        <span>⚠️</span> {{ $message }}
                                    </div>
                                @enderror
                                <div class="field-hint">Informasi tambahan tentang barang.</div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="form-actions">
                            <a href="{{ route('inventory.show', $item) }}" class="btn btn-outline">
                                <svg class="icon"><use href="#ic-arrow-left"/></svg>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <svg class="icon"><use href="#ic-save"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- PREVIEW CARD --}}
            <div class="preview-card">
                <div class="preview-label">
                    <svg class="icon"><use href="#ic-info"/></svg>
                    Pratinjau Nilai Stok
                </div>
                <div class="preview-stat">
                    <div class="k">Total Nilai Stok</div>
                    <div class="v mono" id="previewValue">Rp0</div>
                </div>
                <div class="preview-divider"></div>
                <div class="preview-row">
                    <span>Harga pokok / unit</span>
                    <b id="previewCost">Rp0</b>
                </div>
                <div class="preview-row">
                    <span>Harga jual / unit</span>
                    <b id="previewSell">Rp0</b>
                </div>
                <div class="preview-row" style="padding-top:10px; border-top:1px solid var(--border); margin-top:4px;">
                    <span>Estimasi margin</span>
                    <span class="margin-badge" id="previewMargin">0%</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fmtRupiah(n){
            n = isNaN(n) ? 0 : n;
            return 'Rp' + n.toLocaleString('id-ID', {maximumFractionDigits:0});
        }

        function updatePreview(){
            var qty = parseFloat(document.querySelector('[name="stock_quantity"]')?.value) || 0;
            var cost = parseFloat(document.getElementById('costInput')?.value) || 0;
            var sell = parseFloat(document.getElementById('sellInput')?.value) || 0;

            document.getElementById('previewValue').textContent = fmtRupiah(qty * cost);
            document.getElementById('previewCost').textContent = fmtRupiah(cost);
            document.getElementById('previewSell').textContent = fmtRupiah(sell);

            var margin = sell > 0 ? ((sell - cost) / sell) * 100 : 0;
            var badge = document.getElementById('previewMargin');
            badge.textContent = margin.toFixed(1) + '%';
            badge.className = 'margin-badge' + (margin < 15 ? ' low' : '');
        }

        document.getElementById('invForm').addEventListener('input', updatePreview);
        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>
</x-app-layout>