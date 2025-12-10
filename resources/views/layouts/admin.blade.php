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
    

    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar p-0">
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

                        <!-- Catálogo (Antigo Dados de Itens) -->
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#catalogMenu" 
                               role="button" 
                               aria-expanded="{{ request()->routeIs('admin.products.*', 'admin.categories.*', 'admin.types.*', 'admin.models.*', 'admin.materials.*', 'admin.colors.*', 'admin.sizes.*') ? 'true' : 'false' }}">
                                <span><i class="bi bi-tag"></i> Catálogo</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('admin.products.*', 'admin.categories.*', 'admin.types.*', 'admin.models.*', 'admin.materials.*', 'admin.colors.*', 'admin.sizes.*') ? 'show' : '' }}" 
                                 id="catalogMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.products.index') }}">
                                            <i class="bi bi-box"></i> Produtos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.categories.index') }}">
                                            <i class="bi bi-folder"></i> Categorias
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

                        <!-- CRM -->
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#crmMenu" 
                               role="button" 
                               aria-expanded="{{ request()->routeIs('admin.crm.*', 'admin.users.*', 'admin.leads.*', 'admin.newsletter.*') ? 'true' : 'false' }}">
                                <span><i class="bi bi-people-fill"></i> CRM</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('admin.crm.*', 'admin.users.*', 'admin.leads.*', 'admin.newsletter.*') ? 'show' : '' }}" 
                                 id="crmMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.users.index') }}">
                                            <i class="bi bi-person-badge"></i> Clientes
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.leads.index') }}">
                                            <i class="bi bi-funnel"></i> Leads
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.newsletter.contacts') ? 'active' : '' }}" 
                                           href="{{ route('admin.newsletter.contacts') }}">
                                            <i class="bi bi-chat-left-text"></i> Contatos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.newsletter.campaigns', 'admin.newsletter.campaign.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.newsletter.campaigns') }}">
                                            <i class="bi bi-megaphone"></i> Campanha Newsletter
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.crm.organic-traffic') ? 'active' : '' }}" 
                                           href="{{ route('admin.crm.organic-traffic') }}">
                                            <i class="bi bi-graph-up"></i> Tráfego Orgânico
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex justify-content-between align-items-center collapsed" 
                                           data-bs-toggle="collapse" 
                                           href="#paidTrafficSubMenu" 
                                           role="button" 
                                           aria-expanded="{{ request()->routeIs('admin.crm.paid-traffic') ? 'true' : 'false' }}">
                                            <span><i class="bi bi-currency-dollar"></i> Tráfego Pago</span>
                                            <i class="bi bi-chevron-down"></i>
                                        </a>
                                        <div class="collapse {{ request()->routeIs('admin.crm.paid-traffic') ? 'show' : '' }}" id="paidTrafficSubMenu">
                                            <ul class="nav flex-column ms-3">
                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->fullUrlIs(route('admin.crm.paid-traffic', ['source' => 'meta'])) ? 'active' : '' }}" 
                                                       href="{{ route('admin.crm.paid-traffic', ['source' => 'meta']) }}">
                                                        <i class="bi bi-facebook"></i> Meta Ads
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->fullUrlIs(route('admin.crm.paid-traffic', ['source' => 'google'])) ? 'active' : '' }}" 
                                                       href="{{ route('admin.crm.paid-traffic', ['source' => 'google']) }}">
                                                        <i class="bi bi-google"></i> Google Ads
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->fullUrlIs(route('admin.crm.paid-traffic', ['source' => 'tiktok'])) ? 'active' : '' }}" 
                                                       href="{{ route('admin.crm.paid-traffic', ['source' => 'tiktok']) }}">
                                                        <i class="bi bi-tiktok"></i> TikTok Ads
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.crm.reports') ? 'active' : '' }}" 
                                           href="{{ route('admin.crm.reports') }}">
                                            <i class="bi bi-bar-chart-fill"></i> Relatórios
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Marketing (Visual & Content) -->
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#marketingMenu" 
                               role="button" 
                               aria-expanded="{{ request()->routeIs('admin.stories.*', 'admin.grid.*', 'admin.links.*', 'admin.email-cards.*') ? 'true' : 'false' }}">
                                <span><i class="bi bi-palette"></i> Visual & Conteúdo</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('admin.stories.*', 'admin.grid.*', 'admin.links.*', 'admin.email-cards.*') ? 'show' : '' }}" 
                                 id="marketingMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.stories.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.stories.index') }}">
                                            <i class="bi bi-instagram"></i> Stories
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.grid.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.grid.index') }}">
                                            <i class="bi bi-grid-3x3"></i> Layout do Grid
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.links.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.links.index') }}">
                                            <i class="bi bi-link-45deg"></i> Links da Bio
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.email-cards.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.email-cards.index') }}">
                                            <i class="bi bi-card-image"></i> Cards de Email
                                        </a>
                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.newsletter.templates') ? 'active' : '' }}" 
                                           href="{{ route('admin.newsletter.templates') }}">
                                            <i class="bi bi-file-earmark-text"></i> Modelos de Email
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
            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-md-4">
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
                {{ $slot ?? '' }}
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
