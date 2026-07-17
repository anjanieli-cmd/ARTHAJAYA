<x-app-layout>
  <x-slot name="title">Piutang Usaha (AR)</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query Invoice/Receivable model nanti
    $receivables = [
        ['client' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'date' => '2026-06-10', 'due' => '2026-07-10', 'status' => 'lancar', 'amount' => 5750000],
        ['client' => 'Nusantara Logistik',      'invoice' => '#0571', 'date' => '2026-06-15', 'due' => '2026-06-25', 'status' => 'lancar', 'amount' => 18400000],
        ['client' => 'Ruang Kriya Studio',      'invoice' => '#0574', 'date' => '2026-06-18', 'due' => '2026-06-28', 'status' => 'lancar', 'amount' => 6200000],
        ['client' => 'Bumi Retail Group',       'invoice' => '#0552', 'date' => '2026-05-25', 'due' => '2026-06-02', 'status' => 'jatuh_tempo', 'amount' => 9200000],
        ['client' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'date' => '2026-06-01', 'due' => '2026-06-15', 'status' => 'jatuh_tempo', 'amount' => 2800000],
        ['client' => 'Warung Sinar Abadi',      'invoice' => '#0541', 'date' => '2026-05-20', 'due' => '2026-05-28', 'status' => 'lunas', 'amount' => 4100000],
    ];

    $receivablesCollection = collect($receivables);
    $statusLabel = ['lancar' => 'Lancar', 'jatuh_tempo' => 'Jatuh Tempo', 'lunas' => 'Lunas'];
    $statusPill  = ['lancar' => 'lancar', 'jatuh_tempo' => 'jatuh_tempo', 'lunas' => 'lunas'];

    $totalPiutang   = $receivablesCollection->whereIn('status', ['lancar', 'jatuh_tempo'])->sum('amount');
    $totalJatuhTempo = $receivablesCollection->where('status', 'jatuh_tempo')->sum('amount');
    $totalLancar    = $receivablesCollection->where('status', 'lancar')->sum('amount');
    $totalLunas     = $receivablesCollection->where('status', 'lunas')->sum('amount');
    $countJatuhTempo = $receivablesCollection->where('status', 'jatuh_tempo')->count();
    $countLancar    = $receivablesCollection->where('status', 'lancar')->count();
    $countLunas     = $receivablesCollection->where('status', 'lunas')->count();
    
    // Fungsi helper untuk format tanggal
    function formatTanggal($date) {
        if (empty($date)) return '-';
        try {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
        } catch (\Exception $e) {
            return $date;
        }
    }
    
    function isOverdue($dueDate, $status) {
        if ($status === 'lunas') return false;
        try {
            return \Carbon\Carbon::parse($dueDate)->isPast();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    // Data untuk chart
    $chartData = [
      'lancar' => ['label' => 'Lancar', 'value' => $totalLancar, 'color' => 'var(--theme-primary)'],
      'jatuh_tempo' => ['label' => 'Jatuh Tempo', 'value' => $totalJatuhTempo, 'color' => 'var(--danger)'],
      'lunas' => ['label' => 'Lunas', 'value' => $totalLunas, 'color' => 'var(--text-faint)'],
    ];
  @endphp

  <style>
    /* ============================================
       PIUTANG USAHA (AR) - Modern Card Layout
       ============================================ */
    
    .ar-modern {
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
      
      --danger: #E85A5A;
      --danger-soft: rgba(232, 90, 90, 0.12);
      --danger-glow: rgba(232, 90, 90, 0.20);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .ar-modern * {
      box-sizing: border-box;
    }

    .ar-modern .mono {
      font-family: 'IBM Plex Mono', monospace;
      font-variant-numeric: tabular-nums;
      letter-spacing: -0.02em;
    }

    /* ----- ANIMATIONS ----- */
    @keyframes fadeSlideUp {
      from {
        opacity: 0;
        transform: translateY(16px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    @keyframes countUp {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .ar-modern .animate-in {
      animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      opacity: 0;
    }

    /* ----- SVG ICON BASE ----- */
    .ar-modern .icon {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
      display: inline-block;
      vertical-align: middle;
      fill: none;
      stroke: currentColor;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    /* ----- HEADER SECTION ----- */
    .ar-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .ar-header-left {
      flex: 1;
      min-width: 200px;
    }

    .ar-badge {
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

    .ar-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .ar-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .ar-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .ar-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .ar-header-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .ar-btn {
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

    .ar-btn .icon {
      width: 16px;
      height: 16px;
    }

    .ar-btn:hover {
      transform: translateY(-2px);
    }

    .ar-btn:active {
      transform: translateY(0) scale(0.97);
    }

    .ar-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .ar-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .ar-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .ar-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .ar-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    @keyframes rippleAnim {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }

    /* ----- STATS ROW ----- */
    .ar-stats-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 28px;
    }

    .ar-stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 22px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .ar-stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--theme-light), transparent);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .ar-stat-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .ar-stat-card:hover::before {
      opacity: 1;
    }

    .ar-stat-card .stat-label {
      font-size: 11.5px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .ar-stat-card .stat-label .icon {
      width: 14px;
      height: 14px;
    }

    .ar-stat-card .stat-value {
      font-size: 26px;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: var(--text-primary);
    }

    .ar-stat-card .stat-value.primary {
      color: var(--theme-primary);
    }

    .ar-stat-card .stat-value.danger {
      color: var(--danger);
    }

    .ar-stat-card .stat-value.muted {
      color: var(--text-tertiary);
    }

    .ar-stat-card .stat-sub {
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 4px;
    }

    /* ----- MAIN LAYOUT ----- */
    .ar-layout {
      display: grid;
      grid-template-columns: 320px 1fr;
      gap: 20px;
      align-items: start;
    }

    /* ----- SIDEBAR CARD ----- */
    .ar-sidebar {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px;
      transition: border-color 0.22s ease;
      position: sticky;
      top: 80px;
    }

    .ar-sidebar:hover {
      border-color: var(--border-hover);
    }

    .ar-sidebar .section-title {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 16px;
    }

    /* ----- DONUT CHART ----- */
    .ar-donut-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 20px;
    }

    .ar-donut {
      width: 160px;
      height: 160px;
      position: relative;
      flex-shrink: 0;
      margin-bottom: 16px;
    }

    .ar-donut svg {
      transform: rotate(-90deg);
      width: 100%;
      height: 100%;
    }

    .ar-donut circle {
      fill: none;
      stroke-width: 16;
      stroke-linecap: round;
      transition: stroke-dashoffset 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .ar-donut-center {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .ar-donut-center .total {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 20px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .ar-donut-center .label {
      font-size: 10px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-top: 2px;
    }

    /* ----- LEGEND ----- */
    .ar-legend {
      display: flex;
      flex-direction: column;
      gap: 10px;
      width: 100%;
      margin-bottom: 20px;
    }

    .ar-legend-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 12px;
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      transition: background 0.2s ease;
    }

    .ar-legend-item:hover {
      background: var(--bg-card-hover);
    }

    .ar-legend-item .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    .ar-legend-item .dot.lancar {
      background: var(--theme-primary);
    }

    .ar-legend-item .dot.jatuh_tempo {
      background: var(--danger);
    }

    .ar-legend-item .dot.lunas {
      background: var(--text-tertiary);
    }

    .ar-legend-item .label {
      flex: 1;
      font-size: 13px;
      color: var(--text-secondary);
    }

    .ar-legend-item .value {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .ar-legend-item .count {
      font-size: 11px;
      color: var(--text-tertiary);
      padding: 2px 8px;
      border-radius: 100px;
      background: var(--bg-card-active);
    }

    /* ----- DIVIDER ----- */
    .ar-divider {
      border: none;
      border-top: 1px solid var(--border-color);
      margin: 16px 0;
    }

    /* ----- ALERT BOX ----- */
    .ar-alert {
      background: var(--danger-soft);
      border: 1px solid var(--danger);
      border-radius: var(--radius-sm);
      padding: 14px 16px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--danger);
    }

    .ar-alert .icon {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
    }

    .ar-alert .message {
      font-size: 13px;
      font-weight: 500;
    }

    .ar-alert .message strong {
      font-weight: 700;
    }

    .ar-alert.success {
      background: var(--theme-soft);
      border-color: var(--theme-primary);
      color: var(--theme-primary);
    }

    /* ----- RECEIVABLES LIST ----- */
    .ar-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .ar-item {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 16px 20px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .ar-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .ar-item:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateX(4px);
    }

    .ar-item:hover::before {
      opacity: 1;
    }

    .ar-item.status-lancar::before {
      background: var(--theme-primary);
    }

    .ar-item.status-jatuh_tempo::before {
      background: var(--danger);
    }

    .ar-item.status-lunas::before {
      background: var(--text-tertiary);
    }

    /* ----- CLIENT AVATAR ----- */
    .ar-avatar {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--text-primary);
      flex-shrink: 0;
      background: var(--theme-soft);
    }

    .ar-avatar .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    /* ----- ITEM INFO ----- */
    .ar-item-info {
      flex: 1;
      min-width: 0;
    }

    .ar-item-client {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .ar-item-meta {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 4px;
      font-size: 12px;
      color: var(--text-tertiary);
      flex-wrap: wrap;
    }

    .ar-item-meta .invoice {
      font-family: 'IBM Plex Mono', monospace;
      color: var(--text-secondary);
    }

    .ar-item-meta .separator {
      color: var(--border-color);
    }

    .ar-item-meta .due-date {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .ar-item-meta .due-date .icon {
      width: 12px;
      height: 12px;
    }

    .ar-item-meta .due-date.overdue {
      color: var(--danger);
    }

    /* ----- ITEM RIGHT ----- */
    .ar-item-right {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-shrink: 0;
    }

    .ar-item-amount {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 15px;
      font-weight: 700;
      color: var(--text-primary);
      min-width: 120px;
      text-align: right;
    }

    .ar-status-pill {
      font-size: 11px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 100px;
      display: inline-block;
      white-space: nowrap;
    }

    .ar-status-pill.lancar {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .ar-status-pill.jatuh_tempo {
      background: var(--danger-soft);
      color: var(--danger);
    }

    .ar-status-pill.lunas {
      background: var(--bg-card-active);
      color: var(--text-tertiary);
    }

    /* ----- FOOTER ----- */
    .ar-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-top: 20px;
      padding-top: 16px;
      border-top: 1px solid var(--border-color);
    }

    .ar-footer .info {
      font-size: 13px;
      color: var(--text-tertiary);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .ar-footer .info .icon {
      width: 14px;
      height: 14px;
      color: var(--theme-primary);
    }

    .ar-footer .actions {
      display: flex;
      gap: 12px;
    }

    .ar-footer .actions a {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--text-secondary);
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      padding: 6px 14px;
      border-radius: var(--radius-sm);
      transition: all 0.2s ease;
      border: 1px solid transparent;
    }

    .ar-footer .actions a .icon {
      width: 14px;
      height: 14px;
      color: var(--theme-primary);
    }

    .ar-footer .actions a:hover {
      background: var(--bg-card);
      border-color: var(--border-color);
      color: var(--text-primary);
    }

    /* ----- EMPTY STATE ----- */
    .ar-empty {
      text-align: center;
      padding: 60px 20px;
      background: var(--bg-card);
      border-radius: var(--radius-md);
      border: 2px dashed var(--border-color);
    }

    .ar-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .ar-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
    }

    .ar-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1200px) {
      .ar-stats-row {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 992px) {
      .ar-layout {
        grid-template-columns: 1fr;
      }
      
      .ar-sidebar {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        position: static;
      }
      
      .ar-donut-wrap {
        grid-column: 1 / -1;
      }
    }

    @media (max-width: 640px) {
      .ar-header {
        flex-direction: column;
      }
      
      .ar-header-actions {
        width: 100%;
      }
      
      .ar-header-actions .ar-btn {
        flex: 1;
        justify-content: center;
      }

      .ar-stats-row {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .ar-sidebar {
        grid-template-columns: 1fr;
      }

      .ar-item {
        flex-wrap: wrap;
        padding: 14px 16px;
        gap: 12px;
      }

      .ar-item-right {
        width: 100%;
        justify-content: space-between;
        margin-left: 60px;
      }

      .ar-item-amount {
        min-width: auto;
        font-size: 14px;
      }

      .ar-item-meta {
        font-size: 11px;
        gap: 8px;
      }

      .ar-footer {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
        gap: 12px;
      }

      .ar-footer .actions {
        justify-content: center;
        flex-wrap: wrap;
      }

      .ar-avatar {
        width: 36px;
        height: 36px;
        font-size: 13px;
      }

      .ar-donut {
        width: 130px;
        height: 130px;
      }

      .ar-donut-center .total {
        font-size: 16px;
      }
    }

    @media (max-width: 380px) {
      .ar-header h1 {
        font-size: 22px;
      }
      .ar-btn {
        font-size: 12px;
        padding: 8px 14px;
      }
      .ar-btn .icon {
        width: 14px;
        height: 14px;
      }
    }
  </style>

  <div class="ar-modern">

    <!-- ===== HEADER ===== -->
    <div class="ar-header animate-in" style="animation-delay: 0.05s;">
      <div class="ar-header-left">
        <div class="ar-badge">
          <span class="dot"></span>
          Piutang &amp; Utang
        </div>
        <h1>Piutang Usaha (AR)</h1>
        <p class="subtitle">
          Daftar tagihan yang belum dibayar klien — 
          <strong>{{ $receivablesCollection->count() }}</strong> faktur aktif
        </p>
      </div>
      <div class="ar-header-actions">
        <a href="{{ Route::has('aging.index') ? route('aging.index') : '#' }}" 
           class="ar-btn ar-btn-ghost">
          <svg class="icon"><use href="#ic-trending"/></svg>
          Aging Report
        </a>
        <a href="#" class="ar-btn ar-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Faktur Baru
        </a>
      </div>
    </div>

    <!-- ===== STATS ROW ===== -->
    <div class="ar-stats-row">
      <div class="ar-stat-card animate-in" style="animation-delay: 0.10s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-bank"/></svg>
          Total Piutang
        </div>
        <div class="stat-value primary mono">{{ $currencySymbol }}{{ number_format($totalPiutang, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $countLancar + $countJatuhTempo }} faktur belum dibayar</div>
      </div>

      <div class="ar-stat-card animate-in" style="animation-delay: 0.15s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-trending"/></svg>
          Lancar
        </div>
        <div class="stat-value mono">{{ $currencySymbol }}{{ number_format($totalLancar, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $countLancar }} faktur dalam masa tenggang</div>
      </div>

      <div class="ar-stat-card animate-in" style="animation-delay: 0.20s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-trending-down"/></svg>
          Jatuh Tempo
        </div>
        <div class="stat-value danger mono">{{ $currencySymbol }}{{ number_format($totalJatuhTempo, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $countJatuhTempo }} faktur perlu ditagih</div>
      </div>

      <div class="ar-stat-card animate-in" style="animation-delay: 0.25s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-shield"/></svg>
          Tingkat Kolektibilitas
        </div>
        <div class="stat-value mono">
          {{ $totalPiutang > 0 ? round(($totalLancar / $totalPiutang) * 100) : 0 }}%
        </div>
        <div class="stat-sub">dari total piutang</div>
      </div>
    </div>

    <!-- ===== MAIN LAYOUT ===== -->
    <div class="ar-layout">

      <!-- ===== SIDEBAR ===== -->
      <aside class="ar-sidebar animate-in" style="animation-delay: 0.30s;">
        <div class="section-title">Ringkasan Piutang</div>

        <!-- Donut Chart -->
        <div class="ar-donut-wrap">
          <div class="ar-donut">
            <svg viewBox="0 0 120 120">
              @php
                $total = $totalLancar + $totalJatuhTempo + $totalLunas;
                $circumference = 2 * 3.14159 * 45;
                
                $lancarPercent = $total > 0 ? ($totalLancar / $total) * 100 : 0;
                $jatuhPercent = $total > 0 ? ($totalJatuhTempo / $total) * 100 : 0;
                $lunasPercent = $total > 0 ? ($totalLunas / $total) * 100 : 0;
                
                $lancarOffset = $circumference - ($lancarPercent / 100) * $circumference;
                $jatuhOffset = $circumference - ($jatuhPercent / 100) * $circumference - ($lancarPercent / 100) * $circumference;
                $lunasOffset = $circumference - ($lunasPercent / 100) * $circumference - (($lancarPercent + $jatuhPercent) / 100) * $circumference;
              @endphp
              <circle cx="60" cy="60" r="45" stroke="var(--bg-card-active)" stroke-width="16"/>
              <circle cx="60" cy="60" r="45" stroke="var(--theme-primary)" stroke-width="16" 
                      stroke-dasharray="{{ $circumference }}"
                      stroke-dashoffset="{{ $lancarOffset }}"/>
              <circle cx="60" cy="60" r="45" stroke="var(--danger)" stroke-width="16"
                      stroke-dasharray="{{ $circumference }}"
                      stroke-dashoffset="{{ $jatuhOffset + $lancarOffset }}"/>
              <circle cx="60" cy="60" r="45" stroke="var(--text-tertiary)" stroke-width="16"
                      stroke-dasharray="{{ $circumference }}"
                      stroke-dashoffset="{{ $lunasOffset + $lancarOffset + $jatuhOffset }}"/>
            </svg>
            <div class="ar-donut-center">
              <span class="total mono">{{ $currencySymbol }}{{ number_format($totalPiutang, 0, ',', '.') }}</span>
              <span class="label">Total Piutang</span>
            </div>
          </div>
        </div>

        <!-- Legend -->
        <div class="ar-legend">
          @foreach($chartData as $key => $data)
            <div class="ar-legend-item">
              <span class="dot {{ $key }}"></span>
              <span class="label">{{ $data['label'] }}</span>
              <span class="count">{{ $key === 'lancar' ? $countLancar : ($key === 'jatuh_tempo' ? $countJatuhTempo : $countLunas) }} faktur</span>
              <span class="value mono">{{ $currencySymbol }}{{ number_format($data['value'], 0, ',', '.') }}</span>
            </div>
          @endforeach
        </div>

        <hr class="ar-divider">

        <!-- Alert -->
        @if($countJatuhTempo > 0)
          <div class="ar-alert">
            <svg class="icon"><use href="#ic-trending-down"/></svg>
            <span class="message">
              <strong>{{ $countJatuhTempo }} faktur</strong> telah jatuh tempo! 
              Segera lakukan penagihan.
            </span>
          </div>
        @else
          <div class="ar-alert success">
            <svg class="icon"><use href="#ic-shield"/></svg>
            <span class="message">
              Semua piutang dalam kondisi <strong>lancar</strong>.
            </span>
          </div>
        @endif
      </aside>

      <!-- ===== RECEIVABLES LIST ===== -->
      <div>
        <div class="ar-list">
          @forelse($receivables as $r)
            <div class="ar-item status-{{ $statusPill[$r['status']] }} animate-in" 
                 style="animation-delay: {{ 0.35 + ($loop->index * 0.05) }}s;">
              
              <div class="ar-avatar">
                @if($r['status'] === 'lunas')
                  <svg class="icon"><use href="#ic-shield"/></svg>
                @else
                  {{ mb_substr($r['client'], 0, 1) }}
                @endif
              </div>

              <div class="ar-item-info">
                <div class="ar-item-client">{{ $r['client'] }}</div>
                <div class="ar-item-meta">
                  <span class="invoice mono">{{ $r['invoice'] }}</span>
                  <span class="separator">•</span>
                  <span>{{ formatTanggal($r['date']) }}</span>
                  <span class="separator">•</span>
                  <span class="due-date {{ isOverdue($r['due'], $r['status']) ? 'overdue' : '' }}">
                    <svg class="icon"><use href="#ic-clock"/></svg>
                    Jatuh tempo {{ formatTanggal($r['due']) }}
                    @if(isOverdue($r['due'], $r['status']))
                      <span style="color: var(--danger);">(Lewat)</span>
                    @endif
                  </span>
                </div>
              </div>

              <div class="ar-item-right">
                <span class="ar-status-pill {{ $statusPill[$r['status']] }}">
                  {{ $statusLabel[$r['status']] }}
                </span>
                <span class="ar-item-amount mono">
                  {{ $currencySymbol }}{{ number_format($r['amount'], 0, ',', '.') }}
                </span>
              </div>
            </div>
          @empty
            <div class="ar-empty animate-in" style="animation-delay: 0.35s;">
              <svg class="empty-icon"><use href="#ic-bank"/></svg>
              <h3>Belum Ada Piutang</h3>
              <p>Belum ada faktur yang tercatat di sistem.</p>
              <a href="#" class="ar-btn ar-btn-primary" style="display: inline-flex;">
                <svg class="icon"><use href="#ic-plus"/></svg>
                Buat Faktur Pertama
              </a>
            </div>
          @endforelse
        </div>

        <!-- Footer -->
        <div class="ar-footer animate-in" style="animation-delay: 0.40s;">
          <div class="info">
            <svg class="icon"><use href="#ic-briefcase"/></svg>
            Total {{ $receivablesCollection->count() }} faktur terdaftar
          </div>
          <div class="actions">
            <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}">
              <svg class="icon"><use href="#ic-doc"/></svg>
              Buku Besar Piutang
            </a>
            <a href="#">
              <svg class="icon"><use href="#ic-doc"/></svg>
              Ekspor CSV
            </a>
            <a href="#">
              <svg class="icon"><use href="#ic-doc"/></svg>
              Cetak
            </a>
          </div>
        </div>
      </div>

    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect untuk tombol
      const buttons = document.querySelectorAll('.ar-btn');
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
          setTimeout(() => {
            ripple.remove();
          }, 600);
        });
      });

      // Animasi donut chart
      const circles = document.querySelectorAll('.ar-donut circle');
      circles.forEach(circle => {
        if (circle.getAttribute('stroke') !== 'var(--bg-card-active)') {
          const offset = circle.getAttribute('stroke-dashoffset');
          circle.style.strokeDashoffset = '100%';
          setTimeout(() => {
            circle.style.strokeDashoffset = offset;
          }, 300);
        }
      });
    });
  </script>

</x-app-layout>