<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control bg-white" placeholder="Buscar categorias...">
        </div>
        <div class="col-md-6 text-end">
            <button wire:click="$set('showCreateForm', true)" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Categoria
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($showCreateForm)
        @livewire('admin.category-form', ['categoryId' => $editingCategoryId], key($editingCategoryId ?? 'new'))
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Lista de Categorias</h5>
        </div>
        <div class="card-body">
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $category->products_count }} produtos
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $category->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <button wire:click="edit({{ $category->id }})" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button 
                                    class="btn btn-sm btn-danger"
                                    wire:click="delete({{ $category->id }})"
                                    wire:confirm="Tem certeza que deseja excluir esta categoria? Os produtos associados ficarão sem categoria.">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">Nenhuma categoria encontrada.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
