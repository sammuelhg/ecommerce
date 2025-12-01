<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top navbar-taller">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand text-primary fw-bold fs-3 me-2" href="#">
                <span class="text-secondary">Loja</span>Bagisto
            </a>

            <!-- Ícones de Ação -->
            <div class="d-flex order-lg-3 me-2">
                <!-- Busca Mobile -->
                <template x-if="config.enableSearch">
                    <a class="nav-link p-2 text-dark d-lg-none" href="#" title="Buscar">
                        <i class="bi bi-search fs-5"></i>
                    </a>
                </template>
                
                <!-- Conta -->
                <a class="nav-link p-2 text-dark position-relative" href="#" title="Minha Conta"
                   data-bs-toggle="offcanvas" data-bs-target="#offcanvasUser">
                    <i class="bi bi-person-circle fs-5"></i>
                    @auth
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">Logado</span>
                        </span>
                    @endauth
                </a>
                
                <!-- Carrinho -->
                <template x-if="config.enableCart">
                    <a class="nav-link p-2 text-dark position-relative" href="#" 
                       data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                        <i class="bi bi-cart4 fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary text-primary"
                              x-show="cartTotalItems > 0" x-text="cartTotalItems"></span>
                    </a>
                </template>
                
                <!-- Wishlist -->
                <template x-if="config.enableWishlist">
                    <a class="nav-link p-2 text-dark position-relative" href="#"
                       data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist">
                        <i class="bi fs-5" :class="wishlist.length > 0 ? 'bi-heart-fill' : 'bi-heart'"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                              x-show="wishlist.length > 0" x-text="wishlist.length"></span>
                    </a>
                </template>
                
                <!-- Toggle Menu Mobile -->
                <button class="navbar-toggler p-2 border-0" type="button" 
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Navegação Desktop -->
            <div class="collapse navbar-collapse order-lg-2" x-show="config.enableSearch">
                <!-- Busca Desktop -->
                <form class="d-flex flex-grow-1 me-lg-4 my-2 my-lg-0 d-none d-lg-flex">
                    <input class="form-control me-2 rounded-pill" type="search" placeholder="Buscar produtos...">
                    <button class="btn btn-outline-primary rounded-circle" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- Links de Navegação -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#">Destaques</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Lançamentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Offcanvas Menu Mobile -->
    <div class="offcanvas offcanvas-start bg-white d-lg-none" tabindex="-1" id="offcanvasNav">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-primary fw-bold">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i> Navegação
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active fs-5" href="#">Destaques</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="#">Lançamentos</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="#">Ofertas</a></li>
                <li class="nav-item border-top mt-3 pt-3">
                    <a class="nav-link text-muted" href="#"><i class="bi bi-person-circle me-2"></i> Minha Conta</a>
                </li>
                <template x-if="config.enableWishlist">
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#" data-bs-toggle="offcanvas" 
                           data-bs-target="#offcanvasWishlist" data-bs-dismiss="offcanvas">
                            <i class="bi bi-heart-fill me-2"></i> Lista de Desejos
                        </a>
                    </li>
                </template>
                <template x-if="config.enableCart">
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#" data-bs-toggle="offcanvas" 
                           data-bs-target="#offcanvasCart" data-bs-dismiss="offcanvas">
                            <i class="bi bi-cart-fill me-2"></i> Meu Carrinho
                        </a>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <!-- Barra de Categorias -->
    <div class="bg-primary shadow-sm d-none d-md-block">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link text-white" href="#">Novidades</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Eletrônicos</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Moda</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Casa</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Promoções</a></li>
            </ul>
        </div>
    </div>

    <!-- Barra de Busca Componente -->
    <?php if (file_exists(__DIR__ . '/search-bar.php')) include __DIR__ . '/search-bar.php'; ?>
</header>
