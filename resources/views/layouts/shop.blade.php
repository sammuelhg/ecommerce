<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Loja'))</title>
    
    <!-- SEO Meta Tags -->
    @yield('meta')
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/shop.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
    @livewireStyles
    @stack('styles')
</head>
<body x-data="shopApp()" x-init="init()" 
      @add-to-cart.window="addToCart($event.detail.product, $event.detail.quantity)"
      @toggle-wishlist.window="toggleWishlist($event.detail)">
    @include('shop.partials.header')
    <main class="container my-5">
        @yield('content')
    </main>
    @include('shop.partials.footer')
    <!-- Offcanvas Components -->
    <!-- Offcanvas Components -->
    @include('shop.partials.cart-offcanvas')
    @include('shop.partials.wishlist-offcanvas')
    @include('shop.partials.user-offcanvas')
    @include('shop.partials.toasts')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Alpine.js Framework (required for reactive cart/wishlist) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Shop Alpine App Definition (must load before Alpine initializes) -->
    <script src="{{ asset('js/shop-alpine.js') }}"></script>
    
    <!-- Server-Side Cart Data Injection -->
    <script>
        window.SERVER_CART = @json(array_values(app(\App\Services\CartService::class)->get()));
    </script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>
