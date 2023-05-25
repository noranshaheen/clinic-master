<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialty extends Model
{
    use HasFactory;
    protected $table = 'specialities';
    public $primaryKey = 'id';
    protected $fillable = ['name'];

    public function diagnosis(): HasMany{
        return $this->hasMany('App\Models\Diagnosis', 'specialty_id', 'id');
    }
    public function analysis(): HasMany{
        return $this->hasMany('App\Models\Analysis', 'specialty_id', 'id');
    }

    public function doctors(): HasMany{
        return $this->hasMany('App\Models\Doctor', 'specialty_id', 'id');
    }


}
