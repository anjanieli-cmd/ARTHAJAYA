<x-app-layout>
  <x-slot name="title">Buat Payroll</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY employees - nanti ganti dengan data dari database
    $employees = [
        ['id' => 1, 'name' => 'Budi Santoso', 'position' => 'Pengrajin Batik', 'basic_salary' => 4500000],
        ['id' => 2, 'name' => 'Siti Rahayu', 'position' => 'Desainer', 'basic_salary' => 5200000],
        ['id' => 3, 'name' => 'Agus Wijaya', 'position' => 'Marketing', 'basic_salary' => 4800000],
        ['id' => 4, 'name' => 'Dewi Lestari', 'position' => 'Admin', 'basic_salary' => 4000000],
        ['id' => 5, 'name' => 'Hendra Gunawan', 'position' => 'Pengrajin Batik', 'basic_salary' => 4500000],
    ];
  @endphp

  <style>
    .payroll-create-wrap {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .payroll-create-wrap * { box-sizing: border-box; }
    .payroll-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .payroll-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .payroll-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .pc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .pc-header-left { flex: 1; min-width: 200px; }

    .pc-badge {
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

    .pc-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .pc-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .pc-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .pc-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .pc-btn {
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

    .pc-btn .icon { width: 16px; height: 16px; }
    .pc-btn:hover { transform: translateY(-2px); }
    .pc-btn:active { transform: translateY(0) scale(0.97); }

    .pc-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .pc-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .pc-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .pc-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .pc-btn .ripple {
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
    .pc-form {
      max-width: 800px;
      margin: 0 auto;
    }

    .pc-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .pc-card:hover { border-color: var(--border-hover); }

    .pc-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .pc-form-group {
      margin-bottom: 18px;
    }

    .pc-form-group:last-child { margin-bottom: 0; }

    .pc-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .pc-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .pc-form-group input,
    .pc-form-group select,
    .pc-form-group textarea {
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

    .pc-form-group input:focus,
    .pc-form-group select:focus,
    .pc-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .pc-form-group input::placeholder,
    .pc-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .pc-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .pc-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .pc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .pc-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .pc-form-actions .pc-btn {
      flex: 1;
      justify-content: center;
    }

    .pc-info-box {
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

    .pc-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
    }

    .pc-info-box .message {
      font-size: 13px;
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .pc-form-row { grid-template-columns: 1fr; }
      .pc-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .pc-header { flex-direction: column; }
      .pc-actions { width: 100%; }
      .pc-actions .pc-btn { flex: 1; justify-content: center; }
    }
  </style>

  <div class="payroll-create-wrap">

    <div class="pc-header animate-in" style="animation-delay: 0.05s;">
      <div class="pc-header-left">
        <div class="pc-badge">
          <span class="dot"></span>
          HR &amp; Payroll
        </div>
        <h1>Buat Payroll</h1>
        <p class="subtitle">Buat slip gaji untuk karyawan</p>
      </div>
      <div class="pc-actions">
        <a href="{{ route('payroll.index') }}" class="pc-btn pc-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('payroll.store') }}" method="POST" class="pc-form">
      @csrf

      <div class="pc-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Informasi Payroll</div>

        <div class="pc-info-box">
          <svg class="icon"><use href="#ic-users"/></svg>
          <span class="message">Pilih karyawan dan periode untuk membuat slip gaji</span>
        </div>

        <div class="pc-form-group">
          <label>Karyawan <span class="required">*</span></label>
          <select name="employee_id" required>
            <option value="">Pilih Karyawan...</option>
            @foreach($employees as $e)
              <option value="{{ $e['id'] }}" data-salary="{{ $e['basic_salary'] }}">
                {{ $e['name'] }} - {{ $e['position'] }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="pc-form-row">
          <div class="pc-form-group">
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
          <div class="pc-form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="paid">Dibayar</option>
              <option value="pending" selected>Pending</option>
            </select>
          </div>
        </div>

        <div class="pc-form-row">
          <div class="pc-form-group">
            <label>Gaji Pokok <span class="required">*</span></label>
            <input type="number" name="basic_salary" id="basicSalary" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="pc-form-group">
            <label>Tunjangan</label>
            <input type="number" name="allowance" placeholder="0" min="0" step="1000" value="0">
          </div>
        </div>

        <div class="pc-form-group">
          <label>Potongan</label>
          <input type="number" name="deduction" placeholder="0" min="0" step="1000" value="0">
        </div>

        <div class="pc-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan payroll..."></textarea>
        </div>

        <div class="pc-form-actions">
          <button type="submit" class="pc-btn pc-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Payroll
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Auto fill basic salary when employee selected
      const employeeSelect = document.querySelector('select[name="employee_id"]');
      const basicSalaryInput = document.getElementById('basicSalary');

      employeeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const salary = selectedOption.dataset.salary;
        if (salary) {
          basicSalaryInput.value = salary;
        } else {
          basicSalaryInput.value = '';
        }
      });

      // Ripple effect
      const buttons = document.querySelectorAll('.pc-btn');
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