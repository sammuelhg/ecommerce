<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control bg-white" placeholder="Buscar cores...">
        </div>
        <div class="col-md-6 text-end mt-3 mt-md-0">
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Cor
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
            <h5 class="mb-0 fw-bold">Lista de Cores</h5>
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
                            <th>Cor (Hex)</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colors as $color)
                            <tr>
                                <td class="ps-4">{{ $color->id }}</td>
                                <td class="fw-bold">{{ $color->name }}</td>
                                <td><code class="text-muted">{{ $color->code }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="shadow-sm" style="width: 24px; height: 24px; background-color: {{ $color->hex_code }}; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;"></div>
                                        <small class="text-muted font-monospace">{{ $color->hex_code }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $color->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $color->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $color->id }})" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-outline-danger"
                                        wire:click="delete({{ $color->id }})"
                                        wire:confirm="Tem certeza que deseja excluir esta cor?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox display-4 d-block mb-3 text-secondary"></i>
                                    <p class="mb-0">Nenhuma cor encontrada.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @forelse($colors as $color)
                    <div class="p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1 fw-bold fs-5">{{ $color->name }}</h6>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <code class="text-muted">{{ $color->code }}</code>
                                    <div style="width: 20px; height: 20px; background-color: {{ $color->hex_code }}; border: 1px solid rgba(0,0,0,0.1); border-radius: 50%;"></div>
                                </div>
                            </div>
                            <span class="badge {{ $color->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $color->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button wire:click="edit({{ $color->id }})" class="btn btn-outline-primary btn-sm px-3">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </button>
                            <button 
                                class="btn btn-outline-danger btn-sm px-3"
                                wire:click="delete({{ $color->id }})"
                                wire:confirm="Tem certeza que deseja excluir esta cor?">
                                <i class="bi bi-trash me-1"></i> Excluir
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox display-1 text-secondary mb-3"></i>
                        <p class="mb-0">Nenhuma cor encontrada.</p>
                    </div>
                @endforelse
            </div>

            <div class="p-4 border-top">
                {{ $colors->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="colorModalLabel">
                        {{ $editingId ? 'Editar Cor' : 'Nova Cor' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($showForm)
                        @livewire('admin.product-color-form', ['colorId' => $editingId], key($editingId ?? 'new'))
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
        const modalId = 'colorModal';
        const modalElement = document.getElementById(modalId);
        
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            
            Livewire.on('open-color-modal', () => {
                modal.show();
            });

            Livewire.on('close-color-modal', () => {
                modal.hide();
            });

            modalElement.addEventListener('hidden.bs.modal', function () {
                @this.call('closeForm'); 
            });
        }
    });
</script>
@endpush
```
