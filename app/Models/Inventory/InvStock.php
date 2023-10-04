<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvStock extends Model
{
    use HasFactory;
    /**
     * There are three general categories of inventory, 
     * raw materials (any supplies that are used to produce finished goods),
     * work-in-progress (WIP), 
     * finished goods or those that are ready for sale.
     */

    protected $table = 'inv_stock';

    protected $fillable = ['name', 'inventory_id'];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory\Inventory', 'inventory_id', 'id');
    }

    public function movements()
    {
        return $this->hasMany('App\Models\Inventory\StockMovement', 'inv_stock_id', 'id');
    }

    public function totalItems()
    {
        return $this->hasMany('App\Models\Inventory\StockTotalItams','inv_stock_id','id');
    }
}
