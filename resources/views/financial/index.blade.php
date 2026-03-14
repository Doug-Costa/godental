@extends('facelift2.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1" style="color: #4f4f4f; font-size: 1.6rem;">
                    <i class="bi bi-wallet2 text-success me-2"></i>Financeiro
                </h1>
                <p class="text-muted mb-0 small">Gestão de receitas e despesas</p>
            </div>
            <div>
                <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal"
                    data-bs-target="#modalTransaction">
                    <i class="bi bi-plus-lg me-1"></i> Nova Movimentação
                </button>
            </div>
        </div>

        <!-- Metrics -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-body">
                        <small class="text-success fw-bold">RECEITAS</small>
                        <h4 class="fw-bold mt-2 mb-0 text-success">R$ {{ number_format($totals['income'], 2, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-body">
                        <small class="text-danger fw-bold">DESPESAS</small>
                        <h4 class="fw-bold mt-2 mb-0 text-danger">R$ {{ number_format($totals['expense'], 2, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-body">
                        <small class="text-warning fw-bold">SALDO</small>
                        <h4 class="fw-bold mt-2 mb-0 {{ $totals['balance'] >= 0 ? 'text-success' : 'text-danger' }}">
                            R$ {{ number_format($totals['balance'], 2, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-body">
                        <small class="text-muted fw-bold">A RECEBER (PENDENTE)</small>
                        <h4 class="fw-bold mt-2 mb-0 text-muted">R$
                            {{ number_format($totals['pending_income'], 2, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-3">
                <form action="{{ route('financial.index') }}" method="GET" class="row g-2 align-items-end flex-wrap">
                    <div class="col-md-2">
                        <label class="small text-muted">Início</label>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted">Fim</label>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted">Tipo</label>
                        <select name="type" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Receita</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Despesa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pago</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Atrasado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-filter"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Data</th>
                                <th>Descrição/Detalhes</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Conta/Forma</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $t)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $t->type == 'income' ? 'Receita' : 'Despesa' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $t->description }}</div>
                                        @if($t->supplier) <small class="text-muted d-block"><i class="bi bi-truck"></i>
                                        {{ $t->supplier->name }}</small> @endif
                                        @if($t->patient) <small class="text-muted d-block"><i class="bi bi-person"></i>
                                        {{ $t->patient->full_name }}</small> @endif
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $t->category->color ?? '#6c757d' }}">
                                            {{ $t->category->name }}
                                        </span>
                                    </td>
                                    <td class="{{ $t->type == 'income' ? 'text-success' : 'text-danger' }} fw-bold">
                                        {{ $t->type == 'income' ? '+' : '-' }} R$ {{ number_format($t->amount, 2, ',', '.') }}
                                    </td>
                                    <td>
                                        @if($t->bankAccount)
                                            <div class="small"><i class="bi bi-bank me-1"></i>{{ $t->bankAccount->bank_name }}</div>
                                        @endif
                                        @if($t->paymentMethod)
                                            <div class="small text-muted"><i
                                                    class="bi bi-credit-card me-1"></i>{{ $t->paymentMethod->name }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($t->status == 'paid')
                                            <span class="badge bg-success bg-opacity-10 text-success">Pago</span>
                                            <div class="small text-muted" style="font-size: 0.7rem;">
                                                {{ \Carbon\Carbon::parse($t->paid_at)->format('d/m/Y') }}</div>
                                        @elseif($t->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning">Pendente</span>
                                            <div class="small text-danger" style="font-size: 0.7rem;">Venc:
                                                {{ \Carbon\Carbon::parse($t->due_date)->format('d/m/Y') }}</div>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger">Atrasado</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($t->status != 'paid')
                                            <button class="btn btn-sm btn-link text-success p-0 me-2" title="Confirmar Pagamento"
                                                onclick="openConfirmModal({{ $t }})">
                                                <i class="bi bi-check-circle-fill h5"></i>
                                            </button>
                                        @endif

                                        <button class="btn btn-sm btn-link text-muted" onclick="openFastEditModal({{ $t }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('financial.destroy', $t->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Excluir movimentação?');">
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
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        Nenhuma movimentação encontrada no período.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Transaction (New) -->
    <div class="modal fade" id="modalTransaction" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Nova Movimentação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('financial.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Ação</label>
                            <select name="type" class="form-select" required>
                                <option value="income">Receita (Entrada)</option>
                                <option value="expense">Despesa (Saída)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Descrição</label>
                            <input type="text" name="description" class="form-control" required
                                placeholder="Ex: Conta de Luz, Pagamento Consulta">
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted">Valor (R$)</label>
                                <input type="number" step="0.01" name="amount" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="paid">Pago / Recebido</option>
                                    <option value="pending" selected>Pendente</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted">Data Competência</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Vencimento</label>
                                <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Categoria</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}
                                        ({{ $cat->type == 'income' ? 'Entrada' : 'Saída' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted">Conta Bancária</label>
                                <select name="bank_account_id" class="form-select">
                                    <option value="">Selecione...</option>
                                    @foreach($bankAccounts as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }} - {{ $bank->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Forma Pagamento</label>
                                <select name="payment_method_id" class="form-select">
                                    <option value="">Selecione...</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Fornecedor (Opcional)</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">Selecione...</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="checkRecurrence"
                                onchange="document.getElementById('recurrenceOptions').classList.toggle('d-none')">
                            <label class="form-check-label small" for="checkRecurrence">Repetir movimentação
                                (Recorrência)</label>
                        </div>
                        <div id="recurrenceOptions" class="mt-2 d-none">
                            <select name="recurrence_frequency" class="form-select form-select-sm mb-2">
                                <option value="monthly">Mensalmente</option>
                                <option value="weekly">Semanalmente</option>
                                <option value="yearly">Anualmente</option>
                            </select>
                            <label class="small text-muted">Termina em (Opcional)</label>
                            <input type="date" name="recurrence_end_date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Fast Edit (Edição Rápida) -->
    <div class="modal fade" id="modalFastEdit" tabindex="-1" aria-hidden="true" data-bs-backdrop="false"
        style="z-index: 100002;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: #CA1D53;">Editar Movimentação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formFastEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label small text-muted">Descrição</label>
                            <input type="text" name="description" id="edit_description" class="form-control" required>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label small text-muted">Valor</label>
                                <input type="number" step="0.01" name="amount" id="edit_amount" class="form-control"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Status</label>
                                <select name="status" id="edit_status" class="form-select" required>
                                    <option value="paid">Pago</option>
                                    <option value="pending">Pendente</option>
                                    <option value="overdue">Atrasado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label small text-muted">Vencimento</label>
                                <input type="date" name="due_date" id="edit_due_date" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Pagamento</label>
                                <input type="date" name="date" id="edit_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label small text-muted">Banco</label>
                                <select name="bank_account_id" id="edit_bank_account_id" class="form-select">
                                    <option value="">Selecione...</option>
                                    @foreach($bankAccounts as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Meio Pagto</label>
                                <select name="payment_method_id" id="edit_payment_method_id" class="form-select">
                                    <option value="">Selecione...</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small text-muted">Categoria</label>
                            <select name="category_id" id="edit_category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Confirm Payment -->
    <div class="modal fade" id="modalConfirmPayment" tabindex="-1" style="z-index: 100003;">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content shadow" style="border-radius: 12px;">
                <div class="modal-header border-0">
                    <h6 class="modal-title fw-bold text-success">Confirmar Pagamento</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formConfirmPayment" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p class="small text-muted mb-3">Confirme os dados do recebimento/pagamento:</p>
                        <div class="mb-2">
                            <label class="small text-muted">Data Pagamento</label>
                            <input type="date" name="payment_date" class="form-control form-control-sm"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="small text-muted">Conta Bancária</label>
                            <select name="bank_account_id" class="form-select form-select-sm" required>
                                <option value="">Selecione...</option>
                                @foreach($bankAccounts as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="small text-muted">Forma Pagamento</label>
                            <select name="payment_method_id" class="form-select form-select-sm" required>
                                <option value="">Selecione...</option>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-success btn-sm w-100">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        function openFastEditModal(transaction) {
            const form = document.getElementById('formFastEdit');
            form.action = `/financial/${transaction.id}`; // Update action URL

            // Populate fields
            document.getElementById('edit_description').value = transaction.description;
            document.getElementById('edit_amount').value = transaction.amount;
            document.getElementById('edit_status').value = transaction.status;
            document.getElementById('edit_date').value = transaction.date.substring(0, 10);
            document.getElementById('edit_due_date').value = transaction.due_date.substring(0, 10);
            document.getElementById('edit_category_id').value = transaction.category_id;

            // Handle nulls
            document.getElementById('edit_bank_account_id').value = transaction.bank_account_id || '';
            document.getElementById('edit_payment_method_id').value = transaction.payment_method_id || '';

            const modal = new bootstrap.Modal(document.getElementById('modalFastEdit'));
            modal.show();
        }

        function openConfirmModal(transaction) {
            const form = document.getElementById('formConfirmPayment');
            form.action = `/financial/${transaction.id}/confirm-payment`;

            const modal = new bootstrap.Modal(document.getElementById('modalConfirmPayment'));
            modal.show();
        }
    </script>
@endsection