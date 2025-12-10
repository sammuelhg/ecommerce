<div class="card shadow-sm">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>Leads Capturados
            </h5>
            <span class="badge bg-light text-dark border">
                Total: {{ $leads->total() }}
            </span>
        </div>

        <div class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           class="form-control border-start-0 ps-0" 
                           placeholder="Buscar por Nome, Email ou Telefone...">
                </div>
            </div>
            <div class="col-md-3">
                <select wire:model.live="filter" class="form-select">
                    <option value="all">Todos os Status</option>
                    <option value="active">Ativos</option>
                    <option value="banned">Banidos</option>
                </select>
            </div>
            <div class="col-md-3">
                <select wire:model.live="sourceFilter" class="form-select">
                    <option value="">Todas as Origens</option>
                    @foreach($sources as $src)
                        <option value="{{ $src }}">{{ ucfirst($src ?? 'Desconhecido') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Data</th>
                    <th>Lead</th>
                    <th>Contato</th>
                    <th>Origem (UTM)</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td class="ps-4 text-muted" style="font-size: 0.85rem;">
                            {{ $lead->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $lead->name ?? 'Sem Nome' }}</div>
                            <small class="text-muted">Origem: {{ $lead->source }}</small>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span><i class="bi bi-envelope me-1"></i> {{ $lead->email }}</span>
                                @if($lead->phone)
                                    <small class="text-muted"><i class="bi bi-whatsapp me-1"></i> {{ $lead->phone }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $meta = is_string($lead->meta) ? json_decode($lead->meta, true) : $lead->meta;
                                $source = $meta['utm_source'] ?? '-';
                                $medium = $meta['utm_medium'] ?? '-';
                                $camp = $meta['utm_campaign'] ?? '-';
                            @endphp
                            <div style="font-size: 0.85rem;">
                                @if($source !== '-')
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info-subtle">{{ $source }}</span>
                                @endif
                                <div class="text-muted mt-1">
                                    Meio: {{ $medium }} <br>
                                    Camp: {{ $camp }}
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($lead->status === 'active' || (is_object($lead->status) && $lead->status->value === 'active'))
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                    Ativo
                                </span>
                            @elseif($lead->status === 'banned' || (is_object($lead->status) && $lead->status->value === 'banned'))
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">
                                    Banido
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">
                                    {{ is_object($lead->status) ? $lead->status->value : $lead->status }}
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <button wire:click="toggleStatus({{ $lead->id }})" 
                                        class="btn btn-sm btn-outline-secondary" 
                                        title="{{ ($lead->status === 'banned' || (is_object($lead->status) && $lead->status->value === 'banned')) ? 'Ativar' : 'Banir' }}">
                                    @if($lead->status === 'banned' || (is_object($lead->status) && $lead->status->value === 'banned'))
                                        <i class="bi bi-check-lg text-success"></i>
                                    @else
                                        <i class="bi bi-slash-circle text-danger"></i>
                                    @endif
                                </button>
                                <button wire:confirm="Tem certeza que deseja apagar este lead?" 
                                        wire:click="delete({{ $lead->id }})" 
                                        class="btn btn-sm btn-outline-danger" 
                                        title="Excluir Permanentemente">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            Nenhum lead encontrado com os filtros atuais.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="card-footer bg-white border-top py-3">
        {{ $leads->links() }}
    </div>
</div>
