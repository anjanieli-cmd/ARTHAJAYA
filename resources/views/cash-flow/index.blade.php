<x-app-layout>
    <x-slot name="title">Arus Kas</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        function formatCurrency($amount, $currency = 'Rp') {
            if ($amount === null || $amount === '') return $currency . '0';
            $amount = (float) $amount;
            if ($amount >= 1000000000) {
                return $currency . number_format($amount / 1000000000, 1, ',', '.') . ' M';
            } elseif ($amount >= 1000000) {
                return $currency . number_format($amount / 1000000, 1, ',', '.') . ' Jt';
            } elseif ($amount >= 1000) {
                return $currency . number_format($amount / 1000, 1, ',', '.') . ' Rb';
            } else {
                return $currency . number_format($amount, 0, ',', '.');
            }
        }

        function formatNumber($number) {
            if ($number === null || $number === '') return '0';
            $number = (float) $number;
            if ($number >= 1000000000) {
                return number_format($number / 1000000000, 1, ',', '.') . ' M';
            } elseif ($number >= 1000000) {
                return number_format($number / 1000000, 1, ',', '.') . ' Jt';
            } elseif ($number >= 1000) {
                return number_format($number / 1000, 1, ',', '.') . ' Rb';
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
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/>
            </symbol>
            <symbol id="ic-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/>
            </symbol>
            <symbol id="ic-trending-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 7 9 13 13 9 21 17"/><polyline points="14 17 21 17 21 10"/>
            </symbol>
            <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21h18"/><path d="M5 21V10l7-6 7 6v11"/><path d="M9 21v-7h6v7"/>
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
            <symbol id="ic-chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
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
        .cf-wrap {
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
            --danger-rgb: 232, 90, 90;
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .cf-wrap * { box-sizing: border-box; }
        .cf-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        .cf-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cf-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

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
        .cf-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cf-header-left { flex: 1; min-width: 200px; }

        .cf-badge {
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

        .cf-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cf-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cf-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cf-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .cf-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cf-btn {
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

        .cf-btn .icon { width: 16px; height: 16px; }
        .cf-btn:hover { transform: translateY(-2px); }
        .cf-btn:active { transform: translateY(0) scale(0.97); }

        .cf-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cf-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cf-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cf-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cf-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== STATS ===== */
        .cf-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .cf-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cf-stat::before {
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

        .cf-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .cf-stat:hover::before {
            opacity: 1;
        }

        .cf-stat .number {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            position: relative;
            display: inline-block;
            cursor: default;
        }

        .cf-stat .number.green { color: var(--success); }
        .cf-stat .number.red { color: var(--danger); }
        .cf-stat .number.purple { color: var(--theme-primary); }

        .cf-stat .number .full-number {
            display: none;
            position: absolute;
            bottom: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            background: var(--bg-card-hover);
            color: var(--text-primary);
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }

        .cf-stat .number .full-number::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: var(--border-color);
        }

        .cf-stat .number:hover .full-number {
            display: block;
        }

        .cf-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }

        .cf-stat .sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        /* ===== PERIOD FILTER ===== */
        .cf-filter {
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

        .cf-filter .filter-label {
            font-size: 12px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cf-filter .filter-label .icon {
            width: 14px;
            height: 14px;
        }

        .cf-filter select {
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

        .cf-filter select:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .cf-filter select:hover {
            border-color: var(--border-hover);
        }

        .cf-filter select option {
            background: var(--bg-card);
            color: var(--text-primary);
            padding: 10px 14px;
        }

        .cf-filter-actions {
            display: flex;
            gap: 8px;
            margin-left: auto;
        }

        .cf-filter-actions .cf-btn {
            padding: 8px 14px;
            font-size: 12px;
        }

        /* ===== TIMELINE ===== */
        .cf-timeline {
            position: relative;
            padding-left: 28px;
        }

        .cf-timeline::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: var(--border-color);
        }

        .cf-activity {
            position: relative;
            margin-bottom: 30px;
        }

        .cf-activity:last-child {
            margin-bottom: 0;
        }

        .cf-activity-dot {
            position: absolute;
            left: -28px;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cf-activity-dot .icon {
            width: 10px;
            height: 10px;
        }

        .cf-activity.operasional .cf-activity-dot {
            border-color: var(--success);
            color: var(--success);
        }

        .cf-activity.investasi .cf-activity-dot {
            border-color: var(--info);
            color: var(--info);
        }

        .cf-activity.pendanaan .cf-activity-dot {
            border-color: var(--warning);
            color: var(--warning);
        }

        .cf-activity-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cf-activity-head h3 {
            font-size: 15.5px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .cf-activity-net {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13.5px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
        }

        .cf-activity.operasional .cf-activity-net {
            background: var(--success-soft);
            color: var(--success);
        }

        .cf-activity.investasi .cf-activity-net {
            background: var(--info-soft);
            color: var(--info);
        }

        .cf-activity.pendanaan .cf-activity-net {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .cf-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .cf-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .cf-row:last-child {
            border-bottom: none;
        }

        .cf-row-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cf-row.masuk .cf-row-icon {
            background: var(--success-soft);
            color: var(--success);
        }

        .cf-row.keluar .cf-row-icon {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .cf-row-icon .icon {
            width: 14px;
            height: 14px;
        }

        .cf-row-body {
            flex: 1;
            min-width: 120px;
        }

        .cf-row-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cf-row-cat {
            font-size: 11.5px;
            color: var(--text-tertiary);
        }

        .cf-row-amount {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .cf-row.masuk .cf-row-amount {
            color: var(--success);
        }

        .cf-row.keluar .cf-row-amount {
            color: var(--danger);
        }

        .cf-row-actions {
            display: flex;
            gap: 4px;
            flex-shrink: 0;
        }

        .cf-row-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            transition: all 0.15s ease;
            cursor: pointer;
            width: 32px;
            height: 32px;
        }

        .cf-row-action .icon {
            width: 14px;
            height: 14px;
        }

        .cf-row-action:hover {
            background: var(--bg-card);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cf-row-action.view:hover {
            color: var(--info);
            border-color: rgba(78, 143, 240, 0.3);
            background: var(--info-soft);
        }

        .cf-row-action.edit:hover {
            color: var(--theme-primary);
            border-color: var(--theme-glow);
            background: var(--theme-soft);
        }

        .cf-row-action.delete {
            color: var(--danger);
            border-color: rgba(232, 90, 90, 0.2);
        }

        .cf-row-action.delete:hover {
            background: var(--danger-soft);
            border-color: rgba(232, 90, 90, 0.4);
        }

        .cf-empty {
            padding: 18px 16px;
            font-size: 12.5px;
            color: var(--text-tertiary);
            text-align: center;
        }

        /* ===== FINAL ===== */
        .cf-final {
            margin-top: 16px;
            padding: 20px 24px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .cf-final.positive {
            background: var(--success-soft);
            border: 1px solid rgba(52, 181, 131, 0.3);
        }

        .cf-final.negative {
            background: var(--danger-soft);
            border: 1px solid rgba(232, 90, 90, 0.3);
        }

        .cf-final-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cf-final-label .icon {
            width: 20px;
            height: 20px;
        }

        .cf-final.positive .cf-final-label .icon {
            color: var(--success);
        }

        .cf-final.negative .cf-final-label .icon {
            color: var(--danger);
        }

        .cf-final-value {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 22px;
            font-weight: 700;
        }

        .cf-final.positive .cf-final-value {
            color: var(--success);
        }

        .cf-final.negative .cf-final-value {
            color: var(--danger);
        }

        /* ===== EMPTY ===== */
        .cf-empty-state {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .cf-empty-state .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .cf-empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .cf-empty-state p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .cf-empty-state.hidden {
            display: none;
        }

        /* ============================================================
           DELETE MODAL - SAMA SEPERTI HALAMAN LAINNYA
           ============================================================ */
        .cf-modal-overlay {
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

        .cf-modal-overlay.active {
            display: flex;
        }

        .cf-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="dark"] .cf-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .cf-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .cf-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .cf-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .cf-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .cf-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .cf-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
        }

        .cf-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
        }

        .cf-modal-box .item-name-modal {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-size: 15px;
        }

        .cf-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .cf-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .cf-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .cf-modal-actions .btn {
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

        .cf-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .cf-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cf-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .cf-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .cf-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .cf-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .cf-modal-actions .btn-danger:hover {
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
            .cf-stats { grid-template-columns: 1fr 1fr; }
            .cf-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .cf-wrap { padding: 0 12px; }
            .cf-header { flex-direction: column; }
            .cf-actions { width: 100%; }
            .cf-actions .cf-btn { flex: 1; justify-content: center; }
            .cf-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .cf-stat .number { font-size: 20px; }
            .cf-filter { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 10px; 
                padding: 12px 16px;
            }
            .cf-filter select { width: 100%; }
            .cf-filter-actions { 
                width: 100%; 
                justify-content: flex-end; 
                flex-wrap: wrap;
                margin-left: 0;
            }
            .cf-filter-actions .cf-btn { flex: 1; }
            .cf-final { flex-direction: column; text-align: center; }
            
            .cf-stat .number .full-number {
                font-size: 11px;
                padding: 4px 10px;
            }
            .cf-activity-head h3 { font-size: 14px; }
            .cf-modal-box { padding: 24px 20px; margin: 10px; }
            .cf-modal-actions { flex-direction: column; }
            .cf-modal-actions .btn { width: 100%; }
        }

        @media (max-width: 640px) {
            .cf-wrap { padding: 0 8px; }
            .cf-stats { grid-template-columns: 1fr; }
            .cf-header h1 { font-size: 22px; }
            .cf-btn { font-size: 12px; padding: 8px 14px; }
            .cf-btn .icon { width: 14px; height: 14px; }
            .cf-modal-box { padding: 20px 16px; }
            .cf-modal-box h3 { font-size: 18px; }
            .cf-modal-box .icon-danger { width: 48px; height: 48px; }
            .cf-modal-box .icon-danger svg { width: 24px; height: 24px; }
            .cf-row { flex-wrap: wrap; }
            .cf-row-actions { margin-left: auto; }
        }

        @media (max-width: 480px) {
            .cf-wrap { padding: 0 4px; }
            .cf-btn { font-size: 11px; padding: 6px 10px; }
            .cf-btn .icon { width: 13px; height: 13px; }
            .cf-stat .number { font-size: 18px; }
            .cf-row { font-size: 12px; padding: 10px 12px; }
            .cf-row-name { font-size: 12px; }
            .cf-row-amount { font-size: 12px; }
            .cf-row-action { width: 28px; height: 28px; }
            .cf-row-action .icon { width: 12px; height: 12px; }
        }
    </style>

    <div class="cf-wrap">

        {{-- ===== TOAST ===== --}}
        <div class="toast-container" id="toastContainer"></div>

        {{-- ===== HEADER ===== --}}
        <div class="cf-header animate-in" style="animation-delay: 0.05s;">
            <div class="cf-header-left">
                <div class="cf-badge">
                    <span class="dot"></span>
                    Laporan Keuangan
                </div>
                <h1>Arus Kas</h1>
                <p class="subtitle">
                    Pergerakan kas <strong>{{ $company->name ?? 'perusahaanmu' }}</strong> berdasarkan aktivitas operasional, investasi, dan pendanaan.
                </p>
            </div>
            <div class="cf-actions">
                <a href="{{ route('cash-flow.create') }}" class="cf-btn cf-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Transaksi
                </a>
            </div>
        </div>

        {{-- ===== STATS ===== --}}
        <div class="cf-stats animate-in" style="animation-delay: 0.10s;" id="cfStats">
            <div class="cf-stat">
                <div class="number green mono" id="statMasuk">
                    {{ formatCurrency($totalMasuk ?? 0, $currencySymbol) }}
                    <span class="full-number">{{ $currencySymbol }}{{ number_format($totalMasuk ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="label">Total Kas Masuk</div>
                <div class="sub">Penerimaan kas</div>
            </div>
            <div class="cf-stat">
                <div class="number red mono" id="statKeluar">
                    {{ formatCurrency($totalKeluar ?? 0, $currencySymbol) }}
                    <span class="full-number">{{ $currencySymbol }}{{ number_format($totalKeluar ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="label">Total Kas Keluar</div>
                <div class="sub">Pengeluaran kas</div>
            </div>
            <div class="cf-stat">
                <div class="number purple mono" id="statNet">
                    {{ formatCurrency($netCashFlow ?? 0, $currencySymbol) }}
                    <span class="full-number">{{ $currencySymbol }}{{ number_format($netCashFlow ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="label">Arus Kas Bersih</div>
                <div class="sub">Selisih masuk - keluar</div>
            </div>
        </div>

        {{-- ===== PERIOD FILTER ===== --}}
        <div class="cf-filter animate-in" style="animation-delay: 0.12s;">
            <span class="filter-label">
                <svg class="icon"><use href="#ic-calendar"/></svg>
                Periode
            </span>
            <form method="GET" action="{{ route('cash-flow.index') }}" id="cfPeriodForm">
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
            <div class="cf-filter-actions">
                <a href="{{ route('cash-flow.index') }}" class="cf-btn cf-btn-ghost">
                    <svg class="icon"><use href="#ic-x"/></svg>
                    Reset
                </a>
            </div>
        </div>

        {{-- ===== TIMELINE ===== --}}
        @if(isset($groups) && !empty($groups))
            <div class="cf-timeline animate-in" style="animation-delay: 0.15s;" id="cfTimeline">
                @foreach($groups as $key => $group)
                    <div class="cf-activity {{ $key }}">
                        <div class="cf-activity-dot">
                            <svg class="icon"><use href="#{{ $key === 'operasional' ? 'ic-activity' : ($key === 'investasi' ? 'ic-trending' : 'ic-bank') }}"/></svg>
                        </div>
                        <div class="cf-activity-head">
                            <h3>{{ $group['label'] }}</h3>
                            <span class="cf-activity-net">Net: {{ $currencySymbol }}{{ number_format($group['net'], 0, ',', '.') }}</span>
                        </div>
                        <div class="cf-card">
                            @forelse($group['items'] as $item)
                                <div class="cf-row {{ $item->direction }}">
                                    <div class="cf-row-icon">
                                        <svg class="icon"><use href="#{{ $item->direction === 'masuk' ? 'ic-trending' : 'ic-trending-down' }}"/></svg>
                                    </div>
                                    <div class="cf-row-body">
                                        <div class="cf-row-name">{{ $item->name }}</div>
                                        <div class="cf-row-cat">{{ $item->category }}</div>
                                    </div>
                                    <div class="cf-row-amount">{{ $item->direction === 'masuk' ? '+' : '-' }}{{ $currencySymbol }}{{ number_format($item->amount, 0, ',', '.') }}</div>
                                    <div class="cf-row-actions">
                                        <a href="{{ route('cash-flow.show', $item) }}" class="cf-row-action view" title="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('cash-flow.edit', $item) }}" class="cf-row-action edit" title="Edit Transaksi">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="cf-row-action delete" title="Hapus Transaksi" onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->name) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="cf-empty">Belum ada transaksi {{ strtolower($group['label']) }} untuk periode ini.</div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ===== FINAL ===== --}}
            <div class="cf-final {{ ($netCashFlow ?? 0) >= 0 ? 'positive' : 'negative' }} animate-in" style="animation-delay: 0.18s;">
                <span class="cf-final-label">
                    @if(($netCashFlow ?? 0) >= 0)
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                        Kenaikan Kas Bersih
                    @else
                        <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                        Penurunan Kas Bersih
                    @endif
                </span>
                <span class="cf-final-value">{{ $currencySymbol }}{{ number_format(abs($netCashFlow ?? 0), 0, ',', '.') }}</span>
            </div>
        @else
            <div class="cf-empty-state animate-in" style="animation-delay: 0.15s;">
                <svg class="empty-icon"><use href="#ic-inbox"/></svg>
                <h3>Belum ada transaksi</h3>
                <p>Tambahkan transaksi pertama untuk mulai melihat laporan arus kas.</p>
                <a href="{{ route('cash-flow.create') }}" class="cf-btn cf-btn-primary" style="display:inline-flex;">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Transaksi Pertama
                </a>
            </div>
        @endif

    </div>

    {{-- ===== DELETE MODAL - SAMA SEPERTI HALAMAN LAINNYA ===== --}}
    <div class="cf-modal-overlay" id="deleteModal">
        <div class="cf-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Transaksi?</h3>

            <p>
                Anda yakin ingin menghapus transaksi
                <br>
                <span class="item-name-modal" id="deleteItemName">—</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="cf-modal-actions">
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

        // ===== DELETE MODAL - SAMA SEPERTI HALAMAN LAINNYA =====
        function openDeleteModal(id, name) {
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').action = '{{ url("cash-flow") }}/' + id;
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

        // ===== RIPPLE EFFECT =====
        document.querySelectorAll('.cf-btn').forEach(btn => {
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
    </script>
</x-app-layout>