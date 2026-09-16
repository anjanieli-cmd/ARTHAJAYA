<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <div class="logo-mark">
      @php
        $company = Auth::user()?->company;
      @endphp
      <img src="{{ asset('logos.png') }}" alt="{{ $company->name ?? 'Arvessa' }}">
    </div>
    <span class="sb-wordmark">Arve<span class="grad">ssa</span></span>
  </div>

  <div class="sb-group-label">Menu</div>

  <!-- Dashboard -->

  <a href="{{ route('user.dashboard') }}" class="sb-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
    <span class="sb-link-main">
      <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/>
      </svg>
      <span class="sb-link-text">Dashboard</span>
    </span>
  </a>

  <!-- Ajukan Pengeluaran -> CREATE -->

  <a href="{{ route('user.expenses.create') }}" class="sb-link {{ request()->routeIs('user.expenses.create') ? 'active' : '' }}">
    <span class="sb-link-main">
      <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="22" y1="2" x2="11" y2="13"/>
        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
      </svg>
      <span class="sb-link-text">Ajukan Pengeluaran</span>
    </span>
  </a>

  <!-- Riwayat Pengeluaran -> INDEX -->

  <a href="{{ route('user.expenses.index') }}" class="sb-link {{ request()->routeIs('user.expenses.index') ? 'active' : '' }}">
    <span class="sb-link-main">
      <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
      </svg>
      <span class="sb-link-text">Riwayat Pengeluaran</span>
    </span>
    @if(($pendingCount ?? 0) > 0)
      <span class="badge">{{ $pendingCount }}</span>
    @endif
  </a>

  <!-- Ringkasan Kas -> SUMMARY -->

  <a href="{{ route('user.expenses.summary') }}" class="sb-link {{ request()->routeIs('user.expenses.summary') ? 'active' : '' }}">
    <span class="sb-link-main">
      <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="2" y="10" width="20" height="12" rx="2"/>
        <line x1="12" y1="2" x2="12" y2="10"/>
        <line x1="6" y1="6" x2="6" y2="10"/>
        <line x1="18" y1="6" x2="18" y2="10"/>
      </svg>
      <span class="sb-link-text">Ringkasan Kas</span>
    </span>
  </a>

  <div class="sb-group-label">Akun</div>

  <!-- Profil Saya -->

  <a href="{{ route('user.profile') }}" class="sb-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
    <span class="sb-link-main">
      <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      <span class="sb-link-text">Profil Saya</span>
    </span>
  </a>

  <div class="sb-bottom">
    <div class="sb-plan">
      <div class="lbl">Masuk sebagai</div>
      <div class="name">{{ Auth::user()->name ?? 'Pengguna' }}</div>
      <div style="font-size:11px;color:var(--text-faint);margin-top:2px;display:flex;align-items:center;gap:4px;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        User
      </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="sb-link" style="width:100%;border:none;background:none;cursor:pointer;color:var(--danger);">
        <span class="sb-link-main">
          <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
          </svg>
          <span class="sb-link-text">Keluar</span>
        </span>
      </button>
    </form>
  </div>
</aside>