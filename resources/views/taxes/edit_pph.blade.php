<x-app-layout>
  <x-slot name="title">Edit PPh</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY data - nanti diganti dengan data dari database
    $tax = [
        'id' => 1,
        'period' => 'Juli 2026',
        'gross' => 25000000,
        'deduction' => 5000000,
        'tax' => 2000000,
        'due' => '2026-08-20',
        'status' => 'pending',
        'notes' => 'PPh Pasal 21 untuk karyawan',
    ];

    $months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
  @endphp

  <style>
    /* ============================================
       PPH EDIT - Premium Design
       ============================================ */
    
    .pe-wrap {
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

    .pe-wrap * { box-sizing: border-box; }
    .pe-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .pe-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .pe-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .pe-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .pe-header-left { flex: 1; min-width: 200px; }

    .pe-badge {
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

    .pe-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .pe-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .pe-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .pe-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .pe-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .pe-btn {
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

    .pe-btn .icon { width: 16px; height: 16px; }
    .pe-btn:hover { transform: translateY(-2px); }
    .pe-btn:active { transform: translateY(0) scale(0.97); }

    .pe-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pe-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .pe-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .pe-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .pe-btn .ripple {
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

    /* FORM LAYOUT - FULL WIDTH */
    .pe-form {
      width: 100%;
      max-width: 100%;
    }

    .pe-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 40px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
    }

    .pe-card:hover {
      border-color: var(--border-hover);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .pe-card .title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .pe-card .title .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    .pe-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .pe-form-group {
      margin-bottom: 20px;
    }

    .pe-form-group:last-child { margin-bottom: 0; }

    .pe-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .pe-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .pe-form-group input,
    .pe-form-group select,
    .pe-form-group textarea {
      width: 100%;
      padding: 12px 16px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .pe-form-group input:focus,
    .pe-form-group select:focus,
    .pe-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .pe-form-group input::placeholder,
    .pe-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .pe-form-group textarea {
      resize: vertical;
      min-height: 90px;
    }

    .pe-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .pe-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 14px;
    }

    .pe-form-group select option:checked,
    .pe-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .pe-form-group select option:disabled {
      color: #6b7280;
    }

    .pe-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* INFO BOX */
    .pe-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 14px 18px;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .pe-info-box .icon {
      width: 22px;
      height: 22px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .pe-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.6;
    }

    .pe-info-box .message strong {
      color: var(--text-primary);
    }

    /* FORM ACTIONS */
    .pe-form-actions {
      display: flex;
      gap: 12px;
      margin-top: 28px;
    }

    .pe-form-actions .pe-btn {
      flex: 1;
      justify-content: center;
      padding: 14px 24px;
      font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .pe-wrap { padding: 0 16px; }
      .pe-card { padding: 24px 28px; }
    }

    @media (max-width: 768px) {
      .pe-wrap { padding: 0 12px; }
      .pe-card { padding: 20px; }
      .pe-form-row { 
        grid-template-columns: 1fr; 
        gap: 0;
      }
      .pe-header h1 { font-size: 24px; }
    }

    @media (max-width: 640px) {
      .pe-header { 
        flex-direction: column; 
      }
      .pe-actions { 
        width: 100%; 
      }
      .pe-actions .pe-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .pe-form-actions { 
        flex-direction: column; 
      }
      .pe-form-actions .pe-btn { 
        flex: none; 
      }
      .pe-card { padding: 16px; }
    }

    @media (max-width: 380px) {
      .pe-header h1 { 
        font-size: 20px; 
      }
      .pe-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .pe-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
      .pe-card { padding: 12px; }
    }
  </style>

  <div class="pe-wrap">

    <!-- ===== HEADER ===== -->
    <div class="pe-header animate-in" style="animation-delay: 0.05s;">
      <div class="pe-header-left">
        <div class="pe-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Edit PPh</h1>
        <p class="subtitle">
          Edit Pajak Penghasilan — <strong>periode {{ $tax['period'] }}</strong>
        </p>
      </div>
      <div class="pe-actions">
        <a href="{{ route('taxes.pph.show', $tax['id']) }}" class="pe-btn pe-btn-ghost">
          <svg class="icon"><use href="#ic-eye"/></svg>
          Batal
        </a>
        <a href="{{ route('taxes.pph') }}" class="pe-btn pe-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('taxes.pph.update', $tax['id']) }}" method="POST" class="pe-form">
      @csrf
      @method('PUT')

      <div class="pe-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-tax"/></svg>
          Informasi PPh
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="pe-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Pastikan data PPh diisi dengan benar. 
            Penghasilan bruto dikurangi pengurang akan menghasilkan PPh terutang.
          </div>
        </div>

        <!-- Period -->
        <div class="pe-form-group">
          <label>Periode <span class="required">*</span></label>
          <select name="period" required>
            @foreach($months as $month)
              @php
                $year = date('Y');
                $value = $month . ' ' . $year;
                $selected = ($value == $tax['period']) ? 'selected' : '';
              @endphp
              <option value="{{ $value }}" {{ $selected }}>
                {{ $month }} {{ $year }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Gross & Deduction -->
        <div class="pe-form-row">
          <div class="pe-form-group">
            <label>Penghasilan Bruto <span class="required">*</span></label>
            <input type="number" name="gross" value="{{ $tax['gross'] }}" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="pe-form-group">
            <label>Pengurang <span class="required">*</span></label>
            <input type="number" name="deduction" value="{{ $tax['deduction'] }}" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <!-- Tax Amount -->
        <div class="pe-form-group">
          <label>PPh Terutang <span class="required">*</span></label>
          <input type="number" name="tax" value="{{ $tax['tax'] }}" placeholder="0" min="0" step="1000" required>
        </div>

        <!-- Due Date & Status -->
        <div class="pe-form-row">
          <div class="pe-form-group">
            <label>Jatuh Tempo <span class="required">*</span></label>
            <input type="date" name="due" value="{{ $tax['due'] }}" required>
          </div>
          <div class="pe-form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="pending" {{ $tax['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ $tax['status'] == 'paid' ? 'selected' : '' }}>Dibayar</option>
            </select>
          </div>
        </div>

        <!-- Notes -->
        <div class="pe-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan PPh...">{{ $tax['notes'] }}</textarea>
        </div>

        <!-- Actions -->
        <div class="pe-form-actions">
          <button type="submit" class="pe-btn pe-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Update PPh
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
    <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.pe-btn');
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