<x-app-layout>
  <x-slot name="title">Tambah PPN</x-slot>

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
       PPN CREATE - Premium Design
       ============================================ */
    
    .ppn-create-wrap {
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

    .ppn-create-wrap * { box-sizing: border-box; }
    .ppn-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .ppn-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .ppn-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .pn-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .pn-header-left { flex: 1; min-width: 200px; }

    .pn-badge {
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

    .pn-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .pn-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .pn-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .pn-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .pn-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .pn-btn {
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

    .pn-btn .icon { width: 16px; height: 16px; }
    .pn-btn:hover { transform: translateY(-2px); }
    .pn-btn:active { transform: translateY(0) scale(0.97); }

    .pn-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pn-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .pn-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .pn-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .pn-btn .ripple {
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
    .pn-form {
      max-width: 800px;
      margin: 0 auto;
    }

    .pn-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .pn-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .pn-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .pn-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .pn-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .pn-form-group {
      margin-bottom: 18px;
    }

    .pn-form-group:last-child { margin-bottom: 0; }

    .pn-form-group label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .pn-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .pn-form-group input,
    .pn-form-group select,
    .pn-form-group textarea {
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

    .pn-form-group input:focus,
    .pn-form-group select:focus,
    .pn-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .pn-form-group input::placeholder,
    .pn-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .pn-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .pn-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .pn-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 13px;
    }

    .pn-form-group select option:checked,
    .pn-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .pn-form-group select option:disabled {
      color: #6b7280;
    }

    .pn-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    /* INFO BOX */
    .pn-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      margin-bottom: 18px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }

    .pn-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .pn-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.5;
    }

    .pn-info-box .message strong {
      color: var(--text-primary);
    }

    /* FORM ACTIONS */
    .pn-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .pn-form-actions .pn-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .pn-form-row { 
        grid-template-columns: 1fr; 
      }
      .pn-card { 
        padding: 20px; 
      }
    }

    @media (max-width: 640px) {
      .pn-header { 
        flex-direction: column; 
      }
      .pn-actions { 
        width: 100%; 
      }
      .pn-actions .pn-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .pn-form-actions { 
        flex-direction: column; 
      }
      .pn-form-actions .pn-btn { 
        flex: none; 
      }
    }

    @media (max-width: 380px) {
      .pn-header h1 { 
        font-size: 22px; 
      }
      .pn-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .pn-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
    }
  </style>

  <div class="ppn-create-wrap">

    <!-- ===== HEADER ===== -->
    <div class="pn-header animate-in" style="animation-delay: 0.05s;">
      <div class="pn-header-left">
        <div class="pn-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Tambah PPN</h1>
        <p class="subtitle">
          Catat Pajak Pertambahan Nilai (PPN) — <strong>periode {{ $currentMonth }}</strong>
        </p>
      </div>
      <div class="pn-actions">
        <a href="{{ route('taxes.ppn') }}" class="pn-btn pn-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('taxes.ppn.store') }}" method="POST" class="pn-form">
      @csrf

      <div class="pn-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-tax"/></svg>
          Informasi PPN
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="pn-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Catat PPN Keluaran dan PPN Masukan untuk setiap periode. 
            Selisih antara keduanya akan menentukan PPN yang harus dibayar.
          </div>
        </div>

        <!-- Period -->
        <div class="pn-form-group">
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

        <!-- Output & Input -->
        <div class="pn-form-row">
          <div class="pn-form-group">
            <label>PPN Keluaran <span class="required">*</span></label>
            <input type="number" name="output" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="pn-form-group">
            <label>PPN Masukan <span class="required">*</span></label>
            <input type="number" name="input" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <!-- Due Date & Status -->
        <div class="pn-form-row">
          <div class="pn-form-group">
            <label>Jatuh Tempo <span class="required">*</span></label>
            <input type="date" name="due" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
          </div>
          <div class="pn-form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="pending">Pending</option>
              <option value="paid">Dibayar</option>
            </select>
          </div>
        </div>

        <!-- Notes -->
        <div class="pn-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan PPN..."></textarea>
        </div>

        <!-- Actions -->
        <div class="pn-form-actions">
          <button type="submit" class="pn-btn pn-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan PPN
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
      const buttons = document.querySelectorAll('.pn-btn');
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