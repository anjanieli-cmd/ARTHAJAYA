<x-admin-layout>
    <x-slot name="title">Statistik Sistem</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6M9 11h6M9 15h3"/>
            </symbol>
            <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </symbol>
            <symbol id="ic-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-pause-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </symbol>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/>
            </symbol>
            <symbol id="ic-bar-chart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>
            </symbol>
            <symbol id="ic-award" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="6"/><polyline points="9 14 9 22 12 20 15 22 15 14"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-refresh" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .stw {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .stw * { box-sizing:border-box; }

        .stw .mono {
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

        @keyframes growBar {
            from { height: 0 !important; }
        }

        .stw .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .stw .icon {
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
        .stw-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .stw-header-left {
            flex: 1;
            min-width: 200px;
        }

        .stw-badge {
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

        .stw-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .stw-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .stw-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stw-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .stw-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .stw-btn {
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

        .stw-btn .icon {
            width: 16px;
            height: 16px;
        }

        .stw-btn:hover {
            transform: translateY(-2px);
        }

        .stw-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .stw-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .stw-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .stw-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .stw-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .stw-btn .ripple {
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

        /* ===== TOP METRIC ROW ===== */
        .metric-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1px;
            background: var(--border-color);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .metric-cell {
            background: var(--bg-card);
            padding: 24px 18px;
            text-align: center;
            transition: background 0.3s ease;
        }

        .metric-cell:hover {
            background: var(--bg-card-hover);
        }

        .metric-cell .ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .metric-cell .ic .icon {
            width: 17px;
            height: 17px;
        }

        .metric-cell .n {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .metric-cell .l {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ===== CHART PANEL ===== */
        .stw-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 18px;
            margin-bottom: 18px;
            align-items: start;
        }

        .chart-panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 26px 28px;
            transition: border-color 0.3s ease;
        }

        .chart-panel:hover {
            border-color: var(--border-hover);
        }

        .chart-panel .panel-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .chart-panel .panel-head .pi {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .chart-panel .panel-head .pi .icon {
            width: 15px;
            height: 15px;
        }

        .chart-panel h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 14px;
            height: 150px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        .bar-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            height: 100%;
            justify-content: flex-end;
        }

        .bar-fill {
            width: 100%;
            max-width: 40px;
            border-radius: 6px 6px 0 0;
            background: linear-gradient(180deg, var(--emerald), var(--emerald-dim));
            animation: growBar 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            min-height: 4px;
            transition: height 0.5s ease;
        }

        .bar-fill .bv {
            position: absolute;
            top: -22px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 11px;
            font-weight: 700;
            color: var(--text-primary);
            font-family: 'IBM Plex Mono', monospace;
        }

        .bar-lbl {
            font-size: 10.5px;
            color: var(--text-tertiary);
            margin-top: 6px;
            text-align: center;
            font-weight: 500;
        }

        /* ===== ACCESS LEVEL BARS ===== */
        .level-bars {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .level-row .lr-top {
            display: flex;
            justify-content: space-between;
            font-size: 12.5px;
            margin-bottom: 6px;
        }

        .level-row .lr-top .name {
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .level-row .lr-top .name .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .level-row .lr-top .count {
            color: var(--text-secondary);
            font-weight: 600;
        }

        .level-row .lr-track {
            height: 8px;
            border-radius: 100px;
            background: var(--bg-card-active);
            overflow: hidden;
        }

        .level-row .lr-fill {
            height: 100%;
            border-radius: 100px;
            transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
            width: 0;
        }

        .level-row.admin .lr-fill {
            background: var(--emerald);
        }
        .level-row.admin .lr-top .name .dot {
            background: var(--emerald);
        }

        .level-row.staff .lr-fill {
            background: #4E8FF0;
        }
        .level-row.staff .lr-top .name .dot {
            background: #4E8FF0;
        }

        .level-row.user .lr-fill {
            background: var(--text-tertiary);
        }
        .level-row.user .lr-top .name .dot {
            background: var(--text-tertiary);
        }

        /* ===== TOP COMPANIES LIST ===== */
        .top-list {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 26px 28px;
            transition: border-color 0.3s ease;
        }

        .top-list:hover {
            border-color: var(--border-hover);
        }

        .top-list .panel-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .top-list .panel-head .pi {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .top-list .panel-head .pi .icon {
            width: 15px;
            height: 15px;
        }

        .top-list h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .top-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-top: 1px solid var(--border-color);
            transition: background 0.2s ease;
            border-radius: 8px;
            padding: 12px 10px;
            margin: 0 -10px;
        }

        .top-row:first-child {
            border-top: none;
        }

        .top-row:hover {
            background: var(--bg-card-active);
        }

        .top-rank {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--bg-card-active);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        .top-rank.gold {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }

        .top-rank.silver {
            background: rgba(156, 163, 175, 0.15);
            color: #9ca3af;
        }

        .top-rank.bronze {
            background: rgba(180, 83, 9, 0.15);
            color: #b45309;
        }

        .top-name {
            flex: 1;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .top-count {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: var(--theme-primary);
            font-weight: 600;
            background: var(--theme-soft);
            padding: 2px 10px;
            border-radius: 100px;
        }

        /* ===== EMPTY ===== */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-tertiary);
        }

        .empty-state .icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            opacity: 0.5;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px) {
            .metric-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .metric-cell:last-child {
                grid-column: span 2;
            }
        }

        @media (max-width: 900px) {
            .stw {
                padding: 0 12px;
            }

            .stw-grid {
                grid-template-columns: 1fr;
            }

            .metric-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .metric-cell:last-child {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .stw-header {
                flex-direction: column;
            }

            .stw-header-actions {
                width: 100%;
            }

            .stw-header-actions .stw-btn {
                flex: 1;
                justify-content: center;
            }

            .stw-header h1 {
                font-size: 24px;
            }

            .metric-cell .n {
                font-size: 20px;
            }

            .metric-cell .ic {
                width: 32px;
                height: 32px;
            }

            .metric-cell .ic .icon {
                width: 14px;
                height: 14px;
            }

            .chart-panel, .top-list {
                padding: 20px;
            }

            .bar-chart {
                height: 120px;
                gap: 10px;
            }

            .bar-fill {
                max-width: 30px;
            }
        }

        @media (max-width: 480px) {
            .metric-row {
                grid-template-columns: 1fr 1fr;
                gap: 1px;
            }

            .metric-cell {
                padding: 16px 12px;
            }

            .metric-cell .n {
                font-size: 18px;
            }

            .stw-header h1 {
                font-size: 20px;
            }

            .bar-chart {
                height: 100px;
                gap: 6px;
            }

            .bar-fill {
                max-width: 24px;
            }

            .bar-fill .bv {
                font-size: 9px;
                top: -18px;
            }

            .bar-lbl {
                font-size: 9px;
            }

            .chart-panel, .top-list {
                padding: 16px;
            }

            .chart-panel h3, .top-list h3 {
                font-size: 13px;
            }

            .top-row {
                padding: 10px 8px;
                margin: 0 -8px;
            }

            .top-rank {
                width: 24px;
                height: 24px;
                font-size: 10px;
            }

            .top-name {
                font-size: 12px;
            }

            .top-count {
                font-size: 10px;
                padding: 1px 8px;
            }
        }

        @media (max-width: 380px) {
            .stw-header h1 {
                font-size: 18px;
            }

            .metric-cell .n {
                font-size: 16px;
            }

            .metric-cell .l {
                font-size: 9px;
            }
        }
    </style>

    <div class="stw">

        <!-- ===== HEADER ===== -->
        <div class="stw-header animate-in" style="animation-delay: 0.05s;">
            <div class="stw-header-left">
                <div class="stw-badge">
                    <span class="dot"></span>
                    Analitik
                </div>
                <h1><span class="highlight">Statistik Sistem</span></h1>
                <p>Ringkasan penggunaan aplikasi Arvessa secara keseluruhan, lintas semua company.</p>
            </div>
            <div class="stw-header-actions">
                <a href="{{ route('admin.stats.index') }}" class="stw-btn stw-btn-ghost">
                    <svg class="icon"><use href="#ic-refresh"/></svg>
                    Refresh Data
                </a>
            </div>
        </div>

        <!-- ===== METRIC ROW ===== -->
        <div class="metric-row animate-in" style="animation-delay: 0.08s;">
            <div class="metric-cell">
                <div class="ic"><svg class="icon"><use href="#ic-building"/></svg></div>
                <div class="n">{{ $totalCompanies }}</div>
                <div class="l">Company</div>
            </div>
            <div class="metric-cell">
                <div class="ic"><svg class="icon"><use href="#ic-check-circle"/></svg></div>
                <div class="n">{{ $activeCompanies }}</div>
                <div class="l">Company Aktif</div>
            </div>
            <div class="metric-cell">
                <div class="ic"><svg class="icon"><use href="#ic-users"/></svg></div>
                <div class="n">{{ $totalUsers }}</div>
                <div class="l">User</div>
            </div>
            <div class="metric-cell">
                <div class="ic"><svg class="icon"><use href="#ic-briefcase"/></svg></div>
                <div class="n">{{ $totalClients }}</div>
                <div class="l">Klien</div>
            </div>
            <div class="metric-cell">
                <div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>
                <div class="n">{{ $totalInvoices }}</div>
                <div class="l">Faktur</div>
            </div>
        </div>

        <!-- ===== GRID 1 ===== -->
        <div class="stw-grid">
            <!-- Company Growth Chart -->
            <div class="chart-panel animate-in" style="animation-delay: 0.14s;">
                <div class="panel-head">
                    <div class="pi"><svg class="icon"><use href="#ic-building"/></svg></div>
                    <h3>Pertumbuhan Company (6 Bulan Terakhir)</h3>
                </div>
                <div class="bar-chart">
                    @foreach($companyGrowth as $g)
                        <div class="bar-col">
                            <div class="bar-fill" style="height:{{ $g['count'] > 0 ? max(8, ($g['count']/$maxCompanyGrowth)*100) : 4 }}%;">
                                @if($g['count'] > 0)
                                    <span class="bv">{{ $g['count'] }}</span>
                                @endif
                            </div>
                            <div class="bar-lbl">{{ $g['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Access Level Distribution -->
            <div class="chart-panel animate-in" style="animation-delay: 0.18s;">
                <div class="panel-head">
                    <div class="pi"><svg class="icon"><use href="#ic-users"/></svg></div>
                    <h3>Distribusi Access Level</h3>
                </div>
                <div class="level-bars" id="levelBars">
                    @php $totalLevel = max(1, array_sum($usersByLevel)); @endphp
                    <div class="level-row admin">
                        <div class="lr-top">
                            <span class="name"><span class="dot"></span>Admin</span>
                            <span class="count">{{ $usersByLevel['admin'] }}</span>
                        </div>
                        <div class="lr-track">
                            <div class="lr-fill" data-w="{{ ($usersByLevel['admin']/$totalLevel)*100 }}%"></div>
                        </div>
                    </div>
                    <div class="level-row staff">
                        <div class="lr-top">
                            <span class="name"><span class="dot"></span>Staff</span>
                            <span class="count">{{ $usersByLevel['staff'] }}</span>
                        </div>
                        <div class="lr-track">
                            <div class="lr-fill" data-w="{{ ($usersByLevel['staff']/$totalLevel)*100 }}%"></div>
                        </div>
                    </div>
                    <div class="level-row user">
                        <div class="lr-top">
                            <span class="name"><span class="dot"></span>User Biasa</span>
                            <span class="count">{{ $usersByLevel['user'] }}</span>
                        </div>
                        <div class="lr-track">
                            <div class="lr-fill" data-w="{{ ($usersByLevel['user']/$totalLevel)*100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== GRID 2 ===== -->
        <div class="stw-grid">
            <!-- User Growth Chart -->
            <div class="chart-panel animate-in" style="animation-delay: 0.22s;">
                <div class="panel-head">
                    <div class="pi"><svg class="icon"><use href="#ic-user"/></svg></div>
                    <h3>Pertumbuhan User (6 Bulan Terakhir)</h3>
                </div>
                <div class="bar-chart">
                    @foreach($userGrowth as $g)
                        <div class="bar-col">
                            <div class="bar-fill" style="height:{{ $g['count'] > 0 ? max(8, ($g['count']/$maxUserGrowth)*100) : 4 }}%; background:linear-gradient(180deg,#4E8FF0,#3465C4);">
                                @if($g['count'] > 0)
                                    <span class="bv">{{ $g['count'] }}</span>
                                @endif
                            </div>
                            <div class="bar-lbl">{{ $g['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Companies -->
            <div class="top-list animate-in" style="animation-delay: 0.26s;">
                <div class="panel-head">
                    <div class="pi"><svg class="icon"><use href="#ic-award"/></svg></div>
                    <h3>Top 5 Company (Berdasarkan Faktur)</h3>
                </div>
                @forelse($topCompanies as $i => $c)
                    @php
                        $rankClass = '';
                        if ($i === 0) $rankClass = 'gold';
                        elseif ($i === 1) $rankClass = 'silver';
                        elseif ($i === 2) $rankClass = 'bronze';
                    @endphp
                    <div class="top-row">
                        <div class="top-rank {{ $rankClass }}">{{ $i + 1 }}</div>
                        <div class="top-name">{{ $c->name }}</div>
                        <div class="top-count">{{ $c->invoices_count }} faktur</div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg class="icon"><use href="#ic-inbox"/></svg>
                        <p style="font-size:12.5px;">Belum ada data perusahaan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // ===== ANIMATE LEVEL BARS =====
            setTimeout(function(){
                document.querySelectorAll('.lr-fill').forEach(function(el){
                    el.style.width = el.getAttribute('data-w');
                });
            }, 200);

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.stw-btn');
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
</x-admin-layout>