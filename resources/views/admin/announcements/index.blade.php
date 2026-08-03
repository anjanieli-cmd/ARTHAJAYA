<x-admin-layout>
    <x-slot name="title">Broadcast Pengumuman</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 11v2a1 1 0 0 0 1 1h2.5l4 3V8l-4 3H4a1 1 0 0 0-1 1z"/><path d="M18 8c2 0 4 1.5 4 4s-2 4-4 4"/><path d="M14 8v8"/>
            </symbol>
            <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .bcw {
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

        .bcw * { box-sizing:border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInTimeline {
            from { opacity: 0; transform: translateX(-16px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes dotPulse {
            0% { box-shadow: 0 0 0 0 rgba(var(--emerald-rgb), 0.5); }
            100% { box-shadow: 0 0 0 12px rgba(var(--emerald-rgb), 0); }
        }

        @keyframes highlightFlash {
            0% { background: rgba(var(--emerald-rgb), 0.16); }
            100% { background: var(--surface); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .bcw .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .bcw .icon {
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
        .bcw-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .bcw-header-left {
            flex: 1;
            min-width: 200px;
        }

        .bcw-badge {
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

        .bcw-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .bcw-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .bcw-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bcw-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .bcw-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .bcw-btn {
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

        .bcw-btn .icon {
            width: 16px;
            height: 16px;
        }

        .bcw-btn:hover {
            transform: translateY(-2px);
        }

        .bcw-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .bcw-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .bcw-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .bcw-btn .ripple {
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

        /* ===== LAYOUT ===== */
        .bcw-layout {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .bcw-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ===== COMPOSE CARD ===== */
        .compose-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 28px 26px;
            position: sticky;
            top: 100px;
            transition: border-color 0.3s ease;
        }

        .compose-card:hover {
            border-color: var(--border-hover);
        }

        .compose-card .compose-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--theme-soft);
            color: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .compose-card .compose-icon .icon {
            width: 22px;
            height: 22px;
        }

        .compose-card h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--text-primary);
        }

        .compose-card .sub {
            font-size: 12.5px;
            color: var(--text-tertiary);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: 11px;
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
            background: var(--bg-card);
        }

        .form-control::placeholder {
            color: var(--text-tertiary);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .bcw-btn-send {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 11px;
            background: var(--theme-gradient);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 16px var(--theme-glow);
            font-family: 'Inter', sans-serif;
        }

        .bcw-btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px var(--theme-glow);
        }

        .bcw-btn-send:active {
            transform: scale(0.97);
        }

        .bcw-btn-send:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .bcw-btn-send .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: none;
        }

        .bcw-btn-send.loading .spinner {
            display: block;
        }

        .bcw-btn-send.loading .label {
            display: none;
        }

        .bcw-btn-send .icon {
            width: 18px;
            height: 18px;
        }

        /* ===== TIMELINE ===== */
        .timeline-wrap {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 28px;
            transition: border-color 0.3s ease;
        }

        .timeline-wrap:hover {
            border-color: var(--border-hover);
        }

        .timeline-wrap .timeline-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .timeline-wrap .timeline-header h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .timeline-wrap .timeline-header h3 .icon {
            width: 18px;
            height: 18px;
            color: var(--theme-primary);
        }

        .timeline-wrap .timeline-header .count {
            font-size: 12px;
            color: var(--text-tertiary);
            background: var(--bg-card-active);
            padding: 2px 12px;
            border-radius: 100px;
        }

        .timeline {
            position: relative;
            padding-left: 32px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: linear-gradient(var(--border-color), transparent);
        }

        .tl-item {
            position: relative;
            margin-bottom: 20px;
            animation: slideInTimeline 0.4s cubic-bezier(0.16, 1, 0.3, 1) backwards;
        }

        .tl-item.flash {
            animation: highlightFlash 1.6s ease;
        }

        .tl-dot {
            position: absolute;
            left: -32px;
            top: 18px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--theme-primary);
            border: 3px solid var(--bg);
        }

        .tl-dot.new {
            animation: dotPulse 1.2s ease-out 2;
        }

        .tl-card {
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 22px;
            transition: all 0.3s ease;
        }

        .tl-card:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
        }

        .tl-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 8px;
        }

        .tl-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .tl-del {
            background: none;
            border: none;
            color: var(--text-tertiary);
            cursor: pointer;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 6px;
            flex-shrink: 0;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .tl-del .icon {
            width: 13px;
            height: 13px;
        }

        .tl-del:hover {
            color: var(--danger);
            background: var(--danger-soft);
        }

        .tl-msg {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.7;
            white-space: pre-line;
            margin-bottom: 12px;
        }

        .tl-meta {
            font-size: 11.5px;
            color: var(--text-tertiary);
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .tl-meta .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .tl-meta .meta-item .icon {
            width: 12px;
            height: 12px;
        }

        .tl-meta .dot-sep {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--text-tertiary);
        }

        .tl-empty {
            padding: 50px 20px;
            text-align: center;
            color: var(--text-tertiary);
            font-size: 13.5px;
            background: var(--bg-card-active);
            border: 1px dashed var(--border-color);
            border-radius: var(--radius-md);
        }

        .tl-empty .icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            color: var(--text-tertiary);
            opacity: 0.5;
        }

        .tl-empty h4 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .tl-empty p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .bcw {
                padding: 0 12px;
            }

            .bcw-header {
                flex-direction: column;
            }

            .bcw-header h1 {
                font-size: 24px;
            }

            .compose-card {
                position: relative;
                top: 0;
                padding: 20px;
            }

            .timeline-wrap {
                padding: 20px;
            }

            .tl-card {
                padding: 16px 18px;
            }

            .tl-title {
                font-size: 14px;
            }

            .tl-msg {
                font-size: 12.5px;
            }
        }

        @media (max-width: 480px) {
            .bcw-header h1 {
                font-size: 20px;
            }

            .bcw-header p {
                font-size: 13px;
            }

            .compose-card {
                padding: 16px;
            }

            .compose-card h3 {
                font-size: 15px;
            }

            .timeline-wrap {
                padding: 16px;
            }

            .timeline {
                padding-left: 24px;
            }

            .tl-dot {
                left: -24px;
                width: 12px;
                height: 12px;
                top: 16px;
            }

            .tl-card {
                padding: 14px 16px;
            }

            .tl-head {
                flex-wrap: wrap;
            }

            .tl-del {
                font-size: 10px;
                padding: 2px 8px;
            }

            .tl-meta {
                font-size: 10.5px;
                gap: 6px;
            }

            .tl-empty h4 {
                font-size: 14px;
            }

            .tl-empty p {
                font-size: 12px;
            }
        }

        @media (max-width: 380px) {
            .bcw-header h1 {
                font-size: 18px;
            }

            .bcw-btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .bcw-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="bcw">

        <!-- ===== HEADER ===== -->
        <div class="bcw-header animate-in" style="animation-delay: 0.05s;">
            <div class="bcw-header-left">
                <div class="bcw-badge">
                    <span class="dot"></span>
                    Komunikasi
                </div>
                <h1><span class="highlight">Broadcast Pengumuman</span></h1>
                <p>Kirim pengumuman yang akan tercatat dan dapat dilihat riwayatnya di sini.</p>
            </div>
            <div class="bcw-header-actions">
                <a href="{{ route('admin.announcements.index') }}" class="bcw-btn bcw-btn-primary">
                    <svg class="icon"><use href="#ic-megaphone"/></svg>
                    Refresh
                </a>
            </div>
        </div>

        <!-- ===== LAYOUT ===== -->
        <div class="bcw-layout">

            <!-- ===== KIRI: COMPOSE ===== -->
            <div class="compose-card animate-in" style="animation-delay: 0.1s;">
                <div class="compose-icon">
                    <svg class="icon"><use href="#ic-megaphone"/></svg>
                </div>
                <h3>Buat Pengumuman</h3>
                <div class="sub">Isi judul dan pesan singkat untuk dibagikan.</div>

                <form id="announceForm">
                    @csrf
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" placeholder="contoh: Maintenance Terjadwal" required>
                    </div>
                    <div class="form-group">
                        <label>Pesan</label>
                        <textarea name="message" class="form-control" placeholder="Tulis isi pengumuman..." required></textarea>
                    </div>
                    <button type="submit" class="bcw-btn-send" id="sendBtn">
                        <span class="spinner"></span>
                        <svg class="icon"><use href="#ic-send"/></svg>
                        <span class="label">Kirim Pengumuman</span>
                    </button>
                </form>
            </div>

            <!-- ===== KANAN: TIMELINE ===== -->
            <div class="timeline-wrap animate-in" style="animation-delay: 0.12s;">
                <div class="timeline-header">
                    <h3>
                        <svg class="icon"><use href="#ic-megaphone"/></svg>
                        Riwayat Pengumuman
                    </h3>
                    <span class="count">{{ $announcements->count() }}</span>
                </div>

                <div class="timeline" id="timeline">
                    @forelse($announcements as $i => $a)
                        <div class="tl-item" style="animation-delay: {{ min($i * 0.06, 0.4) }}s;">
                            <div class="tl-dot"></div>
                            <div class="tl-card">
                                <div class="tl-head">
                                    <div class="tl-title">{{ $a->title }}</div>
                                    <form method="POST" action="{{ route('admin.announcements.destroy', $a) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tl-del">
                                            <svg class="icon"><use href="#ic-trash"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                <div class="tl-msg">{{ $a->message }}</div>
                                <div class="tl-meta">
                                    <span class="meta-item">
                                        <svg class="icon"><use href="#ic-user"/></svg>
                                        {{ $a->creator->name ?? 'Sistem' }}
                                    </span>
                                    <span class="dot-sep"></span>
                                    <span class="meta-item">
                                        <svg class="icon"><use href="#ic-clock"/></svg>
                                        {{ $a->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="tl-empty" id="timelineEmpty">
                            <svg class="icon"><use href="#ic-inbox"/></svg>
                            <h4>Belum ada pengumuman</h4>
                            <p>Pengumuman yang dikirim akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script>
        (function(){
            var form = document.getElementById('announceForm');
            var btn = document.getElementById('sendBtn');
            var timeline = document.getElementById('timeline');
            var empty = document.getElementById('timelineEmpty');

            // ===== RIPPLE EFFECT =====
            document.querySelectorAll('.bcw-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    var rect = this.getBoundingClientRect();
                    var ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    var size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(function() {
                        ripple.remove();
                    }, 600);
                });
            });

            // ===== FORM SUBMIT =====
            form.addEventListener('submit', function(e){
                e.preventDefault();
                btn.disabled = true;
                btn.classList.add('loading');

                var formData = new FormData(form);

                fetch('{{ route("admin.announcements.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(function(res){ return res.json(); })
                .then(function(data){
                    if(!data.success) throw new Error('Gagal');

                    if(empty){ empty.remove(); }

                    var a = data.announcement;
                    var item = document.createElement('div');
                    item.className = 'tl-item flash';
                    item.style.animationDelay = '0s';
                    item.innerHTML = 
                        '<div class="tl-dot new"></div>' +
                        '<div class="tl-card">' +
                            '<div class="tl-head">' +
                                '<div class="tl-title"></div>' +
                                '<form method="POST" action="/admin/announcements/' + a.id + '" onsubmit="return confirm(\'Hapus pengumuman ini?\')">' +
                                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                    '<input type="hidden" name="_method" value="DELETE">' +
                                    '<button type="submit" class="tl-del">' +
                                        '<svg class="icon"><use href="#ic-trash"/></svg> Hapus' +
                                    '</button>' +
                                '</form>' +
                            '</div>' +
                            '<div class="tl-msg"></div>' +
                            '<div class="tl-meta">' +
                                '<span class="meta-item"><svg class="icon"><use href="#ic-user"/></svg></span>' +
                                '<span class="dot-sep"></span>' +
                                '<span class="meta-item"><svg class="icon"><use href="#ic-clock"/></svg> Baru saja</span>' +
                            '</div>' +
                        '</div>';

                    item.querySelector('.tl-title').textContent = a.title;
                    item.querySelector('.tl-msg').textContent = a.message;
                    item.querySelector('.tl-meta .meta-item').innerHTML = 
                        '<svg class="icon"><use href="#ic-user"/></svg> ' + a.creator;

                    timeline.insertBefore(item, timeline.firstChild);

                    // Update count
                    var countEl = document.querySelector('.count');
                    if(countEl) {
                        var currentCount = parseInt(countEl.textContent) || 0;
                        countEl.textContent = currentCount + 1;
                    }

                    form.reset();
                })
                .catch(function(err){
                    alert('Gagal mengirim pengumuman. Coba lagi.');
                    console.error(err);
                })
                .finally(function(){
                    btn.disabled = false;
                    btn.classList.remove('loading');
                });
            });
        })();
    </script>
</x-admin-layout>