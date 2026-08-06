<x-app-layout>
    <x-slot name="title">Kategori Biaya</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // Pastikan $categories adalah collection, jika array kosong buat collection kosong
        if (!is_array($categories) && !is_object($categories)) {
            $categories = collect();
        }
        
        // Jika array, konversi ke collection
        if (is_array($categories)) {
            $categories = collect($categories);
        }

        // Hitung statistik dari data
        $totalKategori = $categories->count();
        $totalSemuaBiaya = 0;
        $totalTransaksi = 0;
        
        // Iterasi manual untuk menghitung total
        foreach ($categories as $cat) {
            $totalSemuaBiaya += isset($cat['total']) ? $cat['total'] : (isset($cat->total) ? $cat->total : 0);
            $totalTransaksi += isset($cat['count']) ? $cat['count'] : (isset($cat->count) ? $cat->count : 0);
        }
        
        $kategoriTerbesar = $categories->sortByDesc(function($item) {
            return isset($item['total']) ? $item['total'] : (isset($item->total) ? $item->total : 0);
        })->first();

        $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A', '#14B8A6', '#F97316'];

        function formatAngkaPendek($angka) {
            if ($angka >= 1000000000) {
                return number_format($angka / 1000000000, 1, ',', '') . ' M';
            } elseif ($angka >= 1000000) {
                return number_format($angka / 1000000, 1, ',', '') . ' Jt';
            } elseif ($angka >= 1000) {
                return number_format($angka / 1000, 0, ',', '') . ' Rb';
            } else {
                return number_format($angka, 0, ',', '.');
            }
        }
        
        // Helper untuk mendapatkan nilai dari object atau array
        function getValue($item, $key, $default = 0) {
            if (is_array($item)) {
                return $item[$key] ?? $default;
            } elseif (is_object($item)) {
                return $item->$key ?? $default;
            }
            return $default;
        }
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
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-chevron-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </symbol>
            <symbol id="ic-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>
            </symbol>
            <symbol id="ic-layers" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>
            </symbol>
        </defs>
    </svg>

    <style>
        /* ============================================
           KATEGORI BIAYA - Modern Card Grid Design
           ============================================ */
        
        .cat-modern {
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
            
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .cat-modern * { box-sizing: border-box; }
        .cat-modern .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .cat-modern .animate-in { animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cat-modern .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .cat-modern svg { fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

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
            margin-bottom:24px;
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

        .search-wrap:focus-within .icon { color: var(--theme-primary); }

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

        .filter-bar input[type=text]::placeholder{ color:var(--text-tertiary); }

        .filter-actions{
            display:flex;
            gap:8px;
            align-items:center;
        }

        .filter-actions .cat-btn { padding: 8px 14px; font-size: 12px; }

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

        .search-indicator.active { display: inline-flex; }
        .search-indicator .count { font-weight: 600; color: var(--text-primary); }

        /* HEADER */
        .cat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 32px;
            padding: 0 4px;
        }

        .cat-header-left { flex: 1; min-width: 200px; }

        .cat-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px 6px 12px;
            background: var(--theme-glow);
            border: 1px solid var(--theme-glow);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--theme-primary);
            margin-bottom: 14px;
        }

        .cat-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cat-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cat-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cat-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .cat-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cat-btn {
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
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background: transparent;
            color: var(--text-secondary);
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .cat-btn .icon { width: 16px; height: 16px; }
        .cat-btn:hover { transform: translateY(-2px); }
        .cat-btn:active { transform: translateY(0) scale(0.97); }

        .cat-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cat-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cat-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cat-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cat-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

        /* SUCCESS MESSAGE */
        .cat-success {
            background: var(--success-soft);
            border: 1px solid var(--success);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
            margin-bottom: 24px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 13px;
        }

        .cat-success .icon { width: 20px; height: 20px; flex-shrink: 0; }
        .cat-success .message { font-weight: 500; }

        /* STATS */
        .cat-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .cat-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .cat-stat-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .cat-stat-card .stat-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .cat-stat-card .stat-head .ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .cat-stat-card .stat-head .ic .icon { width: 17px; height: 17px; }

        .cat-stat-card .stat-head .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .cat-stat-card .stat-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            padding-left: 4px;
        }

        .cat-stat-card .stat-value.primary { color: var(--theme-primary); }
        .cat-stat-card .stat-value.warning { color: #F0A83C; }

        .cat-stat-card .stat-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 4px;
            padding-left: 4px;
        }

        /* CATEGORY GRID */
        .cat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .cat-grid.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .cat-item {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .cat-item:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .cat-item .color-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            opacity: 0.7;
        }

        .cat-item:hover .color-bar { opacity: 1; }

        .cat-item .cat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .cat-item .cat-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .cat-item .cat-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .cat-item .cat-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 16px;
            line-height: 1.5;
            word-break: break-word;
        }

        .cat-item .cat-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
        }

        .cat-item .cat-footer .stat {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cat-item .cat-footer .stat .icon {
            width: 14px;
            height: 14px;
            color: var(--text-tertiary);
        }

        .cat-item .cat-footer .stat .label {
            font-size: 12px;
            color: var(--text-tertiary);
        }

        .cat-item .cat-footer .stat .value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cat-item .cat-footer .total {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 15px;
            font-weight: 700;
            color: var(--theme-primary);
        }

        /* ACTION BUTTONS */
        .cat-actions {
            display: flex;
            gap: 4px;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .cat-item:hover .cat-actions { opacity: 1; }

        .cat-actions .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-tertiary);
            background: transparent;
            border: 1px solid var(--border-color);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .cat-actions .btn-action .icon { width: 14px; height: 14px; }

        .cat-actions .btn-action.show { color: var(--theme-primary); }
        .cat-actions .btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .cat-actions .btn-action.edit { color: #4FA6E8; }
        .cat-actions .btn-action.edit:hover {
            background: rgba(79, 166, 232, 0.12);
            border-color: #4FA6E8;
        }

        .cat-actions .btn-action.danger { color: var(--danger); }
        .cat-actions .btn-action.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        /* EMPTY STATE */
        .cat-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
            grid-column: 1 / -1;
        }

        .cat-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .cat-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .cat-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ===== MODAL DELETE ===== */
        .cat-modal-overlay {
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

        .cat-modal-overlay.active { display: flex; }

        [data-theme="dark"] .cat-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .cat-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .cat-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .cat-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .cat-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .cat-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .cat-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .cat-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .cat-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .cat-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .cat-modal-box .category-name {
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

        .cat-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .cat-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .cat-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .cat-modal-actions .btn {
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

        .cat-modal-actions .btn .icon { width: 16px; height: 16px; }

        .cat-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cat-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .cat-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .cat-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .cat-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .cat-modal-actions .btn-danger:hover {
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

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .cat-stats { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .cat-grid { grid-template-columns: 1fr; }
            .cat-actions { opacity: 1; }
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 12px 16px;
            }
            .filter-bar form { flex-direction: column; }
            .search-wrap { min-width: 100%; }
            .filter-actions {
                width: 100%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }
            .cat-modal-box {
                padding: 24px 20px;
                margin: 10px;
            }
            .cat-modal-actions { flex-direction: column; }
            .cat-modal-actions .btn { width: 100%; }
        }

        @media (max-width: 640px) {
            .cat-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .cat-header-actions {
                width: 100%;
            }
            .cat-header-actions .cat-btn {
                flex: 1;
                justify-content: center;
            }
            .cat-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .cat-stat-card .stat-value { font-size: 22px; }
            .cat-item { padding: 18px 16px; }
            .cat-modal-box {
                padding: 20px 16px;
            }
            .cat-modal-box h3 { font-size: 18px; }
            .cat-modal-box .icon-danger {
                width: 48px;
                height: 48px;
            }
            .cat-modal-box .icon-danger svg {
                width: 24px;
                height: 24px;
            }
        }

        @media (max-width: 380px) {
            .cat-header h1 { font-size: 22px; }
            .cat-btn {
                font-size: 12px;
                padding: 8px 14px;
            }
            .cat-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="cat-modern">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- HEADER -->
        <div class="cat-header animate-in" style="animation-delay: 0.05s;">
            <div class="cat-header-left">
                <div class="cat-badge">
                    <span class="dot"></span>
                    Pembelian &amp; Biaya
                </div>
                <h1>Kategori Biaya</h1>
                <p class="subtitle">
                    Kelompokkan pengeluaran usaha agar laporan lebih rapi — 
                    <strong id="catTotalCount">{{ $totalKategori }}</strong> kategori aktif
                </p>
            </div>
            <div class="cat-header-actions">
                <a href="{{ route('expenses.index') }}" class="cat-btn cat-btn-ghost">
                    <svg class="icon"><use href="#ic-file-text"/></svg>
                    Lihat Pengeluaran
                </a>
                <a href="{{ route('expense-categories.create') }}" class="cat-btn cat-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Kategori Baru
                </a>
            </div>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="cat-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="cat-success" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <span class="message">{{ session('error') }}</span>
            </div>
        @endif

        <!-- STATS -->
        <div class="cat-stats" id="catStatCards">
            <div class="cat-stat-card animate-in" style="animation-delay: 0.10s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-tag"/></svg>
                    </div>
                    <span class="label">Total Kategori</span>
                </div>
                <div class="stat-value primary" id="catStatTotal">{{ $totalKategori }}</div>
                <div class="stat-sub">Kelompok biaya aktif</div>
            </div>

            <div class="cat-stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-file-text"/></svg>
                    </div>
                    <span class="label">Total Transaksi</span>
                </div>
                <div class="stat-value" id="catStatTransaksi">{{ $totalTransaksi }}</div>
                <div class="stat-sub">Pengeluaran tercatat</div>
            </div>

            <div class="cat-stat-card animate-in" style="animation-delay: 0.20s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-trending"/></svg>
                    </div>
                    <span class="label">Total Biaya</span>
                </div>
                <div class="stat-value primary mono" id="catStatTotalBiaya">{{ $currencySymbol }}{{ formatAngkaPendek($totalSemuaBiaya) }}</div>
                <div class="stat-sub">Semua kategori</div>
            </div>

            <div class="cat-stat-card animate-in" style="animation-delay: 0.25s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-layers"/></svg>
                    </div>
                    <span class="label">Kategori Terbesar</span>
                </div>
                <div class="stat-value warning" id="catStatTerbesar">{{ $kategoriTerbesar['name'] ?? '-' }}</div>
                <div class="stat-sub mono" id="catStatTerbesarTotal">{{ $kategoriTerbesar ? $currencySymbol . formatAngkaPendek($kategoriTerbesar['total'] ?? 0) : 'Tidak ada data' }}</div>
            </div>
        </div>

        <!-- ===== FILTER BAR ===== -->
        <div class="filter-bar animate-in" style="animation-delay: 0.27s;">
            <form method="GET" action="{{ route('expense-categories.index') }}" id="filterForm">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="catSearchInput" value="{{ request('q') }}" placeholder="Cari nama atau deskripsi kategori..." autocomplete="off">
                </div>
                <div class="filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <a href="{{ route('expense-categories.index') }}" class="cat-btn cat-btn-ghost" id="resetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- CATEGORY GRID -->
        <div class="cat-grid" id="catGrid">
            @forelse($categories as $category)
                @php
                    $color = $colors[$loop->index % count($colors)];
                    
                    // Handle jika array atau object
                    if (is_array($category)) {
                        $id = $category['id'] ?? $loop->index;
                        $name = $category['name'] ?? 'Kategori';
                        $desc = $category['description'] ?? (isset($category['desc']) ? $category['desc'] : '-');
                        $total = $category['total'] ?? (isset($category['total_expenses']) ? $category['total_expenses'] : 0);
                        $count = $category['count'] ?? (isset($category['count_expenses']) ? $category['count_expenses'] : 0);
                    } else {
                        $id = $category->id ?? $loop->index;
                        $name = $category->name ?? 'Kategori';
                        $desc = $category->description ?? (isset($category->desc) ? $category->desc : '-');
                        $total = $category->total ?? (isset($category->total_expenses) ? $category->total_expenses : 0);
                        $count = $category->count ?? (isset($category->count_expenses) ? $category->count_expenses : 0);
                    }
                @endphp
                <div class="cat-item animate-in" style="animation-delay: {{ 0.30 + ($loop->index * 0.05) }}s;" data-id="{{ $id }}">
                    <div class="color-bar" style="background: {{ $color }};"></div>
                    
                    <div class="cat-top">
                        <div class="cat-avatar" style="background: {{ $color }};">
                            {{ mb_substr($name, 0, 1) }}
                        </div>
                        <div class="cat-actions">
                            <a href="{{ route('expense-categories.show', $id) }}" class="btn-action show" title="Lihat Detail">
                                <svg class="icon"><use href="#ic-eye"/></svg>
                            </a>
                            <a href="{{ route('expense-categories.edit', $id) }}" class="btn-action edit" title="Edit">
                                <svg class="icon"><use href="#ic-edit"/></svg>
                            </a>
                            <button type="button" class="btn-action danger" title="Hapus"
                                    onclick="openDeleteModal('{{ $id }}', '{{ $name }}')">
                                <svg class="icon"><use href="#ic-trash"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="cat-name">{{ $name }}</div>
                    <div class="cat-desc">{{ $desc }}</div>

                    <div class="cat-footer">
                        <div class="stat">
                            <svg class="icon"><use href="#ic-file-text"/></svg>
                            <span class="label">Transaksi</span>
                            <span class="value mono">{{ $count }}</span>
                        </div>
                        <div class="total mono">{{ $currencySymbol }}{{ formatAngkaPendek($total) }}</div>
                    </div>
                </div>
            @empty
                <div class="cat-empty animate-in" style="animation-delay: 0.35s;">
                    <svg class="empty-icon"><use href="#ic-tag"/></svg>
                    <h3>Belum Ada Kategori</h3>
                    <p>Belum ada kategori biaya yang tercatat di sistem.</p>
                    <a href="{{ route('expense-categories.create') }}" class="cat-btn cat-btn-primary" style="display: inline-flex;">
                        <svg class="icon"><use href="#ic-plus"/></svg>
                        Buat Kategori Pertama
                    </a>
                </div>
            @endforelse
        </div>

    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="cat-modal-overlay" id="deleteModal">
        <div class="cat-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Kategori?</h3>
            <p>
                Anda yakin ingin menghapus kategori
                <br>
                <span class="category-name" id="deleteCategoryName">-</span>
            </p>
            <div class="warning-text">⚠️ Data yang dihapus tidak dapat dikembalikan!</div>

            <div class="cat-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
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
        function openDeleteModal(id, categoryName) {
            document.getElementById('deleteCategoryName').textContent = categoryName;
            document.getElementById('deleteForm').action = '/expense-categories/' + id;
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

        document.addEventListener('DOMContentLoaded', function() {
            // ===== LIVE SEARCH =====
            var searchInput = document.getElementById('catSearchInput');
            var catGrid = document.getElementById('catGrid');
            var catStatCards = document.getElementById('catStatCards');
            var resetBtn = document.getElementById('resetBtn');
            var searchIndicator = document.getElementById('searchIndicator');
            var searchResultCount = document.getElementById('searchResultCount');
            var totalCountEl = document.getElementById('catTotalCount');
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
                window.history.replaceState({}, {}, url.toString());

                updateResults(true);
            }

            function updateResults(isReset = false) {
                catGrid.classList.add('loading');
                
                var q = searchInput ? searchInput.value : '';
                var url = '{{ route("expense-categories.index") }}';
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
                    
                    var newGrid = doc.querySelector('#catGrid');
                    if (newGrid) {
                        catGrid.innerHTML = newGrid.innerHTML;
                    }
                    
                    var newStats = doc.querySelector('#catStatCards');
                    if (newStats) {
                        catStatCards.innerHTML = newStats.innerHTML;
                    }
                    
                    var newTotal = doc.querySelector('#catTotalCount');
                    if (newTotal && totalCountEl) {
                        totalCountEl.textContent = newTotal.textContent;
                    }

                    if (searchIndicator && searchResultCount && !isReset && q) {
                        var newItems = doc.querySelectorAll('.cat-item');
                        var count = newItems.length;
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
                    
                    catGrid.classList.remove('loading');
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    catGrid.classList.remove('loading');
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
                    window.history.replaceState({}, {}, url.toString());

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

            // Ripple effect
            const buttons = document.querySelectorAll('.cat-btn');
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