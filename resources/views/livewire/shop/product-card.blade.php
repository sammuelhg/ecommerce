<div class="card product-card h-100">
    <!-- Imagem do Produto -->
    <a href="{{ route('shop.show', $product) }}" class="text-decoration-none">
        @if($product->image)
            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                 class="card-img-top" 
                 alt="{{ $product->name }}"
                 style="height: 200px; object-fit: cover;"
                 onerror="this.onerror=null;this.src='https://placehold.co/350x200/f0f8ff/1a1a1a?text=Imagem+Indispon%C3%ADvel';">
        @else
            <img src="https://placehold.co/350x200/f0f8ff/1a1a1a?text={{ urlencode($product->name) }}" 
                 class="card-img-top" 
                 alt="{{ $product->name }}"
                 style="height: 200px; object-fit: cover;">
        @endif
    </a>
    
    <div class="card-body d-flex flex-column">
        <!-- Título do Produto -->
        <a href="{{ route('shop.show', $product) }}" class="text-decoration-none">
            <h5 class="card-title fw-bold text-primary mb-0">{{ $product->name }}</h5>
        </a>
        
        <!-- Preço e Ícones na Mesma Linha -->
        <div class="d-flex justify-content-between align-items-center mt-1 mb-3">
            <!-- Preço -->
            <div>
                @if($product->is_offer && $product->old_price)
                    <span class="fw-bolder text-success fs-5">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                    <br>
                    <small class="text-muted text-decoration-line-through">R$ {{ number_format($product->old_price, 2, ',', '.') }}</small>
                @else
                    <span class="fw-bolder text-success fs-5">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                @endif
            </div>
            
            <!-- Ícones de Ação -->
            <div>
                <!-- Ícone Favoritar -->
                <button wire:click="toggleWishlist" 
                        class="btn btn-link text-decoration-none p-0 action-icon me-3 {{ $inWishlist ? 'text-danger' : 'text-secondary' }}" 
                        title="{{ $inWishlist ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}"
                        wire:loading.attr="disabled">
                    <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"></i>
                </button>
                
                <!-- Ícone Compartilhar -->
                <a href="#" 
                   class="text-secondary action-icon text-decoration-none" 
                   title="Compartilhar este item"
                   onclick="navigator.share ? navigator.share({title: '{{ $product->name }}', url: '{{ route('shop.show', $product) }}'}) : alert('Compartilhamento não suportado'); return false;">
                    <i class="bi bi-share-fill"></i>
                </a>
            </div>
        </div>
        
        <!-- Botão Adicionar ao Carrinho -->
        <button wire:click="addToCart" 
                class="btn btn-primary d-flex align-items-center justify-content-center py-2 mt-auto"
                wire:loading.attr="disabled">
            <i class="bi bi-cart-plus-fill me-2"></i>
            <span wire:loading.remove>Adicionar</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Adicionando...
            </span>
        </button>
    </div>
</div>
