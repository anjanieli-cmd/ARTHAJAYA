<x-app-layout>
    <x-slot name="title">Buat Tiket Baru</x-slot>

    <svg style="display:none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <symbol id="tktn-ic-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </symbol>
            <symbol id="tktn-ic-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </symbol>
            <symbol id="tktn-ic-tool" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
            </symbol>
            <symbol id="tktn-ic-credit-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </symbol>
            <symbol id="tktn-ic-sparkles" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M18.4 5.6l-2.8 2.8M8.4 15.6l-2.8 2.8"/>
            </symbol>
            <symbol id="tktn-ic-more" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>
            </symbol>
            <symbol id="tktn-ic-arrow-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
            </symbol>
            <symbol id="tktn-ic-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/>
            </symbol>
            <symbol id="tktn-ic-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </symbol>
            <symbol id="tktn-ic-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </symbol>
            <symbol id="tktn-ic-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </symbol>
            <symbol id="tktn-ic-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41L11 22 2 13l9-9h9v9z"/><circle cx="7" cy="7" r="1"/>
            </symbol>
            <symbol id="tktn-ic-flag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/>
            </symbol>
        </defs>
    </svg>

    <style>
        .tktn-wrap{
            --theme-primary: var(--emerald);
            --theme-glow: rgba(var(--emerald-rgb), 0.25);
            --theme-soft: rgba(var(--emerald-rgb), 0.12);
            --theme-gradient: linear-gradient(135deg, var(--emerald), var(--emerald-dim));
            font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color:var(--text); padding:0 24px;
        }
        .tktn-wrap *{ box-sizing:border-box; }
        @keyframes tktnFadeSlideUp{ from{opacity:0; transform:translateY(16px);} to{opacity:1; transform:translateY(0);} }
        @keyframes tktnPulseGlow{ 0%,100%{opacity:1;} 50%{opacity:.6;} }
        .tktn-wrap .animate-in{ animation:tktnFadeSlideUp .5s cubic-bezier(.16,1,.3,1) forwards; opacity:0; }
        .tktn-wrap .icon{ width:16px; height:16px; flex-shrink:0; display:inline-block; vertical-align:middle; fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }

        .tktn-back{ display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color:var(--text-mute); margin-bottom:18px; text-decoration:none; transition:color .18s ease; }
        .tktn-back:hover{ color:var(--text); }
        .tktn-back .icon{ width:14px; height:14px; }

        .tktn-badge{ display:inline-flex; align-items:center; gap:8px; padding:6px 14px 6px 10px; background:var(--theme-glow); border:1px solid var(--theme-glow); border-radius:100px; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:var(--theme-primary); margin-bottom:12px; }
        .tktn-badge .dot{ width:6px; height:6px; border-radius:50%; background:var(--theme-primary); animation:tktnPulseGlow 2s ease-in-out infinite; }
        .tktn-header h1{ font-size:28px; font-weight:700; margin:0 0 6px; background:linear-gradient(135deg, var(--text) 60%, var(--theme-primary)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:-0.02em; }
        .tktn-header .subtitle{ font-size:14px; color:var(--text-mute); margin:0 0 24px; }

        /* ===== 2-KOLOM LAYOUT (full width) ===== */
        .tktn-layout{ display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start; }

        .tktn-card{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:28px; transition:border-color .22s ease; }
        .tktn-card:hover{ border-color:var(--border-hover); }

        .tktn-field{ margin-bottom:22px; }
        .tktn-field label{ display:block; font-size:12.5px; font-weight:600; color:var(--text-mute); margin-bottom:9px; }
        .tktn-field label .req{ color:#E85A5A; margin-left:2px; }

        .tktn-field input[type=text], .tktn-field textarea{
            width:100%; padding:12px 14px; border-radius:12px; background:var(--surface-strong); border:1px solid var(--border);
            color:var(--text); font-size:13.5px; outline:none; font-family:inherit; transition:all .18s ease;
        }
        .tktn-field input[type=text]:focus, .tktn-field textarea:focus{ border-color:var(--theme-primary); box-shadow:0 0 0 3px var(--theme-soft); }
        .tktn-field textarea{ resize:vertical; min-height:160px; line-height:1.55; }

        .tktn-charcount{ display:flex; justify-content:flex-end; font-size:11px; color:var(--text-faint); margin-top:6px; }
        .tktn-charcount.warn{ color:#E8B23A; }

        /* ===== KATEGORI: chip cards, 4 kolom biar melebar penuh ===== */
        .tktn-chip-grid{ display:grid; grid-template-columns:repeat(4, 1fr); gap:10px; }
        .tktn-chip-card{ position:relative; }
        .tktn-chip-card input{ position:absolute; opacity:0; pointer-events:none; }
        .tktn-chip-card label{
            display:flex; flex-direction:column; align-items:flex-start; gap:10px; padding:14px; border-radius:12px;
            background:var(--surface-strong); border:1.5px solid var(--border); cursor:pointer;
            transition:all .18s ease; margin:0; font-size:13px; font-weight:500; color:var(--text-mute); height:100%;
        }
        .tktn-chip-card label .ic{ width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,.04); color:var(--text-faint); flex-shrink:0; transition:all .18s ease; }
        .tktn-chip-card label .ic .icon{ width:15px; height:15px; }
        .tktn-chip-card input:checked + label{ border-color:var(--theme-primary); background:var(--theme-soft); color:var(--text); }
        .tktn-chip-card input:checked + label .ic{ background:var(--theme-gradient); color:#052117; }
        .tktn-chip-card label:hover{ border-color:var(--border-hover); }
        .tktn-chip-card input:focus-visible + label{ outline:2px solid var(--theme-primary); outline-offset:2px; }

        /* ===== PRIORITAS: segmented control ===== */
        .tktn-seg{ display:grid; grid-template-columns:repeat(3, 1fr); gap:10px; }
        .tktn-seg-item{ position:relative; }
        .tktn-seg-item input{ position:absolute; opacity:0; pointer-events:none; }
        .tktn-seg-item label{
            display:flex; align-items:center; justify-content:center; gap:7px; padding:13px 10px; border-radius:11px;
            background:var(--surface-strong); border:1.5px solid var(--border); cursor:pointer;
            transition:all .18s ease; margin:0; font-size:13px; font-weight:600; color:var(--text-mute);
        }
        .tktn-seg-item label .icon{ width:13px; height:13px; }
        .tktn-seg-item.low input:checked + label{ border-color:#4FA6E8; background:rgba(79,166,232,.12); color:#4FA6E8; }
        .tktn-seg-item.medium input:checked + label{ border-color:#E8B23A; background:rgba(232,178,58,.12); color:#E8B23A; }
        .tktn-seg-item.high input:checked + label{ border-color:#E85A5A; background:rgba(232,90,90,.12); color:#E85A5A; }
        .tktn-seg-item label:hover{ border-color:var(--border-hover); }
        .tktn-seg-item input:focus-visible + label{ outline:2px solid var(--theme-primary); outline-offset:2px; }

        .tktn-error{ font-size:11.5px; color:#E85A5A; margin-top:7px; display:flex; align-items:center; gap:5px; }
        .tktn-error .icon{ width:12px; height:12px; }

        .tktn-divider{ height:1px; background:var(--border); margin:24px 0; }

        .tktn-submit-row{ display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
        .tktn-hint{ font-size:11.5px; color:var(--text-faint); }
        .tktn-submit{ display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:12px; background:var(--theme-gradient); color:#052117; font-size:13.5px; font-weight:700; border:none; cursor:pointer; transition:all .2s ease; box-shadow:0 4px 16px var(--theme-glow); }
        .tktn-submit:hover{ transform:translateY(-2px); box-shadow:0 8px 24px var(--theme-glow); }
        .tktn-submit .icon{ width:15px; height:15px; }

        /* ===== SIDEBAR: ringkasan tiket live ===== */
        .tktn-side-card{ background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:22px; position:sticky; top:20px; }
        .tktn-side-card h3{ font-size:14px; font-weight:700; margin:0 0 16px; color:var(--text); }

        .tktn-preview-subject{ font-size:14px; font-weight:600; color:var(--text); margin-bottom:2px; line-height:1.4; word-break:break-word; }
        .tktn-preview-subject.placeholder{ color:var(--text-faint); font-weight:400; font-style:italic; }
        .tktn-preview-meta{ display:flex; flex-wrap:wrap; gap:8px; margin:12px 0 18px; }

        .tktn-preview-chip{ font-size:11px; font-weight:600; padding:5px 12px; border-radius:100px; display:inline-flex; align-items:center; gap:5px; background:var(--surface-strong); color:var(--text-faint); border:1px solid var(--border); }
        .tktn-preview-chip .icon{ width:11px; height:11px; }
        .tktn-preview-chip.filled{ background:var(--theme-soft); color:var(--theme-primary); border-color:transparent; }
        .tktn-preview-chip.pri-low.filled{ background:rgba(79,166,232,.12); color:#4FA6E8; }
        .tktn-preview-chip.pri-medium.filled{ background:rgba(232,178,58,.12); color:#E8B23A; }
        .tktn-preview-chip.pri-high.filled{ background:rgba(232,90,90,.12); color:#E85A5A; }

        .tktn-side-divider{ height:1px; background:var(--border); margin:16px 0; }

        .tktn-info-row{ display:flex; gap:10px; padding:10px 0; }
        .tktn-info-row .ic{ width:28px; height:28px; border-radius:8px; background:var(--surface-strong); color:var(--text-faint); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .tktn-info-row .ic .icon{ width:13px; height:13px; }
        .tktn-info-row p{ font-size:12px; color:var(--text-faint); margin:0; line-height:1.5; }

        @media (max-width:1000px){
            .tktn-layout{ grid-template-columns:1fr; }
            .tktn-side-card{ position:static; }
            .tktn-chip-grid{ grid-template-columns:repeat(2, 1fr); }
        }
        @media (max-width:600px){
            .tktn-wrap{ padding:0 12px; }
            .tktn-card{ padding:20px; }
            .tktn-submit-row{ flex-direction:column; align-items:stretch; }
            .tktn-submit{ justify-content:center; }
        }
    </style>

    <div class="tktn-wrap">
        <a href="{{ route('staff.tickets.index') }}" class="tktn-back animate-in" style="animation-delay:.03s;">
            <svg class="icon"><use href="#tktn-ic-arrow-left"/></svg> Kembali ke Tiket Saya
        </a>

        <div class="tktn-header animate-in" style="animation-delay:.05s;">
            <div class="tktn-badge"><span class="dot"></span> Support &amp; Bantuan</div>
            <h1>Buat Tiket Baru</h1>
            <p class="subtitle">Jelaskan kendala atau pertanyaanmu, admin akan membalas secepatnya.</p>
        </div>

        <div class="tktn-layout">
            <div class="tktn-card animate-in" style="animation-delay:.08s;">
                <form method="POST" action="{{ route('staff.tickets.store') }}" id="tktnForm">
                    @csrf

                    <div class="tktn-field">
                        <label for="subject">Subjek<span class="req">*</span></label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Ringkasan singkat kendalamu" maxlength="255" required>
                        @error('subject')
                            <div class="tktn-error"><svg class="icon"><use href="#tktn-ic-alert"/></svg>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="tktn-field">
                        <label>Kategori<span class="req">*</span></label>
                        <div class="tktn-chip-grid">
                            <div class="tktn-chip-card">
                                <input type="radio" id="cat-technical" name="category" value="technical" data-label="Teknis" {{ old('category') === 'technical' ? 'checked' : '' }} required>
                                <label for="cat-technical">
                                    <span class="ic"><svg class="icon"><use href="#tktn-ic-tool"/></svg></span> Teknis
                                </label>
                            </div>
                            <div class="tktn-chip-card">
                                <input type="radio" id="cat-billing" name="category" value="billing" data-label="Tagihan" {{ old('category') === 'billing' ? 'checked' : '' }} required>
                                <label for="cat-billing">
                                    <span class="ic"><svg class="icon"><use href="#tktn-ic-credit-card"/></svg></span> Tagihan
                                </label>
                            </div>
                            <div class="tktn-chip-card">
                                <input type="radio" id="cat-feature" name="category" value="feature_request" data-label="Permintaan Fitur" {{ old('category') === 'feature_request' ? 'checked' : '' }} required>
                                <label for="cat-feature">
                                    <span class="ic"><svg class="icon"><use href="#tktn-ic-sparkles"/></svg></span> Permintaan Fitur
                                </label>
                            </div>
                            <div class="tktn-chip-card">
                                <input type="radio" id="cat-other" name="category" value="other" data-label="Lainnya" {{ old('category') === 'other' ? 'checked' : '' }} required>
                                <label for="cat-other">
                                    <span class="ic"><svg class="icon"><use href="#tktn-ic-more"/></svg></span> Lainnya
                                </label>
                            </div>
                        </div>
                        @error('category')
                            <div class="tktn-error"><svg class="icon"><use href="#tktn-ic-alert"/></svg>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="tktn-field">
                        <label>Prioritas<span class="req">*</span></label>
                        <div class="tktn-seg">
                            <div class="tktn-seg-item low">
                                <input type="radio" id="pri-low" name="priority" value="low" data-label="Rendah" {{ old('priority') === 'low' ? 'checked' : '' }} required>
                                <label for="pri-low"><svg class="icon"><use href="#tktn-ic-arrow-down"/></svg> Rendah</label>
                            </div>
                            <div class="tktn-seg-item medium">
                                <input type="radio" id="pri-medium" name="priority" value="medium" data-label="Sedang" {{ old('priority', 'medium') === 'medium' ? 'checked' : '' }} required>
                                <label for="pri-medium"><svg class="icon"><use href="#tktn-ic-minus"/></svg> Sedang</label>
                            </div>
                            <div class="tktn-seg-item high">
                                <input type="radio" id="pri-high" name="priority" value="high" data-label="Tinggi" {{ old('priority') === 'high' ? 'checked' : '' }} required>
                                <label for="pri-high"><svg class="icon"><use href="#tktn-ic-alert"/></svg> Tinggi</label>
                            </div>
                        </div>
                        @error('priority')
                            <div class="tktn-error"><svg class="icon"><use href="#tktn-ic-alert"/></svg>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="tktn-field" style="margin-bottom:0;">
                        <label for="message">Detail Kendala<span class="req">*</span></label>
                        <textarea id="message" name="message" placeholder="Ceritakan detailnya di sini — semakin jelas, semakin cepat admin bisa bantu." maxlength="2000" required>{{ old('message') }}</textarea>
                        <div class="tktn-charcount" id="tktnCharCount">0 / 2000</div>
                        @error('message')
                            <div class="tktn-error"><svg class="icon"><use href="#tktn-ic-alert"/></svg>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="tktn-divider"></div>

                    <div class="tktn-submit-row">
                        <span class="tktn-hint">Admin akan dinotifikasi begitu tiket dikirim.</span>
                        <button type="submit" class="tktn-submit">
                            <svg class="icon"><use href="#tktn-ic-send"/></svg> Kirim Tiket
                        </button>
                    </div>
                </form>
            </div>

            <div class="tktn-side-card animate-in" style="animation-delay:.12s;">
                <h3>Ringkasan Tiket</h3>

                <div class="tktn-preview-subject placeholder" id="previewSubject">Subjek tiketmu akan muncul di sini...</div>

                <div class="tktn-preview-meta">
                    <span class="tktn-preview-chip" id="previewCategory"><svg class="icon"><use href="#tktn-ic-tag"/></svg> Kategori</span>
                    <span class="tktn-preview-chip" id="previewPriority"><svg class="icon"><use href="#tktn-ic-flag"/></svg> Prioritas</span>
                </div>

                <div class="tktn-side-divider"></div>

                <div class="tktn-info-row">
                    <div class="ic"><svg class="icon"><use href="#tktn-ic-clock"/></svg></div>
                    <p>Waktu respon tergantung prioritas — tiket <strong style="color:var(--text);">Tinggi</strong> akan diprioritaskan admin.</p>
                </div>
                <div class="tktn-info-row">
                    <div class="ic"><svg class="icon"><use href="#tktn-ic-info"/></svg></div>
                    <p>Kamu bisa balas percakapan ini kapan pun sampai admin menandainya selesai.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var textarea  = document.getElementById('message');
            var charCount = document.getElementById('tktnCharCount');
            var maxLen    = 2000;

            function updateCount() {
                var len = textarea.value.length;
                charCount.textContent = len + ' / ' + maxLen;
                charCount.classList.toggle('warn', len > maxLen * 0.9);
            }

            if (textarea && charCount) {
                textarea.addEventListener('input', updateCount);
                updateCount();
            }

            // ===== LIVE PREVIEW SIDEBAR =====
            var subjectInput   = document.getElementById('subject');
            var previewSubject = document.getElementById('previewSubject');
            var previewCategory = document.getElementById('previewCategory');
            var previewPriority = document.getElementById('previewPriority');

            function updateSubjectPreview() {
                var val = subjectInput.value.trim();
                if (val) {
                    previewSubject.textContent = val;
                    previewSubject.classList.remove('placeholder');
                } else {
                    previewSubject.textContent = 'Subjek tiketmu akan muncul di sini...';
                    previewSubject.classList.add('placeholder');
                }
            }

            function updateCategoryPreview() {
                var checked = document.querySelector('input[name="category"]:checked');
                if (checked) {
                    previewCategory.innerHTML = '<svg class="icon"><use href="#tktn-ic-tag"/></svg> ' + checked.dataset.label;
                    previewCategory.classList.add('filled');
                } else {
                    previewCategory.innerHTML = '<svg class="icon"><use href="#tktn-ic-tag"/></svg> Kategori';
                    previewCategory.classList.remove('filled');
                }
            }

            function updatePriorityPreview() {
                var checked = document.querySelector('input[name="priority"]:checked');
                previewPriority.classList.remove('pri-low', 'pri-medium', 'pri-high');
                if (checked) {
                    previewPriority.innerHTML = '<svg class="icon"><use href="#tktn-ic-flag"/></svg> ' + checked.dataset.label;
                    previewPriority.classList.add('filled', 'pri-' + checked.value);
                } else {
                    previewPriority.innerHTML = '<svg class="icon"><use href="#tktn-ic-flag"/></svg> Prioritas';
                    previewPriority.classList.remove('filled');
                }
            }

            if (subjectInput) subjectInput.addEventListener('input', updateSubjectPreview);
            document.querySelectorAll('input[name="category"]').forEach(function (el) {
                el.addEventListener('change', updateCategoryPreview);
            });
            document.querySelectorAll('input[name="priority"]').forEach(function (el) {
                el.addEventListener('change', updatePriorityPreview);
            });

            updateSubjectPreview();
            updateCategoryPreview();
            updatePriorityPreview();
        });
    </script>
</x-app-layout>