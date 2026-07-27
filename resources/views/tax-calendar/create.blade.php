<x-app-layout>
  <x-slot name="title">Tambah Event Kalender Pajak</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
  @endphp

  <style>
    /* ============================================
       KALENDER PAJAK CREATE - Premium Design
       ============================================ */
    
    .cal-create-wrap {
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
      padding: 0 24px;
    }

    .cal-create-wrap * { box-sizing: border-box; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    .cal-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .cal-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .cc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .cc-header-left { flex: 1; min-width: 200px; }

    .cc-badge {
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

    .cc-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .cc-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .cc-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .cc-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .cc-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .cc-btn {
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
      font-family: 'Inter', sans-serif;
    }

    .cc-btn .icon { width: 16px; height: 16px; }
    .cc-btn:hover { transform: translateY(-2px); }
    .cc-btn:active { transform: translateY(0) scale(0.97); }

    .cc-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .cc-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .cc-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .cc-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .cc-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    /* ===== FORM - FULL WIDTH ===== */
    .cc-form {
      width: 100%;
    }

    .cc-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 36px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
    }

    .cc-card:hover {
      border-color: var(--border-hover);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    }

    .cc-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cc-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .cc-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .cc-form-group {
      margin-bottom: 20px;
    }

    .cc-form-group:last-child { margin-bottom: 0; }

    .cc-form-group label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .cc-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .cc-form-group input,
    .cc-form-group select,
    .cc-form-group textarea {
      width: 100%;
      padding: 11px 16px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .cc-form-group input:focus,
    .cc-form-group select:focus,
    .cc-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .cc-form-group input::placeholder,
    .cc-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .cc-form-group textarea {
      resize: vertical;
      min-height: 90px;
    }

    .cc-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .cc-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 14px;
    }

    .cc-form-group select option:checked,
    .cc-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .cc-form-group select option:disabled {
      color: #6b7280;
    }

    .cc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* INFO BOX */
    .cc-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 14px 18px;
      margin-bottom: 24px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .cc-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .cc-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.6;
    }

    .cc-info-box .message strong {
      color: var(--text-primary);
    }

    /* FORM ACTIONS */
    .cc-form-actions {
      display: flex;
      gap: 12px;
      margin-top: 28px;
      padding-top: 24px;
      border-top: 1px solid var(--border-color);
    }

    .cc-form-actions .cc-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 24px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .cal-create-wrap { padding: 0 16px; }
      .cc-card { padding: 28px 32px; }
    }

    @media (max-width: 768px) {
      .cal-create-wrap { padding: 0 12px; }
      .cc-card { padding: 24px 28px; }
      .cc-form-row { 
        grid-template-columns: 1fr; 
        gap: 0;
      }
      .cc-header h1 { font-size: 24px; }
    }

    @media (max-width: 640px) {
      .cal-create-wrap { padding: 0 12px; }
      .cc-header { 
        flex-direction: column; 
      }
      .cc-actions { 
        width: 100%; 
      }
      .cc-actions .cc-btn { 
        flex: 1; 
        justify-content: center; 
        font-size: 12px;
        padding: 8px 12px;
      }
      .cc-form-actions { 
        flex-direction: column; 
      }
      .cc-form-actions .cc-btn { 
        flex: none; 
      }
      .cc-card { 
        padding: 20px; 
      }
    }

    @media (max-width: 380px) {
      .cal-create-wrap { padding: 0 8px; }
      .cc-header h1 { 
        font-size: 22px; 
      }
      .cc-btn { 
        font-size: 11px; 
        padding: 6px 10px; 
      }
      .cc-btn .icon { 
        width: 13px; 
        height: 13px; 
      }
      .cc-card { 
        padding: 16px; 
      }
    }
  </style>

  <div class="cal-create-wrap">

    <!-- ===== HEADER ===== -->
    <div class="cc-header animate-in" style="animation-delay: 0.05s;">
      <div class="cc-header-left">
        <div class="cc-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Tambah Event Kalender Pajak</h1>
        <p class="subtitle">
          Tambahkan event pajak baru ke kalender — <strong>kelola jadwal pajak dengan mudah</strong>
        </p>
      </div>
      <div class="cc-actions">
        <a href="{{ route('tax-calendar.index') }}" class="cc-btn cc-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('tax-calendar.store') }}" method="POST" class="cc-form">
      @csrf

      <div class="cc-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-calendar"/></svg>
          Informasi Event
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="cc-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Tambahkan event pajak seperti PPh, PPN, atau event pajak lainnya. 
            Event akan muncul di kalender pajak dan pengingat.
          </div>
        </div>

        <!-- Title -->
        <div class="cc-form-group">
          <label>Judul Event <span class="required">*</span></label>
          <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: PPh Pasal 21 / PPN Masa Juli" required>
        </div>

        <!-- Date & Type -->
        <div class="cc-form-row">
          <div class="cc-form-group">
            <label>Tanggal <span class="required">*</span></label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d', strtotime('+14 days'))) }}" required>
          </div>
          <div class="cc-form-group">
            <label>Tipe <span class="required">*</span></label>
            <select name="type" required>
              <option value="pph" {{ old('type') == 'pph' ? 'selected' : '' }}>PPh</option>
              <option value="ppn" {{ old('type') == 'ppn' ? 'selected' : '' }}>PPN</option>
              <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
          </div>
        </div>

        <!-- Description -->
        <div class="cc-form-group">
          <label>Deskripsi <span class="required">*</span></label>
          <textarea name="desc" placeholder="Deskripsi event (contoh: Pembayaran PPh Pasal 21 periode Juli)" required>{{ old('desc') }}</textarea>
        </div>

        <!-- Status -->
        <div class="cc-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
            <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Lewat Jatuh Tempo</option>
            <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Selesai</option>
          </select>
        </div>

        <!-- Actions -->
        <div class="cc-form-actions">
          <button type="submit" class="cc-btn cc-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Event
          </button>
          <a href="{{ route('tax-calendar.index') }}" class="cc-btn cc-btn-ghost">
            Batal
          </a>
        </div>
      </div>

    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="5" y1="12" x2="19" y2="12"/>
        <polyline points="12 5 19 12 12 19"/>
      </symbol>
      <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"/>
      </symbol>
      <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="16" x2="12" y2="12"/>
        <line x1="12" y1="8" x2="12.01" y2="8"/>
      </symbol>
      <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </symbol>
    </defs>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.cc-btn');
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          // Skip jika ini link
          if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
            return;
          }
          const rect = this.getBoundingClientRect();
          const ripple = document.createElement('span');
          ripple.className = 'ripple';
          const size = Math.max(rect.width, rect.height);
          ripple.style.width = ripple.style.height = size + 'px';
          ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
          ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
          this.appendChild(ripple);
          setTimeout(function() { 
            if (ripple.parentNode) ripple.remove(); 
          }, 600);
        });
      });
    });
  </script>

</x-app-layout>