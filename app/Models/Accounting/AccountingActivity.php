<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingActivity extends Model
{
    use HasFactory;

    protected $table = 'accounting_activity';
    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
    ];
}
