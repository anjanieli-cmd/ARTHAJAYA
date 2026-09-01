<x-app-layout>
<x-slot name="title">Pembayaran</x-slot>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<div style="text-align:center;padding:60px 20px">
    <h2 style="margin-bottom:8px">Memproses pembayaran</h2>
    <p style="color:var(--text-mute);margin-bottom:24px">{{ $plan->name }} — Rp{{ number_format($plan->price, 0, ',', '.') }}</p>
    <button id="pay-btn" style="padding:13px 32px;border-radius:12px;background:#6366f1;color:#fff;border:none;cursor:pointer;font-weight:700;font-size:14px">
        Bayar Sekarang
    </button>
</div>

<script>
document.getElementById('pay-btn').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            window.location.href = "{{ route('pricing.index') }}?status=success";
        },
        onPending: function(result) {
            window.location.href = "{{ route('pricing.index') }}?status=pending";
        },
        onError: function(result) {
            alert('Pembayaran gagal, coba lagi.');
        },
        onClose: function() {
            // user nutup popup tanpa nyelesain pembayaran
        }
    });
};
</script>
</x-app-layout>