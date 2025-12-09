@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm border-0" style="max-width: 500px; width: 100%;">
        <div class="card-body text-center p-5">
            <!-- Icon -->
            <div class="mb-4 text-muted">
                <i class="bi bi-envelope-x display-1 text-danger"></i>
            </div>

            <h2 class="card-title fw-bold mb-3">Inscrição Cancelada</h2>
            
            <p class="text-muted mb-4">
                Você foi removido da nossa lista de newsletter com sucesso. <br>Sentiremos sua falta!
            </p>

            @if(session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('newsletter.resubscribe', $subscriber->id) }}" method="POST">
                @csrf
                <p class="small text-muted mb-2">Foi um engano ou mudou de ideia?</p>
                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                    Reativar Minha Inscrição
                </button>
            </form>

            <div class="mt-4 pt-3 border-top">
                <a href="{{ route('shop.index') }}" class="text-decoration-none fw-bold">
                    &larr; Voltar para a Loja
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
