

<?php $__env->startSection('title', 'Configurações da Loja'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Identidade Visual -->
                        <h5 class="mb-4 text-primary border-bottom pb-2">Identidade Visual</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Logo da Loja</label>
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($settings['store_logo'])): ?>
                                        <div class="border p-2 rounded bg-light">
                                            <img src="<?php echo e($settings['store_logo']); ?>" alt="Logo Atual" style="height: 60px;">
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <input type="file" class="form-control bg-white" name="store_logo" accept="image/*">
                                </div>
                                <div class="form-text">Recomendado: PNG transparente, altura min. 90px.</div>
                            </div>
                        </div>

                        <!-- Cores do Tema -->
                        <h5 class="mb-4 text-primary border-bottom pb-2 mt-5">Cores do Tema (Bootstrap Custom)</h5>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor Primária (Primary)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_primary" value="<?php echo e($settings['color_primary'] ?? '#0d6efd'); ?>" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_primary'] ?? '#0d6efd'); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor Secundária (Secondary)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_secondary" value="<?php echo e($settings['color_secondary'] ?? '#6c757d'); ?>" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_secondary'] ?? '#6c757d'); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor de Destaque (Accent)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_accent" value="<?php echo e($settings['color_accent'] ?? '#ffc107'); ?>" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_accent'] ?? '#ffc107'); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor de Fundo (Background)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_background" value="<?php echo e($settings['color_background'] ?? '#f8f9fa'); ?>" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_background'] ?? '#f8f9fa'); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Informações da Loja -->
                        <h5 class="mb-4 text-primary border-bottom pb-2 mt-5">Informações da Loja</h5>
                        <div class="row mb-4">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Endereço Completo</label>
                                <textarea class="form-control bg-white" name="store_address" rows="3"><?php echo e($settings['store_address'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">CNPJ</label>
                                <input type="text" class="form-control bg-white" name="store_cnpj" value="<?php echo e($settings['store_cnpj'] ?? ''); ?>" placeholder="00.000.000/0000-00">
                            </div>
                        </div>

                        <!-- Certificados de Segurança -->
                        <h5 class="mb-4 text-primary border-bottom pb-2 mt-5">Certificados de Segurança</h5>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Adicionar Certificados (Imagens)</label>
                                <input type="file" class="form-control bg-white" name="security_certificates[]" multiple accept="image/*">
                            </div>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($certificates) > 0): ?>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Certificados Ativos:</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="position-relative border p-2 rounded bg-white">
                                                <img src="<?php echo e($cert); ?>" style="height: 50px; width: auto;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle p-0 d-flex align-items-center justify-content-center" 
                                                        style="width: 20px; height: 20px;"
                                                        onclick="removeCertificate('<?php echo e($cert); ?>')">
                                                    &times;
                                                </button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-save me-2"></i> Salvar Configurações
                            </button>
                        </div>
                    </form>
                    
                    <!-- Hidden Form for Removal -->
                    <form id="remove-cert-form" action="<?php echo e(route('admin.settings.remove-certificate')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="path" id="remove-cert-path">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function removeCertificate(path) {
        if(confirm('Tem certeza que deseja remover este certificado?')) {
            document.getElementById('remove-cert-path').value = path;
            document.getElementById('remove-cert-form').submit();
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>