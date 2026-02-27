@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <div class="mb-5 text-center">
            <h1 class="fw-bold mb-1" style="color: #4f4f4f;">Hub Go Clinic</h1>
            <p class="text-secondary fs-5">Selecione uma funcionalidade para começar</p>
        </div>

        <!-- Hub de Ações Rápidas -->
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('patients.index') }}"
                    class="card border-0 shadow-sm h-100 text-decoration-none hover-lift" style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-people-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Pacientes</h4>
                        <p class="text-muted mb-0">Gestão completa de prontuários</p>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('consultas.index') }}"
                    class="card border-0 shadow-sm h-100 text-decoration-none hover-lift" style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle bg-info-subtle text-info mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-mic-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Consultas</h4>
                        <p class="text-muted mb-0">Histórico e transcrições</p>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('agenda.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none hover-lift"
                    style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle bg-success-subtle text-success mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-calendar3 fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Agenda</h4>
                        <p class="text-muted mb-0">Calendário e compromissos</p>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('kanban.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none hover-lift"
                    style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px; background: #d1ecf1; color: #0c5460;">
                            <i class="bi bi-kanban fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Kanban</h4>
                        <p class="text-muted mb-0">Fluxo de atendimento</p>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('dashboard.index') }}"
                    class="card border-0 shadow-sm h-100 text-decoration-none hover-lift" style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle bg-warning-subtle text-warning mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-bar-chart-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Dashboard</h4>
                        <p class="text-muted mb-0">Análise de desempenho</p>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('admin.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none hover-lift"
                    style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px; background: #e2d5f1; color: #5a2d82;">
                            <i class="bi bi-gear-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Administração</h4>
                        <p class="text-muted mb-0">Dentistas, preços e horários</p>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('financial.index') }}"
                    class="card border-0 shadow-sm h-100 text-decoration-none hover-lift" style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle bg-danger-subtle text-danger mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-cash-coin fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Financeiro</h4>
                        <p class="text-muted mb-0">Contas e fluxo de caixa</p>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-3 col-6">
                <a href="{{ route('inventory.index') }}"
                    class="card border-0 shadow-sm h-100 text-decoration-none hover-lift" style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="rounded-circle bg-secondary-subtle text-secondary mx-auto mb-4 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-box-seam fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Estoque</h4>
                        <p class="text-muted mb-0">Gestão de materiais</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Botão de Ação Primária -->
        <div class="text-center mt-4">
            <button type="button" class="btn btn-lg text-white px-5 py-3 shadow-lg hover-lift"
                style="border-radius: 16px; background: linear-gradient(135deg, #CA1D53, #7c1233); font-weight: 600;"
                data-bs-toggle="modal" data-bs-target="#modalNovaConsulta">
                <i class="bi bi-mic-fill me-2"></i> Iniciar Nova Consulta (Go Clinic)
            </button>
        </div>
    </div>

    @include('facelift2.partials.modal_nova_consulta')
@endsection

@section('scripts')
    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection