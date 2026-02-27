<?php

namespace App\Http\Controllers;

use App\Models\ClinicalCase;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\TreatmentPlan;
use App\Models\Procedure;
use App\Models\TimelineEvent;
use App\Models\FinancialTransaction;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard Clínico — métricas e gráficos
     */
    public function index(Request $request)
    {
        $startDate = $request->query('startDate')
            ? Carbon::parse($request->query('startDate'))->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $endDate = $request->query('endDate')
            ? Carbon::parse($request->query('endDate'))->endOfDay()
            : Carbon::now()->endOfDay();

        // KPIs
        $totalConsultas = Consultation::whereBetween('created_at', [$startDate, $endDate])->count();
        $novosPacientes = Patient::whereBetween('created_at', [$startDate, $endDate])->count();
        $casosAtivos = ClinicalCase::where('status', ClinicalCase::STATUS_ATIVO)->count();

        $planosPropostos = TreatmentPlan::where('status', 'Proposto')
            ->whereBetween('created_at', [$startDate, $endDate])->count();
        $planosAprovados = TreatmentPlan::whereIn('status', ['Aprovado', 'EmExecucao'])
            ->whereBetween('created_at', [$startDate, $endDate])->count();

        $faturamentoPrevisto = TreatmentPlan::whereBetween('created_at', [$startDate, $endDate])
            ->sum('estimated_value');
        $faturamentoRealizado = TreatmentPlan::whereIn('status', ['Finalizado'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('estimated_value');

        // Receita de consultas (novo)
        $receitaConsultas = Consultation::whereBetween('created_at', [$startDate, $endDate])
            ->sum('valor');

        // Consultas por tipo
        $consultasPorTipo = Consultation::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('consultation_type, COUNT(*) as total')
            ->groupBy('consultation_type')
            ->pluck('total', 'consultation_type')
            ->toArray();

        // Consultas por período (agrupado por dia)
        $consultasPorPeriodo = Consultation::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as data, COUNT(*) as total')
            ->groupBy('data')
            ->orderBy('data')
            ->pluck('total', 'data')
            ->toArray();

        // Distribuição por etapa clínica
        $distribuicaoEtapa = Consultation::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('clinical_step')
            ->selectRaw('clinical_step, COUNT(*) as total')
            ->groupBy('clinical_step')
            ->pluck('total', 'clinical_step')
            ->pluck('total', 'clinical_step')
            ->toArray();

        // ─── FINANCEIRO ───
        $receitaTotal = FinancialTransaction::where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'paid')
            ->sum('amount');

        $despesaTotal = FinancialTransaction::where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'paid')
            ->sum('amount');

        $fluxoCaixa = $receitaTotal - $despesaTotal;

        $contasReceber = FinancialTransaction::where('type', 'income')
            ->where('status', 'pending')
            ->sum('amount');

        $contasPagar = FinancialTransaction::where('type', 'expense')
            ->where('status', 'pending')
            ->sum('amount');

        // Inadimplência (Receitas vencidas ou pendentes com data passada)
        $queryInadimplencia = FinancialTransaction::where('type', 'income')
            ->where(function ($q) {
                $q->where('status', 'overdue')
                    ->orWhere(function ($q2) {
                        $q2->where('status', 'pending')
                            ->where('due_date', '<', now()->format('Y-m-d'));
                    });
            });

        $totalInadimplencia = $queryInadimplencia->sum('amount');
        // Contar quantos pacientes únicos possuem essas pendências
        $pacientesInadimplentes = $queryInadimplencia->distinct('patient_id')->count('patient_id');

        // ─── ESTOQUE ───
        $lowStockItems = InventoryItem::whereColumn('current_stock', '<=', 'min_stock')->get();

        return view('dashboard.index', compact(
            'startDate',
            'endDate',
            'totalConsultas',
            'novosPacientes',
            'casosAtivos',
            'planosPropostos',
            'planosAprovados',
            'faturamentoPrevisto',
            'faturamentoRealizado',
            'receitaConsultas',
            'consultasPorTipo',
            'consultasPorPeriodo',
            'distribuicaoEtapa',
            'receitaTotal',
            'despesaTotal',
            'fluxoCaixa',
            'contasReceber',
            'contasReceber',
            'contasPagar',
            'totalInadimplencia',
            'pacientesInadimplentes',
            'lowStockItems'
        ));
    }

    /**
     * Kanban de Atendimentos — baseado em CasoClínico
     * SIMPLIFICADO: usa etapa_atual diretamente do ClinicalCase
     */
    public function kanban(Request $request)
    {
        $cases = ClinicalCase::with([
            'patient',
            'consultations' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
            'treatmentPlans.procedures'
        ])->get();

        // Colunas do kanban baseadas nas etapas do ClinicalCase
        $columns = [
            ClinicalCase::ETAPA_CONSULTA_INICIAL => ['label' => 'Consulta Inicial', 'color' => '#6c757d', 'cases' => []],
            ClinicalCase::ETAPA_ANAMNESE => ['label' => 'Anamnese', 'color' => '#0d6efd', 'cases' => []],
            ClinicalCase::ETAPA_DIAGNOSTICO_PROGNOSTICO => ['label' => 'Diag. / Prognóstico', 'color' => '#ffc107', 'cases' => []],
            ClinicalCase::ETAPA_PLANO_TRATAMENTO => ['label' => 'Plano de Tratamento', 'color' => '#198754', 'cases' => []],
            ClinicalCase::ETAPA_EM_TRATAMENTO => ['label' => 'Em Tratamento', 'color' => '#0dcaf0', 'cases' => []],
            'FINALIZADO' => ['label' => 'Finalizado', 'color' => '#adb5bd', 'cases' => []],
        ];

        $now = Carbon::now();

        foreach ($cases as $case) {
            // Determinar coluna: status FINALIZADO → coluna Finalizado, senão → etapa_atual
            $stage = $case->status === ClinicalCase::STATUS_FINALIZADO
                ? 'FINALIZADO'
                : ($case->etapa_atual ?? ClinicalCase::ETAPA_CONSULTA_INICIAL);

            // Calcular alertas
            $lastConsulta = $case->consultations->first();
            $alerts = [];

            if ($lastConsulta && $lastConsulta->created_at->diffInDays($now) > 30) {
                $alerts[] = ['type' => 'warning', 'text' => 'Sem consulta há ' . $lastConsulta->created_at->diffInDays($now) . ' dias'];
            }

            $planoProposto = $case->treatmentPlans->where('status', 'Proposto')->first();
            if ($planoProposto && $planoProposto->created_at->diffInDays($now) > 15) {
                $alerts[] = ['type' => 'danger', 'text' => 'Plano proposto há ' . $planoProposto->created_at->diffInDays($now) . ' dias'];
            }

            // Calcular valor estimado total
            $valorEstimado = $case->treatmentPlans->sum('estimated_value');

            // Calcular idade do paciente
            $idade = null;
            if ($case->patient && $case->patient->birth_date) {
                $idade = Carbon::parse($case->patient->birth_date)->age;
            }

            $cardData = [
                'id' => $case->id,
                'title' => $case->title,
                'patient_name' => $case->patient->full_name ?? 'Paciente',
                'patient_id' => $case->patient_id,
                'idade' => $idade,
                'etapa_atual' => $case->etapa_atual,
                'etapa_label' => $case->etapa_label,
                'last_consulta' => $lastConsulta ? $lastConsulta->created_at->format('d/m/Y') : null,
                'plano_status' => $case->treatmentPlans->first()->status ?? null,
                'valor_estimado' => $valorEstimado > 0 ? $valorEstimado : null,
                'alerts' => $alerts,
                'stage' => $stage,
            ];

            if (isset($columns[$stage])) {
                $columns[$stage]['cases'][] = $cardData;
            }
        }

        return view('kanban.index', compact('columns'));
    }

    /**
     * Mover card no Kanban (AJAX)
     * Atualiza etapa_atual diretamente no ClinicalCase
     */
    public function updateKanbanStage(Request $request, $id)
    {
        $allStages = array_merge(ClinicalCase::ETAPAS, ['FINALIZADO']);

        $validated = $request->validate([
            'stage' => 'required|string|in:' . implode(',', $allStages),
        ]);

        $case = ClinicalCase::findOrFail($id);
        $stage = $validated['stage'];
        $oldEtapa = $case->etapa_atual;

        // Se Finalizado → encerrar caso
        if ($stage === 'FINALIZADO') {
            $case->update([
                'status' => ClinicalCase::STATUS_FINALIZADO,
                'data_fim' => now()->toDateString(),
                'closed_at' => now(),
            ]);

            TimelineEvent::registrar(
                TimelineEvent::CASO_FINALIZADO,
                $case->patient_id,
                $case->id,
                "Caso finalizado via Kanban"
            );
        }
        // Se voltou do Finalizado → reabrir
        elseif ($case->status === ClinicalCase::STATUS_FINALIZADO && $stage !== 'FINALIZADO') {
            $case->update([
                'status' => ClinicalCase::STATUS_ATIVO,
                'etapa_atual' => $stage,
                'data_fim' => null,
                'closed_at' => null,
            ]);

            TimelineEvent::registrar(
                TimelineEvent::CASO_REABERTO,
                $case->patient_id,
                $case->id,
                "Caso reaberto via Kanban para etapa: " . (ClinicalCase::ETAPA_LABELS[$stage] ?? $stage)
            );
        }
        // Movendo entre etapas clínicas
        else {
            $case->update(['etapa_atual' => $stage]);

            // Se EM_TRATAMENTO → atualiza plano para EmExecucao e status do caso
            if ($stage === ClinicalCase::ETAPA_EM_TRATAMENTO) {
                $case->update(['status' => ClinicalCase::STATUS_EM_TRATAMENTO]);
                $plan = $case->treatmentPlans()->where('status', 'Proposto')->first()
                    ?: $case->treatmentPlans()->where('status', 'Aprovado')->first();
                if ($plan) {
                    $plan->update(['status' => 'EmExecucao']);
                }
            }

            TimelineEvent::registrar(
                TimelineEvent::ETAPA_ALTERADA,
                $case->patient_id,
                $case->id,
                "Etapa alterada via Kanban: " . (ClinicalCase::ETAPA_LABELS[$oldEtapa] ?? $oldEtapa) .
                " → " . (ClinicalCase::ETAPA_LABELS[$stage] ?? $stage),
                ['de' => $oldEtapa, 'para' => $stage]
            );
        }

        return response()->json(['success' => true, 'stage' => $stage]);
    }
}
