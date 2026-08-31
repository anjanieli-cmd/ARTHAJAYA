<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout(string $plan)
    {
        if ($plan === 'free') {
            return redirect()->route('pricing.select', 'free');
        }

        $selectedPlan = Plan::where('slug', $plan)->firstOrFail();

        // ===== Lengkapi atribut yang dibutuhkan view checkout.blade.php =====
        $selectedPlan->accent = $selectedPlan->slug === 'gold' ? 'gold' : 'emerald';
        $selectedPlan->period = '/bulan';
        $selectedPlan->label  = 'Rp' . number_format($selectedPlan->price, 0, ',', '.') . $selectedPlan->period;

        // FIX: features_list bisa null (accessor tidak ada / data kosong di DB).
        // Fallback berlapis supaya @foreach($plan->features) di view tidak pernah menerima null.
        $features = $selectedPlan->features_list
            ?? $selectedPlan->features
            ?? [];

        // Jika hasilnya masih bukan array (misal string JSON mentah), amankan juga.
        if (!is_array($features)) {
            $decoded = json_decode($features, true);
            $features = is_array($decoded) ? $decoded : [];
        }

        $selectedPlan->features = $features;
        $selectedPlan->billing_period = $selectedPlan->billing_period ?? 'monthly';

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
        $selectedPlan = Plan::where('slug', $plan)->firstOrFail();

        $request->validate([
            'payment_method' => ['required', 'in:bank_transfer,e_wallet,credit_card,qris'],
        ], [
            'payment_method.required' => 'Pilih metode pembayaran terlebih dahulu.',
        ]);

        $user = auth()->user();
        $company = $user->company ?? null;

        if (!$company) {
            return back()->withErrors(['company' => 'Company tidak ditemukan untuk user ini.']);
        }

        $enabledPayments = match ($request->payment_method) {
            'bank_transfer' => ['bca_va', 'bni_va', 'bri_va', 'permata_va', 'other_va'],
            'e_wallet'      => ['gopay', 'shopeepay'],
            'credit_card'   => ['credit_card'],
            'qris'          => ['other_qris'],
        };

        $orderId = 'ORDER-' . $selectedPlan->slug . '-' . $company->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $selectedPlan->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
            ],
            'item_details' => [[
                'id'       => $selectedPlan->slug,
                'price'    => (int) $selectedPlan->price,
                'quantity' => 1,
                'name'     => $selectedPlan->name,
            ]],
            'enabled_payments' => $enabledPayments,
        ];

        $snapToken = Snap::getSnapToken($params);

        Transaction::create([
            'company_id'   => $company->id,
            'plan_id'      => $selectedPlan->id,
            'order_id'     => $orderId,
            'amount'       => $selectedPlan->price,
            'status'       => 'pending',
            'payment_type' => $request->payment_method,
        ]);

        return view('payment.snap', [
            'snapToken' => $snapToken,
            'plan'      => $selectedPlan,
        ]);
    }

    public function notification(Request $request)
    {
        $notif = new Notification();

        $transaction = Transaction::where('order_id', $notif->order_id)->first();

        if (!$transaction) {
            return response()->json(['status' => 'order not found'], 404);
        }

        $status = match (true) {
            in_array($notif->transaction_status, ['capture', 'settlement']) => 'success',
            in_array($notif->transaction_status, ['deny', 'expire', 'cancel']) => 'failed',
            default => 'pending',
        };

        $transaction->update([
            'status'            => $status,
            'payment_type'      => $notif->payment_type,
            'midtrans_response' => json_decode(json_encode($notif), true),
        ]);

        if ($status === 'success') {
            $transaction->company->update([
                'plan'             => $transaction->plan->slug,
                'plan_upgraded_at' => now(),
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}