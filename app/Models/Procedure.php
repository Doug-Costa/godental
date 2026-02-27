<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment_plan_id',
        'name',
        'region',
        'status',
        'expected_date'
    ];

    protected $casts = [
        'expected_date' => 'date',
    ];

    public function treatmentPlan()
    {
        return $this->belongsTo(TreatmentPlan::class);
    }
}
