<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'data',
        'version'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
