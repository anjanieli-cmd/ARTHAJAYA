<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // 'h-7', 'h-3', 'h-1', 'expired'
            $table->timestamp('plan_expires_at_snapshot'); // nilai plan_expires_at saat notif dikirim
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->unique(['company_id', 'type', 'plan_expires_at_snapshot'], 'uniq_company_type_expiry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_notifications');
    }
};