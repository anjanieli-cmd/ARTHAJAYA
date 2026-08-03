<x-admin-layout>
    <x-slot name="title">Kelola Langganan</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><line x1="6" y1="15" x2="10" y2="15"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-pause-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .spw {
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
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .spw * { box-sizing:border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeScaleIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .spw .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .spw .animate-scale {
            animation: fadeScaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .spw .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ===== HEADER ===== */
        .spw-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .spw-header-left {
            flex: 1;
            min-width: 200px;
        }

        .spw-badge {
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

        .spw-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .spw-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .spw-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .spw-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .spw-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .spw-btn {
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

        .spw-btn .icon {
            width: 16px;
            height: 16px;
        }

        .spw-btn:hover {
            transform: translateY(-2px);
        }

        .spw-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .spw-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .spw-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .spw-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .spw-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .spw-btn .ripple {
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

        /* ===== ALERT ===== */
        .alert-success {
            background: rgba(var(--emerald-rgb), 0.1);
            border: 1px solid rgba(var(--emerald-rgb), 0.3);
            color: var(--emerald);
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .alert-error {
            background: rgba(232, 90, 90, 0.1);
            border: 1px solid rgba(232, 90, 90, 0.3);
            color: var(--danger);
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* ===== PLAN GRID ===== */
        .plan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 18px;
        }

        .plan-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 26px 28px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .plan-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }

        .plan-card.inactive {
            opacity: 0.55;
        }

        .plan-card.inactive:hover {
            opacity: 0.75;
        }

        .plan-card .plan-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .plan-card .plan-icon .icon {
            width: 20px;
            height: 20px;
        }

        .plan-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 19px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .plan-price {
            font-size: 28px;
            font-weight: 700;
            color: var(--theme-primary);
            margin-bottom: 2px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .plan-price small {
            font-size: 13px;
            color: var(--text-tertiary);
            font-weight: 400;
        }

        .plan-desc {
            font-size: 12.5px;
            color: var(--text-secondary);
            margin: 10px 0 14px;
            line-height: 1.6;
            min-height: 38px;
        }

        .plan-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 12px;
            color: var(--text-tertiary);
            margin-bottom: 18px;
            padding: 10px 12px;
            background: var(--bg-card-active);
            border-radius: 10px;
        }

        .plan-meta .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .plan-meta .meta-item .icon {
            width: 13px;
            height: 13px;
        }

        .badge-inactive {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            background: var(--surface-strong);
            color: var(--text-tertiary);
            padding: 3px 12px;
            border-radius: 100px;
            letter-spacing: 0.04em;
        }

        .plan-actions {
            display: flex;
            gap: 8px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .spw-btn-sm {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9px;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
            font-family: inherit;
        }

        .spw-btn-sm:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .spw-btn-sm .icon {
            width: 14px;
            height: 14px;
        }

        .spw-btn-sm.danger {
            color: var(--danger);
        }

        .spw-btn-sm.danger:hover {
            background: var(--danger-soft);
            border-color: var(--danger);
        }

        .spw-btn-sm.primary {
            background: var(--theme-gradient);
            color: #fff;
            border-color: transparent;
        }

        .spw-btn-sm.primary:hover {
            box-shadow: 0 4px 16px var(--theme-glow);
            color: #fff;
        }

        /* ===== EMPTY STATE ===== */
        .empty-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 360px);
            text-align: center;
        }

        .empty-inner {
            max-width: 380px;
        }

        .empty-ic {
            width: 64px;
            height: 64px;
            margin: 0 auto 18px;
            border-radius: 18px;
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--theme-primary);
        }

        .empty-ic .icon {
            width: 28px;
            height: 28px;
        }

        .empty-inner h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 18px;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .empty-inner p {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .spw {
                padding: 0 12px;
            }

            .spw-header {
                flex-direction: column;
            }

            .spw-header-actions {
                width: 100%;
            }

            .spw-header-actions .spw-btn {
                flex: 1;
                justify-content: center;
            }

            .spw-header h1 {
                font-size: 24px;
            }

            .plan-grid {
                grid-template-columns: 1fr;
            }

            .plan-card {
                padding: 22px 20px;
            }

            .plan-price {
                font-size: 24px;
            }

            .empty-wrap {
                min-height: calc(100vh - 300px);
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .spw-header h1 {
                font-size: 20px;
            }

            .plan-name {
                font-size: 17px;
            }

            .plan-price {
                font-size: 22px;
            }

            .plan-actions {
                flex-wrap: wrap;
            }

            .plan-actions .spw-btn-sm {
                flex: 1;
                justify-content: center;
                min-width: 80px;
            }

            .empty-inner h3 {
                font-size: 16px;
            }

            .empty-inner p {
                font-size: 12.5px;
            }
        }

        @media (max-width: 380px) {
            .spw-header h1 {
                font-size: 18px;
            }

            .spw-btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .spw-btn .icon {
                width: 14px;
                height: 14px;
            }

            .plan-card {
                padding: 18px 16px;
            }

            .plan-meta {
                font-size: 11px;
                padding: 8px 10px;
            }
        }
    </style>

    <div class="spw">

        <!-- ===== HEADER ===== -->
        <div class="spw-header animate-in" style="animation-delay: 0.03s;">
            <div class="spw-header-left">
                <div class="spw-badge">
                    <span class="dot"></span>
                    Manajemen
                </div>
                <h1><span class="highlight">Kelola Langganan</span></h1>
                <p>Atur paket langganan yang tersedia untuk perusahaan pengguna Arvessa.</p>
            </div>
            <div class="spw-header-actions">
                <a href="{{ route('admin.subscription-plans.create') }}" class="spw-btn spw-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Tambah Paket
                </a>
            </div>
        </div>

        <!-- ===== ALERT ===== -->
        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay: 0.06s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error animate-in" style="animation-delay: 0.06s;">
                <svg class="icon"><use href="#ic-pause-circle"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <!-- ===== PLAN GRID ===== -->
        @if($plans->isEmpty())
            <div class="empty-wrap animate-scale" style="animation-delay: 0.1s;">
                <div class="empty-inner">
                    <div class="empty-ic"><svg class="icon"><use href="#ic-card"/></svg></div>
                    <h3>Belum ada paket langganan</h3>
                    <p>Kamu belum membuat paket langganan apa pun. Klik tombol di bawah untuk membuat paket pertama yang bisa dipilih perusahaan.</p>
                    <a href="{{ route('admin.subscription-plans.create') }}" class="spw-btn spw-btn-primary" style="display:inline-flex;">
                        <svg class="icon"><use href="#ic-plus"/></svg>
                        Tambah Paket Pertama
                    </a>
                </div>
            </div>
        @else
            <div class="plan-grid">
                @foreach($plans as $i => $plan)
                    <div class="plan-card {{ $plan->is_active ? '' : 'inactive' }} animate-in" style="animation-delay: {{ 0.1 + ($i * 0.05) }}s;">
                        @unless($plan->is_active)
                            <span class="badge-inactive">Nonaktif</span>
                        @endunless

                        <div class="plan-icon">
                            <svg class="icon"><use href="#ic-card"/></svg>
                        </div>

                        <div class="plan-name">{{ $plan->name }}</div>
                        <div class="plan-price">
                            Rp{{ number_format($plan->price, 0, ',', '.') }}
                            <small>/ {{ $plan->billing_period === 'monthly' ? 'bulan' : 'tahun' }}</small>
                        </div>
                        <div class="plan-desc">{{ $plan->description ?? 'Tidak ada deskripsi.' }}</div>

                        <div class="plan-meta">
                            <span class="meta-item">
                                <svg class="icon"><use href="#ic-users"/></svg>
                                Maks. {{ $plan->max_users ?? '∞' }} user
                            </span>
                            <span class="meta-item">
                                <svg class="icon"><use href="#ic-building"/></svg>
                                {{ $plan->companies_count }} perusahaan
                            </span>
                        </div>

                        <div class="plan-actions">
                            <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="spw-btn-sm">
                                <svg class="icon"><use href="#ic-edit"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.subscription-plans.destroy', $plan) }}" onsubmit="return confirm('Hapus paket ini?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="spw-btn-sm danger">
                                    <svg class="icon"><use href="#ic-trash"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.spw-btn, .spw-btn-sm');
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
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
</x-admin-layout>