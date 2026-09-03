<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->logFillable();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Hitung total pengeluaran untuk kategori ini
    public function getTotalExpensesAttribute()
    {
        return ExpenseSubmission::where('company_id', $this->company_id)
            ->where('category', $this->name)
            ->sum('amount');
    }

    // Hitung jumlah transaksi untuk kategori ini
    public function getCountExpensesAttribute()
    {
        return ExpenseSubmission::where('company_id', $this->company_id)
            ->where('category', $this->name)
            ->count();
    }
}