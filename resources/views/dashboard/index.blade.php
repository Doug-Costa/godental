@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <!-- Header + Filtro -->
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-5">
            <div>
                <h1 class="fw-bold mb-1" style="color: #4f4f4f;">Dashboard Clínico</h1>
                <p class="text-muted mb-0">Visão geral do desempenho da sua clínica</p>
            </div>
            <form method="GET" action="{{ route('dashboard.index') }}" class="d-flex gap-2 align-items-end">
                <div>
                    <label class="form-label small text-muted mb-1">De</label>
                    <input type="date" name="startDate" value="{{ $startDate->format('Y-m-d') }}" class="form-control"
                        style="border-radius: 10px; border-color: #eee;">
                </div>
                <div>
                    <label class="form-label small text-muted mb-1">Até</label>
                    <input type="date" name="endDate" value="{{ $endDate->format('Y-m-d') }}" class="form-control"
                        style="border-radius: 10px; border-color: #eee;">
                </div>
                <button type="submit" class="btn text-white px-4"
                    style="background-color: #CA1D53; border-radius: 10px; height: 38px;">
                    <i class="bi bi-funnel me-1"></i>Filtrar
                </button>
            </form>
        </div>

        <!-- KPI Cards -->
        <div class="row g-3 mb-5">
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #fce4ec;">
                            <i class="bi bi-mic-fill" style="color: #CA1D53; font-size: 1.2rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0" style="color: #CA1D53;">{{ $totalConsultas }}</h3>
                        <small class="text-muted">Consultas</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #e3f2fd;">
                            <i class="bi bi-people-fill text-primary" style="font-size: 1.2rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0 text-primary">{{ $novosPacientes }}</h3>
                        <small class="text-muted">Novos Pacientes</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #e8f5e9;">
                            <i class="bi bi-folder2-open text-success" style="font-size: 1.2rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0 text-success">{{ $casosAtivos }}</h3>
                        <small class="text-muted">Casos Ativos</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #fff3e0;">
                            <i class="bi bi-journal-text text-warning" style="font-size: 1.2rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0 text-warning">{{ $planosPropostos }}</h3>
                        <small class="text-muted">Planos Propostos</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #e8eaf6;">
                            <i class="bi bi-check2-circle text-info" style="font-size: 1.2rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0 text-info">{{ $planosAprovados }}</h3>
                        <small class="text-muted">Planos Aprovados</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 16px; background: linear-gradient(135deg, #CA1D53, #d9346a);">
                    <div class="card-body p-3 text-center text-white">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background: rgba(255,255,255,0.15);">
                            <i class="bi bi-currency-dollar" style="font-size: 1.2rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0">R$ {{ number_format($faturamentoPrevisto, 0, ',', '.') }}</h3>
                        <small class="opacity-75">Faturamento Previsto</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas de Estoque -->
        @if($lowStockItems->isNotEmpty())
            <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-5" role="alert">
                <h5 class="alert-heading fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Atenção: Estoque Baixo
                </h5>
                <div class="row g-2">
                    @foreach($lowStockItems as $item)
                        <div class="col-md-4 col-sm-6">
                            <div class="bg-white p-2 rounded border d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">{{ $item->name }}</span>
                                <span class="badge bg-danger">{{ $item->current_stock }} / {{ $item->min_stock }}
                                    {{ $item->unit }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Alertas de Inadimplência -->
        @if($pacientesInadimplentes > 0)
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-5" role="alert">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center me-3"
                            style="width: 48px; height: 48px; flex-shrink: 0;">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading fw-bold mb-1 text-danger">Atenção: Inadimplência Detectada</h5>
                            <p class="mb-0 text-secondary">
                                Existem <strong>{{ $pacientesInadimplentes }}</strong> pacientes com pagamentos em atraso,
                                totalizando
                                <strong class="text-danger">R$ {{ number_format($totalInadimplencia, 2, ',', '.') }}</strong>.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('financial.index', ['status' => 'delinquent']) }}" class="btn btn-danger rounded-pill px-4 fw-bold">
                        Verificar Financeiro
                    </a>
                </div>
            </div>
        @endif

        <!-- Painel Financeiro -->
        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block mb-1">Fluxo de Caixa (Realizado)</small>
                        <h3 class="fw-bold mb-0 {{ $fluxoCaixa >= 0 ? 'text-success' : 'text-danger' }}">
                            R$ {{ number_format($fluxoCaixa, 2, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block mb-1">Total Receitas (Pago)</small>
                        <h3 class="fw-bold mb-0 text-success">
                            R$ {{ number_format($receitaTotal, 2, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block mb-1">Total Despesas (Pago)</small>
                        <h3 class="fw-bold mb-0 text-danger">
                            R$ {{ number_format($despesaTotal, 2, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block mb-1">A Receber / A Pagar (Pendente)</small>
                        <div class="d-flex justify-content-center gap-3">
                            <span class="text-success fw-bold"><i class="bi bi-arrow-up"></i>
                                {{ number_format($contasReceber, 0, ',', '.') }}</span>
                            <span class="text-danger fw-bold"><i class="bi bi-arrow-down"></i>
                                {{ number_format($contasPagar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-4 mb-5">
            <!-- Consultas no Tempo -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #4f4f4f;">
                            <i class="bi bi-graph-up text-danger me-2"></i>Consultas no Período
                        </h6>
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="chartConsultasPeriodo"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultas por Tipo -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #4f4f4f;">
                            <i class="bi bi-bar-chart text-danger me-2"></i>Por Tipo
                        </h6>
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="chartConsultasTipo"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <!-- Distribuição por Etapa -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #4f4f4f;">
                            <i class="bi bi-diagram-3 text-danger me-2"></i>Distribuição por Etapa Clínica
                        </h6>
                        <div style="position: relative; height: 280px; width: 100%;">
                            <canvas id="chartEtapas"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bloco Financeiro -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4" style="color: #4f4f4f;">
                            <i class="bi bi-wallet2 text-danger me-2"></i>Resumo Financeiro
                        </h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
                                    <small class="text-muted d-block mb-1">Faturamento Previsto</small>
                                    <h4 class="fw-bold text-success mb-0">R$
                                        {{ number_format($faturamentoPrevisto, 2, ',', '.') }}
                                    </h4>
                                    <small class="text-muted">Todos os planos</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background-color: #eff6ff; border: 1px solid #bfdbfe;">
                                    <small class="text-muted d-block mb-1">Faturamento Realizado</small>
                                    <h4 class="fw-bold text-primary mb-0">R$
                                        {{ number_format($faturamentoRealizado, 2, ',', '.') }}
                                    </h4>
                                    <small class="text-muted">Planos finalizados</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background-color: #fff7ed; border: 1px solid #fed7aa;">
                                    <small class="text-muted d-block mb-1">Planos Propostos</small>
                                    <h4 class="fw-bold text-warning mb-0">{{ $planosPropostos }}</h4>
                                    <small class="text-muted">Aguardando aprovação</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background-color: #fdf2f8; border: 1px solid #fbcfe8;">
                                    <small class="text-muted d-block mb-1">Taxa Conversão</small>
                                    @php
                                        $totalPlanos = $planosPropostos + $planosAprovados;
                                        $taxaConversao = $totalPlanos > 0 ? round(($planosAprovados / $totalPlanos) * 100) : 0;
                                    @endphp
                                    <h4 class="fw-bold mb-0" style="color: #CA1D53;">{{ $taxaConversao }}%</h4>
                                    <small class="text-muted">Propostos → Aprovados</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Link para Kanban -->
        <div class="text-center">
            <a href="{{ route('kanban.index') }}" class="btn btn-outline-danger px-5 py-3 rounded-pill fw-bold">
                <i class="bi bi-kanban me-2"></i>Abrir Kanban de Atendimentos
            </a>
        </div>
    </div>
@endsection

@section('api')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const brandColor = '#CA1D53';
            const brandColorAlpha = 'rgba(202, 29, 83, 0.15)';

            // Consultas no Período (Linha)
            const periodoData = @json($consultasPorPeriodo);
            const periodoKeys = Object.keys(periodoData);
            const periodoLabels = periodoKeys.map(d => {
                const parts = d.split('-');
                return parts[2] + '/' + parts[1];
            });

            if (periodoKeys.length > 0) {
                new Chart(document.getElementById('chartConsultasPeriodo'), {
                    type: 'line',
                    data: {
                        labels: periodoLabels,
                        datasets: [{
                            label: 'Consultas',
                            data: Object.values(periodoData),
                            borderColor: brandColor,
                            backgroundColor: brandColorAlpha,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: brandColor,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f0f0f0' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // Consultas por Tipo (Barra horizontal)
            const tipoData = @json($consultasPorTipo);
            const tipoKeys = Object.keys(tipoData);

            if (tipoKeys.length > 0) {
                new Chart(document.getElementById('chartConsultasTipo'), {
                    type: 'bar',
                    data: {
                        labels: tipoKeys,
                        datasets: [{
                            data: Object.values(tipoData),
                            backgroundColor: [brandColor, '#0d6efd', '#198754', '#ffc107', '#fd7e14', '#6f42c1'],
                            borderRadius: 8,
                            barThickness: 28,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f0f0f0' } },
                            y: { grid: { display: false } }
                        }
                    }
                });
            }

            // Distribuição por Etapa (Barra)
            const etapaData = @json($distribuicaoEtapa);
            const etapaKeys = Object.keys(etapaData);
            const etapaColors = {
                'ENTRADA': '#6c757d', 'ANAMNESE': '#0d6efd',
                'DIAGNOSTICO': '#ffc107', 'PROGNOSTICO': '#fd7e14', 'PLANO': '#198754'
            };
            const etapaLabelsMap = {
                'ENTRADA': 'Entrada', 'ANAMNESE': 'Anamnese',
                'DIAGNOSTICO': 'Diagnóstico', 'PROGNOSTICO': 'Prognóstico', 'PLANO': 'Plano'
            };

            if (etapaKeys.length > 0) {
                new Chart(document.getElementById('chartEtapas'), {
                    type: 'bar',
                    data: {
                        labels: etapaKeys.map(k => etapaLabelsMap[k] || k),
                        datasets: [{
                            data: Object.values(etapaData),
                            backgroundColor: etapaKeys.map(k => etapaColors[k] || '#adb5bd'),
                            borderRadius: 8,
                            barThickness: 40,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f0f0f0' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
@endsection