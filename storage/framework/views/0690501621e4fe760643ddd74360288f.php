<div class="card product-card h-100" x-data='{ product: <?php echo json_encode($product, JSON_HEX_APOS | JSON_HEX_QUOT); ?> }'>
    <!-- Imagem do Produto -->
    <a href="<?php echo e(route('shop.show', $product->slug ?: $product->id)); ?>" class="text-decoration-none">
        <div class="ratio ratio-1x1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
                <img src="<?php echo e(Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)); ?>" 
                     class="card-img-top object-fit-cover" 
                     alt="<?php echo e($product->name); ?>"
                     onerror="this.onerror=null;this.src='https://placehold.co/500x500/f0f8ff/1a1a1a?text=Imagem+Indispon%C3%ADvel';">
            <?php else: ?>
                <img src="https://placehold.co/500x500/f0f8ff/1a1a1a?text=<?php echo e(urlencode($product->name)); ?>" 
                     class="card-img-top object-fit-cover" 
                     alt="<?php echo e($product->name); ?>">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </a>
    
    <div class="card-body d-flex flex-column">
        <!-- Título do Produto -->
        <a href="<?php echo e(route('shop.show', $product->slug ?: $product->id)); ?>" class="text-decoration-none">
            <h5 class="card-title fw-bold text-primary mb-0"><?php echo e($product->name); ?></h5>
        </a>
        
        <!-- Preço e Ícones na Mesma Linha -->
        <div class="d-flex justify-content-between align-items-center mt-1 mb-3">
            <!-- Preço -->
            <div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->is_offer && $product->old_price): ?>
                    <div>
                        <span class="fw-bolder text-success fs-5">R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></span>
                        <br>
                        <small class="text-muted text-decoration-line-through">R$ <?php echo e(number_format($product->old_price, 2, ',', '.')); ?></small>
                    </div>
                <?php else: ?>
                    <span class="fw-bolder text-success fs-5">R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        @click.prevent="navigator.share ? navigator.share({title: '<?php echo e($product->name); ?>', url: '<?php echo e(route('shop.show', $product->slug ?: $product->id)); ?>'}) : alert('Compartilhamento não suportado')">
                    <i class="bi bi-share-fill"></i>
                </button>
            </div>
        </div>
        
        <!-- Botão Adicionar ao Carrinho -->
        <button @click="$dispatch('add-to-cart', { product: product, quantity: 1 })" 
                class="btn btn-warning w-100 d-flex align-items-center justify-content-center py-2 mt-auto">
            <i class="bi bi-cart-plus-fill me-2"></i>
            <span>Adicionar</span>
        </button>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/shop/product-card.blade.php ENDPATH**/ ?>