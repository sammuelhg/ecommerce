<div class="container py-4">
    <div class="row">
        <!-- Sidebar Navigation -->
        <x-account-sidebar />

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i> Editar Perfil</h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="save" x-data="profileForm()">
                        <div class="row g-4">
                            <!-- Avatar Upload Section -->
                            <div class="col-12 d-flex align-items-center mb-2">
                                <div class="position-relative me-4">
                                    <img :src="avatarPreview || '{{ $currentAvatar }}'"
                                         class="rounded-circle img-thumbnail" width="100" height="100" alt="Avatar"
                                         style="object-fit: cover;">
                                    @if(!$socialProvider)
                                        <label class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1 cursor-pointer shadow-sm" 
                                               style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                            <i class="bi bi-camera-fill small"></i>
                                            <input type="file" accept="image/*" class="d-none"
                                                   @change="handleAvatar($event)">
                                        </label>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Foto de Perfil</h6>
                                    @if($socialProvider)
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-{{ $isGoogleUser ? 'google' : 'facebook' }} me-1"></i>
                                            Sincronizado com {{ $socialProvider }}
                                        </p>
                                    @else
                                        <p class="text-muted small mb-0">Formatos: JPG, PNG. Max: 2MB</p>
                                        <div wire:loading wire:target="avatar" class="text-primary small mt-1">Carregando...</div>
                                        @error('avatar') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nome Completo</label>
                                <input type="text" wire:model="name" 
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">E-mail</label>
                                <input type="email" wire:model.live="email" 
                                       class="form-control @error('email') is-invalid @enderror"
                                       @if($socialProvider) disabled @endif>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @if($socialProvider)
                                    <div class="mt-2">
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-{{ $isGoogleUser ? 'google' : 'facebook' }} me-1"></i>
                                            Conectado via {{ $socialProvider }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Telefone</label>
                                <input type="text" x-mask="(99) 99999-9999" wire:model.live="phone"
                                       class="form-control @error('phone') is-invalid @enderror" placeholder="(99) 99999-9999">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">CPF</label>
                                <input type="text" x-mask="999.999.999-99" wire:model.live="taxvat"
                                       class="form-control @error('taxvat') is-invalid @enderror" placeholder="000.000.000-00">
                                @error('taxvat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <h6 class="fw-bold border-bottom pb-2 mb-3">Segurança</h6>
                            </div>

                            @if($hasPassword)
                                <!-- User has password - can change it -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Nova Senha</label>
                                    <div class="input-group">
                                        <input :type="showPass ? 'text' : 'password'" wire:model="password" class="form-control @error('password') is-invalid @enderror">
                                        <button type="button" class="btn btn-outline-secondary" @click="showPass = !showPass">
                                            <i :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                                        </button>
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <small class="text-muted">Deixe em branco para manter a atual.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Confirmar Senha</label>
                                    <input type="password" wire:model="password_confirmation" class="form-control">
                                </div>
                            @else
                                <!-- User doesn't have password - show button to set one -->
                                <div class="col-12">
                                    <div class="alert alert-info d-flex align-items-center">
                                        <i class="bi bi-info-circle fs-4 me-3"></i>
                                        <div class="flex-grow-1">
                                            <strong>Senha não definida</strong>
                                            <p class="mb-0 small">Você está usando login via {{ $socialProvider }}. Defina uma senha para poder fazer login também com email e senha.</p>
                                        </div>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#passwordModal" class="btn btn-primary ms-3">
                                            <i class="bi bi-key me-2"></i>Definir Senha
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12 mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4 fw-bold" wire:loading.attr="disabled">
                                    <span wire:loading.remove>SALVAR ALTERAÇÕES</span>
                                    <span wire:loading>SALVANDO...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Definir Senha -->
    <div class="modal fade" id="passwordModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-key me-2"></i>Definir Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Defina uma senha para poder fazer login com email e senha, além do login via {{ $socialProvider }}.</p>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha</label>
                        <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Senha</label>
                        <input type="password" wire:model="password_confirmation" class="form-control" placeholder="Digite a senha novamente">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="setPassword" wire:loading.attr="disabled">
                        <span wire:loading.remove>Definir Senha</span>
                        <span wire:loading>Salvando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Cropper Modal -->
    <div class="modal fade" id="avatarCropperModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white border-bottom-0">
                    <h5 class="modal-title"><i class="bi bi-crop me-2"></i>Recortar Foto de Perfil</h5>
                    <button type="button" class="btn-close btn-close-warning" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="img-container" style="max-height: 400px;">
                        <img id="avatarToCrop" src="" style="max-width: 100%; display: block;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" :disabled="isCropping">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="window.cropAndClose()" :disabled="isCropping">
                        <i class="bi bi-check-lg"></i> Confirmar Recorte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
@endpush

@push('scripts')
<!-- Cropper.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush

@script
<script>
    $wire.on('password-set', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('passwordModal'));
        modal.hide();
    });
