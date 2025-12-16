<div>
@section('title', 'Dashboard')

    <!-- SECTION: CATÁLOGO -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-tag me-2"></i>Catálogo
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
        <!-- Attributes Group -->
        <div class="col-md-6">
             <div class="card h-100 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted">Atributos do Produto</h6>
                    <div class="row text-center g-2">
                        <div class="col-4">
                            <a href="{{ route('admin.types.index') }}" class="btn btn-white w-100 py-3 border shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-tags fs-2 text-info mb-1"></i> <span class="small fw-bold">Tipos</span>
                            </a>
                        </div>
                        <div class="col-4">
                             <a href="{{ route('admin.models.index') }}" class="btn btn-white w-100 py-3 border shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-diagram-3 fs-2 text-secondary mb-1"></i> <span class="small fw-bold">Modelos</span>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="{{ route('admin.sizes.index') }}" class="btn btn-white w-100 py-3 border shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-rulers fs-2 text-dark mb-1"></i> <span class="small fw-bold">Tamanhos</span>
                            </a>
                        </div>
                        <div class="col-4">
                             <a href="{{ route('admin.materials.index') }}" class="btn btn-white w-100 py-3 border shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-palette fs-2 text-warning mb-1"></i> <span class="small fw-bold">Materiais</span>
                            </a>
                        </div>
                         <div class="col-4">
                             <a href="{{ route('admin.flavors.index') }}" class="btn btn-white w-100 py-3 border shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-droplet fs-2 text-success mb-1"></i> <span class="small fw-bold">Sabores</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION: CRM & VENDAS -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-people-fill me-2"></i>CRM & Vendas
    </h5>
    <div class="row g-4 mb-5">
         <div class="col-md-3">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-person-circle fs-1 mb-3 text-primary"></i>
                        <h5 class="card-title fw-bold">Clientes</h5>
                        <small class="text-muted">Usuários do sistema</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             <a href="{{ route('admin.leads.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-funnel fs-1 mb-3 text-warning"></i>
                        <h5 class="card-title fw-bold">Leads</h5>
                        <small class="text-muted">Captura de contatos</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
             <a href="{{ route('admin.leads.kanban') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-warning-subtle">
                    <div class="card-body py-4">
                        <i class="bi bi-kanban fs-1 mb-3 text-warning"></i>
                        <h5 class="card-title fw-bold">Pipeline</h5>
                        <small class="text-muted">Kanban de Negócios</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             <a href="{{ route('admin.funnel.automations') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-warning-subtle">
                    <div class="card-body py-4">
                        <i class="bi bi-lightning-charge fs-1 mb-3 text-primary"></i>
                        <h5 class="card-title fw-bold">Automações</h5>
                        <small class="text-muted">Funis e Gatilhos</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             <a href="{{ route('admin.crm.forms.builder') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-warning-subtle">
                    <div class="card-body py-4">
                         <i class="bi bi-ui-checks fs-1 mb-3 text-warning"></i>
                        <h5 class="card-title fw-bold">Formulários</h5>
                        <small class="text-muted">Landing Pages</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
            <a href="{{ route('admin.marketing.contacts') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-chat-left-text fs-1 mb-3 text-info"></i>
                        <h5 class="card-title fw-bold">Contatos</h5>
                        <small class="text-muted">Lista da Newsletter</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
            <a href="{{ route('admin.campaigns.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-megaphone fs-1 mb-3 text-danger"></i>
                        <h5 class="card-title fw-bold">Campanhas</h5>
                        <small class="text-muted">Disparos de Email</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-info-subtle">
                    <div class="card-body py-4">
                        <i class="bi bi-cart4 fs-1 mb-3 text-success"></i>
                        <h5 class="card-title fw-bold">Pedidos</h5>
                        <small class="text-muted">Gerenciar Vendas</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.crm.organic-traffic') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-graph-up fs-1 mb-3 text-dark"></i>
                        <h5 class="card-title fw-bold">Tráfego Orgânico</h5>
                        <small class="text-muted">SEO e Visitantes</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             <a href="{{ route('admin.crm.paid-traffic') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-currency-dollar fs-1 mb-3 text-success"></i>
                        <h5 class="card-title fw-bold">Tráfego Pago</h5>
                        <small class="text-muted">Ads & Investimento</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             <a href="{{ route('admin.crm.reports') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-file-earmark-bar-graph fs-1 mb-3 text-secondary"></i>
                        <h5 class="card-title fw-bold">Relatórios</h5>
                        <small class="text-muted">Financeiro e Métricas</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             <a href="{{ route('admin.crm.expenses.general') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-wallet2 fs-1 mb-3 text-secondary"></i>
                        <h5 class="card-title fw-bold">Outros Custos</h5>
                        <small class="text-muted">Investimentos Gerais</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
     <!-- SECTION: VISUAL & CONTEÚDO -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-palette me-2"></i>Visual & Conteúdo
    </h5>
    <div class="row g-4 mb-5">
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
                        <h5 class="card-title fw-bold">Layout Grid</h5>
                        <small class="text-muted">Vitrines e Banners</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
             <a href="{{ route('admin.links.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-link-45deg fs-1 mb-3 text-dark"></i>
                        <h5 class="card-title fw-bold">Links da Bio</h5>
                        <small class="text-muted">Linktree & Redes</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
             <a href="{{ route('admin.sign-cards') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-card-image fs-1 mb-3 text-secondary"></i>
                        <h5 class="card-title fw-bold">Cartões & Assinatura</h5>
                        <small class="text-muted">Cards e Assinaturas</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
             <a href="{{ route('admin.cms.pages.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                         <i class="bi bi-layout-text-window-reverse fs-1 mb-3 text-primary"></i>
                        <h5 class="card-title fw-bold">Páginas CMS</h5>
                        <small class="text-muted">Landing Pages</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
             <a href="{{ route('admin.cms.components.index') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-puzzle fs-1 mb-3 text-secondary"></i>
                        <h5 class="card-title fw-bold">Componentes</h5>
                        <small class="text-muted">Partes Reutilizáveis</small>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- SECTION: INTEGRAÇÕES -->
    <h5 class="mb-3 text-secondary border-bottom pb-2">
        <i class="bi bi-hdd-network me-2"></i>Integrações
    </h5>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
             <a href="{{ route('admin.integrations.index', ['tab' => 'meta']) }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-primary-subtle">
                    <div class="card-body py-4">
                        <i class="bi bi-facebook fs-1 mb-3 text-primary"></i>
                        <h5 class="card-title fw-bold">Meta Ads</h5>
                        <small class="text-muted">Pixel & CAPI</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
             <a href="{{ route('admin.integrations.index', ['tab' => 'google']) }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-danger-subtle">
                    <div class="card-body py-4">
                        <i class="bi bi-google fs-1 mb-3 text-danger"></i>
                        <h5 class="card-title fw-bold">Google Ads</h5>
                        <small class="text-muted">Conversions API</small>
                    </div>
                </div>
            </a>
        </div>
         <div class="col-md-3">
             <a href="{{ route('admin.integrations.index', ['tab' => 'tiktok']) }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-dark-subtle">
                    <div class="card-body py-4">
                        <i class="bi bi-tiktok fs-1 mb-3 text-dark"></i>
                        <h5 class="card-title fw-bold">TikTok Ads</h5>
                        <small class="text-muted">Events API</small>
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
        <div class="col-md-3">
            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-sliders fs-1 mb-3 text-secondary"></i>
                        <h5 class="card-title fw-bold">Configurações</h5>
                        <small class="text-muted">Identidade, SMTP</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.settings.team') }}" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-shield-lock fs-1 mb-3 text-dark"></i>
                        <h5 class="card-title fw-bold">Equipe</h5>
                        <small class="text-muted">Gerenciar Acessos</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.settings.billing') }}" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm hover-card">
                    <div class="card-body py-4">
                        <i class="bi bi-credit-card fs-1 mb-3 text-success"></i>
                        <h5 class="card-title fw-bold">Faturamento</h5>
                        <small class="text-muted">Assinatura e Notas</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <style>
        .hover-card {
            transition: all 0.2s ease-in-out;
            border: 1px solid rgba(0,0,0,0.05);
            cursor: pointer;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important;
            border-color: rgba(0,0,0,0.1);
        }
        .btn-white {
            background-color: #fff;
            color: #333;
        }
        .btn-white:hover {
            background-color: #f8f9fa;
        }
    </style>
</div>
