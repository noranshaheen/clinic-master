<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    use HasFactory;
    protected $table = 'clinics';

    public $primaryKey = 'id';
    protected $fillable = ['name', 'phone', 'address'];

    public function rooms():HasMany{
        return $this->hasMany('App\Models\Room','clinic_id','id');
    }
}