<x-app-layout>
<x-slot name="title">Paket Berlangganan</x-slot>

@php
    function featureIcon(string $text): string {
        $t = strtolower($text);
        if (str_contains($t,'payroll') || str_contains($t,'karyawan')) return 'i-users';
        if (str_contains($t,'pajak') || str_contains($t,'ppn') || str_contains($t,'pph')) return 'i-building';
        if (str_contains($t,'faktur') || str_contains($t,'invoice') || str_contains($t,'penawaran')) return 'i-invoice';
        if (str_contains($t,'piutang') || str_contains($t,'utang')) return 'i-receive';
        if (str_contains($t,'bank') || str_contains($t,'rekonsiliasi')) return 'i-bank';
        if (str_contains($t,'laba') || str_contains($t,'neraca') || str_contains($t,'laporan') || str_contains($t,'arus kas')) return 'i-trending';
        if (str_contains($t,'inventaris') || str_contains($t,'stok')) return 'i-briefcase';
        if (str_contains($t,'anggaran') || str_contains($t,'forecast')) return 'i-target';
        if (str_contains($t,'akses') || str_contains($t,'multi-user') || str_contains($t,'keamanan')) return 'i-shield';
        if (str_contains($t,'klien') || str_contains($t,'manajemen')) return 'i-users';
        return 'i-check';
    }
@endphp

<style>
/* ===== ANIMATIONS ===== */
@keyframes fadeDown { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeUp   { from{opacity:0;transform:translateY(28px)}  to{opacity:1;transform:translateY(0)} }
.ad{animation:fadeDown .5s cubic-bezier(.16,1,.3,1) forwards;opacity:0}
.au{animation:fadeUp   .5s cubic-bezier(.16,1,.3,1) forwards;opacity:0}
.d1{animation-delay:.05s}.d2{animation-delay:.12s}.d3{animation-delay:.19s}
.d4{animation-delay:.26s}.d5{animation-delay:.33s}.d6{animation-delay:.40s}

/* ===== PAGE HEADER ===== */
.pricing-head{text-align:center;padding:32px 0 28px}
.pricing-badge{
    display:inline-flex;align-items:center;gap:7px;
    padding:5px 16px;border-radius:20px;font-size:12px;font-weight:700;
    letter-spacing:.06em;text-transform:uppercase;margin-bottom:18px;
    background:rgba(99,102,241,.12);border:1px solid rgba(99,102,241,.25);color:#818cf8
}
.pricing-badge svg{width:13px;height:13px}
.pricing-head h1{
    font-size:34px;font-weight:800;color:var(--text);
    margin:0 0 16px;font-family:'Space Grotesk',sans-serif;line-height:1.15
}
.current-pill{
    display:inline-flex;align-items:center;gap:8px;font-size:14px;
    color:var(--text-mute);background:var(--surface);
    border:1px solid var(--border);padding:7px 18px;border-radius:20px
}
.current-pill strong{color:var(--text);font-weight:700}

/* ===== PLAN GRID ===== */
.plan-grid{
    display:grid;gap:20px;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    max-width:1100px;margin:0 auto 40px
}

/* ===== PLAN CARD ===== */
.plan-card{
    --plan-solid: #6366f1;
    border-radius:22px;padding:28px;
    display:flex;flex-direction:column;position:relative;overflow:hidden;
    border:1.5px solid var(--border);background:var(--surface);
    transition:transform .3s cubic-bezier(.16,1,.3,1),box-shadow .3s ease;
}
.plan-card:hover{transform:translateY(-7px)}

.plan-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:3px;
    background:var(--plan-solid);
}

.plan-card.is-current{
    border-color:var(--plan-solid);
    box-shadow:0 0 0 1px var(--plan-solid),0 12px 40px color-mix(in srgb, var(--plan-solid) 18%, transparent);
}
.active-badge{
    position:absolute;top:14px;right:16px;
    background:var(--plan-solid);color:#fff;
    font-size:10.5px;font-weight:800;letter-spacing:.06em;
    padding:3px 12px;border-radius:20px;text-transform:uppercase;
}

.plan-icon{
    width:46px;height:46px;border-radius:13px;
    display:flex;align-items:center;justify-content:center;
    margin-bottom:18px;flex-shrink:0;
    background:color-mix(in srgb, var(--plan-solid) 13%, transparent);
    border:1px solid color-mix(in srgb, var(--plan-solid) 20%, transparent);
}
.plan-icon svg{width:22px;height:22px;color:var(--plan-solid)}

.plan-name{font-size:22px;font-weight:800;color:var(--text);margin-bottom:4px;font-family:'Space Grotesk',sans-serif}
.plan-tagline{font-size:13px;color:var(--text-mute);margin-bottom:20px;line-height:1.4;min-height:36px}

