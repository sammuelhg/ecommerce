@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="row">
        <x-account-sidebar />
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Assine Clube</h5>
                </div>
                <div class="card-body p-5 text-center">
                    <i class="bi bi-star-fill fs-1 text-warning mb-3"></i>
                    <h4 class="fw-bold">Clube VIP</h4>
                    <p class="text-muted mb-4">Torne-se membro e aproveite benefícios exclusivos, frete grátis e descontos especiais.</p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <i class="bi bi-truck fs-4 text-primary"></i>
                                <p class="mb-0 mt-2 small fw-bold">Frete Grátis</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <i class="bi bi-percent fs-4 text-success"></i>
                                <p class="mb-0 mt-2 small fw-bold">10% OFF</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <i class="bi bi-gift fs-4 text-danger"></i>
                                <p class="mb-0 mt-2 small fw-bold">Brindes</p>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-warning px-5 fw-bold">ASSINAR AGORA</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
