<x-app-layout>
  <x-slot name="title">Harga Pokok Penjualan</x-slot>

<style>
  .cg-page-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:22px; flex-wrap:wrap; }
  .cg-page-head h1{ font-size:25px; margin-bottom:6px; }
  .cg-page-head p{ font-size:13.5px; color:var(--text-mute); }

  .cg-btn{ display:inline-flex; align-items:center; gap:8px; padding:11px 20px; border-radius:11px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; text-decoration:none; }
  .cg-btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
  .cg-btn-primary:hover{ transform:translateY(-1px); }
  .cg-btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .cg-btn-sm{ padding:7px 12px; font-size:12px; }

  /* Stat trio - lingkaran, beda dari strip di Stok Barang */
  .cg-stat-row{ display:flex; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
  .cg-stat-circle{ flex:1; min-width:180px; background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:14px; }
  .cg-stat-circle .ring{ width:46px; height:46px; border-radius:50%; background:rgba(var(--emerald-rgb),0.12); color:var(--emerald); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
  .cg-stat-circle .ring .icon{ width:20px; height:20px; }
  .cg-stat-circle .k{ font-size:11.5px; color:var(--text-faint); margin-bottom:3px; }
  .cg-stat-circle .v{ font-family:'Space Grotesk'; font-size:18px; font-weight:700; }

  .cg-toolbar{ display:flex; gap:10px; margin-bottom:24px; flex-wrap:wrap; align-items:center; }
  .cg-search{ flex:1; min-width:200px; }
  .cg-search input, .cg-toolbar input[type=month]{ width:100%; padding:10px 14px; border-radius:11px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; }
  .cg-search input:focus, .cg-toolbar input[type=month]:focus{ border-color:var(--border-hover); background:var(--surface-strong); }

  /* TIMELINE — pola utama yang membedakan halaman ini */
  .cg-timeline{ position:relative; padding-left:6px; }
  .cg-day-group{ margin-bottom:28px; }
  .cg-day-label{ display:flex; align-items:center; gap:10px; margin-bottom:14px; }
  .cg-day-dot{ width:10px; height:10px; border-radius:50%; background:var(--emerald); flex-shrink:0; box-shadow:0 0 0 4px rgba(var(--emerald-rgb),0.15); }
  .cg-day-label b{ font-size:14px; }
  .cg-day-label span{ font-size:12px; color:var(--text-faint); }

  .cg-entries{ margin-left:5px; padding-left:20px; border-left:2px solid var(--border); display:flex; flex-direction:column; gap:10px; }
  .cg-entry{ background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:14px 16px; display:flex; align-items:center; gap:14px; position:relative; transition:border-color .2s ease; }
  .cg-entry:hover{ border-color:var(--border-hover); }
  .cg-entry::before{ content:''; position:absolute; left:-26px; top:50%; transform:translateY(-50%); width:8px; height:8px; border-radius:50%; background:var(--text-faint); }
  .cg-entry-main{ flex:1; min-width:0; }
  .cg-entry-name{ font-size:13.5px; font-weight:600; margin-bottom:2px; }
  .cg-entry-meta{ font-size:11.5px; color:var(--text-faint); }
  .cg-entry-total{ font-family:'IBM Plex Mono'; font-size:14px; font-weight:600; color:var(--emerald); white-space:nowrap; }
  .cg-entry-actions{ display:flex; gap:4px; flex-shrink:0; }
  .cg-icon-btn{ width:30px; height:30px; border-radius:8px; background:transparent; border:none; display:flex; align-items:center; justify-content:center; color:var(--text-faint); cursor:pointer; transition:all .15s ease; text-decoration:none; }
  .cg-icon-btn:hover{ background:var(--surface-strong); color:var(--text); }
  .cg-icon-btn.danger:hover{ color:var(--danger); background:rgba(var(--danger-rgb),0.1); }
  .cg-icon-btn .icon{ width:14px; height:14px; }

  .cg-empty{ text-align:center; padding:60px 20px; }
  .cg-empty-ic{ width:56px; height:56px; border-radius:16px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-faint); margin:0 auto 16px; }
  .cg-empty h3{ font-size:16px; margin-bottom:6px; }
  .cg-empty p{ font-size:13px; color:var(--text-mute); margin-bottom:16px; }

  .cg-pagination{ display:flex; justify-content:space-between; align-items:center; padding:16px 4px; flex-wrap:wrap; gap:10px; margin-top:10px; }
  .cg-pg-info{ font-size:12px; color:var(--text-faint); }

  .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; padding:20px; }
  .modal-overlay.open{ display:flex; }
  .modal-box{ background:var(--modal-bg); border:1px solid var(--border); border-radius:18px; padding:26px; max-width:380px; width:100%; }
  .modal-box h3{ font-size:16px; margin-bottom:8px; }
  .modal-box p{ font-size:13px; color:var(--text-mute); margin-bottom:20px; }
  .modal-box p b{ color:var(--text); }
  .modal-actions{ display:flex; gap:10px; justify-content:flex-end; }
</style>

