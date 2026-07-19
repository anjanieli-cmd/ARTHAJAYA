<x-app-layout>
  <x-slot name="title">Tambah Mutasi Rekening</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY accounts - nanti ganti dengan data dari database
    $accounts = [
        ['id' => 1, 'name' => 'BCA - 1234567890'],
        ['id' => 2, 'name' => 'Mandiri - 9876543210'],
        ['id' => 3, 'name' => 'BNI - 4567891230'],
    ];
  @endphp

  <style>
    .bm-create-wrap {
      --theme-primary: var(--emerald);
      --theme-light: var(--emerald);
      --theme-dark: var(--emerald-dim);
      --theme-glow: rgba(var(--emerald-rgb), 0.25);
      --theme-soft: rgba(var(--emerald-rgb), 0.12);
      --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));
      
      --text-primary: var(--text);
      --text-secondary: var(--text-mute);
      --text-tertiary: var(--text-faint);
      
      --bg-card: var(--surface);
      --bg-card-hover: var(--surface-strong);
      --bg-card-active: rgba(255, 255, 255, 0.04);
      --border-color: var(--border);
      --border-hover: var(--border-hover);
      
      --danger: #E85A5A;
      --danger-soft: rgba(232, 90, 90, 0.12);
      --success: #34B583;
      --success-soft: rgba(52, 181, 131, 0.14);
      --warning: #F0A83C;
      --warning-soft: rgba(240, 168, 60, 0.14);
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .bm-create-wrap * { box-sizing: border-box; }
    .bm-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .bm-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .bm-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .bm-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .bm-header-left { flex: 1; min-width: 200px; }

    .bm-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 14px 6px 10px;
      background: var(--theme-glow);
      border: 1px solid var(--theme-glow);
      border-radius: 100px;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--theme-primary);
      margin-bottom: 12px;
    }

    .bm-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .bm-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .bm-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .bm-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .bm-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: var(--radius-sm);
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      background: transparent;
      color: var(--text-secondary);
      position: relative;
      overflow: hidden;
    }

    .bm-btn .icon { width: 16px; height: 16px; }
    .bm-btn:hover { transform: translateY(-2px); }
    .bm-btn:active { transform: translateY(0) scale(0.97); }

    .bm-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .bm-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .bm-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .bm-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .bm-btn .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: scale(0);
      animation: rippleAnim 0.6s ease-out forwards;
      pointer-events: none;
    }

    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }

    /* FORM */
    .bm-form {
      max-width: 800px;
      margin: 0 auto;
    }

    .bm-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: border-color 0.22s ease;
    }

    .bm-card:hover { border-color: var(--border-hover); }

    .bm-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .bm-form-group {
      margin-bottom: 18px;
    }

    .bm-form-group:last-child { margin-bottom: 0; }

    .bm-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 5px;
    }

    .bm-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .bm-form-group input,
    .bm-form-group select,
    .bm-form-group textarea {
      width: 100%;
      padding: 10px 14px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      transition: all 0.2s ease;
      outline: none;
    }

    .bm-form-group input:focus,
    .bm-form-group select:focus,
    .bm-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .bm-form-group input::placeholder,
    .bm-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .bm-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .bm-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .bm-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .bm-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .bm-form-actions .bm-btn {
      flex: 1;
      justify-content: center;
    }

    .bm-type-selector {
      display: flex;
      gap: 10px;
      margin-bottom: 18px;
    }

    .bm-type-btn {
      flex: 1;
      padding: 12px 16px;
      border: 2px solid var(--border-color);
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      color: var(--text-secondary);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-align: center;
    }

    .bm-type-btn:hover {
      border-color: var(--border-hover);
      background: var(--bg-card-hover);
    }

    .bm-type-btn.active {
      border-color: var(--theme-primary);
      background: var(--theme-soft);
      color: var(--theme-primary);
    }

    .bm-type-btn .icon {
      width: 16px;
      height: 16px;
      display: inline-block;
      vertical-align: middle;
      margin-right: 6px;
    }

    @media (max-width: 768px) {
      .bm-form-row { grid-template-columns: 1fr; }
      .bm-card { padding: 20px; }
      .bm-type-selector { flex-direction: column; }
    }

    @media (max-width: 640px) {
      .bm-header { flex-direction: column; }
      .bm-actions { width: 100%; }
      .bm-actions .bm-btn { flex: 1; justify-content: center; }
    }
  </style>

  <div class="bm-create-wrap">

    <div class="bm-header animate-in" style="animation-delay: 0.05s;">
      <div class="bm-header-left">
        <div class="bm-badge">
          <span class="dot"></span>
          Perbankan
        </div>
        <h1>Tambah Mutasi Rekening</h1>
        <p class="subtitle">Catat transaksi masuk atau keluar dari rekening bank</p>
      </div>
      <div class="bm-actions">
        <a href="{{ route('bank-mutations.index') }}" class="bm-btn bm-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('bank-mutations.store') }}" method="POST" class="bm-form">
      @csrf

      <div class="bm-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Informasi Mutasi</div>

        <div class="bm-type-selector" id="typeSelector">
          <button type="button" class="bm-type-btn active" data-type="masuk">
            <svg class="icon"><use href="#ic-receive"/></svg>
            Pemasukan
          </button>
          <button type="button" class="bm-type-btn" data-type="keluar">
            <svg class="icon"><use href="#ic-arrow-up"/></svg>
            Pengeluaran
          </button>
        </div>

        <div class="bm-form-group">
          <label>Akun Bank <span class="required">*</span></label>
          <select name="account_id" required>
            <option value="">Pilih Akun Bank...</option>
            @foreach($accounts as $a)
              <option value="{{ $a['id'] }}">{{ $a['name'] }}</option>
            @endforeach
          </select>
        </div>

        <div class="bm-form-group">
          <label>Deskripsi <span class="required">*</span></label>
          <input type="text" name="description" placeholder="Contoh: Transfer masuk dari klien" required>
        </div>

        <div class="bm-form-row">
          <div class="bm-form-group">
            <label>Tanggal <span class="required">*</span></label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="bm-form-group">
            <label>Jumlah <span class="required">*</span></label>
            <input type="number" name="amount" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <div class="bm-form-group">
          <label>Saldo Setelah Transaksi</label>
          <input type="number" name="balance" placeholder="0" min="0" step="1000">
        </div>

        <div class="bm-form-group">
          <label>Kategori Transaksi</label>
          <select name="category">
            <option value="">Pilih Kategori...</option>
            <option value="transfer">Transfer</option>
            <option value="setoran">Setoran Tunai</option>
            <option value="tarik_tunai">Tarik Tunai</option>
            <option value="biaya_admin">Biaya Admin</option>
            <option value="pembayaran">Pembayaran</option>
            <option value="lainnya">Lainnya</option>
          </select>
        </div>

        <div class="bm-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan tambahan..."></textarea>
        </div>

        <div class="bm-form-actions">
          <button type="submit" class="bm-btn bm-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Mutasi
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Type selector
      const typeBtns = document.querySelectorAll('.bm-type-btn');
      const typeInput = document.createElement('input');
      typeInput.type = 'hidden';
      typeInput.name = 'type';
      typeInput.value = 'masuk';
      document.querySelector('.bm-form').appendChild(typeInput);

      typeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          typeBtns.forEach(b => b.classList.remove('active'));
          this.classList.add('active');
          typeInput.value = this.dataset.type;
        });
      });

      // Ripple effect
      const buttons = document.querySelectorAll('.bm-btn');
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          const rect = this.getBoundingClientRect();
          const ripple = document.createElement('span');
          ripple.className = 'ripple';
          const size = Math.max(rect.width, rect.height);
          ripple.style.width = ripple.style.height = size + 'px';
          ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
          ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
          this.appendChild(ripple);
          setTimeout(() => { ripple.remove(); }, 600);
        });
      });
    });
  </script>

</x-app-layout>