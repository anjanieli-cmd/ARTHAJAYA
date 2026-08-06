<x-admin-layout>
    <x-slot name="title">Keamanan Akun</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </symbol>
            <symbol id="ic-shield-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>
            </symbol>
            <symbol id="ic-key" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="7.5" cy="15.5" r="5.5"/><path d="M21 2l-9.6 9.6"/><path d="M15.5 7.5l3 3L22 7l-3-3"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-smartphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .asw {
            --theme-primary: var(--emerald);
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
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            --info-glow: rgba(78, 143, 240, 0.3);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 28px 20px;
        }

        .asw * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .asw .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .asw .icon {
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

        /* ===== HEADER ===== */
        .asw-head {
            margin-bottom: 28px;
        }
        .asw-badge {
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
        .asw-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }
        .asw-head h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }
        .asw-head p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.6;
        }

        /* ===== ALERT ===== */
        .alert-success {
            background: rgba(var(--emerald-rgb), 0.08);
            border: 1px solid rgba(var(--emerald-rgb), 0.2);
            color: var(--emerald);
            padding: 14px 20px;
            border-radius: 14px;
            font-size: 13.5px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success .icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        .alert-error {
            background: rgba(232, 90, 90, 0.08);
            border: 1px solid rgba(232, 90, 90, 0.2);
            color: var(--danger);
            padding: 14px 20px;
            border-radius: 14px;
            font-size: 13.5px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-error .icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* ===== STATUS BANNER ===== */
        .sec-banner {
            display: flex;
            align-items: center;
            gap: 16px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px 28px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }
        .sec-banner:hover {
            border-color: var(--border-hover);
        }
        .sec-banner .ic {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--theme-soft);
            border: 1px solid rgba(var(--emerald-rgb), 0.15);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        .sec-banner:hover .ic {
            transform: scale(1.05) rotate(-3deg);
        }
        .sec-banner .ic .icon {
            width: 22px;
            height: 22px;
        }
        .sec-banner .txt strong {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .sec-banner .txt p {
            font-size: 13px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        /* ===== SETTINGS LIST ===== */
        .sec-list {
            display: flex;
            flex-direction: column;
            gap: 1px;
            background: var(--border-color);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 24px;
        }
        .sec-row {
            background: var(--bg-card);
            padding: 22px 26px;
            display: flex;
            align-items: center;
            gap: 16px;
            justify-content: space-between;
            flex-wrap: wrap;
            transition: background 0.3s ease;
        }
        .sec-row:hover {
            background: var(--bg-card-hover);
        }
        .sec-row-left {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 220px;
        }
        .sec-row-ic {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: var(--info-soft);
            color: var(--info);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sec-row-ic .icon {
            width: 18px;
            height: 18px;
        }
        .sec-row-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }
        .sec-row-sub {
            font-size: 12.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }
        .sec-row-status {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .sec-row-status .sdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        .sec-row-status.active {
            background: rgba(var(--emerald-rgb), 0.12);
            color: var(--emerald);
        }
        .sec-row-status.active .sdot {
            background: var(--emerald);
            animation: pulseGlow 1.8s ease-in-out infinite;
        }
        .sec-row-status.inactive {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }
        .sec-row-status.inactive .sdot {
            background: var(--text-tertiary);
        }

        /* ===== TOGGLE SWITCH ===== */
        .switch {
            position: relative;
            width: 48px;
            height: 28px;
            flex-shrink: 0;
        }
        .switch input {
            display: none;
        }
        .switch-track {
            position: absolute;
            inset: 0;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: 100px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .switch-track::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: var(--text-tertiary);
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .switch input:checked + .switch-track {
            background: rgba(var(--emerald-rgb), 0.2);
            border-color: var(--emerald);
        }
        .switch input:checked + .switch-track::after {
            transform: translateX(20px);
            background: var(--emerald);
            box-shadow: 0 2px 8px var(--theme-glow);
        }
        .switch input:focus-visible + .switch-track {
            outline: 2px solid var(--theme-primary);
            outline-offset: 2px;
        }

        /* ===== PASSWORD PANEL ===== */
        .pw-panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 28px 30px;
            transition: all 0.3s ease;
        }
        .pw-panel:hover {
            border-color: var(--border-hover);
        }
        .pw-panel .panel-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }
        .pw-panel .panel-head .ic {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: var(--theme-soft);
            border: 1px solid rgba(var(--emerald-rgb), 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--theme-primary);
            flex-shrink: 0;
        }
        .pw-panel .panel-head .ic .icon {
            width: 15px;
            height: 15px;
        }
        .pw-panel .panel-head h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }
        .pw-panel .panel-head .sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }
        .pw-panel .divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 16px 0 22px;
        }

        .field-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }
        .field.full {
            grid-column: 1 / -1;
        }
        .field label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
        }
        .field input {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 14px;
            outline: none;
            font-family: inherit;
            transition: all 0.25s ease;
        }
        .field input:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }
        .field input::placeholder {
            color: var(--text-tertiary);
        }
        .field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }
        .field-hint {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 3px;
        }

        /* ===== FORM ACTIONS ===== */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--border-color);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: inherit;
        }
        .btn .icon {
            width: 16px;
            height: 16px;
        }
        .btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 20px var(--theme-glow);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px var(--theme-glow);
        }
        .btn-primary:active {
            transform: scale(0.97);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .asw {
                padding: 0 16px 16px;
            }
            .asw-head h1 {
                font-size: 22px;
            }
            .sec-banner {
                padding: 18px 20px;
                flex-direction: column;
                text-align: center;
            }
            .sec-row {
                padding: 18px 20px;
                flex-direction: column;
                align-items: flex-start;
            }
            .sec-row-left {
                width: 100%;
            }
            .field-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .pw-panel {
                padding: 22px 20px;
            }
            .form-actions {
                justify-content: stretch;
            }
            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .asw {
                padding: 0 12px 12px;
            }
            .asw-head h1 {
                font-size: 19px;
            }
            .asw-head p {
                font-size: 13px;
            }
            .sec-banner {
                padding: 16px;
                border-radius: var(--radius-md);
            }
            .sec-banner .ic {
                width: 40px;
                height: 40px;
            }
            .sec-banner .ic .icon {
                width: 18px;
                height: 18px;
            }
            .sec-banner .txt strong {
                font-size: 14px;
            }
            .sec-banner .txt p {
                font-size: 12px;
            }
            .sec-row {
                padding: 14px 16px;
            }
            .sec-row-ic {
                width: 34px;
                height: 34px;
            }
            .sec-row-ic .icon {
                width: 15px;
                height: 15px;
            }
            .sec-row-title {
                font-size: 13px;
            }
            .sec-row-sub {
                font-size: 11.5px;
            }
            .pw-panel {
                padding: 18px 16px;
                border-radius: var(--radius-md);
            }
            .pw-panel .panel-head h3 {
                font-size: 14px;
            }
            .field input {
                font-size: 13px;
                padding: 10px 14px;
            }
            .btn {
                font-size: 13px;
                padding: 10px 20px;
            }
            .asw-badge {
                font-size: 10px;
                padding: 4px 12px 4px 8px;
            }
            .alert-success,
            .alert-error {
                font-size: 12.5px;
                padding: 12px 16px;
            }
            .switch {
                width: 42px;
                height: 24px;
            }
            .switch-track::after {
                width: 17px;
                height: 17px;
                top: 2.5px;
                left: 2.5px;
            }
            .switch input:checked + .switch-track::after {
                transform: translateX(18px);
            }
            .sec-row-status {
                font-size: 11px;
                padding: 3px 12px;
            }
        }
    </style>

    <div class="asw">
        {{-- ===== HEADER ===== --}}
        <div class="asw-head animate-in" style="animation-delay: 0.03s;">
            <div class="asw-badge">
                <span class="dot"></span>
                Keamanan
            </div>
            <h1>Keamanan Akun</h1>
            <p>Kelola password dan pengaturan keamanan akun admin kamu.</p>
        </div>

        {{-- ===== ALERTS ===== --}}
        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay: 0.05s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert-error animate-in" style="animation-delay: 0.05s;">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ===== STATUS BANNER ===== --}}
        <div class="sec-banner animate-in" style="animation-delay: 0.08s;">
            <div class="ic"><svg class="icon"><use href="#ic-shield-check"/></svg></div>
            <div class="txt">
                <strong>Akun kamu {{ $admin->two_factor_enabled ? 'terlindungi dengan 2FA' : 'menggunakan proteksi standar' }}</strong>
                <p>Password terakhir diubah: {{ $admin->password_changed_at ? $admin->password_changed_at->translatedFormat('d M Y, H:i') : 'Belum pernah diubah' }}</p>
            </div>
        </div>

        {{-- ===== SETTINGS LIST ===== --}}
        <div class="sec-list animate-in" style="animation-delay: 0.12s;">
            <div class="sec-row">
                <div class="sec-row-left">
                    <div class="sec-row-ic"><svg class="icon"><use href="#ic-smartphone"/></svg></div>
                    <div>
                        <div class="sec-row-title">Autentikasi Dua Faktor (2FA)</div>
                        <div class="sec-row-sub">Tambahan lapisan keamanan saat login ke panel admin.</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    <span class="sec-row-status {{ $admin->two_factor_enabled ? 'active' : 'inactive' }}">
                        <span class="sdot"></span>
                        {{ $admin->two_factor_enabled ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <form method="POST" action="{{ route('admin.security.two-factor.toggle') }}">
                        @csrf
                        <label class="switch">
                            <input type="checkbox" name="enabled" value="1" {{ $admin->two_factor_enabled ? 'checked' : '' }} onchange="this.closest('form').submit()">
                            <span class="switch-track"></span>
                        </label>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== PASSWORD PANEL ===== --}}
        <div class="pw-panel animate-in" style="animation-delay: 0.16s;">
            <div class="panel-head">
                <span class="ic"><svg class="icon"><use href="#ic-key"/></svg></span>
                <div>
                    <h3>Ubah Password</h3>
                    <div class="sub">Gunakan password yang kuat dan belum pernah dipakai di layanan lain.</div>
                </div>
            </div>
            <hr class="divider">

            <form method="POST" action="{{ route('admin.security.password.update') }}">
                @csrf
                @method('PUT')
                <div class="field-grid">
                    <div class="field full">
                        <label>Password Saat Ini</label>
                        <input type="password" name="current_password" placeholder="Masukkan password saat ini" required>
                        @error('current_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" placeholder="Minimal 8 karakter" required minlength="8">
                        <span class="field-hint">Minimal 8 karakter, kombinasi huruf dan angka</span>
                        @error('new_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru" required minlength="8">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon"><use href="#ic-check-circle"/></svg>
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>