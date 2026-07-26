<x-app-layout>
    <x-slot name="title">Penawaran</x-slot>

    {{-- ===== SVG ICONS LENGKAP ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
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
            <symbol id="ic-chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
            </symbol>
            <symbol id="ic-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
        </defs>
    </svg>

    @php
        // 🔧 SEEDING SESSION — Untuk quotes menggunakan database, tidak perlu seeding
        // Tapi kita tetap siapkan untuk keperluan lain jika diperlukan

        $statusLabels = [
            'draft' => 'Draft',
            'sent' => 'Terkirim',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'expired' => 'Kadaluwarsa',
        ];
        
        $statusMeta = [
            'draft' => ['label' => 'Draft', 'class' => 'st-draft'],
            'sent' => ['label' => 'Terkirim', 'class' => 'st-sent'],
            'accepted' => ['label' => 'Diterima', 'class' => 'st-accepted'],
            'rejected' => ['label' => 'Ditolak', 'class' => 'st-rejected'],
            'expired' => ['label' => 'Kadaluwarsa', 'class' => 'st-expired'],
        ];

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
        .quotes-wrap {
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

        .quotes-wrap * { box-sizing: border-box; }
        .quotes-wrap .mono {
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

        .quotes-wrap .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .quotes-wrap .icon {
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

        /* ===== TOAST NOTIFICATION ===== */
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
        .quotes-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .quotes-header-left {
            flex: 1;
            min-width: 200px;
        }

        .quotes-badge {
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

        .quotes-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .quotes-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .quotes-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .quotes-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .quotes-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .quotes-btn {
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

        .quotes-btn .icon {
            width: 16px;
            height: 16px;
        }

        .quotes-btn:hover {
            transform: translateY(-2px);
        }

        .quotes-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .quotes-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .quotes-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .quotes-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .quotes-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .quotes-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ===== SUCCESS MESSAGE ===== */
        .quotes-success {
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

        .quotes-success .icon {
            width: 20px;
            height: 20px;
        }

        .quotes-success .message {
            font-weight: 500;
        }

        /* ===== STAT CARDS ===== */
        .quotes-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .quotes-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .quotes-stat-card::before {
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

        .quotes-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .quotes-stat-card:hover::before {
            opacity: 1;
        }

        .quotes-stat-card .stat-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .quotes-stat-card .stat-head .ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .quotes-stat-card .stat-head .ic .icon {
            width: 17px;
            height: 17px;
        }

        .quotes-stat-card .stat-label {
            font-size: 12px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .quotes-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .quotes-stat-card .stat-value.primary {
            color: var(--theme-primary);
        }

        .quotes-stat-card .stat-value.success {
            color: var(--success);
        }

        .quotes-stat-card .stat-value.warning {
            color: var(--warning);
        }

        .quotes-stat-card .stat-sub {
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

        .filter-bar select{
            padding:10px 38px 10px 16px;
            border-radius:var(--radius-sm);
            background:var(--bg-card-active);
            border:1px solid var(--border-color);
            color:var(--text-primary);
            font-size:13px;
            outline:none;
            min-width:170px;
            cursor:pointer;
            transition:all .3s ease;
            appearance:none;
            -webkit-appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat:no-repeat;
            background-position:right 12px center;
            background-size:12px;
        }

        .filter-bar select:focus{
            border-color:var(--theme-primary);
            background-color:var(--bg-card);
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1);
        }

        .filter-bar select:hover{
            border-color:var(--border-hover);
        }

        .filter-bar select option{
            background-color:var(--bg-card);
            color:var(--text-primary);
            padding:10px 14px;
        }

        .filter-actions{
            display:flex;
            gap:8px;
            align-items:center;
        }

        .filter-actions .quotes-btn {
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
        .quotes-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.22s ease;
        }

        .quotes-card:hover {
            border-color: var(--border-hover);
        }

        .quotes-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .quotes-card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .quotes-table-wrap {
            overflow-x: auto;
            padding: 0 4px 4px 4px;
        }

        .quotes-table-wrap.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .quotes-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .quotes-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .quotes-table th.text-right {
            text-align: right;
        }

        .quotes-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            vertical-align: middle;
        }

        .quotes-table tbody tr {
            transition: background 0.2s ease;
            position: relative;
        }

        .quotes-table tbody tr:hover {
            background: var(--bg-card-hover);
        }

        .quotes-table tbody tr:last-child td {
            border-bottom: none;
        }

        .quote-number {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 12px;
            border-radius: 6px;
            display: inline-block;
            border: 1px solid var(--border-color);
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
        }

        .date-cell {
            color: var(--text-secondary);
            font-size: 13px;
        }

        .amount-cell {
            font-weight: 700;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            color: var(--text-primary);
            text-align: right;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .st-draft {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }
        .st-draft .dot { background: var(--text-tertiary); }

        .st-sent {
            background: rgba(79, 166, 232, 0.14);
            color: #4FA6E8;
        }
        .st-sent .dot { background: #4FA6E8; }

        .st-accepted {
            background: var(--success-soft);
            color: var(--success);
        }
        .st-accepted .dot { background: var(--success); }

        .st-rejected {
            background: var(--danger-soft);
            color: var(--danger);
        }
        .st-rejected .dot { background: var(--danger); }

        .st-expired {
            background: var(--warning-soft);
            color: var(--warning);
        }
        .st-expired .dot { background: var(--warning); animation: pulseGlow 1.6s ease-in-out infinite; }

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
        .quotes-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-tertiary);
        }

        .quotes-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .quotes-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .quotes-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ============================================================
           DELETE MODAL - SAMA KAYA YANG LAIN
           ============================================================ */
        .quotes-modal-overlay {
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

        .quotes-modal-overlay.active {
            display: flex;
        }

        [data-theme="dark"] .quotes-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .quotes-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .quotes-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .quotes-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .quotes-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .quotes-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .quotes-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .quotes-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .quotes-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .quotes-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .quotes-modal-box .quote-number-modal {
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

        .quotes-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .quotes-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .quotes-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .quotes-modal-actions .btn {
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

        .quotes-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .quotes-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .quotes-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .quotes-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .quotes-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .quotes-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .quotes-modal-actions .btn-danger:hover {
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

        /* ===== PAGINATION ===== */
        .pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 12px;
        }

        .pg-info {
            font-size: 12.5px;
            color: var(--text-tertiary);
        }

        .pagination-bar nav {
            display: flex;
            gap: 4px;
        }

        .pagination-bar nav a,
        .pagination-bar nav span {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pagination-bar nav a:hover {
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        .pagination-bar nav .active {
            background: var(--theme-gradient);
            color: #fff;
            font-weight: 600;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .quotes-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .quotes-table {
                font-size: 12.5px;
            }

            .quotes-table th,
            .quotes-table td {
                padding: 10px 12px;
            }

            .quotes-card-header {
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

            .filter-bar select {
                width: 100%;
                min-width: unset;
            }

            .filter-actions {
                width: 100%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .quotes-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }

            .quotes-modal-actions {
                flex-direction: column;
            }

            .quotes-modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .quotes-header {
                flex-direction: column;
            }
            
            .quotes-header-actions {
                width: 100%;
            }
            
            .quotes-header-actions .quotes-btn {
                flex: 1;
                justify-content: center;
            }

            .quotes-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .quotes-stat-card .stat-value {
                font-size: 22px;
            }

            .row-actions {
                opacity: 1;
            }

            .quotes-modal-box {
                padding: 20px 16px;
            }

            .quotes-modal-box h3 {
                font-size: 18px;
            }

            .quotes-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }

            .quotes-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 380px) {
            .quotes-header h1 {
                font-size: 22px;
            }
            .quotes-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .quotes-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="quotes-wrap">

        {{-- ===== TOAST CONTAINER ===== --}}
        <div class="toast-container" id="toastContainer"></div>

        {{-- ===== HEADER ===== --}}
        <div class="quotes-header animate-in" style="animation-delay: 0.05s;">
            <div class="quotes-header-left">
                <div class="quotes-badge">
                    <span class="dot"></span>
                    Penjualan
                </div>
                <h1>Daftar Penawaran</h1>
                <p class="subtitle">
                    Kelola semua penawaran atau quotation yang telah dibuat untuk klien — 
                    <strong id="quoteTotalCount">{{ $stats['total_count'] ?? 0 }}</strong> penawaran
                </p>
            </div>
            <div class="quotes-header-actions">
                <a href="{{ route('quotes.create') }}" class="quotes-btn quotes-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Buat Penawaran
                </a>
            </div>
        </div>

        {{-- ===== SUCCESS MESSAGE ===== --}}
        @if(session('success'))
            <div class="quotes-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="quotes-success" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <span class="message">{{ session('error') }}</span>
            </div>
        @endif

        {{-- ===== STAT CARDS ===== --}}
        <div class="quotes-stats" id="statCards">
            <div class="quotes-stat-card animate-in" style="animation-delay: 0.10s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-file"/></svg>
                    </div>
                </div>
                <div class="stat-label">Total Penawaran</div>
                <div class="stat-value primary" id="statTotal">{{ $stats['total_count'] ?? 0 }}</div>
                <div class="stat-sub">Total penawaran dibuat</div>
            </div>

            <div class="quotes-stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-send"/></svg>
                    </div>
                </div>
                <div class="stat-label">Terkirim</div>
                <div class="stat-value" id="statSent">{{ $stats['sent_count'] ?? 0 }}</div>
                <div class="stat-sub">Menunggu respon klien</div>
            </div>

            <div class="quotes-stat-card animate-in" style="animation-delay: 0.20s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                    </div>
                </div>
                <div class="stat-label">Diterima</div>
                <div class="stat-value success" id="statAccepted">{{ $stats['accepted_count'] ?? 0 }}</div>
                <div class="stat-sub">Disetujui oleh klien</div>
            </div>

            <div class="quotes-stat-card animate-in" style="animation-delay: 0.25s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                    </div>
                </div>
                <div class="stat-label">Kadaluwarsa</div>
                <div class="stat-value warning" id="statExpired">{{ $stats['expired_count'] ?? 0 }}</div>
                <div class="stat-sub">Melewati masa berlaku</div>
            </div>
        </div>

        {{-- ===== FILTER BAR ===== --}}
        <div class="filter-bar animate-in" style="animation-delay: 0.27s;">
            <form method="GET" action="{{ route('quotes.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="quoteSearchInput" value="{{ request('q') }}" placeholder="Cari nomor penawaran atau nama klien..." autocomplete="off">
                </div>
                <select name="status" id="quoteStatusSelect">
                    <option value="">Semua Status</option>
                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <a href="{{ route('quotes.index') }}" class="quotes-btn quotes-btn-ghost" id="resetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="quotes-card animate-in" style="animation-delay: 0.30s;">
            <div class="quotes-card-header">
                <h3>Semua Penawaran</h3>
                <a href="#" class="quotes-btn quotes-btn-ghost" style="padding: 6px 14px; font-size: 12px;">
                    <svg class="icon"><use href="#ic-chevron-down"/></svg>
                    Filter Lanjutan
                </a>
            </div>

            <div class="quotes-table-wrap" id="tableContainer">
                <table class="quotes-table">
                    <thead>
                        <tr>
                            <th>No. Penawaran</th>
                            <th>Klien</th>
                            <th>Tanggal</th>
                            <th>Berlaku Sampai</th>
                            <th class="text-right">Total</th>
                            <th>Status</th>
                            <th class="text-right" style="min-width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($quotes as $quote)
                            @php
                                $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A', '#14B8A6', '#F97316'];
                                $avColor = $colors[$loop->index % count($colors)];
                                $st = $statusMeta[$quote->status] ?? $statusMeta['draft'];
                            @endphp
                            <tr data-id="{{ $quote->id }}">
                                <td><span class="quote-number">{{ $quote->quote_number }}</span></td>
                                <td>
                                    <div class="client-cell">
                                        <div class="client-avatar" style="background:{{ $avColor }};">
                                            {{ strtoupper(substr($quote->client->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="client-name">{{ $quote->client->name ?? '—' }}</div>
                                            @if($quote->client->company_name ?? null)
                                                <div class="client-sub">{{ $quote->client->company_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="date-cell">{{ optional($quote->issue_date)->translatedFormat('d M Y') ?? '—' }}</td>
                                <td class="date-cell">{{ optional($quote->valid_until)->translatedFormat('d M Y') ?? '—' }}</td>
                                <td class="amount-cell mono">
                                    {{ formatRupiahShort($quote->total ?? 0) }}
                                </td>
                                <td>
                                    <span class="status-badge {{ $st['class'] }}">
                                        <span class="dot"></span>
                                        {{ $st['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('quotes.show', $quote) }}" class="btn-action show" title="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="{{ route('quotes.edit', $quote) }}" class="btn-action edit" title="Edit Penawaran">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="btn-action danger" title="Hapus" 
                                                onclick="openDeleteModal('{{ $quote->id }}', '{{ addslashes($quote->quote_number) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="quotes-empty">
                                        <svg class="empty-icon"><use href="#ic-inbox"/></svg>
                                        <h3>Belum Ada Penawaran</h3>
                                        <p>Buat penawaran pertama untuk klienmu sekarang!</p>
                                        <a href="{{ route('quotes.create') }}" class="quotes-btn quotes-btn-primary" style="display: inline-flex;">
                                            <svg class="icon"><use href="#ic-plus"/></svg>
                                            Buat Penawaran Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($quotes) && method_exists($quotes, 'total') && $quotes->total() > 0)
                <div class="pagination-bar" id="paginationBar">
                    <div class="pg-info">
                        Menampilkan {{ $quotes->firstItem() }}–{{ $quotes->lastItem() }} dari {{ $quotes->total() }} penawaran
                    </div>
                    <div>
                        {{ $quotes->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>

        {{-- ===== MODAL DELETE ===== --}}
        <div class="quotes-modal-overlay" id="deleteModal">
            <div class="quotes-modal-box">
                <!-- ICON DANGER -->
                <div class="icon-danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>

                <!-- JUDUL -->
                <h3>Hapus Penawaran Ini?</h3>

                <!-- DESKRIPSI -->
                <p>
                    Anda yakin ingin menghapus penawaran
                    <br>
                    <span class="quote-number-modal" id="deleteQuoteNo">-</span>
                </p>

                <!-- WARNING -->
                <div class="warning-text">
                    ⚠️ Data yang dihapus tidak dapat dikembalikan!
                </div>

                <!-- TOMBOL -->
                <div class="quotes-modal-actions">
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
        function openDeleteModal(id, quoteNo) {
            document.getElementById('deleteQuoteNo').textContent = quoteNo;
            var url = '{{ url("quotes") }}/' + id;
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

        // ===== LIVE SEARCH & FILTER =====
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('quoteSearchInput');
            var statusSelect = document.getElementById('quoteStatusSelect');
            var tableContainer = document.getElementById('tableContainer');
            var tableBody = document.getElementById('tableBody');
            var statCards = document.getElementById('statCards');
            var paginationBar = document.getElementById('paginationBar');
            var resetBtn = document.getElementById('resetBtn');
            var searchIndicator = document.getElementById('searchIndicator');
            var searchResultCount = document.getElementById('searchResultCount');
            var totalCountEl = document.getElementById('quoteTotalCount');
            var loadingTimeout = null;

            function resetToInitial() {
                if (searchInput) {
                    searchInput.value = '';
                }
                if (statusSelect) {
                    statusSelect.value = '';
                }

                if (searchIndicator) {
                    searchIndicator.classList.remove('active');
                }

                var url = new URL(window.location.href);
                url.searchParams.delete('q');
                url.searchParams.delete('status');
                window.history.replaceState({}, '', url.toString());

                updateResults(true);
            }

            function updateResults(isReset = false) {
                tableContainer.classList.add('loading');
                
                var q = searchInput ? searchInput.value : '';
                var status = statusSelect ? statusSelect.value : '';
                
                var url = '{{ route("quotes.index") }}';
                var params = [];
                if (!isReset && q) params.push('q=' + encodeURIComponent(q));
                if (!isReset && status) params.push('status=' + encodeURIComponent(status));
                if (params.length > 0) url += '?' + params.join('&');
                
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
                    
                    var newPagination = doc.querySelector('#paginationBar');
                    if (newPagination && paginationBar) {
                        paginationBar.innerHTML = newPagination.innerHTML;
                    } else if (!newPagination && paginationBar) {
                        paginationBar.remove();
                    }

                    var newTotal = doc.querySelector('#quoteTotalCount');
                    if (newTotal && totalCountEl) {
                        totalCountEl.textContent = newTotal.textContent;
                    }

                    if (searchIndicator && searchResultCount && !isReset && (q || status)) {
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
                    }, 400);
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

            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }

                    var url = new URL(window.location.href);
                    if (this.value !== '') {
                        url.searchParams.set('status', this.value);
                    } else {
                        url.searchParams.delete('status');
                    }
                    window.history.replaceState({}, '', url.toString());

                    updateResults(false);
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    resetToInitial();
                });
            }

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.quotes-btn');
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