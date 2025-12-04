<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control bg-white" placeholder="Buscar categorias...">
        </div>
        <div class="col-md-6 text-end">
            <button wire:click="$set('showCreateForm', true)" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Categoria
            </button>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('message')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCreateForm): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.category-form', ['categoryId' => $editingCategoryId]);

$key = $editingCategoryId ?? 'new';

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-4197136767-0', $editingCategoryId ?? 'new');

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Lista de Categorias</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th>Produtos</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($category->id); ?></td>
                            <td><?php echo e($category->name); ?></td>
                            <td><code><?php echo e($category->slug); ?></code></td>
                            <td>
                                <span class="badge bg-info">
                                    <?php echo e($category->products_count); ?> produtos
                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo e($category->is_active ? 'bg-success' : 'bg-danger'); ?>">
                                    <?php echo e($category->is_active ? 'Ativo' : 'Inativo'); ?>

                                </span>
                            </td>
                            <td>
                                <button wire:click="edit(<?php echo e($category->id); ?>)" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button 
                                    class="btn btn-sm btn-danger"
                                    wire:click="delete(<?php echo e($category->id); ?>)"
                                    wire:confirm="Tem certeza que deseja excluir esta categoria? Os produtos associados ficarão sem categoria.">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">Nenhuma categoria encontrada.</p>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>

            <div class="mt-4">
                <?php echo e($categories->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/category-index.blade.php ENDPATH**/ ?>