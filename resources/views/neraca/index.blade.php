<x-app-layout>
    <x-slot name="title">Neraca</x-slot>

    {{-- SVG SPRITE DEFINITIONS --}}
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="ic-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </symbol>
            <symbol id="ic-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </symbol>
            <symbol id="ic-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-bank" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </symbol>
            <symbol id="ic-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </symbol>
            <symbol id="ic-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .page-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:22px; flex-wrap:wrap; }
        .page-head h1{ font-size:26px; margin-bottom:6px; }
        .page-head p{ font-size:14px; color:var(--text-mute); }
        .head-actions{ display:flex; gap:10px; }
        .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; white-space:nowrap; }
        .btn .icon{ width:15px; height:15px; }
        .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
        .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 8px 26px rgba(var(--emerald-rgb),0.45); }
        .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
        .btn-outline:hover{ background:var(--surface-strong); }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        .date-filter{ display:flex; align-items:center; gap:10px; margin-bottom:22px; }
        .date-filter input{
            padding:10px 14px; border-radius:12px; background:var(--surface); border:1px solid var(--border);
            color:var(--text); font-size:13px; outline:none;
        }

        /* ===== TWO-COLUMN NERACA LAYOUT ===== */
        .neraca-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start; max-width:1100px; }
        .neraca-col{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px 28px; }
        .neraca-col-header{ display:flex; align-items:center; gap:10px; margin-bottom:18px; padding-bottom:16px; border-bottom:1px dashed var(--border); }
        .neraca-col-header .ic{ width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
        .neraca-col-header .ic .icon{ width:17px; height:17px; }
        .neraca-col.aset .ic{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
        .neraca-col.pasiva .ic{ background:rgba(var(--info-rgb),0.12); color:var(--info); }
        .neraca-col-header h3{ font-family:'Space Grotesk', sans-serif; font-size:16px; }

        .nr-group-title{ font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:.04em; color:var(--text-faint); margin:16px 0 8px; }
        .nr-group-title:first-of-type{ margin-top:0; }
        .nr-row{ display:flex; justify-content:space-between; align-items:center; padding:8px 0; font-size:13.5px; border-bottom:1px solid var(--border); gap:10px; }
        .nr-row-name{ flex:1; min-width:0; }
        .nr-amount{ font-family:'IBM Plex Mono', monospace; white-space:nowrap; }
        .nr-subtotal{ display:flex; justify-content:space-between; padding:6px 0 12px; font-size:12.5px; color:var(--text-mute); font-weight:600; }
        .nr-empty{ font-size:12.5px; color:var(--text-faint); padding:6px 0 14px; }

        .nr-col-total{ display:flex; justify-content:space-between; margin-top:10px; padding-top:14px; border-top:1px solid var(--border); font-size:14.5px; font-weight:700; }
        .neraca-col.aset .nr-col-total{ color:var(--emerald); }
        .neraca-col.pasiva .nr-col-total{ color:var(--info); }

        .balance-bar{ max-width:1100px; margin-top:18px; padding:16px 22px; border-radius:14px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
        .balance-bar.ok{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); }
        .balance-bar.warn{ background:rgba(var(--danger-rgb),0.1); border:1px solid rgba(var(--danger-rgb),0.3); }
        .balance-bar-label{ display:flex; align-items:center; gap:10px; font-size:13.5px; font-weight:600; }
        .balance-bar.ok .balance-bar-label{ color:var(--emerald); }
        .balance-bar.warn .balance-bar-label{ color:var(--danger); }
        .balance-bar-detail{ font-size:12.5px; color:var(--text-mute); font-family:'IBM Plex Mono', monospace; }

        /* ===== ACTION BUTTONS HANYA IKON ===== */
        .row-actions{ display:flex; gap:4px; flex-shrink:0; }
        .row-action-btn{
            display:inline-flex; align-items:center; justify-content:center;
            width:30px; height:30px; border-radius:7px;
            border:1px solid var(--border);
            background:var(--surface-strong); color:var(--text-mute);
            transition:all .15s ease; cursor:pointer; text-decoration:none;
        }
        .row-action-btn .icon{ width:14px; height:14px; }
        .row-action-btn:hover{ background:var(--surface); border-color:var(--border-hover); color:var(--text); }
        .row-action-btn.view{ color:var(--info); border-color:rgba(var(--info-rgb),0.3); }
        .row-action-btn.view:hover{ background:rgba(var(--info-rgb),0.08); border-color:var(--info); }
        .row-action-btn.edit{ color:var(--emerald); border-color:rgba(var(--emerald-rgb),0.3); }
        .row-action-btn.edit:hover{ background:rgba(var(--emerald-rgb),0.08); border-color:var(--emerald); }
        .row-action-btn.delete{ color:var(--danger); border-color:rgba(var(--danger-rgb),0.25); }
        .row-action-btn.delete:hover{ background:rgba(var(--danger-rgb),0.1); border-color:rgba(var(--danger-rgb),0.4); }
        .row-action-btn button{ all:unset; display:flex; align-items:center; justify-content:center; width:100%; height:100%; cursor:pointer; }

        /* Fix untuk icon */
        .icon {
            display: inline-block;
            width: 15px;
            height: 15px;
            color: currentColor;
            flex-shrink: 0;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .date-filter .icon {
            width: 15px;
            height: 15px;
        }

        .btn .icon {
            width: 15px;
            height: 15px;
        }

        @media (max-width:900px){
            .neraca-grid{ grid-template-columns:1fr; }
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
        }
        @media (max-width:560px){
            .nr-row{ flex-wrap:wrap; }
            .row-action-btn{ width:28px; height:28px; }
            .row-action-btn .icon{ width:12px; height:12px; }
        }
    </style>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="page-head">
        <div>
            <h1>Neraca</h1>
            <p>Posisi aset, kewajiban, dan modal {{ $company->name ?? 'perusahaanmu' }} pada tanggal tertentu.</p>
        </div>
        <div class="head-actions">
            <a href="{{ route('neraca.create') }}" class="btn btn-primary">
                <svg class="icon"><use href="#ic-plus"/></svg> Tambah Pos
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('neraca.index') }}" class="date-filter">
        <svg class="icon"><use href="#ic-calendar"/></svg>
        <input type="date" name="as_of_date" value="{{ $asOfDate }}" onchange="this.form.submit()">
    </form>

    <div class="neraca-grid">
        {{-- ===== KIRI: ASET ===== --}}
        <div class="neraca-col aset">
            <div class="neraca-col-header">
                <div class="ic"><svg class="icon"><use href="#ic-bank"/></svg></div>
                <h3>Aset</h3>
            </div>

            @forelse($aset as $category => $groupItems)
                <div class="nr-group-title">{{ $category }}</div>
                @foreach($groupItems as $item)
                    <div class="nr-row">
                        <span class="nr-row-name">{{ $item->name }}</span>
                        <span class="nr-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                        <div class="row-actions">
                            <a href="{{ route('neraca.show', $item) }}" class="row-action-btn view" title="Lihat">
                                <svg class="icon"><use href="#ic-eye"/></svg>
                            </a>
                            <a href="{{ route('neraca.edit', $item) }}" class="row-action-btn edit" title="Edit">
                                <svg class="icon"><use href="#ic-edit"/></svg>
                            </a>
                            <form method="POST" action="{{ route('neraca.destroy', $item) }}" onsubmit="return confirm('Hapus pos ini?')" style="display:contents;">
                                @csrf @method('DELETE')
                                <span class="row-action-btn delete" title="Hapus">
                                    <button type="submit"><svg class="icon"><use href="#ic-trash"/></svg></button>
                                </span>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="nr-subtotal">
                    <span>Subtotal {{ $category }}</span>
                    <span class="nr-amount">Rp{{ number_format($groupItems->sum('amount'), 0, ',', '.') }}</span>
                </div>
            @empty
                <div class="nr-empty">Belum ada pos aset per tanggal ini.</div>
            @endforelse

            <div class="nr-col-total">
                <span>Total Aset</span>
                <span class="nr-amount">Rp{{ number_format($totalAset, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- ===== KANAN: KEWAJIBAN + MODAL ===== --}}
        <div class="neraca-col pasiva">
            <div class="neraca-col-header">
                <div class="ic"><svg class="icon"><use href="#ic-shield"/></svg></div>
                <h3>Kewajiban & Modal</h3>
            </div>

            <div class="nr-group-title" style="color:var(--danger); opacity:.85;">Kewajiban</div>
            @forelse($kewajiban as $category => $groupItems)
                <div class="nr-group-title">{{ $category }}</div>
                @foreach($groupItems as $item)
                    <div class="nr-row">
                        <span class="nr-row-name">{{ $item->name }}</span>
                        <span class="nr-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                        <div class="row-actions">
                            <a href="{{ route('neraca.show', $item) }}" class="row-action-btn view" title="Lihat">
                                <svg class="icon"><use href="#ic-eye"/></svg>
                            </a>
                            <a href="{{ route('neraca.edit', $item) }}" class="row-action-btn edit" title="Edit">
                                <svg class="icon"><use href="#ic-edit"/></svg>
                            </a>
                            <form method="POST" action="{{ route('neraca.destroy', $item) }}" onsubmit="return confirm('Hapus pos ini?')" style="display:contents;">
                                @csrf @method('DELETE')
                                <span class="row-action-btn delete" title="Hapus">
                                    <button type="submit"><svg class="icon"><use href="#ic-trash"/></svg></button>
                                </span>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="nr-subtotal">
                    <span>Subtotal {{ $category }}</span>
                    <span class="nr-amount">Rp{{ number_format($groupItems->sum('amount'), 0, ',', '.') }}</span>
                </div>
            @empty
                <div class="nr-empty">Belum ada pos kewajiban.</div>
            @endforelse
            <div class="nr-subtotal" style="font-size:13px; padding-top:2px; border-top:1px solid var(--border);">
                <span>Total Kewajiban</span>
                <span class="nr-amount">Rp{{ number_format($totalKewajiban, 0, ',', '.') }}</span>
            </div>

            <div class="nr-group-title" style="color:var(--emerald); opacity:.85; margin-top:20px;">Modal</div>
            @forelse($modal as $category => $groupItems)
                <div class="nr-group-title">{{ $category }}</div>
                @foreach($groupItems as $item)
                    <div class="nr-row">
                        <span class="nr-row-name">{{ $item->name }}</span>
                        <span class="nr-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                        <div class="row-actions">
                            <a href="{{ route('neraca.show', $item) }}" class="row-action-btn view" title="Lihat">
                                <svg class="icon"><use href="#ic-eye"/></svg>
                            </a>
                            <a href="{{ route('neraca.edit', $item) }}" class="row-action-btn edit" title="Edit">
                                <svg class="icon"><use href="#ic-edit"/></svg>
                            </a>
                            <form method="POST" action="{{ route('neraca.destroy', $item) }}" onsubmit="return confirm('Hapus pos ini?')" style="display:contents;">
                                @csrf @method('DELETE')
                                <span class="row-action-btn delete" title="Hapus">
                                    <button type="submit"><svg class="icon"><use href="#ic-trash"/></svg></button>
                                </span>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="nr-subtotal">
                    <span>Subtotal {{ $category }}</span>
                    <span class="nr-amount">Rp{{ number_format($groupItems->sum('amount'), 0, ',', '.') }}</span>
                </div>
            @empty
                <div class="nr-empty">Belum ada pos modal.</div>
            @endforelse
            <div class="nr-subtotal" style="font-size:13px; padding-top:2px; border-top:1px solid var(--border);">
                <span>Total Modal</span>
                <span class="nr-amount">Rp{{ number_format($totalModal, 0, ',', '.') }}</span>
            </div>

            <div class="nr-col-total">
                <span>Total Kewajiban + Modal</span>
                <span class="nr-amount">Rp{{ number_format($totalPasiva, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="balance-bar {{ $isBalanced ? 'ok' : 'warn' }}">
        <div class="balance-bar-label">
            <svg class="icon" style="width:16px;height:16px;"><use href="#{{ $isBalanced ? 'ic-shield' : 'ic-alert' }}"/></svg>
            {{ $isBalanced ? 'Neraca seimbang' : 'Neraca belum seimbang' }}
        </div>
        <div class="balance-bar-detail">
            Aset: Rp{{ number_format($totalAset, 0, ',', '.') }} — Kewajiban + Modal: Rp{{ number_format($totalPasiva, 0, ',', '.') }}
        </div>
    </div>
</x-app-layout>