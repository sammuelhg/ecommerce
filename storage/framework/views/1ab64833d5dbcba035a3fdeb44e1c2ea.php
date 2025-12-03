<div class="d-flex gap-3 align-items-stretch" 
     x-data="{ 
         quantity: 1, 
         maxStock: <?php echo e($product->stock); ?>,
         product: {
             id: <?php echo e($product->id); ?>,
             name: '<?php echo e(addslashes($product->name)); ?>',
             price: <?php echo e($product->price); ?>,
             image: '<?php echo e($product->image); ?>',
             slug: '<?php echo e($product->slug); ?>'
         }
     }">
    <!-- Seletor de Quantidade -->
    <div class="input-group" style="width: 140px;">
        <button class="btn btn-outline-secondary" type="button" @click="quantity = Math.max(1, quantity - 1)">
            <i class="bi bi-dash"></i>
        </button>
        <input type="number" class="form-control text-center border-secondary" 
               x-model="quantity" min="1" :max="maxStock" readonly 
               style="appearance: textfield;">
        <button class="btn btn-outline-secondary" type="button" @click="quantity = Math.min(maxStock, quantity + 1)">
            <i class="bi bi-plus"></i>
        </button>
    </div>

    <!-- Botões de Ação -->
    <div class="flex-grow-1 d-flex gap-2">
        <button @click="$dispatch('add-to-cart', { product: product, quantity: quantity }); 
                        showAlert('<?php echo e(addslashes($product->name)); ?> adicionado ao carrinho!', 'success')" 
                class="btn btn-primary flex-grow-1 d-flex align-items-center justify-content-center py-2">
            <i class="bi bi-cart-plus-fill me-2"></i>
            <span>Adicionar ao Carrinho</span>
        </button>
        
        <button @click="$dispatch('toggle-wishlist', product); 
                        toggleWishlist(product)" 
                class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-3"
                :class="{ 'text-danger': isInWishlist(product.id) }"
                title="Adicionar aos Favoritos">
            <i class="bi fs-5" :class="isInWishlist(product.id) ? 'bi-heart-fill' : 'bi-heart'"></i>
        </button>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/shop/add-to-cart-button.blade.php ENDPATH**/ ?>