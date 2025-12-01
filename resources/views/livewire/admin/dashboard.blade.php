<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">Bem-vindo, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-muted">Painel de Controle do E-commerce</p>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <!-- Produtos -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Produtos</h6>
                            <h2 class="mb-0">{{ $totalProducts }}</h2>
                            <small class="text-success">{{ $activeProducts }} ativos</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categorias -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Categorias</h6>
                            <h2 class="mb-0">{{ $totalCategories }}</h2>
                            <small class="text-muted">Organizadas</small>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-folder text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clientes -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Clientes</h6>
                            <h2 class="mb-0">{{ $totalUsers }}</h2>
                            <small class="text-muted">Cadastrados</small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estoque Baixo -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Estoque Baixo</h6>
                            <h2 class="mb-0 text-warning">{{ $lowStockProducts }}</h2>
                            <small class="text-warning">Requer atenção</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Produtos -->
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-box-seam d-block mb-2" style="font-size: 2rem;"></i>
                                Gerenciar Produtos
                            </a>
                        </div>

                        <!-- Categorias -->
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-folder d-block mb-2" style="font-size: 2rem;"></i>
                                Gerenciar Categorias
                            </a>
                        </div>

                        <!-- Pedidos -->
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-cart-check d-block mb-2" style="font-size: 2rem;"></i>
                                Ver Pedidos
                            </a>
                        </div>

                        <!-- Usuários -->
                        <div class="col-md-6 col-lg-3">
                            <a href="#" class="btn btn-outline-secondary w-100 py-3">
                                <i class="bi bi-people d-block mb-2" style="font-size: 2rem;"></i>
                                Gerenciar Usuários
                            </a>
                        </div>

                        <!-- Email Marketing -->
                        <div class="col-md-6 col-lg-3">
                            <a href="#" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-envelope d-block mb-2" style="font-size: 2rem;"></i>
                                Campanhas de Email
                            </a>
                        </div>

                        <!-- Páginas de Conteúdo -->
                        <div class="col-md-6 col-lg-3">
                            <a href="#" class="btn btn-outline-dark w-100 py-3">
                                <i class="bi bi-file-earmark-text d-block mb-2" style="font-size: 2rem;"></i>
                                Páginas de Conteúdo
                            </a>
                        </div>

                        <!-- Configurações -->
                        <div class="col-md-6 col-lg-3">
                            <a href="#" class="btn btn-outline-danger w-100 py-3">
                                <i class="bi bi-gear d-block mb-2" style="font-size: 2rem;"></i>
                                Configurações
                            </a>
                        </div>

                        <!-- Ver Loja -->
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('shop.index') }}" target="_blank" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-shop d-block mb-2" style="font-size: 2rem;"></i>
                                Ver Loja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
