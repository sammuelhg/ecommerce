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

    @if($showForm)
        @livewire('admin.product-model-form', ['modelId' => $editingId], key($editingId ?? 'new'))
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Modelos de Produto</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->name }}</td>
                            <td><code>{{ $model->code }}</code></td>
                            <td>
                                <span class="badge {{ $model->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $model->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <button wire:click="edit({{ $model->id }})" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button 
                                    class="btn btn-sm btn-danger"
                                    wire:click="delete({{ $model->id }})"
                                    wire:confirm="Tem certeza que deseja excluir este modelo?">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">Nenhum modelo encontrado.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $models->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
