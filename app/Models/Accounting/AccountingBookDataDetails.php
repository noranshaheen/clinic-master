<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounting\AccountingBookData;
use App\Models\Accounting\AccountingChart;

class AccountingBookDataDetails extends Model
{
    use HasFactory;

    protected $table = 'accounting_book_data_details';
    
    protected $fillable = [
        'accounting_book_data_id',
        'accounting_chart_id',
        'debit',
        'credit',
    ];

    protected $casts = [
        'debit' => 'float',
        'credit' => 'float',
    ];

    public function accountingBookData()
    {
        return $this->belongsTo(AccountingBookData::class, 'accounting_book_data_id');
    }

    public function account()
    {
        return $this->belongsTo(AccountingChart::class, 'accounting_chart_id');
    }
}
