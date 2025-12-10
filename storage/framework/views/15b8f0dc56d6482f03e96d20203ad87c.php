<header>
    <style>
        /* Fix para telas muito pequenas (344px) - logo absoluta, ícones sobrepõem */
        @media (max-width: 480px) {
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($storeSettings['store_logo']) && $storeSettings['store_logo']): ?>
                    <img src="<?php echo e($storeSettings['store_logo']); ?>" alt="Logo" style="height: 70px; width: auto;">
                <?php else: ?>
                    <img src="<?php echo e(asset('logo.svg')); ?>" alt="Logo" style="height: 70px; width: auto;">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>

            <!-- Ícones de Ação -->
            <div class="d-flex order-lg-3 me-2">
                <!-- Conta -->
                <!-- Conta (Story Ring / Avatar Button) -->
                <div class="nav-item me-2 position-relative" 
                     x-data="{
                        latestStoryTimestamp: '<?php echo e($storyStatus->latestStoryTimestamp); ?>',
                        hasActiveStories: <?php echo e($storyStatus->hasActiveStories ? 'true' : 'false'); ?>,
                        isUnseen: false,
                        
                        init() {
                            if (this.hasActiveStories && this.latestStoryTimestamp) {
                                const lastViewed = localStorage.getItem('lastViewedStoryTimestamp');
                                // If no last viewed OR server timestamp is newer > unseen
                                this.isUnseen = !lastViewed || new Date(this.latestStoryTimestamp) > new Date(lastViewed);
                            }
                        },
                        
                        handleClick() {
                            if (this.hasActiveStories && this.isUnseen) {
                                // Open Story Viewer
                                const storyModal = new bootstrap.Modal(document.getElementById('storyViewerModal'));
                                storyModal.show();
                                
                                // Mark as seen immediately (or could do it when modal closes)
                                localStorage.setItem('lastViewedStoryTimestamp', new Date().toISOString());
                                this.isUnseen = false;
                            } else {
                                // Open Offcanvas
                                const offcanvasFn = new bootstrap.Offcanvas(document.getElementById('offcanvasUser'));
                                offcanvasFn.show();
                            }
                        }
                     }">
                     
                     <!-- 1. O Aro (Externo e com gap) - Exibe apenas se TIVER stories E for NÃO VISTO -->
                     <!-- Se já viu, o aro some, igual Instagram -->
                     <template x-if="hasActiveStories && isUnseen">
                        <div class="story-ring"></div>
                     </template>

                    <button class="btn btn-outline-warning btn-icon-shape rounded-circle position-relative p-0 d-flex align-items-center justify-content-center" 
                            type="button" 
                            @click="handleClick()"
                            title="<?php echo e(Auth::check() ? 'Minha Conta' : 'Entrar'); ?>"
                            aria-label="<?php echo e(Auth::check() ? 'Minha Conta' : 'Entrar'); ?>"
                            style="width: 40px; height: 40px; z-index: 2; background-color: #1a1a1a;">
                        
                        <!-- 2. O Conteúdo (Avatar ou Ícone) -->
                        <div class="d-flex align-items-center justify-content-center w-100 h-100 rounded-circle overflow-hidden">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->avatar): ?>
                                    <img src="<?php echo e(Auth::user()->avatar); ?>" class="w-100 h-100 object-fit-cover" alt="Avatar">
                                <?php else: ?>
                                    <span class="fw-bold fs-6"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                                <i class="bi bi-person-fill fs-5"></i>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </button>

                    <style>
                        /* O Aro Colorido (Anel Externo - Estático) */
                        .story-ring {
                            position: absolute;
                            /* Centralizar perfeitamente sobre o botão */
                            top: 50%; left: 50%;
                            transform: translate(-50%, -50%);
                            
                            /* Tamanho do Anel: 46px */
                            width: 46px;
                            height: 46px;
                            
                            border-radius: 50%;
                            background: linear-gradient(45deg, #FFD600 0%, #FF7A00 25%, #FF0069 50%, #D300C5 75%, #833AB4 100%);
                            z-index: 1;
                            
                            /* Máscara "Tuck Under": Começa em 38px (19px raio) para entrar sob o botão de 40px (20px raio) */
                            /* Ring Radius: 23px. Inner Radius: 19px. */
                            /* 19/23 = ~82.6% */
                            -webkit-mask: radial-gradient(farthest-side, transparent 82%, black 84%);
                            mask: radial-gradient(farthest-side, transparent 82%, black 84%);
                        }
                    </style>
                </div>
                
                <!-- Carrinho -->
                <button class="btn btn-outline-warning btn-icon-shape rounded-circle position-relative me-2 d-flex align-items-center justify-content-center" 
                        type="button" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#offcanvasCart"
                        aria-label="Carrinho de Compras"
                        style="width: 40px; height: 40px;">
                    <i class="bi bi-cart4"></i>
                    <span class="notification-badge" 
                          x-show="cartTotalItems > 0" 
                          x-text="cartTotalItems"
                          style="display: none;">
                    </span>
                </button>

                <!-- Wishlist -->
                <button class="btn btn-outline-warning btn-icon-shape rounded-circle position-relative me-2 d-flex align-items-center justify-content-center" 
                        type="button" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#offcanvasWishlist"
                        aria-label="Lista de Desejos"
                        style="width: 40px; height: 40px;">
                    <i class="bi" :class="wishlist.length > 0 ? 'bi-heart-fill' : 'bi-heart'"></i>
                    <span class="notification-badge" 
                          x-show="wishlist.length > 0" 
                          x-text="wishlist.length"
                          style="display: none;">
                    </span>
                </button>

                <!-- Menu Hambúrguer (Mobile) -->
                <button class="btn btn-outline-warning btn-icon-shape rounded-circle d-lg-none d-flex align-items-center justify-content-center" 
                        type="button" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#offcanvasNav"
                        aria-label="Menu Navegação"
                        style="width: 40px; height: 40px;">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <!-- Navegação Desktop -->
            <div class="collapse navbar-collapse order-lg-2">
                
                <!-- Wrapper para Busca (Fake Layout + Real Absolute) -->
                <div class="d-none d-lg-block flex-grow-1 me-lg-4 position-relative">
                    <!-- 1. Fake Bar (Invisível) para determinar altura/largura no fluxo -->
                    <div style="visibility: hidden; pointer-events: none;" aria-hidden="true">
                        <?php if (isset($component)) { $__componentOriginal901916e66f76643cea530aa9f8bff40c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal901916e66f76643cea530aa9f8bff40c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.shop.header-search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop.header-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal901916e66f76643cea530aa9f8bff40c)): ?>
