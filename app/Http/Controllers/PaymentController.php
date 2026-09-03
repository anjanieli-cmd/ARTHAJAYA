<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        $features = $selectedPlan->features_list
            ?? $selectedPlan->features
            ?? [];

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

        try {
            // Minta token dulu ke Midtrans. Kalau gagal, exception di-catch
            // di bawah dan transaksi TIDAK akan tersimpan (tidak ada data nyangkut).
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans getSnapToken gagal: ' . $e->getMessage(), [
                'order_id' => $orderId,
                'company_id' => $company->id,
            ]);

            return back()->withErrors([
                'payment' => 'Gagal menghubungi layanan pembayaran. Silakan coba lagi dalam beberapa saat.',
            ]);
        }

        // Simpan transaksi HANYA setelah token berhasil didapat.
        DB::transaction(function () use ($company, $selectedPlan, $orderId, $request) {
            Transaction::create([
                'company_id'   => $company->id,
                'plan_id'      => $selectedPlan->id,
                'order_id'     => $orderId,
                'amount'       => $selectedPlan->price,
                'status'       => 'pending',
                'payment_type' => $request->payment_method,
            ]);
        });

        return view('payment.snap', [
            'snapToken' => $snapToken,
            'plan'      => $selectedPlan,
        ]);
    }

    public function notification(Request $request)
    {
        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans notification tidak valid: ' . $e->getMessage());
            return response()->json(['status' => 'invalid notification'], 400);
        }

        $transaction = Transaction::where('order_id', $notif->order_id)->first();

        if (!$transaction) {
            Log::warning('Midtrans notification: order_id tidak ditemukan', ['order_id' => $notif->order_id]);
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
            // Guard: hanya update kolom yang memang ada di tabel companies,
            // supaya tidak crash kalau kolomnya belum ditambahkan lewat migration.
            $companyColumns = \Illuminate\Support\Facades\Schema::getColumnListing('companies');

            $updateData = [];
            if (in_array('plan', $companyColumns)) {
                $updateData['plan'] = $transaction->plan->slug;
            }
            if (in_array('plan_upgraded_at', $companyColumns)) {
                $updateData['plan_upgraded_at'] = now();
            }

            if (!empty($updateData)) {
                $transaction->company->update($updateData);
            } else {
                Log::warning('Kolom plan/plan_upgraded_at belum ada di tabel companies.', [
                    'company_id' => $transaction->company_id,
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}