.plan-price-wrap{margin-bottom:6px}
.plan-price{
    font-family:'Space Grotesk',sans-serif;
    font-size:34px;font-weight:800;color:var(--text);line-height:1
}
.plan-price .rp{font-size:18px;font-weight:600;vertical-align:top;margin-top:5px;display:inline-block;color:var(--plan-solid)}
.plan-price .period{font-size:13px;font-weight:400;color:var(--text-mute)}
.plan-price-free{font-size:34px;font-weight:800;color:var(--plan-solid);font-family:'Space Grotesk',sans-serif}
.plan-price-note{font-size:12px;color:var(--text-faint);margin-top:5px;margin-bottom:18px}
.plan-max-users{
    display:inline-flex;align-items:center;gap:5px;
    font-size:11.5px;color:var(--text-faint);margin-top:6px;margin-bottom:18px
}
.plan-max-users svg{width:12px;height:12px}

.plan-divider{height:1px;background:var(--border);margin:0 0 18px}

.plan-features{display:flex;flex-direction:column;gap:10px;flex:1;margin-bottom:24px}
.pf-item{display:flex;align-items:flex-start;gap:9px;font-size:13px;color:var(--text-mute);line-height:1.4}
.pf-tick{
    width:20px;height:20px;border-radius:6px;flex-shrink:0;margin-top:0px;
    display:flex;align-items:center;justify-content:center;
    background:color-mix(in srgb, var(--plan-solid) 12%, transparent);color:var(--plan-solid);
}
.pf-tick svg{width:11px;height:11px}

.plan-cta{margin-top:auto}
.btn-plan{
    width:100%;padding:13px 20px;border-radius:12px;
    font-size:14px;font-weight:700;cursor:pointer;border:none;
    display:flex;align-items:center;justify-content:center;gap:8px;
    transition:all .22s ease;text-decoration:none;font-family:inherit;
    letter-spacing:.01em;
}
.btn-plan svg{width:15px;height:15px}
.btn-plan.active-plan{
    background:color-mix(in srgb, var(--plan-solid) 12%, transparent);
    color:var(--plan-solid);
    border:1.5px solid color-mix(in srgb, var(--plan-solid) 30%, transparent);
    cursor:default;
}
.btn-plan.upgrade{
    background:var(--plan-solid);color:#fff;
    box-shadow:0 4px 18px color-mix(in srgb, var(--plan-solid) 40%, transparent);
}
.btn-plan.upgrade:hover{
    transform:translateY(-1px);
    box-shadow:0 8px 26px color-mix(in srgb, var(--plan-solid) 55%, transparent);
}
.btn-plan.downgrade{
    background:var(--surface-strong);
    border:1.5px solid var(--border);color:var(--text-mute);
}
.btn-plan.downgrade:hover{color:var(--text);border-color:var(--border-hover)}

.pricing-note{text-align:center;font-size:12.5px;color:var(--text-faint);padding-bottom:28px}

.alert-ok{
    background:rgba(42,157,143,.1);border:1px solid rgba(42,157,143,.3);
    color:#2A9D8F;padding:13px 18px;border-radius:13px;
    font-size:13.5px;margin-bottom:24px;max-width:700px;
    margin-left:auto;margin-right:auto;
    display:flex;align-items:center;gap:9px;
}
.alert-ok svg{width:16px;height:16px;flex-shrink:0}

.pricing-empty{
    text-align:center;padding:80px 20px;
    background:var(--surface);border:1px solid var(--border);border-radius:20px;
    max-width:500px;margin:0 auto;
}
.pricing-empty h2{font-size:18px;font-weight:700;margin-bottom:8px}
.pricing-empty p{font-size:13.5px;color:var(--text-mute)}

@media(max-width:640px){
    .plan-grid{grid-template-columns:1fr}
    .pricing-head h1{font-size:26px}
}
</style>

<svg style="display:none;"><defs>
<symbol id="i-zap"     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></symbol>
<symbol id="i-star"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></symbol>
<symbol id="i-shield"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></symbol>
<symbol id="i-diamond" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"/></symbol>
<symbol id="i-rocket"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></symbol>
<symbol id="i-check"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
<symbol id="i-users"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
<symbol id="i-down"    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
<symbol id="i-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/></symbol>
<symbol id="i-invoice"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6M9 11h6M9 15h3"/></symbol>
<symbol id="i-receive"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="7" x2="7" y2="17"/><polyline points="7 7 7 17 17 17"/></symbol>
<symbol id="i-bank"     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V10l7-6 7 6v11"/><path d="M9 21v-7h6v7"/></symbol>
<symbol id="i-trending" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/></symbol>
<symbol id="i-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
<symbol id="i-target"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></symbol>
</defs></svg>

