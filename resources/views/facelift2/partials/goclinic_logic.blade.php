<!-- MODAL 1 - GO CLINIC HUB -->
<div class="modal fade" id="modalGoIntelligence" tabindex="-1" aria-hidden="true" data-bs-backdrop="false"
    style="z-index: 100001;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <div>
                    <h4 class="modal-title fw-bold mb-0" style="color: #CA1D53;">Go Clinic</h4>
                    <small class="text-muted">Painel clínico integrado</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-2">

                <!-- ═══════ HUB — ATALHOS DOS MÓDULOS ═══════ -->
                <div class="row g-3 mb-4">
                    <div class="col-4 col-md-2">
                        <a href="{{ route('dashboard.index') }}" class="goclinic-hub-card text-decoration-none"
                            onclick="window.location.href=this.href">
                            <div class="hub-icon" style="background: linear-gradient(135deg, #f8d7da, #f5c6cb);">
                                <i class="bi bi-grid-1x2-fill" style="color: #c0392b;"></i>
                            </div>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-2">
                        <a href="{{ route('kanban.index') }}" class="goclinic-hub-card text-decoration-none"
                            onclick="window.location.href=this.href">
                            <div class="hub-icon" style="background: linear-gradient(135deg, #d1ecf1, #bee5eb);">
                                <i class="bi bi-kanban" style="color: #0c5460;"></i>
                            </div>
                            <span>Kanban</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-2">
                        <a href="{{ route('agenda.index') }}" class="goclinic-hub-card text-decoration-none"
                            onclick="window.location.href=this.href">
                            <div class="hub-icon" style="background: linear-gradient(135deg, #d4edda, #c3e6cb);">
                                <i class="bi bi-calendar3" style="color: #155724;"></i>
                            </div>
                            <span>Agenda</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-2">
                        <a href="{{ route('patients.index') }}" class="goclinic-hub-card text-decoration-none"
                            onclick="window.location.href=this.href">
                            <div class="hub-icon" style="background: linear-gradient(135deg, #cce5ff, #b8daff);">
                                <i class="bi bi-people-fill" style="color: #004085;"></i>
                            </div>
                            <span>Pacientes</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-2">
                        <a href="{{ route('consultas.index') }}" class="goclinic-hub-card text-decoration-none"
                            onclick="window.location.href=this.href">
                            <div class="hub-icon" style="background: linear-gradient(135deg, #fff3cd, #ffeeba);">
                                <i class="bi bi-journal-text" style="color: #856404;"></i>
                            </div>
                            <span>Consultas</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-2">
                        <a href="{{ route('admin.index') }}" class="goclinic-hub-card text-decoration-none"
                            onclick="window.location.href=this.href">
                            <div class="hub-icon" style="background: linear-gradient(135deg, #e2d5f1, #d4c4e3);">
                                <i class="bi bi-gear-fill" style="color: #5a2d82;"></i>
                            </div>
                            <span>Admin</span>
                        </a>
                    </div>
                </div>

                <!-- ═══════ NOVA CONSULTA RÁPIDA ═══════ -->
                <div class="border-top pt-3">
                    <div class="d-flex align-items-center justify-content-between mb-3 goclinic-section-toggle"
                        data-bs-toggle="collapse" data-bs-target="#collapseNovaConsulta" style="cursor: pointer;"
                        role="button">
                        <h6 class="fw-bold mb-0" style="color: #4f4f4f;">
                            <i class="bi bi-mic-fill me-2 text-danger"></i>Nova Consulta Rápida
                        </h6>
                        <i class="bi bi-chevron-down text-muted" id="collapseChevron"></i>
                    </div>

                    <div class="collapse" id="collapseNovaConsulta">
                        <form id="formNovaConsulta">
                            <div class="mb-3 position-relative">
                                <label class="form-label fw-semibold">Nome do Paciente</label>
                                <input type="text" class="form-control form-control-lg" name="patient_name"
                                    id="patient_search_input" placeholder="Ex: João da Silva" autocomplete="off"
                                    required style="border-radius: 12px;">
                                <input type="hidden" name="patient_id" id="patient_id_hidden">
                                <div id="patient_search_results"
                                    class="list-group shadow-sm position-absolute w-100 mt-1 d-none"
                                    style="z-index: 1050; border-radius: 12px; max-height: 200px; overflow-y: auto;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Identificador (Telefone / Prontuário)</label>
                                <input type="text" class="form-control" name="patient_identifier"
                                    id="patient_identifier_input" placeholder="Ex: (44) 99999-9999"
                                    style="border-radius: 10px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tipo de Consulta</label>
                                <select class="form-select" name="consultation_type" style="border-radius: 10px;">
                                    <option value="Avaliação">Avaliação</option>
                                    <option value="Retorno">Retorno</option>
                                    <option value="Cirurgia">Cirurgia</option>
                                    <option value="Manutenção">Manutenção</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Observações Rápidas</label>
                                <textarea class="form-control" name="observations" rows="2"
                                    placeholder="Notas curtas..." style="border-radius: 10px;"></textarea>
                            </div>
                        </form>
                        <div class="d-flex justify-content-end gap-2 mt-3 mb-2">
                            <button type="button" class="btn btn-light px-4 fw-semibold" data-bs-dismiss="modal"
                                style="border-radius: 10px;">Cancelar</button>
                            <button type="button" class="btn text-white px-4 fw-semibold" id="btnIniciarEscuta"
                                style="background-color: #CA1D53; border-radius: 10px;">
                                <i class="bi bi-mic-fill me-1"></i> Iniciar Escuta (GoTalks)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .goclinic-hub-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 14px 8px;
        border-radius: 16px;
        transition: all 0.2s ease;
        text-align: center;
    }

    .goclinic-hub-card:hover {
        background-color: #f8f9fa;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .goclinic-hub-card .hub-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        transition: transform 0.2s ease;
    }

    .goclinic-hub-card:hover .hub-icon {
        transform: scale(1.1);
    }

    .goclinic-hub-card span {
        font-size: 0.78rem;
        font-weight: 600;
        color: #4f4f4f;
    }

    .goclinic-section-toggle:hover {
        opacity: 0.8;
    }

    #collapseNovaConsulta.show~.goclinic-section-toggle #collapseChevron,
    .goclinic-section-toggle[aria-expanded="true"] #collapseChevron {
        transform: rotate(180deg);
    }

    #collapseChevron {
        transition: transform 0.3s ease;
    }

    /* Styles specific to Hub Modal */
    #modalGoIntelligence .modal-content {
        background-color: #ffffff !important;
        color: #333333 !important;
        box-shadow: 0 0 80px rgba(0, 0, 0, 0.9) !important;
        border: 2px solid #CA1D53 !important;
        position: relative;
    }
</style>

@include('facelift2.partials.goclinic_core')