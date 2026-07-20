<x-app-layout>
  <x-slot name="title">Kelola Akses</x-slot>

  <style>
    .em-header{display:flex;align-items:center;gap:16px;background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:20px 24px;margin-bottom:20px;max-width:960px;}
    .em-avatar{width:56px;height:56px;border-radius:14px;background:var(--surface-strong);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:20px;}
    .em-name{font-size:17px;font-weight:700;}
    .em-email{font-size:13px;color:var(--text-mute);}
    .em-body{display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:960px;}
    .em-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:22px;}
    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
    .form-control{width:100%;padding:10px 14px;border-radius:12px;background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:13.5px;outline:none;}
    .perm-module{border-bottom:1px solid var(--border);padding:12px 0;}
    .perm-module:last-child{border-bottom:none;}
    .perm-module .mh{font-weight:600;font-size:13px;margin-bottom:8px;}
    .perm-checks{display:flex;flex-wrap:wrap;gap:14px;}
    .perm-checks label{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text-mute);}
    .danger-zone{border:1px solid rgba(232,90,122,0.3);border-radius:14px;padding:16px 18px;margin-top:20px;max-width:960px;}
    .danger-zone h4{color:var(--danger);font-size:13px;margin-bottom:4px;}
    .danger-zone p{font-size:12px;color:var(--text-mute);margin-bottom:10px;}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
    .btn-danger{background:transparent;border:1px solid var(--danger);color:var(--danger);}
  </style>

  <div class="page-head"><div><h1>Kelola Akses Anggota</h1><p>Perbarui role, status, dan hak akses detail.</p></div></div>

  <div class="em-header">
    <div class="em-avatar">{{ strtoupper(substr($teamMember->name,0,1)) }}</div>
    <div><div class="em-name">{{ $teamMember->name }}</div><div class="em-email">{{ $teamMember->email }}</div></div>
  </div>

  <form method="POST" action="{{ route('team-members.update', $teamMember) }}">
    @csrf @method('PUT')
    <div class="em-body">
      <div class="em-card">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name', $teamMember->name) }}" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $teamMember->email) }}" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-control" required>
            @foreach(['Admin','Manager','Staff','Viewer'] as $r)
              <option value="{{ $r }}" {{ old('role', $teamMember->role) == $r ? 'selected' : '' }}>{{ $r }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="active" {{ $teamMember->status == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="invited" {{ $teamMember->status == 'invited' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="suspended" {{ $teamMember->status == 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
          </select>
        </div>
      </div>

      <div class="em-card">
        @foreach($modules as $key => $mod)
          @php $current = old('permissions', $teamMember->permissions ?? []); @endphp
          <div class="perm-module">
            <div class="mh">{{ $mod['label'] }}</div>
            <div class="perm-checks">
              @foreach($mod['actions'] as $action)
                <label>
                  <input type="checkbox" name="permissions[]" value="{{ $key }}.{{ $action }}"
                    {{ in_array($key.'.'.$action, $current) ? 'checked' : '' }}>
                  {{ ucfirst($action) }}
                </label>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div style="display:flex;gap:12px;margin-top:20px;max-width:960px;">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('team-members.index') }}" class="btn btn-outline">Batal</a>
    </div>
  </form>

  <div class="danger-zone">
    <h4>Hapus Anggota</h4>
    <p>Anggota ini akan kehilangan seluruh akses ke sistem secara permanen.</p>
    <form action="{{ route('team-members.destroy', $teamMember) }}" method="POST" onsubmit="return confirm('Hapus anggota ini secara permanen?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn btn-danger">Hapus Anggota</button>
    </form>
  </div>
</x-app-layout>