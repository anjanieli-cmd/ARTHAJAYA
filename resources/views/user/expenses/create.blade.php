<x-user-layout>
    <x-slot name="title">Ajukan Pengeluaran</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
        
        // Pastikan $categories adalah collection
        if (is_array($categories)) {
            $categories = collect($categories);
        }
        
        // Jika kosong, gunakan default
        if ($categories->isEmpty()) {
            $categories = collect(['Operasional', 'Transportasi', 'Perlengkapan', 'Konsumsi', 'Marketing', 'Lainnya']);
        }
        
        $selectedCategory = old('category', $categories->first() ?? 'Operasional');
    @endphp

    <style>
        /* ============================================
           AJUKAN PENGELUARAN - Premium Design
           ============================================ */
        
        .ue-wrap {
            --theme-primary: var(--emerald);
            --theme-light: var(--emerald);
            --theme-dark: var(--emerald-dim);
            --theme-glow: rgba(var(--emerald-rgb), 0.25);
            --theme-soft: rgba(var(--emerald-rgb), 0.12);
            --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));
            
            --text-primary: var(--text);
            --text-secondary: var(--text-mute);
            --text-tertiary: var(--text-faint);
            
            --bg-card: var(--surface);
            --bg-card-hover: var(--surface-strong);
            --bg-card-active: rgba(255, 255, 255, 0.04);
            --border-color: var(--border);
            --border-hover: var(--border-hover);
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .ue-wrap * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes stampIn {
            0% { opacity: 0; transform: scale(1.6) rotate(-14deg); }
            60% { opacity: 1; }
            100% { opacity: 1; transform: scale(1) rotate(-6deg); }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .ue-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        /* Base icon styling — applies via .icon class */
        .ue-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* Defensive fallback: ANY svg inside .ue-wrap renders as outline/stroke,
           never as a filled shape — even if class="icon" is accidentally left
           off an element. This is exactly what broke the "Form Pengeluaran"
           icon: that <svg> was missing class="icon", so the browser fell back
           to the default SVG fill (solid black) on paths only ever meant to
           be drawn as strokes, producing the distorted blob shape. */
        .ue-wrap svg { fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .ue-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ue-header-left { flex: 1; min-width: 200px; }

        .ue-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px 6px 10px;
            background: var(--theme-glow);
            border: 1px solid var(--theme-glow);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--theme-primary);
            margin-bottom: 12px;
        }

        .ue-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ue-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ue-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ue-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .ue-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ue-btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            background: transparent;
            color: var(--text-secondary);
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .ue-btn-action .icon { width: 16px; height: 16px; }
        .ue-btn-action:hover { transform: translateY(-2px); }
        .ue-btn-action:active { transform: translateY(0) scale(0.97); }

        .ue-btn-action-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ue-btn-action-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ue-btn-action .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== ALERTS ===== */
        .ue-alert {
            border-radius: var(--radius-md);
            padding: 14px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .ue-alert-success {
            background: var(--success-soft);
            border: 1px solid rgba(52, 181, 131, 0.25);
            color: var(--success);
        }

        .ue-alert-error {
            background: var(--danger-soft);
            border: 1px solid rgba(232, 90, 90, 0.25);
            color: var(--danger);
            flex-direction: column;
            align-items: flex-start;
        }

        .ue-alert-error ul { padding-left: 18px; margin: 4px 0 0; }

        /* ===== GRID: FORM + SLIP ===== */
        .ue-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        /* ===== FORM CARD ===== */
        .ue-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 36px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ue-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--theme-gradient);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .ue-card:hover { border-color: var(--border-hover); }

        .ue-card .card-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .ue-card .card-head .icon-box {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: var(--theme-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ue-card .card-head .icon-box svg {
            width: 20px;
            height: 20px;
        }

        .ue-card .card-head .head-text h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
            letter-spacing: -0.02em;
        }

        .ue-card .card-head .head-text p {
            font-size: 13px;
            color: var(--text-tertiary);
            margin: 0;
        }

        /* ===== FORM STYLES ===== */
        .ue-form-group { margin-bottom: 20px; }

        .ue-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
            letter-spacing: 0.02em;
        }

        .ue-form-group label .required { color: var(--danger); margin-left: 2px; }
        .ue-form-group .helper-text {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        .ue-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .ue-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-primary);
            font-size: 14px;
            font-family: inherit;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
        }

        .ue-input:hover {
            border-color: var(--text-tertiary);
            background: var(--bg-card);
        }

        .ue-input:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .ue-input::placeholder { color: var(--text-tertiary); font-weight: 400; }
        .ue-input.has-prefix { padding-left: 42px; }

        .ue-input[type="number"] {
            -moz-appearance: textfield;
            font-family: 'IBM Plex Mono', monospace;
        }

        .ue-input[type="number"]::-webkit-outer-spin-button,
        .ue-input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .ue-input.error {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px var(--danger-soft);
        }

        .ue-input-wrap { position: relative; }

        .ue-input-wrap .prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-tertiary);
            font-size: 14px;
            font-weight: 700;
            pointer-events: none;
            font-family: 'IBM Plex Mono', monospace;
        }

        textarea.ue-input {
            resize: vertical;
            min-height: 80px;
            line-height: 1.6;
        }

        /* ===== CATEGORY CHIPS ===== */
        .ue-chip-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ue-chip {
            position: relative;
        }

        .ue-chip input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            cursor: pointer;
        }

        .ue-chip span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 100px;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease;
            user-select: none;
        }

        .ue-chip input:checked + span {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
            color: var(--theme-primary);
        }

        .ue-chip input:focus-visible + span {
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .ue-chip:hover span {
            border-color: var(--border-hover);
        }

        /* ===== SUBMIT BUTTON ===== */
        .ue-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 20px var(--theme-glow);
            width: 100%;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.02em;
            font-family: 'Inter', sans-serif;
        }

        .ue-btn:hover {
            box-shadow: 0 8px 32px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ue-btn:active {
            transform: translateY(0) scale(0.98);
        }

        .ue-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .ue-btn .icon { width: 18px; height: 18px; }

        .ue-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        .ue-card-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-top: 20px;
            border: 1px dashed var(--border-color);
        }

        .ue-card-note .icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            margin-top: 1px;
            color: var(--theme-primary);
        }

        .ue-card-note strong { color: var(--text-secondary); }

        /* ===== SLIP / RECEIPT PREVIEW ===== */
        .ue-slip-sticky { position: sticky; top: 24px; }

        .ue-slip {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            position: relative;
            overflow: hidden;
            font-family: 'IBM Plex Mono', monospace;
        }

        .ue-slip::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 10px;
            background-image: radial-gradient(circle, var(--bg-card-active) 4.5px, transparent 4.6px);
            background-size: 16px 16px;
            background-position: 0 -8px;
        }

        .ue-slip-body { padding: 26px 24px 22px; }

        .ue-slip-eyebrow {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 10.5px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-tertiary);
            margin-bottom: 4px;
        }

        .ue-slip-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-primary);
            margin-bottom: 18px;
        }

        .ue-slip-amount-label {
            font-size: 11px;
            color: var(--text-tertiary);
            letter-spacing: 0.04em;
        }

        .ue-slip-amount {
            font-size: 30px;
            font-weight: 600;
            color: var(--theme-primary);
            margin: 2px 0 20px;
            word-break: break-all;
            line-height: 1.15;
            transition: color 0.2s ease;
        }

        .ue-slip-amount.is-empty { color: var(--text-faint); }

        .ue-slip-divider {
            border: none;
            border-top: 1px dashed var(--border-hover);
            margin: 16px 0;
        }

        .ue-slip-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            font-size: 12px;
            margin-bottom: 11px;
        }

        .ue-slip-row .k {
            color: var(--text-tertiary);
            white-space: nowrap;
        }

        .ue-slip-row .v {
            color: var(--text-secondary);
            text-align: right;
            font-weight: 500;
            overflow-wrap: anywhere;
            font-family: 'Inter', sans-serif;
        }

        .ue-slip-row .v.is-empty {
            color: var(--text-faint);
            font-style: italic;
        }

        .ue-slip-stamp {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            padding: 6px 14px;
            border: 1.5px solid var(--warning);
            border-radius: 6px;
            color: var(--warning);
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transform: rotate(-4deg);
            animation: stampIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .ue-slip-stamp .icon { width: 14px; height: 14px; }

        .ue-slip-foot {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            color: var(--text-faint);
            text-align: center;
            padding: 14px 24px 20px;
            border-top: 1px dashed var(--border-hover);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .ue-wrap { padding: 0 16px; }
            .ue-grid { grid-template-columns: 1fr; }
            .ue-slip-sticky { position: static; }
        }

        @media (max-width: 768px) {
            .ue-wrap { padding: 0 12px; }
            .ue-header { flex-direction: column; }
            .ue-actions { width: 100%; }
            .ue-actions .ue-btn-action { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .ue-card { padding: 24px 20px; }
            .ue-form-row { grid-template-columns: 1fr; gap: 0; }
            .ue-header h1 { font-size: 22px; }
            .ue-slip-amount { font-size: 26px; }
            .ue-slip-body { padding: 20px 18px; }
        }

        @media (max-width: 480px) {
            .ue-wrap { padding: 0 8px; }
            .ue-card .card-head .icon-box { width: 36px; height: 36px; }
            .ue-card .card-head .icon-box svg { width: 16px; height: 16px; }
            .ue-card .card-head .head-text h2 { font-size: 16px; }
            .ue-btn { font-size: 14px; padding: 12px 20px; }
            .ue-card { padding: 20px 16px; }
            .ue-chip span { font-size: 11px; padding: 6px 12px; }
            .ue-slip-amount { font-size: 22px; }
            .ue-slip-body { padding: 16px 14px; }
        }
    </style>

    <div class="ue-wrap">

        <!-- ===== HEADER ===== -->
        <div class="ue-header animate-in" style="animation-delay: 0.05s;">
            <div class="ue-header-left">
                <div class="ue-badge">
                    <span class="dot"></span>
                    Pengajuan Baru
                </div>
                <h1>Ajukan Pengeluaran</h1>
                <p class="subtitle">
                    Isi form di bawah untuk mengajukan pengeluaran perusahaan — 
                    <strong>pastikan data sesuai dengan bukti pendukung</strong>
                </p>
            </div>
            <div class="ue-actions">
                <a href="{{ route('user.expenses.index') }}" class="ue-btn-action ue-btn-action-ghost">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== ALERTS ===== -->
        @if (session('success'))
            <div class="ue-alert ue-alert-success animate-in" style="animation-delay: 0.07s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="ue-alert ue-alert-error animate-in" style="animation-delay: 0.07s;">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- ===== GRID: FORM + SLIP ===== -->
        <div class="ue-grid">

            <!-- ===== FORM CARD ===== -->
            <div class="ue-card animate-in" style="animation-delay: 0.10s;">
                <div class="card-head">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-file-text"/></svg>
                    </div>
                    <div class="head-text">
                        <h2>Form Pengeluaran</h2>
                        <p style="font-size:13px;color:var(--text-tertiary);margin:0;">Isi data pengeluaran dengan lengkap dan jelas</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('user.expenses.store') }}" id="expenseForm">
                    @csrf

                    <!-- Deskripsi -->
                    <div class="ue-form-group">
                        <label for="description">
                            Deskripsi Pengeluaran <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="description"
                            name="description"
                            class="ue-input @error('description') error @enderror"
                            value="{{ old('description') }}"
                            placeholder="Contoh: Pembelian bahan baku batik"
                            required
                            autofocus
                        >
                        <div class="helper-text">Deskripsikan dengan jelas tujuan pengeluaran</div>
                    </div>

                    <!-- Row: Amount + Date -->
                    <div class="ue-form-row">
                        <div class="ue-form-group">
                            <label for="amount">
                                Jumlah Pengeluaran <span class="required">*</span>
                            </label>
                            <div class="ue-input-wrap">
                                <span class="prefix">{{ $currencySymbol }}</span>
                                <input
                                    type="number"
                                    id="amount"
                                    name="amount"
                                    class="ue-input has-prefix @error('amount') error @enderror"
                                    value="{{ old('amount') }}"
                                    placeholder="0"
                                    min="1"
                                    step="1"
                                    required
                                >
                            </div>
                            <div class="helper-text">Masukkan nominal dalam angka (tanpa titik atau koma)</div>
                        </div>
                        <div class="ue-form-group">
                            <label for="expense_date">
                                Tanggal Pengeluaran <span class="required">*</span>
                            </label>
                            <input
                                type="date"
                                id="expense_date"
                                name="expense_date"
                                class="ue-input @error('expense_date') error @enderror"
                                value="{{ old('expense_date', date('Y-m-d')) }}"
                                required
                            >
                            <div class="helper-text">Pilih tanggal terjadinya pengeluaran</div>
                        </div>
                    </div>

                    <!-- Kategori - dari database dengan fallback -->
                    <div class="ue-form-group">
                        <label>Kategori Pengeluaran</label>
                        @if($categories->isEmpty())
                            <div style="padding: 12px 16px; background: var(--warning-soft); border: 1px solid var(--warning); border-radius: var(--radius-sm); color: var(--warning); font-size: 13px; margin-top: 4px;">
                                <svg class="icon" style="width:16px;height:16px;display:inline-block;vertical-align:middle;margin-right:6px;"><use href="#ic-alert-triangle"/></svg>
                                Belum ada kategori yang dibuat. Silakan hubungi Staff untuk menambahkan kategori.
                            </div>
                        @else
                            <div class="ue-chip-group">
                                @foreach ($categories as $cat)
                                    <label class="ue-chip">
                                        <input type="radio" name="category" value="{{ $cat }}" {{ $selectedCategory === $cat ? 'checked' : '' }}>
                                        <span>{{ $cat }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        <div class="helper-text">Pilih kategori yang paling sesuai dengan pengeluaran</div>
                    </div>

                    <!-- Catatan -->
                    <div class="ue-form-group">
                        <label for="notes">
                            Catatan Tambahan
                            <span style="font-weight:400;color:var(--text-tertiary);">(opsional)</span>
                        </label>
                        <textarea
                            id="notes"
                            name="notes"
                            class="ue-input @error('notes') error @enderror"
                            rows="3"
                            placeholder="Tambahkan catatan atau keterangan tambahan jika diperlukan..."
                        >{{ old('notes') }}</textarea>
                        <div class="helper-text">Misalnya: nomor invoice, keterangan vendor, dll.</div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="ue-btn" id="submitBtn">
                        <svg class="icon"><use href="#ic-send"/></svg>
                        <span id="btnText">Ajukan Pengeluaran</span>
                    </button>
                </form>

                <div class="ue-card-note">
                    <svg class="icon"><use href="#ic-info"/></svg>
                    <div>
                        <strong>Perhatian:</strong> Pengajuan akan masuk ke antrian dan perlu disetujui oleh tim finance sebelum dapat direalisasikan.
                        <br>
                        <span style="font-size:11px;color:var(--text-tertiary);">Pastikan data yang diisi sudah benar dan sesuai dengan bukti pendukung.</span>
                    </div>
                </div>
            </div>

            <!-- ===== SLIP / RECEIPT PREVIEW ===== -->
            <div class="ue-slip-sticky animate-in" style="animation-delay: 0.14s;">
                <div class="ue-slip">
                    <div class="ue-slip-body">
                        <div class="ue-slip-eyebrow">
                            <span>Slip Pengajuan</span>
                            <span id="slip-date-short">{{ date('d/m/Y') }}</span>
                        </div>
                        <div class="ue-slip-title">{{ $company->name ?? 'Arvessa' }}</div>

                        <div class="ue-slip-amount-label">Nominal</div>
                        <div class="ue-slip-amount is-empty" id="slip-amount">{{ $currencySymbol }} 0</div>

                        <hr class="ue-slip-divider">

                        <div class="ue-slip-row">
                            <span class="k">Deskripsi</span>
                            <span class="v is-empty" id="slip-description">—</span>
                        </div>
                        <div class="ue-slip-row">
                            <span class="k">Kategori</span>
                            <span class="v" id="slip-category">{{ $selectedCategory }}</span>
                        </div>
                        <div class="ue-slip-row">
                            <span class="k">Tanggal</span>
                            <span class="v" id="slip-date">{{ \Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="ue-slip-row">
                            <span class="k">Diajukan oleh</span>
                            <span class="v">{{ $user->name ?? 'Anda' }}</span>
                        </div>

                        <div class="ue-slip-stamp">
                            <svg class="icon"><use href="#ic-clock"/></svg>
                            Belum diajukan
                        </div>
                    </div>
                    <div class="ue-slip-foot">Preview — belum tersimpan sampai kamu menekan &ldquo;Ajukan Pengeluaran&rdquo;</div>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></symbol>
        <symbol id="ic-send" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
        <symbol id="ic-check-circle" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
        <symbol id="ic-alert-triangle" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
        <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
        <symbol id="ic-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
        <symbol id="ic-file-text" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.ue-btn, .ue-btn-action');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        return;
                    }
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // ===== BUTTON LOADING STATE =====
            const form = document.getElementById('expenseForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');

            if (form) {
                form.addEventListener('submit', function() {
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        btnText.textContent = 'Mengajukan...';
                    }
                });
            }

            // ===== AMOUNT FORMATTING =====
            const amountInput = document.getElementById('amount');
            if (amountInput) {
                amountInput.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = Math.round(parseFloat(this.value) || 0);
                    }
                });

                amountInput.addEventListener('keydown', function(e) {
                    if (e.key === '-' || e.key === 'e') {
                        e.preventDefault();
                    }
                });
            }

            // ===== LIVE SLIP PREVIEW =====
            const currencySymbol = @json($currencySymbol);
            const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

            const descInput   = document.getElementById('description');
            const dateInput   = document.getElementById('expense_date');
            const categoryInputs = document.querySelectorAll('input[name="category"]');

            const slipAmount = document.getElementById('slip-amount');
            const slipDesc   = document.getElementById('slip-description');
            const slipCategory = document.getElementById('slip-category');
            const slipDate   = document.getElementById('slip-date');
            const slipDateShort = document.getElementById('slip-date-short');

            function formatAmount(value) {
                const num = parseInt(value, 10);
                if (!value || isNaN(num) || num <= 0) return null;
                return currencySymbol + ' ' + num.toLocaleString('id-ID');
            }

            function formatDateLong(value) {
                if (!value) return null;
                const parts = value.split('-');
                if (parts.length !== 3) return null;
                const [y, m, d] = parts;
                const monthName = monthNames[parseInt(m, 10) - 1];
                if (!monthName) return null;
                return parseInt(d, 10) + ' ' + monthName + ' ' + y;
            }

            function formatDateShort(value) {
                if (!value) return '';
                const [y, m, d] = value.split('-');
                return `${d}/${m}/${y}`;
            }

            function updateSlip() {
                const formattedAmount = formatAmount(amountInput.value);
                if (formattedAmount) {
                    slipAmount.textContent = formattedAmount;
                    slipAmount.classList.remove('is-empty');
                } else {
                    slipAmount.textContent = currencySymbol + ' 0';
                    slipAmount.classList.add('is-empty');
                }

                const descVal = descInput.value.trim();
                if (descVal) {
                    slipDesc.textContent = descVal.length > 40 ? descVal.slice(0, 40) + '…' : descVal;
                    slipDesc.classList.remove('is-empty');
                } else {
                    slipDesc.textContent = '—';
                    slipDesc.classList.add('is-empty');
                }

                const checkedCategory = document.querySelector('input[name="category"]:checked');
                slipCategory.textContent = checkedCategory ? checkedCategory.value : '—';

                const formattedDate = formatDateLong(dateInput.value);
                slipDate.textContent = formattedDate || '—';
                slipDateShort.textContent = formatDateShort(dateInput.value);
            }

            // Event listeners for live preview
            [descInput, amountInput, dateInput].forEach(el => {
                if (el) el.addEventListener('input', updateSlip);
            });
            categoryInputs.forEach(el => el.addEventListener('change', updateSlip));

            // Initial update
            updateSlip();

        });
    </script>
</x-user-layout>