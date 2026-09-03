<x-app-layout>
    <x-slot name="title">Mutasi Rekening</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $defaultMutations = [
            ['desc' => 'Transfer masuk - Nusantara Logistik',   'date' => '2026-07-02', 'type' => 'masuk',  'amount' => 18400000, 'saldo' => 24650000],
            ['desc' => 'Pembayaran listrik workshop',            'date' => '2026-07-06', 'type' => 'keluar', 'amount' => 820000,   'saldo' => 23830000],
            ['desc' => 'Setoran tunai penjualan',                'date' => '2026-07-09', 'type' => 'masuk',  'amount' => 1500000,  'saldo' => 25330000],
            ['desc' => 'Biaya admin bank',                       'date' => '2026-07-10', 'type' => 'keluar', 'amount' => 25000,    'saldo' => 25305000],
            ['desc' => 'Transfer masuk - Ruang Kriya Studio',    'date' => '2026-07-12', 'type' => 'masuk',  'amount' => 6200000,  'saldo' => 31505000],
            ['desc' => 'Beli kain mori 50 meter',                'date' => '2026-07-01', 'type' => 'keluar', 'amount' => 2500000,  'saldo' => 22150000],
        ];

        // ===== SEEDING SESSION PAKAI KEY 'bank_mutations' =====
        if (!session()->has('bank_mutations') && !request()->filled('q')) {
            session(['bank_mutations' => $defaultMutations]);
        }

        $mutations = session('bank_mutations', []);
        $mutationsCollection = collect($mutations);
        $typeLabel = ['masuk' => 'Masuk', 'keluar' => 'Keluar'];

        $totalMasuk  = $mutationsCollection->where('type', 'masuk')->sum('amount');
        $totalKeluar = $mutationsCollection->where('type', 'keluar')->sum('amount');
        $saldoAkhir  = $mutationsCollection->sortBy('date')->last()['saldo'] ?? 0;
        $arus        = $totalMasuk + $totalKeluar;

        $sorted  = $mutationsCollection->sortByDesc('date');
        $byDate  = $sorted->groupBy('date');

        $jumlahMasuk = $mutationsCollection->where('type', 'masuk')->count();
        $jumlahKeluar = $mutationsCollection->where('type', 'keluar')->count();
        
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
            <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="10" width="20" height="14" rx="2"/>
                <path d="M12 3L2 10h20L12 3z"/>
                <line x1="8" y1="14" x2="8" y2="18"/>
                <line x1="12" y1="14" x2="12" y2="18"/>
                <line x1="16" y1="14" x2="16" y2="18"/>
            </symbol>
            <symbol id="ic-receive" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </symbol>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 17 9 11 13 15 21 7"/>
                <polyline points="14 7 21 7 21 14"/>
            </symbol>
            <symbol id="ic-trending-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 7 17 13 13 9 1 21"/>
                <polyline points="17 7 23 7 23 13"/>
            </symbol>
            <symbol id="ic-refresh" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"/>
                <polyline points="1 20 1 14 7 14"/>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </symbol>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </symbol>
            <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </symbol>
            <symbol id="ic-doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .mut-modern {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            
            --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.20);
            --shadow-glow: 0 8px 40px var(--theme-glow);
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .mut-modern * { box-sizing: border-box; }
        .mut-modern .num { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulseGlow { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
        @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalSlideUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

        .mut-modern .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .mut-modern .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .mut-modern .icon-sm { width: 14px; height: 14px; }
        .mut-modern .icon-lg { width: 22px; height: 22px; }

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

        /* ===== SUCCESS ===== */
        .mut-success {
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
        .mut-success .icon { width: 20px; height: 20px; }
        .mut-success .message { font-weight: 500; }

        /* ===== HEADER ===== */
        .mut-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }
        .mut-header-left { flex: 1; min-width: 200px; }
        .mut-badge {
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
        .mut-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--theme-primary); animation: pulseGlow 2s ease-in-out infinite; }
        .mut-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }
        .mut-header .subtitle { font-size: 14px; color: var(--text-secondary); margin: 0; }
        .mut-header .subtitle strong { color: var(--text-primary); font-weight: 600; }
        .mut-header-actions { display: flex; gap: 10px; flex-shrink: 0; flex-wrap: wrap; }

        .mut-btn {
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
            font-family: 'Inter', sans-serif;
        }
        .mut-btn .icon { width: 16px; height: 16px; }
        .mut-btn:hover { transform: translateY(-2px); }
        .mut-btn:active { transform: translateY(0) scale(0.97); }
        .mut-btn-primary { background: var(--theme-gradient); color: #fff; box-shadow: 0 4px 16px var(--theme-glow); }
        .mut-btn-primary:hover { box-shadow: 0 8px 28px var(--theme-glow); transform: translateY(-2px); color: #fff; }
        .mut-btn-ghost { background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-secondary); }
        .mut-btn-ghost:hover { background: var(--bg-card-hover); border-color: var(--border-hover); color: var(--text-primary); }
        .mut-btn .ripple { position: absolute; border-radius: 50%; background: rgba(255, 255, 255, 0.2); transform: scale(0); animation: rippleAnim 0.6s ease-out forwards; pointer-events: none; }

        /* ===== STATS ===== */
        .mut-stats {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 28px;
        }
        .mut-stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .mut-stat-card::before {
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
        .mut-stat-card:hover { background: var(--bg-card-hover); border-color: var(--border-hover); transform: translateY(-2px); }
        .mut-stat-card:hover::before { opacity: 1; }
        .mut-stat-card .label {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .mut-stat-card .label .icon { width: 14px; height: 14px; }
        .mut-stat-card .value { font-size: 28px; font-weight: 700; letter-spacing: -0.02em; }
        .mut-stat-card .value.saldo-value { color: var(--text-primary); }
        .mut-stat-card .value.masuk-value { color: var(--theme-primary); }
        .mut-stat-card .value.keluar-value { color: var(--theme-primary); }
        .mut-stat-card .trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 6px;
            padding: 2px 10px;
            border-radius: 100px;
        }
        .mut-stat-card .trend .icon { width: 12px; height: 12px; }
        .mut-stat-card .trend.up { color: var(--theme-primary); background: var(--theme-soft); }
        .mut-stat-card .trend.down { color: var(--theme-primary); background: var(--theme-soft); }

        /* ===== FLOW BAR ===== */
        .mut-flow-bar {
            grid-column: 1 / -1;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .mut-flow-bar .flow-labels { display: flex; gap: 20px; flex: 1; min-width: 160px; }
        .mut-flow-bar .flow-item { display: flex; align-items: center; gap: 8px; font-size: 13px; }
        .mut-flow-bar .flow-item .dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .mut-flow-bar .flow-item .dot.in { background: var(--theme-primary); }
        .mut-flow-bar .flow-item .dot.out { background: var(--theme-primary); }
        .mut-flow-bar .flow-item .amount { font-weight: 600; font-size: 14px; }
        .mut-flow-bar .flow-item .amount.in { color: var(--theme-primary); }
        .mut-flow-bar .flow-item .amount.out { color: var(--theme-primary); }
        .mut-flow-bar .flow-track { flex: 2; min-width: 120px; height: 6px; border-radius: 100px; background: var(--bg-card-active); overflow: hidden; position: relative; }
        .mut-flow-bar .flow-track .bar { height: 100%; border-radius: 100px; transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .mut-flow-bar .flow-track .bar.in { background: var(--theme-gradient); }
        .mut-flow-bar .flow-track .bar.out { background: var(--theme-gradient); }
        .mut-flow-bar .flow-percent { font-size: 12px; font-weight: 600; color: var(--theme-primary); min-width: 44px; text-align: right; }

        /* ===== FILTER ===== */
        .mut-filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: var(--bg-card);
            padding: 12px 20px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .mut-filter-bar:focus-within { border-color: var(--theme-primary); box-shadow: 0 0 0 3px var(--theme-soft); }
        .mut-filter-bar form { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; width: 100%; }
        .mut-search-wrap { position: relative; flex: 1; min-width: 220px; }
        .mut-search-wrap .icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-tertiary); pointer-events: none; transition: color 0.3s ease; }
        .mut-search-wrap:focus-within .icon { color: var(--theme-primary); }
        .mut-filter-bar input[type="text"] {
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
        .mut-filter-bar input[type="text"]:focus { border-color: var(--theme-primary); background: var(--bg-card); box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1); }
        .mut-filter-bar input[type="text"]::placeholder { color: var(--text-tertiary); }
        .mut-filter-actions { display: flex; gap: 8px; align-items: center; }
        .mut-filter-actions .mut-btn { padding: 8px 14px; font-size: 12px; }

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

        /* ===== DATE DIVIDER ===== */
        .mut-date-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 28px 0 14px;
        }
        .mut-date-divider:first-of-type { margin-top: 0; }
        .mut-date-divider .date-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-tertiary);
            padding: 4px 14px;
            background: var(--bg-card);
            border-radius: 100px;
            border: 1px solid var(--border-color);
            white-space: nowrap;
        }
        .mut-date-divider .line { flex: 1; height: 1px; background: linear-gradient(90deg, var(--border-color), transparent); }

        /* ===== TRANSACTIONS ===== */
        .mut-transactions { display: flex; flex-direction: column; gap: 8px; }
        .mut-transactions-wrap.loading { opacity: 0.5; pointer-events: none; transition: opacity 0.3s ease; }

        .mut-tx {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: default;
            position: relative;
            overflow: hidden;
        }
        .mut-tx::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .mut-tx:hover { background: var(--bg-card-hover); border-color: var(--border-hover); transform: translateX(4px); }
        .mut-tx:hover::before { opacity: 1; }
        .mut-tx.type-masuk::before { background: var(--theme-primary); }
        .mut-tx.type-keluar::before { background: var(--theme-primary); }

        .mut-tx .tx-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        .mut-tx:hover .tx-icon { transform: scale(1.05) rotate(-3deg); }
        .mut-tx .tx-icon .icon { width: 18px; height: 18px; }
        .mut-tx .tx-icon.in { background: var(--theme-soft); color: var(--theme-primary); }
        .mut-tx .tx-icon.out { background: var(--theme-soft); color: var(--theme-primary); }

        .mut-tx .tx-info { flex: 1; min-width: 0; }
        .mut-tx .tx-desc {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .mut-tx .tx-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 2px;
            font-size: 12px;
            color: var(--text-tertiary);
        }
        .mut-tx .tx-meta .tag {
            padding: 1px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .mut-tx .tx-meta .tag.in { background: var(--theme-soft); color: var(--theme-primary); }
        .mut-tx .tx-meta .tag.out { background: var(--theme-soft); color: var(--theme-primary); }

        .mut-tx .tx-right { text-align: right; flex-shrink: 0; }
        .mut-tx .tx-amount { font-size: 15px; font-weight: 700; }
        .mut-tx .tx-amount.in { color: var(--theme-primary); }
        .mut-tx .tx-amount.out { color: var(--theme-primary); }
        .mut-tx .tx-balance { font-size: 11.5px; color: var(--text-tertiary); margin-top: 2px; }

        .mut-tx .tx-actions {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
            margin-left: 4px;
        }
        .mut-tx .tx-actions .btn-action {
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
        .mut-tx .tx-actions .btn-action .icon { width: 14px; height: 14px; }
        .mut-tx .tx-actions .btn-action.show { color: var(--theme-primary); }
        .mut-tx .tx-actions .btn-action.show:hover { background: var(--theme-soft); border-color: var(--theme-primary); }
        .mut-tx .tx-actions .btn-action.edit { color: #4FA6E8; }
        .mut-tx .tx-actions .btn-action.edit:hover { background: rgba(79, 166, 232, 0.12); border-color: #4FA6E8; }
        .mut-tx .tx-actions .btn-action.danger { color: var(--danger); }
        .mut-tx .tx-actions .btn-action.danger:hover { background: var(--danger-soft); border-color: var(--danger); }

        /* ===== EMPTY ===== */
        .mut-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }
        .mut-empty .empty-icon { width: 56px; height: 56px; margin: 0 auto 16px; color: var(--theme-primary); opacity: 0.5; }
        .mut-empty h3 { font-size: 18px; font-weight: 600; margin: 0 0 6px; }
        .mut-empty p { color: var(--text-secondary); margin: 0 0 20px; font-size: 14px; }

        /* ===== FOOTER ===== */
        .mut-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }
        .mut-footer .info { font-size: 13px; color: var(--text-tertiary); display: flex; align-items: center; gap: 8px; }
        .mut-footer .info .icon { width: 14px; height: 14px; color: var(--theme-primary); }
        .mut-footer .actions { display: flex; gap: 12px; }
        .mut-footer .actions a {
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
        .mut-footer .actions a .icon { width: 14px; height: 14px; color: var(--theme-primary); }
        .mut-footer .actions a:hover { background: var(--bg-card); border-color: var(--border-color); color: var(--text-primary); }

        /* ============================================================
           MODAL DELETE - PINGGIRAN BULAT 24px
           ============================================================ */
        .mut-modal-overlay {
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
        .mut-modal-overlay.active { display: flex; }

        [data-theme="dark"] .mut-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .mut-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .mut-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }
        [data-theme="light"] .mut-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .mut-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        [data-theme="dark"] .mut-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }
        .mut-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }
        [data-theme="dark"] .mut-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .mut-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .mut-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .mut-modal-box .mutation-desc {
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
        .mut-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }
        [data-theme="dark"] .mut-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .mut-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        .mut-modal-actions .btn {
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
        .mut-modal-actions .btn .icon { width: 16px; height: 16px; }
        .mut-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        .mut-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }
        .mut-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }
        .mut-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }
        [data-theme="dark"] .mut-modal-actions .btn-danger { background: #DC2626; }
        [data-theme="dark"] .mut-modal-actions .btn-danger:hover { background: #B91C1C; }

        /* CSS UNTUK NAVBAR TIDAK KE-BLUR */
        body.aj-modal-open main { position: relative; z-index: 9998; }
        body.aj-modal-open .sidebar,
        body.aj-modal-open .topbar { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; }
        body.aj-modal-open .sidebar *,
        body.aj-modal-open .topbar * { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .mut-stats { grid-template-columns: 1fr 1fr; }
            .mut-stat-card.saldo { grid-column: 1 / -1; }
        }

        @media (max-width: 640px) {
            .mut-header { flex-direction: column; }
            .mut-header-actions { width: 100%; }
            .mut-header-actions .mut-btn { flex: 1; justify-content: center; }
            .mut-stats { grid-template-columns: 1fr; gap: 12px; }
            .mut-stat-card.saldo { grid-column: 1; }
            .mut-stat-card .value { font-size: 22px; }
            .mut-flow-bar { flex-direction: column; align-items: stretch; gap: 12px; padding: 16px 18px; }
            .mut-flow-bar .flow-labels { justify-content: space-between; }
            .mut-filter-bar { padding: 12px 16px; flex-direction: column; align-items: stretch; }
            .mut-filter-bar form { flex-direction: column; }
            .mut-search-wrap { min-width: 100%; }
            .mut-filter-actions { width: 100%; justify-content: flex-end; flex-wrap: wrap; }
            .mut-tx { padding: 12px 14px; gap: 12px; flex-wrap: wrap; }
            .mut-tx .tx-info { order: 1; flex-basis: 100%; margin-left: 0; }
            .mut-tx .tx-icon { width: 34px; height: 34px; }
            .mut-tx .tx-icon .icon { width: 16px; height: 16px; }
            .mut-tx .tx-desc { white-space: normal; font-size: 13px; }
            .mut-tx .tx-right { margin-left: auto; }
            .mut-tx .tx-actions { order: 2; flex-basis: 100%; justify-content: flex-end; margin-left: 0; margin-top: 4px; }
            .mut-footer { flex-direction: column; align-items: stretch; text-align: center; gap: 12px; }
            .mut-footer .actions { justify-content: center; flex-wrap: wrap; }
            .mut-modal-box { padding: 24px 20px; margin: 10px; }
            .mut-modal-actions { flex-direction: column; }
            .mut-modal-actions .btn { width: 100%; }
        }

        @media (max-width: 380px) {
            .mut-header h1 { font-size: 22px; }
            .mut-btn { font-size: 12px; padding: 8px 14px; }
            .mut-btn .icon { width: 14px; height: 14px; }
            .mut-modal-box { padding: 20px 16px; }
            .mut-modal-box h3 { font-size: 18px; }
            .mut-modal-box .icon-danger { width: 48px; height: 48px; }
            .mut-modal-box .icon-danger svg { width: 24px; height: 24px; }
        }
    </style>

    <div class="mut-modern">

        <!-- ===== TOAST CONTAINER ===== -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- ===== HEADER ===== -->
        <div class="mut-header animate-in" style="animation-delay: 0.05s;">
            <div class="mut-header-left">
                <div class="mut-badge">
                    <span class="dot"></span>
                    Rekening Aktif
                </div>
                <h1>Mutasi Rekening</h1>
                <p class="subtitle">
                    <strong id="mutTotalCount">{{ $mutationsCollection->count() }}</strong> transaksi terakhir · 
                    Periode <strong>Juli 2026</strong>
                </p>
            </div>
            <div class="mut-header-actions">
                <a href="{{ route('reconciliation.index') }}" class="mut-btn mut-btn-ghost">
                    <svg class="icon"><use href="#ic-refresh"/></svg>
                    Rekonsiliasi
                </a>
                <a href="{{ route('bank-mutations.create') }}" class="mut-btn mut-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Mutasi
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="mut-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-shield"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mut-success" style="background:var(--danger-soft);border-color:var(--danger);color:var(--danger);">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <span class="message">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ===== STATS ===== -->
        <div class="mut-stats" id="mutStatCards">
            <div class="mut-stat-card saldo animate-in" style="animation-delay: 0.10s;">
                <div class="label">
                    <svg class="icon"><use href="#ic-bank"/></svg>
                    Saldo Akhir
                </div>
                <div class="value saldo-value num" id="mutSaldoAkhir">{{ $currencySymbol }}{{ formatAngkaPendek($saldoAkhir) }}</div>
                <div class="trend up">
                    <svg class="icon"><use href="#ic-trending"/></svg>
                    +2.4% bulan ini
                </div>
            </div>

            <div class="mut-stat-card masuk animate-in" style="animation-delay: 0.15s;">
                <div class="label">
                    <svg class="icon"><use href="#ic-receive"/></svg>
                    Total Masuk
                </div>
                <div class="value masuk-value num" id="mutTotalMasuk">{{ $currencySymbol }}{{ formatAngkaPendek($totalMasuk) }}</div>
                <div class="trend up">
                    <svg class="icon"><use href="#ic-trending"/></svg>
                    <span id="mutJumlahMasuk">{{ $jumlahMasuk }}</span> transaksi
                </div>
            </div>

            <div class="mut-stat-card keluar animate-in" style="animation-delay: 0.20s;">
                <div class="label">
                    <svg class="icon"><use href="#ic-arrow-right"/></svg>
                    Total Keluar
                </div>
                <div class="value keluar-value num" id="mutTotalKeluar">{{ $currencySymbol }}{{ formatAngkaPendek($totalKeluar) }}</div>
                <div class="trend down">
                    <svg class="icon"><use href="#ic-trending-down"/></svg>
                    <span id="mutJumlahKeluar">{{ $jumlahKeluar }}</span> transaksi
                </div>
            </div>

            <div class="mut-flow-bar animate-in" style="animation-delay: 0.25s;">
                <div class="flow-labels">
                    <div class="flow-item">
                        <span class="dot in"></span>
                        <span>Masuk</span>
                        <span class="amount in" id="mutPersenMasuk">
                            {{ $arus > 0 ? round($totalMasuk / $arus * 100) : 0 }}%
                        </span>
                    </div>
                    <div class="flow-item">
                        <span class="dot out"></span>
                        <span>Keluar</span>
                        <span class="amount out" id="mutPersenKeluar">
                            {{ $arus > 0 ? round($totalKeluar / $arus * 100) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="flow-track">
                    <div class="bar in" id="mutBarMasuk" style="width: {{ $arus > 0 ? round($totalMasuk / $arus * 100) : 0 }}%;"></div>
                    <div class="bar out" id="mutBarKeluar" style="width: {{ $arus > 0 ? round($totalKeluar / $arus * 100) : 0 }}%;"></div>
                </div>
                <div class="flow-percent" id="mutFlowPercent">
                    {{ $arus > 0 ? round($totalMasuk / $arus * 100) : 0 }} / {{ $arus > 0 ? round($totalKeluar / $arus * 100) : 0 }}%
                </div>
            </div>
        </div>

        <!-- ===== FILTER / SEARCH BAR ===== -->
        <div class="mut-filter-bar animate-in" style="animation-delay: 0.27s;">
            <form method="GET" action="{{ route('bank-mutations.index') }}" id="mutFilterForm">
                <div class="mut-search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="mutSearchInput" value="{{ request('q') }}" placeholder="Cari deskripsi, tanggal, atau tipe transaksi..." autocomplete="off">
                </div>
                <div class="mut-filter-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <a href="{{ route('bank-mutations.index') }}" class="mut-btn mut-btn-ghost" id="mutResetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- ===== TRANSACTIONS ===== -->
        <div class="mut-transactions-wrap" id="mutTransactionsWrap">
            @forelse($byDate as $date => $rows)
                <div class="mut-date-divider animate-in" style="animation-delay: {{ 0.30 + ($loop->index * 0.05) }}s;">
                    <span class="date-label">{{ strtoupper(\Carbon\Carbon::parse($date)->translatedFormat('l, d F Y')) }}</span>
                    <span class="line"></span>
                    <span style="font-size: 11px; color: var(--text-tertiary); display: flex; align-items: center; gap: 4px;">
                        <svg class="icon-sm" style="width:12px;height:12px;"><use href="#ic-activity"/></svg>
                        {{ $rows->count() }} transaksi
                    </span>
                </div>

                <div class="mut-transactions" data-date="{{ $date }}">
                    @foreach($rows as $originalIndex => $m)
                        @php
                            $itemId = $originalIndex;
                        @endphp
                        <div class="mut-tx type-{{ $m['type'] }} animate-in" 
                             style="animation-delay: {{ 0.35 + ($loop->parent->index * 0.05) + ($loop->index * 0.03) }}s;">
                            
                            <div class="tx-icon {{ $m['type'] === 'masuk' ? 'in' : 'out' }}">
                                <svg class="icon"><use href="#{{ $m['type'] === 'masuk' ? 'ic-receive' : 'ic-arrow-right' }}"/></svg>
                            </div>

                            <div class="tx-info">
                                <div class="tx-desc">{{ $m['desc'] }}</div>
                                <div class="tx-meta">
                                    <span class="tag {{ $m['type'] }}">{{ $typeLabel[$m['type']] }}</span>
                                    <span>•</span>
                                    <span>{{ formatTanggal($m['date']) }}</span>
                                    <span>•</span>
                                    <span style="font-family: monospace; font-size: 11px;">#{{ str_pad($originalIndex + 1, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>

                            <div class="tx-right">
                                <div class="tx-amount {{ $m['type'] === 'masuk' ? 'in' : 'out' }} num">
                                    {{ $m['type'] === 'masuk' ? '+' : '−' }}{{ $currencySymbol }}{{ formatAngkaPendek($m['amount']) }}
                                </div>
                                <div class="tx-balance num">
                                    Saldo {{ $currencySymbol }}{{ formatAngkaPendek($m['saldo']) }}
                                </div>
                            </div>

                            <div class="tx-actions">
                                <a href="{{ route('bank-mutations.show', ['bank_mutation' => $itemId]) }}" class="btn-action show" title="Lihat Detail">
                                    <svg class="icon"><use href="#ic-eye"/></svg>
                                </a>
                                <a href="{{ route('bank-mutations.edit', ['bank_mutation' => $itemId]) }}" class="btn-action edit" title="Edit">
                                    <svg class="icon"><use href="#ic-edit"/></svg>
                                </a>
                                <button type="button" class="btn-action danger" title="Hapus"
                                        onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($m['desc']) }}')">
                                    <svg class="icon"><use href="#ic-trash"/></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="mut-empty animate-in" style="animation-delay: 0.35s;">
                    <svg class="empty-icon"><use href="#ic-bank"/></svg>
                    <h3>Belum Ada Mutasi</h3>
                    <p>Belum ada transaksi yang tercatat di rekening ini.</p>
                    <a href="{{ route('bank-mutations.create') }}" class="mut-btn mut-btn-primary" style="display: inline-flex;">
                        <svg class="icon"><use href="#ic-plus"/></svg>
                        Tambah Transaksi Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="mut-footer animate-in" style="animation-delay: 0.40s;">
            <div class="info">
                <svg class="icon"><use href="#ic-shield"/></svg>
                Data mutasi diperbarui secara real-time
            </div>
            <div class="actions">
                <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}">
                    <svg class="icon"><use href="#ic-doc"/></svg>
                    Buku Besar
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

    <!-- ============================================================
         MODAL DELETE - PINGGIRAN BULAT 24px
         ============================================================ -->
    <div class="mut-modal-overlay" id="deleteModal">
        <div class="mut-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Mutasi?</h3>

            <p>
                Anda yakin ingin menghapus transaksi
                <br>
                <span class="mutation-desc" id="deleteMutationDesc">-</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="mut-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="{{ route('bank-mutations.destroy', ['bank_mutation' => 0]) }}" method="POST" style="display:inline;">
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

        function openDeleteModal(index, description) {
            document.getElementById('deleteMutationDesc').textContent = description;
            var url = '{{ route("bank-mutations.destroy", ["bank_mutation" => 0]) }}';
            url = url.replace(/\/0$/, '/' + index);
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

        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('mutSearchInput');
            var transactionsWrap = document.getElementById('mutTransactionsWrap');
            var statCards = document.getElementById('mutStatCards');
            var totalCountEl = document.getElementById('mutTotalCount');
            var resetBtn = document.getElementById('mutResetBtn');
            var searchIndicator = document.getElementById('searchIndicator');
            var searchResultCount = document.getElementById('searchResultCount');
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
                if (!transactionsWrap) return;
                transactionsWrap.classList.add('loading');
                
                var q = searchInput ? searchInput.value : '';
                var url = '{{ route("bank-mutations.index") }}';
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
                    
                    var newWrap = doc.querySelector('#mutTransactionsWrap');
                    if (newWrap) { transactionsWrap.innerHTML = newWrap.innerHTML; }
                    
                    var newStats = doc.querySelector('#mutStatCards');
                    if (newStats) { statCards.innerHTML = newStats.innerHTML; }
                    
                    var newTotal = doc.querySelector('#mutTotalCount');
                    if (newTotal && totalCountEl) { totalCountEl.textContent = newTotal.textContent; }

                    if (searchIndicator && searchResultCount && !isReset && q) {
                        var newRows = doc.querySelectorAll('.mut-tx');
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
                    
                    transactionsWrap.classList.remove('loading');
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    transactionsWrap.classList.remove('loading');
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

            const buttons = document.querySelectorAll('.mut-btn');
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
                    setTimeout(() => { ripple.remove(); }, 600);
                });
            });
        });
    </script>

</x-app-layout>