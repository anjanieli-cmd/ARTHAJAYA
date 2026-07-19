<x-app-layout>
  <x-slot name="title">Tambah Rekonsiliasi</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY accounts - nanti ganti dengan data dari database
    $accounts = [
        ['id' => 1, 'name' => 'BCA - 1234567890'],
        ['id' => 2, 'name' => 'Mandiri - 9876543210'],
        ['id' => 3, 'name' => 'BNI - 4567891230'],
    ];
  @endphp

  <style>
    .rec-create-wrap {
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

    .rec-create-wrap * { box-sizing: border-box; }
    .rec-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .rec-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .rec-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .rc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .rc-header-left { flex: 1; min-width: 200px; }

    .rc-badge {
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

    .rc-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .rc-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .rc-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .rc-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .rc-btn {
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

    .rc-btn .icon { width: 16px; height: 16px; }
    .rc-btn:hover { transform: translateY(-2px); }
    .rc-btn:active { transform: translateY(0) scale(0.97); }

    .rc-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .rc-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .rc-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .rc-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .rc-btn .ripple {
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

    /* FORM */
    .rc-form {
      max-width: 800px;
      margin: 0 auto;
    }

    .rc-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .rc-card:hover { border-color: var(--border-hover); }

    .rc-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .rc-form-group {
      margin-bottom: 18px;
    }

    .rc-form-group:last-child { margin-bottom: 0; }

    .rc-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .rc-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .rc-form-group input,
    .rc-form-group select,
    .rc-form-group textarea {
      width: 100%;
      padding: 10px 14px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      transition: all 0.2s ease;
      outline: none;
    }

    .rc-form-group input:focus,
    .rc-form-group select:focus,
    .rc-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .rc-form-group input::placeholder,
    .rc-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .rc-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .rc-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .rc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .rc-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .rc-form-actions .rc-btn {
      flex: 1;
      justify-content: center;
    }

    .rc-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-primary);
      border-radius: var(--radius-sm);
      padding: 14px 16px;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--theme-primary);
    }

    .rc-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
    }

    .rc-info-box .message {
      font-size: 13px;
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .rc-form-row { grid-template-columns: 1fr; }
      .rc-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .rc-header { flex-direction: column; }
      .rc-actions { width: 100%; }
      .rc-actions .rc-btn { flex: 1; justify-content: center; }
    }
  </style>

  <div class="rec-create-wrap">

    <div class="rc-header animate-in" style="animation-delay: 0.05s;">
      <div class="rc-header-left">
        <div class="rc-badge">
          <span class="dot"></span>
          Perbankan
        </div>
        <h1>Tambah Rekonsiliasi</h1>
        <p class="subtitle">Cocokkan mutasi bank dengan catatan pembukuan</p>
      </div>
      <div class="rc-actions">
        <a href="{{ route('reconciliation.index') }}" class="rc-btn rc-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('reconciliation.store') }}" method="POST" class="rc-form">
      @csrf

      <div class="rc-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Informasi Rekonsiliasi</div>

        <div class="rc-info-box">
          <svg class="icon"><use href="#ic-shield"/></svg>
          <span class="message">Cocokkan saldo bank dengan saldo buku untuk periode tertentu</span>
        </div>

        <div class="rc-form-group">
          <label>Akun Bank <span class="required">*</span></label>
          <select name="account_id" required>
            <option value="">Pilih Akun Bank...</option>
            @foreach($accounts as $a)
              <option value="{{ $a['id'] }}">{{ $a['name'] }}</option>
            @endforeach
          </select>
        </div>

        <div class="rc-form-row">
          <div class="rc-form-group">
            <label>Periode <span class="required">*</span></label>
            <input type="month" name="period" value="{{ date('Y-m') }}" required>
          </div>
          <div class="rc-form-group">
            <label>Tanggal Rekonsiliasi <span class="required">*</span></label>
            <input type="date" name="reconciliation_date" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>

        <div class="rc-form-row">
          <div class="rc-form-group">
            <label>Saldo Bank <span class="required">*</span></label>
            <input type="number" name="bank_balance" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="rc-form-group">
            <label>Saldo Buku <span class="required">*</span></label>
            <input type="number" name="book_balance" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <div class="rc-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan rekonsiliasi..."></textarea>
        </div>

        <div class="rc-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="cocok">Cocok</option>
            <option value="belum">Belum Rekon</option>
          </select>
        </div>

        <div class="rc-form-actions">
          <button type="submit" class="rc-btn rc-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Rekonsiliasi
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.rc-btn');
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