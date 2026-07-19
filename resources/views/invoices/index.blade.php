<x-app-layout>
  <x-slot name="title">Semua Faktur</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // Data dari session (sudah passing $invoices dari controller)
    $invoices = $invoices ?? [
        ['client' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'date' => '2026-06-10', 'due' => '2026-07-10', 'status' => 'sent', 'amount' => 5750000],
        ['client' => 'Nusantara Logistik',      'invoice' => '#0571', 'date' => '2026-06-15', 'due' => '2026-06-25', 'status' => 'sent', 'amount' => 18400000],
        ['client' => 'Ruang Kriya Studio',      'invoice' => '#0574', 'date' => '2026-06-18', 'due' => '2026-06-28', 'status' => 'sent', 'amount' => 6200000],
        ['client' => 'Bumi Retail Group',       'invoice' => '#0552', 'date' => '2026-05-25', 'due' => '2026-06-02', 'status' => 'sent', 'amount' => 9200000],
        ['client' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'date' => '2026-06-01', 'due' => '2026-06-15', 'status' => 'paid', 'amount' => 2800000],
    ];

    $invoicesCollection = collect($invoices);
    
    $statusLabel = [
        'draft' => 'Draft',
        'sent' => 'Dikirim',
        'paid' => 'Dibayar'
    ];
    $statusPill = [
        'draft' => 'draft',
        'sent' => 'sent',
        'paid' => 'paid'
    ];

    // Hitung stats
    $totalAmount = $invoicesCollection->sum('amount');
    $paidAmount = $invoicesCollection->where('status', 'paid')->sum('amount');
    $sentAmount = $invoicesCollection->where('status', 'sent')->sum('amount');
    $draftAmount = $invoicesCollection->where('status', 'draft')->sum('amount');
    $countPaid = $invoicesCollection->where('status', 'paid')->count();
    $countSent = $invoicesCollection->where('status', 'sent')->count();
    $countDraft = $invoicesCollection->where('status', 'draft')->count();

    function formatTanggal($date) {
        if (empty($date)) return '-';
        try {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
        } catch (\Exception $e) {
            return $date;
        }
    }

    function isOverdue($dueDate, $status) {
        if ($status === 'paid') return false;
        try {
            return \Carbon\Carbon::parse($dueDate)->isPast();
        } catch (\Exception $e) {
            return false;
        }
    }
  @endphp

  <style>
    /* ============================================
       SEMUA FAKTUR - Modern Design
       ============================================ */
    
    .invoices-wrap {
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
      --info: #4E8FF0;
      --info-soft: rgba(78, 143, 240, 0.12);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .invoices-wrap * { box-sizing: border-box; }
    .invoices-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .invoices-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .invoices-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .inv-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .inv-header-left { flex: 1; min-width: 200px; }

    .inv-badge {
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

    .inv-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .inv-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .inv-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .inv-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .inv-header-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .inv-btn {
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

    .inv-btn .icon { width: 16px; height: 16px; }
    .inv-btn:hover { transform: translateY(-2px); }
    .inv-btn:active { transform: translateY(0) scale(0.97); }

    .inv-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .inv-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .inv-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .inv-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .inv-btn .ripple {
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

    /* SUCCESS MESSAGE */
    .inv-success {
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

    .inv-success .icon {
      width: 20px;
      height: 20px;
    }

    .inv-success .message {
      font-weight: 500;
    }

    /* STATS ROW */
    .inv-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .inv-stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 18px 20px;
      transition: all 0.3s ease;
    }

    .inv-stat-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .inv-stat-card .stat-label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 6px;
    }

    .inv-stat-card .stat-label .icon {
      width: 14px;
      height: 14px;
    }

    .inv-stat-card .stat-value {
      font-size: 22px;
      font-weight: 700;
      color: var(--text-primary);
    }

    .inv-stat-card .stat-value .mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .inv-stat-card .stat-sub {
      font-size: 12px;
      color: var(--text-tertiary);
      margin-top: 4px;
    }

    .inv-stat-card .stat-value.success { color: var(--success); }
    .inv-stat-card .stat-value.warning { color: var(--warning); }
    .inv-stat-card .stat-value.danger { color: var(--danger); }
    .inv-stat-card .stat-value.info { color: var(--info); }

    /* TABLE CARD */
    .inv-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      overflow: hidden;
      transition: border-color 0.22s ease;
    }

    .inv-card:hover { border-color: var(--border-hover); }

    .inv-card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      border-bottom: 1px solid var(--border-color);
    }

    .inv-card-header h3 {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
    }

    .inv-card-header .link {
      font-size: 12.5px;
      color: var(--theme-primary);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-weight: 500;
    }

    .inv-card-header .link .icon {
      width: 13px;
      height: 13px;
    }

    .inv-card-header .link:hover {
      text-decoration: underline;
    }

    .inv-table-wrap { overflow-x: auto; padding: 0 4px; }

    .inv-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }

    .inv-table th {
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-tertiary);
      padding: 14px 16px 10px;
      border-bottom: 1px solid var(--border-color);
    }

    .inv-table td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-primary);
      vertical-align: middle;
    }

    .inv-table tbody tr { transition: background 0.2s ease; }
    .inv-table tbody tr:hover { background: var(--bg-card-hover); }
    .inv-table tbody tr:last-child td { border-bottom: none; }

    /* CLIENT */
    .inv-client {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .inv-client .avatar {
      width: 34px;
      height: 34px;
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13px;
      color: #fff;
      flex-shrink: 0;
      background: var(--theme-primary);
    }

    .inv-client .info .name {
      font-weight: 600;
      color: var(--text-primary);
      font-size: 13.5px;
    }

    .inv-client .info .invoice {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 11px;
      color: var(--text-tertiary);
    }

    /* AMOUNT */
    .inv-amount {
      font-family: 'IBM Plex Mono', monospace;
      font-weight: 600;
      font-size: 13.5px;
      text-align: right;
      color: var(--text-primary);
    }

    /* DUE DATE */
    .inv-due {
      font-size: 12px;
      color: var(--text-secondary);
    }

    .inv-due.overdue {
      color: var(--danger);
    }

    .inv-due .flag {
      font-size: 10px;
      color: var(--danger);
      display: block;
      margin-top: 2px;
    }

    /* STATUS */
    .inv-status {
      font-size: 11px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 100px;
      display: inline-block;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .inv-status.draft {
      background: var(--bg-card-active);
      color: var(--text-tertiary);
    }

    .inv-status.sent {
      background: var(--info-soft);
      color: var(--info);
    }

    .inv-status.paid {
      background: var(--success-soft);
      color: var(--success);
    }

    .inv-status.overdue {
      background: var(--danger-soft);
      color: var(--danger);
    }

    /* ACTIONS */
    .inv-actions {
      display: flex;
      gap: 4px;
      justify-content: flex-end;
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .inv-table tbody tr:hover .inv-actions {
      opacity: 1;
    }

    .inv-actions a {
      width: 32px;
      height: 32px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      color: var(--text-tertiary);
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .inv-actions a .icon {
      width: 14px;
      height: 14px;
    }

    .inv-actions a:hover {
      color: var(--theme-primary);
      background: var(--theme-soft);
      border-color: var(--theme-primary);
    }

    .inv-actions a.danger:hover {
      color: var(--danger);
      background: var(--danger-soft);
      border-color: var(--danger);
    }

    /* EMPTY */
    .inv-empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-tertiary);
    }

    .inv-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .inv-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .inv-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .inv-stats { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .inv-table { font-size: 12px; }
      .inv-table th, .inv-table td { padding: 10px 12px; }
      .inv-card-header {
        padding: 14px 16px;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
      }
      .inv-actions { opacity: 1; }
    }

    @media (max-width: 640px) {
      .inv-header { flex-direction: column; }
      .inv-header-actions { width: 100%; }
      .inv-header-actions .inv-btn { flex: 1; justify-content: center; }
      .inv-stats { grid-template-columns: 1fr; gap: 12px; }
      .inv-client .info .name { font-size: 12.5px; }
      .inv-actions a { width: 28px; height: 28px; }
    }

    @media (max-width: 380px) {
      .inv-header h1 { font-size: 22px; }
      .inv-btn { font-size: 12px; padding: 8px 14px; }
      .inv-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="invoices-wrap">

    <!-- ===== HEADER ===== -->
    <div class="inv-header animate-in" style="animation-delay: 0.05s;">
      <div class="inv-header-left">
        <div class="inv-badge">
          <span class="dot"></span>
          Penjualan
        </div>
        <h1>Semua Faktur</h1>
        <p class="subtitle">
          Kelola dan pantau status semua faktur penjualan — 
          <strong>{{ $invoicesCollection->count() }}</strong> faktur
        </p>
      </div>
      <div class="inv-header-actions">
        <a href="{{ route('receivables.index') }}" class="inv-btn inv-btn-ghost">
          <svg class="icon"><use href="#ic-receive"/></svg>
          Piutang Usaha
        </a>
        <a href="{{ route('invoices.create') }}" class="inv-btn inv-btn-primary">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Faktur Baru
        </a>
      </div>
    </div>

    <!-- ===== SUCCESS MESSAGE ===== -->
    @if(session('success'))
      <div class="inv-success animate-in" style="animation-delay: 0.08s;">
        <svg class="icon"><use href="#ic-shield"/></svg>
        <span class="message">{{ session('success') }}</span>
      </div>
    @endif

    <!-- ===== STATS ===== -->
    <div class="inv-stats">
      <div class="inv-stat-card animate-in" style="animation-delay: 0.10s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-invoice"/></svg>
          Total Faktur
        </div>
        <div class="stat-value mono">{{ $currencySymbol }}{{ number_format($totalAmount, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $invoicesCollection->count() }} faktur</div>
      </div>

      <div class="inv-stat-card animate-in" style="animation-delay: 0.15s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-shield"/></svg>
          Dibayar
        </div>
        <div class="stat-value success mono">{{ $currencySymbol }}{{ number_format($paidAmount, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $countPaid }} faktur lunas</div>
      </div>

      <div class="inv-stat-card animate-in" style="animation-delay: 0.20s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-send"/></svg>
          Dikirim
        </div>
        <div class="stat-value info mono">{{ $currencySymbol }}{{ number_format($sentAmount, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $countSent }} faktur terkirim</div>
      </div>

      <div class="inv-stat-card animate-in" style="animation-delay: 0.25s;">
        <div class="stat-label">
          <svg class="icon"><use href="#ic-trending-down"/></svg>
          Draft
        </div>
        <div class="stat-value warning mono">{{ $currencySymbol }}{{ number_format($draftAmount, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $countDraft }} faktur draft</div>
      </div>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="inv-card animate-in" style="animation-delay: 0.30s;">
      <div class="inv-card-header">
        <h3>Daftar Faktur</h3>
        <a href="#" class="link">
          <svg class="icon"><use href="#ic-download"/></svg>
          Ekspor
        </a>
      </div>

      <div class="inv-table-wrap">
        <table class="inv-table">
          <thead>
            <tr>
              <th>Klien / Faktur</th>
              <th>Tanggal</th>
              <th>Jatuh Tempo</th>
              <th style="text-align:right">Jumlah</th>
              <th>Status</th>
              <th style="width:100px;"></th>
            </tr>
          </thead>
          <tbody>
            @forelse($invoices as $i)
              @php
                $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                $color = $colors[($loop->index + $loop->iteration) % count($colors)];
                $isOverdue = isOverdue($i['due'] ?? '', $i['status'] ?? '');
                $status = $isOverdue ? 'overdue' : ($i['status'] ?? 'draft');
                $statusDisplay = $isOverdue ? 'overdue' : $i['status'];
              @endphp
              <tr>
                <td>
                  <div class="inv-client">
                    <div class="avatar" style="background: {{ $color }};">
                      {{ mb_substr($i['client'] ?? '?', 0, 1) }}
                    </div>
                    <div class="info">
                      <div class="name">{{ $i['client'] ?? 'Unknown Client' }}</div>
                      <div class="invoice">{{ $i['invoice'] ?? '#' }}</div>
                    </div>
                  </div>
                </td>
                <td>{{ formatTanggal($i['date'] ?? '') }}</td>
                <td>
                  <span class="inv-due {{ $isOverdue ? 'overdue' : '' }}">
                    {{ formatTanggal($i['due'] ?? '') }}
                    @if($isOverdue)
                      <span class="flag">⚠️ Lewat jatuh tempo</span>
                    @endif
                  </span>
                </td>
                <td class="inv-amount mono">{{ $currencySymbol }}{{ number_format($i['amount'] ?? 0, 0, ',', '.') }}</td>
                <td>
                  <span class="inv-status {{ $status }}">
                    {{ $statusLabel[$statusDisplay] ?? $statusDisplay }}
                  </span>
                </td>
                <td>
                  <div class="inv-actions">
                    <a href="#" title="Detail">
                      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                    </a>
                    <a href="#" title="Edit">
                      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                        <path d="M15 5l4 4"/>
                      </svg>
                    </a>
                    <a href="#" class="danger" title="Hapus" onclick="return confirm('Yakin mau hapus faktur {{ $i['invoice'] ?? 'ini' }}?');">
                      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/>
                        <path d="M14 11v6"/>
                      </svg>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="inv-empty">
                    <svg class="empty-icon"><use href="#ic-invoice"/></svg>
                    <h3>Belum Ada Faktur</h3>
                    <p>Belum ada faktur yang tercatat di sistem.</p>
                    <a href="{{ route('invoices.create') }}" class="inv-btn inv-btn-primary" style="display: inline-flex;">
                      <svg class="icon"><use href="#ic-plus"/></svg>
                      Buat Faktur Pertama
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
      const buttons = document.querySelectorAll('.inv-btn');
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