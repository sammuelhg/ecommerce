

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row g-4">
        <!-- Produtos -->
        <div class="col-md-3">
            <a href="<?php echo e(route('admin.products.index')); ?>" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-box fs-1 mb-3 text-primary"></i>
                        <h5 class="card-title mb-0">Produtos</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Categorias -->
        <div class="col-md-3">
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-folder fs-1 mb-3 text-success"></i>
                        <h5 class="card-title mb-0">Categorias</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tipos -->
        <div class="col-md-3">
            <a href="<?php echo e(route('admin.types.index')); ?>" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-tags fs-1 mb-3 text-info"></i>
                        <h5 class="card-title mb-0">Tipos</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Materiais -->
        <div class="col-md-3">
            <a href="<?php echo e(route('admin.materials.index')); ?>" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-palette fs-1 mb-3 text-warning"></i>
                        <h5 class="card-title mb-0">Materiais</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Modelos -->
        <div class="col-md-3">
            <a href="<?php echo e(route('admin.models.index')); ?>" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-diagram-3 fs-1 mb-3 text-secondary"></i>
                        <h5 class="card-title mb-0">Modelos</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pedidos -->
        <div class="col-md-3">
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-cart-check fs-1 mb-3 text-danger"></i>
                        <h5 class="card-title mb-0">Pedidos</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Meu Perfil -->
        <div class="col-md-3">
            <a href="<?php echo e(route('customer.account.profile.edit')); ?>" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-person-circle fs-1 mb-3 text-dark"></i>
                        <h5 class="card-title mb-0">Meu Perfil</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        border-color: #ffd700;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .hover-card .card-title {
        color: #333;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>