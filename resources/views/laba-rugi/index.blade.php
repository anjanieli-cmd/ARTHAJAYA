<x-app-layout>
    <x-slot name="title">Laba Rugi</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        function formatCompact($number) {
            if ($number === null || $number === '') return '0';
            $number = (float) $number;
            if ($number >= 1000000000) {
                return number_format($number / 1000000000, 1, ',', '.') . 'B';
            } elseif ($number >= 1000000) {
                $result = $number / 1000000;
                return ($result == floor($result)) ? number_format($result, 0) . 'M' : number_format($result, 1) . 'M';
            } elseif ($number >= 1000) {
                $result = $number / 1000;
                return ($result == floor($result)) ? number_format($result, 0) . 'K' : number_format($result, 1) . 'K';
            } else {
                return number_format($number, 0, ',', '.');
            }
        }
    @endphp

    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-trending-up" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
            </symbol>
            <symbol id="ic-trending-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .lr-wrap {
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

        .lr-wrap * { box-sizing: border-box; }
        .lr-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px) scale(.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .lr-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .lr-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== TOAST ===== */
        .toast-container {
            position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; max-width: 380px; width: 100%;
        }
        .toast {
            background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: slideDown .35s cubic-bezier(.16,1,.3,1);
            display: flex; align-items: center; gap: 12px; backdrop-filter: blur(12px);
        }
        .toast .toast-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .toast .toast-icon.success { background: var(--success-soft); color: var(--success); }
        .toast .toast-icon.error { background: var(--danger-soft); color: var(--danger); }
        .toast .toast-icon .icon { width: 18px; height: 18px; }
        .toast .toast-content { flex: 1; }
        .toast .toast-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .toast .toast-msg { font-size: 12px; color: var(--text-secondary); }
        .toast .toast-close { background: none; border: none; color: var(--text-tertiary); cursor: pointer; padding: 4px; }
        .toast .toast-close .icon { width: 14px; height: 14px; }

        /* ===== HEADER ===== */
        .lr-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .lr-header-left { flex: 1; min-width: 200px; }

        .lr-badge {
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

        .lr-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .lr-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .lr-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .lr-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .lr-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .lr-btn {
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

        .lr-btn .icon { width: 16px; height: 16px; }
        .lr-btn:hover { transform: translateY(-2px); }
        .lr-btn:active { transform: translateY(0) scale(0.97); }

        .lr-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .lr-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .lr-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .lr-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .lr-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== SEARCH ===== */
        .lr-search {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .lr-search:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .lr-search form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .lr-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .lr-search-wrap .icon {
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

        .lr-search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .lr-search input[type="text"] {
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

        .lr-search input[type="text"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .lr-search input[type="text"]::placeholder {
            color: var(--text-tertiary);
        }

        .lr-search-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .lr-search-actions .lr-btn {
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

        /* ===== PERIOD FILTER ===== */
        .lr-filter {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px 20px;
        }

        .lr-filter .filter-label {
            font-size: 12px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lr-filter .filter-label .icon {
            width: 14px;
            height: 14px;
        }

        .lr-filter select {
            padding: 8px 38px 8px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            font-family: inherit;
            min-width: 120px;
        }

        .lr-filter select:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .lr-filter select:hover {
            border-color: var(--border-hover);
        }

        .lr-filter-actions {
            display: flex;
            gap: 8px;
            margin-left: auto;
        }

        .lr-filter-actions .lr-btn {
            padding: 8px 14px;
            font-size: 12px;
        }

        /* ===== 2-COLUMN GRID ===== */
        .lr-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }

        .lr-col {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .lr-col:hover {
            border-color: var(--border-hover);
        }

        .lr-col-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .lr-col-header .col-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .lr-col-header .col-icon .icon {
            width: 18px;
            height: 18px;
        }

        .lr-col.pendapatan .col-icon {
            background: var(--success-soft);
            color: var(--success);
        }

        .lr-col.beban .col-icon {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .lr-col-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .lr-col-header .count-badge {
            margin-left: auto;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 100px;
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }

        .lr-col-body {
            padding: 12px 16px 4px;
        }

        .lr-group-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            margin: 8px 4px 6px;
            padding: 6px 8px 4px;
            border-bottom: 1px solid var(--border-color);
        }

        .lr-group-title:first-of-type {
            margin-top: 0;
        }

        .lr-row {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            border-radius: 8px;
            gap: 10px;
            font-size: 13.5px;
            transition: all 0.15s ease;
        }

        .lr-row:hover {
            background: var(--bg-card-active);
        }

        .lr-row.hidden-row {
            display: none;
        }

        .lr-row-name {
            flex: 1;
            min-width: 0;
            color: var(--text-primary);
            font-weight: 500;
        }

        .lr-row-amount {
            font-family: 'IBM Plex Mono', monospace;
            white-space: nowrap;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .lr-row-actions {
            display: flex;
            gap: 4px;
            flex-shrink: 0;
        }

        .lr-row-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: none;
            background: transparent;
            color: var(--text-tertiary);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .lr-row-action .icon {
            width: 14px;
            height: 14px;
        }

        .lr-row-action:hover {
            background: var(--bg-card-active);
            color: var(--text-primary);
            transform: translateY(-1px);
        }

        .lr-row-action.view:hover {
            background: var(--info-soft);
            color: var(--info);
        }

        .lr-row-action.edit:hover {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .lr-row-action.delete:hover {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .lr-row-action button {
            all: unset;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .lr-subtotal {
            display: flex;
            justify-content: space-between;
            padding: 6px 10px 10px;
            margin: 0 4px 6px;
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 600;
            border-bottom: 1px dashed var(--border-color);
        }

        .lr-empty {
            font-size: 13px;
            color: var(--text-tertiary);
            padding: 20px 12px;
            text-align: center;
        }

        .lr-col-total {
            display: flex;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 2px solid var(--border-color);
            font-size: 15px;
            font-weight: 700;
        }

        .lr-col.pendapatan .lr-col-total {
            color: var(--success);
            background: var(--success-soft);
        }

        .lr-col.beban .lr-col-total {
            color: var(--danger);
            background: var(--danger-soft);
        }

        /* ===== SUMMARY BAR ===== */
        .lr-summary {
            margin-top: 20px;
            padding: 20px 28px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            border: 1px solid var(--border-color);
        }

        .lr-summary.positive {
            background: var(--success-soft);
            border-color: rgba(52, 181, 131, 0.3);
        }

        .lr-summary.negative {
            background: var(--danger-soft);
            border-color: rgba(232, 90, 90, 0.3);
        }

        .lr-summary-left {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .lr-summary-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .lr-summary-sublabel {
            font-size: 12px;
            color: var(--text-tertiary);
        }

        .lr-summary-value {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 28px;
            font-weight: 700;
        }

        .lr-summary.positive .lr-summary-value {
            color: var(--success);
        }

        .lr-summary.negative .lr-summary-value {
            color: var(--danger);
        }

        .lr-summary-detail {
            display: flex;
            gap: 28px;
        }

        .lr-summary-item {
            text-align: right;
        }

        .lr-summary-item .k {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-bottom: 2px;
            font-weight: 500;
        }

        .lr-summary-item .v {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            font-weight: 600;
        }

        .lr-summary-item .v.green {
            color: var(--success);
        }

        .lr-summary-item .v.red {
            color: var(--danger);
        }

        /* ===== EMPTY ===== */
        .lr-empty-state {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .lr-empty-state .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .lr-empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .lr-empty-state p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        /* ============================================================
           DELETE MODAL - SAMA SEPERTI HALAMAN FAKTUR
           ============================================================ */
        .lr-modal-overlay {
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

        .lr-modal-overlay.active {
            display: flex;
        }

        .lr-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="dark"] .lr-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .lr-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .lr-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .lr-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .lr-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .lr-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .lr-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
        }

        .lr-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
        }

        .lr-modal-box .item-name-modal {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-size: 15px;
        }

        .lr-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .lr-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .lr-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .lr-modal-actions .btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .lr-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .lr-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .lr-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .lr-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .lr-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .lr-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .lr-modal-actions .btn-danger:hover {
            background: #B91C1C;
        }

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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .lr-grid { grid-template-columns: 1fr; }
            .lr-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .lr-wrap { padding: 0 12px; }
            .lr-header { flex-direction: column; }
            .lr-actions { width: 100%; }
            .lr-actions .lr-btn { flex: 1; justify-content: center; }
            .lr-search { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 10px; 
                padding: 12px 16px;
            }
            .lr-search form { flex-direction: column; }
            .lr-search-wrap { min-width: 100%; }
            .lr-search-actions { 
                width: 100%; 
                justify-content: flex-end; 
                flex-wrap: wrap;
            }
            .lr-filter { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 8px; 
                padding: 12px 16px;
            }
            .lr-filter select { width: 100%; }
            .lr-filter-actions { 
                width: 100%; 
                justify-content: flex-end; 
                flex-wrap: wrap;
                margin-left: 0;
            }
            .lr-filter-actions .lr-btn { flex: 1; }
            .lr-col-body { padding: 8px 12px 4px; }
            .lr-summary { flex-direction: column; text-align: center; }
            .lr-summary-detail { 
                flex-direction: column; 
                gap: 12px;
                width: 100%;
            }
            .lr-summary-item { text-align: center; }
            .lr-modal-box { padding: 24px 20px; margin: 10px; }
            .lr-modal-actions { flex-direction: column; }
            .lr-modal-actions .btn { width: 100%; }
        }

        @media (max-width: 640px) {
            .lr-wrap { padding: 0 8px; }
            .lr-header h1 { font-size: 22px; }
            .lr-btn { font-size: 12px; padding: 8px 14px; }
            .lr-btn .icon { width: 14px; height: 14px; }
            .lr-col { border-radius: var(--radius-sm); }
            .lr-col-header { padding: 12px 16px; }
            .lr-col-total { padding: 12px 16px; font-size: 14px; }
            .lr-summary-value { font-size: 22px; }
            .lr-summary { padding: 16px 20px; }
            .lr-modal-box { padding: 20px 16px; }
            .lr-modal-box h3 { font-size: 18px; }
            .lr-modal-box .icon-danger { width: 48px; height: 48px; }
            .lr-modal-box .icon-danger svg { width: 24px; height: 24px; }
        }

        @media (max-width: 480px) {
            .lr-wrap { padding: 0 4px; }
            .lr-btn { font-size: 11px; padding: 6px 10px; }
            .lr-btn .icon { width: 13px; height: 13px; }
            .lr-row { font-size: 12px; padding: 6px 8px; }
            .lr-row-amount { font-size: 12px; }
            .lr-row-action { width: 24px; height: 24px; }
            .lr-row-action .icon { width: 12px; height: 12px; }
        }
    </style>

    <div class="lr-wrap">

        {{-- ===== TOAST ===== --}}
        <div class="toast-container" id="toastContainer"></div>

        {{-- ===== HEADER ===== --}}
        <div class="lr-header animate-in" style="animation-delay: 0.05s;">
            <div class="lr-header-left">
                <div class="lr-badge">
                    <span class="dot"></span>
                    Laporan Keuangan
                </div>
                <h1>Laba Rugi</h1>
                <p class="subtitle">
                    Ringkasan pendapatan dan beban <strong>{{ $company->name ?? 'perusahaanmu' }}</strong> per periode.
                </p>
            </div>
            <div class="lr-actions">
                <a href="{{ route('laba-rugi.create') }}" class="lr-btn lr-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Pos
                </a>
            </div>
        </div>

        {{-- ===== SEARCH ===== --}}
        <div class="lr-search animate-in" style="animation-delay: 0.08s;">
            <form method="GET" action="{{ route('laba-rugi.index') }}" id="lrSearchForm" onsubmit="return false;">
                <div class="lr-search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="lrSearchInput" value="{{ request('q') }}" 
                           placeholder="Cari pos pendapatan atau beban..." autocomplete="off">
                </div>
                <div class="lr-search-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <button type="button" class="lr-btn lr-btn-ghost" id="lrResetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </button>
                </div>
            </form>
        </div>

        {{-- ===== PERIOD FILTER ===== --}}
        <div class="lr-filter animate-in" style="animation-delay: 0.10s;">
            <span class="filter-label">
                <svg class="icon"><use href="#ic-calendar"/></svg>
                Periode
            </span>
            <form method="GET" action="{{ route('laba-rugi.index') }}" id="lrPeriodForm">
                <select name="month" onchange="this.form.submit()">
                    @php $bulanList=[1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; @endphp
                    @foreach($bulanList as $num => $label)
                        <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="year" onchange="this.form.submit()">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
            <div class="lr-filter-actions">
                <a href="{{ route('laba-rugi.index') }}" class="lr-btn lr-btn-ghost">
                    <svg class="icon"><use href="#ic-x"/></svg>
                    Reset
                </a>
            </div>
        </div>

        {{-- ===== 2-COLUMN GRID ===== --}}
        @if(isset($pendapatan) && ($pendapatan->isNotEmpty() || $beban->isNotEmpty()))
            <div class="lr-grid animate-in" style="animation-delay: 0.12s;" id="lrGrid">

                {{-- KIRI: PENDAPATAN --}}
                <div class="lr-col pendapatan" id="lrColPendapatan">
                    <div class="lr-col-header">
                        <div class="col-icon">
                            <svg class="icon"><use href="#ic-trending-up"/></svg>
                        </div>
                        <h3>Pendapatan</h3>
                        <span class="count-badge">{{ $pendapatan->count() }} pos</span>
                    </div>
                    <div class="lr-col-body">
                        @forelse($pendapatan as $category => $groupItems)
                            <div class="lr-group-title">{{ $category }}</div>
                            @foreach($groupItems as $item)
                                <div class="lr-row lr-row-data" data-name="{{ strtolower($item->name) }}" data-category="{{ strtolower($category) }}">
                                    <span class="lr-row-name">{{ $item->name }}</span>
                                    <span class="lr-row-amount">{{ $currencySymbol }}{{ formatCompact($item->amount) }}</span>
                                    <div class="lr-row-actions">
                                        <a href="{{ route('laba-rugi.show', $item) }}" class="lr-row-action view" title="Lihat">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('laba-rugi.edit', $item) }}" class="lr-row-action edit" title="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="lr-row-action delete" title="Hapus" onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->name) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="lr-subtotal">
                                <span>Subtotal {{ $category }}</span>
                                <span>{{ $currencySymbol }}{{ formatCompact($groupItems->sum('amount')) }}</span>
                            </div>
                        @empty
                            <div class="lr-empty">Belum ada pos pendapatan untuk periode ini.</div>
                        @endforelse
                    </div>
                    <div class="lr-col-total">
                        <span>Total Pendapatan</span>
                        <span>{{ $currencySymbol }}{{ formatCompact($totalPendapatan ?? 0) }}</span>
                    </div>
                </div>

                {{-- KANAN: BEBAN --}}
                <div class="lr-col beban" id="lrColBeban">
                    <div class="lr-col-header">
                        <div class="col-icon">
                            <svg class="icon"><use href="#ic-trending-down"/></svg>
                        </div>
                        <h3>Beban</h3>
                        <span class="count-badge">{{ $beban->count() }} pos</span>
                    </div>
                    <div class="lr-col-body">
                        @forelse($beban as $category => $groupItems)
                            <div class="lr-group-title">{{ $category }}</div>
                            @foreach($groupItems as $item)
                                <div class="lr-row lr-row-data" data-name="{{ strtolower($item->name) }}" data-category="{{ strtolower($category) }}">
                                    <span class="lr-row-name">{{ $item->name }}</span>
                                    <span class="lr-row-amount">{{ $currencySymbol }}{{ formatCompact($item->amount) }}</span>
                                    <div class="lr-row-actions">
                                        <a href="{{ route('laba-rugi.show', $item) }}" class="lr-row-action view" title="Lihat">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('laba-rugi.edit', $item) }}" class="lr-row-action edit" title="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="lr-row-action delete" title="Hapus" onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->name) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="lr-subtotal">
                                <span>Subtotal {{ $category }}</span>
                                <span>{{ $currencySymbol }}{{ formatCompact($groupItems->sum('amount')) }}</span>
                            </div>
                        @empty
                            <div class="lr-empty">Belum ada pos beban untuk periode ini.</div>
                        @endforelse
                    </div>
                    <div class="lr-col-total">
                        <span>Total Beban</span>
                        <span>{{ $currencySymbol }}{{ formatCompact($totalBeban ?? 0) }}</span>
                    </div>
                </div>
            </div>

            {{-- ===== SUMMARY BAR ===== --}}
            <div class="lr-summary {{ ($labaBersih ?? 0) >= 0 ? 'positive' : 'negative' }} animate-in" style="animation-delay: 0.15s;">
                <div class="lr-summary-left">
                    <div class="lr-summary-label">{{ ($labaBersih ?? 0) >= 0 ? '📈 Laba Bersih' : '📉 Rugi Bersih' }}</div>
                    <div class="lr-summary-sublabel">{{ \Carbon\Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, 1)->translatedFormat('F Y') }} — {{ $company->name ?? 'Perusahaan' }}</div>
                    <div class="lr-summary-value">{{ $currencySymbol }}{{ formatCompact(abs($labaBersih ?? 0)) }}</div>
                </div>
                <div class="lr-summary-detail">
                    <div class="lr-summary-item">
                        <div class="k">Total Pendapatan</div>
                        <div class="v green">{{ $currencySymbol }}{{ formatCompact($totalPendapatan ?? 0) }}</div>
                    </div>
                    <div class="lr-summary-item">
                        <div class="k">Total Beban</div>
                        <div class="v red">{{ $currencySymbol }}{{ formatCompact($totalBeban ?? 0) }}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="lr-empty-state animate-in" style="animation-delay: 0.12s;">
                <svg class="empty-icon"><use href="#ic-inbox"/></svg>
                <h3>Belum ada data laba rugi</h3>
                <p>Tambahkan pos pendapatan atau beban untuk mulai menyusun laporan laba rugi.</p>
                <a href="{{ route('laba-rugi.create') }}" class="lr-btn lr-btn-primary" style="display:inline-flex;">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Pos Pertama
                </a>
            </div>
        @endif

    </div>

    {{-- ===== DELETE MODAL - SAMA SEPERTI HALAMAN FAKTUR ===== --}}
    <div class="lr-modal-overlay" id="deleteModal">
        <div class="lr-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Pos Ini?</h3>

            <p>
                Anda yakin ingin menghapus pos
                <br>
                <span class="item-name-modal" id="deleteItemName">—</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="lr-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                <form method="POST" id="deleteForm" action="">
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
        // ===== TOAST =====
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
            setTimeout(() => { if (toast.parentElement) toast.remove(); }, 5000);
        }

        // ===== DELETE MODAL - SAMA SEPERTI HALAMAN FAKTUR =====
        function openDeleteModal(id, name) {
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').action = '{{ url("laba-rugi") }}/' + id;
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

        // ===== LIVE SEARCH =====
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('lrSearchInput');
            const resetBtn = document.getElementById('lrResetBtn');
            const rows = document.querySelectorAll('.lr-row-data');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchResultCount = document.getElementById('searchResultCount');
            const colPendapatan = document.getElementById('lrColPendapatan');
            const colBeban = document.getElementById('lrColBeban');
            let debounceTimeout = null;

            function filterData() {
                const searchText = searchInput ? searchInput.value.trim().toLowerCase() : '';

                let visibleCount = 0;

                rows.forEach(row => {
                    const name = row.dataset.name || '';
                    const category = row.dataset.category || '';

                    const match = searchText === '' || name.includes(searchText) || category.includes(searchText);

                    if (match) {
                        row.classList.remove('hidden-row');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden-row');
                    }
                });

                if (searchText !== '') {
                    searchIndicator.classList.add('active');
                    searchResultCount.textContent = visibleCount;
                } else {
                    searchIndicator.classList.remove('active');
                }

                [colPendapatan, colBeban].forEach(col => {
                    if (col) {
                        const visibleRows = col.querySelectorAll('.lr-row-data:not(.hidden-row)');
                        const emptyMsg = col.querySelector('.lr-empty');
                        if (emptyMsg) {
                            if (visibleRows.length === 0) {
                                emptyMsg.style.display = 'block';
                            } else {
                                emptyMsg.style.display = 'none';
                            }
                        }
                    }
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(function() {
                        filterData();
                        const url = new URL(window.location.href);
                        if (searchInput.value.trim() !== '') {
                            url.searchParams.set('q', searchInput.value.trim());
                        } else {
                            url.searchParams.delete('q');
                        }
                        window.history.replaceState({}, '', url.toString());
                    }, 300);
                });

                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
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

            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    searchInput.value = '';
                    const url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    window.history.replaceState({}, '', url.toString());
                    searchIndicator.classList.remove('active');
                    filterData();
                });
            }

            setTimeout(function() {
                filterData();
            }, 100);

            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.lr-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
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
        });
    </script>
</x-app-layout>