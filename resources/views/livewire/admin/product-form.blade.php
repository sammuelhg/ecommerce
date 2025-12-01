<div>
    <div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-{{ $isEditing ? 'pencil' : 'plus-circle' }}"></i>
                {{ $isEditing ? 'Editar Produto' : 'Novo Produto' }}
            </h5>
            <button type="button" wire:click="$dispatch('closeForm')" class="btn btn-sm btn-light">
                <i class="bi bi-x-lg"></i> Fechar
            </button>
        </div>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            
            <!-- Tabs Navigation + Save Button -->
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom">
                <ul class="nav nav-tabs border-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" 
                                class="nav-link {{ $activeTab === 'general' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'general')"
                                role="tab">
                            <i class="bi bi-info-circle"></i> Geral
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" 
                                class="nav-link {{ $activeTab === 'images' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'images')"
                                role="tab">
                            <i class="bi bi-images"></i> Imagens
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" 
                                class="nav-link {{ $activeTab === 'pricing' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'pricing')"
                                role="tab">
                            <i class="bi bi-currency-dollar"></i> Preço & Estoque
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" 
                                class="nav-link {{ $activeTab === 'seo' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'seo')"
                                role="tab">
                            <i class="bi bi-google"></i> SEO & Marketing
                        </button>
                    </li>
                </ul>

                <!-- Save Button aligned with tabs -->
                <div class="d-flex align-items-center gap-2">
                    <span wire:loading wire:target="save" class="text-muted small">
                        <span class="spinner-border spinner-border-sm me-1"></span> Salvando...
                    </span>
                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                        <i class="bi bi-check-lg"></i> {{ $isEditing ? 'Atualizar' : 'Salvar' }}
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content border p-4 rounded-bottom border-top-0 bg-white" id="productTabsContent">
                
                <!-- General Tab -->
                <div class="tab-pane fade {{ $activeTab === 'general' ? 'show active' : '' }}" id="general" role="tabpanel">
                    @include('livewire.admin.product-form.general')
                </div>

                <!-- Images Tab -->
                <div class="tab-pane fade {{ $activeTab === 'images' ? 'show active' : '' }}" id="images" role="tabpanel">
                    @include('livewire.admin.product-form.images')
                </div>

                <!-- Pricing Tab -->
                <div class="tab-pane fade {{ $activeTab === 'pricing' ? 'show active' : '' }}" id="pricing" role="tabpanel">
                    @include('livewire.admin.product-form.pricing')
                </div>

                <!-- SEO Tab -->
                <div class="tab-pane fade {{ $activeTab === 'seo' ? 'show active' : '' }}" id="seo" role="tabpanel">
                    @include('livewire.admin.product-form.seo')
                </div>

            </div>

        </form>
    </div>
</div>

<!-- Image Crop Modal -->
<div class="modal fade" id="imageCropModal" tabindex="-1" aria-labelledby="imageCropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageCropModalLabel">
                    <i class="bi bi-crop"></i> Cortar Imagem
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="cropperImage" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="cropButton">
                    <i class="bi bi-check-circle"></i> Aplicar Corte
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
<style>
    .cropper-container {
        max-height: 500px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let cropper = null;
    let currentFile = null;
    let currentInput = null;
    
    // Add click handler to file inputs for crop functionality
    const fileInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file || !file.type.match('image.*')) return;
            
            currentFile = file;
            currentInput = input;
            
            const reader = new FileReader();
            reader.onload = function(event) {
                const image = document.getElementById('cropperImage');
                image.src = event.target.result;
                
                // Destroy previous cropper instance if exists
                if (cropper) {
                    cropper.destroy();
                }
                
                // Initialize Cropper
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Square crop - change to 16/9 for landscape, etc.
                    viewMode: 2,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                    guides: true,
                    center: true,
                    highlight: true,
                    cropBoxResizable: true,
                    cropBoxMovable: true,
                    dragMode: 'move'
                });
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('imageCropModal'));
                modal.show();
            };
            
            reader.readAsDataURL(file);
        });
    });
    
    // Handle crop button
    document.getElementById('cropButton').addEventListener('click', function() {
        if (!cropper) return;
        
        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 1200, // Max width
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });
        
        // Convert to blob and create new File
        canvas.toBlob(function(blob) {
            const croppedFile = new File([blob], currentFile.name, {
                type: 'image/jpeg',
                lastModified: Date.now()
            });
            
            // Create a new FileList (workaround since FileList is read-only)
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            currentInput.files = dataTransfer.files;
            
            // Trigger Livewire update
            currentInput.dispatchEvent(new Event('change', { bubbles: true }));
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('imageCropModal')).hide();
            
            // Destroy cropper
            cropper.destroy();
            cropper = null;
        }, 'image/jpeg', 0.9);
    });
});
</script>
@endpush
</div>
