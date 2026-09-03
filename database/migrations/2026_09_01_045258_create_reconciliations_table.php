<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reconciliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('period')->nullable();
            $table->string('description')->nullable();
            $table->date('date');
            $table->bigInteger('bank_balance')->default(0);
            $table->bigInteger('book_balance')->default(0);
            $table->enum('status', ['cocok', 'belum'])->default('belum');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reconciliations');
    }
};