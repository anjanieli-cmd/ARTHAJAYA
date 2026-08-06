<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->cascadeOnDelete();

            // Kalau expense ini asalnya dari pengajuan user yang di-approve staff,
            // kita simpan referensinya di sini. Nullable karena staff juga bisa
            // input expense manual langsung (tanpa lewat pengajuan user).
            $table->foreignId('expense_submission_id')
                ->nullable()
                ->constrained('expense_submissions')
                ->nullOnDelete();

            // Staff/user yang mencatat expense ini ke pembukuan resmi
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->string('description');
            $table->string('category')->default('Lainnya');
            $table->date('expense_date');
            $table->decimal('amount', 15, 2);

            // Status pembayaran (bukan status approval — itu urusan expense_submissions)
            $table->enum('status', ['lunas', 'pending'])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['company_id', 'expense_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};