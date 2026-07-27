<x-app-layout>
    <x-slot name="title">Stok Barang</x-slot>

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

        $totalSku = $stats['total_sku'] ?? 0;
        $totalValue = $stats['total_value'] ?? 0;
        $lowStock = $stats['low_stock'] ?? 0;
        $outOfStock = $stats['out_of_stock'] ?? 0;
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
            <symbol id="ic-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/>
                <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-trending-up" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </symbol>
            <symbol id="ic-trending-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/>
                <polyline points="17 18 23 18 23 12"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .inv-wrap {
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

        .inv-wrap * { box-sizing: border-box; }
        .inv-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        .inv-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .inv-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .inv-header-left { flex: 1; min-width: 200px; }

        .inv-badge {
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

        .inv-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .inv-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .inv-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .inv-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .inv-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .inv-btn {
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

        .inv-btn .icon { width: 16px; height: 16px; }
        .inv-btn:hover { transform: translateY(-2px); }
        .inv-btn:active { transform: translateY(0) scale(0.97); }

        .inv-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .inv-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .inv-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .inv-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .inv-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== STATS ===== */
        .inv-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .inv-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .inv-stat::before {
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

        .inv-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .inv-stat:hover::before {
            opacity: 1;
        }

        .inv-stat .number {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            position: relative;
            display: inline-block;
            cursor: default;
        }

        .inv-stat .number.purple { color: var(--theme-primary); }
        .inv-stat .number.blue { color: var(--info); }
        .inv-stat .number.yellow { color: var(--warning); }
        .inv-stat .number.red { color: var(--danger); }

        .inv-stat .number .full-number {
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

        .inv-stat .number .full-number::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: var(--border-color);
        }

        .inv-stat .number:hover .full-number {
            display: block;
        }

        .inv-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }

        .inv-stat .sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        /* ===== SEARCH BAR ===== */
        .inv-search {
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

        .inv-search:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .inv-search form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .inv-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .inv-search-wrap .icon {
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

        .inv-search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .inv-search input[type="text"] {
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

        .inv-search input[type="text"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .inv-search input[type="text"]::placeholder {
            color: var(--text-tertiary);
        }

        .inv-search select {
            padding: 10px 38px 10px 16px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            min-width: 170px;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
            font-family: inherit;
        }

        .inv-search select:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .inv-search select:hover {
            border-color: var(--border-hover);
        }

        .inv-search select option {
            background-color: #1a1f2e;
            color: #e8edf5;
            padding: 10px 14px;
            font-size: 14px;
        }

        .inv-search select option:checked {
            background-color: #0d2a1f;
            color: #34d399;
        }

        .inv-search-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .inv-search-actions .inv-btn {
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

        /* ===== GRID ===== */
        .inv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 18px;
            margin-bottom: 20px;
        }

        .inv-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .inv-card::before {
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

        .inv-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .inv-card:hover::before {
            opacity: 1;
        }

        .inv-card.hidden-card {
            display: none;
        }

        .inv-card .card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .inv-card .card-badge {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 4px 12px;
            border-radius: 100px;
            background: var(--bg-card-active);
            color: var(--text-tertiary);
            border: 1px solid var(--border-color);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .inv-card .card-badge.low {
            background: var(--danger-soft);
            color: var(--danger);
            border-color: rgba(232, 90, 90, 0.2);
            animation: pulseGlow 1.6s ease-in-out infinite;
        }

        .inv-card .card-badge .icon {
            width: 12px;
            height: 12px;
        }

        .inv-card .card-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .inv-card .card-sku {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: var(--text-tertiary);
        }

        .inv-card .card-stock {
            margin: 14px 0 10px;
            padding: 12px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .inv-card .stock-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .inv-card .stock-number {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .inv-card .stock-unit {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .inv-card .stock-bar {
            margin-top: 8px;
            height: 6px;
            border-radius: 100px;
            background: var(--bg-card-active);
            overflow: hidden;
        }

        .inv-card .stock-bar .fill {
            height: 100%;
            border-radius: 100px;
            background: linear-gradient(90deg, var(--theme-dark), var(--theme-primary));
            transition: width 0.8s ease;
        }

        .inv-card .stock-bar .fill.low {
            background: linear-gradient(90deg, #b8443f, var(--danger));
        }

        .inv-card .card-price {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin: 12px 0 14px;
            font-size: 12px;
        }

        .inv-card .card-price .label {
            display: block;
            color: var(--text-tertiary);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .inv-card .card-price .value {
            font-weight: 600;
            color: var(--text-primary);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
        }

        .inv-card .card-actions {
            display: flex;
            gap: 8px;
        }

        .inv-card .card-actions a,
        .inv-card .card-actions button {
            flex: 1;
            text-align: center;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .inv-card .card-actions a .icon,
        .inv-card .card-actions button .icon {
            width: 14px;
            height: 14px;
        }

        .inv-card .card-actions a:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        .inv-card .card-actions a.show:hover {
            color: var(--theme-primary);
            border-color: var(--theme-soft);
            background: var(--theme-soft);
        }

        .inv-card .card-actions a.edit:hover {
            color: #4FA6E8;
            border-color: rgba(79, 166, 232, 0.2);
            background: rgba(79, 166, 232, 0.12);
        }

        .inv-card .card-actions button.danger {
            color: var(--danger);
            border-color: rgba(232, 90, 90, 0.15);
        }

        .inv-card .card-actions button.danger:hover {
            background: var(--danger-soft);
            border-color: rgba(232, 90, 90, 0.3);
        }

        /* ===== EMPTY ===== */
        .inv-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .inv-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .inv-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .inv-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        .inv-empty.hidden {
            display: none;
        }

        /* ===== PAGINATION ===== */
        .inv-pagination {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .inv-pagination .info {
            font-size: 13px;
            color: var(--text-tertiary);
        }

        .inv-pagination .links {
            display: flex;
            gap: 6px;
        }

        .inv-pagination .links a,
        .inv-pagination .links span {
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

        .inv-pagination .links a:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .inv-pagination .links .active {
            background: var(--theme-primary);
            border-color: var(--theme-primary);
            color: #fff;
        }

        /* ============================================================
           MODAL DELETE
           ============================================================ */
        .inv-modal-overlay {
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

        .inv-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .inv-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .inv-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .inv-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .inv-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .inv-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .inv-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .inv-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .inv-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .inv-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .inv-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .inv-modal-box .inv-desc-text {
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

        .inv-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .inv-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .inv-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .inv-modal-actions .btn {
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

        .inv-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .inv-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .inv-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .inv-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .inv-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .inv-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .inv-modal-actions .btn-danger:hover {
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
            .inv-stats { grid-template-columns: 1fr 1fr; }
            .inv-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .inv-wrap { padding: 0 12px; }
            .inv-header { flex-direction: column; }
            .inv-actions { width: 100%; }
            .inv-actions .inv-btn { flex: 1; justify-content: center; }
            .inv-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .inv-stat .number { font-size: 20px; }
            .inv-search { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 10px; 
                padding: 12px 16px;
            }
            .inv-search form { flex-direction: column; }
            .inv-search-wrap { min-width: 100%; }
            .inv-search select { width: 100%; }
            .inv-search-actions { 
                width: 100%; 
                justify-content: flex-end; 
                flex-wrap: wrap;
            }
            .inv-grid { grid-template-columns: 1fr; }
            .inv-pagination { flex-direction: column; align-items: center; text-align: center; }
            .inv-pagination .links { justify-content: center; flex-wrap: wrap; }
            
            .inv-stat .number .full-number {
                font-size: 11px;
                padding: 4px 10px;
            }

            .inv-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }

            .inv-modal-actions {
                flex-direction: column;
            }

            .inv-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .inv-stats { grid-template-columns: 1fr; }
            .inv-header h1 { font-size: 22px; }
            .inv-btn { font-size: 12px; padding: 8px 14px; }
            .inv-btn .icon { width: 14px; height: 14px; }
            .inv-card { padding: 16px; }
            .inv-card .stock-number { font-size: 22px; }
            .inv-card .card-price { grid-template-columns: 1fr; }

            .inv-modal-box {
                padding: 20px 16px;
            }

            .inv-modal-box h3 {
                font-size: 18px;
            }

            .inv-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }

            .inv-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }
    </style>

    <div class="inv-wrap">

        <!-- ===== HEADER ===== -->
        <div class="inv-header animate-in" style="animation-delay: 0.05s;">
            <div class="inv-header-left">
                <div class="inv-badge">
                    <span class="dot"></span>
                    Inventory
                </div>
                <h1>Stok Barang</h1>
                <p class="subtitle">
                    Pantau jumlah stok, nilai barang, dan barang yang perlu segera diisi ulang — 
                    <strong id="invTotalCount">{{ isset($items) ? $items->count() : 0 }}</strong> barang
                </p>
            </div>
            <div class="inv-actions">
                <a href="{{ route('inventory.create') }}" class="inv-btn inv-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Barang
                </a>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="inv-stats animate-in" style="animation-delay: 0.10s;" id="invStats">
            <div class="inv-stat">
                <div class="number purple mono" id="statTotalSku">
                    {{ formatNumber($totalSku) }}
                    <span class="full-number">{{ number_format($totalSku, 0, ',', '.') }}</span>
                </div>
                <div class="label">Total SKU</div>
                <div class="sub">Total jenis barang</div>
            </div>
            <div class="inv-stat">
                <div class="number blue mono" id="statTotalValue">
                    {{ formatCurrency($totalValue, $currencySymbol) }}
                    <span class="full-number">{{ $currencySymbol }}{{ number_format($totalValue, 0, ',', '.') }}</span>
                </div>
                <div class="label">Total Nilai Stok</div>
                <div class="sub">Nilai seluruh barang</div>
            </div>
            <div class="inv-stat">
                <div class="number yellow" id="statLowStock">
                    {{ $lowStock }}
                    <span class="full-number">{{ $lowStock }} barang</span>
                </div>
                <div class="label">Stok Menipis</div>
                <div class="sub">Perlu segera diisi ulang</div>
            </div>
            <div class="inv-stat">
                <div class="number red" id="statOutOfStock">
                    {{ $outOfStock }}
                    <span class="full-number">{{ $outOfStock }} barang</span>
                </div>
                <div class="label">Habis</div>
                <div class="sub">Stok kosong</div>
            </div>
        </div>

        <!-- ===== SEARCH BAR ===== -->
        <div class="inv-search animate-in" style="animation-delay: 0.12s;">
            <form method="GET" action="{{ route('inventory.index') }}" id="invSearchForm" onsubmit="return false;">
                <div class="inv-search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="invSearchInput" value="{{ request('q') }}" 
                           placeholder="Cari nama atau SKU barang..." autocomplete="off">
                </div>
                <select name="category" id="invCategorySelect">
                    <option value="">Semua Kategori</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <div class="inv-search-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <button type="button" class="inv-btn inv-btn-ghost" id="invResetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== GRID ===== -->
        @if(isset($items) && $items->count() > 0)
            <div class="inv-grid animate-in" style="animation-delay: 0.15s;" id="invGrid">
                @foreach($items as $item)
                    @php
                        $isLowStock = ($item->stock_quantity ?? 0) <= ($item->min_stock ?? 5);
                        $isOutOfStock = ($item->stock_quantity ?? 0) <= 0;
                        $stockPercent = $item->min_stock > 0 ? min(100, (($item->stock_quantity ?? 0) / $item->min_stock) * 100) : 0;
                    @endphp
                    <div class="inv-card inv-card-data"
                         data-name="{{ strtolower($item->name) }}" 
                         data-sku="{{ strtolower($item->sku ?? '') }}"
                         data-category="{{ strtolower($item->category ?? '') }}">
                        <div class="card-top">
                            <span class="card-badge {{ $isLowStock || $isOutOfStock ? 'low' : '' }}">
                                @if($isOutOfStock)
                                    <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                    Habis
                                @elseif($isLowStock)
                                    <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                    Stok Menipis
                                @else
                                    {{ $item->category ?? 'Umum' }}
                                @endif
                            </span>
                        </div>

                        <div class="card-name">{{ $item->name }}</div>
                        <div class="card-sku">SKU: {{ $item->sku ?? '-' }}</div>

                        <div class="card-stock">
                            <div class="stock-row">
                                <span class="stock-number">{{ $item->stock_quantity ?? 0 }}</span>
                                <span class="stock-unit">{{ $item->unit ?? 'pcs' }}</span>
                            </div>
                            <div class="stock-bar">
                                <div class="fill {{ $isLowStock || $isOutOfStock ? 'low' : '' }}" 
                                     style="width:{{ min(100, $stockPercent) }}%">
                                </div>
                            </div>
                        </div>

                        <div class="card-price">
                            <div>
                                <span class="label">Harga Pokok</span>
                                <span class="value">{{ $currencySymbol }}{{ number_format($item->cost_price ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="label">Harga Jual</span>
                                <span class="value">{{ $currencySymbol }}{{ number_format($item->selling_price ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('inventory.show', ['item' => $item->id]) }}" class="show" title="Lihat Detail">
                                <svg class="icon"><use href="#ic-eye"/></svg>
                                Detail
                            </a>
                            <a href="{{ route('inventory.edit', ['item' => $item->id]) }}" class="edit" title="Edit">
                                <svg class="icon"><use href="#ic-edit"/></svg>
                                Edit
                            </a>
                            <button type="button" class="danger" onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->name) }}')">
                                <svg class="icon"><use href="#ic-trash"/></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ===== PAGINATION ===== -->
            @if(method_exists($items, 'total') && $items->total() > 0)
                <div class="inv-pagination animate-in" style="animation-delay: 0.20s;">
                    <div class="info">
                        Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ number_format($items->total()) }} barang
                    </div>
                    <div class="links">
                        {{ $items->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="inv-empty animate-in" style="animation-delay: 0.15s;" id="emptyState">
                <svg class="empty-icon"><use href="#ic-package"/></svg>
                <h3>Belum ada barang</h3>
                <p>Tambahkan barang pertama untuk mulai melacak stok inventaris.</p>
                <a href="{{ route('inventory.create') }}" class="inv-btn inv-btn-primary" style="display: inline-flex;">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Barang Pertama
                </a>
            </div>
        @endif

    </div>

    <!-- ============================================================
         MODAL DELETE
         ============================================================ -->
    <div class="inv-modal-overlay" id="deleteModal">
        <div class="inv-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Barang Ini?</h3>

            <p>
                Anda yakin ingin menghapus barang
                <br>
                <span class="inv-desc-text" id="deleteDesc">-</span>
            </p>

            <div class="warning-text">
                ⚠️ Data stok yang terhapus tidak dapat dikembalikan!
            </div>

            <div class="inv-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="{{ route('inventory.destroy', ['item' => 0]) }}" method="POST" style="display:inline;">
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
        function openDeleteModal(id, name) {
            document.getElementById('deleteDesc').textContent = name;
            var url = '{{ route("inventory.destroy", ["item" => 0]) }}';
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
            const searchInput = document.getElementById('invSearchInput');
            const categorySelect = document.getElementById('invCategorySelect');
            const resetBtn = document.getElementById('invResetBtn');
            const cards = document.querySelectorAll('.inv-card-data');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchResultCount = document.getElementById('searchResultCount');
            const totalCountEl = document.getElementById('invTotalCount');
            const emptyState = document.getElementById('emptyState');
            let debounceTimeout = null;

            const originalCards = [];
            cards.forEach(card => {
                originalCards.push({
                    element: card,
                    name: card.dataset.name || '',
                    sku: card.dataset.sku || '',
                    category: card.dataset.category || ''
                });
            });

            function resetToInitial() {
                searchInput.value = '';
                categorySelect.value = '';

                cards.forEach(card => {
                    card.classList.remove('hidden-card');
                });

                totalCountEl.textContent = cards.length;
                searchIndicator.classList.remove('active');

                if (emptyState) {
                    emptyState.style.display = 'none';
                    emptyState.classList.add('hidden');
                }
            }

            function filterData() {
                const searchText = searchInput ? searchInput.value.trim().toLowerCase() : '';
                const category = categorySelect ? categorySelect.value.toLowerCase() : '';

                let visibleCount = 0;

                cards.forEach(card => {
                    const name = card.dataset.name || '';
                    const sku = card.dataset.sku || '';
                    const cardCategory = card.dataset.category || '';

                    const matchSearch = searchText === '' || name.includes(searchText) || sku.includes(searchText);
                    const matchCategory = category === '' || cardCategory === category;

                    if (matchSearch && matchCategory) {
                        card.classList.remove('hidden-card');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden-card');
                    }
                });

                if (searchText !== '' || category !== '') {
                    searchIndicator.classList.add('active');
                    searchResultCount.textContent = visibleCount;
                } else {
                    searchIndicator.classList.remove('active');
                }

                totalCountEl.textContent = visibleCount;

                if (emptyState) {
                    if (visibleCount === 0 && cards.length > 0) {
                        emptyState.style.display = 'block';
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Tidak Ada Hasil Pencarian';
                        emptyState.querySelector('p').textContent = 'Tidak ditemukan barang yang sesuai dengan filter yang dipilih.';
                        const btn = emptyState.querySelector('.inv-btn');
                        if (btn) btn.style.display = 'none';
                    } else if (visibleCount === 0 && cards.length === 0) {
                        emptyState.style.display = 'block';
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Belum ada barang';
                        emptyState.querySelector('p').textContent = 'Tambahkan barang pertama untuk mulai melacak stok inventaris.';
                        const btn = emptyState.querySelector('.inv-btn');
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

            if (categorySelect) {
                categorySelect.addEventListener('change', function() {
                    filterData();
                    
                    const url = new URL(window.location.href);
                    if (categorySelect.value !== '') {
                        url.searchParams.set('category', categorySelect.value);
                    } else {
                        url.searchParams.delete('category');
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
                    url.searchParams.delete('category');
                    window.history.replaceState({}, '', url.toString());
                    
                    searchIndicator.classList.remove('active');
                });
            }

            setTimeout(function() {
                resetToInitial();
            }, 100);

            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.inv-btn').forEach(btn => {
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