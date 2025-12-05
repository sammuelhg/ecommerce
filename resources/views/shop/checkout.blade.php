@extends('layouts.shop')

@section('title', 'Finalizar Compra - LosFit')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8">
            <h2 class="fw-bold mb-4">Finalizar Compra</h2>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2"></i>Endereço de Entrega</h5>
                </div>
                <div class="card-body">
                    <form id="checkoutForm" action="#" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" name="name" required value="{{ auth()->user()->name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required value="{{ auth()->user()->email ?? '' }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" name="address" placeholder="Rua, número, bairro" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="state" required>
                                    <option value="">Selecione...</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="MG">Minas Gerais</option>
                                    <!-- Add other states -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">CEP</label>
                                <input type="text" class="form-control" name="zip" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2"></i>Pagamento</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                        <label class="form-check-label" for="creditCard">
                            Cartão de Crédito
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="pix">
                        <label class="form-check-label" for="pix">
                            PIX (5% de desconto)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="boleto">
                        <label class="form-check-label" for="boleto">
                            Boleto Bancário
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Resumo do Pedido</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        @forelse($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ $item['name'] ?? 'Produto' }}</h6>
                                    <small class="text-muted">Qtd: {{ $item['qty'] }}</small>
                                </div>
                                <span class="text-muted">R$ {{ number_format($item['price'] * $item['qty'], 2, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">Seu carrinho está vazio.</li>
                        @endforelse
                        
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Código Promocional</h6>
                                <small>EXAMPLECODE</small>
                            </div>
                            <span class="text-success">−R$ 0,00</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (BRL)</span>
                            <strong>R$ {{ number_format($total, 2, ',', '.') }}</strong>
                        </li>
                    </ul>

                    <button class="btn btn-success w-100 btn-lg fw-bold" type="submit" form="checkoutForm">
                        Confirmar Pedido
                    </button>
                    
                    <div class="mt-3 text-center">
                        <a href="{{ route('shop.index') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
