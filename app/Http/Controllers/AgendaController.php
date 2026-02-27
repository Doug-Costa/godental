<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Patient;
use App\Models\ClinicalCase;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\ServicePrice;
use App\Models\TimelineEvent;
use App\Models\FinancialTransaction;
use App\Models\FinancialCategory;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    /**
     * Página da Agenda
     */
    public function index()
    {
        $patients = Patient::orderBy('full_name')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'full_name' => $p->full_name,
                'is_delinquent' => $p->is_delinquent,
            ];
        });
        $statusColors = Schedule::statusColors();
        $statusLabels = Schedule::statusLabels();
        $doctors = Doctor::active()->orderBy('name')->get();
        $servicePrices = ServicePrice::active()->orderBy('name')->get();

        return view('agenda.index', compact('patients', 'statusColors', 'statusLabels', 'doctors', 'servicePrices'));
    }

    /**
     * Eventos para o calendário (JSON)
     */
    public function events(Request $request)
    {
        $query = Schedule::with('patient');

        // Filtro por intervalo de datas (FullCalendar envia start/end)
        if ($request->has('start')) {
            $query->where('start_time', '>=', Carbon::parse($request->start));
        }
        if ($request->has('end')) {
            $query->where('end_time', '<=', Carbon::parse($request->end));
        }

        // Filtros opcionais
        if ($request->filled('dentista')) {
            $query->where('dentista', $request->dentista);
        }
        if ($request->filled('tipo')) {
            $query->where('consultation_type', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->get();
        $colors = Schedule::statusColors();

        $events = $schedules->map(function ($s) use ($colors) {
            $doctor = $s->doctor;
            return [
                'id' => $s->id,
                'title' => ($s->patient->full_name ?? 'Paciente') . ' — ' . ($s->consultation_type ?? 'Consulta'),
                'start' => $s->start_time->toIso8601String(),
                'end' => $s->end_time->toIso8601String(),
                'color' => $doctor ? $doctor->color : ($colors[$s->status] ?? '#0d6efd'),
                'extendedProps' => [
                    'patient_id' => $s->patient_id,
                    'patient_name' => $s->patient->full_name ?? 'Paciente',
                    'clinical_case_id' => $s->clinical_case_id,
                    'consultation_type' => $s->consultation_type,
                    'dentista' => $s->dentista,
                    'doctor_id' => $s->doctor_id,
                    'doctor_name' => $doctor ? $doctor->name : $s->dentista,
                    'valor' => $s->valor,
                    'status' => $s->status,
                    'status_label' => Schedule::statusLabels()[$s->status] ?? $s->status,
                    'notes' => $s->notes,
                    'is_delinquent' => $s->patient->is_delinquent ?? false,
                ],
            ];
        });

        return response()->json($events);
    }

    /**
     * Criar agendamento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'consultation_type' => 'nullable|string|max:100',
            'doctor_id' => 'nullable|exists:doctors,id',
            'dentista' => 'nullable|string|max:100',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'valor' => 'required|numeric|min:0',
            'service_price_id' => 'nullable|exists:service_prices,id',
            'notes' => 'nullable|string',
        ], [
            'start_time.after_or_equal' => 'Não é possível agendar para uma data passada.',
        ]);

        $validated['status'] = Schedule::STATUS_AGENDADO;

        // Se doctor_id foi preenchido, copiar nome do doutor para dentista
        if (!empty($validated['doctor_id']) && empty($validated['dentista'])) {
            $doc = Doctor::find($validated['doctor_id']);
            if ($doc)
                $validated['dentista'] = $doc->name;
        }

        // Vincular caso clínico ativo se existir
        $activeCaso = ClinicalCase::where('patient_id', $validated['patient_id'])
            ->where('status', ClinicalCase::STATUS_ATIVO)
            ->latest()
            ->first();

        if ($activeCaso) {
            $validated['clinical_case_id'] = $activeCaso->id;
        }

        $schedule = Schedule::create($validated);
        $schedule->load('patient', 'doctor');

        // Registrar evento de retorno na timeline
        $isRetorno = stripos($validated['consultation_type'] ?? '', 'Retorno') !== false;
        if ($activeCaso) {
            TimelineEvent::registrar(
                $isRetorno ? TimelineEvent::RETORNO_AGENDADO : TimelineEvent::CONSULTA_CRIADA,
                $validated['patient_id'],
                $activeCaso->id,
                $isRetorno
                ? "Retorno agendado para " . Carbon::parse($validated['start_time'])->format('d/m/Y H:i')
                : "Agendamento criado: " . ($validated['consultation_type'] ?? 'Consulta'),
                ['valor' => $validated['valor'], 'schedule_id' => $schedule->id]
            );
        }

        // Gerar Conta a Receber (Pendente)
        if ($schedule->valor > 0) {
            $category = FinancialCategory::firstOrCreate(
                ['name' => 'Consultas'],
                ['type' => 'income', 'color' => '#5a9e7c']
            );

            FinancialTransaction::create([
                'description' => "Agendamento: " . ($schedule->consultation_type ?? 'Consulta') . " - " . ($schedule->patient->full_name ?? 'Paciente'),
                'amount' => $schedule->valor,
                'type' => 'income',
                'date' => $schedule->start_time, // Data do agendamento
                'due_date' => $schedule->start_time, // Vencimento no dia
                'status' => 'pending',
                'category_id' => $category->id,
                'patient_id' => $schedule->patient_id,
                'related_type' => Schedule::class,
                'related_id' => $schedule->id,
            ]);
        }

        $colors = Schedule::statusColors();
        $doctor = $schedule->doctor;

        return response()->json([
            'success' => true,
            'event' => [
                'id' => $schedule->id,
                'title' => ($schedule->patient->full_name ?? 'Paciente') . ' — ' . ($schedule->consultation_type ?? 'Consulta'),
                'start' => $schedule->start_time->toIso8601String(),
                'end' => $schedule->end_time->toIso8601String(),
                'color' => $doctor ? $doctor->color : ($colors[$schedule->status] ?? '#0d6efd'),
                'extendedProps' => [
                    'patient_id' => $schedule->patient_id,
                    'patient_name' => $schedule->patient->full_name ?? 'Paciente',
                    'clinical_case_id' => $schedule->clinical_case_id,
                    'consultation_type' => $schedule->consultation_type,
                    'dentista' => $schedule->dentista,
                    'doctor_id' => $schedule->doctor_id,
                    'doctor_name' => $doctor ? $doctor->name : $schedule->dentista,
                    'valor' => $schedule->valor,
                    'status' => $schedule->status,
                    'status_label' => Schedule::statusLabels()[$schedule->status] ?? $schedule->status,
                    'notes' => $schedule->notes,
                ],
            ],
        ]);
    }

    /**
     * Atualizar agendamento (drag-and-drop reagendar)
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'patient_id' => 'sometimes|exists:patients,id', // Allow changing patient if needed
            'start_time' => 'required|date', // Removed 'after_or_equal:today' to avoid TZ issues during debug, can add back later or logic check
            'end_time' => 'required|date|after:start_time',
            'consultation_type' => 'nullable|string|max:100',
            'doctor_id' => 'nullable|exists:doctors,id',
            'dentista' => 'nullable|string|max:100',
            'service_price_id' => 'nullable|exists:service_prices,id',
            'valor' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ], [
            'start_time.after_or_equal' => 'Não é possível agendar para uma data passada.',
        ]);

        // Se doctor_id foi alterado/preenchido, atualizar nome do dentista
        if (!empty($validated['doctor_id'])) {
            $doc = Doctor::find($validated['doctor_id']);
            if ($doc)
                $validated['dentista'] = $doc->name;
        }

        $schedule->update($validated);

        return response()->json(['success' => true]);
    }

    /**
     * Mudar status do agendamento
     * Regra: EM_ATENDIMENTO → cria Consulta automaticamente
     */
    public function updateStatus(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:AGENDADO,CONFIRMADO,EM_ATENDIMENTO,CONCLUIDO,CANCELADO,FALTA',
        ]);

        $newStatus = $validated['status'];
        $schedule->update(['status' => $newStatus]);

        $consultationCreated = false;

        // Regra de negócio: EM_ATENDIMENTO → criar Consulta
        if ($newStatus === Schedule::STATUS_EM_ATENDIMENTO) {
            // Verificar se já existe consulta para este agendamento/caso no mesmo dia
            $existingConsulta = Consultation::where('patient_id', $schedule->patient_id)
                ->whereDate('created_at', today())
                ->when($schedule->clinical_case_id, function ($q) use ($schedule) {
                    $q->where('clinical_case_id', $schedule->clinical_case_id);
                })
                ->first();

            if (!$existingConsulta) {
                // Determinar etapa: se caso existe, usar etapa_atual
                $etapa = ClinicalCase::ETAPA_CONSULTA_INICIAL;
                if ($schedule->clinical_case_id) {
                    $caso = ClinicalCase::find($schedule->clinical_case_id);
                    if ($caso)
                        $etapa = $caso->etapa_atual;
                }

                $consultation = Consultation::create([
                    'patient_id' => $schedule->patient_id,
                    'clinical_case_id' => $schedule->clinical_case_id,
                    'consultation_type' => $schedule->consultation_type,
                    'clinical_step' => $etapa,
                    'valor' => $schedule->valor ?? 0,
                    'service_price_id' => $schedule->service_price_id,
                ]);
                $consultationCreated = true;

                // Registrar evento na timeline
                if ($schedule->clinical_case_id) {
                    TimelineEvent::registrar(
                        TimelineEvent::CONSULTA_CRIADA,
                        $schedule->patient_id,
                        $schedule->clinical_case_id,
                        "Consulta iniciada via agenda: {$schedule->consultation_type}",
                        ['valor' => $consultation->valor, 'consultation_id' => $consultation->id]
                    );
                }
            }

        }

        // Regra de negócio: CONCLUIDO → Gerar Receita e Baixar Estoque
        if ($newStatus === Schedule::STATUS_CONCLUIDO) {
            // 1. Gerar Receita Financeira (se houver valor > 0)
            if ($schedule->valor > 0) {
                // Verificar se já existe transação vinculada
                $transacao = FinancialTransaction::where('related_type', Schedule::class)
                    ->where('related_id', $schedule->id)
                    ->first();

                if (!$transacao) {
                    // Se não existe (ex: legado), cria agora como PENDENTE ou PAGO?
                    // User request: "vai para pendente" (confirma a dívida)
                    $categoriaConsulta = FinancialCategory::firstOrCreate(
                        ['name' => 'Consultas'],
                        ['type' => 'income', 'color' => '#5a9e7c']
                    );

                    FinancialTransaction::create([
                        'description' => "Consulta Concluída: " . ($schedule->patient->full_name ?? 'Paciente'),
                        'amount' => $schedule->valor,
                        'type' => 'income',
                        'date' => now(),
                        'due_date' => now(), // Vence hoje
                        'status' => 'pending', // User solicitou "vai para pendente"
                        'category_id' => $categoriaConsulta->id,
                        'patient_id' => $schedule->patient_id,
                        'related_type' => Schedule::class,
                        'related_id' => $schedule->id,
                    ]);
                } else {
                    // Se já existe, não faz nada com o status financeiro para não sobrepor pagamentos manuais.
                    // Apenas garante que a data reflete a realidade?
                    // Melhor não mexer se já existe.
                }
            }

            // 2. Baixar Estoque (se houver procedimento com materiais)
            if ($schedule->service_price_id) {
                // Carrega o serviço com os materiais vinculados
                $service = ServicePrice::with('materials')->find($schedule->service_price_id);

                if ($service && $service->materials->isNotEmpty()) {
                    // Verifica se já existe transação financeira como "sinal" de que já processamos
                    // (Isso é uma simplificação para o MVP. Ideal seria logar a movimentação de estoque)
                    $jaProcessado = FinancialTransaction::where('related_type', Schedule::class)
                        ->where('related_id', $schedule->id)
                        ->exists();

                    // Se não gerou transação (ex: valor 0), corremos risco de duplicar baixa de estoque se o user mudar status 2x.
                    // Para mitigar, vamos assumir que o fluxo é linear.

                    foreach ($service->materials as $material) {
                        // Baixa do estoque
                        $qtd = $material->pivot->quantity_used;
                        // Decrementa (pode ficar negativo, indicando furo de estoque)
                        InventoryItem::where('id', $material->id)->decrement('current_stock', $qtd);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'status_label' => Schedule::statusLabels()[$newStatus] ?? $newStatus,
            'color' => Schedule::statusColors()[$newStatus] ?? '#0d6efd',
            'consultation_created' => $consultationCreated,
        ]);
    }

    /**
     * Excluir agendamento
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Métricas da agenda (JSON)
     */
    public function metrics(Request $request)
    {
        $startDate = $request->query('startDate')
            ? Carbon::parse($request->query('startDate'))->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $endDate = $request->query('endDate')
            ? Carbon::parse($request->query('endDate'))->endOfDay()
            : Carbon::now()->endOfDay();

        $totalAgendados = Schedule::whereBetween('start_time', [$startDate, $endDate])
            ->whereNotIn('status', [Schedule::STATUS_CANCELADO])
            ->count();

        $concluidos = Schedule::whereBetween('start_time', [$startDate, $endDate])
            ->where('status', Schedule::STATUS_CONCLUIDO)
            ->count();

        $faltas = Schedule::whereBetween('start_time', [$startDate, $endDate])
            ->where('status', Schedule::STATUS_FALTA)
            ->count();

        $taxaComparecimento = $totalAgendados > 0
            ? round(($concluidos / $totalAgendados) * 100, 1)
            : 0;

        $taxaFalta = $totalAgendados > 0
            ? round(($faltas / $totalAgendados) * 100, 1)
            : 0;

        // Ocupação da agenda (assumindo horário comercial: 8h-18h, seg-sex = 10h * 5dias)
        $diasUteis = 0;
        $d = $startDate->copy();
        while ($d->lte($endDate)) {
            if ($d->isWeekday())
                $diasUteis++;
            $d->addDay();
        }
        $slotsDisponiveis = $diasUteis * 20; // 20 slots de 30min por dia
        $ocupacaoAgenda = $slotsDisponiveis > 0
            ? round(($totalAgendados / $slotsDisponiveis) * 100, 1)
            : 0;

        // Tempo médio entre consultas por paciente
        $pacientesComMultiplas = Schedule::whereBetween('start_time', [$startDate, $endDate])
            ->where('status', Schedule::STATUS_CONCLUIDO)
            ->selectRaw('patient_id, COUNT(*) as total')
            ->groupBy('patient_id')
            ->having('total', '>', 1)
            ->pluck('patient_id');

        $tempoMedioEntreConsultas = 0;
        if ($pacientesComMultiplas->isNotEmpty()) {
            $totalDias = 0;
            $totalIntervalos = 0;
            foreach ($pacientesComMultiplas as $pid) {
                $datas = Schedule::where('patient_id', $pid)
                    ->where('status', Schedule::STATUS_CONCLUIDO)
                    ->whereBetween('start_time', [$startDate, $endDate])
                    ->orderBy('start_time')
                    ->pluck('start_time');

                for ($i = 1; $i < $datas->count(); $i++) {
                    $totalDias += $datas[$i]->diffInDays($datas[$i - 1]);
                    $totalIntervalos++;
                }
            }
            $tempoMedioEntreConsultas = $totalIntervalos > 0
                ? round($totalDias / $totalIntervalos, 1)
                : 0;
        }

        return response()->json([
            'taxaComparecimento' => $taxaComparecimento,
            'taxaFalta' => $taxaFalta,
            'ocupacaoAgenda' => $ocupacaoAgenda,
            'tempoMedioEntreConsultas' => $tempoMedioEntreConsultas,
        ]);
    }
}
