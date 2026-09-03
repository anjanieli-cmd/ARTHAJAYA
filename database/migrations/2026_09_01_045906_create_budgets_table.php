<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->string('period');
            $table->bigInteger('target')->default(0);
            $table->bigInteger('actual')->default(0);
            $table->unsignedTinyInteger('progress')->default(0);
            $table->enum('status', ['on_track', 'over_budget', 'under_budget'])->default('on_track');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};