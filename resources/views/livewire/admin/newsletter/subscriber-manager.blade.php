<div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Buscar por email...">
                </div>
                <div class="col-md-3">
                    <select wire:model.live="filter" class="form-select">
                        <option value="all">Todos os Status</option>
                        <option value="active">Ativos</option>
                        <option value="unsubscribed">Cancelados</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select wire:model.live="utmSource" class="form-select">
                        <option value="">Todas as Origens (UTM)</option>
                        @foreach($utmSources as $source)
                            <option value="{{ $source }}">{{ $source }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <span class="badge bg-primary">{{ $subscribers->total() }} total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Email</th>
                        <th>Fonte</th>
                        <th>Status</th>
                        <th>Data Inscrição</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $sub)
                        <tr wire:key="{{ $sub->id }}">
                            <td>{{ $sub->email }}</td>
                            <td>
                                <div>
                                    <span class="badge bg-secondary">{{ $sub->source ?? 'Direct' }}</span>
                                    @if($sub->utm_medium === 'cpc' || $sub->utm_medium === 'paid' || $sub->utm_medium === 'ads')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-megaphone-fill me-1"></i>Pago</span>
                                    @elseif($sub->utm_medium === 'organic' || $sub->utm_medium === 'social')
                                        <span class="badge bg-info"><i class="bi bi-people-fill me-1"></i>Orgânico</span>
                                    @endif
                                    
                                    @if($sub->utm_source)
                                        <small class="d-block text-muted mt-1" style="font-size: 0.75em;">
                                            via {{ $sub->utm_source }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($sub->is_active)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>{{ $sub->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <button wire:click="toggleStatus({{ $sub->id }})" class="btn btn-sm btn-outline-warning" title="Alternar Status">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                                
                                <button wire:click="delete({{ $sub->id }})" 
                                        wire:confirm="Tem certeza que deseja remover este inscrito?"
                                        class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="card-footer">
            {{ $subscribers->links() }}
        </div>
    </div>
</div>
