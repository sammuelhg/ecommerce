

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('shop.index')); ?>">Início</a></li>
            <li class="breadcrumb-item active"><?php echo e($category->name); ?></li>
        </ol>
    </nav>

    <!-- Header da Categoria -->
    <div class="bg-light py-5 mb-5 rounded-3 text-center position-relative overflow-hidden shadow-sm">
        <div class="position-relative z-1">
            <h1 class="display-4 fw-bold text-dark mb-2"><?php echo e($category->name); ?></h1>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->description): ?>
                <p class="lead text-muted mb-2"><?php echo e($category->description); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="d-inline-flex align-items-center text-muted">
                <i class="bi bi-grid-3x3-gap me-2"></i>
                <span><?php echo e($products->count()); ?> produtos encontrados</span>
            </div>
        </div>
        <!-- Elemento Decorativo -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" 
             style="background: radial-gradient(circle at center, #0d6efd 0%, transparent 70%); pointer-events: none;">
        </div>
    </div>

    <!-- Grid de Produtos -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->count() > 0): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <?php echo $__env->make('livewire.shop.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-muted">Nenhum produto nesta categoria</h4>
            <p class="text-muted">Em breve teremos novidades!</p>
            <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-primary mt-3">
                <i class="bi bi-arrow-left me-2"></i>Voltar para a Loja
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    window.DB_PRODUCTS = <?php echo $productsJson; ?>;
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/shop/category.blade.php ENDPATH**/ ?>