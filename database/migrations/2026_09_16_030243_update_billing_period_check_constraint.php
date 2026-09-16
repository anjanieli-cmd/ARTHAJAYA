<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE subscription_plans DROP CONSTRAINT IF EXISTS subscription_plans_billing_period_check');

        DB::statement("ALTER TABLE subscription_plans ADD CONSTRAINT subscription_plans_billing_period_check CHECK (billing_period IN ('minutes', 'hours', 'days', 'monthly', 'yearly'))");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE subscription_plans DROP CONSTRAINT IF EXISTS subscription_plans_billing_period_check');

        DB::statement("ALTER TABLE subscription_plans ADD CONSTRAINT subscription_plans_billing_period_check CHECK (billing_period IN ('monthly', 'yearly'))");
    }
};