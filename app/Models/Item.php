<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    public $primaryKey = 'id';

    protected $fillable = ['name', 'name', 'unit', 'storable'];

    public function billDetails(): HasMany
    {
        return $this->hasMany('App\Models\BillDetails', 'item_id', 'id');
    }

    public function spendings(): HasMany
    {
        return $this->hasMany('App\Models\Spending', 'item_id', 'id');
    }
}
