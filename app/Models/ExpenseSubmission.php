<?php

namespace App\Models;

use App\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;

class ExpenseSubmission extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id', 'submitted_by', 'description', 'amount',
        'category', 'expense_date', 'status', 'note',
        'reviewed_by', 'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
            'reviewed_at'  => 'datetime',
            'amount'       => 'decimal:2',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}