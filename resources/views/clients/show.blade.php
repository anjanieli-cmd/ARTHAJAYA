<x-app-layout>
    <x-slot name="title">{{ $client->name }}</x-slot>

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
            <symbol id="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </symbol>
            <symbol id="ic-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
            </symbol>
            <symbol id="ic-map-pin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="ic-file-invoice" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
            </symbol>
            <symbol id="ic-file-quote" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
            <symbol id="ic-chevron-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </symbol>
        </defs>
    </svg>

    @php
        $colors = ['#EC4C93', '#34B583', '#F0A83C', '#4E8FF0', '#9B7BE0', '#E85A5A'];
        $avColor = $colors[abs(crc32($client->name)) % count($colors)];
        
        $statusLabels = [
            'draft' => ['label' => 'Draft', 'class' => 'status-draft'],
            'sent' => ['label' => 'Terkirim', 'class' => 'status-sent'],
            'paid' => ['label' => 'Lunas', 'class' => 'status-paid'],
            'overdue' => ['label' => 'Jatuh Tempo', 'class' => 'status-overdue'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'status-cancelled'],
            'accepted' => ['label' => 'Diterima', 'class' => 'status-accepted'],
            'rejected' => ['label' => 'Ditolak', 'class' => 'status-rejected'],
            'expired' => ['label' => 'Kadaluwarsa', 'class' => 'status-expired'],
        ];
    @endphp

    <style>
        .client-detail-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .client-detail-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes pulseGlow{ 0%,100%{ opacity:1;} 50%{ opacity:.55;} }
        .client-detail-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

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
        .page-head h1 .client-badge{
            font-family:'Space Grotesk', sans-serif;
            background:var(--surface-hover); padding:2px 14px; border-radius:8px;
            font-size:18px; color:var(--text-secondary);
        }
        .page-head p{
            font-size:14px; color:var(--text-muted); margin:0;
        }

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
        .btn-primary::after{
            content:''; position:absolute; top:-50%; left:-50%; width:200%; height:200%;
            background:linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform:rotate(45deg) translateX(-100%); transition:transform .6s ease;
        }
        .btn-primary:hover::after{ transform:rotate(45deg) translateX(100%); }
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

        /* ===== DETAIL GRID ===== */
        .detail-grid-wrap{
            display:grid; grid-template-columns:1fr 1.6fr; gap:24px; align-items:start;
        }

        /* ===== PROFILE PANEL ===== */
        .profile-panel{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            padding:28px; box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .profile-avatar{
            width:64px; height:64px; border-radius:16px;
            display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk', sans-serif; font-size:26px; font-weight:700; color:#fff;
            margin-bottom:16px;
        }
        .profile-name{
            font-family:'Space Grotesk', sans-serif; font-size:20px; font-weight:700; margin-bottom:2px;
            color:var(--text);
        }
        .profile-company{
            font-size:13px; color:var(--text-muted); margin-bottom:20px;
        }
        .profile-field{
            padding:12px 0; border-top:1px solid var(--border);
        }
        .profile-field:first-of-type{ border-top:none; }
        .profile-field .k{
            font-size:11px; text-transform:uppercase; letter-spacing:.06em;
            color:var(--text-faint); font-weight:600; margin-bottom:4px;
            display:flex; align-items:center; gap:6px;
        }
        .profile-field .k .icon{ width:13px; height:13px; color:var(--text-muted); }
        .profile-field .v{
            font-size:13.5px; font-weight:500; color:var(--text);
        }
        .profile-stats{
            display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:18px;
        }
        .profile-stat{
            background:var(--surface-hover); border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:14px; text-align:center;
            transition:all .2s ease;
        }
        .profile-stat:hover{
            border-color:var(--border-hover);
            transform:translateY(-2px);
        }
        .profile-stat .n{
            font-family:'Space Grotesk', sans-serif; font-size:20px; font-weight:700;
            color:var(--accent);
        }
        .profile-stat .l{
            font-size:11px; color:var(--text-faint); margin-top:2px;
        }

        /* ===== ACTIVITY PANEL ===== */
        .activity-panel{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            padding:24px; box-shadow:0 4px 24px rgba(0,0,0,0.06);
            margin-bottom:20px;
        }
        .activity-panel:last-child{ margin-bottom:0; }
        .activity-title{
            display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;
        }
        .activity-title h3{
            font-family:'Space Grotesk', sans-serif; font-size:15.5px; font-weight:600;
            color:var(--text); margin:0;
            display:flex; align-items:center; gap:8px;
        }
        .activity-title h3 .icon{ width:18px; height:18px; color:var(--accent); }
        .activity-title a{
            font-size:12.5px; color:var(--accent); font-weight:600; text-decoration:none;
            display:flex; align-items:center; gap:4px;
            transition:color .2s ease;
        }
        .activity-title a:hover{ color:var(--accent-dim); }

        .activity-row{
            display:flex; align-items:center; justify-content:space-between;
            gap:10px; padding:11px 0; border-bottom:1px solid var(--border);
            font-size:13px;
        }
        .activity-row:last-child{ border-bottom:none; }
        .activity-row-left{
            display:flex; flex-direction:column; gap:2px; flex:1;
        }
        .activity-row-num{
            font-family:'IBM Plex Mono', monospace; font-size:12.5px; font-weight:600;
            color:var(--text);
        }
        .activity-row-date{
            font-size:11.5px; color:var(--text-faint);
        }
        .activity-row-amount{
            font-family:'IBM Plex Mono', monospace; font-weight:600;
            color:var(--text);
            font-size:13px;
        }
        .activity-empty{
            font-size:12.5px; color:var(--text-faint); text-align:center; padding:20px 0;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge{
            display:inline-flex; align-items:center; gap:5px;
            padding:3px 10px; border-radius:100px; font-size:11px; font-weight:600;
            flex-shrink:0;
        }
        .status-badge .sdot{
            width:5px; height:5px; border-radius:50%;
        }
        .status-draft{ background:var(--surface-strong); color:var(--text-mute); }
        .status-draft .sdot{ background:var(--text-faint); }
        .status-sent{ background:rgba(var(--info-rgb),0.12); color:var(--info); }
        .status-sent .sdot{ background:var(--info); }
        .status-paid{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
        .status-paid .sdot{ background:var(--emerald); }
        .status-overdue{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
        .status-overdue .sdot{ background:var(--danger); }
        .status-cancelled{ background:var(--surface-strong); color:var(--text-faint); text-decoration:line-through; }
        .status-cancelled .sdot{ background:var(--text-faint); }
        .status-accepted{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
        .status-accepted .sdot{ background:var(--emerald); }
        .status-rejected{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
        .status-rejected .sdot{ background:var(--danger); }
        .status-expired{ background:rgba(var(--warning-rgb),0.12); color:var(--warning); }
        .status-expired .sdot{ background:var(--warning); animation:pulseGlow 1.6s ease-in-out infinite; }

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
            font-size:18px; font-weight:700; margin-bottom:8px; color:var(--text);
        }
        .modal-box p{
            font-size:13.5px; color:var(--text-muted); margin-bottom:6px; line-height:1.6;
        }
        .modal-box p b{
            color:var(--text); font-family:'IBM Plex Mono', monospace;
            background:var(--surface-hover); padding:2px 12px; border-radius:6px; display:inline-block; margin-top:4px;
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
            .detail-grid-wrap{ grid-template-columns:1fr; }
        }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .page-head h1{ font-size:22px; flex-direction:column; align-items:flex-start; }
            .page-head h1 .client-badge{ font-size:16px; }
            .profile-panel{ padding:20px; }
            .activity-panel{ padding:18px; }
            .modal-box{ padding:24px 20px; }
            .profile-stats{ grid-template-columns:1fr 1fr; }
        }
        @media (max-width: 480px){
            .profile-stats{ grid-template-columns:1fr; }
            .activity-row{ flex-wrap:wrap; gap:6px; }
            .activity-row-amount{ margin-left:auto; }
        }
    </style>

    <div class="client-detail-wrap">

        {{-- ===== BREADCRUMB ===== --}}
        <div class="breadcrumb animate-in" style="animation-delay:.02s;">
            <a href="{{ route('clients.index') }}">Klien</a>
            <span class="sep">›</span>
            <span class="current">{{ $client->name }}</span>
        </div>

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>
                    <span>Detail Klien</span>
                    <span class="client-badge">{{ $client->name }}</span>
                </h1>
                <p>Informasi lengkap dan riwayat transaksi klien.</p>
            </div>
            <div class="head-actions">
                <a href="{{ route('clients.index') }}" class="btn btn-outline btn-sm">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary btn-sm">
                    <svg class="icon"><use href="#ic-edit"/></svg>
                    Edit
                </a>
                <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('deleteModal').classList.add('open')">
                    <svg class="icon"><use href="#ic-trash"/></svg>
                    Hapus
                </button>
            </div>
        </div>

        {{-- ===== DETAIL GRID ===== --}}
        <div class="detail-grid-wrap animate-in" style="animation-delay:.10s;">

            {{-- ===== KIRI: PROFIL ===== --}}
            <div class="profile-panel">
                <div class="profile-avatar" style="background:{{ $avColor }};">
                    {{ strtoupper(substr($client->name, 0, 1)) }}
                </div>
                <div class="profile-name">{{ $client->name }}</div>
                <div class="profile-company">{{ $client->company_name ?? 'Tidak ada nama perusahaan' }}</div>

                <div class="profile-field">
                    <div class="k">
                        <svg class="icon"><use href="#ic-mail"/></svg> Email
                    </div>
                    <div class="v">{{ $client->email ?? '—' }}</div>
                </div>
                <div class="profile-field">
                    <div class="k">
                        <svg class="icon"><use href="#ic-phone"/></svg> Telepon
                    </div>
                    <div class="v">{{ $client->phone ?? '—' }}</div>
                </div>
                <div class="profile-field">
                    <div class="k">
                        <svg class="icon"><use href="#ic-map-pin"/></svg> Alamat
                    </div>
                    <div class="v">{{ $client->address ?? '—' }}</div>
                </div>
                @if($client->notes)
                <div class="profile-field">
                    <div class="k">
                        <svg class="icon"><use href="#ic-file-text"/></svg> Catatan
                    </div>
                    <div class="v">{{ $client->notes }}</div>
                </div>
                @endif

                <div class="profile-stats">
                    <div class="profile-stat">
                        <div class="n">{{ $client->invoices_count ?? 0 }}</div>
                        <div class="l">Faktur</div>
                    </div>
                    <div class="profile-stat">
                        <div class="n">{{ $client->quotes_count ?? 0 }}</div>
                        <div class="l">Penawaran</div>
                    </div>
                </div>
            </div>

            {{-- ===== KANAN: AKTIVITAS ===== --}}
            <div>

                {{-- Faktur --}}
                <div class="activity-panel">
                    <div class="activity-title">
                        <h3>
                            <svg class="icon"><use href="#ic-file-invoice"/></svg>
                            Faktur Terbaru
                        </h3>
                        <a href="{{ route('invoices.index', ['client_id' => $client->id]) }}">
                            Lihat semua
                            <svg class="icon" style="width:14px;height:14px;"><use href="#ic-chevron-right"/></svg>
                        </a>
                    </div>
                    @forelse($client->invoices->take(5) as $invoice)
                        @php
                            $statusKey = $invoice->status;
                            $st = $statusLabels[$statusKey] ?? ['label' => ucfirst($statusKey), 'class' => 'status-draft'];
                        @endphp
                        <div class="activity-row">
                            <div class="activity-row-left">
                                <span class="activity-row-num">{{ $invoice->invoice_number }}</span>
                                <span class="activity-row-date">{{ optional($invoice->issue_date)->translatedFormat('d M Y') }}</span>
                            </div>
                            <span class="status-badge {{ $st['class'] }}">
                                <span class="sdot"></span>
                                {{ $st['label'] }}
                            </span>
                            <span class="activity-row-amount">Rp{{ number_format($invoice->total ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <div class="activity-empty">Belum ada faktur untuk klien ini.</div>
                    @endforelse
                </div>

                {{-- Penawaran --}}
                <div class="activity-panel">
                    <div class="activity-title">
                        <h3>
                            <svg class="icon"><use href="#ic-file-quote"/></svg>
                            Penawaran Terbaru
                        </h3>
                        <a href="{{ route('quotes.index', ['client_id' => $client->id]) }}">
                            Lihat semua
                            <svg class="icon" style="width:14px;height:14px;"><use href="#ic-chevron-right"/></svg>
                        </a>
                    </div>
                    @forelse($client->quotes->take(5) as $quote)
                        @php
                            $statusKey = $quote->status;
                            $st = $statusLabels[$statusKey] ?? ['label' => ucfirst($statusKey), 'class' => 'status-draft'];
                        @endphp
                        <div class="activity-row">
                            <div class="activity-row-left">
                                <span class="activity-row-num">{{ $quote->quote_number }}</span>
                                <span class="activity-row-date">{{ optional($quote->issue_date)->translatedFormat('d M Y') }}</span>
                            </div>
                            <span class="status-badge {{ $st['class'] }}">
                                <span class="sdot"></span>
                                {{ $st['label'] }}
                            </span>
                            <span class="activity-row-amount">Rp{{ number_format($quote->total ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <div class="activity-empty">Belum ada penawaran untuk klien ini.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-ic">
                <svg class="icon"><use href="#ic-alert-triangle"/></svg>
            </div>
            <h3>Hapus Klien Ini?</h3>
            <p>Klien <br><b>{{ $client->name }}</b></p>
            <p style="margin-top:4px;">akan dihapus permanen dan tidak bisa dikembalikan.</p>
            <div class="modal-warn">⚠️ Semua faktur dan penawaran yang terkait akan ikut terhapus.</div>
            <form method="POST" action="{{ route('clients.destroy', $client) }}">
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