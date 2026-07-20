<x-app-layout>
  <x-slot name="title">Penawaran</x-slot>

<style>
    .stat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 26px;
    }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px 22px;
    }
    .stat-card .sk {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-mute);
        margin-bottom: 12px;
    }
    .stat-card .sk .icon {
        width: 14px;
        height: 14px;
    }
    .stat-card .sv {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 24px;
        font-weight: 600;
    }
    .stat-card .sc {
        font-size: 12px;
        color: var(--text-faint);
        margin-top: 4px;
    }
    .stat-card.acc-emerald {
        border-color: rgba(var(--emerald-rgb), 0.25);
    }
    .stat-card.acc-emerald .sk {
        color: var(--emerald);
    }
    .stat-card.acc-blue .sk {
        color: var(--info);
    }
    .stat-card.acc-danger .sk {
        color: var(--danger);
    }
    .stat-card.acc-warning .sk {
        color: var(--warning);
    }
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all .2s ease;
        white-space: nowrap;
    }
    .btn .icon {
        width: 15px;
        height: 15px;
    }
    .btn-primary {
        background: var(--emerald);
        color: #052117;
        box-shadow: 0 4px 20px rgba(var(--emerald-rgb), 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 26px rgba(var(--emerald-rgb), 0.45);
    }
    .btn-outline {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
    }
    .btn-outline:hover {
        background: var(--surface-strong);
        border-color: var(--border-hover);
    }
    .btn-sm {
        padding: 8px 14px;
        font-size: 12.5px;
    }
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
    }
    .table-scroll {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }
    thead th {
        text-align: left;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--text-faint);
        font-weight: 600;
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    tbody td {
        padding: 14px 18px;
        font-size: 13.5px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border);
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    tbody tr:hover {
        background: var(--surface-strong);
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-draft {
        background: var(--surface-strong);
        color: var(--text-mute);
    }
    .status-sent {
        background: rgba(var(--info-rgb, 78, 143, 240), 0.12);
        color: var(--info);
    }
    .status-accepted {
        background: rgba(var(--emerald-rgb), 0.12);
        color: var(--emerald);
    }
    .status-rejected {
        background: rgba(var(--danger-rgb, 232, 90, 122), 0.12);
        color: var(--danger);
    }
    .status-expired {
        background: rgba(232, 162, 58, 0.12);
        color: var(--warning);
    }
    .page-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 26px;
        flex-wrap: wrap;
    }
    .page-head h1 {
        font-size: 26px;
        margin-bottom: 6px;
    }
    .page-head p {
        font-size: 14px;
        color: var(--text-mute);
    }
    .head-actions {
        display: flex;
        gap: 10px;
    }
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .filter-bar input, .filter-bar select {
        padding: 10px 14px;
        border-radius: 12px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }
    .filter-bar input:focus, .filter-bar select:focus {
        border-color: var(--border-hover);
        background: var(--surface-strong);
    }
    .filter-bar input {
        flex: 1;
        min-width: 200px;
    }
    .filter-bar select {
        min-width: 150px;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-mute);
    }
    .empty-state .icon {
        width: 48px;
        height: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    .empty-state h3 {
        font-size: 18px;
        color: var(--text);
        margin-bottom: 8px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 26px;
    }
    .pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
        gap: 12px;
    }
    .pg-info {
        font-size: 12.5px;
        color: var(--text-faint);
    }
    .pg-nav {
        display: flex;
        gap: 6px;
    }
    .pg-btn {
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        border-radius: 9px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-mute);
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .15s ease;
    }
    .pg-btn:hover {
        border-color: var(--border-hover);
        color: var(--text);
    }
    .pg-btn.active {
        background: var(--emerald);
        border-color: var(--emerald);
        color: #052117;
        font-weight: 700;
    }
    .mono {
        font-family: 'IBM Plex Mono', monospace;
    }
    .text-right {
        text-align: right;
    }
    .flex {
        display: flex;
    }
    .gap-2 {
        gap: 8px;
    }
    .items-center {
        align-items: center;
    }
    .justify-between {
        justify-content: space-between;
    }
    .mb-4 {
        margin-bottom: 16px;
    }
    .mt-4 {
        margin-top: 16px;
    }
    .w-full {
        width: 100%;
    }
    .min-w-200 {
        min-width: 200px;
    }
    .text-sm {
        font-size: 13px;
    }
    .text-gray-500 {
        color: var(--text-mute);
    }
    .text-emerald-500 {
        color: var(--emerald);
    }
    .bg-gray-100 {
        background: var(--surface);
    }
    .bg-blue-100 {
        background: rgba(var(--info-rgb, 78, 143, 240), 0.12);
    }
    .bg-green-100 {
        background: rgba(var(--emerald-rgb), 0.12);
    }
    .bg-red-100 {
        background: rgba(var(--danger-rgb, 232, 90, 122), 0.12);
    }
    .p-4 {
        padding: 16px;
    }
    .rounded-lg {
        border-radius: 12px;
    }
    .text-xl {
        font-size: 20px;
    }
    .font-bold {
        font-weight: 700;
    }
    .grid-cols-4 {
        grid-template-columns: repeat(4, 1fr);
    }
    .gap-4 {
        gap: 16px;
    }
    .mb-6 {
        margin-bottom: 24px;
    }
    .mt-6 {
        margin-top: 24px;
    }
