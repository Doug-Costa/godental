<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'clinical_case_id',
        'title',
        'description',
        'status',
        'estimated_value'
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinicalCase()
    {
        return $this->belongsTo(ClinicalCase::class, 'clinical_case_id');
    }

    public function steps()
    {
        return $this->hasMany(TreatmentStep::class);
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }
}
