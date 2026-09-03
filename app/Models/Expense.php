<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'company_id', 'expense_category_id', 'description',
        'date', 'status', 'amount', 'notes',
    ];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}