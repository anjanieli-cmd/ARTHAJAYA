<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>

    @php
        $user = $user ?? (object) [
            'name' => 'Andi Pratama',
            'email' => 'andi@company.com',
            'phone' => '08123456789',
            'position' => 'Admin',
            'avatar' => null,
            'created_at' => now()->subMonths(6),
        ];

        $company = $company ?? (object) [
            'name' => 'PT Teknologi Maju',
        ];

        $positions = ['Admin', 'Manager', 'Staff', 'Viewer', 'Developer', 'Designer'];
    @endphp

    <style>
        /* ============================================
           PROFIL SAYA - Modern Design
           ============================================ */
        
        .profile-wrap {
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

        .profile-wrap * { box-sizing: border-box; }
        .profile-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .profile-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .profile-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .profile-header-left { flex: 1; min-width: 200px; }

        .profile-badge {
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

        .profile-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .profile-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .profile-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .profile-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .profile-btn {
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

        .profile-btn .icon { width: 16px; height: 16px; }
        .profile-btn:hover { transform: translateY(-2px); }
        .profile-btn:active { transform: translateY(0) scale(0.97); }

        .profile-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .profile-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .profile-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .profile-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .profile-btn .ripple {
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
        .profile-alert {
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .profile-alert .icon { width: 20px; height: 20px; flex-shrink: 0; }
        .profile-alert.success { background: var(--success-soft); border: 1px solid var(--success); color: var(--success); }
        .profile-alert.error { background: var(--danger-soft); border: 1px solid var(--danger); color: var(--danger); }

        /* LAYOUT */
        .profile-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1100px) {
            .profile-layout { grid-template-columns: 1fr; }
        }

        /* ===== SIDEBAR ===== */
        .profile-side {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 28px 24px;
            text-align: center;
            position: sticky;
            top: 20px;
            transition: all 0.3s ease;
        }

        .profile-side:hover {
            border-color: var(--border-hover);
        }

        .profile-avatar-wrap {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 16px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--bg-card-active);
            border: 3px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 700;
            color: var(--text-secondary);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .profile-side:hover .profile-avatar {
            border-color: var(--theme-primary);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar .avatar-initial {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .profile-avatar .avatar-badge {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--theme-primary);
            border: 3px solid var(--bg-card);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .profile-avatar .avatar-badge .icon {
            width: 14px;
            height: 14px;
            stroke: #fff;
        }

        .profile-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .profile-role {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
            margin-bottom: 20px;
        }

        .profile-upload-form {
            border-top: 1px solid var(--border-color);
            padding-top: 18px;
            text-align: left;
        }

        .profile-upload-form .file-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .profile-file-input {
            position: relative;
        }

        .profile-file-input input[type="file"] {
            width: 100%;
            padding: 8px;
            font-size: 12px;
            color: var(--text-secondary);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            cursor: pointer;
        }

        .profile-file-input input[type="file"]::file-selector-button {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            margin-right: 8px;
            transition: all 0.2s ease;
        }

        .profile-file-input input[type="file"]::file-selector-button:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
        }

        .profile-upload-form .profile-btn {
            width: 100%;
            justify-content: center;
            margin-top: 10px;
        }

        /* META INFO */
        .profile-meta {
            text-align: left;
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
            margin-top: 20px;
        }

        .profile-meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 12.5px;
            padding: 7px 0;
        }

        .profile-meta-row .k {
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .profile-meta-row .k .icon {
            width: 14px;
            height: 14px;
        }

        .profile-meta-row .v {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* TIPS */
        .profile-tips {
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            border-radius: var(--radius-sm);
            padding: 16px 18px;
            margin-top: 18px;
            text-align: left;
        }

        .profile-tips .t {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--theme-primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .profile-tips .t .icon {
            width: 16px;
            height: 16px;
            color: var(--theme-primary);
        }

        .profile-tips ul {
            margin: 0;
            padding-left: 16px;
        }

        .profile-tips li {
            font-size: 11.5px;
            color: var(--text-secondary);
            line-height: 1.8;
        }

        .profile-tips-dark {
            background: var(--bg-card-active);
            border-color: var(--border-color);
        }

        .profile-tips-dark .t {
            color: var(--text-primary);
        }

        /* ===== MAIN CONTENT ===== */
        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .profile-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 28px 32px;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            border-color: var(--border-hover);
        }

        .profile-card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-card-title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .profile-card-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0 0 22px;
            line-height: 1.6;
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

        .form-control:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
            padding-right: 40px;
        }

        select.form-control option {
            background: var(--bg-card);
            color: var(--text-primary);
            padding: 8px;
        }

        .form-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        .form-status {
            font-size: 12.5px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-status .icon {
            width: 16px;
            height: 16px;
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
            flex-wrap: wrap;
        }

        /* DANGER ZONE */
        .profile-card.danger-zone {
            border-color: rgba(232, 90, 90, 0.25);
        }

        .profile-card.danger-zone:hover {
            border-color: rgba(232, 90, 90, 0.4);
        }

        .profile-card.danger-zone .profile-card-title {
            color: var(--danger);
        }

        .profile-card.danger-zone .profile-card-title .icon {
            color: var(--danger);
        }

        .profile-card.danger-zone .profile-card-desc {
            color: var(--text-secondary);
        }

        .profile-btn-danger {
            background: transparent;
            border: 1.5px solid var(--danger);
            color: var(--danger);
        }

        .profile-btn-danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
            transform: translateY(-2px);
            color: var(--danger);
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .profile-wrap { padding: 0 16px; }
            .profile-card { padding: 24px; }
        }

        @media (max-width: 768px) {
            .profile-wrap { padding: 0 12px; }
            .profile-layout { grid-template-columns: 1fr; }
            .profile-side { position: static; }
            .profile-header { flex-direction: column; align-items: stretch; }
            .profile-actions { width: 100%; }
            .profile-actions .profile-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .profile-card { padding: 20px; }
            .grid-2 { grid-template-columns: 1fr; }
            .profile-avatar-wrap { width: 80px; height: 80px; }
            .profile-avatar { width: 80px; height: 80px; font-size: 28px; }
        }

        @media (max-width: 640px) {
            .profile-wrap { padding: 0 8px; }
            .profile-header h1 { font-size: 22px; }
            .profile-card { padding: 16px; }
            .profile-side { padding: 20px 16px; }
            .profile-avatar-wrap { width: 72px; height: 72px; }
            .profile-avatar { width: 72px; height: 72px; font-size: 24px; }
            .profile-name { font-size: 16px; }
            .form-actions { flex-direction: column; align-items: stretch; }
            .form-actions .profile-btn { width: 100%; justify-content: center; }
        }

        @media (max-width: 480px) {
            .profile-wrap { padding: 0 4px; }
            .profile-btn { font-size: 11px; padding: 6px 10px; }
            .profile-btn .icon { width: 14px; height: 14px; }
            .form-control { font-size: 12px; padding: 10px 12px; }
            .profile-card { padding: 14px; }
            .profile-card-title { font-size: 14px; }
        }
    </style>

    <div class="profile-wrap">

        <!-- ===== HEADER ===== -->
        <div class="profile-header animate-in" style="animation-delay: 0.05s;">
            <div class="profile-header-left">
                <div class="profile-badge">
                    <span class="dot"></span>
                    Profil
                </div>
                <h1>Profil Saya</h1>
                <p class="subtitle">Kelola informasi akun pribadimu.</p>
            </div>
            <div class="profile-actions">
                <a href="{{ route('security.index') }}" class="profile-btn profile-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <polyline points="9 12 11 14 15 10"/>
                    </svg>
                    Keamanan
                </a>
                <a href="{{ route('dashboard') }}" class="profile-btn profile-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>

        <!-- ===== ALERTS ===== -->
        @if(session('success'))
            <div class="profile-alert success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="profile-alert error animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- ===== LAYOUT ===== -->
        <div class="profile-layout">

            <!-- ===== SIDEBAR ===== -->
            <div class="profile-side animate-in" style="animation-delay: 0.10s;">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar">
                        @if(isset($user->avatar) && $user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <span class="avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="avatar-badge">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>

                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-role">{{ $user->position ?? 'Jabatan belum diisi' }}</div>

                <!-- Upload Avatar -->
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-upload-form">
                    @csrf
                    @method('patch')

                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="phone" value="{{ $user->phone ?? '' }}">
                    <input type="hidden" name="position" value="{{ $user->position ?? '' }}">

                    <label class="file-label">
                        <svg class="icon" style="width:14px;height:14px;display:inline;vertical-align:middle;margin-right:4px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        Ganti Foto Profil
                    </label>
                    <div class="profile-file-input">
                        <input type="file" name="avatar" accept="image/jpeg,image/png,image/jpg">
                    </div>
                    <small style="font-size:10.5px;color:var(--text-tertiary);display:block;margin-top:4px;">JPG/PNG • Maks 2MB</small>
                    @error('avatar')<div class="form-error">{{ $message }}</div>@enderror
                    <button type="submit" class="profile-btn profile-btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Unggah Foto
                    </button>
                </form>

                <!-- Meta Info -->
                <div class="profile-meta">
                    <div class="profile-meta-row">
                        <span class="k">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                            Perusahaan
                        </span>
                        <span class="v">{{ $company->name ?? '—' }}</span>
                    </div>
                    <div class="profile-meta-row">
                        <span class="k">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22 6 12 13 2 6"/>
                            </svg>
                            Email
                        </span>
                        <span class="v">{{ \Illuminate\Support\Str::limit($user->email, 20) }}</span>
                    </div>
                    <div class="profile-meta-row">
                        <span class="k">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Bergabung
                        </span>
                        <span class="v">{{ isset($user->created_at) ? $user->created_at->translatedFormat('d M Y') : '—' }}</span>
                    </div>
                </div>

                <!-- Tips -->
                <div class="profile-tips">
                    <div class="t">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Tips Keamanan
                    </div>
                    <ul>
                        <li>Gunakan foto profil asli agar tim mudah mengenalimu.</li>
                        <li>Pastikan email aktif untuk menerima notifikasi penting.</li>
                        <li>Perbarui nomor telepon jika berganti kontak.</li>
                    </ul>
                </div>

                <div class="profile-tips profile-tips-dark">
                    <div class="t">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        Butuh Bantuan?
                    </div>
                    <div style="font-size:11.5px;color:var(--text-secondary);line-height:1.7;">
                        Hubungi admin perusahaan jika lupa password atau butuh bantuan mengelola akun. 
                        Untuk ganti password, buka menu <strong style="color:var(--text-primary);">Keamanan</strong>.
                    </div>
                </div>
            </div>

            <!-- ===== MAIN CONTENT ===== -->
            <div class="profile-main">

                <!-- Update Profile -->
                <div class="profile-card animate-in" style="animation-delay: 0.12s;">
                    <div class="profile-card-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Informasi Profil
                    </div>
                    <p class="profile-card-desc">Perbarui informasi pribadi dan detail akunmu.</p>

                    <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="required">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                                @error('name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Email <span class="required">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                                @error('email')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control" placeholder="0812 3456 7890">
                                @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select name="position" class="form-control">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($positions ?? ['Admin','Manager','Staff','Viewer','Developer','Designer'] as $pos)
                                        <option value="{{ $pos }}" {{ old('position', $user->position ?? '') == $pos ? 'selected' : '' }}>
                                            {{ $pos }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="profile-btn profile-btn-primary">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                    <polyline points="17 21 17 13 7 13 7 21"/>
                                    <polyline points="7 3 7 8 15 8"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                            <span class="form-status" id="profileStatus" style="display:none;">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                Perubahan tersimpan
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Danger Zone -->
                <div class="profile-card danger-zone animate-in" style="animation-delay: 0.15s;">
                    <div class="profile-card-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Hapus Akun
                    </div>
                    <p class="profile-card-desc">
                        Setelah akun dihapus, semua data dan resource akan dihapus secara permanen. 
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('⚠️ Apakah Anda yakin ingin menghapus akun secara permanen? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="profile-btn profile-btn-danger">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>
                            Hapus Akun Saya
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.profile-btn');
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

            // ===== PROFILE FORM STATUS =====
            const form = document.getElementById('profileForm');
            const status = document.getElementById('profileStatus');

            if (form && status) {
                form.addEventListener('submit', function() {
                    status.style.display = 'inline-flex';
                    setTimeout(() => {
                        status.style.display = 'none';
                    }, 3000);
                });
            }

            // ===== FILE INPUT LABEL =====
            const fileInput = document.querySelector('input[name="avatar"]');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    const fileName = this.files[0]?.name || 'Tidak ada file dipilih';
                    const label = this.closest('.profile-file-input').querySelector('small');
                    if (label) {
                        label.textContent = '📎 ' + fileName + ' • ' + (this.files[0]?.size ? (this.files[0].size / 1024).toFixed(1) + ' KB' : '');
                    }
                });
            }
        });
    </script>

</x-app-layout>