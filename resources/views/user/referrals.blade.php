@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="row">
        <x-account-sidebar />
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Indique Amigos</h5>
                </div>
                <div class="card-body p-5 text-center">
                    <i class="bi bi-envelope-heart fs-1 text-primary mb-3"></i>
                    <h4 class="fw-bold">Ganhe descontos indicando!</h4>
                    <p class="text-muted">Indique amigos e ganhe R$ 20,00 em créditos para sua próxima compra.</p>
                    <button class="btn btn-primary px-4 mt-3">Gerar Link de Indicação</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
