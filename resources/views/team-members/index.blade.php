<x-app-layout>
  <x-slot name="title">Multi-User & Hak Akses</x-slot>

  <style>
    .tm-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
    .tm-stat{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:16px 18px;}
    .tm-stat .n{font-size:22px;font-weight:700;font-family:'Space Grotesk',sans-serif;}
    .tm-stat .l{font-size:12px;color:var(--text-mute);margin-top:2px;}
    .tm-filter{display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap;}
    .tm-filter input,.tm-filter select{padding:10px 14px;border-radius:12px;background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:13px;outline:none;}
    .tm-filter input{flex:1;min-width:200px;}
    .tm-list{display:flex;flex-direction:column;gap:10px;}
    .tm-row{display:flex;align-items:center;gap:16px;background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:16px 20px;transition:border-color .15s ease;}
    .tm-row:hover{border-color:var(--border-hover);}
    .tm-avatar{width:44px;height:44px;border-radius:12px;background:var(--surface-strong);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;flex-shrink:0;}
    .tm-info{flex:1;min-width:0;}
    .tm-name{font-weight:600;font-size:14px;}
    .tm-email{font-size:12.5px;color:var(--text-mute);}
    .tm-role-pill{padding:5px 12px;border-radius:100px;font-size:12px;font-weight:600;white-space:nowrap;}
    .role-Admin{background:rgba(var(--emerald-rgb),0.12);color:var(--emerald);}
    .role-Manager{background:rgba(78,143,240,0.12);color:var(--info);}
    .role-Staff{background:rgba(240,192,90,0.12);color:var(--warning);}
    .role-Viewer{background:var(--surface-strong);color:var(--text-mute);}
    .tm-status{font-size:12px;padding:4px 10px;border-radius:100px;white-space:nowrap;}
    .status-active{background:rgba(var(--emerald-rgb),0.12);color:var(--emerald);}
    .status-invited{background:rgba(78,143,240,0.12);color:var(--info);}
    .status-suspended{background:rgba(232,90,122,0.12);color:var(--danger);}
    .tm-perm-count{font-size:12px;color:var(--text-faint);white-space:nowrap;}
    .tm-actions{display:flex;gap:8px;flex-shrink:0;}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:9px 16px;border-radius:11px;font-size:12.5px;font-weight:600;cursor:pointer;border:none;}
    .btn-primary{background:var(--emerald);color:#052117;}
    .btn-outline{background:var(--surface);border:1px solid var(--border);color:var(--text);}
    .btn-outline:hover{background:var(--surface-strong);}
  </style>

  <div class="page-head">
    <div>
      <h1>Multi-User & Hak Akses</h1>
      <p>Kelola anggota tim dan tentukan hak akses masing-masing.</p>
    </div>
    <a href="{{ route('team-members.create') }}" class="btn btn-primary">
      <svg class="icon"><use href="#ic-plus"/></svg> Undang Anggota
    </a>
  </div>

  <div class="tm-stats">
    <div class="tm-stat"><div class="n mono">{{ $stats['total_count'] }}</div><div class="l">Total Anggota</div></div>
    <div class="tm-stat"><div class="n mono" style="color:var(--emerald)">{{ $stats['active_count'] }}</div><div class="l">Aktif</div></div>
    <div class="tm-stat"><div class="n mono" style="color:var(--info)">{{ $stats['invited_count'] }}</div><div class="l">Menunggu Konfirmasi</div></div>
    <div class="tm-stat"><div class="n mono" style="color:var(--danger)">{{ $stats['suspended_count'] }}</div><div class="l">Ditangguhkan</div></div>
  </div>

  <form method="GET" class="tm-filter">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email...">
    <select name="role">
      <option value="">Semua Role</option>
      @foreach(['Admin','Manager','Staff','Viewer'] as $r)
        <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ $r }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn btn-outline">Filter</button>
  </form>

  <div class="tm-list">
    @forelse($members as $member)
      <div class="tm-row">
        <div class="tm-avatar">{{ strtoupper(substr($member->name,0,1)) }}</div>
        <div class="tm-info">
          <div class="tm-name">{{ $member->name }}</div>
          <div class="tm-email">{{ $member->email }}</div>
        </div>
        <span class="tm-role-pill role-{{ $member->role }}">{{ $member->role }}</span>
        <span class="tm-status status-{{ $member->status }}">{{ ucfirst($member->status) }}</span>
        <span class="tm-perm-count">{{ $member->permissionCount() }} hak akses</span>
        <div class="tm-actions">
          <a href="{{ route('team-members.edit', $member) }}" class="btn btn-outline">Kelola</a>
          <form action="{{ route('team-members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline" style="color:var(--danger);">Hapus</button>
          </form>
        </div>
      </div>
    @empty
      <div class="tm-row" style="justify-content:center;color:var(--text-mute);padding:40px;">
        Belum ada anggota tim. Undang rekan kerja untuk mulai kolaborasi.
      </div>
    @endforelse
  </div>

  <div style="margin-top:18px;">{{ $members->links() }}</div>
</x-app-layout>