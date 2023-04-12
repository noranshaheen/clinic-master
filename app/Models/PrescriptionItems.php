<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrescriptionItems extends Model
{
    use HasFactory;
    protected $table = 'prescription_items';

    public $primaryKey = 'id';
    protected $fillable = ['prescription_id','drug_id','notes'];

    public function prescriptionItems(): BelongsTo
    {
        return $this->belongsTo('App\Models\Prescriptions','prescription_id','id');
    }
}
