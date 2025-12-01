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
    <div class="offcanvas-body d-flex flex-column">
        <!-- Estado Vazio -->
        <div x-show="cart.length === 0" class="p-5 text-center text-muted flex-grow-1">
            <i class="bi bi-cart-x fs-1 mb-3"></i>
            <p class="mb-0 fw-bold">Seu carrinho está vazio.</p>
        </div>

        <!-- Lista de Produtos -->
        <div class="list-group list-group-flush flex-grow-1 overflow-y-auto" x-show="cart.length > 0">
            <template x-for="item in cart" :key="item.id">
                <div class="list-group-item d-flex p-3 align-items-start">
                    <img :src="`https://placehold.co/80x80/2c3e50/ffffff?text=${item.imageText}`"
                         class="rounded me-3 flex-shrink-0" style="width: 80px; height: 80px;">
                    <div class="flex-grow-1 overflow-hidden me-2">
                        <p class="mb-1 fw-bold text-dark line-clamp-2" x-text="item.name"></p>
                        <small class="text-muted d-block">Preço: <span x-text="formatCurrency(item.price)"></span></small>
                        <small class="text-primary fw-semibold d-block">Total: <span x-text="formatCurrency(item.price * item.qty)"></span></small>
                    </div>
                    <div class="ms-auto d-flex flex-column align-items-end">
                        <input type="number" class="form-control form-control-sm text-center mb-2"
                               x-model.number="item.qty" @change="updateQty(item)" min="1" style="width: 60px;">
                        <button class="btn btn-sm btn-outline-danger" @click="removeFromCart(item.id)">
                            <i class="bi bi-trash"></i>
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
        <a href="#" class="btn btn-primary w-100 fw-semibold">Finalizar Compra</a>
    </div>
</div>
