<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->string('invoice')->unique();
            $table->date('date');
            $table->date('due');
            $table->enum('status', ['lancar', 'jatuh_tempo', 'lunas'])->default('lancar');
            $table->decimal('amount', 15, 2);
            $table->json('items')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Index untuk performance
            $table->index(['status', 'due']);
            $table->index('client');
            $table->index('invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivables');
    }
};