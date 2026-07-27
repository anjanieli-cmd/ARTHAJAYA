<x-admin-layout>
    <x-slot name="title">Statistik Sistem</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6M9 11h6M9 15h3"/>
            </symbol>
            <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </symbol>
            <symbol id="ic-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .stw{ --accent: var(--emerald); color:var(--text); }
        .stw *{ box-sizing:border-box; }
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(16px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes growBar{ from{ height:0; } }
        .stw .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        .stw-head{ margin-bottom:24px; }
        .stw-head h1{ font-family:'Space Grotesk', sans-serif; font-size:26px; margin-bottom:6px; }
        .stw-head p{ font-size:13.5px; color:var(--text-mute); }

        /* ===== TOP METRIC ROW (horizontal, angka besar) ===== */
        .metric-row{ display:grid; grid-template-columns:repeat(5,1fr); gap:1px; background:var(--border); border:1px solid var(--border); border-radius:18px; overflow:hidden; margin-bottom:22px; }
        .metric-cell{ background:var(--surface); padding:22px 18px; text-align:center; }
        .metric-cell .n{ font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:700; color:var(--emerald); }
        .metric-cell .l{ font-size:11px; color:var(--text-faint); margin-top:6px; text-transform:uppercase; letter-spacing:.04em; }

        /* ===== CHART PANEL ===== */
        .stw-grid{ display:grid; grid-template-columns:1.2fr 1fr; gap:16px; margin-bottom:16px; align-items:start; }
        .chart-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; }
        .chart-panel h3{ font-family:'Space Grotesk', sans-serif; font-size:15px; margin-bottom:20px; }

        .bar-chart{ display:flex; align-items:flex-end; gap:12px; height:140px; padding-bottom:8px; border-bottom:1px solid var(--border); }
        .bar-col{ flex:1; display:flex; flex-direction:column; align-items:center; gap:8px; height:100%; justify-content:flex-end; }
        .bar-fill{ width:100%; max-width:36px; border-radius:6px 6px 0 0; background:linear-gradient(180deg,var(--emerald),var(--emerald-dim)); animation:growBar .8s cubic-bezier(.16,1,.3,1); position:relative; }
        .bar-fill .bv{ position:absolute; top:-20px; left:50%; transform:translateX(-50%); font-size:11px; font-weight:700; color:var(--text); }
        .bar-lbl{ font-size:10.5px; color:var(--text-faint); margin-top:8px; text-align:center; }

        /* ===== ACCESS LEVEL DONUT-ish (bar) ===== */
        .level-bars{ display:flex; flex-direction:column; gap:14px; }
        .level-row .lr-top{ display:flex; justify-content:space-between; font-size:12.5px; margin-bottom:6px; }
        .level-row .lr-top .name{ font-weight:600; }
        .level-row .lr-track{ height:9px; border-radius:100px; background:var(--surface-strong); overflow:hidden; }
        .level-row .lr-fill{ height:100%; border-radius:100px; transition:width 1s cubic-bezier(.16,1,.3,1); width:0; }
        .level-row.admin .lr-fill{ background:var(--emerald); }
        .level-row.staff .lr-fill{ background:#4E8FF0; }
        .level-row.user .lr-fill{ background:var(--text-faint); }

        /* ===== TOP COMPANIES LIST ===== */
        .top-list{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; }
        .top-list h3{ font-family:'Space Grotesk', sans-serif; font-size:15px; margin-bottom:16px; }
        .top-row{ display:flex; align-items:center; gap:12px; padding:11px 0; border-top:1px solid var(--border); }
        .top-row:first-child{ border-top:none; }
        .top-rank{ width:24px; height:24px; border-radius:7px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:var(--text-mute); flex-shrink:0; }
        .top-name{ flex:1; font-size:12.5px; font-weight:600; }
        .top-count{ font-family:'IBM Plex Mono', monospace; font-size:12px; color:var(--emerald); font-weight:600; }

        @media (max-width:1100px){ .metric-row{ grid-template-columns:repeat(2,1fr); } }
        @media (max-width:900px){ .stw-grid{ grid-template-columns:1fr; } }
    </style>

    <div class="stw">
        <div class="stw-head animate-in" style="animation-delay:.05s;">
            <h1>Statistik Sistem</h1>
            <p>Ringkasan penggunaan aplikasi Arvessa secara keseluruhan, lintas semua company.</p>
        </div>

        <div class="metric-row animate-in" style="animation-delay:.08s;">
            <div class="metric-cell"><div class="n">{{ $totalCompanies }}</div><div class="l">Company</div></div>
            <div class="metric-cell"><div class="n">{{ $activeCompanies }}</div><div class="l">Company Aktif</div></div>
            <div class="metric-cell"><div class="n">{{ $totalUsers }}</div><div class="l">User</div></div>
            <div class="metric-cell"><div class="n">{{ $totalClients }}</div><div class="l">Klien</div></div>
            <div class="metric-cell"><div class="n">{{ $totalInvoices }}</div><div class="l">Faktur</div></div>
        </div>

        <div class="stw-grid">
            <div class="chart-panel animate-in" style="animation-delay:.14s;">
                <h3>Pertumbuhan Company (6 Bulan Terakhir)</h3>
                <div class="bar-chart">
                    @foreach($companyGrowth as $g)
                        <div class="bar-col">
                            <div class="bar-fill" style="height:{{ $g['count'] > 0 ? max(8, ($g['count']/$maxCompanyGrowth)*100) : 4 }}%;">
                                @if($g['count'] > 0)<span class="bv">{{ $g['count'] }}</span>@endif
                            </div>
                            <div class="bar-lbl">{{ $g['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="chart-panel animate-in" style="animation-delay:.18s;">
                <h3>Distribusi Access Level</h3>
                <div class="level-bars" id="levelBars">
                    @php $totalLevel = max(1, array_sum($usersByLevel)); @endphp
                    <div class="level-row admin">
                        <div class="lr-top"><span class="name">Admin</span><span>{{ $usersByLevel['admin'] }}</span></div>
                        <div class="lr-track"><div class="lr-fill" data-w="{{ ($usersByLevel['admin']/$totalLevel)*100 }}%"></div></div>
                    </div>
                    <div class="level-row staff">
                        <div class="lr-top"><span class="name">Staff</span><span>{{ $usersByLevel['staff'] }}</span></div>
                        <div class="lr-track"><div class="lr-fill" data-w="{{ ($usersByLevel['staff']/$totalLevel)*100 }}%"></div></div>
                    </div>
                    <div class="level-row user">
                        <div class="lr-top"><span class="name">User</span><span>{{ $usersByLevel['user'] }}</span></div>
                        <div class="lr-track"><div class="lr-fill" data-w="{{ ($usersByLevel['user']/$totalLevel)*100 }}%"></div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stw-grid">
            <div class="chart-panel animate-in" style="animation-delay:.22s;">
                <h3>Pertumbuhan User (6 Bulan Terakhir)</h3>
                <div class="bar-chart">
                    @foreach($userGrowth as $g)
                        <div class="bar-col">
                            <div class="bar-fill" style="height:{{ $g['count'] > 0 ? max(8, ($g['count']/$maxUserGrowth)*100) : 4 }}%; background:linear-gradient(180deg,#4E8FF0,#3465C4);">
                                @if($g['count'] > 0)<span class="bv">{{ $g['count'] }}</span>@endif
                            </div>
                            <div class="bar-lbl">{{ $g['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="top-list animate-in" style="animation-delay:.26s;">
                <h3>Top 5 Company (Berdasarkan Faktur)</h3>
                @forelse($topCompanies as $i => $c)
                    <div class="top-row">
                        <div class="top-rank">{{ $i + 1 }}</div>
                        <div class="top-name">{{ $c->name }}</div>
                        <div class="top-count">{{ $c->invoices_count }} faktur</div>
                    </div>
                @empty
                    <div style="font-size:12.5px; color:var(--text-faint);">Belum ada data.</div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            setTimeout(function(){
                document.querySelectorAll('.lr-fill').forEach(function(el){
                    el.style.width = el.getAttribute('data-w');
                });
            }, 150);
        });
    </script>
</x-admin-layout>