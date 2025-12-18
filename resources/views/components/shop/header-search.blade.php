<div class="d-flex flex-grow-1 w-100 my-2 my-lg-0 d-none d-lg-block position-relative" 
    x-data="shopSearch()"
    @click.outside="focused = false"
>
   <form class="d-flex flex-nowrap w-100 align-items-center" @submit.prevent="performSearch()">
       <div class="search-container-relative flex-grow-1">
           <div class="input-group search-group-pill">
               <!-- Categoria -->
               @php
                   $searchCategories = \Illuminate\Support\Facades\Cache::remember('active_search_categories', 3600, function () {
                       return \App\Domains\Catalog\Models\Category::where('is_active', true)->orderBy('name')->get();
                   });
               @endphp
               <select class="form-select search-category-select text-muted ps-3 border-end-0 rounded-pill rounded-end-0" 
                       x-model="category" 
                       aria-label="Selecionar Categoria"
                       style="max-width: 150px; cursor: pointer; background-color: white;">
                   <option value="Todos">Todos</option>
                   @foreach($searchCategories as $cat)
                       <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                   @endforeach
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
                       style="z-index: 5;">
                   <i class="bi bi-search"></i>
               </button>
           </div>

    <div class="search-suggestions-dropdown shadow-lg border-0 rounded-3 mt-2" 
         x-show="focused && (searchQuery.length > 0 || isQueryEmpty)" 
         x-transition.opacity.duration.200ms
         style="display: none; background: white; z-index: 1050; width: 100%; max-height: 400px; overflow-y: auto;">
        
        <!-- Empty Search: Show Featured/Random Products -->
        <template x-if="isQueryEmpty">
            <ul class="list-group list-group-flush text-start">
                <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                    🔥 Destaques <span x-show="category !== 'Todos'" x-text="'em ' + getCategoryName()" class="text-lowercase"></span>
                </li>
                
                <template x-for="suggestion in defaultSuggestions" :key="suggestion.id">
                    <li class="list-group-item list-group-item-action cursor-pointer d-flex align-items-center py-2" 
                        @click="selectItem(suggestion.name)">
                        <div class="suggestion-img-wrapper me-3" style="width: 40px; height: 40px; min-width: 40px;">
                            <img :src="suggestion.image_url" class="img-fluid rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;" x-text="suggestion.name"></div>
                            <div class="text-primary small fw-bold" x-text="'R$ ' + suggestion.price"></div>
                        </div>
                    </li>
                </template>

                <li x-show="defaultSuggestions.length === 0" class="list-group-item text-muted small py-2">
                    Nenhum destaque encontrado.
                </li>
            </ul>
        </template>

        <!-- Active Search Results -->
        <template x-if="!isQueryEmpty">
             <ul class="list-group list-group-flush text-start">
                 
                 <!-- CATEGORIAS -->
                 <template x-if="results.categories && results.categories.length > 0">
                     <div>
                         <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                             Categorias
                         </li>
                         <template x-for="cat in results.categories" :key="cat.id">
                             <li class="list-group-item list-group-item-action cursor-pointer d-flex align-items-center" 
                                 @click="goToCategory(cat.slug)">
                                 <i class="bi bi-grid-fill me-2 text-muted"></i>
                                 <span class="text-dark" x-text="cat.name"></span>
                             </li>
                         </template>
                     </div>
                 </template>

                 <!-- PRODUTOS -->
                 <template x-if="results.products && results.products.length > 0">
                     <div>
                         <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                              Produtos
                         </li>
                         <template x-for="prod in results.products" :key="prod.id">
                             <li class="list-group-item list-group-item-action cursor-pointer d-flex align-items-center py-2" 
                                 @click="selectItem(prod.name)">
                                 <div class="suggestion-img-wrapper me-3" style="width: 45px; height: 45px; min-width: 45px;">
                                     <img :src="prod.image_url" class="img-fluid rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                                 </div>
                                 <div class="flex-grow-1">
                                     <div class="fw-bold text-dark" style="font-size: 0.9rem;" x-text="prod.name"></div>
                                     <div class="text-primary small fw-bold" x-text="'R$ ' + prod.price"></div>
                                 </div>
                             </li>
                         </template>
                     </div>
                 </template>

                  <!-- Loading -->
                  <li x-show="isLoading" class="list-group-item text-center text-muted small py-3">
                     <span class="spinner-border spinner-border-sm text-warning me-2"></span> Buscando...
                  </li>

                  <!-- No Results -->
                  <li x-show="!isLoading && (!results.products?.length && !results.categories?.length)" 
                      class="list-group-item text-center text-muted small py-3">
                     Nenhum resultado para "<span class="fw-bold" x-text="searchQuery"></span>"
                  </li>
             </ul>
        </template>
    </div>
