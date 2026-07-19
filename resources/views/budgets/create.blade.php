<x-app-layout>
  <x-slot name="title">Buat Anggaran</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
  @endphp

  <style>
    .budget-create-wrap {
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

    .budget-create-wrap * { box-sizing: border-box; }
    .budget-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .budget-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .budget-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .bc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .bc-header-left { flex: 1; min-width: 200px; }

    .bc-badge {
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

    .bc-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .bc-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .bc-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .bc-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .bc-btn {
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

    .bc-btn .icon { width: 16px; height: 16px; }
    .bc-btn:hover { transform: translateY(-2px); }
    .bc-btn:active { transform: translateY(0) scale(0.97); }

    .bc-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .bc-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .bc-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .bc-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .bc-btn .ripple {
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
    .bc-form {
      max-width: 700px;
      margin: 0 auto;
    }

    .bc-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .bc-card:hover { border-color: var(--border-hover); }

    .bc-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .bc-form-group {
      margin-bottom: 18px;
    }

    .bc-form-group:last-child { margin-bottom: 0; }

    .bc-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .bc-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .bc-form-group input,
    .bc-form-group select,
    .bc-form-group textarea {
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

    .bc-form-group input:focus,
    .bc-form-group select:focus,
    .bc-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .bc-form-group input::placeholder,
    .bc-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .bc-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .bc-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .bc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .bc-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .bc-form-actions .bc-btn {
      flex: 1;
      justify-content: center;
    }

    .bc-info-box {
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

    .bc-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
    }

    .bc-info-box .message {
      font-size: 13px;
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .bc-form-row { grid-template-columns: 1fr; }
      .bc-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .bc-header { flex-direction: column; }
      .bc-actions { width: 100%; }
      .bc-actions .bc-btn { flex: 1; justify-content: center; }
    }
  </style>

  <div class="budget-create-wrap">

    <div class="bc-header animate-in" style="animation-delay: 0.05s;">
      <div class="bc-header-left">
        <div class="bc-badge">
          <span class="dot"></span>
          Keuangan
        </div>
        <h1>Buat Anggaran</h1>
        <p class="subtitle">Buat anggaran baru untuk perencanaan keuangan</p>
      </div>
      <div class="bc-actions">
        <a href="{{ route('budgets.index') }}" class="bc-btn bc-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('budgets.store') }}" method="POST" class="bc-form">
      @csrf

      <div class="bc-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Informasi Anggaran</div>

        <div class="bc-info-box">
          <svg class="icon"><use href="#ic-target"/></svg>
          <span class="message">Buat anggaran untuk setiap kategori biaya dan pendapatan</span>
        </div>

        <div class="bc-form-group">
          <label>Kategori <span class="required">*</span></label>
          <select name="category" required>
            <option value="">Pilih Kategori...</option>
            <option value="Pendapatan">Pendapatan</option>
            <option value="Bahan Baku">Bahan Baku</option>
            <option value="Biaya Produksi">Biaya Produksi</option>
            <option value="Marketing">Marketing</option>
            <option value="Operasional">Operasional</option>
            <option value="Utilitas">Utilitas</option>
            <option value="Pengembangan">Pengembangan</option>
            <option value="Gaji">Gaji</option>
            <option value="Pajak">Pajak</option>
            <option value="Lainnya">Lainnya</option>
          </select>
        </div>

        <div class="bc-form-row">
          <div class="bc-form-group">
            <label>Periode <span class="required">*</span></label>
            <select name="period" required>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
              <option value="2026" selected>2026</option>
              <option value="2027">2027</option>
            </select>
          </div>
          <div class="bc-form-group">
            <label>Target Anggaran <span class="required">*</span></label>
            <input type="number" name="target" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <div class="bc-form-group">
          <label>Realisasi</label>
          <input type="number" name="actual" placeholder="0" min="0" step="1000" value="0">
        </div>

        <div class="bc-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="on_track">On Track</option>
            <option value="over_budget">Over Budget</option>
            <option value="under_budget">Under Budget</option>
          </select>
        </div>

        <div class="bc-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan anggaran..."></textarea>
        </div>

        <div class="bc-form-actions">
          <button type="submit" class="bc-btn bc-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Anggaran
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.bc-btn');
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