<!-- Barra de Busca Completa (Mobile/Tablet) -->
<div class="collapse bg-white border-bottom shadow-sm d-lg-none" id="search-bar-full">
    <div class="container-fluid py-3">
        <form class="d-flex mb-4" @submit.prevent="performSearch()">
            <input class="form-control form-control-lg rounded-pill me-2" 
                   type="search" 
                   placeholder="Buscar produtos, categorias..." 
                   x-model="searchQuery"
                   id="mobile-search-input">
            <button class="btn btn-primary rounded-pill fw-semibold" type="submit">
                <i class="bi bi-search me-1"></i> Buscar
            </button>
        </form>

        <!-- Últimos Pesquisados -->
        <div class="row" x-show="recentSearches.length > 0">
            <div class="col-12 mb-4">
                <h6 class="text-primary fw-bold border-bottom pb-1">
                    <i class="bi bi-clock-history me-1"></i> Últimos Pesquisados
                </h6>
                <div class="d-flex flex-wrap gap-2">
                    <template x-for="term in recentSearches.slice(0, 5)" :key="term">
                        <span class="badge bg-light text-dark border p-2 rounded-pill cursor-pointer"
                              @click="searchQuery = term; performSearch()">
                            <i class="bi bi-search me-1"></i>
                            <span x-text="term"></span>
                        </span>
                    </template>
                </div>
            </div>
        </div>

        <!-- Ofertas em Destaque -->
        <div class="row" x-show="offerProducts.length > 0">
            <div class="col-12">
                <h6 class="text-danger fw-bold border-bottom pb-1">
                    <i class="bi bi-fire me-1"></i> Ofertas em Destaque
                </h6>
                <div class="d-flex flex-wrap gap-2">
                    <template x-for="product in offerProducts.slice(0, 3)" :key="product.id">
                        <span class="badge bg-danger p-2 rounded-pill">
                            <i class="bi bi-tag me-1"></i>
                            <span x-text="truncate(product.name, 25)"></span>
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cursor-pointer { cursor: pointer; }
</style>
