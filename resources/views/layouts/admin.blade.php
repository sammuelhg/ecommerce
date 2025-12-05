<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - LosFit</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Card Styles -->
    <link href="{{ asset('css/card-styles.css') }}" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    
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
        
        /* Submenu styles */
        .admin-nav .nav-link[data-bs-toggle="collapse"] {
            cursor: pointer;
        }
        
        .admin-nav .nav-link .bi-chevron-down {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }
        
        .admin-nav .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }
        
        .admin-nav .collapse .nav-link {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            font-size: 0.9rem;
        }
        
        .admin-nav .collapse .nav-link i {
            width: 16px;
            font-size: 0.9rem;
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
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar p-0 position-relative">
                <div class="d-flex flex-column h-100">
                    <!-- Logo -->
                    <div class="admin-logo">
                        <a href="{{ route('shop.index') }}" target="_blank" title="Ir para a Loja">
                            <img src="{{ asset('logo.svg') }}" alt="LosFit" style="height: 90px; width: auto;" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 60%22%3E%3Ctext x=%2210%22 y=%2240%22 font-family=%22Arial,sans-serif%22 font-size=%2230%22 font-weight=%22bold%22 fill=%22%23ffd700%22%3ELosFit%3C/text%3E%3C/svg%3E';">
                        </a>
                    </div>

                    <!-- Logout Button -->
                    <div class="logout-btn">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light" title="Sair">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Navigation -->
                    <ul class="nav flex-column admin-nav pt-3">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>

                        <!-- Dados de Itens (Data Items) -->
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#dataItemsMenu" 
                               role="button" 
                               aria-expanded="{{ request()->routeIs('admin.categories.*', 'admin.products.*', 'admin.types.*', 'admin.models.*', 'admin.materials.*', 'admin.colors.*', 'admin.sizes.*') ? 'true' : 'false' }}">
                                <span><i class="bi bi-database"></i> Dados de Itens</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('admin.categories.*', 'admin.products.*', 'admin.types.*', 'admin.models.*', 'admin.materials.*', 'admin.colors.*', 'admin.sizes.*') ? 'show' : '' }}" 
                                 id="dataItemsMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.categories.index') }}">
                                            <i class="bi bi-folder"></i> Categorias
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.products.index') }}">
                                            <i class="bi bi-box"></i> Produtos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.types.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.types.index') }}">
                                            <i class="bi bi-tags"></i> Tipos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.models.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.models.index') }}">
                                            <i class="bi bi-diagram-3"></i> Modelos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.materials.index') }}">
                                            <i class="bi bi-palette"></i> Materiais
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.colors.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.colors.index') }}">
                                            <i class="bi bi-paint-bucket"></i> Cores
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.sizes.index') }}">
                                            <i class="bi bi-rulers"></i> Tamanhos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Pedidos (Orders) -->
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#ordersMenu" 
                               role="button" 
                               aria-expanded="{{ request()->routeIs('admin.orders.*') ? 'true' : 'false' }}">
                                <span><i class="bi bi-cart-check"></i> Pedidos</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('admin.orders.*') ? 'show' : '' }}" 
                                 id="ordersMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.orders.incoming') ? 'active' : '' }}" 
                                           href="{{ route('admin.orders.index', ['type' => 'incoming']) }}">
                                            <i class="bi bi-box-arrow-in-down"></i> Entrada
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.orders.outgoing') ? 'active' : '' }}" 
                                           href="{{ route('admin.orders.index', ['type' => 'outgoing']) }}">
                                            <i class="bi bi-box-arrow-up"></i> Saída
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.orders.returns') ? 'active' : '' }}" 
                                           href="{{ route('admin.orders.index', ['type' => 'returns']) }}">
                                            <i class="bi bi-arrow-counterclockwise"></i> Devoluções
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Configurações -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                               href="{{ route('admin.settings.index') }}">
                                <i class="bi bi-gear"></i> Configurações
                            </a>
                        </li>

                        <!-- Usuários Clientes -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> Usuários Clientes
                            </a>
                        </li>
                    </ul>

                    <!-- Home Link -->
                    <div class="home-link mt-auto">
                        <a href="{{ route('shop.index') }}" target="_blank">
                            <i class="bi bi-house-door"></i>
                            <span>Ir para Loja</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="admin-header">
                    <h1 class="h2 mb-0">@yield('title', 'Dashboard')</h1>
                </div>
                
                @if(session('success') || session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') ?? session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Media Library Modal Component -->
    <livewire:admin.media-library />

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div id="validationToast" class="toast" role="alert">
            <div class="toast-header bg-danger text-white">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong class="me-auto">Erro de Validação</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="validationToastBody"></div>
        </div>

        <!-- Generic Live Toast -->
        <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="liveToastBody"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')

    <script>
        document.addEventListener('livewire:init', () => {

            window.Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                fail((response) => {
                    // Check if response exists (network errors may pass undefined)
                    if (!response) {
                        console.warn('Livewire network error detected');
                        return;
                    }

                    const { status, response: responseData } = response;

                    if (status === 422 && responseData?.errors) {
                        let errorHtml = '<ul class="mb-0 ps-3">';

                        Object.values(responseData.errors).forEach(errorArray => {
                            errorArray.forEach(error => {
                                errorHtml += `<li>${error}</li>`;
                            });
                        });

                        errorHtml += '</ul>';

                        document.getElementById('validationToastBody').innerHTML = errorHtml;

                        const toast = new bootstrap.Toast(
                            document.getElementById('validationToast'),
                            { delay: 5000 }
                        );

                        toast.show();
                    }

                });
            });

            // EVENTO EMITIDO PELO COMPONENTE LIVEWIRE (V3)
            window.Livewire.on('show-validation-toast', (event) => {

                const errors = event?.errors ?? event?.[0]?.errors;

                if (errors) {
                    let errorHtml = '<ul class="mb-0 ps-3">';

                    Object.values(errors).forEach(errorArray => {
                        errorArray.forEach(error => {
                            errorHtml += `<li>${error}</li>`;
                        });
                    });

                    errorHtml += '</ul>';

                    document.getElementById('validationToastBody').innerHTML = errorHtml;

                    const toast = new bootstrap.Toast(
                        document.getElementById('validationToast'),
                        { delay: 5000 }
                    );

                    toast.show();
                }

            });

            // Generic Toast Listener
            window.Livewire.on('show-toast', (event) => {
                // Handle both array (from PHP named args sometimes) and object formats
                const data = event[0] || event;
                const type = data.type || 'info';
                const message = data.message || '';
                
                const toastEl = document.getElementById('liveToast');
                const toastBody = document.getElementById('liveToastBody');
                
                // Reset classes
                toastEl.className = 'toast align-items-center text-white border-0';
                
                // Add type class
                if (type === 'success') toastEl.classList.add('bg-success');
                else if (type === 'error') toastEl.classList.add('bg-danger');
                else if (type === 'warning') toastEl.classList.add('bg-warning');
                else toastEl.classList.add('bg-info');
                
                // Set content
                let icon = '';
                if (type === 'success') icon = '<i class="bi bi-check-circle-fill me-2"></i>';
                else if (type === 'error') icon = '<i class="bi bi-exclamation-circle-fill me-2"></i>';
                else if (type === 'warning') icon = '<i class="bi bi-exclamation-triangle-fill me-2"></i>';
                else icon = '<i class="bi bi-info-circle-fill me-2"></i>';
                
                toastBody.innerHTML = icon + message;
                
                const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
                toast.show();
            });

        });
    </script>
</body>
</html>
