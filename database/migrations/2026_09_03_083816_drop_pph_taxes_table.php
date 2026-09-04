<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::dropIfExists('pph_taxes');
    }
    public function down(): void {
        // sengaja dikosongkan — tabel lama sudah tidak dipakai
    }
};