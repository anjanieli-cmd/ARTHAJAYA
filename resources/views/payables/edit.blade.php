<x-app-layout>
    <x-slot name="title">Edit Tagihan</x-slot>

    @php
        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
        $statusOptions = ['lancar' => 'Lancar', 'jatuh_tempo' => 'Jatuh Tempo', 'lunas' => 'Lunas'];
    @endphp

    <style>
        .edit-wrap {
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
            
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .edit-wrap * { box-sizing: border-box; }
        .edit-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .edit-wrap .animate-in { animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .ed-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 32px;
            padding: 0 4px;
        }

        .ed-header-left { flex: 1; min-width: 200px; }

        .ed-badge {
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
            margin-bottom: 14px;
        }

        .ed-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .ed-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .ed-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .ed-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .ed-btn {
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
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background: transparent;
            color: var(--text-secondary);
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .ed-btn .icon { width: 16px; height: 16px; }
        .ed-btn:hover { transform: translateY(-2px); }
        .ed-btn:active { transform: translateY(0) scale(0.97); }

        .ed-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .ed-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .ed-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .ed-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .ed-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ALERT */
        .ed-alert {
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 13px;
        }

        .ed-alert .icon { width: 20px; height: 20px; flex-shrink: 0; }

        .ed-alert.success {
            background: var(--success-soft);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .ed-alert.error {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        /* FORM */
        .ed-form {
            max-width: 100%;
        }

        .ed-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 36px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .ed-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-md);
        }

        .ed-card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }

        .ed-card-header .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--theme-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px var(--theme-glow);
        }

        .ed-card-header .icon-box .icon {
            width: 22px;
            height: 22px;
        }

        .ed-card-header .title-group {
            flex: 1;
        }

        .ed-card-header .title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .ed-card-header .sub {
            font-size: 12.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .ed-group {
            margin-bottom: 22px;
        }

        .ed-group:last-child { margin-bottom: 0; }

        .ed-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 7px;
        }

        .ed-group .required {
            color: var(--danger);
            font-size: 14px;
        }

        .ed-group input,
        .ed-group select {
            width: 100%;
            padding: 12px 16px;
            background: var(--bg-card-active);
            border: 2px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s ease;
            outline: none;
        }

        .ed-group input:focus,
        .ed-group select:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--theme-glow);
        }

        .ed-group input::placeholder {
            color: var(--text-tertiary);
        }

        .ed-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
            cursor: pointer;
        }

        .ed-group select option {
            background: var(--bg-card);
            color: var(--text-primary);
            padding: 8px;
        }

        .ed-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .ed-actions-form {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 24px;
            border-top: 2px solid var(--border-color);
        }

        .ed-actions-form .ed-btn {
            flex: 1;
            justify-content: center;
            padding: 12px 24px;
            font-size: 14px;
        }

        .ed-actions-form .ed-btn-primary {
            flex: 2;
        }

        @media (max-width: 768px) {
            .ed-row { grid-template-columns: 1fr; gap: 0; }
            .ed-card { padding: 24px 20px; }
            .ed-header { flex-direction: column; align-items: flex-start; }
            .ed-actions { width: 100%; }
            .ed-actions .ed-btn { flex: 1; justify-content: center; }
            .ed-header h1 { font-size: 24px; }
        }

        @media (max-width: 640px) {
            .ed-card { padding: 20px 16px; border-radius: var(--radius-sm); }
            .ed-actions-form { flex-direction: column; }
            .ed-actions-form .ed-btn { flex: 1; }
            .ed-card-header .icon-box { width: 40px; height: 40px; }
            .ed-card-header .icon-box .icon { width: 18px; height: 18px; }
            .ed-card-header .title { font-size: 15px; }
        }
    </style>

    <div class="edit-wrap">

        <div class="ed-header animate-in" style="animation-delay: 0.05s;">
            <div class="ed-header-left">
                <div class="ed-badge">
                    <span class="dot"></span>
                    Utang Usaha
                </div>
                <h1>Edit Tagihan</h1>
                <p class="subtitle">Edit data tagihan dari vendor</p>
            </div>
            <div class="ed-actions">
                <a href="/payables" class="ed-btn ed-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Kembali
                </a>
                <a href="/payables/{{ $index }}" class="ed-btn ed-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    Detail
                </a>
            </div>
        </div>

        @if(session('error'))
            <div class="ed-alert error animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="/payables/{{ $index }}" method="POST" class="ed-form">
            @csrf
            @method('PUT')

            <div class="ed-card animate-in" style="animation-delay: 0.10s;">
                
                <div class="ed-card-header">
                    <div class="icon-box">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                    </div>
                    <div class="title-group">
                        <div class="title">Informasi Tagihan</div>
                        <div class="sub">Edit data tagihan dari vendor</div>
                    </div>
                </div>

                <div class="ed-row">
                    <div class="ed-group">
                        <label>
                            <span>Vendor</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="vendor" value="{{ $payable['vendor'] }}" required>
                    </div>
                    <div class="ed-group">
                        <label>
                            <span>Nomor Tagihan</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="bill" value="{{ $payable['bill'] }}" required>
                    </div>
                </div>

                <div class="ed-row">
                    <div class="ed-group">
                        <label>
                            <span>Tanggal</span>
                            <span class="required">*</span>
                        </label>
                        <input type="date" name="date" value="{{ $payable['date'] }}" required>
                    </div>
                    <div class="ed-group">
                        <label>
                            <span>Jatuh Tempo</span>
                            <span class="required">*</span>
                        </label>
                        <input type="date" name="due" value="{{ $payable['due'] }}" required>
                    </div>
                </div>

                <div class="ed-row">
                    <div class="ed-group">
                        <label>
                            <span>Status</span>
                            <span class="required">*</span>
                        </label>
                        <select name="status" required>
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}" {{ $payable['status'] == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ed-group">
                        <label>
                            <span>Jumlah</span>
                            <span class="required">*</span>
                        </label>
                        <input type="number" name="amount" value="{{ $payable['amount'] }}" min="0" step="1000" required>
                    </div>
                </div>

                <div class="ed-actions-form">
                    <a href="/payables" class="ed-btn ed-btn-ghost">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="ed-btn ed-btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                        </svg>
                        Update Tagihan
                    </button>
                </div>

            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.ed-btn');
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

            const firstInput = document.querySelector('.ed-group input:not([type="hidden"])');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 400);
            }
        });
    </script>

</x-app-layout>