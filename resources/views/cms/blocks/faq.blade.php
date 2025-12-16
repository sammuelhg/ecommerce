<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5">{{ $data['title'] }}</h2>
        <div class="accordion" id="accordionFaq-{{ Str::random(5) }}">
            @foreach($data['items'] ?? [] as $index => $item)
                @php $id = Str::random(8); @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $id }}">
                            {{ $item['q'] ?? '' }}
                        </button>
                    </h2>
                    <div id="collapse-{{ $id }}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            {{ $item['a'] ?? '' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
