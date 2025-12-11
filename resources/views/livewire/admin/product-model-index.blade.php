<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control bg-white" placeholder="Buscar modelos...">
        </div>
        <div class="col-md-6 text-end">
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Modelo
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
            <h5 class="mb-0 fw-bold">Modelos de Produto</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
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
                        @forelse($models as $model)
                            <tr>
                                <td class="ps-4">{{ $model->id }}</td>
                                <td class="fw-bold">{{ $model->name }}</td>
                                <td><code class="text-muted">{{ $model->code }}</code></td>
                                <td>
                                    <span class="badge {{ $model->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $model->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $model->id }})" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-outline-danger"
                                        wire:click="delete({{ $model->id }})"
                                        wire:confirm="Tem certeza que deseja excluir este modelo?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-secondary"></i>
                                    <p class="mb-0">Nenhum modelo encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-top">
                {{ $models->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modelModal" tabindex="-1" aria-labelledby="modelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelModalLabel">
                        {{ $editingId ? 'Editar Modelo' : 'Novo Modelo' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($showForm)
                        @livewire('admin.product-model-form', ['modelId' => $editingId], key($editingId ?? 'new'))
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
        const modalId = 'modelModal';
        const modalElement = document.getElementById(modalId);
        
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            
            Livewire.on('open-model-modal', () => {
                modal.show();
            });

            Livewire.on('close-model-modal', () => {
                modal.hide();
            });

            modalElement.addEventListener('hidden.bs.modal', function () {
                @this.call('closeForm'); 
            });
        }
    });
</script>
@endpush
