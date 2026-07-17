<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('neraca_items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['aset', 'kewajiban', 'modal']);
            $table->string('category');
            $table->string('name');
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('as_of_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('as_of_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('neraca_items');
    }
};