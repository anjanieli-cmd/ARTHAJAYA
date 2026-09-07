<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    /**
     * Konfigurasi Midtrans.
     */
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');

        Config::$isProduction =
            (bool) config('services.midtrans.is_production', false);

        Config::$isSanitized = true;
        Config::$is3ds = true;
    }


    /**
     * Menampilkan halaman checkout.
     */
    public function checkout(string $plan)
    {
        // Paket Free tidak perlu pembayaran.
        if ($plan === 'free') {
            return redirect()->route(
                'pricing.select',
                ['plan' => 'free']
            );
        }

        // Ambil paket berdasarkan slug.
        $selectedPlan = Plan::where('slug', $plan)->firstOrFail();

        // =========================================================
        // ATTRIBUTE UNTUK VIEW
        // =========================================================

        $selectedPlan->accent =
            $selectedPlan->slug === 'gold'
                ? 'gold'
                : 'emerald';

        $selectedPlan->period = '/bulan';

        $selectedPlan->label =
            'Rp' .
            number_format(
                $selectedPlan->price,
                0,
                ',',
                '.'
            ) .
            $selectedPlan->period;


        // =========================================================
        // FEATURES
        // =========================================================

        $features =
            $selectedPlan->features_list
            ?? $selectedPlan->features
            ?? [];

        if (!is_array($features)) {

            $decoded = json_decode(
                $features,
                true
            );

            $features =
                is_array($decoded)
                    ? $decoded
                    : [];
        }

        $selectedPlan->features = $features;


        // =========================================================
        // BILLING PERIOD
        // =========================================================

        $selectedPlan->billing_period =
            $selectedPlan->billing_period
            ?? 'monthly';


        // =========================================================
        // COMPANY
        // =========================================================

        $company =
            auth()->user()->company ?? null;


        // =========================================================
        // INVOICE NUMBER
        // =========================================================

        $invoiceNo =
            'INV-' .
            strtoupper(Str::random(8));


        return view('payment.checkout', [

            'planKey' => $plan,

            'plan' => $selectedPlan,

            'company' => $company,

            'invoiceNo' => $invoiceNo,

        ]);
    }


    /**
     * Memproses pembayaran dan membuat Snap Token Midtrans.
     */
    public function process(
        Request $request,
        string $plan
    ) {

        // =========================================================
        // AMBIL PLAN
        // =========================================================

        $selectedPlan =
            Plan::where('slug', $plan)
                ->firstOrFail();


        // =========================================================
        // VALIDASI METODE PEMBAYARAN
        // =========================================================

        $validated =
            $request->validate([

                'payment_method' => [
                    'required',
                    'in:bank_transfer,e_wallet,credit_card,qris',
                ],

            ], [

                'payment_method.required' =>
                    'Pilih metode pembayaran terlebih dahulu.',

                'payment_method.in' =>
                    'Metode pembayaran tidak valid.',

            ]);


        // =========================================================
        // USER
        // =========================================================

        $user = auth()->user();


        // =========================================================
        // COMPANY
        // =========================================================

        $company =
            $user->company ?? null;

        if (!$company) {

            return back()
                ->withErrors([
                    'company' =>
                        'Company tidak ditemukan untuk user ini.',
                ])
                ->withInput();
        }


        // =========================================================
        // MIDTRANS PAYMENT METHOD
        // =========================================================

        switch ($validated['payment_method']) {

            case 'bank_transfer':

                $enabledPayments = [
                    'bca_va',
                    'bni_va',
                    'bri_va',
                    'permata_va',
                    'other_va',
                ];

                break;


            case 'e_wallet':

                $enabledPayments = [
                    'gopay',
                    'shopeepay',
                ];

                break;


            case 'credit_card':

                $enabledPayments = [
                    'credit_card',
                ];

                break;


            case 'qris':

                $enabledPayments = [
                    'other_qris',
                ];

                break;


            default:

                return back()
                    ->withErrors([
                        'payment' =>
                            'Metode pembayaran tidak tersedia.',
                    ])
                    ->withInput();
        }


        // =========================================================
        // ORDER ID
        // =========================================================

        $orderId =
            'ORDER-' .
            strtoupper($selectedPlan->slug) .
            '-' .
            $company->id .
            '-' .
            time();


        // =========================================================
        // MIDTRANS PARAMETER
        // =========================================================

        $params = [

            'transaction_details' => [

                'order_id' =>
                    $orderId,

                'gross_amount' =>
                    (int) $selectedPlan->price,

            ],


            'customer_details' => [

                'first_name' =>
                    $user->name,

                'email' =>
                    $user->email,

            ],


            'item_details' => [[

                'id' =>
                    (string) $selectedPlan->slug,

                'price' =>
                    (int) $selectedPlan->price,

                'quantity' =>
                    1,

                'name' =>
                    $selectedPlan->name,

            ]],


            'enabled_payments' =>
                $enabledPayments,

        ];


        // =========================================================
        // LOG UNTUK DEBUG
        // =========================================================

        Log::info(
            'Memulai transaksi Midtrans',
            [
                'order_id' =>
                    $orderId,

                'plan' =>
                    $selectedPlan->slug,

                'amount' =>
                    $selectedPlan->price,

                'payment_method' =>
                    $validated['payment_method'],

                'enabled_payments' =>
                    $enabledPayments,

                'is_production' =>
                    Config::$isProduction,
            ]
        );


        // =========================================================
        // REQUEST SNAP TOKEN
        // =========================================================

        try {

            $snapToken =
                Snap::getSnapToken($params);

        } catch (\Throwable $e) {

            // Simpan error lengkap ke log.
            Log::error(
                'Midtrans getSnapToken gagal',
                [

                    'message' =>
                        $e->getMessage(),

                    'file' =>
                        $e->getFile(),

                    'line' =>
                        $e->getLine(),

                    'order_id' =>
                        $orderId,

                    'company_id' =>
                        $company->id,

                    'plan' =>
                        $selectedPlan->slug,

                ]
            );


            /*
             * UNTUK DEBUG:
             * Error asli ditampilkan sementara.
             *
             * Kalau aplikasi sudah selesai testing,
             * pesan ini bisa diganti dengan pesan umum.
             */

            return back()
                ->withErrors([
                    'payment' =>
                        'Midtrans error: ' .
                        $e->getMessage(),
                ])
                ->withInput();
        }


        // =========================================================
        // SIMPAN TRANSAKSI
        // =========================================================

        try {

            DB::transaction(function () use (
                $company,
                $selectedPlan,
                $orderId,
                $validated
            ) {

                Transaction::create([

                    'company_id' =>
                        $company->id,

                    'plan_id' =>
                        $selectedPlan->id,

                    'order_id' =>
                        $orderId,

                    'amount' =>
                        $selectedPlan->price,

                    'status' =>
                        'pending',

                    'payment_type' =>
                        $validated['payment_method'],

                ]);

            });

        } catch (\Throwable $e) {

            Log::error(
                'Gagal menyimpan transaksi pembayaran',
                [

                    'message' =>
                        $e->getMessage(),

                    'order_id' =>
                        $orderId,

                    'company_id' =>
                        $company->id,

                ]
            );


            return back()
                ->withErrors([
                    'payment' =>
                        'Transaksi berhasil terhubung ke Midtrans, tetapi gagal disimpan. Silakan coba lagi.',
                ])
                ->withInput();
        }


        // =========================================================
        // ARAHKAN KE HALAMAN SNAP
        // =========================================================

        return view('payment.snap', [

            'snapToken' =>
                $snapToken,

            'plan' =>
                $selectedPlan,

            'orderId' =>
                $orderId,

        ]);
    }


    /**
     * Webhook / Notification dari Midtrans.
     */
    public function notification(Request $request)
    {
        try {

            $notif =
                new Notification();

        } catch (\Throwable $e) {

            Log::error(
                'Midtrans notification tidak valid',
                [
                    'message' =>
                        $e->getMessage(),
                ]
            );

            return response()->json(
                [
                    'status' =>
                        'invalid notification',
                ],
                400
            );
        }


        // =========================================================
        // CARI TRANSAKSI
        // =========================================================

        $transaction =
            Transaction::where(
                'order_id',
                $notif->order_id
            )->first();


        if (!$transaction) {

            Log::warning(
                'Midtrans notification: order_id tidak ditemukan',
                [
                    'order_id' =>
                        $notif->order_id,
                ]
            );

            return response()->json(
                [
                    'status' =>
                        'order not found',
                ],
                404
            );
        }


        // =========================================================
        // STATUS
        // =========================================================

        $status =
            match (true) {

                in_array(
                    $notif->transaction_status,
                    [
                        'capture',
                        'settlement',
                    ]
                )
                    => 'success',


                in_array(
                    $notif->transaction_status,
                    [
                        'deny',
                        'expire',
                        'cancel',
                    ]
                )
                    => 'failed',


                default
                    => 'pending',
            };


        // =========================================================
        // UPDATE TRANSAKSI
        // =========================================================

        $transaction->update([

            'status' =>
                $status,

            'payment_type' =>
                $notif->payment_type,

            'midtrans_response' =>
                json_decode(
                    json_encode($notif),
                    true
                ),

        ]);


        // =========================================================
        // AKTIFKAN PLAN COMPANY
        // =========================================================

        if ($status === 'success') {

            $companyColumns =
                Schema::getColumnListing(
                    'companies'
                );


            $updateData = [];


            if (
                in_array(
                    'plan',
                    $companyColumns
                )
            ) {

                $updateData['plan'] =
                    $transaction
                        ->plan
                        ->slug;
            }


            if (
                in_array(
                    'plan_upgraded_at',
                    $companyColumns
                )
            ) {

                $updateData['plan_upgraded_at'] =
                    now();
            }


            if (!empty($updateData)) {

                $transaction
                    ->company
                    ->update(
                        $updateData
                    );

            } else {

                Log::warning(
                    'Kolom plan/plan_upgraded_at belum ada di tabel companies.',
                    [
                        'company_id' =>
                            $transaction->company_id,
                    ]
                );
            }
        }


        return response()->json([
            'status' => 'ok',
        ]);
    }
}