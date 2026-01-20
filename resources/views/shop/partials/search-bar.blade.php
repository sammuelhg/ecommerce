<div class="search-container-relative flex-grow-1 mb-3">
    <div class="input-group search-group-pill">
        <!-- Categoria -->
        <select class="form-select search-category-select text-muted ps-3 border-end-0 rounded-pill rounded-end-0" 
                x-model="category" 
                @change="onCategoryChange()"
                aria-label="Selecionar Categoria" 
                style="max-width: 150px; cursor: pointer; background-color: white;">
            <option value="Todos">Todos</option>
            <option value="acessorios">Acessórios</option>
            <option value="losfitnutri">LosfitNutri</option>
            <option value="croche">ModaCrochê</option>
            <option value="fit">ModaFit</option>
            <option value="praia">ModaPraia</option>
            <option value="suplementos">Suplementos</option>
        </select>

        <!-- Input -->
        <input class="form-control search-input border-start-0" 
               type="search" 
               placeholder="Buscar produtos..." 
               x-model="searchQuery" 
               @focus="focused = true" 
               @keydown.enter="performSearch()" 
               aria-label="Buscar produtos">

        <!-- Button (Attached) -->
        <button class="btn btn-warning rounded-pill rounded-start-0" 
                type="submit" 
                @click="performSearch()"
                style="z-index: 5;">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <!-- Dropdown de Sugestões / Resultados -->
    <div class="search-suggestions-dropdown shadow-lg border-0 rounded-3 mt-2 d-none d-lg-block" 
         x-show="focused && ((searchQuery.length > 0) || (category !== 'Todos') || isQueryEmpty)" 
         x-transition.opacity.duration.200ms
         @click.outside="focused = false"
         style="display: none; background: white; z-index: 1050; width: 100%; max-height: 400px; overflow-y: auto;">
        
        <!-- Estado Inicial / Destaques (Quando busca vazia E categoria é Todos) -->
        <template x-if="isQueryEmpty && category === 'Todos'">
            <ul class="list-group list-group-flush text-start">
                <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                    🔥 Destaques
                </li>
                
                <template x-for="suggestion in defaultSuggestions" :key="suggestion.id">
                    <li class="list-group-item list-group-item-action cursor-pointer d-flex align-items-center py-2" @click="selectItem(suggestion.name)">
                        <div class="suggestion-img-wrapper me-3" style="width: 40px; height: 40px; min-width: 40px;">
                            <img :src="suggestion.image || suggestion.image_url" class="img-fluid rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;" x-text="suggestion.name"></div>
                            <div class="text-primary small fw-bold" x-text="formatCurrency(suggestion.price)"></div>
                        </div>
                    </li>
                </template>

                <li x-show="defaultSuggestions.length === 0" class="list-group-item text-muted small py-2">
                    Nenhum destaque encontrado.
                </li>
            </ul>
        </template>

        <!-- Resultados Filtrados (Texto digitado OU Categoria selecionada) -->
        <template x-if="!isQueryEmpty || category !== 'Todos'">
             <ul class="list-group list-group-flush text-start">
                 
                 <!-- Header de filtro -->
                 <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                     <span x-show="!isQueryEmpty">Busca: "<span x-text="searchQuery"></span>"</span>
                     <span x-show="!isQueryEmpty && category !== 'Todos'"> em </span>
                     <span x-show="category !== 'Todos'" x-text="getCategoryName()"></span>
                 </li>

                 <!-- Loading -->
                 <li x-show="isLoading" class="list-group-item text-center text-muted small py-3">
                     <span class="spinner-border spinner-border-sm text-warning me-2"></span> Buscando...
                 </li>

                 <!-- PRODUTOS -->
                 <template x-for="prod in filteredProducts" :key="prod.id">
                     <li class="list-group-item list-group-item-action cursor-pointer d-flex align-items-center py-2" @click="goToProduct(prod)">
                         <div class="suggestion-img-wrapper me-3" style="width: 45px; height: 45px; min-width: 45px;">
                             <img :src="prod.image || prod.image_url" class="img-fluid rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                         </div>
                         <div class="flex-grow-1">
                             <div class="fw-bold text-dark" style="font-size: 0.9rem;" x-text="prod.name"></div>
                             <div class="text-primary small fw-bold" x-text="formatCurrency(prod.price)"></div>
                         </div>
                     </li>
                 </template>

                  <!-- No Results -->
                  <li x-show="!isLoading && filteredProducts.length === 0" class="list-group-item text-center text-muted small py-3">
                     Nenhum produto encontrado.
                  </li>
             </ul>
        </template>
    </div>
</div>
