<x-admin-layout>
    <x-slot name="title">Support / Tiket</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-help" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-inbox" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </symbol>
            <symbol id="ic-message" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .tiw{ --accent: var(--emerald); color:var(--text); }
        .tiw *{ box-sizing:border-box; }
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.5;} }
        .tiw .animate-in{ animation:fadeSlideUp .45s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        .tiw-head{ margin-bottom:20px; }
        .tiw-head h1{ font-family:'Space Grotesk', sans-serif; font-size:25px; margin-bottom:6px; }
        .tiw-head p{ font-size:13.5px; color:var(--text-mute); }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        /* ===== STAT PILLS ===== */
        .stat-pills{ display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
        .s-pill{ display:flex; align-items:center; gap:9px; background:var(--surface); border:1px solid var(--border); border-radius:100px; padding:9px 16px 9px 9px; cursor:pointer; transition:all .18s ease; text-decoration:none; color:inherit; }
        .s-pill:hover{ border-color:var(--border-hover); }
        .s-pill.active{ border-color:var(--emerald); background:rgba(var(--emerald-rgb),.08); }
        .s-pill .ic{ width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .s-pill .ic .icon{ width:13px; height:13px; }
        .s-pill.total .ic{ background:var(--surface-strong); color:var(--text-mute); }
        .s-pill.open .ic{ background:rgba(232,90,90,.14); color:var(--danger); }
        .s-pill.progress .ic{ background:rgba(240,162,90,.14); color:#F0A25A; }
        .s-pill.closed .ic{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .s-pill .val{ font-family:'Space Grotesk', sans-serif; font-weight:700; font-size:14px; }
        .s-pill .lbl{ font-size:11px; color:var(--text-faint); }

        /* ===== FILTER BAR ===== */
        .tiw-filter{ margin-bottom:18px; }
        .tiw-filter form{ display:flex; gap:10px; flex-wrap:wrap; }
        .search-wrap{ position:relative; flex:1; min-width:200px; }
        .search-wrap .icon{ position:absolute; left:14px; top:50%; transform:translateY(-50%); width:15px; height:15px; color:var(--text-faint); }
        .tiw-filter input[type=text]{ width:100%; padding:10px 14px 10px 40px; border-radius:12px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; }
        .tiw-filter select{ padding:10px 30px 10px 14px; border-radius:12px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; appearance:none; background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>"); background-repeat:no-repeat; background-position:right 10px center; background-size:12px; }
        .btn-sm{ padding:9px 16px; border-radius:12px; font-size:12.5px; font-weight:600; border:1px solid var(--border); background:var(--surface); color:var(--text); cursor:pointer; text-decoration:none; }

        /* ===== INBOX LIST ===== */
        .inbox-list{ display:flex; flex-direction:column; gap:10px; }
        .inbox-row{
            display:flex; align-items:center; gap:16px; background:var(--surface); border:1px solid var(--border);
            border-radius:16px; padding:18px 20px; text-decoration:none; color:inherit; transition:all .2s ease; position:relative;
        }
        .inbox-row:hover{ transform:translateX(4px); border-color:var(--border-hover); background:var(--surface-strong); }
        .inbox-row::before{ content:''; position:absolute; left:0; top:14px; bottom:14px; width:3px; border-radius:3px; }
        .inbox-row.pri-high::before{ background:var(--danger); }
        .inbox-row.pri-medium::before{ background:#F0A25A; }
        .inbox-row.pri-low::before{ background:var(--text-faint); }

        .inbox-ic{ width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .inbox-ic .icon{ width:19px; height:19px; }
        .inbox-row.st-open .inbox-ic{ background:rgba(232,90,90,.12); color:var(--danger); }
        .inbox-row.st-in_progress .inbox-ic{ background:rgba(240,162,90,.12); color:#F0A25A; }
        .inbox-row.st-closed .inbox-ic{ background:rgba(var(--emerald-rgb),.12); color:var(--emerald); }

        .inbox-body{ flex:1; min-width:0; }
        .inbox-top{ display:flex; align-items:center; gap:10px; margin-bottom:4px; flex-wrap:wrap; }
        .inbox-subject{ font-size:14px; font-weight:700; }
        .inbox-cat{ font-size:10.5px; font-weight:600; color:var(--text-faint); background:var(--surface-strong); padding:2px 9px; border-radius:100px; }
        .inbox-snippet{ font-size:12.5px; color:var(--text-mute); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:600px; }
        .inbox-meta{ display:flex; align-items:center; gap:10px; margin-top:6px; font-size:11px; color:var(--text-faint); }
        .inbox-meta .dot-sep{ width:3px; height:3px; border-radius:50%; background:var(--text-faint); }

        .inbox-right{ display:flex; flex-direction:column; align-items:flex-end; gap:6px; flex-shrink:0; }
        .status-badge{ display:inline-flex; align-items:center; gap:5px; font-size:10.5px; font-weight:700; padding:4px 10px; border-radius:100px; white-space:nowrap; }
        .status-badge .sdot{ width:5px; height:5px; border-radius:50%; }
        .status-badge.open{ background:rgba(232,90,90,.14); color:var(--danger); }
        .status-badge.open .sdot{ background:var(--danger); animation:pulseGlow 1.6s ease-in-out infinite; }
        .status-badge.in_progress{ background:rgba(240,162,90,.14); color:#F0A25A; }
        .status-badge.in_progress .sdot{ background:#F0A25A; }
        .status-badge.closed{ background:rgba(var(--emerald-rgb),.14); color:var(--emerald); }
        .status-badge.closed .sdot{ background:var(--emerald); }
        .inbox-time{ font-size:11px; color:var(--text-faint); }

        .empty-state{ text-align:center; padding:64px 30px; }
        .empty-ic{ width:56px; height:56px; border-radius:16px; background:rgba(var(--emerald-rgb),.12); border:1px solid rgba(var(--emerald-rgb),.25); display:flex; align-items:center; justify-content:center; color:var(--emerald); margin:0 auto 16px; }
        .empty-ic .icon{ width:24px; height:24px; }

        .pagination-wrap{ margin-top:20px; }

        @media (max-width:700px){
            .inbox-snippet{ max-width:200px; }
            .inbox-row{ flex-wrap:wrap; }
        }
    </style>

    <div class="tiw">
        <div class="tiw-head animate-in" style="animation-delay:.03s;">
            <h1>Support / Tiket</h1>
            <p>Kelola permintaan bantuan dari user dan company yang terdaftar.</p>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay:.05s;">{{ session('success') }}</div>
        @endif

        <div class="stat-pills animate-in" style="animation-delay:.06s;">
            <a href="{{ route('admin.tickets.index') }}" class="s-pill total {{ !request('status') ? 'active' : '' }}">
                <span class="ic"><svg class="icon"><use href="#ic-inbox"/></svg></span>
                <div><div class="val">{{ $stats['total'] }}</div><div class="lbl">Semua</div></div>
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="s-pill open {{ request('status')==='open' ? 'active' : '' }}">
                <span class="ic"><svg class="icon"><use href="#ic-help"/></svg></span>
                <div><div class="val">{{ $stats['open'] }}</div><div class="lbl">Terbuka</div></div>
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}" class="s-pill progress {{ request('status')==='in_progress' ? 'active' : '' }}">
                <span class="ic"><svg class="icon"><use href="#ic-clock"/></svg></span>
                <div><div class="val">{{ $stats['in_progress'] }}</div><div class="lbl">Diproses</div></div>
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="s-pill closed {{ request('status')==='closed' ? 'active' : '' }}">
                <span class="ic"><svg class="icon"><use href="#ic-check-circle"/></svg></span>
                <div><div class="val">{{ $stats['closed'] }}</div><div class="lbl">Selesai</div></div>
            </a>
        </div>

        <div class="tiw-filter animate-in" style="animation-delay:.09s;">
            <form method="GET" action="{{ route('admin.tickets.index') }}">
                <div class="search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari subjek tiket...">
                </div>
                <input type="hidden" name="status" value="{{ request('status') }}">
                <select name="priority" onchange="this.form.submit()">
                    <option value="">Semua Prioritas</option>
                    <option value="high" {{ request('priority')==='high' ? 'selected':'' }}>Tinggi</option>
                    <option value="medium" {{ request('priority')==='medium' ? 'selected':'' }}>Sedang</option>
                    <option value="low" {{ request('priority')==='low' ? 'selected':'' }}>Rendah</option>
                </select>
                <button type="submit" class="btn-sm">Cari</button>
                @if(request()->anyFilled(['q','priority']))
                    <a href="{{ route('admin.tickets.index', ['status' => request('status')]) }}" class="btn-sm">Reset</a>
                @endif
            </form>
        </div>

        <div class="inbox-list">
            @forelse($tickets as $i => $ticket)
                <a href="{{ route('admin.tickets.show', $ticket) }}" class="inbox-row st-{{ $ticket->status }} pri-{{ $ticket->priority }} animate-in" style="animation-delay:{{ .12 + ($i * .03) }}s;">
                    <div class="inbox-ic"><svg class="icon"><use href="#ic-message"/></svg></div>
                    <div class="inbox-body">
                        <div class="inbox-top">
                            <span class="inbox-subject">{{ $ticket->subject }}</span>
                            <span class="inbox-cat">{{ $ticket->categoryLabel() }}</span>
                        </div>
                        <div class="inbox-snippet">{{ Str::limit($ticket->message, 90) }}</div>
                        <div class="inbox-meta">
                            <span>{{ $ticket->user->name ?? 'User terhapus' }}</span>
                            <span class="dot-sep"></span>
                            <span>{{ $ticket->company->name ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="inbox-right">
                        <span class="status-badge {{ $ticket->status }}"><span class="sdot"></span>{{ $ticket->statusLabel() }}</span>
                        <span class="inbox-time">{{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                    <h3 style="font-family:'Space Grotesk'; font-size:16px; margin-bottom:4px;">Belum ada tiket</h3>
                    <p style="font-size:13px; color:var(--text-mute);">Tiket bantuan yang masuk akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">
            {{ $tickets->onEachSide(1)->links() }}
        </div>
    </div>
</x-admin-layout>