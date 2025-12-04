

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <?php if (isset($component)) { $__componentOriginal891d8b2665b7c453a51bca8edecbbc95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal891d8b2665b7c453a51bca8edecbbc95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.account-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('account-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal891d8b2665b7c453a51bca8edecbbc95)): ?>
<?php $attributes = $__attributesOriginal891d8b2665b7c453a51bca8edecbbc95; ?>
<?php unset($__attributesOriginal891d8b2665b7c453a51bca8edecbbc95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal891d8b2665b7c453a51bca8edecbbc95)): ?>
<?php $component = $__componentOriginal891d8b2665b7c453a51bca8edecbbc95; ?>
<?php unset($__componentOriginal891d8b2665b7c453a51bca8edecbbc95); ?>
<?php endif; ?>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Assine Clube</h5>
                </div>
                <div class="card-body p-5 text-center">
                    <i class="bi bi-star-fill fs-1 text-warning mb-3"></i>
                    <h4 class="fw-bold">Clube VIP</h4>
                    <p class="text-muted mb-4">Torne-se membro e aproveite benefícios exclusivos, frete grátis e descontos especiais.</p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <i class="bi bi-truck fs-4 text-primary"></i>
                                <p class="mb-0 mt-2 small fw-bold">Frete Grátis</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <i class="bi bi-percent fs-4 text-success"></i>
                                <p class="mb-0 mt-2 small fw-bold">10% OFF</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <i class="bi bi-gift fs-4 text-danger"></i>
                                <p class="mb-0 mt-2 small fw-bold">Brindes</p>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-warning px-5 fw-bold">ASSINAR AGORA</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/user/club.blade.php ENDPATH**/ ?>