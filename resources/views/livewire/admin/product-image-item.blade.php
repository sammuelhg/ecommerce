<div class="col" wire:key="image-{{ $imageId }}">
    <div class="card h-100 {{ $isMain ? 'border-primary border-3 shadow' : 'border' }} image-card">
        <div class="position-relative">
            <img src="{{ asset('storage/' . $imagePath) }}" class="card-img-top" style="aspect-ratio: 1; object-fit: cover;" alt="Imagem do produto">
            
            @if($isMain)
                <span class="position-absolute top-0 start-0 m-2 badge bg-primary">
                    <i class="bi bi-star-fill"></i> Capa
                </span>
            @endif
            
            <!-- Actions Overlay -->
            <div class="image-actions">
                @if(!$isMain)
                    <button type="button"
                            wire:click="setMainImage"
                            wire:loading.attr="disabled"
                            class="btn btn-sm btn-warning"
                            title="Definir como Capa">
                        <i class="bi bi-star"></i>
                    </button>
                @endif
                <button type="button"
                        onclick="openCropper('{{ asset('storage/' . $imagePath) }}', 'existing-{{ $imageId }}')"
                        class="btn btn-sm btn-info text-white"
                        title="Recortar">
                    <i class="bi bi-crop"></i>
                </button>
                <button type="button"
                        wire:click="deleteImage"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-danger"
                        title="Excluir">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
</div>
