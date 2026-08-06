<x-admin-layout>
    <x-slot name="title">Tambah User</x-slot>

    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: .55; }
        }
        .animate-in {
            animation: fadeSlideUp .5s cubic-bezier(.16, 1, .3, 1) backwards;
        }

        /* ===== PAGE HEAD ===== */
        .page-head {
            margin-bottom: 24px;
        }
        .page-head h1 {
            font-size: 26px;
            margin-bottom: 6px;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.02em;
            color: var(--text);
        }
        .page-head p {
            font-size: 14px;
            color: var(--text-mute);
            max-width: 640px;
            line-height: 1.6;
        }

        /* ===== ALERT & HINT ===== */
        .alert-error {
            background: rgba(232, 90, 90, 0.08);
            border: 1px solid rgba(232, 90, 90, 0.3);
            color: #E85A5A;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 18px;
        }
        [data-theme="dark"] .alert-error {
            background: rgba(232, 90, 90, 0.12);
            color: #F08080;
        }

        .hint-box {
            background: rgba(78, 143, 240, 0.06);
            border: 1px solid rgba(78, 143, 240, 0.2);
            color: var(--text-mute);
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 22px;
            line-height: 1.6;
        }
        [data-theme="dark"] .hint-box {
            background: rgba(78, 143, 240, 0.08);
            border-color: rgba(78, 143, 240, 0.15);
        }
        .hint-box b {
            color: var(--text);
        }

        /* ===== LAYOUT 2 KOLOM ===== */
        .create-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 960px) {
            .create-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ===== KIRI: FORM ===== */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 32px;
            transition: background .35s ease, border-color .35s ease;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mute);
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: 12px;
            background: var(--surface-strong);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 13.5px;
            outline: none;
            font-family: inherit;
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .form-control:focus {
            border-color: var(--border-hover);
            background: var(--surface-strong);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.08);
        }
        .form-control::placeholder {
            color: var(--text-faint);
        }
        select.form-control {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B6280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }
        .form-error {
            color: #E85A5A;
            font-size: 12px;
            margin-top: 4px;
        }
        .form-hint {
            font-size: 11.5px;
            color: var(--text-faint);
            margin-top: 5px;
        }
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 8px;
            padding-top: 4px;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 24px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .25s ease, background .25s ease;
            font-family: inherit;
        }
        .btn:active {
            transform: scale(.96);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--purple-1), var(--purple-2));
            color: #fff;
            box-shadow: 0 4px 20px rgba(var(--emerald-rgb), 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(var(--emerald-rgb), 0.4);
        }
        .btn-outline {
            background: var(--surface-strong);
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-outline:hover {
            background: var(--surface-strong);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        /* ===== KANAN: LIVE PREVIEW ===== */
        .preview-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 28px 30px;
            position: sticky;
            top: 100px;
            transition: background .35s ease, border-color .35s ease;
        }
        .preview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .preview-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-faint);
            font-weight: 700;
        }
        .preview-badge-status {
            font-size: 11px;
            font-weight: 600;
            color: var(--emerald);
            background: rgba(var(--emerald-rgb), 0.1);
            padding: 4px 12px;
            border-radius: 100px;
        }
        .preview-avatar {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--purple-1), var(--purple-2));
            margin-bottom: 16px;
            transition: all .3s ease;
            box-shadow: 0 8px 24px rgba(var(--emerald-rgb), 0.2);
        }
        .preview-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
            word-break: break-word;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.01em;
        }
        .preview-email {
            font-size: 13px;
            color: var(--text-faint);
            margin-bottom: 18px;
            word-break: break-word;
        }

        .level-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 100px;
            letter-spacing: .01em;
            margin-bottom: 20px;
        }
        .level-badge .sdot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .level-badge.admin {
            background: rgba(var(--emerald-rgb), 0.12);
            color: var(--emerald);
        }
        .level-badge.admin .sdot {
            background: var(--emerald);
            animation: pulseGlow 1.8s ease-in-out infinite;
        }
        .level-badge.staff {
            background: rgba(78, 143, 240, 0.12);
            color: #4E8FF0;
        }
        .level-badge.staff .sdot {
            background: #4E8FF0;
        }
        .level-badge.user {
            background: var(--surface-strong);
            color: var(--text-mute);
        }
        .level-badge.user .sdot {
            background: var(--text-faint);
        }

        .preview-divider {
            border: none;
            border-top: 1px dashed var(--border);
            margin: 16px 0;
        }
        .preview-note {
            font-size: 12.5px;
            color: var(--text-mute);
            line-height: 1.7;
        }
        .preview-note b {
            color: var(--text);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .page-head h1 {
                font-size: 22px;
            }
            .form-card {
                padding: 24px 20px;
            }
            .grid-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .preview-card {
                padding: 24px 22px;
                position: static;
            }
            .preview-avatar {
                width: 60px;
                height: 60px;
                font-size: 22px;
                border-radius: 14px;
            }
            .preview-name {
                font-size: 16px;
            }
            .form-actions {
                flex-direction: column;
            }
            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .page-head h1 {
                font-size: 19px;
            }
            .page-head p {
                font-size: 13px;
            }
            .form-card {
                padding: 18px 16px;
                border-radius: 14px;
            }
            .form-control {
                font-size: 13px;
                padding: 10px 12px;
            }
            .preview-card {
                padding: 18px 16px;
                border-radius: 14px;
            }
            .preview-avatar {
                width: 52px;
                height: 52px;
                font-size: 20px;
                border-radius: 12px;
            }
            .btn {
                font-size: 13px;
                padding: 10px 18px;
            }
            .hint-box {
                font-size: 12px;
                padding: 12px 14px;
            }
        }

        @media (max-width: 400px) {
            .page-head h1 {
                font-size: 17px;
            }
            .preview-name {
                font-size: 14px;
            }
            .preview-email {
                font-size: 12px;
            }
            .level-badge {
                font-size: 11px;
                padding: 4px 12px;
            }
        }
    </style>

    <div class="page-head animate-in" style="animation-delay:.05s;">
        <h1>Tambah User Baru</h1>
        <p>Buat akun langsung dengan access level tertentu — cocok untuk menambahkan admin/staff tim tanpa lewat proses onboarding.</p>
    </div>

    @if($errors->any())
        <div class="alert-error animate-in" style="animation-delay:.08s;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="hint-box animate-in" style="animation-delay:.10s;">
        💡 Kalau akun ini dibuat dengan access level <b>Admin</b> atau <b>Staff</b>, orangnya akan langsung diarahkan ke dashboard sesuai role saat pertama kali login — <b>tidak akan melewati proses onboarding perusahaan</b>.
    </div>

    <div class="create-layout">
        {{-- ===== KIRI: FORM ===== --}}
        <div class="form-card animate-in" style="animation-delay:.14s;">
            <form method="POST" action="{{ route('admin.users.store') }}" id="createUserForm">
                @csrf
                <div class="grid-2">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" id="fName" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="fEmail" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                        <div class="form-hint">Minimal 8 karakter.</div>
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Access Level</label>
                        <select name="access_level" id="fLevel" class="form-control" required>
                            @foreach($accessLevels as $value => $label)
                                <option value="{{ $value }}" {{ old('access_level') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/></svg>
                        Buat Akun
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>

        {{-- ===== KANAN: LIVE PREVIEW ===== --}}
        <div class="preview-card animate-in" style="animation-delay:.18s;">
            <div class="preview-header">
                <span class="preview-label">Preview Akun</span>
                <span class="preview-badge-status">● Live</span>
            </div>
            <div class="preview-avatar" id="pvAvatar">?</div>
            <div class="preview-name" id="pvName">Nama User</div>
            <div class="preview-email" id="pvEmail">email@contoh.com</div>
            <span class="level-badge user" id="pvBadge">
                <span class="sdot"></span>
                <span id="pvBadgeLabel">User</span>
            </span>
            <hr class="preview-divider">
            <div class="preview-note">
                Akun ini akan langsung aktif begitu dibuat. Pastikan email dan password sudah benar sebelum dibagikan ke orangnya.
            </div>
        </div>
    </div>

    <script>
        (function() {
            var nameInput = document.getElementById('fName');
            var emailInput = document.getElementById('fEmail');
            var levelSelect = document.getElementById('fLevel');

            var pvAvatar = document.getElementById('pvAvatar');
            var pvName = document.getElementById('pvName');
            var pvEmail = document.getElementById('pvEmail');
            var pvBadge = document.getElementById('pvBadge');
            var pvBadgeLabel = document.getElementById('pvBadgeLabel');

            // Warna avatar berdasarkan level
            function getAvatarGradient(level) {
                var gradients = {
                    'admin': 'linear-gradient(135deg, var(--purple-1), var(--purple-2))',
                    'staff': 'linear-gradient(135deg, #4E8FF0, #3465C4)',
                    'user': 'linear-gradient(135deg, var(--text-mute), var(--text-faint))'
                };
                return gradients[level] || gradients['user'];
            }

            function update() {
                var name = nameInput.value.trim();
                var email = emailInput.value.trim();
                var level = levelSelect.value;
                var levelOpt = levelSelect.options[levelSelect.selectedIndex];

                // Avatar
                pvAvatar.textContent = name ? name.charAt(0).toUpperCase() : '?';
                pvAvatar.style.background = getAvatarGradient(level);

                // Nama & Email
                pvName.textContent = name || 'Nama User';
                pvEmail.textContent = email || 'email@contoh.com';

                // Badge
                pvBadge.className = 'level-badge ' + level;
                pvBadgeLabel.textContent = levelOpt ? levelOpt.textContent : 'User';
            }

            nameInput.addEventListener('input', update);
            emailInput.addEventListener('input', update);
            levelSelect.addEventListener('change', update);
            update();
        })();
    </script>
</x-admin-layout>