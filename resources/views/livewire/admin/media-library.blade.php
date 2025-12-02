<div>
    <!-- Modal -->
    <div class="modal fade" id="mediaLibraryModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Biblioteca de Mídia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                        <!-- Search Bar -->
                        <div class="col-12 mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="librarySearch" class="form-control" placeholder="Buscar imagens...">
                            </div>
                        </div>

                        @forelse($mediaLibrary as $media)
                            <div class="col" wire:key="library-{{ $media->id }}">
                                <div class="card library-image-card h-100 {{ in_array($media->path, $selectedLibraryImages) ? 'selected' : '' }}" 
                                    wire:click="selectFromLibrary('{{ $media->path }}')"
                                    style="cursor: pointer; transition: all 0.2s;">
                                    
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $media->path) }}" 
                                            class="card-img-top" 
                                            style="aspect-ratio: 1; object-fit: cover;"
                                            loading="lazy"
                                            alt="Media">
                                        
                                        @if(in_array($media->path, $selectedLibraryImages))
                                            <span class="position-absolute top-0 end-0 m-1 badge bg-primary shadow-sm">
                                                <i class="bi bi-check-lg"></i> {{ array_search($media->path, $selectedLibraryImages) + 1 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Nenhuma imagem encontrada.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="addSelectedLibraryImage" {{ empty($selectedLibraryImages) ? 'disabled' : '' }}>
                        <i class="bi bi-plus-lg"></i> Adicionar Selecionadas ({{ count($selectedLibraryImages) }})
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .library-image-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .library-image-card.selected {
            border: 2px solid var(--bs-primary);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let mediaModal;

            Livewire.on('open-media-library-modal', () => {
                if (!mediaModal) {
                    mediaModal = new bootstrap.Modal(document.getElementById('mediaLibraryModal'));
                }
                mediaModal.show();
            });

            Livewire.on('close-media-library-modal', () => {
                if (mediaModal) {
                    mediaModal.hide();
                }
            });
        });
    </script>
</div>
