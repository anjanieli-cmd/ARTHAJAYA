<x-app-layout>
    <x-slot name="title">PPN - Pajak Pertambahan Nilai</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // DUMMY - ganti dengan query Tax model nanti
        $ppnData = $ppnData ?? [
            ['id' => 1, 'period' => 'Januari 2026', 'output' => 4500000, 'input' => 1200000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-02-28'],
            ['id' => 2, 'period' => 'Februari 2026', 'output' => 4800000, 'input' => 1500000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-03-31'],
            ['id' => 3, 'period' => 'Maret 2026', 'output' => 5200000, 'input' => 1800000, 'ppn' => 3400000, 'status' => 'paid', 'due' => '2026-04-30'],
            ['id' => 4, 'period' => 'April 2026', 'output' => 4900000, 'input' => 1400000, 'ppn' => 3500000, 'status' => 'pending', 'due' => '2026-05-31'],
            ['id' => 5, 'period' => 'Mei 2026', 'output' => 5100000, 'input' => 1600000, 'ppn' => 3500000, 'status' => 'pending', 'due' => '2026-06-30'],
        ];

        $ppnCollection = collect($ppnData);
        $statusLabel = ['paid' => 'Dibayar', 'pending' => 'Pending'];
        $statusPill  = ['paid' => 'paid', 'pending' => 'pending'];

        $totalPpn = $ppnCollection->sum('ppn');
        $totalPaid = $ppnCollection->where('status', 'paid')->sum('ppn');
        $totalPending = $ppnCollection->where('status', 'pending')->sum('ppn');
        
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
        .ppn-wrap {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .ppn-wrap * { box-sizing: border-box; }
        .ppn-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
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

        .ppn-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .ppn-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* SUCCESS MESSAGE */
        .ppn-success {
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

        .ppn-success .icon {
            width: 20px;
            height: 20px;
        }

        .ppn-success .message {
            font-weight: 500;
        }

        /* HEADER */
        .ppn-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ppn-header-left { flex: 1; min-width: 200px; }

        .ppn-badge {
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

        .ppn-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ppn-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ppn-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ppn-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .ppn-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ppn-btn {
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

        .ppn-btn .icon { width: 16px; height: 16px; }
        .ppn-btn:hover { transform: translateY(-2px); }
        .ppn-btn:active { transform: translateY(0) scale(0.97); }

        .ppn-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ppn-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ppn-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ppn-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ppn-btn .ripple {
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

        /* STATS */
        .ppn-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .ppn-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .ppn-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .ppn-stat .number {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .ppn-stat .number.purple { color: var(--theme-primary); }
        .ppn-stat .number.green { color: var(--success); }
        .ppn-stat .number.yellow { color: var(--warning); }

        .ppn-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }

        /* TABLE CARD */
        .ppn-card-table {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.22s ease;
        }

        .ppn-card-table:hover { border-color: var(--border-hover); }

        .ppn-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .ppn-card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .ppn-card-header .link {
            font-size: 12.5px;
            color: var(--theme-primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        .ppn-card-header .link .icon { width: 13px; height: 13px; }
        .ppn-card-header .link:hover { text-decoration: underline; }

        .ppn-table-wrap { overflow-x: auto; padding: 0 4px; }

        .ppn-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .ppn-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .ppn-table th.text-right {
            text-align: right;
        }

        .ppn-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            vertical-align: middle;
        }

        .ppn-table tbody tr { transition: background 0.2s ease; }
        .ppn-table tbody tr:hover { background: var(--bg-card-hover); }
        .ppn-table tbody tr:last-child td { border-bottom: none; }

        .ppn-amount {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            font-size: 13px;
            text-align: right;
            color: var(--text-primary);
        }

        .ppn-amount.paid { color: var(--success); }
        .ppn-amount.pending { color: var(--warning); }

        .ppn-status {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .ppn-status.paid {
            background: var(--success-soft);
            color: var(--success);
        }

        .ppn-status.pending {
            background: var(--warning-soft);
            color: var(--warning);
        }

        /* ===== ACTION BUTTONS - ALWAYS VISIBLE ===== */
        .ppn-actions-row {
            display: flex;
            gap: 4px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .ppn-btn-action {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 500;
            color: var(--text-tertiary);
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
            background: transparent;
            cursor: pointer;
        }

        .ppn-btn-action .icon {
            width: 13px;
            height: 13px;
        }

        .ppn-btn-action .action-label {
            display: none;
        }

        .ppn-btn-action:hover {
            transform: translateY(-1px);
        }

        .ppn-btn-action.show {
            color: var(--theme-primary);
            border-color: var(--theme-soft);
        }

        .ppn-btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .ppn-btn-action.edit {
            color: #4FA6E8;
            border-color: rgba(79, 166, 232, 0.2);
        }

        .ppn-btn-action.edit:hover {
            background: rgba(79, 166, 232, 0.12);
            border-color: #4FA6E8;
        }

        .ppn-btn-action.pay {
            color: var(--success);
            border-color: var(--success-soft);
        }

        .ppn-btn-action.pay:hover {
            background: var(--success-soft);
            border-color: var(--success);
        }

        .ppn-btn-action.delete {
            color: var(--danger);
            border-color: var(--danger-soft);
        }

        .ppn-btn-action.delete:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        /* Show labels on hover for desktop */
        .ppn-btn-action:hover .action-label {
            display: inline;
        }

        /* Mobile: always show labels */
        @media (max-width: 768px) {
            .ppn-btn-action .action-label {
                display: inline;
                font-size: 9px;
            }
            
            .ppn-btn-action {
                padding: 4px 8px;
                font-size: 10px;
            }
            
            .ppn-btn-action .icon {
                width: 12px;
                height: 12px;
            }
        }

        @media (max-width: 480px) {
            .ppn-btn-action .action-label {
                display: none;
            }
            
            .ppn-btn-action {
                padding: 4px 6px;
            }
            
            .ppn-btn-action .icon {
                width: 14px;
                height: 14px;
            }
        }

        /* EMPTY */
        .ppn-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-tertiary);
        }

        .ppn-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .ppn-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .ppn-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ----- MODAL DELETE ----- */
        .ppn-modal-overlay {
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
        .ppn-modal-overlay.active {
            display: flex;
        }
        .ppn-modal-box {
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
        [data-theme="light"] .ppn-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }
        .ppn-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .ppn-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .ppn-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .ppn-modal-box .ppn-desc-text {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .ppn-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .ppn-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        .ppn-modal-actions .btn {
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
        .ppn-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }
        .ppn-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        .ppn-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }
        .ppn-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .ppn-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .ppn-stats { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .ppn-table { font-size: 12px; }
            .ppn-table th, .ppn-table td { padding: 8px 10px; }
            .ppn-card-header {
                padding: 14px 16px;
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }
            .ppn-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
        }

        @media (max-width: 640px) {
            .ppn-header { flex-direction: column; }
            .ppn-actions { width: 100%; }
            .ppn-actions .ppn-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .ppn-stats { grid-template-columns: 1fr; gap: 12px; }
            .ppn-table th:nth-child(2),
            .ppn-table th:nth-child(3),
            .ppn-table td:nth-child(2),
            .ppn-table td:nth-child(3) {
                display: none;
            }
        }

        @media (max-width: 380px) {
            .ppn-header h1 { font-size: 22px; }
            .ppn-btn { font-size: 11px; padding: 6px 10px; }
            .ppn-btn .icon { width: 13px; height: 13px; }
        }
    </style>

    <div class="ppn-wrap">

        <!-- ===== HEADER ===== -->
        <div class="ppn-header animate-in" style="animation-delay: 0.05s;">
            <div class="ppn-header-left">
                <div class="ppn-badge">
                    <span class="dot"></span>
                    Pajak
                </div>
                <h1>Pajak Pertambahan Nilai (PPN)</h1>
                <p class="subtitle">
                    Kelola kewajiban PPN perusahaan — 
                    <strong>{{ $ppnCollection->count() }}</strong> periode pajak
                </p>
            </div>
            <div class="ppn-actions">
                <a href="{{ route('taxes.pph') }}" class="ppn-btn ppn-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="10" width="20" height="14" rx="2"/>
                        <path d="M12 3L2 10h20L12 3z"/>
                        <line x1="8" y1="14" x2="8" y2="18"/>
                        <line x1="12" y1="14" x2="12" y2="18"/>
                        <line x1="16" y1="14" x2="16" y2="18"/>
                    </svg>
                    PPh
                </a>
                <a href="{{ route('tax-calendar.index') }}" class="ppn-btn ppn-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Kalender Pajak
                </a>
                <a href="{{ route('taxes.ppn.create') }}" class="ppn-btn ppn-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah PPN
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="ppn-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== STATS ===== -->
        <div class="ppn-stats animate-in" style="animation-delay: 0.10s;">
            <div class="ppn-stat">
                <div class="number purple mono">{{ $currencySymbol }}{{ number_format($totalPpn, 0, ',', '.') }}</div>
                <div class="label">Total PPN</div>
            </div>
            <div class="ppn-stat">
                <div class="number green mono">{{ $currencySymbol }}{{ number_format($totalPaid, 0, ',', '.') }}</div>
                <div class="label">Sudah Dibayar</div>
            </div>
            <div class="ppn-stat">
                <div class="number yellow mono">{{ $currencySymbol }}{{ number_format($totalPending, 0, ',', '.') }}</div>
                <div class="label">Belum Dibayar</div>
            </div>
            <div class="ppn-stat">
                <div class="number">{{ $ppnCollection->where('status','paid')->count() }} / {{ $ppnCollection->count() }}</div>
                <div class="label">Periode Selesai</div>
            </div>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="ppn-card-table animate-in" style="animation-delay: 0.15s;">
            <div class="ppn-card-header">
                <h3>Daftar PPN</h3>
                <a href="#" class="link">
                    Ekspor CSV
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>

            <div class="ppn-table-wrap">
                <table class="ppn-table">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th style="text-align:right">PPN Keluaran</th>
                            <th style="text-align:right">PPN Masukan</th>
                            <th style="text-align:right">PPN</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th style="text-align:center; min-width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ppnData as $index => $p)
                            @php
                                $itemId = $p['id'] ?? $index;
                            @endphp
                            <tr>
                                <td>{{ $p['period'] }}</td>
                                <td class="ppn-amount mono">{{ $currencySymbol }}{{ number_format($p['output'], 0, ',', '.') }}</td>
                                <td class="ppn-amount mono">{{ $currencySymbol }}{{ number_format($p['input'], 0, ',', '.') }}</td>
                                <td class="ppn-amount {{ $statusPill[$p['status']] }} mono">{{ $currencySymbol }}{{ number_format($p['ppn'], 0, ',', '.') }}</td>
                                <td>{{ formatTanggal($p['due']) }}</td>
                                <td>
                                    <span class="ppn-status {{ $statusPill[$p['status']] }}">{{ $statusLabel[$p['status']] }}</span>
                                </td>
                                <td>
                                    <div class="ppn-actions-row">
                                        @if($p['status'] == 'pending')
                                            <a href="/taxes/ppn/pay/{{ $itemId }}" class="ppn-btn-action pay" title="Bayar">
                                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                                <span class="action-label">Bayar</span>
                                            </a>
                                        @endif
                                        <a href="/taxes/ppn/show/{{ $itemId }}" class="ppn-btn-action show" title="Lihat Detail">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                            <span class="action-label">Detail</span>
                                        </a>
                                        <a href="/taxes/ppn/edit/{{ $itemId }}" class="ppn-btn-action edit" title="Edit">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                                <path d="M15 5l4 4"/>
                                            </svg>
                                            <span class="action-label">Edit</span>
                                        </a>
                                        <button type="button" class="ppn-btn-action delete" title="Hapus"
                                                onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($p['period']) }}')">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"/>
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/>
                                                <path d="M14 11v6"/>
                                            </svg>
                                            <span class="action-label">Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="ppn-empty">
                                        <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="10" width="20" height="14" rx="2"/>
                                            <path d="M12 3L2 10h20L12 3z"/>
                                            <line x1="8" y1="14" x2="8" y2="18"/>
                                            <line x1="12" y1="14" x2="12" y2="18"/>
                                            <line x1="16" y1="14" x2="16" y2="18"/>
                                        </svg>
                                        <h3>Belum Ada Data PPN</h3>
                                        <p>Belum ada data PPN yang tercatat di sistem.</p>
                                        <a href="{{ route('taxes.ppn.create') }}" class="ppn-btn ppn-btn-primary" style="display: inline-flex;">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" y1="5" x2="12" y2="19"/>
                                                <line x1="5" y1="12" x2="19" y2="12"/>
                                            </svg>
                                            Tambah PPN
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
    <div class="ppn-modal-overlay" id="deleteModal">
        <div class="ppn-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Data PPN?</h3>
            <p>
                Anda yakin ingin menghapus data PPN
                <br>
                <span class="ppn-desc-text" id="deleteDesc">-</span>
            </p>
            <div class="warning-text">
                Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="ppn-modal-actions">
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
        // ===== DELETE MODAL =====
        function openDeleteModal(id, description) {
            document.getElementById('deleteDesc').textContent = description;
            var url = '/taxes/ppn/delete/' + id;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal on overlay click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // ===== RIPPLE EFFECT =====
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.ppn-btn');
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