</style>

<div class="page-head">
    <div>
        <h1>Daftar Penawaran</h1>
        <p>Kelola semua penawaran/quotation yang telah dibuat.</p>
    </div>
    <div class="head-actions">
        <a href="{{ route('quotes.create') }}" class="btn btn-primary">
            <svg class="icon"><use href="#ic-plus"/></svg> Buat Penawaran
        </a>
    </div>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card acc-emerald">
        <div class="sk"><svg class="icon"><use href="#ic-invoice"/></svg> Total</div>
        <div class="sv mono">{{ $stats['total_count'] ?? 0 }}</div>
        <div class="sc">Total penawaran</div>
    </div>
    <div class="stat-card acc-blue">
        <div class="sk"><svg class="icon"><use href="#ic-send"/></svg> Terkirim</div>
        <div class="sv mono">{{ $stats['sent_count'] ?? 0 }}</div>
        <div class="sc">Menunggu respon</div>
    </div>
    <div class="stat-card acc-emerald">
        <div class="sk"><svg class="icon"><use href="#ic-check"/></svg> Diterima</div>
        <div class="sv mono">{{ $stats['accepted_count'] ?? 0 }}</div>
        <div class="sc">Disetujui klien</div>
    </div>
    <div class="stat-card acc-danger">
        <div class="sk"><svg class="icon"><use href="#ic-alert"/></svg> Kadaluwarsa</div>
        <div class="sv mono">{{ $stats['expired_count'] ?? 0 }}</div>
        <div class="sc">Melewati masa berlaku</div>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-bar">
    <form method="GET" class="flex items-center gap-2 w-full">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor penawaran atau klien..." class="min-w-200">
        <select name="status">
            <option value="">Semua Status</option>
            @foreach($statusLabels as $key => $label)
                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
        @if(request()->anyFilled(['q','status']))
            <a href="{{ route('quotes.index') }}" class="btn btn-outline btn-sm">Reset</a>
        @endif
    </form>
</div>

{{-- TABLE --}}
<div class="table-card">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>No. Penawaran</th>
                    <th>Klien</th>
                    <th>Tanggal</th>
                    <th>Berlaku Sampai</th>
                    <th class="text-right">Total</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotes as $quote)
                <tr>
                    <td><span class="mono">{{ $quote->quote_number }}</span></td>
                    <td>{{ $quote->client->name ?? '—' }}</td>
                    <td>{{ optional($quote->issue_date)->format('d M Y') }}</td>
                    <td>{{ optional($quote->valid_until)->format('d M Y') }}</td>
                    <td class="mono text-right">Rp{{ number_format($quote->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-badge status-{{ $quote->status }}">
                            {{ $statusLabels[$quote->status] ?? ucfirst($quote->status) }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('quotes.show', $quote) }}" class="btn btn-outline btn-sm">Lihat</a>
                        <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Hapus penawaran ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm" style="color:var(--danger);">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg class="icon"><use href="#ic-inbox"/></svg>
                            <h3>Belum ada penawaran</h3>
                            <p>Buat penawaran pertama untuk klienmu.</p>
                            <a href="{{ route('quotes.create') }}" class="btn btn-primary mt-4">+ Buat Penawaran</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($quotes) && method_exists($quotes, 'total') && $quotes->total() > 0)
        <div class="pagination-bar">
            <div class="pg-info">
                Menampilkan {{ $quotes->firstItem() }}–{{ $quotes->lastItem() }} dari {{ $quotes->total() }} penawaran
            </div>
            <div class="pg-nav">
                {{ $quotes->onEachSide(1)->links() }}
            </div>
        </div>
    @endif
</div>
</x-app-layout>