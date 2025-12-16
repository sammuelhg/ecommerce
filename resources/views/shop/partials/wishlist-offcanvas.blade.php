<!-- Offcanvas Wishlist -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasWishlist">
    <div class="offcanvas-header bg-primary text-white border-bottom">
        <h5 class="offcanvas-title fw-bold">
            <i class="bi bi-heart-fill me-2"></i> Sua Lista de Desejos
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <!-- Estado Vazio -->
        <div x-show="wishlist.length === 0">
            <div class="p-5 text-center text-muted">
                <i class="bi bi-heart-break fs-1 mb-3"></i>
                <p class="mb-0 fw-bold">Sua lista de desejos está vazia.</p>
                <small>Adicione produtos para acompanhá-los!</small>
            </div>
            
            <!-- Ofertas Sugeridas -->
            <div class="p-3 border-top" x-show="offerProducts.length > 0">
                <h6 class="text-danger fw-bold mb-3">Ofertas que Você Pode Gostar:</h6>
                <div class="list-group list-group-flush">
                    <template x-for="product in offerProducts.slice(0, 3)" :key="product.id">
                        <div class="list-group-item d-flex align-items-center p-2 bg-light rounded-3 mb-2">
                            <img :src="product.image 
                                    ? (product.image.startsWith('http') ? product.image : `/storage/${product.image}`) 
                                    : `https://placehold.co/60x60/3498db/ffffff?text=${encodeURIComponent(product.name?.substring(0,10) || 'Oferta')}`" 
                                 class="rounded me-2 flex-shrink-0" 
                                 style="width: 60px; height: 60px; object-fit: cover;"
                                 :alt="product.name"
                                 x-on:error="$el.src = 'https://placehold.co/60x60/3498db/ffffff?text=Imagem'">
                            <div class="flex-grow-1 me-2 overflow-hidden"> 
                                <p class="mb-0 small fw-bold text-dark line-clamp-2" x-text="product.name"></p>
                                <span class="text-danger fw-semibold small" x-text="formatCurrency(product.price)"></span>
                            </div>
                            <button class="btn btn-sm btn-outline-danger" @click="toggleWishlist(product)" title="Adicionar">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Lista de Favoritos -->
        <div class="list-group list-group-flush" x-show="wishlist.length > 0">
            <template x-for="item in wishlist" :key="item.id">
                <div class="list-group-item p-3 border-bottom">
                    <div class="d-flex gap-3">
                        <!-- Imagem -->
                        <div class="flex-shrink-0">
                            <img :src="item.image 
                                    ? (item.image.startsWith('http') ? item.image : `/storage/${item.image}`) 
                                    : `https://placehold.co/80x80/CCCCCC/333333?text=${encodeURIComponent(item.name?.substring(0,10) || 'Produto')}`" 
                                 class="rounded object-fit-cover" 
                                 style="width: 80px; height: 80px;"
                                 :alt="item.name"
                                 x-on:error="$el.src = 'https://placehold.co/80x80/CCCCCC/333333?text=Imagem'">
                        </div>

                        <!-- Conteúdo -->
                        <div class="flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <p class="mb-1 fw-bold text-dark line-clamp-2" x-text="item.name" :title="item.name"></p>
                                <p class="mb-0 text-muted small" x-text="formatCurrency(item.price)"></p>
                            </div>
                            
                            <div class="d-flex gap-2 mt-2 align-items-center">
                                <!-- Botão Adicionar -->
                                <button class="btn btn-warning flex-grow-1 d-flex align-items-center justify-content-center gap-2 text-dark fw-bold" 
                                        @click="addToCart(item)"
                                        title="Adicionar ao Carrinho">
                                    <i class="bi bi-cart-plus-fill"></i>
                                    <span>Adicionar</span>
                                </button>
                                
                                <!-- Botão Remover -->
                                <button class="btn btn-outline-danger d-flex align-items-center justify-content-center px-0" 
                                        style="width: 38px; height: 38px;"
                                        @click="toggleWishlist(item)" 
                                        title="Remover">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-3 text-center" x-show="wishlist.length > 0">
        <!-- Button removed as requested -->
    </div>
</div>
