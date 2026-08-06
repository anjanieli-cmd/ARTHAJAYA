<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();

            // Relasi ke akun karyawan & perusahaan
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();

            // Data kerja - diisi/diedit Staff, BUKAN si karyawan
            $table->string('position')->nullable();      // Posisi/jabatan
            $table->string('department')->nullable();    // Departemen
            $table->unsignedBigInteger('basic_salary')->nullable(); // Gaji pokok
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('joined_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};