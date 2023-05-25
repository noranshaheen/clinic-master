<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Reseptionist extends Model
{
    use HasFactory;

    protected $table = 'reseptionists';
    public $primaryKey = 'id';
    protected $fillable = ['name', 'phone', 'date_of_birth', 'gender'];
    protected $casts = [
        'date_of_birth' => 'date'
    ];

}
