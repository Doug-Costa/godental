<div class="card admin-card mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-journal-check me-2"></i>Modelos de Anamnese</h5>
            <button class="btn btn-admin-sm px-3" onclick="openAnamnesisModal()">
                <i class="bi bi-plus-lg me-1"></i> Novo Modelo
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="anamnesisTable">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Questões</th>
                        <th>Padrão</th>
                        <th>Ativo</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anamnesisTemplates as $template)
                        <tr id="template-row-{{ $template->id }}">
                            <td class="fw-bold">{{ $template->name }}</td>
                            <td class="small text-muted">{{ Str::limit($template->description, 50) }}</td>
                            <td><span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ is_array($template->questions) ? count($template->questions) : 0 }} perguntas</span></td>
                            <td>
                                @if($template->is_default)
                                    <span class="badge bg-primary">Padrão</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $template->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $template->is_active ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary" onclick='editAnamnesisTemplate(@json($template))'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAnamnesisTemplate({{ $template->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
