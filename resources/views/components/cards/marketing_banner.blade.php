@props(['data'])

<div class="card h-100 border-0 shadow-sm {{ $data['bg_class'] ?? 'bg-light' }}">
    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4">
        <h3 class="card-title fw-bold mb-3">{{ $data['title'] ?? 'Banner' }}</h3>
        <p class="card-text fs-5">{{ $data['text'] ?? '' }}</p>
        @if(isset($data['link']))
            <a href="{{ $data['link'] }}" class="btn btn-light mt-3 fw-bold rounded-pill px-4">Ver Mais</a>
        @endif
    </div>
</div>
