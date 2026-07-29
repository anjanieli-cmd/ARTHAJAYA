<x-admin-layout>
    <x-slot name="title">Detail Tiket</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>
            </symbol>
            <symbol id="ic-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41L11 22 2 13l9-9h9v9z"/><circle cx="7" cy="7" r="1"/>
            </symbol>
            <symbol id="ic-flag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .tsw{ --accent: var(--emerald); color:var(--text); }
        .tsw *{ box-sizing:border-box; }
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes bubbleLeft{ from{ opacity:0; transform:translateX(-14px);} to{ opacity:1; transform:translateX(0);} }
        @keyframes bubbleRight{ from{ opacity:0; transform:translateX(14px);} to{ opacity:1; transform:translateX(0);} }
        .tsw .animate-in{ animation:fadeSlideUp .45s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .tsw .bubble-left{ animation:bubbleLeft .4s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .tsw .bubble-right{ animation:bubbleRight .4s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        .tsw-back{ display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color:var(--text-mute); margin-bottom:16px; text-decoration:none; }
        .tsw-back:hover{ color:var(--text); }
        .tsw-back .icon{ width:14px; height:14px; }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        .tsw-layout{ display:grid; grid-template-columns:1fr 300px; gap:16px; align-items:start; }

        /* ===== CHAT PANEL ===== */
        .chat-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; overflow:hidden; display:flex; flex-direction:column; height:calc(100vh - 200px); min-height:500px; }
        .chat-head{ padding:20px 24px; border-bottom:1px solid var(--border); }
        .chat-head h2{ font-family:'Space Grotesk', sans-serif; font-size:17px; margin-bottom:4px; }
        .chat-head .sub{ font-size:12px; color:var(--text-faint); }

        .chat-body{ flex:1; overflow-y:auto; padding:24px; display:flex; flex-direction:column; gap:16px; }
        .bubble-row{ display:flex; gap:10px; max-width:80%; }
        .bubble-row.from-user{ align-self:flex-start; }
        .bubble-row.from-admin{ align-self:flex-end; flex-direction:row-reverse; }
        .bubble-avatar{ width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
        .from-user .bubble-avatar{ background:var(--surface-strong); color:var(--text-mute); }
        .from-admin .bubble-avatar{ background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); color:#052117; }
        .bubble-content{ display:flex; flex-direction:column; gap:4px; }
        .bubble-name{ font-size:11px; color:var(--text-faint); padding:0 4px; }
        .from-admin .bubble-name{ text-align:right; }
        .bubble-text{ padding:12px 16px; border-radius:16px; font-size:13.5px; line-height:1.5; }
        .from-user .bubble-text{ background:var(--surface-strong); border-bottom-left-radius:4px; }
        .from-admin .bubble-text{ background:rgba(var(--emerald-rgb),.14); color:var(--text); border-bottom-right-radius:4px; }
        .bubble-time{ font-size:10.5px; color:var(--text-faint); padding:0 4px; }
        .from-admin .bubble-time{ text-align:right; }

        .chat-input{ padding:16px 20px; border-top:1px solid var(--border); display:flex; gap:10px; align-items:flex-end; }
        .chat-input textarea{
            flex:1; padding:12px 14px; border-radius:14px; background:var(--surface-strong); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none; resize:none; font-family:inherit; min-height:44px; max-height:120px;
        }
        .chat-input textarea:focus{ border-color:var(--border-hover); }
        .send-btn{
            width:44px; height:44px; border-radius:14px; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim));
            color:#052117; border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0; transition:transform .18s ease;
        }
        .send-btn:hover{ transform:scale(1.06); }
        .send-btn .icon{ width:18px; height:18px; }
        .closed-notice{ padding:14px 20px; text-align:center; font-size:12.5px; color:var(--text-faint); border-top:1px solid var(--border); }

        /* ===== META SIDEBAR ===== */
        .meta-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; }
        .meta-panel h3{ font-family:'Space Grotesk', sans-serif; font-size:14px; margin-bottom:16px; }
        .meta-row{ display:flex; align-items:center; gap:10px; padding:10px 0; border-top:1px solid var(--border); }
        .meta-row:first-of-type{ border-top:none; }
        .meta-ic{ width:32px; height:32px; border-radius:9px; background:var(--surface-strong); color:var(--text-mute); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .meta-ic .icon{ width:14px; height:14px; }
        .meta-body .k{ font-size:10.5px; color:var(--text-faint); }
        .meta-body .v{ font-size:12.5px; font-weight:600; }

        .status-select-wrap{ margin-top:18px; padding-top:18px; border-top:1px dashed var(--border); }
        .status-select-wrap label{ font-size:11.5px; font-weight:600; color:var(--text-mute); display:block; margin-bottom:8px; }
        .status-select-wrap select{
            width:100%; padding:11px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
            color:var(--text); font-size:13px; outline:none; appearance:none;
            background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat:no-repeat; background-position:right 14px center; background-size:14px; padding-right:38px;
        }

        .btn-danger-ghost{ width:100%; margin-top:14px; padding:11px; border-radius:12px; background:none; border:1px solid rgba(232,90,90,.3); color:var(--danger); font-size:12.5px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:7px; transition:all .18s ease; }
        .btn-danger-ghost:hover{ background:rgba(232,90,90,.1); }
        .btn-danger-ghost .icon{ width:13px; height:13px; }

        @media (max-width:1000px){
            .tsw-layout{ grid-template-columns:1fr; }
            .chat-panel{ height:auto; min-height:400px; }
        }
    </style>

    <div class="tsw">
        <a href="{{ route('admin.tickets.index') }}" class="tsw-back animate-in" style="animation-delay:.03s;">
            <svg class="icon"><use href="#ic-arrow-left"/></svg> Kembali ke Support / Tiket
        </a>

        @if(session('success'))
            <div class="alert-success animate-in" style="animation-delay:.05s;">{{ session('success') }}</div>
        @endif

        <div class="tsw-layout">
            <div class="chat-panel animate-in" style="animation-delay:.08s;">
                <div class="chat-head">
                    <h2>{{ $ticket->subject }}</h2>
                    <div class="sub">Dibuka oleh {{ $ticket->user->name ?? 'User terhapus' }} — {{ $ticket->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>

                <div class="chat-body">
                    <div class="bubble-row from-user bubble-left" style="animation-delay:.1s;">
                        <div class="bubble-avatar">{{ strtoupper(substr($ticket->user->name ?? '?', 0, 1)) }}</div>
                        <div class="bubble-content">
                            <div class="bubble-name">{{ $ticket->user->name ?? 'User' }}</div>
                            <div class="bubble-text">{{ $ticket->message }}</div>
                            <div class="bubble-time">{{ $ticket->created_at->translatedFormat('d M, H:i') }}</div>
                        </div>
                    </div>

                    @foreach($ticket->replies as $i => $reply)
                        <div class="bubble-row {{ $reply->is_admin_reply ? 'from-admin bubble-right' : 'from-user bubble-left' }}" style="animation-delay:{{ .14 + ($i * .05) }}s;">
                            <div class="bubble-avatar">{{ strtoupper(substr($reply->user->name ?? ($reply->is_admin_reply ? 'A' : '?'), 0, 1)) }}</div>
                            <div class="bubble-content">
                                <div class="bubble-name">{{ $reply->is_admin_reply ? ($reply->user->name ?? 'Admin') : ($reply->user->name ?? 'User') }}</div>
                                <div class="bubble-text">{{ $reply->message }}</div>
                                <div class="bubble-time">{{ $reply->created_at->translatedFormat('d M, H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($ticket->status !== 'closed')
                    <form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}" class="chat-input">
                        @csrf
                        <textarea name="message" placeholder="Tulis balasan..." required onkeydown="if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); this.form.submit(); }"></textarea>
                        <button type="submit" class="send-btn"><svg class="icon"><use href="#ic-send"/></svg></button>
                    </form>
                @else
                    <div class="closed-notice">Tiket ini sudah ditutup. Ubah status di panel kanan untuk membuka kembali percakapan.</div>
                @endif
            </div>

            <div class="meta-panel animate-in" style="animation-delay:.12s;">
                <h3>Detail Tiket</h3>

                <div class="meta-row">
                    <div class="meta-ic"><svg class="icon"><use href="#ic-building"/></svg></div>
                    <div class="meta-body"><div class="k">Company</div><div class="v">{{ $ticket->company->name ?? '—' }}</div></div>
                </div>
                <div class="meta-row">
                    <div class="meta-ic"><svg class="icon"><use href="#ic-tag"/></svg></div>
                    <div class="meta-body"><div class="k">Kategori</div><div class="v">{{ $ticket->categoryLabel() }}</div></div>
                </div>
                <div class="meta-row">
                    <div class="meta-ic"><svg class="icon"><use href="#ic-flag"/></svg></div>
                    <div class="meta-body"><div class="k">Prioritas</div><div class="v">{{ $ticket->priorityLabel() }}</div></div>
                </div>

                <div class="status-select-wrap">
                    <form method="POST" action="{{ route('admin.tickets.status', $ticket) }}" onchange="this.submit()">
                        @csrf
                        @method('PUT')
                        <label>Status Tiket</label>
                        <select name="status">
                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Terbuka</option>
                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>Diproses</option>
                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>
                </div>

                <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}" onsubmit="return confirm('Hapus tiket ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger-ghost"><svg class="icon"><use href="#ic-trash"/></svg> Hapus Tiket</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var chatBody = document.querySelector('.chat-body');
            if(chatBody) chatBody.scrollTop = chatBody.scrollHeight;
        });
    </script>
</x-admin-layout>