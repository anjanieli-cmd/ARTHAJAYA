<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CogsEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'inventory_item_id',
        'item_name',
        'quantity_sold',
        'unit_cost',
        'total_cogs',
        'sale_date',
        'notes',
    ];

    protected $casts = [
        'sale_date'     => 'date',
        'quantity_sold' => 'integer',
        'unit_cost'     => 'decimal:2',
        'total_cogs'    => 'decimal:2',
    ];

    protected static function booted(): void
    {
        // total_cogs selalu dihitung ulang otomatis, tidak pernah diinput manual
        static::saving(function (CogsEntry $entry) {
            $entry->total_cogs = (float) $entry->quantity_sold * (float) $entry->unit_cost;
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}