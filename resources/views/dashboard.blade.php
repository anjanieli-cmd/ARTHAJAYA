<x-app-layout>
  <x-slot name="title">Dashboard</x-slot>

  @php
    // Mapping kode mata uang -> simbol
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Helper function untuk format uang pendek (contoh: 184.600.000 -> 184,6jt)
    function formatCurrencyShort($amount) {
        $amount = (int) $amount;
        if ($amount >= 1000000000) {
            return number_format($amount / 1000000000, 1, ',', '') . 'M';
        } elseif ($amount >= 1000000) {
            return number_format($amount / 1000000, 1, ',', '') . 'jt';
        } elseif ($amount >= 1000) {
            return number_format($amount / 1000, 0, ',', '') . 'rb';
        }
        return number_format($amount, 0, ',', '.');
    }

    // Helper function untuk format uang penuh dengan pemisah ribuan
    function formatCurrencyFull($amount) {
        return number_format($amount, 0, ',', '.');
    }

    // Data dummy untuk transaksi
    $dummyTransactions = [
        ['title' => 'Faktur #0568 — PT Andalas Maju', 'date' => '21 Jun 2026, 09:40', 'status' => 'paid', 'amount' => 5750000, 'icon' => 'invoice'],
        ['title' => 'Sewa Kantor — Juni 2026', 'date' => '20 Jun 2026, 08:30', 'status' => 'paid', 'amount' => -42900000, 'icon' => 'building'],
        ['title' => 'Pembayaran Klien — Kopi Kenangan Senja', 'date' => '18 Jun 2026, 10:20', 'status' => 'paid', 'amount' => 2800000, 'icon' => 'briefcase'],
        ['title' => 'Faktur #0571 — Nusantara Logistik', 'date' => '15 Jun 2026, 14:05', 'status' => 'pending', 'amount' => 18400000, 'icon' => 'invoice'],
        ['title' => 'Faktur #0552 — Bumi Retail Group', 'date' => '02 Jun 2026, 11:15', 'status' => 'overdue', 'amount' => 9200000, 'icon' => 'invoice'],
    ];
  @endphp

  <style>
    /* ============================================
       DASHBOARD - Premium Design
       ============================================ */
    
    .dash-wrap {
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
      --success: #34B583;
      --success-soft: rgba(52, 181, 131, 0.14);
      --warning: #F0A83C;
      --warning-soft: rgba(240, 168, 60, 0.14);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .dash-wrap * { box-sizing: border-box; }
    .dash-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .dash-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .dash-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* ===== HEADER ===== */
    .dash-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .dash-header-left { flex: 1; min-width: 200px; }

    .dash-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 4px 0;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }

    .dash-eyebrow .icon { width: 14px; height: 14px; color: var(--theme-primary); }

    .dash-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 4px 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .dash-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .dash-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .dash-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .dash-btn {
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

    .dash-btn .icon { width: 16px; height: 16px; }
    .dash-btn:hover { transform: translateY(-2px); }
    .dash-btn:active { transform: translateY(0) scale(0.97); }

    .dash-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
      border: none;
    }

    .dash-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .dash-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .dash-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .dash-btn .ripple {
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

    /* ===== COMPANY CARD ===== */
    .dash-company-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px 28px;
      margin-bottom: 24px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 24px;
      flex-wrap: wrap;
    }

    .dash-company-card:hover {
      border-color: var(--border-hover);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .dash-company-logo {
      width: 56px;
      height: 56px;
      border-radius: var(--radius-sm);
      background: var(--theme-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    .dash-company-logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: var(--radius-sm);
    }

    .dash-company-info {
      flex: 1;
      min-width: 200px;
    }

    .dash-company-info h2 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 4px;
      color: var(--text-primary);
    }

    .dash-company-tags {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 8px;
    }

    .dash-tag {
      display: inline-block;
      padding: 2px 12px;
      border-radius: 100px;
      font-size: 11px;
      font-weight: 500;
      color: var(--text-secondary);
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
    }

    .dash-company-details {
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
      font-size: 13px;
    }

    .dash-company-details .item .label {
      color: var(--text-tertiary);
      margin-right: 4px;
    }

    .dash-company-details .item .value {
      color: var(--text-primary);
      font-weight: 500;
    }

    /* ===== STAT GRID ===== */
    .dash-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .dash-stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 22px;
      transition: all 0.3s ease;
    }

    .dash-stat-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .dash-stat-card .stat-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
    }

    .dash-stat-card .stat-top .stat-icon {
      width: 36px;
      height: 36px;
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .dash-stat-card .stat-top .stat-icon .icon {
      width: 18px;
      height: 18px;
    }

    .dash-stat-card .stat-top .stat-change {
      font-size: 12px;
      font-weight: 600;
      padding: 2px 10px;
      border-radius: 100px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .dash-stat-card .stat-top .stat-change.up {
      color: var(--success);
      background: var(--success-soft);
    }

    .dash-stat-card .stat-top .stat-change.down {
      color: var(--danger);
      background: var(--danger-soft);
    }

    .dash-stat-card .stat-top .stat-change .icon {
      width: 14px;
      height: 14px;
    }

    .dash-stat-card .stat-label {
      font-size: 12px;
      color: var(--text-tertiary);
      font-weight: 500;
      margin-bottom: 4px;
    }

    .dash-stat-card .stat-value {
      font-size: 26px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .dash-stat-card .stat-value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    /* ===== MAIN LAYOUT ===== */
    .dash-layout {
      display: grid;
      grid-template-columns: 1.6fr 1fr;
      gap: 24px;
      align-items: start;
    }

    .dash-stack {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    /* ===== CARDS ===== */
    .dash-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px 28px;
      transition: all 0.3s ease;
    }

    .dash-card:hover {
      border-color: var(--border-hover);
    }

    .dash-card .card-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
    }

    .dash-card .card-head h3 {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
    }

    .dash-card .card-head .sub-link {
      font-size: 12px;
      color: var(--text-tertiary);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 4px;
      transition: color 0.2s ease;
    }

    .dash-card .card-head .sub-link:hover {
      color: var(--theme-primary);
    }

    .dash-card .card-head .sub-link .icon {
      width: 14px;
      height: 14px;
    }

    /* ===== BALANCE CARD ===== */
    .dash-balance {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 20px;
    }

    .dash-balance .balance-left .balance-label {
      font-size: 12px;
      color: var(--text-tertiary);
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .dash-balance .balance-left .balance-amount {
      font-size: 34px;
      font-weight: 700;
      color: var(--text-primary);
      margin: 4px 0 2px;
    }

    .dash-balance .balance-left .balance-amount.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .dash-balance .balance-left .balance-sub {
      font-size: 13px;
      color: var(--text-secondary);
    }

    .dash-balance .balance-left .balance-change {
      font-size: 13px;
      color: var(--success);
      display: flex;
      align-items: center;
      gap: 4px;
      margin-top: 4px;
    }

    .dash-balance .balance-left .balance-change .icon {
      width: 14px;
      height: 14px;
    }

    .dash-balance .balance-actions {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 8px;
    }

    .dash-balance .balance-actions .qa-btn {
      padding: 10px 14px;
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      text-align: center;
      font-size: 11px;
      font-weight: 500;
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .dash-balance .balance-actions .qa-btn:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
      transform: translateY(-2px);
    }

    .dash-balance .balance-actions .qa-btn .icon {
      width: 18px;
      height: 18px;
      display: block;
      margin: 0 auto 4px;
      color: var(--theme-primary);
    }

    /* ===== SPARK CHART ===== */
    .dash-spark {
      display: flex;
      align-items: flex-end;
      gap: 4px;
      height: 40px;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid var(--border-color);
    }

    .dash-spark .spark-bar {
      flex: 1;
      height: 0;
      border-radius: 3px 3px 0 0;
      background: var(--theme-gradient);
      opacity: 0.6;
      transition: height 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .dash-spark .spark-bar:nth-child(odd) {
      opacity: 0.8;
    }

    .dash-spark .spark-bar:nth-child(3n) {
      opacity: 1;
    }

    /* ===== TRANSACTION TABLE ===== */
    .dash-tx-table {
      width: 100%;
      border-collapse: collapse;
    }

    .dash-tx-table thead th {
      padding: 8px 4px 12px;
      text-align: left;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      border-bottom: 1px solid var(--border-color);
    }

    .dash-tx-table tbody tr {
      border-bottom: 1px solid var(--border-color);
      transition: background 0.2s ease;
    }

    .dash-tx-table tbody tr:last-child {
      border-bottom: none;
    }

    .dash-tx-table tbody tr:hover {
      background: var(--bg-card-active);
    }

    .dash-tx-table tbody td {
      padding: 12px 4px;
      vertical-align: middle;
    }

    .dash-tx-table .tx-who {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dash-tx-table .tx-who .tx-icon {
      width: 32px;
      height: 32px;
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-tertiary);
      flex-shrink: 0;
    }

    .dash-tx-table .tx-who .tx-icon .icon {
      width: 14px;
      height: 14px;
    }

    .dash-tx-table .tx-who .tx-name {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-primary);
    }

    .dash-tx-table .tx-who .tx-date {
      font-size: 11px;
      color: var(--text-tertiary);
    }

    .dash-tx-table .tx-status {
      display: inline-block;
      padding: 2px 12px;
      border-radius: 100px;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .dash-tx-table .tx-status.paid {
      background: var(--success-soft);
      color: var(--success);
    }

    .dash-tx-table .tx-status.pending {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .dash-tx-table .tx-status.overdue {
      background: var(--danger-soft);
      color: var(--danger);
    }

    .dash-tx-table .tx-amount {
      font-weight: 600;
      font-family: 'IBM Plex Mono', monospace;
      text-align: right;
    }

    .dash-tx-table .tx-amount.pos {
      color: var(--success);
    }

    .dash-tx-table .tx-amount.neg {
      color: var(--danger);
    }

    /* ===== DONUT CHART ===== */
    .dash-donut-wrap {
      display: flex;
      gap: 24px;
      align-items: center;
      flex-wrap: wrap;
    }

    .dash-donut {
      position: relative;
      width: 140px;
      height: 140px;
      flex-shrink: 0;
    }

    .dash-donut svg {
      width: 100%;
      height: 100%;
      transform: rotate(-90deg);
    }

    .dash-donut svg circle {
      fill: none;
      stroke-width: 12;
    }

    .dash-donut svg circle:first-child {
      stroke: var(--bg-card-active);
    }

    .dash-donut .donut-center {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .dash-donut .donut-center .amt {
      font-size: 18px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .dash-donut .donut-center .lbl {
      font-size: 11px;
      color: var(--text-tertiary);
    }

    .dash-legend {
      flex: 1;
      min-width: 140px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .dash-legend .legend-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      color: var(--text-secondary);
    }

    .dash-legend .legend-row .dot {
      width: 10px;
      height: 10px;
      border-radius: 3px;
      display: inline-block;
      margin-right: 8px;
    }

    .dash-legend .legend-row .amt {
      font-weight: 600;
      color: var(--text-primary);
      font-family: 'IBM Plex Mono', monospace;
    }

    /* ===== PROGRESS ===== */
    .dash-progress {
      margin-top: 12px;
    }

    .dash-progress .progress-bar {
      height: 8px;
      border-radius: 100px;
      background: var(--bg-card-active);
      overflow: hidden;
    }

    .dash-progress .progress-bar .progress-fill {
      height: 100%;
      border-radius: 100px;
      background: var(--theme-gradient);
      transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
      width: 0;
    }

    .dash-progress .progress-labels {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 4px;
    }

    /* ===== TEAM ===== */
    .dash-team-row {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 0;
      border-bottom: 1px solid var(--border-color);
    }

    .dash-team-row:last-child {
      border-bottom: none;
    }

    .dash-team-row .avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--theme-soft);
      color: var(--theme-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 14px;
      flex-shrink: 0;
    }

    .dash-team-row .info {
      flex: 1;
    }

    .dash-team-row .info .name {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-primary);
    }

    .dash-team-row .info .email {
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .dash-team-row .role {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      padding: 2px 12px;
      border-radius: 100px;
      background: var(--bg-card-active);
      color: var(--text-tertiary);
      border: 1px solid var(--border-color);
    }

    .dash-empty {
      text-align: center;
      padding: 24px 12px;
      color: var(--text-tertiary);
      font-size: 13px;
    }

    /* ===== INVOICE ROW ===== */
    .dash-inv-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid var(--border-color);
    }

    .dash-inv-row:last-child {
      border-bottom: none;
    }

    .dash-inv-row .info .name {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-primary);
    }

    .dash-inv-row .info .date {
      font-size: 11px;
      color: var(--text-tertiary);
    }

    .dash-inv-row .amount {
      font-weight: 600;
      font-family: 'IBM Plex Mono', monospace;
      color: var(--text-primary);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
      .dash-stats { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 992px) {
      .dash-layout { grid-template-columns: 1fr; }
      .dash-balance { flex-direction: column; }
      .dash-balance .balance-actions { width: 100%; }
    }

    @media (max-width: 768px) {
      .dash-header h1 { font-size: 24px; }
      .dash-stats { grid-template-columns: 1fr 1fr; }
      .dash-company-card { flex-direction: column; text-align: center; }
      .dash-company-details { justify-content: center; }
      .dash-donut-wrap { flex-direction: column; align-items: center; }
      .dash-balance .balance-actions { grid-template-columns: repeat(2, 1fr); }
      .dash-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .dash-header { flex-direction: column; }
      .dash-actions { width: 100%; }
      .dash-actions .dash-btn { flex: 1; justify-content: center; }
      .dash-stats { grid-template-columns: 1fr; }
    }

    @media (max-width: 380px) {
      .dash-header h1 { font-size: 20px; }
      .dash-stat-card .stat-value { font-size: 20px; }
    }
  </style>

  <div class="dash-wrap">

    <!-- ===== HEADER ===== -->
    <div class="dash-header animate-in" style="animation-delay: 0.05s;">
      <div class="dash-header-left">
        <div class="dash-eyebrow">
          <svg class="icon"><use href="#ic-building"/></svg> Dashboard Perusahaan
        </div>
        <h1>{{ $company->name ?? 'Perusahaan Belum Diatur' }}</h1>
        <p class="subtitle">
          {{ $company->industry ?? 'Industri belum diisi' }} @if($company->city ?? false) • {{ $company->city }}@endif — Diperbarui {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </p>
      </div>
      <div class="dash-actions">
        <a href="#" class="dash-btn dash-btn-ghost">
          <svg class="icon"><use href="#ic-receive"/></svg> Catat Transaksi
        </a>
        <a href="#" class="dash-btn dash-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg> Faktur Baru
        </a>
      </div>
    </div>

    <!-- ===== COMPANY CARD ===== -->
    <div class="dash-company-card animate-in" style="animation-delay: 0.08s;">
      <div class="dash-company-logo">
        @if(!empty($company->logo))
          <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}">
        @else
          {{ strtoupper(substr($company->name ?? 'PT', 0, 2)) }}
        @endif
      </div>
      <div class="dash-company-info">
        <h2>{{ $company->name ?? 'Nama Perusahaan' }}</h2>
        <div class="dash-company-tags">
          <span class="dash-tag">{{ $company->industry ?? 'Industri belum diisi' }}</span>
          @if($company->city ?? false)<span class="dash-tag">{{ $company->city }}</span>@endif
        </div>
        <div class="dash-company-details">
          <div class="item">
            <span class="label">Mata Uang</span>
            <span class="value">{{ $company->currency ?? 'IDR' }} ({{ $currencySymbol }})</span>
          </div>
          <div class="item">
            <span class="label">Tahun Fiskal</span>
            <span class="value">{{ $company->fiscal_start_month ?? 'Januari' }} — {{ $company->fiscal_year ?? date('Y') }}</span>
          </div>
        </div>
      </div>
      <a href="#" class="dash-btn dash-btn-ghost" style="flex-shrink:0;">
        <svg class="icon"><use href="#ic-settings"/></svg> Edit Profil
      </a>
    </div>

    <!-- ===== STATS ===== -->
    <div class="dash-stats animate-in" style="animation-delay: 0.10s;">
      <div class="dash-stat-card">
        <div class="stat-top">
          <div class="stat-icon"><svg class="icon"><use href="#ic-bank"/></svg></div>
          <span class="stat-change up"><svg class="icon"><use href="#ic-trending"/></svg> 3.8%</span>
        </div>
        <div class="stat-label">Total Saldo Kas</div>
        <div class="stat-value mono">{{ $currencySymbol }}{{ formatCurrencyShort($account->initial_balance ?? 0) }}</div>
      </div>
      <div class="dash-stat-card">
        <div class="stat-top">
          <div class="stat-icon"><svg class="icon"><use href="#ic-receive"/></svg></div>
          <span class="stat-change up"><svg class="icon"><use href="#ic-trending"/></svg> 12.5%</span>
        </div>
        <div class="stat-label">Pemasukan Bulan Ini</div>
        <div class="stat-value mono">{{ $currencySymbol }}184,6jt</div>
      </div>
      <div class="dash-stat-card">
        <div class="stat-top">
          <div class="stat-icon"><svg class="icon"><use href="#ic-invoice"/></svg></div>
          <span class="stat-change down"><svg class="icon"><use href="#ic-trending-down"/></svg> 4.2%</span>
        </div>
        <div class="stat-label">Pengeluaran Bulan Ini</div>
        <div class="stat-value mono">{{ $currencySymbol }}36,5jt</div>
      </div>
      <div class="dash-stat-card">
        <div class="stat-top">
          <div class="stat-icon"><svg class="icon"><use href="#ic-doc"/></svg></div>
          <span class="stat-change down" style="background:var(--danger-soft);color:var(--danger);">3 jatuh tempo</span>
        </div>
        <div class="stat-label">Faktur Belum Dibayar</div>
        <div class="stat-value mono">{{ $currencySymbol }}87,5jt</div>
      </div>
    </div>

    <!-- ===== MAIN LAYOUT ===== -->
    <div class="dash-layout">

      <!-- LEFT COLUMN -->
      <div class="dash-stack">

        <!-- BALANCE CARD -->
        <div class="dash-card animate-in" style="animation-delay: 0.15s;">
          <div class="dash-balance">
            <div class="balance-left">
              <div class="balance-label">Saldo Kas Konsolidasi</div>
              <div class="balance-amount mono">{{ $currencySymbol }}{{ formatCurrencyShort($account->initial_balance ?? 0) }}</div>
              @if($account)
                <div class="balance-sub">{{ $account->bank_name ?? 'Kas Tunai' }}</div>
              @endif
              <div class="balance-change">
                <svg class="icon"><use href="#ic-trending"/></svg> +Rp16,85jt (3.8%) bulan ini
              </div>
            </div>
            <div class="balance-actions">
              <div class="qa-btn">
                <svg class="icon"><use href="#ic-invoice"/></svg>
                Faktur
              </div>
              <div class="qa-btn">
                <svg class="icon"><use href="#ic-receive"/></svg>
                Terima
              </div>
              <div class="qa-btn">
                <svg class="icon"><use href="#ic-bank"/></svg>
                Rekonsil
              </div>
              <div class="qa-btn">
                <svg class="icon"><use href="#ic-more"/></svg>
                Lainnya
              </div>
            </div>
          </div>
          <div class="dash-spark">
            <i class="spark-bar" data-h="35"></i>
            <i class="spark-bar" data-h="55"></i>
            <i class="spark-bar" data-h="40"></i>
            <i class="spark-bar" data-h="70"></i>
            <i class="spark-bar" data-h="50"></i>
            <i class="spark-bar" data-h="85"></i>
            <i class="spark-bar" data-h="65"></i>
            <i class="spark-bar" data-h="90"></i>
            <i class="spark-bar" data-h="60"></i>
            <i class="spark-bar" data-h="78"></i>
            <i class="spark-bar" data-h="95"></i>
            <i class="spark-bar" data-h="88"></i>
          </div>
        </div>

        <!-- TRANSACTIONS TABLE -->
        <div class="dash-card animate-in" style="animation-delay: 0.20s;">
          <div class="card-head">
            <h3>Transaksi Terbaru</h3>
            <a href="#" class="sub-link">Lihat semua <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
          </div>
          <table class="dash-tx-table">
            <thead>
              <tr>
                <th>Deskripsi</th>
                <th>Status</th>
                <th style="text-align:right">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @foreach($dummyTransactions as $tx)
                <tr>
                  <td>
                    <div class="tx-who">
                      <div class="tx-icon"><svg class="icon"><use href="#ic-{{ $tx['icon'] }}"/></svg></div>
                      <div>
                        <div class="tx-name">{{ $tx['title'] }}</div>
                        <div class="tx-date">{{ $tx['date'] }}</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="tx-status {{ $tx['status'] }}">{{ ucfirst($tx['status']) }}</span></td>
                  <td class="tx-amount {{ $tx['amount'] >= 0 ? 'pos' : 'neg' }}">
                    {{ $tx['amount'] >= 0 ? '+' : '-' }}{{ $currencySymbol }}{{ formatCurrencyShort(abs($tx['amount'])) }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- RIGHT COLUMN -->
      <div class="dash-stack">

        <!-- EXPENSE DONUT -->
        <div class="dash-card animate-in" style="animation-delay: 0.25s;">
          <div class="card-head">
            <h3>Ringkasan Pengeluaran</h3>
            <span class="sub-link">Bulan Ini <svg class="icon"><use href="#ic-chevron"/></svg></span>
          </div>
          <div class="dash-donut-wrap">
            <div class="dash-donut">
              <svg viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="52"></circle>
                <circle cx="60" cy="60" r="52" style="stroke:var(--theme-primary);stroke-dasharray:326.7;stroke-dashoffset:326.7;" class="donut-anim"></circle>
              </svg>
              <div class="donut-center">
                <div class="amt">{{ $currencySymbol }}36,5jt</div>
                <div class="lbl">Total</div>
              </div>
            </div>
            <div class="dash-legend">
              <div class="legend-row">
                <span><i class="dot" style="background:var(--theme-primary)"></i>Operasional</span>
                <span class="amt">{{ $currencySymbol }}14,6jt</span>
              </div>
              <div class="legend-row">
                <span><i class="dot" style="background:#4E8FF0"></i>Gaji</span>
                <span class="amt">{{ $currencySymbol }}9,1jt</span>
              </div>
              <div class="legend-row">
                <span><i class="dot" style="background:#F0C05A"></i>Sewa</span>
                <span class="amt">{{ $currencySymbol }}5,5jt</span>
              </div>
              <div class="legend-row">
                <span><i class="dot" style="background:#9B7BE0"></i>Pemasaran</span>
                <span class="amt">{{ $currencySymbol }}3,7jt</span>
              </div>
            </div>
          </div>
        </div>

        <!-- BILLING TARGET -->
        <div class="dash-card animate-in" style="animation-delay: 0.30s;">
          <div class="card-head">
            <h3>Target Penagihan</h3>
            <svg class="icon" style="width:20px;height:20px;color:var(--theme-primary);"><use href="#ic-target"/></svg>
          </div>
          <div class="balance-amount mono" style="font-size:24px;">{{ $currencySymbol }}62,5jt</div>
          <div style="font-size:12px;color:var(--text-secondary);margin-top:4px;">dari target Rp150jt</div>
          <div class="dash-progress">
            <div class="progress-bar">
              <div class="progress-fill" id="targetFill"></div>
            </div>
            <div class="progress-labels">
              <span>42%</span>
              <span>Sisa 18 hari</span>
            </div>
          </div>
        </div>

        <!-- TEAM -->
        <div class="dash-card animate-in" style="animation-delay: 0.35s;">
          <div class="card-head">
            <h3>Tim Perusahaan</h3>
            <a href="#" class="sub-link">Kelola <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
          </div>
          @if(!empty($teamMembers) && count($teamMembers))
            @foreach($teamMembers as $member)
              <div class="dash-team-row">
                <div class="avatar">{{ strtoupper(substr($member->name ?? $member->email, 0, 1)) }}</div>
                <div class="info">
                  <div class="name">{{ $member->name ?? $member->email }}</div>
                  <div class="email">{{ $member->email }}</div>
                </div>
                <span class="role">{{ $member->role ?? 'Anggota' }}</span>
              </div>
            @endforeach
          @else
            <div class="dash-empty">
              Belum ada anggota tim diundang.<br>
              Undang rekan kerja lewat menu Pengaturan.
            </div>
          @endif
        </div>

        <!-- UPCOMING INVOICES -->
        <div class="dash-card animate-in" style="animation-delay: 0.40s;">
          <div class="card-head">
            <h3>Faktur Akan Jatuh Tempo</h3>
            <a href="#" class="sub-link">Semua <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
          </div>
          <div class="dash-inv-row">
            <div class="info">
              <div class="name">#0571 — Nusantara Logistik</div>
              <div class="date">Jatuh tempo 25 Jun 2026</div>
            </div>
            <div class="amount">{{ $currencySymbol }}18,4jt</div>
          </div>
          <div class="dash-inv-row">
            <div class="info">
              <div class="name">#0574 — Ruang Kriya Studio</div>
              <div class="date">Jatuh tempo 28 Jun 2026</div>
            </div>
            <div class="amount">{{ $currencySymbol }}6,2jt</div>
          </div>
          <div class="dash-inv-row">
            <div class="info">
              <div class="name">#0552 — Bumi Retail Group</div>
              <div class="date" style="color:var(--danger);">Terlambat 4 hari</div>
            </div>
            <div class="amount">{{ $currencySymbol }}9,2jt</div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-building" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="6" x2="15" y2="6"/><line x1="9" y1="10" x2="15" y2="10"/><line x1="9" y1="14" x2="15" y2="14"/><line x1="9" y1="18" x2="15" y2="18"/></symbol>
    <symbol id="ic-bank" viewBox="0 0 24 24"><rect x="2" y="10" width="20" height="12" rx="2"/><line x1="12" y1="2" x2="12" y2="10"/><line x1="6" y1="6" x2="6" y2="10"/><line x1="18" y1="6" x2="18" y2="10"/></symbol>
    <symbol id="ic-receive" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></symbol>
    <symbol id="ic-invoice" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></symbol>
    <symbol id="ic-doc" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></symbol>
    <symbol id="ic-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="ic-settings" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></symbol>
    <symbol id="ic-trending" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></symbol>
    <symbol id="ic-trending-down" viewBox="0 0 24 24"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></symbol>
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></symbol>
    <symbol id="ic-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
    <symbol id="ic-more" viewBox="0 0 24 24"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></symbol>
    <symbol id="ic-briefcase" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.dash-btn');
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

      // Spark bars grow-in
      document.querySelectorAll('.dash-spark .spark-bar').forEach((bar, i) => {
        setTimeout(() => {
          bar.style.height = bar.dataset.h + '%';
        }, i * 60 + 300);
      });

      // Billing target progress fill
      const targetFill = document.getElementById('targetFill');
      if(targetFill) {
        setTimeout(() => {
          targetFill.style.width = '42%';
        }, 400);
      }

      // Donut animation
      const donutCircle = document.querySelector('.donut-anim');
      if(donutCircle) {
        setTimeout(() => {
          donutCircle.style.strokeDashoffset = '130.7';
        }, 200);
      }
    });
  </script>

</x-app-layout>