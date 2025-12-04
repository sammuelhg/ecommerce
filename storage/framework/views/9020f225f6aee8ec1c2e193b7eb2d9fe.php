<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', config('app.name', 'Loja')); ?></title>
    
    <!-- SEO Meta Tags -->
    <?php echo $__env->yieldContent('meta'); ?>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/shop.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/product.css')); ?>" rel="stylesheet">
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
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Alpine.js Framework (required for reactive cart/wishlist) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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