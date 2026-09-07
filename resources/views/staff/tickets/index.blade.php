<x-app-layout>
    <x-slot name="title">Tiket Bantuan</x-slot>

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="tkt-ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="tkt-ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="tkt-ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="tkt-ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="tkt-ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="tkt-ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
            <symbol id="tkt-ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="tkt-ic-loader" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/>
            </symbol>
            <symbol id="tkt-ic-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .tkt-wrap {
            --theme-primary: var(--emerald);
            --theme-glow: rgba(var(--emerald-rgb), 0.25);
            --theme-soft: rgba(var(--emerald-rgb), 0.12);
            --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));
            font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color:var(--text); padding:0 24px;
        }
        .tkt-wrap *{ box-sizing:border-box; }
        .tkt-wrap .mono{ font-family:'IBM Plex Mono', monospace; font-variant-numeric:tabular-nums; letter-spacing:-0.02em; }

        @keyframes tktFadeSlideUp{ from{opacity:0; transform:translateY(16px);} to{opacity:1; transform:translateY(0);} }
        @keyframes tktPulseGlow{ 0%,100%{opacity:1;} 50%{opacity:.6;} }
        .tkt-wrap .animate-in{ animation:tktFadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .tkt-wrap .icon{ width:18px; height:18px; flex-shrink:0; display:inline-block; vertical-align:middle; fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }

        /* ===== HEADER ===== */
        .tkt-header{ display:flex; justify-content:space-between; align-items:flex-start; gap:24px; flex-wrap:wrap; margin-bottom:28px; padding:0 4px; }
        .tkt-header-left{ flex:1; min-width:200px; }
        .tkt-badge{ display:inline-flex; align-items:center; gap:8px; padding:6px 14px 6px 10px; background:var(--theme-glow); border:1px solid var(--theme-glow); border-radius:100px; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:var(--theme-primary); margin-bottom:12px; }
        .tkt-badge .dot{ width:6px; height:6px; border-radius:50%; background:var(--theme-primary); animation:tktPulseGlow 2s ease-in-out infinite; }
        .tkt-header h1{ font-size:28px; font-weight:700; margin:0 0 6px; background:linear-gradient(135deg, var(--text) 60%, var(--theme-primary)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:-0.02em; }
        .tkt-header .subtitle{ font-size:14px; color:var(--text-mute); margin:0; }
        .tkt-header .subtitle strong{ color:var(--text); font-weight:600; }

        .tkt-btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; border:none; cursor:pointer; transition:all .25s cubic-bezier(.16,1,.3,1); font-family:'Inter',sans-serif; }
        .tkt-btn .icon{ width:15px; height:15px; }
        .tkt-btn-primary{ background:var(--theme-gradient); color:#fff; box-shadow:0 4px 16px var(--theme-glow); }
        .tkt-btn-primary:hover{ transform:translateY(-2px); box-shadow:0 8px 28px var(--theme-glow); color:#fff; }
        .tkt-btn-ghost{ background:var(--surface); border:1px solid var(--border); color:var(--text-mute); }
        .tkt-btn-ghost:hover{ background:var(--surface-strong); border-color:var(--border-hover); color:var(--text); }

        .tkt-alert{ border-radius:16px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:12px; font-size:13px; background:rgba(52,181,131,.14); border:1px solid rgba(52,181,131,.3); color:#34B583; }

        /* ===== STATS ===== */
        .tkt-stats{ display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
        .tkt-stat-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:20px 22px; transition:all .3s cubic-bezier(.16,1,.3,1); }
        .tkt-stat-card:hover{ background:var(--surface-strong); border-color:var(--border-hover); transform:translateY(-2px); }
        .tkt-stat-card .stat-head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; }
        .tkt-stat-card .ic{ width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
        .tkt-stat-card .ic .icon{ width:16px; height:16px; }
        .tkt-stat-card.open .ic{ background:rgba(52,181,131,.14); color:#34B583; }
        .tkt-stat-card.progress .ic{ background:rgba(232,178,58,.14); color:#E8B23A; }
        .tkt-stat-card.closed .ic{ background:rgba(255,255,255,.06); color:var(--text-faint); }
        .tkt-stat-card .stat-label{ font-size:11.5px; color:var(--text-faint); text-transform:uppercase; letter-spacing:.05em; margin-bottom:4px; }
        .tkt-stat-card .stat-value{ font-size:24px; font-weight:700; letter-spacing:-.02em; color:var(--text); }

        /* ===== CARD & FILTER ===== */
        .tkt-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; transition:border-color .22s ease; }
        .tkt-card:hover{ border-color:var(--border-hover); }
        .tkt-card-header{ display:flex; justify-content:space-between; align-items:center; padding:18px 24px; border-bottom:1px solid var(--border); flex-wrap:wrap; gap:10px; }
        .tkt-card-header h3{ font-size:15px; font-weight:600; margin:0; color:var(--text); }

        .filter-bar{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; padding:14px 24px; border-bottom:1px solid var(--border); }
        .search-wrap{ position:relative; flex:1; min-width:200px; }
        .search-wrap .icon{ position:absolute; left:14px; top:50%; transform:translateY(-50%); width:15px; height:15px; color:var(--text-faint); pointer-events:none; }
        .search-wrap input{ width:100%; padding:9px 14px 9px 38px; border-radius:10px; background:var(--surface-strong); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; font-family:inherit; transition:all .2s ease; }
        .search-wrap input:focus{ border-color:var(--theme-primary); box-shadow:0 0 0 3px var(--theme-soft); }
        .filter-select{ padding:9px 34px 9px 14px; border-radius:10px; background:var(--surface-strong); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; appearance:none; cursor:pointer;
            background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat:no-repeat; background-position:right 12px center; background-size:13px; }
        .filter-select:focus{ border-color:var(--theme-primary); }
        .search-indicator{ font-size:12px; color:var(--text-faint); white-space:nowrap; }
        .search-indicator strong{ color:var(--text); }

        .tkt-table-wrap{ overflow-x:auto; }
        .tkt-table{ width:100%; border-collapse:collapse; font-size:13.5px; }
        .tkt-table th{ text-align:left; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint); padding:14px 16px 10px; border-bottom:1px solid var(--border); white-space:nowrap; }
        .tkt-table td{ padding:14px 16px; border-bottom:1px solid var(--border); color:var(--text); vertical-align:middle; }
        .tkt-table tbody tr:last-child td{ border-bottom:none; }
        .tkt-table tbody tr{ transition:background .15s ease; }
        .tkt-table tbody tr:hover{ background:var(--surface-strong); }

        .tkt-desc{ display:flex; align-items:center; gap:12px; }
        .tkt-desc .icon-wrap{ width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; background:var(--theme-soft); color:var(--theme-primary); flex-shrink:0; }
        .tkt-desc .icon-wrap .icon{ width:15px; height:15px; }
        .tkt-desc .text-col{ min-width:0; }
        .tkt-subject{ font-weight:600; color:var(--text); }
        .tkt-subject .snippet{ display:block; font-size:11.5px; color:var(--text-faint); font-weight:400; margin-top:2px; max-width:280px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

        .tkt-chip{ font-size:11.5px; font-weight:500; padding:4px 11px; border-radius:100px; background:rgba(255,255,255,.04); color:var(--text-mute); display:inline-block; border:1px solid var(--border); white-space:nowrap; }

        .tkt-status{ font-size:10.5px; font-weight:700; padding:4px 12px; border-radius:100px; display:inline-flex; align-items:center; gap:5px; text-transform:uppercase; letter-spacing:.04em; white-space:nowrap; }
        .tkt-status .icon{ width:11px; height:11px; }
        .tkt-status.open{ background:rgba(52,181,131,.14); color:#34B583; }
        .tkt-status.in_progress{ background:rgba(232,178,58,.14); color:#E8B23A; }
        .tkt-status.closed{ background:rgba(255,255,255,.06); color:var(--text-faint); }

        .tkt-item-actions{ display:flex; justify-content:flex-end; }
        .tkt-btn-action{ width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; color:var(--theme-primary); background:transparent; border:1px solid var(--border); text-decoration:none; transition:all .2s ease; }
        .tkt-btn-action .icon{ width:14px; height:14px; }
        .tkt-btn-action:hover{ background:var(--theme-soft); border-color:var(--theme-primary); }

        .tkt-empty{ text-align:center; padding:56px 20px; color:var(--text-faint); }
        .tkt-empty .empty-icon{ width:52px; height:52px; margin:0 auto 16px; color:var(--theme-primary); opacity:.5; }
        .tkt-empty h4{ font-size:16px; font-weight:600; margin:0 0 6px; color:var(--text); }
        .tkt-empty p{ color:var(--text-mute); margin:0 0 18px; font-size:13.5px; }

        @media (max-width:900px){ .tkt-stats{ grid-template-columns:1fr 1fr; } }
        @media (max-width:768px){
            .tkt-wrap{ padding:0 12px; }
            .tkt-header h1{ font-size:22px; }
            .tkt-table{ font-size:12.5px; }
            .tkt-table th, .tkt-table td{ padding:10px 12px; }
            .tkt-subject .snippet{ max-width:160px; }
            .filter-bar{ flex-direction:column; align-items:stretch; }
            .search-wrap{ min-width:100%; }
        }
        @media (max-width:480px){ .tkt-stats{ grid-template-columns:1fr; } }
    </style>

    <div class="tkt-wrap">
        <div class="tkt-header animate-in" style="animation-delay:.05s;">
            <div class="tkt-header-left">
                <div class="tkt-badge"><span class="dot"></span> Support &amp; Bantuan</div>
                <h1>Tiket Bantuan Saya</h1>
                <p class="subtitle">Ajukan kendala atau pertanyaan ke admin — <strong id="tktTotalCount">{{ $tickets->count() }}</strong> tiket total</p>
            </div>
            <a href="{{ route('staff.tickets.create') }}" class="tkt-btn tkt-btn-primary">
                <svg class="icon"><use href="#tkt-ic-plus"/></svg> Buat Tiket Baru
            </a>
        </div>

        @if(session('success'))
            <div class="tkt-alert animate-in" style="animation-delay:.07s;">
                <svg class="icon"><use href="#tkt-ic-check-circle"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ===== STATS ===== --}}
        <div class="tkt-stats">
            <div class="tkt-stat-card open animate-in" style="animation-delay:.10s;">
                <div class="stat-head">
                    <div class="ic"><svg class="icon"><use href="#tkt-ic-inbox"/></svg></div>
                </div>
                <div class="stat-label">Terbuka</div>
                <div class="stat-value mono">{{ $tickets->where('status', 'open')->count() }}</div>
            </div>
            <div class="tkt-stat-card progress animate-in" style="animation-delay:.15s;">
                <div class="stat-head">
                    <div class="ic"><svg class="icon"><use href="#tkt-ic-loader"/></svg></div>
                </div>
                <div class="stat-label">Diproses</div>
                <div class="stat-value mono">{{ $tickets->where('status', 'in_progress')->count() }}</div>
            </div>
            <div class="tkt-stat-card closed animate-in" style="animation-delay:.20s;">
                <div class="stat-head">
                    <div class="ic"><svg class="icon"><use href="#tkt-ic-check"/></svg></div>
                </div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value mono">{{ $tickets->where('status', 'closed')->count() }}</div>
            </div>
        </div>

        {{-- ===== TABLE CARD ===== --}}
        <div class="tkt-card animate-in" style="animation-delay:.25s;">
            <div class="tkt-card-header">
                <h3>Daftar Tiket</h3>
            </div>

            <div class="filter-bar">
                <div class="search-wrap">
                    <svg class="icon"><use href="#tkt-ic-search"/></svg>
                    <input type="text" id="tktSearchInput" placeholder="Cari subjek atau isi tiket..." autocomplete="off">
                </div>
                <select id="tktStatusFilter" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="open">Terbuka</option>
                    <option value="in_progress">Diproses</option>
                    <option value="closed">Selesai</option>
                </select>
                <span class="search-indicator" id="tktSearchIndicator" style="display:none;">
                    <strong id="tktResultCount">0</strong> hasil
                </span>
            </div>

            <div class="tkt-table-wrap">
                <table class="tkt-table">
                    <thead>
                        <tr>
                            <th>Subjek</th>
                            <th>Kategori</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Dibuka</th>
                            <th style="width:60px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tktTableBody">
                        @forelse($tickets as $ticket)
                            <tr data-subject="{{ strtolower($ticket->subject.' '.$ticket->message) }}" data-status="{{ $ticket->status }}">
                                <td>
                                    <div class="tkt-desc">
                                        <div class="icon-wrap"><svg class="icon"><use href="#tkt-ic-inbox"/></svg></div>
                                        <div class="text-col">
                                            <div class="tkt-subject">
                                                {{ $ticket->subject }}
                                                <span class="snippet">{{ Str::limit($ticket->message, 60) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="tkt-chip">{{ $ticket->categoryLabel() }}</span></td>
                                <td><span class="tkt-chip">{{ $ticket->priorityLabel() }}</span></td>
                                <td>
                                    <span class="tkt-status {{ $ticket->status }}">
                                        @if($ticket->status === 'open')
                                            <svg class="icon"><use href="#tkt-ic-inbox"/></svg>
                                        @elseif($ticket->status === 'in_progress')
                                            <svg class="icon"><use href="#tkt-ic-loader"/></svg>
                                        @else
                                            <svg class="icon"><use href="#tkt-ic-check"/></svg>
                                        @endif
                                        {{ $ticket->statusLabel() }}
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->translatedFormat('d M Y') }}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('staff.tickets.show', $ticket) }}" class="tkt-btn-action" title="Lihat Detail">
                                        <svg class="icon"><use href="#tkt-ic-eye"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>

                <div class="tkt-empty" id="tktEmptyState" style="{{ $tickets->count() ? 'display:none;' : '' }}">
                    <svg class="empty-icon"><use href="#tkt-ic-inbox"/></svg>
                    <h4>Belum Ada Tiket</h4>
                    <p>Kamu belum pernah mengajukan tiket bantuan.</p>
                    <a href="{{ route('staff.tickets.create') }}" class="tkt-btn tkt-btn-primary" style="display:inline-flex;">
                        <svg class="icon"><use href="#tkt-ic-plus"/></svg> Buat Tiket Pertama
                    </a>
                </div>

                <div class="tkt-empty" id="tktNoResultState" style="display:none;">
                    <svg class="empty-icon"><use href="#tkt-ic-search"/></svg>
                    <h4>Gak Ada yang Cocok</h4>
                    <p>Coba ubah kata kunci atau filter status.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput  = document.getElementById('tktSearchInput');
            var statusFilter = document.getElementById('tktStatusFilter');
            var rows          = Array.from(document.querySelectorAll('#tktTableBody tr'));
            var totalRows     = rows.length;
            var indicator     = document.getElementById('tktSearchIndicator');
            var resultCount   = document.getElementById('tktResultCount');
            var emptyState    = document.getElementById('tktEmptyState');
            var noResultState = document.getElementById('tktNoResultState');

            function applyFilter() {
                var q      = (searchInput.value || '').trim().toLowerCase();
                var status = statusFilter.value;
                var visible = 0;

                rows.forEach(function (row) {
                    var matchesQ      = !q || row.dataset.subject.includes(q);
                    var matchesStatus = !status || row.dataset.status === status;
                    var show = matchesQ && matchesStatus;
                    row.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                var filtering = q.length > 0 || status.length > 0;
                indicator.style.display = filtering ? 'inline-flex' : 'none';
                resultCount.textContent = visible;

                if (totalRows === 0) {
                    emptyState.style.display = '';
                    noResultState.style.display = 'none';
                } else if (filtering && visible === 0) {
                    emptyState.style.display = 'none';
                    noResultState.style.display = '';
                } else {
                    emptyState.style.display = 'none';
                    noResultState.style.display = 'none';
                }
            }

            if (searchInput)  searchInput.addEventListener('input', applyFilter);
            if (statusFilter) statusFilter.addEventListener('change', applyFilter);
        });
    </script>
</x-app-layout>