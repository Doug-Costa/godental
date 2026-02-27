<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_AGENDADO = 'AGENDADO';
    const STATUS_CONFIRMADO = 'CONFIRMADO';
    const STATUS_EM_ATENDIMENTO = 'EM_ATENDIMENTO';
    const STATUS_CONCLUIDO = 'CONCLUIDO';
    const STATUS_CANCELADO = 'CANCELADO';
    const STATUS_FALTA = 'FALTA';

    protected $fillable = [
        'patient_id',
        'clinical_case_id',
        'consultation_type',
        'valor',
        'service_price_id',
        'doctor_id',
        'dentista',
        'start_time',
        'end_time',
        'status',
        'notes'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'valor' => 'decimal:2',
    ];

    // ----- Relationships -----

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinicalCase()
    {
        return $this->belongsTo(ClinicalCase::class, 'clinical_case_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function servicePrice()
    {
        return $this->belongsTo(ServicePrice::class);
    }

    // ----- Helpers -----

    public static function statusColors(): array
    {
        return [
            self::STATUS_AGENDADO => '#7c8db5',
            self::STATUS_CONFIRMADO => '#5a9e7c',
            self::STATUS_EM_ATENDIMENTO => '#c9864e',
            self::STATUS_CONCLUIDO => '#9ba5b0',
            self::STATUS_CANCELADO => '#c45c6a',
            self::STATUS_FALTA => '#b54d5e',
        ];
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_AGENDADO => 'Agendado',
            self::STATUS_CONFIRMADO => 'Confirmado',
            self::STATUS_EM_ATENDIMENTO => 'Em Atendimento',
            self::STATUS_CONCLUIDO => 'Concluído',
            self::STATUS_CANCELADO => 'Cancelado',
            self::STATUS_FALTA => 'Falta',
        ];
    }
}
