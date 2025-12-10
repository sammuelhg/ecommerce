@extends('layouts.admin')

@section('title', $title ?? 'CRM')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4 text-center py-5">
            <div class="card-body">
                <div class="mb-4">
                    <i class="bi bi-cone-striped text-warning" style="font-size: 4rem;"></i>
                </div>
                <h2 class="h4 text-gray-800 mb-2">Em Construção</h2>
                <p class="text-muted mb-4">A funcionalidade <strong>{{ $feature ?? 'solicitada' }}</strong> estará disponível em breve.</p>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-2"></i> Voltar ao Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
