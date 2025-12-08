<div class="container py-4">
    <div class="grid-dynamic" id="product-grid">
        @foreach($gridItems as $item)
            @php
                $componentName = $item['type'];
                if (str_starts_with($componentName, 'card.')) {
                    $componentName = 'cards.' . str_replace('card.', '', $componentName);
                } elseif ($componentName === 'marketing_banner') {
                    $componentName = 'cards.marketing_banner';
                }
                
                // Map col_span to CSS class
                $spanClass = 'span-' . ($item['col_span'] ?? 1);
            @endphp

            <div class="{{ $spanClass }} d-flex">
                @if($item['type'] === 'marketing_banner')
                    <x-dynamic-component :component="$componentName" :data="$item['content']" class="w-100" />
                @elseif($item['type'] === 'card.newsletter_form')
                    <x-dynamic-component :component="$componentName" :data="$item['content']" class="w-100" />
                @else
                    <x-dynamic-component :component="$componentName" :product="$item['content']" class="w-100" />
                @endif
            </div>
        @endforeach
    </div>

    {{-- Pagination Links --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>
