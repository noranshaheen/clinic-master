<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Fee extends Model
{
    use HasFactory;

    protected $table = 'fees';
    public $primaryKey = 'id';

    protected $fillable = ['patient_id', 'appointment_id', 'service_id','price','date'];
    protected $casts = [
        'date' => 'date',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id', 'id');
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }
}
