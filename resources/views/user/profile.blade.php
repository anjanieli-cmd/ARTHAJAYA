<x-user-layout>
    <x-slot name="title">Profil Saya</x-slot>

    @php
        $currencySymbols = [
            'IDR' => 'Rp',
            'USD' => '$',
            'SGD' => 'S$',
            'MYR' => 'RM',
        ];

        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        /*
         * ==========================================
         * URL FOTO PROFIL
         * ==========================================
         *
         * Database:
         * avatars/nama-file.jpg
         *
         * Project:
         * http://localhost/arthajaya/public/
         *
         * Jadi URL harus menjadi:
         * /arthajaya/public/storage/avatars/nama-file.jpg
         */
        $avatarUrl = $user->avatar
            ? url('storage/' . ltrim($user->avatar, '/'))
            : null;

        $initial = strtoupper(
            substr($user->name ?? 'U', 0, 1)
        );
    @endphp


    <style>
        .profile-wrap {
            --theme-primary: var(--emerald);
            --theme-light: var(--emerald);
            --theme-dark: var(--emerald-dim);
            --theme-glow: rgba(var(--emerald-rgb), 0.25);
            --theme-soft: rgba(var(--emerald-rgb), 0.12);

            --theme-gradient: linear-gradient(
                135deg,
                var(--emerald),
                var(--emerald-dim)
            );

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

            font-family:
                'Inter',
                -apple-system,
                BlinkMacSystemFont,
                'Segoe UI',
                Roboto,
                sans-serif;

            color: var(--text-primary);
            width: 100%;
            padding: 0 24px;
        }

        .profile-wrap * {
            box-sizing: border-box;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .profile-wrap .animate-in {
            animation:
                fadeSlideUp
                0.5s
                cubic-bezier(0.16, 1, 0.3, 1)
                forwards;

            opacity: 0;
        }

        .profile-wrap .icon {
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


        /* ==============================
           HEADER
        ============================== */

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .profile-header-left {
            flex: 1;
            min-width: 200px;
        }

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

            background:
                linear-gradient(
                    135deg,
                    var(--text) 60%,
                    var(--theme-light)
                );

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
            transition: all 0.25s ease;
            background: transparent;
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
        }

        .profile-btn:hover {
            transform: translateY(-2px);
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


        /* ==============================
           ALERT
        ============================== */

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
            align-items: flex-start;
        }

        .profile-alert-error ul {
            padding-left: 18px;
            margin: 4px 0 0;
        }


        /* ==============================
           CARD
        ============================== */

        .profile-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 36px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
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
        }

        .profile-card:hover {
            border-color: var(--border-hover);
        }

        .card-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .icon-box {
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

        .icon-box svg {
            width: 20px;
            height: 20px;
        }

        .head-text h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
        }

        .head-text p {
            font-size: 13px;
            color: var(--text-tertiary);
            margin: 0;
        }


        /* ==============================
           PHOTO
        ============================== */

        .profile-photo-section {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 28px;
            padding: 20px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            border: 1px dashed var(--border-color);
        }

        .profile-avatar-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            flex-shrink: 0;
        }

        .profile-avatar-wrapper .avatar,
        .profile-avatar-wrapper .avatar-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .profile-avatar-wrapper .avatar {
            object-fit: cover;
            border: 3px solid var(--theme-primary);
            background: var(--bg-card-active);
            display: block;
        }

        .avatar-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 34px;
            font-weight: 700;
            color: #fff;

            border: 3px solid var(--theme-primary);

            background:
                linear-gradient(
                    135deg,
                    var(--emerald),
                    var(--emerald-dim)
                );
        }

        .profile-photo-actions {
            flex: 1;
        }

        .photo-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .photo-desc {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-bottom: 12px;
        }

        .photo-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .profile-photo-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .profile-photo-btn:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        .profile-photo-btn .icon {
            width: 14px;
            height: 14px;
        }

        .profile-photo-input {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        .helper-text {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 7px;
        }


        /* ==============================
           FORM
        ============================== */

        .profile-form-group {
            margin-bottom: 20px;
        }

        .profile-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .required {
            color: var(--danger);
            margin-left: 2px;
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
            transition: all 0.25s ease;
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

        .profile-input::placeholder {
            color: var(--text-tertiary);
        }

        .profile-input.error {
            border-color: var(--danger);
        }

        .profile-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 24px 0;
        }


        /* ==============================
           SUBMIT
        ============================== */

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
            transition: all 0.3s ease;
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 20px var(--theme-glow);
            width: 100%;
            font-family: 'Inter', sans-serif;
        }

        .profile-submit-btn:hover {
            box-shadow: 0 8px 32px var(--theme-glow);
            transform: translateY(-2px);
        }

        .profile-submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }


        /* ==============================
           RESPONSIVE
        ============================== */

        @media (max-width: 768px) {
            .profile-wrap {
                padding: 0 12px;
            }

            .profile-header {
                flex-direction: column;
            }

            .profile-card {
                padding: 24px 20px;
            }

            .profile-photo-section {
                flex-direction: column;
                text-align: center;
            }

            .photo-buttons {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .profile-wrap {
                padding: 0 8px;
            }

            .profile-card {
                padding: 20px 16px;
            }

            .profile-avatar-wrapper {
                width: 80px;
                height: 80px;
            }

            .profile-avatar-wrapper .avatar,
            .profile-avatar-wrapper .avatar-placeholder {
                width: 80px;
                height: 80px;
            }
        }
    </style>


    <div class="profile-wrap">

        <!-- HEADER -->

        <div class="profile-header animate-in">

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

                <a
                    href="{{ route('user.dashboard') }}"
                    class="profile-btn profile-btn-ghost"
                >
                    <svg class="icon">
                        <use href="#ic-arrow-left"></use>
                    </svg>

                    Kembali
                </a>

            </div>

        </div>


        <!-- ALERT SUCCESS -->

        @if (session('success'))

            <div class="profile-alert profile-alert-success">

                <svg class="icon">
                    <use href="#ic-check-circle"></use>
                </svg>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        <!-- ALERT STATUS -->

        @if (session('status') === 'profile-updated')

            <div class="profile-alert profile-alert-success">

                <svg class="icon">
                    <use href="#ic-check-circle"></use>
                </svg>

                <span>
                    Profil berhasil diperbarui.
                </span>

            </div>

        @endif


        <!-- ALERT ERROR -->

        @if ($errors->any())

            <div class="profile-alert profile-alert-error">

                <svg class="icon">
                    <use href="#ic-alert-triangle"></use>
                </svg>

                <div>

                    <strong>
                        Mohon perbaiki kesalahan berikut:
                    </strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        <!-- PROFILE CARD -->

        <div class="profile-card animate-in">

            <div class="card-head">

                <div class="icon-box">

                    <svg>
                        <use href="#ic-user"></use>
                    </svg>

                </div>

                <div class="head-text">

                    <h2>
                        Informasi Profil
                    </h2>

                    <p>
                        Perbarui data diri dan foto profil Anda
                    </p>

                </div>

            </div>


            <!-- FORM -->

            <form
                method="POST"
                action="{{ route('user.profile.update') }}"
                enctype="multipart/form-data"
                id="profileForm"
            >

                @csrf

                @method('PUT')


                <!-- =========================
                     FOTO PROFIL
                ========================== -->

                <div class="profile-photo-section">

                    <div class="profile-avatar-wrapper">

                        @if($avatarUrl)

                            <img
                                src="{{ $avatarUrl }}"
                                alt="Foto Profil {{ $user->name }}"
                                class="avatar"
                                id="avatarPreview"
                                onerror="
                                    this.style.display='none';
                                    document.getElementById('avatarFallback').style.display='flex';
                                "
                            >

                            <div
                                class="avatar-placeholder"
                                id="avatarFallback"
                                style="display:none;"
                            >
                                {{ $initial }}
                            </div>

                        @else

                            <div
                                class="avatar-placeholder"
                                id="avatarFallback"
                            >
                                {{ $initial }}
                            </div>

                            <img
                                src=""
                                alt="Preview Foto"
                                class="avatar"
                                id="avatarPreview"
                                style="display:none;"
                            >

                        @endif

                    </div>


                    <div class="profile-photo-actions">

                        <div class="photo-label">
                            Foto Profil
                        </div>

                        <div class="photo-desc">
                            Pilih foto dan preview akan langsung muncul.
                        </div>


                        <div class="photo-buttons">

                            <!-- PILIH FOTO -->

                            <label
                                for="photoInput"
                                class="profile-photo-btn"
                            >

                                <svg class="icon">
                                    <use href="#ic-upload"></use>
                                </svg>

                                Pilih Foto

                            </label>


                            <input
                                type="file"
                                name="avatar"
                                id="photoInput"
                                class="profile-photo-input"
                                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                            >


                            <!-- HAPUS FOTO -->

                            @if($user->avatar)

                                <button
                                    type="button"
                                    class="profile-photo-btn"
                                    id="removePhotoBtn"
                                    style="
                                        color:var(--danger);
                                        border-color:rgba(232,90,90,0.25);
                                    "
                                >

                                    <svg class="icon">
                                        <use href="#ic-trash"></use>
                                    </svg>

                                    Hapus

                                </button>


                                <input
                                    type="checkbox"
                                    name="remove_photo"
                                    value="1"
                                    id="removePhotoCheck"
                                    style="display:none;"
                                >

                            @endif

                        </div>


                        <div class="helper-text">
                            Maksimal 2MB, format: JPG, JPEG, PNG
                        </div>

                    </div>

                </div>


                <!-- =========================
                     NAMA
                ========================== -->

                <div class="profile-form-group">

                    <label for="name">
                        Nama Lengkap
                        <span class="required">*</span>
                    </label>

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


                <!-- =========================
                     EMAIL
                ========================== -->

                <div class="profile-form-group">

                    <label for="email">
                        Alamat Email
                        <span class="required">*</span>
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="profile-input @error('email') error @enderror"
                        value="{{ old('email', $user->email) }}"
                        placeholder="Masukkan alamat email"
                        required
                    >

                    <div class="helper-text">
                        Email akan digunakan untuk login dan notifikasi
                    </div>

                </div>


                <!-- =========================
                     TELEPON
                ========================== -->

                <div class="profile-form-group">

                    <label for="phone">
                        Nomor Telepon
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="profile-input @error('phone') error @enderror"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="Contoh: 0812-3456-7890"
                    >

                    <div class="helper-text">
                        Format bebas, misal: 0812-3456-7890
                    </div>

                </div>


                <hr class="profile-divider">


                <!-- =========================
                     PASSWORD
                ========================== -->

                <div style="margin-bottom:16px;">

                    <h3
                        style="
                            font-size:14px;
                            font-weight:600;
                            color:var(--text-primary);
                            margin:0 0 4px;
                        "
                    >
                        Ganti Password
                    </h3>

                    <p
                        style="
                            font-size:12px;
                            color:var(--text-tertiary);
                            margin:0;
                        "
                    >
                        Kosongkan jika tidak ingin mengganti password
                    </p>

                </div>


                <div class="profile-form-group">

                    <label for="current_password">
                        Password Saat Ini
                    </label>

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

                    <label for="new_password">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        class="profile-input @error('new_password') error @enderror"
                        placeholder="Masukkan password baru"
                        autocomplete="new-password"
                    >

                </div>


                <div class="profile-form-group">

                    <label for="new_password_confirmation">
                        Konfirmasi Password Baru
                    </label>

                    <input
                        type="password"
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        class="profile-input @error('new_password_confirmation') error @enderror"
                        placeholder="Konfirmasi password baru"
                        autocomplete="new-password"
                    >

                </div>


                <!-- =========================
                     SUBMIT
                ========================== -->

                <button
                    type="submit"
                    class="profile-submit-btn"
                    id="submitBtn"
                >

                    <svg class="icon">
                        <use href="#ic-save"></use>
                    </svg>

                    <span id="btnText">
                        Simpan Perubahan
                    </span>

                </button>

            </form>

        </div>

    </div>


    <!-- =========================
         SVG ICONS
    ========================== -->

    <svg
        style="display:none;"
        xmlns="http://www.w3.org/2000/svg"
    >

        <symbol id="ic-arrow-left" viewBox="0 0 24 24">

            <line
                x1="19"
                y1="12"
                x2="5"
                y2="12"
            />

            <polyline
                points="12 19 5 12 12 5"
            />

        </symbol>


        <symbol id="ic-user" viewBox="0 0 24 24">

            <path
                d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
            />

            <circle
                cx="12"
                cy="7"
                r="4"
            />

        </symbol>


        <symbol id="ic-upload" viewBox="0 0 24 24">

            <path
                d="M12 16V4"
            />

            <polyline
                points="7 9 12 4 17 9"
            />

            <path
                d="M5 20h14"
            />

        </symbol>


        <symbol id="ic-trash" viewBox="0 0 24 24">

            <polyline
                points="3 6 5 6 21 6"
            />

            <path
                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"
            />

            <path
                d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
            />

        </symbol>


        <symbol id="ic-save" viewBox="0 0 24 24">

            <path
                d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"
            />

            <polyline
                points="17 21 17 13 7 13 7 21"
            />

            <polyline
                points="7 3 7 8 15 8"
            />

        </symbol>


        <symbol id="ic-check-circle" viewBox="0 0 24 24">

            <path
                d="M22 11.08V12a10 10 0 1 1-5.93-9.14"
            />

            <polyline
                points="22 4 12 14.01 9 11.01"
            />

        </symbol>


        <symbol id="ic-alert-triangle" viewBox="0 0 24 24">

            <path
                d="M10.29 3.86L1.82 18a2 2 0 0 1 1.71 3l-8.47 14.14a2 2 0 0 1-3.42 0z"
            />

            <line
                x1="12"
                y1="9"
                x2="12"
                y2="13"
            />

            <line
                x1="12"
                y1="17"
                x2="12.01"
                y2="17"
            />

        </symbol>

    </svg>


    <!-- =========================
         JAVASCRIPT
    ========================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const photoInput =
                document.getElementById('photoInput');

            const avatarPreview =
                document.getElementById('avatarPreview');

            const avatarFallback =
                document.getElementById('avatarFallback');


            /*
             * ==========================================
             * PREVIEW FOTO SAAT DIPILIH
             * ==========================================
             */

            if (photoInput) {

                photoInput.addEventListener(
                    'change',
                    function (event) {

                        const file =
                            event.target.files[0];

                        if (!file) {
                            return;
                        }


                        /*
                         * CEK FORMAT
                         */

                        const allowedTypes = [
                            'image/jpeg',
                            'image/png'
                        ];

                        if (
                            !allowedTypes.includes(
                                file.type
                            )
                        ) {

                            alert(
                                'Format foto harus JPG, JPEG, atau PNG.'
                            );

                            photoInput.value = '';

                            return;
                        }


                        /*
                         * CEK UKURAN
                         */

                        if (
                            file.size >
                            2 * 1024 * 1024
                        ) {

                            alert(
                                'Ukuran foto maksimal 2MB.'
                            );

                            photoInput.value = '';

                            return;
                        }


                        /*
                         * PREVIEW
                         */

                        const reader =
                            new FileReader();

                        reader.onload =
                            function (e) {

                                if (avatarPreview) {

                                    avatarPreview.src =
                                        e.target.result;

                                    avatarPreview.style.display =
                                        'block';

                                }

                                if (avatarFallback) {

                                    avatarFallback.style.display =
                                        'none';

                                }

                            };

                        reader.readAsDataURL(file);

                    }
                );

            }


            /*
             * ==========================================
             * HAPUS FOTO
             * ==========================================
             */

            const removePhotoBtn =
                document.getElementById(
                    'removePhotoBtn'
                );

            const removePhotoCheck =
                document.getElementById(
                    'removePhotoCheck'
                );

            const profileForm =
                document.getElementById(
                    'profileForm'
                );


            if (
                removePhotoBtn &&
                removePhotoCheck &&
                profileForm
            ) {

                removePhotoBtn.addEventListener(
                    'click',
                    function () {

                        const confirmed =
                            confirm(
                                'Yakin ingin menghapus foto profil?'
                            );

                        if (!confirmed) {
                            return;
                        }


                        removePhotoCheck.checked =
                            true;


                        /*
                         * Tampilkan placeholder
                         */

                        if (avatarPreview) {

                            avatarPreview.style.display =
                                'none';

                        }

                        if (avatarFallback) {

                            avatarFallback.style.display =
                                'flex';

                        }


                        /*
                         * Submit form
                         */

                        profileForm.submit();

                    }
                );

            }


            /*
             * ==========================================
             * SUBMIT LOADING
             * ==========================================
             */

            const submitBtn =
                document.getElementById(
                    'submitBtn'
                );

            const btnText =
                document.getElementById(
                    'btnText'
                );


            if (profileForm) {

                profileForm.addEventListener(
                    'submit',
                    function () {

                        if (submitBtn) {

                            submitBtn.disabled =
                                true;

                        }

                        if (btnText) {

                            btnText.textContent =
                                'Menyimpan...';

                        }

                    }
                );

            }

        });

    </script>

</x-user-layout>