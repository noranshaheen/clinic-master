<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class BillLine extends Model
{
    use HasFactory;
    protected $table = 'expenses_items';

    public $primaryKey = 'id';
    protected $fillable = ['item', 'unit_price','quantity','total','expenses_id'];

    public function bill(): BelongsTo
    {
        return $this->belongsTo('App\Models\Bill', 'expenses_id', 'id');
    }
}
