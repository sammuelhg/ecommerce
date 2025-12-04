@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="row">
        <x-account-sidebar />
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Meus Cupons</h5>
                </div>
                <div class="card-body p-5 text-center">
                    <i class="bi bi-ticket-perforated fs-1 text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhum cupom disponível</h4>
                    <p class="text-muted">Você ainda não possui cupons de desconto ativos.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
