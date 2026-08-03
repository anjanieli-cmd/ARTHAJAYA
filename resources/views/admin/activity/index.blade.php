<x-admin-layout>
    <x-slot name="title">Log Aktivitas</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-history" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 3-6.7"/><polyline points="3 4 3 9 8 9"/><polyline points="12 7 12 12 16 14"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-login" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
            </symbol>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>
            </symbol>
            <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .law {
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

        .law * { box-sizing:border-box; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeSlideLeft {
            from { opacity: 0; transform: translateX(-16px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes drawLine {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

        .law .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .law .animate-left {
            animation: fadeSlideLeft 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .law .icon {
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
        .law-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .law-header-left {
            flex: 1;
            min-width: 200px;
        }

        .law-badge {
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

        .law-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .law-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .law-header h1 .highlight {
            background: linear-gradient(135deg, var(--text-primary) 55%, var(--theme-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .law-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .law-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .law-btn {
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

        .law-btn .icon {
            width: 16px;
            height: 16px;
        }

        .law-btn:hover {
            transform: translateY(-2px);
        }

        .law-btn:active {
            transform: translateY(0) scale(0.97);
        }

        .law-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .law-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .law-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .law-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .law-btn .ripple {
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

        /* ===== SUMMARY STRIP ===== */
        .law-summary {
            display: flex;
            gap: 14px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .sum-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px 22px;
            flex: 1;
            min-width: 160px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .sum-card:hover {
            transform: translateY(-3px);
            border-color: var(--border-hover);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .sum-card .ic {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sum-card .ic .icon {
            width: 18px;
            height: 18px;
        }

        .sum-card.total .ic {
            background: rgba(var(--emerald-rgb), 0.14);
            color: var(--emerald);
        }

        .sum-card.today .ic {
            background: rgba(78, 143, 240, 0.14);
            color: #4E8FF0;
        }

        .sum-card.deletes .ic {
            background: rgba(232, 90, 90, 0.14);
            color: var(--danger);
        }

        .sum-card .val {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .sum-card .lbl {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        /* ===== TIMELINE ===== */
        .timeline-wrap {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 8px 28px 28px;
            transition: border-color 0.3s ease;
        }

        .timeline-wrap:hover {
            border-color: var(--border-hover);
        }

        .timeline {
            position: relative;
            padding-left: 34px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 13px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: var(--border-color);
            transform-origin: top;
            animation: drawLine 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .tl-item {
            position: relative;
            padding: 22px 0;
            border-bottom: 1px dashed var(--border-color);
        }

        .tl-item:last-child {
            border-bottom: none;
        }

        .tl-dot {
            position: absolute;
            left: -34px;
            top: 26px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--bg);
            z-index: 2;
        }

        .tl-dot .icon {
            width: 13px;
            height: 13px;
        }

        .tl-item.act-update .tl-dot {
            background: rgba(78, 143, 240, 0.18);
            color: #4E8FF0;
        }
        .tl-item.act-create .tl-dot {
            background: rgba(var(--emerald-rgb), 0.18);
            color: var(--emerald);
        }
        .tl-item.act-delete .tl-dot {
            background: rgba(232, 90, 90, 0.18);
            color: var(--danger);
        }
        .tl-item.act-login .tl-dot {
            background: rgba(155, 123, 224, 0.18);
            color: #9B7BE0;
        }
        .tl-item.act-security .tl-dot {
            background: rgba(240, 162, 90, 0.18);
            color: #F0A25A;
        }
        .tl-item.act-other .tl-dot {
            background: var(--surface-strong);
            color: var(--text-mute);
        }

        .tl-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }

        .tl-main {
            flex: 1;
            min-width: 260px;
        }

        .tl-top {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .log-action {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .tl-item.act-update .log-action {
            background: rgba(78, 143, 240, 0.14);
            color: #4E8FF0;
        }
        .tl-item.act-create .log-action {
            background: rgba(var(--emerald-rgb), 0.14);
            color: var(--emerald);
        }
        .tl-item.act-delete .log-action {
            background: rgba(232, 90, 90, 0.14);
            color: var(--danger);
        }
        .tl-item.act-login .log-action {
            background: rgba(155, 123, 224, 0.14);
            color: #9B7BE0;
        }
        .tl-item.act-security .log-action {
            background: rgba(240, 162, 90, 0.14);
            color: #F0A25A;
        }
        .tl-item.act-other .log-action {
            background: var(--surface-strong);
            color: var(--text-mute);
        }

        .tl-admin {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .tl-desc {
            font-size: 13.5px;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .tl-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
        }

        .tl-time {
            font-size: 12px;
            color: var(--text-tertiary);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tl-time .icon {
            width: 12px;
            height: 12px;
        }

        .tl-ip {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: var(--text-tertiary);
            font-family: 'IBM Plex Mono', monospace;
        }

        .tl-ip .icon {
            width: 11px;
            height: 11px;
        }

        /* newest item pulses briefly to draw attention */
        .tl-item:first-child .tl-dot {
            animation: pulseGlow 1.8s ease-in-out infinite;
        }

        .log-empty {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-ic {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: var(--theme-soft);
            border: 1px solid var(--theme-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--theme-primary);
            margin: 0 auto 16px;
        }

        .empty-ic .icon {
            width: 24px;
            height: 24px;
        }

        .log-empty h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 17px;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .log-empty p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .pagination-wrap {
            margin-top: 22px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .law {
                padding: 0 12px;
            }

            .law-header {
                flex-direction: column;
            }

            .law-header-actions {
                width: 100%;
            }

            .law-header-actions .law-btn {
                flex: 1;
                justify-content: center;
            }

            .law-header h1 {
                font-size: 24px;
            }

            .law-summary {
                gap: 10px;
            }

            .sum-card {
                padding: 14px 16px;
                min-width: 120px;
            }

            .sum-card .val {
                font-size: 17px;
            }

            .timeline-wrap {
                padding: 4px 16px 16px;
            }
        }

        @media (max-width: 640px) {
            .tl-content {
                flex-direction: column;
            }

            .tl-right {
                align-items: flex-start;
                flex-direction: row;
                gap: 12px;
                width: 100%;
            }

            .tl-main {
                min-width: 0;
            }

            .tl-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
        }

        @media (max-width: 480px) {
            .law-header h1 {
                font-size: 20px;
            }

            .law-summary {
                flex-direction: column;
            }

            .sum-card {
                min-width: 0;
            }

            .tl-item {
                padding: 16px 0;
            }

            .tl-dot {
                left: -28px;
                width: 22px;
                height: 22px;
                top: 20px;
            }

            .tl-dot .icon {
                width: 10px;
                height: 10px;
            }

            .timeline {
                padding-left: 26px;
            }

            .timeline::before {
                left: 9px;
            }

            .tl-desc {
                font-size: 12.5px;
            }
        }

        @media (max-width: 380px) {
            .law-header h1 {
                font-size: 18px;
            }

            .law-btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .law-btn .icon {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="law">

        <!-- ===== HEADER ===== -->
        <div class="law-header animate-in" style="animation-delay: 0.03s;">
            <div class="law-header-left">
                <div class="law-badge">
                    <span class="dot"></span>
                    Audit
                </div>
                <h1><span class="highlight">Log Aktivitas</span></h1>
                <p>Riwayat semua aksi yang dilakukan admin di sistem — perubahan access level, penghapusan user, dan lain-lain.</p>
            </div>
            <div class="law-header-actions">
                <a href="{{ route('admin.activity.index') }}" class="law-btn law-btn-ghost">
                    <svg class="icon"><use href="#ic-history"/></svg>
                    Refresh
                </a>
            </div>
        </div>

        @php
            $totalLogs = $logs->total();
            $todayLogs = $logs->getCollection()->filter(fn($l) => $l->created_at->isToday())->count();
            $deleteLogs = $logs->getCollection()->filter(fn($l) => str_contains(strtolower($l->action), 'delete'))->count();
        @endphp

        <!-- ===== SUMMARY STRIP ===== -->
        <div class="law-summary animate-in" style="animation-delay: 0.06s;">
            <div class="sum-card total">
                <span class="ic"><svg class="icon"><use href="#ic-history"/></svg></span>
                <div>
                    <div class="val">{{ $totalLogs }}</div>
                    <div class="lbl">Total Aktivitas</div>
                </div>
            </div>
            <div class="sum-card today">
                <span class="ic"><svg class="icon"><use href="#ic-activity"/></svg></span>
                <div>
                    <div class="val">{{ $todayLogs }}</div>
                    <div class="lbl">Hari Ini</div>
                </div>
            </div>
            <div class="sum-card deletes">
                <span class="ic"><svg class="icon"><use href="#ic-trash"/></svg></span>
                <div>
                    <div class="val">{{ $deleteLogs }}</div>
                    <div class="lbl">Aksi Hapus</div>
                </div>
            </div>
        </div>

        <!-- ===== TIMELINE ===== -->
        <div class="timeline-wrap animate-in" style="animation-delay: 0.1s;">
            @if($logs->isEmpty())
                <div class="log-empty">
                    <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                    <h3>Belum ada aktivitas</h3>
                    <p>Aktivitas admin akan tercatat dan muncul di sini secara otomatis.</p>
                </div>
            @else
                <div class="timeline">
                    @foreach($logs as $i => $log)
                        @php
                            $actionLower = strtolower($log->action);
                            $actClass = 'act-other';
                            $actIcon = 'ic-activity';
                            if (str_contains($actionLower, 'delete')) { $actClass = 'act-delete'; $actIcon = 'ic-trash'; }
                            elseif (str_contains($actionLower, 'create') || str_contains($actionLower, 'add')) { $actClass = 'act-create'; $actIcon = 'ic-plus'; }
                            elseif (str_contains($actionLower, 'update') || str_contains($actionLower, 'edit')) { $actClass = 'act-update'; $actIcon = 'ic-edit'; }
                            elseif (str_contains($actionLower, 'login') || str_contains($actionLower, 'logout')) { $actClass = 'act-login'; $actIcon = 'ic-login'; }
                            elseif (str_contains($actionLower, 'security') || str_contains($actionLower, 'password') || str_contains($actionLower, 'access')) { $actClass = 'act-security'; $actIcon = 'ic-shield'; }
                        @endphp
                        <div class="tl-item {{ $actClass }} animate-left" style="animation-delay: {{ 0.14 + ($i * 0.04) }}s;">
                            <div class="tl-dot"><svg class="icon"><use href="#{{ $actIcon }}"/></svg></div>
                            <div class="tl-content">
                                <div class="tl-main">
                                    <div class="tl-top">
                                        <span class="log-action">{{ str_replace('_', ' ', $log->action) }}</span>
                                        <span class="tl-admin">{{ $log->user->name ?? 'Sistem' }}</span>
                                    </div>
                                    <div class="tl-desc">{{ $log->description }}</div>
                                </div>
                                <div class="tl-right">
                                    <span class="tl-time">
                                        <svg class="icon"><use href="#ic-clock"/></svg>
                                        {{ $log->created_at->format('d M Y, H:i') }}
                                    </span>
                                    <span class="tl-ip">
                                        <svg class="icon"><use href="#ic-globe"/></svg>
                                        {{ $log->ip_address ?? '—' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="pagination-wrap">
            {{ $logs->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.law-btn');
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