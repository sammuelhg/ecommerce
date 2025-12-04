<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control form-control-lg bg-white" placeholder="🔍 Buscar produtos...">
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Adicionar Produto
            </a>
        </div>
    </div>

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
                                    @php
                                        $mainImage = $product->images->where('is_main', true)->first() 
                                                    ?? $product->images->first();
                                        $imageUrl = $mainImage ? asset('storage/' . $mainImage->path) 
                                                    : ($product->image ? asset('storage/' . $product->image) : null);
                                    @endphp

                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" 
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
                                    <span class="badge {{ $product->stock_quantity > 10 ? 'bg-success' : ($product->stock_quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $product->stock_quantity }} unidades
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-info" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button wire:click="openImageGenerator({{ $product->id }})" 
                                                class="btn btn-sm btn-success" 
                                                title="Gerar Imagem com IA">
                                            <i class="bi bi-image"></i>
                                        </button>
                                        <button wire:click="$set('duplicatingProductId', {{ $product->id }})" class="btn btn-sm btn-secondary" title="Duplicar">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button 
                                            class="btn btn-sm btn-danger"
                                            wire:click="delete({{ $product->id }})"
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
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Duplicação -->
    @if($duplicatingProductId)
        @livewire('admin.product-duplicate-modal', ['productId' => $duplicatingProductId], key('duplicate-'.$duplicatingProductId))
    @endif

    <!-- Modal de Geração de Imagem com IA -->
    @if($generatingImageForProductId)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-image me-2"></i>
                            Gerar Imagem com IA
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="cancelImageGeneration"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Preview do Prompt:</strong> Este é o texto que será enviado para a IA gerar a imagem do produto.
                        </div>
                        
                        <div class="card bg-light">
                            <div class="card-body p-0">
                                <textarea 
                                    wire:model="editablePrompt" 
                                    class="form-control border-0 bg-light" 
                                    rows="6" 
                                    style="font-family: 'Courier New', monospace; font-size: 0.9rem; resize: vertical;"
                                ></textarea>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="bi bi-clock me-2"></i>
                            <small>A geração pode levar de 30 a 60 segundos. Você será redirecionado para a galeria do produto após a conclusão.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelImageGeneration">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <button type="button" 
                                class="btn btn-success" 
                                wire:click="generateImage({{ $generatingImageForProductId }})"
                                wire:loading.attr="disabled"
                                wire:target="generateImage">
                            <i class="bi bi-stars me-2" wire:loading.remove wire:target="generateImage"></i>
                            <span wire:loading wire:target="generateImage" class="spinner-border spinner-border-sm me-2"></span>
                            <span wire:loading.remove wire:target="generateImage">Gerar Imagem</span>
                            <span wire:loading wire:target="generateImage">Gerando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
