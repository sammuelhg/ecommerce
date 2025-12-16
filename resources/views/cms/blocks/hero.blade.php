<section class="py-5 bg-light text-{{ $data['layout'] === 'center' ? 'center' : 'start' }}">
    <div class="container">
        @if(!empty($data['image']))
            <img src="{{ $data['image'] }}" class="img-fluid mb-4 rounded" alt="{{ $data['title'] }}" style="max-height: 400px; object-fit: cover;">
        @endif
        <h1 class="display-4 fw-bold">{{ $data['title'] }}</h1>
        <p class="lead text-muted">{{ $data['subtitle'] }}</p>
    </div>
</section>
