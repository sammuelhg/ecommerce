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
                            {{-- Imagem --}}
                            <div class="flex-shrink-0">
                                @php
                                    $imgSrc = $item['image'] ?? null;
                                    if ($imgSrc && !str_starts_with($imgSrc, 'http')) {
                                        $imgSrc = asset('storage/' . $imgSrc);
                                    }
                                @endphp
                                <img src="{{ $imgSrc ?? 'https://placehold.co/80x80/2c3e50/ffffff?text=No+Img' }}" 
                                     class="img-fluid rounded object-fit-cover" 
                                     alt="{{ $item['name'] }}" 
                                     style="width: 80px; height: 80px;">
                            </div>
                            
                            {{-- Conteúdo --}}
                            <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="mb-1 line-clamp-2" style="font-size: 0.95rem;">{{ $item['name'] }}</h6>
                                </div>
                                
                                <div class="d-flex gap-2 mt-2 align-items-center">
                                    {{-- Botão Adicionar --}}
                                    <button wire:click="moveToCart({{ $item['id'] }})" 
                                            class="btn btn-warning flex-grow-1 d-flex align-items-center justify-content-center gap-2 text-dark fw-bold" 
                                            style="font-size: 0.9rem;"
                                            wire:loading.attr="disabled">
                                        <i class="bi bi-cart-plus-fill"></i> 
                                        <span>Adicionar</span>
                                    </button>

                                    {{-- Botão Remover --}}
                                    <button wire:click="removeItem({{ $item['id'] }})" 
                                            class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px;"
                                            title="Remover"
                                            wire:loading.attr="disabled">
                                        <i class="bi bi-trash" wire:loading.remove wire:target="removeItem({{ $item['id'] }})"></i>
                                        <span class="spinner-border spinner-border-sm" wire:loading wire:target="removeItem({{ $item['id'] }})"></span>
                                    </button>
                                </div>
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
