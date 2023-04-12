<?php

namespace App\Models\Accounting;

use App\Http\Requests\StoreCreditRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Accounting\AccountingChartBalance;
use App\Models\Accounting\AccountingBook;
use App\Models\Accounting\AccountingBookData;
use App\Models\Accounting\AccountingBookDataDetails;
class AccountingChart extends Model
{
    use HasFactory;

    protected $table = 'accounting_chart';
    
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'status',
        'visible_balance_sheet',
        'visible_income_sheet',
    ];

    protected $casts = [
        'status' => 'string',
        'visible_balance_sheet' => 'boolean',
        'visible_income_sheet' => 'boolean',
    ];

    protected $appends = ['latest_balance'];

    public function parent()
    {
        return $this->belongsTo(AccountingChart::class, 'parent_id');
    }

    public function subaccounts()
    {
        return $this->hasMany(AccountingChart::class, 'parent_id');
    }

    public function balance()
    {
        return $this->hasMany(AccountingChartBalance::class, 'accounting_chart_id');
    }

    public function transactions()
    {
        return $this->hasMany(AccountingBookData::class, 'accounting_chart_id');
    }
    //add property for latest balance
    public function getLatestBalanceAttribute()
    {
        $balance = $this->balance()->orderBy('balance_date', 'desc')->first();
        
        if($balance){
            return ["credit_amount" => $balance->credit, "debit_amount" => $balance->debit];
        }else{
            return ["credit_amount" => 0, "debit_amount" => 0];
        }
    }
}
