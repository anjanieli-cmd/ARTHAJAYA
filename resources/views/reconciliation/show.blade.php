<x-app-layout>
  <x-slot name="title">Detail Rekonsiliasi</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    $statusLabel = ['cocok' => 'Cocok', 'belum' => 'Belum Rekon'];
    $statusBadge = ['cocok' => 'cocok', 'belum' => 'belum'];
  @endphp

  <style>
    /* ============================================
       REKONSILIASI DETAIL - Premium Design
       ============================================ */
    
    .rec-detail-wrap {
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

    .rec-detail-wrap * { box-sizing: border-box; }
    .rec-detail-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .rec-detail-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .rec-detail-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .rd-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .rd-header-left { flex: 1; min-width: 200px; }

    .rd-badge {
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

    .rd-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .rd-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .rd-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .rd-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .rd-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .rd-btn {
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

    .rd-btn .icon { width: 16px; height: 16px; }
    .rd-btn:hover { transform: translateY(-2px); }
    .rd-btn:active { transform: translateY(0) scale(0.97); }

    .rd-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .rd-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .rd-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .rd-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .rd-btn-danger {
      background: var(--danger);
      color: #fff;
      border: none;
    }

    .rd-btn-danger:hover {
      background: #DC2626;
      color: #fff;
      transform: translateY(-2px);
    }

    .rd-btn .ripple {
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

    /* CONTENT LAYOUT */
    .rd-content {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 24px;
      align-items: start;
    }

    .rd-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 30px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .rd-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .rd-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .rd-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .rd-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* INFO GROUP */
    .rd-info-group {
      margin-bottom: 16px;
    }

    .rd-info-group:last-child { margin-bottom: 0; }

    .rd-info-group .label {
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      display: block;
      margin-bottom: 4px;
    }

    .rd-info-group .value {
      font-size: 15px;
      font-weight: 500;
      color: var(--text-primary);
    }

    .rd-info-group .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .rd-info-group .value .badge {
      display: inline-block;
      padding: 4px 14px;
      border-radius: 100px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .rd-info-group .value .badge.cocok {
      background: var(--success-soft);
      color: var(--success);
    }

    .rd-info-group .value .badge.belum {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .rd-info-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    /* SIDEBAR */
    .rd-sidebar {
      position: sticky;
      top: 80px;
    }

    .rd-summary-item {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid var(--border-color);
      font-size: 13px;
    }

    .rd-summary-item:last-child { border-bottom: none; }

    .rd-summary-item .label {
      color: var(--text-secondary);
    }

    .rd-summary-item .value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .rd-summary-item .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .rd-summary-item .value.match {
      color: var(--success);
    }

    .rd-summary-item .value.diff {
      color: var(--danger);
    }

    .rd-summary-total {
      padding: 16px 0 4px;
      display: flex;
      justify-content: space-between;
      font-size: 18px;
      font-weight: 700;
      border-top: 2px solid var(--theme-primary);
      margin-top: 4px;
    }

    .rd-summary-total .label {
      color: var(--text-primary);
    }

    .rd-summary-total .value {
      color: var(--theme-primary);
    }

    .rd-summary-total .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .rd-meta {
      margin-top: 16px;
      padding-top: 16px;
      border-top: 1px solid var(--border-color);
      font-size: 12px;
      color: var(--text-tertiary);
    }

    .rd-meta .meta-item {
      display: flex;
      justify-content: space-between;
      padding: 4px 0;
    }

    .rd-meta .meta-item .meta-label {
      color: var(--text-tertiary);
    }

    .rd-meta .meta-item .meta-value {
      color: var(--text-secondary);
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .rd-content { grid-template-columns: 1fr; }
      .rd-sidebar { position: static; }
      .rd-info-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .rd-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .rd-header { flex-direction: column; }
      .rd-actions { width: 100%; }
      .rd-actions .rd-btn { flex: 1; justify-content: center; }
    }

    @media (max-width: 380px) {
      .rd-header h1 { font-size: 22px; }
      .rd-btn { font-size: 12px; padding: 8px 14px; }
      .rd-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="rec-detail-wrap">

    <!-- ===== HEADER ===== -->
    <div class="rd-header animate-in" style="animation-delay: 0.05s;">
      <div class="rd-header-left">
        <div class="rd-badge">
          <span class="dot"></span>
          Perbankan
        </div>
        <h1>Detail Rekonsiliasi</h1>
        <p class="subtitle">
          Rekonsiliasi bank — <strong>{{ $reconciliation['account_name'] ?? 'BCA - 1234567890' }}</strong>
        </p>
      </div>
      <div class="rd-actions">
        <a href="{{ route('reconciliation.index') }}" class="rd-btn rd-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
        <a href="{{ route('reconciliation.edit', $index ?? 0) }}" class="rd-btn rd-btn-primary">
          <svg class="icon"><use href="#ic-edit"/></svg>
          Edit
        </a>
        <button class="rd-btn rd-btn-danger" onclick="confirmDelete({{ $index ?? 0 }})">
          <svg class="icon"><use href="#ic-trash"/></svg>
          Hapus
        </button>
      </div>
    </div>

    <!-- ===== CONTENT ===== -->
    <div class="rd-content">

      <!-- MAIN INFO -->
      <div class="rd-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-info"/></svg>
          Informasi Rekonsiliasi
          <span class="line"></span>
        </div>

        <div class="rd-info-group">
          <span class="label">Akun Bank</span>
          <div class="value">{{ $reconciliation['account_name'] ?? 'BCA - 1234567890' }}</div>
        </div>

        <div class="rd-info-row">
          <div class="rd-info-group">
            <span class="label">Periode</span>
            <div class="value">{{ isset($reconciliation['period']) ? date('F Y', strtotime($reconciliation['period'] . '-01')) : 'Juli 2026' }}</div>
          </div>
          <div class="rd-info-group">
            <span class="label">Tanggal Rekonsiliasi</span>
            <div class="value">{{ isset($reconciliation['reconciliation_date']) ? date('d/m/Y', strtotime($reconciliation['reconciliation_date'])) : '20/07/2026' }}</div>
          </div>
        </div>

        <div class="rd-info-row">
          <div class="rd-info-group">
            <span class="label">Saldo Bank</span>
            <div class="value mono">{{ $currencySymbol }}{{ number_format($reconciliation['bank_balance'] ?? 125000000, 0, ',', '.') }}</div>
          </div>
          <div class="rd-info-group">
            <span class="label">Saldo Buku</span>
            <div class="value mono">{{ $currencySymbol }}{{ number_format($reconciliation['book_balance'] ?? 125000000, 0, ',', '.') }}</div>
          </div>
        </div>

        <div class="rd-info-group">
          <span class="label">Selisih</span>
          <div class="value mono" style="color: {{ ($reconciliation['difference'] ?? 0) == 0 ? 'var(--success)' : 'var(--danger)' }};">
            {{ ($reconciliation['difference'] ?? 0) >= 0 ? '+' : '-' }}{{ $currencySymbol }}{{ number_format(abs($reconciliation['difference'] ?? 0), 0, ',', '.') }}
          </div>
        </div>

        <div class="rd-info-group">
          <span class="label">Status</span>
          <div class="value">
            <span class="badge {{ ($reconciliation['status'] ?? 'cocok') == 'cocok' ? 'cocok' : 'belum' }}">
              {{ ($reconciliation['status'] ?? 'cocok') == 'cocok' ? 'Cocok' : 'Belum Rekon' }}
            </span>
          </div>
        </div>

        <div class="rd-info-group">
          <span class="label">Catatan</span>
          <div class="value">{{ $reconciliation['notes'] ?? '-' }}</div>
        </div>
      </div>

      <!-- SIDEBAR -->
      <div class="rd-sidebar">
        <div class="rd-card animate-in" style="animation-delay: 0.15s;">
          <div class="title">
            <svg class="icon"><use href="#ic-target"/></svg>
            Ringkasan
            <span class="line"></span>
          </div>

          <div class="rd-summary-item">
            <span class="label">Saldo Bank</span>
            <span class="value mono">{{ $currencySymbol }}{{ number_format($reconciliation['bank_balance'] ?? 125000000, 0, ',', '.') }}</span>
          </div>
          <div class="rd-summary-item">
            <span class="label">Saldo Buku</span>
            <span class="value mono">{{ $currencySymbol }}{{ number_format($reconciliation['book_balance'] ?? 125000000, 0, ',', '.') }}</span>
          </div>
          <div class="rd-summary-item">
            <span class="label">Selisih</span>
            <span class="value mono {{ ($reconciliation['difference'] ?? 0) == 0 ? 'match' : 'diff' }}">
              {{ ($reconciliation['difference'] ?? 0) >= 0 ? '+' : '-' }}{{ $currencySymbol }}{{ number_format(abs($reconciliation['difference'] ?? 0), 0, ',', '.') }}
            </span>
          </div>

          <div class="rd-summary-total">
            <span class="label">Status</span>
            <span class="value">
              <span class="badge {{ ($reconciliation['status'] ?? 'cocok') == 'cocok' ? 'cocok' : 'belum' }}">
                {{ ($reconciliation['status'] ?? 'cocok') == 'cocok' ? 'Cocok' : 'Belum Rekon' }}
              </span>
            </span>
          </div>

          <div class="rd-meta">
            <div class="meta-item">
              <span class="meta-label">Dibuat oleh</span>
              <span class="meta-value">{{ $reconciliation['created_by'] ?? 'Anjani' }}</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Dibuat pada</span>
              <span class="meta-value">{{ isset($reconciliation['created_at']) ? date('d/m/Y H:i', strtotime($reconciliation['created_at'])) : '20/07/2026 14:30' }}</span>
            </div>
            @if(isset($reconciliation['created_at']) && isset($reconciliation['updated_at']) && $reconciliation['created_at'] != $reconciliation['updated_at'])
            <div class="meta-item">
              <span class="meta-label">Terakhir diupdate</span>
              <span class="meta-value">{{ date('d/m/Y H:i', strtotime($reconciliation['updated_at'])) }}</span>
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
      <h3 style="font-size:18px;font-weight:600;margin:0 0 8px;text-align:center;color:var(--text-primary);">Hapus Rekonsiliasi</h3>
      <p style="color:var(--text-secondary);text-align:center;margin:0 0 24px;font-size:14px;line-height:1.5;">
        Apakah Anda yakin ingin menghapus rekonsiliasi ini? Tindakan ini tidak dapat dibatalkan.
      </p>
      <div style="display:flex;gap:10px;justify-content:center;">
        <button class="rd-btn rd-btn-ghost" onclick="closeDeleteModal()" style="min-width:100px;justify-content:center;">Batal</button>
        <form id="deleteForm" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="rd-btn rd-btn-danger" style="min-width:100px;justify-content:center;">Hapus</button>
        </form>
      </div>
    </div>
  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></symbol>
    <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.rd-btn');
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          // Skip jika button punya onclick (delete button)
          if (this.getAttribute('onclick')) return;
          
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

    function confirmDelete(index) {
      // PERBAIKAN: Gunakan url() helper untuk menghindari error route parameter
      document.getElementById('deleteForm').action = '{{ url("/reconciliation/delete") }}/' + index;
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