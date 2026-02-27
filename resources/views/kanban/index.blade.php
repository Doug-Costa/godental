@extends('facelift2.master')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #4f4f4f; font-size: 1.6rem;">
                <i class="bi bi-kanban text-danger me-2"></i>Kanban de Atendimentos
            </h1>
            <p class="text-muted mb-0 small">Arraste os casos clínicos entre as etapas do fluxo</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-speedometer2 me-1"></i>Dashboard
            </a>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-board d-flex gap-3 pb-4" style="overflow-x: auto; min-height: 75vh;">
        @foreach($columns as $stageKey => $column)
            <div class="kanban-column flex-shrink-0" style="width: 280px; min-width: 280px;">
                <!-- Column Header -->
                <div class="d-flex align-items-center gap-2 mb-3 px-1">
                    <span class="rounded-circle" style="width: 12px; height: 12px; background-color: {{ $column['color'] }}; display: inline-block;"></span>
                    <h6 class="fw-bold mb-0 small text-uppercase" style="color: #4f4f4f; letter-spacing: 0.5px;">
                        {{ $column['label'] }}
                    </h6>
                    <span class="badge bg-light text-secondary border rounded-pill ms-auto" style="font-size: 0.7rem;">
                        {{ count($column['cases']) }}
                    </span>
                </div>

                <!-- Column Body (droppable) -->
                <div class="kanban-list rounded-4 p-2"
                     data-stage="{{ $stageKey }}"
                     style="background-color: #f8f9fa; min-height: 60vh; border: 2px dashed transparent; transition: border-color 0.2s;">

                    @foreach($column['cases'] as $card)
                        <div class="kanban-card card border-0 shadow-sm mb-2"
                             data-id="{{ $card['id'] }}"
                             style="border-radius: 14px; cursor: grab; transition: transform 0.15s, box-shadow 0.15s;">

                            <!-- Color stripe top -->
                            <div style="height: 4px; background-color: {{ $column['color'] }}; border-radius: 14px 14px 0 0;"></div>

                            <div class="card-body p-3">
                                <!-- Patient name + valor -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px; background-color: #fce4ec; flex-shrink: 0;">
                                            <i class="bi bi-person-fill" style="color: #CA1D53; font-size: 0.85rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold small" style="color: #4f4f4f; line-height: 1.2;">
                                                {{ Str::limit($card['patient_name'], 20) }}
                                            </div>
                                            @if($card['idade'])
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $card['idade'] }} anos</small>
                                            @endif
                                        </div>
                                    </div>
                                    @if($card['valor_estimado'])
                                        <span class="badge bg-light text-dark border" style="font-size: 0.65rem; border-radius: 6px;">
                                            R$ {{ number_format($card['valor_estimado'], 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Case title -->
                                <div class="small text-secondary mb-2" style="line-height: 1.3;">
                                    <i class="bi bi-folder2 me-1"></i>{{ Str::limit($card['title'], 30) }}
                                </div>

                                <!-- Meta row -->
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    @if($card['last_consulta'])
                                        <span class="badge bg-white text-muted border" style="font-size: 0.65rem; border-radius: 5px;">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $card['last_consulta'] }}
                                        </span>
                                    @endif
                                    @if($card['plano_status'])
                                        @php
                                            $planoColors = [
                                                'Proposto' => 'bg-info-subtle text-info',
                                                'Aprovado' => 'bg-primary-subtle text-primary',
                                                'EmExecucao' => 'bg-warning-subtle text-warning',
                                                'Finalizado' => 'bg-success-subtle text-success',
                                            ];
                                        @endphp
                                        <span class="badge {{ $planoColors[$card['plano_status']] ?? 'bg-secondary-subtle text-secondary' }}"
                                            style="font-size: 0.65rem; border-radius: 5px;">
                                            {{ $card['plano_status'] }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Alert badges -->
                                @foreach($card['alerts'] as $alert)
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <i class="bi bi-exclamation-triangle-fill text-{{ $alert['type'] }}" style="font-size: 0.7rem;"></i>
                                        <small class="text-{{ $alert['type'] }}" style="font-size: 0.65rem; line-height: 1.2;">
                                            {{ $alert['text'] }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .kanban-board::-webkit-scrollbar {
        height: 8px;
    }
    .kanban-board::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .kanban-board::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }
    .kanban-board::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }
    .kanban-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1) !important;
    }
    .kanban-card.sortable-ghost {
        opacity: 0.4;
        transform: rotate(2deg);
    }
    .kanban-card.sortable-chosen {
        box-shadow: 0 8px 25px rgba(202, 29, 83, 0.2) !important;
    }
    .kanban-list.drag-over {
        border-color: #CA1D53 !important;
        background-color: #fef2f5 !important;
    }
</style>
@endsection

@section('api')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lists = document.querySelectorAll('.kanban-list');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    lists.forEach(function(list) {
        new Sortable(list, {
            group: 'kanban',
            animation: 200,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            easing: 'cubic-bezier(0.25, 1, 0.5, 1)',

            onStart: function() {
                lists.forEach(function(l) { l.classList.add('drag-over'); });
            },
            onEnd: function(evt) {
                lists.forEach(function(l) { l.classList.remove('drag-over'); });

                var cardId = evt.item.dataset.id;
                var newStage = evt.to.dataset.stage;
                var oldStage = evt.from.dataset.stage;

                if (newStage === oldStage) return;

                // Update the color stripe
                var columnColors = {
                    'ENTRADA': '#6c757d', 'ANAMNESE': '#0d6efd', 'DIAGNOSTICO': '#ffc107',
                    'PROGNOSTICO': '#fd7e14', 'PLANO': '#198754', 'EM_TRATAMENTO': '#0dcaf0',
                    'FINALIZADO': '#adb5bd'
                };
                var stripe = evt.item.querySelector('div:first-child');
                if (stripe) stripe.style.backgroundColor = columnColors[newStage] || '#adb5bd';

                // Update column counts
                updateColumnCounts();

                // AJAX call
                fetch('/api/kanban/' + cardId + '/move', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ stage: newStage })
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (!data.success) {
                        evt.from.appendChild(evt.item);
                        updateColumnCounts();
                    }
                })
                .catch(function() {
                    evt.from.appendChild(evt.item);
                    updateColumnCounts();
                });
            }
        });
    });

    function updateColumnCounts() {
        document.querySelectorAll('.kanban-column').forEach(function(col) {
            var count = col.querySelector('.kanban-list').children.length;
            var badge = col.querySelector('.badge');
            if (badge) badge.textContent = count;
        });
    }
});
</script>
@endsection
