<x-admin-layout>
    <x-slot name="title">Tambah User</x-slot>

    <style>
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) backwards; }

        .page-head{ margin-bottom:22px; }
        .page-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); max-width:640px; }

        .alert-error{ background:rgba(232,90,90,0.1); border:1px solid rgba(232,90,90,0.3); color:var(--danger); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }
        .hint-box{ background:rgba(78,143,240,0.08); border:1px solid rgba(78,143,240,0.25); color:#8fb4f0; padding:12px 16px; border-radius:12px; font-size:12.5px; margin-bottom:20px; line-height:1.5; }

        /* ===== LAYOUT 2 KOLOM ===== */
        .create-layout{ display:grid; grid-template-columns:1fr 360px; gap:22px; align-items:start; }
        @media (max-width:960px){ .create-layout{ grid-template-columns:1fr; } }

        /* ===== KIRI: FORM ===== */
        .form-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:30px; }
        .grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .form-group{ margin-bottom:18px; }
        .form-group label{ display:block; font-size:13px; font-weight:600; margin-bottom:6px; }
        .form-control{ width:100%; padding:11px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border); color:var(--text); font-size:13.5px; outline:none; font-family:inherit; transition:border-color .2s ease; }
        .form-control:focus{ border-color:var(--border-hover); }
        .form-error{ color:var(--danger); font-size:12px; margin-top:4px; }
        .form-hint{ font-size:11.5px; color:var(--text-faint); margin-top:5px; }
        .form-actions{ display:flex; gap:12px; margin-top:6px; }
        .btn{ display:inline-flex; align-items:center; gap:8px; padding:11px 22px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:transform .15s ease; }
        .btn:active{ transform:scale(.96); }
        .btn-primary{ background:var(--emerald); color:#1a1005; }
        .btn-primary:hover{ box-shadow:0 8px 22px var(--accent-glow, rgba(var(--emerald-rgb),0.35)); transform:translateY(-2px); }
        .btn-outline{ background:var(--surface-strong); border:1px solid var(--border); color:var(--text); }

        /* ===== KANAN: LIVE PREVIEW ===== */
        .preview-card{ background:linear-gradient(150deg, rgba(var(--emerald-rgb),0.1), var(--surface) 60%); border:1px solid rgba(var(--emerald-rgb),0.25); border-radius:18px; padding:28px; position:sticky; top:100px; }
        .preview-label{ font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); font-weight:700; margin-bottom:18px; }
        .preview-avatar{
            width:64px; height:64px; border-radius:16px; display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700; color:#1a1005;
            background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); margin-bottom:16px; transition:all .25s ease;
        }
        .preview-name{ font-size:17px; font-weight:700; color:var(--text); margin-bottom:3px; word-break:break-word; }
        .preview-email{ font-size:12.5px; color:var(--text-faint); margin-bottom:16px; word-break:break-word; }

        .level-badge{ display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:700; padding:5px 12px; border-radius:100px; letter-spacing:.01em; margin-bottom:20px; }
        .level-badge .sdot{ width:6px; height:6px; border-radius:50%; }
        .level-badge.admin{ background:rgba(var(--emerald-rgb),0.14); color:var(--emerald); }
        .level-badge.admin .sdot{ background:var(--emerald); animation:pulseGlow 1.8s ease-in-out infinite; }
        .level-badge.staff{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .level-badge.staff .sdot{ background:#4E8FF0; }
        .level-badge.user{ background:var(--surface-strong); color:var(--text-mute); }
        .level-badge.user .sdot{ background:var(--text-faint); }

        .preview-note{ font-size:12px; color:var(--text-mute); line-height:1.6; padding-top:16px; border-top:1px dashed var(--border); }
        .preview-note b{ color:var(--text); }

        @media (max-width:640px){ .grid-2{ grid-template-columns:1fr; } }
    </style>

    <div class="page-head animate-in" style="animation-delay:.05s;">
        <h1>Tambah User Baru</h1>
        <p>Buat akun langsung dengan access level tertentu — cocok untuk menambahkan admin/staff tim tanpa lewat proses onboarding.</p>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="hint-box animate-in" style="animation-delay:.08s;">
        💡 Kalau akun ini dibuat dengan access level <b>Admin</b> atau <b>Staff</b>, orangnya akan langsung diarahkan ke dashboard sesuai role saat pertama kali login — <b>tidak akan melewati proses onboarding perusahaan</b>.
    </div>

    <div class="create-layout">
        {{-- ===== KIRI: FORM ===== --}}
        <div class="form-card animate-in" style="animation-delay:.12s;">
            <form method="POST" action="{{ route('admin.users.store') }}" id="createUserForm">
                @csrf
                <div class="grid-2">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" id="fName" class="form-control" value="{{ old('name') }}" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="fEmail" class="form-control" value="{{ old('email') }}" required>
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
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
                    <button type="submit" class="btn btn-primary">Buat Akun</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>

        {{-- ===== KANAN: LIVE PREVIEW ===== --}}
        <div class="preview-card animate-in" style="animation-delay:.18s;">
            <div class="preview-label">Preview Akun</div>
            <div class="preview-avatar" id="pvAvatar">?</div>
            <div class="preview-name" id="pvName">Nama User</div>
            <div class="preview-email" id="pvEmail">email@contoh.com</div>
            <span class="level-badge user" id="pvBadge"><span class="sdot"></span><span id="pvBadgeLabel">User</span></span>
            <div class="preview-note">
                Akun ini akan langsung aktif begitu dibuat. Pastikan email dan password sudah benar sebelum dibagikan ke orangnya.
            </div>
        </div>
    </div>

    <script>
        (function(){
            var nameInput  = document.getElementById('fName');
            var emailInput = document.getElementById('fEmail');
            var levelSelect = document.getElementById('fLevel');

            var pvAvatar = document.getElementById('pvAvatar');
            var pvName   = document.getElementById('pvName');
            var pvEmail  = document.getElementById('pvEmail');
            var pvBadge  = document.getElementById('pvBadge');
            var pvBadgeLabel = document.getElementById('pvBadgeLabel');

            function update(){
                var name = nameInput.value.trim();
                var email = emailInput.value.trim();
                var levelOpt = levelSelect.options[levelSelect.selectedIndex];

                pvAvatar.textContent = name ? name.charAt(0).toUpperCase() : '?';
                pvName.textContent = name || 'Nama User';
                pvEmail.textContent = email || 'email@contoh.com';

                pvBadge.className = 'level-badge ' + levelSelect.value;
                pvBadgeLabel.textContent = levelOpt ? levelOpt.textContent : 'User';
            }

            nameInput.addEventListener('input', update);
            emailInput.addEventListener('input', update);
            levelSelect.addEventListener('change', update);
            update();
        })();
    </script>
</x-admin-layout>