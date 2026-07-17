<x-app-layout>
    <x-slot name="title">Buku Besar</x-slot>

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
    .btn-sm{ padding:7px 12px; font-size:12px; }

    .alert-success{ background:rgba(var(--emerald-rgb),0.1); border:1px solid rgba(var(--emerald-rgb),0.3); color:var(--emerald); padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:18px; }

    /* ===== ACCOUNT PILLS ===== */
    .account-pills{ display:flex; flex-wrap:wrap; gap:8px; margin-bottom:22px; }
    .account-pill{
        display:flex; flex-direction:column; gap:2px; padding:10px 16px; border-radius:12px; background:var(--surface);
        border:1px solid var(--border); cursor:pointer; transition:all .15s ease; min-width:150px;
    }
    .account-pill:hover{ border-color:var(--border-hover); }
    .account-pill.active{ border-color:var(--emerald); background:rgba(var(--emerald-rgb),0.08); }
    .account-pill .ap-code{ font-family:'IBM Plex Mono', monospace; font-size:11px; color:var(--text-faint); }
    .account-pill .ap-name{ font-size:13px; font-weight:600; color:var(--text); }
    .account-pill .ap-balance{ font-family:'IBM Plex Mono', monospace; font-size:12px; color:var(--text-mute); margin-top:2px; }
    .account-pill.active .ap-name{ color:var(--emerald); }

    .date-range-filter{ display:flex; align-items:center; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
    .date-range-filter input{
        padding:9px 12px; border-radius:10px; background:var(--surface); border:1px solid var(--border);
        color:var(--text); font-size:12.5px; outline:none;
    }
    .date-range-filter span{ color:var(--text-faint); font-size:12.5px; }

    /* ===== CLASSIC LEDGER TABLE ===== */
    .ledger-header-strip{ display:flex; align-items:center; justify-content:space-between; background:var(--surface); border:1px solid var(--border); border-radius:14px 14px 0 0; padding:16px 20px; border-bottom:none; }
    .ledger-header-strip h3{ font-family:'Space Grotesk', sans-serif; font-size:15px; }
    .ledger-header-strip .code{ font-family:'IBM Plex Mono', monospace; font-size:12px; color:var(--text-faint); margin-left:8px; }
    .ledger-header-strip .bal{ font-family:'IBM Plex Mono', monospace; font-size:15px; font-weight:700; color:var(--emerald); }

    .table-card{ background:var(--surface); border:1px solid var(--border); border-radius:0 0 18px 18px; overflow:hidden; }
    .table-scroll{ overflow-x:auto; }
    table{ width:100%; border-collapse:collapse; min-width:720px; }
    thead th{
        text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint);
        font-weight:600; padding:12px 18px; border-bottom:1px solid var(--border); white-space:nowrap; background:var(--surface-strong);
    }
    tbody tr{ border-bottom:1px solid var(--border); }
    tbody tr:last-child{ border-bottom:none; }
    tbody tr:hover{ background:var(--surface-strong); }
    tbody td{ padding:11px 18px; font-size:13px; vertical-align:middle; }
    .mono{ font-family:'IBM Plex Mono', monospace; }
    .text-right{ text-align:right; }
    .ld-debit{ color:var(--emerald); }
    .ld-credit{ color:var(--danger); }
    .ld-actions{ display:flex; gap:10px; justify-content:flex-end; }
    .ld-actions a, .ld-actions button{ font-size:11.5px; color:var(--text-faint); background:none; border:none; cursor:pointer; }
    .ld-actions a:hover{ color:var(--emerald); }
    .ld-actions button:hover{ color:var(--danger); }

    .empty-state{ text-align:center; padding:60px 30px; }
    .empty-ic{ width:56px; height:56px; border-radius:16px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-faint); margin:0 auto 16px; }
    .empty-ic .icon{ width:24px; height:24px; }
    .empty-state h3{ font-size:16px; margin-bottom:6px; }
    .empty-state p{ font-size:13px; color:var(--text-mute); max-width:320px; margin:0 auto; }

    @media (max-width:640px){
        .page-head{ flex-direction:column; }
        .head-actions{ width:100%; }
        .head-actions .btn{ flex:1; }
    }
</style>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="page-head">
    <div>
        <h1>Buku Besar</h1>
        <p>Riwayat transaksi debit/kredit per akun untuk {{ $company->name ?? 'perusahaanmu' }}.</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('ledger.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Tambah Transaksi</a>
    </div>
</div>

@if($accounts->isEmpty())
    <div class="empty-state">
        <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
        <h3>Belum ada akun</h3>
        <p>Tambahkan transaksi pertama untuk mulai membangun buku besar.</p>
    </div>
@else
    <div class="account-pills">
        @foreach($accounts as $acc)
            @php $balance = (float) $acc->total_debit - (float) $acc->total_credit; @endphp
            <a href="{{ route('ledger.index', ['account' => $acc->account_code]) }}" class="account-pill {{ $accountCode === $acc->account_code ? 'active' : '' }}" style="text-decoration:none;">
                <span class="ap-code">{{ $acc->account_code }}</span>
                <span class="ap-name">{{ $acc->account_name }}</span>
                <span class="ap-balance">Rp{{ number_format($balance, 0, ',', '.') }}</span>
            </a>
        @endforeach
    </div>

    @if($accountCode && $selectedAccount)
        <form method="GET" action="{{ route('ledger.index') }}" class="date-range-filter">
            <input type="hidden" name="account" value="{{ $accountCode }}">
            <input type="date" name="from" value="{{ $from }}">
            <span>s/d</span>
            <input type="date" name="to" value="{{ $to }}">
            <button type="submit" class="btn btn-outline btn-sm">Terapkan</button>
            @if($from || $to)
                <a href="{{ route('ledger.index', ['account' => $accountCode]) }}" class="btn btn-outline btn-sm">Reset Tanggal</a>
            @endif
        </form>

        <div class="ledger-header-strip">
            <h3>{{ $selectedAccount->account_name }} <span class="code">{{ $selectedAccount->account_code }}</span></h3>
            <span class="bal">Saldo: Rp{{ number_format((float) $selectedAccount->total_debit - (float) $selectedAccount->total_credit, 0, ',', '.') }}</span>
        </div>

        <div class="table-card">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Kredit</th>
                            <th class="text-right">Saldo</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $entry)
                        <tr>
                            <td class="mono">{{ $entry->transaction_date->format('d/m/Y') }}</td>
                            <td>{{ $entry->description }}</td>
                            <td class="text-right mono ld-debit">{{ $entry->debit > 0 ? 'Rp'.number_format($entry->debit, 0, ',', '.') : '—' }}</td>
                            <td class="text-right mono ld-credit">{{ $entry->credit > 0 ? 'Rp'.number_format($entry->credit, 0, ',', '.') : '—' }}</td>
                            <td class="text-right mono">Rp{{ number_format($entry->running_balance, 0, ',', '.') }}</td>
                            <td>
                                <div class="ld-actions">
                                    <a href="{{ route('ledger.edit', $entry) }}">Edit</a>
                                    <form method="POST" action="{{ route('ledger.destroy', $entry) }}" onsubmit="return confirm('Hapus transaksi ini?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                                    <h3>Belum ada transaksi</h3>
                                    <p>Transaksi untuk akun ini akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-ic"><svg class="icon"><use href="#ic-eye"/></svg></div>
            <h3>Pilih akun di atas</h3>
            <p>Klik salah satu akun untuk melihat riwayat transaksinya.</p>
        </div>
    @endif
@endif
</x-app-layout>