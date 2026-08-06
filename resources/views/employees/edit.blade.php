<x-app-layout>
    <x-slot name="title">Edit Karyawan</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $profile = $employee->employeeProfile ?? null;

        $statusOptions = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif'
        ];

        function formatTanggalEdit($date) {
            if (empty($date)) return '';
            try {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return $date;
            }
        }
    @endphp

    <!-- SVG ICONS -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-save" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .emp-edit-wrap {
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
            padding: 0 24px;
            width: 100%;
            max-width: 100%;
        }

        .emp-edit-wrap * { box-sizing: border-box; }

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

        .emp-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .emp-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .emp-edit-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .emp-edit-header-left { flex: 1; min-width: 200px; }

        .emp-edit-badge {
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

        .emp-edit-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .emp-edit-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .emp-edit-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .emp-edit-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .emp-edit-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .emp-btn {
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

        .emp-btn .icon { width: 16px; height: 16px; }
        .emp-btn:hover { transform: translateY(-2px); }
        .emp-btn:active { transform: translateY(0) scale(0.97); }

        .emp-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .emp-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .emp-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .emp-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .emp-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* READONLY ACCOUNT INFO BOX */
        .emp-readonly-box {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .emp-readonly-box .avatar-sm {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
            background: var(--theme-gradient);
            overflow: hidden;
        }

        .emp-readonly-box .avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .emp-readonly-box .info .name {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .emp-readonly-box .info .email {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .emp-readonly-box .note {
            margin-left: auto;
            font-size: 11px;
            color: var(--text-tertiary);
            text-align: right;
            max-width: 180px;
            line-height: 1.5;
        }

        /* FORM - FULL WIDTH */
        .emp-edit-form {
            width: 100%;
            max-width: 100%;
        }

        .emp-edit-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
        }

        .emp-edit-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .emp-edit-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .emp-edit-card .title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .emp-edit-card .title .line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border-color), transparent);
        }

        .emp-form-group {
            margin-bottom: 20px;
        }

        .emp-form-group:last-child { margin-bottom: 0; }

        .emp-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .emp-form-group .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .emp-form-group .optional-hint {
            color: var(--text-tertiary);
            text-transform: none;
            font-weight: 400;
            letter-spacing: 0;
            margin-left: 4px;
        }

        .emp-form-group input,
        .emp-form-group select,
        .emp-form-group textarea {
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

        .emp-form-group input:focus,
        .emp-form-group select:focus,
        .emp-form-group textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card-hover);
            box-shadow: 0 0 0 4px var(--theme-glow);
        }

        .emp-form-group input::placeholder,
        .emp-form-group textarea::placeholder {
            color: var(--text-tertiary);
        }

        .emp-form-group textarea {
            resize: vertical;
            min-height: 90px;
        }

        .emp-form-group select {
            cursor: pointer;
            appearance: auto;
            -webkit-appearance: auto;
            color-scheme: light dark;
        }

        .emp-form-group select option {
            background-color: var(--bg-card);
            color: var(--text-primary);
            padding: 10px 14px;
            font-size: 14px;
        }

        .emp-form-group select option:checked,
        .emp-form-group select option:hover {
            background-color: var(--theme-soft);
            color: var(--theme-primary);
        }

        .emp-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 640px) {
            .emp-form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        .emp-form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .emp-form-actions .emp-btn {
            flex: 1;
            justify-content: center;
            padding: 14px 24px;
            font-size: 14px;
        }

        /* VALIDATION ERRORS */
        .emp-error-box {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
            margin-bottom: 20px;
            color: var(--danger);
            font-size: 13px;
        }

        .emp-error-box ul {
            margin: 6px 0 0;
            padding-left: 18px;
        }

        .field-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .emp-edit-wrap { padding: 0 12px; }
            .emp-edit-card { padding: 20px 24px; }
            .emp-edit-header h1 { font-size: 24px; }
            .emp-edit-header { flex-direction: column; }
            .emp-edit-actions { width: 100%; }
            .emp-edit-actions .emp-btn { flex: 1; justify-content: center; }
            .emp-form-actions { flex-direction: column; }
            .emp-form-actions .emp-btn { flex: none; }
            .emp-readonly-box { flex-wrap: wrap; }
            .emp-readonly-box .note { margin-left: 0; max-width: 100%; text-align: left; }
        }

        @media (max-width: 640px) {
            .emp-edit-card { padding: 16px; }
            .emp-edit-header h1 { font-size: 20px; }
            .emp-btn { font-size: 12px; padding: 8px 14px; }
            .emp-btn .icon { width: 14px; height: 14px; }
        }

        @media (max-width: 380px) {
            .emp-edit-wrap { padding: 0 4px; }
            .emp-edit-card { padding: 12px; }
        }
    </style>

    <div class="emp-edit-wrap">

        <!-- ===== HEADER ===== -->
        <div class="emp-edit-header animate-in" style="animation-delay: 0.05s;">
            <div class="emp-edit-header-left">
                <div class="emp-edit-badge">
                    <span class="dot"></span>
                    HR &amp; Payroll
                </div>
                <h1>Edit Karyawan</h1>
                <p class="subtitle">
                    Perbarui data kerja — <strong>{{ $employee->name ?? 'Nama Tidak Diketahui' }}</strong>
                </p>
            </div>
            <div class="emp-edit-actions">
                <a href="{{ route('employees.index') }}" class="emp-btn emp-btn-ghost">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== VALIDATION ERRORS ===== -->
        @if($errors->any())
            <div class="emp-error-box animate-in" style="animation-delay: 0.08s;">
                <strong>Terjadi kesalahan, cek kembali data yang diisi:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ===== FORM - FULL WIDTH ===== -->
        <form method="POST" action="{{ route('employees.update', ['index' => $employee->id]) }}" class="emp-edit-form" id="employeeForm">
            @csrf
            @method('PUT')

            <div class="emp-edit-card animate-in" style="animation-delay: 0.10s;">
                <div class="title">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Data Kerja Karyawan
                    <span class="line"></span>
                </div>

                <!-- Info Akun (Read-only) -->
                <div class="emp-readonly-box">
                    @php
                        $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                        $color = $colors[$employee->id % count($colors)];
                        $initial = mb_substr($employee->name ?? '?', 0, 1);
                    @endphp
                    <div class="avatar-sm" style="background: {{ $color }};">
                        @if(!empty($employee->profile_photo))
                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="{{ $employee->name }}">
                        @else
                            {{ strtoupper($initial) }}
                        @endif
                    </div>
                    <div class="info">
                        <div class="name">{{ $employee->name ?? '-' }}</div>
                        <div class="email">{{ $employee->email ?? '-' }}</div>
                    </div>
                    <div class="note">
                        Nama &amp; email adalah data akun, diatur oleh karyawan sendiri saat registrasi.
                    </div>
                </div>

                <!-- Posisi & Departemen -->
                <div class="emp-form-row">
                    <div class="emp-form-group">
                        <label>Posisi / Jabatan</label>
                        <input type="text" name="position" value="{{ old('position', $profile->position ?? '') }}" placeholder="Contoh: Pengrajin Batik">
                        @error('position') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="emp-form-group">
                        <label>Departemen</label>
                        <input type="text" name="department" value="{{ old('department', $profile->department ?? '') }}" placeholder="Contoh: Produksi">
                        @error('department') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Telepon & Gaji Pokok -->
                <div class="emp-form-row">
                    <div class="emp-form-group">
                        <label>Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" placeholder="Contoh: 0812-3456-7890">
                        @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="emp-form-group">
                        <label>Gaji Pokok / Bulan</label>
                        <input type="number" name="basic_salary" value="{{ old('basic_salary', $profile->basic_salary ?? '') }}" placeholder="0" min="0" step="1000">
                        @error('basic_salary') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Tanggal Bergabung & Status -->
                <div class="emp-form-row">
                    <div class="emp-form-group">
                        <label>Tanggal Bergabung</label>
                        <input type="date" name="joined_date" value="{{ old('joined_date', isset($profile->joined_date) ? formatTanggalEdit($profile->joined_date) : '') }}">
                        @error('joined_date') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="emp-form-group">
                        <label>Status</label>
                        <select name="status">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $profile->status ?? 'active') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div class="emp-form-group">
                    <label>Alamat</label>
                    <textarea name="address" placeholder="Alamat tempat tinggal karyawan...">{{ old('address', $profile->address ?? '') }}</textarea>
                    @error('address') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <!-- Actions -->
                <div class="emp-form-actions">
                    <button type="submit" class="emp-btn emp-btn-primary">
                        <svg class="icon"><use href="#ic-save"/></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('employees.index') }}" class="emp-btn emp-btn-ghost">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Batal
                    </a>
                </div>
            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.emp-btn');
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