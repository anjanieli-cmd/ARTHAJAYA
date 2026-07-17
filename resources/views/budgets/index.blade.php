<x-app-layout>
  <x-slot name="title">Anggaran &amp; Forecasting</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query Budget model nanti
    $budgets = [
        ['category' => 'Pendapatan', 'period' => '2026', 'target' => 850000000, 'actual' => 785000000, 'progress' => 92, 'status' => 'on_track'],
        ['category' => 'Bahan Baku', 'period' => '2026', 'target' => 120000000, 'actual' => 98000000, 'progress' => 82, 'status' => 'on_track'],
        ['category' => 'Biaya Produksi', 'period' => '2026', 'target' => 95000000, 'actual' => 102000000, 'progress' => 107, 'status' => 'over_budget'],
        ['category' => 'Marketing', 'period' => '2026', 'target' => 45000000, 'actual' => 38500000, 'progress' => 86, 'status' => 'on_track'],
        ['category' => 'Operasional', 'period' => '2026', 'target' => 65000000, 'actual' => 72000000, 'progress' => 111, 'status' => 'over_budget'],
        ['category' => 'Utilitas', 'period' => '2026', 'target' => 28000000, 'actual' => 26500000, 'progress' => 95, 'status' => 'on_track'],
        ['category' => 'Pengembangan', 'period' => '2026', 'target' => 35000000, 'actual' => 21000000, 'progress' => 60, 'status' => 'under_budget'],
    ];

    $budgetsCollection = collect($budgets);
    $statusLabel = ['on_track' => 'On Track', 'over_budget' => 'Over Budget', 'under_budget' => 'Under Budget'];
    $statusColor = ['on_track' => 'var(--success)', 'over_budget' => 'var(--danger)', 'under_budget' => 'var(--warning)'];
    $statusPill = ['on_track' => 'on-track', 'over_budget' => 'over-budget', 'under_budget' => 'under-budget'];

    $totalTarget = $budgetsCollection->sum('target');
    $totalActual = $budgetsCollection->sum('actual');
    $totalProgress = $totalTarget > 0 ? round(($totalActual / $totalTarget) * 100) : 0;
    $countOnTrack = $budgetsCollection->where('status', 'on_track')->count();
    $countOverBudget = $budgetsCollection->where('status', 'over_budget')->count();
    $countUnderBudget = $budgetsCollection->where('status', 'under_budget')->count();

    // Forecast data
    $forecast = [
        ['month' => 'Jan', 'target' => 65000000, 'actual' => 62000000],
        ['month' => 'Feb', 'target' => 68000000, 'actual' => 66000000],
        ['month' => 'Mar', 'target' => 72000000, 'actual' => 70000000],
        ['month' => 'Apr', 'target' => 70000000, 'actual' => 68000000],
        ['month' => 'Mei', 'target' => 75000000, 'actual' => 73000000],
        ['month' => 'Jun', 'target' => 78000000, 'actual' => 76000000],
        ['month' => 'Jul', 'target' => 80000000, 'actual' => 74000000],
        ['month' => 'Agu', 'target' => 82000000, 'actual' => 78000000],
        ['month' => 'Sep', 'target' => 85000000, 'actual' => null],
        ['month' => 'Okt', 'target' => 88000000, 'actual' => null],
        ['month' => 'Nov', 'target' => 90000000, 'actual' => null],
        ['month' => 'Des', 'target' => 95000000, 'actual' => null],
    ];
    
    $forecastCollection = collect($forecast);
    $maxValue = $forecastCollection->max('target') * 1.2;
  @endphp

  <style>
    .budget-wrap {
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
    }

    .budget-wrap * { box-sizing: border-box; }
    .budget-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .budget-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .budget-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .budget-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .budget-header-left { flex: 1; min-width: 200px; }

    .budget-badge {
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

    .budget-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .budget-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .budget-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .budget-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    .budget-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .budget-btn {
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

    .budget-btn .icon { width: 16px; height: 16px; }
    .budget-btn:hover { transform: translateY(-2px); }
    .budget-btn:active { transform: translateY(0) scale(0.97); }

    .budget-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .budget-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .budget-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .budget-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .budget-btn .ripple {
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
    .budget-tabs {
      display: flex;
      gap: 4px;
      margin-bottom: 24px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      padding: 4px;
    }

    .budget-tab {
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

    .budget-tab:hover { color: var(--text-primary); background: var(--bg-card-hover); }
    .budget-tab.active { background: var(--theme-gradient); color: #fff; box-shadow: 0 4px 16px var(--theme-glow); }

    .budget-panel { display: none; }
    .budget-panel.active { display: block; animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    /* STATS */
    .budget-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .budget-stat {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 18px 20px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .budget-stat:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .budget-stat .number {
      font-size: 24px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .budget-stat .number.purple { color: var(--theme-primary); }
    .budget-stat .number.green { color: var(--success); }
    .budget-stat .number.red { color: var(--danger); }
    .budget-stat .number.yellow { color: var(--warning); }

    .budget-stat .label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-top: 4px;
    }

    /* BUDGET CARD */
    .budget-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 22px;
      margin-bottom: 12px;
      transition: all 0.3s ease;
    }

    .budget-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateX(4px);
    }

    .budget-card:last-child { margin-bottom: 0; }

    .budget-card .top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 10px;
    }

    .budget-card .top .category {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .budget-card .top .status {
      font-size: 10px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .budget-card .top .status.on-track {
      background: var(--success-soft);
      color: var(--success);
    }

    .budget-card .top .status.over-budget {
      background: var(--danger-soft);
      color: var(--danger);
    }

    .budget-card .top .status.under-budget {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .budget-card .progress-wrap {
      margin: 10px 0 12px;
    }

    .budget-card .progress-bar {
      height: 8px;
      border-radius: 100px;
      background: var(--bg-card-active);
      overflow: hidden;
      position: relative;
    }

    .budget-card .progress-bar .fill {
      height: 100%;
      border-radius: 100px;
      transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .budget-card .progress-bar .fill.green { background: var(--success); }
    .budget-card .progress-bar .fill.red { background: var(--danger); }
    .budget-card .progress-bar .fill.yellow { background: var(--warning); }

    .budget-card .progress-label {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 4px;
    }

    .budget-card .progress-label .percent {
      font-weight: 600;
      color: var(--text-primary);
    }

    .budget-card .bottom {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 12px;
      padding-top: 12px;
      border-top: 1px solid var(--border-color);
    }

    .budget-card .bottom .item .lbl {
      font-size: 10px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .budget-card .bottom .item .val {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      margin-top: 2px;
    }

    .budget-card .bottom .item .val.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    /* FORECAST CHART */
    .forecast-chart {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px;
      overflow-x: auto;
    }

    .forecast-chart .chart-title {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .chart-container {
      display: flex;
      align-items: flex-end;
      gap: 8px;
      height: 200px;
      padding-bottom: 24px;
      position: relative;
      min-width: 600px;
    }

    .chart-bar-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
      height: 100%;
      justify-content: flex-end;
    }

    .chart-bar-group .bars {
      display: flex;
      gap: 3px;
      align-items: flex-end;
      height: 180px;
      width: 100%;
      justify-content: center;
    }

    .chart-bar-group .bar {
      width: 20px;
      border-radius: 4px 4px 0 0;
      min-height: 4px;
      transition: height 0.8s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
    }

    .chart-bar-group .bar.target {
      background: var(--theme-soft);
      border: 1px solid var(--theme-primary);
      opacity: 0.6;
    }

    .chart-bar-group .bar.actual {
      background: var(--theme-gradient);
    }

    .chart-bar-group .bar.actual.forecast {
      opacity: 0.4;
      background: var(--bg-card-active);
      border: 1px dashed var(--theme-primary);
    }

    .chart-bar-group .month-label {
      font-size: 10px;
      color: var(--text-tertiary);
      text-align: center;
      margin-top: 6px;
    }

    .chart-legend {
      display: flex;
      gap: 20px;
      justify-content: center;
      margin-top: 16px;
      padding-top: 16px;
      border-top: 1px solid var(--border-color);
    }

    .chart-legend .item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      color: var(--text-secondary);
    }

    .chart-legend .item .dot {
      width: 12px;
      height: 12px;
      border-radius: 3px;
    }

    .chart-legend .item .dot.target {
      background: var(--theme-soft);
      border: 1px solid var(--theme-primary);
    }

    .chart-legend .item .dot.actual {
      background: var(--theme-gradient);
    }

    .chart-legend .item .dot.forecast {
      background: var(--bg-card-active);
      border: 1px dashed var(--theme-primary);
    }

    /* EMPTY */
    .budget-empty {
      text-align: center;
      padding: 60px 20px;
      background: var(--bg-card);
      border-radius: var(--radius-md);
      border: 2px dashed var(--border-color);
    }

    .budget-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .budget-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .budget-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    @media (max-width: 992px) {
      .budget-stats { grid-template-columns: 1fr 1fr; }
      .budget-card .bottom { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .budget-tabs { flex-direction: column; }
      .budget-tab { text-align: center; }
      .budget-card .top { flex-direction: column; }
      .budget-card .bottom { grid-template-columns: 1fr; }
      .chart-container { min-width: 400px; height: 150px; }
      .chart-bar-group .bar { width: 14px; }
    }

    @media (max-width: 640px) {
      .budget-header { flex-direction: column; }
      .budget-actions { width: 100%; }
      .budget-actions .budget-btn { flex: 1; justify-content: center; }
      .budget-stats { grid-template-columns: 1fr; gap: 12px; }
    }

    @media (max-width: 380px) {
      .budget-header h1 { font-size: 22px; }
      .budget-btn { font-size: 12px; padding: 8px 14px; }
      .budget-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="budget-wrap">

    <div class="budget-header animate-in" style="animation-delay: 0.05s;">
      <div class="budget-header-left">
        <div class="budget-badge">
          <span class="dot"></span>
          Keuangan
        </div>
        <h1>Anggaran &amp; Forecasting</h1>
        <p class="subtitle">
          Kelola anggaran dan prediksi keuangan perusahaan — 
          <strong>{{ $budgetsCollection->count() }}</strong> kategori anggaran
        </p>
      </div>
      <div class="budget-actions">
        <a href="#" class="budget-btn budget-btn-ghost">
          <svg class="icon"><use href="#ic-doc"/></svg>
          Ekspor
        </a>
        <a href="#" class="budget-btn budget-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Buat Anggaran
        </a>
      </div>
    </div>

    <!-- TABS -->
    <div class="budget-tabs animate-in" style="animation-delay: 0.10s;">
      <button class="budget-tab active" data-tab="anggaran">Anggaran</button>
      <button class="budget-tab" data-tab="forecast">Forecasting</button>
    </div>

    <!-- PANEL ANGGARAN -->
    <div class="budget-panel active" data-panel="anggaran">
      <!-- STATS -->
      <div class="budget-stats animate-in" style="animation-delay: 0.15s;">
        <div class="budget-stat">
          <div class="number purple mono">{{ $currencySymbol }}{{ number_format($totalTarget, 0, ',', '.') }}</div>
          <div class="label">Total Target</div>
        </div>
        <div class="budget-stat">
          <div class="number green mono">{{ $currencySymbol }}{{ number_format($totalActual, 0, ',', '.') }}</div>
          <div class="label">Realisasi</div>
        </div>
        <div class="budget-stat">
          <div class="number {{ $totalProgress >= 100 ? 'red' : 'purple' }} mono">{{ $totalProgress }}%</div>
          <div class="label">Progress</div>
        </div>
        <div class="budget-stat">
          <div class="number">{{ $countOnTrack }} / {{ $countOverBudget }} / {{ $countUnderBudget }}</div>
          <div class="label">On Track / Over / Under</div>
        </div>
      </div>

      <!-- BUDGET LIST -->
      @forelse($budgets as $b)
        <div class="budget-card animate-in" style="animation-delay: {{ 0.20 + ($loop->index * 0.04) }}s;">
          <div class="top">
            <span class="category">{{ $b['category'] }}</span>
            <span class="status {{ $statusPill[$b['status']] }}">{{ $statusLabel[$b['status']] }}</span>
          </div>

          <div class="progress-wrap">
            <div class="progress-bar">
              @php
                $progressColor = $b['progress'] > 100 ? 'red' : ($b['progress'] < 70 ? 'yellow' : 'green');
              @endphp
              <div class="fill {{ $progressColor }}" style="width: {{ min($b['progress'], 100) }}%;"></div>
            </div>
            <div class="progress-label">
              <span>Progress</span>
              <span class="percent">{{ $b['progress'] }}%</span>
            </div>
          </div>

          <div class="bottom">
            <div class="item">
              <div class="lbl">Target</div>
              <div class="val mono">{{ $currencySymbol }}{{ number_format($b['target'], 0, ',', '.') }}</div>
            </div>
            <div class="item">
              <div class="lbl">Realisasi</div>
              <div class="val mono">{{ $currencySymbol }}{{ number_format($b['actual'], 0, ',', '.') }}</div>
            </div>
            <div class="item">
              <div class="lbl">Selisih</div>
              <div class="val mono" style="color: {{ $b['actual'] >= $b['target'] ? 'var(--success)' : 'var(--danger)' }};">
                {{ $b['actual'] >= $b['target'] ? '+' : '-' }}{{ $currencySymbol }}{{ number_format(abs($b['actual'] - $b['target']), 0, ',', '.') }}
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="budget-empty animate-in" style="animation-delay: 0.20s;">
          <svg class="empty-icon"><use href="#ic-target"/></svg>
          <h3>Belum Ada Anggaran</h3>
          <p>Belum ada anggaran yang tercatat di sistem.</p>
          <a href="#" class="budget-btn budget-btn-primary" style="display: inline-flex;">
            <svg class="icon"><use href="#ic-plus"/></svg>
            Buat Anggaran Pertama
          </a>
        </div>
      @endforelse
    </div>

    <!-- PANEL FORECAST -->
    <div class="budget-panel" data-panel="forecast">
      <div class="forecast-chart animate-in" style="animation-delay: 0.15s;">
        <div class="chart-title">Forecasting Pendapatan {{ now()->year }}</div>
        
        <div class="chart-container">
          @foreach($forecast as $f)
            @php
              $targetHeight = $maxValue > 0 ? ($f['target'] / $maxValue) * 180 : 0;
              $actualHeight = $f['actual'] ? ($f['actual'] / $maxValue) * 180 : 0;
              $isForecast = $f['actual'] === null;
            @endphp
            <div class="chart-bar-group">
              <div class="bars">
                <div class="bar target" style="height: {{ $targetHeight }}px;"></div>
                <div class="bar actual {{ $isForecast ? 'forecast' : '' }}" style="height: {{ $actualHeight }}px;"></div>
              </div>
              <span class="month-label">{{ $f['month'] }}</span>
            </div>
          @endforeach
        </div>

        <div class="chart-legend">
          <div class="item">
            <span class="dot target"></span>
            Target
          </div>
          <div class="item">
            <span class="dot actual"></span>
            Realisasi
          </div>
          <div class="item">
            <span class="dot forecast"></span>
            Forecast
          </div>
        </div>
      </div>

      <!-- Forecast Summary -->
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-top:20px;">
        <div class="budget-stat animate-in" style="animation-delay: 0.20s;">
          <div class="number purple mono">{{ $currencySymbol }}{{ number_format($forecastCollection->sum('target'), 0, ',', '.') }}</div>
          <div class="label">Target Tahunan</div>
        </div>
        <div class="budget-stat animate-in" style="animation-delay: 0.25s;">
          <div class="number green mono">{{ $currencySymbol }}{{ number_format($forecastCollection->whereNotNull('actual')->sum('actual'), 0, ',', '.') }}</div>
          <div class="label">Realisasi (YTD)</div>
        </div>
        <div class="budget-stat animate-in" style="animation-delay: 0.30s;">
          @php
            $ytdTarget = $forecastCollection->whereNotNull('actual')->sum('target');
            $ytdActual = $forecastCollection->whereNotNull('actual')->sum('actual');
            $ytdProgress = $ytdTarget > 0 ? round(($ytdActual / $ytdTarget) * 100) : 0;
          @endphp
          <div class="number {{ $ytdProgress >= 100 ? 'green' : 'yellow' }}">{{ $ytdProgress }}%</div>
          <div class="label">Progress YTD</div>
        </div>
      </div>
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.budget-btn');
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
      const tabs = document.querySelectorAll('.budget-tab');
      const panels = document.querySelectorAll('.budget-panel');

      tabs.forEach(tab => {
        tab.addEventListener('click', function() {
          // Update tabs
          tabs.forEach(t => t.classList.remove('active'));
          this.classList.add('active');

          // Update panels
          const target = this.dataset.tab;
          panels.forEach(panel => {
            panel.classList.toggle('active', panel.dataset.panel === target);
          });
        });
      });
    });
  </script>
</x-app-layout>