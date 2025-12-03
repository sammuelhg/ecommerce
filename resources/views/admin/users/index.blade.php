@extends('layouts.admin')

@section('title', 'Usuários Clientes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Usuários Clientes</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-people" style="font-size: 3rem; color: #6c757d;"></i>
            <h4 class="mt-3">Gerenciamento de Usuários</h4>
            <p class="text-muted">Esta seção será implementada em breve.</p>
        </div>
    </div>
</div>
@endsection
