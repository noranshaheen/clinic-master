<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Bill extends Model
{
    use HasFactory;
    protected $table = 'expenses';

    public $primaryKey = 'id';
    protected $fillable = ['doctor_id', 'clinic_id','totalAmount'];
    protected $casts = [
        'date' => 'date',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id', 'id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }

    public function billLines(): HasMany
    {
        return $this->hasMany('App\Models\BillLine', 'expenses_id', 'id');
    }
}
