<x-app-layout>
    <x-slot name="title">Buku Besar</x-slot>

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
    @endphp

    <style>
        .ledger-wrap {
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

        .ledger-wrap * { box-sizing: border-box; }
        .ledger-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px) scale(.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .ledger-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .ledger-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
        .ledger-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ledger-header-left { flex: 1; min-width: 200px; }

        .ledger-badge {
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

        .ledger-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ledger-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ledger-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ledger-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .ledger-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ledger-btn {
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

        .ledger-btn .icon { width: 16px; height: 16px; }
        .ledger-btn:hover { transform: translateY(-2px); }
        .ledger-btn:active { transform: translateY(0) scale(0.97); }

        .ledger-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ledger-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            color: #fff;
        }

        .ledger-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ledger-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ledger-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== STATS ===== */
        .ledger-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .ledger-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ledger-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--theme-light), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ledger-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .ledger-stat:hover::before {
            opacity: 1;
        }

        .ledger-stat .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .ledger-stat .stat-icon .icon {
            width: 18px;
            height: 18px;
        }

        .ledger-stat .stat-icon.purple {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .ledger-stat .stat-icon.blue {
            background: var(--info-soft);
            color: var(--info);
        }

        .ledger-stat .stat-icon.green {
            background: var(--success-soft);
            color: var(--success);
        }

        .ledger-stat .stat-icon.red {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .ledger-stat .number {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            position: relative;
            display: inline-block;
            cursor: default;
        }

        .ledger-stat .number.purple { color: var(--theme-primary); }
        .ledger-stat .number.blue { color: var(--info); }
        .ledger-stat .number.green { color: var(--success); }
        .ledger-stat .number.red { color: var(--danger); }

        .ledger-stat .number .full-number {
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

        .ledger-stat .number .full-number::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: var(--border-color);
        }

        .ledger-stat .number:hover .full-number {
            display: block;
        }

        .ledger-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 2px;
        }

        /* ===== ACCOUNT PILLS ===== */
        .ledger-account-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
            padding: 4px 0;
        }

        .ledger-account-pill {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            background: var(--bg-card);
            border: 1.5px solid var(--border-color);
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            min-width: 160px;
            text-decoration: none;
            position: relative;
        }

        .ledger-account-pill::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: transparent;
            border-radius: 0 2px 2px 0;
            transition: background 0.3s ease;
        }

        .ledger-account-pill:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .ledger-account-pill.active {
            border-color: var(--theme-primary);
            background: var(--theme-soft);
        }

        .ledger-account-pill.active::before {
            background: var(--theme-primary);
        }

        .ledger-account-pill .pill-code {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            color: var(--text-tertiary);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .ledger-account-pill .pill-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .ledger-account-pill .pill-balance {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .ledger-account-pill.active .pill-name {
            color: var(--theme-primary);
        }

        /* ===== FILTER ===== */
        .ledger-filter {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
        }

        .ledger-filter form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            width: 100%;
        }

        .ledger-filter .filter-label {
            font-size: 11px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ledger-filter .filter-label .icon {
            width: 14px;
            height: 14px;
        }

        .ledger-filter input[type="date"] {
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1.5px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            min-width: 160px;
        }

        .ledger-filter input[type="date"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--theme-soft);
        }

        .ledger-filter input[type="date"]:hover {
            border-color: var(--border-hover);
        }

        .ledger-filter .filter-actions {
            display: flex;
            gap: 8px;
            margin-left: auto;
        }

        .ledger-filter .filter-actions .ledger-btn {
            padding: 8px 16px;
            font-size: 12px;
        }

        /* ===== LEDGER TABLE ===== */
        .ledger-table-wrap {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .ledger-table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            background: var(--bg-card-active);
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 12px;
        }

        .ledger-table-header .left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ledger-table-header .left .header-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ledger-table-header .left .header-icon .icon {
            width: 16px;
            height: 16px;
        }

        .ledger-table-header .left h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .ledger-table-header .left .code {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 2px 10px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .ledger-table-header .balance {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 18px;
            font-weight: 700;
            color: var(--theme-primary);
        }

        .ledger-table-scroll {
            overflow-x: auto;
        }

        .ledger-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .ledger-table thead th {
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-tertiary);
            font-weight: 700;
            padding: 14px 18px;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            background: var(--bg-card-active);
        }

        .ledger-table thead th.text-right {
            text-align: right;
        }

        .ledger-table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: background 0.15s ease;
        }

        .ledger-table tbody tr:last-child {
            border-bottom: none;
        }

        .ledger-table tbody tr:hover {
            background: var(--bg-card-hover);
        }

        .ledger-table tbody td {
            padding: 14px 18px;
            font-size: 13px;
            vertical-align: middle;
        }

        .ledger-table tbody td .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
        }

        .ledger-table tbody td.text-right {
            text-align: right;
        }

        .ledger-table .debit {
            color: var(--success);
            font-weight: 600;
        }

        .ledger-table .credit {
            color: var(--danger);
            font-weight: 600;
        }

        .ledger-table .description-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ledger-table .balance-cell {
            font-weight: 600;
        }

        /* ===== ROW ACTIONS ===== */
        .ledger-row-actions {
            display: flex;
            gap: 4px;
            justify-content: flex-end;
        }

        .ledger-row-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            transition: all 0.15s ease;
            cursor: pointer;
            white-space: nowrap;
            gap: 4px;
        }

        .ledger-row-action .icon {
            width: 13px;
            height: 13px;
        }

        .ledger-row-action:hover {
            background: var(--bg-card);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ledger-row-action.view:hover {
            color: var(--info);
            border-color: rgba(78, 143, 240, 0.3);
            background: var(--info-soft);
        }

        .ledger-row-action.edit:hover {
            color: var(--theme-primary);
            border-color: var(--theme-glow);
            background: var(--theme-soft);
        }

        .ledger-row-action.delete {
            color: var(--danger);
            border-color: rgba(232, 90, 90, 0.2);
        }

        .ledger-row-action.delete:hover {
            background: var(--danger-soft);
            border-color: rgba(232, 90, 90, 0.4);
        }

        /* ===== EMPTY ===== */
        .ledger-empty {
            text-align: center;
            padding: 60px 20px;
        }

        .ledger-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .ledger-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .ledger-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        /* ===== PAGINATION ===== */
        .ledger-pagination {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .ledger-pagination .info {
            font-size: 13px;
            color: var(--text-tertiary);
        }

        .ledger-pagination .links {
            display: flex;
            gap: 4px;
        }

        .ledger-pagination .links nav {
            display: flex;
            gap: 4px;
        }

        .ledger-pagination .links nav a,
        .ledger-pagination .links nav span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            transition: all 0.2s ease;
            min-width: 36px;
            text-decoration: none;
        }

        .ledger-pagination .links nav a:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ledger-pagination .links nav span[aria-current="page"] {
            background: var(--theme-primary);
            color: #fff;
            border-color: var(--theme-primary);
        }

        .ledger-pagination .links nav .disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ============================================================
           DELETE MODAL - SAMA SEPERTI HALAMAN LABA RUGI
           ============================================================ */
        .ledger-modal-overlay {
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

        .ledger-modal-overlay.active {
            display: flex;
        }

        .ledger-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="dark"] .ledger-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .ledger-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .ledger-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .ledger-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .ledger-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .ledger-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .ledger-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
        }

        .ledger-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
        }

        .ledger-modal-box .ledger-desc-text {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-size: 15px;
        }

        .ledger-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .ledger-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .ledger-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .ledger-modal-actions .btn {
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

        .ledger-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .ledger-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ledger-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .ledger-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .ledger-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .ledger-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .ledger-modal-actions .btn-danger:hover {
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
        @media (max-width: 1200px) {
            .ledger-stats { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .ledger-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .ledger-wrap { padding: 0 12px; }
            .ledger-header { flex-direction: column; }
            .ledger-actions { width: 100%; }
            .ledger-actions .ledger-btn { flex: 1; justify-content: center; }
            .ledger-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .ledger-stat { padding: 16px 18px; }
            .ledger-stat .number { font-size: 20px; }
            .ledger-filter { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 10px; 
                padding: 12px 16px;
            }
            .ledger-filter form { flex-direction: column; align-items: stretch; }
            .ledger-filter input[type="date"] { width: 100%; }
            .ledger-filter .filter-actions { 
                width: 100%; 
                justify-content: stretch;
                margin-left: 0;
            }
            .ledger-filter .filter-actions .ledger-btn { flex: 1; justify-content: center; }
            .ledger-table-header { flex-direction: column; align-items: flex-start; }
            .ledger-table thead th { padding: 10px 12px; font-size: 9px; }
            .ledger-table tbody td { padding: 10px 12px; font-size: 12px; }
            .ledger-account-pill { min-width: 130px; padding: 12px 16px; }
            .ledger-pagination { flex-direction: column; text-align: center; }
            .ledger-pagination .links { justify-content: center; }
            .ledger-modal-box { padding: 24px 20px; margin: 10px; }
            .ledger-modal-actions { flex-direction: column; }
            .ledger-modal-actions .btn { width: 100%; }
        }

        @media (max-width: 480px) {
            .ledger-stats { grid-template-columns: 1fr; }
            .ledger-header h1 { font-size: 22px; }
            .ledger-btn { font-size: 12px; padding: 8px 14px; }
            .ledger-btn .icon { width: 14px; height: 14px; }
            .ledger-account-pill { min-width: 100%; }
            .ledger-modal-box { padding: 20px 16px; }
            .ledger-modal-box h3 { font-size: 18px; }
            .ledger-modal-box .icon-danger { width: 48px; height: 48px; }
            .ledger-modal-box .icon-danger svg { width: 24px; height: 24px; }
            .ledger-row-actions { flex-wrap: wrap; justify-content: flex-start; }
            .ledger-row-action { font-size: 10px; padding: 3px 8px; }
            .ledger-table thead th { font-size: 8px; padding: 8px 10px; }
            .ledger-table tbody td { font-size: 11px; padding: 8px 10px; }
        }
    </style>

    <div class="ledger-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="ledger-header animate-in" style="animation-delay: 0.05s;">
            <div class="ledger-header-left">
                <div class="ledger-badge">
                    <span class="dot"></span>
                    Akuntansi
                </div>
                <h1>Buku Besar</h1>
                <p class="subtitle">
                    Riwayat transaksi debit/kredit per akun untuk 
                    <strong>{{ $company->name ?? 'perusahaanmu' }}</strong>
                </p>
            </div>
            <div class="ledger-actions">
                <a href="{{ route('ledger.create') }}" class="ledger-btn ledger-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Transaksi
                </a>
            </div>
        </div>

        {{-- ===== STATS ===== --}}
        <div class="ledger-stats animate-in" style="animation-delay: 0.10s;">
            <div class="ledger-stat">
                <div class="stat-icon purple">
                    <svg class="icon"><use href="#ic-grid"/></svg>
                </div>
                <div class="number purple" id="statTotalAccounts">
                    {{ $accounts->count() }}
                    <span class="full-number">{{ $accounts->count() }} akun</span>
                </div>
                <div class="label">Total Akun</div>
            </div>
            <div class="ledger-stat">
                <div class="stat-icon blue">
                    <svg class="icon"><use href="#ic-file-text"/></svg>
                </div>
                <div class="number blue" id="statTotalEntries">
                    {{ $totalEntries ?? 0 }}
                    <span class="full-number">{{ number_format($totalEntries ?? 0, 0, ',', '.') }} transaksi</span>
                </div>
                <div class="label">Total Transaksi</div>
            </div>
            <div class="ledger-stat">
                <div class="stat-icon green">
                    <svg class="icon"><use href="#ic-trending-up"/></svg>
                </div>
                <div class="number green" id="statTotalDebit">
                    {{ formatCurrency($totalDebit ?? 0, $currencySymbol) }}
                    <span class="full-number">{{ $currencySymbol }}{{ number_format($totalDebit ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="label">Total Debit</div>
            </div>
            <div class="ledger-stat">
                <div class="stat-icon red">
                    <svg class="icon"><use href="#ic-trending-down"/></svg>
                </div>
                <div class="number red" id="statTotalCredit">
                    {{ formatCurrency($totalCredit ?? 0, $currencySymbol) }}
                    <span class="full-number">{{ $currencySymbol }}{{ number_format($totalCredit ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="label">Total Kredit</div>
            </div>
        </div>

        {{-- ===== ACCOUNT PILLS ===== --}}
        @if($accounts->isNotEmpty())
            <div class="ledger-account-pills animate-in" style="animation-delay: 0.12s;">
                @foreach($accounts as $acc)
                    @php $balance = (float) $acc->total_debit - (float) $acc->total_credit; @endphp
                    <a href="{{ route('ledger.index', ['account' => $acc->account_code]) }}" 
                       class="ledger-account-pill {{ $accountCode === $acc->account_code ? 'active' : '' }}">
                        <span class="pill-code">{{ $acc->account_code }}</span>
                        <span class="pill-name">{{ $acc->account_name }}</span>
                        <span class="pill-balance">{{ $currencySymbol }}{{ number_format($balance, 0, ',', '.') }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- ===== FILTER ===== --}}
        @if($accountCode && $selectedAccount)
            <div class="ledger-filter animate-in" style="animation-delay: 0.15s;">
                <form method="GET" action="{{ route('ledger.index') }}">
                    <input type="hidden" name="account" value="{{ $accountCode }}">
                    <span class="filter-label">
                        <svg class="icon"><use href="#ic-calendar"/></svg>
                        Periode
                    </span>
                    <input type="date" name="from" value="{{ $from }}">
                    <span style="color:var(--text-tertiary);font-size:13px;">s/d</span>
                    <input type="date" name="to" value="{{ $to }}">
                    <div class="filter-actions">
                        <button type="submit" class="ledger-btn ledger-btn-primary">
                            <svg class="icon"><use href="#ic-filter"/></svg>
                            Terapkan
                        </button>
                        @if($from || $to)
                            <a href="{{ route('ledger.index', ['account' => $accountCode]) }}" class="ledger-btn ledger-btn-ghost">
                                <svg class="icon"><use href="#ic-x"/></svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        @endif

        {{-- ===== LEDGER TABLE ===== --}}
        @if($accountCode && $selectedAccount)
            <div class="ledger-table-wrap animate-in" style="animation-delay: 0.18s;">
                <div class="ledger-table-header">
                    <div class="left">
                        <div class="header-icon">
                            <svg class="icon"><use href="#ic-bank"/></svg>
                        </div>
                        <h3>{{ $selectedAccount->account_name }}</h3>
                        <span class="code">{{ $selectedAccount->account_code }}</span>
                    </div>
                    <span class="balance">
                        Saldo: {{ $currencySymbol }}{{ number_format((float) $selectedAccount->total_debit - (float) $selectedAccount->total_credit, 0, ',', '.') }}
                    </span>
                </div>

                <div class="ledger-table-scroll">
                    <table class="ledger-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Kredit</th>
                                <th class="text-right">Saldo</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($entries as $entry)
                            <tr>
                                <td class="mono">{{ $entry->transaction_date->format('d/m/Y') }}</td>
                                <td class="description-cell" title="{{ $entry->description }}">{{ $entry->description }}</td>
                                <td class="text-right mono debit">{{ $entry->debit > 0 ? $currencySymbol . number_format($entry->debit, 0, ',', '.') : '—' }}</td>
                                <td class="text-right mono credit">{{ $entry->credit > 0 ? $currencySymbol . number_format($entry->credit, 0, ',', '.') : '—' }}</td>
                                <td class="text-right mono balance-cell">{{ $currencySymbol }}{{ number_format($entry->running_balance, 0, ',', '.') }}</td>
                                <td>
                                    <div class="ledger-row-actions">
                                        <a href="{{ route('ledger.show', $entry) }}" class="ledger-row-action view" title="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('ledger.edit', $entry) }}" class="ledger-row-action edit" title="Edit Transaksi">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="ledger-row-action delete" title="Hapus Transaksi" onclick="openDeleteModal('{{ $entry->id }}', '{{ addslashes($entry->description) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="ledger-empty">
                                        <svg class="empty-icon"><use href="#ic-inbox"/></svg>
                                        <h3>Belum ada transaksi</h3>
                                        <p>Transaksi untuk akun ini akan muncul di sini setelah dicatat.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ===== PAGINATION ===== --}}
            @if(method_exists($entries, 'total') && $entries->total() > 0)
                <div class="ledger-pagination animate-in" style="animation-delay: 0.20s;">
                    <div class="info">
                        Menampilkan {{ $entries->firstItem() }}–{{ $entries->lastItem() }} 
                        dari {{ number_format($entries->total()) }} transaksi
                    </div>
                    <div class="links">
                        {{ $entries->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif

        @elseif($accounts->isNotEmpty())
            <div class="ledger-empty animate-in" style="animation-delay: 0.18s; background:var(--bg-card); border:1px solid var(--border-color); border-radius:var(--radius-md); margin-top:0;">
                <svg class="empty-icon"><use href="#ic-eye"/></svg>
                <h3>Pilih Akun</h3>
                <p>Klik salah satu akun di atas untuk melihat riwayat transaksinya.</p>
            </div>
        @else
            <div class="ledger-empty animate-in" style="animation-delay: 0.15s; background:var(--bg-card); border:1px solid var(--border-color); border-radius:var(--radius-md); margin-top:0;">
                <svg class="empty-icon"><use href="#ic-inbox"/></svg>
                <h3>Belum ada akun</h3>
                <p>Tambahkan transaksi pertama untuk mulai membangun buku besar.</p>
                <a href="{{ route('ledger.create') }}" class="ledger-btn ledger-btn-primary" style="display:inline-flex;">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Transaksi Pertama
                </a>
            </div>
        @endif

    </div>

    {{-- ===== DELETE MODAL - SAMA SEPERTI HALAMAN LABA RUGI ===== --}}
    <div class="ledger-modal-overlay" id="deleteModal">
        <div class="ledger-modal-box">
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
                <span class="ledger-desc-text" id="deleteDesc">—</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="ledger-modal-actions">
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

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
        <symbol id="ic-grid" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></symbol>
        <symbol id="ic-file-text" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
        <symbol id="ic-trending-up" viewBox="0 0 24 24"><polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/></symbol>
        <symbol id="ic-trending-down" viewBox="0 0 24 24"><polyline points="3 7 9 13 13 9 21 17"/><polyline points="14 17 21 17 21 10"/></symbol>
        <symbol id="ic-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
        <symbol id="ic-filter" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 13 10 21 14 18 14 13 22 3"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-bank" viewBox="0 0 24 24"><path d="M3 21h18"/><path d="M5 21V10l7-6 7 6v11"/><path d="M9 21v-7h6v7"/></symbol>
        <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></symbol>
        <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
        <symbol id="ic-inbox" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></symbol>
    </svg>

    <script>
        // ===== DELETE MODAL =====
        function openDeleteModal(id, description) {
            document.getElementById('deleteDesc').textContent = description;
            document.getElementById('deleteForm').action = '{{ url("ledger") }}/' + id;
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
        document.querySelectorAll('.ledger-btn').forEach(btn => {
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