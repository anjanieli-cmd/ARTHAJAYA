<x-admin-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 12 8 12 10 6 14 18 16 12 21 12"/>
            </symbol>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-a-history" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
            </symbol>
            <symbol id="ic-a-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/>
            </symbol>
            <symbol id="ic-gear" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </symbol>
            <symbol id="ic-a-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 11v2a1 1 0 0 0 1 1h2.5l4 3V8l-4 3H4a1 1 0 0 0-1 1z"/><path d="M18 8c2 0 4 1.5 4 4s-2 4-4 4"/><path d="M14 8v8"/>
            </symbol>
            <symbol id="ic-a-help" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-a-server" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .adash-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            color: var(--text);
            max-width: 100%;
            padding: 0 4px;
        }
        .adash-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.45;} }
        @keyframes floatSlow{ 0%,100%{ transform:translateY(0);} 50%{ transform:translateY(-8px);} }
        @keyframes ringSweep{ from{ stroke-dashoffset:113; } to{ stroke-dashoffset:0; } }

        .adash-wrap .animate-in{ animation:fadeSlideUp .6s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        @media (prefers-reduced-motion: reduce){
            .adash-wrap .animate-in{ animation:none; opacity:1; }
            .adash-hero::before, .adash-hero::after{ animation:none !important; }
        }

        /* ===== HERO ===== */
        .adash-hero{
            position:relative; overflow:hidden;
            background:linear-gradient(150deg, rgba(var(--emerald-rgb),0.13), var(--surface) 65%);
            border:1px solid var(--border); border-radius:24px; padding:36px 42px; margin-bottom:22px;
            backdrop-filter:blur(10px);
            box-shadow: 0 4px 28px rgba(0,0,0,0.07);
            background-image:
                radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(150deg, rgba(var(--emerald-rgb),0.13), var(--surface) 65%);
            background-size: 18px 18px, 100% 100%;
        }
        .adash-hero::before{
            content:''; position:absolute; top:-55%; right:-15%; width:420px; height:420px; border-radius:50%;
            background:radial-gradient(circle, rgba(var(--emerald-rgb),0.16), transparent 70%);
            animation:floatSlow 9s ease-in-out infinite;
        }
        .adash-hero::after{
            content:''; position:absolute; bottom:-45%; left:-8%; width:280px; height:280px; border-radius:50%;
            background:radial-gradient(circle, rgba(var(--emerald-rgb),0.09), transparent 70%);
            animation:floatSlow 11s ease-in-out infinite reverse;
        }
        .adash-hero-inner{ position:relative; z-index:1; display:flex; justify-content:space-between; align-items:flex-end; gap:24px; flex-wrap:wrap; }
        .adash-badge{
            display:inline-flex; align-items:center; gap:8px; padding:6px 16px 6px 12px;
            background:var(--accent-soft); border:1px solid var(--accent-glow); border-radius:100px;
            font-size:11px; font-weight:700; letter-spacing:.07em; text-transform:uppercase; color:var(--accent);
            margin-bottom:16px;
            backdrop-filter:blur(4px);
        }
        .adash-badge .dot{ width:6px; height:6px; border-radius:50%; background:var(--accent); animation:pulseGlow 2s ease-in-out infinite; flex-shrink:0; }
        .adash-badge .icon{ width:13px; height:13px; }
        .adash-hero h1{
            font-family:'Space Grotesk', sans-serif; font-size:32px; font-weight:700; margin:0 0 9px; letter-spacing:-.02em; line-height:1.15;
        }
        .adash-hero h1 span{
            background:linear-gradient(135deg, var(--text) 45%, var(--accent)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
        }
        .adash-hero p{ font-size:14px; color:var(--text-mute); margin:0; max-width:520px; line-height:1.65; }
        .adash-hero-time{ text-align:right; padding:4px 0; }
        .adash-hero-time .t{ font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; color:var(--text); letter-spacing:.02em; font-variant-numeric:tabular-nums; }
        .adash-hero-time .d{ font-size:12.5px; color:var(--text-faint); margin-top:5px; font-weight:500; }

        /* ===== QUICK STATS ===== */
        .stat-row{ display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:22px; }
        .stat-card{
            background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px 24px;
            transition:transform .3s cubic-bezier(.16,1,.3,1), border-color .3s ease, box-shadow .3s ease;
            position:relative; overflow:hidden;
        }
        .stat-card::before{
            content:''; position:absolute; top:0; left:0; right:0; height:2px;
            background:linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity:0; transition:opacity .3s ease;
        }
        .stat-card:hover{
            transform:translateY(-4px);
            border-color:var(--border-hover);
            box-shadow:0 14px 40px rgba(0,0,0,0.09);
        }
        .stat-card:hover::before{ opacity:1; }

        .stat-card .sk{ display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .stat-card .sk-label{ font-size:11px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.07em; font-weight:700; }
        .stat-icon{
            width:36px; height:36px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
            transition:transform .3s cubic-bezier(.34,1.56,.64,1);
        }
        .stat-card:hover .stat-icon{ transform:scale(1.08) rotate(-4deg); }
        .stat-icon .icon{ width:16px; height:16px; }
        .stat-card.c-emerald .stat-icon{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .stat-card.c-info .stat-icon{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .stat-card.c-neutral .stat-icon{ background:var(--surface-strong); color:var(--text-mute); }
        .stat-card .sv{ font-family:'Space Grotesk', sans-serif; font-size:30px; font-weight:700; color:var(--text); letter-spacing:-.02em; line-height:1; }
        .stat-card .sv-sub{ font-size:12px; color:var(--text-faint); margin-top:7px; font-weight:400; }

        /* ===== BENTO GRID ===== */
        .adash-bento{ display:grid; grid-template-columns:1.5fr 1fr; gap:20px; align-items:start; }

        .bento-grid{ display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .bento-card{
            background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:24px;
            transition:transform .3s cubic-bezier(.16,1,.3,1), border-color .3s ease, box-shadow .3s ease;
            position:relative; overflow:hidden; display:block; text-decoration:none; color:inherit;
            cursor:pointer;
        }
        .bento-card::after{
            content:''; position:absolute; inset:0; background:linear-gradient(180deg, transparent, rgba(var(--emerald-rgb),0.03));
            opacity:0; transition:opacity .3s ease; pointer-events:none;
        }
        .bento-card:hover{
            transform:translateY(-4px);
            border-color:var(--border-hover);
            box-shadow:0 14px 40px rgba(0,0,0,0.09);
        }
        .bento-card:hover::after{ opacity:1; }

        .bento-card .bc-icon{
            width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:16px;
            transition:transform .3s cubic-bezier(.34,1.56,.64,1);
        }
        .bento-card:hover .bc-icon{ transform:scale(1.08); }
        .bento-card .bc-icon .icon{ width:20px; height:20px; }
        .bento-card.acc-emerald .bc-icon{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .bento-card.acc-info .bc-icon{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .bento-card.acc-neutral .bc-icon{ background:var(--surface-strong); color:var(--text-mute); }

        .bento-card h3{
            font-family:'Space Grotesk', sans-serif; font-size:15px; font-weight:600; margin-bottom:7px;
            display:flex; align-items:center; justify-content:space-between; gap:8px;
        }
        .bento-card h3 .go{
            width:16px; height:16px; color:var(--text-faint); transition:transform .3s ease, color .3s ease; flex-shrink:0;
        }
        .bento-card:hover h3 .go{ transform:translateX(4px); color:var(--accent); }
        .bento-card p{ font-size:12.5px; color:var(--text-mute); line-height:1.65; margin:0; }

        /* Featured big card */
        .bento-card.featured{
            grid-column: span 2;
            padding:28px 32px;
            background:linear-gradient(150deg, rgba(var(--emerald-rgb),0.09), var(--surface) 60%);
            border-color:rgba(var(--emerald-rgb),0.22);
            display:flex; align-items:center; gap:24px;
        }
        .bento-card.featured .bc-icon{
            width:58px; height:58px; border-radius:16px; margin-bottom:0; flex-shrink:0;
        }
        .bento-card.featured .bc-icon .icon{ width:26px; height:26px; }
        .bento-card.featured h3{ font-size:18px; }
        .bento-card.featured .bc-body{ flex:1; min-width:0; }

        @media (max-width:640px){
            .bento-grid{ grid-template-columns:1fr; }
            .bento-card.featured{ grid-column:span 1; flex-direction:column; align-items:flex-start; padding:22px; }
        }

        /* ===== SIDE PANEL ===== */
        .side-panel{
            background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px;
            margin-bottom:18px; transition:border-color .3s ease, box-shadow .3s ease;
        }
        .side-panel:hover{ border-color:var(--border-hover); box-shadow:0 10px 30px rgba(0,0,0,0.06); }
        .side-panel-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
        .side-panel-head h3{ font-family:'Space Grotesk', sans-serif; font-size:15px; font-weight:600; }
        .side-panel-head .live{ display:flex; align-items:center; gap:6px; font-size:11px; font-weight:700; color:var(--emerald); text-transform:uppercase; letter-spacing:.04em; }
        .side-panel-head .live .dot{ width:7px; height:7px; border-radius:50%; background:var(--emerald); animation:pulseGlow 1.6s ease-in-out infinite; }

        .status-row{ display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid var(--border); }
        .status-row:last-of-type{ border-bottom:none; }
        .status-row .st-ic{
            width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .status-row .st-ic .icon{ width:14px; height:14px; }
        .status-row.ok .st-ic{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .status-row .st-body{ flex:1; min-width:0; }
        .status-row .st-title{ font-size:12.5px; font-weight:600; color:var(--text); }
        .status-row .st-sub{ font-size:11px; color:var(--text-faint); margin-top:2px; }

        .profile-mini{
            display:flex; align-items:center; gap:14px; margin-top:18px; padding-top:18px;
            border-top:1px dashed var(--border);
        }
        .profile-mini .avatar{
            width:42px; height:42px; border-radius:12px;
            background:linear-gradient(135deg, var(--emerald), var(--emerald-dim));
            display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk'; font-weight:700; font-size:15px; color:#0a1a12; flex-shrink:0;
            box-shadow:0 4px 14px rgba(var(--emerald-rgb),0.35);
        }
        .profile-mini .info{ min-width:0; }
        .profile-mini .name{ font-size:13px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .profile-mini .role{ font-size:11px; color:var(--text-faint); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

        /* ===== ACTIVITY FEED ===== */
        .activity-panel{
            background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px;
            transition:border-color .3s ease, box-shadow .3s ease;
        }
        .activity-panel:hover{ border-color:var(--border-hover); box-shadow:0 10px 30px rgba(0,0,0,0.06); }
        .activity-panel h3{ font-family:'Space Grotesk', sans-serif; font-size:15px; font-weight:600; margin-bottom:16px; }
        .act-item{ display:flex; gap:12px; padding:12px 0; border-bottom:1px solid var(--border); position:relative; }
        .act-item:last-child{ border-bottom:none; padding-bottom:0; }
        .act-item:first-child{ padding-top:0; }
        .act-dot{
            width:8px; height:8px; border-radius:50%; background:var(--emerald); margin-top:5px; flex-shrink:0;
            box-shadow:0 0 0 3px rgba(var(--emerald-rgb),0.15);
        }
        .act-body{ min-width:0; }
        .act-desc{ font-size:12.5px; color:var(--text); line-height:1.55; }
        .act-meta{ font-size:10.5px; color:var(--text-faint); margin-top:3px; }
        .act-empty{ font-size:12.5px; color:var(--text-faint); text-align:center; padding:24px 0; }
        .act-more{
            display:flex; align-items:center; justify-content:center; gap:6px; text-align:center; font-size:12px; color:var(--emerald); font-weight:600;
            margin-top:16px; padding:9px 0; border-radius:10px; transition:background .2s ease, gap .2s ease;
            text-decoration:none;
        }
        .act-more:hover{ background:var(--accent-soft); gap:9px; }
        .act-more .icon{ width:13px; height:13px; }

        @media (max-width:1000px){
            .adash-bento{ grid-template-columns:1fr; }
            .stat-row{ grid-template-columns:1fr 1fr; }
        }
        @media (max-width:640px){
            .adash-hero{ padding:26px 20px; }
            .adash-hero-inner{ flex-direction:column; align-items:flex-start; }
            .adash-hero-time{ text-align:left; width:100%; }
            .adash-hero-time .t{ font-size:22px; }
            .adash-hero h1{ font-size:25px; }
            .stat-row{ grid-template-columns:1fr; }
            .stat-card{ padding:18px 20px; }
            .stat-card .sv{ font-size:24px; }
            .side-panel, .activity-panel{ padding:20px; }
        }
        @media (max-width:400px){
            .adash-hero h1{ font-size:21px; }
            .adash-hero p{ font-size:13px; }
            .bento-card{ padding:18px; }
            .bento-card.featured{ padding:18px; }
            .bento-card h3{ font-size:13.5px; }
        }
    </style>

    <div class="adash-wrap">

        {{-- ===== HERO ===== --}}
        <div class="adash-hero animate-in" style="animation-delay:.05s;">
            <div class="adash-hero-inner">
                <div>
                    <div class="adash-badge">
                        <span class="dot"></span>
                        <svg class="icon"><use href="#ic-shield"/></svg>
                        Admin Sistem
                    </div>
                    <h1>Halo, <span>{{ $user->name }}</span></h1>
                    <p>Panel admin sistem Arvessa — terpisah dari dashboard perusahaan biasa. Kelola akses dan pantau kondisi sistem dari sini.</p>
                </div>
                <div class="adash-hero-time">
                    <div class="t" id="adashClock">--:--</div>
                    <div class="d" id="adashDate">—</div>
                </div>
            </div>
        </div>

        {{-- ===== QUICK STATS ===== --}}
        <div class="stat-row">
            <div class="stat-card c-emerald animate-in" style="animation-delay:.08s;">
                <div class="sk">
                    <span class="sk-label">Total User</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-users"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="sv-sub">Seluruh pengguna terdaftar</div>
            </div>
            <div class="stat-card c-info animate-in" style="animation-delay:.12s;">
                <div class="sk">
                    <span class="sk-label">Total Company</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-building"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total_companies'] ?? 0 }}</div>
                <div class="sv-sub">Perusahaan terdaftar</div>
            </div>
            <div class="stat-card c-neutral animate-in" style="animation-delay:.16s;">
                <div class="sk">
                    <span class="sk-label">Admin Aktif</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-shield"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total_admins'] ?? 0 }}</div>
                <div class="sv-sub">Tim admin sistem</div>
            </div>
        </div>

        {{-- ===== BENTO GRID ===== --}}
        <div class="adash-bento">

            {{-- KIRI: semua fitur --}}
            <div class="bento-grid">

                <a href="{{ route('admin.users.index') }}" class="bento-card featured acc-emerald animate-in" style="animation-delay:.20s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-users"/></svg></div>
                    <div class="bc-body">
                        <h3>Kelola User <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                        <p>Atur access level (admin / staff / user), lihat detail perusahaan tiap akun, dan kelola akses mereka.</p>
                    </div>
                </a>

                <a href="{{ route('admin.companies.index') }}" class="bento-card acc-info animate-in" style="animation-delay:.24s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-building"/></svg></div>
                    <h3>Kelola Company <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                    <p>Daftar semua perusahaan terdaftar beserta status langganannya.</p>
                </a>

                <a href="{{ route('admin.stats.index') }}" class="bento-card acc-info animate-in" style="animation-delay:.28s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-activity"/></svg></div>
                    <h3>Statistik Sistem <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                    <p>Ringkasan penggunaan aplikasi secara keseluruhan.</p>
                </a>

                <a href="{{ route('admin.subscription-plans.index') }}" class="bento-card acc-emerald animate-in" style="animation-delay:.36s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-a-card"/></svg></div>
                    <h3>Kelola Langganan <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                    <p>Atur paket langganan untuk perusahaan pengguna.</p>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="bento-card acc-neutral animate-in" style="animation-delay:.40s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-gear"/></svg></div>
                    <h3>Pengaturan Sistem <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                    <p>Konfigurasi umum untuk seluruh platform.</p>
                </a>

                <a href="{{ route('admin.announcements.index') }}" class="bento-card acc-info animate-in" style="animation-delay:.44s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-a-megaphone"/></svg></div>
                    <h3>Broadcast Pengumuman <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                    <p>Kirim pengumuman yang tercatat riwayatnya.</p>
                </a>

                <a href="#" class="bento-card acc-neutral animate-in" style="animation-delay:.48s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-a-help"/></svg></div>
                    <h3>Support / Tiket <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                    <p>Kelola tiket bantuan yang masuk dari pengguna.</p>
                </a>

            </div>

            {{-- KANAN: status + aktivitas terbaru --}}
            <div>
                <div class="side-panel animate-in" style="animation-delay:.15s;">
                    <div class="side-panel-head">
                        <h3>Status Sistem</h3>
                        <span class="live"><span class="dot"></span> Live</span>
                    </div>

                    <div class="status-row ok">
                        <div class="st-ic"><svg class="icon"><use href="#ic-check-circle"/></svg></div>
                        <div class="st-body">
                            <div class="st-title">Aplikasi Berjalan Normal</div>
                            <div class="st-sub">Semua layanan aktif</div>
                        </div>
                    </div>
                    <div class="status-row ok">
                        <div class="st-ic"><svg class="icon"><use href="#ic-lock"/></svg></div>
                        <div class="st-body">
                            <div class="st-title">Sesi Login Aman</div>
                            <div class="st-sub">Terautentikasi sebagai admin</div>
                        </div>
                    </div>
                    <div class="status-row ok">
                        <div class="st-ic"><svg class="icon"><use href="#ic-clock"/></svg></div>
                        <div class="st-body">
                            <div class="st-title">Login Terakhir</div>
                            <div class="st-sub">{{ now()->translatedFormat('d M Y, H:i') }} WIB</div>
                        </div>
                    </div>

                    <div class="profile-mini">
                        <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <div class="info">
                            <div class="name">{{ $user->name }}</div>
                            <div class="role">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="activity-panel animate-in" style="animation-delay:.22s;">
                    <h3>Aktivitas Terbaru</h3>
                    @forelse(($stats['recent_activity'] ?? []) as $log)
                        <div class="act-item">
                            <div class="act-dot"></div>
                            <div class="act-body">
                                <div class="act-desc">{{ $log->description }}</div>
                                <div class="act-meta">{{ $log->user->name ?? 'Sistem' }} &middot; {{ $log->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="act-empty">Belum ada aktivitas tercatat.</div>
                    @endforelse
                    <a href="{{ route('admin.activity.index') }}" class="act-more">Lihat semua log <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
                </div>
            </div>

        </div>
    </div>

    <script>
        // ===== live clock =====
        function updateAdashClock(){
            var now = new Date();
            var h = String(now.getHours()).padStart(2,'0');
            var m = String(now.getMinutes()).padStart(2,'0');
            var clockEl = document.getElementById('adashClock');
            var dateEl = document.getElementById('adashDate');
            if(clockEl) clockEl.textContent = h + ':' + m;
            if(dateEl){
                var days = ['Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu'];
                var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                dateEl.textContent = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
            }
        }
        updateAdashClock();
        setInterval(updateAdashClock, 1000 * 30);
    </script>
</x-admin-layout>