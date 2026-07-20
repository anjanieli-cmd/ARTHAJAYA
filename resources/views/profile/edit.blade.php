<x-app-layout>
  <x-slot name="title">Profil Saya</x-slot>

  <style>
    .pf-layout{display:grid;grid-template-columns:320px 1fr;gap:20px;align-items:start;}
    @media (max-width:1100px){ .pf-layout{grid-template-columns:1fr;} }

    /* ===== SIDEBAR KIRI ===== */
    .pf-side{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:28px 24px;text-align:center;position:sticky;top:20px;}
    .pf-avatar-wrap{position:relative;width:96px;height:96px;margin:0 auto 16px;}
    .pf-avatar{width:96px;height:96px;border-radius:50%;background:var(--surface-strong);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;color:var(--text-mute);overflow:hidden;}
    .pf-avatar img{width:100%;height:100%;object-fit:cover;}
    .pf-name{font-size:17px;font-weight:700;color:var(--text);}
    .pf-role{font-size:12.5px;color:var(--text-mute);margin-top:2px;margin-bottom:20px;}

    .pf-upload-form{border-top:1px solid var(--border);padding-top:18px;text-align:left;}
    .pf-upload-form label.filelabel{display:block;font-size:12px;font-weight:600;color:var(--text-mute);margin-bottom:8px;}
    .pf-file-input input[type=file]{width:100%;color:var(--text-mute);font-size:12px;}
    .pf-file-input input[type=file]::file-selector-button{background:var(--surface-strong);border:1px solid var(--border);color:var(--text);padding:7px 12px;border-radius:9px;font-size:11.5px;font-weight:600;cursor:pointer;margin-right:8px;}
    .pf-upload-form .btn{width:100%;justify-content:center;margin-top:10px;}

    .pf-meta{text-align:left;border-top:1px solid var(--border);padding-top:16px;margin-top:20px;}
    .pf-meta-row{display:flex;justify-content:space-between;font-size:12.5px;padding:7px 0;}
    .pf-meta-row .k{color:var(--text-faint);}
    .pf-meta-row .v{font-weight:600;color:var(--text);}

    .pf-tips{background:rgba(var(--emerald-rgb),0.06);border:1px solid rgba(var(--emerald-rgb),0.2);border-radius:14px;padding:16px 18px;margin-top:18px;text-align:left;}
    .pf-tips .t{font-size:12.5px;font-weight:700;color:var(--emerald);margin-bottom:6px;}
    .pf-tips ul{margin:0;padding-left:16px;}
    .pf-tips li{font-size:11.5px;color:var(--text-mute);line-height:1.7;}

    /* ===== KONTEN KANAN ===== */
    .pf-main-col{display:flex;flex-direction:column;gap:18px;}
    .pf-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:28px;}
    .pf-card h2{font-size:15px;font-weight:700;margin-bottom:4px;color:var(--text);}
    .pf-card .desc{font-size:12.5px;color:var(--text-mute);margin-bottom:22px;}

    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:var(--text);}
    .form-control{width:100%;padding:11px 14px;border-radius:12px;background:var(--surface-strong);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;transition:all .2s ease;font-family:inherit;appearance:none;}
    .form-control:focus{border-color:var(--border-hover);}
    .form-control::placeholder{color:var(--text-faint);}

    select.form-control{
      background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
      background-repeat:no-repeat; background-position: right 14px center; background-size:14px; padding-right:38px;
    }
    /* Warna dropdown native menyesuaikan tema aktif (dark/light) */
    html{ --dropdown-bg:#12161F; --dropdown-text:#EAF0F6; }
    html[data-theme="light"]{ --dropdown-bg:#FFFFFF; --dropdown-text:#131A26; }
    html[data-theme="dark"] select.form-control{ color-scheme: dark; }
    html[data-theme="light"] select.form-control{ color-scheme: light; }
    select.form-control option{
      background: var(--dropdown-bg);
      color: var(--dropdown-text);
      padding: 8px;
    }

    .form-error{color:var(--danger);font-size:12px;margin-top:4px;}
    .form-status{font-size:12.5px;color:var(--emerald);}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .form-actions{display:flex;align-items:center;gap:14px;margin-top:6px;}

    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface-strong);border:1px solid var(--border);color:var(--text);}
    .btn-danger{background:transparent;border:1px solid var(--danger);color:var(--danger);}

    .danger-zone{border-color:rgba(232,90,122,0.3);}
    .danger-zone h2{color:var(--danger);}
  </style>

  <div class="page-head">
    <div>
      <h1>Profil Saya</h1>
      <p>Kelola informasi akun pribadimu.</p>
    </div>
  </div>

  <div class="pf-layout">

    {{-- ===== SIDEBAR KIRI ===== --}}
    <div class="pf-side">
      <div class="pf-avatar-wrap">
        <div class="pf-avatar">
          @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
          @else
            {{ strtoupper(substr($user->name,0,1)) }}
          @endif
        </div>
      </div>
      <div class="pf-name">{{ $user->name }}</div>
      <div class="pf-role">{{ $user->position ?? 'Jabatan belum diisi' }}</div>

      <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="pf-upload-form">
        @csrf
        @method('patch')
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="phone" value="{{ $user->phone }}">
        <input type="hidden" name="position" value="{{ $user->position }}">

        <label class="filelabel">Ganti Foto Profil (JPG/PNG, maks 2MB)</label>
        <div class="pf-file-input">
          <input type="file" name="avatar" accept="image/jpeg,image/png,image/jpg">
        </div>
        @error('avatar')<div class="form-error">{{ $message }}</div>@enderror
        <button type="submit" class="btn btn-primary">Unggah Foto</button>
      </form>

      <div class="pf-meta">
        <div class="pf-meta-row"><span class="k">Perusahaan</span><span class="v">{{ $company->name ?? '—' }}</span></div>
        <div class="pf-meta-row"><span class="k">Email</span><span class="v">{{ \Illuminate\Support\Str::limit($user->email, 20) }}</span></div>
        <div class="pf-meta-row"><span class="k">Bergabung</span><span class="v">{{ $user->created_at->translatedFormat('d M Y') }}</span></div>
      </div>

      <div class="pf-tips">
        <div class="t">Tips Keamanan</div>
        <ul>
          <li>Gunakan foto profil asli agar tim mudah mengenalimu.</li>
          <li>Pastikan email aktif untuk menerima notifikasi penting.</li>
          <li>Perbarui nomor telepon jika berganti kontak.</li>
        </ul>
      </div>

      <div class="pf-tips" style="background:var(--surface-strong);border-color:var(--border);text-align:left;">
        <div class="t" style="color:var(--text);">Butuh Bantuan?</div>
        <div style="font-size:11.5px;color:var(--text-mute);line-height:1.7;">Hubungi admin perusahaan kalau kamu lupa password atau butuh bantuan mengelola akun. Untuk ganti password, buka menu <b>Keamanan</b>.</div>
      </div>
    </div>

    {{-- ===== KONTEN KANAN ===== --}}
    <div class="pf-main-col">
      <div class="pf-card">
        @include('profile.partials.update-profile-information-form')
      </div>

      <div class="pf-card danger-zone">
        @include('profile.partials.delete-user-form')
      </div>
    </div>

  </div>
</x-app-layout>