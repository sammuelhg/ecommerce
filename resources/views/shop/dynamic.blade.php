@extends('layouts.shop')

@section('content')
<div class="row">
    <div class="col-12">
        <livewire:product-grid :variant="$variant ?? 'A'" />
    </div>
</div>
@endsection
