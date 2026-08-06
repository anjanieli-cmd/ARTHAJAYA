<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];

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