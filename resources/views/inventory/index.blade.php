@extends('facelift2.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1" style="color: #4f4f4f; font-size: 1.6rem;">
                    <i class="bi bi-box-seam text-primary me-2"></i>Estoque
                </h1>
                <p class="text-muted mb-0 small">Controle de materiais e insumos</p>
            </div>
            <div>
                <button class="btn btn-primary btn-sm rounded-pill px-3" onclick="openCreateModal()">
                    <i class="bi bi-plus-lg me-1"></i> Novo Item
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Item</th>
                                <th>Unidade</th>
                                <th>Custo Médio</th>
                                <th>Estoque</th>
                                <th>Fornecedor</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $item->name }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>R$ {{ number_format($item->cost_price, 2, ',', '.') }}</td>
                                    <td>
                                        @if($item->current_stock <= $item->min_stock)
                                            <span class="badge bg-danger">
                                                {{ $item->current_stock }} (Min: {{ $item->min_stock }})
                                            </span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                {{ $item->current_stock }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->supplier->name ?? '-' }}</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-success me-1"
                                            onclick="openStockEntry({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->cost_price }})"
                                            title="Entrada de Estoque">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link text-muted" onclick='openEditModal(@json($item))'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Excluir item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Nenhum item cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Item -->
    <div class="modal fade" id="modalCreateItem" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="modalCreateTitle">Novo Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCreateItem" action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div id="methodPut"></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="small text-muted">Nome do Item</label>
                            <input type="text" name="name" id="itemName" class="form-control" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="small text-muted">Unidade</label>
                                <input type="text" name="unit" id="itemUnit" class="form-control" placeholder="un, cx, ml"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Estoque Mínimo</label>
                                <input type="number" name="min_stock" id="itemMinStock" class="form-control" value="5"
                                    required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="small text-muted">Custo (R$)</label>
                                <input type="number" step="0.01" name="cost_price" id="itemCost" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Preço Venda (Opcional)</label>
                                <input type="number" step="0.01" name="selling_price" id="itemSelling" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Fornecedor Padrão</label>
                            <select name="supplier_id" id="itemSupplier" class="form-select">
                                <option value="">Selecione...</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary px-4">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Stock Entry -->
    <div class="modal fade" id="modalStockEntry" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px; border: 2px solid #28a745;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-success">Entrada de Estoque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formStockEntry" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="mb-3">Item: <strong id="stockEntryItemName"></strong></p>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="small text-muted">Quantidade (Adicionar)</label>
                                <input type="number" name="quantity" class="form-control" required min="1">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Novo Custo Unit. (Opcional)</label>
                                <input type="number" step="0.01" name="cost_price" id="stockEntryCost" class="form-control">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="create_expense" value="1"
                                id="checkCreateExpense" checked onchange="toggleExpenseFields()">
                            <label class="form-check-label small" for="checkCreateExpense">Gerar Despesa Financeira
                                Automaticamente</label>
                        </div>

                        <div id="expenseFields" class="p-3 bg-light rounded">
                            <div class="mb-2">
                                <label class="small text-muted">Descrição da Despesa</label>
                                <input type="text" name="expense_description" id="expenseDesc"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="mb-2">
                                <label class="small text-muted">Categoria Financeira</label>
                                <select name="expense_category_id" class="form-select form-select-sm">
                                    @foreach($financialCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-success px-4">Confirmar Entrada</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('formCreateItem').reset();
            document.getElementById('formCreateItem').action = "{{ route('inventory.store') }}";
            document.getElementById('methodPut').innerHTML = '';
            document.getElementById('modalCreateTitle').innerText = 'Novo Item';
            new bootstrap.Modal(document.getElementById('modalCreateItem')).show();
        }

        function openEditModal(item) {
            document.getElementById('formCreateItem').action = "{{ url('/inventory') }}/" + item.id;
            document.getElementById('methodPut').innerHTML = '@method("PUT")';
            document.getElementById('modalCreateTitle').innerText = 'Editar Item';

            document.getElementById('itemName').value = item.name;
            document.getElementById('itemUnit').value = item.unit;
            document.getElementById('itemMinStock').value = item.min_stock;
            document.getElementById('itemCost').value = item.cost_price;
            document.getElementById('itemSelling').value = item.selling_price;
            document.getElementById('itemSupplier').value = item.supplier_id;

            new bootstrap.Modal(document.getElementById('modalCreateItem')).show();
        }

        function openStockEntry(id, name, currentCost) {
            document.getElementById('formStockEntry').reset();
            document.getElementById('formStockEntry').action = "{{ url('/inventory') }}/" + id + "/stock";
            document.getElementById('stockEntryItemName').innerText = name;
            document.getElementById('stockEntryCost').value = currentCost;
            document.getElementById('expenseDesc').value = 'Compra de Estoque - ' + name;

            // Ensure expense toggle is checked by default
            document.getElementById('checkCreateExpense').checked = true;
            toggleExpenseFields();

            new bootstrap.Modal(document.getElementById('modalStockEntry')).show();
        }

        function toggleExpenseFields() {
            const isChecked = document.getElementById('checkCreateExpense').checked;
            const fields = document.getElementById('expenseFields');
            if (isChecked) {
                fields.classList.remove('d-none');
            } else {
                fields.classList.add('d-none');
            }
        }
    </script>
@endsection