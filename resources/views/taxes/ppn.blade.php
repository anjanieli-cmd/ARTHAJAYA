<x-app-layout>
  <x-slot name="title">PPN - Pajak Pertambahan Nilai</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Data dari session (sudah passing $ppnData dari controller)
    $ppnData = $ppnData ?? [
        ['period' => 'Januari 2026', 'output' => 4500000, 'input' => 1200000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-02-28'],
        ['period' => 'Februari 2026', 'output' => 4800000, 'input' => 1500000, 'ppn' => 3300000, 'status' => 'paid', 'due' => '2026-03-31'],
        ['period' => 'Maret 2026', 'output' => 5200000, 'input' => 1800000, 'ppn' => 3400000, 'status' => 'paid', 'due' => '2026-04-30'],
        ['period' => 'April 2026', 'output' => 4900000, 'input' => 1400000, 'ppn' => 3500000, 'status' => 'pending', 'due' => '2026-05-31'],
        ['period' => 'Mei 2026', 'output' => 5100000, 'input' => 1600000, 'ppn' => 3500000, 'status' => 'pending', 'due' => '2026-06-30'],
    ];

    $ppnCollection = collect($ppnData);
    $statusLabel = ['paid' => 'Dibayar', 'pending' => 'Pending'];
    $statusPill  = ['paid' => 'paid', 'pending' => 'pending'];

    $totalPpn = $ppnCollection->sum('ppn');
    $totalPaid = $ppnCollection->where('status', 'paid')->sum('ppn');
    $totalPending = $ppnCollection->where('status', 'pending')->sum('ppn');
  @endphp

  <style>
    .ppn-wrap {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .ppn-wrap * { box-sizing: border-box; }
    .ppn-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .ppn-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .ppn-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* SUCCESS MESSAGE */
    .ppn-success {
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

    .ppn-success .icon {
      width: 20px;
      height: 20px;
    }

    .ppn-success .message {
      font-weight: 500;
    }

    /* HEADER */
    .ppn-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .ppn-header-left { flex: 1; min-width: 200px; }

    .ppn-badge {
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

    .ppn-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .ppn-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .ppn-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .ppn-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    .ppn-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .ppn-btn {
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

    .ppn-btn .icon { width: 16px; height: 16px; }
    .ppn-btn:hover { transform: translateY(-2px); }
    .ppn-btn:active { transform: translateY(0) scale(0.97); }

    .ppn-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .ppn-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .ppn-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .ppn-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .ppn-btn .ripple {
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

    /* STATS */
    .ppn-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .ppn-stat {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 18px 20px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .ppn-stat:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .ppn-stat .number {
      font-size: 24px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .ppn-stat .number.purple { color: var(--theme-primary); }
    .ppn-stat .number.green { color: var(--success); }
    .ppn-stat .number.yellow { color: var(--warning); }

    .ppn-stat .label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-top: 4px;
    }

    /* TABLE CARD */
    .ppn-card-table {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      overflow: hidden;
      transition: border-color 0.22s ease;
    }

    .ppn-card-table:hover { border-color: var(--border-hover); }

    .ppn-card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      border-bottom: 1px solid var(--border-color);
    }

    .ppn-card-header h3 {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
    }

    .ppn-card-header .link {
      font-size: 12.5px;
      color: var(--theme-primary);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-weight: 500;
    }

    .ppn-card-header .link .icon { width: 13px; height: 13px; }
    .ppn-card-header .link:hover { text-decoration: underline; }

    .ppn-table-wrap { overflow-x: auto; padding: 0 4px; }

    .ppn-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }

    .ppn-table th {
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-tertiary);
      padding: 14px 16px 10px;
      border-bottom: 1px solid var(--border-color);
    }

    .ppn-table td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-primary);
      vertical-align: middle;
    }

    .ppn-table tbody tr { transition: background 0.2s ease; }
    .ppn-table tbody tr:hover { background: var(--bg-card-hover); }
    .ppn-table tbody tr:last-child td { border-bottom: none; }

    .ppn-amount {
      font-family: 'IBM Plex Mono', monospace;
      font-weight: 600;
      font-size: 13px;
      text-align: right;
      color: var(--text-primary);
    }

    .ppn-amount.paid { color: var(--success); }
    .ppn-amount.pending { color: var(--warning); }

    .ppn-status {
      font-size: 11px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 100px;
      display: inline-block;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .ppn-status.paid {
      background: var(--success-soft);
      color: var(--success);
    }

    .ppn-status.pending {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .ppn-actions-row {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .ppn-table tbody tr:hover .ppn-actions-row { opacity: 1; }

    .ppn-actions-row a {
      font-size: 12px;
      color: var(--text-tertiary);
      text-decoration: none;
      padding: 4px 10px;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .ppn-actions-row a:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    .ppn-actions-row a.primary:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    /* EMPTY */
    .ppn-empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-tertiary);
    }

    .ppn-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .ppn-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .ppn-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    @media (max-width: 992px) {
      .ppn-stats { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .ppn-table { font-size: 12.5px; }
      .ppn-table th, .ppn-table td { padding: 10px 12px; }
      .ppn-card-header {
        padding: 14px 16px;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
      }
    }

    @media (max-width: 640px) {
      .ppn-header { flex-direction: column; }
      .ppn-actions { width: 100%; }
      .ppn-actions .ppn-btn { flex: 1; justify-content: center; }
      .ppn-stats { grid-template-columns: 1fr; gap: 12px; }
      .ppn-actions-row { opacity: 1; flex-direction: column; gap: 4px; }
      .ppn-actions-row a { font-size: 11px; padding: 2px 6px; }
    }

    @media (max-width: 380px) {
      .ppn-header h1 { font-size: 22px; }
      .ppn-btn { font-size: 12px; padding: 8px 14px; }
      .ppn-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="ppn-wrap">

    <div class="ppn-header animate-in" style="animation-delay: 0.05s;">
      <div class="ppn-header-left">
        <div class="ppn-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Pajak Pertambahan Nilai (PPN)</h1>
        <p class="subtitle">
          Kelola kewajiban PPN perusahaan — 
          <strong>{{ $ppnCollection->count() }}</strong> periode pajak
        </p>
      </div>
      <div class="ppn-actions">
        <a href="{{ route('taxes.pph') }}" class="ppn-btn ppn-btn-ghost">
          <svg class="icon"><use href="#ic-building"/></svg>
          PPh
        </a>
        <a href="{{ route('tax-calendar.index') }}" class="ppn-btn ppn-btn-ghost">
          <svg class="icon"><use href="#ic-calendar"/></svg>
          Kalender Pajak
        </a>
        <a href="{{ route('taxes.ppn.create') }}" class="ppn-btn ppn-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah PPN
        </a>
      </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->
    @if(session('success'))
      <div class="ppn-success animate-in" style="animation-delay: 0.08s;">
        <svg class="icon"><use href="#ic-shield"/></svg>
        <span class="message">{{ session('success') }}</span>
      </div>
    @endif

    <!-- STATS -->
    <div class="ppn-stats animate-in" style="animation-delay: 0.10s;">
      <div class="ppn-stat">
        <div class="number purple mono">{{ $currencySymbol }}{{ number_format($totalPpn, 0, ',', '.') }}</div>
        <div class="label">Total PPN</div>
      </div>
      <div class="ppn-stat">
        <div class="number green mono">{{ $currencySymbol }}{{ number_format($totalPaid, 0, ',', '.') }}</div>
        <div class="label">Sudah Dibayar</div>
      </div>
      <div class="ppn-stat">
        <div class="number yellow mono">{{ $currencySymbol }}{{ number_format($totalPending, 0, ',', '.') }}</div>
        <div class="label">Belum Dibayar</div>
      </div>
      <div class="ppn-stat">
        <div class="number">{{ $ppnCollection->where('status','paid')->count() }} / {{ $ppnCollection->count() }}</div>
        <div class="label">Periode Selesai</div>
      </div>
    </div>

    <!-- TABLE -->
    <div class="ppn-card-table animate-in" style="animation-delay: 0.15s;">
      <div class="ppn-card-header">
        <h3>Daftar PPN</h3>
        <a href="#" class="link">
          Ekspor CSV
          <svg class="icon"><use href="#ic-arrow-right"/></svg>
        </a>
      </div>

      <div class="ppn-table-wrap">
        <table class="ppn-table">
          <thead>
            <tr>
              <th>Periode</th>
              <th style="text-align:right">PPN Keluaran</th>
              <th style="text-align:right">PPN Masukan</th>
              <th style="text-align:right">PPN</th>
              <th>Jatuh Tempo</th>
              <th>Status</th>
              <th style="width:80px;"></th>
            </tr>
          </thead>
          <tbody>
            @forelse($ppnData as $p)
              <tr>
                <td>{{ $p['period'] }}</td>
                <td class="ppn-amount mono">{{ $currencySymbol }}{{ number_format($p['output'], 0, ',', '.') }}</td>
                <td class="ppn-amount mono">{{ $currencySymbol }}{{ number_format($p['input'], 0, ',', '.') }}</td>
                <td class="ppn-amount {{ $statusPill[$p['status']] }} mono">{{ $currencySymbol }}{{ number_format($p['ppn'], 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($p['due'])->translatedFormat('d F Y') }}</td>
                <td>
                  <span class="ppn-status {{ $statusPill[$p['status']] }}">{{ $statusLabel[$p['status']] }}</span>
                </td>
                <td>
                  <div class="ppn-actions-row">
                    @if($p['status'] == 'pending')
                      <a href="#" class="primary">Bayar</a>
                    @endif
                    <a href="#">Detail</a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7">
                  <div class="ppn-empty">
                    <svg class="empty-icon"><use href="#ic-building"/></svg>
                    <h3>Belum Ada Data PPN</h3>
                    <p>Belum ada data PPN yang tercatat di sistem.</p>
                    <a href="{{ route('taxes.ppn.create') }}" class="ppn-btn ppn-btn-primary" style="display: inline-flex;">
                      <svg class="icon"><use href="#ic-plus"/></svg>
                      Tambah PPN
                    </a>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.ppn-btn');
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