@props(['data' => [], 'cols' => 1])
<div {{ $attributes->merge(['class' => 'card h-100 border-0 d-flex flex-column p-0 position-relative overflow-hidden shadow-sm ' . ($data['bg_color'] ?? 'bg-white') . ' ' . ($data['text_color'] ?? '')]) }}
     style="color: {{ isset($data['text_color']) && $data['text_color'] ? '' : '#1a1a1a' }};">
    @php
        $imageStyle = $data['image_style'] ?? 'background';
    @endphp

    @if(isset($data['image']) && $data['image'])
        @if($imageStyle === 'background')
            <div class="position-absolute top-0 start-0 w-100 h-100 placeholder-glow" style="background-image: url('{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}'); background-size: cover; background-position: center; opacity: 0.3;" onerror="this.style.display='none'"></div>
            {{-- Fallback for background image using hidden img to detect error --}}
            <img src="{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}" style="display:none;" onerror="this.previousElementSibling.style.display='none'; this.closest('.card').classList.add('bg-light');">
        @else
            <div class="w-100 flex-shrink-0">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}" class="card-img-top object-fit-cover" style="aspect-ratio: {{ $cols }} / 1; width: 100%; height: auto;" onerror="this.style.display='none'; this.closest('.card').classList.add('bg-light');">
            </div>
        @endif
    @endif
    <div class="w-100 p-3 position-relative d-flex flex-column h-100" style="z-index: 2;">
        @if(!empty($data['form_id']))
            {{-- New Architecture: Use Universal Form --}}
            <livewire:cms.universal-form :formId="$data['form_id']" :headless="true" />
        @endif
    </div>
</div>
