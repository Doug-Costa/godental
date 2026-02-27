<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment_plan_id',
        'description',
        'status',
        'notes'
    ];

    public function treatmentPlan()
    {
        return $this->belongsTo(TreatmentPlan::class);
    }
}
