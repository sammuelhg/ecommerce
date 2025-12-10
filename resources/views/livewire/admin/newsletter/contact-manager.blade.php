<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Contatos do Site</h1>
            <div class="d-flex gap-2">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Buscar contatos...">
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Nome / Email</th>
                                <th>Mensagem</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                                <tr class="{{ !$contact->is_read ? 'fw-bold bg-white' : '' }}">
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span>{{ $contact->name }}</span>
                                            <small class="text-muted">{{ $contact->email }}</small>
                                            <small class="text-muted">{{ $contact->phone }}</small>
                                        </div>
                                    </td>
                                    <td style="max-width: 400px;">
                                        <div class="text-truncate" style="max-width: 380px;" title="{{ $contact->message }}">
                                            {{ $contact->message }}
                                        </div>
                                    </td>
                                    <td>
                                        @if(!$contact->is_read)
                                            <span class="badge bg-primary">Novo</span>
                                        @else
                                            <span class="badge bg-secondary">Lido</span>
                                        @endif
                                    </td>
                                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-end pe-4">
                                        @if(!$contact->is_read)
                                            <button wire:click="markAsRead({{ $contact->id }})" class="btn btn-sm btn-outline-primary" title="Marcar como lido">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        @endif
                                        <button wire:click="delete({{ $contact->id }})" 
                                                wire:confirm="Tem certeza que deseja apagar este contato?"
                                                class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <!-- View Modal Trigger could go here -->
                                        <button class="btn btn-sm btn-light border" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewContactModal{{ $contact->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Modal for Viewing Message -->
                                        <div class="modal fade" id="viewContactModal{{ $contact->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Mensagem de {{ $contact->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-wrap fw-normal text-start">
                                                        <p><strong>Email:</strong> {{ $contact->email }}</p>
                                                        <p><strong>Telefone:</strong> {{ $contact->phone ?? 'N/A' }}</p>
                                                        <p><strong>Data:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
                                                        <hr>
                                                        <p class="whitespace-pre-wrap">{{ $contact->message }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                        <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                                                            <i class="bi bi-envelope-fill me-1"></i> Responder Email
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        Nenhum contato encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>
