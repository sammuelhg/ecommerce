<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Preço de Venda (R$) *</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="number" wire:model.blur="price" class="form-control form-control-lg fw-bold bg-white <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" step="0.01" min="0">
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Preço "De" (Comparação)</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="number" wire:model.blur="compare_at_price" class="form-control bg-white" step="0.01" min="0">
        </div>
        <small class="text-muted">Para promoções (ex: De R$ 100 por R$ 80)</small>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Preço de Custo</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="number" wire:model.blur="cost_price" class="form-control bg-white" step="0.01" min="0">
        </div>
        <small class="text-muted">Uso interno para cálculo de lucro</small>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Estoque</label>
        <input type="number" wire:model.blur="stock" class="form-control bg-white <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="0">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">SKU (Gerado Automaticamente)</label>
        <input type="text" wire:model.blur="sku" class="form-control bg-light" readonly>
        <small class="text-muted">Gerado com base nos atributos do produto.</small>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-form/pricing.blade.php ENDPATH**/ ?>