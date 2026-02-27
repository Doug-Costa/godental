@extends('facelift2.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1" style="color: #4f4f4f; font-size: 1.6rem;">
                    <i class="bi bi-gear-fill text-danger me-2"></i>Administração
                </h1>
                <p class="text-muted mb-0">Gestão completa da clínica: Financeiro, Equipe, Procedimentos e Estoque</p>
            </div>
        </div>

        <!-- Custom Tabs Navigation -->
        <ul class="nav nav-pills mb-4 gap-2" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-4 py-2 fw-semibold" id="general-tab" data-bs-toggle="pill"
                    data-bs-target="#general-panel" type="button" role="tab">
                    <i class="bi bi-hdd-stack me-1"></i> Geral
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 fw-semibold" id="team-tab" data-bs-toggle="pill"
                    data-bs-target="#team-panel" type="button" role="tab">
                    <i class="bi bi-people-fill me-1"></i> Equipe
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 fw-semibold" id="prices-tab" data-bs-toggle="pill"
                    data-bs-target="#prices-panel" type="button" role="tab">
                    <i class="bi bi-currency-dollar me-1"></i> Procedimentos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 fw-semibold" id="stock-tab" data-bs-toggle="pill"
                    data-bs-target="#stock-panel" type="button" role="tab">
                    <i class="bi bi-box-seam me-1"></i> Estoque
                </button>
            </li>
        </ul>

        <style>
            .nav-pills .nav-link.active {
                background: linear-gradient(135deg, #CA1D53, #7c1233) !important;
                color: #fff !important;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(202, 29, 83, 0.2);
            }
            .nav-pills .nav-link:not(.active) {
                background: #fff;
                color: #555;
                border: 1px solid #e0e0e0;
                border-radius: 10px;
            }
            .admin-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
                transition: box-shadow .2s;
                height: 100%;
            }
            .admin-card:hover {
                box-shadow: 0 4px 20px rgba(0, 0, 0, .10);
            }
            .section-title {
                font-size: 1.1rem;
                font-weight: 700;
                color: #444;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
            }
            .section-title i {
                color: #CA1D53;
                margin-right: 8px;
            }
            .btn-admin-sm {
                background: #CA1D53;
                color: white;
                border: none;
                border-radius: 8px;
                padding: 4px 12px;
                font-size: 0.85rem;
            }
            .btn-admin-sm:hover {
                background: #a01540;
                color: white;
            }
            .table-sm-admin th {
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #777;
            }
            .table-sm-admin td {
                font-size: 0.9rem;
            }
        </style>

        <div class="tab-content" id="adminTabContent">

            <!-- ══════════════════════════════════════════════════════════════
                 TAB: GERAL (Bancos, Fornecedores, Categorias)
                 ══════════════════════════════════════════════════════════════ -->
            <div class="tab-pane fade show active" id="general-panel" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- BANCOS -->
                    <div class="col-md-4">
                        <div class="card admin-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="section-title mb-0"><i class="bi bi-bank"></i> Contas Bancárias</div>
                                    <button class="btn btn-admin-sm" data-bs-toggle="modal" data-bs-target="#modalBankAccount">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm-admin align-middle mb-0">
                                        <tbody>
                                            @forelse($bankAccounts as $bank)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $bank->bank_name }}</div>
                                                        <small class="text-muted">{{ $bank->description }}</small>
                                                    </td>
                                                    <td class="text-end text-muted">Ag: {{ $bank->agency }}</td>
                                                    <td class="text-end" style="width: 40px;">
                                                        <form action="{{ route('bank-accounts.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('Excluir?');">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="3" class="text-center text-muted small py-3">Nenhuma conta cadastrada</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FORNECEDORES -->
                    <div class="col-md-4">
                        <div class="card admin-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="section-title mb-0"><i class="bi bi-truck"></i> Fornecedores</div>
                                    <button class="btn btn-admin-sm" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm-admin align-middle mb-0">
                                        <tbody>
                                            @forelse($suppliers as $supplier)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $supplier->name }}</div>
                                                        <small class="text-muted">{{ $supplier->phone ?? '-' }}</small>
                                                    </td>
                                                    <td class="text-end" style="width: 40px;">
                                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Excluir?');">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="2" class="text-center text-muted small py-3">Nenhum fornecedor cadastrado</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CATEGORIAS -->
                    <div class="col-md-4">
                        <div class="card admin-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="section-title mb-0"><i class="bi bi-tags"></i> Categorias</div>
                                    <button class="btn btn-admin-sm" data-bs-toggle="modal" data-bs-target="#modalCategory">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm-admin align-middle mb-0">
                                        <tbody>
                                            @forelse($financialCategories as $cat)
                                                <tr>
                                                    <td>
                                                        <span class="badge {{ $cat->type == 'income' ? 'bg-success' : 'bg-danger' }} me-2">
                                                            {{ $cat->type == 'income' ? 'Rec' : 'Desp' }}
                                                        </span>
                                                        {{ $cat->name }}
                                                    </td>
                                                    <td class="text-end" style="width: 40px;">
                                                        <form action="{{ route('financial-categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Excluir?');">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="2" class="text-center text-muted small py-3">Nenhuma categoria cadastrada</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ══════════════════════════════════════════════════════════════
                 TAB: EQUIPE (Profesionais)
                 ══════════════════════════════════════════════════════════════ -->
            <div class="tab-pane fade" id="team-panel" role="tabpanel">
                <div class="card admin-card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-people-fill me-2"></i>Profissionais (Dentistas e Colaboradores)</h5>
                            <div>
                                <form action="{{ route('remuneration.payroll') }}" method="POST" class="d-inline-block me-2" onsubmit="return confirm('Confirma gerar a folha de pagamento para o mês atual? Isso criará despesas para todos os profissionais CLT/Fixo.');">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm px-3" type="submit">
                                        <i class="bi bi-wallet2 me-1"></i> Gerar Folha
                                    </button>
                                </form>
                                <button class="btn btn-admin-sm px-3" onclick="openDoctorModal()">
                                    <i class="bi bi-plus-lg me-1"></i> Novo Profissional
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="doctorsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome/Função</th>
                                        <th>Tipo Contrato</th>
                                        <th>Remuneração</th>
                                        <th>Contato</th>
                                        <th>Ativo</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doc)
                                        <tr id="doctor-row-{{ $doc->id }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="color-dot me-2" style="background:{{ $doc->color ?? '#ccc' }}"></span>
                                                    <div>
                                                        <div class="fw-bold">{{ $doc->name }}</div>
                                                        <span class="badge {{ $doc->role == 'dentist' ? 'bg-primary' : 'bg-secondary' }} bg-opacity-75" style="font-size: 0.75rem;">
                                                            {{ $doc->role == 'dentist' ? 'Dentista' : 'Colaborador' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($doc->contract_type)
                                                    <span class="badge bg-light text-dark border">{{ strtoupper($doc->contract_type) }}</span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($doc->remuneration_type)
                                                    <div class="small">
                                                        @if($doc->remuneration_type == 'fixed' || $doc->remuneration_type == 'mixed')
                                                            <div>Fixo: R$ {{ number_format($doc->fixed_salary, 2, ',', '.') }}</div>
                                                        @endif
                                                        @if($doc->remuneration_type == 'percentage' || $doc->remuneration_type == 'mixed')
                                                            <div>Comissão: {{ $doc->commission_percentage }}%</div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="small">
                                                <div>{{ $doc->phone ?? '-' }}</div>
                                                <div class="text-muted">{{ $doc->email ?? '' }}</div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $doc->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $doc->is_active ? 'Sim' : 'Não' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    onclick='editDoctor(@json($doc))'>
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteDoctor({{ $doc->id }})">
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
            </div>

            <!-- ══════════════════════════════════════════════════════════════
                 TAB: PROCEDIMENTOS
                 ══════════════════════════════════════════════════════════════ -->
            <div class="tab-pane fade" id="prices-panel" role="tabpanel">
                @include('admin.partials.procedures_tab')
            </div>

            <!-- ══════════════════════════════════════════════════════════════
                 TAB: ESTOQUE
                 ══════════════════════════════════════════════════════════════ -->
            <div class="tab-pane fade" id="stock-panel" role="tabpanel">
                <div class="card admin-card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Controle de Estoque</h5>
                            <button class="btn btn-admin-sm" onclick="openInventoryModal()">
                                <i class="bi bi-plus-lg me-1"></i> Novo Item
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="inventoryTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Unidade</th>
                                        <th>Custo</th>
                                        <th>Estoque Atual</th>
                                        <th>Status</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventoryItems as $item)
                                        <tr id="item-row-{{ $item->id }}">
                                            <td class="fw-semibold">{{ $item->name }}</td>
                                            <td class="text-muted small">{{ $item->unit }}</td>
                                            <td>R$ {{ number_format($item->cost_price ?? 0, 2, ',', '.') }}</td>
                                            <td>
                                                <span class="badge {{ $item->current_stock <= $item->min_stock ? 'bg-danger' : 'bg-success' }}">
                                                    {{ $item->current_stock }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item->current_stock <= 0)
                                                    <span class="text-danger small fw-bold">Sem Estoque</span>
                                                @elseif($item->current_stock <= $item->min_stock)
                                                    <span class="text-warning small fw-bold">Baixo Estoque</span>
                                                @else
                                                    <span class="text-success small fw-bold">OK</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-success" title="Entrada" onclick="openStockEntryModal(@json($item))">
                                                    <i class="bi bi-box-arrow-in-down"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary" title="Editar" onclick='editInventory(@json($item))'>
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Excluir" onclick="deleteInventory({{ $item->id }})">
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
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════
         MODALS
         ══════════════════════════════════════════════════════════════ -->

    <!-- Modal Service Price -->
    <div class="modal fade" id="modalServicePrice" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0"><h6 class="fw-bold" id="modalPriceTitle">Novo Serviço</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" id="priceId">
                    <div class="mb-2"><label>Nome do Serviço</label><input type="text" id="priceName" class="form-control" required></div>
                    <div class="mb-2"><label>Categoria</label><select id="priceCategory" class="form-select"><option value="Consulta">Consulta</option><option value="Procedimento">Procedimento</option><option value="Retorno">Retorno</option></select></div>
                    <div class="mb-2"><label>Preço Padrão (R$)</label><input type="number" step="0.01" id="priceDefault" class="form-control" required></div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="priceActive" checked>
                        <label class="form-check-label">Ativo</label>
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-primary btn-sm w-100" onclick="savePrice()">Salvar</button></div>
            </div>
        </div>
    </div>

    <!-- Modal Inventory Item -->
    <div class="modal fade" id="modalInventory" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0"><h6 class="fw-bold" id="modalInventoryTitle">Novo Item</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" id="itemId">
                    <div class="mb-2"><label>Nome</label><input type="text" id="itemName" class="form-control" required></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label>Unidade</label><input type="text" id="itemUnit" class="form-control" placeholder="un, cx, ml"></div>
                        <div class="col-6"><label>Estoque Mín.</label><input type="number" id="itemMinStock" class="form-control" value="5"></div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label>Custo (R$)</label><input type="number" step="0.01" id="itemCost" class="form-control"></div>
                        <div class="col-6"><label>Venda (R$)</label><input type="number" step="0.01" id="itemSelling" class="form-control"></div>
                    </div>
                    <div class="mb-2">
                        <label>Fornecedor Principal</label>
                        <select id="itemSupplier" class="form-select">
                            <option value="">Selecione...</option>
                            @foreach($suppliers as $sup) <option value="{{ $sup->id }}">{{ $sup->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="alert alert-warning small py-2 d-none" id="initialStockAlert">
                        <i class="bi bi-exclamation-triangle me-1"></i> Para adicionar saldo inicial, use a função "Entrada" após salvar.
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-primary btn-sm w-100" onclick="saveInventory()">Salvar</button></div>
            </div>
        </div>
    </div>

    <!-- Modal Stock Entry -->
    <div class="modal fade" id="modalStockEntry" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0"><h6 class="fw-bold">Entrada de Estoque</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" id="entryItemId">
                    <h6 class="text-center fw-bold text-primary mb-3" id="entryItemName">Nome do Item</h6>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6"><label>Quantidade</label><input type="number" id="entryQuantity" class="form-control" min="1" required></div>
                        <div class="col-6"><label>Novo Custo (Opcional)</label><input type="number" step="0.01" id="entryCost" class="form-control"></div>
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="entryCreateExpense" checked onchange="document.getElementById('expenseFields').classList.toggle('d-none')">
                        <label class="form-check-label">Gerar Despesa Financeira</label>
                    </div>

                    <div id="expenseFields">
                        <div class="mb-2"><label>Categoria Financeira</label>
                            <select id="entryCategory" class="form-select">
                                @foreach($financialCategories->where('type', 'expense') as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2"><label>Descrição</label><input type="text" id="entryDescription" class="form-control" value="Compra de Estoque"></div>
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-success btn-sm w-100" onclick="saveStockEntry()">Confirmar Entrada</button></div>
            </div>
        </div>
    </div>

    <!-- Modal Bank Account -->
    <div class="modal fade" id="modalBankAccount" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0"><h6 class="fw-bold">Nova Conta Bancária</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="{{ route('bank-accounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                         <div class="mb-2"><label>Nome do Banco</label><input type="text" name="bank_name" class="form-control" required></div>
                         <div class="mb-2"><label>Descrição (Apelido)</label><input type="text" name="description" class="form-control" required></div>
                         <div class="row g-2 mb-2">
                             <div class="col-6"><label>Agência</label><input type="text" name="agency" class="form-control"></div>
                             <div class="col-6"><label>Conta</label><input type="text" name="account_number" class="form-control"></div>
                         </div>
                         <div class="row g-2">
                             <div class="col-6"><label>Tipo</label><select name="account_type" class="form-select"><option value="checking">Corrente</option><option value="savings">Poupança</option></select></div>
                             <div class="col-6"><label>Saldo Inicial</label><input type="number" step="0.01" name="initial_balance" class="form-control" value="0.00"></div>
                         </div>
                    </div>
                    <div class="modal-footer border-0"><button class="btn btn-primary btn-sm w-100">Salvar</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Supplier -->
    <div class="modal fade" id="modalSupplier" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header border-0"><h6 class="fw-bold">Novo Fornecedor</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                 <form action="{{ route('suppliers.store') }}" method="POST">
                     @csrf
                     <div class="modal-body">
                         <div class="mb-2"><label>Nome</label><input type="text" name="name" class="form-control" required></div>
                         <div class="mb-2"><label>Telefone</label><input type="text" name="phone" class="form-control"></div>
                         <div class="mb-2"><label>Email</label><input type="email" name="email" class="form-control"></div>
                     </div>
                     <div class="modal-footer border-0"><button class="btn btn-primary btn-sm w-100">Salvar</button></div>
                 </form>
            </div>
        </div>
    </div>

    <!-- Modal Category -->
    <div class="modal fade" id="modalCategory" tabindex="-1">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header border-0"><h6 class="fw-bold">Nova Categoria</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                 <form action="{{ route('financial-categories.store') }}" method="POST">
                     @csrf
                     <div class="modal-body">
                         <div class="mb-2"><label>Nome</label><input type="text" name="name" class="form-control" required></div>
                         <div class="mb-2"><label>Tipo</label><select name="type" class="form-select"><option value="expense">Despesa</option><option value="income">Receita</option></select></div>
                     </div>
                     <div class="modal-footer border-0"><button class="btn btn-primary btn-sm w-100">Salvar</button></div>
                 </form>
             </div>
         </div>
    </div>

    <!-- Modal Professional (Doctor/Collaborator) -->
    <div class="modal fade" id="modalDoctor" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalDoctorTitle">Novo Profissional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="doctorId">
                    
                    <ul class="nav nav-tabs mb-3" id="docTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" id="doc-personal-tab" data-bs-toggle="tab" data-bs-target="#doc-personal" type="button">Dados Pessoais</button></li>
                        <li class="nav-item"><button class="nav-link" id="doc-contract-tab" data-bs-toggle="tab" data-bs-target="#doc-contract" type="button">Contrato & Remuneração</button></li>
                        <li class="nav-item"><button class="nav-link" id="doc-schedule-tab" data-bs-toggle="tab" data-bs-target="#doc-schedule" type="button">Horários</button></li>
                    </ul>

                    <div class="tab-content">
                        <!-- Personal Info -->
                        <div class="tab-pane fade show active" id="doc-personal">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Nome *</label>
                                    <input type="text" class="form-control" id="doctorName" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Função/Cargo *</label>
                                    <select class="form-select" id="doctorRole">
                                        <option value="dentist">Dentista</option>
                                        <option value="collaborator">Colaborador</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Especialidade</label>
                                    <input type="text" class="form-control" id="doctorSpecialty" placeholder="Ex: Ortodontista">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">CRO/CRM (Se aplicável)</label>
                                    <input type="text" class="form-control" id="doctorCrm">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Telefone</label>
                                    <input type="text" class="form-control" id="doctorPhone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" id="doctorEmail">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Cor no Calendário</label>
                                    <input type="color" class="form-control form-control-color" id="doctorColor" value="#CA1D53">
                                </div>
                            </div>
                        </div>

                        <!-- Contract & Remuneration -->
                        <div class="tab-pane fade" id="doc-contract">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipo Contrato</label>
                                    <select class="form-select" id="doctorContractType">
                                        <option value="">Selecione...</option>
                                        <option value="clt">CLT (Mensalista)</option>
                                        <option value="pj">PJ (Prestador)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Modo de Remuneração</label>
                                    <select class="form-select" id="doctorRemunerationType">
                                        <option value="">Selecione...</option>
                                        <option value="fixed">Fixo Mensal</option>
                                        <option value="percentage">Porcentagem (%)</option>
                                        <option value="mixed">Misto (Fixo + %)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Salário Fixo (R$)</label>
                                    <input type="number" class="form-control" id="doctorFixedSalary" step="0.01" placeholder="0.00">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Comissão (%)</label>
                                    <input type="number" class="form-control" id="doctorCommission" step="0.01" placeholder="Ex: 40">
                                    <small class="text-muted">Porcentagem sobre procedimentos</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Chave PIX</label>
                                    <input type="text" class="form-control" id="doctorPixKey" placeholder="CPF, Email, Telefone...">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Dados Bancários / Observações</label>
                                    <textarea class="form-control" id="doctorBankDetails" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule (Placeholder link to existing Logic) -->
                        <div class="tab-pane fade" id="doc-schedule">
                           <div class="row">
                               <div class="col-md-4 border-end">
                                   <h6 class="fw-bold mb-3 small text-uppercase text-muted">Adicionar Horário</h6>
                                   <div class="mb-2">
                                       <label class="small text-muted">Dia da Semana</label>
                                       <select id="scheduleDay" class="form-select form-select-sm">
                                           <option value="1">Segunda-feira</option>
                                           <option value="2">Terça-feira</option>
                                           <option value="3">Quarta-feira</option>
                                           <option value="4">Quinta-feira</option>
                                           <option value="5">Sexta-feira</option>
                                           <option value="6">Sábado</option>
                                           <option value="0">Domingo</option>
                                       </select>
                                   </div>
                                   <div class="row g-2 mb-2">
                                       <div class="col-6">
                                           <label class="small text-muted">Início</label>
                                           <input type="time" id="scheduleStart" class="form-control form-control-sm" required>
                                       </div>
                                       <div class="col-6">
                                           <label class="small text-muted">Fim</label>
                                           <input type="time" id="scheduleEnd" class="form-control form-control-sm" required>
                                       </div>
                                   </div>
                                   <div class="mb-3">
                                        <label class="small text-muted">Duração do Slot (min)</label>
                                        <input type="number" id="scheduleDuration" class="form-control form-control-sm" value="30" min="10" step="5">
                                   </div>
                                   <button class="btn btn-primary btn-sm w-100" onclick="addSchedule()">
                                       <i class="bi bi-plus-lg me-1"></i> Adicionar
                                   </button>
                               </div>
                               <div class="col-md-8">
                                   <h6 class="fw-bold mb-3 small text-uppercase text-muted">Horários Configurados</h6>
                                   <div class="table-responsive border rounded" style="max-height: 300px; overflow-y: auto;">
                                       <table class="table table-sm table-hover align-middle mb-0" id="scheduleTable">
                                           <thead class="table-light sticky-top">
                                               <tr>
                                                   <th style="width: 35%;">Dia</th>
                                                   <th style="width: 30%;">Horário</th>
                                                   <th style="width: 25%;">Slot</th>
                                                   <th style="width: 10%;"></th>
                                               </tr>
                                           </thead>
                                           <tbody id="scheduleList" class="small">
                                               <!-- Populated by JS -->
                                               <tr><td colspan="4" class="text-center text-muted py-3">Selecione um profissional para ver horários</td></tr>
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-admin-sm px-4" onclick="saveDoctor()">Salvar Profissional</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.scripts')
    
    <!-- Inline Scripts for simpler interactions not in partial -->
    <script>
         function switchTab(tabId) {
             const triggerEl = document.querySelector('#' + tabId);
             bootstrap.Tab.getInstance(triggerEl).show();
         }
    </script>
@endsection
