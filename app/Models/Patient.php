<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'birth_date',
        'gender',
        'discovery_source',
        'registration_date',
        'clinical_observations',
        'user_id'
    ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function clinicalCases()
    {
        return $this->hasMany(ClinicalCase::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function documents()
    {
        return $this->hasMany(ClinicalDocument::class);
    }

    public function anamneses()
    {
        return $this->hasMany(Anamnesis::class);
    }

    public function anamnesisInstances()
    {
        return $this->hasMany(AnamnesisInstance::class);
    }

    public function treatmentPlans()
    {
        return $this->hasMany(TreatmentPlan::class);
    }

    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class)->orderBy('created_at', 'desc');
    }

    /**
     * Retorna o caso clínico ativo mais recente do paciente.
     */
    public function activeClinicalCase()
    {
        return $this->clinicalCases()
            ->where('status', ClinicalCase::STATUS_ATIVO)
            ->latest()
            ->first();
    }
    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    /**
     * Verifica se o paciente possui pendências financeiras vencidas.
     */
    public function getIsDelinquentAttribute()
    {
        // Se houver transação 'income' com status 'pending' ou 'overdue' E data de vencimento < hoje
        return $this->financialTransactions()
            ->where('type', 'income')
            ->where(function ($q) {
                $q->where('status', 'overdue')
                    ->orWhere(function ($q2) {
                        $q2->where('status', 'pending')
                            ->where('due_date', '<', now()->format('Y-m-d'));
                    });
            })
            ->exists();
    }
}
