<!-- MODAL NOVA CONSULTA SIMPLES -->
<div class="modal fade" id="modalNovaConsulta" tabindex="-1" aria-hidden="true" data-bs-backdrop="false"
    style="z-index: 100001;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <div>
                    <h4 class="modal-title fw-bold mb-0" style="color: #CA1D53;">Nova Consulta</h4>
                    <small class="text-muted">Inicie uma nova consulta ou gravação</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <form id="formNovaConsulta">
                    <div class="mb-3 position-relative">
                        <label class="form-label fw-semibold">Nome do Paciente</label>
                        <input type="text" class="form-control form-control-lg" name="patient_name"
                            id="patient_search_input" placeholder="Ex: João da Silva" autocomplete="off" required
                            style="border-radius: 12px;">
                        <input type="hidden" name="patient_id" id="patient_id_hidden">
                        <div id="patient_search_results"
                            class="list-group shadow-sm position-absolute w-100 mt-1 d-none"
                            style="z-index: 1050; border-radius: 12px; max-height: 200px; overflow-y: auto;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Identificador (Telefone / Prontuário)</label>
                        <input type="text" class="form-control" name="patient_identifier" id="patient_identifier_input"
                            placeholder="Ex: (44) 99999-9999" style="border-radius: 10px;">
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
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold">Procedimento (Opcional)</label>
                            <select class="form-select" name="service_price_id" id="quickServiceSelect"
                                style="border-radius: 10px;" onchange="updateQuickValue(this)">
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
                            <input type="number" class="form-control" name="valor" id="quickValorInput" value="0.00"
                                step="0.01" min="0" style="border-radius: 10px;">
                        </div>
                    </div>
                    <script>
                        function updateQuickValue(select) {
                            const price = select.options[select.selectedIndex].dataset.price;
                            document.getElementById('quickValorInput').value = parseFloat(price || 0).toFixed(2);
                        }
                    </script>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Observações Rápidas</label>
                        <textarea class="form-control" name="observations" rows="2" placeholder="Notas curtas..."
                            style="border-radius: 10px;"></textarea>
                    </div>
                </form>
                <div class="d-flex justify-content-end gap-2 mt-4">
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

@include('facelift2.partials.goclinic_core')