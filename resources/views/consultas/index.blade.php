@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-5 mb-3 mb-md-0">
                <h1 class="fw-bold" style="color: #4f4f4f;">Consultas GoClinic</h1>
                <p class="text-secondary mb-0">Histórico de transcrições inteligentes (GoIntelligence)</p>
            </div>
            <div class="col-md-7 d-flex justify-content-md-end gap-2 align-items-center flex-wrap">
                <form action="{{ route('consultas.index') }}" method="GET" class="d-flex gap-2 flex-grow-1 flex-md-grow-0"
                    style="height: 44px;">
                    <div class="input-group shadow-sm border-0 flex-nowrap"
                        style="border-radius: 12px; overflow: hidden; background: white; width: 280px;">
                        <input type="text" name="search" class="form-control border-0 px-3"
                            placeholder="Buscar consultas..." value="{{ request('search') }}"
                            style="font-size: 0.95rem; height: 44px;">
                        <button class="btn btn-white border-0 text-secondary px-3" type="submit" style="height: 44px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <select name="per_page" class="form-select border-0 shadow-sm ps-3 pe-5" onchange="this.form.submit()"
                        style="border-radius: 12px; width: 140px; color: #6c757d; font-size: 0.95rem; height: 44px; background-position: right 0.75rem center;">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / página</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 / página</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / página</option>
                    </select>
                </form>
                <button type="button"
                    class="btn btn-outline-secondary px-4 d-flex align-items-center justify-content-center"
                    style="border-radius: 12px; height: 44px; font-weight: 500;" data-bs-toggle="modal"
                    data-bs-target="#modalNovaConsulta">
                    <i class="bi bi-plus-circle me-2"></i> Nova Consulta
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-0">Paciente</th>
                            <th class="py-3 border-0">Data</th>
                            <th class="py-3 border-0">Tipo</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="px-4 py-3 border-0 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <div class="fw-bold" style="color: #4f4f4f;">{{ $consulta->patient_name }}</div>
                                    <small class="text-muted">{{ $consulta->patient_identifier }}</small>
                                </td>
                                <td class="py-3 align-middle">
                                    {{ $consulta->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 align-middle">
                                    <span class="badge bg-light text-dark border px-3 py-2" style="border-radius: 8px;">
                                        {{ $consulta->consultation_type }}
                                    </span>
                                </td>
                                <td class="py-3 align-middle">
                                    @if($consulta->status == 'transcribed')
                                        <span class="badge bg-success-subtle text-success px-3 py-2" style="border-radius: 8px;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Transcrita
                                        </span>
                                    @elseif($consulta->status == 'recorded')
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2" style="border-radius: 8px;">
                                            <i class="bi bi-mic-fill me-1"></i> Gravada
                                        </span>
                                    @elseif($consulta->status == 'completed')
                                        <span class="badge bg-success text-white px-3 py-2" style="border-radius: 8px;">
                                            <i class="bi bi-stars me-1"></i> Concluída (IA)
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2" style="border-radius: 8px;">
                                            <i class="bi bi-clock-history me-1"></i> Pendente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('consultas.show', $consulta->id) }}" class="btn btn-sm btn-light px-3"
                                            style="border-radius: 8px;">
                                            <i class="bi bi-eye me-1"></i> Ver Detalhes
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger px-3 delete-btn"
                                            style="border-radius: 8px;" data-id="{{ $consulta->id }}"
                                            data-patient="{{ $consulta->patient_name }}" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    Nenhuma consulta registrada ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $consultas->appends(request()->query())->links() }}
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
                    <form id="deleteForm" method="POST" action=""
                        onsubmit="console.log('Action:', this.action); console.log('_method:', this.querySelector('input[name=_method]')?.value); return true;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4" style="border-radius: 12px;">Confirmar
                            Exclusão</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('facelift2.partials.modal_nova_consulta')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const patientNameSpan = document.getElementById('patientName');
            const deleteForm = document.getElementById('deleteForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const patient = this.getAttribute('data-patient');

                    if (patientNameSpan) patientNameSpan.textContent = patient;
                    if (deleteForm) deleteForm.action = "{{ url('painel-consultas') }}/" + id;
                });
            });
        });
    </script>

    <style>
        .pagination {
            gap: 5px;
        }

        .pagination .page-item .page-link {
            border-radius: 8px !important;
            border: none;
            color: #4f4f4f !important;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s;
            background-color: #f8f9fa;
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background-color: #CA1D53 !important;
            color: white !important;
            border: none !important;
            box-shadow: 0 4px 6px rgba(202, 29, 83, 0.2);
        }

        .pagination .page-item .page-link:hover {
            background-color: #e9ecef !important;
            color: #CA1D53 !important;
        }

        .pagination .page-item.disabled .page-link {
            background-color: transparent !important;
            opacity: 0.5;
            color: #adb5bd !important;
        }

        /* Custom adjustment for input-group focus */
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(202, 29, 83, 0.1) !important;
        }
    </style>
@endsection