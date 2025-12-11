<div class="card shadow-sm border-top border-4 border-danger mb-4">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <i class="bi bi-google text-danger fs-4 me-2"></i>
            <h5 class="mb-0">Google Ads Conversion API</h5>
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
                    <label for="customerId" class="form-label fw-bold">Customer ID (Conta)</label>
                    <input type="text" 
                           id="customerId" 
                           class="form-control @error('customerId') is-invalid @enderror" 
                           wire:model="customerId"
                           placeholder="Ex: 123-456-7890">
                    @error('customerId') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                    <div class="form-text text-muted">O ID da sua conta Google Ads (sem traços opcional).</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="developerToken" class="form-label fw-bold">Developer Token</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" 
                               id="developerToken" 
                               class="form-control @error('developerToken') is-invalid @enderror" 
                               wire:model="developerToken"
                               placeholder="Token secreto">
                    </div>
                    @error('developerToken') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                    <div class="form-text text-muted">Token de desenvolvedor da API (Nível Basic Access ou Standard).</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="conversionActionId" class="form-label fw-bold">Conversion Action ID (Label)</label>
                    <input type="text" 
                           id="conversionActionId" 
                           class="form-control" 
                           wire:model="conversionActionId"
                           placeholder="Ex: AlphanumericString123">
                    <div class="form-text text-muted">Identificador da conversão configurada no painel do Google Ads.</div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="googleActiveSwitch" wire:model="isActive">
                    <label class="form-check-label fw-bold" for="googleActiveSwitch">
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
