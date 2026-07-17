<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cogs_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->nullable()->constrained('inventory_items')->nullOnDelete();
            $table->string('item_name'); // snapshot nama barang, tetap ada walau barang aslinya dihapus
            $table->integer('quantity_sold');
            $table->decimal('unit_cost', 15, 2);
            $table->decimal('total_cogs', 15, 2)->default(0);
            $table->date('sale_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'sale_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cogs_entries');
    }
};