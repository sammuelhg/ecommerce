<div class="row">
    <!-- Auto-generated fields section -->
    <div class="col-12">
        <div class="card bg-light border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title mb-3 text-muted"><i class="bi bi-gear"></i> Campos Gerados Automaticamente</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">
                            <i class="bi bi-upc-scan"></i> SKU (Gerado Automaticamente)
                        </label>
                        <div class="position-relative">
                            <input type="text" wire:model="sku" class="form-control bg-secondary bg-opacity-10" readonly>
                            <div wire:loading wire:target="category_id,product_type_id,color,size" class="position-absolute top-50 end-0 translate-middle-y me-2">
                                <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                            </div>
                        </div>
                        <small class="text-muted">O SKU é gerado com base na categoria, tipo, cor e tamanho</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">
                            <i class="bi bi-link-45deg"></i> URL Amigável (Slug)
                        </label>
                        <input type="text" wire:model="slug" class="form-control bg-secondary bg-opacity-10" readonly>
                        <small class="text-muted">A URL é gerada automaticamente a partir do título</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Marketing & SEO Content -->
    <div class="col-12">
        <div class="card border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title mb-3 text-muted"><i class="bi bi-megaphone"></i> Conteúdo de Marketing & SEO</h6>
                
                <div class="mb-3">
                    <label class="form-label">Descrição Curta (Marketing)</label>
                    <textarea wire:model.blur="marketing_description" class="form-control bg-white" rows="2" placeholder="Breve descrição para listagens e SEO..."></textarea>
                    <small class="text-muted">Usado em listagens de produtos e resultados de busca</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição Detalhada (Completa)</label>
                    <textarea wire:model.blur="description" class="form-control bg-white" rows="10" placeholder="Descreva o produto em detalhes, incluindo especificações técnicas, benefícios, etc..."></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/livewire/admin/product-form/seo.blade.php ENDPATH**/ ?>