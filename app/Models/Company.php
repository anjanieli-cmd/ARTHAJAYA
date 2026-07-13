// app/Models/Company.php
class Company extends Model {
    protected $fillable = [
        'name','industry','business_size','country','city','address','logo',
        'currency','timezone','date_format','report_language',
        'fiscal_start_month','fiscal_year'
    ];
    public function accounts(){ return $this->hasMany(Account::class); }
    public function users(){ return $this->hasMany(User::class); }
}

// app/Models/Account.php
class Account extends Model {
    protected $fillable = ['company_id','bank_name','account_name','account_number','initial_balance'];
}