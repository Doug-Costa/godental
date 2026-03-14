<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnamnesisInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'patient_id',
        'template_id',
        'token',
        'status',
        'expires_at',
        'completed_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(AnamnesisTemplate::class, 'template_id');
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function responses()
    {
        return $this->hasMany(AnamnesisResponse::class, 'instance_id');
    }
}
