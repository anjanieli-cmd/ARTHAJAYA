<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete(); // tiap company punya daftar akun sendiri
            $table->string('code', 20);              // contoh: '1-101'
            $table->string('name');                  // contoh: 'Kas'
            $table->enum('type', ['asset', 'liability', 'equity', 'revenue', 'expense']); // Aset/Kewajiban/Modal/Pendapatan/Biaya
            $table->enum('normal_balance', ['debit', 'credit']); // saldo normal akun ini
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'code']); // kode akun unik per company
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};