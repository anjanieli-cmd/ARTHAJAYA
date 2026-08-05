<x-admin-layout>
<x-slot name="title">Kelola Langganan</x-slot>

<style>
/* ===== ANIMATIONS ===== */
@keyframes fadeUp  { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeIn  { from{opacity:0} to{opacity:1} }
@keyframes popIn   { from{opacity:0;transform:scale(.92)} to{opacity:1;transform:scale(1)} }
.au{animation:fadeUp .5s cubic-bezier(.16,1,.3,1) forwards;opacity:0}
.ai{animation:fadeIn .4s ease forwards;opacity:0}
.ap{animation:popIn .45s cubic-bezier(.16,1,.3,1) forwards;opacity:0}
.d1{animation-delay:.04s}.d2{animation-delay:.09s}.d3{animation-delay:.14s}
.d4{animation-delay:.19s}.d5{animation-delay:.24s}.d6{animation-delay:.29s}

/* ===== LAYOUT ===== */
.page-layout{display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start}

/* ===== PAGE HEAD ===== */
.ph{margin-bottom:26px}
.ph h1{font-size:27px;font-weight:800;margin:0 0 5px;font-family:'Space Grotesk',sans-serif;color:var(--text)}
.ph p{font-size:13.5px;color:var(--text-mute);margin:0}

/* ===== ALERT ===== */
.alert-ok{background:rgba(var(--emerald-rgb),.1);border:1px solid rgba(var(--emerald-rgb),.3);color:var(--emerald);padding:12px 16px;border-radius:12px;font-size:13.5px;margin-bottom:20px;display:flex;align-items:center;gap:8px}
.alert-err{background:rgba(232,90,90,.1);border:1px solid rgba(232,90,90,.3);color:var(--danger);padding:12px 16px;border-radius:12px;font-size:13.5px;margin-bottom:20px;display:flex;align-items:center;gap:8px}
.alert-ok svg,.alert-err svg{width:15px;height:15px;flex-shrink:0}

/* ===== PLAN LIST ===== */
.plan-list{display:flex;flex-direction:column;gap:16px}

.plan-card{
    background:var(--surface);border:1px solid var(--border);border-radius:18px;
    overflow:hidden;transition:border-color .2s,transform .2s;
    border-left:4px solid var(--pc,var(--border));
}
.plan-card:hover{transform:translateY(-2px);border-color:var(--border-hover)}
.plan-card.inactive{opacity:.6}

/* card header */
.pc-head{
    display:flex;align-items:center;gap:14px;
    padding:16px 20px;border-bottom:1px solid var(--border);
}
.pc-icon-badge{
    width:34px;height:34px;border-radius:10px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    background:color-mix(in srgb, var(--pc) 15%, transparent);
    border:1px solid color-mix(in srgb, var(--pc) 30%, transparent);
    color:var(--pc);
}
.pc-icon-badge svg{width:16px;height:16px}
.pc-name-wrap{flex:1;min-width:0}
.pc-name{font-size:15px;font-weight:700;color:var(--text)}
.pc-slug{font-size:11.5px;color:var(--text-faint);font-family:'IBM Plex Mono',monospace}
.badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
.badge .dot{width:5px;height:5px;border-radius:50%;background:currentColor}
.badge-on{background:rgba(var(--emerald-rgb),.12);color:var(--emerald)}
.badge-off{background:var(--surface-strong);color:var(--text-faint)}

/* card body */
.pc-body{display:grid;grid-template-columns:1fr 1fr 1fr;gap:0;border-bottom:1px solid var(--border)}
.pc-stat{padding:14px 20px;border-right:1px solid var(--border)}
.pc-stat:last-child{border-right:none}
.pc-stat .k{font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--text-faint);font-weight:600;margin-bottom:5px}
.pc-stat .v{font-size:16px;font-weight:700;color:var(--text);font-family:'Space Grotesk',sans-serif}
.pc-stat .v.price{color:var(--pc,var(--emerald))}

