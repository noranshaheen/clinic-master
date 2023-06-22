<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrescriptionItems extends Model
{
    use HasFactory;
    protected $table = 'prescription_items';

    public $primaryKey = 'id';
    protected $fillable = ['prescription_id','drug_id','notes'];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo('App\Models\Prescription','prescription_id','id');
    }

    public function drugs(): BelongsTo
    {
        return $this->belongsTo('App\Models\Drug','drug_id','id');
    }
}
