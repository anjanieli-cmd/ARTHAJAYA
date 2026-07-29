<x-admin-layout>
    <x-slot name="title">Kelola Langganan</x-slot>

    <style>
        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(14px);} to{ opacity:1; transform:translateY(0);} }
        @keyframes fadeScaleIn{ from{ opacity:0; transform:scale(.96);} to{ opacity:1; transform:scale(1);} }
        .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) backwards; }
        .animate-scale{ animation:fadeScaleIn .5s cubic-bezier(.16,1,.3,1) backwards; }

        .page-head{ display:flex; justify-content:space-between; align-items:flex-end; gap:20px; flex-wrap:wrap; margin-bottom:22px; }
        .page-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all .2s ease; }
        .btn-primary{ background:var(--emerald); color:#1a1005; }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 8px 20px rgba(var(--emerald-rgb),0.3); }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }
        .alert-error{ background:rgba(232,90,90,0.1); border:1px solid rgba(232,90,90,0.3); color:var(--danger); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        .plan-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:16px; }
        .plan-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:24px; position:relative; transition:all .2s ease; }
        .plan-card:hover{ transform:translateY(-3px); border-color:var(--border-hover); }
        .plan-card.inactive{ opacity:.55; }
        .plan-name{ font-family:'Space Grotesk',sans-serif; font-size:18px; margin-bottom:4px; }
        .plan-price{ font-size:24px; font-weight:700; color:var(--emerald); margin-bottom:2px; }
        .plan-price small{ font-size:12px; color:var(--text-faint); font-weight:400; }
        .plan-desc{ font-size:12.5px; color:var(--text-mute); margin:10px 0 14px; line-height:1.5; }
        .plan-meta{ font-size:12px; color:var(--text-faint); margin-bottom:16px; }
        .plan-actions{ display:flex; gap:8px; }
        .btn-sm{ padding:7px 14px; font-size:12px; border-radius:9px; border:1px solid var(--border); background:var(--surface-strong); color:var(--text); cursor:pointer; text-decoration:none; }
        .btn-sm.danger{ color:var(--danger); }
        .badge-inactive{ position:absolute; top:20px; right:20px; font-size:10px; font-weight:700; text-transform:uppercase; background:var(--surface-strong); color:var(--text-faint); padding:3px 9px; border-radius:100px; }

        /* ===== EMPTY STATE: full centered ===== */
        .empty-wrap{
            display:flex; align-items:center; justify-content:center;
            min-height:calc(100vh - 320px); text-align:center;
        }
        .empty-inner{ max-width:360px; }
        .empty-ic{
            width:64px; height:64px; margin:0 auto 18px; border-radius:18px;
            background:rgba(var(--emerald-rgb),0.12); border:1px solid rgba(var(--emerald-rgb),0.25);
            display:flex; align-items:center; justify-content:center; color:var(--emerald);
        }
        .empty-ic svg{ width:28px; height:28px; }
        .empty-inner h3{ font-family:'Space Grotesk',sans-serif; font-size:17px; margin-bottom:8px; color:var(--text); }
        .empty-inner p{ font-size:13.5px; color:var(--text-mute); line-height:1.6; margin-bottom:22px; }
    </style>

    <svg style="display:none;">
        <defs>
            <symbol id="ic-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><line x1="6" y1="15" x2="10" y2="15"/>
            </symbol>
            <symbol id="ic-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
        </defs>
    </svg>

    <div class="page-head animate-in" style="animation-delay:.03s;">
        <div>
            <h1>Kelola Langganan</h1>
            <p>Atur paket langganan yang tersedia untuk perusahaan pengguna Arvessa.</p>
        </div>
        <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
            <svg style="width:15px;height:15px;"><use href="#ic-plus"/></svg> Tambah Paket
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success animate-in" style="animation-delay:.06s;">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error animate-in" style="animation-delay:.06s;">{{ $errors->first() }}</div>
    @endif

    @if($plans->isEmpty())
        <div class="empty-wrap animate-scale" style="animation-delay:.1s;">
            <div class="empty-inner">
                <div class="empty-ic"><svg><use href="#ic-card"/></svg></div>
                <h3>Belum ada paket langganan</h3>
                <p>Kamu belum membuat paket langganan apa pun. Klik tombol di bawah untuk membuat paket pertama yang bisa dipilih perusahaan.</p>
                <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
                    <svg style="width:15px;height:15px;"><use href="#ic-plus"/></svg> Tambah Paket Pertama
                </a>
            </div>
        </div>
    @else
        <div class="plan-grid">
            @foreach($plans as $i => $plan)
                <div class="plan-card {{ $plan->is_active ? '' : 'inactive' }} animate-in" style="animation-delay:{{ .1 + ($i * .05) }}s;">
                    @unless($plan->is_active)
                        <span class="badge-inactive">Nonaktif</span>
                    @endunless
                    <div class="plan-name">{{ $plan->name }}</div>
                    <div class="plan-price">
                        Rp{{ number_format($plan->price, 0, ',', '.') }}
                        <small>/ {{ $plan->billing_period === 'monthly' ? 'bulan' : 'tahun' }}</small>
                    </div>
                    <div class="plan-desc">{{ $plan->description ?? 'Tidak ada deskripsi.' }}</div>
                    <div class="plan-meta">
                        Maks. {{ $plan->max_users ?? 'tak terbatas' }} user &middot;
                        Dipakai {{ $plan->companies_count }} perusahaan
                    </div>
                    <div class="plan-actions">
                        <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.subscription-plans.destroy', $plan) }}" onsubmit="return confirm('Hapus paket ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm danger">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-admin-layout>