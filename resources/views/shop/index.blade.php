@extends('layouts.shop')

@section('content')
@if($products->count() > 0)
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
    @foreach ($products as $product)
        <div class="col">
            @include('livewire.shop.product-card', ['product' => $product])
        </div>
    @endforeach
</div>
<div class="row mt-5">
    <div class="col-12 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
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
</script>
@endpush
