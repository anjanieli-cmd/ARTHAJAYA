<x-app-layout>
    <x-slot name="title">{{ $client->name }}</x-slot>

<style>
    .page-head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:14px; }
    .page-head h1{ font-size:24px; margin-bottom:6px; }
    .page-head p{ font-size:13.5px; color:var(--text-mute); }
    .head-actions{ display:flex; gap:10px; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; }
    .btn .icon{ width:15px; height:15px; }
    .btn-primary{ background:var(--emerald); color:#052117; }
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); }
    .btn-danger-ghost{ background:none; border:1px solid rgba(var(--danger-rgb),0.3); color:var(--danger); }
    .btn-danger-ghost:hover{ background:rgba(var(--danger-rgb),0.1); }
    .btn-sm{ padding:8px 14px; font-size:12.5px; }

    .detail-grid-wrap{ display:grid; grid-template-columns:1fr 1.4fr; gap:20px; align-items:start; max-width:1100px; }

    .profile-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:28px; }
    .profile-avatar{ width:64px; height:64px; border-radius:16px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:700; color:var(--emerald); margin-bottom:16px; }
    .profile-name{ font-family:'Space Grotesk', sans-serif; font-size:19px; margin-bottom:2px; }
    .profile-company{ font-size:13px; color:var(--text-mute); margin-bottom:20px; }
    .profile-field{ padding:12px 0; border-top:1px solid var(--border); }
    .profile-field .k{ font-size:11.5px; color:var(--text-faint); margin-bottom:4px; }
    .profile-field .v{ font-size:13.5px; font-weight:500; }
    .profile-stats{ display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:18px; }
    .profile-stat{ background:var(--surface-strong); border:1px solid var(--border); border-radius:12px; padding:14px; text-align:center; }
    .profile-stat .n{ font-family:'Space Grotesk', sans-serif; font-size:20px; font-weight:700; color:var(--emerald); }
    .profile-stat .l{ font-size:11px; color:var(--text-faint); margin-top:2px; }

    .activity-panel{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:28px; }
    .activity-panel + .activity-panel{ margin-top:18px; }
    .activity-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
    .activity-title h3{ font-family:'Space Grotesk', sans-serif; font-size:15.5px; }
    .activity-title a{ font-size:12.5px; color:var(--emerald); font-weight:600; }

    .activity-row{ display:flex; align-items:center; justify-content:space-between; gap:10px; padding:11px 0; border-bottom:1px solid var(--border); font-size:13px; }
    .activity-row:last-child{ border-bottom:none; }
    .activity-row-left{ display:flex; flex-direction:column; gap:2px; }
    .activity-row-num{ font-family:'IBM Plex Mono', monospace; font-size:12.5px; }
    .activity-row-date{ font-size:11.5px; color:var(--text-faint); }
    .activity-row-amount{ font-family:'IBM Plex Mono', monospace; font-weight:600; }
    .activity-empty{ font-size:12.5px; color:var(--text-faint); text-align:center; padding:16px 0; }

    .status-badge{ display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:100px; font-size:11px; font-weight:600; }
    .status-draft{ background:var(--surface-strong); color:var(--text-mute); }
    .status-sent{ background:rgba(var(--info-rgb),0.12); color:var(--info); }
    .status-paid, .status-accepted{ background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); }
    .status-overdue, .status-rejected{ background:rgba(var(--danger-rgb),0.12); color:var(--danger); }
    .status-cancelled, .status-expired{ background:var(--surface-strong); color:var(--text-faint); }

    .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; padding:20px; }
    .modal-overlay.open{ display:flex; }
    .modal-box{ background:var(--modal-bg, var(--surface)); border:1px solid var(--border); border-radius:20px; padding:28px; max-width:400px; width:100%; box-shadow:0 40px 90px rgba(0,0,0,0.5); }
    .modal-ic{ width:52px; height:52px; border-radius:14px; background:rgba(var(--danger-rgb),0.12); color:var(--danger); display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
    .modal-ic .icon{ width:24px; height:24px; }
    .modal-box h3{ font-size:17px; margin-bottom:8px; }
    .modal-box p{ font-size:13.5px; color:var(--text-mute); margin-bottom:22px; }
    .modal-box p b{ color:var(--text); }
    .modal-actions{ display:flex; gap:10px; justify-content:flex-end; }

    @media (max-width:900px){ .detail-grid-wrap{ grid-template-columns:1fr; } }
</style>

<div class="page-head">
    <div>
        <h1>{{ $client->name }}</h1>
        <p>Detail informasi dan riwayat transaksi klien.</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('clients.index') }}" class="btn btn-outline">Kembali</a>
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">Edit Klien</a>
        <button type="button" class="btn btn-danger-ghost" onclick="document.getElementById('deleteModal').classList.add('open')">Hapus</button>
    </div>
