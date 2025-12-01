<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LojaBagisto') }} - Sua Loja Online</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <style>
        :root {
            --bs-primary: #005691;
            --bs-secondary: #FFC72C;
            --bs-danger: #e74c3c;
        }

        .bg-primary { background-color: var(--bs-primary) !important; }
        .text-primary { color: var(--bs-primary) !important; }
        .btn-primary { 
            --bs-btn-bg: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-bg: #003e6b;
            --bs-btn-hover-border-color: #003e6b;
        }
        .bg-secondary { background-color: var(--bs-secondary) !important; }
        .text-secondary { color: var(--bs-secondary) !important; }

        .card-product { transition: all 0.3s ease-in-out; }
        .card-product:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-3px);
        }

        .hero-banner {
            min-height: 350px;
            background-size: cover;
            background-position: center;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            padding: 3rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }

        .rounded-xl { border-radius: 1rem !important; }

        .navbar-taller {
            min-height: 70px; 
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            white-space: normal;
            line-height: 1.25;
            max-height: 2.5em;
        }
        
        .offcanvas-body { overflow-x: hidden; }

        .custom-horizontal-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .custom-horizontal-scroll::-webkit-scrollbar { display: none; }

        .scroll-item-width { flex: 0 0 50%; max-width: 50%; }
        @media (min-width: 576px) { .scroll-item-width { flex: 0 0 33.333%; max-width: 33.333%; } }
        @media (min-width: 992px) { .scroll-item-width { flex: 0 0 25%; max-width: 25%; } }
        
        .wishlist-toggle {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            color: var(--bs-body-color);
            padding: 0.5rem;
            line-height: 1;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .wishlist-toggle:hover {
            transform: scale(1.1);
            color: var(--bs-danger);
            background-color: white;
        }
        .wishlist-toggle.is-favorited {
            color: var(--bs-danger);
            fill: var(--bs-danger);
        }
    </style>
</head>
<body class="bg-light" x-data="shop()" x-init="init()">

    {{-- Toast Notifications --}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 2000;">
        <template x-for="alert in alerts" :key="alert.id">
            <div class="alert alert-dismissible fade show mb-2 rounded-pill shadow-lg d-flex align-items-center"
                 :class="{
                    'alert-success': alert.type === 'success',
                    'alert-danger': alert.type === 'danger',
                    'alert-info': alert.type === 'info'
                 }"
                 role="alert">
                <i class="bi me-2" :class="alert.type === 'success' ? 'bi-check-circle-fill' : 'bi-x-octagon-fill'"></i>
                <div x-text="alert.message"></div>
                <button type="button" class="btn-close" @click="removeAlert(alert.id)" aria-label="Fechar"></button>
            </div>
        </template>
    </div>

    {{-- Header --}}
    @include('partials.shop-header')

    {{-- Main Content --}}
    <main class="container my-5">
        {{-- Hero Banner --}}
        <section class="hero-banner mb-5 bg-primary text-white"
                 style="background-image: url('https://placehold.co/1200x350/005691/ffffff?text=Oferta+Exclusiva');">
            <div class="p-5 p-md-0">
                <div class="col-md-7 px-0">
                    <div class="bg-light p-4 rounded-xl shadow-lg">
                        <h1 class="display-6 fw-bold text-primary mb-3">Liquidação de Verão</h1>
                        <p class="fs-5 text-dark mb-4 d-none d-sm-block">Aproveite descontos incríveis de até 50% OFF.</p>
                        <a href="#" class="btn btn-secondary btn-lg fw-bold shadow-sm">
                            Comprar Agora <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Featured Products --}}
        <section class="mb-5">
            <h2 class="border-bottom border-primary pb-2 mb-4 text-dark fw-bold">Produtos em Destaque</h2>

            <div class="d-flex flex-nowrap overflow-x-auto pb-3 custom-horizontal-scroll mx-n2">
                <template x-for="product in products" :key="product.id">
                    <div class="scroll-item-width p-2">
                        <div class="card h-100 card-product shadow-sm rounded-xl overflow-hidden">
                            <a href="#" class="text-decoration-none">
                                <div class="position-relative">
                                    <img :src="`https://placehold.co/400x400/CCCCCC/333333?text=${product.imageText}`" 
                                         class="card-img-top" style="height: 200px; object-fit: cover;">
                                    
                                    {{-- Badges --}}
                                    <template x-if="product.isOffer">
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 fw-bold">-20%</span>
                                    </template>
                                    <template x-if="!product.isOffer">
                                        <span class="badge bg-secondary text-primary position-absolute top-0 start-0 m-2 fw-bold">NOVO</span>
                                    </template>
                                    
                                    {{-- Wishlist Button --}}
                                    <button class="wishlist-toggle position-absolute top-0 end-0 m-2 border-0" 
                                            @click.prevent.stop="toggleWishlist(product)"
                                            :class="isInWishlist(product.id) ? 'is-favorited' : ''"
                                            :title="isInWishlist(product.id) ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos'">
                                        <i class="bi fs-5" :class="isInWishlist(product.id) ? 'bi-heart-fill' : 'bi-heart'"></i>
                                    </button>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title line-clamp-2 text-dark mb-1" x-text="product.name" :title="product.name"></h5>
                                    <p class="card-text fs-5 fw-bold text-primary mb-0">
                                        <span x-text="formatCurrency(product.price)"></span>
                                        <template x-if="product.oldPrice">
                                            <small class="text-muted text-decoration-line-through" x-text="formatCurrency(product.oldPrice)"></small>
                                        </template>
                                    </p>
                                </div>
                            </a>
                            <div class="card-footer bg-white border-0 p-3 pt-0">
                                <button class="btn w-100 fw-semibold btn-sm" 
                                        :class="isInCart(product.id) ? 'btn-success' : 'btn-primary'"
                                        @click="addToCart(product)">
                                    <i class="bi me-1" :class="isInCart(product.id) ? 'bi-check-lg' : 'bi-cart-plus'"></i> 
                                    <span x-text="isInCart(product.id) ? 'No Carrinho (' + getCartQty(product.id) + ')' : 'Adicionar'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    @include('partials.shop-footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- Alpine.js Shop Logic --}}
    <script>
        function shop() {
            return {
               products: {!! $productsJson !!},
                cart: [],
                wishlist: [],
                alerts: [],
                alertId: 0,

                init() {
                    this.loadFromStorage();
                    this.setupWatchers();
                },

                loadFromStorage() {
                    const storedCart = localStorage.getItem('myShopCart');
                    const storedWishlist = localStorage.getItem('myShopWishlist');
                    
                    if (storedCart) {
                        const parsedCart = JSON.parse(storedCart);
                        this.cart = parsedCart.map(item => {
                            const freshProduct = this.products.find(p => p.id === item.id);
                            return freshProduct ? { ...freshProduct, qty: item.qty } : null;
                        }).filter(item => item !== null);
                    }

                    if (storedWishlist) {
                        const parsedWishlist = JSON.parse(storedWishlist);
                        this.wishlist = parsedWishlist.map(item => {
                            const freshProduct = this.products.find(p => p.id === item.id);
                            return freshProduct || null;
                        }).filter(item => item !== null);
                    }
                },

                setupWatchers() {
                    this.$watch('cart', val => localStorage.setItem('myShopCart', JSON.stringify(val)));
                    this.$watch('wishlist', val => localStorage.setItem('myShopWishlist', JSON.stringify(val)));
                },

                get cartTotalItems() {
                    return this.cart.reduce((sum, item) => sum + item.qty, 0);
                },

                get cartSubtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },
                
                get offerProducts() {
                    return this.products.filter(p => p.isOffer);
                },

                formatCurrency(value) {
                    return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                },

                addToCart(product) {
                    const existing = this.cart.find(item => item.id === product.id);
                    if (existing) {
                        existing.qty++;
                        this.showAlert(`Mais um item de "${product.name.substring(0, 20)}..." adicionado!`, 'success');
                    } else {
                        this.cart.push({ ...product, qty: 1 });
                        this.showAlert(`"${product.name.substring(0, 20)}..." adicionado ao carrinho!`, 'success');
                    }
                },

                removeFromCart(id) {
                    this.cart = this.cart.filter(item => item.id !== id);
                    this.showAlert('Produto removido do carrinho.', 'danger');
                },

                updateQty(item) {
                    if (item.qty < 1) item.qty = 1;
                },

                isInWishlist(id) {
                    return this.wishlist.some(item => item.id === id);
                },
                
                isInCart(id) {
                    return this.cart.some(item => item.id === id);
                },
                
                getCartQty(id) {
                    const item = this.cart.find(item => item.id === id);
                    return item ? item.qty : 0;
                },

                toggleWishlist(product) {
                    if (this.isInWishlist(product.id)) {
                        this.wishlist = this.wishlist.filter(item => item.id !== product.id);
                        this.showAlert(`"${product.name.substring(0, 20)}..." removido da lista.`, 'danger');
                    } else {
                        this.wishlist.push(product);
                        this.showAlert(`"${product.name.substring(0, 20)}..." salvo na lista de desejos!`, 'success');
                    }
                },

                showAlert(message, type = 'info') {
                    const id = this.alertId++;
                    this.alerts.push({ id, message, type });
                    setTimeout(() => this.removeAlert(id), 3000);
                },

                removeAlert(id) {
                    this.alerts = this.alerts.filter(a => a.id !== id);
                },

                toggleSearch() {
                    const searchEl = document.getElementById('search-bar-full');
                    if (searchEl) {
                        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(searchEl);
                        bsCollapse.toggle();
                    }
                }
            }
        }
    </script>
</body>
</html>
