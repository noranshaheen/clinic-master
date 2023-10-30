<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Drug extends Model
{
    use HasFactory;

    protected $table = 'drugs';
    public $primaryKey = 'id';

    protected $fillable = ['name', 'description'];

    public function prescriptionItems(): HasMany
    {
        return $this->hasMany('App\Models\PrescriptionItems','drug_id','id');
    }

    public function diagnosis() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\Diagnosis','diagnosis_drug');
    }
}
