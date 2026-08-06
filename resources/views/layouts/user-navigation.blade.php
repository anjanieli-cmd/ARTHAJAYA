<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <div class="logo-mark">
      <img src="{{ asset('logos.png') }}" alt="Logo">
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

<style>
  /* ===== SIDEBAR STYLES ===== */
  .sidebar {
    --theme-primary: var(--emerald);
    --theme-soft: rgba(var(--emerald-rgb), 0.12);
    
    background: var(--nav-bg);
    backdrop-filter: blur(16px);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    padding: 22px 16px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    transition: background .35s ease, border-color .35s ease;
    width: 250px;
    flex-shrink: 0;
  }

  .sidebar::-webkit-scrollbar { width: 4px; }
  .sidebar::-webkit-scrollbar-thumb { background: var(--border-hover); border-radius: 100px; }
  .sidebar::-webkit-scrollbar-track { background: transparent; }

  /* LOGO */
  .sb-logo {
    display: flex;
    align-items: center;
    gap: 11px;
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 18px;
    padding: 6px 8px 26px;
  }

  .logo-mark {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: var(--surface-strong);
    border: 1px solid var(--border-hover);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    padding: 4px;
  }

  .logo-mark img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .sb-wordmark {
    font-family: 'Inter', sans-serif;
    font-weight: 800;
    font-size: 17px;
    letter-spacing: -0.01em;
    white-space: nowrap;
    word-spacing: 0;
    display: inline-flex;
    align-items: baseline;
    color: var(--text);
  }

  .sb-wordmark .grad {
    background: linear-gradient(90deg, var(--emerald), var(--emerald-dim));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  /* GROUP LABEL */
  .sb-group-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--text-faint);
    padding: 16px 12px 8px;
    font-weight: 600;
  }

  /* LINK */
  .sb-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 12px;
    border-radius: 12px;
    font-size: 14px;
    color: var(--text-mute);
    margin-bottom: 2px;
    transition: all .2s ease;
    position: relative;
    text-decoration: none;
  }

  .sb-link:hover {
    color: var(--text);
    background: var(--surface);
  }

  .sb-link.active {
    color: var(--emerald);
    background: var(--theme-soft);
    font-weight: 600;
  }

  .sb-link .icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    color: currentColor;
  }

  .sb-link-main {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    flex: 1 1 auto;
  }

  .sb-link-text {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    min-width: 0;
  }

  .sb-link .badge {
    margin-left: auto;
    font-size: 10.5px;
    font-family: 'IBM Plex Mono', monospace;
    background: var(--surface-strong);
    color: var(--text-mute);
    padding: 2px 8px;
    border-radius: 100px;
    flex-shrink: 0;
  }

  .sb-link.active .badge {
    background: rgba(var(--emerald-rgb), 0.18);
    color: var(--emerald);
  }

  /* BOTTOM */
  .sb-bottom {
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid var(--border);
  }

  .sb-plan {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 10px;
  }

  .sb-plan .lbl {
    font-size: 10.5px;
    color: var(--text-faint);
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: .04em;
  }

  .sb-plan .name {
    font-size: 13.5px;
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: var(--text);
  }

  /* RESPONSIVE */
  @media (max-width: 980px) {
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 250px;
      z-index: 100;
      transform: translateX(-100%);
      transition: transform .3s cubic-bezier(.4,0,.2,1);
    }
    .sidebar.open {
      transform: translateX(0);
    }
  }

  @media (max-width: 640px) {
    .sidebar {
      padding: 16px 12px;
    }
    .sb-logo {
      padding-bottom: 18px;
    }
    .sb-wordmark {
      font-size: 15px;
    }
    .sb-link {
      padding: 9px 10px;
      font-size: 13px;
    }
    .sb-link .icon {
      width: 15px;
      height: 15px;
    }
  }

  /* Toggle button for mobile */
  .sidebar-toggle {
    display: none;
    position: fixed;
    top: 16px;
    left: 16px;
    z-index: 101;
    background: var(--nav-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 10px;
    cursor: pointer;
    color: var(--text);
    font-size: 20px;
    backdrop-filter: blur(12px);
  }

  @media (max-width: 980px) {
    .sidebar-toggle {
      display: block;
    }
  }
</style>

<script>
  // Simple mobile toggle - no active state overriding
  document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const toggleBtn = document.createElement('button');
    toggleBtn.className = 'sidebar-toggle';
    toggleBtn.innerHTML = '☰';
    toggleBtn.setAttribute('aria-label', 'Toggle sidebar');
    document.body.prepend(toggleBtn);
    
    const sidebar = document.getElementById('sidebar');
    
    toggleBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      sidebar.classList.toggle('open');
      toggleBtn.innerHTML = sidebar.classList.contains('open') ? '✕' : '☰';
    });
    
    // Close sidebar when clicking outside (on mobile)
    document.addEventListener('click', function(e) {
      if (window.innerWidth <= 980) {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
          sidebar.classList.remove('open');
          toggleBtn.innerHTML = '☰';
        }
      }
    });
  });
</script>