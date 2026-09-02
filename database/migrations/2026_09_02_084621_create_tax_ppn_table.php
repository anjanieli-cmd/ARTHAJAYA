<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_ppn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('period');
            $table->decimal('output', 15, 2)->default(0);
            $table->decimal('input', 15, 2)->default(0);
            $table->decimal('ppn', 15, 2)->default(0);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->date('due');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_ppn');
    }
};