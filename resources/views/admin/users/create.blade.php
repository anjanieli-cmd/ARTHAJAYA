<x-admin-layout>
    <x-slot name="title">Tambah User</x-slot>

    <style>
        .page-head{ margin-bottom:22px; }
        .page-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .alert-error{ background:rgba(232,90,90,0.1); border:1px solid rgba(232,90,90,0.3); color:var(--danger); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }
        .hint-box{ background:rgba(78,143,240,0.08); border:1px solid rgba(78,143,240,0.25); color:#8fb4f0; padding:12px 16px; border-radius:12px; font-size:12.5px; margin-bottom:20px; line-height:1.5; }

        .form-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:28px; max-width:480px; }
        .form-group{ margin-bottom:18px; }
        .form-group label{ display:block; font-size:13px; font-weight:600; margin-bottom:6px; }
        .form-control{ width:100%; padding:11px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border); color:var(--text); font-size:13.5px; outline:none; font-family:inherit; }
        .form-error{ color:var(--danger); font-size:12px; margin-top:4px; }
        .form-hint{ font-size:11.5px; color:var(--text-faint); margin-top:5px; }
        .form-actions{ display:flex; gap:12px; margin-top:6px; }
        .btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; text-decoration:none; }
        .btn-primary{ background:var(--emerald); color:#1a1005; }
        .btn-outline{ background:var(--surface-strong); border:1px solid var(--border); color:var(--text); }
    </style>

    <div class="page-head">
        <h1>Tambah User Baru</h1>
        <p>Buat akun langsung dengan access level tertentu — cocok untuk menambahkan admin/staff tim tanpa lewat proses onboarding.</p>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="hint-box">
        💡 Kalau akun ini dibuat dengan access level <b>Admin</b> atau <b>Staff</b>, orangnya akan langsung diarahkan ke dashboard sesuai role saat pertama kali login — <b>tidak akan melewati proses onboarding perusahaan</b>.
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                <div class="form-hint">Minimal 8 karakter.</div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Access Level</label>
                <select name="access_level" class="form-control" required>
                    @foreach($accessLevels as $value => $label)
                        <option value="{{ $value }}" {{ old('access_level') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>