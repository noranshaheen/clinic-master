<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';

    public $primaryKey = 'id';
    protected $fillable = ['name','clinic_id'];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo('App\Models\Clinic','clinic_id','id');
    }
    public function appointment(): HasMany{
        return $this->hasMany('App\Models\Appointment', 'room_id', 'id');
    }
}
