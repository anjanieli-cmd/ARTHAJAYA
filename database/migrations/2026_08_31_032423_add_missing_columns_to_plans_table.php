<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->text('description')->nullable()->after('price');
            $table->string('billing_period')->default('monthly')->after('description');
            $table->unsignedInteger('max_users')->nullable()->after('billing_period');
            $table->boolean('is_active')->default(true)->after('max_users');
            $table->string('color')->nullable()->after('is_active');
            $table->string('icon')->nullable()->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['description', 'billing_period', 'max_users', 'is_active', 'color', 'icon']);
        });
    }
};