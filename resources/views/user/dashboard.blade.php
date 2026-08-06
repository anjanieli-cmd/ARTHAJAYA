<x-user-layout>
    <x-slot name="title">Dashboard</x-slot>

    @php
        // Currency symbol selalu Rp
        $currencySymbol = 'Rp';

        function formatCurrencyShortU($amount) {
            $amount = (int) $amount;
            if ($amount >= 1000000000) return number_format($amount / 1000000000, 1, ',', '') . 'M';
            if ($amount >= 1000000) return number_format($amount / 1000000, 1, ',', '') . 'Jt';
            if ($amount >= 1000) return number_format($amount / 1000, 0, ',', '') . 'Rb';
            return number_format($amount, 0, ',', '.');
        }

        // Hitung statistik
        $totalBalance = $company->accounts->first()->initial_balance ?? 0;
        $totalIncome = 0;
        $totalExpense = 0;

        $ledgerEntries = session('ledger_entries', []);
        $currentMonth = date('Y-m');
        foreach ($ledgerEntries as $entry) {
            $entryDate = substr($entry['date'] ?? '', 0, 7);
            $amount = $entry['amount'] ?? 0;
            if ($entryDate == $currentMonth) {
                if ($amount > 0) $totalIncome += $amount;
                else $totalExpense += abs($amount);
            }
            $totalBalance += $amount;
        }

        $pendingCount = $mySubmissions->where('status', 'pending')->count();
        $approvedThisMonth = $mySubmissions->filter(function ($s) {
            return $s->status === 'approved' && $s->reviewed_at && $s->reviewed_at->format('Y-m') === date('Y-m');
        })->sum('amount');
        $rejectedCount = $mySubmissions->where('status', 'rejected')->count();
        
        // Hitung persentase approval rate
        $totalSubmissions = $mySubmissions->count();
        $approvedCount = $mySubmissions->where('status', 'approved')->count();
        $approvalRate = $totalSubmissions > 0 ? round(($approvedCount / $totalSubmissions) * 100) : 0;

        // Ambil kategori dari database
        $categories = \App\Models\ExpenseCategory::where('company_id', $company->id)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        // Jika kosong, gunakan default
        if (empty($categories)) {
            $categories = ['Operasional', 'Transportasi', 'Perlengkapan', 'Konsumsi', 'Marketing', 'Lainnya'];
        }
    @endphp

    <style>
        .udash-wrap {
            --theme-primary: var(--emerald);
            --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));
            --theme-glow: rgba(var(--emerald-rgb), 0.25);
            --theme-soft: rgba(var(--emerald-rgb), 0.12);

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
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }
        .udash-wrap * { box-sizing: border-box; }
        .udash-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        @keyframes pulseGlow { 0%,100% { opacity:1; } 50% { opacity:0.6; } }
        @keyframes shimmer { 0% { background-position:-200% 0; } 100% { background-position:200% 0; } }

        .udash-wrap .animate-in { animation: fadeSlideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards; opacity:0; }
        .udash-wrap .icon { width:18px; height:18px; flex-shrink:0; display:inline-block; vertical-align:middle; fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }

        /* ===== HERO / HEADER ===== */
        .udash-hero {
            position:relative;
            overflow:hidden;
            background: linear-gradient(145deg, rgba(var(--emerald-rgb),0.08), var(--bg-card) 70%);
            border:1px solid var(--border-color);
            border-radius:var(--radius-lg);
            padding:32px 36px;
            margin-bottom:28px;
            backdrop-filter:blur(10px);
            box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .udash-hero::before {
            content:''; position:absolute; top:-40%; right:-10%; width:300px; height:300px; border-radius:50%;
            background:radial-gradient(circle, rgba(var(--emerald-rgb),0.12), transparent 70%);
            animation: pulseGlow 4s ease-in-out infinite;
        }
        .udash-hero-inner { position:relative; z-index:1; display:flex; justify-content:space-between; align-items:flex-start; gap:24px; flex-wrap:wrap; }
        .udash-hero-left { flex:1; min-width:200px; }
        .udash-hero-eyebrow {
            display:inline-flex; align-items:center; gap:8px;
            font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em;
            color:var(--theme-primary); background:var(--theme-soft);
            padding:4px 14px; border-radius:100px; margin-bottom:12px;
        }
        .udash-hero-eyebrow .icon { width:13px; height:13px; }
        .udash-hero h1 {
            font-size:28px; font-weight:700; margin:0 0 4px;
            background:linear-gradient(135deg, var(--text) 60%, var(--theme-primary));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:-0.02em;
        }
        .udash-hero .subtitle {
            font-size:14px; color:var(--text-secondary); margin:0;
            display:flex; align-items:center; gap:8px;
        }
        .udash-hero .subtitle .dot {
            width:4px; height:4px; border-radius:50%; background:var(--text-tertiary);
        }
        .udash-hero-badge {
            font-size:11px; font-weight:600; color:var(--theme-primary);
            background:var(--theme-soft); padding:6px 16px; border-radius:100px;
            border:1px solid rgba(var(--emerald-rgb),0.15); display:inline-flex; align-items:center; gap:6px;
            white-space:nowrap;
        }
        .udash-hero-badge .icon { width:14px; height:14px; }

        /* ===== STATS ===== */
        .udash-stats {
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:16px;
            margin-bottom:28px;
        }
        .udash-stat-card {
            background:var(--bg-card);
            border:1px solid var(--border-color);
            border-radius:var(--radius-md);
            padding:22px 24px;
            transition:all .3s cubic-bezier(0.16,1,0.3,1);
            position:relative;
            overflow:hidden;
        }
        .udash-stat-card::before {
            content:''; position:absolute; top:0; left:0; right:0; height:2px;
            background:linear-gradient(90deg, transparent, currentColor, transparent);
            opacity:0; transition:opacity .3s ease;
        }
        .udash-stat-card:hover {
            transform:translateY(-4px);
            border-color:var(--border-hover);
            box-shadow:0 12px 40px rgba(0,0,0,0.08);
        }
        .udash-stat-card:hover::before { opacity:0.6; }
        .udash-stat-card .stat-top {
            display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;
        }
        .udash-stat-card .stat-icon {
            width:38px; height:38px; border-radius:var(--radius-sm);
            display:flex; align-items:center; justify-content:center;
            background:var(--theme-soft); color:var(--theme-primary);
            transition:transform .3s ease;
        }
        .udash-stat-card:hover .stat-icon { transform:scale(1.05) rotate(-3deg); }
        .udash-stat-card .stat-icon .icon { width:18px; height:18px; }
        .udash-stat-card .stat-label {
            font-size:11.5px; color:var(--text-tertiary); font-weight:500; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:4px;
        }
        .udash-stat-card .stat-value {
            font-size:26px; font-weight:700; color:var(--text-primary); letter-spacing:-0.02em;
        }
        .udash-stat-card .stat-change {
            font-size:11px; font-weight:600; padding:2px 10px; border-radius:100px;
            display:inline-flex; align-items:center; gap:4px;
        }
        .udash-stat-card .stat-change.up { color:var(--success); background:var(--success-soft); }
        .udash-stat-card .stat-change.down { color:var(--danger); background:var(--danger-soft); }
        .udash-stat-card .stat-change .icon { width:12px; height:12px; }

        /* ===== LAYOUT ===== */
        .udash-layout {
            display:grid;
            grid-template-columns:1.2fr 0.8fr;
            gap:24px;
            align-items:start;
        }

        /* ===== CARD ===== */
        .udash-card {
            background:var(--bg-card);
            border:1px solid var(--border-color);
            border-radius:var(--radius-md);
            padding:24px 28px;
            transition:all .3s ease;
        }
        .udash-card:hover { border-color:var(--border-hover); }
        .udash-card .card-head {
            display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:8px;
        }
        .udash-card .card-head h3 {
            font-size:15px; font-weight:600; color:var(--text-primary); margin:0;
            display:flex; align-items:center; gap:8px;
        }
        .udash-card .card-head h3 .icon { width:18px; height:18px; color:var(--theme-primary); }
        .udash-card .card-note {
            font-size:12px; color:var(--text-tertiary); margin:10px 0 0; display:flex; align-items:center; gap:6px;
        }
        .udash-card .card-note .icon { width:14px; height:14px; }

        /* ===== FORM ===== */
        .udash-form-group { margin-bottom:16px; }
        .udash-form-group label {
            display:block; font-size:12px; font-weight:600; color:var(--text-secondary); margin-bottom:5px;
        }
        .udash-form-group label .required { color:var(--danger); }
        .udash-form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .udash-input {
            width:100%; padding:11px 14px; border-radius:var(--radius-sm); border:1px solid var(--border-color);
            background:var(--bg-card-active); color:var(--text-primary); font-size:13px; font-family:inherit;
            transition:all .2s ease;
        }
        .udash-input:focus {
            outline:none; border-color:var(--theme-primary); background:var(--bg-card);
            box-shadow:0 0 0 3px var(--theme-soft);
        }
        .udash-input.has-prefix { padding-left:34px; }
        .udash-input-wrap { position:relative; }
        .udash-input-wrap .prefix {
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            color:var(--text-tertiary); font-size:13px; font-weight:600;
        }
        .udash-input[type="number"] { -moz-appearance:textfield; }
        .udash-input[type="number"]::-webkit-outer-spin-button,
        .udash-input[type="number"]::-webkit-inner-spin-button { -webkit-appearance:none; margin:0; }
        .udash-input::placeholder { color:var(--text-faint); }

        .udash-btn {
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:12px 24px; border-radius:var(--radius-sm);
            font-size:14px; font-weight:600; border:none; cursor:pointer;
            transition:all .25s cubic-bezier(0.16,1,0.3,1);
            background:var(--theme-gradient); color:#fff;
            box-shadow:0 4px 16px var(--theme-glow);
            width:100%; position:relative; overflow:hidden;
        }
        .udash-btn:hover {
            box-shadow:0 8px 28px var(--theme-glow);
            transform:translateY(-2px);
            color:#fff;
        }
        .udash-btn:active { transform:translateY(0) scale(.97); }
        .udash-btn .icon { width:16px; height:16px; }
        .udash-btn .ripple {
            position:absolute; border-radius:50%; background:rgba(255,255,255,.2);
            transform:scale(0); animation:rippleAnim .6s ease-out forwards; pointer-events:none;
        }
        @keyframes rippleAnim { to { transform:scale(4); opacity:0; } }
        .udash-btn:disabled { opacity:0.6; cursor:not-allowed; transform:none !important; }

        /* ===== ALERT ===== */
        .udash-alert {
            border-radius:var(--radius-md); padding:14px 20px; margin-bottom:20px;
            display:flex; align-items:center; gap:12px; font-size:13px;
        }
        .udash-alert-success {
            background:var(--success-soft); border:1px solid rgba(52,181,131,.25); color:var(--success);
        }
        .udash-alert-error {
            background:var(--danger-soft); border:1px solid rgba(232,90,90,.25); color:var(--danger);
            flex-direction:column; align-items:flex-start;
        }
        .udash-alert-error p { margin:0; }
        .udash-alert-error ul { padding-left:18px; margin:4px 0 0; }

        /* ===== TABLE ===== */
        .udash-table-wrap { overflow-x:auto; }
        .udash-table { width:100%; border-collapse:collapse; }
        .udash-table thead th {
            padding:10px 8px 14px; text-align:left; font-size:10px; font-weight:600; text-transform:uppercase;
            letter-spacing:.06em; color:var(--text-tertiary); border-bottom:1px solid var(--border-color);
        }
        .udash-table tbody tr {
            border-bottom:1px solid var(--border-color); transition:background .2s ease;
        }
        .udash-table tbody tr:last-child { border-bottom:none; }
        .udash-table tbody tr:hover { background:var(--bg-card-active); }
        .udash-table tbody td {
            padding:12px 8px; vertical-align:middle; font-size:13px; color:var(--text-secondary);
        }
        .udash-table .amt { font-family:'IBM Plex Mono', monospace; font-weight:600; color:var(--text-primary); }
        .udash-table .description-cell { color:var(--text-primary); font-weight:500; }

        .status-pill {
            display:inline-block; padding:3px 14px; border-radius:100px;
            font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:.04em;
        }
        .status-pending { background:var(--warning-soft); color:var(--warning); }
        .status-approved { background:var(--success-soft); color:var(--success); }
        .status-rejected { background:var(--danger-soft); color:var(--danger); }

        .udash-empty {
            text-align:center; padding:32px 12px; color:var(--text-tertiary); font-size:13px;
        }

        /* ===== COMPANY SNAPSHOT ===== */
        .udash-snapshot-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:12px 0; border-bottom:1px solid var(--border-color);
        }
        .udash-snapshot-row:last-child { border-bottom:none; }
        .udash-snapshot-row .label {
            font-size:13px; color:var(--text-secondary);
            display:flex; align-items:center; gap:8px;
        }
        .udash-snapshot-row .label .icon { width:16px; height:16px; color:var(--theme-primary); }
        .udash-snapshot-row .value {
            font-family:'IBM Plex Mono', monospace; font-weight:700; font-size:14px; color:var(--text-primary);
        }
        .udash-snapshot-row .value.pos { color:var(--success); }
        .udash-snapshot-row .value.neg { color:var(--danger); }

        .udash-readonly-note {
            display:flex; align-items:center; gap:8px;
            font-size:11px; color:var(--text-tertiary);
            background:var(--bg-card-active); padding:8px 14px;
            border-radius:var(--radius-sm); margin-top:12px;
        }
        .udash-readonly-note .icon { width:14px; height:14px; }

        /* ===== EMPTY STATE ===== */
        .udash-empty-state {
            text-align:center; padding:48px 20px; color:var(--text-tertiary);
        }
        .udash-empty-state .empty-icon {
            width:56px; height:56px; margin:0 auto 16px;
            color:var(--text-tertiary); opacity:0.4;
        }
        .udash-empty-state h4 {
            font-size:16px; font-weight:600; color:var(--text-primary); margin-bottom:4px;
        }
        .udash-empty-state p {
            font-size:13px; color:var(--text-secondary); margin:0;
        }

        /* ===== RIWAYAT CARD ===== */
        .udash-card-riwayat {
            background:var(--bg-card);
            border:1px solid var(--border-color);
            border-radius:var(--radius-md);
            padding:24px 28px;
            transition:all .3s ease;
            margin-top:24px;
        }
        .udash-card-riwayat:hover { border-color:var(--border-hover); }
        .udash-card-riwayat .card-head {
            display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:8px;
        }
        .udash-card-riwayat .card-head h3 {
            font-size:15px; font-weight:600; color:var(--text-primary); margin:0;
            display:flex; align-items:center; gap:8px;
        }
        .udash-card-riwayat .card-head h3 .icon { width:18px; height:18px; color:var(--theme-primary); }

        /* ===== RESPONSIVE ===== */
        @media (max-width:1200px) {
            .udash-stats { grid-template-columns:repeat(2,1fr); }
        }
        @media (max-width:992px) {
            .udash-layout { grid-template-columns:1fr; }
            .udash-hero { padding:24px; }
        }
        @media (max-width:768px) {
            .udash-hero-inner { flex-direction:column; align-items:flex-start; }
            .udash-hero h1 { font-size:24px; }
            .udash-stats { grid-template-columns:1fr 1fr; gap:12px; }
            .udash-stat-card { padding:16px 18px; }
            .udash-stat-card .stat-value { font-size:20px; }
            .udash-card { padding:20px; }
            .udash-card-riwayat { padding:20px; margin-top:20px; }
        }
        @media (max-width:480px) {
            .udash-stats { grid-template-columns:1fr; }
            .udash-form-row { grid-template-columns:1fr; }
            .udash-hero { padding:20px; border-radius:16px; }
            .udash-hero h1 { font-size:20px; }
            .udash-table thead th, .udash-table tbody td { padding:8px 4px; font-size:12px; }
            .udash-card { padding:16px; }
            .udash-card-riwayat { padding:16px; margin-top:16px; }
        }
    </style>

    <div class="udash-wrap">

        <!-- ===== HERO HEADER ===== -->
        <div class="udash-hero animate-in" style="animation-delay:0.05s;">
            <div class="udash-hero-inner">
                <div class="udash-hero-left">
                    <div class="udash-hero-eyebrow">
                        <svg class="icon"><use href="#udash-user"/></svg>
                        Dashboard
                    </div>
                    <h1>Halo, {{ $user->name }}</h1>
                    <p class="subtitle">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="3" width="16" height="18"/>
                            <line x1="9" y1="8" x2="15" y2="8"/>
                            <line x1="9" y1="12" x2="15" y2="12"/>
                            <line x1="9" y1="16" x2="13" y2="16"/>
                        </svg>
                        {{ $company->name ?? 'Belum tergabung ke perusahaan' }}
                        <span class="dot"></span>
                        {{ $company->city ?? 'Kota belum diatur' }}
                    </p>
                </div>
                <div class="udash-hero-badge">
                    <svg class="icon"><use href="#udash-eye"/></svg>
                    Akses User
                </div>
            </div>
        </div>

        <!-- ===== ALERT ===== -->
        @if (session('success'))
            <div class="udash-alert udash-alert-success animate-in" style="animation-delay:0.07s;">
                <svg class="icon"><use href="#udash-check"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="udash-alert udash-alert-error animate-in" style="animation-delay:0.07s;">
                <svg class="icon"><use href="#udash-x-circle"/></svg>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- ===== STATS ===== -->
        <div class="udash-stats animate-in" style="animation-delay:0.10s;">
            <div class="udash-stat-card" style="color:var(--theme-primary);">
                <div class="stat-top">
                    <div class="stat-icon"><svg class="icon"><use href="#udash-bank"/></svg></div>
                </div>
                <div class="stat-label">Saldo Kas Perusahaan</div>
                <div class="stat-value mono">Rp {{ formatCurrencyShortU($totalBalance) }}</div>
            </div>
            <div class="udash-stat-card" style="color:var(--warning);">
                <div class="stat-top">
                    <div class="stat-icon" style="background:var(--warning-soft);color:var(--warning);"><svg class="icon"><use href="#udash-clock"/></svg></div>
                    <span class="stat-change up">
                        <svg class="icon"><use href="#udash-activity"/></svg>
                        {{ $pendingCount }} menunggu
                    </span>
                </div>
                <div class="stat-label">Pengajuan Pending</div>
                <div class="stat-value mono">{{ $pendingCount }}</div>
            </div>
            <div class="udash-stat-card" style="color:var(--success);">
                <div class="stat-top">
                    <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><svg class="icon"><use href="#udash-check-circle"/></svg></div>
                    <span class="stat-change up">
                        <svg class="icon"><use href="#udash-trending"/></svg>
                        {{ $approvalRate }}% approve
                    </span>
                </div>
                <div class="stat-label">Disetujui Bulan Ini</div>
                <div class="stat-value mono">Rp {{ formatCurrencyShortU($approvedThisMonth) }}</div>
            </div>
            <div class="udash-stat-card" style="color:var(--danger);">
                <div class="stat-top">
                    <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);"><svg class="icon"><use href="#udash-x-circle"/></svg></div>
                    <span class="stat-change down">
                        <svg class="icon"><use href="#udash-trending-down"/></svg>
                        {{ $rejectedCount }} ditolak
                    </span>
                </div>
                <div class="stat-label">Ditolak</div>
                <div class="stat-value mono">{{ $rejectedCount }}</div>
            </div>
        </div>

        <!-- ===== LAYOUT 2 KOLOM ===== -->
        <div class="udash-layout">

            <!-- ===== LEFT: FORM AJUKAN ===== -->
            <div class="udash-card animate-in" style="animation-delay:0.15s;" id="ajukan">
                <div class="card-head">
                    <h3>
                        <svg class="icon"><use href="#udash-send"/></svg>
                        Ajukan Pengeluaran
                    </h3>
                </div>

                <form method="POST" action="{{ route('user.expenses.store') }}">
                    @csrf

                    <div class="udash-form-group">
                        <label for="description">Deskripsi <span class="required">*</span></label>
                        <input type="text" id="description" name="description" class="udash-input"
                               value="{{ old('description') }}" placeholder="Misal: Beli ATK kantor" required>
                    </div>

                    <div class="udash-form-row">
                        <div class="udash-form-group">
                            <label for="amount">Jumlah <span class="required">*</span></label>
                            <div class="udash-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" id="amount" name="amount" class="udash-input has-prefix"
                                       value="{{ old('amount') }}" placeholder="0" min="1" step="1" required>
                            </div>
                        </div>
                        <div class="udash-form-group">
                            <label for="expense_date">Tanggal <span class="required">*</span></label>
                            <input type="date" id="expense_date" name="expense_date" class="udash-input"
                                   value="{{ old('expense_date', date('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="udash-form-group">
                        <label for="category">Kategori</label>
                        <select id="category" name="category" class="udash-input">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="udash-btn">
                        <svg class="icon"><use href="#udash-send"/></svg>
                        Ajukan Pengeluaran
                    </button>
                </form>

                <p class="card-note">
                    <svg class="icon"><use href="#udash-info"/></svg>
                    Pengajuan akan masuk antrian dan perlu disetujui oleh Staff sebelum tercatat di kas perusahaan.
                </p>
            </div>

            <!-- ===== RIGHT: COMPANY SNAPSHOT ===== -->
            <div class="udash-card animate-in" style="animation-delay:0.20s;" id="ringkasan">
                <div class="card-head">
                    <h3>
                        <svg class="icon"><use href="#udash-bank"/></svg>
                        Ringkasan Keuangan
                    </h3>
                </div>

                <div class="udash-snapshot-row">
                    <span class="label"><svg class="icon"><use href="#udash-bank"/></svg> Saldo Kas</span>
                    <span class="value">Rp {{ formatCurrencyShortU($totalBalance) }}</span>
                </div>
                <div class="udash-snapshot-row">
                    <span class="label"><svg class="icon"><use href="#udash-trending"/></svg> Pemasukan Bulan Ini</span>
                    <span class="value pos">+Rp {{ formatCurrencyShortU($totalIncome) }}</span>
                </div>
                <div class="udash-snapshot-row">
                    <span class="label"><svg class="icon"><use href="#udash-trending-down"/></svg> Pengeluaran Bulan Ini</span>
                    <span class="value neg">-Rp {{ formatCurrencyShortU($totalExpense) }}</span>
                </div>

                <div class="udash-readonly-note">
                    <svg class="icon"><use href="#udash-lock"/></svg>
                    Data ini hanya untuk dilihat. Perubahan saldo hanya bisa dilakukan oleh Staff.
                </div>
            </div>

        </div>

        <!-- ===== RIWAYAT PENGAJUAN ===== -->
        <div class="udash-card-riwayat animate-in" style="animation-delay:0.25s;" id="riwayat">
            <div class="card-head">
                <h3>
                    <!-- ICON FILE-TEXT (DOC) -->
                    <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    Riwayat Pengajuan Saya
                </h3>
                <span style="font-size:12px;color:var(--text-tertiary);">
                    {{ $mySubmissions->count() }} pengajuan
                </span>
            </div>

            @if ($mySubmissions->isEmpty())
                <div class="udash-empty-state">
                    <!-- ICON INBOX -->
                    <svg class="empty-icon" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/>
                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
                    </svg>
                    <h4>Belum ada pengajuan</h4>
                    <p>Kamu belum pernah mengajukan pengeluaran. Mulai ajukan di atas.</p>
                </div>
            @else
                <div class="udash-table-wrap">
                    <table class="udash-table">
                        <thead>
                            <tr>
                                <th style="width:30%;">Deskripsi</th>
                                <th style="width:15%;">Kategori</th>
                                <th style="width:15%;">Tanggal</th>
                                <th style="width:15%;">Status</th>
                                <th style="width:15%;text-align:right;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mySubmissions as $item)
                                <tr>
                                    <td class="description-cell">{{ $item->description }}</td>
                                    <td>{{ $item->category ?? '-' }}</td>
                                    <td>{{ $item->expense_date->format('d M Y') }}</td>
                                    <td>
                                        @if ($item->status === 'approved')
                                            <span class="status-pill status-approved">✓ Disetujui</span>
                                        @elseif ($item->status === 'rejected')
                                            <span class="status-pill status-rejected">✗ Ditolak</span>
                                        @else
                                            <span class="status-pill status-pending">⏳ Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="amt" style="text-align:right">Rp {{ formatCurrencyShortU($item->amount) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="udash-user" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
        <symbol id="udash-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
        <symbol id="udash-bank" viewBox="0 0 24 24"><rect x="2" y="10" width="20" height="12" rx="2"/><line x1="12" y1="2" x2="12" y2="10"/><line x1="6" y1="6" x2="6" y2="10"/><line x1="18" y1="6" x2="18" y2="10"/></symbol>
        <symbol id="udash-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
        <symbol id="udash-check-circle" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
        <symbol id="udash-x-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></symbol>
        <symbol id="udash-send" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
        <symbol id="udash-trending" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></symbol>
        <symbol id="udash-trending-down" viewBox="0 0 24 24"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></symbol>
        <symbol id="udash-lock" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></symbol>
        <symbol id="udash-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
        <symbol id="udash-activity" viewBox="0 0 24 24"><polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/></symbol>
        <symbol id="udash-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.udash-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // ===== AUTO DISMISS ALERTS =====
            setTimeout(function() {
                document.querySelectorAll('.udash-alert').forEach(function(el) {
                    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(function() { el.style.display = 'none'; }, 500);
                });
            }, 5000);
        });
    </script>

</x-user-layout>