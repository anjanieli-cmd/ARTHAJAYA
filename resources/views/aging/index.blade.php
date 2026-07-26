<x-app-layout>
    <x-slot name="title">Aging Report</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // 🔧 SEEDING SESSION — biar show/delete bisa nemu datanya
        if (!session()->has('aging_ar')) {
            session(['aging_ar' => $arRows]);
        }
        if (!session()->has('aging_ap')) {
            session(['aging_ap' => $apRows]);
        }

        $sumBucket = fn($rows, $key) => collect($rows)->sum($key);
        $totalAr = $sumBucket($arRows,'current') + $sumBucket($arRows,'d30') + $sumBucket($arRows,'d60') + $sumBucket($arRows,'d90');
        $totalAp = $sumBucket($apRows,'current') + $sumBucket($apRows,'d30') + $sumBucket($apRows,'d60') + $sumBucket($apRows,'d90');

        $buckets = [
            ['key' => 'current', 'label' => 'Lancar', 'short' => '0 hari', 'color' => 'var(--theme-primary)'],
            ['key' => 'd30',     'label' => '1–30 Hari', 'short' => '1–30', 'color' => '#F0A25A'],
            ['key' => 'd60',     'label' => '31–60 Hari', 'short' => '31–60', 'color' => '#E8804A'],
            ['key' => 'd90',     'label' => '61–90+ Hari', 'short' => '61–90+', 'color' => 'var(--danger)'],
        ];

        // Fungsi untuk format angka pendek (Rp 18,4 Jt, Rp 820 Rb, Rp 25 Rb)
        function formatAngkaPendek($angka) {
            if ($angka >= 1000000000) {
                return number_format($angka / 1000000000, 1, ',', '') . ' M';
            } elseif ($angka >= 1000000) {
                return number_format($angka / 1000000, 1, ',', '') . ' Jt';
            } elseif ($angka >= 1000) {
                return number_format($angka / 1000, 0, ',', '') . ' Rb';
            } else {
                return number_format($angka, 0, ',', '.');
            }
        }
    @endphp

    <!-- SVG Icons -->
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
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        /* ============================================
           AGING REPORT - Modern Design
           ============================================ */
        
        .aging-modern {
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
            --danger-glow: rgba(232, 90, 90, 0.20);
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .aging-modern * {
            box-sizing: border-box;
        }

        .aging-modern .mono {
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

        .aging-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        /* ----- SVG ICON BASE ----- */
        .aging-modern .icon {
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

        /* ----- FILTER BAR ----- */
        .filter-bar{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:20px;
            flex-wrap:wrap;
            background:var(--bg-card);
            padding:16px 20px;
            border-radius:var(--radius-md);
            border:1px solid var(--border-color);
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

        .filter-actions .aging-btn {
            padding: 8px 14px;
            font-size: 12px;
        }

        /* SEARCH INDICATOR */
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

        /* ----- HEADER SECTION ----- */
        .aging-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .aging-header-left {
            flex: 1;
            min-width: 200px;
        }

        .aging-badge {
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

        .aging-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .aging-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .aging-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .aging-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .aging-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .aging-btn {
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

        .aging-btn .icon {
            width: 16px;
            height: 16px;
        }

        .aging-btn:hover {
            transform: translateY(-2px);
        }

        .aging-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .aging-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .aging-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .aging-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .aging-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .aging-btn .ripple {
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

        /* ----- TABS ----- */
        .aging-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 4px;
        }

        .aging-tab {
            flex: 1;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            background: transparent;
            color: var(--text-secondary);
            text-align: center;
        }

        .aging-tab:hover {
            color: var(--text-primary);
            background: var(--bg-card-hover);
        }

        .aging-tab.active {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .aging-tab .count {
            font-size: 11px;
            opacity: 0.7;
            margin-left: 4px;
        }

        /* ----- PANEL ----- */
        .aging-panel {
            display: none;
        }

        .aging-panel.active {
            display: block;
            animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* ----- SUMMARY CARD ----- */
        .aging-summary {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            margin-bottom: 24px;
            transition: border-color 0.22s ease;
        }

        .aging-summary:hover {
            border-color: var(--border-hover);
        }

        .aging-summary-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .aging-summary-label {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .aging-summary-value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .aging-summary-stats {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .aging-summary-stat {
            text-align: right;
        }

        .aging-summary-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .aging-summary-stat .value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .aging-summary-stat .value.danger {
            color: var(--danger);
        }

        /* ----- BAR ----- */
        .aging-bar {
            display: flex;
            height: 10px;
            border-radius: 100px;
            overflow: hidden;
            background: var(--bg-card-active);
            margin-bottom: 16px;
        }

        .aging-bar .aging-seg {
            height: 100%;
            transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ----- LEGEND ----- */
        .aging-legend {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .aging-legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
        }

        .aging-legend-item .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .aging-legend-item .label {
            color: var(--text-secondary);
        }

        .aging-legend-item .amount {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 12px;
        }

        /* ----- AGING LIST ----- */
        .aging-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .aging-list.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .aging-item {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .aging-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: var(--theme-primary);
        }

        .aging-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateX(4px);
        }

        .aging-item:hover::before {
            opacity: 1;
        }

        .aging-item-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 10px;
        }

        .aging-item-info {
            flex: 1;
            min-width: 0;
        }

        .aging-item-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .aging-item-invoice {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .aging-item-total {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .aging-item-bar {
            display: flex;
            height: 6px;
            border-radius: 100px;
            overflow: hidden;
            background: var(--bg-card-active);
            margin-bottom: 10px;
        }

        .aging-item-bar .aging-seg {
            height: 100%;
            transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .aging-item-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .aging-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            color: var(--text-secondary);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            padding: 4px 10px;
            border-radius: 100px;
        }

        .aging-chip .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .aging-chip .amount {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ----- ACTION BUTTONS (di pojok kanan bawah) ----- */
        .aging-item-actions {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--border-color);
        }

        .aging-item-actions .btn-action {
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

        .aging-item-actions .btn-action .icon {
            width: 14px;
            height: 14px;
        }

        .aging-item-actions .btn-action.show {
            color: var(--theme-primary);
        }

        .aging-item-actions .btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .aging-item-actions .btn-action.danger {
            color: var(--danger);
        }

        .aging-item-actions .btn-action.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        /* ----- SUCCESS MESSAGE ----- */
        .aging-success {
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

        .aging-success .icon {
            width: 20px;
            height: 20px;
        }

        .aging-success .message {
            font-weight: 500;
        }

        /* ----- EMPTY STATE ----- */
        .aging-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .aging-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .aging-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
        }

        .aging-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ============================================================
           MODAL DELETE - PINGGIRAN BULAT 24px (SAMA KAYA AGING)
           ============================================================ */
        .aging-modal-overlay {
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

        .aging-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .aging-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .aging-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .aging-modal-box {
            border-radius: 24px;              /* <--- INI BIKIN GA LANCIP! */
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .aging-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .aging-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .aging-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .aging-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .aging-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .aging-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .aging-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .aging-modal-box .invoice-number {
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

        .aging-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .aging-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .aging-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .aging-modal-actions .btn {
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

        .aging-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .aging-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .aging-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .aging-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .aging-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .aging-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .aging-modal-actions .btn-danger:hover {
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
        @media (max-width: 768px) {
            .aging-summary-top {
                flex-direction: column;
                align-items: stretch;
            }

            .aging-summary-stats {
                justify-content: space-between;
            }

            .aging-item-top {
                flex-direction: column;
                gap: 4px;
            }

            .aging-item-total {
                align-self: flex-start;
            }

            .aging-legend {
                gap: 12px 18px;
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

            .aging-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }

            .aging-modal-actions {
                flex-direction: column;
            }

            .aging-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .aging-header {
                flex-direction: column;
            }
            
            .aging-header-actions {
                width: 100%;
            }
            
            .aging-header-actions .aging-btn {
                flex: 1;
                justify-content: center;
            }

            .aging-tab {
                font-size: 12px;
                padding: 8px 12px;
            }

            .aging-summary {
                padding: 18px 16px;
            }

            .aging-summary-value {
                font-size: 22px;
            }

            .aging-item {
                padding: 14px 16px;
            }

            .aging-item-chips {
                gap: 6px;
            }

            .aging-chip {
                font-size: 10.5px;
                padding: 3px 8px;
            }

            .aging-item-actions {
                justify-content: center;
            }

            .aging-modal-box {
                padding: 20px 16px;
            }

            .aging-modal-box h3 {
                font-size: 18px;
            }

            .aging-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }

            .aging-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 380px) {
            .aging-header h1 {
                font-size: 22px;
            }
            .aging-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .aging-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="aging-modern">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- ===== HEADER ===== -->
        <div class="aging-header animate-in" style="animation-delay: 0.05s;">
            <div class="aging-header-left">
                <div class="aging-badge">
                    <span class="dot"></span>
                    Piutang &amp; Utang
                </div>
                <h1>Aging Report</h1>
                <p class="subtitle">
                    Rincian umur piutang dan utang dalam kelompok 
                    <strong>0, 1–30, 31–60, dan 61–90+</strong> hari
                </p>
            </div>
            <div class="aging-header-actions">
                <a href="{{ route('aging.export-pdf', ['type' => 'ar']) }}" class="aging-btn aging-btn-ghost" target="_blank">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    Ekspor PDF
                </a>
                <a href="{{ route('receivables.index') }}" class="aging-btn aging-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                    Lihat Piutang
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="aging-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="aging-success" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <span class="message">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar animate-in" style="animation-delay: 0.09s;">
            <form method="GET" action="{{ route('aging.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="agingSearchInput" value="{{ request('q') }}" placeholder="Cari nama atau nomor invoice..." autocomplete="off">
                </div>
                <div class="filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <a href="{{ route('aging.index') }}" class="aging-btn aging-btn-ghost" id="resetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- ===== TABS ===== -->
        <div class="aging-tabs animate-in" style="animation-delay: 0.10s;" id="agingTabs">
            <button class="aging-tab active" data-tab="ar">
                Piutang (AR)
                <span class="count" id="arCount">({{ count($arRows) }})</span>
            </button>
            <button class="aging-tab" data-tab="ap">
                Utang (AP)
                <span class="count" id="apCount">({{ count($apRows) }})</span>
            </button>
        </div>

        <!-- ===== PANEL AR ===== -->
        <div class="aging-panel active" data-panel="ar">
            <!-- Summary -->
            <div class="aging-summary animate-in" style="animation-delay: 0.15s;" id="arSummary">
                <div class="aging-summary-top">
                    <div>
                        <div class="aging-summary-label">Total Piutang Berdasarkan Umur</div>
                        <div class="aging-summary-value mono" id="arTotal">{{ $currencySymbol }}{{ formatAngkaPendek($totalAr) }}</div>
                    </div>
                    <div class="aging-summary-stats">
                        <div class="aging-summary-stat">
                            <div class="label">Jatuh Tempo</div>
                            <div class="value danger mono" id="arOverdue">{{ $currencySymbol }}{{ formatAngkaPendek($sumBucket($arRows,'d30') + $sumBucket($arRows,'d60') + $sumBucket($arRows,'d90')) }}</div>
                        </div>
                        <div class="aging-summary-stat">
                            <div class="label">Rata-rata Umur</div>
                            <div class="value mono" id="arAvgAge">{{ $totalAr > 0 ? round((($sumBucket($arRows,'d30') * 15) + ($sumBucket($arRows,'d60') * 45) + ($sumBucket($arRows,'d90') * 75)) / $totalAr) : 0 }} hari</div>
                        </div>
                    </div>
                </div>

                <div class="aging-bar" id="arBar">
                    @foreach($buckets as $b)
                        <div class="aging-seg" style="width: {{ $totalAr > 0 ? round($sumBucket($arRows, $b['key']) / $totalAr * 100, 2) : 0 }}%; background: {{ $b['color'] }}"></div>
                    @endforeach
                </div>

                <div class="aging-legend" id="arLegend">
                    @foreach($buckets as $b)
                        <div class="aging-legend-item">
                            <span class="dot" style="background: {{ $b['color'] }}"></span>
                            <span class="label">{{ $b['label'] }}</span>
                            <span class="amount mono" id="arLegend{{ $b['key'] }}">{{ $currencySymbol }}{{ formatAngkaPendek($sumBucket($arRows, $b['key'])) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- List -->
            <div class="aging-list" id="arList">
                @forelse($arRows as $index => $row)
                    @php 
                        $rowTotal = $row['current'] + $row['d30'] + $row['d60'] + $row['d90'];
                    @endphp
                    <div class="aging-item animate-in" style="animation-delay: {{ 0.20 + ($loop->index * 0.04) }}s;">
                        <div class="aging-item-top">
                            <div class="aging-item-info">
                                <div class="aging-item-name">{{ $row['name'] }}</div>
                                <div class="aging-item-invoice mono">{{ $row['invoice'] }}</div>
                            </div>
                            <div class="aging-item-total mono">{{ $currencySymbol }}{{ formatAngkaPendek($rowTotal) }}</div>
                        </div>
                        
                        <div class="aging-item-bar">
                            @foreach($buckets as $b)
                                @if($row[$b['key']] > 0)
                                    <div class="aging-seg" style="width: {{ $rowTotal > 0 ? round($row[$b['key']] / $rowTotal * 100, 2) : 0 }}%; background: {{ $b['color'] }}"></div>
                                @endif
                            @endforeach
                        </div>

                        <div class="aging-item-chips">
                            @foreach($buckets as $b)
                                @if($row[$b['key']] > 0)
                                    <span class="aging-chip">
                                        <span class="dot" style="background: {{ $b['color'] }}"></span>
                                        {{ $b['short'] }}
                                        <span class="amount mono">{{ $currencySymbol }}{{ formatAngkaPendek($row[$b['key']]) }}</span>
                                    </span>
                                @endif
                            @endforeach
                            @if($rowTotal == 0)
                                <span class="aging-chip" style="color: var(--text-tertiary);">Tidak ada saldo</span>
                            @endif
                        </div>

                        <div class="aging-item-actions">
                            <a href="/aging/show/{{ $index }}?type=ar" class="btn-action show" title="Lihat Detail">
                                <svg class="icon"><use href="#ic-eye"/></svg>
                            </a>
                            <button type="button" class="btn-action danger" title="Hapus"
                                    onclick="openDeleteModal('ar', '{{ $index }}', '{{ addslashes($row['invoice']) }}')">
                                <svg class="icon"><use href="#ic-trash"/></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="aging-empty">
                        <svg class="empty-icon"><use href="#ic-file-text"/></svg>
                        <h3>Belum Ada Data Piutang</h3>
                        <p>Belum ada piutang yang tercatat di sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ===== PANEL AP ===== -->
        <div class="aging-panel" data-panel="ap">
            <!-- Summary -->
            <div class="aging-summary animate-in" style="animation-delay: 0.15s;" id="apSummary">
                <div class="aging-summary-top">
                    <div>
                        <div class="aging-summary-label">Total Utang Berdasarkan Umur</div>
                        <div class="aging-summary-value mono" id="apTotal">{{ $currencySymbol }}{{ formatAngkaPendek($totalAp) }}</div>
                    </div>
                    <div class="aging-summary-stats">
                        <div class="aging-summary-stat">
                            <div class="label">Jatuh Tempo</div>
                            <div class="value danger mono" id="apOverdue">{{ $currencySymbol }}{{ formatAngkaPendek($sumBucket($apRows,'d30') + $sumBucket($apRows,'d60') + $sumBucket($apRows,'d90')) }}</div>
                        </div>
                        <div class="aging-summary-stat">
                            <div class="label">Rata-rata Umur</div>
                            <div class="value mono" id="apAvgAge">{{ $totalAp > 0 ? round((($sumBucket($apRows,'d30') * 15) + ($sumBucket($apRows,'d60') * 45) + ($sumBucket($apRows,'d90') * 75)) / $totalAp) : 0 }} hari</div>
                        </div>
                    </div>
                </div>

                <div class="aging-bar" id="apBar">
                    @foreach($buckets as $b)
                        <div class="aging-seg" style="width: {{ $totalAp > 0 ? round($sumBucket($apRows, $b['key']) / $totalAp * 100, 2) : 0 }}%; background: {{ $b['color'] }}"></div>
                    @endforeach
                </div>

                <div class="aging-legend" id="apLegend">
                    @foreach($buckets as $b)
                        <div class="aging-legend-item">
                            <span class="dot" style="background: {{ $b['color'] }}"></span>
                            <span class="label">{{ $b['label'] }}</span>
                            <span class="amount mono" id="apLegend{{ $b['key'] }}">{{ $currencySymbol }}{{ formatAngkaPendek($sumBucket($apRows, $b['key'])) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- List -->
            <div class="aging-list" id="apList">
                @forelse($apRows as $index => $row)
                    @php 
                        $rowTotal = $row['current'] + $row['d30'] + $row['d60'] + $row['d90'];
                    @endphp
                    <div class="aging-item animate-in" style="animation-delay: {{ 0.20 + ($loop->index * 0.04) }}s;">
                        <div class="aging-item-top">
                            <div class="aging-item-info">
                                <div class="aging-item-name">{{ $row['name'] }}</div>
                                <div class="aging-item-invoice mono">{{ $row['invoice'] }}</div>
                            </div>
                            <div class="aging-item-total mono">{{ $currencySymbol }}{{ formatAngkaPendek($rowTotal) }}</div>
                        </div>
                        
                        <div class="aging-item-bar">
                            @foreach($buckets as $b)
                                @if($row[$b['key']] > 0)
                                    <div class="aging-seg" style="width: {{ $rowTotal > 0 ? round($row[$b['key']] / $rowTotal * 100, 2) : 0 }}%; background: {{ $b['color'] }}"></div>
                                @endif
                            @endforeach
                        </div>

                        <div class="aging-item-chips">
                            @foreach($buckets as $b)
                                @if($row[$b['key']] > 0)
                                    <span class="aging-chip">
                                        <span class="dot" style="background: {{ $b['color'] }}"></span>
                                        {{ $b['short'] }}
                                        <span class="amount mono">{{ $currencySymbol }}{{ formatAngkaPendek($row[$b['key']]) }}</span>
                                    </span>
                                @endif
                            @endforeach
                            @if($rowTotal == 0)
                                <span class="aging-chip" style="color: var(--text-tertiary);">Tidak ada saldo</span>
                            @endif
                        </div>

                        <div class="aging-item-actions">
                            <a href="/aging/show/{{ $index }}?type=ap" class="btn-action show" title="Lihat Detail">
                                <svg class="icon"><use href="#ic-eye"/></svg>
                            </a>
                            <button type="button" class="btn-action danger" title="Hapus"
                                    onclick="openDeleteModal('ap', '{{ $index }}', '{{ addslashes($row['invoice']) }}')">
                                <svg class="icon"><use href="#ic-trash"/></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="aging-empty">
                        <svg class="empty-icon"><use href="#ic-file-text"/></svg>
                        <h3>Belum Ada Data Utang</h3>
                        <p>Belum ada utang yang tercatat di sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ===== MODAL DELETE ===== -->
        <div class="aging-modal-overlay" id="deleteModal">
            <div class="aging-modal-box">
                <!-- ICON DANGER -->
                <div class="icon-danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>

                <!-- JUDUL -->
                <h3>Hapus Data Ini?</h3>

                <!-- DESKRIPSI -->
                <p>
                    Anda yakin ingin menghapus data
                    <br>
                    <span class="invoice-number" id="deleteInvoiceNumber">-</span>
                </p>

                <!-- WARNING -->
                <div class="warning-text">
                    ⚠️ Data yang dihapus tidak dapat dikembalikan!
                </div>

                <!-- TOMBOL -->
                <div class="aging-modal-actions">
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
        function openDeleteModal(type, index, invoiceNumber) {
            document.getElementById('deleteInvoiceNumber').textContent = invoiceNumber;
            var url = '/aging/delete/' + index + '?type=' + type;
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
            // ===== LIVE SEARCH =====
            var searchInput = document.getElementById('agingSearchInput');
            var arList = document.getElementById('arList');
            var apList = document.getElementById('apList');
            var resetBtn = document.getElementById('resetBtn');
            var searchIndicator = document.getElementById('searchIndicator');
            var searchResultCount = document.getElementById('searchResultCount');
            var loadingTimeout = null;

            function resetToInitial() {
                if (searchInput) {
                    searchInput.value = '';
                }

                if (searchIndicator) {
                    searchIndicator.classList.remove('active');
                }

                var url = new URL(window.location.href);
                url.searchParams.delete('q');
                window.history.replaceState({}, '', url.toString());

                updateResults(true);
            }

            function updateResults(isReset = false) {
                if (arList) arList.classList.add('loading');
                if (apList) apList.classList.add('loading');
                
                var q = searchInput ? searchInput.value : '';
                var url = '{{ route("aging.index") }}';
                if (!isReset && q) {
                    url += '?q=' + encodeURIComponent(q);
                }
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    
                    var newArList = doc.querySelector('#arList');
                    if (newArList && arList) {
                        arList.innerHTML = newArList.innerHTML;
                    }
                    
                    var newArSummary = doc.querySelector('#arSummary');
                    if (newArSummary) {
                        document.getElementById('arSummary').innerHTML = newArSummary.innerHTML;
                    }
                    
                    var newApList = doc.querySelector('#apList');
                    if (newApList && apList) {
                        apList.innerHTML = newApList.innerHTML;
                    }
                    
                    var newApSummary = doc.querySelector('#apSummary');
                    if (newApSummary) {
                        document.getElementById('apSummary').innerHTML = newApSummary.innerHTML;
                    }
                    
                    var newArCount = doc.querySelector('#arCount');
                    if (newArCount) {
                        document.getElementById('arCount').textContent = newArCount.textContent;
                    }
                    
                    var newApCount = doc.querySelector('#apCount');
                    if (newApCount) {
                        document.getElementById('apCount').textContent = newApCount.textContent;
                    }

                    if (searchIndicator && searchResultCount && !isReset && q) {
                        var newItems = doc.querySelectorAll('.aging-item');
                        var count = newItems.length;
                        if (count > 0) {
                            searchIndicator.classList.add('active');
                            searchResultCount.textContent = count;
                        } else {
                            searchIndicator.classList.remove('active');
                        }
                    } else if (isReset) {
                        if (searchIndicator) {
                            searchIndicator.classList.remove('active');
                        }
                    }
                    
                    if (arList) arList.classList.remove('loading');
                    if (apList) apList.classList.remove('loading');
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    if (arList) arList.classList.remove('loading');
                    if (apList) apList.classList.remove('loading');
                    showToast('Error', 'Gagal memuat data. Silakan refresh halaman.', 'error');
                });
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

                    loadingTimeout = setTimeout(function() {
                        updateResults(false);
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
                    resetToInitial();
                });
            }

            // ===== TABS =====
            const tabs = document.querySelectorAll('.aging-tab');
            const panels = {
                ar: document.querySelector('[data-panel="ar"]'),
                ap: document.querySelector('[data-panel="ap"]')
            };

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const target = this.dataset.tab;
                    Object.keys(panels).forEach(key => {
                        panels[key].classList.toggle('active', key === target);
                    });
                });
            });

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.aging-btn');
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

            // ===== ANIMASI BAR =====
            setTimeout(() => {
                document.querySelectorAll('.aging-bar .aging-seg, .aging-item-bar .aging-seg').forEach(seg => {
                    const width = seg.style.width;
                    seg.style.width = '0%';
                    setTimeout(() => {
                        seg.style.width = width;
                    }, 100);
                });
            }, 200);
        });
    </script>

</x-app-layout>