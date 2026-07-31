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
        </defs>
    </svg>

    <style>
        .adash-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            color: var(--text);
        }
        .adash-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.5;} }
        @keyframes floatSlow{ 0%,100%{ transform:translateY(0);} 50%{ transform:translateY(-6px);} }
        .adash-wrap .animate-in{ animation:fadeSlideUp .55s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== HERO ===== */
        .adash-hero{
            position:relative; overflow:hidden;
            background:linear-gradient(135deg, rgba(var(--emerald-rgb),0.14), var(--surface) 65%);
            border:1px solid var(--border); border-radius:24px; padding:34px 40px; margin-bottom:18px;
        }
        .adash-hero::after{
            content:''; position:absolute; top:-40%; right:-10%; width:320px; height:320px; border-radius:50%;
            background:radial-gradient(circle, rgba(var(--emerald-rgb),0.18), transparent 70%);
            animation:floatSlow 6s ease-in-out infinite;
        }
        .adash-hero-inner{ position:relative; z-index:1; display:flex; justify-content:space-between; align-items:flex-end; gap:24px; flex-wrap:wrap; }
        .adash-badge{
            display:inline-flex; align-items:center; gap:8px; padding:6px 14px 6px 10px;
            background:var(--accent-glow); border:1px solid var(--accent-glow); border-radius:100px;
            font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:var(--accent);
            margin-bottom:14px;
        }
        .adash-badge .dot{ width:6px; height:6px; border-radius:50%; background:var(--accent); animation:pulseGlow 2s ease-in-out infinite; }
        .adash-badge .icon{ width:13px; height:13px; }
        .adash-hero h1{
            font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; margin:0 0 8px; letter-spacing:-.02em;
        }
        .adash-hero h1 span{
            background:linear-gradient(135deg, var(--text) 55%, var(--accent)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
        }
        .adash-hero p{ font-size:14px; color:var(--text-mute); margin:0; max-width:480px; }
        .adash-hero-time{ text-align:right; }
        .adash-hero-time .t{ font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:700; color:var(--text); }
        .adash-hero-time .d{ font-size:12px; color:var(--text-faint); margin-top:2px; }

        /* ===== QUICK STATS ===== */
        .stat-row{ display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:18px; }
        .stat-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:18px 20px; transition:all .25s ease; }
        .stat-card:hover{ transform:translateY(-3px); border-color:var(--border-hover); }
        .stat-card .sk{ display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
        .stat-card .sk-label{ font-size:11px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.05em; font-weight:600; }
        .stat-icon{ width:30px; height:30px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon .icon{ width:14px; height:14px; }
        .stat-card.c-emerald .stat-icon{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .stat-card.c-info .stat-icon{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .stat-card.c-neutral .stat-icon{ background:var(--surface-strong); color:var(--text-mute); }
        .stat-card .sv{ font-family:'Space Grotesk', sans-serif; font-size:24px; font-weight:700; color:var(--text); }

        /* ===== BENTO GRID ===== */
        .adash-bento{ display:grid; grid-template-columns:1.4fr 1fr; gap:16px; align-items:start; }

        .bento-grid{ display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .bento-card{
            background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px;
            transition:all .25s ease; position:relative; overflow:hidden; display:block; text-decoration:none; color:inherit;
        }
        .bento-card:hover{ transform:translateY(-3px); border-color:var(--border-hover); }

        .bento-card .bc-icon{ width:40px; height:40px; border-radius:11px; display:flex; align-items:center; justify-content:center; margin-bottom:14px; }
        .bento-card .bc-icon .icon{ width:18px; height:18px; }
        .bento-card.acc-emerald .bc-icon{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .bento-card.acc-info .bc-icon{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .bento-card.acc-neutral .bc-icon{ background:var(--surface-strong); color:var(--text-mute); }

        .bento-card h3{ font-family:'Space Grotesk', sans-serif; font-size:14.5px; margin-bottom:6px; display:flex; align-items:center; justify-content:space-between; gap:8px; }
        .bento-card h3 .go{ width:14px; height:14px; color:var(--text-faint); transition:transform .2s ease, color .2s ease; flex-shrink:0; }
        .bento-card:hover h3 .go{ transform:translateX(3px); color:var(--accent); }
        .bento-card p{ font-size:12px; color:var(--text-mute); line-height:1.5; margin:0; }

        /* Featured big card (Kelola User) — span 2 kolom */
        .bento-card.featured{
            grid-column: span 2;
            padding:26px; background:linear-gradient(135deg, rgba(var(--emerald-rgb),0.1), var(--surface) 60%);
            border-color:rgba(var(--emerald-rgb),0.25); display:flex; align-items:center; gap:20px;
        }
        .bento-card.featured .bc-icon{ width:52px; height:52px; border-radius:14px; margin-bottom:0; flex-shrink:0; }
        .bento-card.featured .bc-icon .icon{ width:24px; height:24px; }
        .bento-card.featured h3{ font-size:17px; }
        .bento-card.featured .bc-body{ flex:1; min-width:0; }

        @media (max-width:640px){
            .bento-grid{ grid-template-columns:1fr; }
            .bento-card.featured{ grid-column:span 1; flex-direction:column; align-items:flex-start; }
        }

        /* ===== SIDE PANEL: system status ===== */
        .side-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; margin-bottom:16px; }
        .side-panel-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
        .side-panel-head h3{ font-family:'Space Grotesk', sans-serif; font-size:14.5px; }
        .side-panel-head .live{ display:flex; align-items:center; gap:6px; font-size:11px; font-weight:600; color:var(--emerald); }
        .side-panel-head .live .dot{ width:6px; height:6px; border-radius:50%; background:var(--emerald); animation:pulseGlow 1.6s ease-in-out infinite; }

        .status-row{ display:flex; align-items:center; gap:10px; padding:10px 0; border-top:1px solid var(--border); }
        .status-row:first-of-type{ border-top:none; }
        .status-row .st-ic{ width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .status-row .st-ic .icon{ width:13px; height:13px; }
        .status-row.ok .st-ic{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .status-row .st-body{ flex:1; min-width:0; }
        .status-row .st-title{ font-size:12px; font-weight:600; color:var(--text); }
        .status-row .st-sub{ font-size:10.5px; color:var(--text-faint); margin-top:1px; }

        .profile-mini{ display:flex; align-items:center; gap:12px; margin-top:16px; padding-top:16px; border-top:1px dashed var(--border); }
        .profile-mini .avatar{
            width:38px; height:38px; border-radius:11px; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim));
            display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:13px; color:#1a1005; flex-shrink:0;
        }
        .profile-mini .info{ min-width:0; }
        .profile-mini .name{ font-size:12.5px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .profile-mini .role{ font-size:10.5px; color:var(--text-faint); }

        /* ===== ACTIVITY FEED ===== */
        .activity-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; }
        .activity-panel h3{ font-family:'Space Grotesk', sans-serif; font-size:14.5px; margin-bottom:16px; }
        .act-item{ display:flex; gap:10px; padding:10px 0; border-top:1px solid var(--border); }
        .act-item:first-child{ border-top:none; }
        .act-dot{ width:7px; height:7px; border-radius:50%; background:var(--emerald); margin-top:6px; flex-shrink:0; }
        .act-body{ min-width:0; }
        .act-desc{ font-size:12px; color:var(--text); line-height:1.5; }
        .act-meta{ font-size:10.5px; color:var(--text-faint); margin-top:2px; }
        .act-empty{ font-size:12px; color:var(--text-faint); text-align:center; padding:16px 0; }
        .act-more{ display:block; text-align:center; font-size:11.5px; color:var(--emerald); font-weight:600; margin-top:14px; }

        @media (max-width:1000px){
            .adash-bento{ grid-template-columns:1fr; }
            .stat-row{ grid-template-columns:1fr 1fr; }
        }
        @media (max-width:640px){
            .adash-hero{ padding:26px 22px; }
            .adash-hero-inner{ flex-direction:column; align-items:flex-start; }
            .adash-hero-time{ text-align:left; }
            .adash-hero h1{ font-size:22px; }
            .stat-row{ grid-template-columns:1fr; }
        }
    </style>

    <div class="adash-wrap">

        {{-- ===== HERO ===== --}}
        <div class="adash-hero animate-in" style="animation-delay:.05s;">
            <div class="adash-hero-inner">
                <div>
                    <div class="adash-badge"><svg class="icon"><use href="#ic-shield"/></svg> Admin Sistem</div>
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
            </div>
            <div class="stat-card c-info animate-in" style="animation-delay:.12s;">
                <div class="sk">
                    <span class="sk-label">Total Company</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-building"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total_companies'] ?? 0 }}</div>
            </div>
            <div class="stat-card c-neutral animate-in" style="animation-delay:.16s;">
                <div class="sk">
                    <span class="sk-label">Admin Aktif</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-shield"/></svg></span>
                </div>
                <div class="sv">{{ $stats['total_admins'] ?? 0 }}</div>
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

                <a href="{{ route('admin.activity.index') }}" class="bento-card acc-neutral animate-in" style="animation-delay:.32s;">
                    <div class="bc-icon"><svg class="icon"><use href="#ic-a-history"/></svg></div>
                    <h3>Log Aktivitas <svg class="icon go"><use href="#ic-arrow-right"/></svg></h3>
                    <p>Riwayat semua aksi admin di sistem.</p>
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
                    <a href="{{ route('admin.activity.index') }}" class="act-more">Lihat semua log →</a>
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