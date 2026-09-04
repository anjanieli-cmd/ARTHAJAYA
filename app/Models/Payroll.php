<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id',
        'employee_id',
        'position',
        'period',
        'basic_salary',
        'allowance',
        'deduction',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'basic_salary' => 'integer',
        'allowance'    => 'integer',
        'deduction'    => 'integer',
        'total'        => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}