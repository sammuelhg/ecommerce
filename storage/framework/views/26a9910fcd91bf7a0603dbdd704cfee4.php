<button class="nav-link p-2 text-white position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist">
    <i class="bi bi-heart<?php echo e($count > 0 ? '-fill' : ''); ?> fs-5" style="<?php echo e($count > 0 ? 'color: #ffc107;' : ''); ?>"></i>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($count > 0): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?php echo e($count); ?>

        </span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</button>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/shop/wishlist-icon.blade.php ENDPATH**/ ?>