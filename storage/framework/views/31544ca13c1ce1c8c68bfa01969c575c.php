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
            <div class="card border-0 shadow-sm">
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
                                    <label class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1 cursor-pointer shadow-sm" 
                                           style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <i class="bi bi-camera-fill small"></i>
                                        <input type="file" wire:model="avatar" accept="image/*" class="d-none"
                                               @change="handleAvatar($event)">
                                    </label>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Foto de Perfil</h6>
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
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nome Completo</label>
                                <input type="text" wire:model.live="name" class="form-control <?php $__errorArgs = ['name'];
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
                                <input type="email" wire:model.live="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                <h6 class="fw-bold border-bottom pb-2 mb-3">Alterar Senha</h6>
                            </div>

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
</div>

<script>
function profileForm() {
    return {
        avatarPreview: null,
        showPass: false,

        handleAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                this.avatarPreview = URL.createObjectURL(file);
            }
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