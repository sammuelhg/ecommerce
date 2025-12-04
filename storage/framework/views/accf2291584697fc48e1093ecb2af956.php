<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('message')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Card de Perfil -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-person-circle"></i> Meu Perfil</h4>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$editing): ?>
                        <button wire:click="toggleEdit" class="btn btn-light btn-sm">
                            <i class="bi bi-pencil"></i> Editar Perfil
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editing): ?>
                        <!-- Formulário de Edição -->
                        <form wire:submit="save">
                            <div class="row g-3">
                                <!-- Nome -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nome Completo *</label>
                                    <input type="text" 
                                           wire:model="name" 
                                           class="form-control bg-white <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="name">
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

                                <!-- Email (readonly) -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           value="<?php echo e($email); ?>" 
                                           class="form-control bg-white" 
                                           id="email" 
                                           readonly>
                                    <small class="text-muted">O email não pode ser alterado</small>
                                </div>

                                <!-- Telefone -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Telefone</label>
                                    <input type="text" 
                                           wire:model="phone" 
                                           class="form-control bg-white <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="phone"
                                           placeholder="(00) 00000-0000">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
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

                                <!-- Data de Nascimento -->
                                <div class="col-md-6">
                                    <label for="birth_date" class="form-label">Data de Nascimento</label>
                                    <input type="date" 
                                           wire:model="birth_date" 
                                           class="form-control bg-white <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="birth_date">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['birth_date'];
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

                                <!-- Endereço -->
                                <div class="col-12">
                                    <label for="address" class="form-label">Endereço Completo</label>
                                    <textarea wire:model="address" 
                                              class="form-control bg-white <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="address" 
                                              rows="3"
                                              placeholder="Rua, Número, Complemento, Bairro, Cidade - UF, CEP"></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address'];
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
                            </div>

                            <!-- Botões -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" wire:click="toggleEdit" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Salvar Alterações
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <!-- Visualização do Perfil -->
                        <div class="row">
                            <div class="col-12 text-center mb-4">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" 
                                     style="width: 120px; height: 120px;">
                                    <span class="display-3 text-primary fw-bold">
                                        <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                                    </span>
                                </div>
                                <h3 class="mt-3"><?php echo e(auth()->user()->name); ?></h3>
                                <p class="text-muted"><?php echo e(auth()->user()->email); ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <label class="text-muted small mb-1">Telefone</label>
                                    <p class="mb-0 fw-semibold">
                                        <?php echo e($phone ?: '- não informado -'); ?>

                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <label class="text-muted small mb-1">Data de Nascimento</label>
                                    <p class="mb-0 fw-semibold">
                                        <?php echo e($birth_date ? \Carbon\Carbon::parse($birth_date)->format('d/m/Y') : '- não informado -'); ?>

                                    </p>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <label class="text-muted small mb-1">Endereço</label>
                                    <p class="mb-0 fw-semibold">
                                        <?php echo e($address ?: '- não informado -'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Cards de estatísticas (manter do design anterior) -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-cart-check text-primary" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">Meus Pedidos</h5>
                            <p class="display-6 fw-bold">0</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Ver Histórico</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-bag text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">Carrinho</h5>
                            <p class="display-6 fw-bold">0</p>
                            <a href="#" class="btn btn-outline-success btn-sm">Ver Carrinho</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/user-profile.blade.php ENDPATH**/ ?>