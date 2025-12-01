                <!-- TAB: GERAL -->
                
                <!-- 1. Title (Auto-generated) -->
                <div class="mb-4">
                    <label for="name" class="form-label text-muted small text-uppercase fw-bold">Título do Produto (Gerado Automaticamente)</label>
                    <input type="text" wire:model.blur="name" class="form-control form-control-lg bg-white fw-bold text-primary" id="name" placeholder="Preencha os atributos abaixo..." readonly>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- 2. Note -->
                <div class="alert alert-info mb-4">
                    <i class="bi bi-magic"></i> <strong>Geração Automática:</strong> O título acima é formado pela combinação dos atributos selecionados abaixo.
                </div>

                <!-- 3. Attributes -->
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3 text-muted"><i class="bi bi-tags"></i> Definição de Atributos</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Categoria *</label>
                                <select wire:model.live="category_id" class="form-select bg-white <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Selecione...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->display_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tipo</label>
                                <select wire:model.live="product_type_id" class="form-select bg-white">
                                    <option value="">Selecione...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($t->id); ?>"><?php echo e($t->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Modelo</label>
                                <select wire:model.live="product_model_id" class="form-select bg-white">
                                    <option value="">Selecione...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($m->id); ?>"><?php echo e($m->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Material</label>
                                <select wire:model.live="product_material_id" class="form-select bg-white">
                                    <option value="">Selecione...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($mat->id); ?>"><?php echo e($mat->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor</label>
                                <input type="text" wire:model.blur="color" class="form-control bg-white" placeholder="Ex: Preto">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tamanho</label>
                                <input type="text" wire:model.blur="size" class="form-control bg-white" placeholder="Ex: 42">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Atributo Extra</label>
                                <input type="text" wire:model.blur="attribute" class="form-control bg-white" placeholder="Ex: Manga Longa">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active" role="switch">
                            <label class="form-check-label" for="is_active">
                                <span class="badge <?php echo e($is_active ? 'bg-success' : 'bg-danger'); ?>">
                                    <?php echo e($is_active ? 'Ativo' : 'Inativo'); ?>

                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Kit Management (if applicable) -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isKit): ?>
                    <div class="col-12 mt-3">
                        <div class="card border-info">
                            <div class="card-header bg-info bg-opacity-10">
                                <strong><i class="bi bi-box-seam"></i> Composição do Kit</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 position-relative">
                                    <label class="form-label">Adicionar Produtos ao Kit</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                        <input type="text" wire:model.live.debounce.300ms="productSearch" class="form-control bg-white" placeholder="Buscar produto...">
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($searchResults)): ?>
                                        <div class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $searchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <button type="button" wire:click="addToBundle(<?php echo e($result->id); ?>, '<?php echo e(addslashes($result->name)); ?>', <?php echo e($result->price); ?>)" class="list-group-item list-group-item-action d-flex justify-content-between">
                                                    <span><?php echo e($result->name); ?></span>
                                                    <span class="badge bg-secondary">R$ <?php echo e(number_format($result->price, 2, ',', '.')); ?></span>
                                                </button>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($bundleItems) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr><th>Produto</th><th style="width: 100px;">Qtd</th><th style="width: 50px;"></th></tr>
                                            </thead>
                                            <tbody>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bundleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($item['name']); ?></td>
                                                        <td><input type="number" value="<?php echo e($item['quantity']); ?>" wire:change="updateBundleQuantity(<?php echo e($index); ?>, $event.target.value)" class="form-control form-control-sm bg-white" min="1"></td>
                                                        <td><button type="button" wire:click="removeFromBundle(<?php echo e($index); ?>)" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning mb-0 fs-6 py-2">Nenhum item no kit.</div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-form/general.blade.php ENDPATH**/ ?>