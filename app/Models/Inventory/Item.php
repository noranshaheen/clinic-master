<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = ['name', 'unit', 'storable'];

    public function movements(){
        return $this->hasMany('App\Models\Inventory\StockMovement','item_id','id');
    }

    public function totalItems()
    {
        return $this->hasMany('App\Models\Inventory\StockTotalItams','item_id','id');
    }

}
