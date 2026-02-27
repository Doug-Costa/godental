@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('consultas.index') }}" class="text-decoration-none text-secondary">
                <i class="bi bi-arrow-left"></i> Voltar para a lista
            </a>
            @if($consulta->clinical_case_title)
                <span class="badge px-3 py-2"
                    style="background-color: rgba(202,29,83,0.1); color: #CA1D53; border-radius: 10px; font-size: 0.85rem;">
                    <i class="bi bi-folder2-open me-1"></i>Caso: {{ $consulta->clinical_case_title }}
                </span>
            @endif
        </div>

        <div class="row g-4">
            <!-- Patient Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px;">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill fs-1 text-secondary"></i>
                        </div>
                        <h3 class="fw-bold mb-0" style="color: #4f4f4f;">{{ $consulta->patient_name }}</h3>
                        <p class="text-muted">{{ $consulta->patient_identifier }}</p>
                    </div>

                    <hr class="opacity-10">

                    <div class="mb-3">
                        <label class="small text-uppercase text-muted fw-bold">Tipo de Consulta</label>
                        <p class="mb-0">{{ $consulta->consultation_type }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="small text-uppercase text-muted fw-bold">Etapa Clínica</label>
                        <p class="mb-0">
                            @php
                                $stepLabels = [
                                    'ENTRADA' => ['label' => 'Entrada', 'color' => '#6c757d'],
                                    'ANAMNESE' => ['label' => 'Anamnese', 'color' => '#0d6efd'],
                                    'DIAGNOSTICO' => ['label' => 'Diagnóstico', 'color' => '#ffc107'],
                                    'PROGNOSTICO' => ['label' => 'Prognóstico', 'color' => '#fd7e14'],
                                    'PLANO' => ['label' => 'Plano', 'color' => '#198754'],
                                ];
                                $step = $stepLabels[$consulta->clinical_step] ?? $stepLabels['ENTRADA'];
                            @endphp
                            <span class="badge px-3 py-2 text-white" style="background-color: {{ $step['color'] }}; border-radius: 8px;">
                                {{ $step['label'] }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="small text-uppercase text-muted fw-bold">Data da Gravação</label>
                        <p class="mb-0">{{ $consulta->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="small text-uppercase text-muted fw-bold">Status</label>
                        <div>
                            @if($consulta->status == 'transcribed')
                                <span class="badge bg-success text-white px-3 py-2" style="border-radius: 8px;">Transcrição
                                    Concluída</span>
                            @elseif($consulta->status == 'recorded')
                                <span class="badge bg-primary text-white px-3 py-2" style="border-radius: 8px;">Áudio
                                    Gravado</span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2" style="border-radius: 8px;">Pendente</span>
                            @endif
                        </div>
                    </div>

                    @if($consulta->audio_path)
                        <div class="mt-4">
                            <label class="small text-uppercase text-muted fw-bold mb-2 d-block">Áudio Original</label>
                            <audio controls class="w-100 shadow-sm" style="border-radius: 30px;">
                                <source src="{{ asset($consulta->audio_path) }}" type="audio/webm">
                                Seu navegador não suporta áudio HTML5.
                            </audio>
                        </div>
                    @endif
                </div>

                <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background-color: #f8f9fa;">
                    <h5 class="fw-bold mb-3" style="color: #4f4f4f;">Observações Iniciais</h5>
                    <p class="mb-0 italic text-secondary">
                        {{ $consulta->observations ?: 'Nenhuma observação informada.' }}
                    </p>
                </div>

                <!-- IA Placeholder Button -->
                @if($consulta->is_db ?? false)
                    <div class="card border-0 shadow-sm p-4 mt-4" style="border-radius: 20px; background: linear-gradient(135deg, #CA1D53, #d9346a);">
                        <div class="text-white text-center">
                            <i class="bi bi-stars fs-2 d-block mb-2"></i>
                            <h6 class="fw-bold mb-2">Gerar Estrutura Clínica</h6>
                            <p class="small opacity-75 mb-3">Preencher automaticamente Anamnese, Diagnóstico, Prognóstico e Plano a partir da transcrição.</p>
                            <button class="btn btn-light fw-bold px-4 py-2" style="border-radius: 12px;" disabled>
                                <i class="bi bi-magic me-2"></i>Em breve (IA)
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Content with Tabs -->
            <div class="col-lg-8">
                <!-- Clinical Navigation Tabs -->
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
                    <div class="card-header bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold mb-0" style="color: #4f4f4f;">
                                <i class="bi bi-clipboard2-pulse text-danger me-2"></i> Prontuário Clínico
                            </h4>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                    <i class="bi bi-printer me-1"></i> Exportar
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger px-3 delete-btn"
                                    data-id="{{ $consulta->id }}" data-patient="{{ $consulta->patient_name }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash me-1"></i> Excluir
                                </button>
                            </div>
                        </div>

                        <ul class="nav nav-pills gap-2 flex-nowrap overflow-auto" id="clinicalTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill px-3" id="tab-transcricao" data-bs-toggle="pill"
                                    data-bs-target="#pane-transcricao" type="button" role="tab">
                                    <i class="bi bi-mic me-1"></i>Transcrição
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-3" id="tab-anamnese" data-bs-toggle="pill"
                                    data-bs-target="#pane-anamnese" type="button" role="tab">
                                    <i class="bi bi-clipboard-pulse me-1"></i>Anamnese
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-3" id="tab-diagnostico" data-bs-toggle="pill"
                                    data-bs-target="#pane-diagnostico" type="button" role="tab">
                                    <i class="bi bi-search me-1"></i>Diagnóstico
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-3" id="tab-prognostico" data-bs-toggle="pill"
                                    data-bs-target="#pane-prognostico" type="button" role="tab">
                                    <i class="bi bi-graph-up me-1"></i>Prognóstico
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-3" id="tab-plano" data-bs-toggle="pill"
                                    data-bs-target="#pane-plano" type="button" role="tab">
                                    <i class="bi bi-list-check me-1"></i>Plano
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4 bg-light bg-opacity-50">
                        <div class="tab-content" id="clinicalTabContent">

                            <!-- Tab: Transcrição -->
                            <div class="tab-pane fade show active" id="pane-transcricao" role="tabpanel">
                                <div class="transcription-text p-4 bg-white border shadow-inner"
                                    style="border-radius: 16px; min-height: 300px; line-height: 1.8; font-size: 1.1rem; color: #333;">
                                    @if($consulta->transcription)
                                        {!! nl2br(e($consulta->transcription)) !!}
                                    @else
                                        <div class="text-center py-5">
                                            <div class="spinner-border text-danger mb-3" role="status"></div>
                                            <p class="text-muted">A transcrição está sendo processada por nossa IA...<br>Isso pode levar alguns instantes.</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-center mt-3">
                                    <p class="small text-muted mb-0">Transcrição gerada automaticamente pelo motor GoIntelligence.</p>
                                </div>
                            </div>

                            <!-- Tab: Anamnese -->
                            <div class="tab-pane fade" id="pane-anamnese" role="tabpanel">
                                <div class="clinical-field-card p-4 bg-white border" style="border-radius: 16px; min-height: 300px;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0" style="color: #4f4f4f;">
                                            <i class="bi bi-clipboard-pulse text-primary me-2"></i>Anamnese
                                        </h5>
                                        @if($consulta->is_db ?? false)
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-save-field"
                                                data-field="observations" onclick="saveClinicalField('observations')">
                                                <i class="bi bi-check2 me-1"></i>Salvar
                                            </button>
                                        @endif
                                    </div>
                                    <textarea id="field-observations" class="form-control border-0 bg-light"
                                        style="border-radius: 12px; min-height: 250px; line-height: 1.8; font-size: 1rem; resize: vertical;"
                                        placeholder="Registrar anamnese do paciente: queixa principal, histórico médico, medicamentos, alergias..."
                                        {{ ($consulta->is_db ?? false) ? '' : 'disabled' }}>{{ $consulta->observations }}</textarea>
                                </div>
                            </div>

                            <!-- Tab: Diagnóstico -->
                            <div class="tab-pane fade" id="pane-diagnostico" role="tabpanel">
                                <div class="clinical-field-card p-4 bg-white border" style="border-radius: 16px; min-height: 300px;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0" style="color: #4f4f4f;">
                                            <i class="bi bi-search text-warning me-2"></i>Diagnóstico
                                        </h5>
                                        @if($consulta->is_db ?? false)
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-save-field"
                                                onclick="saveClinicalField('diagnosis')">
                                                <i class="bi bi-check2 me-1"></i>Salvar
                                            </button>
                                        @endif
                                    </div>
                                    <textarea id="field-diagnosis" class="form-control border-0 bg-light"
                                        style="border-radius: 12px; min-height: 250px; line-height: 1.8; font-size: 1rem; resize: vertical;"
                                        placeholder="Registrar diagnóstico clínico..."
                                        {{ ($consulta->is_db ?? false) ? '' : 'disabled' }}>{{ $consulta->diagnosis }}</textarea>
                                </div>
                            </div>

                            <!-- Tab: Prognóstico -->
                            <div class="tab-pane fade" id="pane-prognostico" role="tabpanel">
                                <div class="clinical-field-card p-4 bg-white border" style="border-radius: 16px; min-height: 300px;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0" style="color: #4f4f4f;">
                                            <i class="bi bi-graph-up text-info me-2"></i>Prognóstico
                                        </h5>
                                        @if($consulta->is_db ?? false)
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-save-field"
                                                onclick="saveClinicalField('prognosis')">
                                                <i class="bi bi-check2 me-1"></i>Salvar
                                            </button>
                                        @endif
                                    </div>
                                    <textarea id="field-prognosis" class="form-control border-0 bg-light"
                                        style="border-radius: 12px; min-height: 250px; line-height: 1.8; font-size: 1rem; resize: vertical;"
                                        placeholder="Registrar prognóstico do caso..."
                                        {{ ($consulta->is_db ?? false) ? '' : 'disabled' }}>{{ $consulta->prognosis }}</textarea>
                                </div>
                            </div>

                            <!-- Tab: Plano de Tratamento -->
                            <div class="tab-pane fade" id="pane-plano" role="tabpanel">
                                <div class="clinical-field-card p-4 bg-white border" style="border-radius: 16px; min-height: 300px;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0" style="color: #4f4f4f;">
                                            <i class="bi bi-list-check text-success me-2"></i>Plano de Tratamento Sugerido
                                        </h5>
                                        @if($consulta->is_db ?? false)
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-save-field"
                                                onclick="saveClinicalField('suggested_plan')">
                                                <i class="bi bi-check2 me-1"></i>Salvar
                                            </button>
                                        @endif
                                    </div>
                                    <textarea id="field-suggested_plan" class="form-control border-0 bg-light"
                                        style="border-radius: 12px; min-height: 250px; line-height: 1.8; font-size: 1rem; resize: vertical;"
                                        placeholder="Registrar o plano de tratamento sugerido, procedimentos, materiais..."
                                        {{ ($consulta->is_db ?? false) ? '' : 'disabled' }}>{{ $consulta->suggested_plan }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Go Intelligence Insights -->
                <div class="card border-0 shadow-sm overflow-hidden mt-4"
                    style="border-radius: 24px; background: linear-gradient(135deg, #ffffff, #fff5f8);">
                    <div class="card-header border-0 p-4 bg-transparent">
                        <h4 class="fw-bold mb-0" style="color: #CA1D53;">
                            <i class="bi bi-magic me-2"></i> Go Intelligence Insights
                        </h4>
                        <p class="text-secondary small mb-0">Análise inteligente da consulta e sugestões clínicas</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-3 rounded-4 border bg-white h-100">
                                    <h6 class="fw-bold text-dark mb-2 small text-uppercase">Pontos Chave</h6>
                                    @if($consulta->ai_summary)
                                        <p class="small text-secondary mb-0">{{ $consulta->ai_summary }}</p>
                                    @else
                                        <ul class="mb-0 small text-secondary">
                                            <li>Paciente relatou dor aguda no dente 16.</li>
                                            <li>Sensibilidade térmica confirmada.</li>
                                            <li>Histórico de bruxismo mencionado.</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-4 border bg-white h-100">
                                    <h6 class="fw-bold text-dark mb-2 small text-uppercase">Próximos Passos</h6>
                                    <p class="small text-secondary mb-0">
                                        Solicitar raio-X periapical do quadrante 1. Avaliar possível necessidade de
                                        tratamento endodôntico.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-3 rounded-4 border-dashed text-center">
                            <span class="text-muted small">Insights gerados automaticamente pela IA DentalGO</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true"
        data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel" style="color: #4f4f4f;">Excluir Consulta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <p class="mb-1">Tem certeza que deseja excluir permanentemente a consulta de <strong
                            id="patientName"></strong>?</p>
                    <p class="text-danger small fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i> Esta ação não
                        pode ser desfeita.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" style="border-radius: 12px;"
                        data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4" style="border-radius: 12px;">Confirmar
                            Exclusão</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast for Save Feedback -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
        <div id="saveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i><span id="toastMsg">Salvo com sucesso!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete modal handler
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const patientNameSpan = document.getElementById('patientName');
            const deleteForm = document.getElementById('deleteForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const patient = this.getAttribute('data-patient');
                    patientNameSpan.textContent = patient;
                    deleteForm.action = "{{ url('painel-consultas') }}/" + id;
                });
            });
        });

        // Save clinical field via AJAX
        function saveClinicalField(fieldName) {
            const consultaId = '{{ $consulta->id }}';
            const textarea = document.getElementById('field-' + fieldName);
            if (!textarea) return;

            const data = {};
            data[fieldName] = textarea.value;

            fetch('/api/consultations/' + consultaId + '/clinical-fields', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(r => r.json())
            .then(result => {
                const toast = document.getElementById('saveToast');
                const msg = document.getElementById('toastMsg');
                if (result.success) {
                    msg.textContent = result.message || 'Salvo com sucesso!';
                    toast.classList.remove('bg-danger');
                    toast.classList.add('bg-success');
                } else {
                    msg.textContent = 'Erro ao salvar.';
                    toast.classList.remove('bg-success');
                    toast.classList.add('bg-danger');
                }
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();
            })
            .catch(() => {
                const toast = document.getElementById('saveToast');
                const msg = document.getElementById('toastMsg');
                msg.textContent = 'Erro de conexão.';
                toast.classList.remove('bg-success');
                toast.classList.add('bg-danger');
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();
            });
        }
    </script>

    <style>
        .transcription-text {
            white-space: pre-wrap;
        }

        #clinicalTabs .nav-link {
            color: #6c757d;
            border: 1px solid transparent;
            font-weight: 500;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        #clinicalTabs .nav-link.active {
            background-color: #CA1D53 !important;
            color: white !important;
        }

        #clinicalTabs .nav-link:hover:not(.active) {
            background-color: #f8f0f3;
            color: #CA1D53;
        }

        .border-dashed {
            border: 2px dashed #dee2e6;
            border-radius: 16px;
        }

        @media print {
            .btn,
            .mb-4,
            .patient-sidebar-audio {
                display: none !important;
            }

            .col-lg-8 {
                width: 100% !important;
            }
        }
    </style>
@endsection