/* features preview */
.pc-features{padding:12px 20px;border-bottom:1px solid var(--border)}
.pc-features-title{font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--text-faint);font-weight:600;margin-bottom:8px}
.pc-feat-list{display:flex;flex-wrap:wrap;gap:6px}
.pc-feat-chip{
    display:inline-flex;align-items:center;gap:5px;
    padding:3px 10px;border-radius:20px;font-size:11.5px;
    background:var(--surface-strong);border:1px solid var(--border);color:var(--text-mute);
}
.pc-feat-chip svg{width:11px;height:11px;color:var(--pc,var(--emerald));flex-shrink:0}
.pc-feat-empty{font-size:12px;color:var(--text-faint);font-style:italic}

/* card footer */
.pc-foot{padding:14px 20px;display:flex;align-items:center;gap:8px}

/* ===== BUTTONS ===== */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:all .18s ease;white-space:nowrap}
.btn svg{width:13px;height:13px}
.btn-primary{background:var(--emerald);color:#052117;box-shadow:0 3px 12px rgba(var(--emerald-rgb),.3)}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 5px 18px rgba(var(--emerald-rgb),.4)}
.btn-outline{background:var(--surface-strong);border:1px solid var(--border);color:var(--text-mute)}
.btn-outline:hover{color:var(--text);border-color:var(--border-hover)}
.btn-warn{background:rgba(240,168,60,.1);border:1px solid rgba(240,168,60,.25);color:var(--warning)}
.btn-warn:hover{background:rgba(240,168,60,.18)}
.btn-danger{background:rgba(232,90,90,.1);border:1px solid rgba(232,90,90,.25);color:var(--danger)}
.btn-danger:hover{background:rgba(232,90,90,.18)}
.btn-lg{padding:12px 20px;font-size:13.5px;border-radius:11px}

/* ===== EMPTY ===== */
.empty-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;text-align:center;padding:56px 20px}
.empty-card .ei{width:52px;height:52px;border-radius:14px;background:var(--surface-strong);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
.empty-card .ei svg{width:22px;height:22px;color:var(--text-faint)}
.empty-card h3{font-size:15px;font-weight:700;margin-bottom:5px}
.empty-card p{font-size:13px;color:var(--text-mute)}

/* ===== SIDEBAR FORM ===== */
.side{display:flex;flex-direction:column;gap:16px;position:sticky;top:20px}
.form-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;overflow:hidden}
.fc-head{
    padding:18px 22px;border-bottom:1px solid var(--border);
    background:linear-gradient(135deg,var(--surface) 70%,rgba(var(--emerald-rgb),.04));
    display:flex;align-items:center;gap:10px
}
.fc-head .hi{width:34px;height:34px;border-radius:9px;background:rgba(var(--emerald-rgb),.12);border:1px solid rgba(var(--emerald-rgb),.2);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fc-head .hi svg{width:15px;height:15px;color:var(--emerald)}
.fc-head h3{font-size:14px;font-weight:700;color:var(--text);margin:0 0 2px}
.fc-head p{font-size:11.5px;color:var(--text-mute);margin:0}
.fc-body{padding:20px 22px;display:flex;flex-direction:column;gap:16px}
.fc-foot{padding:16px 22px;border-top:1px solid var(--border)}

/* form fields */
.fg{display:flex;flex-direction:column;gap:6px}
.fg label{font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-mute)}
.fg label .opt{font-size:10.5px;font-weight:400;color:var(--text-faint);text-transform:none;letter-spacing:0}
.fc{width:100%;padding:10px 13px;border-radius:10px;background:var(--surface-strong);border:1px solid var(--border);color:var(--text);font-size:13px;outline:none;font-family:inherit;transition:border-color .15s,box-shadow .15s}
.fc:focus{border-color:var(--emerald);box-shadow:0 0 0 3px rgba(var(--emerald-rgb),.1)}
textarea.fc{resize:vertical;min-height:110px;line-height:1.6}
select.fc{appearance:none;background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238A96AE' stroke-width='2'><polyline points='6 9 12 15 18 9'/></svg>");background-repeat:no-repeat;background-position:right 12px center;background-size:12px;padding-right:32px}
.fhint{font-size:11px;color:var(--text-faint);line-height:1.5}

.fg-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}

