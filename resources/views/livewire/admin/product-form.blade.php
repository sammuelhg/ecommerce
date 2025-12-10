<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
    <!-- Sticky Header for Actions -->
    <div class="sticky-top bg-white border-bottom shadow-sm py-3 mb-4" style="z-index: 1020;">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    <h4 class="mb-0 fw-bold text-dark">
                        {{ $productId ? 'Editar Produto' : 'Novo Produto' }}
                    </h4>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" id="saveProductBtn" wire:loading.attr="disabled" class="btn btn-primary px-4 fw-bold">
                        <span wire:loading.remove wire:target="save"><i class="bi bi-check-lg me-1"></i> Salvar Produto</span>
                        <span wire:loading wire:target="save"><i class="spinner-border spinner-border-sm me-1"></i> Salvando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 pb-5">
        
        <!-- Product Identity Section (Always Visible) -->
        <div class="card border-0 shadow-sm mb-4" 
             x-data="{
                 types: @js($types->pluck('name', 'id')->toArray()),
                 models: @js($models->pluck('name', 'id')->toArray()),
                 materials: @js($materials->pluck('name', 'id')->toArray()),
                 colors: @js($colors->pluck('name', 'id')->toArray()),
                 sizes: @js($sizes->pluck('name', 'id')->toArray()),
                 
                 generateTitle() {
                     let parts = [];
                     
                     if ($wire.product_type_id && this.types[$wire.product_type_id]) {
                         parts.push(this.types[$wire.product_type_id]);
                     }
                     
                     if ($wire.product_model_id && this.models[$wire.product_model_id]) {
                         parts.push(this.models[$wire.product_model_id]);
                     }
                     
                     if ($wire.product_material_id && this.materials[$wire.product_material_id]) {
                         parts.push('em ' + this.materials[$wire.product_material_id]);
                     }
                     
                     if ($wire.attribute) {
                         parts.push($wire.attribute);
                     }
                     
                     if ($wire.product_color_id && this.colors[$wire.product_color_id]) {
                         parts.push('– ' + this.colors[$wire.product_color_id]);
                     }
                     
                     if ($wire.product_size_id && this.sizes[$wire.product_size_id]) {
                         parts.push('Tamanho ' + this.sizes[$wire.product_size_id]);
                     }
                     
                     if (parts.length > 0) {
                         let title = parts.join(' ');
                         // Capitalize first letter of each word
                         title = title.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
                         $wire.name = title;
                     }
                 }
             }"
             x-init="$watch('$wire.product_type_id', () => generateTitle());
                     $watch('$wire.product_model_id', () => generateTitle());
                     $watch('$wire.product_material_id', () => generateTitle());
                     $watch('$wire.product_color_id', () => generateTitle());
                     $watch('$wire.product_size_id', () => generateTitle());
                     $watch('$wire.attribute', () => generateTitle());">
            <div class="card-body bg-light rounded-3 p-4">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <label class="form-label text-muted small text-uppercase fw-bold mb-1">Título do Produto (Gerado Automaticamente)</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-tag-fill"></i></span>
                            <input type="text" wire:model="name" class="form-control bg-white border-start-0 fw-bold text-primary fs-4" placeholder="O título será gerado automaticamente..." readonly>
                        </div>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 text-end">
                        <label class="form-label text-muted small text-uppercase fw-bold d-block mb-1">Status</label>
                        <div class="form-check form-switch form-switch-lg d-inline-block">
                            <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" wire:model="is_active">
                            <label class="form-check-label fw-bold {{ $is_active ? 'text-success' : 'text-muted' }}" for="statusSwitch">
                                {{ $is_active ? 'Ativo' : 'Inativo' }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AlpineJS Tabs        <div class="card border-0 shadow-sm" x-data="{ activeTab: 'general' }" x-init="$watch('activeTab', value => $wire.set('activeTab', value))">
            <!-- Removed bg-white, kept border-bottom-0 to merge with body -->
            <div class="card-header border-bottom-0 pt-3 px-3">
                <ul class="nav nav-tabs nav-fill card-header-tabs nav-tabs-dark-mode" id="productTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3" 
                                :class="{ 'active': activeTab === 'general' }"
                                @click.prevent="activeTab = 'general'"
                                type="button">
                            <i class="bi bi-box-seam me-2"></i> Geral
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3" 
                                :class="{ 'active': activeTab === 'pricing' }"
                                @click.prevent="activeTab = 'pricing'"
                                type="button">
                            <i class="bi bi-currency-dollar me-2"></i> Preço & Estoque
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3" 
                                :class="{ 'active': activeTab === 'images' }"
                                @click.prevent="activeTab = 'images'"
                                type="button">
                            <i class="bi bi-images me-2"></i> Imagens
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3" 
                                :class="{ 'active': activeTab === 'seo' }"
                                @click.prevent="activeTab = 'seo'"
                                type="button">
                            <i class="bi bi-google me-2"></i> SEO & Detalhes
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <!-- General Tab -->
                    <div class="tab-pane fade" :class="{ 'active show': activeTab === 'general' }">
                        @include('livewire.admin.product-form.general')
                    </div>

                    <!-- Pricing Tab -->
                    <div class="tab-pane fade" :class="{ 'active show': activeTab === 'pricing' }">
                        @include('livewire.admin.product-form.pricing')
                    </div>

                    <!-- Images Tab -->
                    <div class="tab-pane fade" :class="{ 'active show': activeTab === 'images' }">
                        @include('livewire.admin.product-form.images')
                    </div>

                    <!-- SEO Tab -->
                    <div class="tab-pane fade" :class="{ 'active show': activeTab === 'seo' }">
                        @include('livewire.admin.product-form.seo')
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Feedback Messages -->
        {{-- <x-flash-messages /> --}}
        
        {{-- @include('livewire.admin.product-form.crop-modal') --}}

    </div>
    </form>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('validation-errors', (data) => {
            const tabId = data[0].tab; 
            if (tabId) {
                const tabTriggerEl = document.querySelector(`#${tabId}-tab`);
                if (tabTriggerEl) {
                    const tab = new bootstrap.Tab(tabTriggerEl);
                    tab.show();
                }
            }
        });
    });
