<x-app-layout>
    <x-slot name="title">Rekonsiliasi Bank</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // Data dari session (sudah passing $reconciliations dari controller)
        $reconciliationsCollection = collect($reconciliations);
        $statusLabel = ['cocok' => 'Cocok', 'belum' => 'Belum Rekon'];
        $statusPill  = ['cocok' => 'cocok', 'belum' => 'belum'];

        $saldoBank   = $reconciliationsCollection->sum('bank');
        $saldoBuku   = $reconciliationsCollection->sum('buku');
        $selisih     = $saldoBank - $saldoBuku;
        $countBelum  = $reconciliationsCollection->where('status', 'belum')->count();
        $countCocok  = $reconciliationsCollection->where('status', 'cocok')->count();
        
        // Fungsi helper untuk format tanggal
        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }
    @endphp

    <style>
        /* ============================================
           REKONSILIASI BANK - Clean & Minimalist Design
           ============================================ */
        
        .rek-modern {
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
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .rek-modern * {
            box-sizing: border-box;
        }

        .rek-modern .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.02em;
        }

        /* ----- ANIMATIONS ----- */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .rek-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        /* ----- SVG ICON BASE ----- */
        .rek-modern .icon {
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

        /* ----- HEADER SECTION ----- */
        .rek-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .rek-header-left {
            flex: 1;
            min-width: 200px;
        }

        .rek-badge {
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

        .rek-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .rek-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .rek-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .rek-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .rek-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .rek-btn {
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
        }

        .rek-btn .icon {
            width: 16px;
            height: 16px;
        }

        .rek-btn:hover {
            transform: translateY(-2px);
        }

        .rek-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .rek-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .rek-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .rek-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .rek-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .rek-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* ----- SUCCESS MESSAGE ----- */
        .rek-success {
            background: var(--success-soft);
            border: 1px solid var(--success);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
            margin-bottom: 20px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rek-success .icon {
            width: 20px;
            height: 20px;
        }

        .rek-success .message {
            font-weight: 500;
        }

        /* ----- STATS ROW ----- */
        .rek-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .rek-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .rek-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--theme-light), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .rek-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .rek-stat-card:hover::before {
            opacity: 1;
        }

        .rek-stat-card .stat-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .rek-stat-card .stat-head .ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .rek-stat-card .stat-head .ic .icon {
            width: 17px;
            height: 17px;
        }

        .rek-stat-card .stat-head .badge {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 100px;
            background: var(--warning-soft);
            color: var(--warning);
        }

        .rek-stat-card .stat-head .badge.success {
            background: var(--success-soft);
            color: var(--success);
        }

        .rek-stat-card .stat-label {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .rek-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .rek-stat-card .stat-value.primary {
            color: var(--theme-primary);
        }

        .rek-stat-card .stat-value.success {
            color: var(--success);
        }

        .rek-stat-card .stat-value.warning {
            color: var(--warning);
        }

        .rek-stat-card .stat-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* ----- TABLE CARD ----- */
        .rek-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.22s ease;
        }

        .rek-card:hover {
            border-color: var(--border-hover);
        }

        .rek-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .rek-card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .rek-card-header .link {
            font-size: 12.5px;
            color: var(--theme-primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        .rek-card-header .link .icon {
            width: 13px;
            height: 13px;
        }

        .rek-card-header .link:hover {
            text-decoration: underline;
        }

        /* ----- TABLE ----- */
        .rek-table-wrap {
            overflow-x: auto;
            padding: 0 4px;
        }

        .rek-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .rek-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .rek-table th.text-right {
            text-align: right;
        }

        .rek-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            vertical-align: middle;
        }

        .rek-table tbody tr {
            transition: background 0.2s ease;
        }

        .rek-table tbody tr:hover {
            background: var(--bg-card-hover);
        }

        .rek-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ----- DESCRIPTION ----- */
        .rek-desc {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rek-desc .icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
            flex-shrink: 0;
        }

        .rek-desc .icon-wrap .icon {
            width: 15px;
            height: 15px;
        }

        .rek-desc .text {
            font-weight: 500;
            color: var(--text-primary);
        }

        /* ----- STATUS PILL ----- */
        .rek-status {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .rek-status.cocok {
            background: var(--success-soft);
            color: var(--success);
        }

        .rek-status.belum {
            background: var(--warning-soft);
            color: var(--warning);
        }

        /* ----- AMOUNT ----- */
        .rek-amount {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            font-size: 13.5px;
            text-align: right;
            color: var(--text-primary);
        }

        .rek-amount.different {
            color: var(--warning);
        }

        /* ----- ACTION BUTTONS ----- */
        .rek-item-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }

        .rek-item-actions .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            color: var(--text-tertiary);
            background: transparent;
            border: 1px solid var(--border-color);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 13px;
        }

        .rek-item-actions .btn-action .icon {
            width: 14px;
            height: 14px;
        }

        .rek-item-actions .btn-action.show {
            color: var(--theme-primary);
        }

        .rek-item-actions .btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .rek-item-actions .btn-action.edit {
            color: #4FA6E8;
        }

        .rek-item-actions .btn-action.edit:hover {
            background: rgba(79, 166, 232, 0.12);
            border-color: #4FA6E8;
        }

        .rek-item-actions .btn-action.danger {
            color: var(--danger);
        }

        .rek-item-actions .btn-action.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        /* ----- EMPTY STATE ----- */
        .rek-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-tertiary);
        }

        .rek-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .rek-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .rek-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ----- MODAL DELETE ----- */
        .rek-modal-overlay {
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
        .rek-modal-overlay.active {
            display: flex;
        }
        .rek-modal-box {
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
        [data-theme="light"] .rek-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }
        .rek-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .rek-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .rek-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .rek-modal-box .rek-desc-text {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .rek-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .rek-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        .rek-modal-actions .btn {
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
        .rek-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }
        .rek-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        .rek-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }
        .rek-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .rek-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .rek-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .rek-table {
                font-size: 12.5px;
            }

            .rek-table th,
            .rek-table td {
                padding: 10px 12px;
            }

            .rek-card-header {
                padding: 14px 16px;
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .rek-item-actions {
                justify-content: flex-start;
            }
        }

        @media (max-width: 640px) {
            .rek-header {
                flex-direction: column;
            }
            
            .rek-header-actions {
                width: 100%;
            }
            
            .rek-header-actions .rek-btn {
                flex: 1;
                justify-content: center;
            }

            .rek-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .rek-stat-card .stat-value {
                font-size: 22px;
            }

            .rek-desc .text {
                font-size: 12.5px;
            }

            .rek-item-actions {
                opacity: 1;
            }
        }

        @media (max-width: 380px) {
            .rek-header h1 {
                font-size: 22px;
            }
            .rek-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .rek-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="rek-modern">

        <!-- ===== HEADER ===== -->
        <div class="rek-header animate-in" style="animation-delay: 0.05s;">
            <div class="rek-header-left">
                <div class="rek-badge">
                    <span class="dot"></span>
                    Perbankan
                </div>
                <h1>Rekonsiliasi Bank</h1>
                <p class="subtitle">
                    Cocokkan mutasi rekening bank dengan catatan pembukuan — 
                    <strong>{{ $reconciliationsCollection->count() }}</strong> transaksi
                </p>
            </div>
            <div class="rek-header-actions">
                <a href="{{ route('bank-mutations.index') }}" class="rek-btn rek-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="10" width="20" height="14" rx="2"/>
                        <path d="M12 3L2 10h20L12 3z"/>
                        <line x1="8" y1="14" x2="8" y2="18"/>
                        <line x1="12" y1="14" x2="12" y2="18"/>
                        <line x1="16" y1="14" x2="16" y2="18"/>
                    </svg>
                    Mutasi Rekening
                </a>
                <a href="{{ route('reconciliation.create') }}" class="rek-btn rek-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Rekonsiliasi
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="rek-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== STATS ===== -->
        <div class="rek-stats">
            <div class="rek-stat-card animate-in" style="animation-delay: 0.10s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="10" width="20" height="14" rx="2"/>
                            <path d="M12 3L2 10h20L12 3z"/>
                            <line x1="8" y1="14" x2="8" y2="18"/>
                            <line x1="12" y1="14" x2="12" y2="18"/>
                            <line x1="16" y1="14" x2="16" y2="18"/>
                        </svg>
                    </div>
                    <span class="badge success">{{ $countCocok }} transaksi</span>
                </div>
                <div class="stat-label">Saldo Bank</div>
                <div class="stat-value primary mono">{{ $currencySymbol }}{{ number_format($saldoBank, 0, ',', '.') }}</div>
                <div class="stat-sub">Mutasi rekening bank</div>
            </div>

            <div class="rek-stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-label">Saldo Buku</div>
                <div class="stat-value success mono">{{ $currencySymbol }}{{ number_format($saldoBuku, 0, ',', '.') }}</div>
                <div class="stat-sub">Catatan pembukuan</div>
            </div>

            <div class="rek-stat-card animate-in" style="animation-delay: 0.20s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/>
                            <polyline points="17 18 23 18 23 12"/>
                        </svg>
                    </div>
                    <span class="badge">{{ $countBelum }} transaksi</span>
                </div>
                <div class="stat-label">Selisih Belum Rekon</div>
                <div class="stat-value warning mono">{{ $currencySymbol }}{{ number_format($selisih, 0, ',', '.') }}</div>
                <div class="stat-sub">Perlu ditelusuri</div>
            </div>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="rek-card animate-in" style="animation-delay: 0.25s;">
            <div class="rek-card-header">
                <h3>Daftar Rekonsiliasi</h3>
                <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="link">
                    Buku besar bank
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>

            <div class="rek-table-wrap">
                <table class="rek-table">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th class="text-right">Jumlah Bank</th>
                            <th class="text-right">Jumlah Buku</th>
                            <th>Status</th>
                            <th style="width:120px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reconciliations as $index => $item)
                            @php
                                $itemId = $item['id'] ?? $index;
                            @endphp
                            <tr>
                                <td>
                                    <div class="rek-desc">
                                        <div class="icon-wrap">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="2" y="10" width="20" height="14" rx="2"/>
                                                <path d="M12 3L2 10h20L12 3z"/>
                                                <line x1="8" y1="14" x2="8" y2="18"/>
                                                <line x1="12" y1="14" x2="12" y2="18"/>
                                                <line x1="16" y1="14" x2="16" y2="18"/>
                                            </svg>
                                        </div>
                                        <span class="text">{{ $item['desc'] }}</span>
                                    </div>
                                </td>
                                <td>{{ formatTanggal($item['date']) }}</td>
                                <td class="rek-amount mono">
                                    {{ $currencySymbol }}{{ number_format($item['bank'], 0, ',', '.') }}
                                </td>
                                <td class="rek-amount mono {{ $item['bank'] != $item['buku'] ? 'different' : '' }}">
                                    {{ $currencySymbol }}{{ number_format($item['buku'], 0, ',', '.') }}
                                    @if($item['bank'] != $item['buku'])
                                        <span style="font-size:10px; color: var(--warning); margin-left:4px;">(!)</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="rek-status {{ $statusPill[$item['status']] }}">
                                        {{ $statusLabel[$item['status']] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="rek-item-actions">
                                        <a href="/reconciliation/show/{{ $itemId }}" class="btn-action show" title="Lihat Detail">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                        <a href="/reconciliation/edit/{{ $itemId }}" class="btn-action edit" title="Edit">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                                <path d="M15 5l4 4"/>
                                            </svg>
                                        </a>
                                        <button type="button" class="btn-action danger" title="Hapus"
                                                onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($item['desc']) }}')">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"/>
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/>
                                                <path d="M14 11v6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="rek-empty">
                                        <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="10" width="20" height="14" rx="2"/>
                                            <path d="M12 3L2 10h20L12 3z"/>
                                            <line x1="8" y1="14" x2="8" y2="18"/>
                                            <line x1="12" y1="14" x2="12" y2="18"/>
                                            <line x1="16" y1="14" x2="16" y2="18"/>
                                        </svg>
                                        <h3>Belum Ada Data Rekonsiliasi</h3>
                                        <p>Belum ada transaksi yang direkonsiliasi.</p>
                                        <a href="{{ route('reconciliation.create') }}" class="rek-btn rek-btn-primary" style="display: inline-flex;">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" y1="5" x2="12" y2="19"/>
                                                <line x1="5" y1="12" x2="19" y2="12"/>
                                            </svg>
                                            Mulai Rekonsiliasi
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="rek-modal-overlay" id="deleteModal">
        <div class="rek-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Rekonsiliasi?</h3>
            <p>
                Anda yakin ingin menghapus data rekonsiliasi
                <br>
                <span class="rek-desc-text" id="deleteDesc">-</span>
            </p>
            <div class="warning-text">
                Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="rek-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <path d="M3 6h18"/>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                        </svg>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id, description) {
            document.getElementById('deleteDesc').textContent = description;
            var url = '/reconciliation/delete/' + id;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
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

        document.addEventListener('DOMContentLoaded', function() {
            // Ripple effect untuk tombol
            const buttons = document.querySelectorAll('.rek-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

</x-app-layout>