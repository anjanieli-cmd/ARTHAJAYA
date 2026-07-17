<x-app-layout>
  <x-slot name="title">Mutasi Rekening</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query BankMutation model nanti
    $mutations = [
        ['desc' => 'Transfer masuk - Nusantara Logistik',   'date' => '02 Jul 2026', 'type' => 'masuk',  'amount' => 18400000, 'saldo' => 24650000],
        ['desc' => 'Pembayaran listrik workshop',            'date' => '06 Jul 2026', 'type' => 'keluar', 'amount' => 820000,   'saldo' => 23830000],
        ['desc' => 'Setoran tunai penjualan',                'date' => '09 Jul 2026', 'type' => 'masuk',  'amount' => 1500000,  'saldo' => 25330000],
        ['desc' => 'Biaya admin bank',                       'date' => '10 Jul 2026', 'type' => 'keluar', 'amount' => 25000,    'saldo' => 25305000],
        ['desc' => 'Transfer masuk - Ruang Kriya Studio',    'date' => '12 Jul 2026', 'type' => 'masuk',  'amount' => 6200000,  'saldo' => 31505000],
        ['desc' => 'Beli kain mori 50 meter',                'date' => '01 Jul 2026', 'type' => 'keluar', 'amount' => 2500000,  'saldo' => 22150000],
    ];

    $mutationsCollection = collect($mutations);
    $typeLabel = ['masuk' => 'Masuk', 'keluar' => 'Keluar'];

    $totalMasuk  = $mutationsCollection->where('type', 'masuk')->sum('amount');
    $totalKeluar = $mutationsCollection->where('type', 'keluar')->sum('amount');
    $saldoAkhir  = $mutationsCollection->sortBy('date')->last()['saldo'] ?? 0;
    $arus        = $totalMasuk + $totalKeluar;

    $sorted  = $mutationsCollection->sortByDesc('date');
    $byDate  = $sorted->groupBy('date');

    $jumlahMasuk = $mutationsCollection->where('type', 'masuk')->count();
    $jumlahKeluar = $mutationsCollection->where('type', 'keluar')->count();
  @endphp

  <style>
    /* ============================================
       MUTASI REKENING - Mengikuti Tema Global
       ============================================ */
    
    .mut-modern {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      --radius-xl: 32px;
      
      --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.20);
      --shadow-glow: 0 8px 40px var(--theme-glow);
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .mut-modern * {
      box-sizing: border-box;
    }

    .mut-modern .num {
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

    .mut-modern .animate-in {
      animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      opacity: 0;
    }

    /* ----- SVG ICON BASE ----- */
    .mut-modern .icon {
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

    .mut-modern .icon-sm {
      width: 14px;
      height: 14px;
    }

    .mut-modern .icon-lg {
      width: 22px;
      height: 22px;
    }

    /* ----- HEADER SECTION ----- */
    .mut-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .mut-header-left {
      flex: 1;
      min-width: 200px;
    }

    .mut-badge {
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

    .mut-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .mut-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .mut-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .mut-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .mut-header-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .mut-btn {
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

    .mut-btn .icon {
      width: 16px;
      height: 16px;
    }

    .mut-btn:hover {
      transform: translateY(-2px);
    }

    .mut-btn:active {
      transform: translateY(0) scale(0.97);
    }

    .mut-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .mut-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .mut-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .mut-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .mut-btn .ripple {
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

    /* ----- STATS CARDS ----- */
    .mut-stats {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 16px;
      margin-bottom: 28px;
    }

    .mut-stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 22px 24px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .mut-stat-card::before {
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

    .mut-stat-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .mut-stat-card:hover::before {
      opacity: 1;
    }

    .mut-stat-card .label {
      font-size: 12px;
      font-weight: 500;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .mut-stat-card .label .icon {
      width: 14px;
      height: 14px;
    }

    .mut-stat-card .value {
      font-size: 28px;
      font-weight: 700;
      letter-spacing: -0.02em;
    }

    .mut-stat-card .value.saldo-value {
      color: var(--text-primary);
    }

    .mut-stat-card .value.masuk-value {
      color: var(--theme-primary);
    }

    .mut-stat-card .value.keluar-value {
      color: var(--theme-primary);
    }

    .mut-stat-card .trend {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 600;
      margin-top: 6px;
      padding: 2px 10px;
      border-radius: 100px;
    }

    .mut-stat-card .trend .icon {
      width: 12px;
      height: 12px;
    }

    .mut-stat-card .trend.up {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    .mut-stat-card .trend.down {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    /* ----- PROGRESS BAR ----- */
    .mut-flow-bar {
      grid-column: 1 / -1;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 18px 24px;
      display: flex;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .mut-flow-bar .flow-labels {
      display: flex;
      gap: 20px;
      flex: 1;
      min-width: 160px;
    }

    .mut-flow-bar .flow-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
    }

    .mut-flow-bar .flow-item .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    .mut-flow-bar .flow-item .dot.in {
      background: var(--theme-primary);
    }

    .mut-flow-bar .flow-item .dot.out {
      background: var(--theme-primary);
    }

    .mut-flow-bar .flow-item .amount {
      font-weight: 600;
      font-size: 14px;
    }

    .mut-flow-bar .flow-item .amount.in {
      color: var(--theme-primary);
    }

    .mut-flow-bar .flow-item .amount.out {
      color: var(--theme-primary);
    }

    .mut-flow-bar .flow-track {
      flex: 2;
      min-width: 120px;
      height: 6px;
      border-radius: 100px;
      background: var(--bg-card-active);
      overflow: hidden;
      position: relative;
    }

    .mut-flow-bar .flow-track .bar {
      height: 100%;
      border-radius: 100px;
      transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .mut-flow-bar .flow-track .bar.in {
      background: var(--theme-gradient);
    }

    .mut-flow-bar .flow-track .bar.out {
      background: var(--theme-gradient);
    }

    .mut-flow-bar .flow-percent {
      font-size: 12px;
      font-weight: 600;
      color: var(--theme-primary);
      min-width: 44px;
      text-align: right;
    }

    /* ----- DATE DIVIDER ----- */
    .mut-date-divider {
      display: flex;
      align-items: center;
      gap: 16px;
      margin: 28px 0 14px;
    }

    .mut-date-divider:first-of-type {
      margin-top: 0;
    }

    .mut-date-divider .date-label {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      padding: 4px 14px;
      background: var(--bg-card);
      border-radius: 100px;
      border: 1px solid var(--border-color);
      white-space: nowrap;
    }

    .mut-date-divider .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* ----- TRANSACTION LIST ----- */
    .mut-transactions {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .mut-tx {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 14px 20px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      cursor: default;
      position: relative;
      overflow: hidden;
    }

    .mut-tx::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .mut-tx:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateX(4px);
    }

    .mut-tx:hover::before {
      opacity: 1;
    }

    .mut-tx.type-masuk::before {
      background: var(--theme-primary);
    }

    .mut-tx.type-keluar::before {
      background: var(--theme-primary);
    }

    .mut-tx .tx-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }

    .mut-tx:hover .tx-icon {
      transform: scale(1.05) rotate(-3deg);
    }

    .mut-tx .tx-icon .icon {
      width: 18px;
      height: 18px;
    }

    .mut-tx .tx-icon.in {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .mut-tx .tx-icon.out {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .mut-tx .tx-info {
      flex: 1;
      min-width: 0;
    }

    .mut-tx .tx-desc {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .mut-tx .tx-meta {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 2px;
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .mut-tx .tx-meta .tag {
      padding: 1px 10px;
      border-radius: 100px;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .mut-tx .tx-meta .tag.in {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .mut-tx .tx-meta .tag.out {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .mut-tx .tx-right {
      text-align: right;
      flex-shrink: 0;
    }

    .mut-tx .tx-amount {
      font-size: 15px;
      font-weight: 700;
    }

    .mut-tx .tx-amount.in {
      color: var(--theme-primary);
    }

    .mut-tx .tx-amount.out {
      color: var(--theme-primary);
    }

    .mut-tx .tx-balance {
      font-size: 11.5px;
      color: var(--text-tertiary);
      margin-top: 2px;
    }

    /* ----- EMPTY STATE ----- */
    .mut-empty {
      text-align: center;
      padding: 60px 20px;
      background: var(--bg-card);
      border-radius: var(--radius-md);
      border: 2px dashed var(--border-color);
    }

    .mut-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .mut-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
    }

    .mut-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    /* ----- FOOTER ----- */
    .mut-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-top: 28px;
      padding-top: 20px;
      border-top: 1px solid var(--border-color);
    }

    .mut-footer .info {
      font-size: 13px;
      color: var(--text-tertiary);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .mut-footer .info .icon {
      width: 14px;
      height: 14px;
      color: var(--theme-primary);
    }

    .mut-footer .actions {
      display: flex;
      gap: 12px;
    }

    .mut-footer .actions a {
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

    .mut-footer .actions a .icon {
      width: 14px;
      height: 14px;
      color: var(--theme-primary);
    }

    .mut-footer .actions a:hover {
      background: var(--bg-card);
      border-color: var(--border-color);
      color: var(--text-primary);
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 992px) {
      .mut-stats {
        grid-template-columns: 1fr 1fr;
      }
      .mut-stat-card.saldo {
        grid-column: 1 / -1;
      }
    }

    @media (max-width: 640px) {
      .mut-header {
        flex-direction: column;
      }
      
      .mut-header-actions {
        width: 100%;
      }
      
      .mut-header-actions .mut-btn {
        flex: 1;
        justify-content: center;
      }

      .mut-stats {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .mut-stat-card.saldo {
        grid-column: 1;
      }

      .mut-stat-card .value {
        font-size: 22px;
      }

      .mut-flow-bar {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
        padding: 16px 18px;
      }

      .mut-flow-bar .flow-labels {
        justify-content: space-between;
      }

      .mut-tx {
        padding: 12px 14px;
        gap: 12px;
        flex-wrap: wrap;
      }

      .mut-tx .tx-info {
        order: 1;
        flex-basis: 100%;
        margin-left: 0;
      }

      .mut-tx .tx-icon {
        width: 34px;
        height: 34px;
      }

      .mut-tx .tx-icon .icon {
        width: 16px;
        height: 16px;
      }

      .mut-tx .tx-desc {
        white-space: normal;
        font-size: 13px;
      }

      .mut-tx .tx-right {
        margin-left: auto;
      }

      .mut-footer {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
        gap: 12px;
      }

      .mut-footer .actions {
        justify-content: center;
        flex-wrap: wrap;
      }
    }

    @media (max-width: 380px) {
      .mut-header h1 {
        font-size: 22px;
      }
      .mut-btn {
        font-size: 12px;
        padding: 8px 14px;
      }
      .mut-btn .icon {
        width: 14px;
        height: 14px;
      }
    }
  </style>

  <div class="mut-modern">

    <!-- ===== HEADER ===== -->
    <div class="mut-header animate-in" style="animation-delay: 0.05s;">
      <div class="mut-header-left">
        <div class="mut-badge">
          <span class="dot"></span>
          Rekening Aktif
        </div>
        <h1>Mutasi Rekening</h1>
        <p class="subtitle">
          <strong>{{ $mutationsCollection->count() }}</strong> transaksi terakhir · 
          Periode <strong>Juli 2026</strong>
        </p>
      </div>
      <div class="mut-header-actions">
        <a href="{{ Route::has('reconciliation.index') ? route('reconciliation.index') : '#' }}" 
           class="mut-btn mut-btn-ghost">
          <svg class="icon"><use href="#ic-refresh"/></svg>
          Rekonsiliasi
        </a>
        <a href="#" class="mut-btn mut-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah Mutasi
        </a>
      </div>
    </div>

    <!-- ===== STATS ===== -->
    <div class="mut-stats">
      <div class="mut-stat-card saldo animate-in" style="animation-delay: 0.10s;">
        <div class="label">
          <svg class="icon"><use href="#ic-bank"/></svg>
          Saldo Akhir
        </div>
        <div class="value saldo-value num">{{ $currencySymbol }}{{ number_format($saldoAkhir, 0, ',', '.') }}</div>
        <div class="trend up">
          <svg class="icon"><use href="#ic-trending"/></svg>
          +2.4% bulan ini
        </div>
      </div>

      <div class="mut-stat-card masuk animate-in" style="animation-delay: 0.15s;">
        <div class="label">
          <svg class="icon"><use href="#ic-receive"/></svg>
          Total Masuk
        </div>
        <div class="value masuk-value num">{{ $currencySymbol }}{{ number_format($totalMasuk, 0, ',', '.') }}</div>
        <div class="trend up">
          <svg class="icon"><use href="#ic-trending"/></svg>
          {{ $jumlahMasuk }} transaksi
        </div>
      </div>

      <div class="mut-stat-card keluar animate-in" style="animation-delay: 0.20s;">
        <div class="label">
          <svg class="icon"><use href="#ic-arrow-right"/></svg>
          Total Keluar
        </div>
        <div class="value keluar-value num">{{ $currencySymbol }}{{ number_format($totalKeluar, 0, ',', '.') }}</div>
        <div class="trend down">
          <svg class="icon"><use href="#ic-trending-down"/></svg>
          {{ $jumlahKeluar }} transaksi
        </div>
      </div>

      <div class="mut-flow-bar animate-in" style="animation-delay: 0.25s;">
        <div class="flow-labels">
          <div class="flow-item">
            <span class="dot in"></span>
            <span>Masuk</span>
            <span class="amount in">
              {{ $arus > 0 ? round($totalMasuk / $arus * 100) : 0 }}%
            </span>
          </div>
          <div class="flow-item">
            <span class="dot out"></span>
            <span>Keluar</span>
            <span class="amount out">
              {{ $arus > 0 ? round($totalKeluar / $arus * 100) : 0 }}%
            </span>
          </div>
        </div>
        <div class="flow-track">
          <div class="bar in" style="width: {{ $arus > 0 ? round($totalMasuk / $arus * 100) : 0 }}%;"></div>
          <div class="bar out" style="width: {{ $arus > 0 ? round($totalKeluar / $arus * 100) : 0 }}%;"></div>
        </div>
        <div class="flow-percent">
          {{ $arus > 0 ? round($totalMasuk / $arus * 100) : 0 }} / {{ $arus > 0 ? round($totalKeluar / $arus * 100) : 0 }}%
        </div>
      </div>
    </div>

    <!-- ===== TRANSACTIONS ===== -->
    @forelse($byDate as $date => $rows)
      <div class="mut-date-divider animate-in" style="animation-delay: {{ 0.30 + ($loop->index * 0.05) }}s;">
        <span class="date-label">{{ strtoupper(\Carbon\Carbon::parse($date)->translatedFormat('l, d F Y')) }}</span>
        <span class="line"></span>
        <span style="font-size: 11px; color: var(--text-tertiary); display: flex; align-items: center; gap: 4px;">
          <svg class="icon-sm" style="width:12px;height:12px;"><use href="#ic-activity"/></svg>
          {{ $rows->count() }} transaksi
        </span>
      </div>

      <div class="mut-transactions">
        @foreach($rows as $m)
          <div class="mut-tx type-{{ $m['type'] }} animate-in" 
               style="animation-delay: {{ 0.35 + ($loop->parent->index * 0.05) + ($loop->index * 0.03) }}s;">
            
            <div class="tx-icon {{ $m['type'] === 'masuk' ? 'in' : 'out' }}">
              <svg class="icon"><use href="#{{ $m['type'] === 'masuk' ? 'ic-receive' : 'ic-arrow-right' }}"/></svg>
            </div>

            <div class="tx-info">
              <div class="tx-desc">{{ $m['desc'] }}</div>
              <div class="tx-meta">
                <span class="tag {{ $m['type'] }}">{{ $typeLabel[$m['type']] }}</span>
                <span>•</span>
                <span>{{ \Carbon\Carbon::parse($m['date'])->translatedFormat('H:i') }}</span>
                <span>•</span>
                <span style="font-family: monospace; font-size: 11px;">#{{ str_pad($loop->parent->index + $loop->index + 1, 4, '0', STR_PAD_LEFT) }}</span>
              </div>
            </div>

            <div class="tx-right">
              <div class="tx-amount {{ $m['type'] === 'masuk' ? 'in' : 'out' }} num">
                {{ $m['type'] === 'masuk' ? '+' : '−' }}{{ $currencySymbol }}{{ number_format($m['amount'], 0, ',', '.') }}
              </div>
              <div class="tx-balance num">
                Saldo {{ $currencySymbol }}{{ number_format($m['saldo'], 0, ',', '.') }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @empty
      <div class="mut-empty animate-in" style="animation-delay: 0.35s;">
        <svg class="empty-icon"><use href="#ic-bank"/></svg>
        <h3>Belum Ada Mutasi</h3>
        <p>Belum ada transaksi yang tercatat di rekening ini.</p>
        <a href="#" class="mut-btn mut-btn-primary" style="display: inline-flex;">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah Transaksi Pertama
        </a>
      </div>
    @endforelse

    <!-- ===== FOOTER ===== -->
    <div class="mut-footer animate-in" style="animation-delay: 0.40s;">
      <div class="info">
        <svg class="icon"><use href="#ic-shield"/></svg>
        Data mutasi diperbarui secara real-time
      </div>
      <div class="actions">
        <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}">
          <svg class="icon"><use href="#ic-doc"/></svg>
          Buku Besar
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.mut-btn');
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
    });
  </script>

</x-app-layout>