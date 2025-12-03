<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?php echo e($materialId ? 'Editar' : 'Novo'); ?> Material</h5>
        <button type="button" class="btn-close" wire:click="$dispatch('materialSaved')"></button>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="mb-3">
                <label class="form-label">Nome *</label>
                <input type="text" wire:model="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Ex: Couro, Algodão, Mesh Respirável">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" wire:model="is_active" class="form-check-input" id="materialActive">
                <label class="form-check-label" for="materialActive">Ativo</label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> <?php echo e($materialId ? 'Atualizar' : 'Salvar'); ?>

                </button>
                <button type="button" class="btn btn-secondary" wire:click="$dispatch('materialSaved')">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-material-form.blade.php ENDPATH**/ ?>