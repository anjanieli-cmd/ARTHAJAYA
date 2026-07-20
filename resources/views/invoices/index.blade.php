<x-app-layout>
    <x-slot name="title">Semua Faktur</x-slot>

<style>
    .page-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:26px; flex-wrap:wrap; }
    .page-head h1{ font-size:26px; margin-bottom:6px; }
    .page-head p{ font-size:14px; color:var(--text-mute); }
    .head-actions{ display:flex; gap:10px; }

    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; white-space:nowrap; }
    .btn .icon{ width:15px; height:15px; }
    .btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
    .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 8px 26px rgba(var(--emerald-rgb),0.45); }
    .btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
    .btn-outline:hover{ background:var(--surface-strong); border-color:var(--border-hover); }
    .btn-danger-ghost{ background:none; color:var(--danger); }
    .btn-sm{ padding:8px 14px; font-size:12.5px; }

    .stat-row{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:26px; }
    .stat-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:20px 22px; position:relative; overflow:hidden; }
    .stat-card .sk{ display:flex; align-items:center; gap:8px; font-size:12.5px; color:var(--text-mute); margin-bottom:12px; }
    .stat-card .sk .icon{ width:14px; height:14px; }
    .stat-card .sv{ font-family:'Space Grotesk', sans-serif; font-size:24px; font-weight:600; }
    .stat-card .sc{ font-size:12px; color:var(--text-faint); margin-top:4px; }
    .stat-card.acc-emerald{ border-color: rgba(var(--emerald-rgb),0.25); }
    .stat-card.acc-emerald .sk{ color: var(--emerald); }
    .stat-card.acc-info .sk{ color: var(--info); }
    .stat-card.acc-warning .sk{ color: var(--warning); }
    .stat-card.acc-danger .sk{ color: var(--danger); }

    /* ===== FILTER BAR (samain kaya quotes) ===== */
    .filter-bar{
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .filter-bar input, .filter-bar select{
        padding: 10px 14px;
        border-radius: 12px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }
    .filter-bar input:focus, .filter-bar select:focus{
        border-color: var(--border-hover);
        background: var(--surface-strong);
    }
    .filter-bar input{ flex: 1; min-width: 200px; }
    .filter-bar select{ min-width: 150px; }
    .flex{ display:flex; }
    .gap-2{ gap:8px; }
    .items-center{ align-items:center; }
    .w-full{ width:100%; }
    .min-w-200{ min-width:200px; }

    .bulk-bar{
        display:none; align-items:center; justify-content:space-between; background:rgba(var(--emerald-rgb),0.08); border:1px solid rgba(var(--emerald-rgb),0.3);
        border-radius:14px; padding:12px 18px; margin-bottom:14px; font-size:13.5px;
    }
    .bulk-bar.show{ display:flex; }
    .bulk-bar b{ color:var(--emerald); }
    .bulk-actions{ display:flex; gap:8px; }

    .table-card{ background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
    .table-scroll{ overflow-x:auto; }
    table{ width:100%; border-collapse:collapse; min-width:920px; }
    thead th{
        text-align:left; font-size:11.5px; text-transform:uppercase; letter-spacing:.05em; color:var(--text-faint);
        font-weight:600; padding:14px 18px; border-bottom:1px solid var(--border); white-space:nowrap;
    }
    tbody tr{ border-bottom:1px solid var(--border); transition: background .15s ease; }
    tbody tr:last-child{ border-bottom:none; }
    tbody tr:hover{ background:var(--surface-strong); }
    tbody td{ padding:14px 18px; font-size:13.5px; vertical-align:middle; }
    td.chk, th.chk{ width:44px; padding-left:18px; }
    input[type=checkbox]{ width:17px; height:17px; border-radius:5px; accent-color:var(--emerald); cursor:pointer; }
    .inv-no{ font-family:'IBM Plex Mono', monospace; font-size:13px; color:var(--text); }
    .client-cell{ display:flex; align-items:center; gap:10px; }
    .client-avatar{ width:32px; height:32px; border-radius:9px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:600; color:var(--text-mute); flex-shrink:0; }
    .client-name{ font-weight:600; font-size:13.5px; }
    .client-sub{ font-size:11.5px; color:var(--text-faint); }
    .amount-cell{ font-family:'Space Grotesk', sans-serif; font-weight:600; }
    .date-cell{ color:var(--text-mute); font-size:13px; }
    .date-cell .overdue-flag{ color:var(--danger); font-size:11px; display:block; margin-top:2px; }

    .status-badge{ display:inline-flex; align-items:center; gap:6px; padding:5px 11px; border-radius:100px; font-size:12px; font-weight:600; }
    .status-badge .sdot{ width:6px; height:6px; border-radius:50%; }
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

    .row-actions{ display:flex; align-items:center; gap:4px; justify-content:flex-end; position:relative; }
    .ra-btn{ width:32px; height:32px; border-radius:9px; background:transparent; border:none; display:flex; align-items:center; justify-content:center; color:var(--text-faint); cursor:pointer; transition:all .15s ease; }
    .ra-btn:hover{ background:var(--surface-strong); color:var(--text); }
    .ra-btn .icon{ width:15px; height:15px; }
    .row-menu{
        position:absolute; top:calc(100% + 6px); right:0; min-width:180px; background:var(--modal-bg); border:1px solid var(--border);
        border-radius:14px; padding:8px; box-shadow:0 24px 60px rgba(0,0,0,0.4); z-index:40; opacity:0; visibility:hidden;
        transform:translateY(6px); transition:all .18s ease;
    }
    .row-menu.open{ opacity:1; visibility:visible; transform:translateY(0); }
    .rm-item{ display:flex; align-items:center; gap:10px; padding:9px 11px; border-radius:9px; font-size:13px; color:var(--text-mute); cursor:pointer; transition:all .15s ease; width:100%; background:none; border:none; text-align:left; }
    .rm-item:hover{ background:var(--surface-strong); color:var(--text); }
    .rm-item.danger{ color:var(--danger); }
    .rm-item.danger:hover{ background:rgba(var(--danger-rgb),0.1); }
    .rm-item .icon{ width:14px; height:14px; }
    .rm-divider{ height:1px; background:var(--border); margin:6px 4px; }

    .empty-state{ text-align:center; padding:70px 30px; }
    .empty-ic{ width:64px; height:64px; border-radius:18px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-faint); margin:0 auto 18px; }
    .empty-ic .icon{ width:28px; height:28px; }
    .empty-state h3{ font-size:17px; margin-bottom:6px; }
    .empty-state p{ font-size:13.5px; color:var(--text-mute); max-width:340px; margin:0 auto 20px; }

    .pagination-bar{ display:flex; align-items:center; justify-content:space-between; padding:16px 18px; border-top:1px solid var(--border); flex-wrap:wrap; gap:12px; }
    .pg-info{ font-size:12.5px; color:var(--text-faint); }

    .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; padding:20px; }
    .modal-overlay.open{ display:flex; }
    .modal-box{ background:var(--modal-bg); border:1px solid var(--border); border-radius:20px; padding:28px; max-width:400px; width:100%; box-shadow:0 40px 90px rgba(0,0,0,0.5); }
    .modal-ic{ width:52px; height:52px; border-radius:14px; background:rgba(var(--danger-rgb),0.12); color:var(--danger); display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
    .modal-ic .icon{ width:24px; height:24px; }
    .modal-box h3{ font-size:17px; margin-bottom:8px; }
    .modal-box p{ font-size:13.5px; color:var(--text-mute); margin-bottom:22px; }
    .modal-box p b{ color:var(--text); }
    .modal-actions{ display:flex; gap:10px; justify-content:flex-end; }

    @media (max-width: 1100px){
        .stat-row{ grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width: 560px){
        .stat-row{ grid-template-columns:1fr; }
        .page-head{ flex-direction:column; }
        .head-actions{ width:100%; }
        .head-actions .btn{ flex:1; }
    }
</style>

{{-- ===== PAGE HEADER ===== --}}
<div class="page-head">
    <div>
        <h1>Semua Faktur</h1>
        <p>Kelola, kirim, dan pantau status semua faktur penjualan {{ $company->name ?? 'perusahaanmu' }} di satu tempat.</p>
    </div>
    <div class="head-actions">
        <button type="button" class="btn btn-outline"><svg class="icon"><use href="#ic-download"/></svg> Ekspor</button>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Buat Faktur</a>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="stat-row">
    <div class="stat-card acc-emerald">
        <div class="sk"><svg class="icon"><use href="#ic-invoice"/></svg> Total Faktur</div>
        <div class="sv mono">Rp{{ number_format($stats['total_amount'] ?? 0, 0, ',', '.') }}</div>
        <div class="sc">{{ $stats['total_count'] ?? 0 }} faktur bulan ini</div>
    </div>
    <div class="stat-card acc-emerald">
        <div class="sk"><svg class="icon"><use href="#ic-activity"/></svg> Sudah Dibayar</div>
        <div class="sv mono">Rp{{ number_format($stats['paid_amount'] ?? 0, 0, ',', '.') }}</div>
        <div class="sc">{{ $stats['paid_count'] ?? 0 }} faktur lunas</div>
    </div>
    <div class="stat-card acc-info">
        <div class="sk"><svg class="icon"><use href="#ic-send"/></svg> Menunggu Dibayar</div>
        <div class="sv mono">Rp{{ number_format($stats['outstanding_amount'] ?? 0, 0, ',', '.') }}</div>
        <div class="sc">{{ $stats['outstanding_count'] ?? 0 }} faktur terkirim</div>
    </div>
    <div class="stat-card acc-danger">
        <div class="sk"><svg class="icon"><use href="#ic-alert"/></svg> Jatuh Tempo</div>
        <div class="sv mono">Rp{{ number_format($stats['overdue_amount'] ?? 0, 0, ',', '.') }}</div>
        <div class="sc">{{ $stats['overdue_count'] ?? 0 }} faktur terlambat</div>
    </div>
</div>

{{-- ===== FILTER (samain kaya quotes) ===== --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('invoices.index') }}" class="flex items-center gap-2 w-full">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor faktur atau nama klien..." class="min-w-200">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="draft" {{ request('status')==='draft' ? 'selected' : '' }}>Draft</option>
            <option value="sent" {{ request('status')==='sent' ? 'selected' : '' }}>Terkirim</option>
            <option value="paid" {{ request('status')==='paid' ? 'selected' : '' }}>Lunas</option>
            <option value="overdue" {{ request('status')==='overdue' ? 'selected' : '' }}>Jatuh Tempo</option>
            <option value="cancelled" {{ request('status')==='cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
        @if(request()->anyFilled(['q','status']))
            <a href="{{ route('invoices.index') }}" class="btn btn-outline btn-sm">Reset</a>
        @endif
    </form>
</div>

{{-- ===== BULK ACTIONS BAR ===== --}}
<div class="bulk-bar" id="bulkBar">
    <span><b id="bulkCount">0</b> faktur dipilih</span>
    <div class="bulk-actions">
        <button type="button" class="btn btn-outline btn-sm"><svg class="icon"><use href="#ic-send"/></svg> Kirim</button>
        <button type="button" class="btn btn-outline btn-sm"><svg class="icon"><use href="#ic-download"/></svg> Unduh PDF</button>
        <button type="button" class="btn btn-danger-ghost btn-sm" onclick="openBulkDeleteModal()"><svg class="icon"><use href="#ic-trash"/></svg> Hapus</button>
    </div>
</div>

{{-- ===== TABLE ===== --}}
<div class="table-card">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th class="chk"><input type="checkbox" id="checkAll"></th>
                    <th>No. Faktur</th>
                    <th>Klien</th>
                    <th>Tanggal Terbit</th>
                    <th>Jatuh Tempo</th>
                    <th style="text-align:right;">Jumlah</th>
                    <th>Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    @php
                        $isOverdue = $invoice->status === 'sent' && $invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->isPast();
                        $statusKey = $isOverdue ? 'overdue' : $invoice->status;
                        $statusMap = [
                            'draft'     => ['label' => 'Draft',        'class' => 'status-draft'],
                            'sent'      => ['label' => 'Terkirim',     'class' => 'status-sent'],
                            'paid'      => ['label' => 'Lunas',        'class' => 'status-paid'],
                            'overdue'   => ['label' => 'Jatuh Tempo',  'class' => 'status-overdue'],
                            'cancelled' => ['label' => 'Dibatalkan',   'class' => 'status-cancelled'],
                        ];
                        $st = $statusMap[$statusKey] ?? $statusMap['draft'];
                    @endphp
                    <tr>
                        <td class="chk"><input type="checkbox" class="rowCheck" value="{{ $invoice->id }}"></td>
                        <td><span class="inv-no">{{ $invoice->invoice_number }}</span></td>
                        <td>
                            <div class="client-cell">
                                <div class="client-avatar">{{ strtoupper(substr($invoice->client->name ?? '?', 0, 1)) }}</div>
                                <div>
                                    <div class="client-name">{{ $invoice->client->name ?? 'Klien terhapus' }}</div>
                                    @if($invoice->client->company_name ?? null)
                                        <div class="client-sub">{{ $invoice->client->company_name }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="date-cell">{{ optional($invoice->issue_date)->translatedFormat('d M Y') ?? '—' }}</td>
                        <td class="date-cell">
                            {{ optional($invoice->due_date)->translatedFormat('d M Y') ?? '—' }}
                            @if($isOverdue)
                                <span class="overdue-flag">Terlambat {{ \Carbon\Carbon::parse($invoice->due_date)->diffInDays(now()) }} hari</span>
                            @endif
                        </td>
                        <td class="amount-cell mono" style="text-align:right;">Rp{{ number_format($invoice->total ?? 0, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge {{ $st['class'] }}"><span class="sdot"></span>{{ $st['label'] }}</span>
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-outline btn-sm">Lihat</a>
                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline btn-sm">Edit</a>
                                <button type="button" class="btn btn-outline btn-sm" style="color:var(--danger);" onclick="openDeleteModal('{{ $invoice->id }}', '{{ $invoice->invoice_number }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-ic"><svg class="icon"><use href="#ic-inbox"/></svg></div>
                                <h3>Belum ada faktur</h3>
                                <p>Faktur yang kamu buat untuk klien akan muncul di sini. Mulai dengan membuat faktur pertamamu.</p>
                                <a href="{{ route('invoices.create') }}" class="btn btn-primary"><svg class="icon"><use href="#ic-plus"/></svg> Buat Faktur Pertama</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($invoices) && method_exists($invoices, 'total') && $invoices->total() > 0)
        <div class="pagination-bar">
            <div class="pg-info">
                Menampilkan {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }} dari {{ $invoices->total() }} faktur
            </div>
            <div>
                {{ $invoices->onEachSide(1)->links() }}
            </div>
        </div>
    @endif
</div>

{{-- ===== DELETE CONFIRM MODAL ===== --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-ic"><svg class="icon"><use href="#ic-alert"/></svg></div>
        <h3>Hapus faktur ini?</h3>
        <p>Faktur <b id="deleteInvoiceNo">—</b> akan dihapus permanen dan tidak bisa dikembalikan. Klien tidak akan bisa lagi mengakses tautan faktur ini.</p>
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                <button type="submit" class="btn" style="background:var(--danger); color:#fff;">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    // ===== row "more" menu =====
    document.querySelectorAll('[data-row-menu-toggle]').forEach(function(btn){
        btn.addEventListener('click', function(e){
            e.stopPropagation();
            var id = btn.getAttribute('data-row-menu-toggle');
            var menu = document.getElementById('rowMenu-'+id);
            var wasOpen = menu.classList.contains('open');
            document.querySelectorAll('.row-menu.open').forEach(function(m){ m.classList.remove('open'); });
            menu.classList.toggle('open', !wasOpen);
        });
    });
    document.addEventListener('click', function(){
        document.querySelectorAll('.row-menu.open').forEach(function(el){ el.classList.remove('open'); });
    });

    // ===== select all / bulk bar =====
    var checkAll = document.getElementById('checkAll');
    var bulkBar = document.getElementById('bulkBar');
    var bulkCount = document.getElementById('bulkCount');

    function refreshBulkBar(){
        var checked = document.querySelectorAll('.rowCheck:checked');
        if(checked.length > 0){
            bulkBar.classList.add('show');
            bulkCount.textContent = checked.length;
        } else {
            bulkBar.classList.remove('show');
        }
    }
    if(checkAll){
        checkAll.addEventListener('change', function(){
            document.querySelectorAll('.rowCheck').forEach(function(cb){ cb.checked = checkAll.checked; });
            refreshBulkBar();
        });
    }
    document.querySelectorAll('.rowCheck').forEach(function(cb){
        cb.addEventListener('change', refreshBulkBar);
    });

    // ===== delete modal =====
    function openDeleteModal(id, invoiceNo){
        document.getElementById('deleteInvoiceNo').textContent = invoiceNo;
        document.getElementById('deleteForm').action = '{{ url("invoices") }}/' + id;
        document.getElementById('deleteModal').classList.add('open');
    }
    function closeDeleteModal(){
        document.getElementById('deleteModal').classList.remove('open');
    }
    function openBulkDeleteModal(){
        var ids = Array.from(document.querySelectorAll('.rowCheck:checked')).map(function(cb){ return cb.value; });
        document.getElementById('deleteInvoiceNo').textContent = ids.length + ' faktur terpilih';
        document.getElementById('deleteForm').action = '{{ route("invoices.bulk-destroy") }}';
        document.getElementById('deleteModal').classList.add('open');
    }
    document.getElementById('deleteModal').addEventListener('click', function(e){
        if(e.target === this) closeDeleteModal();
    });
</script>
</x-app-layout>