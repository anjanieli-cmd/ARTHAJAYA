<x-app-layout>
  <x-slot name="title">PPh - Pajak Penghasilan</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Data dari session (sudah passing $pphData dari controller)
    $pphData = $pphData ?? [
        ['period' => 'Januari 2026', 'gross' => 45000000, 'deduction' => 5000000, 'taxable' => 40000000, 'tax' => 1250000, 'status' => 'paid', 'due' => '2026-02-15'],
        ['period' => 'Februari 2026', 'gross' => 48000000, 'deduction' => 5200000, 'taxable' => 42800000, 'tax' => 1350000, 'status' => 'paid', 'due' => '2026-03-15'],
        ['period' => 'Maret 2026', 'gross' => 52000000, 'deduction' => 5500000, 'taxable' => 46500000, 'tax' => 1500000, 'status' => 'paid', 'due' => '2026-04-15'],
        ['period' => 'April 2026', 'gross' => 49000000, 'deduction' => 5300000, 'taxable' => 43700000, 'tax' => 1400000, 'status' => 'pending', 'due' => '2026-05-15'],
        ['period' => 'Mei 2026', 'gross' => 51000000, 'deduction' => 5400000, 'taxable' => 45600000, 'tax' => 1450000, 'status' => 'pending', 'due' => '2026-06-15'],
    ];

    $pphCollection = collect($pphData);
    $statusLabel = ['paid' => 'Dibayar', 'pending' => 'Pending'];
    $statusPill  = ['paid' => 'paid', 'pending' => 'pending'];

    $totalTax = $pphCollection->sum('tax');
    $totalPaid = $pphCollection->where('status', 'paid')->sum('tax');
    $totalPending = $pphCollection->where('status', 'pending')->sum('tax');
    $countPaid = $pphCollection->where('status', 'paid')->count();
    $countPending = $pphCollection->where('status', 'pending')->count();
  @endphp

  <style>
    .pph-wrap {
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

    .pph-wrap * { box-sizing: border-box; }
    .pph-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .pph-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .pph-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* SUCCESS MESSAGE */
    .pph-success {
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

    .pph-success .icon {
      width: 20px;
      height: 20px;
    }

    .pph-success .message {
      font-weight: 500;
    }

    /* HEADER */
    .pph-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .pph-header-left { flex: 1; min-width: 200px; }

    .pph-badge {
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

    .pph-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .pph-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .pph-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .pph-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    .pph-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .pph-btn {
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

    .pph-btn .icon { width: 16px; height: 16px; }
    .pph-btn:hover { transform: translateY(-2px); }
    .pph-btn:active { transform: translateY(0) scale(0.97); }

    .pph-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pph-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .pph-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .pph-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .pph-btn .ripple {
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

    /* TABS */
    .pph-tabs {
      display: flex;
      gap: 4px;
      margin-bottom: 24px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      padding: 4px;
    }

    .pph-tab {
      flex: 1;
      padding: 10px 16px;
      border: none;
      border-radius: var(--radius-sm);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.25s ease;
      background: transparent;
      color: var(--text-secondary);
      text-align: center;
    }

    .pph-tab:hover { color: var(--text-primary); background: var(--bg-card-hover); }
    .pph-tab.active { background: var(--theme-gradient); color: #fff; box-shadow: 0 4px 16px var(--theme-glow); }

    /* STATS RINGKASAN */
    .pph-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .pph-stat {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 18px 20px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .pph-stat:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .pph-stat .number {
      font-size: 24px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .pph-stat .number.green { color: var(--success); }
    .pph-stat .number.yellow { color: var(--warning); }
    .pph-stat .number.purple { color: var(--theme-primary); }

    .pph-stat .label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-top: 4px;
    }

    /* TIMELINE CARD */
    .pph-timeline {
      position: relative;
      padding-left: 30px;
    }

    .pph-timeline::before {
      content: '';
      position: absolute;
      left: 8px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: var(--border-color);
    }

    .pph-item {
      position: relative;
      margin-bottom: 20px;
      padding: 18px 20px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      transition: all 0.3s ease;
    }

    .pph-item:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
    }

    .pph-item::before {
      content: '';
      position: absolute;
      left: -26px;
      top: 24px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      border: 2px solid var(--border-color);
      background: var(--bg-card);
    }

    .pph-item.status-paid::before {
      background: var(--success);
      border-color: var(--success);
    }

    .pph-item.status-pending::before {
      background: var(--warning);
      border-color: var(--warning);
    }

    .pph-item .top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 12px;
    }

    .pph-item .top .period {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .pph-item .top .status {
      font-size: 11px;
      font-weight: 700;
      padding: 4px 14px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .pph-item .top .status.paid {
      background: var(--success-soft);
      color: var(--success);
    }

    .pph-item .top .status.pending {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .pph-item .details {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      padding: 12px 0;
      border-top: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
    }

    .pph-item .details .item .lbl {
      font-size: 10px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .pph-item .details .item .val {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      margin-top: 2px;
    }

    .pph-item .details .item .val.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .pph-item .footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 12px;
    }

    .pph-item .footer .due {
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .pph-item .footer .due strong { color: var(--text-secondary); }
    .pph-item .footer .due .overdue { color: var(--danger); }

    .pph-item .footer .actions {
      display: flex;
      gap: 8px;
    }

    .pph-item .footer .actions a {
      font-size: 12px;
      color: var(--text-tertiary);
      text-decoration: none;
      padding: 4px 12px;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .pph-item .footer .actions a:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    .pph-item .footer .actions a.primary:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    /* EMPTY */
    .pph-empty {
      text-align: center;
      padding: 60px 20px;
      background: var(--bg-card);
      border-radius: var(--radius-md);
      border: 2px dashed var(--border-color);
    }

    .pph-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .pph-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .pph-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    @media (max-width: 992px) {
      .pph-stats { grid-template-columns: 1fr 1fr; }
      .pph-item .details { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .pph-tabs { flex-direction: column; }
      .pph-tab { text-align: center; }
      .pph-item .top { flex-direction: column; }
      .pph-item .footer { flex-direction: column; gap: 10px; align-items: stretch; text-align: center; }
      .pph-item .footer .actions { justify-content: center; }
    }

    @media (max-width: 640px) {
      .pph-header { flex-direction: column; }
      .pph-actions { width: 100%; }
      .pph-actions .pph-btn { flex: 1; justify-content: center; }
      .pph-stats { grid-template-columns: 1fr; }
      .pph-item .details { grid-template-columns: 1fr; }
    }

    @media (max-width: 380px) {
      .pph-header h1 { font-size: 22px; }
      .pph-btn { font-size: 12px; padding: 8px 14px; }
      .pph-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="pph-wrap">

    <div class="pph-header animate-in" style="animation-delay: 0.05s;">
      <div class="pph-header-left">
        <div class="pph-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Pajak Penghasilan (PPh)</h1>
        <p class="subtitle">
          Kelola kewajiban PPh perusahaan — 
          <strong>{{ $pphCollection->count() }}</strong> periode pajak
        </p>
      </div>
      <div class="pph-actions">
        <a href="{{ route('taxes.ppn') }}" class="pph-btn pph-btn-ghost">
          <svg class="icon"><use href="#ic-invoice"/></svg>
          PPN
        </a>
        <a href="{{ route('tax-calendar.index') }}" class="pph-btn pph-btn-ghost">
          <svg class="icon"><use href="#ic-calendar"/></svg>
          Kalender Pajak
        </a>
        <a href="{{ route('taxes.pph.create') }}" class="pph-btn pph-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah PPh
        </a>
      </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->
    @if(session('success'))
      <div class="pph-success animate-in" style="animation-delay: 0.08s;">
        <svg class="icon"><use href="#ic-shield"/></svg>
        <span class="message">{{ session('success') }}</span>
      </div>
    @endif

    <!-- TABS -->
    <div class="pph-tabs animate-in" style="animation-delay: 0.10s;">
      <button class="pph-tab active">Semua</button>
      <button class="pph-tab">Dibayar</button>
      <button class="pph-tab">Pending</button>
    </div>

    <!-- STATS -->
    <div class="pph-stats animate-in" style="animation-delay: 0.15s;">
      <div class="pph-stat">
        <div class="number purple mono">{{ $currencySymbol }}{{ number_format($totalTax, 0, ',', '.') }}</div>
        <div class="label">Total PPh</div>
      </div>
      <div class="pph-stat">
        <div class="number green mono">{{ $currencySymbol }}{{ number_format($totalPaid, 0, ',', '.') }}</div>
        <div class="label">Sudah Dibayar</div>
      </div>
      <div class="pph-stat">
        <div class="number yellow mono">{{ $currencySymbol }}{{ number_format($totalPending, 0, ',', '.') }}</div>
        <div class="label">Belum Dibayar</div>
      </div>
      <div class="pph-stat">
        <div class="number">{{ $countPaid }} / {{ $pphCollection->count() }}</div>
        <div class="label">Periode Selesai</div>
      </div>
    </div>

    <!-- TIMELINE -->
    <div class="pph-timeline animate-in" style="animation-delay: 0.20s;">
      @forelse($pphData as $p)
        @php
          $dueDate = \Carbon\Carbon::parse($p['due']);
          $isOverdue = $dueDate->isPast() && $p['status'] == 'pending';
        @endphp
        <div class="pph-item status-{{ $p['status'] }}">
          <div class="top">
            <span class="period">{{ $p['period'] }}</span>
            <span class="status {{ $statusPill[$p['status']] }}">{{ $statusLabel[$p['status']] }}</span>
          </div>

          <div class="details">
            <div class="item">
              <div class="lbl">Penghasilan Bruto</div>
              <div class="val mono">{{ $currencySymbol }}{{ number_format($p['gross'], 0, ',', '.') }}</div>
            </div>
            <div class="item">
              <div class="lbl">Pengurang</div>
              <div class="val mono">{{ $currencySymbol }}{{ number_format($p['deduction'], 0, ',', '.') }}</div>
            </div>
            <div class="item">
              <div class="lbl">PKP</div>
              <div class="val mono">{{ $currencySymbol }}{{ number_format($p['taxable'], 0, ',', '.') }}</div>
            </div>
            <div class="item">
              <div class="lbl">PPh Terutang</div>
              <div class="val mono" style="color: var(--theme-primary);">{{ $currencySymbol }}{{ number_format($p['tax'], 0, ',', '.') }}</div>
            </div>
          </div>

          <div class="footer">
            <div class="due">
              Jatuh tempo: <strong>{{ \Carbon\Carbon::parse($p['due'])->translatedFormat('d F Y') }}</strong>
              @if($isOverdue)
                <span class="overdue">(Lewat jatuh tempo!)</span>
              @endif
            </div>
            <div class="actions">
              @if($p['status'] == 'pending')
                <a href="#" class="primary">Bayar</a>
              @endif
              <a href="#">Detail</a>
            </div>
          </div>
        </div>
      @empty
        <div class="pph-empty">
          <svg class="empty-icon"><use href="#ic-building"/></svg>
          <h3>Belum Ada Data PPh</h3>
          <p>Belum ada data PPh yang tercatat.</p>
          <a href="{{ route('taxes.pph.create') }}" class="pph-btn pph-btn-primary" style="display: inline-flex;">
            <svg class="icon"><use href="#ic-plus"/></svg>
            Tambah PPh
          </a>
        </div>
      @endforelse
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.pph-btn');
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

      // Tab switching
      const tabs = document.querySelectorAll('.pph-tab');
      tabs.forEach(tab => {
        tab.addEventListener('click', function() {
          tabs.forEach(t => t.classList.remove('active'));
          this.classList.add('active');
        });
      });
    });
  </script>
</x-app-layout>