<x-app-layout>
  <x-slot name="title">Tambah PPh</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    $months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $currentMonth = $months[date('n') - 1] . ' ' . date('Y');
  @endphp

  <style>
    /* ============================================
       PPh CREATE - Premium Design
       ============================================ */

    .pph-create-wrap {
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

    .pph-create-wrap * { box-sizing: border-box; }
    .pph-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .pph-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .pph-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .ph-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .ph-header-left { flex: 1; min-width: 200px; }

    .ph-badge {
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

    .ph-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .ph-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .ph-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .ph-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .ph-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .ph-btn {
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

    .ph-btn .icon { width: 16px; height: 16px; }
    .ph-btn:hover { transform: translateY(-2px); }
    .ph-btn:active { transform: translateY(0) scale(0.97); }

    .ph-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .ph-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .ph-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .ph-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .ph-btn .ripple {
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
    .ph-form {
      max-width: 800px;
      margin: 0 auto;
    }

    .ph-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .ph-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .ph-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .ph-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .ph-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .ph-form-group {
      margin-bottom: 18px;
    }

    .ph-form-group:last-child { margin-bottom: 0; }

    .ph-form-group label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .ph-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .ph-form-group .hint {
      display: block;
      font-size: 11.5px;
      color: var(--text-tertiary);
      margin-top: 6px;
      text-transform: none;
      letter-spacing: normal;
    }

    .ph-form-group input,
    .ph-form-group select,
    .ph-form-group textarea {
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

    .ph-form-group input:focus,
    .ph-form-group select:focus,
    .ph-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .ph-form-group input::placeholder,
    .ph-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .ph-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .ph-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .ph-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 13px;
    }

    .ph-form-group select option:checked,
    .ph-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .ph-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    /* INFO BOX */
    .ph-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      margin-bottom: 18px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }

    .ph-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .ph-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.5;
    }

    .ph-info-box .message strong {
      color: var(--text-primary);
    }

    /* TAXABLE PREVIEW */
    .ph-preview {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: var(--bg-card-active);
      border: 1px dashed var(--border-color);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      margin-bottom: 18px;
      font-size: 13px;
    }

    .ph-preview .label { color: var(--text-secondary); }
    .ph-preview .value { font-family: 'IBM Plex Mono', monospace; font-weight: 600; color: var(--theme-primary); }

    /* FORM ACTIONS */
    .ph-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .ph-form-actions .ph-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .ph-form-row { grid-template-columns: 1fr; }
      .ph-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .ph-header { flex-direction: column; }
      .ph-actions { width: 100%; }
      .ph-actions .ph-btn { flex: 1; justify-content: center; }
      .ph-form-actions { flex-direction: column; }
      .ph-form-actions .ph-btn { flex: none; }
    }

    @media (max-width: 380px) {
      .ph-header h1 { font-size: 22px; }
      .ph-btn { font-size: 12px; padding: 8px 14px; }
      .ph-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="pph-create-wrap">

    <!-- ===== HEADER ===== -->
    <div class="ph-header animate-in" style="animation-delay: 0.05s;">
      <div class="ph-header-left">
        <div class="ph-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Tambah PPh</h1>
        <p class="subtitle">
          Catat Pajak Penghasilan (PPh) — <strong>periode {{ $currentMonth }}</strong>
        </p>
      </div>
      <div class="ph-actions">
        <a href="{{ route('taxes.pph') }}" class="ph-btn ph-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('taxes.pph.store') }}" method="POST" class="ph-form">
      @csrf

      <div class="ph-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-tax"/></svg>
          Informasi PPh
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="ph-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Penghasilan Kena Pajak dihitung otomatis dari
            Penghasilan Bruto dikurangi Pengurang/Potongan. Isi nominal Pajak Terutang sesuai tarif yang berlaku.
          </div>
        </div>

        <!-- Period -->
        <div class="ph-form-group">
          <label>Periode <span class="required">*</span></label>
          <select name="period" required>
            @foreach($months as $month)
              @php
                $year = date('Y');
                $value = $month . ' ' . $year;
                $selected = ($month == $months[date('n') - 1]) ? 'selected' : '';
              @endphp
              <option value="{{ $value }}" {{ $selected }}>
                {{ $month }} {{ $year }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Gross & Deduction -->
        <div class="ph-form-row">
          <div class="ph-form-group">
            <label>Penghasilan Bruto <span class="required">*</span></label>
            <input type="number" name="gross" id="ph-gross" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="ph-form-group">
            <label>Pengurang / Potongan</label>
            <input type="number" name="deduction" id="ph-deduction" placeholder="0" min="0" step="1000">
            <span class="hint">Biaya jabatan, iuran pensiun, PTKP, dll.</span>
          </div>
        </div>

        <!-- Taxable preview -->
        <div class="ph-preview">
          <span class="label">Penghasilan Kena Pajak</span>
          <span class="value mono" id="ph-taxable-preview">{{ $currencySymbol }}0</span>
        </div>

        <!-- Tax -->
        <div class="ph-form-group">
          <label>Pajak Terutang (PPh) <span class="required">*</span></label>
          <input type="number" name="tax" placeholder="0" min="0" step="1000" required>
        </div>

        <!-- Due Date & Status -->
        <div class="ph-form-row">
          <div class="ph-form-group">
            <label>Jatuh Tempo <span class="required">*</span></label>
            <input type="date" name="due" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
          </div>
          <div class="ph-form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="pending">Pending</option>
              <option value="paid">Dibayar</option>
            </select>
          </div>
        </div>

        <!-- Notes -->
        <div class="ph-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan PPh..."></textarea>
        </div>

        <!-- Actions -->
        <div class="ph-form-actions">
          <button type="submit" class="ph-btn ph-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan PPh
          </button>
        </div>
      </div>

    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-tax" viewBox="0 0 24 24"><path d="M12 2L2 7v4c0 5.52 3.12 10.56 10 11 6.88-.44 10-5.48 10-11V7L12 2z"/><polyline points="12 11 12 17 16 17"/><line x1="8" y1="17" x2="16" y2="17"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.ph-btn');
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

      // Live "Penghasilan Kena Pajak" preview = Bruto - Pengurang
      const grossInput = document.getElementById('ph-gross');
      const deductionInput = document.getElementById('ph-deduction');
      const preview = document.getElementById('ph-taxable-preview');
      const currencySymbol = @json($currencySymbol);

      function updatePreview() {
        const gross = parseFloat(grossInput.value) || 0;
        const deduction = parseFloat(deductionInput.value) || 0;
        const taxable = Math.max(gross - deduction, 0);
        preview.textContent = currencySymbol + taxable.toLocaleString('id-ID');
      }

      grossInput.addEventListener('input', updatePreview);
      deductionInput.addEventListener('input', updatePreview);
    });
  </script>

</x-app-layout>