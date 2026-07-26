<x-app-layout>
  <x-slot name="title">Tambah Mutasi Rekening</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY accounts - nanti ganti dengan data dari database
    $accounts = [
        ['id' => 1, 'name' => 'BCA - 1234567890', 'balance' => 125000000],
        ['id' => 2, 'name' => 'Mandiri - 9876543210', 'balance' => 85000000],
        ['id' => 3, 'name' => 'BNI - 4567891230', 'balance' => 45000000],
    ];
  @endphp

  <style>
    /* ============================================
       MUTASI REKENING - Premium Design - FULL WIDTH
       ============================================ */
    
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
      padding: 0 24px;
    }

    .bm-create-wrap * { box-sizing: border-box; }
    .bm-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
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
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .bm-header-left { flex: 1; min-width: 200px; }

    .bm-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 16px 6px 12px;
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

    .bm-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
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

    /* FORM LAYOUT - FULL WIDTH */
    .bm-form {
      max-width: 100%;
    }

    .bm-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 36px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bm-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .bm-card .title {
      font-size: 17px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .bm-card .title .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    .bm-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* TYPE SELECTOR */
    .bm-type-selector {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-bottom: 24px;
    }

    .bm-type-btn {
      padding: 16px 24px;
      border: 2px solid var(--border-color);
      border-radius: var(--radius-sm);
      background: var(--bg-card-active);
      color: var(--text-secondary);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      font-family: 'Inter', sans-serif;
    }

    .bm-type-btn:hover {
      border-color: var(--border-hover);
      background: var(--bg-card-hover);
      transform: translateY(-2px);
    }

    .bm-type-btn.active {
      border-color: var(--theme-primary);
      background: var(--theme-soft);
      color: var(--theme-primary);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .bm-type-btn .icon {
      width: 22px;
      height: 22px;
    }

    .bm-type-btn .type-label {
      font-size: 14px;
    }

    .bm-type-btn .type-desc {
      font-size: 11px;
      font-weight: 400;
      color: var(--text-tertiary);
      display: block;
    }

    .bm-type-btn.active .type-desc {
      color: var(--theme-primary);
    }

    /* FORM GROUP */
    .bm-form-group {
      margin-bottom: 20px;
    }

    .bm-form-group:last-child { margin-bottom: 0; }

    .bm-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-secondary);
      margin-bottom: 6px;
    }

    .bm-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .bm-form-group input,
    .bm-form-group select,
    .bm-form-group textarea {
      width: 100%;
      padding: 12px 16px;
      background: var(--bg-card-active);
      border: 2px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .bm-form-group input:focus,
    .bm-form-group select:focus,
    .bm-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .bm-form-group input::placeholder,
    .bm-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .bm-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .bm-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .bm-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 13px;
    }

    .bm-form-group select option:checked,
    .bm-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .bm-form-group select option:disabled {
      color: #6b7280;
    }

    .bm-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* FORM ACTIONS */
    .bm-form-actions {
      display: flex;
      gap: 12px;
      margin-top: 28px;
      padding-top: 24px;
      border-top: 2px solid var(--border-color);
    }

    .bm-form-actions .bm-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 24px;
      font-size: 14px;
    }

    .bm-form-actions .bm-btn-primary {
      flex: 2;
    }

    /* INFO BOX */
    .bm-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 14px 18px;
      margin-bottom: 22px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .bm-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .bm-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.5;
    }

    .bm-info-box .message strong {
      color: var(--text-primary);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .bm-form-row { 
        grid-template-columns: 1fr; 
        gap: 0;
      }
      .bm-card { 
        padding: 24px 20px; 
      }
      .bm-type-selector { 
        grid-template-columns: 1fr; 
      }
    }

    @media (max-width: 640px) {
      .bm-create-wrap { padding: 0 16px; }
      .bm-header { 
        flex-direction: column; 
      }
      .bm-actions { 
        width: 100%; 
      }
      .bm-actions .bm-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .bm-form-actions { 
        flex-direction: column; 
      }
      .bm-form-actions .bm-btn { 
        flex: none; 
      }
      .bm-form-actions .bm-btn-primary {
        flex: none;
      }
    }

    @media (max-width: 380px) {
      .bm-header h1 { 
        font-size: 22px; 
      }
      .bm-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .bm-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
    }
  </style>

  <div class="bm-create-wrap">

    <!-- ===== HEADER ===== -->
    <div class="bm-header animate-in" style="animation-delay: 0.05s;">
      <div class="bm-header-left">
        <div class="bm-badge">
          <span class="dot"></span>
          Perbankan
        </div>
        <h1>Tambah Mutasi Rekening</h1>
        <p class="subtitle">
          Catat transaksi masuk atau keluar dari rekening bank — <strong>pastikan data akurat</strong>
        </p>
      </div>
      <div class="bm-actions">
        <a href="{{ route('bank-mutations.index') }}" class="bm-btn bm-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('bank-mutations.store') }}" method="POST" class="bm-form">
      @csrf

      <div class="bm-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-bank"/></svg>
          Informasi Mutasi
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="bm-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Pastikan memilih jenis transaksi yang tepat (Pemasukan/Pengeluaran) 
            dan jumlah yang dimasukkan sudah benar.
          </div>
        </div>

        <!-- Type Selector -->
        <div class="bm-type-selector" id="typeSelector">
          <button type="button" class="bm-type-btn active" data-type="masuk">
            <svg class="icon"><use href="#ic-receive"/></svg>
            <div>
              <div class="type-label">Pemasukan</div>
              <span class="type-desc">Dana masuk ke rekening</span>
            </div>
          </button>
          <button type="button" class="bm-type-btn" data-type="keluar">
            <svg class="icon"><use href="#ic-send"/></svg>
            <div>
              <div class="type-label">Pengeluaran</div>
              <span class="type-desc">Dana keluar dari rekening</span>
            </div>
          </button>
        </div>

        <!-- Account -->
        <div class="bm-form-group">
          <label>Akun Bank <span class="required">*</span></label>
          <select name="account_id" required>
            <option value="">Pilih Akun Bank...</option>
            @foreach($accounts as $a)
              <option value="{{ $a['id'] }}">
                {{ $a['name'] }} (Saldo: {{ $currencySymbol }}{{ number_format($a['balance'], 0, ',', '.') }})
              </option>
            @endforeach
          </select>
        </div>

        <!-- Description -->
        <div class="bm-form-group">
          <label>Deskripsi <span class="required">*</span></label>
          <input type="text" name="description" placeholder="Contoh: Transfer masuk dari klien / Pembayaran tagihan" required>
        </div>

        <!-- Date & Amount -->
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

        <!-- Balance After -->
        <div class="bm-form-group">
          <label>Saldo Setelah Transaksi</label>
          <input type="number" name="balance" placeholder="Saldo setelah transaksi" min="0" step="1000">
          <div style="font-size:11px;color:var(--text-tertiary);margin-top:4px;">
            <span>💡 Biarkan kosong jika tidak diketahui</span>
          </div>
        </div>

        <!-- Category -->
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

        <!-- Notes -->
        <div class="bm-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan tambahan untuk transaksi ini..."></textarea>
        </div>

        <!-- Actions -->
        <div class="bm-form-actions">
          <a href="{{ route('bank-mutations.index') }}" class="bm-btn bm-btn-ghost">
            <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
            Batal
          </a>
          <button type="submit" class="bm-btn bm-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Mutasi
          </button>
        </div>
      </div>

    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-bank" viewBox="0 0 24 24"><rect x="2" y="8" width="20" height="12" rx="2"/><path d="M3 8L12 2l9 6"/><line x1="8" y1="14" x2="16" y2="14"/></symbol>
    <symbol id="ic-receive" viewBox="0 0 24 24"><polyline points="20 12 12 20 4 12"/><line x1="12" y1="4" x2="12" y2="20"/></symbol>
    <symbol id="ic-send" viewBox="0 0 24 24"><polyline points="20 12 12 4 4 12"/><line x1="12" y1="20" x2="12" y2="4"/></symbol>
  </svg>

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
          
          // Update info box message based on type
          const infoBox = document.querySelector('.bm-info-box .message');
          if (this.dataset.type === 'masuk') {
            infoBox.innerHTML = `
              <strong>Perhatian:</strong> Anda mencatat <strong style="color:var(--success);">PEMASUKAN</strong>.
              Pastikan jumlah yang dimasukkan sudah benar dan sesuai dengan bukti transaksi.
            `;
          } else {
            infoBox.innerHTML = `
              <strong>Perhatian:</strong> Anda mencatat <strong style="color:var(--danger);">PENGELUARAN</strong>.
              Pastikan jumlah yang dimasukkan sudah benar dan sesuai dengan bukti transaksi.
            `;
          }
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