<?php $attributes = $__attributesOriginal901916e66f76643cea530aa9f8bff40c; ?>
<?php unset($__attributesOriginal901916e66f76643cea530aa9f8bff40c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal901916e66f76643cea530aa9f8bff40c)): ?>
<?php $component = $__componentOriginal901916e66f76643cea530aa9f8bff40c; ?>
<?php unset($__componentOriginal901916e66f76643cea530aa9f8bff40c); ?>
<?php endif; ?>
                    </div>

                    <!-- 2. Real Bar (Absoluta) Interativa -->
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        <?php if (isset($component)) { $__componentOriginal901916e66f76643cea530aa9f8bff40c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal901916e66f76643cea530aa9f8bff40c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.shop.header-search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop.header-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal901916e66f76643cea530aa9f8bff40c)): ?>
<?php $attributes = $__attributesOriginal901916e66f76643cea530aa9f8bff40c; ?>
<?php unset($__attributesOriginal901916e66f76643cea530aa9f8bff40c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal901916e66f76643cea530aa9f8bff40c)): ?>
<?php $component = $__componentOriginal901916e66f76643cea530aa9f8bff40c; ?>
<?php unset($__componentOriginal901916e66f76643cea530aa9f8bff40c); ?>
<?php endif; ?>
                    </div>
                </div>

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
            <input class="form-control bg-white me-2" type="search" placeholder="Buscar produtos..." x-model="searchQuery" style="border: 1px solid #dee2e6 !important; color: #333 !important;">
            <button class="btn" type="button" @click="performSearch()" style="background-color: #ffc107; color: #1a1a1a;">
                <i class="bi bi-search"></i>
            </button>
            <button class="btn btn-link text-white ms-2" type="button" @click="showMobileSearch = false">
                <i class="bi bi-x-lg"></i>
            </button>
        </form>
    </div>

    <!-- Offcanvas Menu Mobile -->
    <div class="offcanvas offcanvas-end bg-white" tabindex="-1" id="offcanvasNav" 
         style="width: 280px; max-width: 85vw;">
        <div class="offcanvas-header bg-primary text-white border-bottom">
            <h5 class="offcanvas-title fw-bold">
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
                    <a class="nav-link text-muted" href="<?php echo e(route('customer.account.profile.edit')); ?>">
                        <i class="bi bi-person-circle me-2"></i>Minha Conta
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="<?php echo e(route('shop.index')); ?>">
                        <i class="bi bi-heart-fill me-2"></i>Lista de Desejos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="<?php echo e(route('shop.index')); ?>">
                        <i class="bi bi-cart-fill me-2"></i>Meu Carrinho
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Barra de Categorias -->
    <div class="shadow-sm d-none d-md-block" style="background-color: <?php echo e($storeSettings['color_category_bar'] ?? '#f0f8ff'); ?> !important; border-top: 1px solid rgba(0,0,0,0.05) !important;">
        <div class="container py-2" style="max-width: 1200px;">
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