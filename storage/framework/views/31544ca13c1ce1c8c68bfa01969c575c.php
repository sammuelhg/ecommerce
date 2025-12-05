<div class="container py-4">
    <div class="row">
        <!-- Sidebar Navigation -->
        <?php if (isset($component)) { $__componentOriginal891d8b2665b7c453a51bca8edecbbc95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal891d8b2665b7c453a51bca8edecbbc95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.account-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('account-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal891d8b2665b7c453a51bca8edecbbc95)): ?>
<?php $attributes = $__attributesOriginal891d8b2665b7c453a51bca8edecbbc95; ?>
<?php unset($__attributesOriginal891d8b2665b7c453a51bca8edecbbc95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal891d8b2665b7c453a51bca8edecbbc95)): ?>
<?php $component = $__componentOriginal891d8b2665b7c453a51bca8edecbbc95; ?>
<?php unset($__componentOriginal891d8b2665b7c453a51bca8edecbbc95); ?>
<?php endif; ?>

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
                                    <img :src="avatarPreview || '<?php echo e($currentAvatar); ?>'"
                                         class="rounded-circle img-thumbnail" width="100" height="100" alt="Avatar"
                                         style="object-fit: cover;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$socialProvider): ?>
                                        <label class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1 cursor-pointer shadow-sm" 
                                               style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                            <i class="bi bi-camera-fill small"></i>
                                            <input type="file" accept="image/*" class="d-none"
                                                   @change="handleAvatar($event)">
                                        </label>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Foto de Perfil</h6>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialProvider): ?>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-<?php echo e($isGoogleUser ? 'google' : 'facebook'); ?> me-1"></i>
                                            Sincronizado com <?php echo e($socialProvider); ?>

                                        </p>
                                    <?php else: ?>
                                        <p class="text-muted small mb-0">Formatos: JPG, PNG. Max: 2MB</p>
                                        <div wire:loading wire:target="avatar" class="text-primary small mt-1">Carregando...</div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small d-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nome Completo</label>
                                <input type="text" wire:model="name" 
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">E-mail</label>
                                <input type="email" wire:model.live="email" 
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       <?php if($socialProvider): ?> disabled <?php endif; ?>>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialProvider): ?>
                                    <div class="mt-2">
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-<?php echo e($isGoogleUser ? 'google' : 'facebook'); ?> me-1"></i>
                                            Conectado via <?php echo e($socialProvider); ?>

                                        </span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Telefone</label>
                                <input type="text" x-mask="(99) 99999-9999" wire:model.live="phone"
                                       class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="(99) 99999-9999">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">CPF</label>
                                <input type="text" x-mask="999.999.999-99" wire:model.live="taxvat"
                                       class="form-control <?php $__errorArgs = ['taxvat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="000.000.000-00">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['taxvat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-12 mt-4">
                                <h6 class="fw-bold border-bottom pb-2 mb-3">Segurança</h6>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasPassword): ?>
                                <!-- User has password - can change it -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Nova Senha</label>
                                    <div class="input-group">
                                        <input :type="showPass ? 'text' : 'password'" wire:model="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <button type="button" class="btn btn-outline-secondary" @click="showPass = !showPass">
                                            <i :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                                        </button>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <small class="text-muted">Deixe em branco para manter a atual.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Confirmar Senha</label>
                                    <input type="password" wire:model="password_confirmation" class="form-control">
                                </div>
                            <?php else: ?>
                                <!-- User doesn't have password - show button to set one -->
                                <div class="col-12">
                                    <div class="alert alert-info d-flex align-items-center">
                                        <i class="bi bi-info-circle fs-4 me-3"></i>
                                        <div class="flex-grow-1">
                                            <strong>Senha não definida</strong>
                                            <p class="mb-0 small">Você está usando login via <?php echo e($socialProvider); ?>. Defina uma senha para poder fazer login também com email e senha.</p>
                                        </div>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#passwordModal" class="btn btn-primary ms-3">
                                            <i class="bi bi-key me-2"></i>Definir Senha
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
                    <p class="text-muted">Defina uma senha para poder fazer login com email e senha, além do login via <?php echo e($socialProvider); ?>.</p>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha</label>
                        <input type="password" wire:model="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Mínimo 8 caracteres">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

<?php $__env->startPush('styles'); ?>
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Cropper.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<?php $__env->stopPush(); ?>

    <?php
        $__scriptKey = '1401436830-0';
        ob_start();
    ?>
<script>
    $wire.on('password-set', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('passwordModal'));
        modal.hide();
    });
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

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
                    
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').upload('avatar', croppedFile, (uploadedFilename) => {
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
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/customer/profile/edit.blade.php ENDPATH**/ ?>