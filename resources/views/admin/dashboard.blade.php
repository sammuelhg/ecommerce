@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    
    <!-- SECTION: CATÁLOGO -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-tag me-2"></i>Catálogo & Produtos
    </h5>
    <div class="row g-4 mb-5">
        <!-- Produtos -->
        <div class="col-md-3">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-primary-subtle">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-box fs-1 mb-3 text-primary"></i>
                        <h5 class="card-title fw-bold mb-0">Produtos</h5>
                        <small class="text-muted mt-2">Gerenciar itens</small>
                    </div>
                </div>
            </a>
        </div>
        <!-- Categorias -->
        <div class="col-md-3">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-success-subtle">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <i class="bi bi-folder fs-1 mb-3 text-success"></i>
                        <h5 class="card-title fw-bold mb-0">Categorias</h5>
                        <small class="text-muted mt-2">Organizar loja</small>
                    </div>
                </div>
            </a>
        </div>
        <!-- Attributes Group (Small Cards) -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted">Atributos do Produto</h6>
                    <div class="row text-center g-2">
                        <div class="col">
                            <a href="{{ route('admin.types.index') }}" class="btn btn-outline-light text-dark w-100 py-3 border">
                                <i class="bi bi-tags d-block fs-4 text-info mb-1"></i> Tipos
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.models.index') }}" class="btn btn-outline-light text-dark w-100 py-3 border">
                                <i class="bi bi-diagram-3 d-block fs-4 text-secondary mb-1"></i> Modelos
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.colors.index') }}" class="btn btn-outline-light text-dark w-100 py-3 border">
                                <i class="bi bi-paint-bucket d-block fs-4 text-danger mb-1"></i> Cores
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.sizes.index') }}" class="btn btn-outline-light text-dark w-100 py-3 border">
                                <i class="bi bi-rulers d-block fs-4 text-dark mb-1"></i> Tamanhos
                            </a>
                        </div>
                         <div class="col">
                            <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-light text-dark w-100 py-3 border">
                                <i class="bi bi-palette d-block fs-4 text-warning mb-1"></i> Materiais
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION: VENDAS -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-cart me-2"></i>Gestão de Vendas
    </h5>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <a href="{{ route('admin.orders.index', ['type' => 'incoming']) }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-info-subtle">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-box-arrow-in-down fs-1 text-info"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-1">Pedidos de Entrada</h5>
                        <p class="card-text text-muted small">Novas vendas aguardando</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.orders.index', ['type' => 'outgoing']) }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-box-arrow-up fs-1 mb-3 text-primary"></i>
                        <h5 class="card-title fw-bold">Pedidos de Saída</h5>
                        <p class="card-text text-muted small">Enviados / Em rota</p>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-4">
            <a href="{{ route('admin.orders.index', ['type' => 'returns']) }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-danger-subtle">
                    <div class="card-body py-4">
                        <i class="bi bi-arrow-counterclockwise fs-1 mb-3 text-danger"></i>
                        <h5 class="card-title fw-bold">Devoluções</h5>
                        <p class="card-text text-muted small">Trocas e cancelamentos</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- SECTION: MARKETING -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-megaphone me-2"></i>Marketing & Conteúdo
    </h5>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <a href="{{ route('admin.newsletter.campaigns') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-send fs-1 mb-3 text-success"></i>
                        <h5 class="card-title fw-bold">Newsletter</h5>
                        <small class="text-muted">Hub de Marketing</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.stories.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-instagram fs-1 mb-3 text-danger"></i>
                        <h5 class="card-title fw-bold">Stories</h5>
                        <small class="text-muted">Destaques do App</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             <a href="{{ route('admin.grid.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-grid-3x3 fs-1 mb-3 text-info"></i>
                        <h5 class="card-title fw-bold">Layout</h5>
                        <small class="text-muted">Vitrines e Banners</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- SECTION: SISTEMA -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-gear me-2"></i>Sistema
    </h5>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm hover-card flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-people fs-2 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Clientes</h6>
                        <small class="text-muted">Gerenciar usuários</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm hover-card flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-sliders fs-2 text-secondary"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Configurações Gerais</h6>
                        <small class="text-muted">Identidade, Cores, SMTP</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>

<style>
    .hover-card {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
