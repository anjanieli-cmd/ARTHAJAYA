<x-app-layout>
    <x-slot name="title">Pengeluaran</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // 🔧 SEEDING SESSION — biar show/edit/delete bisa nemu datanya
        if (!session()->has('expenses')) {
            session(['expenses' => $expenses]);
        }

        $expensesCollection = collect($expenses);
        $statusLabel = ['lunas' => 'Lunas', 'pending' => 'Pending'];
        $statusPill  = ['lunas' => 'lunas', 'pending' => 'pending'];

        $totalPengeluaran = $expensesCollection->sum('amount');
        $totalLunas       = $expensesCollection->where('status', 'lunas')->sum('amount');
        $totalPending     = $expensesCollection->where('status', 'pending')->sum('amount');
        $countPending     = $expensesCollection->where('status', 'pending')->count();
        $countLunas       = $expensesCollection->where('status', 'lunas')->count();
        
        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }

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
        </defs>
    </svg>

    <style>
        .exp-modern {
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

        .exp-modern * { box-sizing: border-box; }
        .exp-modern .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulseGlow { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
        @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalSlideUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

        .exp-modern .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .exp-modern .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

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
            display:flex; align-items:center; gap:12px; flex-wrap:wrap;
            background:var(--bg-card); padding:12px 20px; border-radius:var(--radius-sm);
            border:1px solid var(--border-color); margin-bottom:16px; transition: all 0.3s ease;
        }
        .filter-bar:focus-within { border-color: var(--theme-primary); box-shadow: 0 0 0 3px var(--theme-soft); }
        .filter-bar form{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; width:100%; }
        .search-wrap{ position:relative; flex:1; min-width:220px; }
        .search-wrap .icon{ position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:var(--text-tertiary); pointer-events:none; transition: color 0.3s ease; }
        .search-wrap:focus-within .icon { color: var(--theme-primary); }
        .filter-bar input[type=text]{ width:100%; padding:10px 16px 10px 42px; border-radius:var(--radius-sm); background:var(--bg-card-active); border:1px solid transparent; color:var(--text-primary); font-size:13px; outline:none; transition:all .3s ease; font-family:inherit; }
        .filter-bar input[type=text]:focus{ border-color:var(--theme-primary); background:var(--bg-card); box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.1); }
        .filter-bar input[type=text]::placeholder{ color:var(--text-tertiary); }
        .filter-actions{ display:flex; gap:8px; align-items:center; }
        .filter-actions .exp-btn { padding: 8px 14px; font-size: 12px; }
        .search-indicator { font-size: 12px; color: var(--text-tertiary); padding: 4px 12px; background: var(--bg-card-active); border-radius: 20px; white-space: nowrap; display: none; align-items: center; gap: 6px; }
        .search-indicator.active { display: inline-flex; }
        .search-indicator .count { font-weight: 600; color: var(--text-primary); }

        /* ===== HEADER ===== */
        .exp-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; flex-wrap: wrap; margin-bottom: 28px; padding: 0 4px; }
        .exp-header-left { flex: 1; min-width: 200px; }
        .exp-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px 6px 10px; background: var(--theme-glow); border: 1px solid var(--theme-glow); border-radius: 100px; font-size: 11px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--theme-primary); margin-bottom: 12px; }
        .exp-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--theme-primary); animation: pulseGlow 2s ease-in-out infinite; }
        .exp-header h1 { font-size: 28px; font-weight: 700; margin: 0 0 6px; background: linear-gradient(135deg, var(--text) 60%, var(--theme-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.02em; }
        .exp-header .subtitle { font-size: 14px; color: var(--text-secondary); margin: 0; }
        .exp-header .subtitle strong { color: var(--text-primary); font-weight: 600; }
        .exp-header-actions { display: flex; gap: 10px; flex-shrink: 0; flex-wrap: wrap; }

        .exp-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); background: transparent; color: var(--text-secondary); position: relative; overflow: hidden; }
        .exp-btn .icon { width: 16px; height: 16px; }
        .exp-btn:hover { transform: translateY(-2px); }
        .exp-btn:active { transform: translateY(0) scale(0.97); }
        .exp-btn-primary { background: var(--theme-gradient); color: #fff; box-shadow: 0 4px 16px var(--theme-glow); }
        .exp-btn-primary:hover { box-shadow: 0 8px 28px var(--theme-glow); transform: translateY(-2px); color: #fff; }
        .exp-btn-ghost { background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-secondary); }
        .exp-btn-ghost:hover { background: var(--bg-card-hover); border-color: var(--border-hover); color: var(--text-primary); }
        .exp-btn .ripple { position: absolute; border-radius: 50%; background: rgba(255, 255, 255, 0.2); transform: scale(0); animation: rippleAnim 0.6s ease-out forwards; pointer-events: none; }

        /* ===== SUCCESS ===== */
        .exp-success { background: var(--success-soft); border: 1px solid var(--success); border-radius: var(--radius-sm); padding: 14px 20px; margin-bottom: 20px; color: var(--success); display: flex; align-items: center; gap: 10px; }
        .exp-success .icon { width: 20px; height: 20px; }
        .exp-success .message { font-weight: 500; }

        /* ===== STATS ===== */
        .exp-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
        .exp-stat-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 22px 24px; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); position: relative; overflow: hidden; }
        .exp-stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent, var(--theme-light), transparent); opacity: 0; transition: opacity 0.3s ease; }
        .exp-stat-card:hover { background: var(--bg-card-hover); border-color: var(--border-hover); transform: translateY(-2px); }
        .exp-stat-card:hover::before { opacity: 1; }
        .exp-stat-card .stat-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .exp-stat-card .stat-head .ic { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: var(--theme-soft); color: var(--theme-primary); }
        .exp-stat-card .stat-head .ic .icon { width: 17px; height: 17px; }
        .exp-stat-card .stat-head .badge { font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 100px; background: var(--warning-soft); color: var(--warning); }
        .exp-stat-card .stat-head .badge.success { background: var(--success-soft); color: var(--success); }
        .exp-stat-card .stat-label { font-size: 12px; color: var(--text-tertiary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .exp-stat-card .stat-value { font-size: 26px; font-weight: 700; letter-spacing: -0.02em; color: var(--text-primary); }
        .exp-stat-card .stat-value.primary { color: var(--theme-primary); }
        .exp-stat-card .stat-value.success { color: var(--success); }
        .exp-stat-card .stat-value.warning { color: var(--warning); }
        .exp-stat-card .stat-sub { font-size: 12px; color: var(--text-tertiary); margin-top: 4px; }

        /* ===== TABLE ===== */
        .exp-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; transition: border-color 0.22s ease; }
        .exp-card:hover { border-color: var(--border-hover); }
        .exp-card-header { display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1px solid var(--border-color); }
        .exp-card-header h3 { font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0; }
        .exp-card-header .link { font-size: 12.5px; color: var(--theme-primary); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; }
        .exp-card-header .link .icon { width: 13px; height: 13px; }
        .exp-card-header .link:hover { text-decoration: underline; }
        .exp-table-wrap { overflow-x: auto; padding: 0 4px 4px 4px; }
        .exp-table-wrap.loading { opacity: 0.5; pointer-events: none; transition: opacity 0.3s ease; }
        .exp-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        .exp-table th { text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary); padding: 14px 16px 10px; border-bottom: 1px solid var(--border-color); }
        .exp-table th.text-right { text-align: right; }
        .exp-table td { padding: 14px 16px; border-bottom: 1px solid var(--border-color); color: var(--text-primary); vertical-align: middle; }
        .exp-table tbody tr { transition: background 0.2s ease; }
        .exp-table tbody tr:hover { background: var(--bg-card-hover); }
        .exp-table tbody tr:last-child td { border-bottom: none; }

        .exp-desc { display: flex; align-items: center; gap: 12px; }
        .exp-desc .icon-wrap { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; background: var(--theme-soft); color: var(--theme-primary); flex-shrink: 0; }
        .exp-desc .icon-wrap .icon { width: 15px; height: 15px; }
        .exp-desc .text { font-weight: 500; color: var(--text-primary); }
        .exp-category { font-size: 12px; font-weight: 500; padding: 4px 12px; border-radius: 100px; background: var(--bg-card-active); color: var(--text-secondary); display: inline-block; border: 1px solid var(--border-color); }
        .exp-status { font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 100px; display: inline-block; text-transform: uppercase; letter-spacing: 0.04em; }
        .exp-status.lunas { background: var(--success-soft); color: var(--success); }
        .exp-status.pending { background: var(--warning-soft); color: var(--warning); }
        .exp-amount { font-family: 'IBM Plex Mono', monospace; font-weight: 600; font-size: 13.5px; text-align: right; color: var(--text-primary); }
        .exp-item-actions { display: flex; gap: 6px; justify-content: flex-end; }
        .exp-item-actions .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; color: var(--text-tertiary); background: transparent; border: 1px solid var(--border-color); text-decoration: none; transition: all 0.2s ease; cursor: pointer; font-size: 13px; }
        .exp-item-actions .btn-action .icon { width: 14px; height: 14px; }
        .exp-item-actions .btn-action.show { color: var(--theme-primary); }
        .exp-item-actions .btn-action.show:hover { background: var(--theme-soft); border-color: var(--theme-primary); }
        .exp-item-actions .btn-action.edit { color: #4FA6E8; }
        .exp-item-actions .btn-action.edit:hover { background: rgba(79, 166, 232, 0.12); border-color: #4FA6E8; }
        .exp-item-actions .btn-action.danger { color: var(--danger); }
        .exp-item-actions .btn-action.danger:hover { background: var(--danger-soft); border-color: var(--danger); }

        .exp-empty { text-align: center; padding: 60px 20px; color: var(--text-tertiary); }
        .exp-empty .empty-icon { width: 56px; height: 56px; margin: 0 auto 16px; color: var(--theme-primary); opacity: 0.5; }
        .exp-empty h3 { font-size: 18px; font-weight: 600; margin: 0 0 6px; color: var(--text-primary); }
        .exp-empty p { color: var(--text-secondary); margin: 0 0 20px; font-size: 14px; }

        /* ============================================================
           MODAL DELETE - PINGGIRAN BULAT 24px (SAMA KAYA AGING)
           ============================================================ */
        .exp-modal-overlay {
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

        .exp-modal-overlay.open.active {
            display: flex;
        }

        [data-theme="dark"] .exp-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .exp-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .exp-modal-box {
            border-radius: 24px;              /* <--- INI BIKIN GA LANCIP! */
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .exp-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .exp-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .exp-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .exp-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .exp-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .exp-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .exp-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .exp-modal-box .expense-desc {
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

        .exp-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .exp-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .exp-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .exp-modal-actions .btn {
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

        .exp-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .exp-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .exp-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .exp-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .exp-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .exp-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .exp-modal-actions .btn-danger:hover {
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
        @media (max-width: 992px) { .exp-stats { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .exp-table { font-size: 12.5px; }
            .exp-table th, .exp-table td { padding: 10px 12px; }
            .exp-card-header { padding: 14px 16px; flex-direction: column; gap: 8px; align-items: flex-start; }
            .exp-item-actions { justify-content: flex-start; }
            .filter-bar { flex-direction: column; align-items: stretch; gap: 10px; padding: 12px 16px; }
            .filter-bar form { flex-direction: column; }
            .search-wrap { min-width: 100%; }
            .filter-actions { width: 100%; justify-content: flex-end; flex-wrap: wrap; }
            .exp-modal-box { padding: 24px 20px; margin: 10px; }
            .exp-modal-actions { flex-direction: column; }
            .exp-modal-actions .btn { width: 100%; }
        }
        @media (max-width: 640px) {
            .exp-header { flex-direction: column; }
            .exp-header-actions { width: 100%; }
            .exp-header-actions .exp-btn { flex: 1; justify-content: center; }
            .exp-stats { grid-template-columns: 1fr; gap: 12px; }
            .exp-stat-card .stat-value { font-size: 22px; }
            .exp-desc .text { font-size: 12.5px; }
            .exp-item-actions { opacity: 1; }
            .exp-modal-box { padding: 20px 16px; }
            .exp-modal-box h3 { font-size: 18px; }
            .exp-modal-box .icon-danger { width: 48px; height: 48px; }
            .exp-modal-box .icon-danger svg { width: 24px; height: 24px; }
        }
        @media (max-width: 380px) {
            .exp-header h1 { font-size: 22px; }
            .exp-btn { font-size: 12px; padding: 8px 14px; }
            .exp-btn .icon { width: 14px; height: 14px; }
        }
    </style>

    <div class="exp-modern">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- ===== HEADER ===== -->
        <div class="exp-header animate-in" style="animation-delay: 0.05s;">
            <div class="exp-header-left">
                <div class="exp-badge">
                    <span class="dot"></span>
                    Pembelian &amp; Biaya
                </div>
                <h1>Pengeluaran</h1>
                <p class="subtitle">
                    Catatan seluruh biaya dan pembelian usaha — 
                    <strong id="expTotalCount">{{ $expensesCollection->count() }}</strong> transaksi
                </p>
            </div>
            <div class="exp-header-actions">
                <a href="{{ route('expense-categories.index') }}" class="exp-btn exp-btn-ghost">
                    <svg class="icon"><use href="#ic-file-text"/></svg>
                    Kategori Biaya
                </a>
                <a href="{{ route('expenses.create') }}" class="exp-btn exp-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Catat Pengeluaran
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="exp-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="exp-success" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <span class="message">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ===== STATS ===== -->
        <div class="exp-stats" id="expStatCards">
            <div class="exp-stat-card animate-in" style="animation-delay: 0.10s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-trending"/></svg>
                    </div>
                </div>
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value primary mono" id="expTotalAmount">{{ $currencySymbol }}{{ formatAngkaPendek($totalPengeluaran) }}</div>
                <div class="stat-sub" id="expTotalSub">{{ $countLunas + $countPending }} transaksi total</div>
            </div>

            <div class="exp-stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                    </div>
                    <span class="badge success" id="expPaidCount">{{ $countLunas }} transaksi</span>
                </div>
                <div class="stat-label">Sudah Dibayar</div>
                <div class="stat-value success mono" id="expPaidAmount">{{ $currencySymbol }}{{ formatAngkaPendek($totalLunas) }}</div>
                <div class="stat-sub" id="expPaidSub">{{ $totalPengeluaran > 0 ? round(($totalLunas / $totalPengeluaran) * 100) : 0 }}% dari total</div>
            </div>

            <div class="exp-stat-card animate-in" style="animation-delay: 0.20s;">
                <div class="stat-head">
                    <div class="ic">
                        <svg class="icon"><use href="#ic-clock"/></svg>
                    </div>
                    <span class="badge" id="expPendingCount">{{ $countPending }} transaksi</span>
                </div>
                <div class="stat-label">Menunggu Pembayaran</div>
                <div class="stat-value warning mono" id="expPendingAmount">{{ $currencySymbol }}{{ formatAngkaPendek($totalPending) }}</div>
                <div class="stat-sub" id="expPendingSub">{{ $totalPengeluaran > 0 ? round(($totalPending / $totalPengeluaran) * 100) : 0 }}% dari total</div>
            </div>
        </div>

        <!-- ===== TABLE ===== -->
        <div class="exp-card animate-in" style="animation-delay: 0.25s;">
            <div class="exp-card-header">
                <h3>Daftar Pengeluaran</h3>
                <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="link">
                    Buku besar biaya
                    <svg class="icon"><use href="#ic-chevron-right"/></svg>
                </a>
            </div>

            <!-- ===== FILTER BAR ===== -->
            <div class="filter-bar animate-in" style="animation-delay: 0.27s;">
                <form method="GET" action="{{ route('expenses.index') }}" id="filterForm">
                    <div class="search-wrap">
                        <svg class="icon"><use href="#ic-search"/></svg>
                        <input type="text" name="q" id="expSearchInput" value="{{ request('q') }}" placeholder="Cari deskripsi atau kategori..." autocomplete="off">
                    </div>
                    <div class="filter-actions">
                        <span class="search-indicator" id="searchIndicator">
                            <span class="count" id="searchResultCount">0</span> hasil ditemukan
                        </span>
                        <a href="{{ route('expenses.index') }}" class="exp-btn exp-btn-ghost" id="resetBtn">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="exp-table-wrap" id="expTableWrap">
                <table class="exp-table">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-right">Jumlah</th>
                            <th style="width:120px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="expTableBody">
                        @forelse($expenses as $index => $e)
                            <tr>
                                <td>
                                    <div class="exp-desc">
                                        <div class="icon-wrap">
                                            <svg class="icon"><use href="#ic-file-text"/></svg>
                                        </div>
                                        <span class="text">{{ $e['desc'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="exp-category">{{ $e['kategori'] }}</span>
                                </td>
                                <td>{{ formatTanggal($e['date']) }}</td>
                                <td>
                                    <span class="exp-status {{ $statusPill[$e['status']] }}">
                                        {{ $statusLabel[$e['status']] }}
                                    </span>
                                </td>
                                <td class="exp-amount mono">
                                    {{ $currencySymbol }}{{ formatAngkaPendek($e['amount']) }}
                                </td>
                                <td>
                                    <div class="exp-item-actions">
                                        <a href="/expenses/show/{{ $index }}" class="btn-action show" title="Lihat Detail">
                                            <svg class="icon"><use href="#ic-eye"/></svg>
                                        </a>
                                        <a href="/expenses/edit/{{ $index }}" class="btn-action edit" title="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        <button type="button" class="btn-action danger" title="Hapus"
                                                onclick="openDeleteModal('{{ $index }}', '{{ addslashes($e['desc']) }}')">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="exp-empty">
                                        <svg class="empty-icon"><use href="#ic-file-text"/></svg>
                                        <h3>Belum Ada Pengeluaran</h3>
                                        <p>Belum ada pengeluaran yang tercatat di sistem.</p>
                                        <a href="{{ route('expenses.create') }}" class="exp-btn exp-btn-primary" style="display: inline-flex;">
                                            <svg class="icon"><use href="#ic-plus"/></svg>
                                            Catat Pengeluaran Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ============================================================
         MODAL DELETE - PINGGIRAN BULAT 24px (SAMA KAYA AGING)
         ============================================================ -->
    <div class="exp-modal-overlay" id="deleteModal">
        <div class="exp-modal-box">
            <!-- ICON DANGER -->
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <!-- JUDUL -->
            <h3>Hapus Pengeluaran Ini?</h3>

            <!-- DESKRIPSI -->
            <p>
                Anda yakin ingin menghapus pengeluaran
                <br>
                <span class="expense-desc" id="deleteExpenseDesc">—</span>
            </p>

            <!-- WARNING -->
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <!-- TOMBOL -->
            <div class="exp-modal-actions">
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
            setTimeout(() => { if (toast.parentElement) toast.remove(); }, 5000);
        }

        // ===== DELETE MODAL =====
        function openDeleteModal(index, description) {
            document.getElementById('deleteExpenseDesc').textContent = description;
            var url = '/expenses/delete/' + index;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('open', 'active');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('aj-modal-open');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('open', 'active');
            document.body.style.overflow = '';
            document.body.classList.remove('aj-modal-open');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) { closeDeleteModal(); }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { closeDeleteModal(); }
        });

        // ===== DOM READY =====
        document.addEventListener('DOMContentLoaded', function() {
            // ===== LIVE SEARCH =====
            var searchInput = document.getElementById('expSearchInput');
            var expTableWrap = document.getElementById('expTableWrap');
            var expTableBody = document.getElementById('expTableBody');
            var expStatCards = document.getElementById('expStatCards');
            var resetBtn = document.getElementById('resetBtn');
            var searchIndicator = document.getElementById('searchIndicator');
            var searchResultCount = document.getElementById('searchResultCount');
            var totalCountEl = document.getElementById('expTotalCount');
            var loadingTimeout = null;

            function resetToInitial() {
                if (searchInput) { searchInput.value = ''; }
                if (searchIndicator) { searchIndicator.classList.remove('active'); }
                var url = new URL(window.location.href);
                url.searchParams.delete('q');
                window.history.replaceState({}, '', url.toString());
                updateResults(true);
            }

            function updateResults(isReset = false) {
                expTableWrap.classList.add('loading');
                var q = searchInput ? searchInput.value : '';
                var url = '{{ route("expenses.index") }}';
                if (!isReset && q) { url += '?q=' + encodeURIComponent(q); }
                
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(response) {
                    if (!response.ok) { throw new Error('Network response was not ok'); }
                    return response.text();
                })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    
                    var newBody = doc.querySelector('#expTableBody');
                    if (newBody) { expTableBody.innerHTML = newBody.innerHTML; }
                    
                    var newStats = doc.querySelector('#expStatCards');
                    if (newStats) { expStatCards.innerHTML = newStats.innerHTML; }
                    
                    var newTotal = doc.querySelector('#expTotalCount');
                    if (newTotal && totalCountEl) { totalCountEl.textContent = newTotal.textContent; }

                    if (searchIndicator && searchResultCount && !isReset && q) {
                        var newRows = doc.querySelectorAll('#expTableBody tr');
                        var count = newRows.length;
                        if (count > 0) {
                            searchIndicator.classList.add('active');
                            searchResultCount.textContent = count;
                        } else {
                            searchIndicator.classList.remove('active');
                        }
                    } else if (isReset) {
                        if (searchIndicator) { searchIndicator.classList.remove('active'); }
                    }
                    
                    expTableWrap.classList.remove('loading');
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    expTableWrap.classList.remove('loading');
                    showToast('Error', 'Gagal memuat data. Silakan refresh halaman.', 'error');
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (loadingTimeout) { clearTimeout(loadingTimeout); }
                    var url = new URL(window.location.href);
                    if (this.value.trim() !== '') {
                        url.searchParams.set('q', this.value.trim());
                    } else {
                        url.searchParams.delete('q');
                    }
                    window.history.replaceState({}, '', url.toString());
                    loadingTimeout = setTimeout(function() { updateResults(false); }, 300);
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
            document.querySelectorAll('.exp-btn').forEach(btn => {
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
        });
    </script>

</x-app-layout>