<x-user-layout>
    <x-slot name="title">Profil Saya</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <style>
        /* ============================================
           PROFIL USER - Premium Design (FULL WIDTH)
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
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            width: 100%;
            padding: 0 24px;
        }

        .profile-wrap * { box-sizing: border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .profile-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .profile-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* ===== HEADER ===== */
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

        /* ===== ALERTS ===== */
        .profile-alert {
            border-radius: var(--radius-md);
            padding: 14px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .profile-alert-success {
            background: var(--success-soft);
            border: 1px solid rgba(52, 181, 131, 0.25);
            color: var(--success);
        }

        .profile-alert-error {
            background: var(--danger-soft);
            border: 1px solid rgba(232, 90, 90, 0.25);
            color: var(--danger);
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-alert-error ul { padding-left: 18px; margin: 4px 0 0; }

        /* ===== PROFILE CARD ===== */
        .profile-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 36px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            max-width: 100%;
            width: 100%;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--theme-gradient);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .profile-card:hover { border-color: var(--border-hover); }

        .profile-card .card-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .profile-card .card-head .icon-box {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: var(--theme-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .profile-card .card-head .icon-box svg { width: 20px; height: 20px; }

        .profile-card .card-head .head-text h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
            letter-spacing: -0.02em;
        }

        .profile-card .card-head .head-text p {
            font-size: 13px;
            color: var(--text-tertiary);
            margin: 0;
        }

        /* ===== PROFILE PHOTO ===== */
        .profile-photo-section {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 24px;
            padding: 20px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            border: 1px dashed var(--border-color);
        }

        .profile-avatar-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .profile-avatar-wrapper .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--theme-primary);
            background: var(--bg-card-active);
        }

        .profile-avatar-wrapper .avatar-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            border: 3px solid var(--theme-primary);
        }

        .profile-photo-actions {
            flex: 1;
        }

        .profile-photo-actions .photo-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .profile-photo-actions .photo-desc {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-bottom: 10px;
        }

        .profile-photo-actions .photo-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .profile-photo-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .profile-photo-btn:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        .profile-photo-btn .icon { width: 14px; height: 14px; }

        .profile-photo-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.1);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        [data-theme="dark"] .profile-photo-btn .ripple {
            background: rgba(255, 255, 255, 0.2);
        }

        .profile-photo-input {
            display: none;
        }

        /* ===== FORM ===== */
        .profile-form-group { margin-bottom: 20px; }

        .profile-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
            letter-spacing: 0.02em;
        }

        .profile-form-group label .required { color: var(--danger); margin-left: 2px; }
        .profile-form-group .helper-text {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        .profile-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-primary);
            font-size: 14px;
            font-family: inherit;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
        }

        .profile-input:hover {
            border-color: var(--text-tertiary);
            background: var(--bg-card);
        }

        .profile-input:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .profile-input::placeholder { color: var(--text-tertiary); font-weight: 400; }
        .profile-input.error {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px var(--danger-soft);
        }

        .profile-input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ===== DIVIDER ===== */
        .profile-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 24px 0;
        }

        /* ===== SUBMIT BUTTON ===== */
        .profile-submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 20px var(--theme-glow);
            width: 100%;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.02em;
            font-family: 'Inter', sans-serif;
        }

        .profile-submit-btn:hover {
            box-shadow: 0 8px 32px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .profile-submit-btn:active {
            transform: translateY(0) scale(0.98);
        }

        .profile-submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .profile-submit-btn .icon { width: 18px; height: 18px; }

        .profile-submit-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 768px) {
            .profile-wrap { padding: 0 12px; }
            .profile-header { flex-direction: column; }
            .profile-actions { width: 100%; }
            .profile-actions .profile-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .profile-card { padding: 24px 20px; }
            .profile-header h1 { font-size: 22px; }
            .profile-photo-section { flex-direction: column; text-align: center; }
            .profile-photo-actions .photo-buttons { justify-content: center; }
        }

        @media (max-width: 480px) {
            .profile-wrap { padding: 0 8px; }
            .profile-card { padding: 20px 16px; }
            .profile-card .card-head .icon-box { width: 36px; height: 36px; }
            .profile-card .card-head .icon-box svg { width: 16px; height: 16px; }
            .profile-card .card-head .head-text h2 { font-size: 16px; }
            .profile-submit-btn { font-size: 14px; padding: 12px 20px; }
            .profile-avatar-wrapper { width: 64px; height: 64px; }
            .profile-avatar-wrapper .avatar,
            .profile-avatar-wrapper .avatar-placeholder { width: 64px; height: 64px; font-size: 26px; }
        }
    </style>

    <div class="profile-wrap">

        <!-- ===== HEADER ===== -->
        <div class="profile-header animate-in" style="animation-delay: 0.05s;">
            <div class="profile-header-left">
                <div class="profile-badge">
                    <span class="dot"></span>
                    Akun
                </div>
                <h1>Profil Saya</h1>
                <p class="subtitle">
                    Kelola informasi profil dan keamanan akun Anda — 
                    <strong>pastikan data selalu terbaru</strong>
                </p>
            </div>
            <div class="profile-actions">
                <a href="{{ route('user.dashboard') }}" class="profile-btn profile-btn-ghost">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== ALERTS ===== -->
        @if (session('success'))
            <div class="profile-alert profile-alert-success animate-in" style="animation-delay: 0.07s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="profile-alert profile-alert-error animate-in" style="animation-delay: 0.07s;">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <div>
                    <strong>Mohon perbaiki kesalahan berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- ===== PROFILE CARD ===== -->
        <div class="profile-card animate-in" style="animation-delay: 0.10s;">
            <div class="card-head">
                <div class="icon-box">
                    <svg><use href="#ic-user"/></svg>
                </div>
                <div class="head-text">
                    <h2>Informasi Profil</h2>
                    <p>Perbarui data diri dan foto profil Anda</p>
                </div>
            </div>

            <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                <!-- ===== PHOTO SECTION ===== -->
                <div class="profile-photo-section">
                    <div class="profile-avatar-wrapper">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="avatar">
                        @else
                            <div class="avatar-placeholder" style="background: linear-gradient(135deg, var(--emerald), var(--emerald-dim));">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="profile-photo-actions">
                        <div class="photo-label">Foto Profil</div>
                        <div class="photo-desc">Upload foto baru atau gunakan foto default</div>
                        <div class="photo-buttons">
                            <label class="profile-photo-btn">
                                <svg class="icon"><use href="#ic-upload"/></svg>
                                Upload Foto
                                <input type="file" name="profile_photo" class="profile-photo-input" accept="image/*" id="photoInput">
                            </label>
                            @if($user->profile_photo)
                                <label class="profile-photo-btn" style="color:var(--danger);border-color:rgba(232,90,90,0.2);cursor:pointer;">
                                    <svg class="icon"><use href="#ic-trash"/></svg>
                                    Hapus
                                    <input type="checkbox" name="remove_photo" value="1" style="display:none;" id="removePhotoCheck">
                                </label>
                            @endif
                        </div>
                        <div class="helper-text" style="margin-top:6px;">Maksimal 2MB, format: JPG, PNG, GIF, SVG</div>
                    </div>
                </div>

                <!-- ===== NAME ===== -->
                <div class="profile-form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="profile-input @error('name') error @enderror"
                        value="{{ old('name', $user->name) }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                </div>

                <!-- ===== EMAIL ===== -->
                <div class="profile-form-group">
                    <label for="email">Alamat Email <span class="required">*</span></label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="profile-input @error('email') error @enderror"
                        value="{{ old('email', $user->email) }}"
                        placeholder="Masukkan alamat email"
                        required
                    >
                    <div class="helper-text">Email akan digunakan untuk login dan notifikasi</div>
                </div>

                <!-- ===== PHONE ===== -->
                <div class="profile-form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="profile-input @error('phone') error @enderror"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="Contoh: 0812-3456-7890"
                    >
                    <div class="helper-text">Format bebas, misal: 0812-3456-7890</div>
                </div>

                <hr class="profile-divider">

                <!-- ===== PASSWORD SECTION ===== -->
                <div style="margin-bottom:16px;">
                    <h3 style="font-size:14px;font-weight:600;color:var(--text-primary);margin:0 0 4px;">Ganti Password</h3>
                    <p style="font-size:12px;color:var(--text-tertiary);margin:0;">Kosongkan jika tidak ingin mengganti password</p>
                </div>

                <div class="profile-form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="profile-input @error('current_password') error @enderror"
                        placeholder="Masukkan password saat ini"
                        autocomplete="current-password"
                    >
                </div>

                <div class="profile-form-group">
                    <label for="new_password">Password Baru</label>
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        class="profile-input @error('new_password') error @enderror"
                        placeholder="Masukkan password baru (min. 8 karakter)"
                        autocomplete="new-password"
                    >
                </div>

                <div class="profile-form-group">
                    <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                    <input
                        type="password"
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        class="profile-input @error('new_password_confirmation') error @enderror"
                        placeholder="Konfirmasi password baru"
                        autocomplete="new-password"
                    >
                </div>

                <!-- ===== SUBMIT ===== -->
                <button type="submit" class="profile-submit-btn" id="submitBtn">
                    <svg class="icon"><use href="#ic-save"/></svg>
                    <span id="btnText">Simpan Perubahan</span>
                </button>
            </form>
        </div>

    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-arrow-left" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></symbol>
        <symbol id="ic-user" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
        <symbol id="ic-upload" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><polyline points="3 8 7 4 11 8"/><line x1="7" y1="4" x2="7" y2="12"/></symbol>
        <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
        <symbol id="ic-save" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
        <symbol id="ic-check-circle" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
        <symbol id="ic-alert-triangle" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.profile-btn, .profile-submit-btn, .profile-photo-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Skip jika tombol adalah label yang punya input file
                    if (this.tagName === 'LABEL') {
                        return;
                    }
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
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // ===== PHOTO INPUT PREVIEW =====
            const photoInput = document.getElementById('photoInput');
            const avatarWrapper = document.querySelector('.profile-avatar-wrapper');

            if (photoInput && avatarWrapper) {
                photoInput.addEventListener('change', function(e) {
                    const file = this.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        let avatarImg = avatarWrapper.querySelector('.avatar');
                        const avatarPlaceholder = avatarWrapper.querySelector('.avatar-placeholder');

                        if (!avatarImg) {
                            avatarImg = document.createElement('img');
                            avatarImg.className = 'avatar';
                            avatarImg.alt = 'Profile Photo';
                            avatarWrapper.appendChild(avatarImg);
                        }

                        avatarImg.src = event.target.result;
                        avatarImg.style.display = 'block';

                        if (avatarPlaceholder) {
                            avatarPlaceholder.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }

            // ===== REMOVE PHOTO =====
            const removePhotoBtn = document.querySelector('label[style*="color:var(--danger)"]');
            const removePhotoCheck = document.getElementById('removePhotoCheck');
            
            if (removePhotoBtn && removePhotoCheck) {
                removePhotoBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Yakin ingin menghapus foto profil?')) {
                        removePhotoCheck.checked = true;
                        document.getElementById('profileForm').submit();
                    }
                });
            }

            // ===== SUBMIT LOADING STATE =====
            const form = document.getElementById('profileForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');

            if (form) {
                form.addEventListener('submit', function() {
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        btnText.textContent = 'Menyimpan...';
                    }
                });
            }

        });
    </script>
</x-user-layout>