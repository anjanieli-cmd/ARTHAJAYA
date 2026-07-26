<x-app-layout>
    <x-slot name="title">Multi-User & Hak Akses</x-slot>

    @php
        // Data dummy untuk stats
        $stats = $stats ?? [
            'total_count' => 12,
            'active_count' => 8,
            'invited_count' => 3,
            'suspended_count' => 1,
        ];

        // Data dummy untuk members
        $members = $members ?? collect([
            (object) [
                'id' => 1,
                'name' => 'Andi Pratama',
                'email' => 'andi@company.com',
                'role' => 'Admin',
                'status' => 'active',
                'permission_count' => 12
            ],
            (object) [
                'id' => 2,
                'name' => 'Budi Santoso',
                'email' => 'budi@company.com',
                'role' => 'Manager',
                'status' => 'active',
                'permission_count' => 8
            ],
            (object) [
                'id' => 3,
                'name' => 'Citra Dewi',
                'email' => 'citra@company.com',
                'role' => 'Staff',
                'status' => 'invited',
                'permission_count' => 5
            ],
            (object) [
                'id' => 4,
                'name' => 'Dian Sastro',
                'email' => 'dian@company.com',
                'role' => 'Viewer',
                'status' => 'active',
                'permission_count' => 3
            ],
            (object) [
                'id' => 5,
                'name' => 'Eko Nugroho',
                'email' => 'eko@company.com',
                'role' => 'Staff',
                'status' => 'suspended',
                'permission_count' => 0
            ],
        ]);

        $roleLabel = [
            'Admin' => 'Admin',
            'Manager' => 'Manager',
            'Staff' => 'Staff',
            'Viewer' => 'Viewer'
        ];
        $roleColor = [
            'Admin' => 'admin',
            'Manager' => 'manager',
            'Staff' => 'staff',
            'Viewer' => 'viewer'
        ];
        $statusLabel = [
            'active' => 'Aktif',
            'invited' => 'Menunggu Konfirmasi',
            'suspended' => 'Ditangguhkan'
        ];
        $statusPill = [
            'active' => 'active',
            'invited' => 'invited',
            'suspended' => 'suspended'
        ];
    @endphp

    <style>
        /* ============================================
           MULTI-USER & HAK AKSES - Modern Design
           ============================================ */
        
        .team-wrap {
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
            
            --success: #34B583;
            --success-soft: rgba(52, 181, 131, 0.14);
            --warning: #F0A83C;
            --warning-soft: rgba(240, 168, 60, 0.14);
            --danger: #E85A5A;
            --danger-soft: rgba(232, 90, 90, 0.12);
            --danger-rgb: 232, 90, 90;
            --info: #4E8FF0;
            --info-soft: rgba(78, 143, 240, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            padding: 0 24px;
        }

        .team-wrap * { box-sizing: border-box; }
        .team-wrap .mono { font-family: 'IBM Plex Mono', monospace; font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .team-wrap .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .team-wrap .icon { width: 18px; height: 18px; flex-shrink: 0; display: inline-block; vertical-align: middle; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* HEADER */
        .team-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .team-header-left { flex: 1; min-width: 200px; }

        .team-badge {
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

        .team-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--theme-primary);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .team-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
            background: linear-gradient(135deg, var(--text) 60%, var(--theme-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .team-header .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .team-header .subtitle strong { color: var(--text-primary); font-weight: 600; }

        .team-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .team-btn {
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
            font-family: 'Inter', sans-serif;
        }

        .team-btn .icon { width: 16px; height: 16px; }
        .team-btn:hover { transform: translateY(-2px); }
        .team-btn:active { transform: translateY(0) scale(0.97); }

        .team-btn-primary {
            background: var(--theme-gradient);
            color: #fff;
            box-shadow: 0 4px 16px var(--theme-glow);
        }

        .team-btn-primary:hover {
            box-shadow: 0 8px 28px var(--theme-glow);
            transform: translateY(-2px);
            color: #fff;
        }

        .team-btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .team-btn-ghost:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .team-btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        }

        /* SUCCESS MESSAGE */
        .team-success {
            background: var(--success-soft);
            border: 1px solid var(--success);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
            margin-bottom: 20px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .team-success .icon {
            width: 20px;
            height: 20px;
        }

        .team-success .message {
            font-weight: 500;
        }

        /* SEARCH BAR */
        .team-search {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .team-search:focus-within {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px var(--theme-soft);
        }

        .team-search form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .team-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .team-search-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .team-search-wrap:focus-within .icon {
            color: var(--theme-primary);
        }

        .team-search input[type="text"] {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid transparent;
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .team-search input[type="text"]:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .team-search input[type="text"]::placeholder {
            color: var(--text-tertiary);
        }

        /* SELECT DROPDOWN WITH ICON */
        .team-search-select-wrap {
            position: relative;
            min-width: 160px;
        }

        .team-search-select-wrap .icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .team-search-select {
            width: 100%;
            padding: 10px 40px 10px 14px;
            border-radius: var(--radius-sm);
            background: var(--bg-card-active);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .team-search-select:focus {
            border-color: var(--theme-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(var(--emerald-rgb), 0.1);
        }

        .team-search-select option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .team-search-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .team-search-actions .team-btn {
            padding: 8px 14px;
            font-size: 12px;
        }

        /* SEARCH INDICATOR */
        .search-indicator {
            font-size: 12px;
            color: var(--text-tertiary);
            padding: 4px 12px;
            background: var(--bg-card-active);
            border-radius: 20px;
            white-space: nowrap;
            display: none;
            align-items: center;
            gap: 6px;
        }

        .search-indicator.active {
            display: inline-flex;
        }

        .search-indicator .count {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* STATS */
        .team-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .team-stat {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .team-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--theme-light), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .team-stat:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .team-stat:hover::before {
            opacity: 1;
        }

        .team-stat .number {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .team-stat .number.purple { color: var(--theme-primary); }
        .team-stat .number.green { color: var(--success); }
        .team-stat .number.blue { color: var(--info); }
        .team-stat .number.red { color: var(--danger); }

        .team-stat .label {
            font-size: 11px;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }

        /* MEMBER LIST */
        .team-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .team-list.loading {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .team-member {
            display: flex;
            align-items: center;
            gap: 16px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            transition: all 0.3s ease;
            position: relative;
        }

        .team-member:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateX(4px);
        }

        .team-member.hidden-member {
            display: none;
        }

        .team-member.visible-member {
            display: flex;
            animation: fadeSlideUp 0.3s ease forwards;
        }

        .team-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            color: #fff;
            flex-shrink: 0;
        }

        .team-info {
            flex: 1;
            min-width: 0;
        }

        .team-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-primary);
        }

        .team-email {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 1px;
        }

        .team-tags {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .team-role-pill {
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .team-role-pill.admin {
            background: var(--theme-soft);
            color: var(--theme-primary);
        }

        .team-role-pill.manager {
            background: var(--info-soft);
            color: var(--info);
        }

        .team-role-pill.staff {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .team-role-pill.viewer {
            background: var(--bg-card-active);
            color: var(--text-tertiary);
        }

        .team-status-pill {
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .team-status-pill.active {
            background: var(--success-soft);
            color: var(--success);
        }

        .team-status-pill.invited {
            background: var(--info-soft);
            color: var(--info);
        }

        .team-status-pill.suspended {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .team-perm-count {
            font-size: 11px;
            color: var(--text-tertiary);
            white-space: nowrap;
            padding: 3px 8px;
            background: var(--bg-card-active);
            border-radius: 6px;
        }

        .team-perm-count strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* ============================================
           ACTION BUTTONS - ICON ONLY
           ============================================ */
        .team-actions-buttons {
            display: flex;
            gap: 4px;
            flex-shrink: 0;
        }

        .team-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--border-color);
            background: var(--bg-card-active);
            color: var(--text-secondary);
            transition: all 0.15s ease;
            cursor: pointer;
            width: 32px;
            height: 32px;
        }

        .team-action-btn .icon {
            width: 14px;
            height: 14px;
        }

        .team-action-btn:hover {
            background: var(--bg-card);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .team-action-btn.show:hover {
            color: var(--theme-primary);
            border-color: var(--theme-glow);
            background: var(--theme-soft);
        }

        .team-action-btn.edit:hover {
            color: #3b82f6;
            border-color: rgba(59, 130, 246, 0.3);
            background: rgba(59, 130, 246, 0.1);
        }

        .team-action-btn.delete {
            color: var(--danger);
            border-color: rgba(232, 90, 90, 0.2);
        }

        .team-action-btn.delete:hover {
            background: var(--danger-soft);
            border-color: rgba(232, 90, 90, 0.4);
        }

        /* EMPTY */
        .team-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 2px dashed var(--border-color);
        }

        .team-empty .empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            color: var(--theme-primary);
            opacity: 0.5;
        }

        .team-empty h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 6px;
            color: var(--text-primary);
        }

        .team-empty p {
            color: var(--text-secondary);
            margin: 0 0 20px;
            font-size: 14px;
        }

        .team-empty.hidden {
            display: none;
        }

        /* ============================================================
           PAGINATION - Compact
           ============================================================ */
        .team-pagination {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .team-pagination .info {
            font-size: 12px;
            color: var(--text-tertiary);
        }

        .team-pagination .links {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .team-pagination .links nav {
            display: flex;
            gap: 4px;
        }

        .team-pagination .links nav a,
        .team-pagination .links nav span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .team-pagination .links nav a:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .team-pagination .links nav span[aria-current="page"] {
            background: var(--theme-primary);
            color: #fff;
            border-color: var(--theme-primary);
        }

        .team-pagination .links nav .disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ============================================================
           MODAL DELETE - SAME AS KALENDER PAJAK
           ============================================================ */
        .team-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: modalFadeIn 0.3s ease;
        }

        .team-modal-overlay.active { display: flex; }

        [data-theme="dark"] .team-modal-box { 
            background: #0F1520; 
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="light"] .team-modal-box { 
            background: #FFFFFF; 
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .team-modal-box {
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 32px 36px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        [data-theme="light"] .team-modal-box {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
        }

        .team-modal-box .icon-danger {
            width: 56px;
            height: 56px;
            background: #FEE2E2;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-theme="dark"] .team-modal-box .icon-danger {
            background: rgba(220, 38, 38, 0.2);
        }

        .team-modal-box .icon-danger svg {
            width: 28px;
            height: 28px;
            stroke: #DC2626;
        }

        [data-theme="dark"] .team-modal-box .icon-danger svg {
            stroke: #F87171;
        }

        .team-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .team-modal-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 4px 0;
            line-height: 1.6;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .team-modal-box .team-desc-text {
            font-weight: 700;
            color: var(--text-primary);
            background: var(--bg-card-active);
            padding: 4px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-size: 15px;
        }

        .team-modal-box .warning-text {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
            margin-top: 16px;
            padding: 10px 16px;
            background: #FEE2E2;
            border-radius: 10px;
            display: inline-block;
        }

        [data-theme="dark"] .team-modal-box .warning-text {
            color: #F87171;
            background: rgba(220, 38, 38, 0.15);
        }

        .team-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }

        .team-modal-actions .btn {
            min-width: 100px;
            justify-content: center;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .team-modal-actions .btn .icon {
            width: 16px;
            height: 16px;
        }

        .team-modal-actions .btn-outline {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .team-modal-actions .btn-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .team-modal-actions .btn-danger {
            background: #DC2626;
            color: #fff;
        }

        .team-modal-actions .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
        }

        [data-theme="dark"] .team-modal-actions .btn-danger {
            background: #DC2626;
        }

        [data-theme="dark"] .team-modal-actions .btn-danger:hover {
            background: #B91C1C;
        }

        /* CSS UNTUK NAVBAR TIDAK KE-BLUR */
        body.aj-modal-open main {
            position: relative;
            z-index: 9998;
        }

        body.aj-modal-open .sidebar,
        body.aj-modal-open .topbar {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        body.aj-modal-open .sidebar *,
        body.aj-modal-open .topbar * {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .team-stats { grid-template-columns: 1fr 1fr; }
            .team-wrap { padding: 0 16px; }
        }

        @media (max-width: 768px) {
            .team-wrap { padding: 0 12px; }
            .team-member {
                flex-wrap: wrap;
                gap: 10px;
                padding: 12px 14px;
            }
            .team-tags {
                width: 100%;
                justify-content: flex-start;
            }
            .team-actions-buttons {
                width: 100%;
                justify-content: flex-start;
            }
            .team-search { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 10px; 
                padding: 12px 16px;
            }
            .team-search form { flex-direction: column; }
            .team-search-wrap { min-width: 100%; }
            .team-search-select-wrap { width: 100%; }
            .team-search-actions { 
                width: 100%; 
                justify-content: flex-end; 
                flex-wrap: wrap;
            }
            .team-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .team-stat .number { font-size: 20px; }
            .team-pagination { flex-direction: column; align-items: center; text-align: center; }
            .team-pagination .links { justify-content: center; flex-wrap: wrap; }
            .team-modal-box { padding: 24px 20px; margin: 10px; }
            .team-modal-actions { flex-direction: column; }
            .team-modal-actions .btn { width: 100%; }
        }

        @media (max-width: 640px) {
            .team-wrap { padding: 0 8px; }
            .team-header { flex-direction: column; }
            .team-actions { width: 100%; }
            .team-actions .team-btn { flex: 1; justify-content: center; font-size: 12px; padding: 8px 12px; }
            .team-stats { grid-template-columns: 1fr; gap: 12px; }
            .team-avatar { width: 36px; height: 36px; font-size: 13px; border-radius: 8px; }
            .team-modal-box { padding: 20px 16px; }
            .team-modal-box h3 { font-size: 18px; }
            .team-modal-box .icon-danger { width: 48px; height: 48px; }
            .team-modal-box .icon-danger svg { width: 24px; height: 24px; }
            .team-pagination .links nav a,
            .team-pagination .links nav span {
                min-width: 28px;
                height: 28px;
                font-size: 11px;
                padding: 0 8px;
            }
        }

        @media (max-width: 380px) {
            .team-wrap { padding: 0 4px; }
            .team-header h1 { font-size: 22px; }
            .team-btn { font-size: 11px; padding: 6px 10px; }
            .team-btn .icon { width: 13px; height: 13px; }
            .team-member { padding: 10px 12px; }
            .team-name { font-size: 13px; }
            .team-email { font-size: 11px; }
            .team-role-pill { font-size: 9px; padding: 2px 8px; }
            .team-status-pill { font-size: 9px; padding: 2px 8px; }
            .team-perm-count { font-size: 10px; padding: 2px 6px; }
        }
    </style>

    <div class="team-wrap">

        <!-- ===== HEADER ===== -->
        <div class="team-header animate-in" style="animation-delay: 0.05s;">
            <div class="team-header-left">
                <div class="team-badge">
                    <span class="dot"></span>
                    Tim & Akses
                </div>
                <h1>Multi-User & Hak Akses</h1>
                <p class="subtitle">
                    Kelola anggota tim dan tentukan hak akses masing-masing — 
                    <strong id="teamTotalCount">{{ $stats['total_count'] }}</strong> anggota
                </p>
            </div>
            <div class="team-actions">
                <a href="{{ route('team-members.create') }}" class="team-btn team-btn-primary">
                    <svg class="icon"><use href="#ic-plus"/></svg>
                    Undang Anggota
                </a>
            </div>
        </div>

        <!-- ===== SUCCESS MESSAGE ===== -->
        @if(session('success'))
            <div class="team-success animate-in" style="animation-delay: 0.08s;">
                <svg class="icon"><use href="#ic-check-circle"/></svg>
                <span class="message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ===== SEARCH BAR ===== -->
        <div class="team-search animate-in" style="animation-delay: 0.10s;">
            <form method="GET" action="{{ route('team-members.index') }}" id="teamSearchForm" onsubmit="return false;">
                <div class="team-search-wrap">
                    <svg class="icon"><use href="#ic-search"/></svg>
                    <input type="text" name="q" id="teamSearchInput" value="{{ request('q') }}" 
                           placeholder="Cari nama atau email..." autocomplete="off">
                </div>
                
                <div class="team-search-select-wrap">
                    <select name="role" id="teamRoleFilter" class="team-search-select">
                        <option value="">Semua Role</option>
                        @foreach(['Admin','Manager','Staff','Viewer'] as $r)
                            <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                    <svg class="icon"><use href="#ic-chevron-down"/></svg>
                </div>

                <div class="team-search-actions">
                    <span class="search-indicator" id="searchIndicator">
                        <span class="count" id="searchResultCount">0</span> hasil ditemukan
                    </span>
                    <a href="#" class="team-btn team-btn-ghost" id="teamResetBtn">
                        <svg class="icon"><use href="#ic-x"/></svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- ===== STATS ===== -->
        <div class="team-stats animate-in" style="animation-delay: 0.12s;" id="teamStats">
            <div class="team-stat">
                <div class="number purple mono" id="statTotal">{{ $stats['total_count'] }}</div>
                <div class="label">Total Anggota</div>
            </div>
            <div class="team-stat">
                <div class="number green mono" id="statActive">{{ $stats['active_count'] }}</div>
                <div class="label">Aktif</div>
            </div>
            <div class="team-stat">
                <div class="number blue mono" id="statInvited">{{ $stats['invited_count'] }}</div>
                <div class="label">Menunggu Konfirmasi</div>
            </div>
            <div class="team-stat">
                <div class="number red mono" id="statSuspended">{{ $stats['suspended_count'] }}</div>
                <div class="label">Ditangguhkan</div>
            </div>
        </div>

        <!-- ===== MEMBER LIST ===== -->
        <div class="team-list" id="teamList">
            @forelse($members as $member)
                @php
                    $colors = ['#34B583', '#4E8FF0', '#F0A83C', '#E85A5A', '#9B7BE0', '#EC4C93'];
                    $color = $colors[($loop->index) % count($colors)];
                    
                    // Get permission count safely
                    if (method_exists($member, 'permissionCount')) {
                        $permCount = $member->permissionCount();
                    } elseif (isset($member->permission_count)) {
                        $permCount = $member->permission_count;
                    } elseif (isset($member->permissionCount)) {
                        $permCount = is_callable($member->permissionCount) ? $member->permissionCount() : $member->permissionCount;
                    } else {
                        $permCount = 0;
                    }
                @endphp
                <div class="team-member team-member-data visible-member animate-in" 
                     style="animation-delay: {{ 0.15 + ($loop->index * 0.04) }}s;"
                     data-name="{{ strtolower($member->name) }}"
                     data-email="{{ strtolower($member->email) }}"
                     data-role="{{ $member->role }}"
                     data-status="{{ $member->status }}">
                    
                    <div class="team-avatar" style="background: {{ $color }}; color: #fff;">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    
                    <div class="team-info">
                        <div class="team-name">{{ $member->name }}</div>
                        <div class="team-email">{{ $member->email }}</div>
                    </div>
                    
                    <div class="team-tags">
                        <span class="team-role-pill {{ $roleColor[$member->role] ?? 'viewer' }}">{{ $roleLabel[$member->role] ?? $member->role }}</span>
                        <span class="team-status-pill {{ $statusPill[$member->status] ?? 'invited' }}">{{ $statusLabel[$member->status] ?? $member->status }}</span>
                        <span class="team-perm-count"><strong>{{ $permCount }}</strong> hak akses</span>
                    </div>
                    
                    <!-- ===== ACTION BUTTONS - ICON ONLY ===== -->
                    <div class="team-actions-buttons">
                        <a href="{{ route('team-members.show', $member->id) }}" class="team-action-btn show" title="Lihat Detail">
                            <svg class="icon"><use href="#ic-eye"/></svg>
                        </a>
                        <a href="{{ route('team-members.edit', $member->id) }}" class="team-action-btn edit" title="Kelola Hak Akses">
                            <svg class="icon"><use href="#ic-edit"/></svg>
                        </a>
                        <button type="button" class="team-action-btn delete" title="Hapus Anggota" onclick="openDeleteModal('{{ $member->id }}', '{{ addslashes($member->name) }}')">
                            <svg class="icon"><use href="#ic-trash"/></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="team-empty" id="emptyState">
                    <svg class="empty-icon"><use href="#ic-users"/></svg>
                    <h3>Belum Ada Anggota Tim</h3>
                    <p>Undang rekan kerja untuk mulai berkolaborasi.</p>
                    <a href="{{ route('team-members.create') }}" class="team-btn team-btn-primary" style="display: inline-flex;">
                        <svg class="icon"><use href="#ic-plus"/></svg>
                        Undang Anggota
                    </a>
                </div>
            @endforelse
        </div>

        <!-- ===== PAGINATION - Compact ===== -->
        @if(isset($members) && method_exists($members, 'links'))
            <div class="team-pagination animate-in" style="animation-delay: 0.20s;">
                <div class="info">
                    Menampilkan {{ $members->firstItem() ?? 0 }} - {{ $members->lastItem() ?? 0 }} dari {{ $members->total() }} anggota
                </div>
                <div class="links">
                    {{ $members->onEachSide(1)->links() }}
                </div>
            </div>
        @endif

    </div>

    <!-- ============================================================
         MODAL DELETE - SAME AS KALENDER PAJAK
         ============================================================ -->
    <div class="team-modal-overlay" id="deleteModal">
        <div class="team-modal-box">
            <div class="icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <h3>Hapus Anggota?</h3>

            <p>
                Anda yakin ingin menghapus anggota
                <br>
                <span class="team-desc-text" id="deleteDesc">-</span>
            </p>

            <div class="warning-text">
                ⚠️ Data yang dihapus tidak dapat dikembalikan!
            </div>

            <div class="team-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== SVG ICONS ===== -->
    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <symbol id="ic-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
        <symbol id="ic-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
        <symbol id="ic-chevron-down" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></symbol>
        <symbol id="ic-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
        <symbol id="ic-check-circle" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
        <symbol id="ic-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
        <symbol id="ic-edit" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></symbol>
        <symbol id="ic-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
        <symbol id="ic-users" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
        <symbol id="ic-alert-triangle" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
    </svg>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== RIPPLE EFFECT =====
            const buttons = document.querySelectorAll('.team-btn, .team-action-btn, .btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        return;
                    }
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // ===== DELETE MODAL =====
            window.openDeleteModal = function(id, name) {
                document.getElementById('deleteDesc').textContent = name;
                document.getElementById('deleteForm').action = '{{ url("team-members") }}/' + id;
                document.getElementById('deleteModal').classList.add('active');
                document.body.style.overflow = 'hidden';
                document.body.classList.add('aj-modal-open');
            };

            window.closeDeleteModal = function() {
                document.getElementById('deleteModal').classList.remove('active');
                document.body.style.overflow = '';
                document.body.classList.remove('aj-modal-open');
            };

            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                }
            });

            // ===== LIVE SEARCH =====
            const searchInput = document.getElementById('teamSearchInput');
            const roleFilter = document.getElementById('teamRoleFilter');
            const resetBtn = document.getElementById('teamResetBtn');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchResultCount = document.getElementById('searchResultCount');
            const totalCountEl = document.getElementById('teamTotalCount');
            const statTotal = document.getElementById('statTotal');
            const statActive = document.getElementById('statActive');
            const statInvited = document.getElementById('statInvited');
            const statSuspended = document.getElementById('statSuspended');
            const teamList = document.getElementById('teamList');
            const emptyState = document.getElementById('emptyState');
            let debounceTimeout = null;

            function normalizeText(text) {
                if (!text) return '';
                return text.toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .trim();
            }

            function filterData() {
                const searchText = searchInput ? searchInput.value.trim() : '';
                const selectedRole = roleFilter ? roleFilter.value : '';
                const normalizedSearch = normalizeText(searchText);

                const members = document.querySelectorAll('.team-member-data');
                let visibleCount = 0;
                let activeCount = 0;
                let invitedCount = 0;
                let suspendedCount = 0;

                members.forEach(member => {
                    const name = member.dataset.name || '';
                    const email = member.dataset.email || '';
                    const role = member.dataset.role || '';
                    const status = member.dataset.status || '';

                    const matchSearch = searchText === '' || 
                        normalizeText(name).includes(normalizedSearch) ||
                        normalizeText(email).includes(normalizedSearch);

                    const matchRole = selectedRole === '' || role === selectedRole;

                    const match = matchSearch && matchRole;

                    if (match) {
                        member.classList.remove('hidden-member');
                        member.classList.add('visible-member');
                        visibleCount++;
                        if (status === 'active') activeCount++;
                        else if (status === 'invited') invitedCount++;
                        else if (status === 'suspended') suspendedCount++;
                    } else {
                        member.classList.remove('visible-member');
                        member.classList.add('hidden-member');
                    }
                });

                // Update search indicator
                if (searchText !== '' || selectedRole !== '') {
                    searchIndicator.classList.add('active');
                    searchResultCount.textContent = visibleCount;
                } else {
                    searchIndicator.classList.remove('active');
                }

                // Update stats
                const totalVisible = visibleCount;
                statTotal.textContent = totalVisible;
                statActive.textContent = activeCount;
                statInvited.textContent = invitedCount;
                statSuspended.textContent = suspendedCount;
                totalCountEl.textContent = totalVisible;

                // Show/hide empty state
                if (emptyState) {
                    if (totalVisible === 0 && (searchText !== '' || selectedRole !== '')) {
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Tidak Ada Hasil Pencarian';
                        emptyState.querySelector('p').textContent = 'Tidak ditemukan anggota yang sesuai dengan filter yang dipilih.';
                        const btn = emptyState.querySelector('.team-btn');
                        if (btn) btn.style.display = 'none';
                    } else if (totalVisible === 0) {
                        emptyState.classList.remove('hidden');
                        emptyState.querySelector('h3').textContent = 'Belum Ada Anggota Tim';
                        emptyState.querySelector('p').textContent = 'Undang rekan kerja untuk mulai berkolaborasi.';
                        const btn = emptyState.querySelector('.team-btn');
                        if (btn) btn.style.display = 'inline-flex';
                    } else {
                        emptyState.classList.add('hidden');
                    }
                }
            }

            // Search input
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    teamList.style.opacity = '0.5';
                    teamList.style.pointerEvents = 'none';

                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(function() {
                        filterData();
                        teamList.style.opacity = '1';
                        teamList.style.pointerEvents = 'auto';

                        const url = new URL(window.location.href);
                        if (searchInput.value.trim() !== '') {
                            url.searchParams.set('q', searchInput.value.trim());
                        } else {
                            url.searchParams.delete('q');
                        }
                        window.history.replaceState({}, '', url.toString());
                    }, 300);
                });

                // Keyboard shortcuts: Cmd+K or Ctrl+K
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                    if (e.key === '/' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        const activeElement = document.activeElement;
                        if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA')) {
                            return;
                        }
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                });
            }

            // Role filter
            if (roleFilter) {
                roleFilter.addEventListener('change', function() {
                    filterData();
                    
                    const url = new URL(window.location.href);
                    if (this.value !== '') {
                        url.searchParams.set('role', this.value);
                    } else {
                        url.searchParams.delete('role');
                    }
                    window.history.replaceState({}, '', url.toString());
                });
            }

            // Reset button
            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchInput) searchInput.value = '';
                    if (roleFilter) roleFilter.value = '';
                    filterData();

                    const url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    url.searchParams.delete('role');
                    window.history.replaceState({}, '', url.toString());

                    if (searchIndicator) searchIndicator.classList.remove('active');
                    if (teamList) {
                        teamList.style.opacity = '1';
                        teamList.style.pointerEvents = 'auto';
                    }
                });
            }

            // Initial filter
            setTimeout(function() {
                filterData();
            }, 100);
        });
    </script>
</x-app-layout>