/* toggle */
.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:10px 0}
.toggle-row .tl{font-size:13px;font-weight:600;color:var(--text)}
.toggle-row .ts{font-size:11.5px;color:var(--text-faint);margin-top:1px}
.sw{position:relative;display:inline-block;width:42px;height:24px;flex-shrink:0}
.sw input{opacity:0;width:0;height:0}
.sw-sl{position:absolute;inset:0;background:var(--border);border-radius:24px;cursor:pointer;transition:background .2s}
.sw-sl::before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s}
.sw input:checked+.sw-sl{background:var(--emerald)}
.sw input:checked+.sw-sl::before{transform:translateX(18px)}

/* ===== COLOR PICKER ===== */
.color-picker{display:flex;flex-wrap:wrap;gap:10px}
.color-opt{position:relative;width:34px;height:34px;border-radius:50%;cursor:pointer;border:2px solid transparent;transition:transform .15s ease;flex-shrink:0}
.color-opt:hover{transform:scale(1.1)}
.color-opt input{position:absolute;opacity:0;inset:0;cursor:pointer;margin:0}
.color-opt .swatch{position:absolute;inset:3px;border-radius:50%;pointer-events:none}
.color-opt .tick{position:absolute;inset:0;display:none;align-items:center;justify-content:center;color:#fff;pointer-events:none}
.color-opt .tick svg{width:14px;height:14px;filter:drop-shadow(0 1px 2px rgba(0,0,0,.4))}
.color-opt input:checked ~ .tick{display:flex}
.color-opt input:checked{ }
.color-opt:has(input:checked){border-color:var(--text)}

/* ===== ICON PICKER ===== */
.icon-picker{display:flex;flex-wrap:wrap;gap:8px}
.icon-opt{position:relative;width:38px;height:38px;border-radius:10px;cursor:pointer;border:1.5px solid var(--border);background:var(--surface-strong);display:flex;align-items:center;justify-content:center;color:var(--text-mute);transition:all .15s ease;flex-shrink:0}
.icon-opt:hover{border-color:var(--border-hover);color:var(--text)}
.icon-opt input{position:absolute;opacity:0;inset:0;cursor:pointer;margin:0}
.icon-opt svg{width:16px;height:16px;pointer-events:none}
.icon-opt:has(input:checked){border-color:var(--emerald);background:rgba(var(--emerald-rgb),.12);color:var(--emerald)}

/* feature preview live */
.feat-preview{background:var(--surface-strong);border:1px solid var(--border);border-radius:10px;padding:12px 14px;margin-top:4px}
.feat-preview-title{font-size:10.5px;text-transform:uppercase;letter-spacing:.05em;color:var(--text-faint);font-weight:600;margin-bottom:8px}
.fp-item{display:flex;align-items:center;gap:7px;font-size:12px;color:var(--text-mute);padding:3px 0}
.fp-item svg{width:11px;height:11px;color:var(--emerald);flex-shrink:0}
.fp-empty{font-size:11.5px;color:var(--text-faint);font-style:italic}

/* info card */
.info-card{background:rgba(var(--emerald-rgb),.05);border:1px solid rgba(var(--emerald-rgb),.15);border-radius:14px;padding:16px 18px}
.info-card h4{font-size:12px;font-weight:700;color:var(--emerald);margin:0 0 10px;text-transform:uppercase;letter-spacing:.05em}
.info-card ul{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:8px}
.info-card li{display:flex;align-items:flex-start;gap:8px;font-size:12px;color:var(--text-mute);line-height:1.5}
.info-card li::before{content:'→';color:var(--emerald);flex-shrink:0;font-weight:700}

/* delete modal */
.modal-ov{position:fixed;inset:0;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);z-index:999;display:none;align-items:center;justify-content:center;padding:20px}
.modal-ov.open{display:flex}
@keyframes mUp{from{opacity:0;transform:translateY(18px) scale(.96)} to{opacity:1;transform:translateY(0) scale(1)}}
.modal-box{background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:28px;max-width:380px;width:100%;animation:mUp .3s cubic-bezier(.16,1,.3,1);text-align:center}
.modal-ic{width:48px;height:48px;border-radius:50%;background:rgba(232,90,90,.1);color:var(--danger);display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
.modal-ic svg{width:22px;height:22px}
.modal-box h3{font-size:17px;font-weight:700;margin-bottom:8px}
.modal-box p{font-size:13.5px;color:var(--text-mute);margin-bottom:22px}
.modal-acts{display:flex;gap:10px;justify-content:center}
.modal-acts .btn{flex:1;justify-content:center}

@media(max-width:1080px){.page-layout{grid-template-columns:1fr}.side{position:static}}
@media(max-width:700px){.pc-body{grid-template-columns:1fr 1fr}}
</style>

<svg style="display:none;"><defs>
<symbol id="i-sub"     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></symbol>
<symbol id="i-plus"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
<symbol id="i-edit"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></symbol>
<symbol id="i-del"     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
<symbol id="i-toggle"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"/><circle cx="16" cy="12" r="3"/></symbol>
<symbol id="i-alert"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
<symbol id="i-check"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
<symbol id="i-users"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
<symbol id="i-info"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></symbol>
<symbol id="i-zap"     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></symbol>
<symbol id="i-star"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></symbol>
<symbol id="i-shield"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></symbol>
<symbol id="i-diamond" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"/></symbol>
<symbol id="i-rocket"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></symbol>
</defs></svg>

@if(session('success'))
<div class="alert-ok au d1"><svg><use href="#i-check"/></svg>{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert-err au d1"><svg><use href="#i-alert"/></svg>{{ $errors->first() }}</div>
@endif

<div class="ph au d1">
    <h1>Kelola Langganan</h1>
    <p>Paket yang aktif langsung muncul di halaman pricing untuk semua user.</p>
</div>

<div class="page-layout">

    {{-- ===== KIRI: DAFTAR PLAN ===== --}}
    <div class="plan-list">
        @forelse($plans as $i => $plan)
        @php
            $features = [];
            if ($plan->description) {
                $features = array_values(array_filter(
                    array_map('trim', explode("\n", $plan->description))
                ));
            }
            $planColor = $plan->color ?: '#6366f1';
            $planIcon = $plan->icon ?: 'i-zap';
        @endphp
        <div class="plan-card {{ $plan->is_active ? '' : 'inactive' }} au" style="--pc:{{ $planColor }}; animation-delay:{{ .1 + $i * .07 }}s;">

            {{-- HEAD --}}
            <div class="pc-head">
                <div class="pc-icon-badge"><svg><use href="#{{ $planIcon }}"/></svg></div>
                <div class="pc-name-wrap">
                    <div class="pc-name">{{ $plan->name }}</div>
                    <div class="pc-slug">{{ $plan->slug }}</div>
                </div>
                <span class="badge {{ $plan->is_active ? 'badge-on' : 'badge-off' }}">
                    <span class="dot"></span>{{ $plan->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            {{-- STATS --}}
            <div class="pc-body">
                <div class="pc-stat">
                    <div class="k">Harga</div>
                    <div class="v price">
                        @if($plan->price == 0) Gratis
                        @else Rp {{ number_format($plan->price, 0, ',', '.') }}
                        @endif
                    </div>
                </div>
                <div class="pc-stat">
                    <div class="k">Periode</div>
                    <div class="v">{{ $plan->billing_period === 'monthly' ? 'Bulanan' : 'Tahunan' }}</div>
                </div>
                <div class="pc-stat">
                    <div class="k">Dipakai</div>
                    <div class="v" style="display:flex;align-items:center;gap:5px;">
                        <svg style="width:13px;height:13px;color:var(--text-faint)"><use href="#i-users"/></svg>
                        {{ $plan->companies_count }} co.
                    </div>
                </div>
            </div>

            {{-- FEATURES PREVIEW --}}
            <div class="pc-features">
                <div class="pc-features-title">Fitur ({{ count($features) }})</div>
                @if(empty($features))
                    <div class="pc-feat-empty">Belum ada fitur — isi di kolom deskripsi</div>
                @else
                    <div class="pc-feat-list">
                        @foreach(array_slice($features, 0, 5) as $feat)
                        <span class="pc-feat-chip">
                            <svg><use href="#i-check"/></svg>
                            {{ Str::limit($feat, 28) }}
                        </span>
                        @endforeach
                        @if(count($features) > 5)
                        <span class="pc-feat-chip" style="color:var(--text-faint)">
                            +{{ count($features) - 5 }} lainnya
                        </span>
                        @endif
                    </div>
                @endif
            </div>

            {{-- FOOTER ACTIONS --}}
            <div class="pc-foot">
                <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="btn btn-outline">
                    <svg><use href="#i-edit"/></svg> Edit
                </a>
                <form method="POST" action="{{ route('admin.subscription-plans.toggle', $plan) }}" style="display:contents">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn {{ $plan->is_active ? 'btn-warn' : 'btn-primary' }}">
                        <svg><use href="#i-toggle"/></svg>
                        {{ $plan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <button type="button" class="btn btn-danger" style="margin-left:auto"
                    onclick="openDel('{{ $plan->id }}','{{ addslashes($plan->name) }}','{{ $plan->companies_count }}')">
                    <svg><use href="#i-del"/></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="empty-card au d3">
            <div class="ei"><svg><use href="#i-sub"/></svg></div>
            <h3>Belum ada paket</h3>
            <p>Tambahkan paket pertama menggunakan form di samping.</p>
        </div>
        @endforelse
    </div>

    {{-- ===== KANAN: SIDEBAR ===== --}}
    <div class="side">

        {{-- FORM TAMBAH --}}
        <div class="form-card ap d3">
            <div class="fc-head">
                <div class="hi"><svg><use href="#i-plus"/></svg></div>
                <div>
                    <h3>Tambah Paket Baru</h3>
                    <p>Langsung muncul di /pricing user</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.subscription-plans.store') }}">
                @csrf
                <div class="fc-body">

                    <div class="fg">
                        <label>Nama Paket</label>
                        <input type="text" name="name" class="fc" placeholder="cth: Free, Platinum, Gold" value="{{ old('name') }}" required oninput="updatePreview()">
                    </div>

                    <div class="fg-row">
                        <div class="fg">
                            <label>Harga <span class="opt">(Rp)</span></label>
                            <input type="number" name="price" class="fc" placeholder="0" min="0" value="{{ old('price', 0) }}" required>
                            <div class="fhint">0 = gratis</div>
                        </div>
                        <div class="fg">
                            <label>Periode</label>
                            <select name="billing_period" class="fc">
                                <option value="monthly" {{ old('billing_period') === 'monthly' ? 'selected' : '' }}>Per Bulan</option>
                                <option value="yearly"  {{ old('billing_period') === 'yearly'  ? 'selected' : '' }}>Per Tahun</option>
                            </select>
                        </div>
                    </div>

                    <div class="fg">
                        <label>Max User <span class="opt">(opsional)</span></label>
                        <input type="number" name="max_users" class="fc" placeholder="Kosongkan = tak terbatas" min="1" value="{{ old('max_users') }}">
                    </div>

                    {{-- ===== COLOR PICKER ===== --}}
                    <div class="fg">
                        <label>Warna Paket</label>
                        @php
                            $colorOptions = [
                                '#6366f1' => 'Indigo', '#2A9D8F' => 'Teal', '#f59e0b' => 'Gold',
                                '#ec4899' => 'Pink', '#14b8a6' => 'Cyan', '#ef4444' => 'Merah',
                                '#3b82f6' => 'Biru', '#64748b' => 'Abu',
                            ];
                            $selectedColor = old('color', '#6366f1');
                        @endphp
                        <div class="color-picker">
                            @foreach($colorOptions as $hex => $label)
                            <label class="color-opt" title="{{ $label }}">
                                <input type="radio" name="color" value="{{ $hex }}" {{ $selectedColor === $hex ? 'checked' : '' }}>
                                <span class="swatch" style="background:{{ $hex }};"></span>
                                <span class="tick"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- ===== ICON PICKER ===== --}}
                    <div class="fg">
                        <label>Ikon Paket</label>
                        @php
                            $iconOptions = ['i-zap', 'i-star', 'i-shield', 'i-diamond', 'i-rocket'];
                            $selectedIcon = old('icon', 'i-zap');
                        @endphp
                        <div class="icon-picker">
                            @foreach($iconOptions as $ic)
                            <label class="icon-opt">
                                <input type="radio" name="icon" value="{{ $ic }}" {{ $selectedIcon === $ic ? 'checked' : '' }}>
                                <svg><use href="#{{ $ic }}"/></svg>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="fg">
                        <label>
                            Daftar Fitur
                            <span class="opt">— satu fitur per baris</span>
                        </label>
                        <textarea name="description" id="featInput" class="fc"
                            placeholder="Semua fitur dasar&#10;Laporan keuangan&#10;Manajemen klien &amp; invoice&#10;Piutang &amp; Utang"
                            oninput="updatePreview()">{{ old('description') }}</textarea>
                        <div class="fhint">Tiap baris = 1 fitur. Ikon fitur otomatis dipilih berdasarkan kata kunci (payroll, pajak, laporan, dll).</div>

                        {{-- LIVE PREVIEW --}}
                        <div class="feat-preview">
                            <div class="feat-preview-title">Preview fitur</div>
                            <div id="featPreview">
                                <div class="fp-empty">Isi fitur di atas untuk lihat preview...</div>
                            </div>
                        </div>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="tl">Aktif</div>
                            <div class="ts">Langsung tampil di halaman pricing</div>
                        </div>
                        <label class="sw">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <span class="sw-sl"></span>
                        </label>
                    </div>

                </div>
                <div class="fc-foot">
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
                        <svg><use href="#i-plus"/></svg> Tambah Paket
                    </button>
                </div>
            </form>
        </div>

{{-- DELETE MODAL --}}
<div class="modal-ov" id="delModal">
    <div class="modal-box">
        <div class="modal-ic"><svg><use href="#i-alert"/></svg></div>
        <h3>Hapus Paket?</h3>
        <p id="delMsg">—</p>
        <form method="POST" id="delForm">
            @csrf @method('DELETE')
            <div class="modal-acts">
                <button type="button" class="btn btn-outline" onclick="closeDel()">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
function updatePreview() {
    const val = document.getElementById('featInput').value;
    const preview = document.getElementById('featPreview');
    const lines = val.split('\n').map(l => l.trim()).filter(l => l.length > 0);
    if (lines.length === 0) {
        preview.innerHTML = '<div class="fp-empty">Isi fitur di atas untuk lihat preview...</div>';
        return;
    }
    preview.innerHTML = lines.map(l =>
        `<div class="fp-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:11px;height:11px;color:var(--emerald);flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>${l}</div>`
    ).join('');
}

function openDel(id, name, count) {
    if (count > 0) {
        alert('Paket "' + name + '" tidak bisa dihapus karena masih dipakai oleh ' + count + ' perusahaan.');
        return;
    }
    document.getElementById('delMsg').innerHTML = 'Paket <strong>' + name + '</strong> akan dihapus permanen.';
    document.getElementById('delForm').action = '/admin/subscription-plans/' + id;
    document.getElementById('delModal').classList.add('open');
}
function closeDel() { document.getElementById('delModal').classList.remove('open'); }
document.getElementById('delModal').addEventListener('click', function(e){ if(e.target===this) closeDel(); });
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeDel(); });
</script>
</x-admin-layout>