<x-app-layout>
    <x-slot name="title">Integrasi</x-slot>

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

        // Connected providers
        $connected = $connected ?? collect([
            (object) ['id' => 1, 'provider' => 'bank', 'status' => 'connected', 'last_sync' => '2026-07-20 14:30:00'],
            (object) ['id' => 2, 'provider' => 'ecommerce', 'status' => 'error', 'last_sync' => '2026-07-19 09:15:00'],
            (object) ['id' => 3, 'provider' => 'payment', 'status' => 'connected', 'last_sync' => '2026-07-21 10:00:00'],
        ])->keyBy('provider');

        $statusLabel = [
            'connected' => 'Terhubung',
            'disconnected' => 'Belum Terhubung',
            'error' => 'Error',
            'pending' => 'Menunggu'
        ];
        $statusBadge = [
            'connected' => 'connected',
            'disconnected' => 'disconnected',
            'error' => 'error',
            'pending' => 'pending'
        ];
        $statusIcon = [
            'connected' => 'check-circle',
            'disconnected' => 'circle',
            'error' => 'x-circle',
            'pending' => 'clock'
        ];

        $totalConnected = $connected->where('status', 'connected')->count();
        $totalError = $connected->where('status', 'error')->count();
        $totalPending = $connected->where('status', 'pending')->count();
        $totalDisconnected = count($providers) - $connected->count();
    @endphp

    <style>
        /* ============================================
           INTEGRASI - Modern Design
           ============================================ */
        
        .ig-wrap {
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

        .ig-wrap * { box-sizing: border-box; }
        .ig-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .ig-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .ig-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .ig-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ig-header-left { flex: 1; min-width: 200px; }

        .ig-badge {
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
            margin-bottom: 12px;
        }

        .ig-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ig-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ig-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ig-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .ig-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ig-btn {
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

        .ig-btn .icon { width: 16px; height: 16px; }
        .ig-btn:hover { transform: translateY(-2px); }
        .ig-btn:active { transform: translateY(0) scale(0.97); }

        .ig-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ig-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ig-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ig-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ig-btn-success {
            background: var(--success);
            color: #fff;
        }

        .ig-btn-success:hover {
            background: #2d9d75;
            transform: translateY(-2px);
            color: #fff;
            box-shadow: 0 8px 22px rgba(52, 181, 131, 0.35);
        }

        .ig-btn .ripple {
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

        /* SUCCESS MESSAGE */
        .ig-success {
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

        .ig-success .icon { width: 20px; height: 20px; }

        /* SEARCH BAR */
        .ig-search {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px 20px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .ig-search:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .ig-search form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .ig-search-wrap {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .ig-search-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .ig-search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .ig-search input[type="text"] {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid transparent;
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .ig-search input[type="text"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .ig-search input[type="text"]::placeholder {
            color: var(--text-tertiary);
        }

        .ig-search-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .ig-search-actions .ig-btn {
            padding: 8px 14px;
            font-size: 12px;
        }

        .search-indicator {
            font-size: 12px;
            color: var(--text-tertiary);
            padding: 4px 12px;
            background: var(--bg-card-active);
            border-radius: 20px;
            white-space: nowrap;
            display: none;
            align-items: center;
            gap: 6px;
        }

        .search-indicator.active {
            display: inline-flex;
        }

        .search-indicator .count {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* STATS */
        .ig-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .ig-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ig-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--theme-light), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ig-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .ig-stat:hover::before {
            opacity: 1;
        }

        .ig-stat .stat-icon {
            width: 28px;
            height: 28px;
            margin-bottom: 6px;
            color: var(--text-secondary);
        }

        .ig-stat .number {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .ig-stat .number.purple { color: var(--theme-primary); }
        .ig-stat .number.green { color: var(--success); }
        .ig-stat .number.red { color: var(--danger); }
        .ig-stat .number.blue { color: var(--info); }
        .ig-stat .number.yellow { color: var(--warning); }

        .ig-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 4px;
            font-weight: 600;
        }

        /* GRID */
        .ig-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .ig-grid.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .ig-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .ig-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: linear-gradient(90deg, var(--theme-primary), var(--theme-light));
        }

        .ig-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-6px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.08);
        }

        .ig-card:hover::before {
            opacity: 1;
        }

        .ig-card.hidden-card {
            display: none;
        }

        .ig-card.visible-card {
            display: block;
            animation: fadeSlideUp 0.3s ease forwards;
        }

        .ig-card .ig-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .ig-card .ig-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .ig-card .ig-icon .icon {
            width: 24px;
            height: 24px;
        }

        .ig-card:hover .ig-icon {
            transform: scale(1.05) rotate(-3deg);
        }

        .ig-card .ig-status {
            font-size: 11px;
            padding: 4px 14px;
            border-radius: 100px;
            font-weight: 600;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ig-card .ig-status .icon {
            width: 14px;
            height: 14px;
        }

        .ig-card .ig-status.connected {
            background: var(--success-soft);
            color: var(--success);
        }

        .ig-card .ig-status.disconnected {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }

        .ig-card .ig-status.error {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .ig-card .ig-status.pending {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .ig-card .ig-name {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .ig-card .ig-type {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 500;
        }

        .ig-card .ig-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 12px 0 16px;
            min-height: 42px;
        }

        .ig-card .ig-foot {
            display: flex;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .ig-card .ig-foot .ig-btn {
            flex: 1;
            justify-content: center;
            padding: 9px 16px;
            font-size: 12px;
        }

        .ig-card .ig-sync-info {
            font-size: 11px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            padding: 8px 12px;
            background: var(--bg-card-active);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .ig-card .ig-sync-info .icon {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        .ig-card .ig-sync-info .syncing {
            animation: spin 1s linear infinite;
        }

        .ig-card .ig-sync-info.success {
            color: var(--success);
            background: var(--success-soft);
        }

        .ig-card .ig-sync-info.error {
            color: var(--danger);
            background: var(--danger-soft);
        }

        /* EMPTY */
        .ig-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
            grid-column: 1 / -1;
        }

        .ig-empty .empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            color: var(--text-tertiary);
            opacity: 0.5;
        }

        .ig-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .ig-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        .ig-empty.hidden {
            display: none;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 1200px) {
            .ig-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .ig-stats { grid-template-columns: 1fr 1fr; }
            .ig-wrap { padding: 0 16px; }
            .ig-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .ig-wrap { padding: 0 12px; }
            .ig-grid { grid-template-columns: 1fr; }
            .ig-search { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 10px; 
                padding: 12px 16px;
            }
            .ig-search form { flex-direction: column; }
            .ig-search-wrap { min-width: 100%; }
            .ig-search-actions { 
                width: 100%; 
                justify-content: flex-end; 
                flex-wrap: wrap;
            }
            .ig-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .ig-stat { padding: 16px 18px; }
            .ig-stat .number { font-size: 22px; }
            .ig-card { padding: 20px; }
            .ig-header { flex-direction: column; }
            .ig-actions { width: 100%; }
            .ig-actions .ig-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
        }

        @media (max-width: 640px) {
            .ig-wrap { padding: 0 8px; }
            .ig-stats { grid-template-columns: 1fr 1fr; }
            .ig-card .ig-icon { width: 44px; height: 44px; }
            .ig-card .ig-icon .icon { width: 20px; height: 20px; }
            .ig-card .ig-name { font-size: 15px; }
            .ig-card .ig-desc { font-size: 12px; min-height: 36px; }
        }

        @media (max-width: 480px) {
            .ig-wrap { padding: 0 4px; }
            .ig-header h1 { font-size: 22px; }
            .ig-stats { grid-template-columns: 1fr; }
            .ig-stat { padding: 14px 16px; }
            .ig-stat .number { font-size: 20px; }
            .ig-card { padding: 16px; }
            .ig-card .ig-foot { flex-direction: column; }
            .ig-card .ig-foot .ig-btn { width: 100%; }
            .ig-btn { font-size: 11px; padding: 6px 10px; }
            .ig-btn .icon { width: 14px; height: 14px; }
            .ig-search-actions .ig-btn { font-size: 11px; padding: 6px 10px; }
        }
    </style>

    <div class="ig-wrap">

        <!-- ===== HEADER ===== -->
        <div class="ig-header animate-in" style="animation-delay: 0.05s;">
            <div class="ig-header-left">
                <div class="ig-badge">
                    <span class="dot"></span>
                    Integrasi
                </div>
                <h1>Integrasi Layanan</h1>
                <p class="subtitle">
                    Hubungkan layanan pihak ketiga untuk memperluas fungsi sistem — 
                    <strong id="igTotalCount">{{ count($providers) }}</strong> integrasi tersedia
                </p>
            </div>
            <div class="ig-actions">
                <button class="ig-btn ig-btn-ghost" id="igRefreshBtn">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Refresh
                </button>
                <a href="{{ route('integrations.create') }}" class="ig-btn ig-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Integrasi
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="ig-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span style="font-weight:500;">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== SEARCH BAR ===== -->
        <div class="ig-search animate-in" style="animation-delay: 0.10s;">
            <form method="GET" action="{{ route('integrations.index') }}" id="igSearchForm" onsubmit="return false;">
                <div class="ig-search-wrap">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="q" id="igSearchInput" value="{{ request('q') }}" 
                           placeholder="Cari integrasi berdasarkan nama atau jenis layanan..." autocomplete="off">
                </div>
                <div class="ig-search-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <button class="ig-btn ig-btn-ghost" id="igResetBtn" type="button">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== STATS ===== -->
        <div class="ig-stats animate-in" style="animation-delay: 0.12s;" id="igStats">
            <div class="ig-stat">
                <svg class="icon stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                <div class="number purple mono" id="statTotal">{{ count($providers) }}</div>
                <div class="label">Total Integrasi</div>
            </div>
            <div class="ig-stat">
                <svg class="icon stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <div class="number green mono" id="statConnected">{{ $totalConnected }}</div>
                <div class="label">Terhubung</div>
            </div>
            <div class="ig-stat">
                <svg class="icon stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <div class="number red mono" id="statError">{{ $totalError }}</div>
                <div class="label">Error</div>
            </div>
            <div class="ig-stat">
                <svg class="icon stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <circle cx="12" cy="12" r="4"/>
                </svg>
                <div class="number blue mono" id="statDisconnected">{{ $totalDisconnected }}</div>
                <div class="label">Belum Terhubung</div>
            </div>
        </div>

        <!-- ===== INTEGRATION GRID ===== -->
        <div class="ig-grid" id="igGrid">
            @forelse($providers as $key => $p)
                @php
                    $item = $connected->get($key);
                    $status = $item ? $item->status : 'disconnected';
                    $statusDisplay = $statusLabel[$status] ?? 'Belum Terhubung';
                    $statusClass = $statusBadge[$status] ?? 'disconnected';
                    $color = $p['color'] ?? '#34B583';
                    $bg = $p['bg'] ?? 'rgba(52,181,131,0.12)';
                    $icon = $p['icon'] ?? 'box';
                @endphp
                <div class="ig-card ig-card-data visible-card animate-in" 
                     style="animation-delay: {{ 0.15 + ($loop->index * 0.06) }}s;"
                     data-name="{{ strtolower($p['label']) }}"
                     data-type="{{ strtolower($p['type']) }}"
                     data-status="{{ $status }}"
                     data-provider="{{ $key }}">
                    
                    <div class="ig-top">
                        <div class="ig-icon" style="background: {{ $bg }}; border-color: {{ $color }}40; color: {{ $color }};">
                            @if($icon == 'bank')
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="10" width="20" height="14" rx="2"/>
                                    <path d="M12 3L2 10h20L12 3z"/>
                                    <line x1="8" y1="14" x2="8" y2="18"/>
                                    <line x1="12" y1="14" x2="12" y2="18"/>
                                    <line x1="16" y1="14" x2="16" y2="18"/>
                                </svg>
                            @elseif($icon == 'shopping-cart')
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="9" cy="21" r="1"/>
                                    <circle cx="20" cy="21" r="1"/>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                            @elseif($icon == 'book')
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            @elseif($icon == 'credit-card')
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                    <line x1="1" y1="10" x2="23" y2="10"/>
                                </svg>
                            @elseif($icon == 'package')
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12.89 1.45l8 4A2 2 0 0 1 22 7.24v9.53a2 2 0 0 1-1.11 1.79l-8 4a2 2 0 0 1-1.79 0l-8-4a2 2 0 0 1-1.1-1.8V7.24a2 2 0 0 1 1.11-1.79l8-4a2 2 0 0 1 1.78 0z"/>
                                    <polyline points="2.32 6.16 12 11 21.68 6.16"/>
                                    <line x1="12" y1="22.76" x2="12" y2="11"/>
                                </svg>
                            @elseif($icon == 'users')
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            @else
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                </svg>
                            @endif
                        </div>
                        <span class="ig-status {{ $statusClass }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                @if($status == 'connected')
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                @elseif($status == 'error')
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                @elseif($status == 'pending')
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                @else
                                    <circle cx="12" cy="12" r="10"/>
                                    <circle cx="12" cy="12" r="4"/>
                                @endif
                            </svg>
                            {{ $statusDisplay }}
                        </span>
                    </div>

                    <div class="ig-name">{{ $p['label'] }}</div>
                    <div class="ig-type">{{ $p['type'] }}</div>
                    <div class="ig-desc">{{ $p['desc'] }}</div>

                    @if($item && isset($item->last_sync) && $item->last_sync)
                        <div class="ig-sync-info">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Sinkronisasi terakhir: {{ \Carbon\Carbon::parse($item->last_sync)->diffForHumans() }}
                        </div>
                    @endif

                    <div class="ig-foot">
                        @if($item)
                            <a href="{{ route('integrations.edit', $item->id) }}" class="ig-btn ig-btn-ghost">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Kelola
                            </a>
                            @if($status == 'connected')
                                <button class="ig-btn ig-btn-success" onclick="syncIntegration('{{ $key }}')">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="23 4 23 10 17 10"/>
                                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                                    </svg>
                                    Sinkronisasi
                                </button>
                            @elseif($status == 'error')
                                <button class="ig-btn ig-btn-primary" onclick="reconnectIntegration('{{ $key }}')">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="23 4 23 10 17 10"/>
                                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                                    </svg>
                                    Hubungkan Ulang
                                </button>
                            @endif
                        @else
                            <a href="{{ route('integrations.create', ['provider' => $key]) }}" class="ig-btn ig-btn-primary">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Hubungkan
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="ig-empty" id="emptyState">
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    <h3>Belum Ada Integrasi</h3>
                    <p>Mulai hubungkan layanan pihak ketiga untuk memperluas fungsi sistem Anda.</p>
                    <a href="{{ route('integrations.create') }}" class="ig-btn ig-btn-primary" style="display: inline-flex;">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Tambah Integrasi
                    </a>
                </div>
            @endforelse
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.ig-btn');
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
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // ===== LIVE SEARCH =====
            const searchInput = document.getElementById('igSearchInput');
            const resetBtn = document.getElementById('igResetBtn');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchResultCount = document.getElementById('searchResultCount');
            const totalCountEl = document.getElementById('igTotalCount');
            const statTotal = document.getElementById('statTotal');
            const statConnected = document.getElementById('statConnected');
            const statError = document.getElementById('statError');
            const statDisconnected = document.getElementById('statDisconnected');
            const igGrid = document.getElementById('igGrid');
            const emptyState = document.getElementById('emptyState');
            let debounceTimeout = null;

            function normalizeText(text) {
                if (!text) return '';
                return text.toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .trim();
            }

            function filterData() {
                const searchText = searchInput ? searchInput.value.trim() : '';
                const normalizedSearch = normalizeText(searchText);

                const cards = document.querySelectorAll('.ig-card-data');
                let visibleCount = 0;
                let connectedCount = 0;
                let errorCount = 0;
                let disconnectedCount = 0;

                cards.forEach(card => {
                    const name = card.dataset.name || '';
                    const type = card.dataset.type || '';
                    const status = card.dataset.status || '';

                    const match = searchText === '' || 
                        normalizeText(name).includes(normalizedSearch) ||
                        normalizeText(type).includes(normalizedSearch);

                    if (match) {
                        card.classList.remove('hidden-card');
                        card.classList.add('visible-card');
                        visibleCount++;
                        if (status === 'connected') connectedCount++;
                        else if (status === 'error') errorCount++;
                        else disconnectedCount++;
                    } else {
                        card.classList.remove('visible-card');
                        card.classList.add('hidden-card');
                    }
                });

                // Update search indicator
                if (searchText !== '') {
                    searchIndicator.classList.add('active');
                    searchResultCount.textContent = visibleCount;
                } else {
                    searchIndicator.classList.remove('active');
                }

                // Update stats
                statTotal.textContent = visibleCount;
                statConnected.textContent = connectedCount;
                statError.textContent = errorCount;
                statDisconnected.textContent = disconnectedCount;
                totalCountEl.textContent = visibleCount;

                // Show/hide empty state
                if (emptyState) {
                    if (visibleCount === 0 && searchText !== '') {
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Tidak Ada Hasil Pencarian';
                        emptyState.querySelector('p').textContent = 'Tidak ditemukan integrasi yang sesuai dengan kata kunci "' + searchText + '"';
                        const btn = emptyState.querySelector('.ig-btn');
                        if (btn) btn.style.display = 'none';
                    } else if (visibleCount === 0) {
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Belum Ada Integrasi';
                        emptyState.querySelector('p').textContent = 'Mulai hubungkan layanan pihak ketiga untuk memperluas fungsi sistem Anda.';
                        const btn = emptyState.querySelector('.ig-btn');
                        if (btn) btn.style.display = 'inline-flex';
                    } else {
                        emptyState.classList.add('hidden');
                    }
                }
            }

            // Search input
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    igGrid.style.opacity = '0.5';
                    igGrid.style.pointerEvents = 'none';

                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(function() {
                        filterData();
                        igGrid.style.opacity = '1';
                        igGrid.style.pointerEvents = 'auto';

                        const url = new URL(window.location.href);
                        if (searchInput.value.trim() !== '') {
                            url.searchParams.set('q', searchInput.value.trim());
                        } else {
                            url.searchParams.delete('q');
                        }
                        window.history.replaceState({}, '', url.toString());
                    }, 300);
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                    if (e.key === '/' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        const activeElement = document.activeElement;
                        if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA')) {
                            return;
                        }
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                });
            }

            // Reset button
            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchInput) searchInput.value = '';
                    filterData();

                    const url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    window.history.replaceState({}, '', url.toString());

                    if (searchIndicator) searchIndicator.classList.remove('active');
                    if (igGrid) {
                        igGrid.style.opacity = '1';
                        igGrid.style.pointerEvents = 'auto';
                    }
                });
            }

            // ===== REFRESH BUTTON =====
            const refreshBtn = document.getElementById('igRefreshBtn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const icon = this.querySelector('.icon');
                    icon.style.animation = 'spin 1s linear infinite';
                    
                    setTimeout(() => {
                        icon.style.animation = '';
                        location.reload();
                    }, 1000);
                });
            }

            // Initial filter
            setTimeout(function() {
                filterData();
            }, 100);
        });

        // ===== SYNC INTEGRATION =====
        function syncIntegration(provider) {
            const card = document.querySelector(`.ig-card-data[data-provider="${provider}"]`);
            if (!card) return;

            const syncInfo = card.querySelector('.ig-sync-info');
            if (syncInfo) {
                syncInfo.innerHTML = `
                    <svg class="icon syncing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Menyinkronisasi data...
                `;
                syncInfo.className = 'ig-sync-info';
            }

            // Simulate sync
            setTimeout(() => {
                if (syncInfo) {
                    syncInfo.innerHTML = `
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Sinkronisasi berhasil! ${new Date().toLocaleTimeString()}
                    `;
                    syncInfo.className = 'ig-sync-info success';
                    
                    setTimeout(() => {
                        syncInfo.className = 'ig-sync-info';
                        syncInfo.innerHTML = `
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Sinkronisasi terakhir: Baru saja
                        `;
                    }, 3000);
                }
            }, 2000);
        }

        // ===== RECONNECT INTEGRATION =====
        function reconnectIntegration(provider) {
            if (confirm('Apakah Anda yakin ingin menghubungkan ulang integrasi ini?')) {
                const card = document.querySelector(`.ig-card-data[data-provider="${provider}"]`);
                if (!card) return;

                const statusEl = card.querySelector('.ig-status');
                if (statusEl) {
                    statusEl.className = 'ig-status pending';
                    statusEl.innerHTML = `
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Menghubungkan...
                    `;
                }

                setTimeout(() => {
                    if (statusEl) {
                        statusEl.className = 'ig-status connected';
                        statusEl.innerHTML = `
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            Terhubung
                        `;
                        
                        // Show success message
                        const syncInfo = card.querySelector('.ig-sync-info');
                        if (syncInfo) {
                            syncInfo.className = 'ig-sync-info success';
                            syncInfo.innerHTML = `
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                Koneksi berhasil dipulihkan!
                            `;
                            setTimeout(() => {
                                syncInfo.className = 'ig-sync-info';
                                syncInfo.innerHTML = `
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    Sinkronisasi terakhir: Baru saja
                                `;
                            }, 3000);
                        }
                    }
                }, 2000);
            }
        }
    </script>

</x-app-layout>