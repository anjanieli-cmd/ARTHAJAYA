<x-app-layout>
    <x-slot name="title">PPN - Pajak Pertambahan Nilai</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // DUMMY - ganti dengan query Tax model nanti
        $ppnData = $ppnData ?? [
            ['period' => 'Januari 2026', 'output' => 4500000, 'input' => 1200000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-02-28'],
            ['period' => 'Februari 2026', 'output' => 4800000, 'input' => 1500000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-03-31'],
            ['period' => 'Maret 2026', 'output' => 5200000, 'input' => 1800000, 'ppn' => 3400000, 'status' => 'paid', 'due' => '2026-04-30'],
            ['period' => 'April 2026', 'output' => 4900000, 'input' => 1400000, 'ppn' => 3500000, 'status' => 'pending', 'due' => '2026-05-31'],
            ['period' => 'Mei 2026', 'output' => 5100000, 'input' => 1600000, 'ppn' => 3500000, 'status' => 'pending', 'due' => '2026-06-30'],
        ];

        // 🔧 SEEDING SESSION — biar show/edit/delete bisa nemuin datanya
        if (!session()->has('ppn_data')) {
            session(['ppn_data' => $ppnData]);
        }

        // Fungsi format angka ke jutaan (M)
        function formatCompact($number) {
            if ($number >= 1000000000) {
                return round($number / 1000000000, 1) . 'B';
            } elseif ($number >= 1000000) {
                $result = $number / 1000000;
                return ($result == floor($result)) ? number_format($result, 0) . 'M' : number_format($result, 1) . 'M';
            } elseif ($number >= 1000) {
                $result = $number / 1000;
                return ($result == floor($result)) ? number_format($result, 0) . 'K' : number_format($result, 1) . 'K';
            }
            return number_format($number, 0);
        }

        // PENTING: simpan index asli (posisi di session) SEBELUM di-collect
        $ppnData = array_map(function($item, $key) {
            $item['_index'] = $key;
            return $item;
        }, $ppnData, array_keys($ppnData));

        $ppnCollection = collect($ppnData);
        $statusLabel = ['paid' => 'Dibayar', 'pending' => 'Pending'];
        $statusPill  = ['paid' => 'paid', 'pending' => 'pending'];

        $totalPpn = $ppnCollection->sum('ppn');
        $totalPaid = $ppnCollection->where('status', 'paid')->sum('ppn');
        $totalPending = $ppnCollection->where('status', 'pending')->sum('ppn');
        $countPaid = $ppnCollection->where('status', 'paid')->count();
        $countPending = $ppnCollection->where('status', 'pending')->count();
        
        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }
    @endphp

    <!-- SVG ICONS -->
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
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="10" width="20" height="14" rx="2"/><path d="M12 3L2 10h20L12 3z"/><line x1="8" y1="14" x2="8" y2="18"/><line x1="12" y1="14" x2="12" y2="18"/><line x1="16" y1="14" x2="16" y2="18"/>
            </symbol>
            <symbol id="ic-chevron-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </symbol>
            <symbol id="ic-more" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>
            </symbol>
        </defs>
    </svg>

    <style>
        /* ============================================
           PPN - Clean & Minimalist Design
           ============================================ */
        
        .ppn-modern {
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

        .ppn-modern * {
            box-sizing: border-box;
        }

        .ppn-modern .mono {
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

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .ppn-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .ppn-modern .icon {
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

        .filter-actions .ppn-btn {
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
        .ppn-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ppn-header-left {
            flex: 1;
            min-width: 200px;
        }

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

        .ppn-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .ppn-header-actions {
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
            font-family: 'Inter', sans-serif;
        }

        .ppn-btn .icon {
            width: 16px;
            height: 16px;
        }

        .ppn-btn:hover {
            transform: translateY(-2px);
        }

        .ppn-btn:active {
            transform: translateY(0) scale(0.97);
        }

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

        /* ===== SUCCESS MESSAGE ===== */
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

        /* ===== STATS ===== */
        .ppn-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .ppn-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .ppn-stat-card::before {
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

        .ppn-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .ppn-stat-card:hover::before {
            opacity: 1;
        }

        .ppn-stat-card .stat-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .ppn-stat-card .stat-head .ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .ppn-stat-card .stat-head .ic .icon {
            width: 17px;
            height: 17px;
        }

        .ppn-stat-card .stat-head .badge {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 100px;
            background: var(--warning-soft);
            color: var(--warning);
        }

        .ppn-stat-card .stat-head .badge.success {
            background: var(--success-soft);
            color: var(--success);
        }

        .ppn-stat-card .stat-label {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .ppn-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .ppn-stat-card .stat-value.primary {
            color: var(--theme-primary);
        }

        .ppn-stat-card .stat-value.success {
            color: var(--success);
        }

        .ppn-stat-card .stat-value.warning {
            color: var(--warning);
        }

        .ppn-stat-card .stat-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* ===== TABLE ===== */
        .ppn-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.22s ease;
        }

        .ppn-card:hover {
            border-color: var(--border-hover);
        }

        .ppn-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
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

        .ppn-card-header .link .icon {
            width: 13px;
            height: 13px;
        }

        .ppn-card-header .link:hover {
            text-decoration: underline;
        }

        .ppn-table-wrap {
            overflow-x: auto;
            padding: 0 4px 4px 4px;
        }

        .ppn-table-wrap.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

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

        .ppn-table tbody tr {
            transition: background 0.2s ease;
        }

        .ppn-table tbody tr:hover {
            background: var(--bg-card-hover);
        }

        .ppn-table tbody tr:last-child td {
            border-bottom: none;
        }

        .ppn-amount {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            font-size: 13.5px;
            text-align: right;
            color: var(--text-primary);
        }

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

        /* ============================================
           DROPDOWN TIGA TITIK
           ============================================ */
        .ppn-dropdown {
            position: relative;
            display: inline-block;
        }

        .ppn-dropdown .dropdown-toggle {
            background: transparent;
            border: none;
            padding: 4px 6px;
            border-radius: 6px;
            cursor: pointer;
            color: var(--text-tertiary);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ppn-dropdown .dropdown-toggle:hover {
            background: var(--bg-card-active);
            color: var(--text-primary);
        }

        .ppn-dropdown .dropdown-toggle .icon {
            width: 20px;
            height: 20px;
        }

        .ppn-dropdown .dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 4px);
            min-width: 170px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            animation: dropdownFade 0.2s ease;
            overflow: hidden;
            padding: 6px 0;
            display: none;
        }

        [data-theme="dark"] .ppn-dropdown .dropdown-menu {
            background: #1a1a2e;
            border-color: #2d2d44;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        .ppn-dropdown .dropdown-menu.active {
            display: block;
        }

        .ppn-dropdown .dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.15s ease;
            width: 100%;
            text-align: left;
            font-family: 'Inter', sans-serif;
        }

        .ppn-dropdown .dropdown-menu .dropdown-item .icon {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        .ppn-dropdown .dropdown-menu .dropdown-item:hover {
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        .ppn-dropdown .dropdown-menu .dropdown-item.show:hover {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .ppn-dropdown .dropdown-menu .dropdown-item.edit:hover {
            background: rgba(59, 130, 246, 0.12);
            color: #3b82f6;
        }

        [data-theme="dark"] .ppn-dropdown .dropdown-menu .dropdown-item.edit:hover {
            background: rgba(59, 130, 246, 0.20);
            color: #60a5fa;
        }

        .ppn-dropdown .dropdown-menu .dropdown-item.delete:hover {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .ppn-dropdown .dropdown-menu .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 4px 12px;
        }

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

        /* ============================================================
           MODAL DELETE
           ============================================================ */
        .ppn-modal-overlay {
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

        .ppn-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .ppn-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .ppn-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .ppn-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .ppn-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .ppn-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .ppn-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .ppn-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .ppn-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .ppn-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .ppn-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .ppn-modal-box .ppn-desc-text {
            font-weight: 700;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-size: 15px;
        }

        .ppn-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .ppn-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
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
            background: #DC2626;
            color: #fff;
        }

        .ppn-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .ppn-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .ppn-modal-actions .btn-danger:hover {
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
            .ppn-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .ppn-modern {
                padding: 0 12px;
            }
            .ppn-table {
                font-size: 12.5px;
            }

            .ppn-table th,
            .ppn-table td {
                padding: 10px 12px;
            }

            .ppn-card-header {
                padding: 14px 16px;
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
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

            .ppn-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }

            .ppn-modal-actions {
                flex-direction: column;
            }

            .ppn-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .ppn-modern {
                padding: 0 8px;
            }
            .ppn-header {
                flex-direction: column;
            }
            
            .ppn-header-actions {
                width: 100%;
            }
            
            .ppn-header-actions .ppn-btn {
                flex: 1;
                justify-content: center;
                font-size: 12px;
                padding: 8px 12px;
            }

            .ppn-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .ppn-stat-card .stat-value {
                font-size: 22px;
            }

            .ppn-modal-box {
                padding: 20px 16px;
            }

            .ppn-modal-box h3 {
                font-size: 18px;
            }

            .ppn-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }

            .ppn-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 380px) {
            .ppn-modern {
                padding: 0 4px;
            }
            .ppn-header h1 {
                font-size: 22px;
            }
            .ppn-btn {
                font-size: 11px;
                padding: 6px 10px;
            }
            .ppn-btn .icon {
                width: 13px;
                height: 13px;
            }
        }
    </style>

    <div class="ppn-modern">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

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
                    <strong id="ppnTotalCount">{{ $ppnCollection->count() }}</strong> periode pajak
                </p>
            </div>
            <div class="ppn-header-actions">
                <a href="{{ route('taxes.pph') }}" class="ppn-btn ppn-btn-ghost">
                    <svg class="icon"><use href="#ic-bank"/></svg>
                    PPh
                </a>
                <a href="{{ route('tax-calendar.index') }}" class="ppn-btn ppn-btn-ghost">
                    <svg class="icon"><use href="#ic-calendar"/></svg>
                    Kalender Pajak
                </a>
                <a href="{{ route('taxes.ppn.create') }}" class="ppn-btn ppn-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah PPN
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="ppn-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="ppn-success" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <span class="message">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar animate-in" style="animation-delay: 0.10s;">
            <form method="GET" action="{{ route('taxes.ppn') }}" id="ppnFilterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="ppnSearchInput" value="{{ request('q') }}" placeholder="Cari periode, status, atau nominal PPN..." autocomplete="off">
                </div>
                <div class="filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    @if(request()->filled('q'))
                        <a href="{{ route('taxes.ppn') }}" class="ppn-btn ppn-btn-ghost" id="resetBtn">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- ===== STATS ===== -->
        <div class="ppn-stats animate-in" style="animation-delay: 0.15s;" id="ppnStats">
            <div class="ppn-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-bank"/></svg>
                    </div>
                </div>
                <div class="stat-label">Total PPN</div>
                <div class="stat-value primary mono" id="ppnTotalPpn">{{ $currencySymbol }}{{ formatCompact($totalPpn) }}</div>
                <div class="stat-sub">Keseluruhan pajak</div>
            </div>
            <div class="ppn-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                    </div>
                    <span class="badge success">{{ $countPaid }} periode</span>
                </div>
                <div class="stat-label">Sudah Dibayar</div>
                <div class="stat-value success mono" id="ppnTotalPaid">{{ $currencySymbol }}{{ formatCompact($totalPaid) }}</div>
                <div class="stat-sub">PPN terbayar</div>
            </div>
            <div class="ppn-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                    </div>
                    <span class="badge">{{ $countPending }} periode</span>
                </div>
                <div class="stat-label">Belum Dibayar</div>
                <div class="stat-value warning mono" id="ppnTotalPending">{{ $currencySymbol }}{{ formatCompact($totalPending) }}</div>
                <div class="stat-sub">PPN tertunda</div>
            </div>
            <div class="ppn-stat-card">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-calendar"/></svg>
                    </div>
                </div>
                <div class="stat-label">Periode Selesai</div>
                <div class="stat-value" id="ppnPeriodCount">{{ $countPaid }} / {{ $ppnCollection->count() }}</div>
                <div class="stat-sub">Telah diselesaikan</div>
            </div>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="ppn-card animate-in" style="animation-delay: 0.20s;">
            <div class="ppn-card-header">
                <h3>Daftar PPN</h3>
                <a href="#" class="link" id="exportCsvBtn">
                    Ekspor CSV
                    <svg class="icon"><use href="#ic-chevron-right"/></svg>
                </a>
            </div>

            <div class="ppn-table-wrap" id="ppnTableWrap">
                <table class="ppn-table">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th style="text-align:right">PPN Keluaran</th>
                            <th style="text-align:right">PPN Masukan</th>
                            <th style="text-align:right">PPN</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th style="text-align:center; min-width:60px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ppnTableBody">
                        @forelse($ppnData as $index => $p)
                            @php
                                // PAKAI _index BUKAN id buatan
                                $itemId = $p['_index'];
                                $periodLower = strtolower($p['period']);
                            @endphp
                            <tr class="ppn-row-data" 
                                data-period="{{ $periodLower }}"
                                data-status="{{ $p['status'] }}"
                                data-ppn="{{ $p['ppn'] }}">
                                <td>{{ $p['period'] }}</td>
                                <td class="ppn-amount mono">{{ $currencySymbol }}{{ formatCompact($p['output']) }}</td>
                                <td class="ppn-amount mono">{{ $currencySymbol }}{{ formatCompact($p['input']) }}</td>
                                <td class="ppn-amount mono">{{ $currencySymbol }}{{ formatCompact($p['ppn']) }}</td>
                                <td>{{ formatTanggal($p['due']) }}</td>
                                <td>
                                    <span class="ppn-status {{ $statusPill[$p['status']] }}">{{ $statusLabel[$p['status']] }}</span>
                                </td>
                                <td>
                                    <!-- ===== DROPDOWN TIGA TITIK ===== -->
                                    <div class="ppn-dropdown">
                                        <button class="dropdown-toggle" onclick="toggleDropdown(event, this)" title="Menu">
                                            <svg class="icon"><use href="#ic-more"/></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($p['status'] == 'pending')
                                                <a href="{{ route('taxes.ppn.pay', $itemId) }}" class="dropdown-item" style="color: var(--success);">
                                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="20 6 9 17 4 12"/>
                                                    </svg>
                                                    Bayar PPN
                                                </a>
                                                <div class="dropdown-divider"></div>
                                            @endif
                                            <a href="{{ route('taxes.ppn.show', $itemId) }}" class="dropdown-item show">
                                                <svg class="icon"><use href="#ic-eye"/></svg>
                                                Lihat Detail
                                            </a>
                                            <a href="{{ route('taxes.ppn.edit', $itemId) }}" class="dropdown-item edit">
                                                <svg class="icon"><use href="#ic-edit"/></svg>
                                                Edit PPN
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <button class="dropdown-item delete" onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($p['period']) }}')">
                                                <svg class="icon"><use href="#ic-trash"/></svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="ppn-empty">
                                        <svg class="empty-icon"><use href="#ic-bank"/></svg>
                                        <h3>Belum Ada Data PPN</h3>
                                        <p>Belum ada data PPN yang tercatat di sistem.</p>
                                        <a href="{{ route('taxes.ppn.create') }}" class="ppn-btn ppn-btn-primary" style="display: inline-flex;">
                                            <svg class="icon"><use href="#ic-plus"/></svg>
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

    <!-- ============================================================
         MODAL DELETE
         ============================================================ -->
    <div class="ppn-modal-overlay" id="deleteModal">
        <div class="ppn-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Data PPN?</h3>

            <p>
                Anda yakin ingin menghapus data PPN
                <br>
                <span class="ppn-desc-text" id="deleteDesc">-</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="ppn-modal-actions">
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

        // ===== DROPDOWN TOGGLE =====
        function toggleDropdown(event, button) {
            event.stopPropagation();
            const menu = button.parentElement.querySelector('.dropdown-menu');
            const isActive = menu.classList.contains('active');
            
            // Tutup semua dropdown lain
            document.querySelectorAll('.ppn-dropdown .dropdown-menu.active').forEach(m => {
                if (m !== menu) m.classList.remove('active');
            });
            
            menu.classList.toggle('active');
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.ppn-dropdown')) {
                document.querySelectorAll('.ppn-dropdown .dropdown-menu.active').forEach(menu => {
                    menu.classList.remove('active');
                });
            }
        });

        // ===== DELETE MODAL =====
        function openDeleteModal(id, description) {
            // Tutup dropdown dulu
            document.querySelectorAll('.ppn-dropdown .dropdown-menu.active').forEach(menu => {
                menu.classList.remove('active');
            });
            
            document.getElementById('deleteDesc').textContent = description;
            document.getElementById('deleteForm').action = '/taxes/ppn/delete/' + id;
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
            // ===== LIVE SEARCH =====
            var searchInput = document.getElementById('ppnSearchInput');
            var resetBtn = document.getElementById('resetBtn');
            var rows = document.querySelectorAll('.ppn-row-data');
            var totalCountEl = document.getElementById('ppnTotalCount');
            var searchIndicator = document.getElementById('searchIndicator');
            var searchResultCount = document.getElementById('searchResultCount');
            var tableWrap = document.getElementById('ppnTableWrap');
            var currencySymbol = '{{ $currencySymbol }}';
            var loadingTimeout = null;

            function numberFormat(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function formatCompact(num) {
                if (num >= 1000000000) return (num / 1000000000).toFixed(1) + 'B';
                if (num >= 1000000) {
                    let val = num / 1000000;
                    return (val % 1 === 0) ? val.toFixed(0) + 'M' : val.toFixed(1) + 'M';
                }
                if (num >= 1000) {
                    let val = num / 1000;
                    return (val % 1 === 0) ? val.toFixed(0) + 'K' : val.toFixed(1) + 'K';
                }
                return num.toFixed(0);
            }

            function resetToInitial() {
                rows.forEach(row => {
                    row.style.display = '';
                });

                // Reset stats
                var totalPpn = 0;
                var totalPaid = 0;
                var totalPending = 0;
                var paidCount = 0;
                var pendingCount = 0;

                rows.forEach(row => {
                    var ppn = parseFloat(row.dataset.ppn) || 0;
                    var status = row.dataset.status || '';
                    totalPpn += ppn;
                    if (status === 'paid') {
                        totalPaid += ppn;
                        paidCount++;
                    } else if (status === 'pending') {
                        totalPending += ppn;
                        pendingCount++;
                    }
                });

                document.getElementById('ppnTotalPpn').textContent = currencySymbol + formatCompact(totalPpn);
                document.getElementById('ppnTotalPaid').textContent = currencySymbol + formatCompact(totalPaid);
                document.getElementById('ppnTotalPending').textContent = currencySymbol + formatCompact(totalPending);
                document.getElementById('ppnPeriodCount').textContent = paidCount + ' / ' + rows.length;
                totalCountEl.textContent = rows.length;

                searchIndicator.classList.remove('active');
                tableWrap.classList.remove('loading');

                // Reset URL
                var url = new URL(window.location.href);
                url.searchParams.delete('q');
                window.history.replaceState({}, '', url.toString());
            }

            function filterData() {
                var searchText = searchInput ? searchInput.value.trim() : '';
                
                if (searchText === '') {
                    resetToInitial();
                    return;
                }

                var visibleCount = 0;
                var totalPpnVisible = 0;
                var paidPpnVisible = 0;
                var pendingPpnVisible = 0;
                var paidCount = 0;
                var pendingCount = 0;

                var normalizedSearch = searchText.toLowerCase();

                rows.forEach(row => {
                    var period = row.dataset.period || '';
                    var status = row.dataset.status || '';
                    var statusLabel = '';
                    if (status === 'paid') statusLabel = 'dibayar';
                    else if (status === 'pending') statusLabel = 'pending';
                    var ppn = parseFloat(row.dataset.ppn) || 0;
                    var ppnFormatted = formatCompact(ppn);

                    var match = period.includes(normalizedSearch) ||
                               status.includes(normalizedSearch) ||
                               statusLabel.includes(normalizedSearch) ||
                               ppnFormatted.includes(normalizedSearch);

                    if (match) {
                        row.style.display = '';
                        visibleCount++;
                        totalPpnVisible += ppn;
                        if (status === 'paid') {
                            paidPpnVisible += ppn;
                            paidCount++;
                        } else if (status === 'pending') {
                            pendingPpnVisible += ppn;
                            pendingCount++;
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });

                searchIndicator.classList.add('active');
                searchResultCount.textContent = visibleCount;

                document.getElementById('ppnTotalPpn').textContent = currencySymbol + formatCompact(totalPpnVisible);
                document.getElementById('ppnTotalPaid').textContent = currencySymbol + formatCompact(paidPpnVisible);
                document.getElementById('ppnTotalPending').textContent = currencySymbol + formatCompact(pendingPpnVisible);
                document.getElementById('ppnPeriodCount').textContent = paidCount + ' / ' + visibleCount;
                totalCountEl.textContent = visibleCount;

                tableWrap.classList.remove('loading');
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }
                    
                    var url = new URL(window.location.href);
                    if (this.value.trim() !== '') {
                        url.searchParams.set('q', this.value.trim());
                    } else {
                        url.searchParams.delete('q');
                    }
                    window.history.replaceState({}, '', url.toString());

                    tableWrap.classList.add('loading');
                    loadingTimeout = setTimeout(function() {
                        filterData();
                    }, 300);
                });

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

            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.value = '';
                    }
                    resetToInitial();
                });
            }

            // Initial filter
            resetToInitial();

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.ppn-btn, .dropdown-item, .btn');
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

            // ===== EXPORT CSV =====
            const exportBtn = document.getElementById('exportCsvBtn');
            if (exportBtn) {
                exportBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const rows = document.querySelectorAll('.ppn-row-data');
                    let csvContent = "Periode,PPN Keluaran,PPN Masukan,PPN,Jatuh Tempo,Status\n";
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        if (cells.length >= 6) {
                            csvContent += `${cells[0].textContent.trim()},${cells[1].textContent.trim()},${cells[2].textContent.trim()},${cells[3].textContent.trim()},${cells[4].textContent.trim()},${cells[5].textContent.trim()}\n`;
                        }
                    });
                    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `ppn_data_${new Date().toISOString().split('T')[0]}.csv`;
                    link.click();
                });
            }
        });
    </script>

</x-app-layout>