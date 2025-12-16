<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Minhas Campanhas</h1>
            <p class="text-muted small">Gerencie suas campanhas de email marketing.</p>
        </div>
        <a href="{{ route('admin.campaigns.builder') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Nova Campanha
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0" placeholder="Buscar campanha por nome...">
            </div>
        </div>
    </div>

    <!-- List -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Campanha</th>
                        <th class="text-center">Emails</th>
                        <th>Remetente</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $campaign->name }}</div>
                                <small class="text-muted">Criado em {{ $campaign->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-envelope me-1"></i> {{ $campaign->email_count }}
                                </span>
                            </td>
                            <td>
                                @if($campaign->signCard)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $campaign->signCard->avatar_url }}" class="rounded-circle me-2" width="24" height="24">
                                        <span class="small">{{ $campaign->signCard->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.campaigns.builder', $campaign->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button wire:click="delete({{ $campaign->id }})" 
                                        wire:confirm="Tem certeza que deseja excluir esta campanha?"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                Nenhuma campanha encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top py-3">
            {{ $campaigns->links() }}
        </div>
    </div>
</div>
