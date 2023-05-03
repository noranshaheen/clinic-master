<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    public $primaryKey = 'id';
    protected $fillable = ['doctor_id','room_id','patient_id','done'];
    protected $casts = [
        'date' => 'date',
        'from' => 'datetime',
        'to'    => 'datetime',
        'done' => 'integer'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo('App\Models\Room', 'room_id', 'id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id', 'id');
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
    }
}