<div class="cg-page-head">
  <div>
    <h1>Harga Pokok Penjualan</h1>
    <p>Riwayat HPP dari setiap transaksi penjualan, diurutkan berdasarkan tanggal.</p>
  </div>
  <a href="{{ route('cogs.create') }}" class="cg-btn cg-btn-primary">+ Catat HPP</a>
</div>

<div class="cg-stat-row">
  <div class="cg-stat-circle">
    <div class="ring"><svg class="icon"><use href="#ic-invoice"/></svg></div>
    <div>
      <div class="k">Total HPP Bulan Ini</div>
      <div class="v mono">Rp{{ number_format($stats['total_cogs_month'], 0, ',', '.') }}</div>
    </div>
  </div>
  <div class="cg-stat-circle">
    <div class="ring"><svg class="icon"><use href="#ic-briefcase"/></svg></div>
    <div>
      <div class="k">Unit Terjual Bulan Ini</div>
      <div class="v">{{ number_format($stats['total_qty_month'], 0, ',', '.') }} unit</div>
    </div>
  </div>
  <div class="cg-stat-circle">
    <div class="ring"><svg class="icon"><use href="#ic-target"/></svg></div>
    <div>
      <div class="k">Rata-rata Biaya / Unit</div>
      <div class="v mono">Rp{{ number_format($stats['avg_unit_cost'], 0, ',', '.') }}</div>
    </div>
  </div>
</div>

<form method="GET" action="{{ route('cogs.index') }}">
  <div class="cg-toolbar">
    <div class="cg-search">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama barang...">
    </div>
    <input type="month" name="month" value="{{ request('month') }}" style="max-width:170px;">
    <button type="submit" class="cg-btn cg-btn-outline cg-btn-sm">Filter</button>
    @if(request()->anyFilled(['q','month']))
      <a href="{{ route('cogs.index') }}" class="cg-btn cg-btn-outline cg-btn-sm">Reset</a>
    @endif
  </div>
</form>

@if($entries->count() > 0)
  <div class="cg-timeline">
    @foreach($groupedEntries as $date => $dayEntries)
      <div class="cg-day-group">
        <div class="cg-day-label">
          <span class="cg-day-dot"></span>
          <b>{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</b>
          <span>{{ $dayEntries->count() }} transaksi</span>
        </div>
        <div class="cg-entries">
          @foreach($dayEntries as $entry)
            <div class="cg-entry">
              <div class="cg-entry-main">
                <div class="cg-entry-name">{{ $entry->item_name }}</div>
                <div class="cg-entry-meta">{{ $entry->quantity_sold }} unit × Rp{{ number_format($entry->unit_cost, 0, ',', '.') }}</div>
              </div>
              <div class="cg-entry-total">Rp{{ number_format($entry->total_cogs, 0, ',', '.') }}</div>
              <div class="cg-entry-actions">
                <a href="{{ route('cogs.edit', $entry) }}" class="cg-icon-btn" title="Edit"><svg class="icon"><use href="#ic-refresh"/></svg></a>
                <button type="button" class="cg-icon-btn danger" title="Hapus" onclick="openDeleteModal('{{ $entry->id }}', '{{ $entry->item_name }}')"><svg class="icon"><use href="#ic-close"/></svg></button>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>

  <div class="cg-pagination">
    <div class="cg-pg-info">Menampilkan {{ $entries->firstItem() }}–{{ $entries->lastItem() }} dari {{ $entries->total() }} transaksi</div>
    <div>{{ $entries->onEachSide(1)->links('pagination::simple-default') }}</div>
  </div>
@else
  <div class="cg-empty">
    <div class="cg-empty-ic"><svg class="icon" style="width:24px;height:24px;"><use href="#ic-invoice"/></svg></div>
    <h3>Belum ada catatan HPP</h3>
    <p>Catat transaksi penjualan pertama untuk mulai melacak harga pokok penjualan.</p>
    <a href="{{ route('cogs.create') }}" class="cg-btn cg-btn-primary">+ Catat HPP Pertama</a>
  </div>
@endif

<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <h3>Hapus catatan ini?</h3>
    <p>Catatan HPP untuk <b id="deleteEntryName">—</b> akan dihapus. Kalau terhubung ke barang inventaris, stok akan dikembalikan.</p>
    <form method="POST" id="deleteForm">
      @csrf
      @method('DELETE')
      <div class="modal-actions">
        <button type="button" class="cg-btn cg-btn-outline" onclick="closeDeleteModal()">Batal</button>
        <button type="submit" class="cg-btn" style="background:var(--danger); color:#fff;">Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openDeleteModal(id, name){
    document.getElementById('deleteEntryName').textContent = name;
    document.getElementById('deleteForm').action = '{{ url("cogs") }}/' + id;
    document.getElementById('deleteModal').classList.add('open');
  }
  function closeDeleteModal(){
    document.getElementById('deleteModal').classList.remove('open');
  }
  document.getElementById('deleteModal').addEventListener('click', function(e){
    if(e.target === this) closeDeleteModal();
  });
</script>
</x-app-layout>