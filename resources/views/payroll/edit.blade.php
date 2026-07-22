<x-app-layout>
  <x-slot name="title">Edit Payroll</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY data - nanti diganti dengan data dari database
    $payroll = [
        'id' => 1,
        'employee_id' => 1,
        'employee_name' => 'Budi Santoso',
        'position' => 'Pengrajin Batik',
        'period' => 'Juli 2026',
        'basic_salary' => 4500000,
        'allowance' => 500000,
        'deduction' => 200000,
        'total' => 4800000,
        'status' => 'paid',
        'notes' => 'Bonus lembur Idul Fitri',
    ];

    // DUMMY employees
    $employees = [
        ['id' => 1, 'name' => 'Budi Santoso', 'position' => 'Pengrajin Batik', 'basic_salary' => 4500000],
        ['id' => 2, 'name' => 'Siti Rahayu', 'position' => 'Desainer', 'basic_salary' => 5200000],
        ['id' => 3, 'name' => 'Agus Wijaya', 'position' => 'Marketing', 'basic_salary' => 4800000],
        ['id' => 4, 'name' => 'Dewi Lestari', 'position' => 'Admin', 'basic_salary' => 4000000],
        ['id' => 5, 'name' => 'Hendra Gunawan', 'position' => 'Pengrajin Batik', 'basic_salary' => 4500000],
    ];

    $months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
  @endphp

  <style>
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

    .pe-form-row-3 {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
    }

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

    .pe-summary {
      margin-top: 24px;
      padding-top: 24px;
      border-top: 1px solid var(--border-color);
    }

    .pe-summary .summary-title {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 14px;
    }

    .pe-summary-item {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
      font-size: 14px;
    }

    .pe-summary-item .label {
      color: var(--text-secondary);
    }

    .pe-summary-item .value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .pe-summary-item .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .pe-summary-total {
      display: flex;
      justify-content: space-between;
      padding: 14px 0 4px;
      margin-top: 8px;
      border-top: 2px solid var(--theme-primary);
      font-size: 18px;
      font-weight: 700;
    }

    .pe-summary-total .label {
      color: var(--text-primary);
    }

    .pe-summary-total .value {
      color: var(--theme-primary);
    }

    .pe-summary-total .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

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

    @media (max-width: 992px) {
      .pe-wrap { padding: 0 16px; }
      .pe-card { padding: 24px 28px; }
      .pe-form-row-3 { 
        grid-template-columns: 1fr 1fr; 
      }
    }

    @media (max-width: 768px) {
      .pe-wrap { padding: 0 12px; }
      .pe-card { padding: 20px; }
      .pe-form-row { 
        grid-template-columns: 1fr; 
        gap: 0;
      }
      .pe-form-row-3 { 
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

    <div class="pe-header animate-in" style="animation-delay: 0.05s;">
      <div class="pe-header-left">
        <div class="pe-badge">
          <span class="dot"></span>
          HR &amp; Payroll
        </div>
        <h1>Edit Payroll</h1>
        <p class="subtitle">
          Edit slip gaji — <strong>{{ $payroll['employee_name'] }}</strong> — {{ $payroll['period'] }}
        </p>
      </div>
      <div class="pe-actions">
        <a href="{{ route('payroll.show', $payroll['id']) }}" class="pe-btn pe-btn-ghost">
          <svg class="icon"><use href="#ic-eye"/></svg>
          Batal
        </a>
        <a href="{{ route('payroll.index') }}" class="pe-btn pe-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('payroll.update', $payroll['id']) }}" method="POST" class="pe-form">
      @csrf
      @method('PUT')

      <div class="pe-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-users"/></svg>
          Informasi Payroll
          <span class="line"></span>
        </div>

        <div class="pe-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Pastikan semua komponen gaji sudah benar sebelum menyimpan.
            Total gaji akan dihitung otomatis.
          </div>
        </div>

        <div class="pe-form-group">
          <label>Karyawan <span class="required">*</span></label>
          <select name="employee_id" id="employeeSelect" required>
            <option value="">Pilih Karyawan...</option>
            @foreach($employees as $e)
              <option value="{{ $e['id'] }}" 
                      data-salary="{{ $e['basic_salary'] }}" 
                      data-position="{{ $e['position'] }}"
                      {{ $e['id'] == $payroll['employee_id'] ? 'selected' : '' }}>
                {{ $e['name'] }} — {{ $e['position'] }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="pe-form-row">
          <div class="pe-form-group">
            <label>Periode <span class="required">*</span></label>
            <select name="period" required>
              @foreach($months as $month)
                @php
                  $year = date('Y');
                  $value = $month . ' ' . $year;
                  $selected = ($value == $payroll['period']) ? 'selected' : '';
                @endphp
                <option value="{{ $value }}" {{ $selected }}>
                  {{ $month }} {{ $year }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="pe-form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="pending" {{ $payroll['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ $payroll['status'] == 'paid' ? 'selected' : '' }}>Dibayar</option>
              <option value="cancelled" {{ $payroll['status'] == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
          </div>
        </div>

        <div class="pe-form-row-3">
          <div class="pe-form-group">
            <label>Gaji Pokok <span class="required">*</span></label>
            <input type="number" name="basic_salary" id="basicSalary" value="{{ $payroll['basic_salary'] }}" placeholder="0" min="0" step="1000" required>
          </div>
          <div class="pe-form-group">
            <label>Tunjangan</label>
            <input type="number" name="allowance" id="allowance" value="{{ $payroll['allowance'] }}" placeholder="0" min="0" step="1000">
          </div>
          <div class="pe-form-group">
            <label>Potongan</label>
            <input type="number" name="deduction" id="deduction" value="{{ $payroll['deduction'] }}" placeholder="0" min="0" step="1000">
          </div>
        </div>

        <div class="pe-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan payroll (contoh: bonus, lembur, dll)...">{{ $payroll['notes'] }}</textarea>
        </div>

        <div class="pe-summary">
          <div class="summary-title">Ringkasan Gaji</div>
          <div class="pe-summary-item">
            <span class="label">Gaji Pokok</span>
            <span class="value mono" id="summaryBasic">{{ $currencySymbol }}{{ number_format($payroll['basic_salary'], 0, ',', '.') }}</span>
          </div>
          <div class="pe-summary-item">
            <span class="label">Tunjangan</span>
            <span class="value mono" id="summaryAllowance">{{ $currencySymbol }}{{ number_format($payroll['allowance'], 0, ',', '.') }}</span>
          </div>
          <div class="pe-summary-item">
            <span class="label">Potongan</span>
            <span class="value mono" id="summaryDeduction">{{ $currencySymbol }}{{ number_format($payroll['deduction'], 0, ',', '.') }}</span>
          </div>
          <div class="pe-summary-total">
            <span class="label">Total Gaji</span>
            <span class="value mono" id="summaryTotal">{{ $currencySymbol }}{{ number_format($payroll['total'], 0, ',', '.') }}</span>
          </div>
        </div>

        <div class="pe-form-actions">
          <button type="submit" class="pe-btn pe-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Update Payroll
          </button>
        </div>
      </div>

    </form>

  </div>

  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-users" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
    <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const employeeSelect = document.getElementById('employeeSelect');
      const basicSalaryInput = document.getElementById('basicSalary');
      const allowanceInput = document.getElementById('allowance');
      const deductionInput = document.getElementById('deduction');

      const summaryBasic = document.getElementById('summaryBasic');
      const summaryAllowance = document.getElementById('summaryAllowance');
      const summaryDeduction = document.getElementById('summaryDeduction');
      const summaryTotal = document.getElementById('summaryTotal');

      const currencySymbol = '{{ $currencySymbol }}';

      function calculateTotal() {
        const basic = parseInt(basicSalaryInput.value) || 0;
        const allowance = parseInt(allowanceInput.value) || 0;
        const deduction = parseInt(deductionInput.value) || 0;
        const total = basic + allowance - deduction;

        summaryBasic.textContent = currencySymbol + basic.toLocaleString('id-ID');
        summaryAllowance.textContent = currencySymbol + allowance.toLocaleString('id-ID');
        summaryDeduction.textContent = currencySymbol + deduction.toLocaleString('id-ID');
        summaryTotal.textContent = currencySymbol + total.toLocaleString('id-ID');
      }

      employeeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const salary = selectedOption.dataset.salary;
        
        if (salary) {
          basicSalaryInput.value = salary;
          calculateTotal();
        }
      });

      basicSalaryInput.addEventListener('input', calculateTotal);
      allowanceInput.addEventListener('input', calculateTotal);
      deductionInput.addEventListener('input', calculateTotal);

      setTimeout(calculateTotal, 100);

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