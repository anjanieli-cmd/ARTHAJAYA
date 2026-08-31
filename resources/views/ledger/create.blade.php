<x-app-layout>
    <x-slot name="title">Tambah Transaksi Buku Besar</x-slot>

    <style>
        .ledger-create-wrap {
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
            --danger-rgb: 232, 90, 90;
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .ledger-create-wrap * { box-sizing: border-box; }
        .ledger-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .ledger-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        /* ===== HEADER ===== */
        .ledger-create-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ledger-create-header-left { flex: 1; min-width: 200px; }

        .ledger-create-badge {
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

        .ledger-create-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ledger-create-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ledger-create-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ledger-create-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* ===== CARD ===== */
        .ledger-create-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 0;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .ledger-create-card:hover {
            border-color: var(--border-hover);
        }

        .ledger-create-card .card-accent {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--theme-gradient);
            border-radius: 0 4px 4px 0;
        }

        .ledger-create-card .card-header {
            padding: 28px 32px 20px 32px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .ledger-create-card .card-header .header-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ledger-create-card .card-header .header-icon .icon {
            width: 20px;
            height: 20px;
        }

        .ledger-create-card .card-header .header-text {
            flex: 1;
        }

        .ledger-create-card .card-header .header-text .title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
        }

        .ledger-create-card .card-header .header-text .desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ledger-create-card .card-header .header-tip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .ledger-create-card .card-header .header-tip .icon {
            width: 14px;
            height: 14px;
        }

        .ledger-create-card .card-body {
            padding: 28px 32px 32px 32px;
        }

        /* ===== FORM ===== */
        .ledger-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 24px 20px;
        }

        .ledger-form-grid .full-width {
            grid-column: 1 / -1;
        }

        .ledger-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .ledger-form-group label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 4px;
            flex-wrap: wrap;
        }

        .ledger-form-group label .required {
            color: var(--danger);
            font-weight: 700;
        }

        .ledger-form-group label .optional {
            color: var(--text-tertiary);
            font-weight: 400;
            font-size: 11px;
        }

        .ledger-form-group label .helper-icon {
            color: var(--text-tertiary);
            cursor: help;
            margin-left: auto;
        }

        .ledger-form-group input,
        .ledger-form-group select,
        .ledger-form-group textarea {
            width: 100%;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1.5px solid var(--border-color);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .ledger-form-group input:focus,
        .ledger-form-group select:focus,
        .ledger-form-group textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--theme-soft);
        }

        .ledger-form-group input:hover,
        .ledger-form-group select:hover,
        .ledger-form-group textarea:hover {
            border-color: var(--border-hover);
        }

        .ledger-form-group input::placeholder,
        .ledger-form-group textarea::placeholder {
            color: var(--text-tertiary);
            font-weight: 400;
        }

        .ledger-form-group select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
            padding-right: 38px;
            cursor: pointer;
        }

        .ledger-form-group select option {
            background-color: #1a1f2e;
            color: #e8edf5;
            padding: 10px 14px;
            font-size: 14px;
        }

        .ledger-form-group select option:checked,
        .ledger-form-group select option:hover {
            background-color: #0d2a1f;
            color: #34d399;
        }

        .ledger-form-group textarea {
            resize: vertical;
            min-height: 100px;
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        .ledger-form-group .field-hint {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .ledger-form-group .field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ledger-form-group .field-error .icon {
            width: 14px;
            height: 14px;
        }

        /* ===== DEBIT/CREDIT HIGHLIGHT ===== */
        .ledger-form-group.debit input {
            border-color: rgba(52, 181, 131, 0.3);
        }

        .ledger-form-group.debit input:focus {
            border-color: var(--success);
            box-shadow: 0 0 0 4px var(--success-soft);
        }

        .ledger-form-group.debit label .debit-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            background: var(--success-soft);
            color: var(--success);
            margin-left: 6px;
            text-transform: uppercase;
        }

        .ledger-form-group.credit input {
            border-color: rgba(232, 90, 90, 0.3);
        }

        .ledger-form-group.credit input:focus {
            border-color: var(--danger);
            box-shadow: 0 0 0 4px var(--danger-soft);
        }

        .ledger-form-group.credit label .credit-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            background: var(--danger-soft);
            color: var(--danger);
            margin-left: 6px;
            text-transform: uppercase;
        }

        /* ===== ACTIONS ===== */
        .ledger-create-actions {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .ledger-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .ledger-btn .icon {
            width: 16px;
            height: 16px;
        }

        .ledger-btn:hover {
            transform: translateY(-2px);
        }

        .ledger-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .ledger-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ledger-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            color: #fff;
        }

        .ledger-btn-outline {
            background: var(--bg-card);
            border: 1.5px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ledger-btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ledger-btn .ripple {
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .ledger-form-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .ledger-create-wrap { padding: 0 16px; }
            .ledger-create-header { flex-direction: column; }
            .ledger-create-header h1 { font-size: 22px; }
            .ledger-create-card .card-header { 
                flex-direction: column; 
                align-items: flex-start;
                padding: 20px 20px 16px;
            }
            .ledger-create-card .card-header .header-tip {
                align-self: flex-start;
            }
            .ledger-create-card .card-body { padding: 20px; }
            .ledger-form-grid { grid-template-columns: 1fr; gap: 18px; }
            .ledger-create-actions { 
                flex-direction: column-reverse;
                align-items: stretch;
            }
            .ledger-create-actions .ledger-btn { 
                width: 100%; 
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .ledger-create-wrap { padding: 0 12px; }
            .ledger-create-header h1 { font-size: 20px; }
            .ledger-create-card .card-header .header-text .title { font-size: 14px; }
            .ledger-create-card .card-header .header-text .desc { font-size: 12px; }
            .ledger-btn { font-size: 12.5px; padding: 10px 20px; }
        }
    </style>

    <div class="ledger-create-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="ledger-create-header animate-in" style="animation-delay: 0.05s;">
            <div class="ledger-create-header-left">
                <div class="ledger-create-badge">
                    <span class="dot"></span>
                    Transaksi Baru
                </div>
                <h1>Tambah Transaksi Buku Besar</h1>
                <p class="subtitle">
                    Catat transaksi debit/kredit untuk akun 
                    <strong>{{ $company->name ?? 'perusahaanmu' }}</strong>
                </p>
            </div>
        </div>

        {{-- ===== FORM ===== --}}
        <form method="POST" action="{{ route('ledger.store') }}" class="animate-in" style="animation-delay: 0.10s;">
            @csrf

            <div class="ledger-create-card">
                <div class="card-accent"></div>

                <div class="card-header">
                    <div class="header-icon">
                        <svg class="icon"><use href="#ic-invoice"/></svg>
                    </div>
                    <div class="header-text">
                        <p class="title">Form Transaksi Buku Besar</p>
                        <p class="desc">Isi salah satu kolom Debit atau Kredit sesuai jenis transaksi.</p>
                    </div>
                    <div class="header-tip">
                        <svg class="icon"><use href="#ic-info"/></svg>
                        <span>Debit = Aset +, Kredit = Aset -</span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="ledger-form-grid">

                        {{-- Tanggal Transaksi --}}
                        <div class="ledger-form-group">
                            <label for="transaction_date">
                                Tanggal Transaksi
                                <span class="required">*</span>
                            </label>
                            <input type="date" name="transaction_date" id="transaction_date"
                                   value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                            @error('transaction_date')
                                <span class="field-error">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Pilih Akun --}}
                        <div class="ledger-form-group">
                            <label for="chart_of_account_id">
                                Akun
                                <span class="required">*</span>
                            </label>
                            <select name="chart_of_account_id" id="chart_of_account_id" required>
                                <option value="">-- Pilih Akun --</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}" {{ old('chart_of_account_id') == $acc->id ? 'selected' : '' }}>
                                        {{ $acc->code }} — {{ $acc->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="field-hint">Pilih akun dari daftar Chart of Accounts perusahaan</span>
                            @error('chart_of_account_id')
                                <span class="field-error">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="ledger-form-group full-width">
                            <label for="description">
                                Deskripsi Transaksi
                                <span class="required">*</span>
                            </label>
                            <input type="text" name="description" id="description"
                                   placeholder="Contoh: Pembayaran invoice dari PT Andalas Maju Bersama"
                                   value="{{ old('description') }}" required>
                            @error('description')
                                <span class="field-error">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Debit --}}
                        <div class="ledger-form-group debit">
                            <label for="debit">
                                Debit
                                <span class="debit-badge">Aset +</span>
                            </label>
                            <input type="number" name="debit" id="debit" min="0" step="1"
                                   placeholder="0" value="{{ old('debit') }}">
                            <span class="field-hint">Isi jika transaksi menambah aset/beban</span>
                            @error('debit')
                                <span class="field-error">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Kredit --}}
                        <div class="ledger-form-group credit">
                            <label for="credit">
                                Kredit
                                <span class="credit-badge">Aset -</span>
                            </label>
                            <input type="number" name="credit" id="credit" min="0" step="1"
                                   placeholder="0" value="{{ old('credit') }}">
                            <span class="field-hint">Isi jika transaksi mengurangi aset/menambah pendapatan</span>
                            @error('credit')
                                <span class="field-error">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Catatan --}}
                        <div class="ledger-form-group full-width">
                            <label for="notes">
                                Catatan
                                <span class="optional">(opsional)</span>
                            </label>
                            <textarea name="notes" id="notes"
                                      placeholder="Catatan tambahan mengenai transaksi ini...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="field-error">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="ledger-create-actions">
                        <a href="{{ route('ledger.index') }}" class="ledger-btn ledger-btn-outline">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Batal
                        </a>
                        <button type="submit" class="ledger-btn ledger-btn-primary">
                            <svg class="icon"><use href="#ic-save"/></svg>
                            Simpan Transaksi
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-invoice" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </symbol>
        <symbol id="ic-info" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="16" x2="12" y2="12"/>
            <line x1="12" y1="8" x2="12.01" y2="8"/>
        </symbol>
        <symbol id="ic-x" viewBox="0 0 24 24">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </symbol>
        <symbol id="ic-save" viewBox="0 0 24 24">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
        </symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== DEBIT/CREDIT AUTO-FILL =====
            const debitInput = document.querySelector('input[name="debit"]');
            const creditInput = document.querySelector('input[name="credit"]');

            if (debitInput && creditInput) {
                debitInput.addEventListener('input', function() {
                    if (this.value && parseFloat(this.value) > 0) {
                        creditInput.value = '';
                        creditInput.disabled = true;
                        creditInput.placeholder = 'Isi Debit saja';
                    } else {
                        creditInput.disabled = false;
                        creditInput.placeholder = '0';
                    }
                });

                creditInput.addEventListener('input', function() {
                    if (this.value && parseFloat(this.value) > 0) {
                        debitInput.value = '';
                        debitInput.disabled = true;
                        debitInput.placeholder = 'Isi Kredit saja';
                    } else {
                        debitInput.disabled = false;
                        debitInput.placeholder = '0';
                    }
                });

                // Reset on focus
                debitInput.addEventListener('focus', function() {
                    if (creditInput.value && parseFloat(creditInput.value) > 0) {
                        creditInput.value = '';
                        creditInput.disabled = false;
                        creditInput.placeholder = '0';
                    }
                });

                creditInput.addEventListener('focus', function() {
                    if (debitInput.value && parseFloat(debitInput.value) > 0) {
                        debitInput.value = '';
                        debitInput.disabled = false;
                        debitInput.placeholder = '0';
                    }
                });
            }

            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.ledger-btn').forEach(btn => {
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

            // ===== FORM VALIDATION =====
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const requiredFields = this.querySelectorAll('[required]');
                    let hasError = false;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.style.borderColor = 'var(--danger)';
                            field.style.boxShadow = '0 0 0 4px var(--danger-soft)';
                            hasError = true;
                            
                            field.addEventListener('focus', function() {
                                this.style.borderColor = '';
                                this.style.boxShadow = '';
                            }, { once: true });
                        }
                    });

                    // Check if both debit and credit are empty or both filled
                    const debit = document.querySelector('input[name="debit"]');
                    const credit = document.querySelector('input[name="credit"]');
                    if (debit && credit) {
                        const debitVal = parseFloat(debit.value) || 0;
                        const creditVal = parseFloat(credit.value) || 0;
                        
                        if (debitVal === 0 && creditVal === 0) {
                            e.preventDefault();
                            debit.style.borderColor = 'var(--danger)';
                            debit.style.boxShadow = '0 0 0 4px var(--danger-soft)';
                            credit.style.borderColor = 'var(--danger)';
                            credit.style.boxShadow = '0 0 0 4px var(--danger-soft)';
                            alert('Silakan isi salah satu kolom Debit atau Kredit.');
                        }
                    }
                });
            }
        });
    </script>

</x-app-layout>