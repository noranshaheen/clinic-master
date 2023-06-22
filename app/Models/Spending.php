<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Spending extends Model
{
    use HasFactory;
    protected $table = 'spendings';

    public $primaryKey = 'id';
    protected $fillable = ['doctor_id', 'clinic_id','item_id','quantity','date_isseud','patient_id'];

    protected $casts=[
        'quantity'=>'float',
        'date_isseud'=>'date'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id', 'id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
    }
}
