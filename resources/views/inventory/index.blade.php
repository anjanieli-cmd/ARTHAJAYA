<x-app-layout>
  <x-slot name="title">Stok Barang</x-slot>

<style>
  .inv-page-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:22px; flex-wrap:wrap; }
  .inv-page-head h1{ font-size:25px; margin-bottom:6px; }
  .inv-page-head p{ font-size:13.5px; color:var(--text-mute); }

  .inv-btn{ display:inline-flex; align-items:center; gap:8px; padding:11px 20px; border-radius:11px; font-size:13.5px; font-weight:600; cursor:pointer; border:none; transition:all .2s ease; text-decoration:none; }
  .inv-btn-primary{ background:var(--emerald); color:#052117; box-shadow:0 4px 20px rgba(var(--emerald-rgb),0.3); }
  .inv-btn-primary:hover{ transform:translateY(-1px); }
  .inv-btn-outline{ background:var(--surface); border:1px solid var(--border); color:var(--text); }
  .inv-btn-sm{ padding:7px 12px; font-size:12px; }

  /* Stat strip - beda dari stat-card kotak, ini strip horizontal dipisah garis vertikal */
  .inv-stat-strip{ display:flex; background:var(--surface); border:1px solid var(--border); border-radius:16px; margin-bottom:20px; overflow:hidden; }
  .inv-stat{ flex:1; padding:18px 22px; border-right:1px solid var(--border); }
  .inv-stat:last-child{ border-right:none; }
  .inv-stat .k{ font-size:11.5px; color:var(--text-faint); margin-bottom:6px; text-transform:uppercase; letter-spacing:.05em; }
  .inv-stat .v{ font-family:'Space Grotesk'; font-size:21px; font-weight:700; }
  .inv-stat.warn .v{ color:var(--warning); }
  @media (max-width:700px){ .inv-stat-strip{ flex-direction:column; } .inv-stat{ border-right:none; border-bottom:1px solid var(--border); } .inv-stat:last-child{ border-bottom:none; } }

  .inv-toolbar{ display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; align-items:center; }
  .inv-search{ flex:1; min-width:200px; position:relative; }
  .inv-search input{ width:100%; padding:10px 14px 10px 38px; border-radius:11px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; }
  .inv-search input:focus{ border-color:var(--border-hover); background:var(--surface-strong); }
  .inv-search .icon{ position:absolute; left:12px; top:50%; transform:translateY(-50%); width:15px; height:15px; color:var(--text-faint); }
  .inv-select{ padding:10px 14px; border-radius:11px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:13px; outline:none; min-width:160px; }

  /* CARD GRID — pola utama yang membedakan halaman ini dari Faktur/Penawaran/Klien */
  .inv-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:16px; margin-bottom:20px; }
  .inv-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:20px; transition:border-color .2s ease, transform .2s ease; display:flex; flex-direction:column; }
  .inv-card:hover{ border-color:var(--border-hover); transform:translateY(-2px); }
  .inv-card-top{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; }
  .inv-cat-badge{ font-size:10.5px; font-weight:600; padding:4px 9px; border-radius:100px; background:var(--surface-strong); color:var(--text-mute); }
  .inv-cat-badge.low{ background:rgba(var(--danger-rgb),0.14); color:var(--danger); }
  .inv-card-name{ font-size:15px; font-weight:600; margin-bottom:2px; }
  .inv-card-sku{ font-family:'IBM Plex Mono'; font-size:11.5px; color:var(--text-faint); }

  .inv-stock-row{ display:flex; align-items:baseline; gap:6px; margin:14px 0 6px; }
  .inv-stock-num{ font-family:'Space Grotesk'; font-size:26px; font-weight:700; }
  .inv-stock-unit{ font-size:12px; color:var(--text-mute); }
  .inv-bar-track{ height:6px; border-radius:100px; background:var(--surface-strong); overflow:hidden; margin-bottom:14px; }
  .inv-bar-fill{ height:100%; border-radius:100px; background:linear-gradient(90deg,var(--emerald-dim),var(--emerald)); }
  .inv-bar-fill.low{ background:linear-gradient(90deg,#b8443f,var(--danger)); }

  .inv-price-row{ display:flex; justify-content:space-between; font-size:12px; color:var(--text-mute); padding:10px 0; border-top:1px solid var(--border); margin-top:auto; }
  .inv-price-row b{ color:var(--text); font-family:'IBM Plex Mono'; font-weight:600; }

  .inv-card-actions{ display:flex; gap:8px; margin-top:12px; }
  .inv-card-actions a, .inv-card-actions button{ flex:1; text-align:center; padding:8px; border-radius:9px; font-size:12px; font-weight:600; border:1px solid var(--border); background:var(--surface-strong); color:var(--text); cursor:pointer; text-decoration:none; transition:all .15s ease; }
  .inv-card-actions a:hover{ border-color:var(--border-hover); }
  .inv-card-actions button.danger{ color:var(--danger); }
  .inv-card-actions button.danger:hover{ background:rgba(var(--danger-rgb),0.1); border-color:rgba(var(--danger-rgb),0.3); }

  .inv-empty{ grid-column:1/-1; text-align:center; padding:60px 20px; }
  .inv-empty-ic{ width:56px; height:56px; border-radius:16px; background:var(--surface-strong); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-faint); margin:0 auto 16px; }
  .inv-empty h3{ font-size:16px; margin-bottom:6px; }
  .inv-empty p{ font-size:13px; color:var(--text-mute); margin-bottom:16px; }

  .inv-pagination{ display:flex; justify-content:space-between; align-items:center; padding:16px 4px; flex-wrap:wrap; gap:10px; }
  .inv-pg-info{ font-size:12px; color:var(--text-faint); }

  .modal-overlay{ position:fixed; inset:0; background:rgba(3,6,12,0.6); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; padding:20px; }
  .modal-overlay.open{ display:flex; }
  .modal-box{ background:var(--modal-bg); border:1px solid var(--border); border-radius:18px; padding:26px; max-width:380px; width:100%; }
  .modal-box h3{ font-size:16px; margin-bottom:8px; }
  .modal-box p{ font-size:13px; color:var(--text-mute); margin-bottom:20px; }
  .modal-box p b{ color:var(--text); }
  .modal-actions{ display:flex; gap:10px; justify-content:flex-end; }
</style>

<div class="inv-page-head">
  <div>
    <h1>Stok Barang</h1>
    <p>Pantau jumlah stok, nilai barang, dan barang yang perlu segera diisi ulang.</p>
  </div>
  <a href="{{ route('inventory.create') }}" class="inv-btn inv-btn-primary">+ Tambah Barang</a>
</div>

<div class="inv-stat-strip">
  <div class="inv-stat">
    <div class="k">Total SKU</div>
    <div class="v">{{ $stats['total_sku'] }}</div>
  </div>
  <div class="inv-stat">
    <div class="k">Total Nilai Stok</div>
    <div class="v mono">Rp{{ number_format($stats['total_value'], 0, ',', '.') }}</div>
  </div>
  <div class="inv-stat {{ $stats['low_stock'] > 0 ? 'warn' : '' }}">
    <div class="k">Stok Menipis</div>
    <div class="v">{{ $stats['low_stock'] }} barang</div>
  </div>
</div>

<form method="GET" action="{{ route('inventory.index') }}">
  <div class="inv-toolbar">
    <div class="inv-search">
      <svg class="icon"><use href="#ic-search"/></svg>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau SKU barang...">
    </div>
    <select name="category" class="inv-select" onchange="this.form.submit()">
      <option value="">Semua Kategori</option>
      @foreach($categories as $cat)
        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
      @endforeach
    </select>
    <button type="submit" class="inv-btn inv-btn-outline inv-btn-sm">Cari</button>
    @if(request()->anyFilled(['q','category']))
      <a href="{{ route('inventory.index') }}" class="inv-btn inv-btn-outline inv-btn-sm">Reset</a>
    @endif
  </div>
</form>

<div class="inv-grid">
  @forelse($items as $item)
    <div class="inv-card">
      <div class="inv-card-top">
        <span class="inv-cat-badge {{ $item->is_low_stock ? 'low' : '' }}">
          {{ $item->is_low_stock ? 'Stok Menipis' : ($item->category ?? 'Umum') }}
        </span>
      </div>
      <div class="inv-card-name">{{ $item->name }}</div>
      <div class="inv-card-sku">{{ $item->sku }}</div>

      <div class="inv-stock-row">
        <span class="inv-stock-num">{{ $item->stock_quantity }}</span>
        <span class="inv-stock-unit">{{ $item->unit }}</span>
      </div>
      <div class="inv-bar-track">
        <div class="inv-bar-fill {{ $item->is_low_stock ? 'low' : '' }}" style="width:{{ $item->stock_percent }}%"></div>
      </div>

      <div class="inv-price-row">
        <span>Pokok: <b>Rp{{ number_format($item->cost_price, 0, ',', '.') }}</b></span>
        <span>Jual: <b>Rp{{ number_format($item->selling_price, 0, ',', '.') }}</b></span>
      </div>

      <div class="inv-card-actions">
        <a href="{{ route('inventory.edit', $item) }}">Edit</a>
        <button type="button" class="danger" onclick="openDeleteModal('{{ $item->id }}', '{{ $item->name }}')">Hapus</button>
      </div>
    </div>
  @empty
    <div class="inv-empty">
      <div class="inv-empty-ic"><svg class="icon" style="width:24px;height:24px;"><use href="#ic-briefcase"/></svg></div>
      <h3>Belum ada barang</h3>
      <p>Tambahkan barang pertama untuk mulai melacak stok inventaris.</p>
      <a href="{{ route('inventory.create') }}" class="inv-btn inv-btn-primary">+ Tambah Barang Pertama</a>
    </div>
  @endforelse
</div>

@if($items->total() > 0)
  <div class="inv-pagination">
    <div class="inv-pg-info">Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ $items->total() }} barang</div>
    <div>{{ $items->onEachSide(1)->links('pagination::simple-default') }}</div>
  </div>
@endif

<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <h3>Hapus barang ini?</h3>
    <p>Barang <b id="deleteItemName">—</b> akan dihapus permanen dari inventaris.</p>
    <form method="POST" id="deleteForm">
      @csrf
      @method('DELETE')
      <div class="modal-actions">
        <button type="button" class="inv-btn inv-btn-outline" onclick="closeDeleteModal()">Batal</button>
        <button type="submit" class="inv-btn" style="background:var(--danger); color:#fff;">Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openDeleteModal(id, name){
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteForm').action = '{{ url("inventory") }}/' + id;
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