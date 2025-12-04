<div class="card product-card h-100" x-data='{ product: {!! json_encode($product, JSON_HEX_APOS | JSON_HEX_QUOT) !!} }'>
    <!-- Imagem do Produto -->
    <a href="{{ route('shop.show', $product->slug ?: $product->id) }}" class="text-decoration-none">
        <div class="ratio ratio-1x1">
            @if($product->image)
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                     class="card-img-top object-fit-cover" 
                     alt="{{ $product->name }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/500x500/f0f8ff/1a1a1a?text=Imagem+Indispon%C3%ADvel';">
            @else
                <img src="https://placehold.co/500x500/f0f8ff/1a1a1a?text={{ urlencode($product->name) }}" 
                     class="card-img-top object-fit-cover" 
                     alt="{{ $product->name }}">
            @endif
        </div>
    </a>
    
    <div class="card-body d-flex flex-column">
        <!-- Título do Produto -->
        <a href="{{ route('shop.show', $product->slug ?: $product->id) }}" class="text-decoration-none">
            <h5 class="card-title fw-bold text-primary mb-0">{{ $product->name }}</h5>
        </a>
        
        <!-- Preço e Ícones na Mesma Linha -->
        <div class="d-flex justify-content-between align-items-center mt-1 mb-3">
            <!-- Preço -->
            <div>
                @if($product->is_offer && $product->old_price)
                    <div>
                        <span class="fw-bolder text-success fs-5">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                        <br>
                        <small class="text-muted text-decoration-line-through">R$ {{ number_format($product->old_price, 2, ',', '.') }}</small>
                    </div>
                @else
                    <span class="fw-bolder text-success fs-5">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                @endif
            </div>
            
            <!-- Ícones de Ação -->
            <div>
                <!-- Ícone Favoritar -->
                <button @click="$dispatch('toggle-wishlist', product)" 
                        class="btn btn-link text-decoration-none p-0 action-icon me-3" 
                        :class="isInWishlist(product.id) ? 'text-danger' : 'text-secondary'"
                        title="Adicionar aos Favoritos">
                    <i class="bi" :class="isInWishlist(product.id) ? 'bi-heart-fill' : 'bi-heart'"></i>
                </button>
                
                <!-- Ícone Compartilhar -->
                <a href="#" 
                   class="text-secondary action-icon text-decoration-none" 
                   title="Compartilhar este item"
                   @click.prevent="navigator.share ? navigator.share({title: '{{ $product->name }}', url: '{{ route('shop.show', $product->slug ?: $product->id) }}'}) : alert('Compartilhamento não suportado')">
                    <i class="bi bi-share-fill"></i>
                </a>
            </div>
        </div>
        
        <!-- Botão Adicionar ao Carrinho -->
        <button @click="$dispatch('add-to-cart', { product: product, quantity: 1 })" 
                class="btn btn-primary d-flex align-items-center justify-content-center py-2 mt-auto">
            <i class="bi bi-cart-plus-fill me-2"></i>
            <span>Adicionar</span>
        </button>
    </div>
</div>
