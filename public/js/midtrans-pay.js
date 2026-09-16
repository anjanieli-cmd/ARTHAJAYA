document.addEventListener('DOMContentLoaded', function () {

    const payButton = document.getElementById('pay-btn');
    const errorBox = document.getElementById('pay-error');

    const snapToken = payButton.dataset.snapToken;
    const successUrl = payButton.dataset.successUrl;
    const pendingUrl = payButton.dataset.pendingUrl;

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
                window.location.href = successUrl;
            },

            onPending: function (result) {
                console.log('Payment pending:', result);
                window.location.href = pendingUrl;
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