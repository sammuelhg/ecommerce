<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Gerenciador de Campanhas de Email</h5>
                <button wire:click="$set('showModal', true)" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Nova Campanha
                </button>
            </div>
            <div class="card-body">
                @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Assunto</th>
                                <th>Status</th>
                                <th>Enviado em</th>
                                <th>Criado em</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($campaigns as $campaign)
                                <tr>
                                    <td>{{ $campaign->subject }}</td>
                                    <td>
                                        @if($campaign->status === 'sent')
                                            <span class="badge bg-success">Enviado</span>
                                        @else
                                            <span class="badge bg-secondary">Rascunho</span>
                                        @endif
                                    </td>
                                    <td>{{ $campaign->sent_at ? $campaign->sent_at->format('d/m/Y H:i') : '-' }}</td>
                                    <td>{{ $campaign->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        @if($campaign->status !== 'sent')
                                            <button wire:click="send({{ $campaign->id }})" class="btn btn-sm btn-success" onclick="confirm('Tem certeza que deseja enviar esta campanha para todos os assinantes?') || event.stopImmediatePropagation()">
                                                <i class="bi bi-send me-1"></i> Enviar
                                            </button>
                                        @endif
                                        <!-- Add Edit/Delete later if needed -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Nenhuma campanha encontrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    @if($showModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Campanha</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label">Assunto do Email</label>
                            <input type="text" wire:model="subject" class="form-control" required>
                            @error('subject') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Corpo do Email (Markdown/HTML)</label>
                            <textarea wire:model="body" class="form-control" rows="10" required></textarea>
                            <div class="form-text">Você pode usar HTML simples ou texto.</div>
                            @error('body') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" wire:click="$set('showModal', false)">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Rascunho</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
