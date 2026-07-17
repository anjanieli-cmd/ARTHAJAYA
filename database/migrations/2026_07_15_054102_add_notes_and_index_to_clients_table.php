<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Tambah kolom notes setelah address
            $table->text('notes')->nullable()->after('address');
            
            // Tambah index untuk company_id dan name
            $table->index(['company_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->dropIndex(['company_id', 'name']);
        });
    }
};