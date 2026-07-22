<x-app-layout>
    <x-slot name="title">Buat Penawaran</x-slot>

    {{-- ===== SVG ICONS ===== --}}
    <svg style="display:none;">
        <defs>
            <symbol id="ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="ic-save" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
            </symbol>
            <symbol id="ic-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </symbol>
            <symbol id="ic-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </symbol>
            <symbol id="ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="ic-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </symbol>
            <symbol id="ic-file-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </symbol>
            <symbol id="ic-file-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .quote-create-wrap{
            --accent: var(--emerald);
            --accent-dim: var(--emerald-dim);
            --accent-soft: rgba(var(--emerald-rgb), 0.12);
            --accent-glow: rgba(var(--emerald-rgb), 0.25);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            color: var(--text);
        }
        .quote-create-wrap *{ box-sizing:border-box; }

        @keyframes fadeSlideUp{ from{ opacity:0; transform:translateY(20px);} to{ opacity:1; transform:translateY(0);} }
        .quote-create-wrap .animate-in{ animation:fadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }

        /* ===== BREADCRUMB ===== */
        .breadcrumb{
            display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); margin-bottom:20px;
        }
        .breadcrumb a{ color:var(--text-secondary); text-decoration:none; transition:color .2s ease; }
        .breadcrumb a:hover{ color:var(--text); }
        .breadcrumb .sep{ color:var(--text-faint); }
        .breadcrumb .current{ color:var(--text); font-weight:600; }

        /* ===== HEADER ===== */
        .page-head{
            display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:28px;
        }
        .page-head-left{ flex:1; min-width:200px; }
        .page-head h1{
            font-size:28px; font-weight:700; margin:0 0 6px; letter-spacing:-.02em;
            background:linear-gradient(135deg, var(--text) 55%, var(--accent)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
        }
        .page-head p{ font-size:14px; color:var(--text-muted); margin:0; }

        .head-actions{ display:flex; gap:10px; flex-wrap:wrap; }

        /* ===== BUTTONS ===== */
        .btn{
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:11px 22px; border-radius:var(--radius-sm); font-size:13.5px; font-weight:600;
            cursor:pointer; border:none; transition:all .22s cubic-bezier(.16,1,.3,1);
            white-space:nowrap; text-decoration:none; position:relative; overflow:hidden;
        }
        .btn .icon{ width:16px; height:16px; flex-shrink:0; }
        .btn-primary{
            background:linear-gradient(135deg, var(--accent), var(--accent-dim));
            color:#052117; box-shadow:0 4px 18px var(--accent-glow);
        }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 10px 28px var(--accent-glow); }
        .btn-primary::after{
            content:''; position:absolute; top:-50%; left:-50%; width:200%; height:200%;
            background:linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform:rotate(45deg) translateX(-100%); transition:transform .6s ease;
        }
        .btn-primary:hover::after{ transform:rotate(45deg) translateX(100%); }
        .btn-outline{
            background:var(--surface); border:1px solid var(--border); color:var(--text);
        }
        .btn-outline:hover{
            background:var(--surface-strong); border-color:var(--border-hover); transform:translateY(-2px);
        }
        .btn-sm{ padding:8px 16px; font-size:12.5px; }

        /* ===== FORM PANEL ===== */
        .form-panel{
            background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg);
            overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .form-panel-header{
            padding:24px 32px; border-bottom:1px solid var(--border);
            display:flex; align-items:center; gap:12px;
        }
        .form-panel-header .icon-wrap{
            width:40px; height:40px; border-radius:12px;
            background:var(--accent-soft); color:var(--accent);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .form-panel-header .icon-wrap .icon{ width:20px; height:20px; }
        .form-panel-header h2{
            font-size:16px; font-weight:600; color:var(--text); margin:0;
        }
        .form-panel-header p{
            font-size:13px; color:var(--text-muted); margin:2px 0 0;
        }

        .form-body{ padding:32px; }

        /* ===== FORM GRID ===== */
        .field-grid{ display:grid; grid-template-columns:1fr 1fr 1fr; gap:24px; }
        .field-grid .full{ grid-column:1/-1; }

        .field-group{ display:flex; flex-direction:column; gap:6px; }
        .field-group label{
            font-size:12.5px; font-weight:600; color:var(--text-secondary);
            display:flex; align-items:center; gap:6px;
        }
        .field-group label .opt{
            font-weight:400; color:var(--text-muted); font-size:11.5px;
        }
        .field-group label .required{
            color:var(--danger); font-size:14px;
        }

        .field-group .input-wrap{
            position:relative;
        }
        .field-group .input-wrap .icon{
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:var(--text-muted); pointer-events:none;
        }
        .field-group input,
        .field-group select,
        .field-group textarea{
            width:100%; padding:11px 16px; border-radius:var(--radius-sm);
            background:var(--surface-hover); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none;
            transition:all .2s ease; font-family:inherit;
        }
        .field-group input.has-icon{ padding-left:42px; }
        .field-group input:focus,
        .field-group select:focus,
        .field-group textarea:focus{
            border-color:var(--accent); background:var(--surface);
            box-shadow:0 0 0 4px rgba(var(--emerald-rgb),0.08);
        }
        .field-group input::placeholder{
            color:var(--text-muted);
        }
        .field-group select{
            padding-right:38px;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='none' stroke='%239CA3AF' stroke-width='2' d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 14px center; background-size:12px;
            appearance:none; -webkit-appearance:none;
            color-scheme: dark;
        }
        /* ===== FIX: OPTION DI DARK MODE ===== */
        .field-group select option{
            background: #1a1f2e !important;
            color: #e8edf5 !important;
            padding: 10px 14px;
            font-size: 14px;
        }
        .field-group select option:checked,
        .field-group select option:hover{
            background: #0d2a1f !important;
            color: #34d399 !important;
        }
        /* Light mode override */
        @media (prefers-color-scheme: light) {
            .field-group select {
                color-scheme: light;
            }
            .field-group select option{
                background: #ffffff !important;
                color: #1a1f2e !important;
            }
            .field-group select option:checked,
            .field-group select option:hover{
                background: #e6f9f1 !important;
                color: #059669 !important;
            }
        }

        .field-group textarea{
            resize:vertical; min-height:100px; padding:12px 16px; font-size:13.5px; line-height:1.6;
        }
        .field-group .field-hint{
            font-size:11.5px; color:var(--text-muted); margin-top:4px;
        }
        .field-group .field-error{
            font-size:12px; color:var(--danger); margin-top:4px; display:flex; align-items:center; gap:4px;
        }

        /* ===== FORM DIVIDER ===== */
        .form-divider{
            display:flex; align-items:center; gap:16px; margin:28px 0 24px;
        }
        .form-divider::before,
        .form-divider::after{
            content:''; flex:1; height:1px; background:var(--border);
        }
        .form-divider span{
            font-size:11.5px; text-transform:uppercase; letter-spacing:.08em;
            color:var(--text-muted); font-weight:600; white-space:nowrap;
        }

        /* ===== FORM ACTIONS ===== */
        .form-actions{
            display:flex; justify-content:flex-end; gap:12px; padding-top:24px;
            border-top:1px solid var(--border); margin-top:8px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px){ .field-grid{ grid-template-columns:1fr 1fr; } }
        @media (max-width: 768px){
            .page-head{ flex-direction:column; }
            .head-actions{ width:100%; }
            .head-actions .btn{ flex:1; }
            .field-grid{ grid-template-columns:1fr; gap:16px; }
            .form-body{ padding:20px; }
            .form-panel-header{ padding:18px 20px; flex-wrap:wrap; }
            .form-panel-header .icon-wrap{ width:32px; height:32px; }
            .form-panel-header .icon-wrap .icon{ width:16px; height:16px; }
            .form-actions{ flex-direction:column-reverse; }
            .form-actions .btn{ flex:1; justify-content:center; }
        }
        @media (max-width: 480px){
            .form-panel-header h2{ font-size:15px; }
            .form-panel-header p{ font-size:12px; }
        }
    </style>

    <div class="quote-create-wrap">

        {{-- ===== BREADCRUMB ===== --}}
        <div class="breadcrumb animate-in" style="animation-delay:.02s;">
            <a href="{{ route('quotes.index') }}">Penawaran</a>
            <span class="sep">›</span>
            <span class="current">Buat Penawaran</span>
        </div>

        {{-- ===== HEADER ===== --}}
        <div class="page-head animate-in" style="animation-delay:.05s;">
            <div class="page-head-left">
                <h1>Buat Penawaran Baru</h1>
                <p>Buat penawaran atau quotation baru untuk klien dengan mudah.</p>
            </div>
            <div class="head-actions">
                <a href="{{ route('quotes.index') }}" class="btn btn-outline">
                    <svg class="icon"><use href="#ic-arrow-left"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        {{-- ===== FORM ===== --}}
        <form method="POST" action="{{ route('quotes.store') }}" class="animate-in" style="animation-delay:.10s;">
            @csrf

            <div class="form-panel">
                {{-- Panel Header --}}
                <div class="form-panel-header">
                    <div class="icon-wrap">
                        <svg class="icon"><use href="#ic-file-plus"/></svg>
                    </div>
                    <div>
                        <h2>Detail Penawaran</h2>
                        <p>Lengkapi semua informasi yang diperlukan untuk membuat penawaran.</p>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="form-body">
                    {{-- Baris 1: Klien & Tanggal --}}
                    <div class="field-grid">
                        {{-- Klien --}}
                        <div class="field-group">
                            <label>
                                Klien
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-user"/></svg>
                                <select name="client_id" class="has-icon" required>
                                    <option value="">Pilih klien...</option>
                                    @foreach($clients ?? [] as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }} {{ $client->company_name ? '- ' . $client->company_name : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('client_id')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Pilih klien yang akan menerima penawaran ini.</div>
                        </div>

                        {{-- Tanggal Terbit --}}
                        <div class="field-group">
                            <label>
                                Tanggal Terbit
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-calendar"/></svg>
                                <input type="date" name="issue_date" class="has-icon" value="{{ old('issue_date', date('Y-m-d')) }}" required>
                            </div>
                            @error('issue_date')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Tanggal penawaran diterbitkan.</div>
                        </div>

                        {{-- Berlaku Sampai --}}
                        <div class="field-group">
                            <label>
                                Berlaku Sampai
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-clock"/></svg>
                                <input type="date" name="valid_until" class="has-icon" value="{{ old('valid_until', date('Y-m-d', strtotime('+14 days'))) }}" required>
                            </div>
                            @error('valid_until')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Tanggal berakhirnya masa berlaku penawaran.</div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="form-divider">
                        <span>Detail Penawaran</span>
                    </div>

                    {{-- Baris 2: Status, Subtotal, Pajak --}}
                    <div class="field-grid">
                        {{-- Status --}}
                        <div class="field-group">
                            <label>
                                Status
                                <span class="required">*</span>
                            </label>
                            <select name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Terkirim</option>
                                <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Kadaluwarsa</option>
                            </select>
                            @error('status')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Status awal penawaran saat dibuat.</div>
                        </div>

                        {{-- Subtotal --}}
                        <div class="field-group">
                            <label>
                                Subtotal
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-dollar"/></svg>
                                <input type="number" name="subtotal" class="has-icon" value="{{ old('subtotal', 0) }}" step="0.01" min="0" required>
                            </div>
                            @error('subtotal')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Subtotal penawaran sebelum pajak.</div>
                        </div>

                        {{-- Pajak --}}
                        <div class="field-group">
                            <label>
                                Pajak
                                <span class="opt">(opsional)</span>
                            </label>
                            <div class="input-wrap">
                                <svg class="icon"><use href="#ic-file-text"/></svg>
                                <input type="number" name="tax_amount" class="has-icon" value="{{ old('tax_amount', 0) }}" step="0.01" min="0">
                            </div>
                            @error('tax_amount')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Jumlah pajak yang dikenakan.</div>
                        </div>
                    </div>

                    {{-- Baris 3: Catatan (full width) --}}
                    <div class="field-grid" style="margin-top:8px;">
                        <div class="field-group full">
                            <label>
                                Catatan
                                <span class="opt">(opsional)</span>
                            </label>
                            <textarea name="notes" rows="4" placeholder="Tambahkan catatan atau deskripsi untuk penawaran ini...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="field-error">
                                    <span>⚠️</span> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">Informasi tambahan yang ingin dicantumkan pada penawaran.</div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="form-actions">
                        <a href="{{ route('quotes.index') }}" class="btn btn-outline">
                            <svg class="icon"><use href="#ic-arrow-left"/></svg>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="icon"><use href="#ic-save"/></svg>
                            Simpan Penawaran
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>