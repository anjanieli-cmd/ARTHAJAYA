<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function checkout(string $plan)
    {
        if ($plan === 'free') {
            return redirect()->route('pricing.select', 'free');
        }

        $selectedPlan = SubscriptionPlan::where('slug', $plan)
            ->where('is_active', true)
            ->firstOrFail();

        // ===== Lengkapi atribut yang dibutuhkan view checkout.blade.php =====
        // Model asli cuma punya kolom database mentah; view butuh beberapa
        // nilai turunan (accent, period, label) dan fallback aman untuk features.
        $selectedPlan->accent  = $selectedPlan->slug === 'gold' ? 'gold' : 'emerald';
        $selectedPlan->period  = $selectedPlan->billing_period === 'monthly' ? '/bulan' : '/tahun';
        $selectedPlan->label   = 'Rp' . number_format($selectedPlan->price, 0, ',', '.') . $selectedPlan->period;
        $selectedPlan->features = $selectedPlan->features ?? [];

        $company = auth()->user()->company ?? null;

        return view('payment.checkout', [
            'planKey'   => $plan,
            'plan'      => $selectedPlan,
            'company'   => $company,
            'invoiceNo' => 'INV-' . strtoupper(Str::random(8)),
        ]);
    }

    public function process(Request $request, string $plan)
    {
        $selectedPlan = SubscriptionPlan::where('slug', $plan)
            ->where('is_active', true)
            ->firstOrFail();

        $request->validate([
            // Tambah 'qris' -- di view ada 4 pilihan metode, tapi validasi
            // sebelumnya cuma izinin 3, jadi QRIS selalu gagal validasi.
            'payment_method' => ['required', 'in:bank_transfer,e_wallet,credit_card,qris'],
        ], [
            'payment_method.required' => 'Pilih metode pembayaran terlebih dahulu.',
        ]);

        $company = auth()->user()->company ?? null;

        if ($company) {
            $company->update([
                'plan'             => $selectedPlan->slug,
                'plan_upgraded_at' => now(),
            ]);
        }

        return redirect()
            ->route('pricing.index')
            ->with('success', 'Pembayaran berhasil! Paket kamu sekarang ' . $selectedPlan->name . '.');
    }
}