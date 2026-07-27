<x-admin-layout>
    <x-slot name="title">Kelola User</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </symbol>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>
            </symbol>
            <symbol id="ic-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 6 12 13 2 6"/>
            </symbol>
        </defs>
    </svg>

    @php
        $totalUsers = $users->total();
        $adminCount = $users->getCollection()->where('access_level.value', 'admin')->count();
        $staffCount = $users->getCollection()->where('access_level.value', 'staff')->count();
        $userCount  = $users->getCollection()->where('access_level.value', 'user')->count();
    @endphp

    <style>
        .adm-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .adm-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        @keyframes slideDown{ from{ opacity:0; transform:translateY(-10px) scale(.95);} to{ opacity:1; transform:translateY(0) scale(1);} }
        @keyframes modalSlideUp{ from{ opacity:0; transform:translateY(24px) scale(.96);} to{ opacity:1; transform:translateY(0) scale(1);} }
        .adm-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== TOAST ===== */
        .toast-container{ position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px; max-width:380px; width:100%; }
        .toast{
            background:var(--modal-bg); border:1px solid var(--border); border-radius:var(--radius-md); padding:16px 20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.5); animation:slideDown .35s cubic-bezier(.16,1,.3,1);
            display:flex; align-items:center; gap:12px; backdrop-filter:blur(12px);
        }
        .toast .toast-icon{ width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .toast .toast-icon.success{ background:rgba(var(--emerald-rgb),0.14); color:var(--emerald); }
        .toast .toast-icon.error{ background:rgba(232,90,90,.14); color:var(--danger); }
        .toast .toast-icon .icon{ width:18px; height:18px; }
        .toast .toast-content{ flex:1; }
        .toast .toast-title{ font-size:13px; font-weight:600; color:var(--text); }
        .toast .toast-msg{ font-size:12px; color:var(--text-mute); }
        .toast .toast-close{ background:none; border:none; color:var(--text-faint); cursor:pointer; padding:4px; }
        .toast .toast-close .icon{ width:14px; height:14px; }

        /* ===== HEADER ===== */
        .adm-header{ display:flex; justify-content:space-between; align-items:flex-start; gap:24px; flex-wrap:wrap; margin-bottom:26px; }
        .adm-header-left{ flex:1; min-width:220px; }
        .adm-badge{
            display:inline-flex; align-items:center; gap:8px; padding:6px 14px 6px 10px;
            background:var(--accent-glow); border:1px solid var(--accent-glow); border-radius:100px;
            font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:var(--accent);
            margin-bottom:12px;
        }
        .adm-badge .dot{ width:6px; height:6px; border-radius:50%; background:var(--accent); animation:pulseGlow 2s ease-in-out infinite; }
        .adm-header h1{
            font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; margin:0 0 6px; letter-spacing:-.02em;
            background:linear-gradient(135deg, var(--text) 55%, var(--accent)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
        }
        .adm-header p{ font-size:14px; color:var(--text-mute); margin:0; }

        /* ===== STAT CARDS ===== */
        .stat-row{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
        .stat-card{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md); padding:20px 22px;
            position:relative; overflow:hidden; transition:all .25s ease;
        }
        .stat-card::before{ content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg, transparent, currentColor, transparent); opacity:0; transition:opacity .3s ease; }
        .stat-card:hover{ transform:translateY(-3px); border-color:var(--border-hover); }
        .stat-card:hover::before{ opacity:.6; }
        .stat-card .sk{ display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .stat-card .sk-label{ font-size:11.5px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.06em; font-weight:600; }
        .stat-icon{ width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon .icon{ width:16px; height:16px; }
        .stat-card.c-emerald{ color:var(--emerald); }
        .stat-card.c-emerald .stat-icon{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .stat-card.c-info{ color:var(--blue); }
        .stat-card.c-info .stat-icon{ background:rgba(78,143,240,.14); color:var(--blue); }
        .stat-card.c-neutral{ color:var(--text-mute); }
        .stat-card.c-neutral .stat-icon{ background:var(--surface-strong); color:var(--text-mute); }
        .stat-card .sv{ font-family:'Space Grotesk', sans-serif; font-size:23px; font-weight:700; letter-spacing:-.01em; color:var(--text); }
        .stat-card .sc{ font-size:12px; color:var(--text-faint); margin-top:5px; }

        /* ===== ALERTS (fallback, kalau JS toast tidak sempat jalan) ===== */
        .alert-success, .alert-error{ display:none; }

        /* ===== TABLE CARD ===== */
        .table-card{ background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); overflow:hidden; position:relative; }
        .table-scroll{ overflow-x:auto; }
        table{ width:100%; border-collapse:collapse; min-width:760px; }
        thead th{ text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:var(--text-faint); font-weight:700; padding:15px 20px; border-bottom:2px solid var(--border); white-space:nowrap; background:var(--surface-hover); }
        tbody tr{ border-bottom:1px solid var(--border); transition:background .18s ease; }
        tbody tr:last-child{ border-bottom:none; }
        tbody tr:hover{ background:var(--surface-strong); }
        tbody td{ padding:15px 20px; font-size:13.5px; vertical-align:middle; }

        .u-avatar{
            width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk', sans-serif; font-size:13px; font-weight:700; color:#fff; flex-shrink:0;
        }
        .u-cell{ display:flex; align-items:center; gap:12px; }
        .u-name{ font-weight:600; color:var(--text); font-size:13.5px; }
        .u-email{ font-size:11.5px; color:var(--text-faint); margin-top:1px; display:flex; align-items:center; gap:5px; }
        .u-email .icon{ width:11px; height:11px; }

        .level-badge{ display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:700; padding:5px 12px; border-radius:100px; letter-spacing:.01em; }
        .level-badge .sdot{ width:6px; height:6px; border-radius:50%; }
        .level-badge.admin{ background:rgba(var(--emerald-rgb),0.14); color:var(--emerald); }
        .level-badge.admin .sdot{ background:var(--emerald); animation:pulseGlow 1.8s ease-in-out infinite; }
        .level-badge.staff{ background:rgba(78,143,240,.14); color:#4E8FF0; }
        .level-badge.staff .sdot{ background:#4E8FF0; }
        .level-badge.user{ background:var(--surface-strong); color:var(--text-mute); }
        .level-badge.user .sdot{ background:var(--text-faint); }

        .joined-cell{ color:var(--text-mute); font-size:13px; }

        /* ===== ICON ACTIONS ===== */
        .row-actions{ display:flex; align-items:center; gap:6px; justify-content:flex-end; }
        .icon-action{
            width:32px; height:32px; border-radius:9px; display:inline-flex; align-items:center; justify-content:center;
            background:var(--surface); border:1px solid var(--border); color:var(--text-faint); cursor:pointer;
            transition:all .18s ease; position:relative; text-decoration:none;
        }
        .icon-action .icon{ width:15px; height:15px; }
        .icon-action:hover{ transform:translateY(-2px); }
        .icon-action.edit:hover{ background:rgba(78,143,240,.14); border-color:#4E8FF0; color:#4E8FF0; }
        .icon-action.delete:hover{ background:rgba(232,90,90,.14); border-color:var(--danger); color:var(--danger); }

        .icon-action[data-tip]::after{
            content:attr(data-tip); position:absolute; bottom:calc(100% + 8px); left:50%; transform:translateX(-50%) translateY(4px);
            background:var(--surface); color:var(--text); font-size:11px; font-weight:600; padding:5px 9px; border-radius:7px; white-space:nowrap;
            opacity:0; visibility:hidden; transition:all .16s ease; pointer-events:none; box-shadow:0 6px 18px rgba(0,0,0,.35); border:1px solid var(--border);
        }
        .icon-action[data-tip]::before{
            content:''; position:absolute; bottom:calc(100% + 3px); left:50%; transform:translateX(-50%);
            border:5px solid transparent; border-top-color:var(--surface); opacity:0; visibility:hidden; transition:all .16s ease;
        }
        .icon-action[data-tip]:hover::after, .icon-action[data-tip]:hover::before{ opacity:1; visibility:visible; transform:translateX(-50%) translateY(0); }

        /* ===== EMPTY STATE ===== */
        .empty-state{ text-align:center; padding:64px 30px; }
        .empty-ic{ width:60px; height:60px; border-radius:16px; background:var(--accent-soft); border:1px solid var(--accent-glow); display:flex; align-items:center; justify-content:center; color:var(--accent); margin:0 auto 18px; }
        .empty-ic .icon{ width:26px; height:26px; }
        .empty-state h3{ font-family:'Space Grotesk', sans-serif; font-size:17px; margin-bottom:6px; color:var(--text); }
        .empty-state p{ font-size:13.5px; color:var(--text-mute); max-width:320px; margin:0 auto; }

        .pagination-wrap{ margin-top:18px; }

        /* ===== DELETE MODAL ===== */
        .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,.65); backdrop-filter:blur(8px); z-index:999; display:none; align-items:center; justify-content:center; padding:20px; }
        .modal-overlay.open{ display:flex; }
        .modal-box{ background:var(--modal-bg); border:1px solid var(--border); border-radius:var(--radius-lg); padding:32px 34px; max-width:420px; width:100%; box-shadow:0 30px 80px rgba(0,0,0,.5); animation:modalSlideUp .3s cubic-bezier(.16,1,.3,1); text-align:center; }
        .modal-ic{ width:54px; height:54px; border-radius:50%; background:rgba(232,90,90,.14); color:var(--danger); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
        .modal-ic .icon{ width:24px; height:24px; }
        .modal-box h3{ font-family:'Space Grotesk', sans-serif; font-size:18px; margin-bottom:8px; color:var(--text); }
        .modal-box p{ font-size:13.5px; color:var(--text-mute); margin-bottom:6px; line-height:1.6; }
        .modal-box p b{ color:var(--text); font-family:'IBM Plex Mono', monospace; background:var(--surface-strong); padding:2px 10px; border-radius:6px; display:inline-block; margin-top:4px; }
        .modal-warn{ font-size:12.5px; color:var(--danger); font-weight:600; margin-top:14px; padding:9px 14px; background:rgba(232,90,90,.1); border-radius:10px; display:inline-block; }
        .modal-actions{ display:flex; gap:10px; justify-content:center; margin-top:22px; }
        .modal-actions .btn{ flex:1; justify-content:center; }

        .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:var(--radius-sm); font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .22s cubic-bezier(.16,1,.3,1); white-space:nowrap; text-decoration:none; }
        .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
        .btn-outline:hover{ background:var(--surface-strong); border-color:var(--border-hover); transform:translateY(-2px); }
        .btn-danger{ background:var(--danger); color:#fff; }
        .btn-danger:hover{ background:#d14a4a; transform:translateY(-2px); box-shadow:0 8px 22px rgba(232,90,90,.35); }

        @media (max-width: 1100px){ .stat-row{ grid-template-columns:repeat(2,1fr); } }
        @media (max-width: 768px){
            .adm-header{ flex-direction:column; }
            .stat-row{ grid-template-columns:1fr 1fr; gap:12px; }
            .stat-card .sv{ font-size:19px; }
        }
        @media (max-width: 480px){
            .stat-row{ grid-template-columns:1fr; }
            .adm-header h1{ font-size:22px; }
        }
    </style>

    <div class="adm-wrap">

        {{-- ===== TOAST CONTAINER ===== --}}
        <div class="toast-container" id="toastContainer"></div>

        {{-- ===== HEADER ===== --}}
        <div class="adm-header animate-in" style="animation-delay:.05s;">
            <div class="adm-header-left">
                <div class="adm-badge"><span class="dot"></span> Pengaturan</div>
                <h1>Kelola User</h1>
                <p>Atur access level (admin / staff / user) untuk semua akun yang terdaftar.</p>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="stat-row">
            <div class="stat-card c-emerald animate-in" style="animation-delay:.10s;">
                <div class="sk">
                    <span class="sk-label">Total User</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-users"/></svg></span>
                </div>
                <div class="sv">{{ $totalUsers }}</div>
                <div class="sc">Akun terdaftar</div>
            </div>
            <div class="stat-card c-emerald animate-in" style="animation-delay:.15s;">
                <div class="sk">
                    <span class="sk-label">Admin</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-shield"/></svg></span>
                </div>
                <div class="sv">{{ $adminCount }}</div>
                <div class="sc">Akses penuh sistem</div>
            </div>
            <div class="stat-card c-info animate-in" style="animation-delay:.20s;">
                <div class="sk">
                    <span class="sk-label">Staff</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-briefcase"/></svg></span>
                </div>
                <div class="sv">{{ $staffCount }}</div>
                <div class="sc">Akses terbatas</div>
            </div>
            <div class="stat-card c-neutral animate-in" style="animation-delay:.25s;">
                <div class="sk">
                    <span class="sk-label">User Biasa</span>
                    <span class="stat-icon"><svg class="icon"><use href="#ic-user"/></svg></span>
                </div>
                <div class="sv">{{ $userCount }}</div>
                <div class="sc">Akses dasar</div>
            </div>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="table-card animate-in" style="animation-delay:.30s;">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Perusahaan</th>
                            <th>Access Level</th>
                            <th>Terdaftar</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            @php
                                $rowColors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
                                $avColor = $rowColors[$loop->index % count($rowColors)];
                            @endphp
                            <tr>
                                <td>
                                    <div class="u-cell">
                                        <div class="u-avatar" style="background:{{ $avColor }};">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="u-name">{{ $u->name }}</div>
                                            <div class="u-email"><svg class="icon"><use href="#ic-mail"/></svg> {{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $u->company->name ?? '—' }}</td>
                                <td>
                                    <span class="level-badge {{ $u->access_level->value }}">
                                        <span class="sdot"></span>{{ $u->access_level->label() }}
                                    </span>
                                </td>
                                <td class="joined-cell">{{ $u->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('admin.users.edit', $u) }}" class="icon-action edit" data-tip="Edit">
                                            <svg class="icon"><use href="#ic-edit"/></svg>
                                        </a>
                                        @if($u->id !== auth()->id())
                                            <button type="button" class="icon-action delete" data-tip="Hapus" onclick="openDeleteModal('{{ $u->id }}', '{{ $u->name }}')">
                                                <svg class="icon"><use href="#ic-trash"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                                        <h3>Belum ada user</h3>
                                        <p>User yang mendaftar akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>

        {{-- ===== DELETE MODAL (dibuat sekali, form action diisi dinamis via JS) ===== --}}
        <div class="modal-overlay" id="deleteModal">
            <div class="modal-box">
                <div class="modal-ic"><svg class="icon"><use href="#ic-alert-triangle"/></svg></div>
                <h3>Hapus user ini?</h3>
                <p>User <br><b id="deleteUserName">—</b></p>
                <p style="margin-top:8px;">akan dihapus permanen dan tidak bisa dikembalikan.</p>
                <div class="modal-warn">Seluruh akses user ini ke sistem akan dicabut.</div>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-actions">
                        <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ===== TOAST SYSTEM =====
        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="toast-icon ${type}">
                    <svg class="icon"><use href="#${type === 'success' ? 'ic-check-circle' : 'ic-alert-triangle'}"/></svg>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-msg">${message}</div>
                </div>
                <button class="toast-close" onclick="this.parentElement.remove()">
                    <svg class="icon"><use href="#ic-x"/></svg>
                </button>
            `;
            container.appendChild(toast);
            setTimeout(() => { if (toast.parentElement) toast.remove(); }, 5000);
        }

        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function(){
                showToast('Berhasil!', @json(session('success')), 'success');
            });
        @endif
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function(){
                showToast('Gagal', @json($errors->first()), 'error');
            });
        @endif

        // ===== DELETE MODAL =====
        function openDeleteModal(id, userName){
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteForm').action = '{{ url("admin/users") }}/' + id;
            document.getElementById('deleteModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteModal(){
            document.getElementById('deleteModal').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.getElementById('deleteModal').addEventListener('click', function(e){
            if(e.target === this) closeDeleteModal();
        });
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape') closeDeleteModal();
        });
    </script>
</x-admin-layout>