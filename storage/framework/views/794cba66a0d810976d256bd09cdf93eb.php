<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control bg-white" placeholder="Buscar cores...">
        </div>
        <div class="col-md-6 text-end mt-3 mt-md-0">
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Cor
            </button>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('message')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showForm): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.product-color-form', ['colorId' => $editingId]);

$key = $editingId ?? 'new';

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1355648435-0', $editingId ?? 'new');

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Lista de Cores</h5>
        </div>
        <div class="card-body p-0">
            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Cor (Hex)</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($color->id); ?></td>
                                <td><?php echo e($color->name); ?></td>
                                <td><code><?php echo e($color->code); ?></code></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 24px; height: 24px; background-color: <?php echo e($color->hex_code); ?>; border: 1px solid #ddd; border-radius: 4px;"></div>
                                        <small class="text-muted"><?php echo e($color->hex_code); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($color->is_active ? 'bg-success' : 'bg-danger'); ?>">
                                        <?php echo e($color->is_active ? 'Ativo' : 'Inativo'); ?>

                                    </span>
                                </td>
                                <td class="text-end">
                                    <button wire:click="edit(<?php echo e($color->id); ?>)" class="btn btn-sm btn-info text-white me-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-danger"
                                        wire:click="delete(<?php echo e($color->id); ?>)"
                                        wire:confirm="Tem certeza que deseja excluir esta cor?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">Nenhuma cor encontrada.</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1 fw-bold"><?php echo e($color->name); ?></h6>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <code class="small"><?php echo e($color->code); ?></code>
                                    <div style="width: 16px; height: 16px; background-color: <?php echo e($color->hex_code); ?>; border: 1px solid #ddd; border-radius: 50%;"></div>
                                </div>
                            </div>
                            <span class="badge <?php echo e($color->is_active ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($color->is_active ? 'Ativo' : 'Inativo'); ?>

                            </span>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-2">
                            <button wire:click="edit(<?php echo e($color->id); ?>)" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button 
                                class="btn btn-sm btn-outline-danger"
                                wire:click="delete(<?php echo e($color->id); ?>)"
                                wire:confirm="Tem certeza que deseja excluir esta cor?">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Nenhuma cor encontrada.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="p-3 border-top">
                <?php echo e($colors->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-color-index.blade.php ENDPATH**/ ?>