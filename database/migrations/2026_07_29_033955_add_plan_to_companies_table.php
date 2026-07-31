<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_plan_to_companies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('plan')->default('free')->after('status'); // free | platinum | gold
            $table->timestamp('plan_upgraded_at')->nullable()->after('plan');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['plan', 'plan_upgraded_at']);
        });
    }
};