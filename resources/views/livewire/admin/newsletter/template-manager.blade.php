<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-1">Biblioteca de Modelos</h2>
        <button wire:click="create" class="btn btn-dark">
            <i class="bi bi-plus-lg me-2"></i>Novo Modelo
        </button>
    </div>

    <!-- Feedback -->
    <x-admin.alert />

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
             <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Buscar modelos...">
        </div>
    </div>

    <div class="row g-4">
        @forelse($templates as $template)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header border-bottom-0 pt-3">
                         <div class="d-flex justify-content-between align-items-start">
                             <h5 class="card-title fw-bold mb-0 text-truncate" title="{{ $template->name }}">{{ $template->name }}</h5>
                             <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><button wire:click="edit({{ $template->id }})" class="dropdown-item"><i class="bi bi-pencil me-2"></i>Editar</button></li>
                                    <li><button wire:click="delete({{ $template->id }})" class="dropdown-item text-danger" onclick="confirm('Excluir este modelo?') || event.stopImmediatePropagation()"><i class="bi bi-trash me-2"></i>Excluir</button></li>
                                </ul>
                            </div>
                         </div>
                         @if($template->category)
                            <span class="badge bg-light text-secondary mt-2">{{ $template->category }}</span>
                         @endif
                    </div>
                    <div class="card-body">
                         <p class="small text-muted mb-2">Assunto: {{ Str::limit($template->subject, 30) }}</p>
                         <div class="bg-light p-2 rounded" style="height: 100px; overflow: hidden; font-size: 0.7rem; color: #666;">
                             {{ strip_tags($template->body) }}
                         </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-layout-text-window-reverse fs-1 text-muted mb-3"></i>
                <p class="text-muted">Nenhum modelo encontrado.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $templates->links() }}
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">{{ $isEditing ? 'Editar Modelo' : 'Novo Modelo' }}</h5>
                    <button wire:click="closeModal" type="button" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nome do Modelo</label>
                            <input wire:model="name" type="text" class="form-control" placeholder="Ex: Promoção Padrão">
                            <x-admin.input-error for="name" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Categoria</label>
                            <input wire:model="category" type="text" class="form-control" placeholder="Ex: Vendas">
                            <x-admin.input-error for="category" />
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Assunto Sugerido</label>
                            <input wire:model="subject" type="text" class="form-control" placeholder="Ex: Confira nossas ofertas">
                             <x-admin.input-error for="subject" />
                        </div>
                         <div class="col-12">
                            <label class="form-label fw-bold">Conteúdo HTML</label>
                            <textarea wire:model="body" class="form-control font-monospace" rows="10"></textarea>
                            <x-admin.input-error for="body" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button wire:click="closeModal" type="button" class="btn btn-link text-muted text-decoration-none">Cancelar</button>
                    <button wire:click="save" type="button" class="btn btn-dark">
                        <i class="bi bi-check-lg me-1"></i>Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
