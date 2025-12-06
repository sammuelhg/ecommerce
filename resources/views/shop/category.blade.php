@extends('layouts.shop')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Início</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Header da Categoria -->
    <div class="bg-light py-5 mb-5 rounded-3 text-center position-relative overflow-hidden shadow-sm">
        <div class="position-relative z-1">
            <h1 class="display-4 fw-bold text-dark mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="lead text-muted mb-2">{{ $category->description }}</p>
            @endif
            <div class="d-inline-flex align-items-center text-muted">
                <i class="bi bi-grid-3x3-gap me-2"></i>
                <span>{{ $products->count() }} produtos encontrados</span>
            </div>
        </div>
        <!-- Elemento Decorativo -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" 
             style="background: radial-gradient(circle at center, #0d6efd 0%, transparent 70%); pointer-events: none;">
        </div>
    </div>

    <!-- Grid de Produtos -->
    @if($products->count() > 0)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            @foreach ($products as $product)
                <div class="col">
                    @include('livewire.shop.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-muted">Nenhum produto nesta categoria</h4>
            <p class="text-muted">Em breve teremos novidades!</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">
                <i class="bi bi-arrow-left me-2"></i>Voltar para a Loja
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    window.DB_PRODUCTS = {!! $productsJson !!};
</script>
@endpush
@endsection
