<div class="container py-5">
    <!-- Cabeçalho -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold">Nossos Produtos</h1>
            <p class="text-muted">Explore nossa seleção de produtos</p>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="row mb-4">
        <!-- Busca -->
        <div class="col-md-4 mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input wire:model.live.debounce.300ms="search" 
                       type="text" 
                       class="form-control" 
                       placeholder="Buscar produtos...">
            </div>
        </div>

        <!-- Filtro de Categoria -->
        <div class="col-md-4 mb-3">
            <select wire:model.live="categoryFilter" class="form-select">
                <option value="">Todas as Categorias</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }} ({{ $category->products_count }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Ordenação -->
        <div class="col-md-4 mb-3">
            <select wire:model.live="sortBy" class="form-select">
                <option value="newest">Mais Recentes</option>
                <option value="name">Nome (A-Z)</option>
                <option value="price_asc">Menor Preço</option>
                <option value="price_desc">Maior Preço</option>
            </select>
        </div>
    </div>

    <!-- Grid de Produtos -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm hover-shadow transition">
                    <!-- Imagem do Produto -->
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="card-img-top object-fit-cover h-100" 
                                 alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <!-- Badge de Estoque Baixo -->
                        @if($product->stock < 10)
                            <span class="position-absolute top-0 end-0 m-2 badge bg-warning">
                                Últimas {{ $product->stock }} unidades
                            </span>
                        @endif
                    </div>

                    <!-- Corpo do Card -->
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-truncate" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h6>
                        
                        <p class="card-text text-muted small flex-grow-1" 
                           style="height: 40px; overflow: hidden;">
                            {{ Str::limit($product->description, 80) }}
                        </p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 mb-0 text-primary fw-bold">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </span>
                                @if($product->stock > 0)
                                    <small class="text-success">
                                        <i class="bi bi-check-circle-fill"></i> Em estoque
                                    </small>
                                @else
                                    <small class="text-danger">
                                        <i class="bi bi-x-circle-fill"></i> Esgotado
                                    </small>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('product.show', $product->slug) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Ver Detalhes
                                </a>
                                @if($product->stock > 0)
                                    <button class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i> Adicionar ao Carrinho
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-x-circle"></i> Indisponível
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Nenhum produto encontrado</h4>
                    <p class="mb-0">
                        @if($search || $categoryFilter)
                            Tente ajustar seus filtros de busca.
                        @else
                            Ainda não há produtos cadastrados.
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($products->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                {{ $products->links() }}
            </div>
        </div>
    @endif
    <style>
    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }

    .transition {
        transition: all 0.3s ease;
    }
    </style>
</div>
