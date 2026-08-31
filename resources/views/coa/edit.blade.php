<x-app-layout>
    <x-slot name="title">Edit Akun COA</x-slot>

    <style>
        .coa-edit-wrap {
            --theme-primary: var(--info);
            --theme-glow: rgba(78, 143, 240, 0.25);
            --theme-soft: rgba(78, 143, 240, 0.12);
            --theme-gradient: linear-gradient(135deg, #4E8FF0, #3a7ad4);

            --text-primary: var(--text);
            --text-secondary: var(--text-mute);
            --text-tertiary: var(--text-faint);

            --bg-card: var(--surface);
            --bg-card-hover: var(--surface-strong);
            --border-color: var(--border);
            --border-hover: var(--border-hover);

            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);

            --radius-sm: 10px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
            max-width: 720px;
            margin: 0 auto;
        }

        .coa-edit-wrap * { box-sizing: border-box; }
        .coa-edit-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalSlideUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .coa-edit-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        .coa-edit-header { margin-bottom: 24px; padding: 0 4px; }
        .coa-edit-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px 6px 10px; background: var(--theme-glow); border: 1px solid var(--theme-glow); border-radius: 100px; font-size: 11px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--theme-primary); margin-bottom: 12px; }
        .coa-edit-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--theme-primary); }
        .coa-edit-header h1 { font-size: 26px; font-weight: 700; margin: 0 0 6px; letter-spacing: -0.02em; }
        .coa-edit-header .subtitle { font-size: 14px; color: var(--text-secondary); margin: 0; }
        .coa-edit-header .subtitle strong { color: var(--theme-primary); }

        .coa-edit-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; position: relative; overflow: hidden; }
        .coa-edit-card .card-accent { position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--theme-gradient); }

        .coa-form-group { margin-bottom: 22px; }
        .coa-form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px; }
        .coa-form-group .required { color: var(--danger); margin-left: 2px; }
        .coa-form-group .optional { font-weight: 400; color: var(--text-tertiary); font-size: 12px; margin-left: 4px; }
        .coa-form-group input[type="text"], .coa-form-group select {
            width: 100%; padding: 12px 14px; border-radius: var(--radius-sm);
            border: 1.5px solid var(--border-color); background: var(--bg-card-hover);
            color: var(--text-primary); font-size: 14px; font-family: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .coa-form-group input[type="text"]:focus, .coa-form-group select:focus {
            outline: none; border-color: var(--theme-primary); box-shadow: 0 0 0 4px var(--theme-soft);
        }
        .coa-form-group input.code-input { font-family: 'IBM Plex Mono', monospace; letter-spacing: 0.02em; }
        .coa-form-hint { display: block; font-size: 12px; color: var(--text-tertiary); margin-top: 6px; }
        .coa-field-error { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--danger); margin-top: 6px; }

        .coa-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }

        .coa-type-picker { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; }
        .coa-type-option { position: relative; }
        .coa-type-option input { position: absolute; opacity: 0; }
        .coa-type-option label {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            padding: 12px 6px; border-radius: var(--radius-sm); border: 1.5px solid var(--border-color);
            background: var(--bg-card-hover); cursor: pointer; text-align: center; margin: 0;
            font-size: 12px; font-weight: 600; color: var(--text-secondary);
            transition: all 0.2s ease;
        }
        .coa-type-option input:checked + label { border-color: var(--theme-primary); background: var(--theme-soft); color: var(--theme-primary); }

        .coa-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: var(--bg-card-hover); border-radius: var(--radius-sm); border: 1.5px solid var(--border-color); }
        .coa-toggle-row .label-text { font-size: 13.5px; font-weight: 600; }
        .coa-toggle-row .label-sub { font-size: 12px; color: var(--text-tertiary); margin-top: 2px; }
        .coa-switch { position: relative; width: 42px; height: 24px; flex-shrink: 0; }
        .coa-switch input { opacity: 0; width: 0; height: 0; }
        .coa-switch .slider { position: absolute; inset: 0; background: var(--border-color); border-radius: 100px; cursor: pointer; transition: 0.2s; }
        .coa-switch .slider:before { content: ""; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: 0.2s; }
        .coa-switch input:checked + .slider { background: var(--theme-primary); }
        .coa-switch input:checked + .slider:before { transform: translateX(18px); }

        .coa-actions { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-top: 28px; flex-wrap: wrap; }
        .coa-actions .right-actions { display: flex; gap: 10px; }
        .coa-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; font-family: inherit; transition: all 0.2s ease; }
        .coa-btn-primary { background: var(--theme-gradient); color: #fff; box-shadow: 0 4px 16px var(--theme-glow); }
        .coa-btn-primary:hover { transform: translateY(-2px); color: #fff; }
        .coa-btn-outline { background: var(--bg-card); border: 1.5px solid var(--border-color); color: var(--text-secondary); }
        .coa-btn-outline:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .coa-btn-danger-ghost { background: transparent; border: 1.5px solid var(--danger-soft); color: var(--danger); }
        .coa-btn-danger-ghost:hover { background: var(--danger-soft); }

        /* ===== DELETE MODAL ===== */
        .coa-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 999; align-items: center; justify-content: center; animation: modalFadeIn 0.25s ease; }
        .coa-modal-overlay.active { display: flex; }
        .coa-modal-box { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; max-width: 380px; width: 90%; text-align: center; animation: modalSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        .coa-modal-box h3 { font-size: 17px; font-weight: 700; margin: 12px 0 8px; }
        .coa-modal-box p { font-size: 13.5px; color: var(--text-secondary); margin: 0 0 20px; }
        .coa-modal-icon { width: 52px; height: 52px; border-radius: 50%; background: var(--danger-soft); color: var(--danger); display: flex; align-items: center; justify-content: center; margin: 0 auto; }
        .coa-modal-icon svg { width: 26px; height: 26px; }
        .coa-modal-actions { display: flex; gap: 10px; }
        .coa-modal-actions button { flex: 1; padding: 11px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; }
        .coa-modal-actions .btn-outline { background: transparent; border: 1.5px solid var(--border-color); color: var(--text-secondary); }
        .coa-modal-actions .btn-danger { background: var(--danger); color: #fff; }

        @media (max-width: 640px) {
            .coa-edit-wrap { padding: 0 16px; }
            .coa-edit-card { padding: 22px; }
            .coa-row-2 { grid-template-columns: 1fr; }
            .coa-type-picker { grid-template-columns: repeat(3, 1fr); }
            .coa-actions { flex-direction: column-reverse; align-items: stretch; }
            .coa-actions .right-actions { flex-direction: column-reverse; }
            .coa-actions .coa-btn { width: 100%; justify-content: center; }
        }
    </style>

    <div class="coa-edit-wrap">

        <div class="coa-edit-header animate-in" style="animation-delay: 0.05s;">
            <div class="coa-edit-badge"><span class="dot"></span> Edit Akun</div>
            <h1>Edit Akun COA</h1>
            <p class="subtitle">Mengubah akun <strong>{{ $account->code }} — {{ $account->name }}</strong></p>
        </div>

        <form method="POST" action="{{ route('coa.update', $account) }}" class="animate-in" style="animation-delay: 0.10s;">
            @csrf
            @method('PUT')

            <div class="coa-edit-card">
                <div class="card-accent"></div>

                <div class="coa-row-2">
                    <div class="coa-form-group">
                        <label for="code">Kode Akun <span class="required">*</span></label>
                        <input type="text" class="code-input" name="code" id="code" value="{{ old('code', $account->code) }}" required>
                        @error('code')<span class="coa-field-error">⚠ {{ $message }}</span>@enderror
                    </div>
                    <div class="coa-form-group">
                        <label for="name">Nama Akun <span class="required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $account->name) }}" required>
                        @error('name')<span class="coa-field-error">⚠ {{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="coa-form-group">
                    <label>Tipe Akun <span class="required">*</span></label>
                    <div class="coa-type-picker">
                        @foreach(['asset' => 'Aset', 'liability' => 'Kewajiban', 'equity' => 'Modal', 'revenue' => 'Pendapatan', 'expense' => 'Beban'] as $key => $label)
                            <div class="coa-type-option">
                                <input type="radio" name="type" id="type_{{ $key }}" value="{{ $key }}"
                                       data-normal="{{ in_array($key, ['asset', 'expense']) ? 'debit' : 'credit' }}"
                                       {{ old('type', $account->type) === $key ? 'checked' : '' }} required>
                                <label for="type_{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('type')<span class="coa-field-error">⚠ {{ $message }}</span>@enderror
                </div>

                <div class="coa-form-group">
                    <label for="normal_balance">Saldo Normal <span class="required">*</span></label>
                    <select name="normal_balance" id="normal_balance" required>
                        <option value="debit" {{ old('normal_balance', $account->normal_balance) === 'debit' ? 'selected' : '' }}>Debit</option>
                        <option value="credit" {{ old('normal_balance', $account->normal_balance) === 'credit' ? 'selected' : '' }}>Kredit</option>
                    </select>
                    <span class="coa-form-hint">Mengubah ini akan mempengaruhi arah perhitungan saldo berjalan di Buku Besar & Neraca.</span>
                    @error('normal_balance')<span class="coa-field-error">⚠ {{ $message }}</span>@enderror
                </div>

                <div class="coa-form-group" style="margin-bottom:0;">
                    <div class="coa-toggle-row">
                        <div>
                            <div class="label-text">Akun Aktif</div>
                            <div class="label-sub">Akun nonaktif tidak akan muncul di dropdown Buku Besar</div>
                        </div>
                        <label class="coa-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div class="coa-actions">
                    <button type="button" class="coa-btn coa-btn-danger-ghost" onclick="openDeleteModal()">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        Hapus Akun
                    </button>
                    <div class="right-actions">
                        <a href="{{ route('coa.index') }}" class="coa-btn coa-btn-outline">Batal</a>
                        <button type="submit" class="coa-btn coa-btn-primary">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="coa-modal-overlay" id="deleteModal">
        <div class="coa-modal-box">
            <div class="coa-modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <h3>Hapus Akun?</h3>
            <p>Anda yakin ingin menghapus akun <strong>{{ $account->code }} — {{ $account->name }}</strong>? Kalau akun ini sudah punya transaksi di Buku Besar, penghapusan akan ditolak otomatis.</p>
            <div class="coa-modal-actions">
                <button type="button" class="btn-outline" onclick="closeDeleteModal()">Batal</button>
                <form method="POST" action="{{ route('coa.destroy', $account) }}" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" style="width:100%;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeInputs = document.querySelectorAll('input[name="type"]');
            const normalSelect = document.getElementById('normal_balance');

            typeInputs.forEach(function (input) {
                input.addEventListener('change', function () {
                    if (this.checked) {
                        normalSelect.value = this.dataset.normal;
                    }
                });
            });

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