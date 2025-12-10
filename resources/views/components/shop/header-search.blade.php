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
                       return \App\Models\Category::where('is_active', true)->orderBy('name')->get();
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

   <div class="search-suggestions-dropdown" 
        x-show="focused && (searchQuery.length > 0 || isQueryEmpty)" 
        x-transition.opacity.duration.200ms
        style="display: none;">
       
       <!-- Empty Search: Show Featured/Random Products -->
       <template x-if="isQueryEmpty">
           <ul class="list-group list-group-flush text-start">
               <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2">
                   🔥 Destaques <span x-show="category !== 'Todos'" x-text="'em ' + category" class="text-lowercase"></span>
               </li>
               
               <template x-for="suggestion in defaultSuggestions" :key="suggestion.id">
                   <li class="list-group-item list-group-item-action cursor-pointer" 
                       @click="selectItem(suggestion.name)">
                       <i class="bi bi-search me-2 text-muted"></i> 
                       <span x-text="suggestion.name"></span>
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
                        <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2">
                            Categorias
                        </li>
                        <template x-for="cat in results.categories" :key="cat.id">
                            <li class="list-group-item list-group-item-action cursor-pointer" 
                                @click="goToCategory(cat.slug)">
                                <i class="bi bi-grid-fill me-2 text-muted"></i>
                                <span x-text="cat.name"></span>
                            </li>
                        </template>
                    </div>
                </template>

                <!-- PRODUTOS -->
                <template x-if="results.products && results.products.length > 0">
                    <div>
                        <li class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2">
                             Produtos
                        </li>
                        <template x-for="prod in results.products" :key="prod.id">
                            <li class="list-group-item list-group-item-action cursor-pointer" 
                                @click="selectItem(prod.name)">
                                <i class="bi bi-search me-2 text-muted"></i>
                                <span x-text="prod.name"></span>
                            </li>
                        </template>
                    </div>
                </template>

                 <!-- Loading -->
                 <li x-show="isLoading" class="list-group-item text-center text-muted small py-3">
                    <span class="spinner-border spinner-border-sm me-2"></span> Buscando...
                 </li>

                 <!-- No Results -->
                 <li x-show="!isLoading && (!results.products?.length && !results.categories?.length)" 
                     class="list-group-item text-center text-muted small py-3">
                    Nenhum resultado para "<span x-text="searchQuery"></span>"
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
           });

           this.$watch('searchQuery', (value) => {
               if (value.length < 2) {
                   this.results = { products: [], categories: [] };
                   // No need to re-fetch default suggestions here, they are independent of query text (unless empty)
                   // But layout switches based on isQueryEmpty.
                   return;
               }
               
               this.isLoading = true;
               clearTimeout(this.debounceTimer);
               this.debounceTimer = setTimeout(() => {
                   this.fetchSuggestions(value);
               }, 300);
           });
       },

       fetchDefaultSuggestions() {
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
