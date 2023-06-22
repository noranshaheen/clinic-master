<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';
    public $primaryKey = 'id';
    protected $fillable = ['name','phone','another_phone','specialty_id','title','date_of_birth'];

    protected $casts = [
        'date_of_birth' => 'date'
    ];

    public function appointments(): HasMany{
        return $this->hasMany('App\Models\Appointment', 'doctor_id', 'id');
    }
    public function prescriptions(): HasMany{
        return $this->hasMany('App\Models\Prescription', 'doctor_id', 'id');
    }
    public function diagnosis(): HasMany{
        return $this->hasMany('App\Models\Diagnosis', 'doctor_id', 'id');
    }

    public function specialties():BelongsTo
    {
        return $this->belongsTo('App\Models\Specialty', 'specialty_id', 'id');
    }

    public function bills():HasMany{
        return $this->hasMany('App\Models\Bill','doctor_id','id');
    }
    public function spendings():HasMany{
        return $this->hasMany('App\Models\Spendings','doctor_id','id');
    }
}
