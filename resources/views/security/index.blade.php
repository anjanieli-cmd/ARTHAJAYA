<x-app-layout>
  <x-slot name="title">Keamanan</x-slot>

  <style>
    .sec-layout{display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;}
    @media (max-width:1100px){ .sec-layout{grid-template-columns:1fr;} }

    .sec-main{display:flex;flex-direction:column;gap:18px;}
    .sec-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:28px;}
    .sec-card h2{font-size:15px;font-weight:700;margin-bottom:4px;color:var(--text);}
    .sec-card .desc{font-size:12.5px;color:var(--text-mute);margin-bottom:22px;line-height:1.5;}
    .sec-card-head{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;}

    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:var(--text);}
    .form-control{width:100%;padding:11px 14px;border-radius:12px;background:var(--surface-strong);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;transition:all .2s ease;font-family:inherit;}
    .form-control:focus{border-color:var(--border-hover);}
    .form-control::placeholder{color:var(--text-faint);}
    .form-error{color:var(--danger);font-size:12px;margin-top:4px;}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .form-actions{display:flex;align-items:center;gap:14px;margin-top:6px;}

    .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface-strong);border:1px solid var(--border);color:var(--text);}
    .btn-sm{padding:7px 14px;font-size:12px;}

    .toggle-row{display:flex;justify-content:space-between;align-items:center;padding:2px 0;}
    .toggle-row .t{font-size:13.5px;font-weight:600;color:var(--text);}
    .toggle-row .d{font-size:12px;color:var(--text-mute);margin-top:2px;}
    .switch{position:relative;width:42px;height:24px;flex-shrink:0;}
    .switch input{opacity:0;width:0;height:0;position:absolute;}
    .switch-track{position:absolute;inset:0;background:var(--surface-strong);border:1px solid var(--border);border-radius:100px;cursor:pointer;transition:.2s;}
    .switch-track:before{content:'';position:absolute;width:16px;height:16px;left:3px;top:2.5px;background:var(--text-faint);border-radius:50%;transition:.2s;}
    .switch input:checked + .switch-track{background:rgba(var(--emerald-rgb),0.25);border-color:var(--emerald);}
    .switch input:checked + .switch-track:before{transform:translateX(18px);background:var(--emerald);}

    .sess-row{display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border);}
    .sess-row:last-child{border-bottom:none;}
    .sess-ic{width:36px;height:36px;border-radius:10px;background:var(--surface-strong);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--text-mute);}
    .sess-ic svg{width:16px;height:16px;}
    .sess-info{flex:1;min-width:0;}
    .sess-agent{font-size:13px;font-weight:600;color:var(--text);}
    .sess-agent .current-tag{font-size:10.5px;font-weight:700;color:var(--emerald);background:rgba(var(--emerald-rgb),0.12);padding:2px 8px;border-radius:100px;margin-left:8px;}
    .sess-meta{font-size:12px;color:var(--text-faint);margin-top:2px;}

    .alert-success{background:rgba(var(--emerald-rgb),0.1);border:1px solid rgba(var(--emerald-rgb),0.3);color:var(--emerald);padding:12px 16px;border-radius:12px;font-size:13px;margin-bottom:18px;}
    .alert-error{background:rgba(232,90,122,0.1);border:1px solid rgba(232,90,122,0.3);color:var(--danger);padding:12px 16px;border-radius:12px;font-size:13px;margin-bottom:18px;}
    .empty-hint{font-size:12.5px;color:var(--text-mute);padding:12px 0;}
    .last-changed{font-size:11.5px;color:var(--text-faint);margin-top:12px;}

    /* ===== SIDEBAR KANAN ===== */
    .sec-side{display:flex;flex-direction:column;gap:18px;position:sticky;top:20px;}
    .score-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:26px 22px;text-align:center;}
    .score-ring{width:96px;height:96px;margin:0 auto 14px;position:relative;}
    .score-ring svg{width:100%;height:100%;transform:rotate(-90deg);}
    .score-ring .bg{stroke:var(--surface-strong);}
    .score-ring .fg{stroke:var(--emerald);stroke-linecap:round;transition:stroke-dashoffset .6s ease;}
    .score-num{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:var(--text);}
    .score-label{font-size:12.5px;color:var(--text-mute);margin-bottom:2px;}
    .score-title{font-size:14px;font-weight:700;color:var(--text);}

    .checklist{display:flex;flex-direction:column;gap:10px;margin-top:18px;text-align:left;}
    .check-row{display:flex;align-items:center;gap:10px;font-size:12.5px;color:var(--text-mute);}
    .check-ic{width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px;font-weight:700;}
    .check-ic.done{background:rgba(var(--emerald-rgb),0.15);color:var(--emerald);}
    .check-ic.pending{background:var(--surface-strong);color:var(--text-faint);}

    .info-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:22px;}
    .info-card .t{font-size:13px;font-weight:700;color:var(--text);margin-bottom:8px;}
    .info-card p{font-size:12px;color:var(--text-mute);line-height:1.7;}
  </style>

  <div class="page-head">
    <div>
      <h1>Keamanan</h1>
      <p>Kelola password, autentikasi dua faktor, dan sesi login aktif.</p>
    </div>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
  @endif

  <div class="sec-layout">

    {{-- ===== KONTEN UTAMA ===== --}}
    <div class="sec-main">
      {{-- GANTI PASSWORD --}}
      <div class="sec-card">
        <h2>Ganti Password</h2>
        <div class="desc">Gunakan password yang kuat dan belum pernah dipakai di tempat lain.</div>
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
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui Password</button>
          </div>
        </form>
        @if($user->password_changed_at)
          <div class="last-changed">Terakhir diubah {{ $user->password_changed_at->diffForHumans() }}</div>
        @endif
      </div>

      {{-- 2FA --}}
      <div class="sec-card">
        <h2>Autentikasi Dua Faktor</h2>
        <div class="desc">Tambahan lapisan keamanan saat login ke akunmu.</div>
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
          <div>
            <h2>Sesi Login Aktif</h2>
            <div class="desc" style="margin-bottom:12px;">Daftar perangkat yang sedang login ke akunmu.</div>
          </div>
          @if($sessions->count() > 1)
            <form method="POST" action="{{ route('security.sessions.revoke-others') }}" onsubmit="return confirm('Akhiri semua sesi lain?')">
              @csrf
              <button type="submit" class="btn btn-outline btn-sm">Akhiri Sesi Lain</button>
            </form>
          @endif
        </div>

        @forelse($sessions as $s)
          <div class="sess-row">
            <div class="sess-ic">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            </div>
            <div class="sess-info">
              <div class="sess-agent">
                {{ \Illuminate\Support\Str::limit($s->user_agent ?? 'Perangkat tidak dikenal', 55) }}
                @if($s->is_current)<span class="current-tag">Perangkat Ini</span>@endif
              </div>
              <div class="sess-meta">{{ $s->ip_address ?? '—' }} • Aktif {{ $s->last_activity_human }}</div>
            </div>
            @if(!$s->is_current)
              <form method="POST" action="{{ route('security.sessions.revoke', $s->id) }}" onsubmit="return confirm('Akhiri sesi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline btn-sm" style="color:var(--danger);">Akhiri</button>
              </form>
            @endif
          </div>
        @empty
          <div class="empty-hint">Tidak ada sesi aktif.</div>
        @endforelse
      </div>
    </div>

    {{-- ===== SIDEBAR KANAN ===== --}}
    @php
      $score = 40;
      if ($user->password_changed_at) $score += 30;
      if ($user->two_factor_enabled) $score += 30;
      $circumference = 2 * 3.14159 * 42;
      $offset = $circumference - ($score / 100) * $circumference;
    @endphp
    <div class="sec-side">
      <div class="score-card">
        <div class="score-label">Skor Keamanan Akun</div>
        <div class="score-ring">
          <svg viewBox="0 0 100 100">
            <circle class="bg" cx="50" cy="50" r="42" fill="none" stroke-width="8"/>
            <circle class="fg" cx="50" cy="50" r="42" fill="none" stroke-width="8"
              stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"/>
          </svg>
          <div class="score-num">{{ $score }}%</div>
        </div>
        <div class="score-title">
          @if($score >= 80) Sangat Aman
          @elseif($score >= 50) Cukup Aman
          @else Perlu Ditingkatkan
          @endif
        </div>

        <div class="checklist">
          <div class="check-row">
            <span class="check-ic done">✓</span> Password aktif
          </div>
          <div class="check-row">
            <span class="check-ic {{ $user->two_factor_enabled ? 'done' : 'pending' }}">{{ $user->two_factor_enabled ? '✓' : '!' }}</span>
            Autentikasi dua faktor {{ $user->two_factor_enabled ? 'aktif' : 'belum aktif' }}
          </div>
          <div class="check-row">
            <span class="check-ic {{ $sessions->count() <= 1 ? 'done' : 'pending' }}">{{ $sessions->count() <= 1 ? '✓' : '!' }}</span>
            {{ $sessions->count() }} sesi login aktif
          </div>
        </div>
      </div>

      <div class="info-card">
        <div class="t">Kenapa ini penting?</div>
        <p>Akun dengan 2FA aktif dan password yang rutin diperbarui jauh lebih sulit dibobol. Periksa daftar sesi secara berkala dan akhiri sesi dari perangkat yang tidak kamu kenali.</p>
      </div>

      <div class="info-card">
        <div class="t">Rekomendasi</div>
        <p>
          @if(!$user->two_factor_enabled)
            Aktifkan 2FA sekarang untuk menaikkan skor keamanan akunmu secara signifikan.
          @elseif($sessions->count() > 1)
            Kamu punya beberapa sesi aktif. Akhiri sesi yang tidak dikenali untuk keamanan ekstra.
          @else
            Akunmu dalam kondisi baik. Tetap perbarui password secara berkala setiap 3 bulan.
          @endif
        </p>
      </div>

      <div class="info-card">
        <div class="t">Riwayat Login Terakhir</div>
        <p>
          @if($sessions->isNotEmpty())
            Login terbaru tercatat {{ $sessions->first()->last_activity_human }} dari {{ $sessions->first()->ip_address ?? 'alamat tidak diketahui' }}.
          @else
            Belum ada riwayat login tercatat.
          @endif
        </p>
      </div>
    </div>

  </div>
</x-app-layout>