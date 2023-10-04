<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';

    protected $fillable = [
        'inv_stock_id', 'item_id', 'date', 'type', 'quantity',
        'unit_price', 'total_price'
    ];

    public function stock()
    {
        return $this->belongsTo('App\Models\Inventory\InvStock', 'inv_stock_id', 'id');
    }
    public function item()
    {
        return $this->belongsTo('App\Models\Inventory\Item', 'item_id', 'id');
    }
}
