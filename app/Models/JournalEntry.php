<?php

namespace App\Models;

use App\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id', 'chart_of_account_id', 'transaction_date',
        'debit', 'credit', 'description', 'reference_type', 'reference_id',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'chart_of_account_id');
    }
}