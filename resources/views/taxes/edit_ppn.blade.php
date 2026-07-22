<x-app-layout>
  <x-slot name="title">Edit PPN</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY data - nanti diganti dengan data dari database
    $tax = [
        'id' => 1,
        'period' => 'Juli 2026',
        'output' => 5500000,
        'input' => 3300000,
        'due' => '2026-08-20',
        'status' => 'pending',
        'notes' => 'PPN Masa Juli 2026',
    ];

    $months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
  @endphp

  <style>
    /* ============================================
       PPN EDIT - Premium Design
       ============================================ */
    
    .pne-wrap {
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

    .pne-wrap * { box-sizing: border-box; }
    .pne-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .pne-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .pne-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .pne-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .pne-header-left { flex: 1; min-width: 200px; }

    .pne-badge {
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

    .pne-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .pne-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .pne-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .pne-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .pne-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .pne-btn {
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

    .pne-btn .icon { width: 16px; height: 16px; }
    .pne-btn:hover { transform: translateY(-2px); }
    .pne-btn:active { transform: translateY(0) scale(0.97); }

    .pne-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pne-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .pne-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .pne-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .pne-btn .ripple {
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
    .pne-form {
      width: 100%;
      max-width: 100%;
    }

    .pne-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 40px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
    }

    .pne-card:hover {
      border-color: var(--border-hover);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .pne-card .title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .pne-card .title .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    .pne-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .pne-form-group {
      margin-bottom: 20px;
    }

    .pne-form-group:last-child { margin-bottom: 0; }

    .pne-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .pne-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .pne-form-group input,
    .pne-form-group select,
    .pne-form-group textarea {
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

    .pne-form-group input:focus,
    .pne-form-group select:focus,
    .pne-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .pne-form-group input::placeholder,
    .pne-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .pne-form-group textarea {
      resize: vertical;
      min-height: 90px;
    }

    .pne-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .pne-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 14px;
    }

    .pne-form-group select option:checked,
    .pne-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .pne-form-group select option:disabled {
      color: #6b7280;
    }

    .pne-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* INFO BOX */
    .pne-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 14px 18px;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .pne-info-box .icon {
      width: 22px;
      height: 22px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .pne-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.6;
    }

    .pne-info-box .message strong {
      color: var(--text-primary);
    }

    /* FORM ACTIONS */
    .pne-form-actions {
      display: flex;
      gap: 12px;
      margin-top: 28px;
    }

    .pne-form-actions .pne-btn {
      flex: 1;
      justify-content: center;
      padding: 14px 24px;
      font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .pne-wrap { padding: 0 16px; }
      .pne-card { padding: 24px 28px; }
    }

    @media (max-width: 768px) {
      .pne-wrap { padding: 0 12px; }
      .pne-card { padding: 20px; }
      .pne-form-row { 
        grid-template-columns: 1fr; 
        gap: 0;
      }
      .pne-header h1 { font-size: 24px; }
    }

    @media (max-width: 640px) {
      .pne-header { 
        flex-direction: column; 
      }
      .pne-actions { 
        width: 100%; 
      }
      .pne-actions .pne-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .pne-form-actions { 
        flex-direction: column; 
      }
      .pne-form-actions .pne-btn { 
        flex: none; 
      }
      .pne-card { padding: 16px; }
    }

    @media (max-width: 380px) {
      .pne-header h1 { 
        font-size: 20px; 
      }
      .pne-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .pne-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
      .pne-card { padding: 12px; }
    }
  </style>

  <div class="pne-wrap">

    <!-- ===== HEADER ===== -->
    <div class="pne-header animate-in" style="animation-delay: 0.05s;">
      <div class="pne-header-left">
        <div class="pne-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Edit PPN</h1>
        <p class="subtitle">
          Edit Pajak Pertambahan Nilai — <strong>periode {{ $tax['period'] }}</strong>
        </p>
      </div>
      <div class="pne-actions">
        <a href="{{ route('taxes.ppn.show', $tax['id']) }}" class="pne-btn pne-btn-ghost">
          <svg class="icon"><use href="#ic-eye"/></svg>
          Batal
        </a>
        <a href="{{ route('taxes.ppn') }}" class="pne-btn pne-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('taxes.ppn.update', $tax['id']) }}" method="POST" class="pne-form">
      @csrf
      @method('PUT')

      <div class="pne-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-tax"/></svg>
          Informasi PPN
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="pne-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Catat PPN Keluaran dan PPN Masukan untuk setiap periode. 
            Selisih antara keduanya akan menentukan PPN yang harus dibayar.
          </div>
        </div>

        <!-- Period -->
        <div class="pne-form-group">
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

        <!-- Output & Input -->
        <div class="pne-form-row">
          <div class="pne-form-group">
            <label>PPN Keluaran <span class="required">*</span></label>
            <input type="number" name="output" value="{{ $tax['output'] }}" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="pne-form-group">
            <label>PPN Masukan <span class="required">*</span></label>
            <input type="number" name="input" value="{{ $tax['input'] }}" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <!-- Due Date & Status -->
        <div class="pne-form-row">
          <div class="pne-form-group">
            <label>Jatuh Tempo <span class="required">*</span></label>
            <input type="date" name="due" value="{{ $tax['due'] }}" required>
          </div>
          <div class="pne-form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="pending" {{ $tax['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ $tax['status'] == 'paid' ? 'selected' : '' }}>Dibayar</option>
            </select>
          </div>
        </div>

        <!-- Notes -->
        <div class="pne-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan PPN...">{{ $tax['notes'] }}</textarea>
        </div>

        <!-- Actions -->
        <div class="pne-form-actions">
          <button type="submit" class="pne-btn pne-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Update PPN
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
      const buttons = document.querySelectorAll('.pne-btn');
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