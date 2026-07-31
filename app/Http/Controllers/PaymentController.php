<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Daftar detail paket berbayar.
     * NOTE: samain dengan data $plans yang ada di halaman pricing.
     * Kalau kamu simpan data paket di tempat lain (misal config/plans.php
     * atau tabel `plans` di database), ganti bagian ini untuk ambil dari sana.
     */
    protected function planData(): array
    {
        return [
            'platinum' => [
                'name'  => 'Platinum',
                'price' => 149000,
                'label' => 'Rp 149.000',
                'period' => '/bulan',
                'accent' => 'emerald',
                'features' => [
                    'Semua fitur Free',
                    'Piutang & Utang + Aging Report',
                    'Perbankan & Rekonsiliasi',
                    'Laba Rugi, Neraca, Arus Kas',
                    'Manajemen Inventaris',
                ],
            ],
            'gold' => [
                'name'  => 'Gold',
                'price' => 349000,
                'label' => 'Rp 349.000',
                'period' => '/bulan',
                'accent' => 'gold',
                'features' => [
                    'Semua fitur Platinum',
                    'Payroll & Data Karyawan',
                    'Pajak (PPh, PPN, Kalender Pajak)',
                    'Anggaran & Forecasting',
                    'Multi-User & Hak Akses',
                ],
            ],
        ];
    }

    /**
     * Tampilkan halaman checkout / pembayaran untuk paket yang dipilih.
     */
    public function checkout(string $plan)
    {
        $plans = $this->planData();

        // Paket Free nggak butuh pembayaran, langsung lempar balik ke pricing.
        if ($plan === 'free') {
            return redirect()->route('pricing.index');
        }

        // Kalau plan yang diminta nggak valid / nggak ada di daftar
        if (!isset($plans[$plan])) {
            abort(404, 'Paket tidak ditemukan.');
        }

        $selectedPlan = $plans[$plan];

        // Ambil data company yang sedang login.
        // NOTE: sesuaikan ini dengan cara kamu ambil company yang aktif.
        // Contoh umum: auth()->user()->company, atau session('company'), dll.
        $company = auth()->user()->company ?? null;

        return view('payment.checkout', [
            'planKey'      => $plan,
            'plan'         => $selectedPlan,
            'company'      => $company,
            'invoiceNo'    => 'INV-' . strtoupper(Str::random(8)),
        ]);
    }

    /**
     * Proses pembayaran (simulasi) lalu upgrade/downgrade paket company.
     */
    public function process(Request $request, string $plan)
    {
        $plans = $this->planData();

        if (!isset($plans[$plan])) {
            abort(404, 'Paket tidak ditemukan.');
        }

        $request->validate([
            'payment_method' => ['required', 'in:bank_transfer,e_wallet,credit_card'],
        ], [
            'payment_method.required' => 'Pilih metode pembayaran terlebih dahulu.',
        ]);

        // ===== SIMULASI PROSES PEMBAYARAN =====
        // Di sini biasanya kamu integrasi ke payment gateway
        // (Midtrans, Xendit, dsb). Untuk sekarang kita anggap
        // pembayaran selalu berhasil dan langsung update plan.

        $company = auth()->user()->company ?? null;

        if ($company) {
            $company->plan = $plan;
            $company->save();
        }

        return redirect()
            ->route('pricing.index')
            ->with('success', 'Pembayaran berhasil! Paket kamu sekarang ' . $plans[$plan]['name'] . '.');
    }
}