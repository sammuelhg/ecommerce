<button class="nav-link p-2 text-white position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
    <i class="bi bi-cart4 fs-5"></i>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($count > 0): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
            <?php echo e($count); ?>

        </span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</button>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/shop/cart-icon.blade.php ENDPATH**/ ?>