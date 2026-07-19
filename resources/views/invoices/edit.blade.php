<x-app-layout>
    <x-slot name="title">Edit Faktur - {{ $invoice['invoice'] ?? $invoice['invoice_number'] ?? 'Detail' }}</x-slot>

    @php
        // Ambil data dengan fallback untuk array
        $invoiceNumber = $invoice['invoice'] ?? $invoice['invoice_number'] ?? 'N/A';
        $clientName = $invoice['client'] ?? $invoice['client_name'] ?? '';
        $amount = $invoice['amount'] ?? $invoice['total'] ?? 0;
        $date = $invoice['date'] ?? $invoice['issue_date'] ?? date('Y-m-d');
        $due = $invoice['due'] ?? $invoice['due_date'] ?? date('Y-m-d', strtotime('+14 days'));
        $status = $invoice['status'] ?? 'draft';
        $notes = $invoice['notes'] ?? '';
        $invoiceId = $invoice['id'] ?? 0;

        $statusOptions = [
            'draft' => ['label' => 'Draft', 'class' => 'draft'],
            'sent' => ['label' => 'Dikirim', 'class' => 'sent'],
            'overdue' => ['label' => 'Jatuh Tempo', 'class' => 'overdue'],
            'paid' => ['label' => 'Lunas', 'class' => 'paid'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'cancelled']
        ];

        function formatTanggal($date) {
            if (empty($date)) return '-';
            try {
                return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return $date;
            }
        }

        function formatCurrency($amount) {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        }
    @endphp

    <style>
        .edit-wrap {
            --theme-soft: rgba(var(--emerald-rgb), 0.12);
            --danger-soft: rgba(232, 90, 122, 0.12);
            --info-soft: rgba(78, 143, 240, 0.12);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.4);
            max-width: 820px;
            margin: 0 auto;
            padding: 24px 20px 60px;
        }

        [data-theme="light"] .edit-wrap {
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.12);
        }

        /* ===== TOPBAR ===== */
        .edit-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0 20px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .edit-topbar-left h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }
        .edit-topbar-left .sub {
            font-size: 14px;
            color: var(--text-mute);
            margin-top: 2px;
        }
        .edit-topbar-left .sub .invoice-num {
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text);
            font-weight: 600;
        }
        .edit-topbar-actions {
            display: flex;
            gap: 10px;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        .btn .icon {
            width: 16px;
            height: 16px;
        }
        .btn-primary {
            background: var(--emerald);
            color: #052117;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(var(--emerald-rgb), 0.35);
        }
        .btn-outline {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-outline:hover {
            background: var(--surface-strong);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }
        .btn-danger {
            background: #E8637A;
            color: #fff;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(232, 90, 122, 0.35);
        }
        .btn-success {
            background: #34B583;
            color: #fff;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(52, 181, 131, 0.35);
        }

        /* ===== CARD ===== */
        .edit-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 40px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        .edit-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-lg);
        }

        .edit-card .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .edit-card .status-badge .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }
        .edit-card .status-badge.draft {
            background: var(--surface-strong);
            color: var(--text-mute);
        }
        .edit-card .status-badge.draft .dot {
            background: var(--text-faint);
        }
        .edit-card .status-badge.sent {
            background: var(--info-soft);
            color: #4E8FF0;
        }
        .edit-card .status-badge.sent .dot {
            background: #4E8FF0;
        }
        .edit-card .status-badge.overdue {
            background: var(--danger-soft);
            color: #E8637A;
        }
        .edit-card .status-badge.overdue .dot {
            background: #E8637A;
        }
        .edit-card .status-badge.paid {
            background: var(--theme-soft);
            color: var(--emerald);
        }
        .edit-card .status-badge.paid .dot {
            background: var(--emerald);
        }
        .edit-card .status-badge.cancelled {
            background: var(--surface-strong);
            color: var(--text-faint);
            text-decoration: line-through;
        }
        .edit-card .status-badge.cancelled .dot {
            background: var(--text-faint);
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 22px;
        }
        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-mute);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .form-group label .required {
            color: #E8637A;
            margin-left: 2px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            background: var(--surface-strong);
            color: var(--text);
            font-size: 14px;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--emerald);
            box-shadow: 0 0 0 4px rgba(var(--emerald-rgb), 0.12);
            background: var(--surface);
        }
        .form-control::placeholder {
            color: var(--text-faint);
        }
        .form-control:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238A96AE' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
            cursor: pointer;
        }
        select.form-control option {
            background: var(--bg);
            color: var(--text);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            font-family: 'Inter', sans-serif;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        /* ===== FORM ACTIONS ===== */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1.5px solid var(--border);
            flex-wrap: wrap;
        }
        .form-actions .spacer {
            flex: 1;
        }
        .form-actions .btn {
            min-width: 130px;
            justify-content: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .edit-wrap {
                padding: 16px 12px 40px;
            }
            .edit-card {
                padding: 24px 18px;
                border-radius: 16px;
            }
            .edit-topbar {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            .edit-topbar-left h1 {
                font-size: 22px;
            }
            .edit-topbar-actions {
                flex-wrap: wrap;
            }
            .edit-topbar-actions .btn {
                flex: 1;
                justify-content: center;
            }
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .form-actions {
                flex-direction: column;
            }
            .form-actions .btn {
                width: 100%;
                min-width: unset;
            }
            .form-actions .spacer {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .edit-card {
                padding: 16px 14px;
            }
            .edit-topbar-left h1 {
                font-size: 20px;
            }
            .form-group label {
                font-size: 11.5px;
            }
            .form-control {
                padding: 10px 14px;
                font-size: 13px;
            }
            .btn {
                font-size: 12px;
                padding: 8px 16px;
            }
        }
    </style>

    <div class="edit-wrap">
        <!-- TOPBAR -->
        <div class="edit-topbar">
            <div class="edit-topbar-left">
                <h1> Edit Faktur</h1>
                <div class="sub">
                    Mengubah data faktur <span class="invoice-num">{{ $invoiceNumber }}</span>
                </div>
            </div>
            <div class="edit-topbar-actions">
                <a href="{{ route('invoices.show', $invoiceId) }}" class="btn btn-outline">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('invoices.index') }}" class="btn btn-outline">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Semua Faktur
                </a>
            </div>
        </div>

        <!-- CARD -->
        <div class="edit-card">
            <!-- Status Badge -->
            <div class="status-badge {{ $statusOptions[$status]['class'] ?? 'draft' }}">
                <span class="dot"></span>
                Status: {{ $statusOptions[$status]['label'] ?? 'Draft' }}
            </div>

            <form action="{{ route('invoices.update', $invoiceId) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Client -->
                <div class="form-group">
                    <label for="client">Klien <span class="required">*</span></label>
                    <input type="text" id="client" name="client" class="form-control" 
                           value="{{ $clientName }}" 
                           placeholder="Masukkan nama klien..." required>
                </div>

                <!-- Date & Due -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Tanggal Terbit <span class="required">*</span></label>
                        <input type="date" id="date" name="date" class="form-control" 
                               value="{{ $date }}" required>
                    </div>
                    <div class="form-group">
                        <label for="due">Jatuh Tempo <span class="required">*</span></label>
                        <input type="date" id="due" name="due" class="form-control" 
                               value="{{ $due }}" required>
                    </div>
                </div>

                <!-- Amount -->
                <div class="form-group">
                    <label for="amount">Jumlah <span class="required">*</span></label>
                    <input type="number" id="amount" name="amount" class="form-control" 
                           value="{{ $amount }}" 
                           placeholder="0" 
                           step="1000" 
                           min="0" 
                           required>
                    <div style="font-size:12px;color:var(--text-faint);margin-top:4px;">
                        💰 Masukkan dalam Rupiah (tanpa tanda koma)
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        @foreach($statusOptions as $key => $option)
                            <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                                {{ $option['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes">Catatan</label>
                    <textarea id="notes" name="notes" class="form-control" 
                              rows="4" 
                              placeholder="Tambahkan catatan untuk faktur ini...">{{ $notes }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('invoices.show', $invoiceId) }}" class="btn btn-outline">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6L6 18"/>
                            <path d="M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <div class="spacer"></div>
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Footer -->
        <div style="margin-top:20px;text-align:center;font-size:13px;color:var(--text-faint);">
            <span>💡 Perubahan akan langsung tersimpan dan diperbarui di daftar faktur</span>
        </div>
    </div>
</x-app-layout>