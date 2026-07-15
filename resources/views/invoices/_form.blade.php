{{--
  Partial form dipakai bareng oleh create.blade.php & edit.blade.php.
  Membutuhkan CSS design-system yang sama seperti onboarding.blade.php
  (variabel --surface, --border, --emerald, dst). Taruh <style> tersebut
  di layout utama / file induk agar tidak duplikat di setiap halaman.
--}}
<div class="field-grid">
  <div class="field full">
    <label>Klien</label>
    <select name="client_id" required>
      <option value="">Pilih klien</option>
      @foreach($clients as $client)
        <option value="{{ $client->id }}" @selected(old('client_id', $invoice->client_id ?? null) == $client->id)>
          {{ $client->name }}{{ $client->company_name ? ' — '.$client->company_name : '' }}
        </option>
      @endforeach
    </select>
    @error('client_id') <div class="field-error">{{ $message }}</div> @enderror
    @if($clients->isEmpty())
      <div class="field-hint">Belum ada klien. Tambahkan klien dulu di menu <b>Penjualan &gt; Klien</b>.</div>
    @endif
  </div>

  <div class="field">
    <label>Tanggal terbit</label>
    <input type="date" name="issue_date" value="{{ old('issue_date', isset($invoice) ? $invoice->issue_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
    @error('issue_date') <div class="field-error">{{ $message }}</div> @enderror
  </div>

  <div class="field">
    <label>Jatuh tempo</label>
    <input type="date" name="due_date" value="{{ old('due_date', isset($invoice) ? $invoice->due_date->format('Y-m-d') : now()->addDays(14)->format('Y-m-d')) }}" required>
    @error('due_date') <div class="field-error">{{ $message }}</div> @enderror
  </div>

  <div class="field">
    <label>Status</label>
    <select name="status">
      @foreach(['draft'=>'Draft','sent'=>'Terkirim','paid'=>'Lunas','cancelled'=>'Dibatalkan'] as $val => $label)
        <option value="{{ $val }}" @selected(old('status', $invoice->status ?? 'draft') === $val)>{{ $label }}</option>
      @endforeach
    </select>
  </div>

  <div class="field">
    <label>Subtotal (Rp)</label>
    <input type="number" name="subtotal" min="0" step="0.01" value="{{ old('subtotal', $invoice->subtotal ?? 0) }}" required>
    @error('subtotal') <div class="field-error">{{ $message }}</div> @enderror
  </div>

  <div class="field">
    <label>Pajak (Rp) <span class="opt">(opsional)</span></label>
    <input type="number" name="tax_amount" min="0" step="0.01" value="{{ old('tax_amount', $invoice->tax_amount ?? 0) }}">
  </div>

  <div class="field full">
    <label>Catatan <span class="opt">(opsional)</span></label>
    <textarea name="notes" placeholder="Catatan tambahan untuk klien...">{{ old('notes', $invoice->notes ?? '') }}</textarea>
  </div>
</div>