<x-app-layout>
  <x-slot name="title">Edit PPh</x-slot>

  @php
    $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
    $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

    $months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    // Data asli dari controller (TaxPphController::edit)
    $tax = array_merge([
        'id' => $index ?? 0,
        'period' => '',
        'gross' => 0,
        'deduction' => 0,
        'tax' => 0,
        'due' => date('Y-m-d'),
        'status' => 'pending',
        'notes' => '',
    ], $pph ?? []);
  @endphp

  <style>
    /* ============================================
       PPh EDIT - Premium Design
       ============================================ */

    .pph-edit-wrap {
      --theme-primary: var(--info);
      --theme-light: var(--info);
      --theme-dark: var(--info);
      --theme-glow: rgba(78, 143, 240, 0.25);
      --theme-soft: rgba(78, 143, 240, 0.12);
      --theme-gradient: linear-gradient(135deg, #4E8FF0, #3a7ad4);

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

    .pph-edit-wrap * { box-sizing: border-box; }
    .pph-edit-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

    @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulseGlow { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
    @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes modalSlideUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }

    .pph-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .pph-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* HEADER */
    .pe-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; flex-wrap: wrap; margin-bottom: 32px; padding: 0 4px; }
    .pe-header-left { flex: 1; min-width: 200px; }

    .pe-badge {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 6px 16px 6px 12px; background: var(--theme-glow); border: 1px solid var(--theme-glow);
      border-radius: 100px; font-size: 11px; font-weight: 600; letter-spacing: 0.06em;
      text-transform: uppercase; color: var(--theme-primary); margin-bottom: 12px;
    }
    .pe-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--theme-primary); animation: pulseGlow 2s ease-in-out infinite; }

    .pe-header h1 {
      font-size: 28px; font-weight: 700; margin: 0 0 6px;
      background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
      letter-spacing: -0.02em;
    }
    .pe-header .subtitle { font-size: 14px; color: var(--text-secondary); margin: 0; }
    .pe-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

    .pe-actions { display: flex; gap: 10px; flex-shrink: 0; flex-wrap: wrap; }

    .pe-btn {
      display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius-sm);
      font-size: 13px; font-weight: 600; text-decoration: none; border: none; cursor: pointer;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); background: transparent; color: var(--text-secondary);
      position: relative; overflow: hidden;
    }
    .pe-btn .icon { width: 16px; height: 16px; }
    .pe-btn:hover { transform: translateY(-2px); }
    .pe-btn:active { transform: translateY(0) scale(0.97); }

    .pe-btn-primary { background: var(--theme-gradient); color: #fff; box-shadow: 0 4px 16px var(--theme-glow); }
    .pe-btn-primary:hover { box-shadow: 0 8px 28px var(--theme-glow); transform: translateY(-2px); color: #fff; }

    .pe-btn-ghost { background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-secondary); }
    .pe-btn-ghost:hover { background: var(--bg-card-hover); border-color: var(--border-hover); color: var(--text-primary); }

    .pe-btn-danger-ghost { background: transparent; border: 1px solid var(--danger-soft); color: var(--danger); }
    .pe-btn-danger-ghost:hover { background: var(--danger-soft); }

    /* FORM LAYOUT */
    .pe-form { max-width: 800px; margin: 0 auto; }

    .pe-card {
      background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md);
      padding: 28px 32px; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .pe-card:hover { border-color: var(--border-hover); }

    .pe-card .title { font-size: 15px; font-weight: 600; color: var(--text-primary); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .pe-card .title .icon { width: 18px; height: 18px; color: var(--theme-primary); }
    .pe-card .title .line { flex: 1; height: 1px; background: linear-gradient(90deg, var(--border-color), transparent); }

    /* FORM GROUP */
    .pe-form-group { margin-bottom: 18px; }
    .pe-form-group:last-child { margin-bottom: 0; }
    .pe-form-group label { display: block; font-size: 11px; font-weight: 600; color: var(--text-tertiary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .pe-form-group .required { color: var(--danger); margin-left: 2px; }
    .pe-form-group .hint { display: block; font-size: 11.5px; color: var(--text-tertiary); margin-top: 6px; text-transform: none; letter-spacing: normal; }

    .pe-form-group input, .pe-form-group select, .pe-form-group textarea {
      width: 100%; padding: 10px 14px; background: var(--bg-card-active); border: 1px solid var(--border-color);
      border-radius: var(--radius-sm); color: var(--text-primary); font-size: 13px; font-family: 'Inter', sans-serif;
      transition: all 0.3s ease; outline: none;
    }
    .pe-form-group input:focus, .pe-form-group select:focus, .pe-form-group textarea:focus {
      border-color: var(--theme-primary); background: var(--bg-card-hover); box-shadow: 0 0 0 4px var(--theme-glow);
    }
    .pe-form-group textarea { resize: vertical; min-height: 80px; }
    .pe-form-group select { cursor: pointer; appearance: auto; -webkit-appearance: auto; color-scheme: dark; }
    .pe-form-group select option { background-color: #12181f; color: #f2f4f7; padding: 10px 14px; font-size: 13px; }

    .pe-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    .pe-preview {
      display: flex; justify-content: space-between; align-items: center; background: var(--bg-card-active);
      border: 1px dashed var(--border-color); border-radius: var(--radius-sm); padding: 12px 16px;
      margin-bottom: 18px; font-size: 13px;
    }
    .pe-preview .label { color: var(--text-secondary); }
    .pe-preview .value { font-family: 'IBM Plex Mono', monospace; font-weight: 600; color: var(--theme-primary); }

    /* FORM ACTIONS */
    .pe-form-actions { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-top: 24px; flex-wrap: wrap; }
    .pe-form-actions .right-actions { display: flex; gap: 10px; }

    /* DELETE MODAL */
    .pe-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 999; align-items: center; justify-content: center; animation: modalFadeIn 0.25s ease; }
    .pe-modal-overlay.active { display: flex; }
    .pe-modal-box { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; max-width: 380px; width: 90%; text-align: center; animation: modalSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .pe-modal-box h3 { font-size: 17px; font-weight: 700; margin: 12px 0 8px; }
    .pe-modal-box p { font-size: 13.5px; color: var(--text-secondary); margin: 0 0 20px; }
    .pe-modal-icon { width: 52px; height: 52px; border-radius: 50%; background: var(--danger-soft); color: var(--danger); display: flex; align-items: center; justify-content: center; margin: 0 auto; }
    .pe-modal-icon svg { width: 26px; height: 26px; }
    .pe-modal-actions { display: flex; gap: 10px; }
    .pe-modal-actions button { flex: 1; padding: 11px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; }
    .pe-modal-actions .btn-outline { background: transparent; border: 1.5px solid var(--border-color); color: var(--text-secondary); }
    .pe-modal-actions .btn-danger { background: var(--danger); color: #fff; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .pe-form-row { grid-template-columns: 1fr; }
      .pe-card { padding: 20px; }
    }
    @media (max-width: 640px) {
      .pe-header { flex-direction: column; }
      .pe-actions { width: 100%; }
      .pe-actions .pe-btn { flex: 1; justify-content: center; }
      .pe-form-actions { flex-direction: column-reverse; align-items: stretch; }
      .pe-form-actions .right-actions { flex-direction: column-reverse; }
      .pe-form-actions .pe-btn { flex: none; width: 100%; }
    }
  </style>

  <div class="pph-edit-wrap">

    <!-- ===== HEADER ===== -->
    <div class="pe-header animate-in" style="animation-delay: 0.05s;">
      <div class="pe-header-left">
        <div class="pe-badge"><span class="dot"></span> Edit Pajak</div>
        <h1>Edit PPh</h1>
        <p class="subtitle">Mengubah data PPh periode <strong>{{ $tax['period'] }}</strong></p>
      </div>
      <div class="pe-actions">
        <a href="{{ route('taxes.pph') }}" class="pe-btn pe-btn-ghost">
          <svg class="icon" style="transform:rotate(180deg);"><use href="#ic-arrow-right"/></svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- ===== FORM ===== -->
    <form action="{{ route('taxes.pph.update', $tax['id']) }}" method="POST" class="pe-form">
      @csrf
      @method('PUT')

      <div class="pe-card animate-in" style="animation-delay: 0.10s;">
        <div class="title">
          <svg class="icon"><use href="#ic-tax"/></svg>
          Informasi PPh
          <span class="line"></span>
        </div>

        <!-- Period -->
        <div class="pe-form-group">
          <label>Periode <span class="required">*</span></label>
          <select name="period" required>
            @foreach($months as $month)
              @php
                $year = date('Y');
                $value = $month . ' ' . $year;
                $selected = ($tax['period'] == $value) ? 'selected' : '';
              @endphp
              <option value="{{ $value }}" {{ $selected }}>{{ $month }} {{ $year }}</option>
            @endforeach
          </select>
        </div>

        <!-- Gross & Deduction -->
        <div class="pe-form-row">
          <div class="pe-form-group">
            <label>Penghasilan Bruto <span class="required">*</span></label>
            <input type="number" name="gross" id="pe-gross" value="{{ $tax['gross'] }}" min="0" step="1000" required>
          </div>
          <div class="pe-form-group">
            <label>Pengurang / Potongan</label>
            <input type="number" name="deduction" id="pe-deduction" value="{{ $tax['deduction'] }}" min="0" step="1000">
            <span class="hint">Biaya jabatan, iuran pensiun, PTKP, dll.</span>
          </div>
        </div>

        <!-- Taxable preview -->
        <div class="pe-preview">
          <span class="label">Penghasilan Kena Pajak</span>
          <span class="value mono" id="pe-taxable-preview">{{ $currencySymbol }}{{ number_format(max($tax['gross'] - $tax['deduction'], 0), 0, ',', '.') }}</span>
        </div>

        <!-- Tax -->
        <div class="pe-form-group">
          <label>Pajak Terutang (PPh) <span class="required">*</span></label>
          <input type="number" name="tax" value="{{ $tax['tax'] }}" min="0" step="1000" required>
        </div>

        <!-- Due Date & Status -->
        <div class="pe-form-row">
          <div class="pe-form-group">
            <label>Jatuh Tempo <span class="required">*</span></label>
            <input type="date" name="due" value="{{ $tax['due'] }}" required>
          </div>
          <div class="pe-form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" required>
              <option value="pending" {{ $tax['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ $tax['status'] === 'paid' ? 'selected' : '' }}>Dibayar</option>
            </select>
          </div>
        </div>

        <!-- Notes -->
        <div class="pe-form-group">
          <label>Catatan</label>
          <textarea name="notes" placeholder="Catatan PPh...">{{ $tax['notes'] }}</textarea>
        </div>

        <!-- Actions -->
        <div class="pe-form-actions">
          <button type="button" class="pe-btn pe-btn-danger-ghost" onclick="openDeleteModal()">
            <svg class="icon"><use href="#ic-trash"/></svg>
            Hapus Data
          </button>
          <div class="right-actions">
            <a href="{{ route('taxes.pph') }}" class="pe-btn pe-btn-ghost">Batal</a>
            <button type="submit" class="pe-btn pe-btn-primary">
              <svg class="icon"><use href="#ic-check"/></svg>
              Simpan Perubahan
            </button>
          </div>
        </div>
      </div>
    </form>

  </div>

  <!-- ===== DELETE MODAL ===== -->
  <div class="pe-modal-overlay" id="deleteModal">
    <div class="pe-modal-box">
      <div class="pe-modal-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      </div>
      <h3>Hapus Data PPh?</h3>
      <p>Data PPh periode <strong>{{ $tax['period'] }}</strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
      <div class="pe-modal-actions">
        <button type="button" class="btn-outline" onclick="closeDeleteModal()">Batal</button>
        <form method="POST" action="{{ route('taxes.pph.destroy', $tax['id']) }}" style="flex:1;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-danger" style="width:100%;">Ya, Hapus</button>
        </form>
      </div>
    </div>
  </div>

  <!-- SVG Icons -->
  <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ic-arrow-right" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="ic-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="ic-tax" viewBox="0 0 24 24"><path d="M12 2L2 7v4c0 5.52 3.12 10.56 10 11 6.88-.44 10-5.48 10-11V7L12 2z"/><polyline points="12 11 12 17 16 17"/><line x1="8" y1="17" x2="16" y2="17"/></symbol>
    <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
  </svg>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const grossInput = document.getElementById('pe-gross');
      const deductionInput = document.getElementById('pe-deduction');
      const preview = document.getElementById('pe-taxable-preview');
      const currencySymbol = @json($currencySymbol);

      function updatePreview() {
        const gross = parseFloat(grossInput.value) || 0;
        const deduction = parseFloat(deductionInput.value) || 0;
        const taxable = Math.max(gross - deduction, 0);
        preview.textContent = currencySymbol + taxable.toLocaleString('id-ID');
      }
      grossInput.addEventListener('input', updatePreview);
      deductionInput.addEventListener('input', updatePreview);

      window.openDeleteModal = function () {
        document.getElementById('deleteModal').classList.add('active');
        document.body.style.overflow = 'hidden';
      };
      window.closeDeleteModal = function () {
        document.getElementById('deleteModal').classList.remove('active');
        document.body.style.overflow = '';
      };
      document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
      });
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDeleteModal();
      });
    });
  </script>

</x-app-layout>