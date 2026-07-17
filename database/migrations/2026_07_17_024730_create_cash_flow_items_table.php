<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_flow_items', function (Blueprint $table) {
            $table->id();
            $table->enum('activity_type', ['operasional', 'investasi', 'pendanaan']);
            $table->enum('direction', ['masuk', 'keluar']);
            $table->string('category');
            $table->string('name');
            $table->decimal('amount', 15, 2)->default(0);
            $table->unsignedTinyInteger('period_month');
            $table->unsignedSmallInteger('period_year');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['period_year', 'period_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_flow_items');
    }
};