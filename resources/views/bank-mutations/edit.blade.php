<x-app-layout>
  <x-slot name="title">Edit Mutasi Rekening</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    // DUMMY data - nanti diganti dengan data dari database
    $mutation = [
        'id' => 1,
        'account_id' => 1,
        'account_name' => 'BCA - 1234567890',
        'type' => 'masuk',
        'description' => 'Transfer masuk dari PT Andalas Maju Bersama',
        'amount' => 25000000,
        'date' => '2026-07-20',
        'balance' => 150000000,
        'category' => 'transfer',
        'notes' => 'Pembayaran invoice INV-2026-0001',
    ];

    // DUMMY accounts
    $accounts = [
        ['id' => 1, 'name' => 'BCA - 1234567890', 'balance' => 125000000],
        ['id' => 2, 'name' => 'Mandiri - 9876543210', 'balance' => 85000000],
        ['id' => 3, 'name' => 'BNI - 4567891230', 'balance' => 45000000],
    ];

    $typeLabel = ['masuk' => 'Pemasukan', 'keluar' => 'Pengeluaran'];
    $typeBadge = ['masuk' => 'masuk', 'keluar' => 'keluar'];

    $categoryLabels = [
        'transfer' => 'Transfer',
        'setoran' => 'Setoran Tunai',
        'tarik_tunai' => 'Tarik Tunai',
        'biaya_admin' => 'Biaya Admin',
        'pembayaran' => 'Pembayaran',
        'lainnya' => 'Lainnya'
    ];
  @endphp

  <style>
    /* ============================================
       MUTASI EDIT - Premium Design
       ============================================ */
    
    .me-wrap {
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

    .me-wrap * { box-sizing: border-box; }
    .me-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .me-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .me-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .me-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .me-header-left { flex: 1; min-width: 200px; }

    .me-badge {
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

    .me-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .me-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .me-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .me-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .me-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .me-btn {
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

    .me-btn .icon { width: 16px; height: 16px; }
    .me-btn:hover { transform: translateY(-2px); }
    .me-btn:active { transform: translateY(0) scale(0.97); }

    .me-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .me-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .me-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .me-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .me-btn .ripple {
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

    /* FORM LAYOUT */
    .me-form {
      max-width: 900px;
      margin: 0 auto;
    }

    .me-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 32px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .me-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .me-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .me-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .me-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* TYPE SELECTOR */
    .me-type-selector {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 20px;
    }

    .me-type-btn {
      padding: 14px 20px;
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
      gap: 10px;
      font-family: 'Inter', sans-serif;
    }

    .me-type-btn:hover {
      border-color: var(--border-hover);
      background: var(--bg-card-hover);
      transform: translateY(-2px);
    }

    .me-type-btn.active {
      border-color: var(--theme-primary);
      background: var(--theme-soft);
      color: var(--theme-primary);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .me-type-btn .icon {
      width: 20px;
      height: 20px;
    }

    .me-type-btn .type-label {
      font-size: 13px;
    }

    .me-type-btn .type-desc {
      font-size: 11px;
      font-weight: 400;
      color: var(--text-tertiary);
      display: block;
    }

    .me-type-btn.active .type-desc {
      color: var(--theme-primary);
    }

    /* FORM GROUP */
    .me-form-group {
      margin-bottom: 18px;
    }

    .me-form-group:last-child { margin-bottom: 0; }

    .me-form-group label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .me-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .me-form-group input,
    .me-form-group select,
    .me-form-group textarea {
      width: 100%;
      padding: 10px 14px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .me-form-group input:focus,
    .me-form-group select:focus,
    .me-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .me-form-group input::placeholder,
    .me-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .me-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .me-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .me-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 13px;
    }

    .me-form-group select option:checked,
    .me-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .me-form-group select option:disabled {
      color: #6b7280;
    }

    .me-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    /* INFO BOX */
    .me-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      margin-bottom: 18px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }

    .me-info-box .icon {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .me-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.5;
    }

    .me-info-box .message strong {
      color: var(--text-primary);
    }

    /* FORM ACTIONS */
    .me-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .me-form-actions .me-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .me-form-row { 
        grid-template-columns: 1fr; 
      }
      .me-card { 
        padding: 20px; 
      }
      .me-type-selector { 
        grid-template-columns: 1fr; 
      }
    }

    @media (max-width: 640px) {
      .me-header { 
        flex-direction: column; 
      }
      .me-actions { 
        width: 100%; 
      }
      .me-actions .me-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .me-form-actions { 
        flex-direction: column; 
      }
      .me-form-actions .me-btn { 
        flex: none; 
      }
    }

    @media (max-width: 380px) {
      .me-header h1 { 
        font-size: 22px; 
      }
      .me-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .me-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
    }
  </style>

  <div class="me-wrap">

    <!-- ===== HEADER ===== -->
    <div class="me-header animate-in" style="animation-delay: 0.05s;">
      <div class="me-header-left">
        <div class="me-badge">
          <span class="dot"></span>
          Perbankan
        </div>
        <h1>Edit Mutasi Rekening</h1>
        <p class="subtitle">
          Edit mutasi rekening — <strong>{{ $mutation['account_name'] }}</strong>
        </p>
      </div>
      <div class="me-actions">
        <a href="{{ route('bank-mutations.show', $mutation['id']) }}" class="me-btn me-btn-ghost">
          <svg class="icon"><use href="#ic-eye"/></svg>
          Batal
        </a>
        <a href="{{ route('bank-mutations.index') }}" class="me-btn me-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('bank-mutations.update', $mutation['id']) }}" method="POST" class="me-form">
      @csrf
      @method('PUT')

      <div class="me-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-bank"/></svg>
          Informasi Mutasi
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="me-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Pastikan memilih jenis transaksi yang tepat (Pemasukan/Pengeluaran) 
            dan jumlah yang dimasukkan sudah benar.
          </div>
        </div>

        <!-- Type Selector -->
        <div class="me-type-selector" id="typeSelector">
          <button type="button" class="me-type-btn {{ $mutation['type'] == 'masuk' ? 'active' : '' }}" data-type="masuk">
            <svg class="icon"><use href="#ic-receive"/></svg>
            <div>
              <div class="type-label">Pemasukan</div>
              <span class="type-desc">Dana masuk ke rekening</span>
            </div>
          </button>
          <button type="button" class="me-type-btn {{ $mutation['type'] == 'keluar' ? 'active' : '' }}" data-type="keluar">
            <svg class="icon"><use href="#ic-send"/></svg>
            <div>
              <div class="type-label">Pengeluaran</div>
              <span class="type-desc">Dana keluar dari rekening</span>
            </div>
          </button>
        </div>

        <!-- Account -->
        <div class="me-form-group">
          <label>Akun Bank <span class="required">*</span></label>
          <select name="account_id" required>
            <option value="">Pilih Akun Bank...</option>
            @foreach($accounts as $a)
              <option value="{{ $a['id'] }}" {{ $a['id'] == $mutation['account_id'] ? 'selected' : '' }}>
                {{ $a['name'] }} (Saldo: {{ $currencySymbol }}{{ number_format($a['balance'], 0, ',', '.') }})
              </option>
            @endforeach
          </select>
        </div>

        <!-- Description -->
        <div class="me-form-group">
          <label>Deskripsi <span class="required">*</span></label>
          <input type="text" name="description" value="{{ $mutation['description'] }}" placeholder="Contoh: Transfer masuk dari klien / Pembayaran tagihan" required>
        </div>

        <!-- Date & Amount -->
        <div class="me-form-row">
          <div class="me-form-group">
            <label>Tanggal <span class="required">*</span></label>
            <input type="date" name="date" value="{{ $mutation['date'] }}" required>
          </div>
          <div class="me-form-group">
            <label>Jumlah <span class="required">*</span></label>
            <input type="number" name="amount" value="{{ $mutation['amount'] }}" placeholder="0" min="0" step="1000" required>
          </div>
        </div>

        <!-- Balance After -->
        <div class="me-form-group">
          <label>Saldo Setelah Transaksi</label>
          <input type="number" name="balance" value="{{ $mutation['balance'] }}" placeholder="Saldo setelah transaksi" min="0" step="1000">
          <div style="font-size:11px;color:var(--text-tertiary);margin-top:4px;">
            <span>💡 Biarkan kosong jika tidak diketahui</span>
          </div>
        </div>

        <!-- Category -->
        <div class="me-form-group">
          <label>Kategori Transaksi</label>
          <select name="category">
            <option value="">Pilih Kategori...</option>
            @foreach($categoryLabels as $key => $label)
              <option value="{{ $key }}" {{ $key == $mutation['category'] ? 'selected' : '' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Notes -->
        <div class="me-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan tambahan untuk transaksi ini...">{{ $mutation['notes'] }}</textarea>
        </div>

        <!-- Actions -->
        <div class="me-form-actions">
          <button type="submit" class="me-btn me-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Update Mutasi
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
    <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Type selector
      const typeBtns = document.querySelectorAll('.me-type-btn');
      const typeInput = document.createElement('input');
      typeInput.type = 'hidden';
      typeInput.name = 'type';
      typeInput.value = '{{ $mutation["type"] }}';
      document.querySelector('.me-form').appendChild(typeInput);

      typeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          typeBtns.forEach(b => b.classList.remove('active'));
          this.classList.add('active');
          typeInput.value = this.dataset.type;
          
          // Update info box message based on type
          const infoBox = document.querySelector('.me-info-box .message');
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
      const buttons = document.querySelectorAll('.me-btn');
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