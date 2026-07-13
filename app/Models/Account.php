<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    protected $fillable = ['company_id','bank_name','account_name','account_number','initial_balance'];
}