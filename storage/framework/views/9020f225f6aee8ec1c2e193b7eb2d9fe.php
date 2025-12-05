<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', config('app.name', 'Loja')); ?></title>
    
    <!-- SEO Meta Tags -->
    <?php echo $__env->yieldContent('meta'); ?>
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/shop.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/product.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/card-styles.css')); ?>" rel="stylesheet">
    
    <!-- Vite Assets (Bootstrap + Custom Theme) -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body x-data="shopApp()" x-init="init()" 
      @add-to-cart.window="addToCart($event.detail.product, $event.detail.quantity)"
      @toggle-wishlist.window="toggleWishlist($event.detail)">
    <?php echo $__env->make('shop.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <main class="container my-5">
        <?php echo e($slot ?? ''); ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php echo $__env->make('shop.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Offcanvas Components -->
    <!-- Offcanvas Components -->
    <?php echo $__env->make('shop.partials.cart-offcanvas', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('shop.partials.wishlist-offcanvas', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('shop.partials.user-offcanvas', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('shop.partials.toasts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Bootstrap Bundle JS (for Offcanvas and other components) - MUST load before Alpine -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Cleanup duplicate backdrops -->
    <script>
        // Function to clean duplicate backdrops (keep one if offcanvas is open)
        function cleanupBackdrops() {
            setTimeout(function() {
                const backdrops = document.querySelectorAll('.offcanvas-backdrop');
                const hasOpenOffcanvas = document.querySelector('.offcanvas.show');
                
                if (hasOpenOffcanvas && backdrops.length > 1) {
                    // If offcanvas is open, keep only one backdrop, remove others
                    backdrops.forEach(function(backdrop, index) {
                        if (index > 0) {
                            backdrop.remove();
                        }
                    });
                } else if (!hasOpenOffcanvas) {
                    // If no offcanvas is open, remove all backdrops
                    backdrops.forEach(function(backdrop) {
                        backdrop.remove();
                    });
                    
                    // Ensure body is unlocked
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }
            }, 100);
        }
        
        // Listen for offcanvas close
        document.addEventListener('hidden.bs.offcanvas', cleanupBackdrops);
        
        // Also listen for backdrop clicks directly
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('offcanvas-backdrop')) {
                cleanupBackdrops();
            }
        });
    </script>
    
    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Shop Alpine App Definition (must load before Alpine initializes) -->
    <script src="<?php echo e(asset('js/shop-alpine.js')); ?>"></script>
    
    <!-- Server-Side Cart Data Injection -->
    <script>
        window.SERVER_CART = <?php echo json_encode(array_values(app(\App\Services\CartService::class)->get()), 15, 512) ?>;
    </script>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/layouts/shop.blade.php ENDPATH**/ ?>