<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chart_of_account_id')->constrained()->cascadeOnDelete();
            $table->date('transaction_date');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->string('description')->nullable();

            // Buat tau transaksi ini asalnya dari mana (expense, piutang, midtrans, dll)
            $table->string('reference_type')->nullable();  // contoh: 'App\Models\ExpenseSubmission'
            $table->unsignedBigInteger('reference_id')->nullable(); // contoh: id dari expense itu

            $table->timestamps();

            $table->index(['company_id', 'transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};