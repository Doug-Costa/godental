<?php

namespace App\Http\Controllers;

use App\Models\ClinicalCase;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\TreatmentPlan;
use App\Models\Procedure;
use App\Models\TimelineEvent;
use App\Models\FinancialTransaction;
use App\Models\FinancialCategory;
use App\Models\Doctor;
use App\Services\RemunerationService;
use App\Models\AnamnesisTemplate;
use App\Models\AnamnesisInstance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ClinicalCaseController extends Controller
{
    /**
     * Store a new clinical case for a patient
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'title' => 'required|string|max:255',
            'tipo_tratamento' => 'nullable|string|max:255',
        ]);

        $case = ClinicalCase::create([
            'patient_id' => $validated['patient_id'],
            'title' => $validated['title'],
            'tipo_tratamento' => $validated['tipo_tratamento'] ?? null,
            'etapa_atual' => ClinicalCase::ETAPA_CONSULTA_INICIAL,
            'status' => ClinicalCase::STATUS_ATIVO,
            'data_inicio' => now()->toDateString(),
            'opened_at' => now(),
        ]);

        TimelineEvent::registrar(
            TimelineEvent::CASO_CRIADO,
            $case->patient_id,
            $case->id,
            "Caso clínico criado: {$case->title}",
            ['tipo_tratamento' => $case->tipo_tratamento]
        );

        return response()->json([
            'success' => true,
            'case' => $case,
        ]);
    }

    /**
     * Close a clinical case
     */
    public function close($id)
    {
        $case = ClinicalCase::findOrFail($id);
        $case->update([
            'status' => ClinicalCase::STATUS_FINALIZADO,
            'data_fim' => now()->toDateString(),
            'closed_at' => now(),
        ]);

        TimelineEvent::registrar(
            TimelineEvent::CASO_FINALIZADO,
            $case->patient_id,
            $case->id,
            "Caso clínico finalizado: {$case->title}"
        );

        return back()->with('success', 'Caso clínico encerrado com sucesso.');
    }

    /**
     * Reopen a clinical case
     */
    public function reopen($id)
    {
        $case = ClinicalCase::findOrFail($id);
        $case->update([
            'status' => ClinicalCase::STATUS_ATIVO,
            'data_fim' => null,
            'closed_at' => null,
        ]);

        TimelineEvent::registrar(
            TimelineEvent::CASO_REABERTO,
            $case->patient_id,
            $case->id,
            "Caso clínico reaberto: {$case->title}"
        );

        return back()->with('success', 'Caso clínico reaberto com sucesso.');
    }

    /**
     * Show a clinical case detail page
     */
    public function show($id)
    {
        $case = ClinicalCase::with([
            'consultations' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
            'treatmentPlans.procedures',
            'patient',
            'timelineEvents' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
        ])->findOrFail($id);

        return view('clinical_cases.show', compact('case'));
    }

    /**
     * Get active cases for a patient (JSON for dropdowns)
     */
    public function activeCases($patientId)
    {
        $cases = ClinicalCase::where('patient_id', $patientId)
            ->where('status', ClinicalCase::STATUS_ATIVO)
            ->orderBy('opened_at', 'desc')
            ->get(['id', 'title', 'etapa_atual', 'opened_at']);

        return response()->json($cases);
    }

    /**
     * Update consultation clinical fields (AJAX)
     * CRITICAL: Propagates etapa to ClinicalCase
     */
    public function updateConsultationFields(Request $request, $consultationId)
    {
        $consultation = Consultation::findOrFail($consultationId);

        $validated = $request->validate([
            'clinical_step' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prognosis' => 'nullable|string',
            'suggested_plan' => 'nullable|string',
            'next_steps' => 'nullable|string',
            'ai_summary' => 'nullable|string',
            'observations' => 'nullable|string',
        ]);

        $oldStep = $consultation->clinical_step;
        $consultation->update($validated);

        // ─── Propagar etapa ao CasoClínico ───
        if (
            isset($validated['clinical_step']) &&
            $validated['clinical_step'] !== $oldStep &&
            $consultation->clinical_case_id
        ) {
            $case = ClinicalCase::find($consultation->clinical_case_id);
            if ($case && in_array($validated['clinical_step'], ClinicalCase::ETAPAS)) {
                $case->update(['etapa_atual' => $validated['clinical_step']]);

                TimelineEvent::registrar(
                    TimelineEvent::ETAPA_ALTERADA,
                    $case->patient_id,
                    $case->id,
                    "Etapa alterada: " . (ClinicalCase::ETAPA_LABELS[$oldStep] ?? $oldStep) .
                    " → " . (ClinicalCase::ETAPA_LABELS[$validated['clinical_step']] ?? $validated['clinical_step']),
                    ['de' => $oldStep, 'para' => $validated['clinical_step']]
                );
            }
        }

        return response()->json(['success' => true, 'message' => 'Dados clínicos salvos.']);
    }

    /**
     * Store a treatment plan linked to a case
     */
    public function storeTreatmentPlan(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'clinical_case_id' => 'nullable|exists:clinical_cases,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'estimated_value' => 'nullable|numeric|min:0',
            'doctor_id' => 'nullable|exists:doctors,id',
        ]);

        $plan = TreatmentPlan::create(array_merge($validated, [
            'status' => 'Proposto',
        ]));

        // Registrar evento na timeline
        if ($validated['clinical_case_id']) {
            $case = ClinicalCase::find($validated['clinical_case_id']);
            if ($case) {
                TimelineEvent::registrar(
                    TimelineEvent::PLANO_CRIADO,
                    $validated['patient_id'],
                    $case->id,
                    "Plano de tratamento criado: {$plan->title}",
                    ['valor_estimado' => $plan->estimated_value]
                );
            }
        }

        return response()->json(['success' => true, 'plan' => $plan]);
    }

    /**
     * Approve a treatment plan and generate financial transaction
     */
    public function approveTreatmentPlan(Request $request, RemunerationService $remunerationService, $id)
    {
        $plan = TreatmentPlan::with('patient')->findOrFail($id);

        if ($plan->status === 'Aprovado') {
            return response()->json(['success' => false, 'message' => 'Plano já aprovado.']);
        }

        $plan->update(['status' => 'Aprovado']);

        // Generate Account Receivable
        if ($plan->estimated_value > 0) {
            $category = FinancialCategory::firstOrCreate(
                ['name' => 'Tratamentos'],
                ['type' => 'income', 'color' => '#0d6efd']
            );

            FinancialTransaction::create([
                'description' => "Tratamento: {$plan->title} - " . ($plan->patient->full_name ?? 'Paciente'),
                'amount' => $plan->estimated_value,
                'type' => 'income',
                'date' => now(),
                'due_date' => now()->addDays(30), // Default 30 days
                'status' => 'pending',
                'category_id' => $category->id,
                'patient_id' => $plan->patient_id,
                'related_type' => TreatmentPlan::class,
                'related_id' => $plan->id,
            ]);
        }

        // Calculate Commission if Doctor is assigned
        if ($plan->doctor_id) {
            $doctor = Doctor::find($plan->doctor_id);
            if ($doctor) {
                $remunerationService->calculateCommission(
                    $doctor,
                    (float) $plan->estimated_value,
                    "Comissão Tratamento: {$plan->title}",
                    $plan
                );
            }
        }

        if ($plan->clinical_case_id) {
            TimelineEvent::registrar(
                TimelineEvent::PLANO_APROVADO,
                $plan->patient_id,
                $plan->clinical_case_id,
                "Plano de tratamento aprovado: {$plan->title}",
                ['valor' => $plan->estimated_value]
            );
        }

        return response()->json(['success' => true]);
    }

    /**
     * Store a procedure within a treatment plan
     */
    public function storeProcedure(Request $request)
    {
        $validated = $request->validate([
            'treatment_plan_id' => 'required|exists:treatment_plans,id',
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'expected_date' => 'nullable|date',
        ]);

        $procedure = Procedure::create(array_merge($validated, [
            'status' => 'Pendente',
        ]));

        return response()->json(['success' => true, 'procedure' => $procedure]);
    }

    /**
     * Update procedure status
     */
    public function updateProcedureStatus(Request $request, $id)
    {
        $procedure = Procedure::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:Pendente,EmAndamento,Concluido',
        ]);
        $procedure->update($validated);

        return response()->json(['success' => true]);
    }

    /**
     * Store a consultation via AJAX (from patient page modal)
     * Validates valor as required, propagates etapa and fires timeline events.
     */
    public function storeConsultation(Request $request, RemunerationService $remunerationService)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'patient_name' => 'nullable|string|max:255',
            'patient_identifier' => 'nullable|string|max:255',
            'consultation_type' => 'required|string|max:255',
            'clinical_step' => 'nullable|string',
            'clinical_case_id' => 'nullable|exists:clinical_cases,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'observations' => 'nullable|string',
            'transcription' => 'nullable|string',
            'status' => 'nullable|string',
            'valor' => 'required|numeric|min:0',
            'service_price_id' => 'nullable|exists:service_prices,id',
            'requires_anamnesis' => 'nullable|boolean',
            'anamnesis_template_id' => 'nullable|exists:anamnesis_templates,id',
        ]);

        try {
            $status = ($request->requires_anamnesis) ? 'awaiting_anamnesis' : ($validated['status'] ?? 'pending');

            $consultation = Consultation::create([
                'patient_id' => $validated['patient_id'],
                'patient_name' => $validated['patient_name'] ?? '',
                'patient_identifier' => $validated['patient_identifier'] ?? '',
                'consultation_type' => $validated['consultation_type'],
                'clinical_step' => $validated['clinical_step'] ?? ClinicalCase::ETAPA_CONSULTA_INICIAL,
                'clinical_case_id' => $validated['clinical_case_id'] ?? null,
                'doctor_id' => $validated['doctor_id'] ?? null,
                'observations' => $validated['observations'] ?? '',
                'transcription' => $validated['transcription'] ?? '',
                'status' => $status,
                'valor' => $validated['valor'],
                'service_price_id' => $validated['service_price_id'] ?? null,
                'user_id' => null,
                'requires_anamnesis' => $request->requires_anamnesis ? true : false,
            ]);

            $anamnesisUrl = null;
            if ($request->requires_anamnesis) {
                $templateId = $request->anamnesis_template_id;
                $template = null;
                if ($templateId) {
                    $template = AnamnesisTemplate::find($templateId);
                }
                if (!$template) {
                    $template = AnamnesisTemplate::where('is_default', true)->first();
                }

                if ($template) {
                    $instance = AnamnesisInstance::create([
                        'consultation_id' => $consultation->id,
                        'patient_id' => $validated['patient_id'],
                        'template_id' => $template->id,
                        'token' => Str::random(64),
                        'status' => 'pending',
                        'expires_at' => now()->addHours(24),
                    ]);
                    $anamnesisUrl = route('anamnesis.show', $instance->token);
                }
            }

            // Propagar etapa ao caso clínico
            if ($consultation->clinical_case_id && $consultation->clinical_step) {
                $case = ClinicalCase::find($consultation->clinical_case_id);
                if ($case && in_array($consultation->clinical_step, ClinicalCase::ETAPAS)) {
                    $case->update(['etapa_atual' => $consultation->clinical_step]);
                }

                if ($case) {
                    TimelineEvent::registrar(
                        TimelineEvent::CONSULTA_CRIADA,
                        $consultation->patient_id,
                        $case->id,
                        "Consulta criada: {$consultation->consultation_type}",
                        [
                            'valor' => $consultation->valor,
                            'etapa' => $consultation->clinical_step,
                            'consultation_id' => $consultation->id,
                        ]
                    );
                }
            }

            // Gerar Conta a Receber (Pendente)
            if ($consultation->valor > 0) {
                $category = FinancialCategory::firstOrCreate(
                    ['name' => 'Consultas'],
                    ['type' => 'income', 'color' => '#5a9e7c']
                );

                FinancialTransaction::create([
                    'description' => "Consulta: " . $consultation->consultation_type . " - " . ($consultation->patient->full_name ?? ($validated['patient_name'] ?? 'Paciente')),
                    'amount' => $consultation->valor,
                    'type' => 'income',
                    'date' => now(),
                    'due_date' => now(),
                    'status' => 'pending',
                    'category_id' => $category->id,
                    'patient_id' => $consultation->patient_id,
                    'related_type' => Consultation::class,
                    'related_id' => $consultation->id,
                ]);
            }

            // Calculate Commission if Doctor is assigned
            if (!empty($validated['doctor_id'])) {
                $doctor = Doctor::find($validated['doctor_id']);
                if ($doctor) {
                    $remunerationService->calculateCommission(
                        $doctor,
                        (float) $consultation->valor,
                        "Comissão Consulta #{$consultation->id}",
                        $consultation
                    );
                }
            }

            return response()->json([
                'success' => true,
                'id' => $consultation->id,
                'db_id' => $consultation->id,
                'anamnesis_url' => $anamnesisUrl,
            ]);
        } catch (\Throwable $e) {
            \Log::error("Erro storeConsultation: " . $e->getMessage(), [
                'input' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }
}
