<x-app-layout>
    <x-slot name="title">Tambah Transaksi Arus Kas</x-slot>

    <style>
        .cf-create-wrap {
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
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .cf-create-wrap * { box-sizing: border-box; }
        .cf-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .cf-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        /* ===== HEADER ===== */
        .cf-create-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .cf-create-header-left { flex: 1; min-width: 200px; }

        .cf-create-badge {
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

        .cf-create-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cf-create-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cf-create-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cf-create-header .subtitle strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* ===== CARD ===== */
        .cf-create-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 0;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .cf-create-card:hover {
            border-color: var(--border-hover);
        }

        .cf-create-card .card-accent {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--theme-gradient);
            border-radius: 0 4px 4px 0;
        }

        .cf-create-card .card-header {
            padding: 28px 32px 20px 32px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .cf-create-card .card-header .header-icon {
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

        .cf-create-card .card-header .header-icon .icon {
            width: 20px;
            height: 20px;
        }

        .cf-create-card .card-header .header-text {
            flex: 1;
        }

        .cf-create-card .card-header .header-text .title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
        }

        .cf-create-card .card-header .header-text .desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cf-create-card .card-body {
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
        .cf-create-actions {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .cf-form-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .cf-create-wrap { padding: 0 16px; }
            .cf-create-header { flex-direction: column; }
            .cf-create-header h1 { font-size: 22px; }
            .cf-create-card .card-header { 
                flex-direction: column; 
                align-items: flex-start;
                padding: 20px 20px 16px;
            }
            .cf-create-card .card-body { padding: 20px; }
            .cf-form-grid { grid-template-columns: 1fr; gap: 18px; }
            .cf-create-actions { 
                flex-direction: column-reverse;
                align-items: stretch;
            }
            .cf-create-actions .cf-btn { 
                width: 100%; 
                justify-content: center;
            }
            .direction-toggle { flex-direction: column; }
        }

        @media (max-width: 480px) {
            .cf-create-wrap { padding: 0 12px; }
            .cf-create-header h1 { font-size: 20px; }
            .cf-create-card .card-header .header-text .title { font-size: 14px; }
            .cf-create-card .card-header .header-text .desc { font-size: 12px; }
            .cf-btn { font-size: 12.5px; padding: 10px 20px; }
        }
    </style>

    <div class="cf-create-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="cf-create-header animate-in" style="animation-delay: 0.05s;">
            <div class="cf-create-header-left">
                <div class="cf-create-badge">
                    <span class="dot"></span>
                    Transaksi Baru
                </div>
                <h1>Tambah Transaksi Arus Kas</h1>
                <p class="subtitle">
                    Catat pergerakan kas <strong>{{ $company->name ?? 'perusahaanmu' }}</strong> 
                    berdasarkan aktivitas operasional, investasi, atau pendanaan.
                </p>
            </div>
        </div>

        {{-- ===== FORM ===== --}}
        <form method="POST" action="{{ route('cash-flow.store') }}" class="animate-in" style="animation-delay: 0.10s;">
            @csrf

            <div class="cf-create-card">
                <div class="card-accent"></div>

                <div class="card-header">
                    <div class="header-icon">
                        <svg class="icon"><use href="#ic-receive"/></svg>
                    </div>
                    <div class="header-text">
                        <p class="title">Form Transaksi Arus Kas</p>
                        <p class="desc">Isi detail transaksi dengan lengkap dan akurat.</p>
                    </div>
                    <div class="category-preview" id="categoryPreview">
                        <span class="dot" style="background:var(--theme-primary);"></span>
                        <span id="categoryLabel">Operasional</span>
                    </div>
                </div>

                <div class="card-body">
                    @include('cash-flow._form')

                    <div class="cf-create-actions">
                        <a href="{{ route('cash-flow.index') }}" class="cf-btn cf-btn-outline">
                            <svg class="icon"><use href="#ic-x"/></svg>
                            Batal
                        </a>
                        <button type="submit" class="cf-btn cf-btn-primary">
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
        <symbol id="ic-receive" viewBox="0 0 24 24"><path d="M12 2v20"/><path d="M6 16l6 6 6-6"/><path d="M6 8l6-6 6 6"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-save" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
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
                    
                    // Update dot color based on category
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

                // Set initial value if not set
                if (!directionInput.value) {
                    setDirection('masuk');
                }
            }

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
                            
                            // Remove highlight on focus
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