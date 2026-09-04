<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (! Schema::hasColumn('subscription_plans', 'description')) {
                $table->text('description')->nullable();
            }
            if (! Schema::hasColumn('subscription_plans', 'billing_period')) {
                $table->string('billing_period')->default('monthly');
            }
            if (! Schema::hasColumn('subscription_plans', 'max_users')) {
                $table->unsignedInteger('max_users')->nullable();
            }
            if (! Schema::hasColumn('subscription_plans', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            // color & icon sudah ditambahkan lewat migration
            // add_color_and_icon_to_subscription_plans_table -- dilewati di sini.
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $columns = ['description', 'billing_period', 'max_users', 'is_active'];
            $existing = array_filter($columns, fn ($col) => Schema::hasColumn('subscription_plans', $col));

            if (! empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};