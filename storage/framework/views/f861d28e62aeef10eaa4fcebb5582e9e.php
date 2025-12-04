<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-<?php echo e($isEditing ? 'pencil' : 'plus-circle'); ?>"></i>
            <?php echo e($isEditing ? 'Editar Categoria' : 'Nova Categoria'); ?>

        </h5>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="row">
                <!-- Nome da Categoria -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome da Categoria *</label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="name" 
                           class="form-control bg-white <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="name" 
                           placeholder="Ex: Eletrônicos">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Slug (gerado automaticamente) -->
                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug (URL amigável) *</label>
                    <input type="text" 
                           wire:model="slug" 
                           class="form-control bg-white <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="slug" 
                           placeholder="eletronicos">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <small class="text-muted">Gerado automaticamente a partir do nome</small>
                </div>

                <!-- Categoria Pai (opcional para subcategorias) -->
                <div class="col-md-6 mb-3">
                    <label for="parent_id" class="form-label">Categoria Pai (Opcional)</label>
                    <select wire:model="parent_id" class="form-select bg-white" id="parent_id">
                        <option value="">Nenhuma (Categoria Principal)</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($parent->id); ?>"><?php echo e($parent->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <small class="text-muted">Deixe vazio para categoria principal, ou selecione uma categoria pai para criar uma subcategoria</small>
                </div>

                <!-- Descrição (para SEO) -->
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Descrição (SEO)</label>
                    <textarea wire:model="description" 
                              class="form-control bg-white <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              id="description" 
                              rows="3"
                              placeholder="Descrição rica em palavras-chave para otimização de SEO..."></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <small class="text-muted">Texto exibido na página da categoria, importante para SEO</small>
                </div>

                <!-- Status Ativo/Inativo -->
                <div class="col-12 mb-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" 
                               wire:model="is_active" 
                               class="form-check-input" 
                               id="is_active"
                               role="switch">
                        <label class="form-check-label" for="is_active">
                            <span class="badge <?php echo e($is_active ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($is_active ? 'Ativo' : 'Inativo'); ?>

                            </span>
                        </label>
                    </div>
                    <small class="text-muted">Categorias inativas não aparecem na loja</small>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="d-flex justify-content-between mt-4">
                <button type="button" 
                        wire:click="$dispatch('closeForm')" 
                        class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="submit" 
                        class="btn btn-success">
                    <i class="bi bi-check-circle"></i> <?php echo e($isEditing ? 'Atualizar' : 'Salvar'); ?> Categoria
                </button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/category-form.blade.php ENDPATH**/ ?>