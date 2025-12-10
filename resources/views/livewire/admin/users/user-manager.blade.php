<div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex gap-2">
                    <button wire:click="setFilter('all')" class="btn {{ $filterType === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        Todos
                    </button>
                    <button wire:click="setFilter('customers')" class="btn {{ $filterType === 'customers' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        <i class="bi bi-cart-check-fill me-1"></i> Clientes
                    </button>
                    <button wire:click="setFilter('users')" class="btn {{ $filterType === 'users' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        <i class="bi bi-person me-1"></i> Usuários
                    </button>
                    <div class="ms-3 d-flex align-items-center">
                        <span class="badge bg-info bg-opacity-10 text-info border border-info p-2">
                            <i class="bi bi-cash-coin me-1"></i> Ticket Médio (Loja): R$ {{ number_format($storeAov, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1" style="max-width: 400px;">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Buscar por nome, email ou ID...">
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th scope="col" class="ps-3">Cliente</th>
                        <th scope="col">Contato</th>
                        <th scope="col">Data Cadastro</th>
                        <th scope="col" class="text-center">Pedidos</th>
                        <th scope="col" class="text-end">Ticket Médio</th>
                        <th scope="col" class="text-end pe-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr wire:key="{{ $user->id }}">
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 40px; height: 40px;">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle w-100 h-100 object-fit-cover">
                                        @else
                                            {{ substr($user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">
                                            {{ $user->name }}
                                            @if($user->orders_count > 0)
                                                <span class="badge bg-success small ms-1" style="font-size: 0.65rem;">CLIENTE</span>
                                            @else
                                                <span class="badge bg-secondary small ms-1" style="font-size: 0.65rem;">USUÁRIO</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">ID: #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="bi bi-envelope me-1 text-muted"></i> {{ $user->email }}</div>
                                @if($user->phone)
                                    <div><i class="bi bi-whatsapp me-1 text-success"></i> {{ $user->phone }}</div>
                                @else
                                    <small class="text-muted fst-italic">Sem telefone</small>
                                @endif
                            </td>
                            <td>
                                <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="text-center">
                                @if($user->orders_count > 0)
                                    <span class="badge bg-success rounded-pill px-3">{{ $user->orders_count }}</span>
                                @else
                                    <span class="badge bg-light text-muted border rounded-pill px-3">0</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($user->orders_count > 0)
                                    <span class="fw-bold text-primary">
                                        R$ {{ number_format($user->orders_sum_total_price / $user->orders_count, 2, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <button wire:click="viewUser({{ $user->id }})" class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-people text-muted fs-1 d-block mb-3"></i>
                                <h5 class="text-muted">Nenhum cliente encontrado</h5>
                                @if($search)
                                    <p class="text-muted small">Tente buscar por outro termo.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $users->links() }}
        </div>
    </div>

    <!-- User Detail Modal -->
    @if($isDetailModalOpen && $selectedUser)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Detalhes do Cliente</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeDetailModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="avatar-lg bg-light rounded-circle me-3 d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 64px; height: 64px; font-size: 1.5rem;">
                                    @if($selectedUser->avatar)
                                        <img src="{{ $selectedUser->avatar_url }}" class="rounded-circle w-100 h-100 object-fit-cover">
                                    @else
                                        {{ substr($selectedUser->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $selectedUser->name }}</h5>
                                    <p class="text-muted mb-0 small">Cadastrado em {{ $selectedUser->created_at->format('d/m/Y') }}</p>
                                    <span class="badge bg-{{ $selectedUser->orders_count > 0 ? 'success' : 'secondary' }}">
                                        {{ $selectedUser->orders_count > 0 ? 'CLIENTE' : 'USUÁRIO' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-envelope text-muted me-2"></i> {{ $selectedUser->email }}</li>
                                    @if($selectedUser->phone)
                                        <li class="mb-2"><i class="bi bi-whatsapp text-success me-2"></i> {{ $selectedUser->phone }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6 col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center p-3">
                                        <h6 class="text-muted small mb-1">Total Gasto</h6>
                                        <h4 class="mb-0 fw-bold text-success">R$ {{ number_format($selectedUser->orders_sum_total_price ?? 0, 2, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center p-3">
                                        <h6 class="text-muted small mb-1">Pedidos</h6>
                                        <h4 class="mb-0 fw-bold">{{ $selectedUser->orders_count }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center p-3">
                                        <h6 class="text-muted small mb-1">Ticket Médio (B2C)</h6>
                                        @php
                                            $userAov = $selectedUser->orders_count > 0 ? $selectedUser->orders_sum_total_price / $selectedUser->orders_count : 0;
                                        @endphp
                                        <h4 class="mb-0 fw-bold text-primary">R$ {{ number_format($userAov, 2, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning me-2"></i>Top Produtos Comprados</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th class="text-center">Qtd</th>
                                        <th class="text-end">Total Gasto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userBestSellers as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded me-2" style="width: 24px; height: 24px; object-fit: cover;">
                                                    @endif
                                                    <span class="small">{{ $item->product->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold">{{ $item->total_qty }}</td>
                                            <td class="text-end text-success small">R$ {{ number_format($item->total_spent, 2, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted small py-3">Nenhum pedido realizado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
