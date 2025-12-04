<div class="col-md-3 mb-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <div class="d-flex align-items-center mb-3">
                <div class="flex-shrink-0">
                    <img src="<?php echo e(auth()->user()->avatar_url); ?>" 
                         class="rounded-circle border" width="50" height="50" style="object-fit: cover;">
                </div>
                <div class="flex-grow-1 ms-3 overflow-hidden">
                    <h6 class="mb-0 text-truncate fw-bold text-dark"><?php echo e(auth()->user()->name); ?></h6>
                    <small class="text-muted text-truncate"><?php echo e(auth()->user()->email); ?></small>
                </div>
            </div>
        </div>
        <div class="list-group list-group-flush">
            <a href="<?php echo e(route('customer.account.profile.edit')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('customer.account.profile.edit') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-person me-3 fs-5"></i> Dados pessoais
            </a>
            <a href="<?php echo e(route('user.orders')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.orders') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-box-seam me-3 fs-5"></i> Pedidos
            </a>
            <a href="<?php echo e(route('user.notifications')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.notifications') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-bell me-3 fs-5"></i> Notificações
            </a>
            <a href="<?php echo e(route('user.payments')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.payments') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-credit-card me-3 fs-5"></i> Cartões
            </a>
            <a href="<?php echo e(route('user.addresses')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.addresses') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-geo-alt me-3 fs-5"></i> Endereços
            </a>
            <a href="<?php echo e(route('user.club')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.club') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-star me-3 fs-5"></i> Assine Clube
            </a>
            
            <div class="my-2 border-top"></div>

            <a href="<?php echo e(route('user.coupons')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.coupons') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-ticket-perforated me-3 fs-5"></i> Cupons
            </a>
            <a href="<?php echo e(route('user.referrals')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.referrals') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-envelope me-3 fs-5"></i> Indique amigos
            </a>
            <a href="<?php echo e(route('user.gifts')); ?>" 
               class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 <?php echo e(request()->routeIs('user.gifts') ? 'bg-light fw-bold border-start border-4 border-dark' : ''); ?> text-dark">
                <i class="bi bi-gift me-3 fs-5"></i> Presentes
            </a>

            <div class="my-2 border-top"></div>

            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="list-group-item list-group-item-action border-0 d-flex align-items-center py-3 text-danger">
                    <i class="bi bi-box-arrow-right me-3 fs-5"></i> Sair
                </button>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/components/account-sidebar.blade.php ENDPATH**/ ?>