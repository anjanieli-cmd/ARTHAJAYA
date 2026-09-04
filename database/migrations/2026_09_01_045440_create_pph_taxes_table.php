<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pph_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('period');
            $table->bigInteger('gross')->default(0);
            $table->bigInteger('deduction')->default(0);
            $table->bigInteger('taxable')->default(0);
            $table->bigInteger('tax')->default(0);
            $table->enum('status', ['paid', 'pending'])->default('pending');
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pph_taxes');
    }
};