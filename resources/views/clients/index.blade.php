<x-app-layout>
    <x-slot name="title">Klien</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
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
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </symbol>
            <symbol id="ic-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="12" y2="14"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-chevron-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </symbol>
        </defs>
    </svg>

    @php
        function formatRupiahShort($amount) {
            if ($amount >= 1000000000) {
                return 'Rp' . number_format($amount / 1000000000, 1, ',', '') . ' M';
            } elseif ($amount >= 1000000) {
                return 'Rp' . number_format($amount / 1000000, 1, ',', '') . ' Jt';
            } elseif ($amount >= 1000) {
                return 'Rp' . number_format($amount / 1000, 0, ',', '') . ' Rb';
            }
            return 'Rp' . number_format($amount, 0, ',', '.');
        }
    @endphp

    <style>
        .clients-wrap {
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
            --danger-rgb: 232, 90, 90;
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .clients-wrap * { box-sizing: border-box; }
        .clients-wrap .mono {
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

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .clients-wrap .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .clients-wrap .icon {
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
        .toast .toast-icon.success{ background:var(--success-soft); color:var(--success); }
        .toast .toast-icon.error{ background:var(--danger-soft); color:var(--danger); }
        .toast .toast-icon .icon{ width:18px; height:18px; }
        .toast .toast-content{ flex:1; }
        .toast .toast-title{ font-size:13px; font-weight:600; color:var(--text); }
        .toast .toast-msg{ font-size:12px; color:var(--text-mute); }
        .toast .toast-close{ background:none; border:none; color:var(--text-faint); cursor:pointer; padding:4px; }
        .toast .toast-close .icon{ width:14px; height:14px; }

        /* ===== HEADER ===== */
        .clients-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .clients-header-left {
            flex: 1;
            min-width: 200px;
        }

        .clients-badge {
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

        .clients-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .clients-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .clients-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .clients-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .clients-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .clients-btn {
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

        .clients-btn .icon {
            width: 16px;
            height: 16px;
        }

        .clients-btn:hover {
            transform: translateY(-2px);
        }

        .clients-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .clients-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .clients-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .clients-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .clients-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .clients-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== SUCCESS MESSAGE ===== */
        .clients-success {
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

        .clients-success .icon {
            width: 20px;
            height: 20px;
        }

        .clients-success .message {
            font-weight: 500;
        }

        /* ===== STAT CARDS ===== */
        .clients-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .clients-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .clients-stat-card::before {
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

        .clients-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .clients-stat-card:hover::before {
            opacity: 1;
        }

        .clients-stat-card .stat-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .clients-stat-card .stat-head .ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .clients-stat-card .stat-head .ic .icon {
            width: 17px;
            height: 17px;
        }

        .clients-stat-card .stat-label {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .clients-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .clients-stat-card .stat-value.primary {
            color: var(--theme-primary);
        }

        .clients-stat-card .stat-value.success {
            color: var(--success);
        }

        .clients-stat-card .stat-value.warning {
            color: var(--warning);
        }

        .clients-stat-card .stat-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* ===== FILTER BAR ===== */
        .filter-bar{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            background:var(--bg-card);
            padding:12px 20px;
            border-radius:var(--radius-sm);
            border:1px solid var(--border-color);
            margin-bottom:16px;
            transition: all 0.3s ease;
        }

        .filter-bar:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .filter-bar form{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            width:100%;
        }

        .search-wrap{
            position:relative;
            flex:1;
            min-width:220px;
        }

        .search-wrap .icon{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            width:16px;
            height:16px;
            color:var(--text-tertiary);
            pointer-events:none;
            transition: color 0.3s ease;
        }

        .search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .filter-bar input[type=text]{
            width:100%;
            padding:10px 16px 10px 42px;
            border-radius:var(--radius-sm);
            background:var(--bg-card-active);
            border:1px solid transparent;
            color:var(--text-primary);
            font-size:13px;
            outline:none;
            transition:all .3s ease;
            font-family:inherit;
        }

        .filter-bar input[type=text]:focus{
            border-color:var(--theme-primary);
            background:var(--bg-card);
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1);
        }

        .filter-bar input[type=text]::placeholder{
            color:var(--text-tertiary);
        }

        .filter-actions{
            display:flex;
            gap:8px;
            align-items:center;
        }

        .filter-actions .clients-btn {
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

        /* ===== TABLE ===== */
        .clients-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.22s ease;
        }

        .clients-card:hover {
            border-color: var(--border-hover);
        }

        .clients-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .clients-card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .clients-table-wrap {
            overflow-x: auto;
            padding: 0 4px 4px 4px;
        }

        .clients-table-wrap.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .clients-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .clients-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .clients-table th.text-center {
            text-align: center;
        }

        .clients-table th.text-right {
            text-align: right;
        }

        .clients-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            vertical-align: middle;
        }

        .clients-table tbody tr {
            transition: background 0.2s ease;
        }

        .clients-table tbody tr:hover {
            background: var(--bg-card-hover);
        }

        .clients-table tbody tr:last-child td {
            border-bottom: none;
        }

        .client-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .client-avatar {
            width: 42px;
            height: 42px;
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

        .client-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-primary);
        }

        .client-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 1px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .client-sub .icon {
            width: 13px;
            height: 13px;
            color: var(--text-mute);
        }

        .client-email {
            color: var(--text-secondary);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .client-email .icon {
            width: 14px;
            height: 14px;
            color: var(--text-tertiary);
        }

        .client-phone {
            color: var(--text-secondary);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .client-phone .icon {
            width: 14px;
            height: 14px;
            color: var(--text-tertiary);
        }

        .client-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 100px;
            background: var(--theme-soft);
            color: var(--theme-primary);
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        /* ===== ROW ACTIONS ===== */
        .row-actions {
            display: flex;
            align-items: center;
            gap: 4px;
            justify-content: flex-end;
        }

        .row-actions .btn-action {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: var(--text-tertiary);
            background: transparent;
            border: 1px solid var(--border-color);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 14px;
        }

        .row-actions .btn-action .icon {
            width: 15px;
            height: 15px;
        }

        .row-actions .btn-action.show {
            color: var(--theme-primary);
        }

        .row-actions .btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .row-actions .btn-action.edit {
            color: #4FA6E8;
        }

        .row-actions .btn-action.edit:hover {
            background: rgba(79, 166, 232, 0.12);
            border-color: #4FA6E8;
        }

        .row-actions .btn-action.danger {
            color: var(--danger);
        }

        .row-actions .btn-action.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        /* ===== EMPTY STATE ===== */
        .clients-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-tertiary);
        }

        .clients-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .clients-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .clients-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ============================================================
           MODAL DELETE - SAMA KAYA YANG LAIN
           ============================================================ */
        .clients-modal-overlay {
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

        .clients-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .clients-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .clients-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .clients-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .clients-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .clients-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .clients-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .clients-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .clients-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .clients-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .clients-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .clients-modal-box .client-name-modal {
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

        .clients-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .clients-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .clients-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .clients-modal-actions .btn {
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

        .clients-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .clients-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .clients-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .clients-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .clients-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .clients-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .clients-modal-actions .btn-danger:hover {
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

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 1200px) {
            .clients-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .clients-table {
                font-size: 12.5px;
            }

            .clients-table th,
            .clients-table td {
                padding: 10px 12px;
            }

            .clients-card-header {
                padding: 14px 16px;
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 12px 16px;
            }

            .filter-bar form {
                flex-direction: column;
            }

            .search-wrap {
                min-width: 100%;
            }

            .filter-actions {
                width: 100%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .clients-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }

            .clients-modal-actions {
                flex-direction: column;
            }

            .clients-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .clients-header {
                flex-direction: column;
            }
            
            .clients-header-actions {
                width: 100%;
            }
            
            .clients-header-actions .clients-btn {
                flex: 1;
                justify-content: center;
            }

            .clients-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .clients-stat-card .stat-value {
                font-size: 22px;
            }

            .row-actions {
                opacity: 1;
            }

            .clients-modal-box {
                padding: 20px 16px;
            }

            .clients-modal-box h3 {
                font-size: 18px;
            }

            .clients-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }

            .clients-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 380px) {
            .clients-header h1 {
                font-size: 22px;
            }
            .clients-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .clients-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="clients-wrap">

        {{-- ===== TOAST CONTAINER ===== --}}
        <div class="toast-container" id="toastContainer"></div>

        {{-- ===== HEADER ===== --}}
        <div class="clients-header animate-in" style="animation-delay: 0.05s;">
            <div class="clients-header-left">
                <div class="clients-badge">
                    <span class="dot"></span>
                    Manajemen Klien
                </div>
                <h1>Daftar Klien</h1>
                <p class="subtitle">
                    Kelola semua klien yang terdaftar di {{ $company->name ?? 'perusahaanmu' }} — 
                    <strong id="clientTotalCount">{{ $stats['total_count'] ?? 0 }}</strong> klien aktif
                </p>
            </div>
            <div class="clients-header-actions">
                <a href="{{ route('clients.create') }}" class="clients-btn clients-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Klien
                </a>
            </div>
        </div>

        {{-- ===== SUCCESS MESSAGE ===== --}}
        @if(session('success'))
            <div class="clients-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="clients-success" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <span class="message">{{ session('error') }}</span>
            </div>
        @endif

        {{-- ===== STAT CARDS ===== --}}
        <div class="clients-stats" id="statCards">
            <div class="clients-stat-card animate-in" style="animation-delay: 0.10s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-users"/></svg>
                    </div>
                </div>
                <div class="stat-label">Total Klien</div>
                <div class="stat-value primary" id="statTotal">{{ $stats['total_count'] ?? 0 }}</div>
                <div class="stat-sub">Klien terdaftar</div>
            </div>

            <div class="clients-stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-file-text"/></svg>
                    </div>
                </div>
                <div class="stat-label">Ada Transaksi</div>
                <div class="stat-value" id="statWithInvoices">{{ $stats['with_invoices_count'] ?? 0 }}</div>
                <div class="stat-sub">Pernah dibuatkan faktur</div>
            </div>

            <div class="clients-stat-card animate-in" style="animation-delay: 0.20s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                    </div>
                </div>
                <div class="stat-label">Piutang Berjalan</div>
                <div class="stat-value warning mono" id="statOutstanding">{{ formatRupiahShort($stats['outstanding_amount'] ?? 0) }}</div>
                <div class="stat-sub">Belum dibayar</div>
            </div>

            <div class="clients-stat-card animate-in" style="animation-delay: 0.25s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-activity"/></svg>
                    </div>
                </div>
                <div class="stat-label">Klien Baru</div>
                <div class="stat-value success" id="statNew">{{ $stats['new_this_month'] ?? 0 }}</div>
                <div class="stat-sub">Bulan ini</div>
            </div>
        </div>

        {{-- ===== FILTER BAR ===== --}}
        <div class="filter-bar animate-in" style="animation-delay: 0.27s;">
            <form method="GET" action="{{ route('clients.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="clientSearchInput" value="{{ request('q') }}" placeholder="Cari nama klien, perusahaan, atau email..." autocomplete="off">
                </div>
                <div class="filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <a href="{{ route('clients.index') }}" class="clients-btn clients-btn-ghost" id="resetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="clients-card animate-in" style="animation-delay: 0.30s;">
            <div class="clients-card-header">
                <h3>Semua Klien</h3>
                <a href="#" class="clients-btn clients-btn-ghost" style="padding: 6px 14px; font-size: 12px;">
                    <svg class="icon"><use href="#ic-chevron-right"/></svg>
                    Lihat Semua
                </a>
            </div>

            <div class="clients-table-wrap" id="tableContainer">
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Nama Klien</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th class="text-center">Total Faktur</th>
                            <th class="text-right" style="min-width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($clients as $client)
                            @php
                                $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A', '#14B8A6', '#F97316'];
                                $avColor = $colors[$loop->index % count($colors)];
                            @endphp
                            <tr>
                                <td>
                                    <div class="client-cell">
                                        <div class="client-avatar" style="background:{{ $avColor }};">
                                            {{ strtoupper(substr($client->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="client-name">{{ $client->name }}</div>
                                            @if($client->company_name)
                                                <div class="client-sub">
                                                    <svg class="icon"><use href="#ic-building"/></svg>
                                                    {{ $client->company_name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($client->email)
                                        <span class="client-email">
                                            <svg class="icon"><use href="#ic-mail"/></svg>
                                            {{ $client->email }}
                                        </span>
                                    @else
                                        <span style="color:var(--text-tertiary);font-size:13px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($client->phone)
                                        <span class="client-phone">
                                            <svg class="icon"><use href="#ic-phone"/></svg>
                                            {{ $client->phone }}
                                        </span>
                                    @else
                                        <span style="color:var(--text-tertiary);font-size:13px;">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="client-badge">{{ $client->invoices_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('clients.show', $client) }}" class="btn-action show" title="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('clients.edit', $client) }}" class="btn-action edit" title="Edit Klien">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="btn-action danger" title="Hapus" 
                                                onclick="openDeleteModal('{{ $client->id }}', '{{ addslashes($client->name) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="clients-empty">
                                        <svg class="empty-icon"><use href="#ic-inbox"/></svg>
                                        <h3>Belum Ada Klien</h3>
                                        <p>Klien yang kamu tambahkan akan muncul di sini. Mulai dengan menambahkan klien pertamamu.</p>
                                        <a href="{{ route('clients.create') }}" class="clients-btn clients-btn-primary" style="display: inline-flex;">
                                            <svg class="icon"><use href="#ic-plus"/></svg>
                                            Tambah Klien Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($clients) && method_exists($clients, 'total') && $clients->total() > 0)
                <div class="pagination-bar" style="display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-top:1px solid var(--border-color); flex-wrap:wrap; gap:12px;">
                    <div style="font-size:12.5px; color:var(--text-tertiary);">
                        Menampilkan {{ $clients->firstItem() }}–{{ $clients->lastItem() }} dari {{ $clients->total() }} klien
                    </div>
                    <div>
                        {{ $clients->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>

        {{-- ===== MODAL DELETE ===== --}}
        <div class="clients-modal-overlay" id="deleteModal">
            <div class="clients-modal-box">
                <!-- ICON DANGER -->
                <div class="icon-danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>

                <!-- JUDUL -->
                <h3>Hapus Klien Ini?</h3>

                <!-- DESKRIPSI -->
                <p>
                    Anda yakin ingin menghapus klien
                    <br>
                    <span class="client-name-modal" id="deleteClientName">-</span>
                </p>

                <!-- WARNING -->
                <div class="warning-text">
                    ⚠️ Data yang dihapus tidak dapat dikembalikan!
                </div>

                <!-- TOMBOL -->
                <div class="clients-modal-actions">
                    <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                        Batal
                    </button>
                    <form id="deleteForm" action="" method="POST" style="display:inline;">
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

        // ===== DELETE MODAL =====
        function openDeleteModal(id, name) {
            document.getElementById('deleteClientName').textContent = name;
            var url = '{{ url("clients") }}/' + id;
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
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // ===== LIVE SEARCH =====
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('clientSearchInput');
            var tableContainer = document.getElementById('tableContainer');
            var tableBody = document.getElementById('tableBody');
            var statCards = document.getElementById('statCards');
            var resetBtn = document.getElementById('resetBtn');
            var searchIndicator = document.getElementById('searchIndicator');
            var searchResultCount = document.getElementById('searchResultCount');
            var totalCountEl = document.getElementById('clientTotalCount');
            var loadingTimeout = null;

            function resetToInitial() {
                if (searchInput) {
                    searchInput.value = '';
                }

                if (searchIndicator) {
                    searchIndicator.classList.remove('active');
                }

                var url = new URL(window.location.href);
                url.searchParams.delete('q');
                window.history.replaceState({}, '', url.toString());

                updateResults(true);
            }

            function updateResults(isReset = false) {
                tableContainer.classList.add('loading');
                
                var q = searchInput ? searchInput.value : '';
                var url = '{{ route("clients.index") }}';
                if (!isReset && q) {
                    url += '?q=' + encodeURIComponent(q);
                }
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    
                    var newBody = doc.querySelector('#tableBody');
                    if (newBody) {
                        tableBody.innerHTML = newBody.innerHTML;
                    }
                    
                    var newStats = doc.querySelector('#statCards');
                    if (newStats) {
                        statCards.innerHTML = newStats.innerHTML;
                    }
                    
                    var newTotal = doc.querySelector('#clientTotalCount');
                    if (newTotal && totalCountEl) {
                        totalCountEl.textContent = newTotal.textContent;
                    }

                    if (searchIndicator && searchResultCount && !isReset && q) {
                        var newRows = doc.querySelectorAll('#tableBody tr');
                        var count = newRows.length;
                        if (count > 0) {
                            searchIndicator.classList.add('active');
                            searchResultCount.textContent = count;
                        } else {
                            searchIndicator.classList.remove('active');
                        }
                    } else if (isReset) {
                        if (searchIndicator) {
                            searchIndicator.classList.remove('active');
                        }
                    }
                    
                    tableContainer.classList.remove('loading');
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    tableContainer.classList.remove('loading');
                    showToast('Error', 'Gagal memuat data. Silakan refresh halaman.', 'error');
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }

                    var url = new URL(window.location.href);
                    if (this.value.trim() !== '') {
                        url.searchParams.set('q', this.value.trim());
                    } else {
                        url.searchParams.delete('q');
                    }
                    window.history.replaceState({}, '', url.toString());

                    loadingTimeout = setTimeout(function() {
                        updateResults(false);
                    }, 300);
                });

                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                    if (e.key === '/' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        var activeElement = document.activeElement;
                        if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA')) {
                            return;
                        }
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    resetToInitial();
                });
            }

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.clients-btn');
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
</x-app-layout>