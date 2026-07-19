<x-app-layout>
    <x-slot name="title">Aging Report</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // DUMMY - ganti dengan query aging Receivable/Payable model nanti
        $arRows = [
            ['name' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'current' => 5750000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
            ['name' => 'Nusantara Logistik',      'invoice' => '#0571', 'current' => 18400000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
            ['name' => 'Bumi Retail Group',       'invoice' => '#0552', 'current' => 0, 'd30' => 9200000, 'd60' => 0, 'd90' => 0],
            ['name' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'current' => 0, 'd30' => 2800000, 'd60' => 0, 'd90' => 0],
            ['name' => 'Toko Elektronik Jaya',    'invoice' => '#0498', 'current' => 0, 'd30' => 0, 'd60' => 6100000, 'd90' => 0],
            ['name' => 'CV Bangun Perkasa',       'invoice' => '#0421', 'current' => 0, 'd30' => 0, 'd60' => 0, 'd90' => 3400000],
        ];

        $apRows = [
            ['name' => 'Toko Bangunan Sentosa',   'invoice' => '#B-0112', 'current' => 12500000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
            ['name' => 'CV Kertas Nusantara',     'invoice' => '#B-0119', 'current' => 3200000, 'd30' => 0, 'd60' => 0, 'd90' => 0],
            ['name' => 'PLN — Listrik Kantor',    'invoice' => '#B-0125', 'current' => 0, 'd30' => 4100000, 'd60' => 0, 'd90' => 0],
            ['name' => 'Distributor Kain Batik',  'invoice' => '#B-0103', 'current' => 0, 'd30' => 21400000, 'd60' => 0, 'd90' => 0],
        ];

        $sumBucket = fn($rows, $key) => collect($rows)->sum($key);
        $totalAr = $sumBucket($arRows,'current') + $sumBucket($arRows,'d30') + $sumBucket($arRows,'d60') + $sumBucket($arRows,'d90');
        $totalAp = $sumBucket($apRows,'current') + $sumBucket($apRows,'d30') + $sumBucket($apRows,'d60') + $sumBucket($apRows,'d90');

        $buckets = [
            ['key' => 'current', 'label' => 'Lancar', 'short' => '0 hari', 'color' => 'var(--theme-primary)'],
            ['key' => 'd30',     'label' => '1–30 Hari', 'short' => '1–30', 'color' => '#F0A25A'],
            ['key' => 'd60',     'label' => '31–60 Hari', 'short' => '31–60', 'color' => '#E8804A'],
            ['key' => 'd90',     'label' => '61–90+ Hari', 'short' => '61–90+', 'color' => 'var(--danger)'],
        ];
    @endphp

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

        /* ----- MODAL DELETE ----- */
        .aging-modal-overlay {
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
        .aging-modal-overlay.active {
            display: flex;
        }
        .aging-modal-box {
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
        [data-theme="light"] .aging-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }
        .aging-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .aging-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .aging-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .aging-modal-box .invoice-number {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .aging-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
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
            background: var(--danger);
            color: #fff;
        }
        .aging-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
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
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== TABS ===== -->
        <div class="aging-tabs animate-in" style="animation-delay: 0.10s;" id="agingTabs">
            <button class="aging-tab active" data-tab="ar">
                Piutang (AR)
                <span class="count">({{ count($arRows) }})</span>
            </button>
            <button class="aging-tab" data-tab="ap">
                Utang (AP)
                <span class="count">({{ count($apRows) }})</span>
            </button>
        </div>

        <!-- ===== PANEL AR ===== -->
        <div class="aging-panel active" data-panel="ar">
            <!-- Summary -->
            <div class="aging-summary animate-in" style="animation-delay: 0.15s;">
                <div class="aging-summary-top">
                    <div>
                        <div class="aging-summary-label">Total Piutang Berdasarkan Umur</div>
                        <div class="aging-summary-value mono">{{ $currencySymbol }}{{ number_format($totalAr, 0, ',', '.') }}</div>
                    </div>
                    <div class="aging-summary-stats">
                        <div class="aging-summary-stat">
                            <div class="label">Jatuh Tempo</div>
                            <div class="value danger mono">{{ $currencySymbol }}{{ number_format($sumBucket($arRows,'d30') + $sumBucket($arRows,'d60') + $sumBucket($arRows,'d90'), 0, ',', '.') }}</div>
                        </div>
                        <div class="aging-summary-stat">
                            <div class="label">Rata-rata Umur</div>
                            <div class="value mono">{{ $totalAr > 0 ? round((($sumBucket($arRows,'d30') * 15) + ($sumBucket($arRows,'d60') * 45) + ($sumBucket($arRows,'d90') * 75)) / $totalAr) : 0 }} hari</div>
                        </div>
                    </div>
                </div>

                <div class="aging-bar">
                    @foreach($buckets as $b)
                        <div class="aging-seg" style="width: {{ $totalAr > 0 ? round($sumBucket($arRows, $b['key']) / $totalAr * 100, 2) : 0 }}%; background: {{ $b['color'] }}"></div>
                    @endforeach
                </div>

                <div class="aging-legend">
                    @foreach($buckets as $b)
                        <div class="aging-legend-item">
                            <span class="dot" style="background: {{ $b['color'] }}"></span>
                            <span class="label">{{ $b['label'] }}</span>
                            <span class="amount mono">{{ $currencySymbol }}{{ number_format($sumBucket($arRows, $b['key']), 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- List -->
            <div class="aging-list">
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
                            <div class="aging-item-total mono">{{ $currencySymbol }}{{ number_format($rowTotal, 0, ',', '.') }}</div>
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
                                        <span class="amount mono">{{ $currencySymbol }}{{ number_format($row[$b['key']], 0, ',', '.') }}</span>
                                    </span>
                                @endif
                            @endforeach
                            @if($rowTotal == 0)
                                <span class="aging-chip" style="color: var(--text-tertiary);">Tidak ada saldo</span>
                            @endif
                        </div>

                        <!-- ===== ACTIONS DI BAWAH ===== -->
                        <div class="aging-item-actions">
                            <a href="/aging/show/{{ $index }}?type=ar" class="btn-action show" title="Lihat Detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <button type="button" class="btn-action danger" title="Hapus"
                                    onclick="openDeleteModal('ar', '{{ $index }}', '{{ $row['invoice'] }}')">
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
                    <div class="aging-empty">
                        <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        <h3>Belum Ada Data Piutang</h3>
                        <p>Belum ada piutang yang tercatat di sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ===== PANEL AP ===== -->
        <div class="aging-panel" data-panel="ap">
            <!-- Summary -->
            <div class="aging-summary animate-in" style="animation-delay: 0.15s;">
                <div class="aging-summary-top">
                    <div>
                        <div class="aging-summary-label">Total Utang Berdasarkan Umur</div>
                        <div class="aging-summary-value mono">{{ $currencySymbol }}{{ number_format($totalAp, 0, ',', '.') }}</div>
                    </div>
                    <div class="aging-summary-stats">
                        <div class="aging-summary-stat">
                            <div class="label">Jatuh Tempo</div>
                            <div class="value danger mono">{{ $currencySymbol }}{{ number_format($sumBucket($apRows,'d30') + $sumBucket($apRows,'d60') + $sumBucket($apRows,'d90'), 0, ',', '.') }}</div>
                        </div>
                        <div class="aging-summary-stat">
                            <div class="label">Rata-rata Umur</div>
                            <div class="value mono">{{ $totalAp > 0 ? round((($sumBucket($apRows,'d30') * 15) + ($sumBucket($apRows,'d60') * 45) + ($sumBucket($apRows,'d90') * 75)) / $totalAp) : 0 }} hari</div>
                        </div>
                    </div>
                </div>

                <div class="aging-bar">
                    @foreach($buckets as $b)
                        <div class="aging-seg" style="width: {{ $totalAp > 0 ? round($sumBucket($apRows, $b['key']) / $totalAp * 100, 2) : 0 }}%; background: {{ $b['color'] }}"></div>
                    @endforeach
                </div>

                <div class="aging-legend">
                    @foreach($buckets as $b)
                        <div class="aging-legend-item">
                            <span class="dot" style="background: {{ $b['color'] }}"></span>
                            <span class="label">{{ $b['label'] }}</span>
                            <span class="amount mono">{{ $currencySymbol }}{{ number_format($sumBucket($apRows, $b['key']), 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- List -->
            <div class="aging-list">
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
                            <div class="aging-item-total mono">{{ $currencySymbol }}{{ number_format($rowTotal, 0, ',', '.') }}</div>
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
                                        <span class="amount mono">{{ $currencySymbol }}{{ number_format($row[$b['key']], 0, ',', '.') }}</span>
                                    </span>
                                @endif
                            @endforeach
                            @if($rowTotal == 0)
                                <span class="aging-chip" style="color: var(--text-tertiary);">Tidak ada saldo</span>
                            @endif
                        </div>

                        <!-- ===== ACTIONS DI BAWAH ===== -->
                        <div class="aging-item-actions">
                            <a href="/aging/show/{{ $index }}?type=ap" class="btn-action show" title="Lihat Detail">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <button type="button" class="btn-action danger" title="Hapus"
                                    onclick="openDeleteModal('ap', '{{ $index }}', '{{ $row['invoice'] }}')">
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
                    <div class="aging-empty">
                        <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        <h3>Belum Ada Data Utang</h3>
                        <p>Belum ada utang yang tercatat di sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="aging-modal-overlay" id="deleteModal">
        <div class="aging-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Data?</h3>
            <p>
                Anda yakin ingin menghapus data
                <br>
                <span class="invoice-number" id="deleteInvoiceNumber">INV-XXXX</span>
            </p>
            <div class="warning-text">
                Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="aging-modal-actions">
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
        function openDeleteModal(type, index, invoiceNumber) {
            document.getElementById('deleteInvoiceNumber').textContent = invoiceNumber;
            var url = '/aging/delete/' + index + '?type=' + type;
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