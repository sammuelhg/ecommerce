@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="row">
        <x-account-sidebar />
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Presentes</h5>
                </div>
                <div class="card-body p-5 text-center">
                    <i class="bi bi-gift fs-1 text-muted mb-3"></i>
                    <h4 class="text-muted">Lista de Presentes</h4>
                    <p class="text-muted">Crie listas de presentes para compartilhar com seus amigos.</p>
                    <button class="btn btn-outline-primary mt-2">Criar Nova Lista</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
