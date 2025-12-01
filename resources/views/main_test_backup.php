<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

try {
    $dbProducts = Product::all();
    if ($dbProducts->isEmpty()) {
        // Fallback data if DB is empty but connected
        $productsJson = json_encode([]);
    } else {
        $productsJson = $dbProducts->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'imageText' => $p->image,
                'isOffer' => (bool) $p->is_offer,
                'oldPrice' => $p->old_price ? (float) $p->old_price : null,
            ];
        })->toJson();
    }
} catch (\Exception $e) {
    // Fallback if DB fails (e.g. migration not run)
    // We'll use an empty array or the original hardcoded list if we wanted, 
    // but for now let's return empty to avoid breaking JS syntax
    $productsJson = '[]';
    // echo "<!-- Error: " . $e->getMessage() . " -->";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Loja - Template E-commerce Completo (Alpine.js)</title>
    <!-- Carrega o Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Carrega Ícones Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <style>
        /* Cores Personalizadas */
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
        
        /* Transition for alerts */
        .fade-enter-active, .fade-leave-active { transition: opacity 0.5s; }
        .fade-enter, .fade-leave-to { opacity: 0; }
    </style>
</head>
<body class="bg-light" x-data="shop()" x-init="init()">

    <!-- Toast Notifications Container -->
    <div class="fixed-bottom end-0 p-3" style="z-index: 2000;">
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

    <!-- 1. Cabeçalho Fixo (Header) -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top navbar-taller">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand text-primary fw-bold fs-3 me-2" href="#">
                    <span class="text-secondary">Loja</span>Bagisto
                </a>

                <!-- Ícones de Ação -->
                <div class="d-flex order-lg-3 me-2">
                    <!-- Ícone de Busca (Mobile) -->
                    <a class="nav-link p-2 text-dark d-lg-none" href="#" @click.prevent="toggleSearch()" title="Buscar">
                        <i class="bi bi-search fs-5"></i>
                    </a>
                    
                    <!-- Ícone de Conta -->
                    <a class="nav-link p-2 text-dark" href="#" title="Minha Conta">
                        <i class="bi bi-person-circle fs-5"></i>
                    </a>
                    
                    <!-- Ícone de Carrinho -->
                    <a class="nav-link p-2 text-dark position-relative" href="#" title="Carrinho"
                       data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                        <i class="bi bi-cart4 fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary text-primary"
                              x-show="cartTotalItems > 0" x-text="cartTotalItems">
                        </span>
                    </a>
                    
                    <!-- Ícone de Lista de Desejos -->
                    <a class="nav-link p-2 text-dark position-relative" href="#" title="Lista de Desejos"
                       data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist" aria-controls="offcanvasWishlist">
                        <i class="bi fs-5" :class="wishlist.length > 0 ? 'bi-heart-fill' : 'bi-heart'"></i> 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                              x-show="wishlist.length > 0" x-text="wishlist.length">
                        </span>
                    </a>
                    
                    <!-- Botão Toggle do Menu -->
                    <button class="navbar-toggler p-2 border-0" type="button" 
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" 
                            aria-controls="offcanvasNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- Menu de Navegação (Desktop) -->
                <div class="collapse navbar-collapse order-lg-2" id="desktopNav">
                    <form class="d-flex flex-grow-1 me-lg-4 my-2 my-lg-0 d-none d-lg-flex">
                        <input class="form-control me-2 rounded-pill" type="search" placeholder="Buscar produtos, categorias..." aria-label="Search">
                        <button class="btn btn-outline-primary rounded-circle" type="submit" title="Buscar">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <ul class="navbar-nav d-flex align-items-start mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" href="#">Destaques</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Lançamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- OFF CANVAS (MENU HAMBÚGUER MOBILE) -->
        <div class="offcanvas offcanvas-start bg-white d-lg-none" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title text-primary fw-bold" id="offcanvasNavLabel">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i> Navegação
                </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item"><a class="nav-link active fs-5" href="#">Destaques</a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="#">Lançamentos</a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="#">Ofertas</a></li>
                    <li class="nav-item border-top mt-3 pt-3">
                        <a class="nav-link text-muted" href="#"><i class="bi bi-person-circle me-2"></i> Minha Conta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist" data-bs-dismiss="offcanvas">
                            <i class="bi bi-heart-fill me-2"></i> Lista de Desejos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" data-bs-dismiss="offcanvas">
                            <i class="bi bi-cart-fill me-2"></i> Meu Carrinho
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- OFF CANVAS (LISTA DE DESEJOS) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasWishlist" aria-labelledby="offcanvasWishlistLabel">
            <div class="offcanvas-header bg-primary text-white border-bottom">
                <h5 class="offcanvas-title fw-bold" id="offcanvasWishlistLabel">
                    <i class="bi bi-heart-fill me-2"></i> Sua Lista de Desejos
                </h5>
                <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
            </div>
            <div class="offcanvas-body p-0">
                <!-- Estado Vazio -->
                <div x-show="wishlist.length === 0">
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-heart-break fs-1 mb-3"></i>
                        <p class="mb-0 fw-bold">Sua lista de desejos está vazia.</p>
                        <small>Adicione produtos para acompanhá-los!</small>
                    </div>
                    
                    <!-- Sugestão de Ofertas -->
                    <div class="p-3 border-top" x-show="offerProducts.length > 0">
                        <h6 class="text-danger fw-bold mb-3">Ofertas que Você Pode Gostar:</h6>
                        <div class="list-group list-group-flush">
                            <template x-for="product in offerProducts.slice(0, 3)" :key="product.id">
                                <div class="list-group-item d-flex align-items-center p-2 bg-light rounded-3 mb-2">
                                    <img :src="`https://placehold.co/60x60/3498db/ffffff?text=${product.imageText}`" 
                                         class="rounded me-2 flex-shrink-0" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="flex-grow-1 me-2 overflow-hidden"> 
                                        <p class="mb-0 small fw-bold text-dark line-clamp-2" x-text="product.name"></p>
                                        <span class="text-danger fw-semibold small" x-text="formatCurrency(product.price)"></span>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger" @click="toggleWishlist(product)" title="Adicionar à Lista">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Lista de Itens -->
                <div class="list-group list-group-flush" x-show="wishlist.length > 0">
                    <template x-for="item in wishlist" :key="item.id">
                        <div class="list-group-item d-flex align-items-center p-3">
                            <img :src="`https://placehold.co/80x80/CCCCCC/333333?text=${item.imageText}`" 
                                 class="rounded me-3 flex-shrink-0" style="width: 80px; height: 80px; object-fit: cover;">
                            
                            <div class="flex-grow-1 me-2 overflow-hidden"> 
                                <p class="mb-1 fw-bold text-dark line-clamp-2" x-text="item.name"></p>
                                <p class="mb-0 text-primary fw-semibold" x-text="formatCurrency(item.price)"></p>
                            </div>
                            
                            <div class="ms-auto d-flex flex-column align-items-end flex-shrink-0">
                                <button class="btn btn-sm btn-outline-danger mb-1" @click="toggleWishlist(item)" title="Remover">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" @click="addToCart(item)" title="Adicionar ao Carrinho">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="offcanvas-footer border-top p-3 text-center" x-show="wishlist.length > 0">
                <a href="#" class="btn btn-primary w-100 fw-semibold">Ver Todos os Itens</a>
            </div>
        </div>

        <!-- OFF CANVAS (CARRINHO DE COMPRAS) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
            <div class="offcanvas-header bg-primary text-white border-bottom">
                <h5 class="offcanvas-title fw-bold" id="offcanvasCartLabel">
                    <i class="bi bi-cart4 me-2"></i> Seu Carrinho (<span x-text="cartTotalItems"></span>)
                </h5>
                <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column">
                
                <!-- Estado Vazio -->
                <div x-show="cart.length === 0" class="p-5 text-center text-muted flex-grow-1 d-flex flex-column justify-content-center">
                    <i class="bi bi-cart-x fs-1 mb-3"></i>
                    <p class="mb-0 fw-bold">Seu carrinho está vazio.</p>
                    <small>Que tal adicionar um produto em destaque?</small>
                </div>

                <!-- Lista de Produtos -->
                <div class="list-group list-group-flush flex-grow-1 overflow-y-auto" x-show="cart.length > 0">
                    <template x-for="item in cart" :key="item.id">
                        <div class="list-group-item d-flex p-3 align-items-start">
                            <img :src="`https://placehold.co/80x80/2c3e50/ffffff?text=${item.imageText}`" 
                                 class="rounded me-3 flex-shrink-0" style="width: 80px; height: 80px; object-fit: cover;">
                            
                            <div class="flex-grow-1 overflow-hidden me-2">
                                <p class="mb-1 fw-bold text-dark line-clamp-2" x-text="item.name"></p>
                                <small class="text-muted d-block">Preço Unit.: <span x-text="formatCurrency(item.price)"></span></small>
                                <small class="text-primary fw-semibold d-block">Total Item: <span x-text="formatCurrency(item.price * item.qty)"></span></small>
                            </div>
                            
                            <div class="ms-auto d-flex flex-column align-items-end flex-shrink-0">
                                <input type="number" class="form-control form-control-sm text-center mb-2" 
                                       x-model.number="item.qty" @change="updateQty(item)" min="1" style="width: 60px;">
                                
                                <button class="btn btn-sm btn-outline-danger" @click="removeFromCart(item.id)" title="Remover">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- Subtotal e Frete -->
                <div class="mt-auto pt-3 border-top" x-show="cart.length > 0">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span class="fw-bold" x-text="formatCurrency(cartSubtotal)"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Frete:</span>
                        <span class="fw-bold text-success">Grátis</span>
                    </div>
                    <div class="d-flex justify-content-between fs-5 fw-bold text-primary border-top pt-2">
                        <span>Total:</span>
                        <span x-text="formatCurrency(cartSubtotal)"></span>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer border-top p-3" x-show="cart.length > 0">
                <a href="#" class="btn btn-secondary w-100 fw-semibold mb-2">Ver Carrinho Completo</a>
                <a href="#" class="btn btn-primary w-100 fw-semibold">Finalizar Compra</a>
            </div>
        </div>

        <!-- Barra de Busca Completa (Mobile) -->
        <div class="collapse bg-white border-bottom shadow-sm d-lg-none" id="search-bar-full">
            <div class="container-fluid py-3">
                <form class="d-flex mb-4">
                    <input class="form-control form-control-lg rounded-pill me-2" type="search" placeholder="Buscar produtos..." id="mobile-search-input">
                    <button class="btn btn-primary rounded-pill fw-semibold" type="submit">Buscar</button>
                </form>
                <!-- ... (Conteúdo estático de busca mantido) ... -->
            </div>
        </div>

        <!-- Navegação de Categorias (Desktop) -->
        <div class="bg-primary shadow-sm d-none d-md-block">
            <div class="container">
                <ul class="nav justify-content-center">
                    <li class="nav-item"><a class="nav-link text-white hover-secondary" href="#">Novidades</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Eletrônicos</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Moda Masculina</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Casa & Decoração</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Promoções</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- 2. Conteúdo Principal -->
    <main class="container my-5">
        <!-- Hero Banner -->
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

        <!-- Produtos em Destaque -->
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
                                    
                                    <!-- Badges -->
                                    <template x-if="product.isOffer">
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 fw-bold">-20%</span>
                                    </template>
                                    <template x-if="!product.isOffer">
                                        <span class="badge bg-secondary text-primary position-absolute top-0 start-0 m-2 fw-bold">NOVO</span>
                                    </template>
                                    
                                    <!-- Wishlist Button -->
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

    <!-- 3. Rodapé -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row border-bottom border-secondary pb-4 mb-4">
                <div class="col-6 col-md-3 mb-3">
                    <h5 class="text-secondary mb-3">A Loja</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Sobre Nós</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Trabalhe Conosco</a></li>
                    </ul>
                </div>
                <!-- ... Outras colunas do footer ... -->
                <div class="col-md-3 mb-3">
                    <h5 class="text-secondary mb-3">Newsletter</h5>
                    <p class="text-light mb-3">Inscreva-se e ganhe 10% de desconto.</p>
                    <form class="d-flex">
                        <input type="email" class="form-control rounded-start" placeholder="Seu e-mail">
                        <button class="btn btn-secondary rounded-end fw-semibold" type="submit">Enviar</button>
                    </form>
                </div>
            </div>
            <div class="text-center text-light small">
                © 2025 LojaBagisto. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function shop() {
            return {
                products: <?php echo $productsJson; ?>,
                cart: [],
                wishlist: [],
                alerts: [],
                alertId: 0,

                init() {
                    // Carregar do LocalStorage
                    const storedCart = localStorage.getItem('myShopCart');
                    const storedWishlist = localStorage.getItem('myShopWishlist');
                    
                    if (storedCart) {
                        // Sincronizar carrinho com dados atuais do banco (preço, nome, etc)
                        const parsedCart = JSON.parse(storedCart);
                        this.cart = parsedCart.map(item => {
                            const freshProduct = this.products.find(p => p.id === item.id);
                            // Se o produto ainda existir no banco, atualiza os dados mantendo a quantidade
                            return freshProduct ? { ...freshProduct, qty: item.qty } : null;
                        }).filter(item => item !== null); // Remove itens que não existem mais no banco
                    }

                    if (storedWishlist) {
                        // Sincronizar wishlist
                        const parsedWishlist = JSON.parse(storedWishlist);
                        this.wishlist = parsedWishlist.map(item => {
                            const freshProduct = this.products.find(p => p.id === item.id);
                            return freshProduct ? freshProduct : null;
                        }).filter(item => item !== null);
                    }

                    // Watchers para persistência
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
                    setTimeout(() => {
                        this.removeAlert(id);
                    }, 3000);
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
