<?php

namespace App\Models\Inventory;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = ['name', 'location', 'clinic_id'];

    public function clinic()
    {
        return $this->belongsTo('App\Models\Clinic','clinic_id','id');
    }

    public function stocks(){
        return $this->hasMany('App\Models\Inventory\InvStock','inventory_id','id');
    }
}
