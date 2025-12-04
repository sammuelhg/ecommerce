<div class="col" wire:key="image-<?php echo e($imageId); ?>">
    <div class="card h-100 <?php echo e($isMain ? 'border-primary border-3 shadow' : 'border'); ?> image-card">
        <div class="position-relative">
            <img src="<?php echo e(asset('storage/' . $imagePath)); ?>" class="card-img-top" style="aspect-ratio: 1; object-fit: cover;" alt="Imagem do produto">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isMain): ?>
                <span class="position-absolute top-0 start-0 m-2 badge bg-primary">
                    <i class="bi bi-star-fill"></i> Capa
                </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <!-- Actions Overlay -->
            <div class="image-actions">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isMain): ?>
                    <button type="button"
                            wire:click="setMainImage"
                            wire:loading.attr="disabled"
                            class="btn btn-sm btn-warning"
                            title="Definir como Capa">
                        <i class="bi bi-star"></i>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button type="button"
                        onclick="openCropper('<?php echo e(asset('storage/' . $imagePath)); ?>', 'existing-<?php echo e($imageId); ?>')"
                        class="btn btn-sm btn-info text-white"
                        title="Recortar">
                    <i class="bi bi-crop"></i>
                </button>
                <button type="button"
                        wire:click="deleteImage"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-danger"
                        title="Excluir">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-image-item.blade.php ENDPATH**/ ?>