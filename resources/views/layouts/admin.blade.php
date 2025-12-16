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
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Quill WYSIWYG -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    @stack('styles')
    
</head>
<body>
    <!-- Navbar (Fixed Top) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow px-3 mb-4">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('logo.svg') }}" alt="LosFit" height="30" class="d-inline-block align-text-top me-2" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 60%22%3E%3Ctext x=%2210%22 y=%2240%22 font-family=%22Arial,sans-serif%22 font-size=%2230%22 font-weight=%22bold%22 fill=%22%23ffd700%22%3ELosFit%3C/text%3E%3C/svg%3E';">
                <span class="fs-6 fw-bold text-uppercase text-warning">Admin</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar" aria-controls="topNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="topNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active text-warning' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-fill me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.cms.*') ? 'active text-warning' : '' }}" href="{{ route('admin.cms.pages.index') }}">
                            <i class="bi bi-file-text me-1"></i> Páginas
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <a href="{{ route('shop.index') }}" target="_blank" class="btn btn-outline-light btn-sm me-3">
                        <i class="bi bi-shop me-1"></i> Ver Loja
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-link text-white text-decoration-none opacity-75 hover-opacity-100">
                             <i class="bi bi-box-arrow-right me-1"></i> Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <main class="col-12">
                 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title', 'Dashboard')</h1>
                    
                    @if(!request()->routeIs('admin.dashboard'))
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Voltar ao Início
                            </a>
                        </div>
                    @endif
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
