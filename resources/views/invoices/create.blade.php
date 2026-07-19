<x-app-layout>
  <x-slot name="title">Faktur Baru</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    
    // DUMMY clients - nanti ganti dengan data dari database
    $clients = [
        ['id' => 1, 'name' => 'PT Andalas Maju Bersama'],
        ['id' => 2, 'name' => 'Nusantara Logistik'],
        ['id' => 3, 'name' => 'Ruang Kriya Studio'],
        ['id' => 4, 'name' => 'Bumi Retail Group'],
    ];
    
    // Generate nomor invoice otomatis
    $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(1, 4, '0', STR_PAD_LEFT);
  @endphp

  <style>
    /* ============================================
       FAKTUR BARU - Premium Design
       ============================================ */
    
    .invoice-create-wrap {
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
      
      --radius-sm: 10px;
      --radius-md: 16px;
      --radius-lg: 24px;
      
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-primary);
    }

    .invoice-create-wrap * { box-sizing: border-box; }
    .invoice-create-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .invoice-create-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .invoice-create-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .ic-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .ic-header-left { flex: 1; min-width: 200px; }

    .ic-badge {
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

    .ic-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .ic-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .ic-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .ic-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .ic-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .ic-btn {
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

    .ic-btn .icon { width: 16px; height: 16px; }
    .ic-btn:hover { transform: translateY(-2px); }
    .ic-btn:active { transform: translateY(0) scale(0.97); }

    .ic-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .ic-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .ic-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .ic-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .ic-btn .ripple {
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
    .ic-form {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 24px;
      align-items: start;
    }

    .ic-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 28px 30px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .ic-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .ic-card .title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .ic-card .title .icon {
      width: 18px;
      height: 18px;
      color: var(--theme-primary);
    }

    .ic-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .ic-form-group {
      margin-bottom: 18px;
    }

    .ic-form-group:last-child { margin-bottom: 0; }

    .ic-form-group label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .ic-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .ic-form-group input,
    .ic-form-group select,
    .ic-form-group textarea {
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

    .ic-form-group input:focus,
    .ic-form-group select:focus,
    .ic-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .ic-form-group input::placeholder,
    .ic-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .ic-form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .ic-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .ic-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 13px;
    }

    .ic-form-group select option:checked,
    .ic-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .ic-form-group select option:disabled {
      color: #6b7280;
    }

    .ic-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    /* ITEMS TABLE */
    .ic-items-wrap {
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      overflow: hidden;
      margin-top: 4px;
    }

    .ic-items-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    .ic-items-table th {
      text-align: left;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--text-tertiary);
      padding: 10px 12px;
      background: var(--bg-card-active);
      border-bottom: 1px solid var(--border-color);
    }

    .ic-items-table td {
      padding: 8px 10px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-primary);
      vertical-align: middle;
    }

    .ic-items-table tr:last-child td {
      border-bottom: none;
    }

    .ic-items-table input {
      width: 100%;
      padding: 8px 10px;
      background: transparent;
      border: 1px solid transparent;
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 12px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .ic-items-table input:hover {
      background: var(--bg-card-active);
      border-color: var(--border-color);
    }

    .ic-items-table input:focus {
      background: var(--bg-card-active);
      border-color: var(--theme-primary);
      box-shadow: 0 0 0 3px var(--theme-glow);
    }

    .ic-items-table .remove-btn {
      background: none;
      border: none;
      color: var(--text-tertiary);
      cursor: pointer;
      font-size: 16px;
      padding: 4px 8px;
      border-radius: 4px;
      transition: all 0.2s ease;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
    }

    .ic-items-table .remove-btn:hover {
      color: var(--danger);
      background: var(--danger-soft);
    }

    .ic-add-item {
      padding: 10px 16px;
      background: transparent;
      border: 1px dashed var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-secondary);
      font-size: 12px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .ic-add-item:hover {
      border-color: var(--theme-primary);
      color: var(--theme-primary);
      background: var(--theme-soft);
    }

    .ic-add-item .icon {
      width: 14px;
      height: 14px;
    }

    /* SIDEBAR SUMMARY */
    .ic-summary {
      position: sticky;
      top: 80px;
    }

    .ic-summary-item {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid var(--border-color);
      font-size: 13px;
    }

    .ic-summary-item:last-child { border-bottom: none; }

    .ic-summary-item .label {
      color: var(--text-secondary);
    }

    .ic-summary-item .value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .ic-summary-item .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .ic-summary-total {
      padding: 16px 0 4px;
      display: flex;
      justify-content: space-between;
      font-size: 20px;
      font-weight: 700;
      border-top: 2px solid var(--theme-primary);
      margin-top: 4px;
    }

    .ic-summary-total .label {
      color: var(--text-primary);
    }

    .ic-summary-total .value {
      color: var(--theme-primary);
    }

    .ic-summary-total .value.mono {
      font-family: 'IBM Plex Mono', monospace;
    }

    .ic-form-actions {
      display: flex;
      gap: 10px;
      margin-top: 24px;
    }

    .ic-form-actions .ic-btn {
      flex: 1;
      justify-content: center;
      padding: 12px 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .ic-form { grid-template-columns: 1fr; }
      .ic-summary { position: static; }
      .ic-form-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .ic-items-table { font-size: 12px; }
      .ic-items-table th, .ic-items-table td { padding: 6px 8px; }
      .ic-items-table input { font-size: 11px; padding: 6px 8px; }
      .ic-card { padding: 20px; }
    }

    @media (max-width: 640px) {
      .ic-header { flex-direction: column; }
      .ic-actions { width: 100%; }
      .ic-actions .ic-btn { flex: 1; justify-content: center; }
    }

    @media (max-width: 380px) {
      .ic-header h1 { font-size: 22px; }
      .ic-btn { font-size: 12px; padding: 8px 14px; }
      .ic-btn .icon { width: 14px; height: 14px; }
    }
  </style>

  <div class="invoice-create-wrap">

    <!-- ===== HEADER ===== -->
    <div class="ic-header animate-in" style="animation-delay: 0.05s;">
      <div class="ic-header-left">
        <div class="ic-badge">
          <span class="dot"></span>
          Penjualan
        </div>
        <h1>Faktur Baru</h1>
        <p class="subtitle">
          Buat faktur baru untuk klien — akan tersimpan di <strong>Semua Faktur</strong>
        </p>
      </div>
      <div class="ic-actions">
        <a href="{{ route('invoices.index') }}" class="ic-btn ic-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali ke Semua Faktur
        </a>
      </div>
    </div>

    <form action="{{ route('invoices.store') }}" method="POST" class="ic-form">
      @csrf

      <!-- ===== MAIN FORM ===== -->
      <div class="ic-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-invoice"/></svg>
          Informasi Faktur
          <span class="line"></span>
        </div>

        <div class="ic-form-group">
          <label>Klien <span class="required">*</span></label>
          <select name="client_id" required>
            <option value="">Pilih Klien...</option>
            @foreach($clients as $c)
              <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
            @endforeach
          </select>
        </div>

        <div class="ic-form-row">
          <div class="ic-form-group">
            <label>Nomor Faktur <span class="required">*</span></label>
            <input type="text" name="number" value="{{ $invoiceNumber }}" placeholder="INV-2026-0001" required>
          </div>
          <div class="ic-form-group">
            <label>Tanggal Faktur <span class="required">*</span></label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>

        <div class="ic-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan untuk klien..."></textarea>
        </div>

        <div class="title" style="margin-top: 24px;">
          <svg class="icon"><use href="#ic-briefcase"/></svg>
          Item Faktur
          <span class="line"></span>
        </div>

        <div class="ic-items-wrap">
          <table class="ic-items-table">
            <thead>
              <tr>
                <th style="width:35%;">Deskripsi</th>
                <th style="width:18%;">Jumlah</th>
                <th style="width:22%;">Harga</th>
                <th style="width:20%;text-align:right;">Total</th>
                <th style="width:5%;"></th>
              </tr>
            </thead>
            <tbody id="itemsBody">
              <tr class="item-row">
                <td><input type="text" name="items[0][description]" placeholder="Nama item..." required></td>
                <td><input type="number" name="items[0][quantity]" value="1" min="1" required></td>
                <td><input type="number" name="items[0][price]" value="0" min="0" step="1000" required></td>
                <td style="text-align:right;font-weight:600;" class="row-total">Rp 0</td>
                <td style="text-align:center;">
                  <button type="button" class="remove-btn" onclick="removeItem(this)">×</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <button type="button" class="ic-add-item" onclick="addItem()">
          <svg class="icon"><use href="#ic-plus"/></svg>
          Tambah Item
        </button>
      </div>

      <!-- ===== SIDEBAR SUMMARY ===== -->
      <div class="ic-summary">
        <div class="ic-card animate-in" style="animation-delay: 0.15s;">
          <div class="title">
            <svg class="icon"><use href="#ic-target"/></svg>
            Ringkasan
            <span class="line"></span>
          </div>

          <div class="ic-summary-item">
            <span class="label">Subtotal</span>
            <span class="value mono" id="subtotal">Rp 0</span>
          </div>
          <div class="ic-summary-item">
            <span class="label">Pajak (11%)</span>
            <span class="value mono" id="tax">Rp 0</span>
          </div>
          <div class="ic-summary-item" style="border-bottom: none;">
            <span class="label">Diskon</span>
            <span class="value mono" id="discount">Rp 0</span>
          </div>

          <div class="ic-summary-total">
            <span class="label">Total</span>
            <span class="value mono" id="total">Rp 0</span>
          </div>

          <div class="ic-form-group" style="margin-top: 20px;">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="draft">Draft</option>
              <option value="sent" selected>Dikirim</option>
              <option value="paid">Dibayar</option>
            </select>
          </div>

          <div class="ic-form-actions">
            <button type="submit" class="ic-btn ic-btn-primary">
              <svg class="icon"><use href="#ic-check"/></svg>
              Simpan Faktur
            </button>
          </div>
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
        <td><input type="text" name="items[${itemIndex}][description]" placeholder="Nama item..." required></td>
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

      const buttons = document.querySelectorAll('.ic-btn');
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