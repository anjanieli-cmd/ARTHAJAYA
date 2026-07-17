<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeracaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'name',
        'amount',
        'as_of_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'as_of_date' => 'date',
    ];

    public function scopeAsOf($query, string $date)
    {
        return $query->whereDate('as_of_date', $date);
    }
}