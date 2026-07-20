<x-app-layout>
  <x-slot name="title">Tambah Event Kalender Pajak</x-slot>

  <style>
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .cal-create-wrap * { box-sizing: border-box; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
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

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    /* FORM */
    .cc-form {
      max-width: 700px;
      margin: 0 auto;
    }

    .cc-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .cc-card:hover { border-color: var(--border-hover); }

    .cc-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .cc-form-group {
      margin-bottom: 18px;
    }

    .cc-form-group:last-child { margin-bottom: 0; }

    .cc-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .cc-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .cc-form-group input,
    .cc-form-group select,
    .cc-form-group textarea {
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

    .cc-form-group input:focus,
    .cc-form-group select:focus,
    .cc-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .cc-form-group input::placeholder,
    .cc-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .cc-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .cc-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .cc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .cc-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .cc-form-actions .cc-btn {
      flex: 1;
      justify-content: center;
    }

    @media (max-width: 768px) {
      .cc-form-row { grid-template-columns: 1fr; }
      .cc-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .cc-header { flex-direction: column; }
      .cc-actions { width: 100%; }
      .cc-actions .cc-btn { flex: 1; justify-content: center; }
    }
  </style>

  <div class="cal-create-wrap">

    <div class="cc-header animate-in" style="animation-delay: 0.05s;">
      <div class="cc-header-left">
        <div class="cc-badge">
          <span class="dot"></span>
          Pajak
        </div>
        <h1>Tambah Event Kalender Pajak</h1>
        <p class="subtitle">Tambahkan event pajak baru ke kalender</p>
      </div>
      <div class="cc-actions">
        <a href="{{ route('tax-calendar.index') }}" class="cc-btn cc-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('tax-calendar.store') }}" method="POST" class="cc-form">
      @csrf

      <div class="cc-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Informasi Event</div>

        <div class="cc-form-group">
          <label>Judul Event <span class="required">*</span></label>
          <input type="text" name="title" placeholder="Contoh: PPh Pasal 21" required>
        </div>

        <div class="cc-form-row">
          <div class="cc-form-group">
            <label>Tanggal <span class="required">*</span></label>
            <input type="date" name="date" value="{{ date('Y-m-d', strtotime('+14 days')) }}" required>
          </div>
          <div class="cc-form-group">
            <label>Tipe <span class="required">*</span></label>
            <select name="type" required>
              <option value="pph">PPh</option>
              <option value="ppn">PPN</option>
              <option value="other">Lainnya</option>
            </select>
          </div>
        </div>

        <div class="cc-form-group">
          <label>Deskripsi <span class="required">*</span></label>
          <textarea name="desc" placeholder="Deskripsi event..." required></textarea>
        </div>

        <div class="cc-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="upcoming">Akan Datang</option>
            <option value="overdue">Lewat Jatuh Tempo</option>
            <option value="done">Selesai</option>
          </select>
        </div>

        <div class="cc-form-actions">
          <button type="submit" class="cc-btn cc-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Event
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.cc-btn');
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