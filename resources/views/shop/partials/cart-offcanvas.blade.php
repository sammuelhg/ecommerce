<?php

/**
 * Cart Offcanvas Blade Partial
 * Utiliza Alpine.js (state já está no layout)
 */
?>
<!-- Offcanvas Carrinho -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header bg-primary text-white border-bottom">
        <h5 class="offcanvas-title fw-bold">
            <i class="bi bi-cart4 me-2"></i> Seu Carrinho (<span x-text="cartTotalItems"></span>)
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column overflow-hidden">
        <!-- Estado Vazio -->
        <div x-show="cart.length === 0" class="p-5 text-center text-muted flex-grow-1">
            <i class="bi bi-cart-x fs-1 mb-3"></i>
            <p class="mb-0 fw-bold">Seu carrinho está vazio.</p>
        </div>

        <!-- Lista de Produtos -->
        <div class="list-group flex-grow-1 overflow-y-auto pb-3" x-show="cart.length > 0">
            <template x-for="item in cart" :key="item.id">
                <div class="list-group-item list-group-item-action p-3 border-bottom">
                    <!-- Row 1: Product Name (Full Width) -->
                    <div class="mb-2">
                        <a :href="`/loja/produto/${item.slug || item.id}`" class="text-decoration-none text-dark">
                            <h6 class="mb-0 text-wrap text-break lh-sm" x-text="item.name"></h6>
                        </a>
                        <!-- Subtitle removed to duplicate info -->
                    </div>

                    <!-- Row 2: Image, Qty, Price, Remove -->
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- Left: Image -->
                        <a :href="`/loja/produto/${item.slug || item.id}`" class="flex-shrink-0 me-3">
                            <img :src="item.image 
                                    ? (item.image.startsWith('http') ? item.image : `/storage/${item.image}`) 
                                    : `https://placehold.co/60x60/f0f8ff/1a1a1a?text=${encodeURIComponent(item.name?.substring(0,10) || 'Produto')}`"
                                 class="rounded" 
                                 style="width: 50px; height: 50px; object-fit: cover;"
                                 :alt="item.name"
                                 x-on:error="$el.src = 'https://placehold.co/60x60/f0f8ff/1a1a1a?text=Imagem'">
                        </a>

                        <!-- Center: Quantity Selector (Primary + Rounded) -->
                        <div class="input-group input-group-sm flex-nowrap me-3 rounded overflow-hidden border" style="width: 90px;">
                            <button class="btn btn-dark px-2 border-0 rounded-0" type="button" 
                                    @click="item.qty > 1 ? item.qty-- : null; updateQty(item)">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="text" class="form-control text-center px-1 border-0 bg-white" x-model="item.qty" readonly style="min-width: 0;">
                            <button class="btn btn-dark px-2 border-0 rounded-0" type="button" 
                                    @click="item.qty++; updateQty(item)">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>

                        <!-- Center-Right: Price -->
                        <div class="flex-grow-1 text-end me-3">
                            <span class="fw-bold text-dark" x-text="formatCurrency(item.price)"></span>
                        </div>

                        <!-- Right: Delete Button -->
                        <button class="btn btn-outline-danger btn-sm rounded flex-shrink-0" 
                                @click.prevent="removeFromCart(item.id)"
                                title="Remover">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Subtotal e Total -->
        <div class="mt-auto pt-3 border-top" x-show="cart.length > 0">
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span class="fw-bold" x-text="formatCurrency(cartSubtotal)"></span>
            </div>
            <div class="d-flex justify-content-between fs-5 fw-bold text-primary border-top pt-2">
                <span>Total:</span>
                <span x-text="formatCurrency(cartSubtotal)"></span>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-3" x-show="cart.length > 0">
        <button @click="finalizePurchase()" class="btn btn-primary w-100 fw-semibold">Finalizar Compra</button>
    </div>
</div>
