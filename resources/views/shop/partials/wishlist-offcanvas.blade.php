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
                <div class="list-group-item d-flex align-items-center p-3">
                    <img :src="item.image 
                            ? (item.image.startsWith('http') ? item.image : `/storage/${item.image}`) 
                            : `https://placehold.co/80x80/CCCCCC/333333?text=${encodeURIComponent(item.name?.substring(0,10) || 'Produto')}`" 
                         class="rounded me-3 flex-shrink-0" 
                         style="width: 80px; height: 80px; object-fit: cover;"
                         :alt="item.name"
                         x-on:error="$el.src = 'https://placehold.co/80x80/CCCCCC/333333?text=Imagem'">
                    
                    <div class="flex-grow-1 me-2 overflow-hidden"> 
                        <p class="mb-1 fw-bold text-dark line-clamp-2" x-text="item.name" :title="item.name"></p>
                        <p class="mb-0 text-primary fw-semibold" x-text="formatCurrency(item.price)"></p>
                    </div>
                    
                    <div class="ms-auto d-flex flex-column align-items-end flex-shrink-0">
                        <button class="btn btn-sm btn-outline-danger mb-1" @click="toggleWishlist(item)" title="Remover">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-primary" @click="addToCart(item)" title="Adicionar ao Carrinho">
                            <i class="bi bi-bag-plus"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-3 text-center" x-show="wishlist.length > 0">
        <a href="#" class="btn btn-primary w-100 fw-semibold">Ver Todos os Itens</a>
    </div>
</div>
