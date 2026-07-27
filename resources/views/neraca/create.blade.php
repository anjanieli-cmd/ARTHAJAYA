<x-app-layout>
    <x-slot name="title">Tambah Pos Neraca</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <style>
        .neraca-create-wrap {
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

        .neraca-create-wrap * { box-sizing: border-box; }
        .neraca-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .neraca-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .neraca-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .nc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .nc-header-left { flex: 1; min-width: 200px; }

        .nc-badge {
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

        .nc-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .nc-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .nc-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .nc-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .nc-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .nc-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .nc-btn {
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

        .nc-btn .icon { width: 16px; height: 16px; }
        .nc-btn:hover { transform: translateY(-2px); }
        .nc-btn:active { transform: translateY(0) scale(0.97); }

        .nc-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .nc-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .nc-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .nc-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .nc-btn .ripple {
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
        .nc-form {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .nc-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: border-color 0.22s ease;
        }

        .nc-card:hover { border-color: var(--border-hover); }

        .nc-card .title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .nc-form-group {
            margin-bottom: 16px;
        }

        .nc-form-group:last-child { margin-bottom: 0; }

        .nc-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .nc-form-group .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .nc-form-group .optional {
            color: var(--text-tertiary);
            font-weight: 400;
            text-transform: none;
            font-size: 11px;
        }

        .nc-form-group input,
        .nc-form-group select,
        .nc-form-group textarea {
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

        .nc-form-group input:focus,
        .nc-form-group select:focus,
        .nc-form-group textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card-hover);
        }

        .nc-form-group input::placeholder,
        .nc-form-group textarea::placeholder {
            color: var(--text-tertiary);
        }

        .nc-form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .nc-form-group select option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .nc-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .nc-field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nc-field-error .icon {
            width: 14px;
            height: 14px;
        }

        .nc-error-summary {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            margin-bottom: 20px;
            animation: fadeSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .nc-error-summary .title {
            font-weight: 600;
            color: var(--danger);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nc-error-summary .title .icon {
            width: 18px;
            height: 18px;
        }

        .nc-error-summary ul {
            margin: 0;
            padding-left: 20px;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .nc-error-summary ul li {
            margin-bottom: 2px;
        }

        /* SIDEBAR */
        .nc-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .nc-info-item:last-child { border-bottom: none; }

        .nc-info-item .icon-box {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nc-info-item .icon-box .icon {
            width: 18px;
            height: 18px;
        }

        .nc-info-item .content {
            flex: 1;
        }

        .nc-info-item .content .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
        }

        .nc-info-item .content .value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .nc-info-item .content .value .mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .nc-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 16px 0;
        }

        .nc-form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .nc-form-actions .nc-btn {
            flex: 1;
            justify-content: center;
        }

        .nc-bank-rule {
            background: var(--theme-soft);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .nc-bank-rule .icon {
            color: var(--theme-primary);
            flex-shrink: 0;
        }

        .nc-bank-rule strong {
            color: var(--theme-primary);
        }

        @media (max-width: 992px) {
            .nc-form { grid-template-columns: 1fr; }
            .nc-form-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .nc-header { flex-direction: column; }
            .nc-actions { width: 100%; }
            .nc-actions .nc-btn { flex: 1; justify-content: center; }
            .nc-card { padding: 16px; }
            .nc-form-actions { flex-direction: column; }
        }

        @media (max-width: 380px) {
            .nc-header h1 { font-size: 22px; }
            .nc-btn { font-size: 12px; padding: 8px 14px; }
            .nc-btn .icon { width: 14px; height: 14px; }
        }
    </style>

    <div class="neraca-create-wrap">

        <div class="nc-header animate-in" style="animation-delay: 0.05s;">
            <div class="nc-header-left">
                <div class="nc-badge">
                    <span class="dot"></span>
                    Laporan Keuangan
                </div>
                <h1>Tambah Pos Neraca</h1>
                <p class="subtitle">
                    Catat pos <strong>Aset</strong>, <strong>Kewajiban</strong>, atau <strong>Modal</strong> untuk periode tertentu.
                    Pastikan total <span class="highlight">Aset = Kewajiban + Modal</span>.
                </p>
            </div>
            <div class="nc-actions">
                <a href="{{ route('neraca.index') }}" class="nc-btn nc-btn-ghost">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        {{-- ERROR SUMMARY --}}
        @if ($errors->any())
            <div class="nc-error-summary animate-in" style="animation-delay: 0.07s;">
                <div class="title">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Terjadi kesalahan:
                </div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('neraca.store') }}" class="nc-form" id="neracaForm">
            @csrf

            <!-- MAIN FORM -->
            <div class="nc-card animate-in" style="animation-delay: 0.10s;">
                <div class="title">Informasi Pos Neraca</div>

                <div class="nc-form-group">
                    <label>Nama Pos <span class="required">*</span></label>
                    <input type="text" name="name" id="name" 
                           placeholder="Contoh: Kas, Piutang Usaha, Hutang Bank, Modal Pemilik"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="nc-field-error">
                            <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="nc-form-row">
                    <div class="nc-form-group">
                        <label>Jenis <span class="required">*</span></label>
                        <select name="type" id="type" required>
                            <option value="">Pilih Jenis</option>
                            <option value="aset" {{ old('type') == 'aset' ? 'selected' : '' }}>Aset</option>
                            <option value="kewajiban" {{ old('type') == 'kewajiban' ? 'selected' : '' }}>Kewajiban</option>
                            <option value="modal" {{ old('type') == 'modal' ? 'selected' : '' }}>Modal</option>
                        </select>
                        @error('type')
                            <div class="nc-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="nc-form-group">
                        <label>Kategori <span class="required">*</span></label>
                        <input type="text" name="category" id="category" 
                               placeholder="Contoh: Lancar, Tetap, Jangka Pendek"
                               value="{{ old('category') }}" required>
                        @error('category')
                            <div class="nc-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="nc-form-row">
                    <div class="nc-form-group">
                        <label>Jumlah <span class="required">*</span></label>
                        <input type="number" name="amount" id="amount" 
                               placeholder="0"
                               value="{{ old('amount') }}" required min="0" step="1000">
                        <div style="font-size: 11px; color: var(--text-tertiary); margin-top: 4px;">
                            Masukkan dalam {{ $currencySymbol }}
                        </div>
                        @error('amount')
                            <div class="nc-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="nc-form-group">
                        <label>Tanggal <span class="required">*</span></label>
                        <input type="date" name="as_of_date" id="as_of_date" 
                               value="{{ old('as_of_date', date('Y-m-d')) }}" required>
                        @error('as_of_date')
                            <div class="nc-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="nc-form-group">
                    <label>Catatan <span class="optional">(opsional)</span></label>
                    <textarea name="notes" id="notes" 
                              placeholder="Tambahkan catatan atau keterangan tambahan...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="nc-field-error">
                            <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="nc-card animate-in" style="animation-delay: 0.15s;">
                <div class="title">Ringkasan</div>

                <div class="nc-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-tag"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Jenis</div>
                        <div class="value" id="typeDisplay">Belum dipilih</div>
                    </div>
                </div>

                <div class="nc-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-folder"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Kategori</div>
                        <div class="value" id="categoryDisplay">Belum diisi</div>
                    </div>
                </div>

                <div class="nc-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-credit-card"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Jumlah</div>
                        <div class="value"><span class="mono" id="amountDisplay">{{ $currencySymbol }} 0</span></div>
                    </div>
                </div>

                <div class="nc-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-calendar"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Tanggal</div>
                        <div class="value" id="dateDisplay">{{ date('d/m/Y') }}</div>
                    </div>
                </div>

                <hr class="nc-divider">

                <div class="nc-bank-rule">
                    <svg class="icon" style="width:20px;height:20px;"><use href="#ic-info"/></svg>
                    <span>Pastikan <strong>Aset = Kewajiban + Modal</strong> untuk menjaga keseimbangan neraca.</span>
                </div>

                <div class="nc-form-actions">
                    <button type="submit" class="nc-btn nc-btn-primary" id="submitBtn">
                        <svg class="icon"><use href="#ic-check"/></svg>
                        Simpan Pos
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
        <symbol id="ic-alert-triangle" viewBox="0 0 24 24"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></symbol>
        <symbol id="ic-tag" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></symbol>
        <symbol id="ic-folder" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></symbol>
        <symbol id="ic-credit-card" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></symbol>
        <symbol id="ic-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.nc-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // ===== LIVE PREVIEW =====
            const typeSelect = document.getElementById('type');
            const typeDisplay = document.getElementById('typeDisplay');
            const categoryInput = document.getElementById('category');
            const categoryDisplay = document.getElementById('categoryDisplay');
            const amountInput = document.getElementById('amount');
            const amountDisplay = document.getElementById('amountDisplay');
            const dateInput = document.getElementById('as_of_date');
            const dateDisplay = document.getElementById('dateDisplay');

            const typeMap = {
                'aset': 'Aset',
                'kewajiban': 'Kewajiban',
                'modal': 'Modal'
            };

            const currencySymbol = '{{ $currencySymbol }}';

            if (typeSelect) {
                const initialType = typeSelect.value;
                if (initialType && typeMap[initialType]) {
                    typeDisplay.textContent = typeMap[initialType];
                }

                typeSelect.addEventListener('change', function() {
                    const value = this.value;
                    typeDisplay.textContent = typeMap[value] || 'Belum dipilih';
                });
            }

            if (categoryInput) {
                const initialCategory = categoryInput.value;
                if (initialCategory) {
                    categoryDisplay.textContent = initialCategory;
                }

                categoryInput.addEventListener('input', function() {
                    categoryDisplay.textContent = this.value || 'Belum diisi';
                });
            }

            if (amountInput) {
                const initialAmount = amountInput.value;
                if (initialAmount && !isNaN(initialAmount) && parseInt(initialAmount) > 0) {
                    const num = parseInt(initialAmount);
                    amountDisplay.textContent = currencySymbol + ' ' + num.toLocaleString('id-ID');
                }

                amountInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    const value = this.value;
                    if (value) {
                        const num = parseInt(value);
                        amountDisplay.textContent = currencySymbol + ' ' + num.toLocaleString('id-ID');
                    } else {
                        amountDisplay.textContent = currencySymbol + ' 0';
                    }
                });

                amountInput.addEventListener('blur', function() {
                    if (this.value) {
                        const num = parseInt(this.value.replace(/[^0-9]/g, ''));
                        if (!isNaN(num) && num > 0) {
                            this.value = num;
                        }
                    }
                });
            }

            if (dateInput) {
                dateInput.addEventListener('change', function() {
                    if (this.value) {
                        const parts = this.value.split('-');
                        const date = new Date(parts[0], parts[1] - 1, parts[2]);
                        dateDisplay.textContent = date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    }
                });
            }

            // ===== SET DEFAULT DATE =====
            if (dateInput && !dateInput.value) {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                dateInput.value = year + '-' + month + '-' + day;
            }

            // ===== PREVENT DOUBLE SUBMIT =====
            const form = document.getElementById('neracaForm');
            const submitBtn = document.getElementById('submitBtn');

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<svg class="icon"><use href="#ic-check"/></svg> Menyimpan...';
                    }
                });
            }
        });
    </script>

</x-app-layout>