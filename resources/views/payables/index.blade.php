<x-app-layout>
    <x-slot name="title">Utang Usaha (AP)</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $payablesCollection = collect($payables);
        $statusLabel = ['lancar' => 'Lancar', 'jatuh_tempo' => 'Jatuh Tempo', 'lunas' => 'Lunas'];
        $statusPill = ['lancar' => 'lancar', 'jatuh_tempo' => 'jatuh_tempo', 'lunas' => 'lunas'];

        $totalUtang = $payablesCollection->whereIn('status', ['lancar', 'jatuh_tempo'])->sum('amount');
        $totalJatuhTempo = $payablesCollection->where('status', 'jatuh_tempo')->sum('amount');
        $totalLancar = $payablesCollection->where('status', 'lancar')->sum('amount');
        $totalLunas = $payablesCollection->where('status', 'lunas')->sum('amount');
        $countJatuhTempo = $payablesCollection->where('status', 'jatuh_tempo')->count();
        $countLancar = $payablesCollection->where('status', 'lancar')->count();
        $countLunas = $payablesCollection->where('status', 'lunas')->count();

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
        .ap-modern {
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
        }

        .ap-modern * {
            box-sizing: border-box;
        }

        .ap-modern .mono {
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

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-10px) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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

        .ap-modern .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .ap-modern .icon {
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

        .ap-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ap-header-left {
            flex: 1;
            min-width: 200px;
        }

        .ap-badge {
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

        .ap-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ap-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ap-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ap-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .ap-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ap-btn {
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

        .ap-btn .icon {
            width: 16px;
            height: 16px;
        }

        .ap-btn:hover {
            transform: translateY(-2px);
        }

        .ap-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .ap-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ap-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ap-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ap-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ap-btn .ripple {
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

        .ap-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .ap-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 22px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .ap-stat-card::before {
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

        .ap-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .ap-stat-card:hover::before {
            opacity: 1;
        }

        .ap-stat-card .stat-label {
            font-size: 11.5px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ap-stat-card .stat-label .icon {
            width: 14px;
            height: 14px;
        }

        .ap-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .ap-stat-card .stat-value.primary {
            color: var(--theme-primary);
        }

        .ap-stat-card .stat-value.danger {
            color: var(--danger);
        }

        .ap-stat-card .stat-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        .ap-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 20px;
            align-items: start;
        }

        .ap-sidebar {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: border-color 0.22s ease;
            position: sticky;
            top: 80px;
        }

        .ap-sidebar:hover {
            border-color: var(--border-hover);
        }

        .ap-sidebar .section-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .ap-donut-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .ap-donut {
            width: 160px;
            height: 160px;
            position: relative;
            flex-shrink: 0;
            margin-bottom: 16px;
        }

        .ap-donut svg {
            transform: rotate(-90deg);
            width: 100%;
            height: 100%;
        }

        .ap-donut circle {
            fill: none;
            stroke-width: 16;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .ap-donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .ap-donut-center .total {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .ap-donut-center .label {
            font-size: 10px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }

        .ap-legend {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        .ap-legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            transition: background 0.2s ease;
        }

        .ap-legend-item:hover {
            background: var(--bg-card-hover);
        }

        .ap-legend-item .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .ap-legend-item .dot.lancar {
            background: var(--theme-primary);
        }

        .ap-legend-item .dot.jatuh_tempo {
            background: var(--danger);
        }

        .ap-legend-item .dot.lunas {
            background: var(--text-tertiary);
        }

        .ap-legend-item .label {
            flex: 1;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .ap-legend-item .value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .ap-legend-item .count {
            font-size: 11px;
            color: var(--text-tertiary);
            padding: 2px 8px;
            border-radius: 100px;
            background: var(--bg-card-active);
        }

        .ap-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 16px 0;
        }

        .ap-alert {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--danger);
        }

        .ap-alert .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .ap-alert .message {
            font-size: 13px;
            font-weight: 500;
        }

        .ap-alert .message strong {
            font-weight: 700;
        }

        .ap-alert.success {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
            color: var(--theme-primary);
        }

        .ap-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ap-item {
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

        .ap-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ap-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .ap-item:hover::before {
            opacity: 1;
        }

        .ap-item.status-lancar::before {
            background: var(--theme-primary);
        }

        .ap-item.status-jatuh_tempo::before {
            background: var(--danger);
        }

        .ap-item.status-lunas::before {
            background: var(--text-tertiary);
        }

        .ap-avatar {
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

        .ap-avatar .icon {
            width: 20px;
            height: 20px;
        }

        .ap-item-info {
            flex: 1;
            min-width: 0;
        }

        .ap-item-vendor {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ap-item-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 4px;
            font-size: 12px;
            color: var(--text-tertiary);
            flex-wrap: wrap;
        }

        .ap-item-meta .bill {
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-secondary);
        }

        .ap-item-meta .separator {
            color: var(--border-color);
        }

        .ap-item-meta .due-date {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ap-item-meta .due-date .icon {
            width: 12px;
            height: 12px;
        }

        .ap-item-meta .due-date.overdue {
            color: var(--danger);
        }

        .ap-item-right {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .ap-item-amount {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            min-width: 90px;
            text-align: right;
            cursor: default;
        }

        .ap-status-pill {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
            display: inline-block;
            white-space: nowrap;
        }

        .ap-status-pill.lancar {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .ap-status-pill.jatuh_tempo {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .ap-status-pill.lunas {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }

        .ap-actions {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
            overflow: hidden;
            max-width: 0;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            visibility: hidden;
        }

        .ap-actions.active {
            max-width: 200px;
            opacity: 1;
            visibility: visible;
            animation: slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .ap-actions .btn-action {
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
            flex-shrink: 0;
        }

        .ap-actions .btn-action .icon {
            width: 15px;
            height: 15px;
        }

        .ap-actions .btn-action.show {
            color: var(--theme-primary);
        }

        .ap-actions .btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .ap-actions .btn-action.edit {
            color: #4FA6E8;
        }

        .ap-actions .btn-action.edit:hover {
            background: rgba(79, 166, 232, 0.12);
            border-color: #4FA6E8;
        }

        .ap-actions .btn-action.danger {
            color: var(--danger);
        }

        .ap-actions .btn-action.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        .ap-toggle-actions {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -2px;
            line-height: 1;
            user-select: none;
        }

        .ap-toggle-actions:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ap-toggle-actions.active {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
            color: var(--theme-primary);
        }

        .ap-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .ap-footer .info {
            font-size: 13px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ap-footer .info .icon {
            width: 14px;
            height: 14px;
            color: var(--theme-primary);
        }

        .ap-footer .actions {
            display: flex;
            gap: 12px;
        }

        .ap-footer .actions a {
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

        .ap-footer .actions a .icon {
            width: 14px;
            height: 14px;
            color: var(--theme-primary);
        }

        .ap-footer .actions a:hover {
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .ap-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .ap-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .ap-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .ap-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        .ap-modal-overlay {
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
        .ap-modal-overlay.active {
            display: flex;
        }
        .ap-modal-box {
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
        [data-theme="light"] .ap-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }
        .ap-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .ap-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .ap-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .ap-modal-box .bill-number {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .ap-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .ap-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        .ap-modal-actions .btn {
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
        .ap-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }
        .ap-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        .ap-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }
        .ap-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .ap-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        @media (max-width: 1200px) {
            .ap-stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .ap-layout {
                grid-template-columns: 1fr;
            }
            .ap-sidebar {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                position: static;
            }
            .ap-donut-wrap {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .ap-item {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 640px) {
            .ap-header {
                flex-direction: column;
            }
            .ap-header-actions {
                width: 100%;
            }
            .ap-header-actions .ap-btn {
                flex: 1;
                justify-content: center;
            }
            .ap-stats-row {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            .ap-stat-card .stat-value {
                font-size: 20px;
            }
            .ap-sidebar {
                grid-template-columns: 1fr;
            }
            .ap-item {
                flex-wrap: wrap;
                padding: 14px 16px;
                gap: 12px;
            }
            .ap-item-right {
                width: 100%;
                justify-content: space-between;
                margin-left: 60px;
            }
            .ap-item-amount {
                min-width: auto;
                font-size: 14px;
            }
            .ap-item-meta {
                font-size: 11px;
                gap: 8px;
            }
            .ap-actions {
                margin-left: 60px;
            }
            .ap-actions.active {
                max-width: 100%;
                width: 100%;
                justify-content: flex-start;
            }
            .ap-footer {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
                gap: 12px;
            }
            .ap-footer .actions {
                justify-content: center;
                flex-wrap: wrap;
            }
            .ap-avatar {
                width: 36px;
                height: 36px;
                font-size: 13px;
            }
            .ap-donut {
                width: 130px;
                height: 130px;
            }
            .ap-donut-center .total {
                font-size: 16px;
            }
            .ap-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }
            .ap-modal-actions {
                flex-direction: column;
            }
            .ap-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 380px) {
            .ap-header h1 {
                font-size: 22px;
            }
            .ap-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .ap-btn .icon {
                width: 14px;
                height: 14px;
            }
            .ap-stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="ap-modern">

        <!-- HEADER -->
        <div class="ap-header animate-in" style="animation-delay: 0.05s;">
            <div class="ap-header-left">
                <div class="ap-badge">
                    <span class="dot"></span>
                    Piutang &amp; Utang
                </div>
                <h1>Utang Usaha (AP)</h1>
                <p class="subtitle">
                    Daftar tagihan dari supplier/vendor yang belum dibayar —
                    <strong>{{ $payablesCollection->count() }}</strong> tagihan aktif
                </p>
            </div>
            <div class="ap-header-actions">
                <a href="{{ route('aging.index') }}" class="ap-btn ap-btn-ghost">
                    <svg class="icon"><use href="#ic-trending"/></svg>
                    Aging Report
                </a>
                <a href="{{ route('payables.create') }}" class="ap-btn ap-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tagihan Baru
                </a>
            </div>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
        <div class="ap-alert success" style="border-color:var(--success);color:var(--success);background:var(--success-soft);">
            <svg class="icon"><use href="#ic-shield"/></svg>
            <span class="message">{{ session('success') }}</span>
        </div>
        @endif

        <!-- STATS -->
        <div class="ap-stats-row">
            <div class="ap-stat-card animate-in" style="animation-delay: 0.10s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-building"/></svg>
                    Total Utang
                </div>
                <div class="stat-value primary mono" title="{{ formatLengkap($totalUtang, $currencySymbol) }}">
                    {{ formatSingkat($totalUtang, $currencySymbol) }}
                </div>
                <div class="stat-sub">{{ $countLancar + $countJatuhTempo }} tagihan belum dibayar</div>
            </div>

            <div class="ap-stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-trending"/></svg>
                    Lancar
                </div>
                <div class="stat-value mono" title="{{ formatLengkap($totalLancar, $currencySymbol) }}">
                    {{ formatSingkat($totalLancar, $currencySymbol) }}
                </div>
                <div class="stat-sub">{{ $countLancar }} tagihan dalam masa tenggang</div>
            </div>

            <div class="ap-stat-card animate-in" style="animation-delay: 0.20s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-trending-down"/></svg>
                    Jatuh Tempo
                </div>
                <div class="stat-value danger mono" title="{{ formatLengkap($totalJatuhTempo, $currencySymbol) }}">
                    {{ formatSingkat($totalJatuhTempo, $currencySymbol) }}
                </div>
                <div class="stat-sub">{{ $countJatuhTempo }} tagihan perlu dibayar</div>
            </div>

            <div class="ap-stat-card animate-in" style="animation-delay: 0.25s;">
                <div class="stat-label">
                    <svg class="icon"><use href="#ic-shield"/></svg>
                    Rasio Utang
                </div>
                <div class="stat-value mono">
                    {{ $totalUtang > 0 ? round(($totalLancar / $totalUtang) * 100) : 0 }}%
                </div>
                <div class="stat-sub">utang dalam kondisi lancar</div>
            </div>
        </div>

        <!-- LAYOUT -->
        <div class="ap-layout">

            <!-- SIDEBAR -->
            <aside class="ap-sidebar animate-in" style="animation-delay: 0.30s;">
                <div class="section-title">Ringkasan Utang</div>

                <div class="ap-donut-wrap">
                    <div class="ap-donut">
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
                        <div class="ap-donut-center">
                            <span class="total mono" title="{{ formatLengkap($totalUtang, $currencySymbol) }}">
                                {{ formatSingkat($totalUtang, $currencySymbol) }}
                            </span>
                            <span class="label">Total Utang</span>
                        </div>
                    </div>
                </div>

                <div class="ap-legend">
                    @foreach($chartData as $key => $data)
                    <div class="ap-legend-item">
                        <span class="dot {{ $key }}"></span>
                        <span class="label">{{ $data['label'] }}</span>
                        <span class="count">{{ $key === 'lancar' ? $countLancar : ($key === 'jatuh_tempo' ? $countJatuhTempo : $countLunas) }} tagihan</span>
                        <span class="value mono" title="{{ formatLengkap($data['value'], $currencySymbol) }}">
                            {{ formatSingkat($data['value'], $currencySymbol) }}
                        </span>
                    </div>
                    @endforeach
                </div>

                <hr class="ap-divider">

                @if($countJatuhTempo > 0)
                <div class="ap-alert">
                    <svg class="icon"><use href="#ic-trending-down"/></svg>
                    <span class="message">
                        <strong>{{ $countJatuhTempo }} tagihan</strong> telah jatuh tempo!
                        Segera lakukan pembayaran.
                    </span>
                </div>
                @else
                <div class="ap-alert success">
                    <svg class="icon"><use href="#ic-shield"/></svg>
                    <span class="message">
                        Semua utang dalam kondisi <strong>lancar</strong>.
                    </span>
                </div>
                @endif
            </aside>

            <!-- LIST -->
            <div>
                <div class="ap-list">
                    @forelse($payables as $index => $p)
                    @php
                    $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                    $color = $colors[($index + $loop->iteration) % count($colors)];
                    $isOverdue = isOverdue($p['due'], $p['status']);
                    $itemId = 'ap-item-' . $index;
                    @endphp
                    <div class="ap-item status-{{ $statusPill[$p['status']] }} animate-in"
                         style="animation-delay: {{ 0.35 + ($index * 0.05) }}s;"
                         data-item="{{ $itemId }}">

                        <div class="ap-avatar" style="background: {{ $color }}; color:#fff;">
                            @if($p['status'] === 'lunas')
                            <svg class="icon"><use href="#ic-shield"/></svg>
                            @else
                            {{ mb_substr($p['vendor'], 0, 1) }}
                            @endif
                        </div>

                        <div class="ap-item-info">
                            <div class="ap-item-vendor">{{ $p['vendor'] }}</div>
                            <div class="ap-item-meta">
                                <span class="bill mono">{{ $p['bill'] }}</span>
                                <span class="separator">•</span>
                                <span>{{ formatTanggal($p['date']) }}</span>
                                <span class="separator">•</span>
                                <span class="due-date {{ $isOverdue ? 'overdue' : '' }}">
                                    <svg class="icon"><use href="#ic-clock"/></svg>
                                    Jatuh tempo {{ formatTanggal($p['due']) }}
                                    @if($isOverdue)
                                    <span style="color: var(--danger);">(Lewat)</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="ap-item-right">
                            <span class="ap-status-pill {{ $statusPill[$p['status']] }}">
                                {{ $statusLabel[$p['status']] }}
                            </span>
                            <span class="ap-item-amount mono" title="{{ formatLengkap($p['amount'], $currencySymbol) }}">
                                {{ formatSingkat($p['amount'], $currencySymbol) }}
                            </span>
                        </div>

                        <!-- Toggle button -->
                        <div class="ap-toggle-actions" data-target="{{ $itemId }}" title="Aksi">
                            ⋮
                        </div>

                        <!-- Actions -->
                        <div class="ap-actions" id="{{ $itemId }}">
                            <!-- Tombol Show - URL MANUAL -->
                            <a href="/payables/{{ $index }}" class="btn-action show" title="Lihat Detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <!-- Tombol Edit - URL MANUAL -->
                            <a href="/payables/{{ $index }}/edit" class="btn-action edit" title="Edit Tagihan">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                    <path d="M15 5l4 4"/>
                                </svg>
                            </a>
                            <!-- Tombol Delete -->
                            <button type="button" class="btn-action danger" title="Hapus Tagihan"
                                    onclick="openDeleteModal('{{ $index }}', '{{ $p['bill'] }}')">
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
                    <div class="ap-empty animate-in" style="animation-delay: 0.35s;">
                        <svg class="empty-icon"><use href="#ic-building"/></svg>
                        <h3>Belum Ada Utang</h3>
                        <p>Belum ada tagihan dari supplier yang tercatat di sistem.</p>
                        <a href="{{ route('payables.create') }}" class="ap-btn ap-btn-primary" style="display: inline-flex;">
                            <svg class="icon"><use href="#ic-plus"/></svg>
                            Buat Tagihan Pertama
                        </a>
                    </div>
                    @endforelse
                </div>

                <div class="ap-footer animate-in" style="animation-delay: 0.40s;">
                    <div class="info">
                        <svg class="icon"><use href="#ic-building"/></svg>
                        Total {{ $payablesCollection->count() }} tagihan terdaftar
                    </div>
                    <div class="actions">
                        <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}">
                            <svg class="icon"><use href="#ic-doc"/></svg>
                            Buku Besar Utang
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
    <div class="ap-modal-overlay" id="deleteModal">
        <div class="ap-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Tagihan?</h3>
            <p>
                Anda yakin ingin menghapus tagihan
                <br>
                <span class="bill-number" id="deleteBillNumber">BILL-XXXX</span>
            </p>
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="ap-modal-actions">
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
        function openDeleteModal(id, billNumber) {
            document.getElementById('deleteBillNumber').textContent = billNumber;
            var url = '/payables/' + id;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
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
            // Toggle actions
            const toggleButtons = document.querySelectorAll('.ap-toggle-actions');

            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const targetId = this.dataset.target;
                    const actions = document.getElementById(targetId);

                    if (actions) {
                        document.querySelectorAll('.ap-actions.active').forEach(el => {
                            if (el.id !== targetId) {
                                el.classList.remove('active');
                                el.style.maxWidth = '0';
                                el.style.opacity = '0';
                                el.style.visibility = 'hidden';
                                const toggleBtn = document.querySelector(
                                    `.ap-toggle-actions[data-target="${el.id}"]`);
                                if (toggleBtn) {
                                    toggleBtn.classList.remove('active');
                                }
                            }
                        });

                        const isActive = actions.classList.contains('active');
                        if (isActive) {
                            actions.classList.remove('active');
                            actions.style.maxWidth = '0';
                            actions.style.opacity = '0';
                            actions.style.visibility = 'hidden';
                            this.classList.remove('active');
                        } else {
                            actions.classList.add('active');
                            actions.style.maxWidth = actions.scrollWidth + 'px';
                            actions.style.opacity = '1';
                            actions.style.visibility = 'visible';
                            this.classList.add('active');
                        }
                    }
                });
            });

            // Close actions when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.ap-item')) {
                    document.querySelectorAll('.ap-actions.active').forEach(el => {
                        el.classList.remove('active');
                        el.style.maxWidth = '0';
                        el.style.opacity = '0';
                        el.style.visibility = 'hidden';
                        const toggleBtn = document.querySelector(
                            `.ap-toggle-actions[data-target="${el.id}"]`);
                        if (toggleBtn) {
                            toggleBtn.classList.remove('active');
                        }
                    });
                }
            });

            // Ripple effect
            document.querySelectorAll('.ap-btn').forEach(btn => {
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
            document.querySelectorAll('.ap-donut circle').forEach(circle => {
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