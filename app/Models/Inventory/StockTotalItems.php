<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTotalItems extends Model
{
    use HasFactory;
    
    protected $table = 'stock_total_items';

    protected $fillable = ['inv_stock_id', 'item_id', 'quantity_in_hand'];

    public function stock()
    {
        return $this->belongsTo('App\Models\Inventory\InvStock', 'inv_stock_id', 'id');
    }
    public function item()
    {
        return $this->belongsTo('App\Models\Inventory\Item', 'item_id', 'id');
    }
}
