<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'clinical_case_id',
        'patient_name',
        'patient_identifier',
        'consultation_type',
        'clinical_step',
        'valor',
        'service_price_id',
        'observations',
        'audio_path',
        'transcription',
        'ai_summary',
        'diagnosis',
        'prognosis',
        'suggested_plan',
        'next_steps',
        'status',
        'user_id',
        'requires_anamnesis',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'requires_anamnesis' => 'boolean',
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

    public function servicePrice()
    {
        return $this->belongsTo(ServicePrice::class);
    }
}
