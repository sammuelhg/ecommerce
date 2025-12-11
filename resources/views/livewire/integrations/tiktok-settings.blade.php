<div class="card shadow-sm border-top border-4 border-dark mb-4">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <i class="bi bi-tiktok text-dark fs-4 me-2"></i>
            <h5 class="mb-0">TikTok Events API</h5>
        </div>
    </div>
    
    <div class="card-body">
        
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @error('integration_error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @enderror

        <form wire:submit="save">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="advertiserId" class="form-label fw-bold">Advertiser ID (Conta)</label>
                    <input type="text" 
                           id="advertiserId" 
                           class="form-control @error('advertiserId') is-invalid @enderror" 
                           wire:model="advertiserId"
                           placeholder="Ex: 123456789012345">
                    @error('advertiserId') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                    <div class="form-text text-muted">ID da sua conta de anunciante no TikTok Business.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pixelId" class="form-label fw-bold">Pixel ID</label>
                    <input type="text" 
                           id="pixelId" 
                           class="form-control @error('pixelId') is-invalid @enderror" 
                           wire:model="pixelId"
                           placeholder="Ex: C4V5...3E9">
                    @error('pixelId') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                    <div class="form-text text-muted">O ID do Pixel que receberá os eventos.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="accessToken" class="form-label fw-bold">Access Token (API)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" 
                               id="accessToken" 
                               class="form-control @error('accessToken') is-invalid @enderror" 
                               wire:model="accessToken"
                               placeholder="Token secreto">
                    </div>
                    @error('accessToken') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                    <div class="form-text text-muted">Token gerado no TikTok Developers para "Events API".</div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="tiktokActiveSwitch" wire:model="isActive">
                    <label class="form-check-label fw-bold" for="tiktokActiveSwitch">
                        Ativar Integração
                    </label>
                </div>

                <button type="submit" class="btn btn-dark">
                    <span wire:loading.remove>
                        <i class="bi bi-save me-1"></i> Salvar Configurações
                    </span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Salvando...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
