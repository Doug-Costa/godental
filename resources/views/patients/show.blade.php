@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="row align-items-start mb-5 g-4">
            <div class="col-md-7">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('patients.index') }}" class="btn btn-light rounded-circle me-3"
                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h1 class="fw-bold mb-1 d-flex align-items-center" style="color: #4f4f4f;">
                        {{ $patient->full_name }}
                        @if($patient->is_delinquent)
                            <span class="badge bg-warning-subtle text-warning fs-6 ms-3 d-flex align-items-center border border-warning-subtle" 
                                  data-bs-toggle="tooltip" title="Este paciente possui pendências financeiras vencidas">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Inadimplente
                            </span>
                        @endif
                    </h1>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <div class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 8px;">
                        <i class="bi bi-person-vcard me-2"></i>ID: #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 8px;">
                        <i class="bi bi-calendar3 me-2"></i>Nascimento:
                        {{ $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') : 'Não informado' }}
                    </div>
                    @if($patient->phone)
                        <div class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 8px;">
                            <i class="bi bi-whatsapp me-2"></i>{{ $patient->phone }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-5 d-flex justify-content-md-end gap-2 align-items-center">
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-outline-secondary px-4"
                    style="border-radius: 12px;">
                    <i class="bi bi-pencil me-2"></i> Editar Cadastro
                </a>
                <button type="button" class="btn btn-outline-danger px-4" style="border-radius: 12px;"
                    data-bs-toggle="modal" data-bs-target="#modalNovaConsulta">
                    <i class="bi bi-plus-circle me-2"></i> Nova Consulta
                </button>
                <button type="button" class="btn text-white px-4" style="background-color: #CA1D53; border-radius: 12px;"
                    data-bs-toggle="modal" data-bs-target="#modalNovoAgendamento">
                    <i class="bi bi-calendar-plus me-2"></i> Agendar Retorno
                </button>
            </div>
        </div>

        <div class="row g-4">
            <!-- Coluna Central: Histórico e Prontuário -->
            <div class="col-lg-8">
                <!-- Abas do Prontuário -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <ul class="nav nav-pills gap-2" id="patientTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill px-4" id="history-tab" data-bs-toggle="pill"
                                    data-bs-target="#history" type="button" role="tab">Linha do Tempo</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4" id="plans-tab" data-bs-toggle="pill"
                                    data-bs-target="#plans" type="button" role="tab">Plano de Tratamento</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4" id="docs-tab" data-bs-toggle="pill"
                                    data-bs-target="#docs" type="button" role="tab">Documentos / Raio-X</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content" id="patientTabContent">



                            <div class="tab-pane fade show active" id="history" role="tabpanel">
                                <div class="timeline-container px-2">
                                    {{-- Grouped consultations by Case --}}
                                    @foreach($patient->clinicalCases as $caso)
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                                <i class="bi bi-folder2-open text-danger"></i>
                                                <strong class="text-dark">{{ $caso->title }}</strong>
                                                <span class="badge {{ $caso->status === 'Ativo' ? 'bg-success' : 'bg-secondary' }} rounded-pill ms-2">{{ $caso->status }}</span>
                                            </div>
                                            @foreach($caso->consultations as $consulta)
                                                <div class="d-flex gap-3 mb-4 position-relative timeline-item ms-3">
                                                    <div class="timeline-line"></div>
                                                    <div class="rounded-circle bg-white shadow-sm border p-2 d-flex align-items-center justify-content-center"
                                                        style="width: 45px; height: 45px; z-index: 2;">
                                                        <i class="bi bi-mic-fill text-danger"></i>
                                                    </div>
                                                    <div class="flex-grow-1 card border-0 bg-light p-3" style="border-radius: 15px;">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="fw-bold mb-0">{{ $consulta->consultation_type }}</h6>
                                                                <small class="text-muted">{{ $consulta->created_at->format('d/m/Y H:i') }}</small>
                                                            </div>
                                                            <a href="{{ route('consultas.show', $consulta->id) }}"
                                                                class="btn btn-sm btn-white border rounded-pill px-3">Ver detalhes</a>
                                                        </div>
                                                        <p class="small text-secondary mb-0 text-truncate-3">
                                                            {{ $consulta->observations ?? 'Sem observações registradas.' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach

                                    {{-- Orphan consultations (not linked to any case) --}}
                                    @if($orphanConsultations->count() > 0)
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                                <i class="bi bi-clock-history text-muted"></i>
                                                <strong class="text-muted">Consultas Avulsas</strong>
                                            </div>
                                            @foreach($orphanConsultations as $consulta)
                                                <div class="d-flex gap-3 mb-4 position-relative timeline-item ms-3">
                                                    <div class="timeline-line"></div>
                                                    <div class="rounded-circle bg-white shadow-sm border p-2 d-flex align-items-center justify-content-center"
                                                        style="width: 45px; height: 45px; z-index: 2;">
                                                        <i class="bi bi-mic-fill text-secondary"></i>
                                                    </div>
                                                    <div class="flex-grow-1 card border-0 bg-light p-3" style="border-radius: 15px;">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="fw-bold mb-0">{{ $consulta->consultation_type }}</h6>
                                                                <small class="text-muted">{{ $consulta->created_at->format('d/m/Y H:i') }}</small>
                                                            </div>
                                                            <a href="{{ route('consultas.show', $consulta->id) }}"
                                                                class="btn btn-sm btn-white border rounded-pill px-3">Ver detalhes</a>
                                                        </div>
                                                        <p class="small text-secondary mb-0 text-truncate-3">
                                                            {{ $consulta->observations ?? 'Sem observações registradas.' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($patient->consultations->count() === 0)
                                        <div class="text-center py-5">
                                            <i class="bi bi-clock-history fs-1 text-muted opacity-25 d-block mb-3"></i>
                                            <p class="text-secondary">Nenhuma atividade registrada ainda.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Plano de Tratamento -->
                            <div class="tab-pane fade" id="plans" role="tabpanel">
                                @forelse($patient->treatmentPlans as $plan)
                                    <div class="card border mb-3" style="border-radius: 15px;">
                                        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $plan->title }}</h6>
                                                @if($plan->description)
                                                    <small class="text-muted">{{ Str::limit($plan->description, 80) }}</small>
                                                @endif
                                            </div>
                                            <div class="d-flex gap-2 align-items-center">
                                                @if($plan->estimated_value)
                                                    <span class="badge bg-light text-dark border px-3 py-2" style="border-radius: 8px;">
                                                        R$ {{ number_format($plan->estimated_value, 2, ',', '.') }}
                                                    </span>
                                                @endif
                                                @php
                                                    $planStatusColors = [
                                                        'Proposto' => 'bg-info-subtle text-info',
                                                        'Aprovado' => 'bg-primary-subtle text-primary',
                                                        'EmExecucao' => 'bg-warning-subtle text-warning',
                                                        'Finalizado' => 'bg-success-subtle text-success',
                                                        'planned' => 'bg-primary-subtle text-primary',
                                                        'active' => 'bg-warning-subtle text-warning',
                                                        'completed' => 'bg-success-subtle text-success',
                                                    ];
                                                @endphp
                                                <span class="badge {{ $planStatusColors[$plan->status] ?? 'bg-secondary-subtle text-secondary' }} rounded-pill">
                                                    {{ ucfirst($plan->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body px-4 pb-4 pt-0">
                                            {{-- Procedures --}}
                                            @if($plan->procedures && $plan->procedures->count() > 0)
                                                <h6 class="small text-uppercase text-muted fw-bold mt-2 mb-3">Procedimentos</h6>
                                                <div class="list-group list-group-flush border-top">
                                                    @foreach($plan->procedures as $proc)
                                                        <div class="list-group-item px-0 py-3 border-light d-flex gap-3 align-items-center">
                                                            @php
                                                                $procStatusColors = [
                                                                    'Pendente' => 'bg-secondary',
                                                                    'EmAndamento' => 'bg-warning',
                                                                    'Concluido' => 'bg-success',
                                                                ];
                                                            @endphp
                                                            <span class="badge {{ $procStatusColors[$proc->status] ?? 'bg-secondary' }} rounded-circle p-2">
                                                                <i class="bi {{ $proc->status === 'Concluido' ? 'bi-check' : 'bi-circle' }} text-white" style="font-size: 0.6rem;"></i>
                                                            </span>
                                                            <div class="flex-grow-1">
                                                                <div class="{{ $proc->status === 'Concluido' ? 'text-decoration-line-through text-muted' : 'fw-semibold' }}">
                                                                    {{ $proc->name }}
                                                                </div>
                                                                @if($proc->region)
                                                                    <small class="text-muted d-block">Região: {{ $proc->region }}</small>
                                                                @endif
                                                                @if($proc->expected_date)
                                                                    <small class="text-muted d-block">Previsto: {{ $proc->expected_date->format('d/m/Y') }}</small>
                                                                @endif
                                                            </div>
                                                            <span class="badge {{ $procStatusColors[$proc->status] ?? 'bg-secondary' }} text-white px-2 py-1" style="border-radius: 6px; font-size: 0.7rem;">
                                                                {{ $proc->status }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Legacy Steps --}}
                                            @if($plan->steps && $plan->steps->count() > 0)
                                                <div class="list-group list-group-flush border-top mt-2">
                                                    @foreach($plan->steps as $step)
                                                        <div class="list-group-item px-0 py-3 border-light d-flex gap-3 align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" {{ $step->status == 'completed' ? 'checked' : '' }} disabled>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="{{ $step->status == 'completed' ? 'text-decoration-line-through text-muted' : 'fw-semibold' }}">
                                                                    {{ $step->description }}
                                                                </div>
                                                                @if($step->notes)
                                                                    <small class="text-muted d-block">{{ $step->notes }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="bi bi-journal-medical fs-1 text-muted opacity-25 d-block mb-3"></i>
                                        <p class="text-secondary">Nenhum plano de tratamento ativo.</p>
                                        <button class="btn btn-sm btn-outline-danger px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalNovoPlano">Criar Novo Plano</button>
                                    </div>
                                @endforelse
                            </div>


                            <!-- Documentos -->
                            <div class="tab-pane fade" id="docs" role="tabpanel">
                                <div class="row row-cols-2 row-cols-md-3 g-3">
                                    @forelse($patient->documents as $doc)
                                        <div class="col">
                                            <div class="card border-light h-100" style="border-radius: 12px; overflow: hidden;">
                                                <div class="bg-dark d-flex align-items-center justify-content-center"
                                                    style="height: 120px;">
                                                    <i class="bi bi-file-earmark-medical text-white fs-1"></i>
                                                </div>
                                                <div class="card-body p-2 text-center">
                                                    <small class="fw-bold d-block text-truncate">{{ $doc->label ?? 'Documento' }}</small>
                                                    <small class="text-muted">{{ $doc->created_at->format('d/m/Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-5">
                                            <i class="bi bi-images fs-1 text-muted opacity-25 d-block mb-3"></i>
                                            <p class="text-secondary">Nenhum exame ou documento anexado.</p>
                                            <button class="btn btn-sm btn-outline-danger px-4 rounded-pill">Fazer Upload</button>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral: Alerts and Clinical Notes -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; background-color: #CA1D53;">
                    <div class="card-body p-4 text-white">
                        <h6 class="fw-bold mb-3"><i class="bi bi-magic me-2"></i>Go Intelligence Insights</h6>
                        <div class="p-3 bg-white bg-opacity-10 rounded-4 mb-3 border border-white border-opacity-10">
                            <small class="d-block opacity-75 mb-1">Dica Clínica Futurista</small>
                            <p class="small mb-0">Baseado no histórico, este paciente apresenta sensibilidade a anestésicos
                                tipo X. Prepare protocolo alternativo.</p>
                        </div>
                        <p class="x-small mb-0 opacity-50 italic">* Esta área será alimentada por IA nas próximas fases.</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-clipboard2-pulse me-2"></i>Observações Clínicas</h6>
                        <div class="bg-light p-3 rounded-4" style="min-height: 150px;">
                            <p class="small text-secondary mb-0">
                                {{ $patient->clinical_observations ?? 'Nenhuma observação clínica especial registrada para este paciente.' }}
                            </p>
                        </div>
                        <button class="btn btn-link btn-sm text-danger mt-2 p-0 text-decoration-none fw-bold">Editar Observações</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Nova Consulta com Caso Clínico -->
    <div class="modal fade" id="modalNovaConsulta" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" style="color: #4f4f4f;">
                        <i class="bi bi-plus-circle text-danger me-2"></i>Nova Consulta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <form id="formNovaConsulta">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                        <input type="hidden" name="patient_name" value="{{ $patient->full_name }}">

                        <!-- Case Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Caso Clínico</label>
                            <div class="d-flex gap-2 mb-3">
                                <button type="button" class="btn btn-outline-danger rounded-pill px-4 flex-fill case-option active"
                                    data-option="new" onclick="toggleCaseOption('new')">
                                    <i class="bi bi-plus me-1"></i>Novo Caso
                                </button>
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 flex-fill case-option"
                                    data-option="existing" onclick="toggleCaseOption('existing')">
                                    <i class="bi bi-folder2-open me-1"></i>Continuar Caso
                                </button>
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 flex-fill case-option"
                                    data-option="none" onclick="toggleCaseOption('none')">
                                    Avulsa
                                </button>
                            </div>

                            <!-- New Case Title -->
                            <div id="newCaseFields">
                                <input type="text" name="case_title" class="form-control"
                                    placeholder="Ex: Tratamento Ortodôntico, Implante Dente 36..."
                                    style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                            </div>

                            <!-- Existing Case Dropdown -->
                            <div id="existingCaseFields" style="display: none;">
                                <select name="clinical_case_id" class="form-select"
                                    style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                    <option value="">Selecione um caso ativo...</option>
                                    @foreach($patient->clinicalCases->where('status', 'Ativo') as $caso)
                                        <option value="{{ $caso->id }}">{{ $caso->title }} ({{ $caso->opened_at ? $caso->opened_at->format('d/m/Y') : '' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Consultation Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tipo de Consulta</label>
                            <select name="consultation_type" class="form-select"
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                <option value="Avaliação">Avaliação</option>
                                <option value="Retorno">Retorno</option>
                                <option value="Urgência">Urgência</option>
                                <option value="Procedimento">Procedimento</option>
                                <option value="Manutenção">Manutenção</option>
                            </select>
                        </div>

                        <!-- Clinical Step -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Etapa Clínica</label>
                            <select name="clinical_step" class="form-select"
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                <option value="ENTRADA">Entrada</option>
                                <option value="ANAMNESE">Anamnese</option>
                                <option value="DIAGNOSTICO">Diagnóstico</option>
                                <option value="PROGNOSTICO">Prognóstico</option>
                                <option value="PLANO">Plano de Tratamento</option>
                            </select>
                        </div>
                        
                        <!-- Doctor/Professional -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Profissional Responsável</label>
                            <select name="doctor_id" class="form-select"
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                <option value="">— Selecionar Profissional —</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->role == 'dentist' ? 'Dentista' : 'Colaborador' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Service and Value -->
                        <div class="row mb-4">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Procedimento Realizado (Opcional)</label>
                                <select class="form-select" name="service_price_id" style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;"
                                    onchange="const p = this.options[this.selectedIndex].dataset.price; document.getElementById('consultValorInput').value = parseFloat(p||0).toFixed(2);">
                                    <option value="" data-price="0">-- Selecione --</option>
                                    @foreach($servicePrices as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->default_price }}">
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Valor (R$)</label>
                                <input type="number" class="form-control" name="valor" id="consultValorInput"
                                    value="0.00" step="0.01" min="0" 
                                    style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                            </div>
                        </div>

                        <!-- Observations -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Observações Rápidas</label>
                            <textarea name="observations" rows="3" class="form-control"
                                placeholder="Notas iniciais..."
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;"></textarea>
                        </div>

                        <button type="submit" class="btn text-white px-5 py-3 fw-bold w-100"
                            style="background-color: #CA1D53; border-radius: 12px;">
                            <i class="bi bi-mic me-2"></i>Iniciar Consulta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles for Timeline and Tabs -->
    <style>
        #patientTab .nav-link {
            color: #6c757d;
            border: 1px solid transparent;
            font-weight: 500;
        }

        #patientTab .nav-link.active {
            background-color: #CA1D53 !important;
            color: white !important;
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-line {
            position: absolute;
            left: 22px;
            top: 45px;
            width: 2px;
            height: calc(100% + 1.5rem);
            background-color: #dee2e6;
            z-index: 1;
        }

        .text-truncate-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .case-card {
            transition: all 0.2s ease;
        }
        .case-card:hover {
            box-shadow: 0 4px 20px rgba(202, 29, 83, 0.12);
            border-color: #CA1D53 !important;
        }

        .case-option.active {
            background-color: #CA1D53 !important;
            border-color: #CA1D53 !important;
            color: white !important;
        }
    </style>

    <script>
        function toggleCaseOption(option) {
            document.querySelectorAll('.case-option').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.case-option[data-option="${option}"]`).classList.add('active');

            document.getElementById('newCaseFields').style.display = option === 'new' ? 'block' : 'none';
            document.getElementById('existingCaseFields').style.display = option === 'existing' ? 'block' : 'none';
        }

        document.getElementById('formNovaConsulta').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            // Determine case handling
            const activeOption = document.querySelector('.case-option.active')?.dataset.option;

            const createConsultation = (clinicalCaseId) => {
                const payload = {
                    patient_id: data.patient_id,
                    patient_name: data.patient_name,
                    patient_identifier: '',
                    consultation_type: data.consultation_type,
                    clinical_step: data.clinical_step,
                    clinical_case_id: clinicalCaseId,
                    observations: data.observations,
                    transcription: '',
                    status: 'pending',
                    service_price_id: data.service_price_id,
                    valor: data.valor
                };

                fetch('/api/consultations/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': data._token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(r => r.json())
                .then(result => {
                    if (result.success && result.id) {
                        window.location.href = '/painel-consultas/' + result.id;
                    } else {
                        window.location.reload();
                    }
                })
                .catch(() => window.location.reload());
            };

            if (activeOption === 'new' && data.case_title) {
                // Create case first, then consultation
                fetch('/clinical-cases', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': data._token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ patient_id: data.patient_id, title: data.case_title })
                })
                .then(r => r.json())
                .then(result => {
                    createConsultation(result.case?.id || null);
                })
                .catch(() => createConsultation(null));
            } else if (activeOption === 'existing' && data.clinical_case_id) {
                createConsultation(data.clinical_case_id);
            } else {
                createConsultation(null);
            }
        });
    </script>

    <!-- ═══════ MODAL: AGENDAR RETORNO ═══════ -->
    <div class="modal fade" id="modalNovoAgendamento" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-calendar-plus me-2 text-danger"></i>Agendar Retorno — {{ $patient->full_name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <form id="formNovoAgendamento">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                        <input type="hidden" name="type" value="retorno">

                        <div class="row g-3">
                            <!-- Data e Hora -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Data *</label>
                                <input type="date" class="form-control" name="start_time_date" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Hora *</label>
                                <input type="time" class="form-control" name="start_time_time" value="09:00" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Duração (min)</label>
                                <select class="form-select" name="duration_minutes">
                                    <option value="15">15 min</option>
                                    <option value="30" selected>30 min</option>
                                    <option value="45">45 min</option>
                                    <option value="60">1 hora</option>
                                    <option value="90">1h30</option>
                                </select>
                            </div>

                            <!-- Caso Clínico -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Caso Clínico</label>
                                <select class="form-select" name="clinical_case_id">
                                    <option value="">— Sem vínculo —</option>
                                    @foreach($patient->clinicalCases as $cc)
                                        <option value="{{ $cc->id }}" {{ $cc->status === 'Ativo' ? 'selected' : '' }}>
                                            {{ $cc->title }} ({{ $cc->etapa_label ?? $cc->status }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dentista -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Dentista</label>
                                <select class="form-select" name="doctor_id">
                                    <option value="">— Selecionar —</option>
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Serviço / Valor -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Serviço (preço pré-cadastrado)</label>
                                <select class="form-select" name="service_price_id" id="agendServicePriceSelect">
                                    <option value="" data-price="">— Valor personalizado —</option>
                                    @foreach($servicePrices as $sp)
                                        <option value="{{ $sp->id }}" data-price="{{ $sp->default_price }}">
                                            {{ $sp->name }} — R$ {{ number_format($sp->default_price, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Valor (R$) *</label>
                                <input type="number" class="form-control" name="valor" id="agendValorInput"
                                    min="0" step="0.01" value="0.00" required>
                            </div>

                            <!-- Observações -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Observações</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Observações sobre o retorno..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                    <button type="button" class="btn text-white px-4" id="btnSalvarAgendamento"
                        style="background: linear-gradient(135deg, #CA1D53, #7c1233); border: none; border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-calendar-check me-1"></i> Agendar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill valor from service price selection
        document.getElementById('agendServicePriceSelect')?.addEventListener('change', function() {
            const price = this.options[this.selectedIndex].dataset.price;
            if (price) {
                document.getElementById('agendValorInput').value = parseFloat(price).toFixed(2);
            }
        });

        // Submit agendamento
        document.getElementById('btnSalvarAgendamento')?.addEventListener('click', function() {
            const form = document.getElementById('formNovoAgendamento');
            const formData = new FormData(form);

            // Combine date + time into start_time
            const date = formData.get('start_time_date');
            const time = formData.get('start_time_time');
            if (!date || !time) {
                alert('Por favor, preencha data e hora.');
                return;
            }

            // Calculate end_time based on duration
            const duration = parseInt(formData.get('duration_minutes') || 30);
            const startDate = new Date(date + 'T' + time);
            const endDate = new Date(startDate.getTime() + duration * 60000);
            
            // Format dates (YYYY-MM-DD HH:mm:ss)
            const startStr = date + ' ' + time + ':00';
            const endStr = endDate.getFullYear() + '-' + 
                           String(endDate.getMonth() + 1).padStart(2, '0') + '-' + 
                           String(endDate.getDate()).padStart(2, '0') + ' ' + 
                           String(endDate.getHours()).padStart(2, '0') + ':' + 
                           String(endDate.getMinutes()).padStart(2, '0') + ':00';

            const payload = {
                patient_id: formData.get('patient_id'),
                consultation_type: 'Retorno',
                start_time: startStr,
                end_time: endStr,
                clinical_case_id: formData.get('clinical_case_id') || null,
                doctor_id: formData.get('doctor_id') || null,
                service_price_id: formData.get('service_price_id') || null,
                valor: formData.get('valor'),
                notes: formData.get('notes'),
                _token: formData.get('_token')
            };

            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Salvando...';

            fetch('/api/agenda', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': payload._token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(result => {
                if (result.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalNovoAgendamento')).hide();
                    window.location.reload();
                } else {
                    alert('Erro ao agendar: ' + (result.message || JSON.stringify(result.errors || 'Erro desconhecido')));
                    this.disabled = false;
                    this.innerHTML = '<i class="bi bi-calendar-check me-1"></i> Agendar';
                }
            })
            .catch(err => {
                alert('Erro de rede: ' + err.message);
                this.disabled = false;
                this.innerHTML = '<i class="bi bi-calendar-check me-1"></i> Agendar';
            });
        });
    </script>
    <!-- ═══════ MODAL: NOVO PLANO DE TRATAMENTO ═══════ -->
    <div class="modal fade" id="modalNovoPlano" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" style="color: #4f4f4f;">
                        <i class="bi bi-journal-plus text-danger me-2"></i>Novo Plano de Tratamento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <form id="formNovoPlano">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título do Plano *</label>
                            <input type="text" name="title" class="form-control" required
                                placeholder="Ex: Implante Elemento 36"
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                        </div>

                        <!-- Clinical Case -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Caso Clínico (Opcional)</label>
                            <select name="clinical_case_id" class="form-select"
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                <option value="">— Sem vínculo —</option>
                                @foreach($patient->clinicalCases->where('status', 'Ativo') as $caso)
                                    <option value="{{ $caso->id }}">{{ $caso->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Doctor -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Profissional Responsável</label>
                            <select name="doctor_id" class="form-select"
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                <option value="">— Selecionar Profissional —</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->role == 'dentist' ? 'Dentista' : 'Colaborador' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Estimated Value -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Valor Estimado (R$)</label>
                            <input type="number" name="estimated_value" class="form-control" step="0.01" min="0" value="0.00"
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Descrição / Observações</label>
                            <textarea name="description" rows="3" class="form-control"
                                placeholder="Detalhes do plano..."
                                style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;"></textarea>
                        </div>

                        <button type="submit" class="btn text-white px-5 py-3 fw-bold w-100"
                            style="background-color: #CA1D53; border-radius: 12px;">
                            <i class="bi bi-check-lg me-2"></i>Criar Plano
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formNovoPlano')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            const btn = form.querySelector('button[type="submit"]');

            // Disable button
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Salvando...';
            btn.disabled = true;

            fetch('/treatment-plans', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': data._token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(r => r.json())
            .then(result => {
                if (result.success) {
                    window.location.reload();
                } else {
                    alert('Erro ao criar plano: ' + (result.message || 'Erro desconhecido'));
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            })
            .catch(err => {
                alert('Erro de rede: ' + err.message);
                btn.innerHTML = originalContent;
                btn.disabled = false;
            });
        });
    </script>
@endsection