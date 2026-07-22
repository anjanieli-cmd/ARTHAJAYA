<x-app-layout>
  <x-slot name="title">Detail Anggaran</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    $statusLabel = ['on_track' => 'On Track', 'over_budget' => 'Over Budget', 'under_budget' => 'Under Budget'];
    $statusColor = ['on_track' => 'var(--success)', 'over_budget' => 'var(--danger)', 'under_budget' => 'var(--warning)'];
    $statusPill = ['on_track' => 'on-track', 'over_budget' => 'over-budget', 'under_budget' => 'under-budget'];

    // Pastikan $budget adalah array
    if (is_object($budget)) {
        $budget = (array) $budget;
    }

    // Default values jika ada yang kosong
    $budget = array_merge([
        'id' => 0,
        'category' => 'Tidak Diketahui',
        'period' => date('Y'),
        'target' => 0,
        'actual' => 0,
        'status' => 'on_track',
        'notes' => '',
        'created_by' => '-',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ], $budget);

    $progress = $budget['target'] > 0 ? round(($budget['actual'] / $budget['target']) * 100) : 0;
    $progressColor = $progress > 100 ? 'red' : ($progress < 70 ? 'yellow' : 'green');
  @endphp

  <style>
    /* ============================================
       BUDGET SHOW - Premium Design
       ============================================ */
    
    .bs-wrap {
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

    .bs-wrap * { box-sizing: border-box; }
    .bs-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .bs-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .bs-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .bs-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .bs-header-left { flex: 1; min-width: 200px; }

    .bs-badge {
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

    .bs-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .bs-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .bs-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .bs-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .bs-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .bs-btn {
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

    .bs-btn .icon { width: 16px; height: 16px; }
    .bs-btn:hover { transform: translateY(-2px); }
    .bs-btn:active { transform: translateY(0) scale(0.97); }

    .bs-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
      border: none;
    }

    .bs-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .bs-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .bs-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .bs-btn-danger {
      background: var(--danger);
      color: #fff;
      border: none;
    }

    .bs-btn-danger:hover {
      background: #DC2626;
      color: #fff;
      transform: translateY(-2px);
    }

    .bs-btn .ripple {
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

    /* CONTENT */
    .bs-content {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 24px;
      align-items: start;
    }

    .bs-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .bs-card:hover { border-color: var(--border-hover); }

    .bs-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .bs-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .bs-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* INFO GROUP */
    .bs-info-group {
      margin-bottom: 16px;
    }

    .bs-info-group:last-child { margin-bottom: 0; }

    .bs-info-group .label {
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      display: block;
      margin-bottom: 4px;
    }

    .bs-info-group .value {
      font-size: 15px;
      font-weight: 500;
      color: var(--text-primary);
    }

    .bs-info-group .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .bs-info-group .value .status-badge {
      display: inline-block;
      padding: 4px 14px;
      border-radius: 100px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .bs-info-group .value .status-badge.on-track {
      background: var(--success-soft);
      color: var(--success);
    }

    .bs-info-group .value .status-badge.over-budget {
      background: var(--danger-soft);
      color: var(--danger);
    }

    .bs-info-group .value .status-badge.under-budget {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .bs-info-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    /* PROGRESS */
    .bs-progress-wrap {
      margin: 16px 0;
    }

    .bs-progress-wrap .progress-bar {
      height: 12px;
      border-radius: 100px;
      background: var(--bg-card-active);
      overflow: hidden;
    }

    .bs-progress-wrap .progress-bar .fill {
      height: 100%;
      border-radius: 100px;
      transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bs-progress-wrap .progress-bar .fill.green { background: var(--success); }
    .bs-progress-wrap .progress-bar .fill.red { background: var(--danger); }
    .bs-progress-wrap .progress-bar .fill.yellow { background: var(--warning); }

    .bs-progress-wrap .progress-label {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      color: var(--text-secondary);
      margin-top: 6px;
    }

    .bs-progress-wrap .progress-label .percent {
      font-weight: 600;
      color: var(--text-primary);
    }

    /* SIDEBAR */
    .bs-sidebar {
      position: sticky;
      top: 24px;
    }

    .bs-summary-item {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid var(--border-color);
      font-size: 13px;
    }

    .bs-summary-item:last-child { border-bottom: none; }

    .bs-summary-item .label {
      color: var(--text-secondary);
    }

    .bs-summary-item .value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .bs-summary-item .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .bs-summary-total {
      padding: 16px 0 4px;
      display: flex;
      justify-content: space-between;
      font-size: 18px;
      font-weight: 700;
      border-top: 2px solid var(--theme-primary);
      margin-top: 4px;
    }

    .bs-summary-total .label {
      color: var(--text-primary);
    }

    .bs-summary-total .value {
      color: var(--theme-primary);
    }

    .bs-summary-total .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .bs-meta {
      margin-top: 16px;
      padding-top: 16px;
      border-top: 1px solid var(--border-color);
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .bs-meta .meta-item {
      display: flex;
      justify-content: space-between;
      padding: 4px 0;
    }

    .bs-meta .meta-item .meta-label {
      color: var(--text-tertiary);
    }

    .bs-meta .meta-item .meta-value {
      color: var(--text-secondary);
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .bs-content { grid-template-columns: 1fr; }
      .bs-sidebar { position: static; }
      .bs-info-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .bs-card { padding: 20px; }
      .bs-header h1 { font-size: 24px; }
    }

    @media (max-width: 640px) {
      .bs-header { flex-direction: column; }
      .bs-actions { width: 100%; }
      .bs-actions .bs-btn { flex: 1; justify-content: center; }
    }

    @media (max-width: 380px) {
      .bs-header h1 { font-size: 20px; }
      .bs-btn { font-size: 12px; padding: 8px 14px; }
      .bs-btn .icon { width: 14px; height: 14px; }
      .bs-card { padding: 16px; }
    }
  </style>

  <div class="bs-wrap">

    <!-- ===== HEADER ===== -->
    <div class="bs-header animate-in" style="animation-delay: 0.05s;">
      <div class="bs-header-left">
        <div class="bs-badge">
          <span class="dot"></span>
          Keuangan
        </div>
        <h1>Detail Anggaran</h1>
        <p class="subtitle">
          Detail anggaran untuk — <strong>{{ $budget['category'] }}</strong>
        </p>
      </div>
      <div class="bs-actions">
        <a href="{{ route('budgets.index') }}" class="bs-btn bs-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
        <a href="{{ route('budgets.edit', ['index' => $budget['id']]) }}" class="bs-btn bs-btn-primary">
          <svg class="icon"><use href="#ic-edit"/></svg>
          Edit
        </a>
        <button class="bs-btn bs-btn-danger" onclick="confirmDelete({{ $budget['id'] }})">
          <svg class="icon"><use href="#ic-trash"/></svg>
          Hapus
        </button>
      </div>
    </div>

    <!-- ===== CONTENT ===== -->
    <div class="bs-content">

      <!-- MAIN INFO -->
      <div class="bs-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-target"/></svg>
          Informasi Anggaran
          <span class="line"></span>
        </div>

        <div class="bs-info-group">
          <span class="label">Kategori</span>
          <div class="value">{{ $budget['category'] }}</div>
        </div>

        <div class="bs-info-row">
          <div class="bs-info-group">
            <span class="label">Periode</span>
            <div class="value">{{ $budget['period'] }}</div>
          </div>
          <div class="bs-info-group">
            <span class="label">Status</span>
            <div class="value">
              <span class="status-badge {{ $statusPill[$budget['status']] }}">
                {{ $statusLabel[$budget['status']] }}
              </span>
            </div>
          </div>
        </div>

        <div class="bs-info-row">
          <div class="bs-info-group">
            <span class="label">Target Anggaran</span>
            <div class="value mono">{{ $currencySymbol }}{{ number_format($budget['target'], 0, ',', '.') }}</div>
          </div>
          <div class="bs-info-group">
            <span class="label">Realisasi</span>
            <div class="value mono">{{ $currencySymbol }}{{ number_format($budget['actual'], 0, ',', '.') }}</div>
          </div>
        </div>

        <div class="bs-progress-wrap">
          <div class="progress-bar">
            <div class="fill {{ $progressColor }}" style="width: {{ min($progress, 100) }}%;"></div>
          </div>
          <div class="progress-label">
            <span>Progress</span>
            <span class="percent">{{ $progress }}%</span>
          </div>
        </div>

        <div class="bs-info-group">
          <span class="label">Selisih</span>
          <div class="value mono" style="color: {{ $budget['actual'] >= $budget['target'] ? 'var(--success)' : 'var(--danger)' }};">
            {{ $budget['actual'] >= $budget['target'] ? '+' : '-' }}{{ $currencySymbol }}{{ number_format(abs($budget['actual'] - $budget['target']), 0, ',', '.') }}
          </div>
        </div>

        <div class="bs-info-group">
          <span class="label">Catatan</span>
          <div class="value">{{ $budget['notes'] ?? '-' }}</div>
        </div>
      </div>

      <!-- SIDEBAR -->
      <div class="bs-sidebar">
        <div class="bs-card animate-in" style="animation-delay: 0.15s;">
          <div class="title">
            <svg class="icon"><use href="#ic-target"/></svg>
            Ringkasan
            <span class="line"></span>
          </div>

          <div class="bs-summary-item">
            <span class="label">Kategori</span>
            <span class="value">{{ $budget['category'] }}</span>
          </div>
          <div class="bs-summary-item">
            <span class="label">Periode</span>
            <span class="value">{{ $budget['period'] }}</span>
          </div>
          <div class="bs-summary-item">
            <span class="label">Status</span>
            <span class="value">
              <span class="status-badge {{ $statusPill[$budget['status']] }}" style="display:inline-block;padding:2px 10px;border-radius:100px;font-size:11px;">
                {{ $statusLabel[$budget['status']] }}
              </span>
            </span>
          </div>

          <div class="bs-summary-total">
            <span class="label">Progress</span>
            <span class="value">{{ $progress }}%</span>
          </div>

          <div class="bs-meta">
            <div class="meta-item">
              <span class="meta-label">Dibuat oleh</span>
              <span class="meta-value">{{ $budget['created_by'] ?? '-' }}</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Dibuat pada</span>
              <span class="meta-value">{{ isset($budget['created_at']) ? date('d/m/Y H:i', strtotime($budget['created_at'])) : '-' }}</span>
            </div>
            @if(isset($budget['created_at']) && isset($budget['updated_at']) && $budget['created_at'] != $budget['updated_at'])
            <div class="meta-item">
              <span class="meta-label">Terakhir diupdate</span>
              <span class="meta-value">{{ isset($budget['updated_at']) ? date('d/m/Y H:i', strtotime($budget['updated_at'])) : '-' }}</span>
            </div>
            @endif
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal-overlay" id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:var(--bg-card);border-radius:var(--radius-md);padding:32px;max-width:440px;width:90%;border:1px solid var(--border-color);">
      <svg style="width:48px;height:48px;color:var(--danger);margin:0 auto 16px;display:block;"><use href="#ic-trash"/></svg>
      <h3 style="font-size:18px;font-weight:600;margin:0 0 8px;text-align:center;color:var(--text-primary);">Hapus Anggaran</h3>
      <p style="color:var(--text-secondary);text-align:center;margin:0 0 24px;font-size:14px;line-height:1.5;">
        Apakah Anda yakin ingin menghapus anggaran <strong>{{ $budget['category'] }}</strong>? Tindakan ini tidak dapat dibatalkan.
      </p>
      <div style="display:flex;gap:10px;justify-content:center;">
        <button class="bs-btn bs-btn-ghost" onclick="closeDeleteModal()" style="min-width:100px;justify-content:center;">Batal</button>
        <form id="deleteForm" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="bs-btn" style="min-width:100px;justify-content:center;background:var(--danger);color:#fff;border:none;">
            Hapus
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></symbol>
    <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></symbol>
    <symbol id="ic-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.bs-btn');
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

    function confirmDelete(id) {
      document.getElementById('deleteForm').action = '{{ route("budgets.destroy", ["index" => "__ID__"]) }}'.replace('__ID__', id);
      document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeDeleteModal();
      }
    });
  </script>

</x-app-layout>