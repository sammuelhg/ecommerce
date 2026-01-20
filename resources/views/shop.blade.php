@extends('layouts.shop')

@section('title', 'Loja Losfit - Sua Loja Online')

@section('content')
    {{-- Hero Banner --}}
    <section class="hero-banner mb-5 bg-primary text-white"
             style="background-image: url('https://placehold.co/1200x350/005691/ffffff?text=Oferta+Exclusiva');">
        <div class="p-5 p-md-0">
            <div class="col-md-7 px-0">
                <div class="bg-light p-4 rounded-xl shadow-lg">
                    <h1 class="display-6 fw-bold text-primary mb-3">Liquidação de Verão</h1>
                    <p class="fs-5 text-dark mb-4 d-none d-sm-block">Aproveite descontos incríveis de até 50% OFF.</p>
                    <a href="#" class="btn btn-secondary btn-lg fw-bold shadow-sm">
                        Comprar Agora <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Products --}}
    <section class="mb-5">
        <h2 class="border-bottom border-primary pb-2 mb-4 text-dark fw-bold">Produtos em Destaque</h2>

        <div class="d-flex flex-nowrap overflow-x-auto pb-3 custom-horizontal-scroll mx-n2">
            <template x-for="product in products" :key="product.id">
                <div class="scroll-item-width p-2">
                    <livewire:shop.product-card :product="$product" :wire:key="'wc-'+product.id" />
                    {{-- Alpine Fallback/Custom Card if Livewire is not desired here --}}
                    {{-- Since shop-alpine.js handles logic, we can use the HTML card from legacy shop.blade.php --}}
                    <div class="card h-100 card-product shadow-sm rounded-xl overflow-hidden">
                        <a href="#" class="text-decoration-none">
                            <div class="position-relative">
                                <img :src="`https://placehold.co/400x400/CCCCCC/333333?text=${product.imageText || product.image || 'Produto'}`" 
                                     class="card-img-top" style="height: 200px; object-fit: cover;">
                                
                                {{-- Badges --}}
                                <template x-if="product.isOffer">
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 fw-bold">-20%</span>
                                </template>
                                <template x-if="!product.isOffer">
                                    <span class="badge bg-secondary text-primary position-absolute top-0 start-0 m-2 fw-bold">NOVO</span>
                                </template>
                                
                                {{-- Wishlist Button --}}
                                <button class="wishlist-toggle position-absolute top-0 end-0 m-2 border-0" 
                                        @click.prevent.stop="toggleWishlist(product)"
                                        :class="isInWishlist(product.id) ? 'is-favorited' : ''"
                                        :title="isInWishlist(product.id) ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos'">
                                    <i class="bi fs-5" :class="isInWishlist(product.id) ? 'bi-heart-fill' : 'bi-heart'"></i>
                                </button>
                            </div>
                            <div class="card-body p-3">
                                <h5 class="card-title line-clamp-2 text-dark mb-1" x-text="product.name" :title="product.name"></h5>
                                <p class="card-text fs-5 fw-bold text-primary mb-0">
                                    <span x-text="formatCurrency(product.price)"></span>
                                    <template x-if="product.oldPrice">
                                        <small class="text-muted text-decoration-line-through" x-text="formatCurrency(product.oldPrice)"></small>
                                    </template>
                                </p>
                            </div>
                        </a>
                        <div class="card-footer bg-white border-0 p-3 pt-0">
                            <button class="btn w-100 fw-semibold btn-sm" 
                                    :class="isInCart(product.id) ? 'btn-success' : 'btn-primary'"
                                    @click="addToCart(product)">
                                <i class="bi me-1" :class="isInCart(product.id) ? 'bi-check-lg' : 'bi-cart-plus'"></i> 
                                <span x-text="isInCart(product.id) ? 'No Carrinho (' + getCartQty(product.id) + ')' : 'Adicionar'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </section>
@endsection

@section('styles')
<style>
    /* Reuse styles from legacy shop.blade.php needed for this section */
    .card-product { transition: all 0.3s ease-in-out; }
    .card-product:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-3px);
    }
    .hero-banner {
        min-height: 350px;
        background-size: cover;
        background-position: center;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        padding: 3rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }
    .rounded-xl { border-radius: 1rem !important; }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        text-overflow: ellipsis;
        white-space: normal;
        line-height: 1.25;
        max-height: 2.5em;
    }
    .custom-horizontal-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .custom-horizontal-scroll::-webkit-scrollbar { display: none; }
    .scroll-item-width { flex: 0 0 50%; max-width: 50%; }
    @media (min-width: 576px) { .scroll-item-width { flex: 0 0 33.333%; max-width: 33.333%; } }
    @media (min-width: 992px) { .scroll-item-width { flex: 0 0 25%; max-width: 25%; } }
    .wishlist-toggle {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.8);
        color: var(--bs-body-color);
        padding: 0.5rem;
        line-height: 1;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .wishlist-toggle:hover {
        transform: scale(1.1);
        color: var(--bs-danger);
        background-color: white;
    }
    .wishlist-toggle.is-favorited {
        color: var(--bs-danger);
        fill: var(--bs-danger);
    }
</style>
@endsection
