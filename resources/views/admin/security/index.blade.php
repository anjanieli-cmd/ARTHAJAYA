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
        </defs>
    </svg>

    <style>
        .asw{ --accent: #4E8FF0; color:var(--text); }
        .asw *{ box-sizing:border-box; }
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(16px);} to{ opacity:1; transform:translateY(0);} }
        .asw .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        .asw-head{ margin-bottom:22px; }
        .asw-head h1{ font-family:'Space Grotesk', sans-serif; font-size:25px; margin-bottom:6px; }
        .asw-head p{ font-size:13.5px; color:var(--text-mute); }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }
        .alert-error{ background:rgba(232,90,90,0.1); border:1px solid rgba(232,90,90,0.3); color:var(--danger); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        /* ===== STATUS BANNER ===== */
        .sec-banner{
            display:flex; align-items:center; gap:14px; background:linear-gradient(120deg, rgba(78,143,240,.12), var(--surface) 65%);
            border:1px solid rgba(78,143,240,.25); border-radius:18px; padding:20px 24px; margin-bottom:20px;
        }
        .sec-banner .ic{ width:44px; height:44px; border-radius:12px; background:rgba(78,143,240,.16); color:#4E8FF0; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .sec-banner .ic .icon{ width:20px; height:20px; }
        .sec-banner .txt strong{ font-size:14px; }
        .sec-banner .txt p{ font-size:12px; color:var(--text-faint); margin-top:2px; }

        /* ===== SETTINGS LIST (row style, beda dari card grid) ===== */
        .sec-list{ display:flex; flex-direction:column; gap:1px; background:var(--border); border:1px solid var(--border); border-radius:20px; overflow:hidden; margin-bottom:20px; }
        .sec-row{ background:var(--surface); padding:22px 26px; display:flex; align-items:center; gap:16px; justify-content:space-between; flex-wrap:wrap; }
        .sec-row-left{ display:flex; align-items:center; gap:14px; flex:1; min-width:220px; }
        .sec-row-ic{ width:40px; height:40px; border-radius:11px; background:rgba(78,143,240,.12); color:#4E8FF0; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .sec-row-ic .icon{ width:18px; height:18px; }
        .sec-row-title{ font-size:13.5px; font-weight:600; }
        .sec-row-sub{ font-size:12px; color:var(--text-faint); margin-top:2px; }

        /* toggle switch */
        .switch{ position:relative; width:46px; height:26px; flex-shrink:0; }
        .switch input{ display:none; }
        .switch-track{ position:absolute; inset:0; background:var(--surface-strong); border:1px solid var(--border); border-radius:100px; cursor:pointer; transition:all .25s ease; }
        .switch-track::after{ content:''; position:absolute; top:2px; left:2px; width:20px; height:20px; background:var(--text-faint); border-radius:50%; transition:all .25s cubic-bezier(.4,0,.2,1); }
        .switch input:checked + .switch-track{ background:rgba(var(--emerald-rgb),.25); border-color:var(--emerald); }
        .switch input:checked + .switch-track::after{ transform:translateX(20px); background:var(--emerald); }

        /* ===== PASSWORD FORM PANEL ===== */
        .pw-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; }
        .pw-panel h3{ font-family:'Space Grotesk', sans-serif; font-size:14.5px; margin-bottom:4px; display:flex; align-items:center; gap:8px; }
        .pw-panel h3 .icon{ width:15px; height:15px; color:#4E8FF0; }
        .pw-panel .sub{ font-size:12px; color:var(--text-faint); margin-bottom:20px; }

        .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        .field.full{ grid-column:1/-1; }
        .field{ display:flex; flex-direction:column; gap:7px; }
        .field label{ font-size:12px; font-weight:600; color:var(--text-mute); }
        .field input{
            padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none; font-family:inherit; transition:all .2s ease;
        }
        .field input:focus{ border-color:rgba(78,143,240,.5); background:var(--surface); }
        .field-error{ font-size:11.5px; color:var(--danger); }

        .form-actions{ display:flex; justify-content:flex-end; margin-top:22px; }
        .btn{ display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
        .btn-info{ background:linear-gradient(135deg,#4E8FF0,#3465C4); color:#fff; box-shadow:0 4px 18px rgba(78,143,240,.3); }
        .btn-info:hover{ transform:translateY(-2px); box-shadow:0 8px 24px rgba(78,143,240,.4); }

        @media (max-width:640px){ .field-grid{ grid-template-columns:1fr; } .sec-row{ flex-direction:column; align-items:flex-start; } }
    </style>

    <div class="asw">
        <div class="asw-head animate-in" style="animation-delay:.03s;">
            <h1>Keamanan Akun</h1>
            <p>Kelola password dan pengaturan keamanan akun admin kamu.</p>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay:.05s;">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error animate-in" style="animation-delay:.05s;">{{ $errors->first() }}</div>
        @endif

        <div class="sec-banner animate-in" style="animation-delay:.08s;">
            <div class="ic"><svg class="icon"><use href="#ic-shield-check"/></svg></div>
            <div class="txt">
                <strong>Akun kamu {{ $admin->two_factor_enabled ? 'terlindungi dengan 2FA' : 'menggunakan proteksi standar' }}</strong>
                <p>Password terakhir diubah: {{ $admin->password_changed_at ? $admin->password_changed_at->translatedFormat('d M Y, H:i') : 'Belum pernah diubah' }}</p>
            </div>
        </div>

        <div class="sec-list animate-in" style="animation-delay:.12s;">
            <div class="sec-row">
                <div class="sec-row-left">
                    <div class="sec-row-ic"><svg class="icon"><use href="#ic-smartphone"/></svg></div>
                    <div>
                        <div class="sec-row-title">Autentikasi Dua Faktor (2FA)</div>
                        <div class="sec-row-sub">Tambahan lapisan keamanan saat login ke panel admin.</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.security.two-factor.toggle') }}" onchange="this.submit()">
                    @csrf
                    <label class="switch">
                        <input type="checkbox" {{ $admin->two_factor_enabled ? 'checked' : '' }} onchange="this.form.submit()">
                        <span class="switch-track"></span>
                    </label>
                </form>
            </div>
        </div>

        <div class="pw-panel animate-in" style="animation-delay:.16s;">
            <h3><svg class="icon"><use href="#ic-key"/></svg> Ubah Password</h3>
            <div class="sub">Gunakan password yang kuat dan belum pernah dipakai di layanan lain.</div>

            <form method="POST" action="{{ route('admin.security.password.update') }}">
                @csrf
                @method('PUT')
                <div class="field-grid">
                    <div class="field full">
                        <label>Password Saat Ini</label>
                        <input type="password" name="current_password" required>
                        @error('current_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" required minlength="8">
                        @error('new_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" required minlength="8">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-info">Perbarui Password</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>