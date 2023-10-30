<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    public $primaryKey = 'id';
    protected $fillable = ['name', 'phone', 'type', 'date_of_birth', 'gender', 'insurance_number', 'insurance_company'];
    protected $casts = [
        'date_of_birth' => 'date'
    ];

    public function prescriptions(): HasMany
    {
        return $this->hasMany('App\Models\Prescription', 'patient_id', 'id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany('App\Models\Appointment', 'patient_id', 'id');
    }

    public function spendings(): HasMany
    {
        return $this->hasMany('App\Models\Spendings', 'patient_id', 'id');
    }
    public function payments(): HasMany
    {
        return $this->hasMany('App\Models\Payment', 'patient_id', 'id');
    }
    public function fees(): HasMany
    {
        return $this->hasMany('App\Models\Fee', 'patient_id', 'id');
    }
}
