@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="row">
        <x-account-sidebar />
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Formas de Pagamento</h5>
                    <button class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Adicionar Cartão
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-5 text-center text-muted">
                            <i class="bi bi-credit-card fs-1 mb-3"></i>
                            <h5 class="mb-2">Nenhum cartão cadastrado</h5>
                            <p class="small">Cadastre cartões para pagamento mais rápido e seguro.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
