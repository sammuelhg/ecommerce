@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="row">
        <x-account-sidebar />
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Meus Pedidos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-5 text-center text-muted">
                            <i class="bi bi-inbox fs-1 mb-3"></i>
                            <h5 class="mb-2">Nenhum pedido realizado</h5>
                            <p class="small">Quando você fizer uma compra, ela aparecerá aqui.</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">
                                <i class="bi bi-bag me-2"></i>Começar a comprar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
