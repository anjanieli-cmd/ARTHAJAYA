<x-app-layout>
    <x-slot name="title">Data Karyawan</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        // Data dari session (sudah passing $employees dari controller)
        $employees = $employees ?? [
            ['id' => 1, 'name' => 'Budi Santoso',      'position' => 'Pengrajin Batik', 'department' => 'Produksi', 'email' => 'budi@arthajaya.com', 'phone' => '0812-3456-7890', 'salary' => 4500000, 'status' => 'active', 'joined' => '2023-01-15'],
            ['id' => 2, 'name' => 'Siti Rahayu',        'position' => 'Desainer',        'department' => 'Kreatif',  'email' => 'siti@arthajaya.com', 'phone' => '0813-4567-8901', 'salary' => 5200000, 'status' => 'active', 'joined' => '2023-03-01'],
            ['id' => 3, 'name' => 'Agus Wijaya',        'position' => 'Marketing',       'department' => 'Marketing', 'email' => 'agus@arthajaya.com', 'phone' => '0814-5678-9012', 'salary' => 4800000, 'status' => 'active', 'joined' => '2023-06-10'],
            ['id' => 4, 'name' => 'Dewi Lestari',       'position' => 'Admin',           'department' => 'Operasional', 'email' => 'dewi@arthajaya.com', 'phone' => '0815-6789-0123', 'salary' => 4000000, 'status' => 'active', 'joined' => '2023-08-20'],
            ['id' => 5, 'name' => 'Hendra Gunawan',     'position' => 'Pengrajin Batik', 'department' => 'Produksi', 'email' => 'hendra@arthajaya.com', 'phone' => '0816-7890-1234', 'salary' => 4500000, 'status' => 'inactive', 'joined' => '2022-11-01'],
            ['id' => 6, 'name' => 'Rina Marlina',       'position' => 'Quality Control', 'department' => 'Produksi', 'email' => 'rina@arthajaya.com', 'phone' => '0817-8901-2345', 'salary' => 4200000, 'status' => 'active', 'joined' => '2024-01-05'],
        ];

        $employeesCollection = collect($employees);
        $statusLabel = ['active' => 'Aktif', 'inactive' => 'Tidak Aktif'];
        $statusPill  = ['active' => 'active', 'inactive' => 'inactive'];

        $totalEmployees = $employeesCollection->count();
        $totalActive    = $employeesCollection->where('status', 'active')->count();
        $totalInactive  = $employeesCollection->where('status', 'inactive')->count();
        $totalSalary    = $employeesCollection->sum('salary');
        $avgSalary      = $totalEmployees > 0 ? round($totalSalary / $totalEmployees) : 0;
        
        $departments = $employeesCollection->pluck('department')->unique()->values();
        
        // Fungsi helper untuk format tanggal
        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }
    @endphp

    <style>
        /* ============================================
           EMPLOYEES - Profile Card Style
           ============================================ */
        
        .emp-wrap {
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
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .emp-wrap * { box-sizing: border-box; }
        .emp-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .emp-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .emp-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* SUCCESS MESSAGE */
        .emp-success {
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

        .emp-success .icon {
            width: 20px;
            height: 20px;
        }

        .emp-success .message {
            font-weight: 500;
        }

        /* HEADER */
        .emp-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .emp-header-left { flex: 1; min-width: 200px; }

        .emp-badge {
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

        .emp-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .emp-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .emp-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .emp-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .emp-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .emp-btn {
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

        .emp-btn .icon { width: 16px; height: 16px; }
        .emp-btn:hover { transform: translateY(-2px); }
        .emp-btn:active { transform: translateY(0) scale(0.97); }

        .emp-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .emp-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .emp-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .emp-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .emp-btn .ripple {
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

        /* STATS ROW */
        .emp-stats {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .emp-stat {
            flex: 1;
            min-width: 160px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .emp-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .emp-stat .ic {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-soft);
            color: var(--theme-primary);
            flex-shrink: 0;
        }

        .emp-stat .ic .icon { width: 20px; height: 20px; }

        .emp-stat .info .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .emp-stat .info .value {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .emp-stat .info .value.green { color: var(--success); }
        .emp-stat .info .value.red { color: var(--danger); }
        .emp-stat .info .value.purple { color: var(--theme-primary); }

        /* SEARCH & FILTER */
        .emp-toolbar {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px 20px;
        }

        .emp-toolbar .search {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 8px 14px;
            transition: all 0.2s ease;
            min-width: 200px;
        }

        .emp-toolbar .search:focus-within {
            border-color: var(--theme-primary);
            background: var(--bg-card-hover);
        }

        .emp-toolbar .search .icon {
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
        }

        .emp-toolbar .search input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            color: var(--text-primary);
            font-size: 13px;
        }

        .emp-toolbar .search input::placeholder {
            color: var(--text-tertiary);
        }

        .emp-toolbar .filter-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .emp-toolbar .filter-group select {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 8px 14px;
            color: var(--text-primary);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
        }

        .emp-toolbar .filter-group select:hover { border-color: var(--border-hover); }
        .emp-toolbar .filter-group select:focus { border-color: var(--theme-primary); }

        /* PROFILE CARD GRID */
        .emp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }

        .emp-profile {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px 20px 20px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .emp-profile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .emp-profile:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .emp-profile:hover::before { opacity: 1; }

        .emp-profile.status-active::before { background: var(--success); }
        .emp-profile.status-inactive::before { background: var(--danger); }

        .emp-profile .avatar-lg {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 28px;
            color: #fff;
            margin: 0 auto 12px;
            border: 3px solid var(--border-color);
            transition: border-color 0.3s ease;
        }

        .emp-profile:hover .avatar-lg {
            border-color: var(--theme-primary);
        }

        .emp-profile .name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .emp-profile .position {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .emp-profile .dept {
            display: inline-block;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 12px;
            border-radius: 100px;
            background: var(--bg-card-active);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            margin-top: 8px;
        }

        .emp-profile .divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 14px 0;
        }

        .emp-profile .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            text-align: left;
            font-size: 12px;
        }

        .emp-profile .details .lbl {
            color: var(--text-tertiary);
        }

        .emp-profile .details .val {
            color: var(--text-secondary);
            font-weight: 500;
            text-align: right;
        }

        .emp-profile .details .val.mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .emp-profile .status-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 12px;
        }

        .emp-profile .status-badge.active {
            background: var(--success-soft);
            color: var(--success);
        }

        .emp-profile .status-badge.inactive {
            background: var(--danger-soft);
            color: var(--danger);
        }

        /* ACTION BUTTONS - Updated with full actions */
        .emp-profile .actions {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
        }

        .emp-profile .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 500;
            color: var(--text-tertiary);
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
            background: transparent;
            cursor: pointer;
        }

        .emp-profile .btn-action .icon {
            width: 13px;
            height: 13px;
        }

        .emp-profile .btn-action:hover {
            transform: translateY(-1px);
        }

        .emp-profile .btn-action.show {
            color: var(--theme-primary);
            border-color: var(--theme-soft);
        }

        .emp-profile .btn-action.show:hover {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .emp-profile .btn-action.edit {
            color: #4FA6E8;
            border-color: rgba(79, 166, 232, 0.2);
        }

        .emp-profile .btn-action.edit:hover {
            background: rgba(79, 166, 232, 0.12);
            border-color: #4FA6E8;
        }

        .emp-profile .btn-action.delete {
            color: var(--danger);
            border-color: var(--danger-soft);
        }

        .emp-profile .btn-action.delete:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        /* EMPTY */
        .emp-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
            grid-column: 1 / -1;
        }

        .emp-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .emp-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .emp-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        /* ----- MODAL DELETE ----- */
        .emp-modal-overlay {
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
        .emp-modal-overlay.active {
            display: flex;
        }
        .emp-modal-box {
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
        [data-theme="light"] .emp-modal-box {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }
        .emp-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }
        .emp-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .emp-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .emp-modal-box .emp-desc-text {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        .emp-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .emp-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        .emp-modal-actions .btn {
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
        .emp-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }
        .emp-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        .emp-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }
        .emp-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .emp-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 768px) {
            .emp-stats { flex-direction: column; }
            .emp-stat { min-width: auto; }
            .emp-toolbar { flex-direction: column; align-items: stretch; }
            .emp-toolbar .search { min-width: auto; }
            .emp-toolbar .filter-group { justify-content: stretch; flex-wrap: wrap; }
            .emp-toolbar .filter-group select { flex: 1; }
            .emp-grid { grid-template-columns: 1fr 1fr; }
            .emp-profile .details { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 640px) {
            .emp-header { flex-direction: column; }
            .emp-actions { width: 100%; }
            .emp-actions .emp-btn { flex: 1; justify-content: center; }
            .emp-grid { grid-template-columns: 1fr; }
            .emp-profile .details { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 400px) {
            .emp-profile .details { grid-template-columns: 1fr; gap: 4px; }
            .emp-profile .details .val { text-align: left; }
            .emp-profile .actions { flex-wrap: wrap; }
        }

        @media (max-width: 380px) {
            .emp-header h1 { font-size: 22px; }
            .emp-btn { font-size: 12px; padding: 8px 14px; }
            .emp-btn .icon { width: 14px; height: 14px; }
        }
    </style>

    <div class="emp-wrap">

        <!-- ===== HEADER ===== -->
        <div class="emp-header animate-in" style="animation-delay: 0.05s;">
            <div class="emp-header-left">
                <div class="emp-badge">
                    <span class="dot"></span>
                    HR &amp; Payroll
                </div>
                <h1>Data Karyawan</h1>
                <p class="subtitle">
                    Kelola data karyawan perusahaan — 
                    <strong>{{ $totalEmployees }}</strong> karyawan terdaftar
                </p>
            </div>
            <div class="emp-actions">
                <a href="{{ route('payroll.index') }}" class="emp-btn emp-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Slip Gaji
                </a>
                <a href="{{ route('employees.create') }}" class="emp-btn emp-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Karyawan
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="emp-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== STATS ===== -->
        <div class="emp-stats animate-in" style="animation-delay: 0.10s;">
            <div class="emp-stat">
                <div class="ic">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="info">
                    <div class="label">Total Karyawan</div>
                    <div class="value purple">{{ $totalEmployees }}</div>
                </div>
            </div>
            <div class="emp-stat">
                <div class="ic">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="info">
                    <div class="label">Aktif</div>
                    <div class="value green">{{ $totalActive }}</div>
                </div>
            </div>
            <div class="emp-stat">
                <div class="ic">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </div>
                <div class="info">
                    <div class="label">Tidak Aktif</div>
                    <div class="value red">{{ $totalInactive }}</div>
                </div>
            </div>
            <div class="emp-stat">
                <div class="ic">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div class="info">
                    <div class="label">Total Gaji</div>
                    <div class="value purple mono">{{ $currencySymbol }}{{ number_format($totalSalary, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- ===== TOOLBAR ===== -->
        <div class="emp-toolbar animate-in" style="animation-delay: 0.15s;">
            <div class="search">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" placeholder="Cari karyawan..." id="searchEmployee" onkeyup="filterEmployees()">
            </div>
            <div class="filter-group">
                <select id="filterDepartment" onchange="filterEmployees()">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
                <select id="filterStatus" onchange="filterEmployees()">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <!-- ===== PROFILE GRID ===== -->
        <div class="emp-grid" id="employeeGrid">
            @forelse($employees as $index => $e)
                @php
                    $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                    $color = $colors[($index + $loop->iteration) % count($colors)];
                    $statusClass = $e['status'] == 'active' ? 'status-active' : 'status-inactive';
                    $itemId = $e['id'] ?? $index;
                    $joined = formatTanggal($e['joined']);
                @endphp
                <div class="emp-profile {{ $statusClass }} animate-in employee-item" 
                     style="animation-delay: {{ 0.20 + ($index * 0.04) }}s;"
                     data-name="{{ strtolower($e['name']) }}"
                     data-department="{{ $e['department'] }}"
                     data-status="{{ $e['status'] }}">
                    
                    <div class="avatar-lg" style="background: {{ $color }};">
                        {{ mb_substr($e['name'], 0, 1) }}
                    </div>
                    <div class="name">{{ $e['name'] }}</div>
                    <div class="position">{{ $e['position'] }}</div>
                    <span class="dept">{{ $e['department'] }}</span>

                    <hr class="divider">

                    <div class="details">
                        <span class="lbl">Email</span>
                        <span class="val">{{ $e['email'] }}</span>
                        <span class="lbl">Telepon</span>
                        <span class="val">{{ $e['phone'] }}</span>
                        <span class="lbl">Bergabung</span>
                        <span class="val">{{ $joined }}</span>
                        <span class="lbl">Gaji</span>
                        <span class="val mono">{{ $currencySymbol }}{{ number_format($e['salary'], 0, ',', '.') }}</span>
                    </div>

                    <span class="status-badge {{ $statusPill[$e['status']] }}">
                        {{ $statusLabel[$e['status']] }}
                    </span>

                    <div class="actions">
                        <!-- Show Button -->
                        <a href="/employees/show/{{ $itemId }}" class="btn-action show" title="Lihat Detail">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Detail
                        </a>

                        <!-- Edit Button -->
                        <a href="/employees/edit/{{ $itemId }}" class="btn-action edit" title="Edit Data">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                <path d="M15 5l4 4"/>
                            </svg>
                            Edit
                        </a>

                        <!-- Delete Button -->
                        <button type="button" class="btn-action delete" title="Hapus"
                                onclick="openDeleteModal('{{ $itemId }}', '{{ addslashes($e['name']) }}')">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"/>
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6"/>
                                <path d="M14 11v6"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="emp-empty">
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <h3>Belum Ada Data Karyawan</h3>
                    <p>Belum ada karyawan yang tercatat di sistem.</p>
                    <a href="{{ route('employees.create') }}" class="emp-btn emp-btn-primary" style="display: inline-flex;">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Tambah Karyawan Pertama
                    </a>
                </div>
            @endforelse
        </div>

    </div>

    <!-- ===== MODAL DELETE ===== -->
    <div class="emp-modal-overlay" id="deleteModal">
        <div class="emp-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Karyawan?</h3>
            <p>
                Anda yakin ingin menghapus data karyawan
                <br>
                <span class="emp-desc-text" id="deleteDesc">-</span>
            </p>
            <div class="warning-text">
                Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="emp-modal-actions">
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
        // ===== FILTER FUNCTION =====
        function filterEmployees() {
            const searchInput = document.getElementById('searchEmployee');
            const departmentFilter = document.getElementById('filterDepartment');
            const statusFilter = document.getElementById('filterStatus');
            const items = document.querySelectorAll('.employee-item');
            
            const searchTerm = searchInput.value.toLowerCase().trim();
            const department = departmentFilter.value;
            const status = statusFilter.value;

            items.forEach(item => {
                const name = item.dataset.name;
                const itemDepartment = item.dataset.department;
                const itemStatus = item.dataset.status;
                
                let show = true;
                
                if (searchTerm && !name.includes(searchTerm)) {
                    show = false;
                }
                
                if (department && itemDepartment !== department) {
                    show = false;
                }
                
                if (status && itemStatus !== status) {
                    show = false;
                }
                
                item.style.display = show ? '' : 'none';
            });
        }

        // ===== DELETE MODAL =====
        function openDeleteModal(id, description) {
            document.getElementById('deleteDesc').textContent = description;
            var url = '/employees/delete/' + id;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal on overlay click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // ===== RIPPLE EFFECT =====
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.emp-btn');
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