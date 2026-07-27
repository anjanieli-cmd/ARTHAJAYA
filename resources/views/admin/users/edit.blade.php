<x-admin-layout>
    <x-slot name="title">Edit User</x-slot>

    <style>
        .page-head{ margin-bottom:28px; }
        .page-head h1{ font-size:26px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .alert-error{ background:rgba(232,90,90,0.1); border:1px solid rgba(232,90,90,0.3); color:var(--danger); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:20px; display:flex; align-items:flex-start; gap:10px; }
        .alert-error svg{ width:15px; height:15px; flex-shrink:0; margin-top:1px; }

        /* ===== LAYOUT 2 KOLOM ===== */
        .edit-layout{ display:grid; grid-template-columns:260px 1fr; gap:24px; align-items:start; }

        /* ===== SIDEBAR KIRI ===== */
        .user-sidebar{
            background:var(--surface); border:1px solid var(--border); border-radius:18px;
            padding:26px 20px; text-align:center; position:sticky; top:20px;
        }
        .user-avatar-big{
            width:68px; height:68px; border-radius:16px;
            background:linear-gradient(135deg, var(--emerald), #0ea572);
            display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk',sans-serif; font-size:26px; font-weight:700;
            color:#052117; margin:0 auto 14px;
        }
        .user-sidebar .u-name{ font-size:15px; font-weight:700; color:var(--text); margin-bottom:3px; }
        .user-sidebar .u-email{ font-size:12px; color:var(--text-faint); word-break:break-all; line-height:1.4; }
        .user-sidebar .u-divider{ height:1px; background:var(--border); margin:16px 0; }
        .user-meta-row{ display:flex; justify-content:space-between; align-items:center; font-size:12.5px; padding:7px 0; border-bottom:1px solid var(--border); }
        .user-meta-row:last-child{ border-bottom:none; }
        .user-meta-row .k{ color:var(--text-faint); }
        .user-meta-row .v{ font-weight:600; color:var(--text); }

        /* ===== FORM CARDS ===== */
        .form-main{ display:flex; flex-direction:column; gap:28px; }

        .form-card{
            background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden;
        }
        .form-card-header{
            padding:22px 28px; border-bottom:1px solid var(--border);
            display:flex; align-items:center; gap:14px;
        }
        .hic{
            width:34px; height:34px; border-radius:9px;
            background:rgba(var(--emerald-rgb),0.12); border:1px solid rgba(var(--emerald-rgb),0.2);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .hic svg{ width:15px; height:15px; color:var(--emerald); }
        .form-card-header h2{ font-size:14.5px; font-weight:700; color:var(--text); margin:0 0 2px; }
        .form-card-header p{ font-size:12px; color:var(--text-mute); margin:0; }

        .form-card-body{ padding:28px; display:flex; flex-direction:column; gap:22px; }
        .form-card-footer{
            padding:20px 28px; border-top:1px solid var(--border);
            display:flex; align-items:center; gap:12px;
            background:rgba(255,255,255,0.01);
        }

        /* ===== FIELDS ===== */
        .form-grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .form-group{ display:flex; flex-direction:column; gap:0; }

        label.flabel{
            font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.05em;
            color:var(--text-mute); margin-bottom:7px;
            display:flex; align-items:center; gap:7px;
        }
        label.flabel .lopt{
            font-size:10.5px; font-weight:500; color:var(--text-faint);
            text-transform:none; letter-spacing:0;
            background:var(--surface-strong); padding:2px 8px; border-radius:20px; border:1px solid var(--border);
        }

        .form-control{
            width:100%; padding:11px 14px; border-radius:11px;
            background:var(--surface-strong); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none; font-family:inherit;
            transition:border-color .15s, box-shadow .15s;
        }
        .form-control:focus{ border-color:var(--emerald); box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.12); }
        .form-control:disabled{ opacity:.45; cursor:not-allowed; }
        select.form-control{
            appearance:none; -webkit-appearance:none;
            background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat:no-repeat; background-position:right 14px center; background-size:14px; padding-right:38px;
            color-scheme:dark;
        }
        select.form-control option{ background:#12161F; color:#EAF0F6; }

        .form-hint{ font-size:11.5px; color:var(--text-faint); margin-top:6px; line-height:1.5; display:flex; align-items:flex-start; gap:5px; }
        .form-hint svg{ width:12px; height:12px; flex-shrink:0; margin-top:1px; }
        .form-error-msg{ color:var(--danger); font-size:12px; margin-top:5px; display:flex; align-items:center; gap:4px; }
        .form-error-msg svg{ width:12px; height:12px; flex-shrink:0; }

        /* Warning box */
        .warn-box{
            display:flex; align-items:flex-start; gap:10px; padding:11px 14px;
            background:rgba(240,168,60,0.08); border:1px solid rgba(240,168,60,0.25); border-radius:10px; margin-top:8px;
        }
        .warn-box svg{ width:13px; height:13px; color:var(--warning); flex-shrink:0; margin-top:2px; }
        .warn-box span{ font-size:12px; color:var(--warning); line-height:1.5; }

        /* Section divider */
        .section-divider{ display:flex; align-items:center; gap:12px; margin:4px 0; }
        .section-divider .line{ flex:1; height:1px; background:var(--border); }
        .section-divider .label{ font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); white-space:nowrap; }

        /* Password toggle */
        .pw-wrap{ position:relative; }
        .pw-wrap .form-control{ padding-right:42px; }
        .pw-toggle{ position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-faint); padding:0; display:flex; align-items:center; }
        .pw-toggle svg{ width:16px; height:16px; }
        .pw-toggle:hover{ color:var(--text); }

        /* ===== BUTTONS ===== */
        .btn{ display:inline-flex; align-items:center; gap:8px; padding:11px 22px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all .2s ease; }
        .btn svg{ width:15px; height:15px; }
        .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 16px rgba(var(--emerald-rgb),0.3); }
        .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 8px 24px rgba(var(--emerald-rgb),0.4); }
        .btn-outline{ background:var(--surface-strong); border:1px solid var(--border); color:var(--text-mute); }
        .btn-outline:hover{ background:var(--surface); border-color:var(--border-hover); color:var(--text); }

        @media (max-width:900px){
            .edit-layout{ grid-template-columns:1fr; }
            .user-sidebar{ position:static; }
            .form-grid-2{ grid-template-columns:1fr; }
        }
    </style>

    {{-- SVG icons --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></symbol>
            <symbol id="ic-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></symbol>
            <symbol id="ic-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
            <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
            <symbol id="ic-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></symbol>
            <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
        </defs>
    </svg>

    <div class="page-head">
        <h1>Edit User</h1>
        <p>Ubah access level atau reset password untuk <strong>{{ $targetUser->name }}</strong>.</p>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-alert"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="edit-layout">

        {{-- ===== SIDEBAR KIRI ===== --}}
        <div class="user-sidebar">
            <div class="user-avatar-big">{{ strtoupper(substr($targetUser->name, 0, 1)) }}</div>
            <div class="u-name">{{ $targetUser->name }}</div>
            <div class="u-email">{{ $targetUser->email }}</div>
            <div class="u-divider"></div>
            <div class="user-meta-row">
                <span class="k">Access Level</span>
                <span class="v">{{ $accessLevels[$targetUser->access_level->value] ?? $targetUser->access_level->value }}</span>
            </div>
            <div class="user-meta-row">
                <span class="k">Bergabung</span>
                <span class="v">{{ $targetUser->created_at->format('d M Y') }}</span>
            </div>
            <div class="user-meta-row">
                <span class="k">Status</span>
                <span class="v" style="color:var(--emerald);">Aktif</span>
            </div>
        </div>

        {{-- ===== FORM UTAMA ===== --}}
        <div class="form-main">
            <form method="POST" action="{{ route('admin.users.update', $targetUser) }}">
                @csrf
                @method('PUT')

                {{-- CARD 1: INFO USER (readonly) --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="hic"><svg><use href="#ic-user"/></svg></div>
                        <div>
                            <h2>Informasi User</h2>
                            <p>Data identitas pengguna (tidak dapat diubah)</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="flabel">Nama</label>
                                <input type="text" class="form-control" value="{{ $targetUser->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="flabel">Email</label>
                                <input type="text" class="form-control" value="{{ $targetUser->email }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: ACCESS LEVEL --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="hic"><svg><use href="#ic-edit"/></svg></div>
                        <div>
                            <h2>Pengaturan Akun</h2>
                            <p>Ubah access level pengguna ini</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="flabel">Access Level</label>
                            <select name="access_level" class="form-control" @if($targetUser->id === auth()->id()) disabled @endif>
                                @foreach($accessLevels as $value => $label)
                                    <option value="{{ $value }}" {{ $targetUser->access_level->value === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if($targetUser->id === auth()->id())
                                <input type="hidden" name="access_level" value="{{ $targetUser->access_level->value }}">
                                <div class="warn-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-alert"/></svg>
                                    <span>Kamu tidak bisa menurunkan access level akunmu sendiri — ini untuk mencegah kamu terkunci dari panel admin.</span>
                                </div>
                            @else
                                <div class="form-hint">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-info"/></svg>
                                    Perubahan access level langsung berlaku setelah disimpan.
                                </div>
                            @endif
                            @error('access_level')
                                <div class="form-error-msg">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-alert"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- CARD 3: RESET PASSWORD --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="hic"><svg><use href="#ic-lock"/></svg></div>
                        <div>
                            <h2>Reset Password</h2>
                            <p>Kosongkan semua field jika tidak ingin mengubah password</p>
                        </div>
                    </div>
                    <div class="form-card-body">

                        {{-- Password lama --}}
                        <div class="form-group">
                            <label class="flabel">
                                Password Lama
                                <span class="lopt">Wajib jika ingin reset</span>
                            </label>
                            <div class="pw-wrap">
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Masukkan password lama user ini">
                                <button type="button" class="pw-toggle" onclick="togglePw('current_password', this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-eye"/></svg>
                                </button>
                            </div>
                            <div class="form-hint">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-info"/></svg>
                                Verifikasi password lama diperlukan sebelum bisa mengubah password.
                            </div>
                            @error('current_password')
                                <div class="form-error-msg">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-alert"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="section-divider">
                            <div class="line"></div>
                            <div class="label">Password Baru</div>
                            <div class="line"></div>
                        </div>

                        {{-- Password baru --}}
                        <div class="form-group">
                            <label class="flabel">
                                Password Baru
                                <span class="lopt">Min. 8 karakter</span>
                            </label>
                            <div class="pw-wrap">
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Masukkan password baru">
                                <button type="button" class="pw-toggle" onclick="togglePw('new_password', this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-eye"/></svg>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="form-error-msg">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-alert"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Konfirmasi password baru --}}
                        <div class="form-group">
                            <label class="flabel">Konfirmasi Password Baru</label>
                            <div class="pw-wrap">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                <button type="button" class="pw-toggle" onclick="togglePw('new_password_confirmation', this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-eye"/></svg>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="form-card-footer">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-check"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                    </div>
                </div>

            </form>
        </div>

    </div>

    <script>
    function togglePw(id, btn) {
        var input = document.getElementById(id);
        var isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.innerHTML = isPassword
            ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-eye-off"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="#ic-eye"/></svg>';
    }
    </script>

</x-admin-layout>