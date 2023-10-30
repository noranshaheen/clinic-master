<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    public $primaryKey = 'id';

    protected $fillable = ['specialty_id', 'name', 'default_price'];

    public function specialty(): BelongsTo
    {
        return $this->belongsTo('App\Models\Specialty', 'specialty_id', 'id');
    }

    public function prescriptionItems(): HasMany
    {
        return $this->hasMany('App\Models\PrescriptionItems', 'service_id', 'id');
    }
    public function fees(): HasMany
    {
        return $this->hasMany('App\Models\Fee', 'service_id', 'id');
    }
}
