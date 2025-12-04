<div class="row">
    <div class="col-12">
        <!-- Upload Area -->
        <div class="mb-4 p-4 border border-2 border-dashed rounded text-center bg-white">
            <i class="bi bi-cloud-upload fs-1 text-primary"></i>
            <h5 class="mt-3">Adicionar Imagens ao Produto</h5>
            <div class="mt-3 d-flex gap-2 justify-content-center flex-wrap">
                <label for="productImages" class="btn btn-primary btn-lg" style="cursor: pointer;">
                    <i class="bi bi-upload"></i> Upload do Dispositivo
                </label>
                <input type="file" id="productImages" wire:model="images" style="display: none;" multiple accept="image/*">
                
                <button type="button" class="btn btn-outline-primary btn-lg" onclick="openMediaLibrary()">
                    <i class="bi bi-images"></i> Biblioteca de Mídia
                </button>
            </div>
            <small class="text-muted d-block mt-3">
                <i class="bi bi-info-circle"></i> JPG, PNG, WebP • Máximo 20MB por arquivo
            </small>
        </div>

        <!-- Livewire file upload indicator -->
        <div wire:loading wire:target="images" class="alert alert-info">
            <i class="spinner-border spinner-border-sm me-2"></i> Carregando imagens...
        </div>

        <!-- Temporary Images (New Uploads) -->
        @if($images || $tempImages)
            <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">
                <i class="bi bi-cloud-plus"></i> Novas Imagens ({{ count($images) + count($tempImages) }})
            </h6>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3 mb-4">
                {{-- Standard Livewire Uploads --}}
                @foreach($images as $index => $image)
                    <div class="col" wire:key="livewire-temp-{{ $index }}">
                        <div class="card h-100 border-success border-2 shadow-sm image-card">
                            <div class="position-relative">
                                <img src="{{ $image->temporaryUrl() }}" class="card-img-top" style="aspect-ratio: 1; object-fit: cover; cursor: pointer;" 
                                     onclick="openCropper('{{ $image->temporaryUrl() }}', 'livewire-{{ $index }}')"
                                     alt="Nova imagem">
                                
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                    <i class="bi bi-plus-lg"></i> Novo (Upload)
                                </span>
                                
                                <!-- Actions Overlay -->
                                <div class="image-actions">
                                    <button type="button" onclick="openCropper('{{ $image->temporaryUrl() }}', 'livewire-{{ $index }}')" class="btn btn-sm btn-info text-white me-1" title="Recortar">
                                        <i class="bi bi-crop"></i>
                                    </button>
                                    <button type="button" wire:click="removeTempImage({{ $index }})" class="btn btn-sm btn-danger" title="Remover">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Custom Temp Images (Library/Cropped) --}}
                @foreach($tempImages as $index => $path)
                    <div class="col" wire:key="custom-temp-{{ $index }}">
                        <div class="card h-100 {{ $newMainImageIndex === $index ? 'border-primary border-3 shadow' : 'border-success border-2 shadow-sm' }} image-card">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $path) }}" class="card-img-top" style="aspect-ratio: 1; object-fit: cover; cursor: pointer;" 
                                     onclick="openCropper('{{ asset('storage/' . $path) }}', {{ $index }})"
                                     alt="Nova imagem">
                                
                                <span class="position-absolute top-0 start-0 m-2 badge {{ $newMainImageIndex === $index ? 'bg-primary' : 'bg-success' }}">
                                    @if($newMainImageIndex === $index)
                                        <i class="bi bi-star-fill"></i> Capa (Novo)
                                    @else
                                        <i class="bi bi-plus-lg"></i> Novo
                                    @endif
                                </span>
                                
                                <!-- Actions Overlay -->
                                <div class="image-actions">
                                    <button type="button" wire:click="setNewMainImage({{ $index }})" class="btn btn-sm {{ $newMainImageIndex === $index ? 'btn-warning' : 'btn-outline-warning text-white' }} me-1" title="Definir como Capa">
                                        <i class="bi {{ $newMainImageIndex === $index ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    </button>
                                    <button type="button" onclick="openCropper('{{ asset('storage/' . $path) }}', {{ $index }})" class="btn btn-sm btn-info text-white me-1" title="Recortar">
                                        <i class="bi bi-crop"></i>
                                    </button>
                                    <button type="button" wire:click="removeTempImage({{ $index }})" class="btn btn-sm btn-danger" title="Remover">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Existing Gallery -->
        @if($isEditing && isset($existingImages) && count($existingImages) > 0)
            <h6 class="text-muted border-bottom pb-2 mb-3">
                <i class="bi bi-images"></i> Galeria Atual ({{ count($existingImages) }} {{ count($existingImages) > 1 ? 'imagens' : 'imagem' }})
            </h6>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
                @foreach($existingImages as $image)
                    @livewire('admin.product-image-item', ['imageId' => $image->id, 'productId' => $productId], key('img-'.$image->id))
                @endforeach
            </div>
        @elseif($isEditing && (!isset($existingImages) || count($existingImages) === 0))
            <div class="alert alert-secondary text-center py-5">
                <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
                <p class="mb-0">Nenhuma imagem na galeria. Adicione imagens usando os botões acima.</p>
            </div>
        @endif
    </div>
</div>

<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recortar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="img-container" style="max-height: 500px;">
                    <img id="imageToCrop" src="" style="max-width: 100%; display: block;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="cropImageBtn">
                    <i class="bi bi-check-lg"></i> Confirmar Recorte
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .image-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .image-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .image-actions {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 8px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        display: flex;
        justify-content: center;
        gap: 8px;
        opacity: 1;
    }
    
    @media (min-width: 768px) {
        .image-actions {
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .image-card:hover .image-actions {
            opacity: 1;
        }
    }
</style>
@endpush
