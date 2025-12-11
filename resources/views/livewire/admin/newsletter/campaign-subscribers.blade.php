<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="d-flex align-items-center mb-1">
                <a href="{{ route('admin.newsletter.campaigns') }}" class="btn btn-sm btn-light border me-3 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="h4 fw-bold mb-0">Inscritos da Campanha</h2>
            </div>
            <p class="text-muted small mb-0 ms-5">{{ $campaign->subject }} (ID: #{{ $campaign->id }})</p>
        </div>
        <div>
             <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                Total: {{ $subscribers->total() }}
             </span>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input wire:model.live.debounce.300ms="search" type="text" class="form-control border-start-0 ps-0" placeholder="Buscar por email ou nome...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.alert />

    <!-- List -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Inscrito</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Entrou em</th>
                            <th class="py-3">Passo Atual</th>
                            <th class="py-3 text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscribers as $subscriber)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $subscriber->email }}</div>
                                    @if($subscriber->name)
                                        <small class="text-muted">{{ $subscriber->name }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $subscriber->is_active ? 'success' : 'danger' }}-subtle text-{{ $subscriber->is_active ? 'success' : 'danger' }} px-3 py-1 rounded-pill">
                                        {{ $subscriber->is_active ? 'Ativo' : 'Cancelado' }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $subscriber->pivot->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    @if($subscriber->pivot->current_email_id)
                                        <span class="badge bg-secondary-subtle text-secondary border">
                                            Email ID: {{ $subscriber->pivot->current_email_id }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="removeSubscriber({{ $subscriber->id }})" 
                                            class="btn btn-sm btn-light text-danger border hover-shadow" 
                                            title="Remover da Campanha"
                                            onclick="confirm('Tem certeza? Isso removerá o inscrito desta campanha.') || event.stopImmediatePropagation()">
                                        <i class="bi bi-person-x"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-2"><i class="bi bi-people fs-1"></i></div>
                                    <p class="mb-0">Nenhum inscrito encontrado nesta campanha.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $subscribers->links() }}
        </div>
    </div>
</div>
