<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

try {
    $dbProducts = Product::all();
    $productsJson = $dbProducts->isEmpty() ? '[]' : $dbProducts->map(fn($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'price' => (float) $p->price,
        'imageText' => $p->image,
        'isOffer' => (bool) $p->is_offer,
        'oldPrice' => $p->old_price ? (float) $p->old_price : null,
    ])->toJson();
} catch (\Exception $e) {
    $productsJson = '[]';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja com Alpine.js - Componentes Configuráveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="shop-styles.css">
</head>
<body class="bg-light" x-data="shopApp()" x-init="init()">

    <!-- Painel de Configurações (Posição Fixa) -->
    <div class="position-fixed bottom-0 start-0 p-3" style="z-index: 1040;" x-show="showConfigPanel">
        <div class="card shadow-lg" style="width: 280px;">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-gear-fill me-2"></i>Configurações</h6>
                <button class="btn btn-sm btn-light" @click="showConfigPanel = false">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="enableCart" x-model="config.enableCart">
                    <label class="form-check-label" for="enableCart">Carrinho</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="enableWishlist" x-model="config.enableWishlist">
                    <label class="form-check-label" for="enableWishlist">Wishlist</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="enableSearch" x-model="config.enableSearch">
                    <label class="form-check-label" for="enableSearch">Busca</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="enableToasts" x-model="config.enableToasts">
                    <label class="form-check-label" for="enableToasts">Notificações</label>
                </div>
                <hr>
                <button class="btn btn-sm btn-outline-danger w-100" @click="resetConfig()">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Resetar
                </button>
            </div>
        </div>
    </div>

    <!-- Botão para Abrir Config -->
    <button class="btn btn-primary position-fixed bottom-0 start-0 m-3 rounded-circle shadow-lg" 
            style="width: 50px; height: 50px; z-index: 1039;"
            @click="showConfigPanel = !showConfigPanel"
            x-show="!showConfigPanel">
        <i class="bi bi-gear-fill fs-5"></i>
    </button>

    <!-- Toast Notifications -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 2000;" x-show="config.enableToasts">
        <template x-for="alert in alerts" :key="alert.id">
            <div class="alert alert-dismissible fade show mb-2 rounded-pill shadow-lg d-flex align-items-center"
                 :class="{'alert-success': alert.type==='success', 'alert-danger': alert.type==='danger', 'alert-info': alert.type==='info'}"
                 role="alert">
                <i class="bi me-2" :class="alert.type==='success' ? 'bi-check-circle-fill' : 'bi-x-octagon-fill'"></i>
                <div x-text="alert.message"></div>
                <button type="button" class="btn-close" @click="removeAlert(alert.id)"></button>
            </div>
        </template>
    </div>

    <!-- Header Component -->
    <?php include __DIR__ . '/components/header.php'; ?>

    <!-- Main Content -->
    <main class="container my-5">
        <section class="hero-banner mb-5 bg-primary text-white"
                 style="background-image: url('https://placehold.co/1200x350/005691/ffffff?text=Oferta+Exclusiva');">
            <div class="p-5 p-md-0">
                <div class="col-md-7 px-0">
                    <div class="bg-light p-4 rounded-xl shadow-lg">
                        <h1 class="display-6 fw-bold text-primary mb-3">Liquidação de Verão</h1>
                        <p class="fs-5 text-dark mb-4 d-none d-sm-block">Descontos de até 50% OFF.</p>
                        <a href="#" class="btn btn-secondary btn-lg fw-bold">Comprar Agora <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h2 class="border-bottom border-primary pb-2 mb-4 fw-bold">Produtos em Destaque</h2>
            <div class="d-flex flex-nowrap overflow-x-auto pb-3 custom-horizontal-scroll mx-n2">
                <template x-for="product in products" :key="product.id">
                    <div class="scroll-item-width p-2">
                        <div class="card h-100 card-product shadow-sm rounded-xl overflow-hidden">
                            <div class="position-relative">
                                <img :src="`https://placehold.co/400x400/CCCCCC/333333?text=${product.imageText}`" 
                                     class="card-img-top" style="height: 200px; object-fit: cover;">
                                <template x-if="product.isOffer">
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 fw-bold">-20%</span>
                                </template>
                                <template x-if="!product.isOffer">
                                    <span class="badge bg-secondary text-primary position-absolute top-0 start-0 m-2 fw-bold">NOVO</span>
                                </template>
                                
                                <!-- Botão Wishlist (Condicional) -->
                                <template x-if="config.enableWishlist">
                                    <button class="wishlist-toggle position-absolute top-0 end-0 m-2 border-0" 
                                            @click.prevent="toggleWishlist(product)"
                                            :class="isInWishlist(product.id) ? 'is-favorited' : ''">
                                        <i class="bi fs-5" :class="isInWishlist(product.id) ? 'bi-heart-fill' : 'bi-heart'"></i>
                                    </button>
                                </template>
                            </div>
                            <div class="card-body p-3">
                                <h5 class="card-title line-clamp-2 text-dark mb-1" x-text="product.name"></h5>
                                <p class="card-text fs-5 fw-bold text-primary mb-0">
                                    <span x-text="formatCurrency(product.price)"></span>
                                    <template x-if="product.oldPrice">
                                        <small class="text-muted text-decoration-line-through" x-text="formatCurrency(product.oldPrice)"></small>
                                    </template>
                                </p>
                            </div>
                            <div class="card-footer bg-white border-0 p-3 pt-0" x-show="config.enableCart">
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
    </main>

    <!-- Footer Component -->
    <?php include __DIR__ . '/components/footer.php'; ?>

    <!-- Offcanvas Components -->
    <?php include __DIR__ . '/components/user-offcanvas.php'; ?>
    <?php include __DIR__ . '/components/cart-offcanvas.php'; ?>
    <?php include __DIR__ . '/components/wishlist-offcanvas.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="shop-app.js"></script>
    <script>
        // Injeta produtos do banco de dados
        window.DB_PRODUCTS = <?php echo $productsJson; ?>;
    </script>
</body>
</html>
