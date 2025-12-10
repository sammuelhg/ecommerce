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

    @if($showForm)
        @livewire('admin.product-color-form', ['colorId' => $editingId], key($editingId ?? 'new'))
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Lista de Cores</h5>
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
                            <th>Cor (Hex)</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colors as $color)
                            <tr>
                                <td>{{ $color->id }}</td>
                                <td>{{ $color->name }}</td>
                                <td><code>{{ $color->code }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 24px; height: 24px; background-color: {{ $color->hex_code }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                                        <small class="text-muted">{{ $color->hex_code }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $color->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $color->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button wire:click="edit({{ $color->id }})" class="btn btn-sm btn-info text-white me-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-danger"
                                        wire:click="delete({{ $color->id }})"
                                        wire:confirm="Tem certeza que deseja excluir esta cor?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">Nenhuma cor encontrada.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @forelse($colors as $color)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $color->name }}</h6>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <code class="small">{{ $color->code }}</code>
                                    <div style="width: 16px; height: 16px; background-color: {{ $color->hex_code }}; border: 1px solid #ddd; border-radius: 50%;"></div>
                                </div>
                            </div>
                            <span class="badge {{ $color->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $color->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-2">
                            <button wire:click="edit({{ $color->id }})" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button 
                                class="btn btn-sm btn-outline-danger"
                                wire:click="delete({{ $color->id }})"
                                wire:confirm="Tem certeza que deseja excluir esta cor?">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Nenhuma cor encontrada.</p>
                    </div>
                @endforelse
            </div>

            <div class="p-3 border-top">
                {{ $colors->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
