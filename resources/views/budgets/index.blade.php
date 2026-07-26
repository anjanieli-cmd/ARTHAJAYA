<x-app-layout>
  <x-slot name="title">Anggaran &amp; Forecasting</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    $budgets = $budgets ?? [
        ['category' => 'Pendapatan', 'period' => '2026', 'target' => 850000000, 'actual' => 785000000, 'progress' => 92, 'status' => 'on_track'],
        ['category' => 'Bahan Baku', 'period' => '2026', 'target' => 120000000, 'actual' => 98000000, 'progress' => 82, 'status' => 'on_track'],
        ['category' => 'Biaya Produksi', 'period' => '2026', 'target' => 95000000, 'actual' => 102000000, 'progress' => 107, 'status' => 'over_budget'],
        ['category' => 'Marketing', 'period' => '2026', 'target' => 45000000, 'actual' => 38500000, 'progress' => 86, 'status' => 'on_track'],
        ['category' => 'Operasional', 'period' => '2026', 'target' => 65000000, 'actual' => 72000000, 'progress' => 111, 'status' => 'over_budget'],
        ['category' => 'Utilitas', 'period' => '2026', 'target' => 28000000, 'actual' => 26500000, 'progress' => 95, 'status' => 'on_track'],
        ['category' => 'Pengembangan', 'period' => '2026', 'target' => 35000000, 'actual' => 21000000, 'progress' => 60, 'status' => 'under_budget'],
    ];

    // Fungsi untuk format angka ke jutaan (M)
    function formatToMillion($number) {
        if ($number >= 1000000000) {
            return number_format($number / 1000000000, 1) . 'B';
        } elseif ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 0) . 'K';
        }
        return number_format($number, 0);
    }

    // Fungsi untuk format angka dengan satuan jutaan (tanpa desimal jika bulat)
    function formatCompact($number) {
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . 'B';
        } elseif ($number >= 1000000) {
            $result = $number / 1000000;
            return ($result == floor($result)) ? number_format($result, 0) . 'M' : number_format($result, 1) . 'M';
        } elseif ($number >= 1000) {
            $result = $number / 1000;
            return ($result == floor($result)) ? number_format($result, 0) . 'K' : number_format($result, 1) . 'K';
        }
        return number_format($number, 0);
    }

    if (!session()->has('budgets') && !request()->filled('q')) {
        session(['budgets' => $budgets]);
    }

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

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </symbol>
      <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </symbol>
      <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
      </symbol>
      <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
      </symbol>
      <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
      </symbol>
      <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
      </symbol>
      <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
      </symbol>
      <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
      </symbol>
      <symbol id="ic-doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
      </symbol>
      <symbol id="ic-target" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
      </symbol>
      <symbol id="ic-more" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>
      </symbol>
    </defs>
  </svg>

  <style>
    /* ============================================
       ANGGARAN - Clean & Modern Design
       ============================================ */
    
    .budget-modern {
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
      --danger-rgb: 232, 90, 90;
      --warning: #F0A83C;
      --warning-soft: rgba(240, 168, 60, 0.14);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
      padding: 0 24px;
    }

    .budget-modern * { box-sizing: border-box; }
    .budget-modern .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    @keyframes modalFadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes modalSlideUp {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes dropdownFade {
      from {
        opacity: 0;
        transform: translateY(-8px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    .budget-modern .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .budget-modern .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* ===== HEADER ===== */
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
      font-family: 'Inter', sans-serif;
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

    .search-wrap:focus-within .icon {
      color: var(--theme-primary);
    }

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

    .filter-bar input[type="text"]::placeholder {
      color: var(--text-tertiary);
    }

    .filter-actions {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .filter-actions .budget-btn {
      padding: 8px 14px;
      font-size: 12px;
    }

    .search-indicator {
      font-size: 12px;
      color: var(--text-tertiary);
      padding: 4px 12px;
      background: var(--bg-card-active);
      border-radius: 20px;
      white-space: nowrap;
      display: none;
      align-items: center;
      gap: 6px;
    }

    .search-indicator.active {
      display: inline-flex;
    }

    .search-indicator .count {
      font-weight: 600;
      color: var(--text-primary);
    }

    /* ===== TABS ===== */
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
      font-family: 'Inter', sans-serif;
    }

    .budget-tab:hover { color: var(--text-primary); background: var(--bg-card-hover); }
    .budget-tab.active { background: var(--theme-gradient); color: #fff; box-shadow: 0 4px 16px var(--theme-glow); }

    .budget-panel { display: none; }
    .budget-panel.active { display: block; animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    /* ===== STATS ===== */
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
      position: relative;
      overflow: hidden;
    }

    .budget-stat::before {
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

    .budget-stat:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .budget-stat:hover::before {
      opacity: 1;
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

    /* ===== BUDGET CARD ===== */
    .budget-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 20px 22px;
      margin-bottom: 12px;
      transition: all 0.3s ease;
      position: relative;
    }

    .budget-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateX(4px);
    }

    .budget-card:last-child { margin-bottom: 0; }

    .budget-card.hidden-card {
      display: none;
    }

    .budget-card.visible-card {
      display: block;
      animation: fadeSlideUp 0.3s ease forwards;
    }

    .budget-card .top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 10px;
    }

    .budget-card .top .left {
      display: flex;
      align-items: center;
      gap: 12px;
      flex: 1;
    }

    .budget-card .top .category {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .budget-card .top .right {
      display: flex;
      align-items: center;
      gap: 10px;
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

    /* ===== DROPDOWN ===== */
    .budget-dropdown {
      position: relative;
      display: inline-block;
    }

    .budget-dropdown .dropdown-toggle {
      background: transparent;
      border: none;
      padding: 4px 6px;
      border-radius: 6px;
      cursor: pointer;
      color: var(--text-tertiary);
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .budget-dropdown .dropdown-toggle:hover {
      background: var(--bg-card-active);
      color: var(--text-primary);
    }

    .budget-dropdown .dropdown-toggle .icon {
      width: 20px;
      height: 20px;
    }

    .budget-dropdown .dropdown-menu {
      position: absolute;
      right: 0;
      top: calc(100% + 4px);
      min-width: 170px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      z-index: 1000;
      animation: dropdownFade 0.2s ease;
      overflow: hidden;
      padding: 6px 0;
      display: none;
    }

    .budget-dropdown .dropdown-menu.active {
      display: block;
    }

    .budget-dropdown .dropdown-menu .dropdown-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 16px;
      font-size: 12px;
      font-weight: 500;
      color: var(--text-secondary);
      text-decoration: none;
      border: none;
      background: transparent;
      cursor: pointer;
      transition: all 0.15s ease;
      width: 100%;
      text-align: left;
      font-family: 'Inter', sans-serif;
    }

    .budget-dropdown .dropdown-menu .dropdown-item .icon {
      width: 14px;
      height: 14px;
      flex-shrink: 0;
    }

    .budget-dropdown .dropdown-menu .dropdown-item:hover {
      background: var(--bg-card-hover);
      color: var(--text-primary);
    }

    .budget-dropdown .dropdown-menu .dropdown-item.show:hover {
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .budget-dropdown .dropdown-menu .dropdown-item.edit:hover {
      background: rgba(59, 130, 246, 0.12);
      color: #3b82f6;
    }

    .budget-dropdown .dropdown-menu .dropdown-item.delete:hover {
      background: var(--danger-soft);
      color: var(--danger);
    }

    .budget-dropdown .dropdown-menu .dropdown-divider {
      height: 1px;
      background: var(--border-color);
      margin: 4px 12px;
    }

    /* ===== FORECAST CHART ===== */
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

    .forecast-summary {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 16px;
      margin-top: 20px;
    }

    /* ===== EMPTY ===== */
    .budget-empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-tertiary);
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

    .budget-empty.hidden {
      display: none;
    }

    /* ===== MODAL DELETE ===== */
    .budget-modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      z-index: 9999;
      align-items: center;
      justify-content: center;
      padding: 20px;
      animation: modalFadeIn 0.3s ease;
    }

    .budget-modal-overlay.active {
      display: flex;
    }

    .budget-modal-box {
      border-radius: 24px;
      max-width: 440px;
      width: 100%;
      padding: 32px 36px;
      box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
      animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      text-align: center;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
    }

    .budget-modal-box .icon-danger {
      width: 56px;
      height: 56px;
      background: var(--danger-soft);
      border-radius: 50%;
      margin: 0 auto 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .budget-modal-box .icon-danger svg {
      width: 28px;
      height: 28px;
      stroke: var(--danger);
    }

    .budget-modal-box h3 {
      font-size: 20px;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0 0 8px 0;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .budget-modal-box p {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0 0 4px 0;
      line-height: 1.6;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .budget-modal-box .budget-desc-text {
      font-weight: 700;
      color: var(--text-primary);
      background: var(--bg-card-active);
      padding: 4px 14px;
      border-radius: 8px;
      display: inline-block;
      margin-top: 4px;
      font-size: 15px;
    }

    .budget-modal-box .warning-text {
      font-size: 13px;
      color: var(--danger);
      font-weight: 500;
      margin-top: 16px;
      padding: 10px 16px;
      background: var(--danger-soft);
      border-radius: 10px;
      display: inline-block;
    }

    .budget-modal-actions {
      display: flex;
      gap: 12px;
      justify-content: center;
      margin-top: 24px;
    }

    .budget-modal-actions .btn {
      min-width: 100px;
      justify-content: center;
      padding: 10px 22px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      transition: all 0.25s ease;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .budget-modal-actions .btn .icon {
      width: 16px;
      height: 16px;
    }

    .budget-modal-actions .btn-outline {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .budget-modal-actions .btn-outline:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
      color: var(--text-primary);
    }

    .budget-modal-actions .btn-danger {
      background: var(--danger);
      color: #fff;
    }

    .budget-modal-actions .btn-danger:hover {
      background: #DC2626;
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(232, 90, 90, 0.35);
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 992px) {
      .budget-modern { padding: 0 16px; }
      .budget-stats { grid-template-columns: 1fr 1fr; }
      .budget-card .bottom { grid-template-columns: 1fr 1fr; }
      .forecast-summary { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .budget-modern { padding: 0 12px; }
      .budget-tabs { flex-direction: column; }
      .budget-tab { text-align: center; }
      .budget-card .top { flex-direction: column; }
      .budget-card .bottom { grid-template-columns: 1fr; }
      .chart-container { min-width: 400px; height: 150px; }
      .chart-bar-group .bar { width: 14px; }
      .filter-bar { 
        flex-direction: column; 
        align-items: stretch; 
        gap: 10px; 
        padding: 12px 16px;
      }
      .filter-bar form { flex-direction: column; }
      .search-wrap { min-width: 100%; }
      .filter-actions { 
        width: 100%; 
        justify-content: flex-end; 
        flex-wrap: wrap;
      }
      .budget-dropdown .dropdown-menu {
        min-width: 150px;
        right: -8px;
      }
      .forecast-summary { grid-template-columns: 1fr; }
      .budget-modal-box {
        padding: 24px 20px;
        margin: 10px;
      }
      .budget-modal-actions {
        flex-direction: column;
      }
      .budget-modal-actions .btn {
        width: 100%;
      }
    }

    @media (max-width: 640px) {
      .budget-header { flex-direction: column; }
      .budget-actions { width: 100%; }
      .budget-actions .budget-btn { flex: 1; justify-content: center; }
      .budget-stats { grid-template-columns: 1fr; gap: 12px; }
      .budget-dropdown .dropdown-menu {
        min-width: 140px;
      }
      .budget-modal-box {
        padding: 20px 16px;
      }
      .budget-modal-box h3 {
        font-size: 18px;
      }
      .budget-modal-box .icon-danger {
        width: 48px;
        height: 48px;
      }
      .budget-modal-box .icon-danger svg {
        width: 24px;
        height: 24px;
      }
    }

    @media (max-width: 380px) {
      .budget-modern { padding: 0 8px; }
      .budget-header h1 { font-size: 22px; }
      .budget-btn { font-size: 12px; padding: 8px 14px; }
      .budget-btn .icon { width: 14px; height: 14px; }
      .budget-dropdown .dropdown-menu {
        min-width: 130px;
      }
      .budget-dropdown .dropdown-menu .dropdown-item {
        font-size: 11px;
        padding: 6px 12px;
      }
    }
  </style>

  <div class="budget-modern">

    <!-- ===== HEADER ===== -->
    <div class="budget-header animate-in" style="animation-delay: 0.05s;">
      <div class="budget-header-left">
        <div class="budget-badge">
          <span class="dot"></span>
          Keuangan
        </div>
        <h1>Anggaran &amp; Forecasting</h1>
        <p class="subtitle">
          Kelola anggaran dan prediksi keuangan perusahaan — 
          <strong id="budgetTotalCount">{{ $budgetsCollection->count() }}</strong> kategori anggaran
        </p>
      </div>
      <div class="budget-actions">
        <a href="{{ route('budgets.export') }}" class="budget-btn budget-btn-ghost">
          <svg class="icon"><use href="#ic-doc"/></svg>
          Ekspor
        </a>
        <a href="{{ route('budgets.create') }}" class="budget-btn budget-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Buat Anggaran
        </a>
      </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->
    @if(session('success'))
      <div class="budget-success animate-in" style="animation-delay: 0.08s; background:var(--success-soft);border:1px solid var(--success);border-radius:var(--radius-sm);padding:14px 20px;margin-bottom:20px;color:var(--success);display:flex;align-items:center;gap:10px;">
        <svg class="icon" style="width:20px;height:20px;"><use href="#ic-check-circle"/></svg>
        <span class="message" style="font-weight:500;">{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="budget-success animate-in" style="animation-delay: 0.08s; background:var(--danger-soft);border:1px solid var(--danger);border-radius:var(--radius-sm);padding:14px 20px;margin-bottom:20px;color:var(--danger);display:flex;align-items:center;gap:10px;">
        <svg class="icon" style="width:20px;height:20px;"><use href="#ic-alert-triangle"/></svg>
        <span class="message" style="font-weight:500;">{{ session('error') }}</span>
      </div>
    @endif

    <!-- ===== FILTER BAR ===== -->
    <div class="filter-bar animate-in" style="animation-delay: 0.09s;">
      <form method="GET" action="{{ route('budgets.index') }}" id="budgetSearchForm" onsubmit="return false;">
        <div class="search-wrap">
          <svg class="icon"><use href="#ic-search"/></svg>
          <input type="text" name="q" id="budgetSearchInput" value="{{ request('q') }}" 
                 placeholder="Cari kategori, status, atau periode anggaran..." autocomplete="off">
        </div>
        <div class="filter-actions">
          <span class="search-indicator" id="searchIndicator">
            <span class="count" id="searchResultCount">0</span> hasil ditemukan
          </span>
          @if(request()->filled('q'))
            <a href="{{ route('budgets.index') }}" class="budget-btn budget-btn-ghost" id="budgetResetBtn">
              <svg class="icon"><use href="#ic-x"/></svg>
              Reset
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- ===== TABS ===== -->
    <div class="budget-tabs animate-in" style="animation-delay: 0.10s;">
      <button class="budget-tab active" data-tab="anggaran">Anggaran</button>
      <button class="budget-tab" data-tab="forecast">Forecasting</button>
    </div>

    <!-- ===== PANEL ANGGARAN ===== -->
    <div class="budget-panel active" data-panel="anggaran">
      <!-- STATS -->
      <div class="budget-stats animate-in" style="animation-delay: 0.15s;" id="budgetStats">
        <div class="budget-stat">
          <div class="number purple mono" id="statTotalTarget">{{ $currencySymbol }}{{ formatCompact($totalTarget) }}</div>
          <div class="label">Total Target</div>
        </div>
        <div class="budget-stat">
          <div class="number green mono" id="statTotalActual">{{ $currencySymbol }}{{ formatCompact($totalActual) }}</div>
          <div class="label">Realisasi</div>
        </div>
        <div class="budget-stat">
          <div class="number {{ $totalProgress >= 100 ? 'red' : 'purple' }} mono" id="statProgress">{{ $totalProgress }}%</div>
          <div class="label">Progress</div>
        </div>
        <div class="budget-stat">
          <div class="number" id="statCounts">{{ $countOnTrack }} / {{ $countOverBudget }} / {{ $countUnderBudget }}</div>
          <div class="label">On Track / Over / Under</div>
        </div>
      </div>

      <!-- BUDGET LIST -->
      <div id="budgetList">
        @forelse($budgets as $index => $b)
          <div class="budget-card budget-card-data visible-card animate-in" 
               style="animation-delay: {{ 0.20 + ($loop->index * 0.04) }}s;"
               data-category="{{ strtolower($b['category']) }}"
               data-status="{{ $b['status'] }}"
               data-period="{{ $b['period'] ?? '2026' }}">
            <div class="top">
              <div class="left">
                <span class="category">{{ $b['category'] }}</span>
              </div>
              <div class="right">
                <span class="status {{ $statusPill[$b['status']] }}">{{ $statusLabel[$b['status']] }}</span>
                
                <!-- DROPDOWN -->
                <div class="budget-dropdown">
                  <button class="dropdown-toggle" onclick="toggleDropdown(event, this)" title="Menu">
                    <svg class="icon"><use href="#ic-more"/></svg>
                  </button>
                  <div class="dropdown-menu">
                    <a href="{{ route('budgets.show', $loop->index) }}" class="dropdown-item show">
                      <svg class="icon"><use href="#ic-eye"/></svg>
                      Lihat Detail
                    </a>
                    <a href="{{ route('budgets.edit', $loop->index) }}" class="dropdown-item edit">
                      <svg class="icon"><use href="#ic-edit"/></svg>
                      Edit Anggaran
                    </a>
                    <div class="dropdown-divider"></div>
                    <button class="dropdown-item delete" onclick="openDeleteModal({{ $loop->index }}, '{{ addslashes($b['category']) }}', '{{ route('budgets.destroy', $loop->index) }}')">
                      <svg class="icon"><use href="#ic-trash"/></svg>
                      Hapus
                    </button>
                  </div>
                </div>
              </div>
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
                <div class="val mono">{{ $currencySymbol }}{{ formatCompact($b['target']) }}</div>
              </div>
              <div class="item">
                <div class="lbl">Realisasi</div>
                <div class="val mono">{{ $currencySymbol }}{{ formatCompact($b['actual']) }}</div>
              </div>
              <div class="item">
                <div class="lbl">Selisih</div>
                <div class="val mono" style="color: {{ $b['actual'] >= $b['target'] ? 'var(--success)' : 'var(--danger)' }};">
                  {{ $b['actual'] >= $b['target'] ? '+' : '-' }}{{ $currencySymbol }}{{ formatCompact(abs($b['actual'] - $b['target'])) }}
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="budget-empty" id="emptyState">
            <svg class="empty-icon"><use href="#ic-target"/></svg>
            <h3>Belum Ada Anggaran</h3>
            <p>Belum ada anggaran yang tercatat di sistem.</p>
            <a href="{{ route('budgets.create') }}" class="budget-btn budget-btn-primary" style="display: inline-flex;">
              <svg class="icon"><use href="#ic-plus"/></svg>
              Buat Anggaran Pertama
            </a>
          </div>
        @endforelse
      </div>
    </div>

    <!-- ===== PANEL FORECAST ===== -->
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
      <div class="forecast-summary">
        <div class="budget-stat animate-in" style="animation-delay: 0.20s;">
          <div class="number purple mono">{{ $currencySymbol }}{{ formatCompact($forecastCollection->sum('target')) }}</div>
          <div class="label">Target Tahunan</div>
        </div>
        <div class="budget-stat animate-in" style="animation-delay: 0.25s;">
          <div class="number green mono">{{ $currencySymbol }}{{ formatCompact($forecastCollection->whereNotNull('actual')->sum('actual')) }}</div>
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

  <!-- ===== MODAL DELETE ===== -->
  <div class="budget-modal-overlay" id="deleteModal">
    <div class="budget-modal-box">
      <div class="icon-danger">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
      </div>
      <h3>Hapus Anggaran?</h3>
      <p>
        Anda yakin ingin menghapus anggaran
        <br>
        <span class="budget-desc-text" id="deleteDesc">-</span>
      </p>
      <div class="warning-text">
        ⚠️ Data yang dihapus tidak dapat dikembalikan!
      </div>
      <div class="budget-modal-actions">
        <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
          Batal
        </button>
        <form id="deleteForm" action="" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"/>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </svg>
            Ya, Hapus!
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    // ===== DROPDOWN TOGGLE =====
    function toggleDropdown(event, button) {
      event.stopPropagation();
      const menu = button.parentElement.querySelector('.dropdown-menu');
      const isActive = menu.classList.contains('active');
      
      document.querySelectorAll('.budget-dropdown .dropdown-menu.active').forEach(m => {
        if (m !== menu) m.classList.remove('active');
      });
      
      menu.classList.toggle('active');
    }

    document.addEventListener('click', function(e) {
      if (!e.target.closest('.budget-dropdown')) {
        document.querySelectorAll('.budget-dropdown .dropdown-menu.active').forEach(menu => {
          menu.classList.remove('active');
        });
      }
    });

    // ===== DELETE MODAL =====
    function openDeleteModal(index, description, actionUrl) {
      document.querySelectorAll('.budget-dropdown .dropdown-menu.active').forEach(menu => {
        menu.classList.remove('active');
      });
      
      document.getElementById('deleteDesc').textContent = description;
      document.getElementById('deleteForm').action = actionUrl;
      document.getElementById('deleteModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('active');
      document.body.style.overflow = '';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeDeleteModal();
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeDeleteModal();
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      // ===== TAB SWITCHING =====
      const tabs = document.querySelectorAll('.budget-tab');
      const panels = document.querySelectorAll('.budget-panel');

      tabs.forEach(tab => {
        tab.addEventListener('click', function() {
          tabs.forEach(t => t.classList.remove('active'));
          this.classList.add('active');

          const target = this.dataset.tab;
          panels.forEach(panel => {
            panel.classList.toggle('active', panel.dataset.panel === target);
          });
        });
      });

      // ===== RIPPLE EFFECT =====
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
          setTimeout(() => {
            ripple.remove();
          }, 600);
        });
      });

      // ===== LIVE SEARCH =====
      const searchInput = document.getElementById('budgetSearchInput');
      const resetBtn = document.getElementById('budgetResetBtn');
      const searchIndicator = document.getElementById('searchIndicator');
      const searchResultCount = document.getElementById('searchResultCount');
      const totalCountEl = document.getElementById('budgetTotalCount');
      const budgetList = document.getElementById('budgetList');
      const emptyState = document.getElementById('emptyState');
      let debounceTimeout = null;
      const currencySymbol = '{{ $currencySymbol }}';

      function normalizeText(text) {
        if (!text) return '';
        return text.toLowerCase().trim();
      }

      function formatCompact(num) {
        if (num >= 1000000000) return (num / 1000000000).toFixed(1) + 'B';
        if (num >= 1000000) {
          let val = num / 1000000;
          return (val % 1 === 0) ? val.toFixed(0) + 'M' : val.toFixed(1) + 'M';
        }
        if (num >= 1000) {
          let val = num / 1000;
          return (val % 1 === 0) ? val.toFixed(0) + 'K' : val.toFixed(1) + 'K';
        }
        return num.toFixed(0);
      }

      function resetToInitial() {
        const cards = document.querySelectorAll('.budget-card-data');
        let totalVisible = cards.length;

        cards.forEach(card => {
          card.classList.remove('hidden-card');
          card.classList.add('visible-card');
        });

        totalCountEl.textContent = totalVisible;

        document.getElementById('statTotalTarget').textContent = currencySymbol + formatCompact({{ $totalTarget }});
        document.getElementById('statTotalActual').textContent = currencySymbol + formatCompact({{ $totalActual }});
        document.getElementById('statProgress').textContent = {{ $totalProgress }} + '%';
        document.getElementById('statCounts').textContent = '{{ $countOnTrack }} / {{ $countOverBudget }} / {{ $countUnderBudget }}';

        searchIndicator.classList.remove('active');

        if (emptyState) {
          emptyState.classList.add('hidden');
        }

        if (budgetList) {
          budgetList.style.opacity = '1';
          budgetList.style.pointerEvents = 'auto';
        }
      }

      function filterData() {
        const searchText = searchInput ? searchInput.value.trim() : '';
        const normalizedSearch = normalizeText(searchText);

        if (searchText === '') {
          resetToInitial();
          return;
        }

        const cards = document.querySelectorAll('.budget-card-data');
        let visibleCount = 0;
        let totalTargetVisible = 0;
        let totalActualVisible = 0;
        let onTrackCount = 0;
        let overBudgetCount = 0;
        let underBudgetCount = 0;

        cards.forEach(card => {
          const category = card.dataset.category || '';
          const status = card.dataset.status || '';
          const period = card.dataset.period || '';

          const targetText = card.querySelector('.bottom .item:first-child .val')?.textContent || '';
          const actualText = card.querySelector('.bottom .item:nth-child(2) .val')?.textContent || '';
          
          const targetMatch = targetText.match(/[\d.]+/);
          const actualMatch = actualText.match(/[\d.]+/);
          const target = targetMatch ? parseFloat(targetMatch[0].replace(/\./g, '')) : 0;
          const actual = actualMatch ? parseFloat(actualMatch[0].replace(/\./g, '')) : 0;

          const match = 
            normalizeText(category).includes(normalizedSearch) ||
            normalizeText(status).includes(normalizedSearch) ||
            normalizeText(period).includes(normalizedSearch) ||
            normalizeText(targetText).includes(normalizedSearch) ||
            normalizeText(actualText).includes(normalizedSearch);

          if (match) {
            card.classList.remove('hidden-card');
            card.classList.add('visible-card');
            visibleCount++;
            totalTargetVisible += target;
            totalActualVisible += actual;
            
            if (status === 'on_track') onTrackCount++;
            else if (status === 'over_budget') overBudgetCount++;
            else if (status === 'under_budget') underBudgetCount++;
          } else {
            card.classList.remove('visible-card');
            card.classList.add('hidden-card');
          }
        });

        searchIndicator.classList.add('active');
        searchResultCount.textContent = visibleCount;
        totalCountEl.textContent = visibleCount;

        const progress = totalTargetVisible > 0 ? Math.round((totalActualVisible / totalTargetVisible) * 100) : 0;
        document.getElementById('statTotalTarget').textContent = currencySymbol + formatCompact(totalTargetVisible);
        document.getElementById('statTotalActual').textContent = currencySymbol + formatCompact(totalActualVisible);
        document.getElementById('statProgress').textContent = progress + '%';
        document.getElementById('statCounts').textContent = onTrackCount + ' / ' + overBudgetCount + ' / ' + underBudgetCount;

        if (emptyState) {
          if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            const titleEl = emptyState.querySelector('h3');
            if (titleEl) titleEl.textContent = 'Tidak Ada Hasil Pencarian';
            const descEl = emptyState.querySelector('p');
            if (descEl) descEl.textContent = 'Tidak ditemukan anggaran yang sesuai dengan kata kunci "' + searchText + '"';
            const btn = emptyState.querySelector('.budget-btn');
            if (btn) btn.style.display = 'none';
          } else {
            emptyState.classList.add('hidden');
          }
        }

        if (budgetList) {
          budgetList.style.opacity = '1';
          budgetList.style.pointerEvents = 'auto';
        }
      }

      if (searchInput) {
        searchInput.addEventListener('input', function() {
          if (budgetList) {
            budgetList.style.opacity = '0.5';
            budgetList.style.pointerEvents = 'none';
          }

          clearTimeout(debounceTimeout);
          debounceTimeout = setTimeout(function() {
            filterData();
            
            const url = new URL(window.location.href);
            if (searchInput.value.trim() !== '') {
              url.searchParams.set('q', searchInput.value.trim());
            } else {
              url.searchParams.delete('q');
            }
            window.history.replaceState({}, '', url.toString());
          }, 300);
        });

        document.addEventListener('keydown', function(e) {
          if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
          }
        });
      }

      if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
          e.preventDefault();
          if (searchInput) {
            searchInput.value = '';
          }
          resetToInitial();
          const url = new URL(window.location.href);
          url.searchParams.delete('q');
          window.history.replaceState({}, '', url.toString());
          if (budgetList) {
            budgetList.style.opacity = '1';
            budgetList.style.pointerEvents = 'auto';
          }
        });
      }

      setTimeout(function() {
        resetToInitial();
      }, 100);
    });
  </script>
</x-app-layout>