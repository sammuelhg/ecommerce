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

    <!-- CRM & Marketing Stats -->
    <div class="row g-4 mb-4">
        <!-- Leads -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Leads Capturados</h6>
                            <h2 class="mb-0">{{ $totalLeads }}</h2>
                            <small class="text-primary">Novas oportunidades</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-funnel text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulários -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Formulários</h6>
                            <h2 class="mb-0">{{ $totalForms }}</h2>
                            <small class="text-info">Campanhas ativas</small>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-ui-checks text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Best Sellers -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                 <div class="card-header bg-white">
                    <h5 class="mb-0 text-primary"><i class="bi bi-trophy-fill me-2 text-warning"></i>Top Produtos Mais Vendidos</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Vendas</th>
                                <th class="text-center">Estoque</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bestSellers as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-box text-muted"></i>
                                                </div>
                                            @endif
                                            <span class="fw-bold text-dark">{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $item->total_qty }} un</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $item->product->stock > 10 ? 'success' : 'warning' }} bg-opacity-10 text-{{ $item->product->stock > 10 ? 'success' : 'warning' }}">
                                            {{ $item->product->stock }} em estoque
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Nenhum produto vendido recentemente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Leads Table -->
    <div class="row mb-4">
         <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                     <h5 class="mb-0">Últimos Leads</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Email</th>
                                <th>Origem (Formulário)</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLeads as $lead)
                                <tr>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->form->title ?? 'N/A' }}</td>
                                    <td>{{ $lead->created_at->diffForHumans() }}</td>
                                    <td>
                                        <span class="badge bg-{{ $lead->status->color() }}">
                                            {{ $lead->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Nenhum lead encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
         </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
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
