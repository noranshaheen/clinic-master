<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounting\AccountingBookData;

class AccountingBook extends Model
{
    use HasFactory;
    protected $table = 'accounting_book';

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function accountingBookData()
    {
        return $this->hasMany(AccountingBookData::class);
    }

}
