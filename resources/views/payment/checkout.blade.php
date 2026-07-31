<x-app-layout>
  <x-slot name="title">Pembayaran</x-slot>

  @php
    $accent = $plan['accent']; // 'emerald' atau 'gold'
    $isGold = $accent === 'gold';
    $accentColor = $isGold ? '#f59e0b' : 'var(--emerald)';
    $accentRgb = $isGold ? '245, 158, 11' : 'var(--emerald-rgb)';
  @endphp

  <style>
    .checkout-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 24px 24px 64px;
    }

    /* ===== BACK BUTTON ===== */
    .checkout-back {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-mute);
      text-decoration: none;
      margin-bottom: 20px;
      transition: all 0.2s ease;
      padding: 6px 12px;
      border-radius: 8px;
    }

    .checkout-back:hover {
      color: var(--text);
      background: var(--surface);
    }

    .checkout-back svg {
      width: 16px;
      height: 16px;
    }

    /* ===== HEADER ===== */
    .checkout-head {
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }

    .checkout-head h1 {
      font-size: 28px;
      font-weight: 800;
      letter-spacing: -0.02em;
      margin: 0 0 4px;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .checkout-head h1 svg {
      width: 28px;
      height: 28px;
      color: var(--emerald);
    }

    [data-accent="gold"] .checkout-head h1 svg {
      color: #f59e0b;
    }

    .checkout-head p {
      margin: 0;
      color: var(--text-mute);
      font-size: 14px;
    }

    .checkout-head p strong {
      color: var(--text);
      font-weight: 700;
    }

    .checkout-head .plan-badge-header {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      padding: 3px 12px;
      border-radius: 100px;
      margin-top: 8px;
      background: rgba(var(--emerald-rgb), 0.1);
      color: var(--emerald);
    }

    .checkout-head .plan-badge-header svg {
      width: 12px;
      height: 12px;
    }

    [data-accent="gold"] .checkout-head .plan-badge-header {
      background: rgba(245, 158, 11, 0.12);
      color: #f59e0b;
    }

    /* ===== GRID ===== */
    .checkout-grid {
      display: grid;
      grid-template-columns: 1.3fr 0.7fr;
      gap: 28px;
      align-items: start;
    }

    @media (max-width: 900px) {
      .checkout-grid {
        grid-template-columns: 1fr;
        gap: 24px;
      }
    }

    /* ===== CARD ===== */
    .checkout-card {
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 28px 30px;
      background: var(--surface);
      backdrop-filter: blur(10px);
    }

    /* ===== METODE PEMBAYARAN ===== */
    .checkout-card h2 {
      font-size: 17px;
      font-weight: 700;
      margin: 0 0 2px;
      color: var(--text);
    }

    .checkout-card .sub {
      font-size: 13px;
      color: var(--text-mute);
      margin: 0 0 20px;
    }

    /* ===== PAYMENT METHOD ===== */
    .pm-option {
      display: flex;
      align-items: center;
      gap: 14px;
      border: 1.5px solid var(--border);
      border-radius: 14px;
      padding: 14px 18px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: all 0.25s ease;
      position: relative;
    }

    .pm-option:hover {
      border-color: var(--border-hover);
      background: var(--surface);
    }

    .pm-option input[type="radio"] {
      width: 18px;
      height: 18px;
      accent-color: {{ $accentColor }};
      flex-shrink: 0;
      cursor: pointer;
    }

    .pm-option .pm-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--surface-strong);
      color: var(--text-mute);
      transition: all 0.25s ease;
    }

    .pm-option .pm-icon svg {
      width: 20px;
      height: 20px;
    }

    .pm-option .pm-info {
      flex: 1;
    }

    .pm-option .pm-name {
      font-size: 14px;
      font-weight: 700;
      color: var(--text);
    }

    .pm-option .pm-desc {
      font-size: 12px;
      color: var(--text-mute);
      margin-top: 2px;
    }

    .pm-option .pm-badge {
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      padding: 2px 10px;
      border-radius: 100px;
      background: rgba(var(--emerald-rgb), 0.1);
      color: var(--emerald);
    }

    [data-accent="gold"] .pm-option .pm-badge {
      background: rgba(245, 158, 11, 0.1);
      color: #f59e0b;
    }

    .pm-option:has(input:checked) {
      border-color: {{ $accentColor }};
      background: rgba({{ $accentRgb }}, 0.06);
      box-shadow: 0 0 0 1px rgba({{ $accentRgb }}, 0.1);
    }

    .pm-option:has(input:checked) .pm-icon {
      background: rgba({{ $accentRgb }}, 0.12);
      color: {{ $accentColor }};
    }

    .pm-option:has(input:checked) .pm-badge {
      background: rgba({{ $accentRgb }}, 0.15);
      color: {{ $accentColor }};
    }

    /* ===== PAYMENT DETAIL FORM ===== */
    .payment-detail {
      margin-top: 14px;
      margin-bottom: 14px;
      padding: 16px 18px;
      border-radius: 14px;
      background: var(--surface-strong);
      border: 1px solid var(--border);
      display: none;
    }

    .payment-detail.show {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-8px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .payment-detail label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-mute);
      margin-bottom: 4px;
      margin-top: 12px;
    }

    .payment-detail label:first-of-type {
      margin-top: 0;
    }

    .payment-detail input,
    .payment-detail select {
      width: 100%;
      padding: 10px 14px;
      border-radius: 10px;
      border: 1px solid var(--border);
      background: var(--surface);
      color: var(--text);
      font-size: 14px;
      transition: border-color 0.2s ease;
      margin-bottom: 4px;
    }

    .payment-detail input:focus,
    .payment-detail select:focus {
      outline: none;
      border-color: {{ $accentColor }};
      box-shadow: 0 0 0 3px rgba({{ $accentRgb }}, 0.1);
    }

    /* ===== FIX: DARK MODE DROPDOWN ===== */
    .payment-detail select {
      appearance: auto;
      -webkit-appearance: auto;
      background-color: var(--surface);
      color: var(--text);
      border: 1px solid var(--border);
      cursor: pointer;
    }

    .payment-detail select option {
      background-color: #1e293b;
      color: #f1f5f9;
      padding: 8px 12px;
    }

    .payment-detail select option:hover,
    .payment-detail select option:checked,
    .payment-detail select option:focus {
      background-color: rgba(var(--emerald-rgb), 0.2);
      color: var(--emerald-light);
    }

    .payment-detail select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      padding-right: 36px;
    }

    @media (prefers-color-scheme: dark) {
      .payment-detail select {
        background-color: #1a2332;
        color: #f1f5f9;
        border-color: rgba(255,255,255,0.08);
      }

      .payment-detail select option {
        background-color: #1a2332;
        color: #f1f5f9;
      }

      .payment-detail select option:hover,
      .payment-detail select option:checked {
        background-color: rgba(var(--emerald-rgb), 0.2);
        color: var(--emerald-light);
      }

      .payment-detail input {
        background-color: #1a2332;
        color: #f1f5f9;
        border-color: rgba(255,255,255,0.08);
      }

      .payment-detail input::placeholder {
        color: #64748b;
      }

      .payment-detail input:focus {
        border-color: {{ $accentColor }};
        box-shadow: 0 0 0 3px rgba({{ $accentRgb }}, 0.15);
      }
    }

    .payment-detail .input-group {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    @media (max-width: 480px) {
      .payment-detail .input-group {
        grid-template-columns: 1fr;
      }
    }

    .payment-detail .bank-list {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 8px;
      margin-bottom: 4px;
    }

    .payment-detail .bank-list .bank-item {
      padding: 8px 6px;
      border-radius: 8px;
      border: 1px solid var(--border);
      background: var(--surface);
      text-align: center;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-mute);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .payment-detail .bank-list .bank-item:hover {
      border-color: var(--border-hover);
      background: var(--surface-strong);
    }

    .payment-detail .bank-list .bank-item.selected {
      border-color: {{ $accentColor }};
      background: rgba({{ $accentRgb }}, 0.08);
      color: {{ $accentColor }};
    }

    .payment-detail .bank-list .bank-item .bank-icon {
      display: block;
      font-size: 18px;
      margin-bottom: 2px;
    }

    @media (max-width: 600px) {
      .payment-detail .bank-list {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    /* ===== ERROR ===== */
    .checkout-error {
      color: #ef4444;
      font-size: 12.5px;
      font-weight: 600;
      margin: -6px 0 14px;
      padding: 8px 14px;
      background: rgba(239, 68, 68, 0.08);
      border-radius: 10px;
      border: 1px solid rgba(239, 68, 68, 0.15);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .checkout-error svg {
      width: 14px;
      height: 14px;
    }

    /* ===== NOTE ===== */
    .checkout-note {
      display: flex;
      gap: 10px;
      align-items: flex-start;
      font-size: 12px;
      color: var(--text-faint);
      margin-top: 18px;
      background: var(--surface-strong);
      border-radius: 12px;
      padding: 14px 16px;
      border: 1px solid var(--border);
    }

    .checkout-note svg {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--text-mute);
    }

    /* ===== SECURITY BADGE ===== */
    .security-badge {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-top: 12px;
      font-size: 11px;
      color: var(--text-faint);
    }

    .security-badge svg {
      width: 14px;
      height: 14px;
      color: var(--text-mute);
    }

    /* ===== SUMMARY ===== */
    .summary-card {
      position: sticky;
      top: 20px;
    }

    .summary-plan {
      display: flex;
      align-items: center;
      gap: 14px;
      padding-bottom: 16px;
      margin-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }

    .summary-plan .plan-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .summary-plan .plan-icon svg {
      width: 22px;
      height: 22px;
    }

    [data-accent="emerald"] .summary-plan .plan-icon {
      background: rgba(var(--emerald-rgb), 0.12);
      color: var(--emerald);
    }

    [data-accent="gold"] .summary-plan .plan-icon {
      background: rgba(245, 158, 11, 0.12);
      color: #f59e0b;
    }

    .summary-plan .plan-name {
      font-size: 17px;
      font-weight: 800;
      color: var(--text);
      letter-spacing: -0.01em;
    }

    .summary-plan .plan-badge {
      display: inline-block;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 2px 10px;
      border-radius: 100px;
      margin-top: 2px;
    }

    [data-accent="emerald"] .plan-badge {
      background: rgba(var(--emerald-rgb), 0.12);
      color: var(--emerald);
    }

    [data-accent="gold"] .plan-badge {
      background: rgba(245, 158, 11, 0.12);
      color: #f59e0b;
    }

    .summary-divider {
      height: 1px;
      background: var(--border);
      margin-bottom: 14px;
    }

    .summary-list {
      list-style: none;
      padding: 0;
      margin: 0 0 14px;
    }

    .summary-list li {
      font-size: 13px;
      color: var(--text);
      padding: 4px 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .summary-list li svg {
      width: 14px;
      height: 14px;
      color: var(--emerald);
      flex-shrink: 0;
    }

    [data-accent="gold"] .summary-list li svg {
      color: #f59e0b;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13.5px;
      color: var(--text-mute);
      padding: 4px 0;
    }

    .summary-row.total {
      border-top: 2px solid var(--border);
      margin-top: 8px;
      padding-top: 14px;
      font-size: 16px;
      font-weight: 800;
      color: var(--text);
    }

    .summary-row.total span:last-child {
      font-size: 22px;
      color: {{ $accentColor }};
    }

    .summary-save {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      color: var(--emerald);
      background: rgba(var(--emerald-rgb), 0.08);
      padding: 6px 12px;
      border-radius: 8px;
      margin-top: 4px;
    }

    [data-accent="gold"] .summary-save {
      color: #f59e0b;
      background: rgba(245, 158, 11, 0.08);
    }

    .summary-save svg {
      width: 14px;
      height: 14px;
    }

    /* ===== BUTTON PAY ===== */
    .btn-pay {
      width: 100%;
      padding: 15px;
      border-radius: 12px;
      border: none;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      margin-top: 20px;
      color: #fff;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-pay svg {
      width: 18px;
      height: 18px;
    }

    .btn-pay:hover {
      transform: translateY(-2px);
      filter: brightness(1.06);
      box-shadow: 0 8px 32px rgba({{ $accentRgb }}, 0.3);
    }

    .btn-pay:active {
      transform: scale(0.98);
    }

    .btn-pay:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      transform: none !important;
    }

    [data-accent="emerald"] .btn-pay {
      background: linear-gradient(135deg, #34D399, var(--emerald));
      box-shadow: 0 4px 16px rgba(var(--emerald-rgb), 0.3);
    }

    [data-accent="gold"] .btn-pay {
      background: linear-gradient(135deg, #fbbf24, #f59e0b);
      color: #0f172a;
      box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
    }

    [data-accent="gold"] .btn-pay:hover {
      box-shadow: 0 8px 32px rgba(245, 158, 11, 0.4);
    }

    .summary-invoice {
      font-size: 11.5px;
      color: var(--text-faint);
      text-align: center;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .summary-invoice svg {
      width: 13px;
      height: 13px;
    }

    /* ===== GUARANTEE ===== */
    .guarantee {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 24px;
      margin-top: 20px;
      padding: 14px 20px;
      border-radius: 12px;
      background: var(--surface-strong);
      border: 1px solid var(--border);
    }

    .guarantee-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11.5px;
      color: var(--text-mute);
    }

    .guarantee-item svg {
      width: 14px;
      height: 14px;
      color: var(--emerald);
    }

    [data-accent="gold"] .guarantee-item svg {
      color: #f59e0b;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .checkout-wrap {
        padding: 16px 16px 40px;
      }

      .checkout-head h1 {
        font-size: 22px;
      }

      .checkout-head p {
        font-size: 13px;
      }

      .checkout-card {
        padding: 20px 18px;
      }

      .pm-option {
        padding: 12px 14px;
        gap: 10px;
      }

      .pm-option .pm-icon {
        width: 36px;
        height: 36px;
      }

      .pm-option .pm-icon svg {
        width: 16px;
        height: 16px;
      }

      .summary-plan .plan-icon {
        width: 40px;
        height: 40px;
      }

      .summary-plan .plan-name {
        font-size: 15px;
      }

      .summary-row.total span:last-child {
        font-size: 18px;
      }

      .btn-pay {
        font-size: 14px;
        padding: 13px;
      }

      .guarantee {
        flex-wrap: wrap;
        gap: 12px;
        padding: 12px;
      }
    }

    @media (max-width: 480px) {
      .checkout-head h1 {
        font-size: 20px;
      }

      .pm-option .pm-name {
        font-size: 13px;
      }

      .pm-option .pm-desc {
        font-size: 11px;
      }

      .payment-detail .bank-list {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  </style>

  <div class="checkout-wrap" data-accent="{{ $accent }}">
    <!-- ===== BACK BUTTON ===== -->
    <a href="{{ route('pricing.index') }}" class="checkout-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
      Kembali ke Paket
    </a>

    <!-- ===== HEADER ===== -->
    <div class="checkout-head">
      <h1>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="1" y="4" width="22" height="16" rx="2"/>
          <path d="M1 10h22"/>
        </svg>
        Selesaikan Pembayaran
      </h1>
      <p>
        Kamu akan upgrade ke paket <strong>{{ $plan['name'] }}</strong>.
        <span class="plan-badge-header">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          {{ $plan['period'] === '/bulan' ? 'Langganan Bulanan' : 'Paket ' . $plan['name'] }}
        </span>
      </p>
    </div>

    <form method="POST" action="{{ route('payment.process', $planKey) }}" id="paymentForm">
      @csrf
      <div class="checkout-grid">
        <!-- ===== METODE PEMBAYARAN ===== -->
        <div class="checkout-card">
          <h2>Metode Pembayaran</h2>
          <p class="sub">Pilih salah satu metode di bawah ini untuk menyelesaikan pembayaran.</p>

          @error('payment_method')
            <div class="checkout-error">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
              </svg>
              {{ $message }}
            </div>
          @enderror

          <!-- Transfer Bank -->
          <label class="pm-option">
            <input type="radio" name="payment_method" value="bank_transfer" data-target="bank-detail" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
            <span class="pm-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/>
                <path d="M2 10h20"/>
                <path d="M6 15h4"/>
              </svg>
            </span>
            <span class="pm-info">
              <span class="pm-name">Transfer Bank</span>
              <span class="pm-desc">BCA, Mandiri, BNI, BRI — via Virtual Account</span>
            </span>
            <span class="pm-badge">Populer</span>
          </label>

          <div class="payment-detail" id="bank-detail">
            <label>Pilih Bank</label>
            <div class="bank-list">
              <div class="bank-item" data-bank="bca">
                <span class="bank-icon">🏦</span>
                BCA
              </div>
              <div class="bank-item" data-bank="mandiri">
                <span class="bank-icon">🏦</span>
                Mandiri
              </div>
              <div class="bank-item" data-bank="bni">
                <span class="bank-icon">🏦</span>
                BNI
              </div>
              <div class="bank-item" data-bank="bri">
                <span class="bank-icon">🏦</span>
                BRI
              </div>
            </div>
            <input type="hidden" name="bank" id="selected-bank" value="bca">
            
            <label>Nomor Rekening</label>
            <input type="text" name="account_number" placeholder="Masukkan nomor rekening Anda" value="{{ old('account_number') }}">
            
            <label>Nama Pemilik Rekening</label>
            <input type="text" name="account_name" placeholder="Masukkan nama pemilik rekening" value="{{ old('account_name') }}">
          </div>

          <!-- E-Wallet -->
          <label class="pm-option">
            <input type="radio" name="payment_method" value="e_wallet" data-target="wallet-detail" {{ old('payment_method') === 'e_wallet' ? 'checked' : '' }}>
            <span class="pm-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="18" height="16" rx="2"/>
                <path d="M16 12h.01"/>
                <path d="M20 8V6a2 2 0 0 0-2-2H4"/>
              </svg>
            </span>
            <span class="pm-info">
              <span class="pm-name">E-Wallet</span>
              <span class="pm-desc">GoPay, OVO, DANA, ShopeePay</span>
            </span>
          </label>

          <div class="payment-detail" id="wallet-detail">
            <label>Pilih E-Wallet</label>
            <select name="wallet_type">
              <option value="gopay">GoPay</option>
              <option value="ovo">OVO</option>
              <option value="dana">DANA</option>
              <option value="shopeepay">ShopeePay</option>
            </select>
            
            <label>Nomor Akun</label>
            <input type="text" name="wallet_number" placeholder="Masukkan nomor akun e-wallet Anda" value="{{ old('wallet_number') }}">
          </div>

          <!-- Kartu Kredit -->
          <label class="pm-option">
            <input type="radio" name="payment_method" value="credit_card" data-target="card-detail" {{ old('payment_method') === 'credit_card' ? 'checked' : '' }}>
            <span class="pm-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2"/>
                <path d="M1 10h22"/>
              </svg>
            </span>
            <span class="pm-info">
              <span class="pm-name">Kartu Kredit / Debit</span>
              <span class="pm-desc">Visa, Mastercard, JCB</span>
            </span>
          </label>

          <div class="payment-detail" id="card-detail">
            <label>Nomor Kartu</label>
            <input type="text" name="card_number" placeholder="1234 5678 9012 3456" value="{{ old('card_number') }}">
            
            <div class="input-group">
              <div>
                <label>Tanggal Kadaluarsa</label>
                <input type="text" name="card_expiry" placeholder="MM/YY" value="{{ old('card_expiry') }}">
              </div>
              <div>
                <label>CVV</label>
                <input type="text" name="card_cvv" placeholder="123" value="{{ old('card_cvv') }}">
              </div>
            </div>
            
            <label>Nama Pemilik Kartu</label>
            <input type="text" name="card_name" placeholder="Nama sesuai kartu" value="{{ old('card_name') }}">
          </div>

          <!-- QRIS -->
          <label class="pm-option">
            <input type="radio" name="payment_method" value="qris" data-target="qris-detail" {{ old('payment_method') === 'qris' ? 'checked' : '' }}>
            <span class="pm-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="8" height="8" rx="1"/>
                <rect x="14" y="2" width="8" height="8" rx="1"/>
                <rect x="2" y="14" width="8" height="8" rx="1"/>
                <rect x="14" y="14" width="8" height="8" rx="1"/>
                <line x1="6" y1="6" x2="6" y2="6.01"/>
                <line x1="18" y1="6" x2="18" y2="6.01"/>
                <line x1="6" y1="18" x2="6" y2="18.01"/>
                <line x1="18" y1="18" x2="18" y2="18.01"/>
              </svg>
            </span>
            <span class="pm-info">
              <span class="pm-name">QRIS</span>
              <span class="pm-desc">Scan QR code dengan aplikasi mobile banking atau e-wallet</span>
            </span>
          </label>

          <div class="payment-detail" id="qris-detail">
            <div style="text-align:center;padding:16px 0;">
              <div style="width:150px;height:150px;margin:0 auto;background:var(--surface-strong);border-radius:16px;display:flex;align-items:center;justify-content:center;border:2px dashed var(--border);">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-mute);">
                  <rect x="2" y="2" width="8" height="8" rx="1"/>
                  <rect x="14" y="2" width="8" height="8" rx="1"/>
                  <rect x="2" y="14" width="8" height="8" rx="1"/>
                  <rect x="14" y="14" width="8" height="8" rx="1"/>
                  <line x1="6" y1="6" x2="6" y2="6.01"/>
                  <line x1="18" y1="6" x2="18" y2="6.01"/>
                  <line x1="6" y1="18" x2="6" y2="18.01"/>
                  <line x1="18" y1="18" x2="18" y2="18.01"/>
                </svg>
              </div>
              <p style="margin-top:12px;font-size:13px;color:var(--text-mute);">
                Scan QR code dengan aplikasi mobile banking atau e-wallet Anda
              </p>
            </div>
          </div>

          <!-- ===== NOTE ===== -->
          <div class="checkout-note">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 16v-4"/>
              <path d="M12 8h.01"/>
            </svg>
            <span>Pembayaran diproses dengan aman. Kamu bisa membatalkan langganan kapan saja setelah pembayaran berhasil.</span>
          </div>

          <!-- ===== SECURITY ===== -->
          <div class="security-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              <polyline points="9 12 11 14 15 10"/>
            </svg>
            <span>Transaksi aman dan terenkripsi</span>
          </div>
        </div>

        <!-- ===== RINGKASAN PESANAN ===== -->
        <div class="checkout-card summary-card" data-accent="{{ $accent }}">
          <!-- Plan -->
          <div class="summary-plan">
            <div class="plan-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                @if($accent === 'gold')
                  <path d="M12 2 3 14h8l-1 8 10-12h-8l1-8Z"/>
                @else
                  <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                @endif
              </svg>
            </div>
            <div>
              <div class="plan-name">Paket {{ $plan['name'] }}</div>
              <span class="plan-badge">{{ $plan['period'] === '/bulan' ? 'Langganan Bulanan' : $plan['name'] }}</span>
            </div>
          </div>

          <!-- Features -->
          <div class="summary-divider"></div>
          <ul class="summary-list">
            @foreach($plan['features'] as $feature)
              <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ $feature }}
              </li>
            @endforeach
          </ul>

          <!-- Price Details -->
          <div class="summary-divider"></div>
          <div class="summary-row">
            <span>Harga paket</span>
            <span>{{ $plan['label'] }}</span>
          </div>
          <div class="summary-row">
            <span>Periode</span>
            <span>Bulanan</span>
          </div>

          <!-- Save Badge -->
          @if($accent === 'gold')
            <div class="summary-save">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2v4"/>
                <path d="M6 9l3 3-3 3"/>
                <path d="M18 9l-3 3 3 3"/>
                <rect x="2" y="14" width="20" height="8" rx="1"/>
              </svg>
              Hemat 10% dengan langganan tahunan
            </div>
          @endif

          <!-- Total -->
          <div class="summary-row total">
            <span>Total Bayar</span>
            <span>{{ $plan['label'] }}</span>
          </div>

          <!-- Pay Button -->
          <button type="submit" class="btn-pay" id="payButton">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <rect x="1" y="4" width="22" height="16" rx="2"/>
              <path d="M1 10h22"/>
            </svg>
            Bayar Sekarang
          </button>

          <!-- Invoice -->
          <div class="summary-invoice">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="16" y1="13" x2="8" y2="13"/>
              <line x1="16" y1="17" x2="8" y2="17"/>
              <polyline points="10 9 9 9 8 9"/>
            </svg>
            No. Invoice: {{ $invoiceNo }}
          </div>
        </div>
      </div>

      <!-- ===== GUARANTEE ===== -->
      <div class="guarantee" data-accent="{{ $accent }}">
        <span class="guarantee-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            <polyline points="9 12 11 14 15 10"/>
          </svg>
          Pembayaran Aman
        </span>
        <span class="guarantee-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 6v6l4 2"/>
          </svg>
          Aktivasi Instan
        </span>
        <span class="guarantee-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16v16H4z"/>
            <polyline points="9 9 11 11 15 7"/>
            <path d="M4 14h6"/>
            <path d="M14 14h6"/>
          </svg>
          Garansi 30 Hari
        </span>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // ===== RADIO BUTTON SHOW/HIDE DETAIL =====
      const radioButtons = document.querySelectorAll('input[name="payment_method"]');
      const detailPanels = {
        'bank_transfer': document.getElementById('bank-detail'),
        'e_wallet': document.getElementById('wallet-detail'),
        'credit_card': document.getElementById('card-detail'),
        'qris': document.getElementById('qris-detail')
      };

      function toggleDetails(selectedValue) {
        // Hide all details
        Object.values(detailPanels).forEach(panel => {
          if (panel) panel.classList.remove('show');
        });

        // Show selected detail
        if (selectedValue && detailPanels[selectedValue]) {
          detailPanels[selectedValue].classList.add('show');
        }
      }

      // Initial state
      const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
      if (checkedRadio) {
        toggleDetails(checkedRadio.value);
      }

      // On change
      radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
          toggleDetails(this.value);
        });
      });

      // ===== BANK SELECTION =====
      const bankItems = document.querySelectorAll('.bank-item');
      const selectedBankInput = document.getElementById('selected-bank');

      bankItems.forEach(item => {
        item.addEventListener('click', function() {
          bankItems.forEach(b => b.classList.remove('selected'));
          this.classList.add('selected');
          selectedBankInput.value = this.dataset.bank;
        });
      });

      // Select first bank by default
      const firstBank = document.querySelector('.bank-item');
      if (firstBank) {
        firstBank.classList.add('selected');
        selectedBankInput.value = firstBank.dataset.bank;
      }

      // ===== FORM VALIDATION =====
      const form = document.getElementById('paymentForm');
      const payButton = document.getElementById('payButton');

      form.addEventListener('submit', function(e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        
        if (!selectedMethod) {
          e.preventDefault();
          alert('Silakan pilih metode pembayaran terlebih dahulu.');
          return;
        }

        const method = selectedMethod.value;
        let isValid = true;
        let errorMessage = '';

        // Validate based on method
        if (method === 'bank_transfer') {
          const accountNumber = document.querySelector('input[name="account_number"]');
          const accountName = document.querySelector('input[name="account_name"]');
          
          if (!accountNumber.value.trim()) {
            isValid = false;
            errorMessage = 'Silakan masukkan nomor rekening Anda.';
            accountNumber.focus();
          } else if (!accountName.value.trim()) {
            isValid = false;
            errorMessage = 'Silakan masukkan nama pemilik rekening.';
            accountName.focus();
          }
        } else if (method === 'e_wallet') {
          const walletNumber = document.querySelector('input[name="wallet_number"]');
          
          if (!walletNumber.value.trim()) {
            isValid = false;
            errorMessage = 'Silakan masukkan nomor akun e-wallet Anda.';
            walletNumber.focus();
          }
        } else if (method === 'credit_card') {
          const cardNumber = document.querySelector('input[name="card_number"]');
          const cardExpiry = document.querySelector('input[name="card_expiry"]');
          const cardCvv = document.querySelector('input[name="card_cvv"]');
          const cardName = document.querySelector('input[name="card_name"]');
          
          if (!cardNumber.value.trim()) {
            isValid = false;
            errorMessage = 'Silakan masukkan nomor kartu Anda.';
            cardNumber.focus();
          } else if (!cardExpiry.value.trim()) {
            isValid = false;
            errorMessage = 'Silakan masukkan tanggal kadaluarsa kartu.';
            cardExpiry.focus();
          } else if (!cardCvv.value.trim()) {
            isValid = false;
            errorMessage = 'Silakan masukkan CVV kartu Anda.';
            cardCvv.focus();
          } else if (!cardName.value.trim()) {
            isValid = false;
            errorMessage = 'Silakan masukkan nama pemilik kartu.';
            cardName.focus();
          }
        }

        if (!isValid) {
          e.preventDefault();
          alert(errorMessage);
        }
      });
    });
  </script>
</x-app-layout>