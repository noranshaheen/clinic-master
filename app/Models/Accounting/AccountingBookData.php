<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Accounting\AccountingBook;
use App\Models\Accounting\AccountingBookDataDetails;
use App\Models\Accounting\AccountingBookDataActivity;
use App\Models\Accounting\AccountingActivity;

class AccountingBookData extends Model
{
    use HasFactory;

    protected $table = 'accounting_book_data';

    protected $fillable = [
        'name',
        'description',
        'reference_code',
        'accounting_book_id',
        'transaction_date',
        'debit',
        'credit',
        'approved_by',
        'accepted_by',
        'rejected_by',
        'rejection_reason',
        'status',
        'attachment',
    ];

    protected $casts = [
        'status' => 'string',
        'transaction_date' => 'datetime',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    public function accountingBook()
    {
        return $this->belongsTo(AccountingBook::class);
    }

    public function entries()
    {
        return $this->hasMany(AccountingBookDataDetails::class);
    }

    public function activities()
    {
        return $this->belongsToMany(AccountingActivity::class, 'accounting_book_data_activity', 'accounting_book_data_id', 'accounting_activity_id')
            ->withPivot("contribution_percentage");
    }
}
