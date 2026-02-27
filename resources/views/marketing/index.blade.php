@extends('facelift2.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1" style="color: #4f4f4f; font-size: 1.6rem;">
                    <i class="bi bi-megaphone-fill text-danger me-2"></i>Marketing & Vendas
                </h1>
                <p class="text-muted mb-0">Gestão de Leads, Integrações (WhatsApp, Instagram, IA) e Funil de Vendas.</p>
            </div>
        </div>

        <!-- Placeholder Content -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3 text-success">
                            <i class="bi bi-whatsapp" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold text-muted">WhatsApp Business</h5>
                        <p class="small text-muted mb-3">Conecte seu WhatsApp para gerenciar conversas e agendamentos
                            automáticos.</p>
                        <button class="btn btn-outline-secondary btn-sm" disabled>Em Breve</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-robot" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold text-muted">Bot de Atendimento IA</h5>
                        <p class="small text-muted mb-3">Configure respostas automáticas e triagem inteligente de pacientes.
                        </p>
                        <button class="btn btn-outline-secondary btn-sm" disabled>Em Breve</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-funnel-fill" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold text-muted">Funil de Vendas</h5>
                        <p class="small text-muted mb-3">Acompanhe a jornada do paciente desde o primeiro contato até o
                            fechamento.</p>
                        <button class="btn btn-outline-secondary btn-sm" disabled>Em Breve</button>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-5 text-center">
                        <i class="bi bi-rocket-takeoff text-danger mb-3" style="font-size: 4rem;"></i>
                        <h3 class="fw-bold text-secondary">Módulo em Desenvolvimento</h3>
                        <p class="text-muted" style="max-width: 600px; margin: 0 auto;">
                            Estamos preparando uma suíte completa de ferramentas de marketing para impulsionar sua clínica.
                            Em breve você poderá integrar redes sociais, disparar campanhas e automatizar o relacionamento
                            com seus pacientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection