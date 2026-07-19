<x-app-layout>
  <x-slot name="title">Data Karyawan</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Data dari session (sudah passing $employees dari controller)
    $employees = $employees ?? [
        ['name' => 'Budi Santoso',      'position' => 'Pengrajin Batik', 'department' => 'Produksi', 'email' => 'budi@arthajaya.com', 'phone' => '0812-3456-7890', 'salary' => 4500000, 'status' => 'active', 'joined' => '2023-01-15'],
        ['name' => 'Siti Rahayu',        'position' => 'Desainer',        'department' => 'Kreatif',  'email' => 'siti@arthajaya.com', 'phone' => '0813-4567-8901', 'salary' => 5200000, 'status' => 'active', 'joined' => '2023-03-01'],
        ['name' => 'Agus Wijaya',        'position' => 'Marketing',       'department' => 'Marketing', 'email' => 'agus@arthajaya.com', 'phone' => '0814-5678-9012', 'salary' => 4800000, 'status' => 'active', 'joined' => '2023-06-10'],
        ['name' => 'Dewi Lestari',       'position' => 'Admin',           'department' => 'Operasional', 'email' => 'dewi@arthajaya.com', 'phone' => '0815-6789-0123', 'salary' => 4000000, 'status' => 'active', 'joined' => '2023-08-20'],
        ['name' => 'Hendra Gunawan',     'position' => 'Pengrajin Batik', 'department' => 'Produksi', 'email' => 'hendra@arthajaya.com', 'phone' => '0816-7890-1234', 'salary' => 4500000, 'status' => 'inactive', 'joined' => '2022-11-01'],
        ['name' => 'Rina Marlina',       'position' => 'Quality Control', 'department' => 'Produksi', 'email' => 'rina@arthajaya.com', 'phone' => '0817-8901-2345', 'salary' => 4200000, 'status' => 'active', 'joined' => '2024-01-05'],
    ];

    $employeesCollection = collect($employees);
    $statusLabel = ['active' => 'Aktif', 'inactive' => 'Tidak Aktif'];
    $statusPill  = ['active' => 'active', 'inactive' => 'inactive'];

    $totalEmployees = $employeesCollection->count();
    $totalActive    = $employeesCollection->where('status', 'active')->count();
    $totalInactive  = $employeesCollection->where('status', 'inactive')->count();
    $totalSalary    = $employeesCollection->sum('salary');
    $avgSalary      = $totalEmployees > 0 ? round($totalSalary / $totalEmployees) : 0;
    
    $departments = $employeesCollection->pluck('department')->unique()->values();
    
    // Fungsi helper untuk format tanggal
    function formatTanggal($date) {
        if (empty($date)) return '-';
        try {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
        } catch (\Exception $e) {
            return $date;
        }
    }
  @endphp

  <style>
    /* ============================================
       EMPLOYEES - LAYOUT BERBEDA (Profile Card Style)
       ============================================ */
    
    .emp-wrap {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .emp-wrap * { box-sizing: border-box; }
    .emp-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .emp-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .emp-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* SUCCESS MESSAGE */
    .emp-success {
      background: var(--success-soft);
      border: 1px solid var(--success);
      border-radius: var(--radius-sm);
      padding: 14px 20px;
      margin-bottom: 20px;
      color: var(--success);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .emp-success .icon {
      width: 20px;
      height: 20px;
    }

    .emp-success .message {
      font-weight: 500;
    }

    /* HEADER */
    .emp-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .emp-header-left { flex: 1; min-width: 200px; }

    .emp-badge {
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

    .emp-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .emp-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .emp-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .emp-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    .emp-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .emp-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: var(--radius-sm);
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      background: transparent;
      color: var(--text-secondary);
      position: relative;
      overflow: hidden;
    }

    .emp-btn .icon { width: 16px; height: 16px; }
    .emp-btn:hover { transform: translateY(-2px); }
    .emp-btn:active { transform: translateY(0) scale(0.97); }

    .emp-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .emp-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .emp-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .emp-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .emp-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    /* STATS ROW - Beda layout */
    .emp-stats {
      display: flex;
      gap: 16px;
      margin-bottom: 28px;
      flex-wrap: wrap;
    }

    .emp-stat {
      flex: 1;
      min-width: 160px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 18px 22px;
      display: flex;
      align-items: center;
      gap: 16px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .emp-stat:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .emp-stat .ic {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--theme-soft);
      color: var(--theme-primary);
      flex-shrink: 0;
    }

    .emp-stat .ic .icon { width: 20px; height: 20px; }

    .emp-stat .info .label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .emp-stat .info .value {
      font-size: 22px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .emp-stat .info .value.green { color: var(--success); }
    .emp-stat .info .value.red { color: var(--danger); }
    .emp-stat .info .value.purple { color: var(--theme-primary); }

    /* SEARCH & FILTER */
    .emp-toolbar {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 24px;
      flex-wrap: wrap;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      padding: 12px 20px;
    }

    .emp-toolbar .search {
      flex: 1;
      display: flex;
      align-items: center;
      gap: 10px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      padding: 8px 14px;
      transition: all 0.2s ease;
      min-width: 200px;
    }

    .emp-toolbar .search:focus-within {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .emp-toolbar .search .icon {
      width: 16px;
      height: 16px;
      color: var(--text-tertiary);
    }

    .emp-toolbar .search input {
      flex: 1;
      background: none;
      border: none;
      outline: none;
      color: var(--text-primary);
      font-size: 13px;
    }

    .emp-toolbar .search input::placeholder {
      color: var(--text-tertiary);
    }

    .emp-toolbar .filter-group {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .emp-toolbar .filter-group select {
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      padding: 8px 14px;
      color: var(--text-primary);
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      outline: none;
      transition: all 0.2s ease;
    }

    .emp-toolbar .filter-group select:hover { border-color: var(--border-hover); }
    .emp-toolbar .filter-group select:focus { border-color: var(--theme-primary); }

    /* PROFILE CARD GRID */
    .emp-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 16px;
    }

    .emp-profile {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px 20px 20px;
      text-align: center;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .emp-profile::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .emp-profile:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-4px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .emp-profile:hover::before { opacity: 1; }

    .emp-profile.status-active::before { background: var(--success); }
    .emp-profile.status-inactive::before { background: var(--danger); }

    .emp-profile .avatar-lg {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 28px;
      color: #fff;
      margin: 0 auto 12px;
      border: 3px solid var(--border-color);
      transition: border-color 0.3s ease;
    }

    .emp-profile:hover .avatar-lg {
      border-color: var(--theme-primary);
    }

    .emp-profile .name {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .emp-profile .position {
      font-size: 13px;
      color: var(--text-secondary);
      margin-top: 2px;
    }

    .emp-profile .dept {
      display: inline-block;
      font-size: 11px;
      font-weight: 500;
      padding: 3px 12px;
      border-radius: 100px;
      background: var(--bg-card-active);
      color: var(--text-secondary);
      border: 1px solid var(--border-color);
      margin-top: 8px;
    }

    .emp-profile .divider {
      border: none;
      border-top: 1px solid var(--border-color);
      margin: 14px 0;
    }

    .emp-profile .details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
      text-align: left;
      font-size: 12px;
    }

    .emp-profile .details .lbl {
      color: var(--text-tertiary);
    }

    .emp-profile .details .val {
      color: var(--text-secondary);
      font-weight: 500;
      text-align: right;
    }

    .emp-profile .details .val.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .emp-profile .status-badge {
      display: inline-block;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 14px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-top: 12px;
    }

    .emp-profile .status-badge.active {
      background: var(--success-soft);
      color: var(--success);
    }

    .emp-profile .status-badge.inactive {
      background: var(--danger-soft);
      color: var(--danger);
    }

    .emp-profile .actions {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid var(--border-color);
    }

    .emp-profile .actions a {
      font-size: 12px;
      color: var(--text-tertiary);
      text-decoration: none;
      padding: 4px 12px;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .emp-profile .actions a:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    .emp-profile .actions a.danger:hover {
      color: var(--danger);
      background: var(--danger-soft);
    }

    /* EMPTY */
    .emp-empty {
      text-align: center;
      padding: 60px 20px;
      background: var(--bg-card);
      border-radius: var(--radius-md);
      border: 2px dashed var(--border-color);
      grid-column: 1 / -1;
    }

    .emp-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .emp-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .emp-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .emp-stats { flex-direction: column; }
      .emp-stat { min-width: auto; }
      .emp-toolbar { flex-direction: column; align-items: stretch; }
      .emp-toolbar .search { min-width: auto; }
      .emp-toolbar .filter-group { justify-content: stretch; }
      .emp-toolbar .filter-group select { flex: 1; }
      .emp-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 640px) {
      .emp-header { flex-direction: column; }
      .emp-actions { width: 100%; }
      .emp-actions .emp-btn { flex: 1; justify-content: center; }
      .emp-grid { grid-template-columns: 1fr; }
      .emp-profile .details { grid-template-columns: 1fr; gap: 4px; }
      .emp-profile .details .val { text-align: left; }
    }

    @media (max-width: 380px) {
      .emp-header h1 { font-size: 22px; }
      .emp-btn { font-size: 12px; padding: 8px 14px; }
      .emp-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="emp-wrap">

    <div class="emp-header animate-in" style="animation-delay: 0.05s;">
      <div class="emp-header-left">
        <div class="emp-badge">
          <span class="dot"></span>
          HR &amp; Payroll
        </div>
        <h1>Data Karyawan</h1>
        <p class="subtitle">
          Kelola data karyawan perusahaan — 
          <strong>{{ $totalEmployees }}</strong> karyawan terdaftar
        </p>
      </div>
      <div class="emp-actions">
        <a href="{{ route('payroll.index') }}" class="emp-btn emp-btn-ghost">
          <svg class="icon"><use href="#ic-invoice"/></svg>
          Slip Gaji
        </a>
        <a href="{{ route('employees.create') }}" class="emp-btn emp-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah Karyawan
        </a>
      </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->
    @if(session('success'))
      <div class="emp-success animate-in" style="animation-delay: 0.08s;">
        <svg class="icon"><use href="#ic-shield"/></svg>
        <span class="message">{{ session('success') }}</span>
      </div>
    @endif

    <!-- STATS -->
    <div class="emp-stats animate-in" style="animation-delay: 0.10s;">
      <div class="emp-stat">
        <div class="ic"><svg class="icon"><use href="#ic-users"/></svg></div>
        <div class="info">
          <div class="label">Total Karyawan</div>
          <div class="value purple">{{ $totalEmployees }}</div>
        </div>
      </div>
      <div class="emp-stat">
        <div class="ic"><svg class="icon"><use href="#ic-shield"/></svg></div>
        <div class="info">
          <div class="label">Aktif</div>
          <div class="value green">{{ $totalActive }}</div>
        </div>
      </div>
      <div class="emp-stat">
        <div class="ic"><svg class="icon"><use href="#ic-close"/></svg></div>
        <div class="info">
          <div class="label">Tidak Aktif</div>
          <div class="value red">{{ $totalInactive }}</div>
        </div>
      </div>
      <div class="emp-stat">
        <div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>
        <div class="info">
          <div class="label">Total Gaji</div>
          <div class="value purple mono">{{ $currencySymbol }}{{ number_format($totalSalary, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>

    <!-- TOOLBAR -->
    <div class="emp-toolbar animate-in" style="animation-delay: 0.15s;">
      <div class="search">
        <svg class="icon"><use href="#ic-search"/></svg>
        <input type="text" placeholder="Cari karyawan..." id="searchEmployee">
      </div>
      <div class="filter-group">
        <select id="filterDepartment">
          <option value="">Semua Departemen</option>
          @foreach($departments as $dept)
            <option value="{{ $dept }}">{{ $dept }}</option>
          @endforeach
        </select>
        <select id="filterStatus">
          <option value="">Semua Status</option>
          <option value="active">Aktif</option>
          <option value="inactive">Tidak Aktif</option>
        </select>
      </div>
    </div>

    <!-- PROFILE GRID -->
    <div class="emp-grid">
      @forelse($employees as $e)
        @php
          $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
          $color = $colors[($loop->index + $loop->iteration) % count($colors)];
          $statusClass = $e['status'] == 'active' ? 'status-active' : 'status-inactive';
          
          // Format tanggal join
          $joined = formatTanggal($e['joined']);
        @endphp
        <div class="emp-profile {{ $statusClass }} animate-in" style="animation-delay: {{ 0.20 + ($loop->index * 0.04) }}s;">
          <div class="avatar-lg" style="background: {{ $color }};">
            {{ mb_substr($e['name'], 0, 1) }}
          </div>
          <div class="name">{{ $e['name'] }}</div>
          <div class="position">{{ $e['position'] }}</div>
          <span class="dept">{{ $e['department'] }}</span>

          <hr class="divider">

          <div class="details">
            <span class="lbl">Email</span>
            <span class="val">{{ $e['email'] }}</span>
            <span class="lbl">Telepon</span>
            <span class="val">{{ $e['phone'] }}</span>
            <span class="lbl">Bergabung</span>
            <span class="val">{{ $joined }}</span>
            <span class="lbl">Gaji</span>
            <span class="val mono">{{ $currencySymbol }}{{ number_format($e['salary'], 0, ',', '.') }}</span>
          </div>

          <span class="status-badge {{ $statusPill[$e['status']] }}">
            {{ $statusLabel[$e['status']] }}
          </span>

          <div class="actions">
            <a href="#">Edit</a>
            <a href="#" class="danger">Hapus</a>
          </div>
        </div>
      @empty
        <div class="emp-empty">
          <svg class="empty-icon"><use href="#ic-users"/></svg>
          <h3>Belum Ada Data Karyawan</h3>
          <p>Belum ada karyawan yang tercatat di sistem.</p>
          <a href="{{ route('employees.create') }}" class="emp-btn emp-btn-primary" style="display: inline-flex;">
            <svg class="icon"><use href="#ic-plus"/></svg>
            Tambah Karyawan Pertama
          </a>
        </div>
      @endforelse
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.emp-btn');
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          const rect = this.getBoundingClientRect();
          const ripple = document.createElement('span');
          ripple.className = 'ripple';
          const size = Math.max(rect.width, rect.height);
          ripple.style.width = ripple.style.height = size + 'px';
          ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
          ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
          this.appendChild(ripple);
          setTimeout(() => { ripple.remove(); }, 600);
        });
      });
    });
  </script>
</x-app-layout>