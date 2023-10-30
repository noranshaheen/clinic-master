<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    public $primaryKey = 'id';
    protected $fillable = ['appointment_id','patient_id','doctor_id','paid_amount', 'receiver_team_id','receiver_id','date'];
    protected $casts = [
        'date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id', 'id');
    }
    public function appointment(): BelongsTo
    {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id', 'id');
    }

}
