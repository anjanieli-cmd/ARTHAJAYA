<x-user-layout>
    <x-slot name="title">Ringkasan Kas</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        function formatCurrencyShortUS($amount) {
            $amount = (int) $amount;
            if ($amount >= 1000000000) return number_format($amount / 1000000000, 1, ',', '') . 'M';
            if ($amount >= 1000000) return number_format($amount / 1000000, 1, ',', '') . 'Jt';
            if ($amount >= 1000) return number_format($amount / 1000, 0, ',', '') . 'Rb';
            return number_format($amount, 0, ',', '.');
        }

        // Hitung statistik
        $totalBalance = $company->accounts->first()->initial_balance ?? 0;
        $totalIncome = 0;
        $totalExpense = 0;

        $ledgerEntries = session('ledger_entries', []);
        $currentMonth = date('Y-m');
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthlyData[$month] = ['income' => 0, 'expense' => 0];
        }

        foreach ($ledgerEntries as $entry) {
            $entryDate = substr($entry['date'] ?? '', 0, 7);
            $amount = $entry['amount'] ?? 0;
            
            if ($entryDate == $currentMonth) {
                if ($amount > 0) $totalIncome += $amount;
                else $totalExpense += abs($amount);
            }
            $totalBalance += $amount;
            
            if (isset($monthlyData[$entryDate])) {
                if ($amount > 0) $monthlyData[$entryDate]['income'] += $amount;
                else $monthlyData[$entryDate]['expense'] += abs($amount);
            }
        }

        $cashRatio = $totalBalance > 0 ? round(($totalIncome / max(1, $totalBalance)) * 100, 1) : 0;
    @endphp

    <style>
        /* ============================================
           RINGKASAN KAS - Premium Design
           ============================================ */
        
        .ringkasan-wrap {
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

        .ringkasan-wrap * { box-sizing: border-box; }
        .ringkasan-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes growBar {
            from { height: 0; }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .ringkasan-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .ringkasan-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .ringkasan-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ringkasan-header-left { flex: 1; min-width: 200px; }

        .ringkasan-badge {
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

        .ringkasan-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ringkasan-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ringkasan-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ringkasan-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .ringkasan-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ringkasan-btn {
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

        .ringkasan-btn .icon { width: 16px; height: 16px; }
        .ringkasan-btn:hover { transform: translateY(-2px); }
        .ringkasan-btn:active { transform: translateY(0) scale(0.97); }

        .ringkasan-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ringkasan-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ringkasan-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ringkasan-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ringkasan-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== BIG NUMBER ===== */
        .ringkasan-big {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 36px;
            margin-bottom: 24px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ringkasan-big::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--theme-gradient);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .ringkasan-big:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.06);
        }

        .ringkasan-big .label {
            font-size: 12px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .ringkasan-big .value {
            font-size: 42px;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 6px;
            font-family: 'IBM Plex Mono', monospace;
            letter-spacing: -0.02em;
        }

        .ringkasan-big .sub {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 8px;
        }

        .ringkasan-big .sub .up {
            color: var(--success);
            font-weight: 600;
        }

        .ringkasan-big .sub .down {
            color: var(--danger);
            font-weight: 600;
        }

        /* ===== STATS GRID ===== */
        .ringkasan-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .ringkasan-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 22px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ringkasan-stat::before {
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

        .ringkasan-stat:hover {
            transform: translateY(-3px);
            border-color: var(--border-hover);
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }

        .ringkasan-stat:hover::before { opacity: 1; }

        .ringkasan-stat .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .ringkasan-stat .stat-icon .icon { width: 20px; height: 20px; }

        .ringkasan-stat .stat-label {
            font-size: 11px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .ringkasan-stat .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 4px;
            font-family: 'IBM Plex Mono', monospace;
        }

        .ringkasan-stat .stat-value.pos { color: var(--success); }
        .ringkasan-stat .stat-value.neg { color: var(--danger); }
        .ringkasan-stat .stat-value.info { color: var(--info); }

        /* ===== CARD ===== */
        .ringkasan-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .ringkasan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--theme-gradient);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .ringkasan-card:hover { border-color: var(--border-hover); }

        .ringkasan-card .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ringkasan-card .card-head h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ringkasan-card .card-head h3 .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        /* ===== BAR CHART ===== */
        .ringkasan-bars {
            display: flex;
            align-items: flex-end;
            gap: 12px;
            height: 150px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--border-color);
        }

        .ringkasan-bar-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            height: 100%;
            justify-content: flex-end;
        }

        .ringkasan-bar-group {
            display: flex;
            gap: 3px;
            width: 100%;
            height: 100%;
            align-items: flex-end;
        }

        .ringkasan-bar {
            flex: 1;
            border-radius: 4px 4px 0 0;
            min-height: 4px;
            transition: height 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            background: var(--success);
            opacity: 0.8;
            animation: growBar 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .ringkasan-bar.out {
            background: var(--danger);
            opacity: 0.8;
        }

        .ringkasan-bar-label {
            font-size: 10px;
            color: var(--text-tertiary);
            font-weight: 600;
        }

        /* ===== LEGEND ===== */
        .ringkasan-legend {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 14px;
        }

        .ringkasan-legend .item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .ringkasan-legend .item .dot {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            display: inline-block;
        }

        .ringkasan-legend .item .dot.in { background: var(--success); }
        .ringkasan-legend .item .dot.out { background: var(--danger); }

        /* ===== COMPANY INFO ===== */
        .ringkasan-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .ringkasan-info-item {
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .ringkasan-info-item .info-label {
            font-size: 11px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .ringkasan-info-item .info-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 2px;
        }

        /* ===== READONLY NOTE ===== */
        .ringkasan-readonly {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 10px 16px;
            border-radius: var(--radius-sm);
            margin-top: 16px;
            border: 1px dashed var(--border-color);
        }

        .ringkasan-readonly .icon {
            width: 16px;
            height: 16px;
            color: var(--theme-primary);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .ringkasan-stats { grid-template-columns: repeat(2, 1fr); }
            .ringkasan-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .ringkasan-wrap { padding: 0 12px; }
            .ringkasan-header { flex-direction: column; }
            .ringkasan-actions { width: 100%; }
            .ringkasan-actions .ringkasan-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .ringkasan-big { padding: 24px 20px; }
            .ringkasan-big .value { font-size: 32px; }
            .ringkasan-card { padding: 16px; }
            .ringkasan-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .ringkasan-stat .stat-value { font-size: 18px; }
            .ringkasan-header h1 { font-size: 22px; }
            .ringkasan-bars { height: 120px; gap: 8px; }
            .ringkasan-info-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 480px) {
            .ringkasan-wrap { padding: 0 8px; }
            .ringkasan-stats { grid-template-columns: 1fr; }
            .ringkasan-big { padding: 20px 16px; }
            .ringkasan-big .value { font-size: 28px; }
            .ringkasan-card { padding: 12px; }
            .ringkasan-card .card-head h3 { font-size: 14px; }
            .ringkasan-bars { height: 100px; gap: 6px; }
            .ringkasan-bar-label { font-size: 9px; }
            .ringkasan-legend { gap: 16px; }
            .ringkasan-legend .item { font-size: 11px; }
            .ringkasan-stat .stat-icon { width: 36px; height: 36px; }
            .ringkasan-stat .stat-icon .icon { width: 16px; height: 16px; }
        }
    </style>

    <div class="ringkasan-wrap">

        <!-- ===== HEADER ===== -->
        <div class="ringkasan-header animate-in" style="animation-delay: 0.05s;">
            <div class="ringkasan-header-left">
                <div class="ringkasan-badge">
                    <span class="dot"></span>
                    Keuangan
                </div>
                <h1>Ringkasan Kas</h1>
                <p class="subtitle">
                    Lihat kondisi keuangan perusahaan secara keseluruhan — 
                    <strong>pantau arus kas dan saldo terkini</strong>
                </p>
            </div>
            <div class="ringkasan-actions">
                <a href="{{ route('user.dashboard') }}" class="ringkasan-btn ringkasan-btn-ghost">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== BIG NUMBER ===== -->
        <div class="ringkasan-big animate-in" style="animation-delay: 0.08s;">
            <div class="label">Total Saldo Kas</div>
            <div class="value mono">{{ $currencySymbol }}{{ formatCurrencyShortUS($totalBalance) }}</div>
            <div class="sub">
                <span class="up">▲ {{ $currencySymbol }}{{ formatCurrencyShortUS($totalIncome) }}</span> pemasukan &nbsp;•&nbsp;
                <span class="down">▼ {{ $currencySymbol }}{{ formatCurrencyShortUS($totalExpense) }}</span> pengeluaran
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="ringkasan-stats animate-in" style="animation-delay: 0.10s;">
            <div class="ringkasan-stat">
                <div class="stat-icon">
                    <svg class="icon"><use href="#ic-trending-up"/></svg>
                </div>
                <div class="stat-label">Pemasukan Bulan Ini</div>
                <div class="stat-value pos">+{{ $currencySymbol }}{{ formatCurrencyShortUS($totalIncome) }}</div>
            </div>
            <div class="ringkasan-stat">
                <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);">
                    <svg class="icon"><use href="#ic-trending-down"/></svg>
                </div>
                <div class="stat-label">Pengeluaran Bulan Ini</div>
                <div class="stat-value neg">-{{ $currencySymbol }}{{ formatCurrencyShortUS($totalExpense) }}</div>
            </div>
            <div class="ringkasan-stat">
                <div class="stat-icon" style="background:var(--info-soft);color:var(--info);">
                    <svg class="icon"><use href="#ic-pie-chart"/></svg>
                </div>
                <div class="stat-label">Rasio Kas</div>
                <div class="stat-value info">{{ $cashRatio }}%</div>
            </div>
        </div>

        <!-- ===== CASH FLOW CHART ===== -->
        <div class="ringkasan-card animate-in" style="animation-delay: 0.14s;">
            <div class="card-head">
                <h3>
                    <svg class="icon"><use href="#ic-bar-chart"/></svg>
                    Arus Kas 6 Bulan Terakhir
                </h3>
            </div>

            <div class="ringkasan-bars">
                @php
                    $maxVal = 1;
                    foreach ($monthlyData as $data) {
                        $maxVal = max($maxVal, $data['income'], $data['expense']);
                    }
                    $maxVal = $maxVal > 0 ? $maxVal : 1;
                @endphp
                @foreach($monthlyData as $month => $data)
                    @php
                        $monthLabel = date('M', strtotime($month . '-01'));
                        $inHeight = ($data['income'] / $maxVal) * 100;
                        $outHeight = ($data['expense'] / $maxVal) * 100;
                    @endphp
                    <div class="ringkasan-bar-wrap">
                        <div class="ringkasan-bar-group">
                            @if($data['income'] > 0)
                                <div class="ringkasan-bar" style="height:{{ max($inHeight, 4) }}%;"></div>
                            @else
                                <div class="ringkasan-bar" style="height:4px;opacity:0.2;"></div>
                            @endif
                            @if($data['expense'] > 0)
                                <div class="ringkasan-bar out" style="height:{{ max($outHeight, 4) }}%;"></div>
                            @else
                                <div class="ringkasan-bar out" style="height:4px;opacity:0.2;"></div>
                            @endif
                        </div>
                        <div class="ringkasan-bar-label">{{ $monthLabel }}</div>
                    </div>
                @endforeach
            </div>

            <div class="ringkasan-legend">
                <span class="item">
                    <span class="dot in"></span>
                    Pemasukan
                </span>
                <span class="item">
                    <span class="dot out"></span>
                    Pengeluaran
                </span>
            </div>
        </div>

        <!-- ===== COMPANY INFO ===== -->
        <div class="ringkasan-card animate-in" style="animation-delay: 0.18s;">
            <div class="card-head">
                <h3>
                    <svg class="icon"><use href="#ic-building"/></svg>
                    Informasi Perusahaan
                </h3>
            </div>

            <div class="ringkasan-info-grid">
                <div class="ringkasan-info-item">
                    <div class="info-label">Nama Perusahaan</div>
                    <div class="info-value">{{ $company->name ?? '—' }}</div>
                </div>
                <div class="ringkasan-info-item">
                    <div class="info-label">Mata Uang</div>
                    <div class="info-value">{{ $company->currency ?? 'IDR' }} ({{ $currencySymbol }})</div>
                </div>
                <div class="ringkasan-info-item">
                    <div class="info-label">Industri</div>
                    <div class="info-value">{{ $company->industry ?? '—' }}</div>
                </div>
                <div class="ringkasan-info-item">
                    <div class="info-label">Kota</div>
                    <div class="info-value">{{ $company->city ?? '—' }}</div>
                </div>
            </div>

            <div class="ringkasan-readonly">
                <svg class="icon"><use href="#ic-lock"/></svg>
                <span>Data ini hanya untuk dilihat. Perubahan hanya bisa dilakukan oleh Staff.</span>
            </div>
        </div>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></symbol>
        <symbol id="ic-trending-up" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></symbol>
        <symbol id="ic-trending-down" viewBox="0 0 24 24"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></symbol>
        <symbol id="ic-pie-chart" viewBox="0 0 24 24"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></symbol>
        <symbol id="ic-bar-chart" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></symbol>
        <symbol id="ic-building" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></symbol>
        <symbol id="ic-lock" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.ringkasan-btn');
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

            // ===== ANIMATE BARS =====
            setTimeout(function() {
                document.querySelectorAll('.ringkasan-bar').forEach(bar => {
                    const height = bar.style.height;
                    bar.style.height = '0px';
                    requestAnimationFrame(() => {
                        bar.style.height = height;
                    });
                });
            }, 400);

        });
    </script>
</x-user-layout>