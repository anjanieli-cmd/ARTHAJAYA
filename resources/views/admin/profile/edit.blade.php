<x-admin-layout>
    <x-slot name="title">Lihat Profil</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </symbol>
            <symbol id="ic-camera" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 6 12 13 2 6"/>
            </symbol>
            <symbol id="ic-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
            </symbol>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>
            </symbol>
            <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
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
        .apw {
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
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 28px 20px;
        }

        .apw * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeSlideLeft {
            from { opacity: 0; transform: translateX(-16px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .apw .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .apw .animate-in-left {
            animation: fadeSlideLeft 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .apw .icon {
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
        .apw-head {
            margin-bottom: 28px;
        }
        .apw-badge {
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
        .apw-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }
        .apw-head h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }
        .apw-head p {
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

        /* ===== LAYOUT ===== */
        .apw-layout {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* ===== LEFT: AVATAR CARD ===== */
        .avatar-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 34px 24px;
            text-align: center;
            position: sticky;
            top: 20px;
            transition: all 0.3s ease;
        }
        .avatar-card:hover {
            border-color: var(--border-hover);
        }

        .avatar-wrap {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 18px;
        }
        .avatar-img {
            width: 120px;
            height: 120px;
            border-radius: 28px;
            object-fit: cover;
            background: var(--bg-card-active);
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 40px;
            color: var(--theme-primary);
            transition: all 0.3s ease;
        }
        .avatar-card:hover .avatar-img {
            border-color: var(--border-hover);
        }

        .avatar-cam {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--theme-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid var(--bg-card);
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px var(--theme-glow);
        }
        .avatar-cam:hover {
            transform: scale(1.1);
        }
        .avatar-cam .icon {
            width: 15px;
            height: 15px;
        }

        .avatar-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--text-primary);
        }
        .avatar-email {
            font-size: 13px;
            color: var(--text-tertiary);
            margin-bottom: 16px;
        }
        .avatar-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            color: var(--theme-primary);
            background: var(--theme-soft);
            padding: 6px 14px;
            border-radius: 100px;
            border: 1px solid rgba(var(--emerald-rgb), 0.15);
        }
        .avatar-badge .icon {
            width: 13px;
            height: 13px;
        }

        /* ===== RIGHT: FORM SECTIONS ===== */
        .form-section {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 28px 30px;
            margin-bottom: 18px;
            transition: all 0.3s ease;
        }
        .form-section:hover {
            border-color: var(--border-hover);
        }
        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-section .section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }
        .form-section .section-head .ic {
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
        .form-section .section-head .ic .icon {
            width: 15px;
            height: 15px;
        }
        .form-section .section-head h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }
        .form-section .section-head .sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 2px;
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
        .field input:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
        @media (max-width: 900px) {
            .apw {
                padding: 0 16px 16px;
            }
            .apw-layout {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .avatar-card {
                position: static;
            }
            .field-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
        }

        @media (max-width: 768px) {
            .apw-head h1 {
                font-size: 22px;
            }
            .avatar-wrap {
                width: 100px;
                height: 100px;
            }
            .avatar-img {
                width: 100px;
                height: 100px;
                font-size: 32px;
                border-radius: 24px;
            }
            .avatar-cam {
                width: 32px;
                height: 32px;
            }
            .avatar-cam .icon {
                width: 13px;
                height: 13px;
            }
            .form-section {
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
            .apw {
                padding: 0 12px 12px;
            }
            .apw-head h1 {
                font-size: 19px;
            }
            .apw-head p {
                font-size: 13px;
            }
            .avatar-wrap {
                width: 80px;
                height: 80px;
            }
            .avatar-img {
                width: 80px;
                height: 80px;
                font-size: 28px;
                border-radius: 20px;
            }
            .avatar-cam {
                width: 28px;
                height: 28px;
                bottom: 0;
                right: 0;
            }
            .avatar-cam .icon {
                width: 12px;
                height: 12px;
            }
            .avatar-name {
                font-size: 17px;
            }
            .form-section {
                padding: 18px 16px;
                border-radius: var(--radius-md);
            }
            .form-section .section-head h3 {
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
            .apw-badge {
                font-size: 10px;
                padding: 4px 12px 4px 8px;
            }
            .alert-success,
            .alert-error {
                font-size: 12.5px;
                padding: 12px 16px;
            }
        }
    </style>

    <div class="apw">
        {{-- ===== HEADER ===== --}}
        <div class="apw-head animate-in" style="animation-delay: 0.03s;">
            <div class="apw-badge">
                <span class="dot"></span>
                Akun Saya
            </div>
            <h1>Lihat Profil</h1>
            <p>Kelola informasi akun admin sistem kamu.</p>
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

        {{-- ===== FORM ===== --}}
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="apw-layout">
                {{-- LEFT: AVATAR --}}
                <div class="avatar-card animate-in-left" style="animation-delay: 0.08s;">
                    <div class="avatar-wrap">
                        @if($admin->avatar)
                            <img src="{{ asset('storage/' . $admin->avatar) }}" class="avatar-img" id="avatarPreview" alt="Avatar">
                        @else
                            <div class="avatar-img" id="avatarPreview">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
                        @endif
                        <label class="avatar-cam" for="avatarInput" title="Ganti foto profil">
                            <svg class="icon"><use href="#ic-camera"/></svg>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;" onchange="previewAvatar(event)">
                    </div>
                    <div class="avatar-name">{{ $admin->name }}</div>
                    <div class="avatar-email">{{ $admin->email }}</div>
                    <span class="avatar-badge">
                        <svg class="icon"><use href="#ic-shield"/></svg>
                        Admin Sistem
                    </span>
                </div>

                {{-- RIGHT: FORM FIELDS --}}
                <div>
                    {{-- INFORMASI UMUM --}}
                    <div class="form-section animate-in" style="animation-delay: 0.12s;">
                        <div class="section-head">
                            <span class="ic"><svg class="icon"><use href="#ic-user"/></svg></span>
                            <div>
                                <h3>Informasi Umum</h3>
                                <div class="sub">Data diri admin sistem</div>
                            </div>
                        </div>
                        <div class="field-grid">
                            <div class="field">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required>
                                @error('name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label>Posisi / Jabatan</label>
                                <input type="text" name="position" value="{{ old('position', $admin->position) }}" placeholder="Mis: System Administrator">
                                <span class="field-hint">Opsional — akan ditampilkan di profil</span>
                            </div>
                        </div>
                    </div>

                    {{-- KONTAK --}}
                    <div class="form-section animate-in" style="animation-delay: 0.16s;">
                        <div class="section-head">
                            <span class="ic"><svg class="icon"><use href="#ic-mail"/></svg></span>
                            <div>
                                <h3>Kontak</h3>
                                <div class="sub">Informasi kontak admin</div>
                            </div>
                        </div>
                        <div class="field-grid">
                            <div class="field">
                                <label>Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                @error('email')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label>Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" placeholder="Mis: 0812-3456-7890">
                                <span class="field-hint">Opsional — untuk keperluan kontak</span>
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="form-actions animate-in" style="animation-delay: 0.20s;">
                        <button type="submit" class="btn btn-primary">
                            <svg class="icon"><use href="#ic-check-circle"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewAvatar(event) {
            var file = event.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('avatarPreview');
                preview.outerHTML = '<img src="' + e.target.result + '" class="avatar-img" id="avatarPreview" alt="Avatar">';
            };
            reader.readAsDataURL(file);
        }
    </script>
</x-admin-layout>