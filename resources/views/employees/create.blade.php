<x-app-layout>
    <x-slot name="title">Tambah Karyawan</x-slot>

    @php
        $statusOptions = ['active' => 'Aktif', 'inactive' => 'Tidak Aktif'];
    @endphp

    <!-- SVG ICONS -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-save" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
        </defs>
    </svg>

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

        .emp-create-wrap * { box-sizing: border-box; }

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

        .emp-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .emp-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .emp-create-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .emp-create-header-left { flex: 1; min-width: 200px; }

        .emp-create-badge {
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

        .emp-create-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .emp-create-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .emp-create-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .emp-create-actions {
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

        /* FORM - FULL WIDTH */
        .emp-create-form {
            width: 100%;
            max-width: 100%;
        }

        .emp-create-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
        }

        .emp-create-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .emp-create-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .emp-create-card .title .icon {
            width: 20px;
            height: 20px;
            color: var(--theme-primary);
        }

        .emp-create-card .title .line {
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
            color-scheme: dark;
        }

        .emp-form-group select option {
            background-color: #12181f;
            color: #f2f4f7;
            padding: 10px 14px;
            font-size: 14px;
        }

        .emp-form-group select option:checked,
        .emp-form-group select option:hover {
            background-color: #17352c;
            color: #34d399;
        }

        .emp-form-group select option:disabled {
            color: #6b7280;
        }

        .emp-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .emp-form-row {
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }
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

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .emp-create-wrap { padding: 0 12px; }
            .emp-create-card { padding: 20px 24px; }
            .emp-create-header h1 { font-size: 24px; }
            .emp-create-header { flex-direction: column; }
            .emp-create-actions { width: 100%; }
            .emp-create-actions .emp-btn { flex: 1; justify-content: center; }
            .emp-form-actions { flex-direction: column; }
            .emp-form-actions .emp-btn { flex: none; }
        }

        @media (max-width: 640px) {
            .emp-create-card { padding: 16px; }
            .emp-create-header h1 { font-size: 20px; }
            .emp-btn { font-size: 12px; padding: 8px 14px; }
            .emp-btn .icon { width: 14px; height: 14px; }
        }

        @media (max-width: 380px) {
            .emp-create-wrap { padding: 0 4px; }
            .emp-create-card { padding: 12px; }
        }
    </style>

    <div class="emp-create-wrap">

        <!-- ===== HEADER ===== -->
        <div class="emp-create-header animate-in" style="animation-delay: 0.05s;">
            <div class="emp-create-header-left">
                <div class="emp-create-badge">
                    <span class="dot"></span>
                    HR &amp; Payroll
                </div>
                <h1>Tambah Karyawan</h1>
                <p class="subtitle">
                    Tambahkan data karyawan baru ke sistem
                </p>
            </div>
            <div class="emp-create-actions">
                <a href="{{ route('employees.index') }}" class="emp-btn emp-btn-ghost">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ===== FORM - FULL WIDTH ===== -->
        <form method="POST" action="{{ route('employees.store') }}" class="emp-create-form" id="employeeForm">
            @csrf

            <div class="emp-create-card animate-in" style="animation-delay: 0.10s;">
                <div class="title">
                    <svg class="icon"><use href="#ic-user"/></svg>
                    Data Karyawan Baru
                    <span class="line"></span>
                </div>

                <!-- Nama - FULL WIDTH -->
                <div class="emp-form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Posisi & Departemen -->
                <div class="emp-form-row">
                    <div class="emp-form-group">
                        <label>Posisi / Jabatan <span class="required">*</span></label>
                        <input type="text" name="position" value="{{ old('position') }}" placeholder="Contoh: Pengrajin Batik" required>
                    </div>
                    <div class="emp-form-group">
                        <label>Departemen <span class="required">*</span></label>
                        <input type="text" name="department" value="{{ old('department') }}" placeholder="Contoh: Produksi" required>
                    </div>
                </div>

                <!-- Email & Telepon -->
                <div class="emp-form-row">
                    <div class="emp-form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@perusahaan.com" required>
                    </div>
                    <div class="emp-form-group">
                        <label>Telepon <span class="required">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 0812-3456-7890" required>
                    </div>
                </div>

                <!-- Gaji & Tanggal Bergabung -->
                <div class="emp-form-row">
                    <div class="emp-form-group">
                        <label>Gaji / Bulan <span class="required">*</span></label>
                        <input type="number" name="salary" value="{{ old('salary') }}" placeholder="0" min="0" step="1000" required>
                    </div>
                    <div class="emp-form-group">
                        <label>Tanggal Bergabung <span class="required">*</span></label>
                        <input type="date" name="joined" value="{{ old('joined', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Status -->
                <div class="emp-form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="status" required>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions - FULL WIDTH -->
                <div class="emp-form-actions">
                    <button type="submit" class="emp-btn emp-btn-primary">
                        <svg class="icon"><use href="#ic-save"/></svg>
                        Simpan Karyawan
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