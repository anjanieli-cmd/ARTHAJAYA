<x-app-layout>
  <x-slot name="title">Tambah Karyawan</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
  @endphp

  <style>
    .emp-create-wrap {
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

    .emp-create-wrap * { box-sizing: border-box; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .emp-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .emp-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .ec-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .ec-header-left { flex: 1; min-width: 200px; }

    .ec-badge {
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

    .ec-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .ec-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .ec-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .ec-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .ec-btn {
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

    .ec-btn .icon { width: 16px; height: 16px; }
    .ec-btn:hover { transform: translateY(-2px); }
    .ec-btn:active { transform: translateY(0) scale(0.97); }

    .ec-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .ec-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .ec-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .ec-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .ec-btn .ripple {
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
    .ec-form {
      max-width: 700px;
      margin: 0 auto;
    }

    .ec-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .ec-card:hover { border-color: var(--border-hover); }

    .ec-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .ec-form-group {
      margin-bottom: 18px;
    }

    .ec-form-group:last-child { margin-bottom: 0; }

    .ec-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .ec-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .ec-form-group input,
    .ec-form-group select,
    .ec-form-group textarea {
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

    .ec-form-group input:focus,
    .ec-form-group select:focus,
    .ec-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .ec-form-group input::placeholder,
    .ec-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .ec-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .ec-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .ec-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .ec-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .ec-form-actions .ec-btn {
      flex: 1;
      justify-content: center;
    }

    @media (max-width: 768px) {
      .ec-form-row { grid-template-columns: 1fr; }
      .ec-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .ec-header { flex-direction: column; }
      .ec-actions { width: 100%; }
      .ec-actions .ec-btn { flex: 1; justify-content: center; }
    }
  </style>

  <div class="emp-create-wrap">

    <div class="ec-header animate-in" style="animation-delay: 0.05s;">
      <div class="ec-header-left">
        <div class="ec-badge">
          <span class="dot"></span>
          HR &amp; Payroll
        </div>
        <h1>Tambah Karyawan</h1>
        <p class="subtitle">Tambahkan data karyawan baru</p>
      </div>
      <div class="ec-actions">
        <a href="{{ route('employees.index') }}" class="ec-btn ec-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('employees.store') }}" method="POST" class="ec-form">
      @csrf

      <div class="ec-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Data Karyawan</div>

        <div class="ec-form-group">
          <label>Nama Lengkap <span class="required">*</span></label>
          <input type="text" name="name" placeholder="Contoh: Budi Santoso" required>
        </div>

        <div class="ec-form-row">
          <div class="ec-form-group">
            <label>Posisi <span class="required">*</span></label>
            <input type="text" name="position" placeholder="Contoh: Pengrajin Batik" required>
          </div>
          <div class="ec-form-group">
            <label>Departemen <span class="required">*</span></label>
            <select name="department" required>
              <option value="">Pilih Departemen...</option>
              <option value="Produksi">Produksi</option>
              <option value="Kreatif">Kreatif</option>
              <option value="Marketing">Marketing</option>
              <option value="Operasional">Operasional</option>
              <option value="Keuangan">Keuangan</option>
              <option value="HRD">HRD</option>
              <option value="IT">IT</option>
            </select>
          </div>
        </div>

        <div class="ec-form-row">
          <div class="ec-form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" placeholder="email@perusahaan.com" required>
          </div>
          <div class="ec-form-group">
            <label>Telepon <span class="required">*</span></label>
            <input type="text" name="phone" placeholder="0812-3456-7890" required>
          </div>
        </div>

        <div class="ec-form-row">
          <div class="ec-form-group">
            <label>Tanggal Bergabung <span class="required">*</span></label>
            <input type="date" name="joined" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="ec-form-group">
            <label>Gaji Pokok <span class="required">*</span></label>
            <input type="number" name="salary" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <div class="ec-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
          </select>
        </div>

        <div class="ec-form-group">
          <label>Alamat</label>
          <textarea name="address" placeholder="Alamat lengkap karyawan..."></textarea>
        </div>

        <div class="ec-form-actions">
          <button type="submit" class="ec-btn ec-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Karyawan
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.ec-btn');
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