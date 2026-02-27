@extends('facelift2.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1" style="color: #4f4f4f; font-size: 1.6rem;">
                    <i class="bi bi-calendar3 text-danger me-2"></i>Agenda
                </h1>
                <p class="text-muted mb-0 small">Gerencie seus agendamentos clínicos</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <!-- Filtros -->
                <input type="text" id="filtroDentista" class="form-control form-control-sm"
                    placeholder="Filtrar dentista..." style="width: 160px; border-radius: 10px;">
                <select id="filtroTipo" class="form-select form-select-sm" style="width: 160px; border-radius: 10px;">
                    <option value="">Todos os tipos</option>
                    <option value="Avaliação">Avaliação</option>
                    <option value="Retorno">Retorno</option>
                    <option value="Procedimento">Procedimento</option>
                    <option value="Urgência">Urgência</option>
                    <option value="Documentação">Documentação</option>
                </select>
                <select id="filtroStatus" class="form-select form-select-sm" style="width: 160px; border-radius: 10px;">
                    <option value="">Todos os status</option>
                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                </a>
            </div>
        </div>

        <!-- Métricas rápidas -->
        <div class="row g-2 mb-4" id="metricsRow">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block">Comparecimento</small>
                        <h4 class="fw-bold mb-0" style="color: #5a9e7c;" id="metricComparecimento">—</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block">Faltas</small>
                        <h4 class="fw-bold mb-0" style="color: #c45c6a;" id="metricFaltas">—</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block">Ocupação</small>
                        <h4 class="fw-bold mb-0" style="color: #7c8db5;" id="metricOcupacao">—</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body p-3 text-center">
                        <small class="text-muted d-block">Intervalo Médio</small>
                        <h4 class="fw-bold mb-0" style="color: #c9864e;" id="metricIntervalo">—</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendário -->
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-3 p-md-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL: Criar / Editar Agendamento -->
    <!-- ============================================================ -->
    <div class="modal fade" id="modalAgendamento" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 20px; border: 2px solid #CA1D53; box-shadow: 0 12px 40px rgba(202, 29, 83, 0.25);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalAgendamentoTitle">Novo Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgendamento">
                        <input type="hidden" id="agendamentoId">

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Paciente *</label>

                            <!-- Mode Toggle -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="patientMode" id="modeSearch"
                                        value="search" checked>
                                    <label class="form-check-label small" for="modeSearch">Buscar Paciente</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="patientMode" id="modeNew"
                                        value="new">
                                    <label class="form-check-label small" for="modeNew">Novo Paciente (Rápido)</label>
                                </div>
                            </div>

                            <!-- Search Mode -->
                            <div id="sectionSearch">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                    <input type="text" id="agSearchPatient" class="form-control border-start-0"
                                        placeholder="Digite nome, telefone ou email..." autocomplete="off"
                                        style="border-radius: 0 10px 10px 0;">
                                    <input type="hidden" id="agPaciente"> <!-- Stores selected ID -->
                                </div>
                                <div id="searchResults" class="list-group position-absolute shadow-sm"
                                    style="z-index: 1050; width: 92%; max-height: 200px; overflow-y: auto; display: none;">
                                </div>
                                <div id="selectedPatientDisplay" class="mt-2 p-2 bg-light rounded d-none border">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-person-check text-success me-2"></i>
                                            <strong id="selectedPatientName"></strong>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none"
                                            id="btnClearSelection">Alterar</button>
                                    </div>
                                </div>
                            </div>

                            <!-- New Patient Mode -->
                            <div id="sectionNew" class="d-none p-3 border rounded bg-light">
                                <div class="mb-3">
                                    <label for="agNewName" class="form-label small text-muted">Nome Completo *</label>
                                    <input type="text" class="form-control" id="agNewName" placeholder="Ex: Maria Silva">
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="agNewPhone" class="form-label small text-muted">Telefone/WhatsApp
                                                *</label>
                                            <input type="text" class="form-control" id="agNewPhone"
                                                placeholder="(11) 99999-9999">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="agNewEmail" class="form-label small text-muted">Email
                                                (Opcional)</label>
                                            <input type="email" class="form-control" id="agNewEmail"
                                                placeholder="email@exemplo.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Tipo de Consulta</label>
                                <select id="agTipo" class="form-select" style="border-radius: 10px;">
                                    <option value="Avaliação">Avaliação</option>
                                    <option value="Retorno">Retorno</option>
                                    <option value="Procedimento">Procedimento</option>
                                    <option value="Urgência">Urgência</option>
                                    <option value="Documentação">Documentação</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Dentista</label>
                                <select id="agDoctorId" class="form-select" style="border-radius: 10px;">
                                    <option value="">— Selecionar —</option>
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Início *</label>
                                <input type="datetime-local" id="agInicio" class="form-control" required
                                    style="border-radius: 10px;">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Fim *</label>
                                <input type="datetime-local" id="agFim" class="form-control" required
                                    style="border-radius: 10px;">
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Serviço (preço pré-cadastrado)</label>
                                <select id="agServicePriceId" class="form-select" style="border-radius: 10px;">
                                    <option value="" data-price="">— Valor personalizado —</option>
                                    @foreach($servicePrices as $sp)
                                        <option value="{{ $sp->id }}" data-price="{{ $sp->default_price }}">
                                            {{ $sp->name }} — R$ {{ number_format($sp->default_price, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Valor (R$) *</label>
                                <input type="number" id="agValor" class="form-control" min="0" step="0.01" value="0.00"
                                    required style="border-radius: 10px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Observações</label>
                            <textarea id="agNotas" class="form-control" rows="2" style="border-radius: 10px;"
                                placeholder="Anotações sobre o agendamento..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn text-white rounded-pill px-4" id="btnSalvarAgendamento"
                        style="background-color: #CA1D53;">
                        <i class="bi bi-check2 me-1"></i>Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL: Detalhes do Agendamento -->
    <!-- ============================================================ -->
    <div class="modal fade" id="modalDetalhes" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 20px; border: 2px solid #CA1D53; box-shadow: 0 12px 40px rgba(202, 29, 83, 0.25);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Detalhes do Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; background-color: #fce4ec; flex-shrink: 0;">
                                <i class="bi bi-person-fill" style="color: #CA1D53;"></i>
                            </div>
                            <div>
                                <div class="fw-bold" id="detPaciente">—</div>
                                <small class="text-muted" id="detTipo">—</small>
                            </div>
                            <span class="badge rounded-pill ms-auto" id="detStatusBadge">—</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Início</small>
                            <span class="fw-bold small" id="detInicio">—</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Fim</small>
                            <span class="fw-bold small" id="detFim">—</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Dentista</small>
                            <span class="fw-bold small" id="detDentista">—</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Valor</small>
                            <span class="fw-bold small" id="detValor">—</span>
                        </div>
                    </div>

                    <div class="mb-3" id="detNotasRow">
                        <small class="text-muted d-block">Observações</small>
                        <span class="small" id="detNotas">—</span>
                    </div>

                    <!-- Status Actions -->
                    <div class="border-top pt-3">
                        <small class="text-muted d-block mb-2 fw-bold">Alterar Status:</small>
                        <div class="d-flex flex-wrap gap-1" id="detStatusActions"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3"
                        id="btnExcluirAgendamento">
                        <i class="bi bi-trash me-1"></i>Excluir
                    </button>
                    <button type="button" class="btn btn-light btn-sm rounded-pill px-3"
                        data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL: Agendar Retorno -->
    <!-- ============================================================ -->
    <div class="modal fade" id="modalRetorno" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content"
                style="border-radius: 20px; border: 2px solid #CA1D53; box-shadow: 0 12px 40px rgba(202, 29, 83, 0.25);">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold">
                        <i class="bi bi-arrow-repeat text-success me-1"></i>Agendar Retorno
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted">Deseja agendar um retorno para este paciente?</p>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Data sugerida</label>
                        <input type="datetime-local" id="retornoData" class="form-control" style="border-radius: 10px;">
                    </div>
                    <input type="hidden" id="retornoPatientId">
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light btn-sm rounded-pill" data-bs-dismiss="modal">Não
                        agora</button>
                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" id="btnConfirmarRetorno">
                        <i class="bi bi-check2 me-1"></i>Agendar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* FullCalendar customization */
        .fc {
            font-family: 'Inter', 'Poppins', sans-serif;
        }

        .fc .fc-toolbar-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #4f4f4f;
        }

        .fc .fc-button {
            background-color: #CA1D53;
            border-color: #CA1D53;
            border-radius: 8px;
            font-size: 0.8rem;
            text-transform: capitalize;
        }

        .fc .fc-button:hover {
            background-color: #a31645;
            border-color: #a31645;
        }

        .fc .fc-button-active {
            background-color: #8a1239 !important;
            border-color: #8a1239 !important;
        }

        .fc .fc-today-button {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .fc .fc-event {
            border-radius: 6px;
            border: none;
            padding: 2px 6px;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: #fdf6f8;
        }

        .fc .fc-timegrid-col.fc-day-today {
            background-color: #fdf6f8;
        }

        .fc .fc-timegrid-now-indicator-line {
            border-color: #CA1D53;
        }

        .fc .fc-timegrid-now-indicator-arrow {
            border-color: #CA1D53;
            color: #CA1D53;
        }

        .fc .fc-col-header-cell {
            background-color: #f8f9fa;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .fc .fc-timegrid-slot {
            height: 40px;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: #f0f0f0;
        }
    </style>
@endsection

@section('api')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
            var calendarEl = document.getElementById('calendar');
            var currentEventId = null;

            var statusColors = @json($statusColors);
            var statusLabels = @json($statusLabels);

            // FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'pt-br',
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia'
                },
                slotMinTime: '05:00:00',
                slotMaxTime: '23:00:00',
                allDaySlot: false,
                nowIndicator: true,
                editable: true,
                selectable: true,
                selectMirror: true,
                slotDuration: '00:30:00',
                height: 700,
                selectConstraint: {
                    start: '00:00',
                    end: '24:00',
                },
                selectAllow: function (selectInfo) {
                    return moment().diff(selectInfo.start) <= 0;
                },
                eventConstraint: {
                    start: moment().format('YYYY-MM-DD'), // Prevent dragging to past
                },
                navLinks: true,

                events: function (fetchInfo, successCallback, failureCallback) {
                    var params = new URLSearchParams({
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr
                    });

                    var dentista = document.getElementById('filtroDentista').value;
                    var tipo = document.getElementById('filtroTipo').value;
                    var status = document.getElementById('filtroStatus').value;

                    if (dentista) params.append('dentista', dentista);
                    if (tipo) params.append('tipo', tipo);
                    if (status) params.append('status', status);

                    fetch('/api/agenda/events?' + params.toString())
                        .then(function (r) { return r.json(); })
                        .then(function (data) { successCallback(data); })
                        .catch(function (err) { failureCallback(err); });
                },

                // Custom Event Content (Icon for delinquency)
                eventContent: function (arg) {
                    let title = arg.event.title;
                    let isDelinquent = arg.event.extendedProps.is_delinquent;

                    let content = document.createElement('div');
                    content.className = 'fc-event-main-frame d-flex align-items-center';

                    if (isDelinquent) {
                        let icon = document.createElement('i');
                        icon.className = 'bi bi-exclamation-triangle-fill text-warning me-1';
                        icon.title = 'Pendências Financeiras';
                        content.appendChild(icon);
                    }

                    let titleEl = document.createElement('div');
                    titleEl.className = 'fc-event-title fc-sticky';
                    titleEl.innerText = title;
                    content.appendChild(titleEl);

                    return { domNodes: [content] };
                },

                // Clicar em horário vazio (Ponto único)
                dateClick: function (info) {
                    if (moment().diff(info.date) > 0) {
                        showToast('Não é possível agendar no passado.', 'danger');
                        return;
                    }
                    openCreateModal(info.date);
                },

                // Clicar e arrastar (Seleção de range)
                select: function (info) {
                    if (moment().diff(info.start) > 0) {
                        calendar.unselect();
                        return;
                    }
                    openCreateModal(info.start, info.end);
                    calendar.unselect();
                },

                // Clicar em evento → mostrar detalhes
                eventClick: function (info) {
                    openDetailsModal(info.event);
                },

                // Drag-and-drop → reagendar
                eventDrop: function (info) {
                    if (moment().diff(info.event.start) > 0) {
                        info.revert();
                        showToast('Não é possível mover para o passado.', 'danger');
                        return;
                    }
                    updateEventTimes(info.event);
                },

                // Resize → mudar duração
                eventResize: function (info) {
                    updateEventTimes(info.event);
                },
            });

            calendar.render();

            // Carregar métricas
            loadMetrics();

            // Filtros: re-fetch ao mudar
            document.getElementById('filtroDentista').addEventListener('change', function () { calendar.refetchEvents(); });
            document.getElementById('filtroTipo').addEventListener('change', function () { calendar.refetchEvents(); });
            document.getElementById('filtroStatus').addEventListener('change', function () { calendar.refetchEvents(); });

            // Também aplicar no input text com debounce
            var dentistaTimeout;
            document.getElementById('filtroDentista').addEventListener('input', function () {
                clearTimeout(dentistaTimeout);
                dentistaTimeout = setTimeout(function () { calendar.refetchEvents(); }, 400);
            });

            // ===================== Modal Criar: Configuração Inicial =====================
            var searchInput = document.getElementById('agSearchPatient');
            var resultsList = document.getElementById('searchResults');
            var searchTimeout;

            // Toggle Modes
            document.querySelectorAll('input[name="patientMode"]').forEach(r => {
                r.addEventListener('change', function () {
                    if (this.value === 'search') {
                        document.getElementById('sectionSearch').classList.remove('d-none');
                        document.getElementById('sectionNew').classList.add('d-none');
                    } else {
                        document.getElementById('sectionSearch').classList.add('d-none');
                        document.getElementById('sectionNew').classList.remove('d-none');
                    }
                });
            });

            // Autocomplete Search
            searchInput.addEventListener('input', function () {
                var term = this.value.trim();
                clearTimeout(searchTimeout);

                if (term.length < 2) {
                    resultsList.innerHTML = '';
                    resultsList.style.display = 'none';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch('/api/patients-search?q=' + encodeURIComponent(term))
                        .then(r => r.json())
                        .then(data => {
                            resultsList.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(p => {
                                    var item = document.createElement('a');
                                    item.className = 'list-group-item list-group-item-action small';
                                    item.href = '#';
                                    item.innerHTML = `
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <div>
                                                    <strong>${p.full_name}</strong> 
                                                    <span class="text-muted ms-2">${p.phone || ''}</span>
                                                </div>
                                                ${p.is_delinquent ? '<i class="bi bi-exclamation-triangle-fill text-warning" title="Pendência Financeira"></i>' : ''}
                                            </div>
                                        `;
                                    item.onclick = (e) => {
                                        e.preventDefault();
                                        selectPatient(p.id, p.full_name, p.is_delinquent);
                                    };
                                    resultsList.appendChild(item);
                                });
                                resultsList.style.display = 'block';
                            } else {
                                resultsList.innerHTML = '<div class="list-group-item small text-muted">Nenhum paciente encontrado</div>';
                                resultsList.style.display = 'block';
                            }
                        })
                        .catch(err => console.error('Busca falhou', err));
                }, 300);
            });

            // Close results when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
                    resultsList.style.display = 'none';
                }
            });

            function selectPatient(id, name, isDelinquent = false) {
                document.getElementById('agPaciente').value = id;
                document.getElementById('selectedPatientName').innerHTML = name + (isDelinquent ? ' <i class="bi bi-exclamation-triangle-fill text-warning ms-1" title="Pendência Financeira"></i>' : '');
                document.getElementById('selectedPatientDisplay').classList.remove('d-none');
                searchInput.value = '';
                searchInput.classList.add('d-none');
                resultsList.style.display = 'none';
            }

            document.getElementById('btnClearSelection').addEventListener('click', function () {
                document.getElementById('agPaciente').value = '';
                document.getElementById('selectedPatientDisplay').classList.add('d-none');
                searchInput.classList.remove('d-none');
                searchInput.focus();
            });

            function clearPatientSelection() {
                document.getElementById('agPaciente').value = '';
                document.getElementById('selectedPatientDisplay').classList.add('d-none');
                searchInput.classList.remove('d-none');
                searchInput.value = '';
                document.getElementById('agNewName').value = '';
                document.getElementById('agNewPhone').value = '';
                document.getElementById('agNewEmail').value = '';

                // Reset to search mode
                document.getElementById('modeSearch').checked = true;
                document.getElementById('sectionSearch').classList.remove('d-none');
                document.getElementById('sectionNew').classList.add('d-none');
            }

            // ===================== Modal Criar =====================
            function openCreateModal(start, end, eventToEdit = null) {
                document.getElementById('modalAgendamentoTitle').textContent = eventToEdit ? 'Editar Agendamento' : 'Novo Agendamento';
                document.getElementById('agendamentoId').value = eventToEdit ? eventToEdit.id : '';
                document.getElementById('agTipo').value = eventToEdit ? eventToEdit.extendedProps.consultation_type : 'Avaliação';
                document.getElementById('agDoctorId').value = eventToEdit ? eventToEdit.extendedProps.doctor_id : '';
                document.getElementById('agServicePriceId').value = ''; // Reset, or logic to find
                document.getElementById('agValor').value = eventToEdit ? eventToEdit.extendedProps.valor : '0.00';
                document.getElementById('agNotas').value = eventToEdit ? eventToEdit.extendedProps.notes : '';

                // Patient logic
                clearPatientSelection();
                if (eventToEdit && eventToEdit.extendedProps.patient_id) {
                    selectPatient(eventToEdit.extendedProps.patient_id, eventToEdit.extendedProps.patient_name, eventToEdit.extendedProps.is_delinquent);
                }

                // Dates: Priority to arguments (from drag/select), then event props, then Now
                var finalStart = start;
                var finalEnd = end;

                // If eventToEdit exists but NO start/end passed (e.g. from "Edit button" in details), use event's times
                if (eventToEdit && !start) {
                    finalStart = eventToEdit.start;
                    finalEnd = eventToEdit.end;
                }

                if (!finalStart) finalStart = new Date();

                // Validation: If dragging to 00:00 (Month View click), set to 08:00 default if New
                if (!eventToEdit && finalStart.getHours() === 0 && finalStart.getMinutes() === 0 && !finalEnd) {
                    finalStart.setHours(8);
                }

                document.getElementById('agInicio').value = formatDateTimeLocal(finalStart);
                if (finalEnd) {
                    document.getElementById('agFim').value = formatDateTimeLocal(finalEnd);
                } else {
                    var endDate = new Date(finalStart.getTime() + 30 * 60000); // 30 min default
                    document.getElementById('agFim').value = formatDateTimeLocal(endDate);
                }

                new bootstrap.Modal(document.getElementById('modalAgendamento')).show();
            }

            // ===================== Salvar Agendamento =====================
            document.getElementById('btnSalvarAgendamento').addEventListener('click', async function () {
                var patientId = document.getElementById('agPaciente').value;
                var modeNew = document.getElementById('modeNew').checked;
                var inicio = document.getElementById('agInicio').value;
                var fim = document.getElementById('agFim').value;
                var agId = document.getElementById('agendamentoId').value; // Edit ID

                if (!inicio || !fim) {
                    alert('Defina o horário de início e fim.');
                    return;
                }

                if (modeNew) {
                    var newName = document.getElementById('agNewName').value.trim();
                    var newPhone = document.getElementById('agNewPhone').value.trim();
                    var newEmail = document.getElementById('agNewEmail').value.trim();

                    if (!newName) {
                        alert('Digite o nome do paciente.');
                        return;
                    }

                    try {
                        const respApp = await fetch('/patients', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                full_name: newName,
                                phone: newPhone,
                                email: newEmail,
                                registration_date: new Date().toISOString().split('T')[0]
                            })
                        });

                        if (!respApp.ok) {
                            const errData = await respApp.json().catch(() => ({}));
                            console.error('Erro criar paciente:', errData);
                            throw new Error(errData.message || 'Erro ao criar paciente.');
                        }

                        // Controller returns JSON due to wantsJson() check
                        const pData = await respApp.json();
                        patientId = pData.id; // Get the new ID

                    } catch (e) {
                        alert('Erro ao cadastrar paciente: ' + e.message);
                        return;
                    }
                }

                if (!patientId) {
                    alert('Selecione ou cadastre um paciente.');
                    return;
                }

                // 2. Save Appointment
                var body = {
                    patient_id: patientId,
                    consultation_type: document.getElementById('agTipo').value,
                    doctor_id: document.getElementById('agDoctorId').value || null,
                    service_price_id: document.getElementById('agServicePriceId').value || null,
                    valor: document.getElementById('agValor').value || 0,
                    start_time: new Date(inicio).toISOString(),
                    end_time: new Date(fim).toISOString(),
                    notes: document.getElementById('agNotas').value
                };

                var url = agId ? '/api/agenda/' + agId : '/api/agenda';
                var method = agId ? 'PUT' : 'POST';

                fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(body)
                })
                    .then(async function (r) {
                        if (!r.ok) {
                            const err = await r.json().catch(() => ({}));
                            throw new Error(err.message || JSON.stringify(err.errors) || 'Erro ' + r.status);
                        }
                        return r.json();
                    })
                    .then(function (data) {
                        if (data.success) {
                            calendar.refetchEvents();
                            bootstrap.Modal.getInstance(document.getElementById('modalAgendamento')).hide();
                            showToast('Agendamento salvo!');
                        } else {
                            alert('Erro: ' + (data.message || 'Desconhecido'));
                        }
                    })
                    .catch(function (err) {
                        alert('Erro ao salvar: ' + err.message);
                    });
            });

            // ===================== Detalhes do Evento =====================
            function openDetailsModal(event) {
                var props = event.extendedProps;

                document.getElementById('detPaciente').textContent = props.patient_name || '—';
                document.getElementById('detTipo').textContent = props.consultation_type || '—';
                document.getElementById('detInicio').textContent = formatBR(event.start);
                document.getElementById('detFim').textContent = formatBR(event.end);
                document.getElementById('detDentista').textContent = props.doctor_name || props.dentista || '—';
                document.getElementById('detValor').textContent = 'R$ ' + parseFloat(props.valor || 0).toFixed(2);
                document.getElementById('detNotas').textContent = props.notes || '—';

                // Status Badge
                var status = props.status;
                var badge = document.getElementById('detStatusBadge');
                badge.textContent = statusLabels[status] || status;
                badge.style.backgroundColor = statusColors[status] || '#6c757d';
                badge.className = 'badge rounded-pill ms-auto text-white';

                // Status Actions
                var actionsDiv = document.getElementById('detStatusActions');
                actionsDiv.innerHTML = '';

                // Generate buttons based on current status
                // Simplified logic: Allow changing to any status except current
                Object.keys(statusLabels).forEach(key => {
                    if (key !== status) {
                        var btn = document.createElement('button');
                        btn.className = 'btn btn-sm btn-outline-secondary';
                        btn.textContent = statusLabels[key];
                        btn.onclick = function () { changeStatus(event.id, key); };
                        actionsDiv.appendChild(btn);
                    }
                });

                // Edit Button -> Open CreateModal with event data
                // IMPORTANT: Pass null for start/end so it uses event's existing times
                var btnEdit = document.createElement('button');
                btnEdit.className = 'btn btn-sm btn-outline-primary ms-2';
                btnEdit.innerHTML = '<i class="bi bi-pencil"></i> Editar';
                btnEdit.onclick = function () {
                    bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
                    openCreateModal(null, null, event);
                };
                document.querySelector('#modalDetalhes .modal-footer').prepend(btnEdit); // Add temporarily or manage better

                // Delete Button
                document.getElementById('btnExcluirAgendamento').onclick = function () {
                    if (confirm('Tem certeza que deseja excluir?')) {
                        deleteEvent(event.id);
                    }
                };

                new bootstrap.Modal(document.getElementById('modalDetalhes')).show();
            }

            function changeStatus(id, newStatus) {
                fetch('/api/agenda/' + id + '/status', {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ status: newStatus })
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            calendar.refetchEvents();
                            bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
                            showToast('Status atualizado!');
                        }
                    });
            }

            function deleteEvent(id) {
                fetch('/api/agenda/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                })
                    .then(r => r.json())
                    .then(data => {
                        calendar.refetchEvents();
                        bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
                        showToast('Agendamento excluído.');
                    });
            }

            function updateEventTimes(event) {
                // Open modal with new dates (dragged times)
                // Pass event.start and event.end explicitly so openCreateModal uses them!
                openCreateModal(event.start, event.end, event);

                // If user cancels, we must revert. 
                // FullCalendar keeps the drop unless we revert it. 
                // But since we are waiting for User Save in Modal, the event "looks" moved.
                // If they close modal, we should refetch to reset it.
                var modalEl = document.getElementById('modalAgendamento');
                var hiddenHandler = function () {
                    // Check if it was saved? 
                    // Actually, always refetch is safer to ensure sync.
                    calendar.refetchEvents();
                    modalEl.removeEventListener('hidden.bs.modal', hiddenHandler);
                    // Clear button prepends to avoid duplicates in Details modal if we reused code there
                    // (Cleanup for details modal if needed, but here it is CreateModal)
                };
                modalEl.addEventListener('hidden.bs.modal', hiddenHandler);
            }

            // ===================== Modal Retorno =====================
            function openRetornoModal(patientId) {
                var suggestedDate = new Date();
                suggestedDate.setDate(suggestedDate.getDate() + 15);
                suggestedDate.setHours(9, 0, 0, 0);

                document.getElementById('retornoData').value = formatDateTimeLocal(suggestedDate);
                document.getElementById('retornoPatientId').value = patientId;

                new bootstrap.Modal(document.getElementById('modalRetorno')).show();
            }

            document.getElementById('btnConfirmarRetorno').addEventListener('click', function () {
                var patientId = document.getElementById('retornoPatientId').value;
                var retornoDate = document.getElementById('retornoData').value;

                if (!retornoDate) return;

                var endDate = new Date(retornoDate);
                endDate.setMinutes(endDate.getMinutes() + 30);

                fetch('/api/agenda', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({
                        patient_id: patientId,
                        consultation_type: 'Retorno',
                        start_time: retornoDate,
                        end_time: formatDateTimeLocal(endDate),
                    })
                })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data.success) {
                            calendar.refetchEvents();
                            bootstrap.Modal.getInstance(document.getElementById('modalRetorno')).hide();
                            showToast('Retorno agendado!');
                        }
                    });
            });

            // ===================== Métricas =====================
            function loadMetrics() {
                fetch('/api/agenda/metrics')
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        document.getElementById('metricComparecimento').textContent = data.taxaComparecimento + '%';
                        document.getElementById('metricFaltas').textContent = data.taxaFalta + '%';
                        document.getElementById('metricOcupacao').textContent = data.ocupacaoAgenda + '%';
                        document.getElementById('metricIntervalo').textContent = data.tempoMedioEntreConsultas + ' dias';
                    })
                    .catch(function () { });
            }

            // ===================== Helpers =====================
            function formatDateTimeLocal(date) {
                if (typeof date === 'string') date = new Date(date);
                var y = date.getFullYear();
                var m = String(date.getMonth() + 1).padStart(2, '0');
                var d = String(date.getDate()).padStart(2, '0');
                var h = String(date.getHours()).padStart(2, '0');
                var min = String(date.getMinutes()).padStart(2, '0');
                return y + '-' + m + '-' + d + 'T' + h + ':' + min;
            }

            function formatBR(date) {
                if (!date) return '—';
                var d = new Date(date);
                return String(d.getDate()).padStart(2, '0') + '/' +
                    String(d.getMonth() + 1).padStart(2, '0') + '/' +
                    d.getFullYear() + ' ' +
                    String(d.getHours()).padStart(2, '0') + ':' +
                    String(d.getMinutes()).padStart(2, '0');
            }

            function showToast(msg) {
                var toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 p-3';
                toast.style.zIndex = 9999;
                toast.innerHTML = '<div class="toast show align-items-center text-white border-0" style="background-color: #198754; border-radius: 12px;">' +
                    '<div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i>' + msg + '</div>' +
                    '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>';
                document.body.appendChild(toast);
                setTimeout(function () { toast.remove(); }, 3000);
            }

            // Auto-fill valor from service price
            var spSelect = document.getElementById('agServicePriceId');
            if (spSelect) {
                spSelect.addEventListener('change', function () {
                    var price = this.options[this.selectedIndex].dataset.price;
                    if (price) {
                        document.getElementById('agValor').value = parseFloat(price).toFixed(2);
                    }
                });
            }
        });
    </script>
@endsection