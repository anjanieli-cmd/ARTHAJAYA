<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ExpenseCategory extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];

    /**
     * Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->logFillable();
    }

    /**
     * Relasi ke Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relasi ke Expense
     *
     * Satu kategori dapat memiliki banyak pengeluaran.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(
            Expense::class,
            'expense_category_id'
        );
    }

    /**
     * Total seluruh pengeluaran dalam kategori ini
     */
    public function getTotalExpensesAttribute()
    {
        return $this->expenses()
            ->where('company_id', $this->company_id)
            ->sum('amount');
    }

    /**
     * Jumlah pengeluaran dalam kategori ini
     */
    public function getCountExpensesAttribute()
    {
        return $this->expenses()
            ->where('company_id', $this->company_id)
            ->count();
    }
}