@if(session('success'))
<div class="alert-ok ad d1">
    <svg><use href="#i-check"/></svg>{{ session('success') }}
</div>
@endif

{{-- HEADER --}}
<div class="pricing-head ad d1">
    <div class="pricing-badge"><svg><use href="#i-zap"/></svg> Paket Berlangganan</div>
    <h1>Pilih paket yang cocok<br>buat bisnismu</h1>
    <div class="current-pill">
        Paket aktif kamu sekarang:
        <strong>{{ ucfirst($currentPlan) }}</strong>
    </div>
</div>

@if($plans->isEmpty())
    <div class="pricing-empty au d2">
        <h2>Belum ada paket tersedia</h2>
        <p>Hubungi administrator untuk informasi paket langganan.</p>
    </div>
@else
    @php
        $taglines = [
            'Mulai dari sini, gratis selamanya.',
            'Paling dipilih bisnis berkembang.',
            'Semua fitur, tanpa batas.',
            'Untuk skala enterprise.',
            'Solusi terlengkap.',
        ];
    @endphp

    <div class="plan-grid">
        @foreach($plans as $i => $plan)
            @php
                $isCurrent = ($currentPlan === $plan->slug);
                $isFree    = ($plan->price == 0);
                $planColor = $plan->color ?: '#6366f1';
                $planIcon  = $plan->icon ?: 'i-zap';

                $features = [];
                if ($plan->description) {
                    $features = array_values(array_filter(
                        array_map('trim', explode("\n", $plan->description))
                    ));
                }
                if (empty($features)) {
                    $features = ['Akses semua fitur dasar', 'Laporan keuangan', 'Manajemen klien'];
                }

                $tagline = $taglines[$i] ?? 'Paket terbaik untuk bisnismu.';
            @endphp

            <div class="plan-card {{ $isCurrent ? 'is-current' : '' }} au" style="--plan-solid:{{ $planColor }}; animation-delay:{{ .1 + $i * .09 }}s;">

                @if($isCurrent)
                    <div class="active-badge">✓ Aktif</div>
                @endif

                <div class="plan-icon">
                    <svg><use href="#{{ $planIcon }}"/></svg>
                </div>

                <div class="plan-name">{{ $plan->name }}</div>
                <div class="plan-tagline">{{ $tagline }}</div>

                <div class="plan-price-wrap">
                    @if($isFree)
                        <div class="plan-price-free">Rp 0</div>
                        <div class="plan-price-note">Gratis selamanya</div>
                    @else
                        <div class="plan-price">
                            <span class="rp">Rp</span>{{ number_format($plan->price, 0, ',', '.') }}
                            <span class="period">/{{ $plan->billing_period === 'monthly' ? 'bulan' : 'tahun' }}</span>
                        </div>
                        <div class="plan-price-note">
                            @if($plan->billing_period === 'yearly')
                                Hemat dibanding bayar bulanan
                            @else
                                Batalkan kapan saja
                            @endif
                        </div>
                    @endif
                </div>

                @if($plan->max_users)
                <div class="plan-max-users">
                    <svg><use href="#i-users"/></svg>
                    Maks. {{ $plan->max_users }} pengguna
                </div>
                @endif

                <div class="plan-divider"></div>

                <div class="plan-features">
                    @foreach($features as $feature)
                    <div class="pf-item">
                        <span class="pf-tick"><svg><use href="#{{ featureIcon($feature) }}"/></svg></span>
                        {{ $feature }}
                    </div>
                    @endforeach
                </div>

                <div class="plan-cta">
                    @if($isCurrent)
                        <div class="btn-plan active-plan">
                            <svg><use href="#i-check"/></svg> Paket Aktif
                        </div>
                    @elseif($isFree)
                        <form method="POST" action="{{ route('pricing.select', $plan->slug) }}">
                            @csrf
                            <button type="submit" class="btn-plan downgrade">
                                <svg><use href="#i-down"/></svg> Turun ke Free
                            </button>
                        </form>
                    @else
                        <a href="{{ route('payment.checkout', $plan->slug) }}" class="btn-plan upgrade">
                            <svg><use href="#i-zap"/></svg> Upgrade Sekarang
                        </a>
                    @endif
                </div>

            </div>
        @endforeach
    </div>

    <div class="pricing-note au">
        Semua harga sudah termasuk PPN. Batalkan langganan kapan saja tanpa biaya tambahan.
    </div>
@endif

</x-app-layout>