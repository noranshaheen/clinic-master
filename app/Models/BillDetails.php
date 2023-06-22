<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class BillDetails extends Model
{
    use HasFactory;
    protected $table = 'bill_details';

    public $primaryKey = 'id';
    protected $fillable = ['item_id', 'purches_price','quantity','total','date','bill_id'];

    protected $casts=[
        'purches_price'=>'float',
        'quantity'=>'float',
        'date'=>'date',
    ];

    public function bill(): BelongsTo
    {
        return $this->belongsTo('App\Models\Bill', 'bill_id', 'id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }
}