</div>

</form>

<script>
function shopSearch() {
   return {
       focused: false,
       category: '{{ request('category') ?? 'Todos' }}',
       searchQuery: '{{ request('q') }}',
       results: { products: [], categories: [] },
       defaultSuggestions: [],
       isLoading: false,
       debounceTimer: null,
       
       get isQueryEmpty() { return this.searchQuery === ''; },

       init() {
           // Initial fetch for default suggestions
           this.fetchDefaultSuggestions();

           // Watch category changes to update default suggestions
           this.$watch('category', (value) => {
               this.fetchDefaultSuggestions();
               if (this.searchQuery.length >= 2) {
                   this.syncSearch();
               }
           });

           this.$watch('searchQuery', (value) => {
               this.syncSearch();
           });
       },

       syncSearch() {
           const value = this.searchQuery;
           if (value.length < 2) {
               this.results = { products: [], categories: [] };
               return;
           }
           
           // Attempt Client-Side Filtering if DB_PRODUCTS is available
           if (window.DB_PRODUCTS && window.DB_PRODUCTS.length > 0) {
               this.filterLocally(value);
               return;
           }

           this.isLoading = true;
           clearTimeout(this.debounceTimer);
           this.debounceTimer = setTimeout(() => {
               this.fetchSuggestions(value);
           }, 300);
       },

       filterLocally(query) {
           const term = query.toLowerCase();
           const categorySlug = this.category;

           let filtered = window.DB_PRODUCTS.filter(p => {
               const matchesName = p.name.toLowerCase().includes(term);
               const matchesCategory = categorySlug === 'Todos' || (p.category_slug === categorySlug);
               return matchesName && matchesCategory;
           });

           // Format like the API response
           this.results.products = filtered.slice(0, 5).map(p => ({
               id: p.id,
               name: p.name,
               slug: p.slug,
               image_url: p.image_url || p.image,
               price: typeof p.price === 'number' ? p.price.toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : p.price
           }));

           // For categories, we might not have all categories in DB_PRODUCTS objects, 
           // but we can try to find them if needed or just clear them.
           // Since we want to avoid reloading/db calls for products, we'll keep categories empty or fetch if really needed.
           this.results.categories = []; 
           this.isLoading = false;
       },

       fetchDefaultSuggestions() {
            // If we have DB_PRODUCTS, we can even provide default suggestions locally
            if (window.DB_PRODUCTS && window.DB_PRODUCTS.length > 0) {
                const categorySlug = this.category;
                this.defaultSuggestions = window.DB_PRODUCTS
                    .filter(p => categorySlug === 'Todos' || p.category_slug === categorySlug)
                    .slice(0, 3)
                    .map(p => ({
                        id: p.id,
                        name: p.name,
                        image_url: p.image_url || p.image,
                        price: typeof p.price === 'number' ? p.price.toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : p.price
                    }));
                return;
            }

            // Fetch highlights for empty search state context
            let url = `{{ route('shop.search.suggestions') }}?q=&category=${encodeURIComponent(this.category)}`;
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    this.defaultSuggestions = data.products || [];
                });
       },

       fetchSuggestions(query) {
           let url = `{{ route('shop.search.suggestions') }}?q=${encodeURIComponent(query)}&category=${encodeURIComponent(this.category)}`;
           fetch(url)
               .then(res => res.json())
               .then(data => {
                   this.results = data;
                   this.isLoading = false;
               })
               .catch(() => {
                   this.isLoading = false;
               });
       },

       selectItem(name) {
           this.searchQuery = name;
           this.focused = false;
           this.performSearch();
       },

       getCategoryName() {
           const select = document.querySelector('.search-category-select');
           return select ? select.options[select.selectedIndex].text : this.category;
       },

       goToCategory(slug) {
            window.location.href = "{{ url('/loja/categoria') }}/" + slug;
       },

       performSearch() {
           let url = "{{ route('shop.search') }}";
           const params = new URLSearchParams();
           params.append('q', this.searchQuery);
           if(this.category !== 'Todos') {
                params.append('category', this.category);
           }
           window.location.href = url + '?' + params.toString();
       }
   }
}
</script>
</div>
