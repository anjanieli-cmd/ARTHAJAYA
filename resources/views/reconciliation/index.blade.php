<x-app-layout>
  <x-slot name="title">Rekonsiliasi Bank</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Data dari session (sudah passing $reconciliations dari controller)
    $items = $reconciliations ?? [
        ['desc' => 'Transfer masuk dari Nusantara Logistik', 'date' => '2026-07-02', 'bank' => 18400000, 'buku' => 18400000, 'status' => 'cocok'],
        ['desc' => 'Pembayaran listrik workshop',            'date' => '2026-07-06', 'bank' => 820000,    'buku' => 820000,    'status' => 'cocok'],
        ['desc' => 'Setoran tunai penjualan',                'date' => '2026-07-09', 'bank' => 1500000,   'buku' => 0,          'status' => 'belum'],
        ['desc' => 'Biaya admin bank',                       'date' => '2026-07-10', 'bank' => 25000,     'buku' => 0,          'status' => 'belum'],
        ['desc' => 'Transfer masuk dari Ruang Kriya Studio',  'date' => '2026-07-12', 'bank' => 6200000,   'buku' => 6200000,   'status' => 'cocok'],
    ];

    $itemsCollection = collect($items);
    $statusLabel = ['cocok' => 'Cocok', 'belum' => 'Belum Rekon'];
    $statusPill  = ['cocok' => 'cocok', 'belum' => 'belum'];

    $saldoBank   = $itemsCollection->sum('bank');
    $saldoBuku   = $itemsCollection->sum('buku');
    $selisih     = $saldoBank - $saldoBuku;
    $countBelum  = $itemsCollection->where('status', 'belum')->count();
    $countCocok  = $itemsCollection->where('status', 'cocok')->count();
    
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
       REKONSILIASI BANK - Modern Design
       ============================================ */
    
    .rek-modern {
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

    .rek-modern * {
      box-sizing: border-box;
    }

    .rek-modern .mono {
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

    .rek-modern .animate-in {
      animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      opacity: 0;
    }

    /* ----- SVG ICON BASE ----- */
    .rek-modern .icon {
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
    .rek-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .rek-header-left {
      flex: 1;
      min-width: 200px;
    }

    .rek-badge {
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

    .rek-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .rek-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .rek-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .rek-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .rek-header-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .rek-btn {
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

    .rek-btn .icon {
      width: 16px;
      height: 16px;
    }

    .rek-btn:hover {
      transform: translateY(-2px);
    }

    .rek-btn:active {
      transform: translateY(0) scale(0.97);
    }

    .rek-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .rek-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .rek-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .rek-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .rek-btn .ripple {
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

    /* ----- SUCCESS MESSAGE ----- */
    .rek-success {
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

    .rek-success .icon {
      width: 20px;
      height: 20px;
    }

    .rek-success .message {
      font-weight: 500;
    }

    /* ----- STATS ROW ----- */
    .rek-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 28px;
    }

    .rek-stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 22px 24px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }

    .rek-stat-card::before {
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

    .rek-stat-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .rek-stat-card:hover::before {
      opacity: 1;
    }

    .rek-stat-card .stat-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 12px;
    }

    .rek-stat-card .stat-head .ic {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .rek-stat-card .stat-head .ic .icon {
      width: 17px;
      height: 17px;
    }

    .rek-stat-card .stat-head .badge {
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 100px;
      background: var(--warning-soft);
      color: var(--warning);
    }

    .rek-stat-card .stat-head .badge.success {
      background: var(--success-soft);
      color: var(--success);
    }

    .rek-stat-card .stat-label {
      font-size: 12px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 4px;
    }

    .rek-stat-card .stat-value {
      font-size: 26px;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: var(--text-primary);
    }

    .rek-stat-card .stat-value.primary {
      color: var(--theme-primary);
    }

    .rek-stat-card .stat-value.success {
      color: var(--success);
    }

    .rek-stat-card .stat-value.warning {
      color: var(--warning);
    }

    .rek-stat-card .stat-sub {
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 4px;
    }

    /* ----- TABLE CARD ----- */
    .rek-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      overflow: hidden;
      transition: border-color 0.22s ease;
    }

    .rek-card:hover {
      border-color: var(--border-hover);
    }

    .rek-card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 24px;
      border-bottom: 1px solid var(--border-color);
    }

    .rek-card-header h3 {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
    }

    .rek-card-header .link {
      font-size: 12.5px;
      color: var(--theme-primary);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-weight: 500;
    }

    .rek-card-header .link .icon {
      width: 13px;
      height: 13px;
    }

    .rek-card-header .link:hover {
      text-decoration: underline;
    }

    /* ----- TABLE ----- */
    .rek-table-wrap {
      overflow-x: auto;
      padding: 0 4px;
    }

    .rek-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }

    .rek-table th {
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-tertiary);
      padding: 14px 16px 10px;
      border-bottom: 1px solid var(--border-color);
    }

    .rek-table td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-primary);
      vertical-align: middle;
    }

    .rek-table tbody tr {
      transition: background 0.2s ease;
    }

    .rek-table tbody tr:hover {
      background: var(--bg-card-hover);
    }

    .rek-table tbody tr:last-child td {
      border-bottom: none;
    }

    /* ----- DESCRIPTION ----- */
    .rek-desc {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .rek-desc .icon-wrap {
      width: 34px;
      height: 34px;
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--theme-soft);
      color: var(--theme-primary);
      flex-shrink: 0;
    }

    .rek-desc .icon-wrap .icon {
      width: 15px;
      height: 15px;
    }

    .rek-desc .text {
      font-weight: 500;
      color: var(--text-primary);
    }

    /* ----- AMOUNT CELL ----- */
    .rek-amount {
      font-family: 'IBM Plex Mono', monospace;
      font-weight: 600;
      font-size: 13.5px;
      text-align: right;
      color: var(--text-primary);
    }

    .rek-amount.different {
      color: var(--warning);
    }

    /* ----- STATUS PILL ----- */
    .rek-status {
      font-size: 11px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 100px;
      display: inline-block;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .rek-status.cocok {
      background: var(--success-soft);
      color: var(--success);
    }

    .rek-status.belum {
      background: var(--warning-soft);
      color: var(--warning);
    }

    /* ----- ROW ACTIONS ----- */
    .rek-actions {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .rek-table tbody tr:hover .rek-actions {
      opacity: 1;
    }

    .rek-actions a {
      font-size: 12px;
      color: var(--text-tertiary);
      text-decoration: none;
      padding: 4px 10px;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .rek-actions a:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    /* ----- EMPTY STATE ----- */
    .rek-empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-tertiary);
    }

    .rek-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .rek-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .rek-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 992px) {
      .rek-stats {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      .rek-table {
        font-size: 12.5px;
      }

      .rek-table th,
      .rek-table td {
        padding: 10px 12px;
      }

      .rek-card-header {
        padding: 14px 16px;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
      }
    }

    @media (max-width: 640px) {
      .rek-header {
        flex-direction: column;
      }
      
      .rek-header-actions {
        width: 100%;
      }
      
      .rek-header-actions .rek-btn {
        flex: 1;
        justify-content: center;
      }

      .rek-stats {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .rek-stat-card .stat-value {
        font-size: 22px;
      }

      .rek-actions {
        opacity: 1;
        flex-direction: column;
        gap: 4px;
      }

      .rek-actions a {
        font-size: 11px;
        padding: 2px 6px;
      }

      .rek-desc .text {
        font-size: 12.5px;
      }
    }

    @media (max-width: 380px) {
      .rek-header h1 {
        font-size: 22px;
      }
      .rek-btn {
        font-size: 12px;
        padding: 8px 14px;
      }
      .rek-btn .icon {
        width: 14px;
        height: 14px;
      }
    }
  </style>

  <div class="rek-modern">

    <!-- ===== HEADER ===== -->
    <div class="rek-header animate-in" style="animation-delay: 0.05s;">
      <div class="rek-header-left">
        <div class="rek-badge">
          <span class="dot"></span>
          Perbankan
        </div>
        <h1>Rekonsiliasi Bank</h1>
        <p class="subtitle">
          Cocokkan mutasi rekening bank dengan catatan pembukuan — 
          <strong>{{ $itemsCollection->count() }}</strong> transaksi
        </p>
      </div>
      <div class="rek-header-actions">
        <a href="{{ route('bank-mutations.index') }}" class="rek-btn rek-btn-ghost">
          <svg class="icon"><use href="#ic-bank"/></svg>
          Mutasi Rekening
        </a>
        <a href="{{ route('reconciliation.create') }}" class="rek-btn rek-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah Rekonsiliasi
        </a>
      </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->
    @if(session('success'))
      <div class="rek-success animate-in" style="animation-delay: 0.08s;">
        <svg class="icon"><use href="#ic-shield"/></svg>
        <span class="message">{{ session('success') }}</span>
      </div>
    @endif

    <!-- ===== STATS ===== -->
    <div class="rek-stats">
      <div class="rek-stat-card animate-in" style="animation-delay: 0.10s;">
        <div class="stat-head">
          <div class="ic"><svg class="icon"><use href="#ic-bank"/></svg></div>
        </div>
        <div class="stat-label">Saldo Bank</div>
        <div class="stat-value primary mono">{{ $currencySymbol }}{{ number_format($saldoBank, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $countCocok }} transaksi tercocokkan</div>
      </div>

      <div class="rek-stat-card animate-in" style="animation-delay: 0.15s;">
        <div class="stat-head">
          <div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div>
        </div>
        <div class="stat-label">Saldo Buku</div>
        <div class="stat-value success mono">{{ $currencySymbol }}{{ number_format($saldoBuku, 0, ',', '.') }}</div>
        <div class="stat-sub">Catatan pembukuan</div>
      </div>

      <div class="rek-stat-card animate-in" style="animation-delay: 0.20s;">
        <div class="stat-head">
          <div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div>
          <span class="badge">{{ $countBelum }} transaksi</span>
        </div>
        <div class="stat-label">Selisih Belum Rekon</div>
        <div class="stat-value warning mono">{{ $currencySymbol }}{{ number_format($selisih, 0, ',', '.') }}</div>
        <div class="stat-sub">Perlu ditelusuri</div>
      </div>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="rek-card animate-in" style="animation-delay: 0.25s;">
      <div class="rek-card-header">
        <h3>Daftar Rekonsiliasi</h3>
        <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="link">
          Buku besar bank
          <svg class="icon"><use href="#ic-arrow-right"/></svg>
        </a>
      </div>

      <div class="rek-table-wrap">
        <table class="rek-table">
          <thead>
            <tr>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th style="text-align:right">Jumlah Bank</th>
              <th style="text-align:right">Jumlah Buku</th>
              <th>Status</th>
              <th style="width:80px;"></th>
            </tr>
          </thead>
          <tbody>
            @forelse($items as $i)
              <tr>
                <td>
                  <div class="rek-desc">
                    <div class="icon-wrap">
                      <svg class="icon"><use href="#ic-bank"/></svg>
                    </div>
                    <span class="text">{{ $i['desc'] }}</span>
                  </div>
                </td>
                <td>{{ formatTanggal($i['date']) }}</td>
                <td class="rek-amount mono">
                  {{ $currencySymbol }}{{ number_format($i['bank'], 0, ',', '.') }}
                </td>
                <td class="rek-amount mono {{ $i['bank'] != $i['buku'] ? 'different' : '' }}">
                  {{ $currencySymbol }}{{ number_format($i['buku'], 0, ',', '.') }}
                  @if($i['bank'] != $i['buku'])
                    <span style="font-size:10px; color: var(--warning);">(!)</span>
                  @endif
                </td>
                <td>
                  <span class="rek-status {{ $statusPill[$i['status']] }}">
                    {{ $statusLabel[$i['status']] }}
                  </span>
                </td>
                <td>
                  <div class="rek-actions">
                    <a href="#">Cocokkan</a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="rek-empty">
                    <svg class="empty-icon"><use href="#ic-bank"/></svg>
                    <h3>Belum Ada Data Rekonsiliasi</h3>
                    <p>Belum ada transaksi yang direkonsiliasi.</p>
                    <a href="{{ route('reconciliation.create') }}" class="rek-btn rek-btn-primary" style="display: inline-flex;">
                      <svg class="icon"><use href="#ic-plus"/></svg>
                      Mulai Rekonsiliasi
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
      // Ripple effect untuk tombol
      const buttons = document.querySelectorAll('.rek-btn');
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