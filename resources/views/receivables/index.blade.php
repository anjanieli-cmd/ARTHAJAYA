<x-app-layout>
  <x-slot name="title">Piutang Usaha (AR)</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY - ganti dengan query Invoice/Receivable model nanti
    $receivables = [
        ['client' => 'PT Andalas Maju Bersama', 'invoice' => '#0568', 'date' => '10 Jun 2026', 'due' => '10 Jul 2026', 'status' => 'lancar', 'amount' => 5750000],
        ['client' => 'Nusantara Logistik',      'invoice' => '#0571', 'date' => '15 Jun 2026', 'due' => '25 Jun 2026', 'status' => 'lancar', 'amount' => 18400000],
        ['client' => 'Ruang Kriya Studio',      'invoice' => '#0574', 'date' => '18 Jun 2026', 'due' => '28 Jun 2026', 'status' => 'lancar', 'amount' => 6200000],
        ['client' => 'Bumi Retail Group',       'invoice' => '#0552', 'date' => '25 Mei 2026', 'due' => '02 Jun 2026', 'status' => 'jatuh_tempo', 'amount' => 9200000],
        ['client' => 'Kopi Kenangan Senja',     'invoice' => '#0560', 'date' => '01 Jun 2026', 'due' => '15 Jun 2026', 'status' => 'jatuh_tempo', 'amount' => 2800000],
        ['client' => 'Warung Sinar Abadi',      'invoice' => '#0541', 'date' => '20 Mei 2026', 'due' => '28 Mei 2026', 'status' => 'lunas', 'amount' => 4100000],
    ];

    $statusLabel = ['lancar' => 'Lancar', 'jatuh_tempo' => 'Jatuh Tempo', 'lunas' => 'Lunas'];
    $statusPill  = ['lancar' => 'pending', 'jatuh_tempo' => 'overdue', 'lunas' => 'paid'];

    $totalPiutang   = collect($receivables)->whereIn('status', ['lancar', 'jatuh_tempo'])->sum('amount');
    $totalJatuhTempo = collect($receivables)->where('status', 'jatuh_tempo')->sum('amount');
    $totalLancar    = collect($receivables)->where('status', 'lancar')->sum('amount');
    $countJatuhTempo = collect($receivables)->where('status', 'jatuh_tempo')->count();
  @endphp

  <div class="page-head">
    <div>
      <div class="eyebrow"><svg class="icon" style="width:13px;height:13px;"><use href="#ic-receive"/></svg> Piutang &amp; Utang</div>
      <h1>Piutang Usaha (AR)</h1>
      <p>Daftar tagihan yang belum dibayar klien — {{ count($receivables) }} faktur aktif.</p>
    </div>
    <div class="actions">
      <a href="{{ Route::has('aging.index') ? route('aging.index') : '#' }}" class="btn btn-outline">
        <svg class="icon"><use href="#ic-trending"/></svg> Lihat Aging Report
      </a>
      <a href="#" class="btn btn-primary">
        <svg class="icon"><use href="#ic-plus"/></svg> Faktur Baru
      </a>
    </div>
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-receive"/></svg></div></div>
      <div class="lbl">Total Piutang Belum Dibayar</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalPiutang, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-invoice"/></svg></div></div>
      <div class="lbl">Piutang Lancar</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalLancar, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-head"><div class="ic"><svg class="icon"><use href="#ic-trending-down"/></svg></div><div class="chg down">{{ $countJatuhTempo }} faktur</div></div>
      <div class="lbl">Piutang Jatuh Tempo</div>
      <div class="val mono">{{ $currencySymbol }}{{ number_format($totalJatuhTempo, 0, ',', '.') }}</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Daftar Piutang</h3>
      <a href="{{ Route::has('reports.general-ledger') ? route('reports.general-ledger') : '#' }}" class="sub-link">Buku besar piutang <svg class="icon"><use href="#ic-arrow-right"/></svg></a>
    </div>
    <table class="tx-table">
      <thead>
        <tr>
          <th>Klien</th>
          <th>No. Faktur</th>
          <th>Tanggal</th>
          <th>Jatuh Tempo</th>
          <th>Status</th>
          <th style="text-align:right">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @forelse($receivables as $r)
          <tr>
            <td>
              <div class="tx-who">
                <div class="tx-ic"><svg class="icon"><use href="#ic-briefcase"/></svg></div>
                <div class="tx-name">{{ $r['client'] }}</div>
              </div>
            </td>
            <td class="mono">{{ $r['invoice'] }}</td>
            <td>{{ $r['date'] }}</td>
            <td>{{ $r['due'] }}</td>
            <td><span class="status-pill {{ $statusPill[$r['status']] }}">{{ $statusLabel[$r['status']] }}</span></td>
            <td class="amt-cell {{ $r['status'] === 'lunas' ? 'pos' : 'neg' }}">{{ $currencySymbol }}{{ number_format($r['amount'], 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr><td colspan="6"><div class="empty-state">Belum ada piutang tercatat.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-app-layout>