<div class="h-100 d-flex flex-column">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-danger fw-bold">
            <i class="bi bi-heart-fill me-2"></i> Lista de Desejos
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        @if(count($wishlistItems) > 0)
            <div class="list-group list-group-flush">
                @foreach($wishlistItems as $item)
                    <div class="list-group-item px-0 py-3 border-bottom" wire:key="wishlist-item-{{ $item['id'] }}">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <img src="https://placehold.co/80x80/2c3e50/ffffff?text={{ $item['image'] ?? 'Prod' }}" 
                                     class="img-fluid rounded" alt="{{ $item['name'] }}" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 line-clamp-2">{{ $item['name'] }}</h6>
                                    <button wire:click="removeItem({{ $item['id'] }})" class="btn btn-link text-danger p-0 ms-2" wire:loading.attr="disabled">
                                        <i class="bi bi-trash" wire:loading.remove wire:target="removeItem({{ $item['id'] }})"></i>
                                        <span class="spinner-border spinner-border-sm" wire:loading wire:target="removeItem({{ $item['id'] }})"></span>
                                    </button>
                                </div>
                                <p class="text-primary fw-bold mb-2">R$ {{ number_format($item['price'], 2, ',', '.') }}</p>
                                <button wire:click="moveToCart({{ $item['id'] }})" class="btn btn-sm btn-outline-primary w-100" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="moveToCart({{ $item['id'] }})">
                                        <i class="bi bi-cart-plus me-1"></i> Mover p/ Carrinho
                                    </span>
                                    <span wire:loading wire:target="moveToCart({{ $item['id'] }})">
                                        <span class="spinner-border spinner-border-sm me-1"></span> Movendo...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">Sua lista está vazia</h5>
                <p class="text-muted small">Salve seus itens favoritos para ver depois.</p>
                <button class="btn btn-outline-danger mt-3" data-bs-dismiss="offcanvas">
                    Explorar Produtos
                </button>
            </div>
        @endif
    </div>
</div>
