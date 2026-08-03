<x-admin-layout>
    <x-slot name="title">Support / Tiket</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-help" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-message" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-alert-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .tiw {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .tiw * { box-sizing:border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .tiw .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .tiw .icon {
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

        /* ===== HEADER ===== */
        .tiw-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .tiw-header-left {
            flex: 1;
            min-width: 200px;
        }

        .tiw-badge {
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

        .tiw-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .tiw-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .tiw-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .tiw-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .tiw-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .tiw-btn {
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

        .tiw-btn .icon {
            width: 16px;
            height: 16px;
        }

        .tiw-btn:hover {
            transform: translateY(-2px);
        }

        .tiw-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .tiw-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .tiw-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .tiw-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        /* ===== ALERT SUCCESS ===== */
        .alert-success {
            background: rgba(var(--emerald-rgb), 0.1);
            border: 1px solid rgba(var(--emerald-rgb), 0.3);
            color: var(--emerald);
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* ===== STAT CARDS (bukan pills) ===== */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, currentColor, transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }

        .stat-card:hover::before {
            opacity: 0.6;
        }

        .stat-card.active {
            border-color: var(--theme-primary);
            background: var(--theme-soft);
        }

        .stat-card.active::before {
            opacity: 1;
        }

        .stat-card .sk {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-card .sk-label {
            font-size: 11.5px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 600;
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.05) rotate(-3deg);
        }

        .stat-icon .icon {
            width: 16px;
            height: 16px;
        }

        .stat-card.c-emerald { color: var(--emerald); }
        .stat-card.c-emerald .stat-icon { background: rgba(var(--emerald-rgb), 0.14); color: var(--emerald); }
        .stat-card.c-danger { color: var(--danger); }
        .stat-card.c-danger .stat-icon { background: rgba(232, 90, 90, 0.14); color: var(--danger); }
        .stat-card.c-warning { color: #F0A25A; }
        .stat-card.c-warning .stat-icon { background: rgba(240, 162, 90, 0.14); color: #F0A25A; }
        .stat-card.c-neutral { color: var(--text-mute); }
        .stat-card.c-neutral .stat-icon { background: var(--surface-strong); color: var(--text-mute); }

        .stat-card .sv {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .stat-card .sc {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* ===== FILTER BAR ===== */
        .tiw-filter {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: var(--bg-card);
            padding: 16px 20px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .tiw-filter:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .tiw-filter form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-wrap .icon {
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

        .search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .tiw-filter input[type=text] {
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

        .tiw-filter input[type=text]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .tiw-filter input[type=text]::placeholder {
            color: var(--text-tertiary);
        }

        .tiw-filter select {
            padding: 10px 32px 10px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .tiw-filter select:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .tiw-filter select option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .btn-sm {
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
            font-family: inherit;
        }

        .btn-sm:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .btn-sm-primary {
            background: var(--theme-gradient);
            color: #fff;
            border-color: transparent;
        }

        .btn-sm-primary:hover {
            box-shadow: 0 4px 16px var(--theme-glow);
            color: #fff;
        }

        /* ===== INBOX LIST ===== */
        .inbox-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .inbox-row {
            display: flex;
            align-items: center;
            gap: 16px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .inbox-row::before {
            content: '';
            position: absolute;
            left: 0;
            top: 14px;
            bottom: 14px;
            width: 4px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .inbox-row:hover::before {
            opacity: 1;
        }

        .inbox-row:hover {
            transform: translateX(4px);
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .inbox-row.pri-high::before {
            background: var(--danger);
        }

        .inbox-row.pri-medium::before {
            background: #F0A25A;
        }

        .inbox-row.pri-low::before {
            background: var(--text-tertiary);
        }

        .inbox-ic {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .inbox-ic .icon {
            width: 20px;
            height: 20px;
        }

        .inbox-row.st-open .inbox-ic {
            background: rgba(232, 90, 90, 0.12);
            color: var(--danger);
        }

        .inbox-row.st-in_progress .inbox-ic {
            background: rgba(240, 162, 90, 0.12);
            color: #F0A25A;
        }

        .inbox-row.st-closed .inbox-ic {
            background: rgba(var(--emerald-rgb), 0.12);
            color: var(--emerald);
        }

        .inbox-body {
            flex: 1;
            min-width: 0;
        }

        .inbox-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
            flex-wrap: wrap;
        }

        .inbox-subject {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .inbox-cat {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 2px 10px;
            border-radius: 100px;
        }

        .inbox-snippet {
            font-size: 12.5px;
            color: var(--text-secondary);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 600px;
        }

        .inbox-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 6px;
            font-size: 11.5px;
            color: var(--text-tertiary);
        }

        .inbox-meta .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .inbox-meta .meta-item .icon {
            width: 12px;
            height: 12px;
        }

        .inbox-meta .dot-sep {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--text-tertiary);
        }

        .inbox-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
            flex-shrink: 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10.5px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 100px;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .status-badge .sdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-badge.open {
            background: rgba(232, 90, 90, 0.14);
            color: var(--danger);
        }

        .status-badge.open .sdot {
            background: var(--danger);
            animation: pulseGlow 1.6s ease-in-out infinite;
        }

        .status-badge.in_progress {
            background: rgba(240, 162, 90, 0.14);
            color: #F0A25A;
        }

        .status-badge.in_progress .sdot {
            background: #F0A25A;
        }

        .status-badge.closed {
            background: rgba(var(--emerald-rgb), 0.14);
            color: var(--emerald);
        }

        .status-badge.closed .sdot {
            background: var(--emerald);
        }

        .inbox-time {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 30px;
        }

        .empty-ic {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--theme-primary);
            margin: 0 auto 18px;
        }

        .empty-ic .icon {
            width: 26px;
            height: 26px;
        }

        .empty-state h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 17px;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .empty-state p {
            font-size: 13.5px;
            color: var(--text-secondary);
            max-width: 320px;
            margin: 0 auto;
        }

        .pagination-wrap {
            margin-top: 22px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .tiw {
                padding: 0 12px;
            }

            .tiw-header {
                flex-direction: column;
            }

            .tiw-header-actions {
                width: 100%;
            }

            .tiw-header-actions .tiw-btn {
                flex: 1;
                justify-content: center;
            }

            .tiw-header h1 {
                font-size: 24px;
            }

            .stat-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .stat-card .sv {
                font-size: 20px;
            }

            .tiw-filter form {
                flex-direction: column;
            }

            .search-wrap {
                min-width: 100%;
            }

            .tiw-filter select {
                width: 100%;
            }

            .inbox-row {
                flex-wrap: wrap;
                padding: 16px 18px;
            }

            .inbox-snippet {
                max-width: 200px;
            }

            .inbox-right {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding-top: 8px;
                border-top: 1px solid var(--border-color);
            }

            .inbox-meta {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 480px) {
            .tiw-header h1 {
                font-size: 20px;
            }

            .tiw-header p {
                font-size: 13px;
            }

            .stat-row {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 16px 18px;
            }

            .stat-card .sv {
                font-size: 18px;
            }

            .stat-card .sk-label {
                font-size: 10px;
            }

            .inbox-row {
                padding: 14px 16px;
            }

            .inbox-subject {
                font-size: 13px;
            }

            .inbox-snippet {
                font-size: 11.5px;
                max-width: 150px;
            }

            .inbox-meta {
                font-size: 10.5px;
                gap: 6px;
            }

            .status-badge {
                font-size: 9.5px;
                padding: 3px 10px;
            }

            .inbox-time {
                font-size: 10px;
            }
        }

        @media (max-width: 380px) {
            .tiw-header h1 {
                font-size: 18px;
            }

            .tiw-btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .tiw-btn .icon {
                width: 14px;
                height: 14px;
            }

            .stat-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="tiw">

        <!-- ===== HEADER ===== -->
        <div class="tiw-header animate-in" style="animation-delay: 0.03s;">
            <div class="tiw-header-left">
                <div class="tiw-badge">
                    <span class="dot"></span>
                    Dukungan
                </div>
                <h1><span class="highlight">Support / Tiket</span></h1>
                <p>Kelola permintaan bantuan dari user dan company yang terdaftar.</p>
            </div>
            <div class="tiw-header-actions">
                <a href="{{ route('admin.tickets.index') }}" class="tiw-btn tiw-btn-primary">
                    <svg class="icon"><use href="#ic-help"/></svg>
                    Refresh
                </a>
            </div>
        </div>

        <!-- ===== ALERT SUCCESS ===== -->
        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay: 0.05s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- ===== STAT CARDS ===== -->
        <div class="stat-row animate-in" style="animation-delay: 0.06s;">
            <a href="{{ route('admin.tickets.index') }}" class="stat-card c-neutral {{ !request('status') ? 'active' : '' }}">
                <div class="sk">
                    <span class="sk-label">Semua Tiket</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-inbox"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total'] }}</div>
                <div class="sc">Total tiket</div>
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="stat-card c-danger {{ request('status')==='open' ? 'active' : '' }}">
                <div class="sk">
                    <span class="sk-label">Terbuka</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-alert-circle"/></svg></span>
                </div>
                <div class="sv">{{ $stats['open'] }}</div>
                <div class="sc">Perlu ditangani</div>
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}" class="stat-card c-warning {{ request('status')==='in_progress' ? 'active' : '' }}">
                <div class="sk">
                    <span class="sk-label">Diproses</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-clock"/></svg></span>
                </div>
                <div class="sv">{{ $stats['in_progress'] }}</div>
                <div class="sc">Sedang dikerjakan</div>
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="stat-card c-emerald {{ request('status')==='closed' ? 'active' : '' }}">
                <div class="sk">
                    <span class="sk-label">Selesai</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-check-circle"/></svg></span>
                </div>
                <div class="sv">{{ $stats['closed'] }}</div>
                <div class="sc">Tiket selesai</div>
            </a>
        </div>

        <!-- ===== FILTER BAR ===== -->
        <div class="tiw-filter animate-in" style="animation-delay: 0.09s;">
            <form method="GET" action="{{ route('admin.tickets.index') }}">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari subjek tiket...">
                </div>
                <input type="hidden" name="status" value="{{ request('status') }}">
                <select name="priority" onchange="this.form.submit()">
                    <option value="">Semua Prioritas</option>
                    <option value="high" {{ request('priority')==='high' ? 'selected':'' }}>Tinggi</option>
                    <option value="medium" {{ request('priority')==='medium' ? 'selected':'' }}>Sedang</option>
                    <option value="low" {{ request('priority')==='low' ? 'selected':'' }}>Rendah</option>
                </select>
                <button type="submit" class="btn-sm btn-sm-primary">Cari</button>
                @if(request()->anyFilled(['q','priority']))
                    <a href="{{ route('admin.tickets.index', ['status' => request('status')]) }}" class="btn-sm">Reset</a>
                @endif
            </form>
        </div>

        <!-- ===== INBOX LIST ===== -->
        <div class="inbox-list">
            @forelse($tickets as $i => $ticket)
                <a href="{{ route('admin.tickets.show', $ticket) }}" class="inbox-row st-{{ $ticket->status }} pri-{{ $ticket->priority }} animate-in" style="animation-delay: {{ 0.12 + ($i * 0.03) }}s;">
                    <div class="inbox-ic">
                        <svg class="icon"><use href="#ic-message"/></svg>
                    </div>
                    <div class="inbox-body">
                        <div class="inbox-top">
                            <span class="inbox-subject">{{ $ticket->subject }}</span>
                            <span class="inbox-cat">{{ $ticket->categoryLabel() }}</span>
                        </div>
                        <div class="inbox-snippet">{{ Str::limit($ticket->message, 90) }}</div>
                        <div class="inbox-meta">
                            <span class="meta-item">
                                <svg class="icon"><use href="#ic-user"/></svg>
                                {{ $ticket->user->name ?? 'User terhapus' }}
                            </span>
                            <span class="dot-sep"></span>
                            <span class="meta-item">
                                <svg class="icon"><use href="#ic-building"/></svg>
                                {{ $ticket->company->name ?? '—' }}
                            </span>
                        </div>
                    </div>
                    <div class="inbox-right">
                        <span class="status-badge {{ $ticket->status }}">
                            <span class="sdot"></span>
                            {{ $ticket->statusLabel() }}
                        </span>
                        <span class="inbox-time">{{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                    <h3>Belum ada tiket</h3>
                    <p>Tiket bantuan yang masuk akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">
            {{ $tickets->onEachSide(1)->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.tiw-btn, .btn-sm');
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
        });
    </script>
</x-admin-layout>