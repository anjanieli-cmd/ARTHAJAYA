<x-app-layout>
    <x-slot name="title">Hubungkan Integrasi</x-slot>

    @php
        // Data providers dengan icon SVG
        $providers = $providers ?? [
            'bank' => [
                'label' => 'Bank & Rekening',
                'type' => 'Perbankan',
                'desc' => 'Hubungkan rekening bank untuk sinkronisasi transaksi otomatis.',
                'icon' => 'bank',
                'color' => '#34B583',
                'bg' => 'rgba(52,181,131,0.12)'
            ],
            'ecommerce' => [
                'label' => 'E-Commerce',
                'type' => 'Marketplace',
                'desc' => 'Integrasi dengan platform e-commerce untuk sinkronisasi penjualan.',
                'icon' => 'shopping-cart',
                'color' => '#F0A83C',
                'bg' => 'rgba(240,168,60,0.12)'
            ],
            'accounting' => [
                'label' => 'Akuntansi',
                'type' => 'Software Akuntansi',
                'desc' => 'Hubungkan dengan software akuntansi untuk pembukuan otomatis.',
                'icon' => 'book',
                'color' => '#4E8FF0',
                'bg' => 'rgba(78,143,240,0.12)'
            ],
            'payment' => [
                'label' => 'Payment Gateway',
                'type' => 'Pembayaran',
                'desc' => 'Integrasi dengan payment gateway untuk menerima pembayaran online.',
                'icon' => 'credit-card',
                'color' => '#9B7BE0',
                'bg' => 'rgba(155,123,224,0.12)'
            ],
            'inventory' => [
                'label' => 'Inventaris',
                'type' => 'Manajemen Stok',
                'desc' => 'Sinkronisasi data inventaris dan stok barang secara real-time.',
                'icon' => 'package',
                'color' => '#EC4C93',
                'bg' => 'rgba(236,76,147,0.12)'
            ],
            'hr' => [
                'label' => 'HR & Payroll',
                'type' => 'Sumber Daya Manusia',
                'desc' => 'Integrasi data karyawan dan penggajian dari sistem HR.',
                'icon' => 'users',
                'color' => '#E85A5A',
                'bg' => 'rgba(232,90,90,0.12)'
            ],
        ];

        $selected = $selected ?? null;
    @endphp

    <style>
        /* ============================================
           HUBUNGKAN INTEGRASI - Full Width
           ============================================ */
        
        .connect-wrap {
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
            padding: 0 24px;
        }

        .connect-wrap * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .connect-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .connect-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .connect-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            padding: 0 4px;
        }

        .connect-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .connect-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Inter', sans-serif;
        }

        .connect-back-btn .icon { width: 16px; height: 16px; }
        
        .connect-back-btn:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateX(-4px);
        }

        .connect-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .connect-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 2px 0 0;
        }

        .connect-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px 6px 12px;
            background: var(--theme-glow);
            border: 1px solid var(--theme-glow);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--theme-primary);
            margin-top: 4px;
        }

        .connect-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        /* CARD */
        .connect-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px;
            transition: all 0.3s ease;
            max-width: 800px;
            margin: 0 auto;
        }

        .connect-card:hover {
            border-color: var(--border-hover);
        }

        .connect-card .card-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .connect-card .card-icon .icon {
            width: 32px;
            height: 32px;
        }

        .connect-card .card-title {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 4px;
        }

        .connect-card .card-desc {
            text-align: center;
            font-size: 13.5px;
            color: var(--text-secondary);
            margin: 0 0 28px;
            line-height: 1.6;
        }

        /* FORM GRID - 2 Columns */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-grid .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .form-group label .required {
            color: var(--danger);
            font-weight: 700;
        }

        .form-group label .optional {
            font-size: 11px;
            font-weight: 400;
            color: var(--text-tertiary);
            text-transform: lowercase;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1.5px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
            background: var(--bg-card);
        }

        .form-control::placeholder {
            color: var(--text-tertiary);
        }

        .form-control.error {
            border-color: var(--danger);
        }

        .form-control.error:focus {
            box-shadow: 0 0 0 3px var(--danger-soft);
        }

        .form-control option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .form-hint {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-hint .icon {
            width: 14px;
            height: 14px;
            color: var(--info);
        }

        .form-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        /* SELECT WITH ICON */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper .form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 40px;
        }

        .select-wrapper .select-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--text-tertiary);
            transition: color 0.3s ease;
        }

        .select-wrapper:focus-within .select-icon {
            color: var(--theme-primary);
        }

        /* PROVIDER PREVIEW */
        .selected-provider-preview {
            display: none;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: var(--theme-soft);
            border-radius: var(--radius-sm);
            margin-top: 12px;
            border: 1px solid var(--theme-glow);
            animation: fadeSlideUp 0.3s ease;
            grid-column: 1 / -1;
        }

        .selected-provider-preview.active {
            display: flex;
        }

        .selected-provider-preview .sp-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .selected-provider-preview .sp-icon .icon {
            width: 20px;
            height: 20px;
        }

        .selected-provider-preview .sp-info .sp-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .selected-provider-preview .sp-info .sp-type {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .selected-provider-preview .sp-info .sp-desc {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        /* FORM ACTIONS */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 2px solid var(--border-color);
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 32px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Inter', sans-serif;
            text-decoration: none;
        }

        .btn .icon {
            width: 16px;
            height: 16px;
        }

        .btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .btn-primary:active {
            transform: translateY(0) scale(0.97);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline {
            background: var(--bg-card-active);
            border: 1.5px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .btn .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .btn.loading .spinner {
            display: inline-block;
        }

        .btn.loading .btn-text {
            opacity: 0.8;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .connect-wrap { padding: 0 16px; }
            .connect-card { max-width: 100%; }
        }

        @media (max-width: 768px) {
            .connect-wrap { padding: 0 12px; }
            .connect-card { padding: 24px 20px; }
            .connect-header { flex-direction: column; align-items: stretch; }
            .connect-header-left { flex-wrap: wrap; }
            .connect-header h1 { font-size: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-grid .full-width { grid-column: 1; }
            .selected-provider-preview { flex-wrap: wrap; }
            .form-actions { flex-direction: column; }
            .form-actions .btn { width: 100%; justify-content: center; }
        }

        @media (max-width: 640px) {
            .connect-wrap { padding: 0 8px; }
            .connect-card { padding: 20px 16px; }
            .connect-card .card-icon { width: 52px; height: 52px; }
            .connect-card .card-icon .icon { width: 26px; height: 26px; }
            .connect-card .card-title { font-size: 16px; }
            .connect-card .card-desc { font-size: 12.5px; }
        }

        @media (max-width: 480px) {
            .connect-wrap { padding: 0 4px; }
            .connect-card { padding: 16px 12px; }
            .btn { font-size: 12px; padding: 10px 16px; }
            .btn .icon { width: 14px; height: 14px; }
            .form-control { font-size: 12.5px; padding: 10px 12px; }
            .selected-provider-preview { padding: 12px 14px; }
            .selected-provider-preview .sp-icon { width: 34px; height: 34px; }
            .selected-provider-preview .sp-icon .icon { width: 17px; height: 17px; }
            .connect-back-btn { font-size: 12px; padding: 6px 12px; }
        }
    </style>

    <div class="connect-wrap">

        <!-- ===== HEADER ===== -->
        <div class="connect-header animate-in" style="animation-delay: 0.05s;">
            <div class="connect-header-left">
                <a href="{{ route('integrations.index') }}" class="connect-back-btn">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <div>
                    <h1>Hubungkan Integrasi</h1>
                    <p>Masukkan kredensial layanan yang ingin dihubungkan.</p>
                </div>
            </div>
            <div class="connect-badge">
                <span class="dot"></span>
                Baru
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="ig-success animate-in" style="animation-delay: 0.08s; background: var(--success-soft); border: 1px solid var(--success); border-radius: var(--radius-sm); padding: 14px 20px; margin-bottom: 20px; color: var(--success); display: flex; align-items: center; gap: 10px;">
                <svg class="icon" style="width:20px;height:20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span style="font-weight:500;">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== CARD ===== -->
        <div class="connect-card animate-in" style="animation-delay: 0.10s;">

            <!-- Card Header -->
            <div class="card-icon">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
            </div>
            <div class="card-title">Konfigurasi Integrasi</div>
            <div class="card-desc">Isi informasi kredensial dari layanan yang ingin Anda hubungkan dengan sistem.</div>

            <!-- ===== FORM ===== -->
            <form method="POST" action="{{ route('integrations.store') }}" id="connectForm">
                @csrf

                <div class="form-grid">

                    <!-- Provider -->
                    <div class="form-group full-width">
                        <label>
                            Layanan <span class="required">*</span>
                        </label>
                        <div class="select-wrapper">
                            <select name="provider" class="form-control" id="providerSelect" required>
                                <option value="">Pilih Layanan</option>
                                @foreach($providers as $key => $p)
                                    <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                                        {{ $p['label'] }} ({{ $p['type'] }})
                                    </option>
                                @endforeach
                            </select>
                            <svg class="icon select-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                        @error('provider')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- Provider Preview -->
                    <div class="selected-provider-preview" id="providerPreview">
                        <div class="sp-icon" id="previewIcon" style="background: var(--theme-soft); color: var(--theme-primary);">
                            <svg class="icon"><use href="#ic-bank"/></svg>
                        </div>
                        <div class="sp-info">
                            <div class="sp-name" id="previewName">Bank & Rekening</div>
                            <div class="sp-type" id="previewType">Perbankan</div>
                            <div class="sp-desc" id="previewDesc">Hubungkan rekening bank untuk sinkronisasi transaksi otomatis.</div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="form-group full-width">
                        <label>
                            Nama Tampilan <span class="required">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Misal: Bank BCA - Utama" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- API Key -->
                    <div class="form-group">
                        <label>
                            API Key <span class="required">*</span>
                        </label>
                        <input type="text" name="api_key" value="{{ old('api_key') }}" class="form-control" placeholder="Masukkan API Key" required>
                        <div class="form-hint">
                            <svg class="icon"><use href="#ic-info"/></svg>
                            API Key diberikan oleh penyedia layanan.
                        </div>
                        @error('api_key')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- API Secret -->
                    <div class="form-group">
                        <label>
                            API Secret <span class="required">*</span>
                        </label>
                        <input type="password" name="api_secret" value="{{ old('api_secret') }}" class="form-control" placeholder="Masukkan API Secret" required>
                        <div class="form-hint">
                            <svg class="icon"><use href="#ic-lock"/></svg>
                            API Secret bersifat rahasia.
                        </div>
                        @error('api_secret')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- Webhook URL -->
                    <div class="form-group full-width">
                        <label>
                            Webhook URL <span class="optional">(opsional)</span>
                        </label>
                        <input type="url" name="webhook_url" value="{{ old('webhook_url') }}" class="form-control" placeholder="https://example.com/webhook">
                        <div class="form-hint">
                            <svg class="icon"><use href="#ic-link"/></svg>
                            Digunakan untuk menerima notifikasi real-time dari layanan ini.
                        </div>
                        @error('webhook_url')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="spinner"></span>
                        <span class="btn-text">
                            <svg class="icon"><use href="#ic-plug"/></svg>
                            Hubungkan Sekarang
                        </span>
                    </button>
                    <a href="{{ route('integrations.index') }}" class="btn btn-outline">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
        <symbol id="ic-lock" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></symbol>
        <symbol id="ic-link" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></symbol>
        <symbol id="ic-plug" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></symbol>
        
        <!-- Provider Icons -->
        <symbol id="ic-bank" viewBox="0 0 24 24">
            <rect x="2" y="10" width="20" height="14" rx="2"/>
            <path d="M12 3L2 10h20L12 3z"/>
            <line x1="8" y1="14" x2="8" y2="18"/>
            <line x1="12" y1="14" x2="12" y2="18"/>
            <line x1="16" y1="14" x2="16" y2="18"/>
        </symbol>
        <symbol id="ic-shopping-cart" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"/>
            <circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </symbol>
        <symbol id="ic-book" viewBox="0 0 24 24">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
        </symbol>
        <symbol id="ic-credit-card" viewBox="0 0 24 24">
            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
            <line x1="1" y1="10" x2="23" y2="10"/>
        </symbol>
        <symbol id="ic-package" viewBox="0 0 24 24">
            <path d="M12.89 1.45l8 4A2 2 0 0 1 22 7.24v9.53a2 2 0 0 1-1.11 1.79l-8 4a2 2 0 0 1-1.79 0l-8-4a2 2 0 0 1-1.1-1.8V7.24a2 2 0 0 1 1.11-1.79l8-4a2 2 0 0 1 1.78 0z"/>
            <polyline points="2.32 6.16 12 11 21.68 6.16"/>
            <line x1="12" y1="22.76" x2="12" y2="11"/>
        </symbol>
        <symbol id="ic-users" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== PROVIDER PREVIEW =====
            const providerSelect = document.getElementById('providerSelect');
            const preview = document.getElementById('providerPreview');
            const previewIcon = document.getElementById('previewIcon');
            const previewName = document.getElementById('previewName');
            const previewType = document.getElementById('previewType');
            const previewDesc = document.getElementById('previewDesc');

            const providers = @json($providers);
            const iconMap = {
                'bank': 'ic-bank',
                'shopping-cart': 'ic-shopping-cart',
                'book': 'ic-book',
                'credit-card': 'ic-credit-card',
                'package': 'ic-package',
                'users': 'ic-users'
            };

            function updatePreview(providerKey) {
                if (providerKey && providers[providerKey]) {
                    const p = providers[providerKey];
                    preview.classList.add('active');
                    
                    // Update icon
                    const iconName = iconMap[p.icon] || 'ic-plug';
                    previewIcon.style.background = p.bg || 'var(--theme-soft)';
                    previewIcon.style.color = p.color || 'var(--theme-primary)';
                    previewIcon.innerHTML = `<svg class="icon"><use href="#${iconName}"/></svg>`;
                    
                    previewName.textContent = p.label;
                    previewType.textContent = p.type;
                    previewDesc.textContent = p.desc;
                } else {
                    preview.classList.remove('active');
                }
            }

            // Initial preview
            const initialValue = providerSelect.value;
            if (initialValue) {
                updatePreview(initialValue);
            }

            // On change
            providerSelect.addEventListener('change', function() {
                updatePreview(this.value);
            });

            // ===== FORM SUBMIT LOADING =====
            const form = document.getElementById('connectForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.btn, .connect-back-btn');
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
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255,255,255,0.2)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'rippleAnim 0.6s ease-out forwards';
                    ripple.style.pointerEvents = 'none';
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add ripple animation
            const styleSheet = document.createElement('style');
            styleSheet.textContent = `
                @keyframes rippleAnim {
                    to { transform: scale(4); opacity: 0; }
                }
            `;
            document.head.appendChild(styleSheet);
        });
    </script>

</x-app-layout>