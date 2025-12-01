<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModal): ?>
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Duplicar Produto</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($originalProduct): ?>
                        <div class="alert alert-info mb-3">
                            <strong>Produto Original:</strong> <?php echo e($originalProduct->name); ?><br>
                            <small class="text-muted">
                                Atributo: <?php echo e($originalProduct->attribute ?? 'N/A'); ?> | 
                                Cor: <?php echo e($originalProduct->color ?? 'N/A'); ?> | 
                                Tamanho: <?php echo e($originalProduct->size ?? 'N/A'); ?>

                            </small>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errorMessage): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i><?php echo e($errorMessage); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <form wire:submit.prevent="duplicate">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Atributo (opcional)</label>
                                <input type="text" class="form-control" wire:model="newAttribute" placeholder="Ex: Manga Longa, Estampado...">
                                <small class="form-text text-muted">Campo genérico adicionado ao título do produto</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Cor</label>
                                <input type="text" class="form-control" wire:model="newColor" placeholder="Ex: Vermelho, Azul...">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tamanho</label>
                                <input type="text" class="form-control" wire:model="newSize" placeholder="Ex: P, M, G, GG...">
                            </div>

                            <div class="alert alert-warning">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Atenção:</strong> Você precisa alterar pelo menos <u>um</u> campo para criar um novo produto.
                            </div>
                        </form>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="duplicate">
                        <i class="bi bi-files me-1"></i> Criar Produto
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-duplicate-modal.blade.php ENDPATH**/ ?>