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
        </defs>
    </svg>

    <style>
        .law{ --accent: var(--emerald); color:var(--text); }
        .law *{ box-sizing:border-box; }
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes fadeSlideLeft{ from{ opacity:0; transform:translateX(-16px);} to{ opacity:1; transform:translateX(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.5;} }
        @keyframes drawLine{ from{ transform:scaleY(0);} to{ transform:scaleY(1);} }
        .law .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) backwards; }
        .law .animate-left{ animation:fadeSlideLeft .45s cubic-bezier(.16,1,.3,1) backwards; }

        .law-head{ margin-bottom:22px; }
        .law-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .law-head p{ font-size:13.5px; color:var(--text-mute); }

        /* ===== SUMMARY STRIP ===== */
        .law-summary{ display:flex; gap:12px; margin-bottom:24px; flex-wrap:wrap; }
        .sum-card{ display:flex; align-items:center; gap:12px; background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:14px 20px; flex:1; min-width:160px; transition:all .2s ease; }
        .sum-card:hover{ transform:translateY(-2px); border-color:var(--border-hover); }
        .sum-card .ic{ width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .sum-card .ic svg{ width:17px; height:17px; }
        .sum-card.total .ic{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .sum-card.today .ic{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .sum-card.deletes .ic{ background:rgba(232,90,90,.14); color:var(--danger); }
        .sum-card .val{ font-family:'Space Grotesk',sans-serif; font-size:19px; font-weight:700; }
        .sum-card .lbl{ font-size:11px; color:var(--text-faint); }

        /* ===== TIMELINE ===== */
        .timeline-wrap{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:8px 28px 28px; }
        .timeline{ position:relative; padding-left:34px; }
        .timeline::before{
            content:''; position:absolute; left:13px; top:6px; bottom:6px; width:2px; background:var(--border);
            transform-origin:top; animation:drawLine .8s cubic-bezier(.16,1,.3,1) forwards;
        }

        .tl-item{ position:relative; padding:22px 0; border-bottom:1px dashed var(--border); }
        .tl-item:last-child{ border-bottom:none; }
        .tl-dot{
            position:absolute; left:-34px; top:26px; width:28px; height:28px; border-radius:50%;
            display:flex; align-items:center; justify-content:center; border:3px solid var(--bg); z-index:2;
        }
        .tl-dot svg{ width:13px; height:13px; }
        .tl-item.act-update .tl-dot{ background:rgba(78,143,240,.18); color:#4E8FF0; }
        .tl-item.act-create .tl-dot{ background:rgba(var(--emerald-rgb),.18); color:var(--emerald); }
        .tl-item.act-delete .tl-dot{ background:rgba(232,90,90,.18); color:var(--danger); }
        .tl-item.act-login .tl-dot{ background:rgba(155,123,224,.18); color:#9B7BE0; }
        .tl-item.act-security .tl-dot{ background:rgba(240,162,90,.18); color:#F0A25A; }
        .tl-item.act-other .tl-dot{ background:var(--surface-strong); color:var(--text-mute); }

        .tl-content{ display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap; }
        .tl-main{ flex:1; min-width:260px; }
        .tl-top{ display:flex; align-items:center; gap:9px; flex-wrap:wrap; margin-bottom:6px; }
        .log-action{
            display:inline-flex; align-items:center; gap:5px; font-size:10.5px; font-weight:700; padding:3px 10px;
            border-radius:100px; text-transform:uppercase; letter-spacing:.03em;
        }
        .tl-item.act-update .log-action{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .tl-item.act-create .log-action{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .tl-item.act-delete .log-action{ background:rgba(232,90,90,.14); color:var(--danger); }
        .tl-item.act-login .log-action{ background:rgba(155,123,224,.14); color:#9B7BE0; }
        .tl-item.act-security .log-action{ background:rgba(240,162,90,.14); color:#F0A25A; }
        .tl-item.act-other .log-action{ background:var(--surface-strong); color:var(--text-mute); }

        .tl-admin{ font-size:12px; font-weight:600; color:var(--text); }
        .tl-desc{ font-size:13.5px; color:var(--text); line-height:1.55; }

        .tl-right{ display:flex; flex-direction:column; align-items:flex-end; gap:5px; flex-shrink:0; }
        .tl-time{ font-size:12px; color:var(--text-faint); white-space:nowrap; }
        .tl-ip{ display:flex; align-items:center; gap:5px; font-size:11px; color:var(--text-faint); font-family:'IBM Plex Mono',monospace; }
        .tl-ip svg{ width:11px; height:11px; }

        /* newest item pulses briefly to draw attention */
        .tl-item:first-child .tl-dot{ animation:pulseGlow 1.8s ease-in-out infinite; }

        .log-empty{ text-align:center; padding:60px 20px; }
        .empty-ic{ width:56px; height:56px; border-radius:16px; background:rgba(var(--emerald-rgb),.12); border:1px solid rgba(var(--emerald-rgb),.25); display:flex; align-items:center; justify-content:center; color:var(--emerald); margin:0 auto 16px; }
        .empty-ic svg{ width:24px; height:24px; }
        .log-empty h3{ font-family:'Space Grotesk',sans-serif; font-size:16px; margin-bottom:4px; color:var(--text); }
        .log-empty p{ font-size:13px; color:var(--text-mute); }

        .pagination-wrap{ margin-top:20px; }

        @media (max-width:640px){
            .tl-content{ flex-direction:column; }
            .tl-right{ align-items:flex-start; flex-direction:row; gap:12px; }
        }
    </style>

    <div class="law">
        <div class="law-head animate-in" style="animation-delay:.03s;">
            <h1>Log Aktivitas</h1>
            <p>Riwayat semua aksi yang dilakukan admin di sistem — perubahan access level, penghapusan user, dan lain-lain.</p>
        </div>

        @php
            $totalLogs = $logs->total();
            $todayLogs = $logs->getCollection()->filter(fn($l) => $l->created_at->isToday())->count();
            $deleteLogs = $logs->getCollection()->filter(fn($l) => str_contains(strtolower($l->action), 'delete'))->count();
        @endphp

        <div class="law-summary animate-in" style="animation-delay:.06s;">
            <div class="sum-card total">
                <span class="ic"><svg><use href="#ic-history"/></svg></span>
                <div><div class="val">{{ $totalLogs }}</div><div class="lbl">Total Aktivitas</div></div>
            </div>
            <div class="sum-card today">
                <span class="ic"><svg><use href="#ic-activity"/></svg></span>
                <div><div class="val">{{ $todayLogs }}</div><div class="lbl">Hari Ini</div></div>
            </div>
            <div class="sum-card deletes">
                <span class="ic"><svg><use href="#ic-trash"/></svg></span>
                <div><div class="val">{{ $deleteLogs }}</div><div class="lbl">Aksi Hapus (halaman ini)</div></div>
            </div>
        </div>

        <div class="timeline-wrap animate-in" style="animation-delay:.1s;">
            @if($logs->isEmpty())
                <div class="log-empty">
                    <div class="empty-ic"><svg><use href="#ic-inbox"/></svg></div>
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
                        <div class="tl-item {{ $actClass }} animate-left" style="animation-delay:{{ .14 + ($i * .04) }}s;">
                            <div class="tl-dot"><svg><use href="#{{ $actIcon }}"/></svg></div>
                            <div class="tl-content">
                                <div class="tl-main">
                                    <div class="tl-top">
                                        <span class="log-action">{{ str_replace('_', ' ', $log->action) }}</span>
                                        <span class="tl-admin">{{ $log->user->name ?? 'Sistem' }}</span>
                                    </div>
                                    <div class="tl-desc">{{ $log->description }}</div>
                                </div>
                                <div class="tl-right">
                                    <span class="tl-time">{{ $log->created_at->format('d M Y, H:i') }}</span>
                                    <span class="tl-ip"><svg><use href="#ic-globe"/></svg> {{ $log->ip_address ?? '—' }}</span>
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
</x-admin-layout>