</div>

<div class="detail-grid-wrap">
    {{-- ===== KIRI: PROFIL ===== --}}
    <div class="profile-panel">
        <div class="profile-avatar">{{ strtoupper(substr($client->name, 0, 1)) }}</div>
        <div class="profile-name">{{ $client->name }}</div>
        <div class="profile-company">{{ $client->company_name ?? 'Tidak ada nama perusahaan' }}</div>

        <div class="profile-field">
            <div class="k">Email</div>
            <div class="v">{{ $client->email ?? '—' }}</div>
        </div>
        <div class="profile-field">
            <div class="k">Telepon</div>
            <div class="v">{{ $client->phone ?? '—' }}</div>
        </div>
        <div class="profile-field">
            <div class="k">Alamat</div>
            <div class="v">{{ $client->address ?? '—' }}</div>
        </div>
        @if($client->notes)
        <div class="profile-field">
            <div class="k">Catatan</div>
            <div class="v">{{ $client->notes }}</div>
        </div>
        @endif

        <div class="profile-stats">
            <div class="profile-stat">
                <div class="n">{{ $client->invoices_count }}</div>
                <div class="l">Faktur</div>
            </div>
            <div class="profile-stat">
                <div class="n">{{ $client->quotes_count }}</div>
                <div class="l">Penawaran</div>
            </div>
        </div>
    </div>

    {{-- ===== KANAN: AKTIVITAS ===== --}}
    <div>
        <div class="activity-panel">
            <div class="activity-title">
                <h3>Faktur Terbaru</h3>
                <a href="{{ route('invoices.index') }}">Lihat semua →</a>
            </div>
            @forelse($client->invoices as $invoice)
                <div class="activity-row">
                    <div class="activity-row-left">
                        <span class="activity-row-num">{{ $invoice->invoice_number }}</span>
                        <span class="activity-row-date">{{ optional($invoice->issue_date)->translatedFormat('d M Y') }}</span>
                    </div>
                    <span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
                    <span class="activity-row-amount">Rp{{ number_format($invoice->total, 0, ',', '.') }}</span>
                </div>
            @empty
                <div class="activity-empty">Belum ada faktur untuk klien ini.</div>
            @endforelse
        </div>

        <div class="activity-panel">
            <div class="activity-title">
                <h3>Penawaran Terbaru</h3>
                <a href="{{ route('quotes.index') }}">Lihat semua →</a>
            </div>
            @forelse($client->quotes as $quote)
                <div class="activity-row">
                    <div class="activity-row-left">
                        <span class="activity-row-num">{{ $quote->quote_number }}</span>
                        <span class="activity-row-date">{{ optional($quote->issue_date)->translatedFormat('d M Y') }}</span>
                    </div>
                    <span class="status-badge status-{{ $quote->status }}">{{ ucfirst($quote->status) }}</span>
                    <span class="activity-row-amount">Rp{{ number_format($quote->total, 0, ',', '.') }}</span>
                </div>
            @empty
                <div class="activity-empty">Belum ada penawaran untuk klien ini.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ===== DELETE CONFIRM MODAL ===== --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-ic"><svg class="icon"><use href="#ic-alert"/></svg></div>
        <h3>Hapus klien ini?</h3>
        <p>Klien <b>{{ $client->name }}</b> akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <form method="POST" action="{{ route('clients.destroy', $client) }}">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn" style="background:var(--danger); color:#fff;">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('deleteModal').addEventListener('click', function(e){
        if(e.target === this) this.classList.remove('open');
    });
</script>
</x-app-layout>