<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class XRay extends Model
{
    use HasFactory;
    protected $table = 'xrays';
    public $primaryKey = 'id';
    protected $fillable = ['name','description','specialty_id'];

    public function specialty() : BelongsTo
    {
        return $this->BelongsTo('App\Models\Specialty','specialty_id','id');
    }
}
