@extends('layouts.admin')

@section('title', 'Editar Produto')

@section('content')
    @livewire('admin.product-form', ['product' => $product])
@endsection
