<x-app-layout>
  <x-slot name="title">Edit Penawaran</x-slot>

<style>
    .page-head h1 {
        font-size: 26px;
        margin-bottom: 6px;
    }
    .page-head p {
        font-size: 14px;
        color: var(--text-mute);
        margin-bottom: 24px;
    }
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 28px;
        max-width: 700px;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text);
    }
    .form-group label .required {
        color: var(--danger);
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: 13.5px;
        outline: none;
        transition: all .2s ease;
        font-family: inherit;
    }
    .form-control:focus {
        border-color: var(--border-hover);
        background: var(--surface-strong);
    }
    select.form-control {
        appearance: auto;
    }
    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }
    .form-error {
        color: var(--danger);
        font-size: 12px;
        margin-top: 4px;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 24px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all .2s ease;
    }
    .btn-primary {
        background: var(--emerald);
        color: #052117;
        box-shadow: 0 4px 20px rgba(var(--emerald-rgb), 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 26px rgba(var(--emerald-rgb), 0.45);
    }
    .btn-outline {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
    }
    .btn-outline:hover {
        background: var(--surface-strong);
        border-color: var(--border-hover);
    }
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    .info-box {
        background: var(--surface-strong);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 20px;
    }
    .info-box .label {
        font-size: 12px;
        color: var(--text-faint);
    }
    .info-box .value {
        font-size: 15px;
        font-weight: 600;
        font-family: 'IBM Plex Mono', monospace;
    }
</style>

<div class="page-head">
    <div>
        <h1>Edit Penawaran</h1>
        <p>Perbarui data penawaran.</p>
    </div>
</div>

<div class="form-card">
    <div class="info-box">
        <div class="label">Nomor Penawaran</div>
        <div class="value">{{ $quote->quote_number }}</div>
    </div>

    <form method="POST" action="{{ route('quotes.update', $quote) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Klien <span class="required">*</span></label>
            <select name="client_id" class="form-control" required>
                <option value="">Pilih Klien</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id', $quote->client_id) == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} {{ $client->company_name ? '- ' . $client->company_name : '' }}
                    </option>
                @endforeach
            </select>
            @error('client_id') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label>Tanggal Terbit <span class="required">*</span></label>
                <input type="date" name="issue_date" value="{{ old('issue_date', $quote->issue_date->format('Y-m-d')) }}" class="form-control" required>
                @error('issue_date') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Berlaku Sampai <span class="required">*</span></label>
                <input type="date" name="valid_until" value="{{ old('valid_until', $quote->valid_until->format('Y-m-d')) }}" class="form-control" required>
                @error('valid_until') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label>Subtotal <span class="required">*</span></label>
                <input type="number" name="subtotal" value="{{ old('subtotal', $quote->subtotal) }}" step="0.01" min="0" class="form-control" required>
                @error('subtotal') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Pajak</label>
                <input type="number" name="tax_amount" value="{{ old('tax_amount', $quote->tax_amount) }}" step="0.01" min="0" class="form-control">
                @error('tax_amount') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Status <span class="required">*</span></label>
            <select name="status" class="form-control" required>
                <option value="draft" {{ old('status', $quote->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="sent" {{ old('status', $quote->status) == 'sent' ? 'selected' : '' }}>Terkirim</option>
                <option value="accepted" {{ old('status', $quote->status) == 'accepted' ? 'selected' : '' }}>Diterima</option>
                <option value="rejected" {{ old('status', $quote->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="expired" {{ old('status', $quote->status) == 'expired' ? 'selected' : '' }}>Kadaluwarsa</option>
            </select>
            @error('status') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Catatan</label>
            <textarea name="notes" class="form-control">{{ old('notes', $quote->notes) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('quotes.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
</x-app-layout>