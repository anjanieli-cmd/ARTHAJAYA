<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('subscription_plans')->cascadeOnDelete();
            $table->string('order_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending'); // pending, success, failed
            $table->string('payment_type')->nullable(); // bank_transfer, e_wallet, credit_card, qris
            $table->json('midtrans_response')->nullable(); // simpan payload notifikasi dari Midtrans
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};