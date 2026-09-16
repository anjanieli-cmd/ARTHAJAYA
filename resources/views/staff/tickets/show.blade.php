<x-app-layout>
    <x-slot name="title">Detail Tiket</x-slot>

    <svg style="display:none;">
        <defs>
            <symbol id="tkts-ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="tkts-ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="tkts-ic-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41L11 22 2 13l9-9h9v9z"/><circle cx="7" cy="7" r="1"/>
            </symbol>
            <symbol id="tkts-ic-flag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/>
            </symbol>
            <symbol id="tkts-ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .tkts{ --accent: var(--emerald); color:var(--text); padding:0 24px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .tkts *{ box-sizing:border-box; }
        @keyframes tktsFadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes tktsBubbleLeft{ from{ opacity:0; transform:translateX(-14px);} to{ opacity:1; transform:translateX(0);} }
        @keyframes tktsBubbleRight{ from{ opacity:0; transform:translateX(14px);} to{ opacity:1; transform:translateX(0);} }
        .tkts .animate-in{ animation:tktsFadeSlideUp .45s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .tkts .bubble-left{ animation:tktsBubbleLeft .4s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .tkts .bubble-right{ animation:tktsBubbleRight .4s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .tkts .icon{ width:16px; height:16px; flex-shrink:0; }

        .tkts-back{ display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color:var(--text-mute); margin-bottom:16px; text-decoration:none; }
        .tkts-back:hover{ color:var(--text); }
        .tkts-back .icon{ width:14px; height:14px; }

        .tkts-alert-success{ background:rgba(52,181,131,.1); border:1px solid rgba(52,181,131,.3); color:#34B583; padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }
        .tkts-alert-error{ background:rgba(232,90,90,.1); border:1px solid rgba(232,90,90,.3); color:#E85A5A; padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        .tkts-layout{ display:grid; grid-template-columns:1fr 300px; gap:16px; align-items:start; }

        .chat-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; overflow:hidden; display:flex; flex-direction:column; height:calc(100vh - 200px); min-height:500px; }
        .chat-head{ padding:20px 24px; border-bottom:1px solid var(--border); }
        .chat-head h2{ font-size:17px; margin:0 0 4px; font-weight:700; }
        .chat-head .sub{ font-size:12px; color:var(--text-faint); }

        .chat-body{ flex:1; overflow-y:auto; padding:24px; display:flex; flex-direction:column; gap:16px; }
        .bubble-row{ display:flex; gap:10px; max-width:80%; }
        .bubble-row.from-admin{ align-self:flex-start; }
        .bubble-row.from-me{ align-self:flex-end; flex-direction:row-reverse; }
        .bubble-avatar{ width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
        .from-admin .bubble-avatar{ background:var(--surface-strong); color:var(--text-mute); }
        .from-me .bubble-avatar{ background:linear-gradient(135deg,var(--emerald),var(--emerald-dim)); color:#052117; }
        .bubble-content{ display:flex; flex-direction:column; gap:4px; }
        .bubble-name{ font-size:11px; color:var(--text-faint); padding:0 4px; }
        .from-me .bubble-name{ text-align:right; }
        .bubble-text{ padding:12px 16px; border-radius:16px; font-size:13.5px; line-height:1.5; }
        .from-admin .bubble-text{ background:var(--surface-strong); border-bottom-left-radius:4px; }
        .from-me .bubble-text{ background:rgba(52,181,131,.14); color:var(--text); border-bottom-right-radius:4px; }
        .bubble-time{ font-size:10.5px; color:var(--text-faint); padding:0 4px; }
        .from-me .bubble-time{ text-align:right; }

        .chat-input{ padding:16px 20px; border-top:1px solid var(--border); display:flex; gap:10px; align-items:flex-end; }
        .chat-input textarea{
            flex:1; padding:12px 14px; border-radius:14px; background:var(--surface-strong); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none; resize:none; font-family:inherit; min-height:44px; max-height:120px;
        }
        .chat-input textarea:focus{ border-color:var(--emerald); }
        .send-btn{
            width:44px; height:44px; border-radius:14px; background:linear-gradient(135deg,var(--emerald),var(--emerald-dim));
            color:#052117; border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0; transition:transform .18s ease;
        }
        .send-btn:hover{ transform:scale(1.06); }
        .closed-notice{ padding:14px 20px; text-align:center; font-size:12.5px; color:var(--text-faint); border-top:1px solid var(--border); }

        .meta-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; }
        .meta-panel h3{ font-size:14px; margin:0 0 16px; font-weight:700; }
        .meta-row{ display:flex; align-items:center; gap:10px; padding:10px 0; border-top:1px solid var(--border); }
        .meta-row:first-of-type{ border-top:none; }
        .meta-ic{ width:32px; height:32px; border-radius:9px; background:var(--surface-strong); color:var(--text-mute); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .meta-ic .icon{ width:14px; height:14px; }
        .meta-body .k{ font-size:10.5px; color:var(--text-faint); }
        .meta-body .v{ font-size:12.5px; font-weight:600; }

        .tkts-status-wrap{ margin-top:18px; padding-top:18px; border-top:1px dashed var(--border); }
        .tkts-status-wrap label{ font-size:11.5px; font-weight:600; color:var(--text-mute); display:block; margin-bottom:8px; }
        .tkts-status{ font-size:11px; font-weight:700; padding:6px 14px; border-radius:100px; display:inline-block; text-transform:uppercase; letter-spacing:.04em; }
        .tkts-status.open{ background:rgba(52,181,131,.14); color:#34B583; }
        .tkts-status.in_progress{ background:rgba(232,178,58,.14); color:#E8B23A; }
        .tkts-status.closed{ background:rgba(255,255,255,.06); color:var(--text-faint); }

        @media (max-width:1000px){
            .tkts-layout{ grid-template-columns:1fr; }
            .chat-panel{ height:auto; min-height:400px; }
        }
    </style>

    <div class="tkts">
        <a href="{{ route('staff.tickets.index') }}" class="tkts-back animate-in" style="animation-delay:.03s;">
            <svg class="icon"><use href="#tkts-ic-arrow-left"/></svg> Kembali ke Tiket Saya
        </a>

        @if(session('success'))
            <div class="tkts-alert-success animate-in" style="animation-delay:.05s;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="tkts-alert-error animate-in" style="animation-delay:.05s;">{{ session('error') }}</div>
        @endif

        <div class="tkts-layout">
            <div class="chat-panel animate-in" style="animation-delay:.08s;">
                <div class="chat-head">
                    <h2>{{ $ticket->subject }}</h2>
                    <div class="sub">Dibuka {{ $ticket->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>

                <div class="chat-body">
                    <div class="bubble-row from-me bubble-right" style="animation-delay:.1s;">
                        <div class="bubble-avatar">{{ strtoupper(substr(auth()->user()->name ?? '?', 0, 1)) }}</div>
                        <div class="bubble-content">
                            <div class="bubble-name">Kamu</div>
                            <div class="bubble-text">{{ $ticket->message }}</div>
                            <div class="bubble-time">{{ $ticket->created_at->translatedFormat('d M, H:i') }}</div>
                        </div>
                    </div>

                    @foreach($ticket->replies as $i => $reply)
                        <div class="bubble-row {{ $reply->is_admin_reply ? 'from-admin bubble-left' : 'from-me bubble-right' }}" style="animation-delay:{{ .14 + ($i * .05) }}s;">
                            <div class="bubble-avatar">{{ strtoupper(substr($reply->user->name ?? ($reply->is_admin_reply ? 'A' : '?'), 0, 1)) }}</div>
                            <div class="bubble-content">
                                <div class="bubble-name">{{ $reply->is_admin_reply ? ($reply->user->name ?? 'Admin') : 'Kamu' }}</div>
                                <div class="bubble-text">{{ $reply->message }}</div>
                                <div class="bubble-time">{{ $reply->created_at->translatedFormat('d M, H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($ticket->status !== 'closed')
                    <form method="POST" action="{{ route('staff.tickets.reply', $ticket) }}" class="chat-input">
                        @csrf
                        <textarea name="message" placeholder="Tulis balasan..." required onkeydown="if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); this.form.submit(); }"></textarea>
                        <button type="submit" class="send-btn"><svg class="icon"><use href="#tkts-ic-send"/></svg></button>
                    </form>
                @else
                    <div class="closed-notice">Tiket ini sudah ditutup admin. Buat tiket baru kalau masih ada kendala.</div>
                @endif
            </div>

            <div class="meta-panel animate-in" style="animation-delay:.12s;">
                <h3>Detail Tiket</h3>

                <div class="meta-row">
                    <div class="meta-ic"><svg class="icon"><use href="#tkts-ic-tag"/></svg></div>
                    <div class="meta-body"><div class="k">Kategori</div><div class="v">{{ $ticket->categoryLabel() }}</div></div>
                </div>
                <div class="meta-row">
                    <div class="meta-ic"><svg class="icon"><use href="#tkts-ic-flag"/></svg></div>
                    <div class="meta-body"><div class="k">Prioritas</div><div class="v">{{ $ticket->priorityLabel() }}</div></div>
                </div>
                <div class="meta-row">
                    <div class="meta-ic"><svg class="icon"><use href="#tkts-ic-clock"/></svg></div>
                    <div class="meta-body"><div class="k">Dibuka</div><div class="v">{{ $ticket->created_at->translatedFormat('d M Y') }}</div></div>
                </div>

                <div class="tkts-status-wrap">
                    <label>Status Tiket</label>
                    <span class="tkts-status {{ $ticket->status }}">{{ $ticket->statusLabel() }}</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var chatBody = document.querySelector('.chat-body');
            if(chatBody) chatBody.scrollTop = chatBody.scrollHeight;
        });
    </script>
</x-app-layout>