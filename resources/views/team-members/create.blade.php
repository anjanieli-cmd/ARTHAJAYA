<x-app-layout>
  <x-slot name="title">Undang Anggota</x-slot>

  <style>
    .inv-wrap{display:grid;grid-template-columns:340px 1fr;gap:20px;max-width:960px;}
    .inv-side{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:24px;height:fit-content;}
    .inv-side h3{font-size:15px;margin-bottom:8px;}
    .inv-side p{font-size:12.5px;color:var(--text-mute);line-height:1.6;}
    .role-option{display:flex;align-items:flex-start;gap:10px;padding:12px;border-radius:12px;border:1px solid var(--border);margin-top:10px;cursor:pointer;}
    .role-option input{margin-top:3px;}
    .role-option .t{font-weight:600;font-size:13px;}
    .role-option .d{font-size:11.5px;color:var(--text-faint);}
    .inv-main{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:24px;}
    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
    .form-control{width:100%;padding:10px 14px;border-radius:12px;background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;}
    .perm-module{border-top:1px solid var(--border);padding:14px 0;}
    .perm-module .mh{font-weight:600;font-size:13px;margin-bottom:8px;}
    .perm-checks{display:flex;flex-wrap:wrap;gap:14px;}
    .perm-checks label{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text-mute);}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
  </style>

  <div class="page-head">
    <div><h1>Undang Anggota Baru</h1><p>Tambahkan anggota tim dan atur hak aksesnya.</p></div>
  </div>

  <form method="POST" action="{{ route('team-members.store') }}">
    @csrf
    <div class="inv-wrap">
      <div class="inv-side">
        <h3>Pilih Role</h3>
        <p>Role menentukan template awal hak akses. Kamu masih bisa mengubah detail izin di sebelah kanan.</p>
        @foreach(['Admin'=>'Akses penuh ke semua fitur.','Manager'=>'Kelola operasional harian.','Staff'=>'Input data transaksi.','Viewer'=>'Hanya bisa melihat data.'] as $role => $desc)
          <label class="role-option">
            <input type="radio" name="role" value="{{ $role }}" {{ old('role') == $role ? 'checked' : '' }} required>
            <span><div class="t">{{ $role }}</div><div class="d">{{ $desc }}</div></span>
          </label>
        @endforeach
        @error('role')<div style="color:var(--danger);font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
      </div>

      <div class="inv-main">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
          @error('name')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
          @error('email')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div style="font-size:13px;font-weight:600;margin-top:8px;">Hak Akses Detail</div>
        @foreach($modules as $key => $mod)
          <div class="perm-module">
            <div class="mh">{{ $mod['label'] }}</div>
            <div class="perm-checks">
              @foreach($mod['actions'] as $action)
                <label>
                  <input type="checkbox" name="permissions[]" value="{{ $key }}.{{ $action }}"
                    {{ in_array($key.'.'.$action, old('permissions', [])) ? 'checked' : '' }}>
                  {{ ucfirst($action) }}
                </label>
              @endforeach
            </div>
          </div>
        @endforeach

        <div style="display:flex;gap:12px;margin-top:20px;">
          <button type="submit" class="btn btn-primary">Kirim Undangan</button>
          <a href="{{ route('team-members.index') }}" class="btn btn-outline">Batal</a>
        </div>
      </div>
    </div>
  </form>
</x-app-layout>