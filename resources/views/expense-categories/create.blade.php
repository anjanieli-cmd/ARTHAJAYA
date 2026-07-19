<x-app-layout>
    <x-slot name="title">Kategori Baru</x-slot>

    <style>
        /* ============================================
           CREATE CATEGORY - Premium Design
           ============================================ */
        
        .cc-wrap {
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
            
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
        }

        .cc-wrap * { box-sizing: border-box; }

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

        .cc-wrap .animate-in { animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .cc-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .cc-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 32px;
            padding: 0 4px;
        }

        .cc-header-left { flex: 1; min-width: 200px; }

        .cc-badge {
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

        .cc-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .cc-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .cc-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .cc-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .cc-btn {
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

        .cc-btn .icon { width: 16px; height: 16px; }
        .cc-btn:hover { transform: translateY(-2px); }
        .cc-btn:active { transform: translateY(0) scale(0.97); }

        .cc-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .cc-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .cc-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .cc-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .cc-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* ALERT */
        .cc-alert {
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 13px;
        }

        .cc-alert .icon { width: 20px; height: 20px; flex-shrink: 0; }

        .cc-alert.error {
            background: var(--danger-soft);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        /* FORM */
        .cc-form {
            max-width: 100%;
        }

        .cc-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px 36px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .cc-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-md);
        }

        .cc-card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }

        .cc-card-header .icon-box {
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

        .cc-card-header .icon-box .icon {
            width: 22px;
            height: 22px;
        }

        .cc-card-header .title-group {
            flex: 1;
        }

        .cc-card-header .title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .cc-card-header .sub {
            font-size: 12.5px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }

        .cc-group {
            margin-bottom: 22px;
        }

        .cc-group:last-child { margin-bottom: 0; }

        .cc-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 7px;
        }

        .cc-group .required {
            color: var(--danger);
            font-size: 14px;
        }

        .cc-group .helper {
            font-size: 11.5px;
            color: var(--text-tertiary);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cc-group .helper .icon {
            width: 14px;
            height: 14px;
        }

        .cc-group input,
        .cc-group textarea {
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

        .cc-group input:focus,
        .cc-group textarea:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--theme-glow);
        }

        .cc-group input::placeholder,
        .cc-group textarea::placeholder {
            color: var(--text-tertiary);
        }

        .cc-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .cc-group .error-text {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cc-group .error-text .icon {
            width: 14px;
            height: 14px;
        }

        .cc-actions-form {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 24px;
            border-top: 2px solid var(--border-color);
        }

        .cc-actions-form .cc-btn {
            flex: 1;
            justify-content: center;
            padding: 12px 24px;
            font-size: 14px;
        }

        .cc-actions-form .cc-btn-primary {
            flex: 2;
        }

        @media (max-width: 768px) {
            .cc-card { padding: 24px 20px; }
            .cc-header { flex-direction: column; align-items: flex-start; }
            .cc-actions { width: 100%; }
            .cc-actions .cc-btn { flex: 1; justify-content: center; }
            .cc-header h1 { font-size: 24px; }
        }

        @media (max-width: 640px) {
            .cc-card { padding: 20px 16px; border-radius: var(--radius-sm); }
            .cc-actions-form { flex-direction: column; }
            .cc-actions-form .cc-btn { flex: 1; }
            .cc-card-header .icon-box { width: 40px; height: 40px; }
            .cc-card-header .icon-box .icon { width: 18px; height: 18px; }
            .cc-card-header .title { font-size: 15px; }
        }

        @media (max-width: 380px) {
            .cc-header h1 { font-size: 20px; }
            .cc-btn { font-size: 12px; padding: 8px 14px; }
            .cc-btn .icon { width: 14px; height: 14px; }
        }
    </style>

    <div class="cc-wrap">

        <!-- HEADER -->
        <div class="cc-header animate-in" style="animation-delay: 0.05s;">
            <div class="cc-header-left">
                <div class="cc-badge">
                    <span class="dot"></span>
                    Pembelian &amp; Biaya
                </div>
                <h1>Kategori Baru</h1>
                <p class="subtitle">Buat kategori biaya baru untuk pengeluaran usaha</p>
            </div>
            <div class="cc-actions">
                <a href="{{ route('expense-categories.index') }}" class="cc-btn cc-btn-ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- ALERT -->
        @if(session('error'))
            <div class="cc-alert error animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('expense-categories.store') }}" method="POST" class="cc-form">
            @csrf

            <div class="cc-card animate-in" style="animation-delay: 0.10s;">
                
                <!-- Card Header -->
                <div class="cc-card-header">
                    <div class="icon-box">
                        <!-- Icon Folder untuk kategori -->
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="title-group">
                        <div class="title">Informasi Kategori</div>
                        <div class="sub">Isi data kategori biaya dengan lengkap</div>
                    </div>
                </div>

                <!-- Nama Kategori -->
                <div class="cc-group">
                    <label>
                        <span>Nama Kategori</span>
                        <span class="required">*</span>
                    </label>
                    <input type="text" name="name" placeholder="Contoh: Bahan Baku" required value="{{ old('name') }}">
                    <span class="helper">
                        <!-- Icon Info -->
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Nama kategori harus unik dan mudah diingat
                    </span>
                    @error('name')
                        <span class="error-text">
                            <!-- Icon Alert -->
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="cc-group">
                    <label>Deskripsi</label>
                    <textarea name="description" placeholder="Contoh: Biaya untuk pembelian bahan baku produksi...">{{ old('description') }}</textarea>
                    <span class="helper">
                        <!-- Icon Edit/Note -->
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                        </svg>
                        Deskripsi opsional, untuk menjelaskan kategori lebih detail
                    </span>
                    @error('description')
                        <span class="error-text">
                            <!-- Icon Alert -->
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="cc-actions-form">
                    <a href="{{ route('expense-categories.index') }}" class="cc-btn cc-btn-ghost">
                        <!-- Icon X/Close -->
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="cc-btn cc-btn-primary">
                        <!-- Icon Save/Check -->
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                        </svg>
                        Simpan Kategori
                    </button>
                </div>

            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ripple effect
            const buttons = document.querySelectorAll('.cc-btn');
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

            // Auto-focus
            const firstInput = document.querySelector('.cc-group input:not([type="hidden"])');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 400);
            }
        });
    </script>

</x-app-layout>