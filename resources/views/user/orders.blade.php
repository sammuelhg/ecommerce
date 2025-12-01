@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Meus Pedidos</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Esta funcionalidade será implementada na Fase IV (Checkout e Pagamentos).
                    </div>
                    <p class="text-muted">Aqui você poderá visualizar o histórico de todos os seus pedidos.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">
                        <i class="bi bi-shop me-2"></i>Continuar Comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
