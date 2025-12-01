@extends('layouts.shop')

@section('title', $product->name . ' - ' . config('app.name'))

@section('meta')
    <meta name="description" content="{{ $product->marketing_description ?? $product->description }}">
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ $product->marketing_description ?? $product->description }}">
    <meta property="og:image" content="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : asset('logo.svg') }}">
    <meta property="product:price:amount" content="{{ $product->price }}">
    <meta property="product:price:currency" content="BRL">
@endsection

@section('content')
<div class="container py-4">
    <div class="product-card">
        
        <div class="row">

            <!-- Coluna de Imagens (Esquerda) -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <!-- Imagem Principal -->
                <div class="mb-3">
                    <img id="mainProductImage" 
                         src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/800x800/f0f8ff/1a1a1a?text='.urlencode($product->name) }}" 
                         class="main-image shadow-sm w-100 rounded" 
                         alt="{{ $product->name }}"
                         style="object-fit: cover; aspect-ratio: 1; cursor: zoom-in;"
                         onerror="this.onerror=null;this.src='https://placehold.co/800x800/f0f8ff/1a1a1a?text=Imagem+Indispon%C3%ADvel';">
                </div>

                <!-- Galeria de Miniaturas -->
                @if($product->images->count() > 0)
                    <div class="row row-cols-4 g-2">
                        @foreach($product->images as $image)
                            <div class="col">
                                <img src="{{ asset('storage/' . $image->path) }}" 
                                     class="img-fluid thumbnail-image rounded {{ $image->is_main ? 'active border border-2 border-primary' : 'border border-secondary opacity-75' }}" 
                                     alt="Imagem {{ $loop->iteration }}"
                                     style="cursor: pointer; aspect-ratio: 1; object-fit: cover; transition: all 0.3s;"
                                     onclick="changeMainImage(this.src)"
                                     onmouseover="this.style.opacity='1'; this.classList.add('shadow')"
                                     onmouseout="this.style.opacity='{{ $image->is_main ? '1' : '0.75' }}'; this.classList.remove('shadow')"
                                     onerror="this.src='https://placehold.co/200x200/f8f9fa/adb5bd?text={{ $loop->iteration }}'">
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback: Se não houver galeria, mostra apenas a imagem principal como thumbnail -->
                    @if($product->image)
                        <div class="row row-cols-4 g-2">
                            <div class="col">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                                     class="img-fluid thumbnail-image active rounded border border-2 border-primary" 
                                     alt="Principal"
                                     style="aspect-ratio: 1; object-fit: cover; opacity: 1;">
                            </div>
                            <!-- Placeholders -->
                            <div class="col">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="aspect-ratio: 1;">
                                    <i class="bi bi-camera text-muted fs-3"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="aspect-ratio: 1;">
                                    <i class="bi bi-camera text-muted fs-3"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Coluna de Detalhes e Ações (Direita) -->
            <div class="col-lg-6">
                
                <!-- Breadcrumb (Migalhas de Pão) -->
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Início</a></li>
                        @if($product->category)
                            <li class="breadcrumb-item">
                                <a href="{{ route('shop.category', $product->category->slug) }}" class="text-decoration-none">
                                    {{ $product->category->name }}
                                </a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>

                <!-- Título e Avaliação -->
                <h1 class="h3 fw-bold mb-1">{{ $product->name }}</h1>
                <div class="text-warning mb-3">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span class="ms-2 text-muted small">(128 Avaliações)</span>
                </div>

                <!-- Preço -->
                <div class="mb-4">
                    @if($product->is_offer && $product->old_price)
                        <p class="price-display text-success h2 fw-bold mb-0">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                        <p class="text-muted">
                            <s class="me-2">De R$ {{ number_format($product->old_price, 2, ',', '.') }}</s> 
                            <span class="badge bg-success-subtle text-success">
                                {{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}% OFF
                            </span>
                        </p>
                    @else
                        <p class="price-display text-primary h2 fw-bold">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                    @endif
                    
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-credit-card me-1"></i>
                        em até 12x de R$ {{ number_format($product->price / 12, 2, ',', '.') }} sem juros
                    </small>
                </div>

                <!-- Descrição Curta (Marketing) -->
                @if($product->marketing_description)
                    <p class="text-muted border-start border-3 border-primary ps-3 mb-4">
                        {{ $product->marketing_description }}
                    </p>
                @endif

                <hr class="mb-4">

                <!-- Seção de Variações (Alpine.js) -->
                <!-- Seção de Variações -->
                @if(count($colorVariants) > 0 || count($sizeVariants) > 0)
                <div>
                    
                    <!-- Seleção de Cor -->
                    @if(count($colorVariants) > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">
                            Cor: <span class="text-primary">{{ $product->color }}</span>
                        </h6>
                        <div class="d-flex gap-2 flex-wrap align-items-center">
                            @foreach($colorVariants as $color)
                                <div class="position-relative text-center">
                                    <a href="{{ route('shop.show', $color['slug']) }}" 
                                       class="btn rounded-circle p-0 border-3 position-relative d-block mx-auto {{ $color['active'] ? 'border-primary shadow' : 'border-secondary' }}" 
                                       style="width: 40px; height: 40px; transition: all 0.2s;"
                                       title="{{ $color['name'] }} ({{ $color['stock'] }} unidades)">
                                        <span class="d-block w-100 h-100 rounded-circle border border-2 border-white" 
                                              style="background-color: {{ $color['hex'] }}; opacity: {{ $color['stock'] > 0 ? '1' : '0.3' }};"></span>
                                        @if($color['stock'] <= 0)
                                            <span class="position-absolute top-50 start-50 translate-middle"
                                                  style="width: 2px; height: 45px; background: red; transform: translate(-50%, -50%) rotate(45deg);"></span>
                                        @endif
                                    </a>
                                    <small class="d-block mt-1 {{ $color['active'] ? 'fw-bold text-primary' : 'text-muted' }}" 
                                           style="font-size: 0.7rem;">
                                        {{ $color['stock'] }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Atributo (Campo Genérico) -->
                    @if($product->attribute)
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Atributo:</h6>
                        <p class="text-muted mb-0">
                            <i class="bi bi-tag me-2"></i>{{ $product->attribute }}
                        </p>
                    </div>
                    @endif

                    <!-- Seleção de Tamanho -->
                    @if(count($sizeVariants) > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">
                            Tamanho: <span class="text-primary">{{ $product->size }}</span>
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sizeVariants as $size)
                                <a href="{{ route('shop.show', $size['slug']) }}" 
                                   class="btn {{ $size['active'] ? 'btn-primary' : 'btn-outline-secondary' }} {{ $size['stock'] <= 0 ? 'disabled opacity-50' : '' }}"
                                   style="min-width: 60px;">
                                    <span class="fw-bold">{{ $size['name'] }}</span>
                                    <small class="d-block" style="font-size: 0.7rem;">({{ $size['stock'] }})</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Seção de Quantidade e Ações -->
                @if($product->stock > 0)
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-2">Quantidade:</label>
                        
                        @livewire('shop.add-to-cart-button', ['product' => $product], key('add-to-cart-'.$product->id))

                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-box-seam me-1"></i>{{ $product->stock }} unidades disponíveis
                        </small>
                    </div>
                @else
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                        <div>
                            Produto temporariamente indisponível.
                        </div>
                    </div>
                @endif

                <hr class="mb-4">

                <!-- Informações Extras (Frete, Estoque) -->
                <div class="mt-4 p-3 bg-light rounded">
                    <p class="mb-1">
                        <i class="bi bi-box-seam me-2 text-primary"></i> 
                        Estoque: 
                        <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ $product->stock > 0 ? 'Disponível' : 'Esgotado' }}
                        </span>
                    </p>
                    <p class="mb-0"><i class="bi bi-truck me-2 text-primary"></i> Frete Grátis acima de R$ 299,00</p>
                </div>

            </div>
        </div> <!-- Fim da Row Principal -->

    </div> <!-- Fim do Product Card Wrapper -->

    <!-- Seção de Abas (Descrição, Especificações, Avaliações) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-white p-4 rounded shadow-sm border">
                <ul class="nav nav-tabs" id="productDetailTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-pane" type="button" role="tab" aria-controls="description-pane" aria-selected="true">Descrição Completa</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane" type="button" role="tab" aria-controls="specs-pane" aria-selected="false">Especificações</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab" aria-controls="reviews-pane" aria-selected="false">Avaliações (128)</button>
                    </li>
                </ul>
                
                <div class="tab-content p-3 border border-top-0" id="productDetailTabsContent">
                    <!-- Aba Descrição -->
                    <div class="tab-pane fade show active" id="description-pane" role="tabpanel" aria-labelledby="description-tab">
                        <h4 class="h5 mb-3">Sobre o Produto</h4>
                        @if($product->description)
                            <p>{{ $product->description }}</p>
                        @else
                            <p class="text-muted">Descrição detalhada não disponível.</p>
                        @endif
                        
                        <h5 class="mt-4">Destaques</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i> Alta qualidade</li>
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i> Design exclusivo</li>
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i> Garantia de satisfação</li>
                        </ul>
                    </div>
                    
                    <!-- Aba Especificações -->
                    <div class="tab-pane fade" id="specs-pane" role="tabpanel" aria-labelledby="specs-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%;">SKU</th>
                                    <td>{{ $product->sku ?? 'PROD-'.$product->id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Categoria</th>
                                    <td>{{ $product->category->name ?? 'Geral' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Peso</th>
                                    <td>{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Garantia</th>
                                    <td>{{ $product->warranty ?? '90 dias' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Aba Avaliações -->
                    <div class="tab-pane fade" id="reviews-pane" role="tabpanel" aria-labelledby="reviews-tab">
                        <h5 class="mb-3">Média de 4.5 / 5 Estrelas</h5>
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">João Silva <span class="text-warning"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></span></h6>
                                    <small class="text-muted">Há 2 dias</small>
                                </div>
                                <p class="mb-1 small">Produto excelente! Superou minhas expectativas.</p>
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Maria Souza <span class="text-warning"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span></h6>
                                    <small class="text-muted">Há 1 semana</small>
                                </div>
                                <p class="mb-1 small">Entrega rápida e produto muito bem embalado.</p>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Sistema de avaliações completo em breve.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Fim da Row de Abas -->

    <!-- Produtos Relacionados -->
    @if($relatedProducts->count() > 0)
        <div class="mt-5 pt-4 border-top">
            <h3 class="h4 mb-4">Produtos Relacionados</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($relatedProducts as $related)
                    <div class="col">
                        @livewire('shop.product-card', ['product' => $related], key('related-'.$related->id))
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
// Function to change main product image when clicking thumbnails
function changeMainImage(src) {
    const mainImage = document.getElementById('mainProductImage');
    if (mainImage) {
        // Fade out effect
        mainImage.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 150);
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-image').forEach(thumb => {
            thumb.classList.remove('active', 'border-primary', 'border-2');
            thumb.classList.add('border-secondary', 'opacity-75');
        });
        
        // Mark clicked thumbnail as active
        event.target.classList.add('active', 'border-primary', 'border-2');
        event.target.classList.remove('border-secondary', 'opacity-75');
        event.target.style.opacity = '1';
    }
}
</script>
@endsection
