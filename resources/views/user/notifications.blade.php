@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="row">
        <x-account-sidebar />
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Notificações</h5>
                    <button class="btn btn-sm btn-outline-secondary">Marcar todas como lidas</button>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-4 text-center text-muted">
                            <i class="bi bi-bell-slash fs-1 mb-3"></i>
                            <h5 class="mb-0">Nenhuma notificação</h5>
                            <p class="small">Você não possui notificações no momento.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
