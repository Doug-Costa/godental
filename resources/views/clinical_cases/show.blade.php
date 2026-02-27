@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <!-- Breadcrumbs -->
        <div class="d-flex align-items-center gap-2 mb-4 text-secondary small">
            <a href="{{ route('patients.show', $case->patient->id) }}" class="text-decoration-none text-secondary">
                <i class="bi bi-person me-1"></i>{{ $case->patient->full_name }}
            </a>
            <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
            <span class="text-dark fw-semibold">{{ $case->title }}</span>
        </div>

        <!-- Case Header -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: #4f4f4f;">
                            <i class="bi bi-folder2-open text-danger me-2"></i>{{ $case->title }}
                        </h2>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span
                                class="badge px-3 py-2 {{ $case->status === 'Ativo' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}"
                                style="border-radius: 8px; font-size: 0.85rem;">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>{{ $case->status }}
                            </span>
                            <span class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 8px;">
                                <i class="bi bi-calendar3 me-1"></i>Aberto em:
                                {{ $case->opened_at ? $case->opened_at->format('d/m/Y') : $case->created_at->format('d/m/Y') }}
                            </span>
                            @if($case->closed_at)
                                <span class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 8px;">
                                    <i class="bi bi-calendar-x me-1"></i>Fechado em: {{ $case->closed_at->format('d/m/Y') }}
                                </span>
                            @endif
                            <span class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 8px;">
                                <i class="bi bi-chat-dots me-1"></i>{{ $case->consultations->count() }} consulta(s)
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        @if($case->status === 'Ativo')
                            <form action="{{ route('clinical-cases.close', $case->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary px-4" style="border-radius: 12px;">
                                    <i class="bi bi-lock me-1"></i>Encerrar Caso
                                </button>
                            </form>
                        @else
                            <form action="{{ route('clinical-cases.reopen', $case->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-success px-4" style="border-radius: 12px;">
                                    <i class="bi bi-unlock me-1"></i>Reabrir Caso
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Content: Consultations Timeline -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 p-4">
                        <h5 class="fw-bold mb-0" style="color: #4f4f4f;">
                            <i class="bi bi-clock-history text-danger me-2"></i>Consultas deste Caso
                        </h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        @forelse($case->consultations as $consulta)
                            <div class="d-flex gap-3 mb-4 position-relative timeline-item">
                                <div class="timeline-line"></div>
                                @php
                                    $stepColors = [
                                        'ENTRADA' => '#6c757d',
                                        'ANAMNESE' => '#0d6efd',
                                        'DIAGNOSTICO' => '#ffc107',
                                        'PROGNOSTICO' => '#fd7e14',
                                        'PLANO' => '#198754'
                                    ];
                                    $stepLabels = [
                                        'ENTRADA' => 'Entrada',
                                        'ANAMNESE' => 'Anamnese',
                                        'DIAGNOSTICO' => 'Diagnóstico',
                                        'PROGNOSTICO' => 'Prognóstico',
                                        'PLANO' => 'Plano'
                                    ];
                                    $color = $stepColors[$consulta->clinical_step ?? 'ENTRADA'];
                                @endphp
                                <div class="rounded-circle bg-white shadow-sm border d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px; z-index: 2; flex-shrink: 0; border-color: {{ $color }} !important; border-width: 2px !important;">
                                    <i class="bi bi-mic-fill" style="color: {{ $color }};"></i>
                                </div>
                                <div class="flex-grow-1 card border bg-light p-4" style="border-radius: 16px;">
                                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $consulta->consultation_type ?? 'Consulta' }}</h6>
                                            <small
                                                class="text-muted">{{ $consulta->created_at->format('d/m/Y \à\s H:i') }}</small>
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <span class="badge text-white px-2 py-1"
                                                style="background-color: {{ $color }}; font-size: 0.75rem; border-radius: 6px;">
                                                {{ $stepLabels[$consulta->clinical_step ?? 'ENTRADA'] }}
                                            </span>
                                            <a href="{{ route('consultas.show', $consulta->id) }}"
                                                class="btn btn-sm btn-white border rounded-pill px-3">
                                                <i class="bi bi-eye me-1"></i>Ver
                                            </a>
                                        </div>
                                    </div>
                                    @if($consulta->observations)
                                        <p class="small text-secondary mb-0 mt-2">{{ Str::limit($consulta->observations, 200) }}</p>
                                    @endif
                                    @if($consulta->diagnosis)
                                        <div class="mt-2 p-2 bg-white rounded-3 border">
                                            <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                                style="font-size: 0.7rem;">Diagnóstico</small>
                                            <small class="text-dark">{{ Str::limit($consulta->diagnosis, 150) }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-clipboard-x fs-1 text-muted opacity-25 d-block mb-3"></i>
                                <p class="text-secondary">Nenhuma consulta registrada neste caso.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar: Treatment Plans & Procedures -->
            <div class="col-lg-4">
                <!-- Treatment Plans -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #4f4f4f;">
                            <i class="bi bi-journal-medical text-danger me-2"></i>Planos de Tratamento
                        </h6>
                        @forelse($case->treatmentPlans as $plan)
                                        <div class="border rounded-4 p-3 mb-3 bg-light">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <strong class="small">{{ $plan->title }}</strong>
                                                @php
                                                    $planColors = [
                                                        'Proposto' => 'text-info',
                                                        'Aprovado' => 'text-primary',
                                                        'EmExecucao' => 'text-warning',
                                                        'Finalizado' => 'text-success',
                                                    ];
                                                @endphp
                            <span
                                                    class="badge bg-white border {{ $planColors[$plan->status] ?? 'text-secondary' }} px-2 py-1"
                                                    style="font-size: 0.7rem;">
                                                    {{ $plan->status }}
                                                </span>
                                            </div>
                                            @if($plan->estimated_value)
                                                <small class="text-muted d-block mb-2">Valor est.: R$
                                                    {{ number_format($plan->estimated_value, 2, ',', '.') }}</small>
                                            @endif
                                            @if($plan->procedures->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($plan->procedures as $proc)
                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                            @php
                                                                $procIcons = [
                                                                    'Pendente' => 'bi-circle text-secondary',
                                                                    'EmAndamento' => 'bi-arrow-repeat text-warning',
                                                                    'Concluido' => 'bi-check-circle-fill text-success',
                                                                ];
                                                            @endphp
                                                            <i class="bi {{ $procIcons[$proc->status] ?? 'bi-circle text-secondary' }}"
                                                                style="font-size: 0.75rem;"></i>
                                                            <small
                                                                class="{{ $proc->status === 'Concluido' ? 'text-decoration-line-through text-muted' : '' }}">{{ $proc->name }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                        @empty
                            <div class="text-center py-3">
                                <p class="small text-muted mb-0">Sem planos vinculados.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- AI Insights Placeholder -->
                <div class="card border-0 shadow-sm"
                    style="border-radius: 20px; background: linear-gradient(135deg, #CA1D53, #d9346a);">
                    <div class="card-body p-4 text-white">
                        <h6 class="fw-bold mb-3"><i class="bi bi-stars me-2"></i>Resumo IA do Caso</h6>
                        <p class="small opacity-75 mb-3">Análise geral do caso com base nas consultas registradas,
                            diagnósticos e evolução terapêutica.</p>
                        <div class="p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-10">
                            <p class="small mb-0 opacity-75 italic">Funcionalidade em desenvolvimento. Será gerada
                                automaticamente pela IA GoIntelligence.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-line {
            position: absolute;
            left: 23px;
            top: 48px;
            width: 2px;
            height: calc(100% + 1.5rem);
            background-color: #dee2e6;
            z-index: 1;
        }
    </style>
@endsection