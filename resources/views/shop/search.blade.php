@extends('layouts.shop')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Início</a></li>
            <li class="breadcrumb-item active">Busca</li>
        </ol>
    </nav>

    <!-- Resultado da Busca -->
    <div class="mb-4">
        <h2>Resultados para: <span class="text-primary">"{{ $query }}"</span></h2>
        <p class="text-muted">{{ $products->count() }} produto(s) encontrado(s)</p>
    </div>

    <!-- Grid de Produtos -->
    @if($products->count() > 0)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($products as $product)
                <div class="col">
                    @livewire('shop.product-card', ['product' => $product], key('search-'.$product->id))
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-muted">Nenhum produto encontrado</h4>
            <p class="text-muted">Tente buscar com outras palavras-chave</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">
                <i class="bi bi-arrow-left me-2"></i>Voltar para a Loja
            </a>
        </div>
    @endif
</div>
@endsection
