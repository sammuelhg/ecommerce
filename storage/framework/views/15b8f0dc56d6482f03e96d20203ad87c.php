<header>
    <style>
        /* Fix para telas muito pequenas (344px) - logo absoluta, ícones sobrepõem */
        @media (max-width: 400px) {
            .navbar .container {
                position: relative;
                min-height: 90px;
            }
            .navbar-brand {
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                z-index: 1;
                margin: 0;
            }
            .navbar .d-flex.order-lg-3 {
                position: relative;
                z-index: 2;
                margin-left: auto !important;
                width: auto;
            }
        }
    </style>
    
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-taller" style="background-color: #1a1a1a; box-shadow: 0 2px 10px rgba(0,0,0,0.5);">
        <div class="container" style="max-width: 1200px;">
            <!-- Logo -->
            <a class="navbar-brand me-2" href="<?php echo e(route('shop.index')); ?>" title="Página Inicial">
                <img src="<?php echo e(asset('logo.svg')); ?>" alt="Logo" style="height: 90px; width: auto;">
            </a>

            <!-- Ícones de Ação -->
            <div class="d-flex order-lg-3 me-2">
                <!-- Busca Mobile -->
                <a class="nav-link p-2 text-white d-lg-none" href="#" title="Buscar" @click.prevent="showMobileSearch = !showMobileSearch">
                    <i class="bi bi-search fs-5"></i>
                </a>
                
                <!-- Conta -->
                <a class="nav-link p-2 text-white position-relative" href="#" title="Minha Conta"
                   data-bs-toggle="offcanvas" data-bs-target="#offcanvasUser">
                    <i class="bi bi-person-circle fs-5"></i>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">Logado</span>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>
                
                <!-- Carrinho -->
                <button class="nav-link p-2 text-white position-relative bg-transparent border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                    <i class="bi bi-cart4 fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary" 
                          x-show="cartTotalItems > 0" 
                          x-text="cartTotalItems"
                          style="display: none;">
                    </span>
                </button>

                <!-- Wishlist -->
                <button class="nav-link p-2 text-white position-relative bg-transparent border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist">
                    <i class="bi fs-5" :class="wishlist.length > 0 ? 'bi-heart-fill' : 'bi-heart'" :style="wishlist.length > 0 ? 'color: #ffc107;' : ''"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                          x-show="wishlist.length > 0" 
                          x-text="wishlist.length"
                          style="display: none;">
                    </span>
                </button>

                <!-- Menu Hambúrguer (Mobile) -->
                <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Navegação Desktop -->
            <div class="collapse navbar-collapse order-lg-2">
                <!-- Busca Desktop -->
                <form class="d-flex flex-grow-1 me-lg-4 my-2 my-lg-0 d-none d-lg-flex" @submit.prevent="performSearch()">
                    <input class="form-control bg-white me-2 rounded-pill" type="search" placeholder="Buscar produtos..." x-model="searchQuery" style="background-color: #f0f8ff !important; border: 1px solid #d0e8ff !important; color: #333 !important;">
                    <button class="btn rounded-circle" type="submit" style="background-color: #ffc107; border: none; color: #1a1a1a; width: 40px; height: 40px;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- Links de Navegação -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-white active" href="<?php echo e(route('shop.index')); ?>" style="font-weight: 500;">Destaques</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#" style="font-weight: 500;">Lançamentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" style="color: #ffc107; font-weight: 500;">Ofertas</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Barra de Busca Mobile -->
    <div class="p-3 border-bottom d-lg-none" style="background-color: #1a1a1a; border-bottom: 1px solid #333 !important;" 
         x-show="showMobileSearch" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         style="display: none;">
        <form class="d-flex" @submit.prevent="performSearch()">
            <input class="form-control bg-white me-2" type="search" placeholder="Buscar produtos..." x-model="searchQuery" style="background-color: #f0f8ff !important; border: 1px solid #d0e8ff !important; color: #333 !important;">
            <button class="btn" type="button" @click="performSearch()" style="background-color: #ffc107; color: #1a1a1a;">
                <i class="bi bi-search"></i>
            </button>
            <button class="btn btn-link text-white ms-2" type="button" @click="showMobileSearch = false">
                <i class="bi bi-x-lg"></i>
            </button>
        </form>
    </div>

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
                <!-- Links Principais -->
                <li class="nav-item">
                    <a class="nav-link active fs-5" href="<?php echo e(route('shop.index')); ?>">
                        <i class="bi bi-house-fill me-2"></i>Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="<?php echo e(route('shop.index')); ?>?filter=new">
                        <i class="bi bi-stars me-2"></i>Lançamentos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5 text-danger" href="<?php echo e(route('shop.index')); ?>?filter=offers">
                        <i class="bi bi-tag-fill me-2"></i>Promoções
                    </a>
                </li>

                <!-- Categorias -->
                <?php
                    $categories = \App\Models\Category::where('is_active', true)->get();
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->count() > 0): ?>
                    <li class="nav-item border-top mt-3 pt-3">
                        <h6 class="text-muted px-3 mb-2">
                            <i class="bi bi-grid-3x3-gap me-2"></i>Categorias
                        </h6>
                    </li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('shop.category', $category->slug)); ?>">
                                <?php echo e($category->name); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Ações Rápidas -->
                <li class="nav-item border-top mt-3 pt-3">
                    <a class="nav-link text-muted" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasUser">
                        <i class="bi bi-person-circle me-2"></i>Minha Conta
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#" data-bs-toggle="offcanvas" 
                       data-bs-target="#offcanvasWishlist">
                        <i class="bi bi-heart-fill me-2"></i>Lista de Desejos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#" data-bs-toggle="offcanvas" 
                       data-bs-target="#offcanvasCart">
                        <i class="bi bi-cart-fill me-2"></i>Meu Carrinho
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Barra de Categorias -->
    <div class="shadow-sm d-none d-md-block" style="background-color: #f0f8ff !important; border-top: 1px solid #d0e8ff !important;">
        <div class="container" style="max-width: 1200px;">
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link text-dark fw-bold" href="<?php echo e(route('shop.index', ['sort' => 'latest'])); ?>" style="transition: color 0.3s;" onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#212529'">Novidades</a></li>
                <li class="nav-item"><a class="nav-link text-dark fw-bold" href="<?php echo e(route('shop.category', 'fit')); ?>" style="transition: color 0.3s;" onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#212529'">ModaFit</a></li>
                <li class="nav-item"><a class="nav-link text-dark fw-bold" href="<?php echo e(route('shop.category', 'praia')); ?>" style="transition: color 0.3s;" onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#212529'">ModaPraia</a></li>
                <li class="nav-item"><a class="nav-link text-dark fw-bold" href="<?php echo e(route('shop.category', 'croche')); ?>" style="transition: color 0.3s;" onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#212529'">ModaCrochê</a></li>
                <li class="nav-item"><a class="nav-link text-dark fw-bold" href="<?php echo e(route('shop.category', 'suplementos')); ?>" style="transition: color 0.3s;" onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#212529'">LosfitNutri</a></li>
                <li class="nav-item"><a class="nav-link text-danger fw-bold" href="<?php echo e(route('shop.index', ['filter' => 'offers'])); ?>" style="transition: color 0.3s;" onmouseover="this.style.color='#dc3545'" onmouseout="this.style.color='#dc3545'">Promoções</a></li>
            </ul>
        </div>
    </div>
</header>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/shop/partials/header.blade.php ENDPATH**/ ?>