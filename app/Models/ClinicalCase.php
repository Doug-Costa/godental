<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalCase extends Model
{
    use HasFactory;

    // ─── Status Constants ───
    const STATUS_ATIVO = 'ATIVO';
    const STATUS_EM_TRATAMENTO = 'EM_TRATAMENTO';
    const STATUS_FINALIZADO = 'FINALIZADO';
    const STATUS_SUSPENSO = 'SUSPENSO';

    const STATUSES = [
        self::STATUS_ATIVO,
        self::STATUS_EM_TRATAMENTO,
        self::STATUS_FINALIZADO,
        self::STATUS_SUSPENSO,
    ];

    // ─── Etapa Constants (fluxo obrigatório) ───
    const ETAPA_CONSULTA_INICIAL = 'CONSULTA_INICIAL';
    const ETAPA_ANAMNESE = 'ANAMNESE';
    const ETAPA_DIAGNOSTICO_PROGNOSTICO = 'DIAGNOSTICO_PROGNOSTICO';
    const ETAPA_PLANO_TRATAMENTO = 'PLANO_TRATAMENTO';
    const ETAPA_EM_TRATAMENTO = 'EM_TRATAMENTO';

    const ETAPAS = [
        self::ETAPA_CONSULTA_INICIAL,
        self::ETAPA_ANAMNESE,
        self::ETAPA_DIAGNOSTICO_PROGNOSTICO,
        self::ETAPA_PLANO_TRATAMENTO,
        self::ETAPA_EM_TRATAMENTO,
    ];

    const ETAPA_LABELS = [
        self::ETAPA_CONSULTA_INICIAL => 'Consulta Inicial',
        self::ETAPA_ANAMNESE => 'Anamnese',
        self::ETAPA_DIAGNOSTICO_PROGNOSTICO => 'Diagnóstico / Prognóstico',
        self::ETAPA_PLANO_TRATAMENTO => 'Plano de Tratamento',
        self::ETAPA_EM_TRATAMENTO => 'Em Tratamento',
    ];

    protected $fillable = [
        'patient_id',
        'title',
        'tipo_tratamento',
        'etapa_atual',
        'status',
        'data_inicio',
        'data_fim',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'opened_at' => 'date',
        'closed_at' => 'date',
        'data_inicio' => 'date',
        'data_fim' => 'date',
    ];

    // ─── Scopes ───

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }

    // ─── Accessors ───

    public function getEtapaLabelAttribute()
    {
        return self::ETAPA_LABELS[$this->etapa_atual] ?? $this->etapa_atual;
    }

    // ─── Relationships ───

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'clinical_case_id');
    }

    public function treatmentPlans()
    {
        return $this->hasMany(TreatmentPlan::class, 'clinical_case_id');
    }

    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'clinical_case_id');
    }
}
