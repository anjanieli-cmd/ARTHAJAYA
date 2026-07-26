<x-app-layout>
    <x-slot name="title">Keamanan</x-slot>

    @php
        // Data dummy untuk sessions
        $sessions = $sessions ?? collect([
            (object) [
                'id' => 1,
                'user_agent' => 'Chrome 120.0.0.0 on Windows 11',
                'ip_address' => '192.168.1.100',
                'is_current' => true,
                'last_activity_human' => 'Sekarang',
                'last_activity' => now(),
                'device' => 'Desktop',
                'location' => 'Jakarta, Indonesia'
            ],
            (object) [
                'id' => 2,
                'user_agent' => 'Safari 17.2 on macOS 14.2',
                'ip_address' => '192.168.1.101',
                'is_current' => false,
                'last_activity_human' => '2 jam yang lalu',
                'last_activity' => now()->subHours(2),
                'device' => 'Laptop',
                'location' => 'Bandung, Indonesia'
            ],
            (object) [
                'id' => 3,
                'user_agent' => 'Firefox 121.0 on Android 14',
                'ip_address' => '192.168.1.102',
                'is_current' => false,
                'last_activity_human' => '5 jam yang lalu',
                'last_activity' => now()->subHours(5),
                'device' => 'Mobile',
                'location' => 'Surabaya, Indonesia'
            ],
        ]);

        $user = $user ?? (object) [
            'password_changed_at' => now()->subDays(45),
            'two_factor_enabled' => true,
            'email' => 'user@example.com',
        ];

        $score = 70;
        if (isset($user->password_changed_at)) $score += 30;
        if (isset($user->two_factor_enabled) && $user->two_factor_enabled) $score += 30;
        $circumference = 2 * 3.14159 * 42;
        $offset = $circumference - ($score / 100) * $circumference;
    @endphp

    <style>
        /* ============================================
           KEAMANAN - Modern Design
           ============================================ */
        
        .sec-wrap {
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
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --danger-rgb: 232, 90, 90;
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .sec-wrap * { box-sizing: border-box; }
        .sec-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .sec-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .sec-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .sec-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .sec-header-left { flex: 1; min-width: 200px; }

        .sec-badge {
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

        .sec-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .sec-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .sec-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .sec-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .sec-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .sec-btn {
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

        .sec-btn .icon { width: 16px; height: 16px; }
        .sec-btn:hover { transform: translateY(-2px); }
        .sec-btn:active { transform: translateY(0) scale(0.97); }

        .sec-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .sec-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .sec-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .sec-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .sec-btn .ripple {
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

        /* ALERT */
        .sec-alert {
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .sec-alert .icon { width: 20px; height: 20px; flex-shrink: 0; }
        .sec-alert.success { background: var(--success-soft); border: 1px solid var(--success); color: var(--success); }
        .sec-alert.error { background: var(--danger-soft); border: 1px solid var(--danger); color: var(--danger); }

        /* LAYOUT */
        .sec-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1100px) {
            .sec-layout { grid-template-columns: 1fr; }
        }

        /* MAIN CONTENT */
        .sec-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sec-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 28px 32px;
            transition: all 0.3s ease;
        }

        .sec-card:hover {
            border-color: var(--border-hover);
        }

        .sec-card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sec-card-title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .sec-card-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0 0 22px;
            line-height: 1.6;
        }

        .sec-card-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 4px;
        }

        /* FORM */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group:last-child { margin-bottom: 0; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .form-group label .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1.5px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
            background: var(--bg-card);
        }

        .form-control::placeholder {
            color: var(--text-tertiary);
        }

        .form-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 6px;
        }

        .sec-btn-sm {
            padding: 7px 14px;
            font-size: 12px;
        }

        /* TOGGLE */
        .toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
        }

        .toggle-row .t {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .toggle-row .d {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .toggle-row .d.active { color: var(--success); }
        .toggle-row .d.inactive { color: var(--text-tertiary); }

        .toggle-row .d .icon {
            width: 14px;
            height: 14px;
        }

        .switch {
            position: relative;
            width: 44px;
            height: 26px;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .switch-track {
            position: absolute;
            inset: 0;
            background: var(--bg-card-active);
            border: 2px solid var(--border-color);
            border-radius: 100px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .switch-track:before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 2px;
            top: 2px;
            background: var(--text-tertiary);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .switch input:checked + .switch-track {
            background: var(--theme-soft);
            border-color: var(--theme-primary);
        }

        .switch input:checked + .switch-track:before {
            transform: translateX(18px);
            background: var(--theme-primary);
        }

        /* SESSIONS */
        .sess-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .sess-row:last-child {
            border-bottom: none;
        }

        .sess-ic {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--text-secondary);
        }

        .sess-ic .icon {
            width: 18px;
            height: 18px;
        }

        .sess-info {
            flex: 1;
            min-width: 0;
        }

        .sess-agent {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .sess-agent .device-icon {
            width: 14px;
            height: 14px;
            color: var(--text-secondary);
        }

        .sess-agent .current-tag {
            font-size: 10px;
            font-weight: 700;
            color: var(--theme-primary);
            background: var(--theme-soft);
            padding: 2px 10px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .sess-meta {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .sess-meta .dot {
            display: inline-block;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--text-tertiary);
        }

        .sess-meta .icon {
            width: 12px;
            height: 12px;
        }

        .last-changed {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .last-changed .icon {
            width: 14px;
            height: 14px;
        }

        .empty-hint {
            font-size: 13px;
            color: var(--text-secondary);
            padding: 20px 0;
            text-align: center;
        }

        .empty-hint .icon {
            width: 32px;
            height: 32px;
            margin: 0 auto 8px;
            display: block;
            color: var(--text-tertiary);
            opacity: 0.3;
        }

        /* ===== SIDEBAR ===== */
        .sec-side {
            display: flex;
            flex-direction: column;
            gap: 18px;
            position: sticky;
            top: 20px;
        }

        .score-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 28px 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .score-card:hover {
            border-color: var(--border-hover);
        }

        .score-ring {
            width: 100px;
            height: 100px;
            margin: 0 auto 14px;
            position: relative;
        }

        .score-ring svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .score-ring .bg {
            stroke: var(--bg-card-active);
            fill: none;
        }

        .score-ring .fg {
            stroke: var(--theme-primary);
            stroke-linecap: round;
            fill: none;
            transition: stroke-dashoffset 0.8s ease;
        }

        .score-ring .fg.high { stroke: var(--success); }
        .score-ring .fg.medium { stroke: var(--warning); }
        .score-ring .fg.low { stroke: var(--danger); }

        .score-num {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .score-label {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .score-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .score-title.high { color: var(--success); }
        .score-title.medium { color: var(--warning); }
        .score-title.low { color: var(--danger); }

        .checklist {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 18px;
            text-align: left;
            padding-top: 18px;
            border-top: 1px solid var(--border-color);
        }

        .check-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .check-ic {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 11px;
            font-weight: 700;
        }

        .check-ic .icon {
            width: 12px;
            height: 12px;
        }

        .check-ic.done {
            background: var(--success-soft);
            color: var(--success);
        }

        .check-ic.pending {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
            border: 1.5px solid var(--border-color);
        }

        .check-ic.pending .icon {
            stroke-width: 3;
        }

        .info-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 22px;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            border-color: var(--border-hover);
        }

        .info-card .t {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card .t .icon {
            width: 16px;
            height: 16px;
            color: var(--theme-primary);
        }

        .info-card p {
            font-size: 12.5px;
            color: var(--text-secondary);
            line-height: 1.7;
            margin: 0;
        }

        .info-card .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sec-wrap { padding: 0 16px; }
            .sec-card { padding: 24px; }
        }

        @media (max-width: 768px) {
            .sec-wrap { padding: 0 12px; }
            .sec-layout { grid-template-columns: 1fr; }
            .sec-side { position: static; }
            .sec-header { flex-direction: column; align-items: stretch; }
            .sec-actions { width: 100%; }
            .sec-actions .sec-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .sec-card { padding: 20px; }
            .grid-2 { grid-template-columns: 1fr; }
            .sec-card-head { flex-direction: column; align-items: stretch; }
            .sess-row { flex-wrap: wrap; }
            .score-ring { width: 80px; height: 80px; }
            .score-num { font-size: 20px; }
        }

        @media (max-width: 640px) {
            .sec-wrap { padding: 0 8px; }
            .sec-header h1 { font-size: 22px; }
            .sec-card { padding: 16px; }
            .sess-row { padding: 12px 0; }
            .sess-ic { width: 34px; height: 34px; }
            .sess-agent { font-size: 12px; }
            .toggle-row { flex-wrap: wrap; gap: 8px; }
        }

        @media (max-width: 480px) {
            .sec-wrap { padding: 0 4px; }
            .sec-btn { font-size: 11px; padding: 6px 10px; }
            .sec-btn .icon { width: 14px; height: 14px; }
            .form-control { font-size: 12px; padding: 10px 12px; }
            .form-actions { flex-direction: column; align-items: stretch; }
            .form-actions .sec-btn { width: 100%; justify-content: center; }
            .sec-card { padding: 14px; }
            .sec-card-title { font-size: 14px; }
        }
    </style>

    <div class="sec-wrap">

        <!-- ===== HEADER ===== -->
        <div class="sec-header animate-in" style="animation-delay: 0.05s;">
            <div class="sec-header-left">
                <div class="sec-badge">
                    <span class="dot"></span>
                    Keamanan
                </div>
                <h1>Keamanan Akun</h1>
                <p class="subtitle">
                    Kelola password, autentikasi dua faktor, dan sesi login aktif — 
                    <strong>{{ $sessions->count() }}</strong> sesi aktif
                </p>
            </div>
            <div class="sec-actions">
                <button class="sec-btn sec-btn-ghost" onclick="location.reload()">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Refresh
                </button>
                <a href="{{ route('profile.edit') }}" class="sec-btn sec-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Profil Saya
                </a>
            </div>
        </div>

        <!-- ===== ALERTS ===== -->
        @if(session('success'))
            <div class="sec-alert success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="sec-alert error animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- ===== LAYOUT ===== -->
        <div class="sec-layout">

            <!-- ===== MAIN CONTENT ===== -->
            <div class="sec-main">

                <!-- GANTI PASSWORD -->
                <div class="sec-card animate-in" style="animation-delay: 0.10s;">
                    <div class="sec-card-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Ganti Password
                    </div>
                    <p class="sec-card-desc">Gunakan password yang kuat dan belum pernah dipakai di tempat lain.</p>

                    <form method="POST" action="{{ route('security.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Password Saat Ini <span class="required">*</span></label>
                            <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini" required>
                            @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Password Baru <span class="required">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                                @error('password')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password Baru <span class="required">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="sec-btn sec-btn-primary">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                    <polyline points="17 21 17 13 7 13 7 21"/>
                                    <polyline points="7 3 7 8 15 8"/>
                                </svg>
                                Perbarui Password
                            </button>
                        </div>
                    </form>

                    @if(isset($user->password_changed_at))
                        <div class="last-changed">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Terakhir diubah {{ \Carbon\Carbon::parse($user->password_changed_at)->diffForHumans() }}
                        </div>
                    @endif
                </div>

                <!-- 2FA -->
                <div class="sec-card animate-in" style="animation-delay: 0.15s;">
                    <div class="sec-card-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <polyline points="9 12 11 14 15 10"/>
                        </svg>
                        Autentikasi Dua Faktor
                    </div>
                    <p class="sec-card-desc">Tambahan lapisan keamanan saat login ke akunmu.</p>

                    <div class="toggle-row">
                        <div>
                            <div class="t">Aktifkan 2FA</div>
                            <div class="d {{ isset($user->two_factor_enabled) && $user->two_factor_enabled ? 'active' : 'inactive' }}">
                                @if(isset($user->two_factor_enabled) && $user->two_factor_enabled)
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                    Sedang aktif
                                @else
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <circle cx="12" cy="12" r="4"/>
                                    </svg>
                                    Sedang nonaktif
                                @endif
                            </div>
                        </div>
                        <form method="POST" action="{{ route('security.two-factor.toggle') }}">
                            @csrf
                            <label class="switch">
                                <input type="checkbox" onchange="this.form.submit()" {{ isset($user->two_factor_enabled) && $user->two_factor_enabled ? 'checked' : '' }}>
                                <span class="switch-track"></span>
                            </label>
                        </form>
                    </div>
                </div>

                <!-- SESI AKTIF -->
                <div class="sec-card animate-in" style="animation-delay: 0.20s;">
                    <div class="sec-card-head">
                        <div>
                            <div class="sec-card-title">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="14" rx="2"/>
                                    <path d="M8 21h8M12 17v4"/>
                                </svg>
                                Sesi Login Aktif
                            </div>
                            <p class="sec-card-desc" style="margin-bottom: 12px;">Daftar perangkat yang sedang login ke akunmu.</p>
                        </div>
                        @if($sessions->count() > 1)
                            <form method="POST" action="{{ route('security.sessions.revoke-others') }}" onsubmit="return confirm('⚠️ Akhiri semua sesi lain?')">
                                @csrf
                                <button type="submit" class="sec-btn sec-btn-ghost sec-btn-sm" style="color:var(--danger);border-color:var(--danger-soft);">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                    Akhiri Sesi Lain
                                </button>
                            </form>
                        @endif
                    </div>

                    @forelse($sessions as $s)
                        <div class="sess-row">
                            <div class="sess-ic">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    @if(isset($s->device) && $s->device == 'Mobile')
                                        <rect x="5" y="2" width="14" height="20" rx="2"/>
                                        <line x1="12" y1="18" x2="12.01" y2="18"/>
                                    @elseif(isset($s->device) && $s->device == 'Laptop')
                                        <rect x="4" y="3" width="16" height="14" rx="2"/>
                                        <line x1="8" y1="21" x2="16" y2="21"/>
                                    @elseif(isset($s->device) && $s->device == 'Desktop')
                                        <rect x="4" y="2" width="16" height="16" rx="2"/>
                                        <line x1="8" y1="20" x2="16" y2="20"/>
                                    @else
                                        <rect x="2" y="4" width="20" height="14" rx="2"/>
                                        <path d="M8 21h8M12 17v4"/>
                                    @endif
                                </svg>
                            </div>
                            <div class="sess-info">
                                <div class="sess-agent">
                                    <svg class="icon device-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        @if(isset($s->device) && $s->device == 'Mobile')
                                            <rect x="5" y="2" width="14" height="20" rx="2"/>
                                            <line x1="12" y1="18" x2="12.01" y2="18"/>
                                        @elseif(isset($s->device) && $s->device == 'Laptop')
                                            <rect x="4" y="3" width="16" height="14" rx="2"/>
                                            <line x1="8" y1="21" x2="16" y2="21"/>
                                        @elseif(isset($s->device) && $s->device == 'Desktop')
                                            <rect x="4" y="2" width="16" height="16" rx="2"/>
                                            <line x1="8" y1="20" x2="16" y2="20"/>
                                        @else
                                            <rect x="2" y="4" width="20" height="14" rx="2"/>
                                            <path d="M8 21h8M12 17v4"/>
                                        @endif
                                    </svg>
                                    {{ \Illuminate\Support\Str::limit($s->user_agent ?? 'Perangkat tidak dikenal', 50) }}
                                    @if(isset($s->is_current) && $s->is_current)
                                        <span class="current-tag">Perangkat Ini</span>
                                    @endif
                                </div>
                                <div class="sess-meta">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ $s->ip_address ?? '—' }}
                                    @if(isset($s->location))
                                        <span class="dot"></span>
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        {{ $s->location }}
                                    @endif
                                    <span class="dot"></span>
                                    Aktif {{ $s->last_activity_human ?? 'baru saja' }}
                                </div>
                            </div>
                            @if(!isset($s->is_current) || !$s->is_current)
                                <form method="POST" action="{{ route('security.sessions.revoke', $s->id ?? 1) }}" onsubmit="return confirm('Akhiri sesi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="sec-btn sec-btn-ghost sec-btn-sm" style="color:var(--danger);border-color:var(--danger-soft);">
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"/>
                                            <line x1="6" y1="6" x2="18" y2="18"/>
                                        </svg>
                                        Akhiri
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="empty-hint">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="14" rx="2"/>
                                <path d="M8 21h8M12 17v4"/>
                            </svg>
                            Tidak ada sesi aktif.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ===== SIDEBAR ===== -->
            <div class="sec-side">

                <!-- SCORE CARD -->
                <div class="score-card animate-in" style="animation-delay: 0.12s;">
                    <div class="score-label">Skor Keamanan Akun</div>
                    <div class="score-ring">
                        <svg viewBox="0 0 100 100">
                            <circle class="bg" cx="50" cy="50" r="42" stroke-width="8"/>
                            <circle class="fg {{ $score >= 80 ? 'high' : ($score >= 50 ? 'medium' : 'low') }}" 
                                    cx="50" cy="50" r="42" stroke-width="8"
                                    stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"/>
                        </svg>
                        <div class="score-num">{{ $score }}%</div>
                    </div>
                    <div class="score-title {{ $score >= 80 ? 'high' : ($score >= 50 ? 'medium' : 'low') }}">
                        @if($score >= 80) Sangat Aman
                        @elseif($score >= 50) Cukup Aman
                        @else Perlu Ditingkatkan
                        @endif
                    </div>

                    <div class="checklist">
                        <div class="check-row">
                            <span class="check-ic done">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </span>
                            Password aktif
                        </div>
                        <div class="check-row">
                            <span class="check-ic {{ isset($user->two_factor_enabled) && $user->two_factor_enabled ? 'done' : 'pending' }}">
                                @if(isset($user->two_factor_enabled) && $user->two_factor_enabled)
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                @else
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="12" x2="12" y2="12.01"/>
                                    </svg>
                                @endif
                            </span>
                            Autentikasi dua faktor {{ isset($user->two_factor_enabled) && $user->two_factor_enabled ? 'aktif' : 'belum aktif' }}
                        </div>
                        <div class="check-row">
                            <span class="check-ic {{ $sessions->count() <= 1 ? 'done' : 'pending' }}">
                                @if($sessions->count() <= 1)
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                @else
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="12" x2="12" y2="12.01"/>
                                    </svg>
                                @endif
                            </span>
                            {{ $sessions->count() }} sesi login aktif
                        </div>
                    </div>
                </div>

                <div class="info-card animate-in" style="animation-delay: 0.15s;">
                    <div class="t">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Kenapa ini penting?
                    </div>
                    <p>Akun dengan 2FA aktif dan password yang rutin diperbarui jauh lebih sulit dibobol. Periksa daftar sesi secara berkala dan akhiri sesi dari perangkat yang tidak kamu kenali.</p>
                </div>

                <div class="info-card animate-in" style="animation-delay: 0.18s;">
                    <div class="t">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <polyline points="9 12 11 14 15 10"/>
                        </svg>
                        Rekomendasi
                    </div>
                    <p>
                        @if(!isset($user->two_factor_enabled) || !$user->two_factor_enabled)
                            <span class="highlight">Aktifkan 2FA</span> sekarang untuk menaikkan skor keamanan akunmu secara signifikan.
                        @elseif($sessions->count() > 1)
                            Kamu punya <span class="highlight">{{ $sessions->count() }} sesi aktif</span>. Akhiri sesi yang tidak dikenali untuk keamanan ekstra.
                        @else
                            Akunmu dalam <span class="highlight">kondisi baik</span>. Tetap perbarui password secara berkala setiap 3 bulan.
                        @endif
                    </p>
                </div>

                <div class="info-card animate-in" style="animation-delay: 0.20s;">
                    <div class="t">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Riwayat Login Terakhir
                    </div>
                    <p>
                        @if($sessions->isNotEmpty())
                            Login terbaru tercatat <span class="highlight">{{ $sessions->first()->last_activity_human ?? 'baru saja' }}</span> 
                            dari {{ $sessions->first()->ip_address ?? 'alamat tidak diketahui' }}.
                        @else
                            Belum ada riwayat login tercatat.
                        @endif
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.sec-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        return;
                    }
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

            // ===== TOGGLE 2FA =====
            const toggleSwitch = document.querySelector('.switch input');
            if (toggleSwitch) {
                toggleSwitch.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            }
        });
    </script>

</x-app-layout>