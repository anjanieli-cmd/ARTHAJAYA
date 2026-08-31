<x-app-layout>
    <x-slot name="title">Chart of Accounts</x-slot>

    <style>
        .coa-wrap {
            --theme-primary: var(--warning);
            --theme-light: #F0A83C;
            --theme-dark: #d6902a;
            --theme-glow: rgba(240, 168, 60, 0.25);
            --theme-soft: rgba(240, 168, 60, 0.12);
            --theme-gradient: linear-gradient(135deg, #F0A83C, #d6902a);

            --text-primary: var(--text);
            --text-secondary: var(--text-mute);
            --text-tertiary: var(--text-faint);

            --bg-card: var(--surface);
            --bg-card-hover: var(--surface-strong);
            --border-color: var(--border);
            --border-hover: var(--border-hover);

            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;

            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .coa-wrap * { box-sizing: border-box; }
        .coa-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalSlideUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .coa-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        /* ===== HEADER ===== */
        .coa-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; flex-wrap: wrap; margin-bottom: 24px; padding: 0 4px; }
        .coa-header-left { flex: 1; min-width: 220px; }
        .coa-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px 6px 10px; background: var(--theme-glow); border: 1px solid var(--theme-glow); border-radius: 100px; font-size: 11px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--theme-primary); margin-bottom: 12px; }
        .coa-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--theme-primary); }
        .coa-header h1 { font-size: 28px; font-weight: 700; margin: 0 0 6px; letter-spacing: -0.02em; }
        .coa-header .subtitle { font-size: 14px; color: var(--text-secondary); margin: 0; }

        .coa-btn-add {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 22px; border-radius: var(--radius-sm);
            background: var(--theme-gradient); color: #fff;
            font-size: 13.5px; font-weight: 600; text-decoration: none;
            box-shadow: 0 4px 16px var(--theme-glow);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .coa-btn-add:hover { transform: translateY(-2px); box-shadow: 0 8px 28px var(--theme-glow); color: #fff; }

        /* ===== TOOLBAR: TABS + SEARCH ===== */
        .coa-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 18px; }

        .coa-tabs { display: flex; gap: 6px; flex-wrap: wrap; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 100px; padding: 4px; }
        .coa-tab {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 100px; font-size: 13px; font-weight: 600;
            color: var(--text-secondary); text-decoration: none; white-space: nowrap;
            transition: all 0.2s ease;
        }
        .coa-tab:hover { color: var(--text-primary); }
        .coa-tab.active { background: var(--theme-soft); color: var(--theme-primary); }
        .coa-tab .count { font-size: 11px; opacity: 0.75; }

        .coa-search { position: relative; min-width: 220px; }
        .coa-search input {
            width: 100%; padding: 10px 14px 10px 38px; border-radius: var(--radius-sm);
            border: 1.5px solid var(--border-color); background: var(--bg-card);
            color: var(--text-primary); font-size: 13.5px; font-family: inherit;
            transition: border-color 0.2s ease;
        }
        .coa-search input:focus { outline: none; border-color: var(--theme-primary); }
        .coa-search .icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-tertiary); }

        /* ===== TABLE ===== */
        .coa-table-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; }
        .coa-table { width: 100%; border-collapse: collapse; }
        .coa-table thead th {
            text-align: left; padding: 14px 20px; font-size: 11.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-tertiary);
            border-bottom: 1px solid var(--border-color); background: var(--bg-card-hover);
        }
        .coa-table tbody tr { border-bottom: 1px solid var(--border-color); transition: background 0.15s ease; }
        .coa-table tbody tr:last-child { border-bottom: none; }
        .coa-table tbody tr:hover { background: var(--bg-card-hover); }
        .coa-table td { padding: 16px 20px; font-size: 13.5px; vertical-align: middle; }

        .coa-code { font-family: 'IBM Plex Mono', monospace; font-weight: 600; color: var(--theme-primary); font-size: 13px; }
        .coa-name { font-weight: 600; color: var(--text-primary); }

        .coa-type-badge {
            display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 100px;
            font-size: 11.5px; font-weight: 600;
        }
        .coa-type-badge.asset { background: var(--success-soft); color: var(--success); }
        .coa-type-badge.liability { background: var(--danger-soft); color: var(--danger); }
        .coa-type-badge.equity { background: var(--info-soft); color: var(--info); }
        .coa-type-badge.revenue { background: var(--theme-soft); color: var(--theme-primary); }
        .coa-type-badge.expense { background: rgba(232, 90, 90, 0.08); color: #c96a6a; }

        .coa-balance-tag { font-size: 12px; color: var(--text-secondary); font-family: 'IBM Plex Mono', monospace; }

        .coa-status { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 600; }
        .coa-status .dot { width: 6px; height: 6px; border-radius: 50%; }
        .coa-status.active { color: var(--success); }
        .coa-status.active .dot { background: var(--success); }
        .coa-status.inactive { color: var(--text-tertiary); }
        .coa-status.inactive .dot { background: var(--text-tertiary); }

        .coa-row-actions { display: flex; gap: 8px; justify-content: flex-end; }
        .coa-icon-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border-color);
            background: var(--bg-card); color: var(--text-secondary); cursor: pointer; text-decoration: none;
            transition: all 0.2s ease;
        }
        .coa-icon-btn:hover { border-color: var(--theme-primary); color: var(--theme-primary); }
        .coa-icon-btn.danger:hover { border-color: var(--danger); color: var(--danger); background: var(--danger-soft); }
        .coa-icon-btn .icon { width: 15px; height: 15px; }

        .coa-empty { padding: 60px 20px; text-align: center; }
        .coa-empty .icon { width: 40px; height: 40px; color: var(--text-tertiary); margin-bottom: 14px; }
        .coa-empty p { font-size: 14px; color: var(--text-secondary); margin: 0 0 16px; }

        /* ===== ALERTS ===== */
        .coa-alert { display: flex; align-items: center; gap: 10px; padding: 14px 18px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 500; margin-bottom: 18px; }
        .coa-alert.success { background: var(--success-soft); color: var(--success); }
        .coa-alert.error { background: var(--danger-soft); color: var(--danger); }

        /* ===== DELETE MODAL ===== */
        .coa-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 999; align-items: center; justify-content: center; animation: modalFadeIn 0.25s ease; }
        .coa-modal-overlay.active { display: flex; }
        .coa-modal-box { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; max-width: 380px; width: 90%; text-align: center; animation: modalSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        .coa-modal-box h3 { font-size: 17px; font-weight: 700; margin: 12px 0 8px; }
        .coa-modal-box p { font-size: 13.5px; color: var(--text-secondary); margin: 0 0 20px; }
        .coa-modal-icon { width: 52px; height: 52px; border-radius: 50%; background: var(--danger-soft); color: var(--danger); display: flex; align-items: center; justify-content: center; margin: 0 auto; }
        .coa-modal-icon svg { width: 26px; height: 26px; }
        .coa-modal-actions { display: flex; gap: 10px; }
        .coa-modal-actions button, .coa-modal-actions .btn { flex: 1; padding: 11px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; }
        .coa-modal-actions .btn-outline { background: transparent; border: 1.5px solid var(--border-color); color: var(--text-secondary); }
        .coa-modal-actions .btn-danger { background: var(--danger); color: #fff; }

        @media (max-width: 768px) {
            .coa-wrap { padding: 0 16px; }
            .coa-header { flex-direction: column; }
            .coa-toolbar { flex-direction: column; align-items: stretch; }
            .coa-table thead { display: none; }
            .coa-table, .coa-table tbody, .coa-table tr, .coa-table td { display: block; width: 100%; }
            .coa-table tr { padding: 14px 20px; }
            .coa-table td { padding: 4px 0; border: none; }
            .coa-row-actions { justify-content: flex-start; margin-top: 10px; }
        }
    </style>

    <div class="coa-wrap">

        {{-- ===== HEADER ===== --}}
        <div class="coa-header animate-in" style="animation-delay: 0.05s;">
            <div class="coa-header-left">
                <div class="coa-badge"><span class="dot"></span> Chart of Accounts</div>
                <h1>Daftar Akun</h1>
                <p class="subtitle">Kelola akun yang dipakai di Buku Besar dan Neraca <strong>{{ $company->name ?? 'perusahaanmu' }}</strong></p>
            </div>
            <a href="{{ route('coa.create') }}" class="coa-btn-add">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Akun
            </a>
        </div>

        @if(session('success'))
            <div class="coa-alert success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="coa-alert error animate-in" style="animation-delay: 0.08s;">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ===== TOOLBAR ===== --}}
        <div class="coa-toolbar animate-in" style="animation-delay: 0.10s;">
            <div class="coa-tabs">
                <a href="{{ route('coa.index') }}" class="coa-tab {{ !$type ? 'active' : '' }}">
                    Semua <span class="count">{{ $counts->sum() }}</span>
                </a>
                @foreach(['asset' => 'Aset', 'liability' => 'Kewajiban', 'equity' => 'Modal', 'revenue' => 'Pendapatan', 'expense' => 'Beban'] as $key => $label)
                    <a href="{{ route('coa.index', ['type' => $key]) }}" class="coa-tab {{ $type === $key ? 'active' : '' }}">
                        {{ $label }} <span class="count">{{ $counts[$key] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
            <form method="GET" class="coa-search">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode atau nama akun...">
                @if($type)<input type="hidden" name="type" value="{{ $type }}">@endif
            </form>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="coa-table-card animate-in" style="animation-delay: 0.15s;">
            @if($accounts->isEmpty())
                <div class="coa-empty">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M4 9h16M9 4v16"/></svg>
                    <p>
                        @if($search || $type)
                            Nggak ada akun yang cocok dengan filter ini.
                        @else
                            Belum ada akun di Chart of Accounts. Tambahkan akun pertama untuk mulai mencatat transaksi.
                        @endif
                    </p>
                    <a href="{{ route('coa.create') }}" class="coa-btn-add">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Akun
                    </a>
                </div>
            @else
                <table class="coa-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Akun</th>
                            <th>Tipe</th>
                            <th>Saldo Normal</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $acc)
                            <tr>
                                <td><span class="coa-code">{{ $acc->code }}</span></td>
                                <td><span class="coa-name">{{ $acc->name }}</span></td>
                                <td>
                                    <span class="coa-type-badge {{ $acc->type }}">
                                        {{ ['asset' => 'Aset', 'liability' => 'Kewajiban', 'equity' => 'Modal', 'revenue' => 'Pendapatan', 'expense' => 'Beban'][$acc->type] }}
                                    </span>
                                </td>
                                <td><span class="coa-balance-tag">{{ $acc->normal_balance === 'debit' ? 'Debit' : 'Kredit' }}</span></td>
                                <td>
                                    <span class="coa-status {{ $acc->is_active ? 'active' : 'inactive' }}">
                                        <span class="dot"></span> {{ $acc->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="coa-row-actions">
                                        <a href="{{ route('coa.edit', $acc) }}" class="coa-icon-btn" title="Edit">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                        </a>
                                        <button type="button" class="coa-icon-btn danger" title="Hapus"
                                                onclick="openDeleteModal('{{ $acc->id }}', '{{ addslashes($acc->name) }}')">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                        <form id="delete-form-{{ $acc->id }}" action="{{ route('coa.destroy', $acc) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="coa-modal-overlay" id="deleteModal">
        <div class="coa-modal-box">
            <div class="coa-modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <h3>Hapus Akun?</h3>
            <p>Anda yakin ingin menghapus akun <strong id="deleteAccountName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="coa-modal-actions">
                <button type="button" class="btn-outline" onclick="closeDeleteModal()">Batal</button>
                <button type="button" class="btn-danger" onclick="confirmDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        let pendingDeleteId = null;

        function openDeleteModal(id, name) {
            pendingDeleteId = id;
            document.getElementById('deleteAccountName').textContent = name;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            pendingDeleteId = null;
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function confirmDelete() {
            if (pendingDeleteId) {
                document.getElementById('delete-form-' + pendingDeleteId).submit();
            }
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>

</x-app-layout>