<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control bg-white" placeholder="Buscar sabores...">
        </div>
        <div class="col-md-6 text-end mt-3 mt-md-0">
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Sabor
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
            <h5 class="mb-0 fw-bold">Lista de Sabores</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Cor Representativa</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($flavors as $flavor)
                            <tr>
                                <td class="ps-4">{{ $flavor->id }}</td>
                                <td class="fw-bold">{{ $flavor->name }}</td>
                                <td><code class="text-muted">{{ $flavor->slug }}</code></td>
                                <td>
                                    @if($flavor->hex_code)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="shadow-sm" style="width: 24px; height: 24px; background-color: {{ $flavor->hex_code }}; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;"></div>
                                            <small class="text-muted font-monospace">{{ $flavor->hex_code }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">Nenhuma cor definida</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $flavor->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $flavor->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $flavor->id }})" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-outline-danger"
                                        wire:click="delete({{ $flavor->id }})"
                                        wire:confirm="Tem certeza que deseja excluir este sabor?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-secondary"></i>
                                    <p class="mb-0">Nenhum sabor encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-top">
                {{ $flavors->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="flavorModal" tabindex="-1" aria-labelledby="flavorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="flavorModalLabel">
                        {{ $editingId ? 'Editar Sabor' : 'Novo Sabor' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($showForm)
                        @livewire('admin.flavor-form', ['flavorId' => $editingId], key($editingId ?? 'new'))
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
        const modalId = 'flavorModal';
        const modalElement = document.getElementById(modalId);
        
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            
            Livewire.on('open-flavor-modal', () => {
                modal.show();
            });

            Livewire.on('close-flavor-modal', () => {
                modal.hide();
            });

            modalElement.addEventListener('hidden.bs.modal', function () {
                @this.call('closeForm'); 
            });
        }
    });
</script>
@endpush
