<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control bg-white" placeholder="Buscar tamanhos...">
        </div>
        <div class="col-md-6 text-end mt-3 mt-md-0">
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Tamanho
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Lista de Tamanhos</h5>
        </div>
        <div class="card-body p-0">
            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sizes as $size)
                            <tr>
                                <td class="ps-4">{{ $size->id }}</td>
                                <td class="fw-bold">{{ $size->name }}</td>
                                <td><code class="text-muted">{{ $size->code }}</code></td>
                                <td>
                                    <span class="badge {{ $size->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $size->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $size->id }})" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-outline-danger"
                                        wire:click="delete({{ $size->id }})"
                                        wire:confirm="Tem certeza que deseja excluir este tamanho?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-secondary"></i>
                                    <p class="mb-0">Nenhum tamanho encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @forelse($sizes as $size)
                    <div class="p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1 fw-bold fs-5">{{ $size->name }}</h6>
                                <code class="text-muted">{{ $size->code }}</code>
                            </div>
                            <span class="badge {{ $size->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $size->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button wire:click="edit({{ $size->id }})" class="btn btn-outline-primary btn-sm px-3">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </button>
                            <button 
                                class="btn btn-outline-danger btn-sm px-3"
                                wire:click="delete({{ $size->id }})"
                                wire:confirm="Tem certeza que deseja excluir este tamanho?">
                                <i class="bi bi-trash me-1"></i> Excluir
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox display-1 text-secondary mb-3"></i>
                        <p class="mb-0">Nenhum tamanho encontrado.</p>
                    </div>
                @endforelse
            </div>

            <div class="p-4 border-top">
                {{ $sizes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sizeModalLabel">
                        {{ $editingId ? 'Editar Tamanho' : 'Novo Tamanho' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($showForm)
                        @livewire('admin.product-size-form', ['sizeId' => $editingId], key($editingId ?? 'new'))
                    @else
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        const modalId = 'sizeModal';
        const modalElement = document.getElementById(modalId);
        
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            
            Livewire.on('open-size-modal', () => {
                modal.show();
            });

            Livewire.on('close-size-modal', () => {
                modal.hide();
            });

            modalElement.addEventListener('hidden.bs.modal', function () {
                @this.call('closeForm'); 
            });
        }
    });
</script>
@endpush
