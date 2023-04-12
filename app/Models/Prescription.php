<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';

    public $primaryKey = 'id';
    protected $fillable = ['doctor_id','patient_id','dateTimeIssued'];
    protected $casts = [
        'dateTimeIssued' =>'datetime'
    ];

    public function prescriptionItems(): HasMany
    {
        return $this->hasMany('App\Models\PrescriptionItems','prescription_id','id');
    }

    public function doctor():BelongsTo
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id', 'id');
    }
    public function patient():BelongsTo
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
    }
}
