<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Expense extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id',
        'expense_category_id',
        'description',
        'date',
        'status',
        'amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->logFillable();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(
            ExpenseCategory::class,
            'expense_category_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}