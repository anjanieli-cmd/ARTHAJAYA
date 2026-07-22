<x-app-layout>
  <x-slot name="title">Edit Rekonsiliasi</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY data - nanti diganti dengan data dari database
    $reconciliation = [
        'id' => 1,
        'account_id' => 1,
        'account_name' => 'BCA - 1234567890',
        'period' => '2026-07',
        'reconciliation_date' => '2026-07-20',
        'bank_balance' => 125000000,
        'book_balance' => 125000000,
        'status' => 'cocok',
        'notes' => 'Rekonsiliasi bulan Juli 2026 - semua saldo cocok',
    ];

    // DUMMY accounts
    $accounts = [
        ['id' => 1, 'name' => 'BCA - 1234567890', 'balance' => 125000000],
        ['id' => 2, 'name' => 'Mandiri - 9876543210', 'balance' => 85000000],
        ['id' => 3, 'name' => 'BNI - 4567891230', 'balance' => 45000000],
    ];

    $statusLabel = ['cocok' => 'Cocok', 'belum' => 'Belum Rekon'];
    $statusBadge = ['cocok' => 'cocok', 'belum' => 'belum'];
  @endphp

  <style>
    /* ============================================
       REKONSILIASI EDIT - Premium Design
       ============================================ */
    
    .rec-edit-wrap {
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

    .rec-edit-wrap * { box-sizing: border-box; }
    .rec-edit-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .rec-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .rec-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .re-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .re-header-left { flex: 1; min-width: 200px; }

    .re-badge {
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

    .re-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .re-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .re-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .re-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .re-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .re-btn {
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

    .re-btn .icon { width: 16px; height: 16px; }
    .re-btn:hover { transform: translateY(-2px); }
    .re-btn:active { transform: translateY(0) scale(0.97); }

    .re-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .re-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .re-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .re-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .re-btn-danger {
      background: var(--danger);
      color: #fff;
      border: none;
    }

    .re-btn-danger:hover {
      background: #DC2626;
      color: #fff;
      transform: translateY(-2px);
    }

    .re-btn .ripple {
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

    /* FORM LAYOUT */
    .re-form {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 24px;
      align-items: start;
    }

    .re-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 30px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .re-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .re-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .re-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .re-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .re-form-group {
      margin-bottom: 18px;
    }

    .re-form-group:last-child { margin-bottom: 0; }

    .re-form-group label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .re-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .re-form-group input,
    .re-form-group select,
    .re-form-group textarea {
      width: 100%;
      padding: 10px 14px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .re-form-group input:focus,
    .re-form-group select:focus,
    .re-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .re-form-group input::placeholder,
    .re-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .re-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .re-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .re-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 13px;
    }

    .re-form-group select option:checked,
    .re-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .re-form-group select option:disabled {
      color: #6b7280;
    }

    .re-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    /* SIDEBAR SUMMARY */
    .re-summary {
      position: sticky;
      top: 80px;
    }

    .re-summary-item {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid var(--border-color);
      font-size: 13px;
    }

    .re-summary-item:last-child { border-bottom: none; }

    .re-summary-item .label {
      color: var(--text-secondary);
    }

    .re-summary-item .value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .re-summary-item .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .re-summary-item .value.match {
      color: var(--success);
    }

    .re-summary-item .value.diff {
      color: var(--danger);
    }

    .re-summary-total {
      padding: 16px 0 4px;
      display: flex;
      justify-content: space-between;
      font-size: 18px;
      font-weight: 700;
      border-top: 2px solid var(--theme-primary);
      margin-top: 4px;
    }

    .re-summary-total .label {
      color: var(--text-primary);
    }

    .re-summary-total .value {
      color: var(--theme-primary);
    }

    .re-summary-total .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .re-status-badge {
      display: inline-block;
      padding: 4px 14px;
      border-radius: 100px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .re-status-badge.cocok {
      background: var(--success-soft);
      color: var(--success);
    }

    .re-status-badge.belum {
      background: var(--warning-soft);
      color: var(--warning);
    }

    .re-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .re-form-actions .re-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .re-form { grid-template-columns: 1fr; }
      .re-summary { position: static; }
      .re-form-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .re-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .re-header { flex-direction: column; }
      .re-actions { width: 100%; }
      .re-actions .re-btn { flex: 1; justify-content: center; }
    }

    @media (max-width: 380px) {
      .re-header h1 { font-size: 22px; }
      .re-btn { font-size: 12px; padding: 8px 14px; }
      .re-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="rec-edit-wrap">

    <!-- ===== HEADER ===== -->
    <div class="re-header animate-in" style="animation-delay: 0.05s;">
      <div class="re-header-left">
        <div class="re-badge">
          <span class="dot"></span>
          Perbankan
        </div>
        <h1>Edit Rekonsiliasi</h1>
        <p class="subtitle">
          Edit rekonsiliasi bank — <strong>{{ $reconciliation['account_name'] }}</strong>
        </p>
      </div>
      <div class="re-actions">
        <a href="{{ route('reconciliation.show', $reconciliation['id']) }}" class="re-btn re-btn-ghost">
          <svg class="icon"><use href="#ic-eye"/></svg>
          Batal
        </a>
        <a href="{{ route('reconciliation.index') }}" class="re-btn re-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('reconciliation.update', $reconciliation['id']) }}" method="POST" class="re-form">
      @csrf
      @method('PUT')

      <!-- ===== MAIN FORM ===== -->
      <div class="re-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-bank"/></svg>
          Informasi Rekonsiliasi
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="re-info-box" style="background:var(--theme-soft);border:1px solid var(--theme-glow);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:18px;display:flex;align-items:flex-start;gap:10px;">
          <svg class="icon" style="width:20px;height:20px;flex-shrink:0;margin-top:1px;color:var(--theme-primary);"><use href="#ic-info"/></svg>
          <div style="font-size:13px;color:var(--text-secondary);line-height:1.5;">
            <strong style="color:var(--text-primary);">Perhatian:</strong> Pastikan saldo bank dan saldo buku sesuai sebelum menyimpan. Selisih yang tidak wajar akan ditandai.
          </div>
        </div>

        <div class="re-form-group">
          <label>Akun Bank <span class="required">*</span></label>
          <select name="account_id" required>
            <option value="">Pilih Akun Bank...</option>
            @foreach($accounts as $a)
              <option value="{{ $a['id'] }}" {{ $a['id'] == $reconciliation['account_id'] ? 'selected' : '' }}>
                {{ $a['name'] }} (Saldo: {{ $currencySymbol }}{{ number_format($a['balance'], 0, ',', '.') }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="re-form-row">
          <div class="re-form-group">
            <label>Periode <span class="required">*</span></label>
            <input type="month" name="period" value="{{ $reconciliation['period'] }}" required>
          </div>
          <div class="re-form-group">
            <label>Tanggal Rekonsiliasi <span class="required">*</span></label>
            <input type="date" name="reconciliation_date" value="{{ $reconciliation['reconciliation_date'] }}" required>
          </div>
        </div>

        <div class="re-form-row">
          <div class="re-form-group">
            <label>Saldo Bank <span class="required">*</span></label>
            <input 
              type="number" 
              name="bank_balance" 
              value="{{ $reconciliation['bank_balance'] }}"
              placeholder="Masukkan saldo bank" 
              min="0" 
              step="1000" 
              required
              oninput="calculateDifference()"
            >
          </div>
          <div class="re-form-group">
            <label>Saldo Buku <span class="required">*</span></label>
            <input 
              type="number" 
              name="book_balance" 
              value="{{ $reconciliation['book_balance'] }}"
              placeholder="Masukkan saldo buku" 
              min="0" 
              step="1000" 
              required
              oninput="calculateDifference()"
            >
          </div>
        </div>

        <div class="re-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan untuk rekonsiliasi...">{{ $reconciliation['notes'] }}</textarea>
        </div>
      </div>

      <!-- ===== SIDEBAR SUMMARY ===== -->
      <div class="re-summary">
        <div class="re-card animate-in" style="animation-delay: 0.15s;">
          <div class="title">
            <svg class="icon"><use href="#ic-target"/></svg>
            Ringkasan
            <span class="line"></span>
          </div>

          <div class="re-summary-item">
            <span class="label">Saldo Bank</span>
            <span class="value mono" id="summaryBank">{{ $currencySymbol }}{{ number_format($reconciliation['bank_balance'], 0, ',', '.') }}</span>
          </div>
          <div class="re-summary-item">
            <span class="label">Saldo Buku</span>
            <span class="value mono" id="summaryBook">{{ $currencySymbol }}{{ number_format($reconciliation['book_balance'], 0, ',', '.') }}</span>
          </div>
          <div class="re-summary-item">
            <span class="label">Selisih</span>
            <span class="value mono" id="summaryDiff">
              @php
                $diff = $reconciliation['bank_balance'] - $reconciliation['book_balance'];
              @endphp
              {{ $diff >= 0 ? '+' : '-' }}{{ $currencySymbol }}{{ number_format(abs($diff), 0, ',', '.') }}
            </span>
          </div>

          <div class="re-summary-total">
            <span class="label">Status</span>
            <span class="value" id="summaryStatus">
              <span class="re-status-badge {{ $statusBadge[$reconciliation['status']] }}">
                {{ $statusLabel[$reconciliation['status']] }}
              </span>
            </span>
          </div>

          <div class="re-form-group" style="margin-top: 20px;">
            <label>Status <span class="required">*</span></label>
            <select name="status" id="statusSelect" required onchange="updateStatusBadge(this.value)">
              <option value="cocok" {{ $reconciliation['status'] == 'cocok' ? 'selected' : '' }}>Cocok</option>
              <option value="belum" {{ $reconciliation['status'] == 'belum' ? 'selected' : '' }}>Belum Rekon</option>
            </select>
          </div>

          <div class="re-form-actions">
            <button type="submit" class="re-btn re-btn-primary">
              <svg class="icon"><use href="#ic-check"/></svg>
              Update Rekonsiliasi
            </button>
          </div>
        </div>
      </div>

    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-bank" viewBox="0 0 24 24"><rect x="2" y="8" width="20" height="12" rx="2"/><path d="M3 8L12 2l9 6"/><line x1="8" y1="14" x2="16" y2="14"/></symbol>
    <symbol id="ic-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
    <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.re-btn');
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

      // Initial calculation
      setTimeout(calculateDifference, 100);
    });

    function calculateDifference() {
      const bankInput = document.querySelector('input[name="bank_balance"]');
      const bookInput = document.querySelector('input[name="book_balance"]');
      
      const bank = parseFloat(bankInput?.value) || 0;
      const book = parseFloat(bookInput?.value) || 0;
      const diff = bank - book;
      
      const currencySymbol = '{{ $currencySymbol }}';
      
      // Update summary
      document.getElementById('summaryBank').textContent = currencySymbol + bank.toLocaleString('id-ID');
      document.getElementById('summaryBook').textContent = currencySymbol + book.toLocaleString('id-ID');
      
      const diffEl = document.getElementById('summaryDiff');
      const absDiff = Math.abs(diff);
      diffEl.textContent = (diff >= 0 ? '+' : '-') + currencySymbol + absDiff.toLocaleString('id-ID');
      
      if (diff === 0 && bank > 0) {
        diffEl.className = 'value mono match';
      } else if (diff !== 0) {
        diffEl.className = 'value mono diff';
      } else {
        diffEl.className = 'value mono';
      }
    }

    function updateStatusBadge(value) {
      const statusEl = document.getElementById('summaryStatus');
      const labels = {
        'cocok': '<span class="re-status-badge cocok">Cocok</span>',
        'belum': '<span class="re-status-badge belum">Belum Rekon</span>'
      };
      statusEl.innerHTML = labels[value] || labels['cocok'];
    }
  </script>

</x-app-layout>