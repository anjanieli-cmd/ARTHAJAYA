<x-admin-layout>
    <x-slot name="title">Detail Company</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-pause-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 6 12 13 2 6"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .cew{ --accent: var(--emerald); color:var(--text); }
        .cew *{ box-sizing:border-box; }
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        .cew .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        .cew-back{ display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color:var(--text-mute); margin-bottom:16px; text-decoration:none; }
        .cew-back:hover{ color:var(--text); }
        .cew-back .icon{ width:14px; height:14px; }

        .cew-hero{
            background:linear-gradient(135deg, rgba(var(--emerald-rgb),.1), var(--surface) 60%);
            border:1px solid var(--border); border-radius:22px; padding:30px; margin-bottom:20px;
            display:flex; justify-content:space-between; align-items:center; gap:20px; flex-wrap:wrap;
        }
        .cew-hero-left{ display:flex; align-items:center; gap:16px; }
        .cew-logo{ width:64px; height:64px; border-radius:16px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk'; font-weight:700; font-size:22px; color:var(--emerald); flex-shrink:0; }
        .cew-hero h1{ font-family:'Space Grotesk', sans-serif; font-size:22px; margin-bottom:4px; }
        .cew-hero p{ font-size:12.5px; color:var(--text-faint); }

        .cew-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
        .cew-stat{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:20px; text-align:center; }
        .cew-stat .n{ font-family:'Space Grotesk', sans-serif; font-size:24px; font-weight:700; color:var(--emerald); }
        .cew-stat .l{ font-size:11.5px; color:var(--text-faint); margin-top:4px; }

        .cew-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; }
        .cew-panel h3{ font-family:'Space Grotesk', sans-serif; font-size:15px; margin-bottom:16px; }

        .status-toggle{ display:flex; gap:10px; margin-bottom:20px; }
        .status-opt{ flex:1; padding:14px; border-radius:14px; border:1px solid var(--border); background:var(--surface-strong); text-align:center; cursor:pointer; transition:all .18s ease; }
        .status-opt input{ display:none; }
        .status-opt .icon{ width:18px; height:18px; margin-bottom:6px; }
        .status-opt .lbl{ font-size:12.5px; font-weight:600; }
        .status-opt.active-opt{ color:var(--emerald); }
        .status-opt.suspend-opt{ color:var(--danger); }
        .status-opt.selected.active-opt{ border-color:var(--emerald); background:rgba(var(--emerald-rgb),.1); }
        .status-opt.selected.suspend-opt{ border-color:var(--danger); background:rgba(232,90,90,.1); }

        .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; text-decoration:none; width:100%; }
        .btn-primary{ background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); color:#052117; }

        .u-list{ margin-top:20px; }
        .u-row{ display:flex; align-items:center; gap:10px; padding:10px 0; border-top:1px solid var(--border); }
        .u-row:first-child{ border-top:none; }
        .u-avatar{ width:30px; height:30px; border-radius:9px; background:var(--surface-strong); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:var(--emerald); flex-shrink:0; }
        .u-name{ font-size:12.5px; font-weight:600; }
        .u-email{ font-size:11px; color:var(--text-faint); }

        @media (max-width:900px){ .cew-grid{ grid-template-columns:1fr 1fr; } }
        @media (max-width:640px){ .cew-grid{ grid-template-columns:1fr; } }
    </style>

    <div class="cew">
        <a href="{{ route('admin.companies.index') }}" class="cew-back animate-in" style="animation-delay:.03s;">
            <svg class="icon"><use href="#ic-arrow-left"/></svg> Kembali ke Kelola Company
        </a>

        <div class="cew-hero animate-in" style="animation-delay:.06s;">
            <div class="cew-hero-left">
                <div class="cew-logo">{{ strtoupper(substr($company->name, 0, 1)) }}</div>
                <div>
                    <h1>{{ $company->name }}</h1>
                    <p>Terdaftar sejak {{ $company->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="cew-grid animate-in" style="animation-delay:.1s;">
            <div class="cew-stat"><div class="n">{{ $company->users_count }}</div><div class="l">Total User</div></div>
            <div class="cew-stat"><div class="n">{{ $company->invoices_count }}</div><div class="l">Total Faktur</div></div>
            <div class="cew-stat"><div class="n">{{ $company->clients_count }}</div><div class="l">Total Klien</div></div>
            <div class="cew-stat"><div class="n">{{ $company->quotes_count }}</div><div class="l">Total Penawaran</div></div>
        </div>

        <div class="cew-grid" style="grid-template-columns:1fr 1fr;">
            <div class="cew-panel animate-in" style="animation-delay:.14s;">
                <h3>Status Company</h3>
                <form method="POST" action="{{ route('admin.companies.update', $company) }}">
                    @csrf
                    @method('PUT')
                    <div class="status-toggle">
                        <label class="status-opt active-opt {{ $company->status === 'active' ? 'selected' : '' }}" onclick="selectStatus(this, 'active')">
                            <input type="radio" name="status" value="active" {{ $company->status === 'active' ? 'checked' : '' }}>
                            <svg class="icon"><use href="#ic-check-circle"/></svg>
                            <div class="lbl">Aktif</div>
                        </label>
                        <label class="status-opt suspend-opt {{ $company->status === 'suspended' ? 'selected' : '' }}" onclick="selectStatus(this, 'suspended')">
                            <input type="radio" name="status" value="suspended" {{ $company->status === 'suspended' ? 'checked' : '' }}>
                            <svg class="icon"><use href="#ic-pause-circle"/></svg>
                            <div class="lbl">Suspend</div>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Status</button>
                </form>
            </div>

            <div class="cew-panel animate-in" style="animation-delay:.18s;">
                <h3>User di Company Ini</h3>
                <div class="u-list">
                    @forelse($company->users as $u)
                        <div class="u-row">
                            <div class="u-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                            <div>
                                <div class="u-name">{{ $u->name }}</div>
                                <div class="u-email">{{ $u->email }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="font-size:12.5px; color:var(--text-faint);">Belum ada user.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectStatus(el, val){
            document.querySelectorAll('.status-opt').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
        }
    </script>
</x-admin-layout>