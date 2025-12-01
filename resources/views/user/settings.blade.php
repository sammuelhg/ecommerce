@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Configurações da Conta</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Esta funcionalidade será implementada em breve.
                    </div>
                    <p class="text-muted">Aqui você poderá gerenciar preferências de notificação, privacidade e segurança.</p>
                    
                    <h6 class="mt-4">Ações Rápidas:</h6>
                    <div class="list-group">
                        <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-person me-2"></i>Editar Perfil
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-shield-lock me-2"></i>Alterar Senha
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-bell me-2"></i>Preferências de Notificação
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
