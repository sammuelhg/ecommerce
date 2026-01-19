<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Loja'))</title>
    
    <!-- SEO Meta Tags -->
    @yield('meta')
    
    <!-- Bootstrap Icons -->
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"></noscript>
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/shop.css') }}" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="{{ asset('css/shop.css') }}" rel="stylesheet"></noscript>

    <link href="{{ asset('css/product.css') }}" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="{{ asset('css/product.css') }}" rel="stylesheet"></noscript>

    <link href="{{ asset('css/card-styles.css') }}" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="{{ asset('css/card-styles.css') }}" rel="stylesheet"></noscript>
    
    <!-- Vite Assets (Bootstrap + Custom Theme) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
</head>
<body x-data="shopApp()" x-init="init()" 
      @add-to-cart.window="addToCart($event.detail.product, $event.detail.quantity)"
      @toggle-wishlist.window="toggleWishlist($event.detail)">
    @include('shop.partials.header')
    <main class="container my-5">
        {{ $slot ?? '' }}
        @yield('content')
    </main>
    @include('shop.partials.footer')
    <!-- Offcanvas Components -->
    <!-- Offcanvas Components -->
    @include('shop.partials.cart-offcanvas')
    @include('shop.partials.wishlist-offcanvas')
    @include('shop.partials.user-offcanvas')
    @include('shop.partials.story-viewer-modal')
    @include('shop.partials.toasts')
    
    <!-- Bootstrap Bundle JS (for Offcanvas and other components) - MUST load before Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
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
    <script defer src="{{ asset('js/shop-alpine.js') }}"></script>
    
    <!-- Server-Side Cart Data Injection -->
    @php
        // Prevent loading heavy product data on Profile/Account pages to save performance
        $shouldLoadProducts = !request()->is('conta*') && !request()->is('admin*');
        
        $dbProducts = collect([]);
        
        if ($shouldLoadProducts) {
             $dbProducts = \App\Domains\Catalog\Models\Product::where('is_active', true)
                ->select(['id', 'name', 'price', 'image', 'is_offer', 'old_price'])
                ->limit(50)
                ->get()
                ->map(function($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'price' => (float) $p->price,
                        // Fix 404s: Use absolute URL
                        'image' => $p->image ? \Illuminate\Support\Facades\Storage::url($p->image) : null,
                        'isOffer' => (bool) $p->is_offer,
                        'oldPrice' => $p->old_price ? (float) $p->old_price : null,
                    ];
                });
        }
    @endphp
    <script>
        window.IS_GUEST = @json(auth()->guest());
        window.SERVER_CART = @json(array_values(app(\App\Domains\Sales\Services\CartService::class)->get()));
        
        // Inject all active products for Alpine hydration (Wishlist/Cart sync)
        window.DB_PRODUCTS = @json($dbProducts);
    </script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>
