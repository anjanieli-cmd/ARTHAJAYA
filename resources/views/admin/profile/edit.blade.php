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
        </defs>
    </svg>

    <style>
        .apw{ --accent: var(--emerald); color:var(--text); }
        .apw *{ box-sizing:border-box; }
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(16px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes fadeSlideLeft{ from{ opacity:0; transform:translateX(-16px);} to{ opacity:1; transform:translateX(0);} }
        .apw .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .apw .animate-in-left{ animation:fadeSlideLeft .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        .apw-head{ margin-bottom:22px; }
        .apw-head h1{ font-family:'Space Grotesk', sans-serif; font-size:25px; margin-bottom:6px; }
        .apw-head p{ font-size:13.5px; color:var(--text-mute); }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }
        .alert-error{ background:rgba(232,90,90,0.1); border:1px solid rgba(232,90,90,0.3); color:var(--danger); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        .apw-layout{ display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start; }

        /* ===== LEFT: avatar card ===== */
        .avatar-card{
            background:linear-gradient(160deg, rgba(var(--emerald-rgb),.1), var(--surface) 60%);
            border:1px solid var(--border); border-radius:22px; padding:32px 24px; text-align:center; position:sticky; top:20px;
        }
        .avatar-wrap{ position:relative; width:110px; height:110px; margin:0 auto 18px; }
        .avatar-img{
            width:110px; height:110px; border-radius:26px; object-fit:cover; background:var(--surface-strong);
            border:2px solid var(--border); display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk'; font-weight:700; font-size:36px; color:var(--emerald);
        }
        .avatar-cam{
            position:absolute; bottom:-4px; right:-4px; width:34px; height:34px; border-radius:50%;
            background:var(--emerald); color:#052117; display:flex; align-items:center; justify-content:center;
            cursor:pointer; border:3px solid var(--bg); transition:transform .2s ease;
        }
        .avatar-cam:hover{ transform:scale(1.08); }
        .avatar-cam .icon{ width:14px; height:14px; }

        .avatar-name{ font-family:'Space Grotesk', sans-serif; font-size:18px; font-weight:700; margin-bottom:4px; }
        .avatar-email{ font-size:12.5px; color:var(--text-faint); margin-bottom:14px; }
        .avatar-badge{ display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:700; color:var(--emerald); background:rgba(var(--emerald-rgb),.14); padding:5px 12px; border-radius:100px; }
        .avatar-badge .icon{ width:12px; height:12px; }

        /* ===== RIGHT: form sections ===== */
        .form-section{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; margin-bottom:16px; }
        .form-section h3{ font-family:'Space Grotesk', sans-serif; font-size:14.5px; margin-bottom:18px; display:flex; align-items:center; gap:8px; }
        .form-section h3 .icon{ width:15px; height:15px; color:var(--emerald); }

        .field-grid{ display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        .field{ display:flex; flex-direction:column; gap:7px; }
        .field.full{ grid-column:1/-1; }
        .field label{ font-size:12px; font-weight:600; color:var(--text-mute); }
        .field input{
            padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none; font-family:inherit; transition:all .2s ease;
        }
        .field input:focus{ border-color:var(--border-hover); background:var(--surface); }
        .field-error{ font-size:11.5px; color:var(--danger); }

        .form-actions{ display:flex; justify-content:flex-end; margin-top:6px; }
        .btn{ display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
        .btn-primary{ background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); color:#052117; box-shadow:0 4px 18px rgba(var(--emerald-rgb),.3); }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 8px 24px rgba(var(--emerald-rgb),.4); }

        @media (max-width:900px){
            .apw-layout{ grid-template-columns:1fr; }
            .avatar-card{ position:static; }
            .field-grid{ grid-template-columns:1fr; }
        }
    </style>

    <div class="apw">
        <div class="apw-head animate-in" style="animation-delay:.03s;">
            <h1>Lihat Profil</h1>
            <p>Informasi akun admin sistem kamu.</p>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay:.05s;">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error animate-in" style="animation-delay:.05s;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="apw-layout">
                <div class="avatar-card animate-in-left" style="animation-delay:.08s;">
                    <div class="avatar-wrap">
                        @if($admin->avatar)
                            <img src="{{ asset('storage/' . $admin->avatar) }}" class="avatar-img" id="avatarPreview">
                        @else
                            <div class="avatar-img" id="avatarPreview">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
                        @endif
                        <label class="avatar-cam" for="avatarInput">
                            <svg class="icon"><use href="#ic-camera"/></svg>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;" onchange="previewAvatar(event)">
                    </div>
                    <div class="avatar-name">{{ $admin->name }}</div>
                    <div class="avatar-email">{{ $admin->email }}</div>
                    <span class="avatar-badge"><svg class="icon"><use href="#ic-shield"/></svg> Admin Sistem</span>
                </div>

                <div>
                    <div class="form-section animate-in" style="animation-delay:.12s;">
                        <h3><svg class="icon"><use href="#ic-user"/></svg> Informasi Umum</h3>
                        <div class="field-grid">
                            <div class="field">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required>
                                @error('name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label>Posisi / Jabatan</label>
                                <input type="text" name="position" value="{{ old('position', $admin->position) }}" placeholder="mis. System Administrator">
                            </div>
                        </div>
                    </div>

                    <div class="form-section animate-in" style="animation-delay:.16s;">
                        <h3><svg class="icon"><use href="#ic-mail"/></svg> Kontak</h3>
                        <div class="field-grid">
                            <div class="field">
                                <label>Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                @error('email')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label>Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" placeholder="mis. 0812-3456-7890">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions animate-in" style="animation-delay:.2s;">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewAvatar(event){
            var file = event.target.files[0];
            if(!file) return;
            var reader = new FileReader();
            reader.onload = function(e){
                var preview = document.getElementById('avatarPreview');
                preview.outerHTML = '<img src="' + e.target.result + '" class="avatar-img" id="avatarPreview">';
            };
            reader.readAsDataURL(file);
        }
    </script>
</x-admin-layout>