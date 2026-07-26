<x-app-layout>
    <x-slot name="title">Harga Pokok Penjualan</x-slot>

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

        $totalCogs = $stats['total_cogs_month'] ?? 0;
        $totalQty = $stats['total_qty_month'] ?? 0;
        $avgCost = $stats['avg_unit_cost'] ?? 0;
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
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/>
                <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cogs-wrap {
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

        .cogs-wrap * { box-sizing: border-box; }
        .cogs-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        .cogs-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cogs-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .cogs-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cogs-header-left { flex: 1; min-width: 200px; }

        .cogs-badge {
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

        .cogs-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cogs-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cogs-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cogs-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .cogs-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cogs-btn {
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

        .cogs-btn .icon { width: 16px; height: 16px; }
        .cogs-btn:hover { transform: translateY(-2px); }
        .cogs-btn:active { transform: translateY(0) scale(0.97); }

        .cogs-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cogs-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cogs-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cogs-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cogs-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== STATS ===== */
        .cogs-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .cogs-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cogs-stat::before {
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

        .cogs-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .cogs-stat:hover::before {
            opacity: 1;
        }

        .cogs-stat .number {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            position: relative;
            display: inline-block;
            cursor: default;
        }

        .cogs-stat .number.purple { color: var(--theme-primary); }
        .cogs-stat .number.blue { color: var(--info); }
        .cogs-stat .number.yellow { color: var(--warning); }

        .cogs-stat .number .full-number {
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

        .cogs-stat .number .full-number::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: var(--border-color);
        }

        .cogs-stat .number:hover .full-number {
            display: block;
        }

        .cogs-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }

        .cogs-stat .sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        /* ===== SEARCH BAR ===== */
        .cogs-search {
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

        .cogs-search:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .cogs-search form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .cogs-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .cogs-search-wrap .icon {
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

        .cogs-search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .cogs-search input[type="text"] {
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

        .cogs-search input[type="text"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .cogs-search input[type="text"]::placeholder {
            color: var(--text-tertiary);
        }

        .cogs-search input[type="month"] {
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
            min-width: 170px;
        }

        .cogs-search input[type="month"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .cogs-search-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .cogs-search-actions .cogs-btn {
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

        /* ===== TIMELINE ===== */
        .cogs-timeline { position: relative; padding-left: 6px; }

        .cogs-day {
            margin-bottom: 24px;
        }

        .cogs-day:last-child { margin-bottom: 0; }

        .cogs-day-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .cogs-day-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--theme-primary);
            flex-shrink: 0;
            box-shadow: 0 0 0 4px var(--theme-soft);
        }

        .cogs-day-label .date {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cogs-day-label .count {
            font-size: 12px;
            color: var(--text-tertiary);
        }

        .cogs-entries {
            margin-left: 6px;
            padding-left: 24px;
            border-left: 2px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cogs-entry {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            transition: all 0.2s ease;
        }

        .cogs-entry:hover {
            border-color: var(--border-hover);
            transform: translateX(4px);
            background: var(--bg-card-hover);
        }

        .cogs-entry::before {
            content: '';
            position: absolute;
            left: -28px;
            top: 50%;
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--text-tertiary);
            border: 2px solid var(--bg-card);
        }

        .cogs-entry.hidden-entry {
            display: none;
        }

        .cogs-entry.visible-entry {
            display: flex;
            animation: fadeSlideUp 0.3s ease forwards;
        }

        .cogs-entry-info {
            flex: 1;
            min-width: 0;
        }

        .cogs-entry-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cogs-entry-meta {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .cogs-entry-total {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            font-weight: 700;
            color: var(--theme-primary);
            white-space: nowrap;
        }

        .cogs-entry-actions {
            display: flex;
            gap: 4px;
            flex-shrink: 0;
        }

        .cogs-action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid transparent;
            color: var(--text-tertiary);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .cogs-action-btn .icon {
            width: 14px;
            height: 14px;
        }

        .cogs-action-btn:hover {
            background: var(--bg-card-active);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .cogs-action-btn.show:hover {
            color: var(--theme-primary);
            background: var(--theme-soft);
            border-color: var(--theme-soft);
        }

        .cogs-action-btn.edit:hover {
            color: #4FA6E8;
            background: rgba(79, 166, 232, 0.12);
            border-color: rgba(79, 166, 232, 0.2);
        }

        .cogs-action-btn.delete:hover {
            color: var(--danger);
            background: var(--danger-soft);
            border-color: var(--danger-soft);
        }

        /* ===== EMPTY ===== */
        .cogs-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .cogs-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .cogs-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .cogs-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        .cogs-empty.hidden {
            display: none;
        }

        /* ===== PAGINATION ===== */
        .cogs-pagination {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .cogs-pagination .info {
            font-size: 13px;
            color: var(--text-tertiary);
        }

        .cogs-pagination .links {
            display: flex;
            gap: 6px;
        }

        .cogs-pagination .links a,
        .cogs-pagination .links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            min-width: 36px;
        }

        .cogs-pagination .links a:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cogs-pagination .links .active {
            background: var(--theme-primary);
            border-color: var(--theme-primary);
            color: #fff;
        }

        /* ============================================================
           MODAL DELETE
           ============================================================ */
        .cogs-modal-overlay {
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

        .cogs-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .cogs-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .cogs-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .cogs-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .cogs-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .cogs-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .cogs-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .cogs-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .cogs-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .cogs-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .cogs-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .cogs-modal-box .cogs-desc-text {
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

        .cogs-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .cogs-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .cogs-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .cogs-modal-actions .btn {
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

        .cogs-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .cogs-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cogs-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .cogs-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .cogs-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .cogs-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .cogs-modal-actions .btn-danger:hover {
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .cogs-stats { grid-template-columns: 1fr 1fr; }
            .cogs-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .cogs-wrap { padding: 0 12px; }
            .cogs-header { flex-direction: column; }
            .cogs-actions { width: 100%; }
            .cogs-actions .cogs-btn { flex: 1; justify-content: center; }
            .cogs-stats { grid-template-columns: 1fr; gap: 12px; }
            .cogs-stat .number { font-size: 20px; }
            .cogs-search { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 10px; 
                padding: 12px 16px;
            }
            .cogs-search form { flex-direction: column; }
            .cogs-search-wrap { min-width: 100%; }
            .cogs-search input[type="month"] { width: 100%; }
            .cogs-search-actions { 
                width: 100%; 
                justify-content: flex-end; 
                flex-wrap: wrap;
            }
            .cogs-entry { flex-wrap: wrap; gap: 8px; }
            .cogs-entry-total { margin-left: auto; }
            .cogs-pagination { flex-direction: column; align-items: center; text-align: center; }
            .cogs-pagination .links { justify-content: center; flex-wrap: wrap; }
            
            .cogs-stat .number .full-number {
                font-size: 11px;
                padding: 4px 10px;
            }

            .cogs-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }

            .cogs-modal-actions {
                flex-direction: column;
            }

            .cogs-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .cogs-entry { flex-wrap: wrap; }
            .cogs-entry-actions { margin-left: auto; }
        }

        @media (max-width: 380px) {
            .cogs-header h1 { font-size: 22px; }
            .cogs-btn { font-size: 12px; padding: 8px 14px; }
            .cogs-btn .icon { width: 14px; height: 14px; }
            .cogs-entry { padding: 10px 14px; }
            .cogs-entry-name { font-size: 13px; }
            .cogs-entry-total { font-size: 13px; }

            .cogs-modal-box {
                padding: 20px 16px;
            }

            .cogs-modal-box h3 {
                font-size: 18px;
            }

            .cogs-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }

            .cogs-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }
    </style>

    <div class="cogs-wrap">

        <!-- ===== HEADER ===== -->
        <div class="cogs-header animate-in" style="animation-delay: 0.05s;">
            <div class="cogs-header-left">
                <div class="cogs-badge">
                    <span class="dot"></span>
                    Akuntansi
                </div>
                <h1>Harga Pokok Penjualan</h1>
                <p class="subtitle">
                    Riwayat HPP dari setiap transaksi penjualan — 
                    <strong id="cogsTotalCount">{{ isset($entries) ? $entries->count() : 0 }}</strong> transaksi
                </p>
            </div>
            <div class="cogs-actions">
                <a href="{{ route('cogs.create') }}" class="cogs-btn cogs-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Catat HPP
                </a>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="cogs-stats animate-in" style="animation-delay: 0.10s;" id="cogsStats">
            <div class="cogs-stat">
                <div class="number purple mono" id="statTotalCogs">
                    {{ formatCurrency($totalCogs, $currencySymbol) }}
                    <span class="full-number">{{ $currencySymbol }}{{ number_format($totalCogs, 0, ',', '.') }}</span>
                </div>
                <div class="label">Total HPP Bulan Ini</div>
                <div class="sub">Total biaya pokok penjualan</div>
            </div>
            <div class="cogs-stat">
                <div class="number blue" id="statTotalQty">
                    {{ formatNumber($totalQty) }} unit
                    <span class="full-number">{{ number_format($totalQty, 0, ',', '.') }} unit</span>
                </div>
                <div class="label">Unit Terjual Bulan Ini</div>
                <div class="sub">Total unit terjual</div>
            </div>
            <div class="cogs-stat">
                <div class="number yellow mono" id="statAvgCost">
                    {{ $avgCost > 0 ? formatCurrency($avgCost, $currencySymbol) : $currencySymbol . '0' }}
                    <span class="full-number">{{ $avgCost > 0 ? $currencySymbol . number_format($avgCost, 0, ',', '.') : $currencySymbol . '0' }}</span>
                </div>
                <div class="label">Rata-rata Biaya / Unit</div>
                <div class="sub">Rata-rata per unit</div>
            </div>
        </div>

        <!-- ===== SEARCH BAR ===== -->
        <div class="cogs-search animate-in" style="animation-delay: 0.12s;">
            <form method="GET" action="{{ route('cogs.index') }}" id="cogsSearchForm" onsubmit="return false;">
                <div class="cogs-search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="cogsSearchInput" value="{{ request('q') }}" 
                           placeholder="Cari nama barang..." autocomplete="off">
                </div>
                <input type="month" name="month" id="cogsMonthInput" value="{{ request('month') }}" placeholder="Pilih bulan">
                <div class="cogs-search-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <button type="button" class="cogs-btn cogs-btn-ghost" id="cogsResetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== TIMELINE ===== -->
        @if(isset($entries) && $entries->count() > 0)
            <div class="cogs-timeline animate-in" style="animation-delay: 0.15s;" id="cogsTimeline">
                @foreach($groupedEntries ?? [] as $date => $dayEntries)
                    <div class="cogs-day cogs-day-data" data-date="{{ $date }}">
                        <div class="cogs-day-label">
                            <span class="cogs-day-dot"></span>
                            <span class="date">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
                            <span class="count">{{ $dayEntries->count() }} transaksi</span>
                        </div>
                        <div class="cogs-entries">
                            @foreach($dayEntries as $entry)
                                <div class="cogs-entry cogs-entry-data visible-entry"
                                     data-item="{{ strtolower($entry->item_name) }}"
                                     data-date="{{ $date }}">
                                    <div class="cogs-entry-info">
                                        <div class="cogs-entry-name">{{ $entry->item_name }}</div>
                                        <div class="cogs-entry-meta">{{ $entry->quantity_sold }} unit × {{ $currencySymbol }}{{ number_format($entry->unit_cost, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="cogs-entry-total">{{ $currencySymbol }}{{ number_format($entry->total_cogs, 0, ',', '.') }}</div>
                                    <div class="cogs-entry-actions">
                                        <a href="{{ route('cogs.show', ['entry' => $entry->id]) }}" class="cogs-action-btn show" title="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('cogs.edit', ['entry' => $entry->id]) }}" class="cogs-action-btn edit" title="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="cogs-action-btn delete" title="Hapus"
                                                onclick="openDeleteModal('{{ $entry->id }}', '{{ addslashes($entry->item_name) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ===== PAGINATION ===== -->
            @if(method_exists($entries, 'total') && $entries->total() > 0)
                <div class="cogs-pagination animate-in" style="animation-delay: 0.20s;">
                    <div class="info">
                        Menampilkan {{ $entries->firstItem() }}–{{ $entries->lastItem() }} dari {{ number_format($entries->total()) }} transaksi
                    </div>
                    <div class="links">
                        {{ $entries->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="cogs-empty animate-in" style="animation-delay: 0.15s;" id="emptyState">
                <svg class="empty-icon"><use href="#ic-package"/></svg>
                <h3>Belum ada catatan HPP</h3>
                <p>Catat transaksi penjualan pertama untuk mulai melacak harga pokok penjualan.</p>
                <a href="{{ route('cogs.create') }}" class="cogs-btn cogs-btn-primary" style="display: inline-flex;">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Catat HPP Pertama
                </a>
            </div>
        @endif

    </div>

    <!-- ============================================================
         MODAL DELETE
         ============================================================ -->
    <div class="cogs-modal-overlay" id="deleteModal">
        <div class="cogs-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Catatan HPP?</h3>

            <p>
                Anda yakin ingin menghapus catatan HPP
                <br>
                <span class="cogs-desc-text" id="deleteDesc">-</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="cogs-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="{{ route('cogs.destroy', ['entry' => 0]) }}" method="POST" style="display:inline;">
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
        // ===== DELETE MODAL =====
        function openDeleteModal(id, description) {
            document.getElementById('deleteDesc').textContent = description;
            var url = '{{ route("cogs.destroy", ["entry" => 0]) }}';
            url = url.replace(/\/0$/, '/' + id);
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
            if (e.target === this) closeDeleteModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });

        // ===== LIVE SEARCH =====
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('cogsSearchInput');
            const monthInput = document.getElementById('cogsMonthInput');
            const resetBtn = document.getElementById('cogsResetBtn');
            const entries = document.querySelectorAll('.cogs-entry-data');
            const days = document.querySelectorAll('.cogs-day-data');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchResultCount = document.getElementById('searchResultCount');
            const totalCountEl = document.getElementById('cogsTotalCount');
            const emptyState = document.getElementById('emptyState');
            let debounceTimeout = null;

            const originalEntries = [];
            entries.forEach(entry => {
                originalEntries.push({
                    element: entry,
                    item: entry.dataset.item,
                    date: entry.dataset.date
                });
            });

            function resetToInitial() {
                searchInput.value = '';
                if (monthInput) monthInput.value = '';

                entries.forEach(entry => {
                    entry.classList.remove('hidden-entry');
                    entry.classList.add('visible-entry');
                });

                days.forEach(day => {
                    day.style.display = 'block';
                    const dayEntries = day.querySelectorAll('.cogs-entry-data');
                    const countEl = day.querySelector('.count');
                    if (countEl) {
                        countEl.textContent = dayEntries.length + ' transaksi';
                    }
                });

                totalCountEl.textContent = entries.length;
                searchIndicator.classList.remove('active');

                if (emptyState) {
                    emptyState.style.display = 'none';
                    emptyState.classList.add('hidden');
                }
            }

            function filterData() {
                const searchText = searchInput ? searchInput.value.trim().toLowerCase() : '';
                const monthValue = monthInput ? monthInput.value : '';

                let visibleCount = 0;

                entries.forEach(entry => {
                    const item = entry.dataset.item || '';
                    const date = entry.dataset.date || '';

                    const matchSearch = searchText === '' || item.includes(searchText);
                    const matchMonth = monthValue === '' || date.startsWith(monthValue);

                    if (matchSearch && matchMonth) {
                        entry.classList.remove('hidden-entry');
                        entry.classList.add('visible-entry');
                        visibleCount++;
                    } else {
                        entry.classList.remove('visible-entry');
                        entry.classList.add('hidden-entry');
                    }
                });

                days.forEach(day => {
                    const dayEntries = day.querySelectorAll('.cogs-entry-data:not(.hidden-entry)');
                    const countEl = day.querySelector('.count');
                    if (countEl) {
                        countEl.textContent = dayEntries.length + ' transaksi';
                    }
                    if (dayEntries.length === 0) {
                        day.style.display = 'none';
                    } else {
                        day.style.display = 'block';
                    }
                });

                if (searchText !== '' || monthValue !== '') {
                    searchIndicator.classList.add('active');
                    searchResultCount.textContent = visibleCount;
                } else {
                    searchIndicator.classList.remove('active');
                }

                totalCountEl.textContent = visibleCount;

                if (emptyState) {
                    if (visibleCount === 0 && entries.length > 0) {
                        emptyState.style.display = 'block';
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Tidak Ada Hasil Pencarian';
                        emptyState.querySelector('p').textContent = 'Tidak ditemukan catatan HPP yang sesuai dengan filter yang dipilih.';
                        const btn = emptyState.querySelector('.cogs-btn');
                        if (btn) btn.style.display = 'none';
                    } else if (visibleCount === 0 && entries.length === 0) {
                        emptyState.style.display = 'block';
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Belum ada catatan HPP';
                        emptyState.querySelector('p').textContent = 'Catat transaksi penjualan pertama untuk mulai melacak harga pokok penjualan.';
                        const btn = emptyState.querySelector('.cogs-btn');
                        if (btn) btn.style.display = 'inline-flex';
                    } else {
                        emptyState.style.display = 'none';
                        emptyState.classList.add('hidden');
                    }
                }
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

            if (monthInput) {
                monthInput.addEventListener('change', function() {
                    filterData();
                    
                    const url = new URL(window.location.href);
                    if (monthInput.value !== '') {
                        url.searchParams.set('month', monthInput.value);
                    } else {
                        url.searchParams.delete('month');
                    }
                    window.history.replaceState({}, '', url.toString());
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    resetToInitial();
                    
                    const url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    url.searchParams.delete('month');
                    window.history.replaceState({}, '', url.toString());
                    
                    searchIndicator.classList.remove('active');
                });
            }

            setTimeout(function() {
                resetToInitial();
            }, 100);

            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.cogs-btn').forEach(btn => {
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