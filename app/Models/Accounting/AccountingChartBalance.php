<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingChartBalance extends Model
{
    use HasFactory;

    protected $table = 'accounting_chart_balance';
    
    protected $fillable = [
        'accounting_chart_id',
        'credit',
        'debit', 
        'balance_date',
        'transferable',
    ];

    protected $casts = [
        'credit' => 'float',
        'debit' => 'float',
        'balance_date' => 'date',
        'transferable' => 'boolean',
    ];

    public function account()
    {
        return $this->belongsTo(AccountingChart::class, 'accounting_chart_id');
    }
}
