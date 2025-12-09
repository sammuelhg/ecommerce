@props(['product', 'data' => []])

@php
    $badgeType = $data['badge_type'] ?? 'best_buy';
    $badgeIcon = match($badgeType) {
        'best_buy' => 'bi-stars',
        'editor_choice' => 'bi-award-fill',
        'big_discount' => 'bi-percent',
        'limited' => 'bi-stopwatch-fill',
        default => 'bi-tag-fill'
    };
    $badgeLabel = match($badgeType) {
        'best_buy' => 'Melhor Compra',
        'editor_choice' => 'Escolha do Editor',
        'big_discount' => 'Super Desconto',
        'limited' => 'Oferta Limitada',
        default => 'Especial'
    };
    $badgeColor = match($badgeType) {
        'best_buy' => 'bg-warning text-dark',
        'editor_choice' => 'bg-primary text-white',
        'big_discount' => 'bg-danger text-white',
        'limited' => 'bg-dark text-white',
        default => 'bg-secondary text-white'
    };
@endphp

<div class="card h-100 border-0 shadow-sm overflow-hidden position-relative product-card-special">
    {{-- Badge --}}
    <div class="position-absolute top-0 start-0 w-100 p-2 d-flex justify-content-between align-items-start z-2">
        <span class="badge {{ $badgeColor }} d-flex align-items-center gap-1 shadow-sm px-3 py-2 rounded-pill">
            <i class="bi {{ $badgeIcon }} fs-6"></i>
            <span class="fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ $badgeLabel }}</span>
        </span>
        
        {{-- Discount Badge if applicable --}}
        @if($product->on_sale)
            <span class="badge bg-danger rounded-pill shadow-sm">-{{ $product->discount_percentage }}%</span>
        @endif
    </div>

    {{-- Image --}}
    <div class="position-relative bg-light" style="padding-top: 100%;">
        <a href="{{ route('shop.show', $product->slug) }}" class="d-block position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
             @if($product->image)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid object-fit-cover w-100 h-100 transition-transform">
            @else
                <div class="text-muted d-flex flex-column align-items-center">
                    <i class="bi bi-image fs-1 mb-2"></i>
                </div>
            @endif
        </a>
    </div>

    {{-- Content --}}
    <div class="card-body d-flex flex-column justify-content-between bg-white text-center pb-4 pt-3">
        <div class="mb-2">
            <h5 class="card-title fw-bold text-dark mb-1 position-relative d-inline-block">
                <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link">
                    {{ $product->name }}
                </a>
            </h5>
        </div>

        <div>
           <div class="d-flex justify-content-center align-items-baseline gap-2 mb-3">
                @if($product->on_sale)
                    <small class="text-decoration-line-through text-muted">R$ {{ number_format($product->price, 2, ',', '.') }}</small>
                    <span class="fw-bold text-danger fs-4">R$ {{ number_format($product->sale_price, 2, ',', '.') }}</span>
                @else
                    <span class="fw-bold text-dark fs-4">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                @endif
           </div>
           
           <button wire:click.prevent="addToCart({{ $product->id }})" class="btn {{ $badgeType == 'big_discount' ? 'btn-danger' : 'btn-dark' }} w-100 rounded-pill fw-bold">
               <i class="bi bi-cart-plus me-1"></i> Adicionar
           </button>
        </div>
    </div>
</div>
