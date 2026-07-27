<x-app-layout>
    <x-slot name="title">PPh - Pajak Penghasilan</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // Data dari session (sudah passing $pphData dari controller)
        $pphData = $pphData ?? [
            ['id' => 1, 'period' => 'Januari 2026', 'gross' => 45000000, 'deduction' => 5000000, 'taxable' => 40000000, 'tax' => 1250000, 'status' => 'paid', 'due' => '2026-02-15'],
            ['id' => 2, 'period' => 'Februari 2026', 'gross' => 48000000, 'deduction' => 5200000, 'taxable' => 42800000, 'tax' => 1350000, 'status' => 'paid', 'due' => '2026-03-15'],
            ['id' => 3, 'period' => 'Maret 2026', 'gross' => 52000000, 'deduction' => 5500000, 'taxable' => 46500000, 'tax' => 1500000, 'status' => 'pending', 'due' => '2026-04-15'],
            ['id' => 4, 'period' => 'April 2026', 'gross' => 49000000, 'deduction' => 5300000, 'taxable' => 43700000, 'tax' => 1400000, 'status' => 'pending', 'due' => '2026-05-15'],
            ['id' => 5, 'period' => 'Mei 2026', 'gross' => 51000000, 'deduction' => 5400000, 'taxable' => 45600000, 'tax' => 1450000, 'status' => 'pending', 'due' => '2026-06-15'],
        ];

        $pphCollection = collect($pphData);
        $statusLabel = ['paid' => 'Dibayar', 'pending' => 'Pending'];
        $statusPill  = ['paid' => 'paid', 'pending' => 'pending'];

        $totalTax = $pphCollection->sum('tax');
        $totalPaid = $pphCollection->where('status', 'paid')->sum('tax');
        $totalPending = $pphCollection->where('status', 'pending')->sum('tax');
        $countPaid = $pphCollection->where('status', 'paid')->count();
        $countPending = $pphCollection->where('status', 'pending')->count();
        
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

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-chevron-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </symbol>
            <symbol id="ic-more-horizontal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
        </defs>
    </svg>

    <style>
        /* ============================================
           PPH - Clean & Minimalist Design
           ============================================ */
        
        .pph-modern {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .pph-modern * {
            box-sizing: border-box;
        }

        .pph-modern .mono {
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

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-8px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .pph-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .pph-modern .icon {
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

        /* ===== TOAST ===== */
        .toast-container{
            position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px; max-width:380px; width:100%;
        }
        .toast{
            background:var(--modal-bg); border:1px solid var(--border); border-radius:var(--radius-md); padding:16px 20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.5); animation:fadeSlideUp .35s cubic-bezier(.16,1,.3,1);
            display:flex; align-items:center; gap:12px; backdrop-filter:blur(12px);
        }
        .toast .toast-icon{ width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .toast .toast-icon.success{ background:var(--success-soft); color:var(--success); }
        .toast .toast-icon.error{ background:var(--danger-soft); color:var(--danger); }
        .toast .toast-icon .icon{ width:18px; height:18px; }
        .toast .toast-content{ flex:1; }
        .toast .toast-title{ font-size:13px; font-weight:600; color:var(--text); }
        .toast .toast-msg{ font-size:12px; color:var(--text-mute); }
        .toast .toast-close{ background:none; border:none; color:var(--text-faint); cursor:pointer; padding:4px; }
        .toast .toast-close .icon{ width:14px; height:14px; }

        /* ===== FILTER BAR ===== */
        .filter-bar{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            background:var(--bg-card);
            padding:12px 20px;
            border-radius:var(--radius-sm);
            border:1px solid var(--border-color);
            margin-bottom:16px;
            transition: all 0.3s ease;
        }

        .filter-bar:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .filter-bar form{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            width:100%;
        }

        .search-wrap{
            position:relative;
            flex:1;
            min-width:220px;
        }

        .search-wrap .icon{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            width:16px;
            height:16px;
            color:var(--text-tertiary);
            pointer-events:none;
            transition: color 0.3s ease;
        }

        .search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .filter-bar input[type=text]{
            width:100%;
            padding:10px 16px 10px 42px;
            border-radius:var(--radius-sm);
            background:var(--bg-card-active);
            border:1px solid transparent;
            color:var(--text-primary);
            font-size:13px;
            outline:none;
            transition:all .3s ease;
            font-family:inherit;
        }

        .filter-bar input[type=text]:focus{
            border-color:var(--theme-primary);
            background:var(--bg-card);
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1);
        }

        .filter-bar input[type=text]::placeholder{
            color:var(--text-tertiary);
        }

        .filter-actions{
            display:flex;
            gap:8px;
            align-items:center;
        }

        .filter-actions .pph-btn {
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

        /* ===== HEADER ===== */
        .pph-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .pph-header-left {
            flex: 1;
            min-width: 200px;
        }

        .pph-badge {
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

        .pph-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .pph-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .pph-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .pph-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .pph-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .pph-btn {
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

        .pph-btn .icon {
            width: 16px;
            height: 16px;
        }

        .pph-btn:hover {
            transform: translateY(-2px);
        }

        .pph-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .pph-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .pph-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .pph-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .pph-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .pph-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== SUCCESS MESSAGE ===== */
        .pph-success {
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

        .pph-success .icon {
            width: 20px;
            height: 20px;
        }

        .pph-success .message {
            font-weight: 500;
        }

        /* ===== STATS ===== */
        .pph-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .pph-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .pph-stat-card::before {
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

        .pph-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .pph-stat-card:hover::before {
            opacity: 1;
        }

        .pph-stat-card .stat-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .pph-stat-card .stat-head .ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .pph-stat-card .stat-head .ic .icon {
            width: 17px;
            height: 17px;
        }

        .pph-stat-card .stat-head .badge {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 100px;
            background: var(--warning-soft);
            color: var(--warning);
        }

        .pph-stat-card .stat-head .badge.success {
            background: var(--success-soft);
            color: var(--success);
        }

        .pph-stat-card .stat-label {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .pph-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .pph-stat-card .stat-value.primary {
            color: var(--theme-primary);
        }

        .pph-stat-card .stat-value.success {
            color: var(--success);
        }

        .pph-stat-card .stat-value.warning {
            color: var(--warning);
        }

        .pph-stat-card .stat-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* ===== TABS ===== */
        .pph-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 16px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 4px;
        }

        .pph-tab {
            flex: 1;
            padding: 10px 16px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            background: transparent;
            color: var(--text-secondary);
            text-align: center;
            font-family: 'Inter', sans-serif;
        }

        .pph-tab:hover {
            color: var(--text-primary);
            background: var(--bg-card-hover);
        }

        .pph-tab.active {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        /* ===== TIMELINE / CARD LIST ===== */
        .pph-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.22s ease;
        }

        .pph-card:hover {
            border-color: var(--border-hover);
        }

        .pph-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .pph-card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .pph-card-header .link {
            font-size: 12.5px;
            color: var(--theme-primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        .pph-card-header .link .icon {
            width: 13px;
            height: 13px;
        }

        .pph-card-header .link:hover {
            text-decoration: underline;
        }

        .pph-timeline-wrap {
            padding: 0 4px 4px 4px;
        }

        .pph-timeline-wrap.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        /* TIMELINE CARD ITEMS */
        .pph-timeline {
            position: relative;
            padding-left: 30px;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .pph-timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 8px;
            bottom: 8px;
            width: 2px;
            background: var(--border-color);
        }

        .pph-item {
            position: relative;
            margin-bottom: 20px;
            padding: 18px 20px;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            transition: all 0.3s ease;
        }

        .pph-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .pph-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 24px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            background: var(--bg-card);
        }

        .pph-item.status-paid::before {
            background: var(--success);
            border-color: var(--success);
        }

        .pph-item.status-pending::before {
            background: var(--warning);
            border-color: var(--warning);
        }

        .pph-item .top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 12px;
        }

        .pph-item .top .period {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .pph-item .top .status {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .pph-item .top .status.paid {
            background: var(--success-soft);
            color: var(--success);
        }

        .pph-item .top .status.pending {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .pph-item .details {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            padding: 12px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .pph-item .details .item .lbl {
            font-size: 10px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .pph-item .details .item .val {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 2px;
        }

        .pph-item .details .item .val.mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .pph-item .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
        }

        .pph-item .footer .due {
            font-size: 12px;
            color: var(--text-tertiary);
        }

        .pph-item .footer .due strong {
            color: var(--text-secondary);
        }

        .pph-item .footer .due .overdue {
            color: var(--danger);
        }

        .pph-item .footer .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .pph-item .footer .actions .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .pph-item .footer .actions .btn-action:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-1px);
        }

        .pph-item .footer .actions .btn-action.pay {
            border-color: var(--success-soft);
            color: var(--success);
        }

        .pph-item .footer .actions .btn-action.pay:hover {
            background: var(--success-soft);
            border-color: var(--success);
        }

        .pph-item .footer .actions .btn-icon {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            color: var(--text-tertiary);
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .pph-item .footer .actions .btn-icon .icon {
            width: 14px;
            height: 14px;
        }

        .pph-item .footer .actions .btn-icon.show {
            color: var(--theme-primary);
        }

        .pph-item .footer .actions .btn-icon.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .pph-item .footer .actions .btn-icon.edit {
            color: #4FA6E8;
        }

        .pph-item .footer .actions .btn-icon.edit:hover {
            background: rgba(79, 166, 232, 0.12);
            border-color: #4FA6E8;
        }

        .pph-item .footer .actions .btn-icon.danger {
            color: var(--danger);
        }

        .pph-item .footer .actions .btn-icon.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        .pph-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-tertiary);
        }

        .pph-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .pph-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .pph-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ============================================================
           MODAL DELETE - PINGGIRAN BULAT 24px (SAMA KAYA AGING)
           ============================================================ */
        .pph-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }

        .pph-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .pph-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .pph-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .pph-modal-box {
            border-radius: 24px;              /* <--- INI BIKIN GA LANCIP! */
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .pph-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .pph-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .pph-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .pph-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .pph-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .pph-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .pph-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .pph-modal-box .pph-desc-text {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-size: 15px;
        }

        .pph-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .pph-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .pph-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .pph-modal-actions .btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .pph-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .pph-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .pph-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .pph-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .pph-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .pph-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .pph-modal-actions .btn-danger:hover {
            background: #B91C1C;
        }

        /* CSS UNTUK NAVBAR TIDAK KE-BLUR */
        body.aj-modal-open main {
            position: relative;
            z-index: 9998;
        }

        body.aj-modal-open .sidebar,
        body.aj-modal-open .topbar {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        body.aj-modal-open .sidebar *,
        body.aj-modal-open .topbar * {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .pph-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            .pph-item .details {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .pph-tabs {
                flex-direction: column;
            }
            .pph-tab {
                text-align: center;
            }
            .pph-item .details {
                grid-template-columns: 1fr 1fr;
            }
            .pph-item .top {
                flex-direction: column;
            }
            .pph-item .footer {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
                text-align: center;
            }
            .pph-item .footer .actions {
                justify-content: center;
                flex-wrap: wrap;
            }
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 12px 16px;
            }
            .filter-bar form {
                flex-direction: column;
            }
            .search-wrap {
                min-width: 100%;
            }
            .filter-actions {
                width: 100%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }
            .pph-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }
            .pph-modal-actions {
                flex-direction: column;
            }
            .pph-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .pph-header {
                flex-direction: column;
            }
            .pph-header-actions {
                width: 100%;
            }
            .pph-header-actions .pph-btn {
                flex: 1;
                justify-content: center;
            }
            .pph-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .pph-stat-card .stat-value {
                font-size: 22px;
            }
            .pph-item .details {
                grid-template-columns: 1fr;
            }
            .pph-modal-box {
                padding: 20px 16px;
            }
            .pph-modal-box h3 {
                font-size: 18px;
            }
            .pph-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }
            .pph-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 380px) {
            .pph-header h1 {
                font-size: 22px;
            }
            .pph-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .pph-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="pph-modern">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- ===== HEADER ===== -->
        <div class="pph-header animate-in" style="animation-delay: 0.05s;">
            <div class="pph-header-left">
                <div class="pph-badge">
                    <span class="dot"></span>
                    Pajak
                </div>
                <h1>Pajak Penghasilan (PPh)</h1>
                <p class="subtitle">
                    Kelola kewajiban PPh perusahaan — 
                    <strong id="pphTotalCount">{{ $pphCollection->count() }}</strong> periode pajak
                </p>
            </div>
            <div class="pph-header-actions">
                <a href="{{ route('taxes.ppn') }}" class="pph-btn pph-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    PPN
                </a>
                <a href="{{ route('tax-calendar.index') }}" class="pph-btn pph-btn-ghost">
                    <svg class="icon"><use href="#ic-calendar"/></svg>
                    Kalender Pajak
                </a>
                <a href="{{ route('taxes.pph.create') }}" class="pph-btn pph-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah PPh
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="pph-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== TABS ===== -->
        <div class="pph-tabs animate-in" style="animation-delay: 0.10s;">
            <button class="pph-tab active" data-filter="all">Semua</button>
            <button class="pph-tab" data-filter="paid">Dibayar</button>
            <button class="pph-tab" data-filter="pending">Pending</button>
        </div>

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar animate-in" style="animation-delay: 0.13s;">
            <form method="GET" action="{{ route('taxes.pph') }}" id="pphFilterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="pphSearchInput" value="{{ request('q') }}" placeholder="Cari periode, status, atau nominal pajak..." autocomplete="off">
                </div>
                <div class="filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    @if(request()->filled('q'))
                        <a href="{{ route('taxes.pph') }}" class="pph-btn pph-btn-ghost" id="resetBtn">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- ===== STATS ===== -->
        <div class="pph-stats animate-in" style="animation-delay: 0.18s;" id="pphStats">
            <div class="pph-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-bank"/></svg>
                    </div>
                </div>
                <div class="stat-label">Total PPh</div>
                <div class="stat-value primary mono" id="pphTotalTax">{{ $currencySymbol }}{{ number_format($totalTax, 0, ',', '.') }}</div>
                <div class="stat-sub">Keseluruhan pajak</div>
            </div>
            <div class="pph-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                    </div>
                    <span class="badge success">{{ $countPaid }} periode</span>
                </div>
                <div class="stat-label">Sudah Dibayar</div>
                <div class="stat-value success mono" id="pphTotalPaid">{{ $currencySymbol }}{{ number_format($totalPaid, 0, ',', '.') }}</div>
                <div class="stat-sub">PPh terbayar</div>
            </div>
            <div class="pph-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                    </div>
                    <span class="badge">{{ $countPending }} periode</span>
                </div>
                <div class="stat-label">Belum Dibayar</div>
                <div class="stat-value warning mono" id="pphTotalPending">{{ $currencySymbol }}{{ number_format($totalPending, 0, ',', '.') }}</div>
                <div class="stat-sub">PPh tertunda</div>
            </div>
            <div class="pph-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-calendar"/></svg>
                    </div>
                </div>
                <div class="stat-label">Periode Selesai</div>
                <div class="stat-value" id="pphPeriodCount">{{ $countPaid }} / {{ $pphCollection->count() }}</div>
                <div class="stat-sub">Telah diselesaikan</div>
            </div>
        </div>

        <!-- ===== CARD / TIMELINE ===== -->
        <div class="pph-card animate-in" style="animation-delay: 0.22s;">
            <div class="pph-card-header">
                <h3>Periode Pajak</h3>
                <span style="font-size:12px; color:var(--text-tertiary);">
                    {{ $pphCollection->count() }} periode
                </span>
            </div>

            <div class="pph-timeline-wrap" id="pphTimelineWrap">
                <div class="pph-timeline" id="pphTimeline">
                    @forelse($pphData as $index => $p)
                        @php
                            $dueDate = \Carbon\Carbon::parse($p['due']);
                            $isOverdue = $dueDate->isPast() && $p['status'] == 'pending';
                            $itemId = $p['id'] ?? $index;
                            $periodLower = strtolower($p['period']);
                            $statusText = $statusLabel[$p['status']];
                        @endphp
                        <div class="pph-item status-{{ $p['status'] }} pph-item-data" 
                             data-period="{{ $periodLower }}"
                             data-status="{{ $p['status'] }}"
                             data-tax="{{ $p['tax'] }}">
                            <div class="top">
                                <span class="period">{{ $p['period'] }}</span>
                                <span class="status {{ $statusPill[$p['status']] }}">{{ $statusLabel[$p['status']] }}</span>
                            </div>

                            <div class="details">
                                <div class="item">
                                    <div class="lbl">Penghasilan Bruto</div>
                                    <div class="val mono">{{ $currencySymbol }}{{ number_format($p['gross'], 0, ',', '.') }}</div>
                                </div>
                                <div class="item">
                                    <div class="lbl">Pengurang</div>
                                    <div class="val mono">{{ $currencySymbol }}{{ number_format($p['deduction'], 0, ',', '.') }}</div>
                                </div>
                                <div class="item">
                                    <div class="lbl">PKP</div>
                                    <div class="val mono">{{ $currencySymbol }}{{ number_format($p['taxable'], 0, ',', '.') }}</div>
                                </div>
                                <div class="item">
                                    <div class="lbl">PPh Terutang</div>
                                    <div class="val mono" style="color: var(--theme-primary);">{{ $currencySymbol }}{{ number_format($p['tax'], 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div class="footer">
                                <div class="due">
                                    Jatuh tempo: <strong>{{ formatTanggal($p['due']) }}</strong>
                                    @if($isOverdue)
                                        <span class="overdue">(Lewat jatuh tempo!)</span>
                                    @endif
                                </div>
                                <div class="actions">
                                    @if($p['status'] == 'pending')
                                        <a href="{{ route('taxes.pph.pay', $itemId) }}" class="btn-action pay">
                                            Bayar
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('taxes.pph.show', $itemId) }}" class="btn-icon show" title="Lihat Detail">
                                        <svg class="icon"><use href="#ic-eye"/></svg>
                                    </a>
                                    <a href="{{ route('taxes.pph.edit', $itemId) }}" class="btn-icon edit" title="Edit">
                                        <svg class="icon"><use href="#ic-edit"/></svg>
                                    </a>
                                    <button type="button" class="btn-icon danger" title="Hapus"
                                            onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($p['period']) }}')">
                                        <svg class="icon"><use href="#ic-trash"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="pph-empty">
                            <svg class="empty-icon"><use href="#ic-bank"/></svg>
                            <h3>Belum Ada Data PPh</h3>
                            <p>Belum ada data PPh yang tercatat.</p>
                            <a href="{{ route('taxes.pph.create') }}" class="pph-btn pph-btn-primary" style="display: inline-flex;">
                                <svg class="icon"><use href="#ic-plus"/></svg>
                                Tambah PPh
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================
         MODAL DELETE - PINGGIRAN BULAT 24px (SAMA KAYA AGING)
         ============================================================ -->
    <div class="pph-modal-overlay" id="deleteModal">
        <div class="pph-modal-box">
            <!-- ICON DANGER -->
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <!-- JUDUL -->
            <h3>Hapus Data PPh?</h3>

            <!-- DESKRIPSI -->
            <p>
                Anda yakin ingin menghapus data PPh
                <br>
                <span class="pph-desc-text" id="deleteDesc">-</span>
            </p>

            <!-- WARNING -->
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <!-- TOMBOL -->
            <div class="pph-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ===== TOAST SYSTEM =====
        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="toast-icon ${type}">
                    <svg class="icon"><use href="#${type === 'success' ? 'ic-check-circle' : 'ic-alert-triangle'}"/></svg>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-msg">${message}</div>
                </div>
                <button class="toast-close" onclick="this.parentElement.remove()">
                    <svg class="icon"><use href="#ic-x"/></svg>
                </button>
            `;
            container.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, 5000);
        }

        // ===== DELETE MODAL =====
        function openDeleteModal(id, description) {
            document.getElementById('deleteDesc').textContent = description;
            var url = '/taxes/pph/delete/' + id;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('aj-modal-open');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
            document.body.classList.remove('aj-modal-open');
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
            // ===== FILTER & SEARCH =====
            const searchInput = document.getElementById('pphSearchInput');
            const tabs = document.querySelectorAll('.pph-tab');
            const items = document.querySelectorAll('.pph-item-data');
            const totalCountEl = document.getElementById('pphTotalCount');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchResultCount = document.getElementById('searchResultCount');
            const resetBtn = document.getElementById('resetBtn');
            let loadingTimeout = null;

            function filterAndSearch() {
                const searchText = searchInput ? searchInput.value.toLowerCase() : '';
                const activeTab = document.querySelector('.pph-tab.active');
                const statusFilter = activeTab ? activeTab.dataset.filter : 'all';
                
                let visibleCount = 0;
                let totalTaxVisible = 0;
                let paidTaxVisible = 0;
                let pendingTaxVisible = 0;
                let paidCount = 0;
                let pendingCount = 0;

                items.forEach(item => {
                    const period = item.dataset.period || '';
                    const status = item.dataset.status || '';
                    const tax = parseFloat(item.dataset.tax) || 0;
                    
                    const matchSearch = searchText === '' || 
                                       period.includes(searchText) ||
                                       status.toLowerCase().includes(searchText) ||
                                       tax.toString().includes(searchText.replace(/[^0-9]/g, ''));
                    
                    const matchStatus = statusFilter === 'all' || status === statusFilter;
                    
                    if (matchSearch && matchStatus) {
                        item.style.display = '';
                        visibleCount++;
                        totalTaxVisible += tax;
                        if (status === 'paid') {
                            paidTaxVisible += tax;
                            paidCount++;
                        } else {
                            pendingTaxVisible += tax;
                            pendingCount++;
                        }
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Update stats
                const currencySymbol = '{{ $currencySymbol }}';
                document.getElementById('pphTotalTax').textContent = currencySymbol + numberFormat(totalTaxVisible);
                document.getElementById('pphTotalPaid').textContent = currencySymbol + numberFormat(paidTaxVisible);
                document.getElementById('pphTotalPending').textContent = currencySymbol + numberFormat(pendingTaxVisible);
                document.getElementById('pphPeriodCount').textContent = paidCount + ' / ' + visibleCount;
                totalCountEl.textContent = visibleCount;

                // Update search indicator
                if (searchIndicator && searchResultCount) {
                    if (searchText !== '' && visibleCount > 0) {
                        searchIndicator.classList.add('active');
                        searchResultCount.textContent = visibleCount;
                    } else {
                        searchIndicator.classList.remove('active');
                    }
                }

                // Show/hide empty state
                const emptyState = document.querySelector('.pph-empty');
                if (emptyState) {
                    if (visibleCount === 0 && items.length > 0) {
                        emptyState.style.display = 'block';
                    } else {
                        emptyState.style.display = 'none';
                    }
                }
            }

            function numberFormat(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Tab switching
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    filterAndSearch();
                });
            });

            // Search input with debounce
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }
                    
                    // Update URL
                    var url = new URL(window.location.href);
                    if (this.value.trim() !== '') {
                        url.searchParams.set('q', this.value.trim());
                    } else {
                        url.searchParams.delete('q');
                    }
                    window.history.replaceState({}, '', url.toString());

                    loadingTimeout = setTimeout(function() {
                        filterAndSearch();
                    }, 300);
                });

                // Keyboard shortcut: Ctrl+K or Cmd+K
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                    if (e.key === '/' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        var activeElement = document.activeElement;
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
                    if (searchInput) {
                        searchInput.value = '';
                    }
                    var url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    window.history.replaceState({}, '', url.toString());
                    filterAndSearch();
                });
            }

            // Initial filter
            filterAndSearch();

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.pph-btn');
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