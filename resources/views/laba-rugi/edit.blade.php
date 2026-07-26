<x-app-layout>
    <x-slot name="title">Edit Pos Laba Rugi</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <style>
        .pl-modern {
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

            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --danger-rgb: 232, 90, 90;
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            --info-rgb: 78, 143, 240;

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .pl-modern * { box-sizing: border-box; }
        .pl-modern .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.02em;
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .pl-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .pl-modern .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ===== HEADER ===== */
        .pl-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .pl-header-left { flex: 1; min-width: 200px; }

        .pl-badge {
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

        .pl-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .pl-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .pl-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .pl-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .pl-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .pl-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        /* ===== PANEL ===== */
        .pl-panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 32px 36px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .pl-panel:hover {
            border-color: var(--border-hover);
        }

        .pl-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--theme-gradient);
            border-radius: 0 2px 2px 0;
        }

        .pl-panel-icon {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .pl-panel-icon .icon-box {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pl-panel-icon .icon-box .icon {
            width: 20px;
            height: 20px;
        }

        .pl-panel-icon .info {
            flex: 1;
        }

        .pl-panel-icon .info .label {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .pl-panel-icon .info .desc {
            font-size: 13px;
            color: var(--text-tertiary);
        }

        .pl-panel-icon .info .desc strong {
            color: var(--theme-primary);
            font-weight: 600;
        }

        /* ===== ERROR SUMMARY ===== */
        .pl-error-summary {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            margin-bottom: 20px;
            animation: fadeSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .pl-error-summary .title {
            font-weight: 600;
            color: var(--danger);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pl-error-summary .title .icon {
            width: 18px;
            height: 18px;
        }

        .pl-error-summary ul {
            margin: 0;
            padding-left: 20px;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .pl-error-summary ul li {
            margin-bottom: 2px;
        }

        /* ===== FORM ===== */
        .pl-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px 24px;
        }

        .pl-form-grid .full-width {
            grid-column: 1 / -1;
        }

        .pl-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .pl-field label {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pl-field label .required {
            color: var(--danger);
            font-weight: 600;
        }

        .pl-field label .optional {
            color: var(--text-tertiary);
            font-weight: 400;
            font-size: 11px;
        }

        .pl-field .field-hint {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .pl-field input,
        .pl-field select,
        .pl-field textarea {
            width: 100%;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .pl-field input:hover,
        .pl-field select:hover,
        .pl-field textarea:hover {
            border-color: var(--border-hover);
        }

        .pl-field input:focus,
        .pl-field textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .pl-field select:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .pl-field input::placeholder,
        .pl-field textarea::placeholder {
            color: var(--text-tertiary);
        }

        .pl-field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
            appearance: none;
            cursor: pointer;
        }

        .pl-field select option {
            padding: 8px;
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .pl-field textarea {
            resize: vertical;
            min-height: 100px;
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        .pl-field .field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pl-field .field-error .icon {
            width: 14px;
            height: 14px;
        }

        /* ===== DIVIDER ===== */
        .pl-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 24px 0;
        }

        /* ===== ACTIONS ===== */
        .pl-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            margin-top: 4px;
            flex-wrap: wrap;
        }

        .pl-actions .left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pl-actions .right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pl-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 24px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .pl-btn .icon {
            width: 16px;
            height: 16px;
        }

        .pl-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .pl-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .pl-btn-primary:active {
            transform: translateY(0) scale(0.97);
        }

        .pl-btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .pl-btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .pl-btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .pl-btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        .pl-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .pl-form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .pl-header {
                flex-direction: column;
            }
            .pl-panel {
                padding: 24px 20px;
            }
            .pl-form-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .pl-form-grid .full-width {
                grid-column: 1;
            }
            .pl-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }
            .pl-actions .left {
                justify-content: center;
                order: 2;
            }
            .pl-actions .right {
                flex-direction: column;
                width: 100%;
                order: 1;
            }
            .pl-actions .right .pl-btn {
                width: 100%;
                justify-content: center;
            }
            .pl-panel-icon {
                flex-direction: column;
                text-align: center;
            }
            .pl-panel-icon .info .desc {
                font-size: 12px;
            }
            .pl-header-actions {
                width: 100%;
            }
            .pl-header-actions .pl-btn {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .pl-header h1 {
                font-size: 22px;
            }
            .pl-panel {
                padding: 20px 16px;
                border-radius: var(--radius-md);
            }
            .pl-field input,
            .pl-field select,
            .pl-field textarea {
                font-size: 13px;
                padding: 10px 12px;
            }
            .pl-btn {
                font-size: 12px;
                padding: 10px 18px;
            }
        }

        /* ===== MODAL DELETE ===== */
        .pl-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }
        .pl-modal-overlay.active { display: flex; }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .pl-modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .pl-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }

        .pl-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }

        .pl-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .pl-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }

        .pl-modal-box .item-name {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 4px;
        }

        .pl-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .pl-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .pl-modal-actions .btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .pl-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .pl-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .pl-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .pl-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .pl-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        @media (max-width: 480px) {
            .pl-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }
            .pl-modal-actions {
                flex-direction: column;
            }
            .pl-modal-actions .btn {
                width: 100%;
            }
        }
    </style>

    <div class="pl-modern">

        <!-- ===== HEADER ===== -->
        <div class="pl-header animate-in" style="animation-delay: 0.05s;">
            <div class="pl-header-left">
                <div class="pl-badge">
                    <span class="dot"></span>
                    Edit Data
                </div>
                <h1>Edit Pos Laba Rugi</h1>
                <p class="subtitle">
                    Perbarui data pos <strong>"{{ $item->name }}"</strong>.
                    Perubahan akan langsung memengaruhi laporan periode <span class="highlight">{{ $item->period_label }}</span>.
                </p>
            </div>
            <div class="pl-header-actions">
                <a href="{{ route('laba-rugi.index') }}" class="pl-btn pl-btn-outline">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== ERROR SUMMARY ===== -->
        @if ($errors->any())
            <div class="pl-error-summary animate-in" style="animation-delay: 0.07s;">
                <div class="title">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Terjadi kesalahan:
                </div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ===== FORM ===== -->
        <form method="POST" action="{{ route('laba-rugi.update', $item) }}" class="animate-in" style="animation-delay: 0.10s;" id="labaRugiForm">
            @csrf
            @method('PUT')

            <div class="pl-panel">
                <!-- Panel Icon -->
                <div class="pl-panel-icon">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-edit"/></svg>
                    </div>
                    <div class="info">
                        <div class="label">Edit Pos Laba Rugi</div>
                        <div class="desc">
                            Perbarui data pos <strong>{{ $item->name }}</strong>.
                            Perubahan akan langsung memengaruhi laporan periode <strong>{{ $item->period_label }}</strong>.
                        </div>
                    </div>
                </div>

                <!-- ===== FORM FIELDS ===== -->
                <div class="pl-form-grid">
                    <!-- Nama Pos -->
                    <div class="pl-field full-width">
                        <label>
                            Nama Pos <span class="required">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                               placeholder="Contoh: Penjualan Produk A, Gaji Karyawan, Sewa Gedung"
                               value="{{ old('name', $item->name) }}" required>
                        @error('name')
                            <div class="field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Jenis (Type) -->
                    <div class="pl-field">
                        <label>
                            Jenis <span class="required">*</span>
                        </label>
                        <select name="type" id="type" required>
                            <option value="">Pilih Jenis</option>
                            <option value="pendapatan" {{ old('type', $item->type) == 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                            <option value="beban" {{ old('type', $item->type) == 'beban' ? 'selected' : '' }}>Beban</option>
                        </select>
                        <div class="field-hint">Pilih apakah ini pendapatan atau beban</div>
                        @error('type')
                            <div class="field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="pl-field">
                        <label>
                            Kategori <span class="required">*</span>
                        </label>
                        <input type="text" name="category" id="category" 
                               placeholder="Contoh: Penjualan, Operasional, Gaji"
                               value="{{ old('category', $item->category) }}" required>
                        <div class="field-hint">Kelompokkan pos sejenis</div>
                        @error('category')
                            <div class="field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div class="pl-field">
                        <label>
                            Jumlah <span class="required">*</span>
                        </label>
                        <input type="number" name="amount" id="amount" 
                               placeholder="0"
                               value="{{ old('amount', $item->amount) }}" required min="0" step="1000">
                        <div class="field-hint">Masukkan dalam {{ $currencySymbol }}</div>
                        @error('amount')
                            <div class="field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Bulan -->
                    <div class="pl-field">
                        <label>
                            Bulan <span class="required">*</span>
                        </label>
                        <select name="period_month" id="period_month" required>
                            <option value="">Pilih Bulan</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ old('period_month', $item->period_month) == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        @error('period_month')
                            <div class="field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tahun -->
                    <div class="pl-field">
                        <label>
                            Tahun <span class="required">*</span>
                        </label>
                        <select name="period_year" id="period_year" required>
                            <option value="">Pilih Tahun</option>
                            @for($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                <option value="{{ $y }}" {{ old('period_year', $item->period_year) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                        @error('period_year')
                            <div class="field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="pl-field full-width">
                        <label>
                            Catatan <span class="optional">(opsional)</span>
                        </label>
                        <textarea name="notes" id="notes" 
                                  placeholder="Tambahkan catatan atau keterangan tambahan...">{{ old('notes', $item->notes) }}</textarea>
                        @error('notes')
                            <div class="field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- ===== DIVIDER ===== -->
                <hr class="pl-divider">

                <!-- ===== ACTIONS ===== -->
                <div class="pl-actions">
                    <div class="left">
                        <button type="button" class="pl-btn pl-btn-danger" onclick="confirmDelete()">
                            <svg class="icon"><use href="#ic-trash"/></svg>
                            Hapus Pos
                        </button>
                    </div>
                    <div class="right">
                        <a href="{{ route('laba-rugi.index') }}" class="pl-btn pl-btn-outline">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Batal
                        </a>
                        <button type="submit" class="pl-btn pl-btn-primary" id="submitBtn">
                            <svg class="icon"><use href="#ic-check"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- ===== DELETE FORM ===== -->
        <form method="POST" action="{{ route('laba-rugi.destroy', $item) }}" id="deleteForm">
            @csrf
            @method('DELETE')
        </form>

    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="pl-modal-overlay" id="deleteModal">
        <div class="pl-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Pos Laba Rugi?</h3>
            <p>
                Anda yakin ingin menghapus pos
                <br>
                <span class="item-name">"{{ $item->name }}"</span>
            </p>
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="pl-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <button type="button" class="btn btn-danger" onclick="submitDelete()">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                        <path d="M3 6h18"/>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/>
                        <path d="M14 11v6"/>
                    </svg>
                    Ya, Hapus!
                </button>
            </div>
        </div>
    </div>

    <!-- SVG Icons -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></symbol>
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
        <symbol id="ic-alert-triangle" viewBox="0 0 24 24"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></symbol>
        <symbol id="ic-trash" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.pl-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // ===== AUTO FORMAT AMOUNT =====
            const amountInput = document.getElementById('amount');
            if (amountInput) {
                amountInput.addEventListener('blur', function() {
                    if (this.value) {
                        const num = parseInt(this.value.replace(/[^0-9]/g, ''));
                        if (!isNaN(num) && num > 0) {
                            this.value = num;
                        }
                    }
                });

                amountInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // ===== PREVENT DOUBLE SUBMIT =====
            const form = document.getElementById('labaRugiForm');
            const submitBtn = document.getElementById('submitBtn');

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<svg class="icon"><use href="#ic-check"/></svg> Menyimpan...';
                    }
                });
            }

            // ===== KEYBOARD SHORTCUT: Ctrl+S =====
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    const form = document.getElementById('labaRugiForm');
                    if (form) {
                        const submitBtn = document.getElementById('submitBtn');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<svg class="icon"><use href="#ic-check"/></svg> Menyimpan...';
                        }
                        form.submit();
                    }
                }
            });
        });

        // ===== DELETE MODAL =====
        function confirmDelete() {
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function submitDelete() {
            document.getElementById('deleteForm').submit();
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>

</x-app-layout>