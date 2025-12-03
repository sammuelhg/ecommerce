<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog') }}" class="text-decoration-none">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Detalhes do Produto -->
    <div class="row mb-5">
        <!-- Imagem -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="img-fluid rounded" 
                         alt="{{ $product->name }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                        <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informações -->
        <div class="col-md-6">
            <h1 class="fw-bold mb-2">{{ $product->name }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-secondary">{{ $product->category->name ?? 'Geral' }}</span>
                @if($product->stock > 0)
                    <span class="badge bg-success ms-2">Em Estoque</span>
                @else
                    <span class="badge bg-danger ms-2">Esgotado</span>
                @endif
            </div>

            <h2 class="text-primary fw-bold mb-4">
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </h2>

            <p class="lead text-muted mb-4">
                {{ $product->description }}
            </p>

            @if($product->stock > 0)
                <div class="d-flex align-items-center mb-4">
                    <div class="input-group" style="width: 140px;">
                        <button wire:click="decrementQuantity" class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="text" class="form-control bg-white text-center" value="{{ $quantity }}" readonly>
                        <button wire:click="incrementQuantity" class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <span class="ms-3 text-muted small">{{ $product->stock }} unidades disponíveis</span>
                </div>

                <button wire:click="addToCart" class="btn btn-primary btn-lg w-100 mb-3">
                    <i class="bi bi-cart-plus me-2"></i> Adicionar ao Carrinho
                </button>

                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @else
                <div class="alert alert-warning">
                    Este produto está indisponível no momento.
                </div>
            @endif
        </div>
    </div>

    <!-- Produtos Relacionados -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12 mb-4">
                <h3 class="fw-bold">Produtos Relacionados</h3>
                <hr>
            </div>
            
            @foreach($relatedProducts as $related)
                <div class="col-sm-6 col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" 
                                     class="card-img-top object-fit-cover h-100" 
                                     alt="{{ $related->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-truncate">{{ $related->name }}</h6>
                            <p class="card-text text-primary fw-bold">
                                R$ {{ number_format($related->price, 2, ',', '.') }}
                            </p>
                            <a href="{{ route('product.show', $related->slug) }}" class="btn btn-outline-primary btn-sm w-100 stretched-link">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <style>
    .hover-card {
        transition: transform 0.2s;
    }
    .hover-card:hover {
        transform: translateY(-5px);
    }
    </style>
</div>
