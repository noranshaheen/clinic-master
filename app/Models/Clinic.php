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

    public function prescriptions():HasMany{
        return $this->hasMany('App\Models\Prescription','clinic_id','id');
    }

    public function appointments():HasMany{
        return $this->hasMany('App\Models\Appointment','clinic_id','id');
    }

    public function bill():HasMany{
        return $this->hasMany('App\Models\Bill','clinic_id','id');
    }

    public function spendings():HasMany{
        return $this->hasMany('App\Models\Spendings','clinic','id');
    }

    public function inventories():HasMany{
        return $this->hasMany('App\Models\Inventory\Inventory','clinic_id','id');
    }
}