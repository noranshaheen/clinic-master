<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'patient_payments';
    public $primaryKey = 'id';
    protected $fillable = ['patient_id', 'appointment_id', 'doctor_id', 'detection_fees', 'service_fees'];
    // protected $casts = [
    //     'patient_id' => 'integer',
    //     'appointment_id' => 'integer',
    //     'doctor_id' => 'integer',
    // ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id', 'id');
    }
}
