<div class="fixed-bottom p-3" style="z-index: 1050; pointer-events: none;">
    <div class="toast bg-white shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" 
         x-show="showConfigPanel" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         style="pointer-events: auto; max-width: 350px; margin-left: auto; display: none;">
        
        <div class="toast-header bg-primary text-white">
            <i class="bi bi-gear-fill me-2"></i>
            <strong class="me-auto">Configurações da Loja</strong>
            <button type="button" class="btn-close btn-close-white" @click="showConfigPanel = false"></button>
        </div>
        <div class="toast-body">
            <p class="small text-muted mb-3">Personalize sua experiência na loja.</p>
            
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="confCart" x-model="config.enableCart">
                <label class="form-check-label" for="confCart">Habilitar Carrinho</label>
            </div>
            
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="confWish" x-model="config.enableWishlist">
                <label class="form-check-label" for="confWish">Habilitar Wishlist</label>
            </div>
            
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="confSearch" x-model="config.enableSearch">
                <label class="form-check-label" for="confSearch">Habilitar Busca</label>
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="confToast" x-model="config.enableToasts">
                <label class="form-check-label" for="confToast">Habilitar Notificações</label>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-outline-danger btn-sm" @click="resetConfig(); showConfigPanel = false">
                    <i class="bi bi-arrow-counterclockwise"></i> Resetar Padrões
                </button>
            </div>
        </div>
    </div>
</div>
