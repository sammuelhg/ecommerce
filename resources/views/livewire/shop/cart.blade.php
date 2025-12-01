<div class="h-100 d-flex flex-column">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-primary fw-bold">
            <i class="bi bi-cart-fill me-2"></i> Meu Carrinho
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        @if(count($cartItems) > 0)
            <div class="list-group list-group-flush">
                @foreach($cartItems as $item)
                    <div class="list-group-item px-0 py-3 border-bottom" wire:key="cart-item-{{ $item['id'] }}">
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
                                <div class="d-flex align-items-center" style="width: 120px;">
                                    <button wire:click="updateQty({{ $item['id'] }}, {{ $item['qty'] - 1 }})" class="btn btn-sm btn-outline-secondary" {{ $item['qty'] <= 1 ? 'disabled' : '' }} wire:loading.attr="disabled">-</button>
                                    <input type="text" class="form-control form-control-sm text-center mx-1" value="{{ $item['qty'] }}" readonly>
                                    <button wire:click="updateQty({{ $item['id'] }}, {{ $item['qty'] + 1 }})" class="btn btn-sm btn-outline-secondary" wire:loading.attr="disabled">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">Seu carrinho está vazio</h5>
                <p class="text-muted small">Navegue pela loja e adicione produtos.</p>
                <button class="btn btn-primary mt-3" data-bs-dismiss="offcanvas">
                    Começar a Comprar
                </button>
            </div>
        @endif
    </div>

    @if(count($cartItems) > 0)
        <div class="offcanvas-footer border-top p-3 bg-light">
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Subtotal:</span>
                <span class="fw-bold text-primary fs-5">R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>
            <div class="d-grid gap-2">
                <a href="#" class="btn btn-primary">
                    Finalizar Compra <i class="bi bi-arrow-right ms-1"></i>
                </a>
                <button class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Continuar Comprando
                </button>
            </div>
        </div>
    @endif
</div>
