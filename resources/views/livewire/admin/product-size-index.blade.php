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

    @if($showForm)
        @livewire('admin.product-size-form', ['sizeId' => $editingId], key($editingId ?? 'new'))
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Lista de Tamanhos</h5>
        </div>
        <div class="card-body p-0">
            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sizes as $size)
                            <tr>
                                <td>{{ $size->id }}</td>
                                <td>{{ $size->name }}</td>
                                <td><code>{{ $size->code }}</code></td>
                                <td>
                                    <span class="badge {{ $size->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $size->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button wire:click="edit({{ $size->id }})" class="btn btn-sm btn-info text-white me-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-danger"
                                        wire:click="delete({{ $size->id }})"
                                        wire:confirm="Tem certeza que deseja excluir este tamanho?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">Nenhum tamanho encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @forelse($sizes as $size)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $size->name }}</h6>
                                <code class="small">{{ $size->code }}</code>
                            </div>
                            <span class="badge {{ $size->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $size->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-2">
                            <button wire:click="edit({{ $size->id }})" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button 
                                class="btn btn-sm btn-outline-danger"
                                wire:click="delete({{ $size->id }})"
                                wire:confirm="Tem certeza que deseja excluir este tamanho?">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Nenhum tamanho encontrado.</p>
                    </div>
                @endforelse
            </div>

            <div class="p-3 border-top">
                {{ $sizes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
