@extends('layouts.admin')

@section('title', 'Cores do Produto')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-palette text-primary me-2"></i> Cores do Produto</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Cores</li>
            </ol>
        </nav>
    </div>

    @livewire('admin.product-color-index')
</div>
@endsection
