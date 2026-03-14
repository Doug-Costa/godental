@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-5 mb-3 mb-md-0">
                <h1 class="fw-bold" style="color: #4f4f4f;">Pacientes GoClinic</h1>
                <p class="text-secondary mb-0">Gestão centralizada de prontuários e histórico clínico</p>
            </div>
            <div class="col-md-7 d-flex justify-content-md-end gap-2 align-items-center flex-wrap">
                <form action="{{ route('patients.index') }}" method="GET" class="d-flex gap-2 flex-grow-1 flex-md-grow-0"
                    style="height: 44px;">
                    <div class="input-group shadow-sm border-0 flex-nowrap"
                        style="border-radius: 12px; overflow: hidden; background: white; max-width: 280px; width: 100%;">
                        <input type="text" name="search" class="form-control border-0 px-3"
                            placeholder="Buscar pacientes..." value="{{ request('search') }}"
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
                <a href="{{ route('patients.create') }}"
                    class="btn text-white px-4 d-flex align-items-center justify-content-center"
                    style="border-radius: 12px; background-color: #CA1D53; height: 44px; font-weight: 500;">
                    <i class="bi bi-person-plus-fill me-2"></i> Novo Paciente
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-0">Paciente</th>
                            <th class="py-3 border-0">Contato</th>
                            <th class="py-3 border-0 text-center">Consultas</th>
                            <th class="py-3 border-0">Última Atividade</th>
                            <th class="px-4 py-3 border-0 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold me-3"
                                            style="width: 40px; height: 40px; font-size: 14px;">
                                            {{ strtoupper(substr($patient->full_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="color: #4f4f4f;">
                                                {{ $patient->full_name }}
                                                @if($patient->is_delinquent)
                                                    <i class="bi bi-exclamation-triangle-fill text-warning ms-1"
                                                        title="Pendências Financeiras Encontradas" data-bs-toggle="tooltip"></i>
                                                @endif
                                            </div>
                                            <small class="text-muted">ID:
                                                #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <div><i class="bi bi-telephone small me-1"></i> {{ $patient->phone ?? '---' }}</div>
                                    <small class="text-muted"><i class="bi bi-envelope small me-1"></i>
                                        {{ $patient->email ?? '---' }}</small>
                                </td>
                                <td class="py-3 align-middle text-center">
                                    <span class="badge bg-light text-dark border px-3 py-2" style="border-radius: 8px;">
                                        {{ $patient->consultations_count }}
                                    </span>
                                </td>
                                <td class="py-3 align-middle">
                                    {{ $patient->updated_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 align-middle text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-light px-3"
                                            style="border-radius: 8px;">
                                            <i class="bi bi-folder2-open me-1"></i> Prontuário
                                        </a>
                                        <a href="{{ route('patients.edit', $patient->id) }}"
                                            class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-3"></i>
                                    Nenhum paciente cadastrado ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $patients->appends(request()->query())->links() }}
        </div>
    </div>

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