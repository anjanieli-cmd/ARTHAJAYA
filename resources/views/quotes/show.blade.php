<x-app-layout>
    <x-slot name="title">Penawaran {{ $quote->quote_number }}</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </symbol>
            <symbol id="ic-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="12" y2="14"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </symbol>
            <symbol id="ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="ic-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </symbol>
        </defs>
    </svg>

    @php
        $statusMeta = [
            'draft' => ['label' => 'Draft', 'class' => 'st-draft', 'icon' => 'ic-file-text'],
            'sent' => ['label' => 'Terkirim', 'class' => 'st-sent', 'icon' => 'ic-send'],
            'accepted' => ['label' => 'Diterima', 'class' => 'st-accepted', 'icon' => 'ic-check-circle'],
            'rejected' => ['label' => 'Ditolak', 'class' => 'st-rejected', 'icon' => 'ic-x'],
            'expired' => ['label' => 'Kadaluwarsa', 'class' => 'st-expired', 'icon' => 'ic-alert-triangle'],
        ];
        
        $isExpired = $quote->status === 'sent' && $quote->valid_until && $quote->valid_until->isPast();
        $statusKey = $isExpired ? 'expired' : $quote->status;
        $st = $statusMeta[$statusKey] ?? $statusMeta['draft'];
        $overdueDays = $isExpired ? $quote->valid_until->diffInDays(now()) : 0;
    @endphp

    <style>
        .quote-detail-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .quote-detail-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        .quote-detail-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== BREADCRUMB ===== */
        .breadcrumb{
            display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); margin-bottom:20px;
        }
        .breadcrumb a{ color:var(--text-secondary); text-decoration:none; transition:color .2s ease; }
        .breadcrumb a:hover{ color:var(--text); }
        .breadcrumb .sep{ color:var(--text-faint); }
        .breadcrumb .current{ color:var(--text); font-weight:600; }

        /* ===== HEADER ===== */
        .page-head{
            display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:28px;
        }
        .page-head-left{ flex:1; min-width:200px; }
        .page-head h1{
            font-size:28px; font-weight:700; margin:0 0 4px; letter-spacing:-.02em;
            display:flex; align-items:center; gap:12px; flex-wrap:wrap;
        }
        .page-head h1 .quote-number{
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background:var(--surface-hover); padding:4px 16px; border-radius:8px;
            font-size:20px; font-weight:700; color:var(--text);
            border:1px solid var(--border);
        }
        .page-head p{
            font-size:14px; color:var(--text-muted); margin:0;
            display:flex; align-items:center; gap:6px;
        }
        .page-head p .icon{ width:14px; height:14px; color:var(--text-muted); }

        .head-actions{ display:flex; gap:10px; flex-wrap:wrap; }

        /* ===== BUTTONS ===== */
        .btn{
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:11px 22px; border-radius:var(--radius-sm); font-size:13.5px; font-weight:600;
            cursor:pointer; border:none; transition:all .22s cubic-bezier(.16,1,.3,1);
            white-space:nowrap; text-decoration:none; position:relative; overflow:hidden;
        }
        .btn .icon{ width:16px; height:16px; flex-shrink:0; }
        .btn-primary{
            background:linear-gradient(135deg, var(--accent), var(--accent-dim));
            color:#052117; box-shadow:0 4px 18px var(--accent-glow);
        }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 28px var(--accent-glow); }
        .btn-outline{
            background:var(--surface); border:1px solid var(--border); color:var(--text);
        }
        .btn-outline:hover{
            background:var(--surface-strong); border-color:var(--border-hover); transform:translateY(-2px);
        }
        .btn-danger{
            background:var(--danger); color:#fff; border:1px solid var(--danger);
        }
        .btn-danger:hover{
            background:var(--danger-hover); transform:translateY(-2px); box-shadow:0 8px 22px rgba(var(--danger-rgb),0.35);
        }
        .btn-sm{ padding:8px 16px; font-size:12.5px; }

        /* ===== STATUS BADGE ===== */
        .status-badge{
            display:inline-flex; align-items:center; gap:8px;
            padding:6px 16px; border-radius:100px; font-size:12.5px; font-weight:700; letter-spacing:.02em;
            transition:all .2s ease;
        }
        .status-badge .sdot{
            width:8px; height:8px; border-radius:50%; flex-shrink:0;
        }
        .status-badge .icon{ width:14px; height:14px; }
        .st-draft{ background:var(--surface-hover); color:var(--text-muted); }
        .st-draft .sdot{ background:var(--text-muted); }
        .st-sent{ background:rgba(var(--info-rgb),0.12); color:var(--info); }
        .st-sent .sdot{ background:var(--info); }
        .st-accepted{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
        .st-accepted .sdot{ background:var(--emerald); }
        .st-rejected{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
        .st-rejected .sdot{ background:var(--danger); }
        .st-expired{ background:rgba(var(--warning-rgb),0.12); color:var(--warning); }
        .st-expired .sdot{ background:var(--warning); animation:pulseGlow 1.6s ease-in-out infinite; }

        /* ===== EXPIRED BANNER ===== */
        .expired-banner{
            display:flex; align-items:center; gap:12px;
            background:rgba(var(--warning-rgb),0.08); border:1px solid rgba(var(--warning-rgb),0.25);
            border-radius:var(--radius-md); padding:14px 20px; margin-bottom:20px;
        }
        .expired-banner .icon{ width:20px; height:20px; color:var(--warning); flex-shrink:0; }
        .expired-banner .text{ font-size:13.5px; color:var(--text); }
        .expired-banner .text strong{ color:var(--warning); }

        /* ===== MAIN CARD ===== */
        .main-card{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .main-card-header{
            padding:24px 32px; border-bottom:1px solid var(--border);
            display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;
        }
        .main-card-header .left{ display:flex; align-items:center; gap:14px; }
        .main-card-header .left .icon-wrap{
            width:44px; height:44px; border-radius:12px;
            background:var(--accent-soft); color:var(--accent);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .main-card-header .left .icon-wrap .icon{ width:20px; height:20px; }
        .main-card-header .left h2{
            font-size:16px; font-weight:600; color:var(--text); margin:0;
        }
        .main-card-header .left p{
            font-size:13px; color:var(--text-muted); margin:2px 0 0;
        }

        .main-card-body{ padding:32px; }

        /* ===== AMOUNT HERO ===== */
        .amount-hero{
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            font-size:38px; font-weight:800;
            letter-spacing:-.02em; color:var(--text); margin:4px 0;
            padding:12px 20px;
            background:var(--surface-hover);
            border-radius:var(--radius-sm);
            border:1px solid var(--border);
            display:inline-block;
        }
        .amount-hero .currency{ 
            font-size:24px; 
            color:var(--text-muted); 
            margin-right:6px;
            font-weight:600;
        }

        /* ===== DETAIL GRID ===== */
        .detail-grid{
            display:grid; grid-template-columns:repeat(3,1fr); gap:20px 28px; margin-top:24px;
        }
        .detail-item{
            padding:16px 20px; background:var(--surface-hover); border-radius:var(--radius-sm);
            border:1px solid var(--border); transition:all .2s ease;
        }
        .detail-item:hover{ border-color:var(--border-hover); }
        .detail-item .k{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-muted); font-weight:600; margin-bottom:6px;
            display:flex; align-items:center; gap:6px;
        }
        .detail-item .k .icon{ width:13px; height:13px; color:var(--text-muted); }
        
        /* ===== FIX: DETAIL VALUE JELAS ===== */
        .detail-item .v{
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            font-size:16px; 
            font-weight:700; 
            color:var(--text);
            letter-spacing:0.3px;
        }
        .detail-item .v.mono{
            font-family: 'JetBrains Mono', 'Fira Code', 'IBM Plex Mono', monospace;
            font-size:15px;
            font-weight:700;
            color:var(--text);
            background:var(--surface);
            padding:2px 12px;
            border-radius:6px;
            display:inline-block;
            border:1px solid var(--border);
        }
        .detail-item .v .sub{
            font-size:12px; 
            font-weight:400; 
            color:var(--text-muted);
            margin-left:6px;
        }

        /* ===== NOTES ===== */
        .notes-section{ margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
        .notes-section .label{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-muted); font-weight:600; margin-bottom:8px;
            display:flex; align-items:center; gap:6px;
        }
        .notes-section .label .icon{ width:14px; height:14px; }
        .notes-box{
            background:var(--surface-hover); border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:16px 20px;
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            font-size:14px; 
            color:var(--text-secondary); 
            line-height:1.7;
        }

        /* ===== MODAL ===== */
        .modal-overlay{
            position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(8px);
            z-index:999; display:none; align-items:center; justify-content:center; padding:20px;
        }
        .modal-overlay.open{ display:flex; }
        @keyframes modalSlideUp{
            from{ opacity:0; transform:translateY(24px) scale(.96);}
            to{ opacity:1; transform:translateY(0) scale(1);}
        }
        .modal-box{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            padding:32px 36px; max-width:420px; width:100%;
            box-shadow:0 40px 90px rgba(0,0,0,0.5);
            animation:modalSlideUp .3s cubic-bezier(.16,1,.3,1); text-align:center;
        }
        .modal-ic{
            width:56px; height:56px; border-radius:50%;
            background:rgba(var(--danger-rgb),0.12); color:var(--danger);
            display:flex; align-items:center; justify-content:center; margin:0 auto 16px;
        }
        .modal-ic .icon{ width:26px; height:26px; }
        .modal-box h3{
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            font-size:18px; font-weight:700; margin-bottom:8px; color:var(--text);
        }
        .modal-box p{
            font-size:13.5px; color:var(--text-muted); margin-bottom:6px; line-height:1.6;
        }
        .modal-box p b{
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            font-weight:700; color:var(--text);
            background:var(--surface-hover); padding:4px 14px; border-radius:6px; 
            display:inline-block; margin-top:4px;
            border:1px solid var(--border);
        }
        .modal-warn{
            font-size:12.5px; color:var(--danger); font-weight:600;
            margin-top:14px; padding:10px 16px;
            background:rgba(var(--danger-rgb),0.08); border-radius:10px; display:inline-block;
        }
        .modal-actions{ display:flex; gap:10px; justify-content:center; margin-top:22px; }
        .modal-actions .btn{ flex:1; justify-content:center; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px){ 
            .detail-grid{ grid-template-columns:1fr 1fr; }
            .amount-hero{ font-size:30px; }
        }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .main-card-header{ flex-direction:column; align-items:stretch; }
            .main-card-body{ padding:20px; }
            .detail-grid{ grid-template-columns:1fr; gap:12px; }
            .amount-hero{ font-size:26px; display:block; text-align:center; }
            .modal-box{ padding:24px 20px; }
            .page-head h1{ font-size:22px; flex-direction:column; align-items:flex-start; }
            .page-head h1 .quote-number{ font-size:16px; }
        }
        @media (max-width: 480px){
            .main-card-header .left{ flex-wrap:wrap; }
            .amount-hero{ font-size:22px; padding:10px 16px; }
            .detail-item .v{ font-size:14px; }
            .detail-item .v.mono{ font-size:13px; }
        }
    </style>

    <div class="quote-detail-wrap">

        {{-- ===== BREADCRUMB ===== --}}
        <div class="breadcrumb animate-in" style="animation-delay:.02s;">
            <a href="{{ route('quotes.index') }}">Penawaran</a>
            <span class="sep">›</span>
            <span class="current">#{{ $quote->quote_number }}</span>
        </div>

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>
                    <span>Detail Penawaran</span>
                    <span class="quote-number">{{ $quote->quote_number }}</span>
                </h1>
                <p>
                    <svg class="icon"><use href="#ic-user"/></svg>
                    Dibuat untuk <strong>{{ $quote->client->name ?? 'klien terhapus' }}</strong>
                    @if($quote->client->company_name ?? null)
                        · {{ $quote->client->company_name }}
                    @endif
                </p>
            </div>
            <div class="head-actions">
                <a href="{{ route('quotes.index') }}" class="btn btn-outline btn-sm">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-primary btn-sm">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
                <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('deleteModal').classList.add('open')">
                    <svg class="icon"><use href="#ic-trash"/></svg>
                    Hapus
                </button>
            </div>
        </div>

        {{-- ===== EXPIRED BANNER ===== --}}
        @if($isExpired)
            <div class="expired-banner animate-in" style="animation-delay:.08s;">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
                <div class="text">
                    <strong>⚠️ Penawaran telah kadaluwarsa!</strong> 
                    Melewati masa berlaku {{ $overdueDays }} hari yang lalu 
                    ({{ $quote->valid_until->translatedFormat('d M Y') }})
                </div>
            </div>
        @endif

        {{-- ===== MAIN CARD ===== --}}
        <div class="main-card animate-in" style="animation-delay:.10s;">

            {{-- Card Header --}}
            <div class="main-card-header">
                <div class="left">
                    <div class="icon-wrap">
                        <svg class="icon"><use href="#ic-file-text"/></svg>
                    </div>
                    <div>
                        <h2>Informasi Penawaran</h2>
                        <p>Detail lengkap penawaran #{{ $quote->quote_number }}</p>
                    </div>
                </div>
                <div>
                    <span class="status-badge {{ $st['class'] }}">
                        <span class="sdot"></span>
                        <svg class="icon"><use href="#{{ $st['icon'] }}"/></svg>
                        {{ $st['label'] }}
                    </span>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="main-card-body">

                {{-- Amount Hero --}}
                <div class="amount-hero">
                    <span class="currency">Rp</span>{{ number_format($quote->total ?? 0, 0, ',', '.') }}
                </div>

                {{-- Detail Grid --}}
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-user"/></svg> Klien</div>
                        <div class="v">{{ $quote->client->name ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-building"/></svg> Perusahaan</div>
                        <div class="v">{{ $quote->client->company_name ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-calendar"/></svg> Tanggal Penawaran</div>
                        <div class="v">{{ optional($quote->issue_date)->translatedFormat('d M Y') ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-clock"/></svg> Berlaku Sampai</div>
                        <div class="v">
                            {{ optional($quote->valid_until)->translatedFormat('d M Y') ?? '—' }}
                            @if($isExpired)
                                <span class="sub">(Kadaluwarsa {{ $overdueDays }} hari lalu)</span>
                            @endif
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-dollar"/></svg> Subtotal</div>
                        <div class="v mono">Rp{{ number_format($quote->subtotal ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="k"><svg class="icon"><use href="#ic-file-text"/></svg> Pajak</div>
                        <div class="v mono">Rp{{ number_format($quote->tax_amount ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Notes --}}
                @if($quote->notes)
                    <div class="notes-section">
                        <div class="label">
                            <svg class="icon"><use href="#ic-file-text"/></svg>
                            Catatan
                        </div>
                        <div class="notes-box">{{ $quote->notes }}</div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-ic">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
            </div>
            <h3>Hapus Penawaran Ini?</h3>
            <p>Penawaran <br><b>{{ $quote->quote_number }}</b></p>
            <p style="margin-top:4px;">akan dihapus permanen dan tidak bisa dikembalikan.</p>
            <div class="modal-warn">⚠️ Klien tidak akan bisa lagi mengakses tautan penawaran ini.</div>
            <form method="POST" action="{{ route('quotes.destroy', $quote) }}">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal').classList.remove('open')">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ===== Modal =====
        document.getElementById('deleteModal').addEventListener('click', function(e){
            if(e.target === this) this.classList.remove('open');
        });

        // ===== ESC =====
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape'){
                document.getElementById('deleteModal').classList.remove('open');
            }
        });
    </script>
</x-app-layout>