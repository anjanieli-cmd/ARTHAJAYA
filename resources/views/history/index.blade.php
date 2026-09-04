<x-app-layout>
  <x-slot name="title">Riwayat Aktivitas</x-slot>

  @php
    $actionLabel = ['created' => 'Dibuat', 'updated' => 'Diupdate', 'deleted' => 'Dihapus'];
    $actionColorVar = ['created' => 'var(--success)', 'updated' => 'var(--warning)', 'deleted' => 'var(--danger)'];
    $actionIcon = ['created' => 'ic-plus', 'updated' => 'ic-edit', 'deleted' => 'ic-trash'];
  @endphp

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </symbol>
      <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </symbol>
      <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
      </symbol>
      <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
      </symbol>
      <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
      </symbol>
      <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
      </symbol>
      <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
      </symbol>
    </defs>
  </svg>

  <style>
    /* ============================================
       RIWAYAT AKTIVITAS - Clean & Modern Design
       ============================================ */

    .history-modern {
      --theme-primary: var(--emerald);
      --theme-light: var(--emerald);
      --theme-dark: var(--emerald-dim);
      --theme-glow: rgba(var(--emerald-rgb), 0.25);
      --theme-soft: rgba(var(--emerald-rgb), 0.12);
      --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));

      --text-primary: var(--text);
      --text-secondary: var(--text-mute);
      --text-tertiary: var(--text-faint);

      --bg-card: var(--surface);
      --bg-card-hover: var(--surface-strong);
      --bg-card-active: rgba(255, 255, 255, 0.04);
      --border-color: var(--border);
      --border-hover: var(--border-hover);

      --success: #34B583;
      --success-soft: rgba(52, 181, 131, 0.14);
      --danger: #E85A5A;
      --danger-soft: rgba(232, 90, 90, 0.12);
      --warning: #F0A83C;
      --warning-soft: rgba(240, 168, 60, 0.14);

      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;

      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
      padding: 0 24px;
    }

    .history-modern * { box-sizing: border-box; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .history-modern .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .history-modern .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* ===== HEADER ===== */
    .history-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .history-header-left { flex: 1; min-width: 200px; }

    .history-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 14px 6px 10px;
      background: var(--theme-glow);
      border: 1px solid var(--theme-glow);
      border-radius: 100px;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--theme-primary);
      margin-bottom: 12px;
    }

    .history-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .history-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .history-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .history-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    /* ===== FILTER BAR ===== */
    .filter-bar {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      padding: 12px 20px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }

    .filter-bar:focus-within {
      border-color: var(--theme-primary);
      box-shadow: 0 0 0 3px var(--theme-soft);
    }

    .filter-bar form {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
      width: 100%;
    }

    .search-wrap {
      position: relative;
      flex: 1;
      min-width: 220px;
    }

    .search-wrap .icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      color: var(--text-tertiary);
      pointer-events: none;
      transition: color 0.3s ease;
    }

    .search-wrap:focus-within .icon { color: var(--theme-primary); }

    .filter-bar input[type="text"] {
      width: 100%;
      padding: 10px 16px 10px 42px;
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      border: 1px solid transparent;
      color: var(--text-primary);
      font-size: 13px;
      outline: none;
      transition: all 0.3s ease;
      font-family: inherit;
    }

    .filter-bar input[type="text"]:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card);
      box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
    }

    .filter-bar input[type="text"]::placeholder { color: var(--text-tertiary); }

    .filter-bar select {
      padding: 10px 14px;
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      border: 1px solid transparent;
      color: var(--text-primary);
      font-size: 13px;
      outline: none;
      font-family: inherit;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .filter-bar select:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card);
      box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
    }

    .filter-actions { display: flex; gap: 8px; align-items: center; }

    .history-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      border-radius: var(--radius-sm);
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      font-family: 'Inter', sans-serif;
    }

    .history-btn .icon { width: 16px; height: 16px; }
    .history-btn:hover { transform: translateY(-2px); }

    .history-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .history-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .history-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    /* ===== FLASH MESSAGES ===== */
    .history-flash {
      border-radius: var(--radius-sm);
      padding: 14px 20px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 500;
    }

    /* ===== ACTIVITY LIST ===== */
    .history-list {
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      overflow: hidden;
      background: var(--bg-card);
    }

    .history-row {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 16px 20px;
      border-bottom: 1px solid var(--border-color);
      transition: background 0.2s ease;
    }

    .history-row:last-child { border-bottom: none; }
    .history-row:hover { background: var(--bg-card-hover); }

    .history-row .action-icon {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .history-row .action-icon .icon { width: 18px; height: 18px; }

    .history-row .body { flex: 1; min-width: 0; }

    .history-row .desc {
      font-weight: 600;
      font-size: 14px;
      color: var(--text-primary);
      overflow-wrap: anywhere;
    }

    .history-row .meta {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 3px;
    }

    .history-row .meta .icon { width: 12px; height: 12px; }

    .history-row .status {
      font-size: 10px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      white-space: nowrap;
      flex-shrink: 0;
    }

    /* ===== EMPTY ===== */
    .history-empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-tertiary);
    }

    .history-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .history-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .history-empty p {
      color: var(--text-secondary);
      margin: 0;
      font-size: 14px;
    }

    /* ===== PAGINATION ===== */
    .history-pagination { margin-top: 20px; }
    .history-pagination nav { color: var(--text-secondary); }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
      .history-modern { padding: 0 12px; }
      .filter-bar { flex-direction: column; align-items: stretch; gap: 10px; padding: 12px 16px; }
      .filter-bar form { flex-direction: column; }
      .search-wrap { min-width: 100%; }
      .filter-bar select { width: 100%; }
      .filter-actions { width: 100%; justify-content: flex-end; flex-wrap: wrap; }
      .history-row { flex-wrap: wrap; }
      .history-row .status { margin-left: 52px; }
    }

    @media (max-width: 640px) {
      .history-header { flex-direction: column; }
      .history-row .desc { font-size: 13px; }
    }
  </style>

  <div class="history-modern">

    <!-- ===== HEADER ===== -->
    <div class="history-header animate-in" style="animation-delay: 0.05s;">
      <div class="history-header-left">
        <div class="history-badge">
          <span class="dot"></span>
          Aktivitas
        </div>
        <h1>Riwayat Aktivitas</h1>
        <p class="subtitle">
          Semua perubahan data yang tercatat di perusahaan kamu —
          <strong>{{ $activities->total() }}</strong> aktivitas
        </p>
      </div>
    </div>

    <!-- ===== FLASH MESSAGES ===== -->
    @if(session('success'))
      <div class="history-flash animate-in" style="animation-delay: 0.08s; background: var(--success-soft); border: 1px solid var(--success); color: var(--success);">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="history-flash animate-in" style="animation-delay: 0.08s; background: var(--danger-soft); border: 1px solid var(--danger); color: var(--danger);">
        {{ session('error') }}
      </div>
    @endif

    <!-- ===== FILTER BAR ===== -->
    <div class="filter-bar animate-in" style="animation-delay: 0.09s;">
      <form method="GET" action="{{ route('history.index') }}">
        <div class="search-wrap">
          <svg class="icon"><use href="#ic-search"/></svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari aktivitas..." autocomplete="off">
        </div>
        <select name="action">
          <option value="">Semua Aksi</option>
          <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Dibuat</option>
          <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Diupdate</option>
          <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>Dihapus</option>
        </select>
        <div class="filter-actions">
          <button type="submit" class="history-btn history-btn-primary">
            <svg class="icon"><use href="#ic-search"/></svg>
            Cari
          </button>
          @if(request()->filled('q') || request()->filled('action'))
            <a href="{{ route('history.index') }}" class="history-btn history-btn-ghost">
              <svg class="icon"><use href="#ic-x"/></svg>
              Reset
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- ===== ACTIVITY LIST ===== -->
    @if($activities->isEmpty())
      <div class="history-empty animate-in" style="animation-delay: 0.15s;">
        <svg class="empty-icon"><use href="#ic-clock"/></svg>
        <h3>Belum Ada Aktivitas</h3>
        <p>
          @if(request()->filled('q') || request()->filled('action'))
            Tidak ditemukan aktivitas yang sesuai dengan pencarian kamu.
          @else
            Belum ada aktivitas tercatat di sistem.
          @endif
        </p>
      </div>
    @else
      <div class="history-list animate-in" style="animation-delay: 0.15s;">
        @foreach($activities as $log)
          @php
            $color = $actionColorVar[$log->action] ?? 'var(--theme-primary)';
            $soft = match($log->action) {
              'created' => 'var(--success-soft)',
              'deleted' => 'var(--danger-soft)',
              'updated' => 'var(--warning-soft)',
              default => 'var(--theme-soft)',
            };
            $icon = $actionIcon[$log->action] ?? 'ic-clock';
            $label = $actionLabel[$log->action] ?? $log->action;
          @endphp
          <div class="history-row">
            <div class="action-icon" style="background: {{ $soft }}; color: {{ $color }};">
              <svg class="icon"><use href="#{{ $icon }}"/></svg>
            </div>
            <div class="body">
              <div class="desc">{{ $log->description }}</div>
              <div class="meta">
                <svg class="icon"><use href="#ic-user"/></svg>
                {{ $log->user->name ?? 'System' }}
                &middot;
                {{ $log->created_at->format('d M Y, H:i') }}
              </div>
            </div>
            <span class="status" style="background: {{ $soft }}; color: {{ $color }};">
              {{ $label }}
            </span>
          </div>
        @endforeach
      </div>

      <div class="history-pagination">
        {{ $activities->appends(request()->query())->links() }}
      </div>
    @endif

  </div>
</x-app-layout>