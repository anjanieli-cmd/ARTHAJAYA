<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('expense_category_id')
                ->nullable()
                ->after('expense_submission_id')
                ->constrained('expense_categories')
                ->nullOnDelete();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->renameColumn('expense_date', 'date');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('expense_category_id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->renameColumn('date', 'expense_date');
        });
    }
};