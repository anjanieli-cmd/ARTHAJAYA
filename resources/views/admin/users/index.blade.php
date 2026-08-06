<x-admin-layout>
    <x-slot name="title">Kelola User</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>
            </symbol>
            <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 6 12 13 2 6"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
        </defs>
    </svg>

    @php
        // Helper: works whether access_level is a plain string OR a PHP Enum instance
        $levelValueOf = function ($level) {
            if ($level instanceof \BackedEnum) {
                return $level->value;
            }
            return $level;
        };
        $levelLabelOf = function ($level) {
            if (is_object($level) && method_exists($level, 'label')) {
                return $level->label();
            }
            return ucfirst((string) $level);
        };

        $totalUsers = $users->total();
        $adminCount = $users->getCollection()->filter(fn($u) => $levelValueOf($u->access_level) === 'admin')->count();
        $staffCount = $users->getCollection()->filter(fn($u) => $levelValueOf($u->access_level) === 'staff')->count();
        $userCount  = $users->getCollection()->filter(fn($u) => $levelValueOf($u->access_level) === 'user')->count();
    @endphp

    <style>
        .adm-wrap {
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

        .adm-wrap * { box-sizing:border-box; }

        .adm-wrap .mono {
            font-family: 'IBM Plex Mono', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.02em;
        }

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

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .adm-wrap .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .adm-wrap .icon {
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

        /* ===== HEADER ===== */
        .adm-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .adm-header-left {
            flex: 1;
            min-width: 200px;
        }

        .adm-badge {
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

        .adm-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .adm-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .adm-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .adm-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .adm-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .adm-btn {
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

        .adm-btn .icon {
            width: 16px;
            height: 16px;
        }

        .adm-btn:hover {
            transform: translateY(-2px);
        }

        .adm-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .adm-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .adm-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .adm-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .adm-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .adm-btn .ripple {
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

        /* ===== FILTER BAR ===== */
        .filter-bar {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
            margin-bottom: 16px;
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 220px;
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
        }

        .filter-form input[type=text] {
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

        .filter-form input[type=text]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .filter-select {
            padding: 10px 34px 10px 16px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid transparent;
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            appearance: none;
            cursor: pointer;
            font-family: inherit;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 14px;
            min-width: 180px;
        }

        .filter-select:focus {
            border-color: var(--theme-primary);
        }

        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrap {
                min-width: 100%;
            }

            .filter-select {
                width: 100%;
            }
        }

        /* ===== STAT CARDS ===== */
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

        /* ===== TABLE CARD ===== */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .table-card:hover {
            border-color: var(--border-hover);
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        thead th {
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            font-weight: 700;
            padding: 16px 20px;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            background: var(--bg-card-active);
        }

        tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: background 0.18s ease;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--bg-card-hover);
        }

        tbody td {
            padding: 16px 20px;
            font-size: 13.5px;
            vertical-align: middle;
        }

        .u-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .u-avatar {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .u-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 13.5px;
        }

        .u-email {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .u-email .icon {
            width: 11px;
            height: 11px;
        }

        .level-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 100px;
            letter-spacing: 0.02em;
        }

        .level-badge .sdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .level-badge.admin {
            background: rgba(var(--emerald-rgb), 0.14);
            color: var(--emerald);
        }
        .level-badge.admin .sdot { background: var(--emerald); animation: pulseGlow 1.8s ease-in-out infinite; }

        .level-badge.staff {
            background: rgba(78, 143, 240, 0.14);
            color: #4E8FF0;
        }
        .level-badge.staff .sdot { background: #4E8FF0; }

        .level-badge.user {
            background: var(--surface-strong);
            color: var(--text-mute);
        }
        .level-badge.user .sdot { background: var(--text-faint); }

        .joined-cell {
            color: var(--text-mute);
            font-size: 13px;
        }

        .row-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            justify-content: flex-end;
        }

        .icon-action {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
            border: 1px solid var(--border-color);
            color: var(--text-tertiary);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            text-decoration: none;
        }

        .icon-action .icon {
            width: 15px;
            height: 15px;
        }

        .icon-action:hover {
            transform: translateY(-2px);
        }

        .icon-action.edit:hover {
            background: rgba(78, 143, 240, 0.14);
            border-color: #4E8FF0;
            color: #4E8FF0;
        }

        .icon-action.delete:hover {
            background: rgba(232, 90, 90, 0.14);
            border-color: var(--danger);
            color: var(--danger);
        }

        .icon-action[data-tip]::after {
            content: attr(data-tip);
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) translateY(4px);
            background: var(--surface);
            color: var(--text);
            font-size: 11px;
            font-weight: 600;
            padding: 5px 9px;
            border-radius: 7px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.16s ease;
            pointer-events: none;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.35);
            border: 1px solid var(--border);
        }

        .icon-action[data-tip]::before {
            content: '';
            position: absolute;
            bottom: calc(100% + 3px);
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: var(--surface);
            opacity: 0;
            visibility: hidden;
            transition: all 0.16s ease;
        }

        .icon-action[data-tip]:hover::after,
        .icon-action[data-tip]:hover::before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
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
            color: var(--text);
        }

        .empty-state p {
            font-size: 13.5px;
            color: var(--text-secondary);
            max-width: 320px;
            margin: 0 auto;
        }

        .pagination-wrap {
            margin-top: 18px;
        }

        /* ===== DELETE MODAL ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .modal-box {
            background: #0F1520;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        [data-theme="light"] .modal-box {
            background: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .modal-box .user-name {
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

        .modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .modal-actions .btn {
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

        .modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .modal-actions .btn-danger:hover {
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
        @media (max-width: 1100px) {
            .stat-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .adm-wrap {
                padding: 0 16px;
            }

            .adm-header {
                flex-direction: column;
            }

            .adm-header-actions {
                width: 100%;
            }

            .adm-header-actions .adm-btn {
                flex: 1;
                justify-content: center;
            }

            .stat-row {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .stat-card .sv {
                font-size: 20px;
            }

            .modal-box {
                padding: 24px 20px;
                margin: 10px;
            }

            .modal-actions {
                flex-direction: column;
            }

            .modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .adm-wrap {
                padding: 0 12px;
            }

            .stat-row {
                grid-template-columns: 1fr;
            }

            .adm-header h1 {
                font-size: 24px;
            }

            .modal-box {
                padding: 20px 16px;
            }

            .modal-box h3 {
                font-size: 18px;
            }

            .modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }

            .modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 380px) {
            .adm-header h1 {
                font-size: 20px;
            }

            .adm-btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .adm-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="adm-wrap">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- ===== HEADER ===== -->
        <div class="adm-header animate-in" style="animation-delay: 0.05s;">
            <div class="adm-header-left">
                <div class="adm-badge">
                    <span class="dot"></span>
                    Pengaturan
                </div>
                <h1><span class="highlight">Kelola User</span></h1>
                <p>Atur access level (admin / staff / user) untuk semua akun yang terdaftar.</p>
            </div>
            <div class="adm-header-actions">
                <a href="{{ route('admin.users.create') }}" class="adm-btn adm-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah User
                </a>
            </div>
        </div>

        <!-- ===== STAT CARDS ===== -->
        <div class="stat-row">
            <div class="stat-card c-emerald animate-in" style="animation-delay: 0.10s;">
                <div class="sk">
                    <span class="sk-label">Total User</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-users"/></svg></span>
                </div>
                <div class="sv">{{ $totalUsers }}</div>
                <div class="sc">Akun terdaftar</div>
            </div>
            <div class="stat-card c-emerald animate-in" style="animation-delay: 0.15s;">
                <div class="sk">
                    <span class="sk-label">Admin</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-shield"/></svg></span>
                </div>
                <div class="sv">{{ $adminCount }}</div>
                <div class="sc">Akses penuh sistem</div>
            </div>
            <div class="stat-card c-info animate-in" style="animation-delay: 0.20s;">
                <div class="sk">
                    <span class="sk-label">Staff</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-briefcase"/></svg></span>
                </div>
                <div class="sv">{{ $staffCount }}</div>
                <div class="sc">Akses terbatas</div>
            </div>
            <div class="stat-card c-neutral animate-in" style="animation-delay: 0.25s;">
                <div class="sk">
                    <span class="sk-label">User Biasa</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-user"/></svg></span>
                </div>
                <div class="sv">{{ $userCount }}</div>
                <div class="sc">Akses dasar</div>
            </div>
        </div>

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar animate-in" style="animation-delay: 0.27s;">
            <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Cari nama atau email..." autocomplete="off">
                </div>
                <select name="access_level" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Access Level</option>
                    @foreach($accessLevels as $level)
                        @php
                            $optValue = $levelValueOf($level);
                            $optLabel = $levelLabelOf($level);
                        @endphp
                        <option value="{{ $optValue }}" {{ request('access_level') === $optValue ? 'selected' : '' }}>
                            {{ $optLabel }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="adm-btn adm-btn-primary" style="padding:9px 18px;">
                    <svg class="icon"><use href="#ic-search"/></svg> Cari
                </button>
                @if(request()->filled('q') || request()->filled('access_level'))
                    <a href="{{ route('admin.users.index') }}" class="adm-btn adm-btn-ghost" style="padding:9px 14px;">
                        <svg class="icon"><use href="#ic-x"/></svg> Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="table-card animate-in" style="animation-delay: 0.30s;">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Perusahaan</th>
                            <th>Access Level</th>
                            <th>Terdaftar</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            @php
                                $rowColors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                                $avColor = $rowColors[$loop->index % count($rowColors)];
                                $uLevelValue = $levelValueOf($u->access_level);
                                $uLevelLabel = $levelLabelOf($u->access_level);
                            @endphp
                            <tr>
                                <td>
                                    <div class="u-cell">
                                        <div class="u-avatar" style="background:{{ $avColor }};">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="u-name">{{ $u->name }}</div>
                                            <div class="u-email">
                                                <svg class="icon"><use href="#ic-mail"/></svg>
                                                {{ $u->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $u->company->name ?? '—' }}</td>
                                <td>
                                    <span class="level-badge {{ $uLevelValue }}">
                                        <span class="sdot"></span>{{ $uLevelLabel }}
                                    </span>
                                </td>
                                <td class="joined-cell">{{ $u->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('admin.users.edit', $u) }}" class="icon-action edit" data-tip="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        @if($u->id !== auth()->id())
                                            <button type="button" class="icon-action delete" data-tip="Hapus" onclick="openDeleteModal('{{ $u->id }}', '{{ $u->name }}')">
                                                <svg class="icon"><use href="#ic-trash"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                                        <h3>Belum ada user</h3>
                                        <p>User yang mendaftar akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>

        <!-- ===== DELETE MODAL ===== -->
        <div class="modal-overlay" id="deleteModal">
            <div class="modal-box">
                <div class="icon-danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <h3>Hapus user ini?</h3>
                <p>
                    User
                    <br>
                    <span class="user-name" id="deleteUserName">—</span>
                </p>
                <p style="margin-top:8px;">akan dihapus permanen dan tidak bisa dikembalikan.</p>
                <div class="warning-text">Seluruh akses user ini ke sistem akan dicabut.</div>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-actions">
                        <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
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
        
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function(){
                showToast('Gagal', @json($errors->first()), 'error');
            });
        @endif

        // ===== DELETE MODAL =====
        function openDeleteModal(id, userName) {
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteForm').action = '{{ url("admin/users") }}/' + id;
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
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.adm-btn');
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
            let debounceTimer = null;

            if (searchInput && filterForm) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    
                    // Get current value
                    const currentValue = this.value;
                    
                    // If empty, submit immediately to clear filter
                    if (currentValue === '') {
                        filterForm.submit();
                        return;
                    }
                    
                    // Otherwise debounce
                    debounceTimer = setTimeout(function() {
                        filterForm.submit();
                    }, 400); // 400ms delay after user stops typing
                });
            }
        });
    </script>
</x-admin-layout>