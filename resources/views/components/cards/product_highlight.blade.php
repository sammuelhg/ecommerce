@props(['product'])

<div class="card h-100 border-0 shadow-sm position-relative product-highlight-card" style="font-family: 'Inter', sans-serif;">
    
    <div class="row g-0 h-100">
        <!-- Image Side (Left or Top? Reference looked vertical card-like). User said "imitar o layout dessa foto". 
             The photo provided in context (text) is typically vertical in MercadoLibre style.
             Let's put the image at the TOP for a vertical card.
        -->
        <div class="col-12 text-center p-3">
             @if($product->image)
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                     class="img-fluid object-fit-contain" 
                     style="max-height: 200px;"
                     alt="{{ $product->name }}">
            @else
                <img src="https://placehold.co/300x300/f8f9fa/dee2e6?text={{ urlencode($product->name) }}" 
                     class="img-fluid object-fit-contain" 
                     style="max-height: 200px;"
                     alt="{{ $product->name }}">
            @endif
        </div>

        <div class="col-12">
            <div class="card-body p-3 pt-0">
        <!-- Brand Name -->
        <div class="text-uppercase fw-bold text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
            {{ $product->brand ?? 'MAX TITANIUM' }}
        </div>
        
        <!-- Product Title -->
        <h6 class="card-title text-dark mb-1" style="font-size: 0.95rem; line-height: 1.3;">
            {{ $product->name }}
        </h6>
        
        <!-- Seller Info -->
        <div class="text-secondary mb-2" style="font-size: 0.75rem;">
            Por <span class="text-dark">{{ $product->seller_name ?? 'Max Titanium' }}</span>
        </div>
        
        <!-- Rating -->
        <div class="d-flex align-items-center mb-2">
            <span class="text-secondary me-1" style="font-size: 0.8rem;">4.8</span>
            <div class="text-primary me-1" style="font-size: 0.8rem;">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
            </div>
            <span class="text-secondary" style="font-size: 0.75rem;">(59836)</span>
        </div>
        
        <!-- Price Section -->
        <div class="mb-1">
            @if($product->old_price)
                <div class="text-decoration-line-through text-muted" style="font-size: 0.75rem;">R$ {{ number_format($product->old_price, 2, ',', '.') }}</div>
            @endif
            
            <div class="d-flex align-items-center">
                <span class="fw-normal text-dark" style="font-size: 1.2rem;">R$ {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="fw-normal text-dark ms-0" style="font-size: 0.8rem; margin-top: -5px;">{{ substr(number_format($product->price, 2, '', ''), -2) }}</span>
                @if($product->old_price)
                    @php
                        $discount = round((($product->old_price - $product->price) / $product->old_price) * 100);
                    @endphp
                    <span class="ms-2 text-success fw-bold" style="font-size: 0.8rem;">{{ $discount }}% OFF</span>
                @endif
            </div>
        </div>
        
        <!-- Installments -->
        <div class="mb-2">
            <span class="text-success" style="font-size: 0.8rem;">12x R$ {{ number_format($product->price / 12, 2, ',', '.') }} sem juros</span>
        </div>
        
        <!-- Shipping Badge -->
        <div class="text-success fw-bold mb-2" style="font-size: 0.85rem;">
            Frete grátis <span class="fst-italic fw-bolder" style="font-family: sans-serif;"><i class="bi bi-lightning-fill"></i>FULL</span>
        </div>
        
        <!-- Image (Absolute Positioned or Standard?) -->
        <!-- User image shows text on LEFT, Layout is likely vertical card. -->
        <!-- Wait, the reference image looks like a CARD, but typically these have images. 
             If this is a "Highlight" card, maybe the image is huge or it's a text-heavy card?
             Looking at the user request: "com a foto do produto, ver textos e estrutura..."
             Usually the image is at the TOP. In the reference crop, I don't see the image, just text. 
             I will place the image at the TOP as standard.
        -->
        
    </div>
        </div>
    </div>
    <!-- We need to render the image. The user reference crop does NOT show the image, but implies it.
         I'll put the image at the top, consistent effectively.
    -->
    <a href="{{ route('shop.show', $product->slug ?: $product->id) }}" class="position-absolute w-100 h-100 start-0 top-0 z-1"></a>
</div>
