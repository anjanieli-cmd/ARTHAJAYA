<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_plans', 'description')) {
                $table->text('description')->nullable()->after('price');
            }
            if (!Schema::hasColumn('subscription_plans', 'billing_period')) {
                $table->string('billing_period')->default('monthly')->after('description');
            }
            if (!Schema::hasColumn('subscription_plans', 'max_users')) {
                $table->unsignedInteger('max_users')->nullable()->after('billing_period');
            }
            if (!Schema::hasColumn('subscription_plans', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('max_users');
            }
            if (!Schema::hasColumn('subscription_plans', 'color')) {
                $table->string('color')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('subscription_plans', 'icon')) {
                $table->string('icon')->nullable()->after('color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $columns = ['description', 'billing_period', 'max_users', 'is_active', 'color', 'icon'];
            $existing = array_filter($columns, fn($col) => Schema::hasColumn('subscription_plans', $col));
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};