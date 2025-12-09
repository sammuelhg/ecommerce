@props(['data'])
<div {{ $attributes->merge(['class' => 'card h-100 border-0 overflow-hidden position-relative shadow-sm ' . ($data['bg_color'] ?? 'bg-primary') . ' ' . ($data['text_color'] ?? 'text-white')]) }}>
    @php
        $imageStyle = $data['image_style'] ?? 'background';
    @endphp

    @if(isset($data['image']) && $data['image'])
        @if($imageStyle === 'background')
             <div class="position-absolute top-0 start-0 w-100 h-100" 
                  style="background-image: url('{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}'); background-size: cover; background-position: center;">
                  <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.3;"></div> 
             </div>
        @else
             <div class="w-100 flex-shrink-0">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}" class="card-img-top object-fit-cover" style="height: 200px;">
             </div>
        @endif
    @endif
    
    <div class="card-body d-flex flex-column justify-content-center align-items-start p-4 position-relative" style="z-index: 2;">
        @if(!empty($data['title']))
            <h3 class="card-title fw-bold mb-2">{{ $data['title'] }}</h3>
        @endif
        
        @if(!empty($data['text']))
            <p class="card-text mb-4 fs-5">{!! $data['text'] !!}</p>
        @endif
        
        @if(!empty($data['link']))
            <a href="{{ $data['link'] }}" class="btn {{ $data['btn_color'] ?? 'btn-light' }} fw-bold px-4 rounded-pill">
                {{ $data['button_text'] ?? 'Ver Oferta' }}
            </a>
        @endif
    </div>
</div>
