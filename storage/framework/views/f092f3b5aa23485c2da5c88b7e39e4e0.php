<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Admin - LosFit</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    
   <style>
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .admin-logo {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }
        
        .admin-logo img {
            max-width: 150px;
            height: auto;
        }
        
        .admin-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .admin-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-left-color: #ffd700;
        }
        
        .admin-nav .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border-left-color: #ffd700;
            font-weight: 600;
        }
        
        .admin-nav .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }
        
        .home-link {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }
        
        .home-link a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }
        
        .home-link a:hover {
            color: #ffd700;
        }
        
        .admin-header {
            background: #fff;
            padding: 1rem 2rem;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 2rem;
        }
        
        .logout-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar p-0 position-relative">
                <div class="d-flex flex-column h-100">
                    <!-- Logo -->
                    <div class="admin-logo">
                        <img src="<?php echo e(asset('logo.svg')); ?>" alt="LosFit" style="height: 90px; width: auto;" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 60%22%3E%3Ctext x=%2210%22 y=%2240%22 font-family=%22Arial,sans-serif%22 font-size=%2230%22 font-weight=%22bold%22 fill=%22%23ffd700%22%3ELosFit%3C/text%3E%3C/svg%3E';">
                    </div>

                    <!-- Logout Button -->
                    <div class="logout-btn">
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-light" title="Sair">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Navigation -->
                    <ul class="nav flex-column admin-nav pt-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.dashboard')); ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.products.index')); ?>">
                                <i class="bi bi-box"></i> Produtos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.categories.index')); ?>">
                                <i class="bi bi-folder"></i> Categorias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.types.*') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.types.index')); ?>">
                                <i class="bi bi-tags"></i> Tipos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.materials.*') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.materials.index')); ?>">
                                <i class="bi bi-palette"></i> Materiais
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.models.*') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.models.index')); ?>">
                                <i class="bi bi-diagram-3"></i> Modelos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.orders.index')); ?>">
                                <i class="bi bi-cart-check"></i> Pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('admin.settings.index')); ?>">
                                <i class="bi bi-gear"></i> Configurações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>" 
                               href="<?php echo e(route('profile')); ?>">
                                <i class="bi bi-person-circle"></i> Meu Perfil
                            </a>
                        </li>
                    </ul>

                    <!-- Home Link -->
                    <div class="home-link mt-auto">
                        <a href="<?php echo e(route('shop.index')); ?>" target="_blank">
                            <i class="bi bi-house-door"></i>
                            <span>Ir para Loja</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="admin-header">
                    <h1 class="h2 mb-0"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                </div>
                
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/layouts/admin.blade.php ENDPATH**/ ?>