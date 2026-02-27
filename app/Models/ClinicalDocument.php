<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'consultation_id',
        'file_path',
        'file_type',
        'category',
        'label'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
