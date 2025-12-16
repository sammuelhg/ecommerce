<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            
            @forelse($posts as $post)
                <div class="{{ $this->getColumnClass() }}">
                    <article class="card h-100 shadow-sm border-0 overflow-hidden">
                        
                        {{-- Thumbnail --}}
                        @if($post->thumbnail)
                            <img src="{{ asset($post->thumbnail) }}" 
                                 class="card-img-top object-fit-cover" 
                                 alt="{{ $post->title }}"
                                 style="height: 200px;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            {{-- Data --}}
                            <div class="mb-2 {{ $config->subtitleColor }}" style="font-size: 0.85rem">
                                <i class="bi bi-calendar3 me-1"></i>
                                @if($config->dateFormat === 'human')
                                    {{ $post->created_at->diffForHumans() }}
                                @else
                                    {{ $post->created_at->format('d/m/Y') }}
                                @endif
                            </div>

                            {{-- Título --}}
                            <a href="#" class="text-decoration-none">
                                <h4 class="card-title {{ $config->titleSize }} {{ $config->titleColor }} fw-bold mb-2">
                                    {{ $post->title }}
                                </h4>
                            </a>

                            {{-- Subtítulo --}}
                            <p class="card-text {{ $config->subtitleSize }} {{ $config->subtitleColor }} mb-4">
                                {{ Str::limit($post->excerpt ?? $post->content, 100) }}
                            </p>

                            {{-- Rodapé: Autor e Avatar --}}
                            <div class="mt-auto d-flex align-items-center pt-3 border-top">
                                @if($config->showAvatar && $post->author?->avatar)
                                    <img src="{{ asset($post->author->avatar) }}" 
                                         class="rounded-circle me-2" 
                                         width="32" height="32" 
                                         alt="Avatar">
                                @endif
                                
                                <span class="{{ $config->authorColor }} fw-medium small">
                                    {{ $post->author->name ?? 'Admin' }}
                                </span>
                            </div>

                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Nenhum post publicado ainda.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>
