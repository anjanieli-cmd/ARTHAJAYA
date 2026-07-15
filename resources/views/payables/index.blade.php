<x-app-layout>
  <x-slot name="title">Utang Usaha (AP)</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query Bill/Payable model nanti
    $payables = [
        ['vendor' => 'Toko Bangunan Sentosa',  'bill' => '#B-0112', 'date' => '05 Jun 2026', 'due' => '20 Jul 2026', 'status' => 'lancar', 'amount' => 12500000],
        ['vendor' => 'CV Kertas Nusantara',    'bill' => '#B-0119', 'date' => '12 Jun 2026', 'due' => '12 Jul 2026', 'status' => 'lancar', 'amount' => 3200000],
        ['vendor' => 'PLN — Listrik Kantor',   'bill' => '#B-0125', 'date' => '01 Jun 2026', 'due' => '15 Jun 2026', 'status' => 'jatuh_tempo', 'amount' => 4100000],
        ['vendor' => 'Distributor Kain Batik', 'bill' => '#B-0103', 'date' => '20 Mei 2026', 'due' => '05 Jun 2026', 'status' => 'jatuh_tempo', 'amount' => 21400000],
        ['vendor' => 'Jasa Ekspedisi Cepat',   'bill' => '#B-0098', 'date' => '10 Mei 2026', 'due' => '24 Mei 2026', 'status' => 'lunas', 'amount' => 1850000],
    ];

    $statusLabel = ['lancar' => 'Lancar', 'jatuh_tempo' => 'Jatuh Tempo', 'lunas' => 'Lunas'];
    $statusPill  = ['lancar' => 'pending', 'jatuh_tempo' => 'overdue', 'lunas' => 'paid'];

    $totalUtang      = collect($payables)->whereIn('status', ['lancar', 'jatuh_tempo'])->sum('amount');
    $totalJatuhTempo = collect($payables)->where('status', 'jatuh_tempo')->sum('amount');
    $totalLancar     = collect($payables)->where('status', 'lancar')->sum('amount');
    $countJatuhTempo = collect($payables)->where('status', 'jatuh_tempo')->count();
  @endphp

  <div class="page-head">
    <div>
      <div class="eyebrow"><svg class="icon" style="width:13px;height:13px;"><use href="#ic-trending-down"/></svg> Piutang &amp; Utang</div>
      <h1>Utang Usaha (AP)</h1>
      <p>Daftar tagihan dari supplier/vendor yang belum dibayar — {{ count($payables) }} tagihan aktif.</p>
    </div>
    <div class="actions">
      <a href="{{ Route::has('aging.index') ? route('aging.index') : '#' }}" class="btn btn-outline">
        <svg class="icon"><use href="#ic-trending"/></svg> Lihat Aging Report
      </a>
      <a href="#" class="btn btn-primary">
        <svg class="icon"><use href="#ic-plus"/></svg> Tagihan Baru
      </a>
    </div>
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div></div>
      <div class="lbl">Total Utang Belum Dibayar</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalUtang, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-doc"/></svg></div></div>
      <div class="lbl">Utang Lancar</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalLancar, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div><div class="chg down">{{ $countJatuhTempo }} tagihan</div></div>
      <div class="lbl">Utang Jatuh Tempo</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalJatuhTempo, 0, ',', '.') }}</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Daftar Utang</h3>
      <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="sub-link">Buku besar utang <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
    </div>
    <table class="tx-table">
      <thead>
        <tr>
          <th>Vendor</th>
          <th>No. Tagihan</th>
          <th>Tanggal</th>
          <th>Jatuh Tempo</th>
          <th>Status</th>
          <th style="text-align:right">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @forelse($payables as $p)
          <tr>
            <td>
              <div class="tx-who">
                <div class="tx-ic"><svg class="icon"><use href="#ic-building"/></svg></div>
                <div class="tx-name">{{ $p['vendor'] }}</div>
              </div>
            </td>
            <td class="mono">{{ $p['bill'] }}</td>
            <td>{{ $p['date'] }}</td>
            <td>{{ $p['due'] }}</td>
            <td><span class="status-pill {{ $statusPill[$p['status']] }}">{{ $statusLabel[$p['status']] }}</span></td>
            <td class="amt-cell neg">{{ $currencySymbol }}{{ number_format($p['amount'], 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr><td colspan="6"><div class="empty-state">Belum ada utang tercatat.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-app-layout>