<div class="card admin-card mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-currency-dollar me-2"></i>Preços de Serviços</h5>
            <button class="btn btn-admin-sm" onclick="openPriceModal()">
                <i class="bi bi-plus-lg me-1"></i> Novo Serviço
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="pricesTable">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço Padrão</th>
                        <th>Ativo</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicePrices as $sp)
                        <tr id="price-row-{{ $sp->id }}">
                            <td class="fw-semibold">{{ $sp->name }}</td>
                            <td><span class="badge bg-info text-dark">{{ $sp->category }}</span></td>
                            <td>R$ {{ number_format($sp->default_price, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $sp->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $sp->is_active ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary" onclick='editPrice(@json($sp))'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deletePrice({{ $sp->id }})">
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

<!-- Modal Price (Needed if not global, but currently global in index.blade.php so this might be redundant if modal is outside partial. 
     The modal is in admin/index.blade.php bottom area. This partial only contains the TAB content.) 
-->