<x-admin-layout>
    <x-slot name="title">Kelola Company</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6M9 11h6M9 15h3"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-pause-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cmw {
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

        .cmw * { box-sizing:border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .cmw .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .cmw .icon {
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
        .toast .toast-icon.success{ background:rgba(var(--emerald-rgb),0.14); color:var(--emerald); }
        .toast .toast-icon.error{ background:rgba(232,90,90,.14); color:var(--danger); }
        .toast .toast-icon .icon{ width:18px; height:18px; }
        .toast .toast-content{ flex:1; }
        .toast .toast-title{ font-size:13px; font-weight:600; color:var(--text); }
        .toast .toast-msg{ font-size:12px; color:var(--text-mute); }
        .toast .toast-close{ background:none; border:none; color:var(--text-faint); cursor:pointer; padding:4px; }
        .toast .toast-close .icon{ width:14px; height:14px; }

        /* ===== ALERT SUCCESS ===== */
        .alert-success{ 
            background:rgba(var(--emerald-rgb),0.1); 
            border:1px solid rgba(var(--emerald-rgb),0.3); 
            color:var(--emerald); 
            padding:14px 20px; 
            border-radius:12px; 
            font-size:13.5px; 
            margin-bottom:20px; 
            display:flex; 
            align-items:center; 
            gap:10px;
        }
        .alert-success .icon{ width:18px; height:18px; flex-shrink:0; }

        /* ===== HEADER ===== */
        .cmw-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cmw-header-left {
            flex: 1;
            min-width: 200px;
        }

        .cmw-badge {
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

        .cmw-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cmw-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .cmw-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cmw-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cmw-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cmw-btn {
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

        .cmw-btn .icon {
            width: 16px;
            height: 16px;
        }

        .cmw-btn:hover {
            transform: translateY(-2px);
        }

        .cmw-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .cmw-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cmw-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cmw-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cmw-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cmw-btn .ripple {
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

        /* ===== STAT CARDS ===== */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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

        .stat-card .sk {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
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
        .stat-card.c-info { color: #4E8FF0; }
        .stat-card.c-info .stat-icon { background: rgba(78, 143, 240, 0.14); color: #4E8FF0; }
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
            margin-top: 6px;
        }

        /* ===== FILTER ===== */
        .cmw-filter {
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

        .cmw-filter:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .cmw-filter form {
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

        .cmw-filter input[type=text] {
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

        .cmw-filter input[type=text]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .cmw-filter input[type=text]::placeholder {
            color: var(--text-tertiary);
        }

        .cmw-filter select {
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

        .cmw-filter select:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .cmw-filter select option {
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
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

        .btn-sm .icon {
            width: 14px;
            height: 14px;
        }

        /* ===== CARD GRID ===== */
        .company-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 18px;
        }

        .company-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px 26px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
            overflow: hidden;
        }

        .company-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .company-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hover);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.08);
        }

        .company-card:hover::before {
            opacity: 1;
        }

        .company-card.st-active::before {
            background: var(--emerald);
        }

        .company-card.st-suspended::before {
            background: var(--danger);
        }

        .cc-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .cc-logo {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--theme-primary);
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .company-card:hover .cc-logo {
            transform: scale(1.05) rotate(-2deg);
        }

        .cc-status {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 12px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .cc-status .sdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .cc-status.active {
            background: rgba(var(--emerald-rgb), 0.14);
            color: var(--emerald);
        }

        .cc-status.active .sdot {
            background: var(--emerald);
            animation: pulseGlow 1.8s ease-in-out infinite;
        }

        .cc-status.suspended {
            background: rgba(232, 90, 90, 0.14);
            color: var(--danger);
        }

        .cc-status.suspended .sdot {
            background: var(--danger);
        }

        .cc-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--text-primary);
        }

        .cc-date {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-bottom: 18px;
        }

        .cc-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 18px;
        }

        .cc-stat {
            background: var(--bg-card-active);
            border-radius: 10px;
            padding: 10px 8px;
            text-align: center;
            transition: background 0.3s ease;
        }

        .company-card:hover .cc-stat {
            background: var(--bg-card-hover);
        }

        .cc-stat .n {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .cc-stat .l {
            font-size: 9.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .cc-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--theme-primary);
            padding-top: 16px;
            border-top: 1px dashed var(--border-color);
        }

        .cc-foot .go {
            width: 16px;
            height: 16px;
            transition: transform 0.3s ease;
        }

        .company-card:hover .cc-foot .go {
            transform: translateX(4px);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 64px 30px;
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
            .cmw {
                padding: 0 12px;
            }

            .cmw-header {
                flex-direction: column;
            }

            .cmw-header-actions {
                width: 100%;
            }

            .cmw-header-actions .cmw-btn {
                flex: 1;
                justify-content: center;
            }

            .cmw-header h1 {
                font-size: 24px;
            }

            .stat-row {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .stat-card .sv {
                font-size: 20px;
            }

            .cmw-filter form {
                flex-direction: column;
            }

            .search-wrap {
                min-width: 100%;
            }

            .cmw-filter select {
                width: 100%;
            }

            .company-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .stat-row {
                grid-template-columns: 1fr;
            }

            .cmw-header h1 {
                font-size: 20px;
            }

            .company-card {
                padding: 18px 16px;
            }

            .cc-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 6px;
            }

            .cc-stat .n {
                font-size: 14px;
            }
        }

        @media (max-width: 380px) {
            .cmw-header h1 {
                font-size: 18px;
            }

            .cmw-btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .cmw-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="cmw">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- ===== HEADER ===== -->
        <div class="cmw-header animate-in" style="animation-delay: 0.05s;">
            <div class="cmw-header-left">
                <div class="cmw-badge">
                    <span class="dot"></span>
                    Manajemen
                </div>
                <h1><span class="highlight">Kelola Company</span></h1>
                <p>Daftar semua perusahaan yang terdaftar di sistem Arvessa.</p>
            </div>
            <div class="cmw-header-actions">
                <a href="{{ route('admin.companies.index') }}" class="cmw-btn cmw-btn-ghost">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Refresh
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- ===== STAT CARDS ===== -->
        <div class="stat-row animate-in" style="animation-delay: 0.10s;">
            <div class="stat-card c-emerald">
                <div class="sk">
                    <span class="sk-label">Total Company</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-building"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total'] }}</div>
                <div class="sc">Perusahaan terdaftar</div>
            </div>
            <div class="stat-card c-emerald">
                <div class="sk">
                    <span class="sk-label">Aktif</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-check-circle"/></svg></span>
                </div>
                <div class="sv">{{ $stats['active'] }}</div>
                <div class="sc">Perusahaan aktif</div>
            </div>
            <div class="stat-card c-neutral">
                <div class="sk">
                    <span class="sk-label">Disuspend</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-pause-circle"/></svg></span>
                </div>
                <div class="sv">{{ $stats['suspended'] }}</div>
                <div class="sc">Perusahaan non-aktif</div>
            </div>
        </div>

        <!-- ===== FILTER ===== -->
        <div class="cmw-filter animate-in" style="animation-delay: 0.14s;">
            <form method="GET" action="{{ route('admin.companies.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Cari nama company...">
                </div>
                <select name="status" id="statusSelect" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status')==='active' ? 'selected':'' }}>Aktif</option>
                    <option value="suspended" {{ request('status')==='suspended' ? 'selected':'' }}>Disuspend</option>
                </select>
                <button type="submit" class="btn-sm btn-sm-primary">
                    <svg class="icon"><use href="#ic-search"/></svg> Cari
                </button>
                @if(request()->anyFilled(['q','status']))
                    <a href="{{ route('admin.companies.index') }}" class="btn-sm">
                        <svg class="icon"><use href="#ic-x"/></svg> Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- ===== COMPANY GRID ===== -->
        <div class="company-grid">
            @forelse($companies as $company)
                <a href="{{ route('admin.companies.edit', $company) }}" class="company-card st-{{ $company->status }} animate-in" style="animation-delay: {{ 0.16 + ($loop->index * 0.04) }}s;">
                    <div class="cc-top">
                        <div class="cc-logo">{{ strtoupper(substr($company->name, 0, 1)) }}</div>
                        <span class="cc-status {{ $company->status }}">
                            <span class="sdot"></span>
                            {{ $company->status === 'active' ? 'Aktif' : 'Suspend' }}
                        </span>
                    </div>
                    <div class="cc-name">{{ $company->name }}</div>
                    <div class="cc-date">Terdaftar {{ $company->created_at->translatedFormat('d M Y') }}</div>

                    <div class="cc-stats">
                        <div class="cc-stat">
                            <div class="n">{{ $company->users_count }}</div>
                            <div class="l">User</div>
                        </div>
                        <div class="cc-stat">
                            <div class="n">{{ $company->invoices_count }}</div>
                            <div class="l">Faktur</div>
                        </div>
                        <div class="cc-stat">
                            <div class="n">{{ $company->clients_count }}</div>
                            <div class="l">Klien</div>
                        </div>
                    </div>

                    <div class="cc-foot">
                        Lihat detail
                        <svg class="icon go"><use href="#ic-arrow-right"/></svg>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                    <h3>Belum ada company</h3>
                    <p>Company yang mendaftar akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">
            {{ $companies->onEachSide(1)->links() }}
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

        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function(){
                showToast('Berhasil!', @json(session('success')), 'success');
            });
        @endif

        // ===== RIPPLE EFFECT =====
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.cmw-btn');
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

        // ===== DEBOUNCE SEARCH =====
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            const statusSelect = document.getElementById('statusSelect');
            let debounceTimer = null;

            if (searchInput && filterForm) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    
                    const currentValue = this.value;
                    
                    if (currentValue === '') {
                        filterForm.submit();
                        return;
                    }
                    
                    debounceTimer = setTimeout(function() {
                        filterForm.submit();
                    }, 400);
                });
            }

            // Status select tetap auto-submit via onchange
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    // Clear any pending search debounce
                    clearTimeout(debounceTimer);
                });
            }
        });
    </script>
</x-admin-layout>