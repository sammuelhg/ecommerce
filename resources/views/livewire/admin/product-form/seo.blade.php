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
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">Descrição Curta (Marketing)</label>
                        <button type="button" wire:click="previewAiGeneration('seo')" wire:loading.attr="disabled" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-stars me-1"></i> 
                            <span wire:loading.remove wire:target="previewAiGeneration('seo')">Gerar SEO com IA</span>
                            <span wire:loading wire:target="previewAiGeneration('seo')">Preparando...</span>
                        </button>
                    </div>
                    <textarea wire:model.blur="marketing_description" 
                              class="form-control bg-white" 
                              rows="3" 
                              style="min-height: 80px; max-height: 200px; overflow-y: auto;"
                              placeholder="Breve descrição para listagens e SEO..."></textarea>
                    <small class="text-muted">Usado em listagens de produtos e resultados de busca</small>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">Descrição Detalhada (Completa)</label>
                        <button type="button" wire:click="previewAiGeneration('description')" wire:loading.attr="disabled" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-stars me-1"></i> 
                            <span wire:loading.remove wire:target="previewAiGeneration('description')">Gerar Descrição com IA</span>
                            <span wire:loading wire:target="previewAiGeneration('description')">Preparando...</span>
                        </button>
                    </div>
                    <div wire:ignore
                         class="border rounded"
                         x-data="productDescriptionEditor($wire.entangle('description'))">
                        
                        <!-- Fallback if Quill fails -->
                        <textarea id="quill-fallback" style="display:none;" class="form-control" rows="5" wire:model.defer="description"></textarea>
                        
                        <!-- Editor Container -->
                        <div x-ref="quillEditor" style="min-height: 300px; background: white;"></div>
                    </div>

                    @push('scripts')
                    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                    <script>
                        // Prevent double loading check
                        if (!document.querySelector('link[href*="quill.snow.css"]')) {
                            var link = document.createElement('link');
                            link.rel = 'stylesheet';
                            link.href = 'https://cdn.quilljs.com/1.3.6/quill.snow.css';
                            document.head.appendChild(link);
                        }

                        document.addEventListener('alpine:init', () => {
                            Alpine.data('productDescriptionEditor', (entangled) => ({
                                quill: null,
                                content: entangled,
                                init() {
                                    if (typeof Quill === 'undefined') {
                                        console.error('Quill not loaded');
                                        document.getElementById('quill-fallback').style.display = 'block';
                                        return;
                                    }
                                    
                                    this.quill = new Quill(this.$refs.quillEditor, {
                                        theme: 'snow',
                                        placeholder: 'Descreva o produto...',
                                        modules: {
                                            toolbar: [
                                                ['bold', 'italic', 'underline'],
                                                [{ 'header': 1 }, { 'header': 2 }],
                                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                                ['clean']
                                            ]
                                        }
                                    });

                                    // Sync content from Quill to Livewire
                                    this.quill.on('text-change', () => {
                                        this.content = this.quill.root.innerHTML;
                                    });

                                    // Initial load
                                    if (this.content) {
                                        let cleanContent = this.content;
                                        // Simple check for quoted JSON string
                                        if (typeof cleanContent === 'string' && cleanContent.startsWith('"') && cleanContent.endsWith('"')) {
                                            try {
                                                cleanContent = JSON.parse(cleanContent);
                                            } catch(e) {}
                                        }
                                        this.quill.root.innerHTML = cleanContent;
                                    }

                                    // Listen for AI Updates
                                    Livewire.on('description-updated', (newContent) => {
                                        // Handle potential double-encoding or array wrapping
                                        if (Array.isArray(newContent)) newContent = newContent[0];
                                        
                                        if (typeof newContent === 'string' && newContent.startsWith('"') && newContent.endsWith('"')) {
                                           try {
                                               newContent = JSON.parse(newContent);
                                           } catch(e) {}
                                        }

                                        if(this.quill) {
                                            this.quill.root.innerHTML = newContent;
                                            this.content = newContent;
                                        }
                                    });
                                }
                            }));
                        });
                    </script>
                    @endpush
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AI Prompt Preview Modal -->
<div class="modal fade" id="aiPromptModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-robot me-2"></i>Revisar Prompt de IA
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-2">Verifique o prompt que será enviado para a IA. Você pode editá-lo se necessário (edição direta aqui não altera o template salvo).</p>
                <div class="form-group">
                    <label class="form-label fw-bold">Prompt Gerado:</label>
                    <textarea wire:model="promptPreview" class="form-control font-monospace bg-light" rows="10" style="font-size: 0.85rem;"></textarea>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" wire:click="confirmAiGeneration" wire:loading.attr="disabled" class="btn btn-primary">
                    <span wire:loading.remove wire:target="confirmAiGeneration">
                        <i class="bi bi-lightning-charge-fill me-1"></i> Confirmar e Gerar
                    </span>
                    <span wire:loading wire:target="confirmAiGeneration">
                        <span class="spinner-border spinner-border-sm me-1"></span> Gerando...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        let aiModalInstance = null;

        function getModal() {
            const el = document.getElementById('aiPromptModal');
            if (el) {
                if (!aiModalInstance) {
                    aiModalInstance = new bootstrap.Modal(el);
                }
                return aiModalInstance;
            }
            return null;
        }
        
        Livewire.on('open-prompt-modal', () => {
            const modal = getModal();
            if (modal) modal.show();
        });

        Livewire.on('close-prompt-modal', () => {
            const modal = getModal();
            if (modal) modal.hide();
        });
    });
</script>
