<x-admin-layout>
    <x-slot name="title">Kelola Company</x-slot>

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
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-pause-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cmw{ --accent: var(--emerald); --accent-dim: var(--emerald-dim); color:var(--text); }
        .cmw *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(16px) scale(.98);} to{ opacity:1; transform:translateY(0) scale(1);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.5;} }
        .cmw .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        .cmw-header{ display:flex; justify-content:space-between; align-items:flex-end; gap:20px; flex-wrap:wrap; margin-bottom:24px; }
        .cmw-header h1{ font-family:'Space Grotesk', sans-serif; font-size:26px; margin-bottom:6px; }
        .cmw-header p{ font-size:13.5px; color:var(--text-mute); }

        /* ===== SUMMARY PILLS (bukan card kotak, tapi pill horizontal) ===== */
        .summary-pills{ display:flex; gap:12px; flex-wrap:wrap; margin-bottom:24px; }
        .s-pill{ display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:100px; padding:10px 18px 10px 10px; }
        .s-pill .ic{ width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .s-pill .ic .icon{ width:15px; height:15px; }
        .s-pill.total .ic{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .s-pill.active .ic{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .s-pill.suspended .ic{ background:rgba(232,90,90,.14); color:var(--danger); }
        .s-pill .val{ font-family:'Space Grotesk', sans-serif; font-weight:700; font-size:16px; }
        .s-pill .lbl{ font-size:11.5px; color:var(--text-faint); }

        /* ===== FILTER ===== */
        .cmw-filter{ display:flex; gap:10px; margin-bottom:22px; flex-wrap:wrap; }
        .cmw-filter form{ display:flex; gap:10px; flex-wrap:wrap; width:100%; }
        .search-wrap{ position:relative; flex:1; min-width:200px; }
        .search-wrap .icon{ position:absolute; left:14px; top:50%; transform:translateY(-50%); width:15px; height:15px; color:var(--text-faint); }
        .cmw-filter input[type=text]{ width:100%; padding:10px 14px 10px 40px; border-radius:12px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; }
        .cmw-filter select{ padding:10px 32px 10px 14px; border-radius:12px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; appearance:none; background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>"); background-repeat:no-repeat; background-position:right 10px center; background-size:12px; }
        .btn-sm{ padding:9px 16px; border-radius:12px; font-size:12.5px; font-weight:600; border:1px solid var(--border); background:var(--surface); color:var(--text); cursor:pointer; text-decoration:none; }

        /* ===== CARD GRID ===== */
        .company-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:16px; }
        .company-card{
            background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px;
            transition:all .22s ease; text-decoration:none; color:inherit; display:block; position:relative; overflow:hidden;
        }
        .company-card:hover{ transform:translateY(-4px); border-color:var(--border-hover); box-shadow:0 16px 40px -14px rgba(0,0,0,.5); }
        .company-card::before{ content:''; position:absolute; top:0; left:0; width:4px; height:100%; }
        .company-card.st-active::before{ background:var(--emerald); }
        .company-card.st-suspended::before{ background:var(--danger); }

        .cc-top{ display:flex; align-items:flex-start; justify-content:space-between; gap:10px; margin-bottom:16px; }
        .cc-logo{ width:44px; height:44px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:16px; color:var(--emerald); flex-shrink:0; }
        .cc-status{ font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; padding:4px 10px; border-radius:100px; display:flex; align-items:center; gap:5px; }
        .cc-status .sdot{ width:6px; height:6px; border-radius:50%; }
        .cc-status.active{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .cc-status.active .sdot{ background:var(--emerald); animation:pulseGlow 1.8s ease-in-out infinite; }
        .cc-status.suspended{ background:rgba(232,90,90,.14); color:var(--danger); }
        .cc-status.suspended .sdot{ background:var(--danger); }

        .cc-name{ font-family:'Space Grotesk', sans-serif; font-size:16.5px; font-weight:700; margin-bottom:4px; }
        .cc-date{ font-size:11.5px; color:var(--text-faint); margin-bottom:18px; }

        .cc-stats{ display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-bottom:16px; }
        .cc-stat{ background:var(--surface-strong); border-radius:10px; padding:10px 8px; text-align:center; }
        .cc-stat .n{ font-family:'Space Grotesk', sans-serif; font-size:15px; font-weight:700; }
        .cc-stat .l{ font-size:9.5px; color:var(--text-faint); margin-top:2px; text-transform:uppercase; letter-spacing:.03em; }

        .cc-foot{ display:flex; align-items:center; justify-content:space-between; font-size:12px; font-weight:600; color:var(--accent); padding-top:14px; border-top:1px dashed var(--border); }
        .cc-foot .go{ width:14px; height:14px; transition:transform .18s ease; }
        .company-card:hover .cc-foot .go{ transform:translateX(3px); }

        .empty-state{ grid-column:1/-1; text-align:center; padding:64px 30px; }
        .empty-ic{ width:56px; height:56px; border-radius:16px; background:rgba(var(--emerald-rgb),.12); border:1px solid rgba(var(--emerald-rgb),.25); display:flex; align-items:center; justify-content:center; color:var(--emerald); margin:0 auto 16px; }
        .empty-ic .icon{ width:24px; height:24px; }

        .pagination-wrap{ margin-top:20px; }
    </style>

    <div class="cmw">
        <div class="cmw-header animate-in" style="animation-delay:.05s;">
            <div>
                <h1>Kelola Company</h1>
                <p>Daftar semua perusahaan yang terdaftar di sistem Arvessa.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay:.08s;">{{ session('success') }}</div>
        @endif

        <div class="summary-pills animate-in" style="animation-delay:.1s;">
            <div class="s-pill total">
                <span class="ic"><svg class="icon"><use href="#ic-building"/></svg></span>
                <div><div class="val">{{ $stats['total'] }}</div><div class="lbl">Total Company</div></div>
            </div>
            <div class="s-pill active">
                <span class="ic"><svg class="icon"><use href="#ic-check-circle"/></svg></span>
                <div><div class="val">{{ $stats['active'] }}</div><div class="lbl">Aktif</div></div>
            </div>
            <div class="s-pill suspended">
                <span class="ic"><svg class="icon"><use href="#ic-pause-circle"/></svg></span>
                <div><div class="val">{{ $stats['suspended'] }}</div><div class="lbl">Disuspend</div></div>
            </div>
        </div>

        <div class="cmw-filter animate-in" style="animation-delay:.14s;">
            <form method="GET" action="{{ route('admin.companies.index') }}">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama company...">
                </div>
                <select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status')==='active' ? 'selected':'' }}>Aktif</option>
                    <option value="suspended" {{ request('status')==='suspended' ? 'selected':'' }}>Disuspend</option>
                </select>
                <button type="submit" class="btn-sm">Cari</button>
                @if(request()->anyFilled(['q','status']))
                    <a href="{{ route('admin.companies.index') }}" class="btn-sm">Reset</a>
                @endif
            </form>
        </div>

        <div class="company-grid">
            @forelse($companies as $company)
                <a href="{{ route('admin.companies.edit', $company) }}" class="company-card st-{{ $company->status }} animate-in" style="animation-delay:{{ .16 + ($loop->index * .04) }}s;">
                    <div class="cc-top">
                        <div class="cc-logo">{{ strtoupper(substr($company->name, 0, 1)) }}</div>
                        <span class="cc-status {{ $company->status }}"><span class="sdot"></span>{{ $company->status === 'active' ? 'Aktif' : 'Suspend' }}</span>
                    </div>
                    <div class="cc-name">{{ $company->name }}</div>
                    <div class="cc-date">Terdaftar {{ $company->created_at->translatedFormat('d M Y') }}</div>

                    <div class="cc-stats">
                        <div class="cc-stat"><div class="n">{{ $company->users_count }}</div><div class="l">User</div></div>
                        <div class="cc-stat"><div class="n">{{ $company->invoices_count }}</div><div class="l">Faktur</div></div>
                        <div class="cc-stat"><div class="n">{{ $company->clients_count }}</div><div class="l">Klien</div></div>
                    </div>

                    <div class="cc-foot">
                        Lihat detail
                        <svg class="icon go"><use href="#ic-arrow-right"/></svg>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                    <h3 style="font-family:'Space Grotesk'; font-size:16px; margin-bottom:4px;">Belum ada company</h3>
                    <p style="font-size:13px; color:var(--text-mute);">Company yang mendaftar akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">
            {{ $companies->onEachSide(1)->links() }}
        </div>
    </div>
</x-admin-layout>