</script>
@endscript

<script>
function profileForm() {
    return {
        avatarPreview: null,
        showPass: false,
        cropperModal: null,
        cropper: null,
        selectedFile: null,
        isCropping: false,

        handleAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                this.selectedFile = file;
                const imageUrl = URL.createObjectURL(file);
                this.openCropper(imageUrl);
            }
        },

        openCropper(imageUrl) {
            const modalEl = document.getElementById('avatarCropperModal');
            const imageElement = document.getElementById('avatarToCrop');
            
            if (typeof Cropper === 'undefined') {
                console.error('Cropper.js not loaded');
                alert('Erro: Biblioteca de recorte não carregada. Recarregue a página.');
                return;
            }
            
            // Clean up existing cropper immediately
            if (this.cropper) {
                this.cropper.destroy();
                this.cropper = null;
            }

            // Set image source
            imageElement.src = imageUrl;
            
            // Create or get modal instance
            if (!this.cropperModal) {
                this.cropperModal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                
                // Cleanup when modal is hidden
                modalEl.addEventListener('hidden.bs.modal', () => {
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    imageElement.src = '';
                    this.isCropping = false;
                });
            }
            
            // Show modal
            this.cropperModal.show();
            
            // Wait for modal to be fully shown to ensure dimensions are correct
            modalEl.addEventListener('shown.bs.modal', () => {
                // Ensure image is loaded
                if (imageElement.complete) {
                    this.initCropperInstance(imageElement);
                } else {
                    imageElement.onload = () => {
                        this.initCropperInstance(imageElement);
                    };
                }
            }, { once: true });
        },

        initCropperInstance(imageElement) {
            try {
                this.cropper = new Cropper(imageElement, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    center: true,
                    zoomable: true,
                    scalable: true,
                });
            } catch (error) {
                console.error('Error initializing cropper:', error);
                alert('Erro ao inicializar editor de imagem: ' + error.message);
            }
        },

        cropAvatar() {
            if (!this.cropper) return;
            
            this.isCropping = true;
            
            try {
                const canvas = this.cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                });
                
                canvas.toBlob((blob) => {
                    const croppedFile = new File([blob], this.selectedFile.name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                    
                    this.avatarPreview = URL.createObjectURL(croppedFile);
                    
                    @this.upload('avatar', croppedFile, (uploadedFilename) => {
                        // Success callback
                        this.cropperModal.hide();
                        this.isCropping = false;
                    }, () => {
                        // Error callback
                        this.isCropping = false;
                        alert('Erro no upload da imagem.');
                    });
                    
                }, 'image/jpeg', 0.95);
            } catch (error) {
                console.error('Error cropping avatar:', error);
                this.isCropping = false;
            }
        }
    }
}

// Global function to crop and close modal
window.cropAndClose = function() {
    const formElement = document.querySelector('[x-data="profileForm()"]');
    if (formElement) {
        const formInstance = Alpine.$data(formElement);
        if (formInstance && formInstance.cropAvatar) {
            formInstance.cropAvatar();
        }
    }
}

// Toast global (SweetAlert2)
document.addEventListener('livewire:init', () => {
    Livewire.on('toast', (data) => {
        // Handle array or object
        const toastData = Array.isArray(data) ? data[0] : data;
        
        Swal.fire({
            icon: toastData.icon || 'success',
            title: toastData.title,
            text: toastData.text,
            timer: 3000,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
        });
    });
});
</script>
