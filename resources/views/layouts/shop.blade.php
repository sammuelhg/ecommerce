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
    @stack('styles')
    @stack('styles')
</head>
<body x-data="shopApp()" x-init="init()">
    @include('shop.partials.header')
    <main class="container my-5">
        @yield('content')
    </main>
    @include('shop.partials.footer')
    <!-- Offcanvas Components -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
        @livewire('shop.cart')
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasWishlist" aria-labelledby="offcanvasWishlistLabel">
        @livewire('shop.wishlist')
    </div>
    @include('shop.partials.user-offcanvas')
    @include('shop.partials.toasts')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/shop-alpine.js') }}"></script>
    @stack('scripts')
</body>
</html>
