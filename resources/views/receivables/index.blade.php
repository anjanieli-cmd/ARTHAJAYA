<x-app-layout>
    <x-slot name="title">Piutang Usaha (AR)</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $receivablesCollection = collect($receivables);
        $statusLabel = ['lancar' => 'Lancar', 'jatuh_tempo' => 'Jatuh Tempo', 'lunas' => 'Lunas'];
        $statusPill = ['lancar' => 'lancar', 'jatuh_tempo' => 'jatuh_tempo', 'lunas' => 'lunas'];

        $totalPiutang = $receivablesCollection->whereIn('status', ['lancar', 'jatuh_tempo'])->sum('amount');
        $totalJatuhTempo = $receivablesCollection->where('status', 'jatuh_tempo')->sum('amount');
        $totalLancar = $receivablesCollection->where('status', 'lancar')->sum('amount');
        $totalLunas = $receivablesCollection->where('status', 'lunas')->sum('amount');
        $countJatuhTempo = $receivablesCollection->where('status', 'jatuh_tempo')->count();
        $countLancar = $receivablesCollection->where('status', 'lancar')->count();
        $countLunas = $receivablesCollection->where('status', 'lunas')->count();

        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }

        function isOverdue($dueDate, $status) {
            if ($status === 'lunas') return false;
            try {
                return \Carbon\Carbon::parse($dueDate)->isPast();
            } catch (\Exception $e) {
                return false;
            }
        }

        function formatSingkat($number, $symbol = 'Rp') {
            $number = (float) $number;
            $neg = $number < 0;
            $abs = abs($number);

            if ($abs >= 1_000_000_000_000) {
                $val = $abs / 1_000_000_000_000;
                $suffix = 'T';
            } elseif ($abs >= 1_000_000_000) {
                $val = $abs / 1_000_000_000;
                $suffix = 'M';
            } elseif ($abs >= 1_000_000) {
                $val = $abs / 1_000_000;
                $suffix = 'Jt';
            } elseif ($abs >= 1_000) {
                $val = $abs / 1_000;
                $suffix = 'Rb';
            } else {
                return ($neg ? '-' : '') . $symbol . number_format($abs, 0, ',', '.');
            }

            $formatted = number_format($val, 1, ',', '.');
            $formatted = preg_replace('/,0$/', '', $formatted);

            return ($neg ? '-' : '') . $symbol . $formatted . ' ' . $suffix;
        }

        function formatLengkap($number, $symbol = 'Rp') {
            return $symbol . number_format($number, 0, ',', '.');
        }

        $chartData = [
            'lancar' => ['label' => 'Lancar', 'value' => $totalLancar, 'color' => 'var(--theme-primary)'],
            'jatuh_tempo' => ['label' => 'Jatuh Tempo', 'value' => $totalJatuhTempo, 'color' => 'var(--danger)'],
            'lunas' => ['label' => 'Lunas', 'value' => $totalLunas, 'color' => 'var(--text-faint)'],
        ];
    @endphp

    <style>
        .ar-modern {
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
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .ar-modern * {
            box-sizing: border-box;
        }
        .ar-modern .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.02em;
        }

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
            0%,
            100% {
                opacity: 1;
            }
            50% {
                opacity: 0.6;
            }
        }

        .ar-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .ar-modern .icon {
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

        /* HEADER */
        .ar-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ar-header-left {
            flex: 1;
            min-width: 200px;
        }

        .ar-badge {
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

        .ar-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ar-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ar-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ar-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .ar-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ar-btn {
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

        .ar-btn .icon {
            width: 16px;
            height: 16px;
        }
        .ar-btn:hover {
            transform: translateY(-2px);
        }
        .ar-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .ar-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ar-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ar-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ar-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ar-btn .ripple {
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

        /* STATS */
        .ar-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .ar-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 22px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-width: 0;
        }

        .ar-stat-card::before {
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

        .ar-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .ar-stat-card:hover::before {
            opacity: 1;
        }

        .ar-stat-card .stat-label {
            font-size: 11.5px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ar-stat-card .stat-label .icon {
            width: 14px;
            height: 14px;
        }

        .ar-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: default;
        }

        .ar-stat-card .stat-value.primary {
            color: var(--theme-primary);
        }
        .ar-stat-card .stat-value.danger {
            color: var(--danger);
        }

        .ar-stat-card .stat-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* LAYOUT */
        .ar-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 20px;
            align-items: start;
        }

        /* SIDEBAR */
        .ar-sidebar {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: border-color 0.22s ease;
            position: sticky;
            top: 80px;
        }

        .ar-sidebar:hover {
            border-color: var(--border-hover);
        }

        .ar-sidebar .section-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        /* DONUT */
        .ar-donut-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .ar-donut {
            width: 160px;
            height: 160px;
            position: relative;
            flex-shrink: 0;
            margin-bottom: 16px;
        }

        .ar-donut svg {
            transform: rotate(-90deg);
            width: 100%;
            height: 100%;
        }

        .ar-donut circle {
            fill: none;
            stroke-width: 16;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .ar-donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
            text-align: center;
        }

        .ar-donut-center .total {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            cursor: default;
        }

        .ar-donut-center .label {
            font-size: 10px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }

        /* LEGEND */
        .ar-legend {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        .ar-legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            transition: background 0.2s ease;
        }

        .ar-legend-item:hover {
            background: var(--bg-card-hover);
        }

        .ar-legend-item .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .ar-legend-item .dot.lancar {
            background: var(--theme-primary);
        }
        .ar-legend-item .dot.jatuh_tempo {
            background: var(--danger);
        }
        .ar-legend-item .dot.lunas {
            background: var(--text-tertiary);
        }

        .ar-legend-item .label {
            flex: 1;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .ar-legend-item .value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            cursor: default;
        }

        .ar-legend-item .count {
            font-size: 11px;
            color: var(--text-tertiary);
            padding: 2px 8px;
            border-radius: 100px;
            background: var(--bg-card-active);
        }

        .ar-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 16px 0;
        }

        .ar-alert {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--danger);
        }

        .ar-alert .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
        .ar-alert .message {
            font-size: 13px;
            font-weight: 500;
        }
        .ar-alert .message strong {
            font-weight: 700;
        }

        .ar-alert.success {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
            color: var(--theme-primary);
        }

        /* LIST */
        .ar-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ar-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .ar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ar-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .ar-item:hover::before {
            opacity: 1;
        }

        .ar-item.status-lancar::before {
            background: var(--theme-primary);
        }
        .ar-item.status-jatuh_tempo::before {
            background: var(--danger);
        }
        .ar-item.status-lunas::before {
            background: var(--text-tertiary);
        }

        .ar-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .ar-avatar .icon {
            width: 20px;
            height: 20px;
        }

        .ar-item-info {
            flex: 1;
            min-width: 0;
        }

        .ar-item-client {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ar-item-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 4px;
            font-size: 12px;
            color: var(--text-tertiary);
            flex-wrap: wrap;
        }

        .ar-item-meta .invoice {
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-secondary);
        }

        .ar-item-meta .separator {
            color: var(--border-color);
        }

        .ar-item-meta .due-date {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ar-item-meta .due-date .icon {
            width: 12px;
            height: 12px;
        }
        .ar-item-meta .due-date.overdue {
            color: var(--danger);
        }

        .ar-item-right {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .ar-item-amount {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            min-width: 90px;
            text-align: right;
            cursor: default;
        }

        .ar-status-pill {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
            display: inline-block;
            white-space: nowrap;
        }

        .ar-status-pill.lancar {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .ar-status-pill.jatuh_tempo {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .ar-status-pill.lunas {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }

        /* ACTIONS */
        .ar-actions {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
        }

        .ar-actions .btn-action {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 14px;
            border: none;
        }

        .ar-actions .btn-action .icon {
            width: 15px;
            height: 15px;
        }

        .ar-actions .btn-action.show {
            color: var(--theme-primary);
        }

        .ar-actions .btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
            transform: translateY(-2px);
        }

        .ar-actions .btn-action.danger {
            color: var(--danger);
        }

        .ar-actions .btn-action.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
            transform: translateY(-2px);
        }

        /* FOOTER */
        .ar-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .ar-footer .info {
            font-size: 13px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ar-footer .info .icon {
            width: 14px;
            height: 14px;
            color: var(--theme-primary);
        }

        .ar-footer .actions {
            display: flex;
            gap: 12px;
        }

        .ar-footer .actions a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .ar-footer .actions a .icon {
            width: 14px;
            height: 14px;
            color: var(--theme-primary);
        }

        .ar-footer .actions a:hover {
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        /* EMPTY */
        .ar-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .ar-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .ar-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .ar-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* INFO NOTE */
        .ar-info-note {
            background: var(--theme-soft);
            border: 1px solid var(--theme-primary);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--theme-primary);
            font-size: 13px;
        }

        .ar-info-note .icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        .ar-info-note a {
            color: var(--theme-primary);
            font-weight: 600;
            text-decoration: underline;
        }
        .ar-info-note a:hover {
            opacity: 0.8;
        }

        /* SUCCESS */
        .ar-success {
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

        .ar-success .icon {
            width: 20px;
            height: 20px;
        }
        .ar-success .message {
            font-weight: 500;
        }

        /* MODAL DELETE */
        .ar-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }
        .ar-modal-overlay.active {
            display: flex;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes modalSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .ar-modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }
        [data-theme="light"] .ar-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }
        .ar-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .ar-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .ar-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .ar-modal-box .invoice-number {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .ar-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .ar-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        .ar-modal-actions .btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .ar-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }
        .ar-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        .ar-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }
        .ar-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .ar-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        @media (max-width: 1200px) {
            .ar-stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .ar-layout {
                grid-template-columns: 1fr;
            }
            .ar-sidebar {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                position: static;
            }
            .ar-donut-wrap {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .ar-item {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 640px) {
            .ar-header {
                flex-direction: column;
            }
            .ar-header-actions {
                width: 100%;
            }
            .ar-header-actions .ar-btn {
                flex: 1;
                justify-content: center;
            }
            .ar-stats-row {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            .ar-stat-card .stat-value {
                font-size: 20px;
            }
            .ar-sidebar {
                grid-template-columns: 1fr;
            }
            .ar-item {
                flex-wrap: wrap;
                padding: 14px 16px;
                gap: 12px;
            }
            .ar-item-right {
                width: 100%;
                justify-content: space-between;
                margin-left: 60px;
            }
            .ar-item-amount {
                min-width: auto;
                font-size: 14px;
            }
            .ar-item-meta {
                font-size: 11px;
                gap: 8px;
            }
            .ar-actions {
                width: 100%;
                margin-left: 60px;
                justify-content: flex-start;
            }
            .ar-footer {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
                gap: 12px;
            }
            .ar-footer .actions {
                justify-content: center;
                flex-wrap: wrap;
            }
            .ar-avatar {
                width: 36px;
                height: 36px;
                font-size: 13px;
            }
            .ar-donut {
                width: 130px;
                height: 130px;
            }
            .ar-donut-center .total {
                font-size: 16px;
            }
            .ar-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }
            .ar-modal-actions {
                flex-direction: column;
            }
            .ar-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 380px) {
            .ar-header h1 {
                font-size: 22px;
            }
            .ar-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .ar-btn .icon {
                width: 14px;
                height: 14px;
            }
            .ar-stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="ar-modern">

        <!-- HEADER -->
        <div class="ar-header animate-in" style="animation-delay: 0.05s;">
            <div class="ar-header-left">
                <div class="ar-badge">
                    <span class="dot"></span>
                    Piutang &amp; Utang
                </div>
                <h1>Piutang Usaha (AR)</h1>
                <p class="subtitle">
                    Daftar tagihan yang belum dibayar klien —
                    <strong>{{ $receivablesCollection->count() }}</strong> faktur aktif
                </p>
            </div>
            <div class="ar-header-actions">
                <a href="{{ route('aging.index') }}" class="ar-btn ar-btn-ghost">
                    <svg class="icon"><use href="#ic-trending"/></svg>
                    Aging Report
                </a>
                <a href="{{ route('invoices.index') }}" class="ar-btn ar-btn-ghost">
                    <svg class="icon"><use href="#ic-invoice"/></svg>
                    Semua Faktur
                </a>
            </div>
        </div>

        <!-- INFO NOTE -->
        <div class="ar-info-note animate-in" style="animation-delay: 0.07s;">
            <svg class="icon"><use href="#ic-info"/></svg>
            <span>
                💡 Faktur baru dibuat di halaman
                <a href="{{ route('invoices.index') }}">Semua Faktur</a>.
                Faktur yang sudah jatuh tempo otomatis muncul di sini.
            </span>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
        <div class="ar-success animate-in" style="animation-delay: 0.08s;">
            <svg class="icon"><use href="#ic-shield"/></svg>
            <span class="message">{{ session('success') }}</span>
        </div>
        @endif

        <!-- STATS -->
        <div class="ar-stats-row">
            <div class="ar-stat-card animate-in" style="animation-delay: 0.10s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-bank"/></svg>
                    Total Piutang
                </div>
                <div class="stat-value primary mono" title="{{ formatLengkap($totalPiutang, $currencySymbol) }}">
                    {{ formatSingkat($totalPiutang, $currencySymbol) }}
                </div>
                <div class="stat-sub">{{ $countLancar + $countJatuhTempo }} faktur belum dibayar</div>
            </div>

            <div class="ar-stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-trending"/></svg>
                    Lancar
                </div>
                <div class="stat-value mono" title="{{ formatLengkap($totalLancar, $currencySymbol) }}">
                    {{ formatSingkat($totalLancar, $currencySymbol) }}
                </div>
                <div class="stat-sub">{{ $countLancar }} faktur dalam masa tenggang</div>
            </div>

            <div class="ar-stat-card animate-in" style="animation-delay: 0.20s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-trending-down"/></svg>
                    Jatuh Tempo
                </div>
                <div class="stat-value danger mono" title="{{ formatLengkap($totalJatuhTempo, $currencySymbol) }}">
                    {{ formatSingkat($totalJatuhTempo, $currencySymbol) }}
                </div>
                <div class="stat-sub">{{ $countJatuhTempo }} faktur perlu ditagih</div>
            </div>

            <div class="ar-stat-card animate-in" style="animation-delay: 0.25s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-shield"/></svg>
                    Tingkat Kolektibilitas
                </div>
                <div class="stat-value mono">
                    {{ $totalPiutang > 0 ? round(($totalLancar / $totalPiutang) * 100) : 0 }}%
                </div>
                <div class="stat-sub">dari total piutang</div>
            </div>
        </div>

        <!-- LAYOUT -->
        <div class="ar-layout">

            <!-- SIDEBAR -->
            <aside class="ar-sidebar animate-in" style="animation-delay: 0.30s;">
                <div class="section-title">Ringkasan Piutang</div>

                <div class="ar-donut-wrap">
                    <div class="ar-donut">
                        <svg viewBox="0 0 120 120">
                            @php
                            $total = $totalLancar + $totalJatuhTempo + $totalLunas;
                            $circumference = 2 * 3.14159 * 45;
                            $lancarPercent = $total > 0 ? ($totalLancar / $total) * 100 : 0;
                            $jatuhPercent = $total > 0 ? ($totalJatuhTempo / $total) * 100 : 0;
                            $lunasPercent = $total > 0 ? ($totalLunas / $total) * 100 : 0;
                            $lancarOffset = $circumference - ($lancarPercent / 100) * $circumference;
                            $jatuhOffset = $circumference - ($jatuhPercent / 100) * $circumference - ($lancarPercent / 100) * $circumference;
                            $lunasOffset = $circumference - ($lunasPercent / 100) * $circumference - (($lancarPercent + $jatuhPercent) / 100) * $circumference;
                            @endphp
                            <circle cx="60" cy="60" r="45" stroke="var(--bg-card-active)" stroke-width="16"/>
                            <circle cx="60" cy="60" r="45" stroke="var(--theme-primary)" stroke-width="16" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $lancarOffset }}"/>
                            <circle cx="60" cy="60" r="45" stroke="var(--danger)" stroke-width="16" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $jatuhOffset + $lancarOffset }}"/>
                            <circle cx="60" cy="60" r="45" stroke="var(--text-tertiary)" stroke-width="16" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $lunasOffset + $lancarOffset + $jatuhOffset }}"/>
                        </svg>
                        <div class="ar-donut-center">
                            <span class="total mono" title="{{ formatLengkap($totalPiutang, $currencySymbol) }}">
                                {{ formatSingkat($totalPiutang, $currencySymbol) }}
                            </span>
                            <span class="label">Total Piutang</span>
                        </div>
                    </div>
                </div>

                <div class="ar-legend">
                    @foreach($chartData as $key => $data)
                    <div class="ar-legend-item">
                        <span class="dot {{ $key }}"></span>
                        <span class="label">{{ $data['label'] }}</span>
                        <span class="count">{{ $key === 'lancar' ? $countLancar : ($key === 'jatuh_tempo' ? $countJatuhTempo : $countLunas) }} faktur</span>
                        <span class="value mono" title="{{ formatLengkap($data['value'], $currencySymbol) }}">
                            {{ formatSingkat($data['value'], $currencySymbol) }}
                        </span>
                    </div>
                    @endforeach
                </div>

                <hr class="ar-divider">

                @if($countJatuhTempo > 0)
                <div class="ar-alert">
                    <svg class="icon"><use href="#ic-trending-down"/></svg>
                    <span class="message">
                        <strong>{{ $countJatuhTempo }} faktur</strong> telah jatuh tempo!
                        Segera lakukan penagihan.
                    </span>
                </div>
                @else
                <div class="ar-alert success">
                    <svg class="icon"><use href="#ic-shield"/></svg>
                    <span class="message">
                        Semua piutang dalam kondisi <strong>lancar</strong>.
                    </span>
                </div>
                @endif
            </aside>

            <!-- LIST -->
            <div>
                <div class="ar-list">
                    @forelse($receivables as $index => $r)
                    @php
                    $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                    $color = $colors[($index + $loop->iteration) % count($colors)];
                    $isOverdue = isOverdue($r['due'], $r['status']);
                    @endphp
                    <div class="ar-item status-{{ $statusPill[$r['status']] }} animate-in"
                         style="animation-delay: {{ 0.35 + ($index * 0.05) }}s;">

                        <div class="ar-avatar" style="background: {{ $color }};">
                            @if($r['status'] === 'lunas')
                            <svg class="icon"><use href="#ic-shield"/></svg>
                            @else
                            {{ mb_substr($r['client'], 0, 1) }}
                            @endif
                        </div>

                        <div class="ar-item-info">
                            <div class="ar-item-client">{{ $r['client'] }}</div>
                            <div class="ar-item-meta">
                                <span class="invoice mono">{{ $r['invoice'] }}</span>
                                <span class="separator">•</span>
                                <span>{{ formatTanggal($r['date']) }}</span>
                                <span class="separator">•</span>
                                <span class="due-date {{ $isOverdue ? 'overdue' : '' }}">
                                    <svg class="icon"><use href="#ic-clock"/></svg>
                                    Jatuh tempo {{ formatTanggal($r['due']) }}
                                    @if($isOverdue)
                                    <span style="color: var(--danger);">(Lewat)</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="ar-item-right">
                            <span class="ar-status-pill {{ $statusPill[$r['status']] }}">
                                {{ $statusLabel[$r['status']] }}
                            </span>
                            <span class="ar-item-amount mono" title="{{ formatLengkap($r['amount'], $currencySymbol) }}">
                                {{ formatSingkat($r['amount'], $currencySymbol) }}
                            </span>
                        </div>

                        <!-- ACTIONS: Show & Delete -->
                        <div class="ar-actions">
                            <a href="{{ route('invoices.show', $r['id']) }}" class="btn-action show" title="Lihat Detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <button type="button" class="btn-action danger" title="Hapus Faktur" 
                                    onclick="openDeleteModal('{{ $r['id'] }}', '{{ $r['invoice'] }}')">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"/>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/>
                                    <path d="M14 11v6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="ar-empty animate-in" style="animation-delay: 0.35s;">
                        <svg class="empty-icon"><use href="#ic-bank"/></svg>
                        <h3>Belum Ada Piutang</h3>
                        <p>Belum ada faktur yang jatuh tempo atau belum dibayar.</p>
                        <a href="{{ route('invoices.index') }}" class="ar-btn ar-btn-ghost" style="display: inline-flex;">
                            <svg class="icon"><use href="#ic-invoice"/></svg>
                            Lihat Semua Faktur
                        </a>
                    </div>
                    @endforelse
                </div>

                <div class="ar-footer animate-in" style="animation-delay: 0.40s;">
                    <div class="info">
                        <svg class="icon"><use href="#ic-briefcase"/></svg>
                        Total {{ $receivablesCollection->count() }} faktur terdaftar
                    </div>
                    <div class="actions">
                        <a href="{{ route('invoices.index') }}">
                            <svg class="icon"><use href="#ic-invoice"/></svg>
                            Semua Faktur
                        </a>
                        <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}">
                            <svg class="icon"><use href="#ic-doc"/></svg>
                            Buku Besar Piutang
                        </a>
                        <a href="#">
                            <svg class="icon"><use href="#ic-doc"/></svg>
                            Ekspor CSV
                        </a>
                        <a href="#">
                            <svg class="icon"><use href="#ic-doc"/></svg>
                            Cetak
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- MODAL DELETE -->
    <div class="ar-modal-overlay" id="deleteModal">
        <div class="ar-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Faktur?</h3>
            <p>
                Anda yakin ingin menghapus faktur
                <br>
                <span class="invoice-number" id="deleteInvoiceNumber">INV-XXXX</span>
            </p>
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="ar-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <path d="M3 6h18"/>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                        </svg>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id, invoiceNumber) {
            document.getElementById('deleteInvoiceNumber').textContent = invoiceNumber;
            // Buat URL dengan placeholder :id
            var url = '{{ route("invoices.destroy", ":id") }}';
            url = url.replace(':id', id);
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Ripple effect untuk button
            document.querySelectorAll('.ar-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // Donut chart animation
            document.querySelectorAll('.ar-donut circle').forEach(circle => {
                if (circle.getAttribute('stroke') !== 'var(--bg-card-active)') {
                    const offset = circle.getAttribute('stroke-dashoffset');
                    circle.style.strokeDashoffset = '100%';
                    setTimeout(() => {
                        circle.style.strokeDashoffset = offset;
                    }, 300);
                }
            });
        });
    </script>

</x-app-layout>