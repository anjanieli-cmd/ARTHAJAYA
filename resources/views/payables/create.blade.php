<x-app-layout>
  <x-slot name="title">Tagihan Baru</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    
    // DUMMY vendors - nanti ganti dengan data dari database
    $vendors = [
        ['id' => 1, 'name' => 'Toko Bangunan Sentosa'],
        ['id' => 2, 'name' => 'CV Kertas Nusantara'],
        ['id' => 3, 'name' => 'Distributor Kain Batik'],
        ['id' => 4, 'name' => 'Jasa Ekspedisi Cepat'],
        ['id' => 5, 'name' => 'PLN — Listrik Kantor'],
    ];
    
    // Generate nomor tagihan otomatis
    $billNumber = 'B-' . date('Y') . '-' . str_pad(1, 4, '0', STR_PAD_LEFT);
  @endphp

  <style>
    .bill-create-wrap {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .bill-create-wrap * { box-sizing: border-box; }
    .bill-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .bill-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .bill-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .bc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 28px;
      padding: 0 4px;
    }

    .bc-header-left { flex: 1; min-width: 200px; }

    .bc-badge {
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

    .bc-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .bc-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .bc-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .bc-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .bc-btn {
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

    .bc-btn .icon { width: 16px; height: 16px; }
    .bc-btn:hover { transform: translateY(-2px); }
    .bc-btn:active { transform: translateY(0) scale(0.97); }

    .bc-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .bc-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .bc-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .bc-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .bc-btn .ripple {
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
    .bc-form {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }

    .bc-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 24px;
      transition: border-color 0.22s ease;
    }

    .bc-card:hover { border-color: var(--border-hover); }

    .bc-card .title {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 16px;
    }

    .bc-form-group {
      margin-bottom: 16px;
    }

    .bc-form-group:last-child { margin-bottom: 0; }

    .bc-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 4px;
    }

    .bc-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .bc-form-group input,
    .bc-form-group select,
    .bc-form-group textarea {
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

    .bc-form-group input:focus,
    .bc-form-group select:focus,
    .bc-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .bc-form-group input::placeholder,
    .bc-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .bc-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .bc-form-group select option {
      background: var(--bg-card);
      color: var(--text-primary);
    }

    .bc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    /* ITEMS TABLE */
    .bc-items-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    .bc-items-table th {
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      color: var(--text-tertiary);
      padding: 8px 10px;
      border-bottom: 1px solid var(--border-color);
    }

    .bc-items-table td {
      padding: 8px 10px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-primary);
    }

    .bc-items-table input {
      width: 100%;
      padding: 8px 10px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 12px;
      font-family: 'Inter', sans-serif;
      transition: all 0.2s ease;
      outline: none;
    }

    .bc-items-table input:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
    }

    .bc-items-table .remove-btn {
      background: none;
      border: none;
      color: var(--text-tertiary);
      cursor: pointer;
      font-size: 18px;
      padding: 4px 8px;
      border-radius: 4px;
      transition: all 0.2s ease;
    }

    .bc-items-table .remove-btn:hover {
      color: var(--danger);
      background: var(--danger-soft);
    }

    .bc-add-item {
      padding: 8px 16px;
      background: var(--bg-card-active);
      border: 1px dashed var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-secondary);
      font-size: 12px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      width: 100%;
      margin-top: 8px;
    }

    .bc-add-item:hover {
      border-color: var(--theme-primary);
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    /* SIDEBAR SUMMARY */
    .bc-summary-item {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid var(--border-color);
      font-size: 13px;
    }

    .bc-summary-item:last-child { border-bottom: none; }

    .bc-summary-item .label {
      color: var(--text-secondary);
    }

    .bc-summary-item .value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .bc-summary-item .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .bc-summary-total {
      padding: 14px 0;
      display: flex;
      justify-content: space-between;
      font-size: 18px;
      font-weight: 700;
      border-top: 2px solid var(--theme-primary);
      margin-top: 4px;
    }

    .bc-summary-total .value {
      color: var(--theme-primary);
    }

    .bc-summary-total .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .bc-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }

    .bc-form-actions .bc-btn {
      flex: 1;
      justify-content: center;
    }

    /* EMPTY */
    .bc-empty {
      text-align: center;
      padding: 40px 20px;
      color: var(--text-tertiary);
    }

    .bc-empty .empty-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      color: var(--theme-primary);
      opacity: 0.5;
    }

    .bc-empty h3 {
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 6px;
      color: var(--text-primary);
    }

    .bc-empty p {
      color: var(--text-secondary);
      margin: 0 0 20px;
      font-size: 14px;
    }

    @media (max-width: 992px) {
      .bc-form { grid-template-columns: 1fr; }
      .bc-form-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .bc-items-table { font-size: 12px; }
      .bc-items-table th, .bc-items-table td { padding: 6px 8px; }
      .bc-items-table input { font-size: 11px; padding: 6px 8px; }
    }

    @media (max-width: 640px) {
      .bc-header { flex-direction: column; }
      .bc-actions { width: 100%; }
      .bc-actions .bc-btn { flex: 1; justify-content: center; }
      .bc-card { padding: 16px; }
    }

    @media (max-width: 380px) {
      .bc-header h1 { font-size: 22px; }
      .bc-btn { font-size: 12px; padding: 8px 14px; }
      .bc-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="bill-create-wrap">

    <div class="bc-header animate-in" style="animation-delay: 0.05s;">
      <div class="bc-header-left">
        <div class="bc-badge">
          <span class="dot"></span>
          Piutang &amp; Utang
        </div>
        <h1>Tagihan Baru</h1>
        <p class="subtitle">Buat tagihan baru dari supplier/vendor</p>
      </div>
      <div class="bc-actions">
        <a href="{{ route('payables.index') }}" class="bc-btn bc-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('payables.store') }}" method="POST" class="bc-form">
      @csrf

      <!-- MAIN FORM -->
      <div class="bc-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">Informasi Tagihan</div>

        <div class="bc-form-group">
          <label>Vendor / Supplier <span class="required">*</span></label>
          <select name="vendor_id" required>
            <option value="">Pilih Vendor...</option>
            @foreach($vendors as $v)
              <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
            @endforeach
          </select>
        </div>

        <div class="bc-form-row">
          <div class="bc-form-group">
            <label>Nomor Tagihan <span class="required">*</span></label>
            <input type="text" name="number" value="{{ $billNumber }}" placeholder="B-2026-0001" required>
          </div>
          <div class="bc-form-group">
            <label>Tanggal Tagihan <span class="required">*</span></label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>

        <div class="bc-form-row">
          <div class="bc-form-group">
            <label>Jatuh Tempo <span class="required">*</span></label>
            <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+14 days')) }}" required>
          </div>
          <div class="bc-form-group">
            <label>Kategori</label>
            <select name="category">
              <option value="">Pilih Kategori...</option>
              <option value="bahan_baku">Bahan Baku</option>
              <option value="utilitas">Utilitas</option>
              <option value="transportasi">Transportasi</option>
              <option value="produksi">Produksi</option>
              <option value="marketing">Marketing</option>
              <option value="operasional">Operasional</option>
            </select>
          </div>
        </div>

        <div class="bc-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan untuk tagihan..."></textarea>
        </div>

        <div class="title" style="margin-top: 20px;">Item Tagihan</div>

        <table class="bc-items-table">
          <thead>
            <tr>
              <th style="width:35%;">Deskripsi</th>
              <th style="width:15%;">Jumlah</th>
              <th style="width:20%;">Harga</th>
              <th style="width:25%;text-align:right;">Total</th>
              <th style="width:5%;"></th>
            </tr>
          </thead>
          <tbody id="itemsBody">
            <tr class="item-row">
              <td><input type="text" name="items[0][description]" placeholder="Deskripsi item..." required></td>
              <td><input type="number" name="items[0][quantity]" value="1" min="1" required></td>
              <td><input type="number" name="items[0][price]" value="0" min="0" step="1000" required></td>
              <td style="text-align:right;font-weight:600;" class="row-total">Rp 0</td>
              <td style="text-align:center;">
                <button type="button" class="remove-btn" onclick="removeItem(this)">×</button>
              </td>
            </tr>
          </tbody>
        </table>

        <button type="button" class="bc-add-item" onclick="addItem()">
          + Tambah Item
        </button>
      </div>

      <!-- SIDEBAR -->
      <div class="bc-card animate-in" style="animation-delay: 0.15s;">
        <div class="title">Ringkasan</div>

        <div class="bc-summary-item">
          <span class="label">Subtotal</span>
          <span class="value mono" id="subtotal">Rp 0</span>
        </div>
        <div class="bc-summary-item">
          <span class="label">Pajak (11%)</span>
          <span class="value mono" id="tax">Rp 0</span>
        </div>
        <div class="bc-summary-item">
          <span class="label">Diskon</span>
          <span class="value mono" id="discount">Rp 0</span>
        </div>

        <div class="bc-summary-total">
          <span>Total</span>
          <span class="value mono" id="total">Rp 0</span>
        </div>

        <div class="bc-form-group" style="margin-top:16px;">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="draft">Draft</option>
            <option value="sent" selected>Dikirim</option>
            <option value="paid">Dibayar</option>
          </select>
        </div>

        <div class="bc-form-actions">
          <button type="submit" class="bc-btn bc-btn-primary">
            <svg class="icon"><use href="#ic-check"/></svg>
            Simpan Tagihan
          </button>
        </div>
      </div>

    </form>

  </div>

  <script>
    let itemIndex = 1;

    function addItem() {
      const tbody = document.getElementById('itemsBody');
      const tr = document.createElement('tr');
      tr.className = 'item-row';
      tr.innerHTML = `
        <td><input type="text" name="items[${itemIndex}][description]" placeholder="Deskripsi item..." required></td>
        <td><input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" required></td>
        <td><input type="number" name="items[${itemIndex}][price]" value="0" min="0" step="1000" required></td>
        <td style="text-align:right;font-weight:600;" class="row-total">Rp 0</td>
        <td style="text-align:center;">
          <button type="button" class="remove-btn" onclick="removeItem(this)">×</button>
        </td>
      `;
      tbody.appendChild(tr);
      itemIndex++;
      
      attachEventListeners(tr);
    }

    function removeItem(btn) {
      const tbody = document.getElementById('itemsBody');
      if (tbody.children.length > 1) {
        btn.closest('tr').remove();
        calculateTotal();
      }
    }

    function attachEventListeners(row) {
      const inputs = row.querySelectorAll('input');
      inputs.forEach(input => {
        input.addEventListener('input', function() {
          calculateRowTotal(row);
          calculateTotal();
        });
        input.addEventListener('change', function() {
          calculateRowTotal(row);
          calculateTotal();
        });
      });
    }

    function calculateRowTotal(row) {
      const qty = parseInt(row.querySelector('input[name*="[quantity]"]').value) || 0;
      const price = parseInt(row.querySelector('input[name*="[price]"]').value) || 0;
      const total = qty * price;
      const totalCell = row.querySelector('.row-total');
      totalCell.textContent = 'Rp ' + total.toLocaleString('id-ID');
      return total;
    }

    function calculateTotal() {
      const rows = document.querySelectorAll('.item-row');
      let subtotal = 0;
      
      rows.forEach(row => {
        const qty = parseInt(row.querySelector('input[name*="[quantity]"]').value) || 0;
        const price = parseInt(row.querySelector('input[name*="[price]"]').value) || 0;
        subtotal += qty * price;
      });

      const tax = Math.round(subtotal * 0.11);
      const total = subtotal + tax;

      document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
      document.getElementById('tax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
      document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', function() {
      const initialRow = document.querySelector('.item-row');
      if (initialRow) {
        attachEventListeners(initialRow);
      }
      
      setTimeout(calculateTotal, 100);

      const buttons = document.querySelectorAll('.bc-btn');
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