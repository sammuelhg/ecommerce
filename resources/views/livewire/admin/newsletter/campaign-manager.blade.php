<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1">Gerenciador de Campanhas</h2>
            <p class="text-muted small mb-0">Gerencie e envie suas newsletters.</p>
        </div>
        <button wire:click="create" class="btn btn-dark">
            <i class="bi bi-plus-lg me-2"></i>Nova Campanha
        </button>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input wire:model.live.debounce.300ms="search" type="text" class="form-control border-start-0 ps-0" placeholder="Buscar por assunto...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="all">Todos os Status</option>
                        <option value="draft">Rascunho</option>
                        <option value="sent">Enviado</option>
                        <option value="scheduled">Agendado</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback -->
    <x-admin.alert />

    <!-- List -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Assunto</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Data de Envio</th>
                            <th class="py-3 text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaigns as $campaign)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $campaign->subject }}</div>
                                    <small class="text-muted d-block mb-2">ID: #{{ $campaign->id }}</small>
                                    
                                    @if($campaign->emails->count() > 0)
                                        <div class="bg-light rounded p-2 mt-1 border">
                                            <h6 class="text-muted small fw-bold mb-2"><i class="bi bi-diagram-2 me-1"></i>Sequência de Emails:</h6>
                                            <ul class="list-unstyled mb-0 small">
                                                @foreach($campaign->emails as $email)
                                                    <li class="mb-1 d-flex align-items-center">
                                                        <span class="badge bg-secondary me-2">{{ $loop->iteration }}</span>
                                                        <span class="text-dark me-2">{{ $email->subject ?? '(Sem Assunto)' }}</span>
                                                        @if($email->delay_in_hours > 0)
                                                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                                                +{{ $email->delay_in_hours }}h após anterior
                                                            </span>
                                                        @else
                                                            <span class="badge bg-light text-secondary border">Imediato</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $campaign->status->color() }}-subtle text-{{ $campaign->status->color() }} px-3 py-2 rounded-pill">
                                        {{ $campaign->status->label() }}
                                    </span>
                                </td>
                                <td>
                                    @if($campaign->sent_at)
                                        <i class="bi bi-calendar-check me-1 text-muted"></i>
                                        {{ $campaign->sent_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <!-- Builder Button -->
                                    <a href="{{ route('admin.newsletter.campaign.builder', $campaign->slug ?? $campaign->id) }}" 
                                       class="btn btn-sm btn-outline-primary me-1" 
                                       title="Abrir no Builder">
                                        <i class="bi bi-pencil-square"></i> Builder
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <button wire:click="confirmDeletion({{ $campaign->id }})" class="btn btn-sm btn-outline-danger" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted mb-2"><i class="bi bi-inbox fs-1"></i></div>
                                    <p class="mb-0">Nenhuma campanha encontrada.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $campaigns->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal using Bootstrap styles inline for simplicity or assume generic modal structure -->
    @if($showModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">{{ $isEditing ? 'Editar Campanha' : 'Nova Campanha' }}</h5>
                    <button wire:click="closeModal" type="button" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Assunto do Email</label>
                        <input wire:model="subject" type="text" class="form-control @error('subject') is-invalid @enderror" placeholder="Ex: Ofertas Imperdíveis da Semana">
                        <x-admin.input-error for="subject" />
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button wire:click="closeModal" type="button" class="btn btn-link text-decoration-none text-muted">Cancelar</button>
                    <button wire:click="save" type="button" class="btn btn-dark px-4">
                        <i class="bi bi-check-lg me-2"></i>{{ $isEditing ? 'Salvar Alterações' : 'Criar Rascunho' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingDeletionId)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-exclamation-circle text-danger fs-1 mb-3"></i>
                    <h5 class="fw-bold mb-2">Excluir Campanha?</h5>
                    <p class="text-muted small mb-4">Esta ação não pode ser desfeita.</p>
                    <div class="d-grid gap-2">
                        <button wire:click="delete" class="btn btn-danger">Sim, Excluir</button>
                        <button wire:click="cancelDeletion" class="btn btn-light">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
