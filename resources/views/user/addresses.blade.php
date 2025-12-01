@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Meus Endereços</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Esta funcionalidade será implementada na Fase IV (Checkout).
                    </div>
                    <p class="text-muted">Aqui você poderá gerenciar seus endereços de entrega.</p>
                    <a href="{{ route('profile') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Voltar ao Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
