<x-app-layout>
    <x-slot name="title">Pembayaran</x-slot>

    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <div style="text-align:center;padding:60px 20px">
        <h2 style="margin-bottom:8px">
            Mengarahkan ke pembayaran...
        </h2>

        <p style="color:var(--text-mute);margin-bottom:24px">
            {{ $plan->name }}
            — Rp{{ number_format($plan->price, 0, ',', '.') }}
        </p>

        <button
            type="button"
            id="pay-btn"
            style="
                padding:13px 32px;
                border-radius:12px;
                background:#f59e0b;
                color:#0f172a;
                border:none;
                cursor:pointer;
                font-weight:700;
                font-size:14px;
            "
        >
            Lanjutkan Pembayaran
        </button>

        <p id="pay-error" style="color:#f87171;margin-top:16px;display:none"></p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const snapToken = @json($snapToken);
            const payButton = document.getElementById('pay-btn');
            const errorBox = document.getElementById('pay-error');

            function showError(message) {
                errorBox.textContent = message;
                errorBox.style.display = 'block';
            }

            function openMidtrans() {
                errorBox.style.display = 'none';

                if (!snapToken) {
                    showError('Token pembayaran tidak ditemukan. Silakan muat ulang halaman.');
                    console.error('snapToken kosong:', snapToken);
                    return;
                }

                if (typeof snap === 'undefined') {
                    showError('Layanan pembayaran belum siap. Silakan coba lagi sebentar.');
                    console.error('Snap.js belum ter-load. Cek koneksi ke app.sandbox.midtrans.com atau ad-blocker.');
                    return;
                }

                snap.pay(snapToken, {

                    onSuccess: function (result) {
                        console.log('Payment success:', result);
                        window.location.href =
                            "{{ route('pricing.index') }}?status=success";
                    },

                    onPending: function (result) {
                        console.log('Payment pending:', result);
                        window.location.href =
                            "{{ route('pricing.index') }}?status=pending";
                    },

                    onError: function (result) {
                        console.error('Midtrans error:', result);
                        showError('Pembayaran gagal. Silakan coba lagi.');
                    },

                    onClose: function () {
                        console.log('Popup Midtrans ditutup oleh pengguna.');
                    }

                });
            }

            payButton.addEventListener('click', openMidtrans);
        });
    </script>
</x-app-layout>