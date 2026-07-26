<x-app-layout>
    <x-slot name="title">Edit Transaksi Arus Kas</x-slot>

    <style>
        .cf-edit-wrap {
            --theme-primary: var(--warning);
            --theme-light: #F0A83C;
            --theme-dark: #d4942e;
            --theme-glow: rgba(240, 168, 60, 0.25);
            --theme-soft: rgba(240, 168, 60, 0.12);
            --theme-gradient: linear-gradient(135deg, #F0A83C, #d4942e);
            
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .cf-edit-wrap * { box-sizing: border-box; }
        .cf-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        .cf-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        /* ===== HEADER ===== */
        .cf-edit-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cf-edit-header-left { flex: 1; min-width: 200px; }

        .cf-edit-badge {
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

        .cf-edit-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cf-edit-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cf-edit-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cf-edit-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .cf-edit-header .subtitle .highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        /* ===== CARD ===== */
        .cf-edit-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 0;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .cf-edit-card:hover {
            border-color: var(--border-hover);
        }

        .cf-edit-card .card-accent {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--theme-gradient);
            border-radius: 0 4px 4px 0;
        }

        .cf-edit-card .card-header {
            padding: 28px 32px 20px 32px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .cf-edit-card .card-header .header-icon {
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

        .cf-edit-card .card-header .header-icon .icon {
            width: 20px;
            height: 20px;
        }

        .cf-edit-card .card-header .header-text {
            flex: 1;
        }

        .cf-edit-card .card-header .header-text .title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
        }

        .cf-edit-card .card-header .header-text .desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cf-edit-card .card-header .header-text .desc .period-highlight {
            color: var(--theme-primary);
            font-weight: 600;
        }

        .cf-edit-card .card-body {
            padding: 28px 32px 32px 32px;
        }

        /* ===== FORM ===== */
        .cf-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 24px 20px;
        }

        .cf-form-grid .full-width {
            grid-column: 1 / -1;
        }

        .cf-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .cf-form-group label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cf-form-group label .required {
            color: var(--danger);
            font-weight: 700;
        }

        .cf-form-group label .optional {
            color: var(--text-tertiary);
            font-weight: 400;
            font-size: 11px;
        }

        .cf-form-group label .helper-icon {
            color: var(--text-tertiary);
            cursor: help;
            margin-left: auto;
        }

        .cf-form-group input,
        .cf-form-group select,
        .cf-form-group textarea {
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

        .cf-form-group input:focus,
        .cf-form-group select:focus,
        .cf-form-group textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--theme-soft);
        }

        .cf-form-group input:hover,
        .cf-form-group select:hover,
        .cf-form-group textarea:hover {
            border-color: var(--border-hover);
        }

        .cf-form-group input::placeholder,
        .cf-form-group textarea::placeholder {
            color: var(--text-tertiary);
            font-weight: 400;
        }

        .cf-form-group select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
            padding-right: 38px;
            cursor: pointer;
        }

        .cf-form-group select option {
            background: var(--bg-card);
            color: var(--text-primary);
            padding: 8px 12px;
        }

        .cf-form-group textarea {
            resize: vertical;
            min-height: 100px;
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        .cf-form-group .field-hint {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .cf-form-group .field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cf-form-group .field-error .icon {
            width: 14px;
            height: 14px;
        }

        /* ===== DIRECTION TOGGLE ===== */
        .direction-toggle {
            display: flex;
            gap: 8px;
            background: var(--bg-card-active);
            border-radius: var(--radius-sm);
            padding: 4px;
            border: 1.5px solid var(--border-color);
            transition: border-color 0.25s ease;
        }

        .direction-toggle:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 4px var(--theme-soft);
        }

        .direction-option {
            flex: 1;
            padding: 10px 16px;
            border-radius: calc(var(--radius-sm) - 4px);
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
        }

        .direction-option .icon {
            width: 16px;
            height: 16px;
        }

        .direction-option:hover {
            color: var(--text-primary);
            background: var(--bg-card);
        }

        .direction-option.active-masuk {
            background: var(--success-soft);
            color: var(--success);
        }

        .direction-option.active-keluar {
            background: var(--danger-soft);
            color: var(--danger);
        }

        /* ===== CATEGORY BADGE PREVIEW ===== */
        .category-preview {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px 4px 8px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            background: var(--theme-soft);
            color: var(--theme-primary);
            margin-top: 4px;
        }

        .category-preview .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        /* ===== ACTIONS ===== */
        .cf-edit-actions {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .cf-edit-actions .left-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .cf-edit-actions .right-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .cf-btn {
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

        .cf-btn .icon {
            width: 16px;
            height: 16px;
        }

        .cf-btn:hover {
            transform: translateY(-2px);
        }

        .cf-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .cf-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cf-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            color: #fff;
        }

        .cf-btn-outline {
            background: var(--bg-card);
            border: 1.5px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cf-btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cf-btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .cf-btn-danger:hover {
            background: #d14a4a;
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
            color: #fff;
        }

        .cf-btn-danger-ghost {
            background: transparent;
            color: var(--danger);
            border: 1.5px solid var(--danger-soft);
        }

        .cf-btn-danger-ghost:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
            transform: translateY(-2px);
        }

        .cf-btn .ripple {
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

        /* ===== DELETE MODAL ===== */
        .cf-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }

        .cf-modal-overlay.active {
            display: flex;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .cf-modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        .cf-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            color: var(--danger);
            margin: 0 auto 16px;
            background: var(--danger-soft);
            border-radius: 50%;
            padding: 12px;
        }

        .cf-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .cf-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            line-height: 1.6;
        }

        .cf-modal-box .cf-desc-text {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 6px;
            display: inline-block;
        }

        .cf-modal-box .warning-text {
            font-size: 13px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 12px;
            padding: 10px 16px;
            background: var(--danger-soft);
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .cf-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .cf-modal-actions .btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .cf-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .cf-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cf-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .cf-modal-actions .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .cf-modal-actions .btn-danger:hover {
            background: #d14a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 90, 0.4);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .cf-form-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .cf-edit-wrap { padding: 0 16px; }
            .cf-edit-header { flex-direction: column; }
            .cf-edit-header h1 { font-size: 22px; }
            .cf-edit-card .card-header { 
                flex-direction: column; 
                align-items: flex-start;
                padding: 20px 20px 16px;
            }
            .cf-edit-card .card-body { padding: 20px; }
            .cf-form-grid { grid-template-columns: 1fr; gap: 18px; }
            .cf-edit-actions { 
                flex-direction: column-reverse;
                align-items: stretch;
            }
            .cf-edit-actions .left-actions,
            .cf-edit-actions .right-actions {
                width: 100%;
                flex-direction: column;
            }
            .cf-edit-actions .cf-btn { 
                width: 100%; 
                justify-content: center;
            }
            .direction-toggle { flex-direction: column; }
        }

        @media (max-width: 480px) {
            .cf-edit-wrap { padding: 0 12px; }
            .cf-edit-header h1 { font-size: 20px; }
            .cf-edit-card .card-header .header-text .title { font-size: 14px; }
            .cf-edit-card .card-header .header-text .desc { font-size: 12px; }
            .cf-btn { font-size: 12.5px; padding: 10px 20px; }
            .cf-modal-box { padding: 24px 20px; }
            .cf-modal-actions { flex-direction: column; }
            .cf-modal-actions .btn { width: 100%; }
        }
    </style>

    <div class="cf-edit-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="cf-edit-header animate-in" style="animation-delay: 0.05s;">
            <div class="cf-edit-header-left">
                <div class="cf-edit-badge">
                    <span class="dot"></span>
                    Edit Transaksi
                </div>
                <h1>Edit Transaksi Arus Kas</h1>
                <p class="subtitle">
                    Perbarui data transaksi <strong>{{ $item->name }}</strong> untuk 
                    <span class="highlight">periode {{ $item->period_label }}</span>
                </p>
            </div>
        </div>

        {{-- ===== FORM ===== --}}
        <form method="POST" action="{{ route('cash-flow.update', $item) }}" class="animate-in" style="animation-delay: 0.10s;">
            @csrf
            @method('PUT')

            <div class="cf-edit-card">
                <div class="card-accent"></div>

                <div class="card-header">
                    <div class="header-icon">
                        <svg class="icon"><use href="#ic-edit"/></svg>
                    </div>
                    <div class="header-text">
                        <p class="title">Form Edit Transaksi</p>
                        <p class="desc">
                            Perubahan akan memengaruhi laporan arus kas 
                            <span class="period-highlight">periode {{ $item->period_label }}</span>
                        </p>
                    </div>
                    <div class="category-preview" id="categoryPreview">
                        <span class="dot" style="background:var(--theme-primary);"></span>
                        <span id="categoryLabel">{{ ucfirst($item->category ?? 'Operasional') }}</span>
                    </div>
                </div>

                <div class="card-body">
                    @include('cash-flow._form')

                    <div class="cf-edit-actions">
                        <div class="left-actions">
                            <button type="button" class="cf-btn cf-btn-danger-ghost" onclick="openDeleteModal()">
                                <svg class="icon"><use href="#ic-trash"/></svg>
                                Hapus Transaksi
                            </button>
                        </div>
                        <div class="right-actions">
                            <a href="{{ route('cash-flow.index') }}" class="cf-btn cf-btn-outline">
                                <svg class="icon"><use href="#ic-x"/></svg>
                                Batal
                            </a>
                            <button type="submit" class="cf-btn cf-btn-primary">
                                <svg class="icon"><use href="#ic-save"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="cf-modal-overlay" id="deleteModal">
        <div class="cf-modal-box">
            <svg class="icon-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <h3>Hapus Transaksi?</h3>
            <p>
                Anda yakin ingin menghapus transaksi
                <br>
                <span class="cf-desc-text">{{ $item->name }}</span>
            </p>
            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>
            <div class="cf-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form method="POST" action="{{ route('cash-flow.destroy', $item) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <path d="M3 6h18"/>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                        </svg>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></symbol>
        <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-save" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
        <symbol id="ic-receive" viewBox="0 0 24 24"><path d="M12 2v20"/><path d="M6 16l6 6 6-6"/><path d="M6 8l6-6 6 6"/></symbol>
        <symbol id="ic-alert-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== CATEGORY PREVIEW =====
            const categorySelect = document.querySelector('select[name="category"]');
            const categoryLabel = document.getElementById('categoryLabel');
            const categoryPreview = document.getElementById('categoryPreview');

            if (categorySelect && categoryLabel) {
                function updateCategoryPreview() {
                    const selected = categorySelect.options[categorySelect.selectedIndex];
                    const label = selected ? selected.text : 'Operasional';
                    categoryLabel.textContent = label;
                    
                    const dot = categoryPreview.querySelector('.dot');
                    const colors = {
                        'operasional': 'var(--success)',
                        'investasi': 'var(--info)',
                        'pendanaan': 'var(--warning)'
                    };
                    const bgColors = {
                        'operasional': 'var(--success-soft)',
                        'investasi': 'var(--info-soft)',
                        'pendanaan': 'var(--warning-soft)'
                    };
                    const value = categorySelect.value;
                    if (dot) {
                        dot.style.background = colors[value] || 'var(--theme-primary)';
                    }
                    categoryPreview.style.background = bgColors[value] || 'var(--theme-soft)';
                    categoryPreview.style.color = colors[value] || 'var(--theme-primary)';
                }

                categorySelect.addEventListener('change', updateCategoryPreview);
                updateCategoryPreview();
            }

            // ===== DIRECTION TOGGLE =====
            const directionInput = document.querySelector('input[name="direction"][type="hidden"]');
            const masukBtn = document.querySelector('.direction-option[data-value="masuk"]');
            const keluarBtn = document.querySelector('.direction-option[data-value="keluar"]');

            if (directionInput && masukBtn && keluarBtn) {
                function setDirection(value) {
                    directionInput.value = value;
                    masukBtn.classList.remove('active-masuk');
                    keluarBtn.classList.remove('active-keluar');
                    if (value === 'masuk') {
                        masukBtn.classList.add('active-masuk');
                    } else {
                        keluarBtn.classList.add('active-keluar');
                    }
                }

                masukBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    setDirection('masuk');
                });

                keluarBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    setDirection('keluar');
                });

                // Set initial value
                if (directionInput.value) {
                    setDirection(directionInput.value);
                }
            }

            // ===== DELETE MODAL =====
            window.openDeleteModal = function() {
                document.getElementById('deleteModal').classList.add('active');
                document.body.style.overflow = 'hidden';
            };

            window.closeDeleteModal = function() {
                document.getElementById('deleteModal').classList.remove('active');
                document.body.style.overflow = '';
            };

            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeDeleteModal();
            });

            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.cf-btn').forEach(btn => {
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

            // ===== FORM VALIDATION HIGHLIGHT =====
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
                });
            }
        });
    </script>

</x-app-layout>