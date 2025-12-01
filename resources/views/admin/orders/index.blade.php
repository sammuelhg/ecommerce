@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h2 mb-4">Gerenciamento de Pedidos</h1>
    @livewire('admin.order-index')
</div>
@endsection
