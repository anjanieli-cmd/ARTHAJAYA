<x-app-layout>
  <x-slot name="title">Detail PPh</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // 🔧 Pakai data ASLI dari controller, bukan dummy
    $tax = $pph ?? [];
    $tax['id'] = $index ?? 0;

    // Default values jika ada yang kosong
    $tax = array_merge([
        'id' => 0,
        'period' => 'Tidak Diketahui',
        'gross' => 0,
        'deduction' => 0,
        'tax' => 0,
        'due' => date('Y-m-d'),
        'status' => 'pending',
        'notes' => '-',
        'created_by' => '-',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ], $tax);

    // Fungsi format angka ke jutaan (M)
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

    $statusLabel = [
        'pending' => 'Pending',
        'paid' => 'Dibayar'
    ];
    $statusBadge = [
        'pending' => 'pending',
        'paid' => 'paid'
    ];
  @endphp

  <style>
    /* ============================================
       PPH DETAIL - Premium Design
       ============================================ */
    
    .pd-wrap {
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
      max-width: 100%;
      padding: 0 24px;
    }

    .pd-wrap * { box-sizing: border-box; }
    .pd-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    .pd-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .pd-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .pd-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .pd-header-left { flex: 1; min-width: 200px; }

    .pd-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 16px 6px 12px;
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

    .pd-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .pd-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .pd-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .pd-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .pd-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .pd-btn {
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

    .pd-btn .icon { width: 16px; height: 16px; }
    .pd-btn:hover { transform: translateY(-2px); }
    .pd-btn:active { transform: translateY(0) scale(0.97); }

    .pd-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pd-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .pd-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .pd-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .pd-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    /* CONTENT LAYOUT */
    .pd-content {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 24px;
      align-items: start;
    }

    .pd-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 30px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .pd-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .pd-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .pd-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .pd-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* INFO GROUP */
    .pd-info-group {
      margin-bottom: 16px;
    }

    .pd-info-group:last-child { margin-bottom: 0; }

    .pd-info-group .label {
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      display: block;
      margin-bottom: 4px;
    }

    .pd-info-group .value {
      font-size: 15px;
      font-weight: 500;
      color: var(--text-primary);
    }

    .pd-info-group .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .pd-info-group .value .badge {
      display: inline-block;
      padding: 4px 14px;
      border-radius: 100px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .pd-info-group .value .badge.pending {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .pd-info-group .value .badge.paid {
      background: var(--success-soft);
      color: var(--success);
    }

    .pd-info-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    /* SIDEBAR */
    .pd-sidebar {
      position: sticky;
      top: 80px;
    }

    .pd-summary-item {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid var(--border-color);
      font-size: 13px;
    }

    .pd-summary-item:last-child { border-bottom: none; }

    .pd-summary-item .label {
      color: var(--text-secondary);
    }

    .pd-summary-item .value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .pd-summary-item .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .pd-summary-total {
      padding: 16px 0 4px;
      display: flex;
      justify-content: space-between;
      font-size: 18px;
      font-weight: 700;
      border-top: 2px solid var(--theme-primary);
      margin-top: 4px;
    }

    .pd-summary-total .label {
      color: var(--text-primary);
    }

    .pd-summary-total .value {
      color: var(--theme-primary);
    }

    .pd-summary-total .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .pd-meta {
      margin-top: 16px;
      padding-top: 16px;
      border-top: 1px solid var(--border-color);
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .pd-meta .meta-item {
      display: flex;
      justify-content: space-between;
      padding: 4px 0;
    }

    .pd-meta .meta-item .meta-label {
      color: var(--text-tertiary);
    }

    .pd-meta .meta-item .meta-value {
      color: var(--text-secondary);
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .pd-content { grid-template-columns: 1fr; }
      .pd-sidebar { position: static; }
      .pd-info-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .pd-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .pd-header { flex-direction: column; }
      .pd-actions { width: 100%; }
      .pd-actions .pd-btn { flex: 1; justify-content: center; }
    }

    @media (max-width: 380px) {
      .pd-header h1 { font-size: 22px; }
      .pd-btn { font-size: 12px; padding: 8px 14px; }
      .pd-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="pd-wrap">

    <!-- ===== HEADER ===== -->
    <div class="pd-header animate-in" style="animation-delay: 0.05s;">
      <div class="pd-header-left">
        <div class="pd-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Detail PPh</h1>
        <p class="subtitle">
          Pajak Penghasilan — <strong>periode {{ $tax['period'] }}</strong>
        </p>
      </div>
      <div class="pd-actions">
        <a href="{{ route('taxes.pph') }}" class="pd-btn pd-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
        <a href="{{ route('taxes.pph.edit', $tax['id']) }}" class="pd-btn pd-btn-primary">
          <svg class="icon"><use href="#ic-edit"/></svg>
          Edit
        </a>
      </div>
    </div>

    <!-- ===== CONTENT ===== -->
    <div class="pd-content">

      <!-- MAIN INFO -->
      <div class="pd-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-tax"/></svg>
          Informasi PPh
          <span class="line"></span>
        </div>

        <div class="pd-info-group">
          <span class="label">Periode</span>
          <div class="value">{{ $tax['period'] }}</div>
        </div>

        <div class="pd-info-row">
          <div class="pd-info-group">
            <span class="label">Penghasilan Bruto</span>
            <div class="value mono">{{ $currencySymbol }}{{ formatCompact($tax['gross']) }}</div>
          </div>
          <div class="pd-info-group">
            <span class="label">Pengurang</span>
            <div class="value mono">{{ $currencySymbol }}{{ formatCompact($tax['deduction']) }}</div>
          </div>
        </div>

        <div class="pd-info-group">
          <span class="label">PPh Terutang</span>
          <div class="value mono" style="font-size:20px;font-weight:700;color:var(--theme-primary);">
            {{ $currencySymbol }}{{ formatCompact($tax['tax']) }}
          </div>
        </div>

        <div class="pd-info-row">
          <div class="pd-info-group">
            <span class="label">Jatuh Tempo</span>
            <div class="value">{{ isset($tax['due']) ? date('d/m/Y', strtotime($tax['due'])) : '-' }}</div>
          </div>
          <div class="pd-info-group">
            <span class="label">Status</span>
            <div class="value">
              <span class="badge {{ $statusBadge[$tax['status']] ?? 'pending' }}">
                {{ $statusLabel[$tax['status']] ?? 'Pending' }}
              </span>
            </div>
          </div>
        </div>

        <div class="pd-info-group">
          <span class="label">Catatan</span>
          <div class="value">{{ $tax['notes'] ?? '-' }}</div>
        </div>
      </div>

      <!-- SIDEBAR -->
      <div class="pd-sidebar">
        <div class="pd-card animate-in" style="animation-delay: 0.15s;">
          <div class="title">
            <svg class="icon"><use href="#ic-target"/></svg>
            Ringkasan
            <span class="line"></span>
          </div>

          <div class="pd-summary-item">
            <span class="label">Periode</span>
            <span class="value">{{ $tax['period'] }}</span>
          </div>
          <div class="pd-summary-item">
            <span class="label">Penghasilan Bruto</span>
            <span class="value mono">{{ $currencySymbol }}{{ formatCompact($tax['gross']) }}</span>
          </div>
          <div class="pd-summary-item">
            <span class="label">Pengurang</span>
            <span class="value mono">{{ $currencySymbol }}{{ formatCompact($tax['deduction']) }}</span>
          </div>
          <div class="pd-summary-item">
            <span class="label">Status</span>
            <span class="value">
              <span class="badge {{ $statusBadge[$tax['status']] ?? 'pending' }}" style="display:inline-block;padding:2px 10px;border-radius:100px;font-size:11px;">
                {{ $statusLabel[$tax['status']] ?? 'Pending' }}
              </span>
            </span>
          </div>

          <div class="pd-summary-total">
            <span class="label">PPh Terutang</span>
            <span class="value mono">{{ $currencySymbol }}{{ formatCompact($tax['tax']) }}</span>
          </div>

          <div class="pd-meta">
            <div class="meta-item">
              <span class="meta-label">Dibuat oleh</span>
              <span class="meta-value">{{ $tax['created_by'] ?? '-' }}</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Dibuat pada</span>
              <span class="meta-value">{{ isset($tax['created_at']) ? date('d/m/Y H:i', strtotime($tax['created_at'])) : '-' }}</span>
            </div>
            @if(isset($tax['created_at']) && isset($tax['updated_at']) && $tax['created_at'] != $tax['updated_at'])
            <div class="meta-item">
              <span class="meta-label">Terakhir diupdate</span>
              <span class="meta-value">{{ isset($tax['updated_at']) ? date('d/m/Y H:i', strtotime($tax['updated_at'])) : '-' }}</span>
            </div>
            @endif
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></symbol>
    <symbol id="ic-tax" viewBox="0 0 24 24"><path d="M12 2L2 7v4c0 5.52 3.12 10.56 10 11 6.88-.44 10-5.48 10-11V7L12 2z"/><polyline points="12 11 12 17 16 17"/><line x1="8" y1="17" x2="16" y2="17"/></symbol>
    <symbol id="ic-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.pd-btn');
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