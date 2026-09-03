<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('vendor');
            $table->string('bill_number');
            $table->date('date');
            $table->date('due');
            $table->string('category')->nullable();
            $table->enum('status', ['lancar', 'jatuh_tempo', 'lunas'])->default('lancar');
            $table->decimal('amount', 15, 2);
            $table->json('items')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'status', 'due']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payables');
    }
};