</script>
@endpush
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<style>
    /* Custom Tab Styling for Primary Header */
    .nav-tabs-dark-mode {
        border-bottom: none; /* Card body handles the border */
    }
    .nav-tabs-dark-mode .nav-link {
        color: rgba(255, 255, 255, 0.85);
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        padding: 1rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }
    .nav-tabs-dark-mode .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: transparent;
        color: #fff;
    }
    .nav-tabs-dark-mode .nav-link.active {
        color: var(--bs-primary);
        background-color: #fff;
        border-color: #fff #fff #fff; /* Match card body background */
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    window.addEventListener('switch-tab', event => {
        const tabId = event.detail[0];
        const triggerEl = document.querySelector(`#productTabs button[data-bs-target="#${tabId}"]`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    });

    window.addEventListener('validation-errors', event => {
        // Handle both Livewire event structures
        const params = event.detail;
        const tabId = params.tab || (params[0] && params[0].tab);
        
        if (tabId) {
            const triggerEl = document.querySelector(`#productTabs button[data-bs-target="#${tabId}"]`);
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }
    });

    // Livewire hook to handle successful commits if needed
    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
        succeed(({ snapshot, effect }) => {
            // Additional logic if needed after update
        });
    });

    // Cropper Logic
    let cropper;
    let currentImageIndex;
    let cropperModal;
    const imageElement = document.getElementById('imageToCrop');

    // Define openMediaLibrary to prevent ReferenceError
    window.openMediaLibrary = function() {
        // Check if the global event exists or just alert for now
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('open-media-library'); 
        } else {
            console.warn('Media Library not available yet');
            alert('Biblioteca de Mídia em desenvolvimento.');
        }
    };

    window.openCropper = function(imageUrl, index) {
        // Lazy init modal to ensure bootstrap is loaded
        if (!cropperModal) {
            if (typeof bootstrap === 'undefined') {
                // Try to get from window
                if (window.bootstrap) {
                    cropperModal = new window.bootstrap.Modal(document.getElementById('cropperModal'));
                } else {
                    console.error('Bootstrap is not loaded yet!');
                    return;
                }
            } else {
                cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
            }
            
            // Setup events only once
            document.getElementById('cropperModal').addEventListener('shown.bs.modal', function () {
                if (cropper) cropper.destroy();
                cropper = new Cropper(imageElement, {
                    aspectRatio: 1, // Square crop by default
                    viewMode: 1,
                    autoCropArea: 1,
                });
            });
            
            document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                imageElement.src = '';
            });
        }

        currentImageIndex = index;
        imageElement.src = imageUrl;
        
        cropperModal.show();
    };

    document.getElementById('cropImageBtn').addEventListener('click', function() {
        if (!cropper) return;

        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 800,
            height: 800,
        });

        // Get base64
        const base64Data = canvas.toDataURL('image/jpeg');

        // Check if it's a Livewire upload (has 'livewire-' prefix) or temp image (numeric)
        if (typeof currentImageIndex === 'string' && currentImageIndex.startsWith('livewire-')) {
            // Extract numeric index from 'livewire-0' -> 0
            const index = parseInt(currentImageIndex.replace('livewire-', ''));
            
            // For Livewire uploads, we need to convert to temp image
            // Send the base64 directly and let backend handle conversion
            @this.call('cropLivewireUpload', index, base64Data);
        } else if (typeof currentImageIndex === 'string' && currentImageIndex.startsWith('existing-')) {
            // Existing image from DB
            const id = parseInt(currentImageIndex.replace('existing-', ''));
            @this.call('cropExistingImage', id, base64Data);
        } else {
            // It's a temp image (from library/previous crop)
            @this.updateCroppedImage(currentImageIndex, base64Data);
        }

        cropperModal.hide();
    });

    // Helper functions for image actions
    window.deleteProductImage = function(imageId) {
        if (confirm('Tem certeza que deseja excluir esta imagem?')) {
            const component = Livewire.find('{{ $_instance->getId() }}');
            if (component) {
                component.call('deleteImage', imageId);
            } else {
                console.error('Livewire component not found');
            }
        }
    };

    window.setProductMainImage = function(imageId) {
        const component = Livewire.find('{{ $_instance->getId() }}');
        if (component) {
            component.call('setMainImage', imageId);
        } else {
            console.error('Livewire component not found');
        }
    };
</script>
@endpush
</div>
