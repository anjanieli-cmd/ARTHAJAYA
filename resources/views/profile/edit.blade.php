<x-app-layout>
  <x-slot name="title">Profil Saya</x-slot>

  <style>
    .pf-wrap{display:flex;flex-direction:column;gap:18px;max-width:720px;}
    .pf-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:26px;}
    .pf-card h2{font-size:15px;font-weight:700;margin-bottom:4px;}
    .pf-card .desc{font-size:12.5px;color:var(--text-mute);margin-bottom:20px;}
    .pf-avatar-row{display:flex;align-items:center;gap:18px;flex-wrap:wrap;}
    .pf-avatar{width:72px;height:72px;border-radius:50%;background:var(--surface-strong);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:var(--text-mute);overflow:hidden;flex-shrink:0;}
    .pf-avatar img{width:100%;height:100%;object-fit:cover;}
    .pf-file-input{font-size:12.5px;color:var(--text-mute);}
    .pf-file-input input[type=file]{color:var(--text-mute);font-size:12.5px;margin-top:6px;}
    .pf-file-input input[type=file]::file-selector-button{background:var(--surface-strong);border:1px solid var(--border);color:var(--text);padding:8px 14px;border-radius:10px;font-size:12.5px;font-weight:600;cursor:pointer;margin-right:10px;}
    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:var(--text);}
    .form-control{width:100%;padding:10px 14px;border-radius:12px;background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;transition:all .2s ease;font-family:inherit;}
    .form-control:focus{border-color:var(--border-hover);background:var(--surface-strong);}
    .form-error{color:var(--danger);font-size:12px;margin-top:4px;}
    .form-status{font-size:12.5px;color:var(--emerald);margin-left:4px;}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
    .btn-danger{background:transparent;border:1px solid var(--danger);color:var(--danger);}
    .form-actions{display:flex;align-items:center;gap:14px;margin-top:6px;}
    .danger-zone{border-color:rgba(232,90,122,0.3);}
    .danger-zone h2{color:var(--danger);}
  </style>

  <div class="page-head">
    <div>
      <h1>Profil Saya</h1>
      <p>Kelola informasi akun pribadimu.</p>
    </div>
  </div>

  <div class="pf-wrap">

    {{-- ===== AVATAR ===== --}}
    <div class="pf-card">
      <h2>Foto Profil</h2>
      <div class="desc">Unggah foto untuk mempersonalisasi akunmu. Format JPG/PNG, maksimal 2MB.</div>

      <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="phone" value="{{ $user->phone }}">
        <input type="hidden" name="position" value="{{ $user->position }}">

        <div class="pf-avatar-row">
          <div class="pf-avatar">
            @if($user->avatar)
              <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
            @else
              {{ strtoupper(substr($user->name,0,1)) }}
            @endif
          </div>
          <div class="pf-file-input">
            <input type="file" name="avatar" accept="image/jpeg,image/png,image/jpg">
            <div class="form-error">{{ $errors->first('avatar') }}</div>
            <button type="submit" class="btn btn-primary" style="margin-top:10px;">Unggah Foto</button>
          </div>
        </div>
      </form>
    </div>

    {{-- ===== INFO PROFIL ===== --}}
    <div class="pf-card">
      @include('profile.partials.update-profile-information-form')
    </div>

    {{-- ===== PASSWORD ===== --}}
    <div class="pf-card">
      @include('profile.partials.update-password-form')
    </div>

    {{-- ===== HAPUS AKUN ===== --}}
    <div class="pf-card danger-zone">
      @include('profile.partials.delete-user-form')
    </div>

  </div>
</x-app-layout>