<div class="h-100 d-flex flex-column">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-danger fw-bold">
            <i class="bi bi-heart-fill me-2"></i> Lista de Desejos
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($wishlistItems) > 0): ?>
            <div class="list-group list-group-flush">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="list-group-item px-0 py-3 border-bottom" wire:key="wishlist-item-<?php echo e($item['id']); ?>">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <img src="https://placehold.co/80x80/2c3e50/ffffff?text=<?php echo e($item['image'] ?? 'Prod'); ?>" 
                                     class="img-fluid rounded" alt="<?php echo e($item['name']); ?>" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 line-clamp-2"><?php echo e($item['name']); ?></h6>
                                    <button wire:click="removeItem(<?php echo e($item['id']); ?>)" class="btn btn-link text-danger p-0 ms-2" wire:loading.attr="disabled">
                                        <i class="bi bi-trash" wire:loading.remove wire:target="removeItem(<?php echo e($item['id']); ?>)"></i>
                                        <span class="spinner-border spinner-border-sm" wire:loading wire:target="removeItem(<?php echo e($item['id']); ?>)"></span>
                                    </button>
                                </div>
                                <p class="text-primary fw-bold mb-2">R$ <?php echo e(number_format($item['price'], 2, ',', '.')); ?></p>
                                <button wire:click="moveToCart(<?php echo e($item['id']); ?>)" class="btn btn-sm btn-outline-primary w-100" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="moveToCart(<?php echo e($item['id']); ?>)">
                                        <i class="bi bi-cart-plus me-1"></i> Mover p/ Carrinho
                                    </span>
                                    <span wire:loading wire:target="moveToCart(<?php echo e($item['id']); ?>)">
                                        <span class="spinner-border spinner-border-sm me-1"></span> Movendo...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">Sua lista está vazia</h5>
                <p class="text-muted small">Salve seus itens favoritos para ver depois.</p>
                <button class="btn btn-outline-danger mt-3" data-bs-dismiss="offcanvas">
                    Explorar Produtos
                </button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/shop/wishlist.blade.php ENDPATH**/ ?>