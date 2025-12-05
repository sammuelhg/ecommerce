@extends('layouts.shop')

@section('content')
@if($products->count() > 0)
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    @foreach ($products as $product)
        <div class="col">
            @include('livewire.shop.product-card', ['product' => $product])
        </div>
    @endforeach
</div>
@else
    <div class="col-12 text-center py-5">
        <h4 class="text-muted">Nenhum produto encontrado.</h4>
    </div>
@endif
@endsection

@push('scripts')
<script>
    window.DB_PRODUCTS = {!! $productsJson !!};
    
    // Abre automaticamente o offcanvas de login ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const offcanvasElement = document.getElementById('offcanvasUser');
        if (offcanvasElement) {
            const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        }
    });
</script>
@endpush
