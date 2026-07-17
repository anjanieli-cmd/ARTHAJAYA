<x-app-layout>
  <x-slot name="title">Keamanan</x-slot>

  <style>
    .sec-wrap{display:flex;flex-direction:column;gap:18px;max-width:820px;}
    .sec-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:24px;}
    .sec-card-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;}
    .sec-card-head h3{font-size:15px;font-weight:700;}
    .sec-card-desc{font-size:12.5px;color:var(--text-mute);margin-bottom:18px;}
    .form-group{margin-bottom:14px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
    .form-control{width:100%;padding:10px 14px;border-radius:12px;background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;}
    .form-error{color:var(--danger);font-size:12px;margin-top:4px;}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
    .btn-sm{padding:7px 14px;font-size:12px;}

    .toggle-row{display:flex;justify-content:space-between;align-items:center;padding:4px 0;}
    .toggle-row .t{font-size:13.5px;font-weight:600;}
    .toggle-row .d{font-size:12px;color:var(--text-mute);margin-top:2px;}
    .switch{position:relative;width:42px;height:24px;flex-shrink:0;}
    .switch input{opacity:0;width:0;height:0;}
    .switch-track{position:absolute;inset:0;background:var(--surface-strong);border:1px solid var(--border);border-radius:100px;cursor:pointer;transition:.2s;}
    .switch-track:before{content:'';position:absolute;width:16px;height:16px;left:3px;top:2.5px;background:var(--text-faint);border-radius:50%;transition:.2s;}
    .switch input:checked + .switch-track{background:rgba(var(--emerald-rgb),0.25);border-color:var(--emerald);}
    .switch input:checked + .switch-track:before{transform:translateX(18px);background:var(--emerald);}

    .sess-row{display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border);}
    .sess-row:last-child{border-bottom:none;}
    .sess-ic{width:36px;height:36px;border-radius:10px;background:var(--surface-strong);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .sess-info{flex:1;min-width:0;}
    .sess-agent{font-size:13px;font-weight:600;}
    .sess-agent .current-tag{font-size:10.5px;font-weight:700;color:var(--emerald);background:rgba(var(--emerald-rgb),0.12);padding:2px 8px;border-radius:100px;margin-left:8px;}
    .sess-meta{font-size:12px;color:var(--text-faint);margin-top:2px;}
    .alert-success{background:rgba(var(--emerald-rgb),0.1);border:1px solid rgba(var(--emerald-rgb),0.3);color:var(--emerald);padding:12px 16px;border-radius:12px;font-size:13px;margin-bottom:18px;max-width:820px;}
    .alert-error{background:rgba(232,90,122,0.1);border:1px solid rgba(232,90,122,0.3);color:var(--danger);padding:12px 16px;border-radius:12px;font-size:13px;margin-bottom:18px;max-width:820px;}
  </style>

  <div class="page-head"><div><h1>Keamanan</h1><p>Kelola password, autentikasi dua faktor, dan sesi login aktif.</p></div></div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
  @endif

  <div class="sec-wrap">
    {{-- GANTI PASSWORD --}}
    <div class="sec-card">
      <div class="sec-card-head"><h3>Ganti Password</h3></div>
      <div class="sec-card-desc">Gunakan password yang kuat dan belum pernah dipakai di tempat lain.</div>
      <form method="POST" action="{{ route('security.password.update') }}">
        @csrf @method('PUT')
        <div class="form-group">
          <label>Password Saat Ini</label>
          <input type="password" name="current_password" class="form-control" required>
          @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="grid-2">
          <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Password</button>
      </form>
      @if($user->password_changed_at)
        <div style="font-size:11.5px;color:var(--text-faint);margin-top:12px;">Terakhir diubah {{ $user->password_changed_at->diffForHumans() }}</div>
      @endif
    </div>

    {{-- 2FA --}}
    <div class="sec-card">
      <div class="sec-card-head"><h3>Autentikasi Dua Faktor</h3></div>
      <div class="sec-card-desc">Tambahan lapisan keamanan saat login ke akunmu.</div>
      <div class="toggle-row">
        <div>
          <div class="t">Aktifkan 2FA</div>
          <div class="d">{{ $user->two_factor_enabled ? 'Sedang aktif' : 'Sedang nonaktif' }}</div>
        </div>
        <form method="POST" action="{{ route('security.two-factor.toggle') }}">
          @csrf
          <label class="switch">
            <input type="checkbox" onchange="this.form.submit()" {{ $user->two_factor_enabled ? 'checked' : '' }}>
            <span class="switch-track"></span>
          </label>
        </form>
      </div>
    </div>

    {{-- SESI AKTIF --}}
    <div class="sec-card">
      <div class="sec-card-head">
        <h3>Sesi Login Aktif</h3>
        @if($sessions->count() > 1)
          <form method="POST" action="{{ route('security.sessions.revoke-others') }}" onsubmit="return confirm('Akhiri semua sesi lain?')">
            @csrf
            <button type="submit" class="btn btn-outline btn-sm">Akhiri Sesi Lain</button>
          </form>
        @endif
      </div>
      <div class="sec-card-desc">Daftar perangkat yang sedang login ke akunmu.</div>

      @forelse($sessions as $s)
        <div class="sess-row">
          <div class="sess-ic"><svg class="icon"><use href="#ic-bank"/></svg></div>
          <div class="sess-info">
            <div class="sess-agent">
              {{ \Illuminate\Support\Str::limit($s->user_agent, 60) }}
              @if($s->is_current)<span class="current-tag">Perangkat Ini</span>@endif
            </div>
            <div class="sess-meta">{{ $s->ip_address }} • Aktif {{ $s->last_activity_human }}</div>
          </div>
          @if(!$s->is_current)
            <form method="POST" action="{{ route('security.sessions.revoke', $s->id) }}" onsubmit="return confirm('Akhiri sesi ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-outline btn-sm" style="color:var(--danger);">Akhiri</button>
            </form>
          @endif
        </div>
      @empty
        <div style="font-size:12.5px;color:var(--text-mute);padding:12px 0;">Tidak ada sesi aktif.</div>
      @endforelse
    </div>
  </div>
</x-app-layout>