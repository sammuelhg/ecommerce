<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-currency-dollar me-2"></i> Gestão de Tráfego Pago
                    @if($sourceFilter)
                        <span class="badge bg-white text-primary ms-2">{{ ucfirst($sourceFilter) }}</span>
                    @endif
                </h5>
                <button wire:click="create" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-lg"></i> Adicionar Despesa
                </button>
            </div>
            <div class="card-body">
                
                @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Data</th>
                                <th>Origem</th>
                                <th>Valor</th>
                                <th>Descrição</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $expense->source === 'meta' ? 'primary' : ($expense->source === 'google' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($expense->source) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-danger">R$ {{ number_format($expense->amount, 2, ',', '.') }}</td>
                                    <td class="text-muted">{{ $expense->description ?? '-' }}</td>
                                    <td class="text-end">
                                        <button wire:click="delete({{ $expense->id }})" class="btn btn-sm btn-outline-danger" onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Nenhuma despesa registrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    @if($isModalOpen)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Registrar Investimento</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('isModalOpen', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Data</label>
                            <input type="date" wire:model="date" class="form-control">
                            @error('date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Plataforma</label>
                            <select wire:model="source" class="form-select">
                                <option value="meta">Meta ADS (Facebook/Instagram)</option>
                                <option value="google">Google ADS</option>
                                <option value="tiktok">TikTok ADS</option>
                                <option value="other">Outros</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Valor Investido (R$)</label>
                            <input type="number" step="0.01" wire:model="amount" class="form-control" placeholder="0.00">
                            @error('amount') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição (Opcional)</label>
                            <input type="text" wire:model="description" class="form-control" placeholder="Ex: Campanha Black Friday">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('isModalOpen', false)">Cancelar</button>
                        <button type="button" class="btn btn-primary" wire:click="store">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
