<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    protected $fillable = [
        'patient_id',
        'clinical_case_id',
        'event_type',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // ─── Event Type Constants ───

    const CASO_CRIADO = 'CASO_CRIADO';
    const CONSULTA_CRIADA = 'CONSULTA_CRIADA';
    const ETAPA_ALTERADA = 'ETAPA_ALTERADA';
    const PLANO_CRIADO = 'PLANO_CRIADO';
    const PLANO_APROVADO = 'PLANO_APROVADO';
    const RETORNO_AGENDADO = 'RETORNO_AGENDADO';
    const CASO_FINALIZADO = 'CASO_FINALIZADO';
    const CASO_REABERTO = 'CASO_REABERTO';

    const EVENT_ICONS = [
        self::CASO_CRIADO => 'bi-folder-plus',
        self::CONSULTA_CRIADA => 'bi-mic-fill',
        self::ETAPA_ALTERADA => 'bi-arrow-right-circle',
        self::PLANO_CRIADO => 'bi-journal-medical',
        self::PLANO_APROVADO => 'bi-check2-circle',
        self::RETORNO_AGENDADO => 'bi-calendar-check',
        self::CASO_FINALIZADO => 'bi-flag-fill',
        self::CASO_REABERTO => 'bi-arrow-counterclockwise',
    ];

    const EVENT_COLORS = [
        self::CASO_CRIADO => '#198754',
        self::CONSULTA_CRIADA => '#CA1D53',
        self::ETAPA_ALTERADA => '#0d6efd',
        self::PLANO_CRIADO => '#fd7e14',
        self::PLANO_APROVADO => '#198754',
        self::RETORNO_AGENDADO => '#6f42c1',
        self::CASO_FINALIZADO => '#6c757d',
        self::CASO_REABERTO => '#ffc107',
    ];

    // ─── Relationships ───

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinicalCase()
    {
        return $this->belongsTo(ClinicalCase::class);
    }

    // ─── Helpers ───

    public function getIconAttribute()
    {
        return self::EVENT_ICONS[$this->event_type] ?? 'bi-circle';
    }

    public function getColorAttribute()
    {
        return self::EVENT_COLORS[$this->event_type] ?? '#6c757d';
    }

    /**
     * Helper estático para registrar eventos de timeline rapidamente.
     */
    public static function registrar(string $type, int $patientId, ?int $caseId, string $description, array $meta = []): self
    {
        return self::create([
            'patient_id' => $patientId,
            'clinical_case_id' => $caseId,
            'event_type' => $type,
            'description' => $description,
            'metadata' => !empty($meta) ? $meta : null,
        ]);
    }
}
