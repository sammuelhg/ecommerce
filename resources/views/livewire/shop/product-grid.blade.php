<div>
    <div class="container py-4">

        <div class="row g-4">
            @forelse($gridItems as $item)
                {{-- 5-Column Grid Logic --}}
                @php
                    $span = $item['col_span'] ?? 1;
                    $widthPercent = $span * 20; 
                    $desktopClass = 'col-md-' . $widthPercent;
                @endphp
                <div class="col-12 {{ $desktopClass }}">
                    
                    @if(isset($item['type']) && $item['type'] === 'marketing_banner')
                        {{-- Renderiza Banner --}}
                        <x-cards.marketing_banner :data="$item['content']" />

                    @elseif(isset($item['type']) && $item['type'] === 'card.newsletter_form')
                         {{-- Renderiza Form (Legacy Support) --}}
                         <x-cards.newsletter_form :data="$item['content']" :cols="$item['col_span'] ?? 1" />
                        
                    @elseif(isset($item['content']) && $item['content'] instanceof \App\Models\Product)
                        {{-- Renderiza Produto --}}
                        @livewire('shop.product-card', ['product' => $item['content']], key('prod-'.$item['content']->id))
                        
                    @elseif(isset($item['type']) && str_contains($item['type'], 'product_special'))
                         {{-- Special Product Card --}}
                         @if(isset($item['content']['product']))
                            <x-cards.product_special :product="$item['content']['product']" :data="$item['content']['data'] ?? []" />
                         @endif
                    @else
                        {{-- Fallback de Debug (Só aparece se algo estiver estranho) --}}
                        {{-- <div class="alert alert-warning">Item desconhecido no Grid</div> --}}
                        {{-- Silent Fallback: if product structure matches --}}
                         @if(isset($item['content']) && $item['content'] instanceof \App\Models\Product)
                            @livewire('shop.product-card', ['product' => $item['content']], key('prod-fallback-'.$item['content']->id))
                         @endif
                    @endif
                    
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">Nenhum produto encontrado :(</h3>
                    <p>Tente ajustar os filtros ou volte mais tarde.</p>
                </div>
            @endforelse
        </div>
    
        {{-- Paginação fora do loop --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
