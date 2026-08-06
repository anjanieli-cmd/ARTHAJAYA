<x-app-layout>
    <x-slot name="title">Buat Payroll</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $currentMonth = $months[date('n') - 1] . ' ' . date('Y');
    @endphp

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </symbol>
            <symbol id="ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
        </defs>
    </svg>

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
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
            width: 100%;
            max-width: 100%;
        }

        .payroll-create-wrap * { box-sizing: border-box; }
        .payroll-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

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

        .pc-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
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
            font-family: 'Inter', sans-serif;
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

        /* FORM - FULL WIDTH */
        .pc-form {
            width: 100%;
            max-width: 100%;
        }

        .pc-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
        }

        .pc-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .pc-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pc-card .title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .pc-card .title .line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border-color), transparent);
        }

        /* FORM GROUP */
        .pc-form-group {
            margin-bottom: 20px;
        }

        .pc-form-group:last-child { margin-bottom: 0; }

        .pc-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .pc-form-group .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .pc-form-group input,
        .pc-form-group select,
        .pc-form-group textarea {
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

        .pc-form-group input:focus,
        .pc-form-group select:focus,
        .pc-form-group textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card-hover);
            box-shadow: 0 0 0 4px var(--theme-glow);
        }

        .pc-form-group input::placeholder,
        .pc-form-group textarea::placeholder {
            color: var(--text-tertiary);
        }

        .pc-form-group textarea {
            resize: vertical;
            min-height: 90px;
        }

        .pc-form-group select {
            cursor: pointer;
            appearance: auto;
            -webkit-appearance: auto;
            color-scheme: light dark;
        }

        .pc-form-group select option {
            background-color: var(--bg-card);
            color: var(--text-primary);
            padding: 10px 14px;
            font-size: 14px;
        }

        .pc-form-group select option:checked,
        .pc-form-group select option:hover {
            background-color: var(--theme-soft);
            color: var(--theme-primary);
        }

        .pc-form-group select option:disabled {
            color: var(--text-tertiary);
        }

        .pc-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .pc-form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 992px) {
            .pc-form-row-3 { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .pc-form-row { grid-template-columns: 1fr; gap: 0; }
            .pc-form-row-3 { grid-template-columns: 1fr; gap: 0; }
        }

        .pc-info-box {
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .pc-info-box .icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            margin-top: 1px;
            color: var(--theme-primary);
        }

        .pc-info-box .message {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .pc-info-box .message strong {
            color: var(--text-primary);
        }

        .pc-summary {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .pc-summary .summary-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 14px;
        }

        .pc-summary-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .pc-summary-item:last-of-type {
            border-bottom: none;
        }

        .pc-summary-item .label {
            color: var(--text-secondary);
        }

        .pc-summary-item .value {
            font-weight: 600;
            color: var(--text-primary);
        }

        .pc-summary-item .value.mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .pc-summary-total {
            display: flex;
            justify-content: space-between;
            padding: 12px 0 0;
            margin-top: 4px;
            border-top: 2px solid var(--theme-primary);
            font-size: 18px;
            font-weight: 700;
        }

        .pc-summary-total .label {
            color: var(--text-primary);
        }

        .pc-summary-total .value {
            color: var(--theme-primary);
        }

        .pc-summary-total .value.mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .pc-form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .pc-form-actions .pc-btn {
            flex: 1;
            justify-content: center;
            padding: 14px 24px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .payroll-create-wrap { padding: 0 12px; }
            .pc-card { padding: 20px 24px; }
            .pc-header h1 { font-size: 24px; }
            .pc-header { flex-direction: column; }
            .pc-actions { width: 100%; }
            .pc-actions .pc-btn { flex: 1; justify-content: center; }
            .pc-form-actions { flex-direction: column; }
            .pc-form-actions .pc-btn { flex: none; }
        }

        @media (max-width: 640px) {
            .pc-card { padding: 16px; }
            .pc-header h1 { font-size: 20px; }
            .pc-btn { font-size: 12px; padding: 8px 14px; }
            .pc-btn .icon { width: 14px; height: 14px; }
            .pc-summary-total { font-size: 16px; }
        }

        @media (max-width: 380px) {
            .payroll-create-wrap { padding: 0 4px; }
            .pc-card { padding: 12px; }
        }
    </style>

    <div class="payroll-create-wrap">

        <!-- ===== HEADER ===== -->
        <div class="pc-header animate-in" style="animation-delay: 0.05s;">
            <div class="pc-header-left">
                <div class="pc-badge">
                    <span class="dot"></span>
                    HR &amp; Payroll
                </div>
                <h1>Buat Payroll</h1>
                <p class="subtitle">
                    Buat slip gaji untuk karyawan — <strong>periode {{ $currentMonth }}</strong>
                </p>
            </div>
            <div class="pc-actions">
                <a href="{{ route('payroll.index') }}" class="pc-btn pc-btn-ghost">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== FORM - FULL WIDTH ===== -->
        <form action="{{ route('payroll.store') }}" method="POST" class="pc-form">
            @csrf

            <div class="pc-card animate-in" style="animation-delay: 0.10s;">
                <div class="title">
                    <svg class="icon"><use href="#ic-users"/></svg>
                    Informasi Payroll
                    <span class="line"></span>
                </div>

                <!-- Info Box -->
                <div class="pc-info-box">
                    <svg class="icon"><use href="#ic-info"/></svg>
                    <div class="message">
                        <strong>Perhatian:</strong> Pilih karyawan dan periode untuk membuat slip gaji.
                        Gaji pokok akan otomatis terisi dari data karyawan.
                    </div>
                </div>

                <!-- Employee -->
                <div class="pc-form-group">
                    <label>Karyawan <span class="required">*</span></label>
                    <select name="employee_id" id="employeeSelect" required>
                        <option value="">Pilih Karyawan...</option>
                        @foreach($employees as $e)
                            @php
                                $profile = $e->employeeProfile;
                                $salary = $profile->basic_salary ?? 0;
                            @endphp
                            <option value="{{ $e->id }}"
                                    data-salary="{{ $salary }}">
                                {{ $e->name }} ({{ $currencySymbol }}{{ number_format($salary, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @if(count($employees) == 0)
                        <div style="margin-top: 8px; font-size: 13px; color: var(--danger);">
                            ⚠️ Belum ada data karyawan. Silakan tambahkan karyawan terlebih dahulu.
                        </div>
                    @endif
                </div>

                <!-- Jabatan (Position) - Dapat DIKETIK -->
                <div class="pc-form-group">
                    <label>Jabatan <span class="required">*</span></label>
                    <input type="text" name="position" id="positionInput" 
                           placeholder="Contoh: Manager, Staff, Admin, dll" 
                           value="{{ old('position') }}"
                           style="background: var(--bg-card-active);">
                </div>

                <!-- Period & Status -->
                <div class="pc-form-row">
                    <div class="pc-form-group">
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
                    <div class="pc-form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" required>
                            <option value="pending" selected>⏳ Pending</option>
                            <option value="paid">✅ Dibayar</option>
                            <option value="cancelled">❌ Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <!-- Salary Components -->
                <div class="pc-form-row-3">
                    <div class="pc-form-group">
                        <label>Gaji Pokok <span class="required">*</span></label>
                        <input type="number" name="basic_salary" id="basicSalary" placeholder="0" min="0" step="1000" required>
                    </div>
                    <div class="pc-form-group">
                        <label>Tunjangan</label>
                        <input type="number" name="allowance" id="allowance" placeholder="0" min="0" step="1000" value="0">
                    </div>
                    <div class="pc-form-group">
                        <label>Potongan</label>
                        <input type="number" name="deduction" id="deduction" placeholder="0" min="0" step="1000" value="0">
                    </div>
                </div>

                <!-- Notes -->
                <div class="pc-form-group">
                    <label>Catatan</label>
                    <textarea name="notes" placeholder="Catatan payroll (contoh: bonus, lembur, dll)..."></textarea>
                </div>

                <!-- Summary Preview -->
                <div class="pc-summary">
                    <div class="summary-title">📊 Ringkasan Gaji</div>
                    <div class="pc-summary-item">
                        <span class="label">Jabatan</span>
                        <span class="value" id="summaryPosition">—</span>
                    </div>
                    <div class="pc-summary-item">
                        <span class="label">Gaji Pokok</span>
                        <span class="value mono" id="summaryBasic">{{ $currencySymbol }}0</span>
                    </div>
                    <div class="pc-summary-item">
                        <span class="label">Tunjangan</span>
                        <span class="value mono" id="summaryAllowance">{{ $currencySymbol }}0</span>
                    </div>
                    <div class="pc-summary-item">
                        <span class="label">Potongan</span>
                        <span class="value mono" id="summaryDeduction">{{ $currencySymbol }}0</span>
                    </div>
                    <div class="pc-summary-total">
                        <span class="label">Total Gaji</span>
                        <span class="value mono" id="summaryTotal">{{ $currencySymbol }}0</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pc-form-actions">
                    <button type="submit" class="pc-btn pc-btn-primary">
                        <svg class="icon"><use href="#ic-check"/></svg>
                        Simpan Payroll
                    </button>
                    <a href="{{ route('payroll.index') }}" class="pc-btn pc-btn-ghost">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Batal
                    </a>
                </div>
            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const employeeSelect = document.getElementById('employeeSelect');
            const positionInput = document.getElementById('positionInput');
            const basicSalaryInput = document.getElementById('basicSalary');
            const allowanceInput = document.getElementById('allowance');
            const deductionInput = document.getElementById('deduction');

            const summaryPosition = document.getElementById('summaryPosition');
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

            function updateSalary() {
                const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
                const salary = selectedOption.dataset.salary || 0;

                // Update salary
                if (salary) {
                    basicSalaryInput.value = salary;
                    allowanceInput.value = 0;
                    deductionInput.value = 0;
                    calculateTotal();
                } else {
                    basicSalaryInput.value = '';
                    calculateTotal();
                }
            }

            // Update position saat user mengetik
            positionInput.addEventListener('input', function() {
                summaryPosition.textContent = this.value || '—';
            });

            employeeSelect.addEventListener('change', updateSalary);

            basicSalaryInput.addEventListener('input', calculateTotal);
            allowanceInput.addEventListener('input', calculateTotal);
            deductionInput.addEventListener('input', calculateTotal);

            // Initial calculation
            setTimeout(updateSalary, 100);

            // Ripple effect
            const buttons = document.querySelectorAll('.pc-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
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
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

</x-app-layout>