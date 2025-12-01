<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control" placeholder="Buscar tipos...">
        </div>
        <div class="col-md-6 text-end">
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Tipo
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
        @livewire('admin.product-type-form', ['typeId' => $editingId], key($editingId ?? 'new'))
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tipos de Produto</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->name }}</td>
                            <td><code>{{ $type->code }}</code></td>
                            <td>
                                <span class="badge {{ $type->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $type->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <button wire:click="edit({{ $type->id }})" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button 
                                    class="btn btn-sm btn-danger"
                                    wire:click="delete({{ $type->id }})"
                                    wire:confirm="Tem certeza que deseja excluir este tipo?">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">Nenhum tipo encontrado.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $types->links() }}
            </div>
        </div>
    </div>
</div>
