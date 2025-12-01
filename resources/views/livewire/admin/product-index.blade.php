<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control form-control-lg" placeholder="🔍 Buscar produtos...">
        </div>
        <div class="col-md-6 text-end">
            <button wire:click="$set('showCreateForm', true)" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Adicionar Produto
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
        @livewire('admin.product-form', ['productId' => $editingProductId], key($editingProductId ?? 'new'))
    @else
        <!-- Lista de Produtos -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Lista de Produtos</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">Imagem</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Status</th>
                                <th style="width: 200px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr wire:key="product-{{ $product->id }}">
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge bg-info">
                                                {{ $product->category->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Sem categoria</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="text-success">R$ {{ number_format($product->price, 2, ',', '.') }}</strong>
                                        @if($product->compare_at_price)
                                            <br>
                                            <small class="text-muted text-decoration-line-through">
                                                R$ {{ number_format($product->compare_at_price, 2, ',', '.') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $product->stock }} unidades
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $product->id }})" class="btn btn-sm btn-info" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button wire:click="$set('duplicatingProductId', {{ $product->id }})" class="btn btn-sm btn-secondary" title="Duplicar">
                                                <i class="bi bi-files"></i>
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-danger"
                                                wire:click="delete({{ $product->id }})"
                                                wire:confirm="Tem certeza que deseja excluir este produto?"
                                                title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                                        <p class="mt-3 mb-0">Nenhum produto encontrado.</p>
                                        @if($search)
                                            <small>Tente ajustar sua busca</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                    <div class="card-footer bg-white">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Modal de Duplicação -->
    @if($duplicatingProductId)
        @livewire('admin.product-duplicate-modal', ['productId' => $duplicatingProductId], key('duplicate-'.$duplicatingProductId))
    @endif
</div>
