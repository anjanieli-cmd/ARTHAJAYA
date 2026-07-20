<x-app-layout>
  <x-slot name="title">Slip Gaji</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Data dari session (sudah passing $payrolls dari controller)
    $payrolls = $payrolls ?? [
        ['employee' => 'Budi Santoso',      'position' => 'Pengrajin Batik', 'period' => 'Juli 2026', 'basic_salary' => 4500000, 'allowance' => 500000, 'deduction' => 150000, 'total' => 4850000, 'status' => 'paid'],
        ['employee' => 'Siti Rahayu',        'position' => 'Desainer',        'period' => 'Juli 2026', 'basic_salary' => 5200000, 'allowance' => 750000, 'deduction' => 200000, 'total' => 5750000, 'status' => 'paid'],
        ['employee' => 'Agus Wijaya',        'position' => 'Marketing',       'period' => 'Juli 2026', 'basic_salary' => 4800000, 'allowance' => 600000, 'deduction' => 180000, 'total' => 5220000, 'status' => 'pending'],
        ['employee' => 'Dewi Lestari',       'position' => 'Admin',           'period' => 'Juli 2026', 'basic_salary' => 4000000, 'allowance' => 400000, 'deduction' => 120000, 'total' => 4280000, 'status' => 'pending'],
        ['employee' => 'Hendra Gunawan',     'position' => 'Pengrajin Batik', 'period' => 'Juni 2026', 'basic_salary' => 4500000, 'allowance' => 500000, 'deduction' => 150000, 'total' => 4850000, 'status' => 'paid'],
        ['employee' => 'Rina Marlina',       'position' => 'Quality Control', 'period' => 'Juni 2026', 'basic_salary' => 4200000, 'allowance' => 450000, 'deduction' => 130000, 'total' => 4520000, 'status' => 'paid'],
    ];

    $payrollsCollection = collect($payrolls);
    $statusLabel = ['paid' => 'Dibayar', 'pending' => 'Pending'];
    $statusPill  = ['paid' => 'paid', 'pending' => 'pending'];

    $totalPayroll    = $payrollsCollection->sum('total');
    $totalPaid       = $payrollsCollection->where('status', 'paid')->sum('total');
    $totalPending    = $payrollsCollection->where('status', 'pending')->sum('total');
    $countPending    = $payrollsCollection->where('status', 'pending')->count();
    $countPaid       = $payrollsCollection->where('status', 'paid')->count();
    
    $periods = $payrollsCollection->pluck('period')->unique()->sort()->reverse()->values();
    $currentPeriod = $periods->first() ?? 'Juli 2026';
  @endphp

  <style>
    /* ============================================
       PAYROLL - LAYOUT BERBEDA (Card Grid Style)
       ============================================ */
    
    .payroll-wrap {
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
      
      --warning: #F0A83C;
      --warning-soft: rgba(240, 168, 60, 0.14);
      
      --danger: #E85A5A;
      --danger-soft: rgba(232, 90, 90, 0.12);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .payroll-wrap * { box-sizing: border-box; }
    .payroll-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .payroll-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .payroll-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* SUCCESS MESSAGE */
    .pay-success {
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

    .pay-success .icon {
      width: 20px;
      height: 20px;
    }

    .pay-success .message {
      font-weight: 500;
    }

    /* HEADER */
    .pay-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .pay-header-left { flex: 1; min-width: 200px; }

    .pay-badge {
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

    .pay-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .pay-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .pay-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .pay-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    .pay-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .pay-btn {
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

    .pay-btn .icon { width: 16px; height: 16px; }
    .pay-btn:hover { transform: translateY(-2px); }
    .pay-btn:active { transform: translateY(0) scale(0.97); }

    .pay-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pay-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .pay-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .pay-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .pay-btn .ripple {
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

    /* HERO CARD */
    .pay-hero {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      padding: 28px 32px;
      margin-bottom: 28px;
      position: relative;
      overflow: hidden;
    }

    .pay-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: var(--theme-gradient);
    }

    .pay-hero-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      gap: 20px;
    }

    .pay-hero-item .label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 4px;
    }

    .pay-hero-item .value {
      font-size: 24px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .pay-hero-item .value.green { color: var(--success); }
    .pay-hero-item .value.yellow { color: var(--warning); }
    .pay-hero-item .value.purple { color: var(--theme-primary); }

    .pay-hero-item .sub {
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 2px;
    }

    /* FILTER BAR */
    .pay-filter {
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

    .pay-filter .label {
      font-size: 12px;
      color: var(--text-tertiary);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .pay-filter select {
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      padding: 8px 16px;
      color: var(--text-primary);
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      outline: none;
      transition: all 0.2s ease;
    }

    .pay-filter select:hover { border-color: var(--border-hover); }
    .pay-filter select:focus { border-color: var(--theme-primary); }

    .pay-filter .info {
      margin-left: auto;
      font-size: 13px;
      color: var(--text-secondary);
    }

    .pay-filter .info strong { color: var(--text-primary); }

    /* CARD GRID - LAYOUT BERBEDA */
    .pay-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
      gap: 16px;
    }

    .pay-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 22px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .pay-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .pay-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-4px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .pay-card:hover::before { opacity: 1; }

    .pay-card.status-paid::before { background: var(--success); }
    .pay-card.status-pending::before { background: var(--warning); }

    .pay-card-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 14px;
    }

    .pay-card-emp {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .pay-card-emp .avatar {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 16px;
      color: #fff;
      flex-shrink: 0;
    }

    .pay-card-emp .info .name {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .pay-card-emp .info .position {
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 2px;
    }

    .pay-card-status {
      font-size: 10px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .pay-card-status.paid {
      background: var(--success-soft);
      color: var(--success);
    }

    .pay-card-status.pending {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .pay-card-details {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 12px;
      padding: 14px 0;
      border-top: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
      margin-bottom: 14px;
    }

    .pay-card-details .item .lbl {
      font-size: 10px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .pay-card-details .item .val {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      margin-top: 2px;
    }

    .pay-card-details .item .val.danger { color: var(--danger); }

    .pay-card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .pay-card-footer .period {
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .pay-card-footer .period strong { color: var(--text-secondary); }

    .pay-card-footer .actions {
      display: flex;
      gap: 6px;
    }

    .pay-card-footer .actions a {
      font-size: 12px;
      color: var(--text-tertiary);
      text-decoration: none;
      padding: 4px 10px;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .pay-card-footer .actions a:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    .pay-card-footer .actions a.primary:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    .pay-card-footer .actions a.success:hover {
      color: var(--success);
      background: var(--success-soft);
    }

    /* EMPTY */
    .pay-empty {
      text-align: center;
      padding: 60px 20px;
      background: var(--bg-card);
      border-radius: var(--radius-md);
      border: 2px dashed var(--border-color);
      grid-column: 1 / -1;
    }

    .pay-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .pay-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .pay-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    @media (max-width: 1200px) {
      .pay-hero-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .pay-hero { padding: 20px; }
      .pay-hero-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
      .pay-hero-item .value { font-size: 20px; }
      .pay-grid { grid-template-columns: 1fr; }
      .pay-filter { flex-direction: column; align-items: stretch; gap: 10px; }
      .pay-filter .info { margin-left: 0; text-align: center; }
    }

    @media (max-width: 640px) {
      .pay-header { flex-direction: column; }
      .pay-actions { width: 100%; }
      .pay-actions .pay-btn { flex: 1; justify-content: center; }
      .pay-hero-grid { grid-template-columns: 1fr; }
      .pay-card-details { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 380px) {
      .pay-header h1 { font-size: 22px; }
      .pay-btn { font-size: 12px; padding: 8px 14px; }
      .pay-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="payroll-wrap">

    <div class="pay-header animate-in" style="animation-delay: 0.05s;">
      <div class="pay-header-left">
        <div class="pay-badge">
          <span class="dot"></span>
          HR &amp; Payroll
        </div>
        <h1>Slip Gaji</h1>
        <p class="subtitle">
          Kelola gaji dan slip gaji karyawan — 
          <strong>{{ $payrollsCollection->count() }}</strong> slip gaji
        </p>
      </div>
      <div class="pay-actions">
        <a href="{{ route('employees.index') }}" class="pay-btn pay-btn-ghost">
          <svg class="icon"><use href="#ic-users"/></svg>
          Data Karyawan
        </a>
        <a href="{{ route('payroll.create') }}" class="pay-btn pay-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Buat Payroll
        </a>
      </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->
    @if(session('success'))
      <div class="pay-success animate-in" style="animation-delay: 0.08s;">
        <svg class="icon"><use href="#ic-shield"/></svg>
        <span class="message">{{ session('success') }}</span>
      </div>
    @endif

    <!-- HERO -->
    <div class="pay-hero animate-in" style="animation-delay: 0.10s;">
      <div class="pay-hero-grid">
        <div class="pay-hero-item">
          <div class="label">Total Payroll</div>
          <div class="value purple mono">{{ $currencySymbol }}{{ number_format($totalPayroll, 0, ',', '.') }}</div>
          <div class="sub">{{ $payrollsCollection->count() }} slip gaji</div>
        </div>
        <div class="pay-hero-item">
          <div class="label">Sudah Dibayar</div>
          <div class="value green mono">{{ $currencySymbol }}{{ number_format($totalPaid, 0, ',', '.') }}</div>
          <div class="sub">{{ $countPaid }} slip gaji</div>
        </div>
        <div class="pay-hero-item">
          <div class="label">Menunggu Pembayaran</div>
          <div class="value yellow mono">{{ $currencySymbol }}{{ number_format($totalPending, 0, ',', '.') }}</div>
          <div class="sub">{{ $countPending }} slip gaji</div>
        </div>
        <div class="pay-hero-item">
          <div class="label">Rata-rata Gaji</div>
          <div class="value mono">{{ $payrollsCollection->count() > 0 ? $currencySymbol . number_format(round($totalPayroll / $payrollsCollection->count()), 0, ',', '.') : $currencySymbol . '0' }}</div>
          <div class="sub">Per karyawan</div>
        </div>
      </div>
    </div>

    <!-- FILTER -->
    <div class="pay-filter animate-in" style="animation-delay: 0.15s;">
      <span class="label">Periode</span>
      <select id="periodFilter">
        @foreach($periods as $period)
          <option value="{{ $period }}" {{ $period == $currentPeriod ? 'selected' : '' }}>
            {{ $period }}
          </option>
        @endforeach
      </select>
      <span class="info">
        Menampilkan <strong>{{ $payrollsCollection->where('period', $currentPeriod)->count() }}</strong> 
        slip gaji untuk periode <strong>{{ $currentPeriod }}</strong>
      </span>
    </div>

    <!-- CARD GRID -->
    <div class="pay-grid">
      @forelse($payrolls as $p)
        @php
          $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
          $color = $colors[($loop->index + $loop->iteration) % count($colors)];
          $statusClass = $p['status'] == 'paid' ? 'status-paid' : 'status-pending';
        @endphp
        <div class="pay-card {{ $statusClass }} animate-in" style="animation-delay: {{ 0.20 + ($loop->index * 0.04) }}s;">
          <div class="pay-card-top">
            <div class="pay-card-emp">
              <div class="avatar" style="background: {{ $color }};">
                {{ mb_substr($p['employee'], 0, 1) }}
              </div>
              <div class="info">
                <div class="name">{{ $p['employee'] }}</div>
                <div class="position">{{ $p['position'] }}</div>
              </div>
            </div>
            <span class="pay-card-status {{ $statusPill[$p['status']] }}">
              {{ $statusLabel[$p['status']] }}
            </span>
          </div>

          <div class="pay-card-details">
            <div class="item">
              <div class="lbl">Gaji Pokok</div>
              <div class="val mono">{{ $currencySymbol }}{{ number_format($p['basic_salary'], 0, ',', '.') }}</div>
            </div>
            <div class="item">
              <div class="lbl">Tunjangan</div>
              <div class="val mono">{{ $currencySymbol }}{{ number_format($p['allowance'], 0, ',', '.') }}</div>
            </div>
            <div class="item">
              <div class="lbl">Potongan</div>
              <div class="val mono danger">-{{ $currencySymbol }}{{ number_format($p['deduction'], 0, ',', '.') }}</div>
            </div>
          </div>

          <div class="pay-card-footer">
            <div class="period">
              Periode <strong>{{ $p['period'] }}</strong>
            </div>
            <div class="actions">
              @if($p['status'] == 'pending')
                <a href="#" class="primary">Bayar</a>
              @endif
              <a href="#" class="success">Slip</a>
            </div>
          </div>
        </div>
      @empty
        <div class="pay-empty">
          <svg class="empty-icon"><use href="#ic-invoice"/></svg>
          <h3>Belum Ada Slip Gaji</h3>
          <p>Belum ada slip gaji yang tercatat di sistem.</p>
          <a href="{{ route('payroll.create') }}" class="pay-btn pay-btn-primary" style="display: inline-flex;">
            <svg class="icon"><use href="#ic-plus"/></svg>
            Buat Slip Gaji Pertama
          </a>
        </div>
      @endforelse
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.pay-btn');
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