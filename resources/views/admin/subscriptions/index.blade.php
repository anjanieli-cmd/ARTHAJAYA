<x-admin-layout>
    <x-slot name="title">Kelola Langganan</x-slot>

    <style>
        .page-head{ display:flex; justify-content:space-between; align-items:flex-end; gap:20px; flex-wrap:wrap; margin-bottom:22px; }
        .page-head h1{ font-size:25px; margin-bottom:6px; font-family:'Space Grotesk',sans-serif; }
        .page-head p{ font-size:13.5px; color:var(--text-mute); }

        .btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; text-decoration:none; }
        .btn-primary{ background:var(--emerald); color:#1a1005; }

        .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }
        .alert-error{ background:rgba(232,90,90,0.1); border:1px solid rgba(232,90,90,0.3); color:var(--danger); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

        .plan-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:16px; }
        .plan-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:24px; position:relative; }
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
        .empty-hint{ text-align:center; padding:40px 20px; color:var(--text-faint); font-size:13.5px; }
    </style>

    <div class="page-head">
        <div>
            <h1>Kelola Langganan</h1>
            <p>Atur paket langganan yang tersedia untuk perusahaan pengguna Arvessa.</p>
        </div>
        <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">+ Tambah Paket</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="plan-grid">
        @forelse($plans as $plan)
            <div class="plan-card {{ $plan->is_active ? '' : 'inactive' }}">
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
        @empty
            <div class="empty-hint">Belum ada paket langganan. Klik "+ Tambah Paket" untuk membuat yang pertama.</div>
        @endforelse
    </div>
</x-admin-layout>