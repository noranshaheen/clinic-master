<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingBookDataActivity extends Model
{
    use HasFactory;

    protected $table = 'accounting_book_data_activity';
    protected $fillable = [
        'accounting_book_data_id',
        'accounting_activity_id',
        'contribution_percentage'
    ];

    protected $casts = [
        'contribution_percentage' => 'float'
    ];

    public function accountingBookData()
    {
        return $this->belongsTo(AccountingBookData::class, 'accounting_book_data_id');
    }

    public function accountingActivity()
    {
        return $this->belongsTo(AccountingActivity::class, 'accounting_activity_id');
    }
}
