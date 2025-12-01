<div class="d-flex gap-3 align-items-stretch">
    <!-- Seletor de Quantidade -->
    <div class="input-group" style="width: 140px;">
        <button class="btn btn-outline-secondary" type="button" wire:click="decrement">
            <i class="bi bi-dash"></i>
        </button>
        <input type="number" class="form-control text-center border-secondary" 
               wire:model.live="quantity" min="1" max="{{ $product->stock }}" readonly 
               style="appearance: textfield;">
        <button class="btn btn-outline-secondary" type="button" wire:click="increment">
            <i class="bi bi-plus"></i>
        </button>
    </div>

    <!-- Botões de Ação -->
    <div class="flex-grow-1 d-flex gap-2">
        <button wire:click="addToCart" 
                class="btn btn-primary flex-grow-1 d-flex align-items-center justify-content-center py-2"
                wire:loading.attr="disabled"
                wire:target="addToCart">
            <i class="bi bi-cart-plus-fill me-2"></i>
            <span wire:loading.remove wire:target="addToCart">Adicionar ao Carrinho</span>
            <span wire:loading wire:target="addToCart">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Adicionando...
            </span>
        </button>
        
        <button wire:click="toggleWishlist" 
                class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-3"
                title="{{ $inWishlist ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}"
                wire:loading.attr="disabled"
                wire:target="toggleWishlist">
            <i class="bi bi-heart{{ $inWishlist ? '-fill text-danger' : '' }} fs-5"></i>
        </button>
    </div>
</div>
