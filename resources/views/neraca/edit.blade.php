<x-app-layout>
    <x-slot name="title">Edit Pos Neraca</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    @endphp

    <style>
        .neraca-edit-wrap {
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
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --warning-rgb: 240, 168, 60;
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .neraca-edit-wrap * { box-sizing: border-box; }
        .neraca-edit-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .neraca-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .neraca-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .ne-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .ne-header-left { flex: 1; min-width: 200px; }

        .ne-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px 6px 10px;
            background: var(--warning-soft);
            border: 1px solid rgba(var(--warning-rgb), 0.25);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--warning);
            margin-bottom: 12px;
        }

        .ne-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--warning);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ne-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ne-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ne-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .ne-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .ne-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ne-btn {
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

        .ne-btn .icon { width: 16px; height: 16px; }
        .ne-btn:hover { transform: translateY(-2px); }
        .ne-btn:active { transform: translateY(0) scale(0.97); }

        .ne-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ne-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ne-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ne-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ne-btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .ne-btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            color: #fff;
        }

        .ne-btn .ripple {
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

        /* ERROR SUMMARY */
        .ne-error-summary {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            margin-bottom: 20px;
            animation: fadeSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .ne-error-summary .title {
            font-weight: 600;
            color: var(--danger);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ne-error-summary .title .icon {
            width: 18px;
            height: 18px;
        }

        .ne-error-summary ul {
            margin: 0;
            padding-left: 20px;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .ne-error-summary ul li {
            margin-bottom: 2px;
        }

        /* FORM */
        .ne-form {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .ne-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 24px;
            transition: border-color 0.22s ease;
        }

        .ne-card:hover { border-color: var(--border-hover); }

        .ne-card .title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ne-card .title .icon-box {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            background: var(--warning-soft);
            color: var(--warning);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ne-card .title .icon-box .icon {
            width: 16px;
            height: 16px;
        }

        .ne-form-group {
            margin-bottom: 16px;
        }

        .ne-form-group:last-child { margin-bottom: 0; }

        .ne-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .ne-form-group .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .ne-form-group .optional {
            color: var(--text-tertiary);
            font-weight: 400;
            text-transform: none;
            font-size: 11px;
        }

        .ne-form-group input,
        .ne-form-group select,
        .ne-form-group textarea {
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

        .ne-form-group input:focus,
        .ne-form-group select:focus,
        .ne-form-group textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card-hover);
        }

        .ne-form-group input::placeholder,
        .ne-form-group textarea::placeholder {
            color: var(--text-tertiary);
        }

        .ne-form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .ne-form-group select option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .ne-form-group select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
            appearance: none;
            cursor: pointer;
        }

        .ne-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .ne-field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ne-field-error .icon {
            width: 14px;
            height: 14px;
        }

        /* SIDEBAR */
        .ne-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .ne-info-item:last-child { border-bottom: none; }

        .ne-info-item .icon-box {
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

        .ne-info-item .icon-box .icon {
            width: 18px;
            height: 18px;
        }

        .ne-info-item .content {
            flex: 1;
        }

        .ne-info-item .content .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
        }

        .ne-info-item .content .value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .ne-info-item .content .value .mono {
            font-family: 'IBM Plex Mono', monospace;
        }

        .ne-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 16px 0;
        }

        .ne-bank-rule {
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

        .ne-bank-rule .icon {
            color: var(--theme-primary);
            flex-shrink: 0;
        }

        .ne-bank-rule strong {
            color: var(--theme-primary);
        }

        .ne-form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .ne-form-actions .ne-btn {
            flex: 1;
            justify-content: center;
        }

        .ne-delete-section {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .ne-delete-section .delete-label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
            margin-bottom: 8px;
        }

        @media (max-width: 992px) {
            .ne-form { grid-template-columns: 1fr; }
            .ne-form-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .ne-header { flex-direction: column; }
            .ne-actions { width: 100%; }
            .ne-actions .ne-btn { flex: 1; justify-content: center; }
            .ne-card { padding: 16px; }
            .ne-form-actions { flex-direction: column; }
        }

        @media (max-width: 380px) {
            .ne-header h1 { font-size: 22px; }
            .ne-btn { font-size: 12px; padding: 8px 14px; }
            .ne-btn .icon { width: 14px; height: 14px; }
        }
    </style>

    <div class="neraca-edit-wrap">

        <div class="ne-header animate-in" style="animation-delay: 0.05s;">
            <div class="ne-header-left">
                <div class="ne-badge">
                    <span class="dot"></span>
                    Edit Data
                </div>
                <h1>Edit Pos Neraca</h1>
                <p class="subtitle">
                    Perbarui data pos <strong>{{ $item->name }}</strong> untuk periode 
                    <span class="highlight">{{ $item->as_of_date->translatedFormat('d F Y') }}</span>.
                </p>
            </div>
            <div class="ne-actions">
                <a href="{{ route('neraca.index') }}" class="ne-btn ne-btn-ghost">
                    <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        {{-- ERROR SUMMARY --}}
        @if ($errors->any())
            <div class="ne-error-summary animate-in" style="animation-delay: 0.07s;">
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

        <form method="POST" action="{{ route('neraca.update', $item) }}" class="ne-form" id="neracaEditForm">
            @csrf
            @method('PUT')

            <!-- MAIN FORM -->
            <div class="ne-card animate-in" style="animation-delay: 0.10s;">
                <div class="title">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-edit"/></svg>
                    </div>
                    Informasi Pos Neraca
                </div>

                <div class="ne-form-group">
                    <label>Nama Pos <span class="required">*</span></label>
                    <input type="text" name="name" id="name" 
                           placeholder="Contoh: Kas, Piutang Usaha, Hutang Bank, Modal Pemilik"
                           value="{{ old('name', $item->name) }}" required>
                    @error('name')
                        <div class="ne-field-error">
                            <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="ne-form-row">
                    <div class="ne-form-group">
                        <label>Jenis <span class="required">*</span></label>
                        <select name="type" id="type" required>
                            <option value="">Pilih Jenis</option>
                            <option value="aset" {{ old('type', $item->type) == 'aset' ? 'selected' : '' }}>Aset</option>
                            <option value="kewajiban" {{ old('type', $item->type) == 'kewajiban' ? 'selected' : '' }}>Kewajiban</option>
                            <option value="modal" {{ old('type', $item->type) == 'modal' ? 'selected' : '' }}>Modal</option>
                        </select>
                        @error('type')
                            <div class="ne-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="ne-form-group">
                        <label>Kategori <span class="required">*</span></label>
                        <input type="text" name="category" id="category" 
                               placeholder="Contoh: Lancar, Tetap, Jangka Pendek"
                               value="{{ old('category', $item->category) }}" required>
                        @error('category')
                            <div class="ne-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="ne-form-row">
                    <div class="ne-form-group">
                        <label>Jumlah <span class="required">*</span></label>
                        <input type="number" name="amount" id="amount" 
                               placeholder="0"
                               value="{{ old('amount', $item->amount) }}" required min="0" step="1000">
                        <div style="font-size: 11px; color: var(--text-tertiary); margin-top: 4px;">
                            Masukkan dalam {{ $currencySymbol }}
                        </div>
                        @error('amount')
                            <div class="ne-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="ne-form-group">
                        <label>Tanggal <span class="required">*</span></label>
                        <input type="date" name="as_of_date" id="as_of_date" 
                               value="{{ old('as_of_date', $item->as_of_date->format('Y-m-d')) }}" required>
                        @error('as_of_date')
                            <div class="ne-field-error">
                                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="ne-form-group">
                    <label>Catatan <span class="optional">(opsional)</span></label>
                    <textarea name="notes" id="notes" 
                              placeholder="Tambahkan catatan atau keterangan tambahan...">{{ old('notes', $item->notes) }}</textarea>
                    @error('notes')
                        <div class="ne-field-error">
                            <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="ne-card animate-in" style="animation-delay: 0.15s;">
                <div class="title">Ringkasan</div>

                <div class="ne-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-tag"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Jenis</div>
                        <div class="value" id="typeDisplay">
                            @php
                                $typeMap = ['aset' => 'Aset', 'kewajiban' => 'Kewajiban', 'modal' => 'Modal'];
                            @endphp
                            {{ $typeMap[$item->type] ?? 'Belum dipilih' }}
                        </div>
                    </div>
                </div>

                <div class="ne-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-folder"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Kategori</div>
                        <div class="value" id="categoryDisplay">{{ $item->category }}</div>
                    </div>
                </div>

                <div class="ne-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-credit-card"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Jumlah</div>
                        <div class="value">
                            <span class="mono" id="amountDisplay">
                                {{ $currencySymbol }} {{ number_format($item->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="ne-info-item">
                    <div class="icon-box">
                        <svg class="icon"><use href="#ic-calendar"/></svg>
                    </div>
                    <div class="content">
                        <div class="label">Tanggal</div>
                        <div class="value" id="dateDisplay">{{ $item->as_of_date->format('d/m/Y') }}</div>
                    </div>
                </div>

                <hr class="ne-divider">

                <div class="ne-bank-rule">
                    <svg class="icon" style="width:20px;height:20px;"><use href="#ic-info"/></svg>
                    <span>Pastikan <strong>Aset = Kewajiban + Modal</strong> untuk menjaga keseimbangan neraca.</span>
                </div>

                <div class="ne-form-actions">
                    <button type="submit" class="ne-btn ne-btn-primary" id="submitBtn">
                        <svg class="icon"><use href="#ic-check"/></svg>
                        Simpan Perubahan
                    </button>
                </div>

                <div class="ne-delete-section">
                    <div class="delete-label">Danger Zone</div>
                    <button type="button" class="ne-btn ne-btn-danger" style="width:100%;justify-content:center;" onclick="document.getElementById('deleteFormNeraca').submit()">
                        <svg class="icon"><use href="#ic-trash"/></svg>
                        Hapus Pos Neraca
                    </button>
                </div>
            </div>

        </form>

        <form method="POST" action="{{ route('neraca.destroy', $item) }}" id="deleteFormNeraca" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pos neraca &quot;{{ $item->name }}&quot;? Tindakan ini tidak dapat dibatalkan.')" style="display:none;">
            @csrf
            @method('DELETE')
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
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></symbol>
        <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.ne-btn').forEach(btn => {
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
                typeSelect.addEventListener('change', function() {
                    const value = this.value;
                    typeDisplay.textContent = typeMap[value] || 'Belum dipilih';
                });
            }

            if (categoryInput) {
                categoryInput.addEventListener('input', function() {
                    categoryDisplay.textContent = this.value || 'Belum diisi';
                });
            }

            if (amountInput) {
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

            // ===== PREVENT DOUBLE SUBMIT =====
            const form = document.getElementById('neracaEditForm');
            const submitBtn = document.getElementById('submitBtn');

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<svg class="icon"><use href="#ic-check"/></svg> Menyimpan...';
                    }
                });
            }

            // ===== KEYBOARD SHORTCUT: Ctrl+S =====
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    const form = document.getElementById('neracaEditForm');
                    if (form) {
                        const submitBtn = document.getElementById('submitBtn');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<svg class="icon"><use href="#ic-check"/></svg> Menyimpan...';
                        }
                        form.submit();
                    }
                }
            });
        });
    </script>

</x-app-layout>