<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.live="search" type="text" class="form-control form-control-lg bg-white" placeholder="🔍 Buscar produtos...">
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Adicionar Produto
            </a>
        </div>
    </div>

    <!-- Lista de Produtos -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-box-seam"></i> Lista de Produtos</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Imagem</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Status</th>
                            <th style="width: 200px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr wire:key="product-<?php echo e($product->id); ?>">
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                                alt="<?php echo e($product->name); ?>" 
                                                class="img-thumbnail"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                style="width: 60px; height: 60px;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo e($product->name); ?></strong>
                                    <br>
                                    <small class="text-muted">SKU: <?php echo e($product->sku ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->category): ?>
                                        <span class="badge bg-info">
                                            <?php echo e($product->category->name); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Sem categoria</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <strong class="text-success">R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></strong>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->compare_at_price): ?>
                                        <br>
                                        <small class="text-muted text-decoration-line-through">
                                            R$ <?php echo e(number_format($product->compare_at_price, 2, ',', '.')); ?>

                                        </small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($product->stock_quantity > 10 ? 'bg-success' : ($product->stock_quantity > 0 ? 'bg-warning' : 'bg-danger')); ?>">
                                        <?php echo e($product->stock_quantity); ?> unidades
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($product->is_active ? 'bg-success' : 'bg-danger'); ?>">
                                        <?php echo e($product->is_active ? 'Ativo' : 'Inativo'); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-info" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button wire:click="$set('duplicatingProductId', <?php echo e($product->id); ?>)" class="btn btn-sm btn-secondary" title="Duplicar">
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button 
                                            class="btn btn-sm btn-danger"
                                            wire:click="delete(<?php echo e($product->id); ?>)"
                                            wire:confirm="Tem certeza que deseja excluir este produto?"
                                            title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0">Nenhum produto encontrado.</p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                        <small>Tente ajustar sua busca</small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasPages()): ?>
                <div class="card-footer bg-white">
                    <?php echo e($products->links('pagination::bootstrap-5')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Modal de Duplicação -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($duplicatingProductId): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.product-duplicate-modal', ['productId' => $duplicatingProductId]);

$key = 'duplicate-'.$duplicatingProductId;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3011831586-0', 'duplicate-'.$duplicatingProductId);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-index.blade.php ENDPATH**/ ?>