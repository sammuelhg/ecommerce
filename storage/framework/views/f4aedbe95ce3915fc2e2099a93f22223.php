

<?php $__env->startSection('title', 'Configurações da Loja'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0"><i class="bi bi-gear me-2"></i>Configurações da Loja</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="identity-tab" data-bs-toggle="tab" data-bs-target="#identity" type="button">
                                    <i class="bi bi-palette me-2"></i>Identidade Visual
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors" type="button">
                                    <i class="bi bi-paint-bucket me-2"></i>Cores
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button">
                                    <i class="bi bi-building me-2"></i>Informações
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ai-tab" data-bs-toggle="tab" data-bs-target="#ai" type="button">
                                    <i class="bi bi-stars me-2"></i>IA & Geração
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="modals-tab" data-bs-toggle="tab" data-bs-target="#modals" type="button">
                                    <i class="bi bi-window me-2"></i>Modais
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button">
                                    <i class="bi bi-shield-check me-2"></i>Segurança
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="settingsTabContent">
                            
                            <!-- Identidade Visual -->
                            <div class="tab-pane fade show active" id="identity" role="tabpanel">
                                <h5 class="mb-4 text-primary border-bottom pb-2">Logo da Loja</h5>
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
                            </div>

                            <!-- Cores -->
                            <div class="tab-pane fade" id="colors" role="tabpanel">
                                <h5 class="mb-4 text-primary border-bottom pb-2">Cores do Tema (Bootstrap Custom)</h5>
                                <div class="row mb-4">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Cor Primária (Primary)</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color bg-white" name="color_primary" value="<?php echo e($settings['color_primary'] ?? '#0d6efd'); ?>">
                                            <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_primary'] ?? '#0d6efd'); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Cor Secundária (Secondary)</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color bg-white" name="color_secondary" value="<?php echo e($settings['color_secondary'] ?? '#6c757d'); ?>">
                                            <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_secondary'] ?? '#6c757d'); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Cor de Destaque (Accent)</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color bg-white" name="color_accent" value="<?php echo e($settings['color_accent'] ?? '#ffc107'); ?>">
                                            <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_accent'] ?? '#ffc107'); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Cor de Fundo (Background)</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color bg-white" name="color_background" value="<?php echo e($settings['color_background'] ?? '#f8f9fa'); ?>">
                                            <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_background'] ?? '#f8f9fa'); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Cor Barra Categorias</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color bg-white" name="color_category_bar" value="<?php echo e($settings['color_category_bar'] ?? '#f0f8ff'); ?>">
                                            <input type="text" class="form-control bg-white" value="<?php echo e($settings['color_category_bar'] ?? '#f0f8ff'); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações da Loja -->
                            <div class="tab-pane fade" id="info" role="tabpanel">
                                <h5 class="mb-4 text-primary border-bottom pb-2">Dados da Empresa</h5>
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Endereço Completo</label>
                                        <textarea class="form-control bg-white" name="store_address" rows="2"><?php echo e($settings['store_address'] ?? ''); ?></textarea>
                                        <div class="form-text">Suporta múltiplas linhas</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">CNPJ</label>
                                        <input type="text" class="form-control bg-white" name="store_cnpj" value="<?php echo e($settings['store_cnpj'] ?? ''); ?>" placeholder="00.000.000/0000-00">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Telefone / WhatsApp</label>
                                        <input type="text" class="form-control bg-white" name="store_phone" value="<?php echo e($settings['store_phone'] ?? ''); ?>" placeholder="(00) 00000-0000">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">URL Embed Google Maps</label>
                                        <input type="text" class="form-control bg-white" name="google_maps_embed_url" value="<?php echo e($settings['google_maps_embed_url'] ?? ''); ?>" placeholder="https://www.google.com/maps/embed?pb=...">
                                        <div class="form-text">Cole a URL do src do iframe OU o código completo do iframe</div>
                                    </div>
                                </div>
                            </div>

                            <!-- IA & Geração -->
                            <div class="tab-pane fade" id="ai" role="tabpanel">
                                <h5 class="mb-4 text-primary border-bottom pb-2">Template de Geração de Imagens com IA</h5>
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Prompt Template</label>
                                        <textarea class="form-control bg-white font-monospace" name="ai_image_prompt_template" rows="6" placeholder="Professional e-commerce product photography of {product_name}..."><?php echo $settings['ai_image_prompt_template'] ?? 'Professional e-commerce product photography of {product_name}, {category} category product, {type} type, {model} model, {size} size, {flavor} flavor, {material} packaging. Studio lighting, clean white background, product centered, front view, label visible and readable, high resolution, professional packshot, 8k quality, photorealistic'; ?></textarea>
                                        <div class="form-text">
                                            <strong>Variáveis disponíveis:</strong> 
                                            <code>{product_name}</code>, <code>{category}</code>, <code>{type}</code>, 
                                            <code>{model}</code>, <code>{size}</code>, <code>{flavor}</code>, <code>{material}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modais Informativos -->
                            <div class="tab-pane fade" id="modals" role="tabpanel">
                                <h5 class="mb-4 text-primary border-bottom pb-2">Conteúdo dos Modais do Footer</h5>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Sobre Nós</label>
                                        <textarea class="form-control bg-white" name="modal_about" rows="5" placeholder="Conte a história da sua empresa..."><?php echo $settings['modal_about'] ?? ''; ?></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Trabalhe Conosco</label>
                                        <textarea class="form-control bg-white" name="modal_careers" rows="5" placeholder="Informações sobre vagas..."><?php echo $settings['modal_careers'] ?? ''; ?></textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Contato</label>
                                        <textarea class="form-control bg-white" name="modal_contact" rows="5" placeholder="Formas de contato..."><?php echo $settings['modal_contact'] ?? ''; ?></textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Trocas e Devoluções</label>
                                        <textarea class="form-control bg-white" name="modal_returns" rows="5" placeholder="Política de trocas..."><?php echo $settings['modal_returns'] ?? ''; ?></textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">FAQ</label>
                                        <textarea class="form-control bg-white" name="modal_faq" rows="5" placeholder="Perguntas frequentes..."><?php echo $settings['modal_faq'] ?? ''; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Certificados de Segurança -->
                            <div class="tab-pane fade" id="security" role="tabpanel">
                                <h5 class="mb-4 text-primary border-bottom pb-2">Certificados e Selos</h5>
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Adicionar Certificados (Imagens)</label>
                                        <input type="file" class="form-control bg-white" name="security_certificates[]" multiple accept="image/*">
                                        <div class="form-text">Selos de segurança, certificados SSL, etc.</div>
                                    </div>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($certificates) > 0): ?>
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label fw-bold">Certificados Ativos:</label>
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
                            </div>

                        </div>

                        <!-- Save Button (Fixed at bottom of all tabs) -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 pt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-save me-2"></i> Salvar Todas as Configurações
                            </button>
                        </div>
                    </form>
                    
                    <!-- Hidden Form for Certificate Removal -->
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