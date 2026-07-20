<x-app-layout>
  <x-slot name="title">Tambah PPh</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
  @endphp

  <style>
    .tax-create-wrap {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .tax-create-wrap * { box-sizing: border-box; }
    .tax-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .tax-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .tax-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .tch-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .tch-header-left { flex: 1; min-width: 200px; }

    .tch-badge {
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

    .tch-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .tch-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .tch-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .tch-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .tch-btn {
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

    .tch-btn .icon { width: 16px; height: 16px; }
    .tch-btn:hover { transform: translateY(-2px); }
    .tch-btn:active { transform: translateY(0) scale(0.97); }

    .tch-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .tch-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .tch-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .tch-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .tch-btn .ripple {
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
    .tch-form {
      max-width: 700px;
      margin: 0 auto;
    }

    .tch-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .tch-card:hover { border-color: var(--border-hover); }

    .tch-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .tch-form-group {
      margin-bottom: 18px;
    }

    .tch-form-group:last-child { margin-bottom: 0; }

    .tch-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .tch-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .tch-form-group input,
    .tch-form-group select,
    .tch-form-group textarea {
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

    .tch-form-group input:focus,
    .tch-form-group select:focus,
    .tch-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .tch-form-group input::placeholder,
    .tch-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .tch-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .tch-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .tch-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .tch-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .tch-form-actions .tch-btn {
      flex: 1;
      justify-content: center;
    }

    .tch-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-primary);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--theme-primary);
    }

    .tch-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
    }

    .tch-info-box .message {
      font-size: 13px;
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .tch-form-row { grid-template-columns: 1fr; }
      .tch-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .tch-header { flex-direction: column; }
      .tch-actions { width: 100%; }
      .tch-actions .tch-btn { flex: 1; justify-content: center; }
    }
  </style>

  <div class="tax-create-wrap">

    <div class="tch-header animate-in" style="animation-delay: 0.05s;">
      <div class="tch-header-left">
        <div class="tch-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Tambah PPh</h1>
        <p class="subtitle">Catat Pajak Penghasilan (PPh) baru</p>
      </div>
      <div class="tch-actions">
        <a href="{{ route('taxes.pph') }}" class="tch-btn tch-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('taxes.pph.store') }}" method="POST" class="tch-form">
      @csrf

      <div class="tch-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Informasi PPh</div>

        <div class="tch-info-box">
          <svg class="icon"><use href="#ic-building"/></svg>
          <span class="message">Catat PPh terutang untuk setiap periode</span>
        </div>

        <div class="tch-form-group">
          <label>Periode <span class="required">*</span></label>
          <select name="period" required>
            <option value="Januari 2026">Januari 2026</option>
            <option value="Februari 2026">Februari 2026</option>
            <option value="Maret 2026">Maret 2026</option>
            <option value="April 2026">April 2026</option>
            <option value="Mei 2026">Mei 2026</option>
            <option value="Juni 2026">Juni 2026</option>
            <option value="Juli 2026" selected>Juli 2026</option>
            <option value="Agustus 2026">Agustus 2026</option>
            <option value="September 2026">September 2026</option>
            <option value="Oktober 2026">Oktober 2026</option>
            <option value="November 2026">November 2026</option>
            <option value="Desember 2026">Desember 2026</option>
          </select>
        </div>

        <div class="tch-form-row">
          <div class="tch-form-group">
            <label>Penghasilan Bruto <span class="required">*</span></label>
            <input type="number" name="gross" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="tch-form-group">
            <label>Pengurang <span class="required">*</span></label>
            <input type="number" name="deduction" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <div class="tch-form-group">
          <label>PPh Terutang <span class="required">*</span></label>
          <input type="number" name="tax" placeholder="0" min="0" step="1000" required>
        </div>

        <div class="tch-form-group">
          <label>Jatuh Tempo <span class="required">*</span></label>
          <input type="date" name="due" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
        </div>

        <div class="tch-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="pending">Pending</option>
            <option value="paid">Dibayar</option>
          </select>
        </div>

        <div class="tch-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan PPh..."></textarea>
        </div>

        <div class="tch-form-actions">
          <button type="submit" class="tch-btn tch-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan PPh
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.tch-btn');
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