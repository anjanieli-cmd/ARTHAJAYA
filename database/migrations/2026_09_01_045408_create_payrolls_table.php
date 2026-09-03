<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('position')->nullable();
            $table->string('period');
            $table->bigInteger('basic_salary')->default(0);
            $table->bigInteger('allowance')->default(0);
            $table->bigInteger('deduction')->default(0);
            $table->bigInteger('total')->default(0);
            $table->enum('status', ['paid', 'pending'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};