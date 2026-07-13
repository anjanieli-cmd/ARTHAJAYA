<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    protected $fillable = [
        'name','industry','business_size','country','city','address','logo',
        'currency','timezone','date_format','report_language',
        'fiscal_start_month','fiscal_year'
    ];
    public function accounts(){ return $this->hasMany(Account::class); }
    public function users(){ return $this->hasMany(User::class); }
}