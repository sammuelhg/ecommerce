<div class="card h-100 position-relative border-0 shadow-sm" x-data="{ 
       product: {{ json_encode($product->only(['id', 'name', 'price', 'image', 'is_offer', 'old_price'])) }},
       isFavorite: false, 
       init() {
           // Sync with server state first (if available) then check local storage (source of truth for guests)
           this.isFavorite = {{ $product->is_favorite ? 'true' : 'false' }} || this.checkLocalWishlist();
       },
       checkLocalWishlist() {
           try {
               const list = JSON.parse(localStorage.getItem('myShopWishlist') || '[]');
               return list.some(i => i.id == this.product.id);
           } catch(e) { return false; }
       },
       toggleFav() {
           this.isFavorite = !this.isFavorite;
           // Send only ID to avoid large payload
           $dispatch('toggle-wishlist', this.product); // Send full product so offcanvas can render it
       },
       updateState(event) {
           // Optional: Listen to global changes if needed, but the button click handles it locally
           // This is kept if other components change the state of THIS product
       }
    }"
    @wishlist-updated.window="isFavorite = checkLocalWishlist()"
    >
    
   {{-- Imagem com Link --}}
   <div class="position-relative overflow-hidden">
       <a href="{{ route('shop.show', $product->slug) }}">
           @if($product->image)
               <img src="{{ 
                       str_starts_with($product->image, 'http') 
                       ? $product->image 
                       : asset('storage/' . $product->image) 
                    }}" 
                    class="card-img-top object-fit-cover" 
                    alt="{{ $product->name }}"
                    style="aspect-ratio: 1 / 1; width: 100%; height: auto;"
                    onerror="this.onerror=null;this.src='https://placehold.co/250x250/f3f4f6/6c757d?text=Sem+Imagem';">
           @else
               <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 250px;">
                   <i class="bi bi-image" style="font-size: 2rem;"></i>
               </div>
           @endif
       </a>

       {{-- Badge de Oferta (Opcional) --}}
       @if($product->is_offer ?? false)
           <span class="position-absolute top-0 start-0 badge bg-danger m-2">
               Oferta
           </span>
       @endif
   </div>

   {{-- Corpo do Card --}}
   <div class="card-body d-flex flex-column">
       <a href="{{ route('shop.show', $product->slug) }}" class="card-title fw-bold text-decoration-none h3 mb-1" style="color: #000000; line-height: 1.3;">
           {{ $product->name }}
       </a>
       
       <div class="mt-auto">
           <div class="d-flex justify-content-between align-items-center mb-2">
               <span class="fw-bold text-primary" style="font-size: 1.2rem;">
                   R$ {{ number_format($product->price, 2, ',', '.') }}
               </span>
               
               {{-- Ações Secundárias (Favorito e Share) --}}
               <div class="d-flex gap-2">
                   <button type="button" 
                           @click="toggleFav()"
                           class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                           :class="isFavorite ? 'btn-danger text-white' : 'btn-warning text-dark'"
                           style="width: 32px; height: 32px;"
                           title="Adicionar aos Favoritos">
                       <i class="bi" :class="isFavorite ? 'bi-heart-fill' : 'bi-heart'"></i>
                   </button>
                   
                   <button type="button" 
                           @click.prevent="navigator.share ? navigator.share({title: '{{ $product->name }}', url: '{{ route('shop.show', $product->slug) }}'}) : alert('Compartilhamento não suportado nesta plataforma')"
                           class="btn btn-sm btn-warning text-dark rounded-circle d-flex align-items-center justify-content-center"
                           style="width: 32px; height: 32px;"
                           title="Compartilhar">
                       <i class="bi bi-share-fill"></i>
                   </button>
               </div>
           </div>
           
           {{-- Botão Principal: Adicionar ao Carrinho --}}
           <button type="button" 
                   @click="$dispatch('add-to-cart', { product: product, quantity: 1 })"
                   class="btn btn-warning w-100 btn-sm d-flex align-items-center justify-content-center" style="padding-top: 0.4rem; padding-bottom: 0.4rem;">
               <i class="bi bi-cart-plus-fill me-2"></i>
               Adicionar
           </button>
       </div>
   </div>
</div>
