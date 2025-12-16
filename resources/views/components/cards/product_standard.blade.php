@props(['product'])

<div class="card product-card h-100" x-data='{ 
    product: { 
        id: {{ $product->id }}, 
        name: "{{ addslashes($product->name) }}", 
        slug: "{{ $product->slug ?: $product->id }}",
        price: {{ $product->price }}, 
        old_price: {{ $product->old_price ?? "null" }},
        is_offer: {{ $product->is_offer ? "true" : "false" }},
        image: "{{ $product->image ? (Str::startsWith($product->image, "http") ? $product->image : asset("storage/" . $product->image)) : "" }}"
    } 
}'>
    <!-- Imagem do Produto -->
    <a href="{{ route('shop.show', $product->slug ?: $product->id) }}" class="text-decoration-none">
        <div class="ratio ratio-1x1">
            @if($product->image)
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                     srcset="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }} 1x, {{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }} 2x"
                     sizes="(max-width: 576px) 100vw, (max-width: 768px) 50vw, (max-width: 1200px) 33vw, 25vw"
                     width="500" height="500"
                     loading="lazy"
                     class="card-img-top object-fit-cover" 
                     alt="{{ $product->name }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/500x500/f0f8ff/1a1a1a?text=Imagem+Indispon%C3%ADvel';">
            @else
                <img src="https://placehold.co/500x500/f0f8ff/1a1a1a?text={{ urlencode($product->name) }}" 
                     width="500" height="500"
                     loading="lazy"
                     class="card-img-top object-fit-cover" 
                     alt="{{ $product->name }}">
            @endif
        </div>
    </a>
    
    <div class="card-body d-flex flex-column">
        <!-- Título do Produto -->
        <!-- Título do Produto -->
        <a href="{{ route('shop.show', $product->slug ?: $product->id) }}" class="card-title fw-bold text-decoration-none h3 mb-1 position-relative" style="color: #000000; line-height: 1.3;">
            {{ $product->name }}
        </a>
        
        <!-- Preço e Ícones na Mesma Linha -->
        <div class="d-flex flex-column mt-1 mb-2">
            <!-- Preço -->
            <div>
                @if($product->is_offer && $product->old_price)
                    <div>
                         <small class="text-muted text-decoration-line-through d-block" style="font-size: 0.75rem; line-height: 1;">R$ {{ number_format($product->old_price, 2, ',', '.') }}</small>
                         <div class="d-flex align-items-baseline gap-1">
                            <span class="fw-normal text-dark" style="font-size: 1.2rem;">R$ {{ number_format(floor($product->price), 0, ',', '.') }}<sup style="font-size: 0.75rem;">,{{ substr(number_format($product->price, 2, '', ''), -2) }}</sup></span>
                            <span class="text-danger fw-bold" style="font-size: 0.75rem;">{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}% OFF</span>
                         </div>
                    </div>
                @else
                    <span class="fw-normal text-dark" style="font-size: 1.2rem;">R$ {{ number_format(floor($product->price), 0, ',', '.') }}<sup style="font-size: 0.75rem;">,{{ substr(number_format($product->price, 2, '', ''), -2) }}</sup></span>
                @endif
                
                <div class="text-success small fw-medium" style="font-size: 0.75rem;">
                    10x R$ {{ number_format($product->price/10, 2, ',', '.') }} sem juros
                </div>
            </div>
        </div>
            
            <!-- Ícones de Ação -->
            <div>
                <!-- Ícone Favoritar -->
                <button @click="$dispatch('toggle-wishlist', product)" 
                        class="btn btn-warning btn-icon-shape btn-sm rounded-circle d-flex align-items-center justify-content-center me-2" 
                        :class="isInWishlist(product.id) ? 'text-danger' : 'text-dark'"
                        title="Adicionar aos Favoritos">
                    <i class="bi" :class="isInWishlist(product.id) ? 'bi-heart-fill' : 'bi-heart'"></i>
                </button>
                
                <!-- Ícone Compartilhar -->
                <button class="btn btn-warning btn-icon-shape btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                        title="Compartilhar este item"
                        @click.prevent="navigator.share ? navigator.share({title: '{{ $product->name }}', url: '{{ route('shop.show', $product->slug ?: $product->id) }}'}) : alert('Compartilhamento não suportado')">
                    <i class="bi bi-share-fill"></i>
                </button>
            </div>
        </div>
        
        <!-- Botão Adicionar ao Carrinho -->
        <button @click="$dispatch('add-to-cart', { product: product, quantity: 1 })" 
                class="btn btn-warning w-100 btn-sm d-flex align-items-center justify-content-center mt-auto" style="padding-top: 0.4rem; padding-bottom: 0.4rem;">
            <i class="bi bi-cart-plus-fill me-2"></i>
            <span>Adicionar</span>
        </button>
    </div>
</div>
