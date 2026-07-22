<x-app-layout>
  <x-slot name="title">Edit Event Kalender Pajak</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';
    
    // $event adalah array dari session (tanpa key 'id')
    // $index adalah parameter dari route (posisi asli di session)
    // Gunakan $index untuk semua operasi CRUD
  @endphp

  <style>
    /* ============================================
       KALENDER PAJAK EDIT - Premium Design
       ============================================ */
    
    .cal-edit-wrap {
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
      max-width: 100%;
      padding: 0 24px;
    }

    .cal-edit-wrap * { box-sizing: border-box; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }

    .cal-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .cal-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .ce-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 0 4px;
    }

    .ce-header-left { flex: 1; min-width: 200px; }

    .ce-badge {
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

    .ce-badge .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--theme-primary);
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .ce-header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    .ce-header .subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin: 0;
    }

    .ce-header .subtitle strong {
      color: var(--text-primary);
      font-weight: 600;
    }

    .ce-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
      flex-wrap: wrap;
    }

    .ce-btn {
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

    .ce-btn .icon { width: 16px; height: 16px; }
    .ce-btn:hover { transform: translateY(-2px); }
    .ce-btn:active { transform: translateY(0) scale(0.97); }

    .ce-btn-primary {
      background: var(--theme-gradient);
      color: #fff;
      box-shadow: 0 4px 16px var(--theme-glow);
    }

    .ce-btn-primary:hover {
      box-shadow: 0 8px 28px var(--theme-glow);
      transform: translateY(-2px);
      color: #fff;
    }

    .ce-btn-danger {
      background: var(--danger);
      color: #fff;
      box-shadow: 0 4px 16px rgba(232, 90, 90, 0.25);
    }

    .ce-btn-danger:hover {
      box-shadow: 0 8px 28px rgba(232, 90, 90, 0.35);
      transform: translateY(-2px);
      color: #fff;
    }

    .ce-btn-ghost {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
    }

    .ce-btn-ghost:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-hover);
      color: var(--text-primary);
    }

    .ce-btn .ripple {
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
    .ce-form {
      width: 100%;
      max-width: 100%;
    }

    .ce-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 32px 40px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
    }

    .ce-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .ce-card .title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .ce-card .title .icon {
      width: 20px;
      height: 20px;
      color: var(--theme-primary);
    }

    .ce-card .title .line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }

    /* FORM GROUP */
    .ce-form-group {
      margin-bottom: 20px;
    }

    .ce-form-group:last-child { margin-bottom: 0; }

    .ce-form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
    }

    .ce-form-group .required {
      color: var(--danger);
      margin-left: 2px;
    }

    .ce-form-group input,
    .ce-form-group select,
    .ce-form-group textarea {
      width: 100%;
      padding: 12px 16px;
      background: var(--bg-card-active);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-sm);
      color: var(--text-primary);
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      outline: none;
    }

    .ce-form-group input:focus,
    .ce-form-group select:focus,
    .ce-form-group textarea:focus {
      border-color: var(--theme-primary);
      background: var(--bg-card-hover);
      box-shadow: 0 0 0 4px var(--theme-glow);
    }

    .ce-form-group input::placeholder,
    .ce-form-group textarea::placeholder {
      color: var(--text-tertiary);
    }

    .ce-form-group textarea {
      resize: vertical;
      min-height: 90px;
    }

    .ce-form-group select {
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
      color-scheme: dark;
    }

    .ce-form-group select option {
      background-color: #12181f;
      color: #f2f4f7;
      padding: 10px 14px;
      font-size: 14px;
    }

    .ce-form-group select option:checked,
    .ce-form-group select option:hover {
      background-color: #17352c;
      color: #34d399;
    }

    .ce-form-group select option:disabled {
      color: #6b7280;
    }

    .ce-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* INFO BOX */
    .ce-info-box {
      background: var(--theme-soft);
      border: 1px solid var(--theme-glow);
      border-radius: var(--radius-sm);
      padding: 14px 18px;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .ce-info-box .icon {
      width: 22px;
      height: 22px;
      flex-shrink: 0;
      margin-top: 1px;
      color: var(--theme-primary);
    }

    .ce-info-box .message {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.6;
    }

    .ce-info-box .message strong {
      color: var(--text-primary);
    }

    /* FORM ACTIONS */
    .ce-form-actions {
      display: flex;
      gap: 12px;
      margin-top: 28px;
    }

    .ce-form-actions .ce-btn {
      flex: 1;
      justify-content: center;
      padding: 14px 24px;
      font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .cal-edit-wrap { padding: 0 16px; }
      .ce-card { padding: 24px 28px; }
    }

    @media (max-width: 768px) {
      .cal-edit-wrap { padding: 0 12px; }
      .ce-card { padding: 20px; }
      .ce-form-row { 
        grid-template-columns: 1fr; 
        gap: 0;
      }
      .ce-header h1 { font-size: 24px; }
    }

    @media (max-width: 640px) {
      .ce-header { 
        flex-direction: column; 
      }
      .ce-actions { 
        width: 100%; 
      }
      .ce-actions .ce-btn { 
        flex: 1; 
        justify-content: center; 
      }
      .ce-form-actions { 
        flex-direction: column; 
      }
      .ce-form-actions .ce-btn { 
        flex: none; 
      }
      .ce-card { padding: 16px; }
    }

    @media (max-width: 380px) {
      .cal-edit-wrap { padding: 0 8px; }
      .ce-header h1 { 
        font-size: 20px; 
      }
      .ce-btn { 
        font-size: 12px; 
        padding: 8px 14px; 
      }
      .ce-btn .icon { 
        width: 14px; 
        height: 14px; 
      }
      .ce-card { padding: 12px; }
    }
  </style>

  <div class="cal-edit-wrap">

    <!-- ===== HEADER ===== -->
    <div class="ce-header animate-in" style="animation-delay: 0.05s;">
      <div class="ce-header-left">
        <div class="ce-badge">
          <span class="dot"></span>
          Edit Pajak
        </div>
        <h1>Edit Event Kalender Pajak</h1>
        <p class="subtitle">
          Perbarui informasi event pajak — <strong>pastikan data tetap akurat</strong>
        </p>
      </div>
      <div class="ce-actions">
        <a href="{{ route('tax-calendar.index') }}" class="ce-btn ce-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
        <a href="{{ route('tax-calendar.show', $index) }}" class="ce-btn ce-btn-ghost">
          <svg class="icon"><use href="#ic-eye"/></svg>
          Lihat Event
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('tax-calendar.update', $index) }}" method="POST" class="ce-form">
      @csrf
      @method('PUT')

      <div class="ce-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-calendar"/></svg>
          Informasi Event
          <span class="line"></span>
        </div>

        <!-- Info Box -->
        <div class="ce-info-box">
          <svg class="icon"><use href="#ic-info"/></svg>
          <div class="message">
            <strong>Perhatian:</strong> Perbarui data event pajak dengan benar. 
            Perubahan akan langsung terlihat di kalender pajak.
          </div>
        </div>

        <!-- Title -->
        <div class="ce-form-group">
          <label>Judul Event <span class="required">*</span></label>
          <input type="text" name="title" placeholder="Contoh: PPh Pasal 21 / PPN Masa Juli" value="{{ old('title', $event['title']) }}" required>
        </div>

        <!-- Date & Type -->
        <div class="ce-form-row">
          <div class="ce-form-group">
            <label>Tanggal <span class="required">*</span></label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d', strtotime($event['date']))) }}" required>
          </div>
          <div class="ce-form-group">
            <label>Tipe <span class="required">*</span></label>
            <select name="type" required>
              <option value="pph" {{ old('type', $event['type']) == 'pph' ? 'selected' : '' }}>PPh</option>
              <option value="ppn" {{ old('type', $event['type']) == 'ppn' ? 'selected' : '' }}>PPN</option>
              <option value="other" {{ old('type', $event['type']) == 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
          </div>
        </div>

        <!-- Description -->
        <div class="ce-form-group">
          <label>Deskripsi <span class="required">*</span></label>
          <textarea name="desc" placeholder="Deskripsi event (contoh: Pembayaran PPh Pasal 21 periode Juli)" required>{{ old('desc', $event['desc']) }}</textarea>
        </div>

        <!-- Status -->
        <div class="ce-form-group">
          <label>Status <span class="required">*</span></label>
          <select name="status" required>
            <option value="upcoming" {{ old('status', $event['status']) == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
            <option value="overdue" {{ old('status', $event['status']) == 'overdue' ? 'selected' : '' }}>Lewat Jatuh Tempo</option>
            <option value="done" {{ old('status', $event['status']) == 'done' ? 'selected' : '' }}>Selesai</option>
          </select>
        </div>

        <!-- Actions -->
        <div class="ce-form-actions">
          <button type="submit" class="ce-btn ce-btn-primary">
            <svg class="icon"><use href="#ic-save"/></svg>
            Perbarui Event
          </button>
          <button type="button" class="ce-btn ce-btn-danger" onclick="confirmDelete()">
            <svg class="icon"><use href="#ic-trash"/></svg>
            Hapus Event
          </button>
        </div>
      </div>

    </form>

    <!-- ===== DELETE FORM ===== -->
    <form id="delete-form" action="{{ route('tax-calendar.destroy', $index) }}" method="POST" style="display:none;">
      @csrf
      @method('DELETE')
    </form>

  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-save" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
    <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="ic-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></symbol>
    <symbol id="ic-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
    <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ripple effect
      const buttons = document.querySelectorAll('.ce-btn');
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          if (this.getAttribute('onclick')) return;
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

    function confirmDelete() {
      if (confirm('Apakah Anda yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('delete-form').submit();
      }
    }
  </script>

</x-app-layout>