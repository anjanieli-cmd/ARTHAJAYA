<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'sku',
        'name',
        'category',
        'unit',
        'stock_quantity',
        'reorder_level',
        'cost_price',
        'selling_price',
        'description',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'reorder_level'  => 'integer',
        'cost_price'     => 'decimal:2',
        'selling_price'  => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function cogsEntries()
    {
        return $this->hasMany(CogsEntry::class);
    }

    // Nilai total stok barang ini (qty x harga pokok)
    public function getStockValueAttribute(): float
    {
        return (float) $this->stock_quantity * (float) $this->cost_price;
    }

    // Apakah stok sudah di bawah/sama dengan batas minimum
    public function getIsLowStockAttribute(): bool
    {
        return $this->stock_quantity <= $this->reorder_level;
    }

    // Persentase kesehatan stok untuk progress bar (target sehat = 3x reorder level)
    public function getStockPercentAttribute(): int
    {
        $target = $this->reorder_level > 0 ? $this->reorder_level * 3 : max($this->stock_quantity, 1);

        return (int) min(100, round(($this->stock_quantity / $target) * 100));
    }

    // Estimasi margin per unit dalam persen
    public function getMarginPercentAttribute(): float
    {
        if ((float) $this->selling_price <= 0) {
            return 0;
        }

        return round((($this->selling_price - $this->cost_price) / $this->selling_price) * 100, 1);
    }
}