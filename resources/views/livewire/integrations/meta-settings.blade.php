<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
        <i class="bi bi-facebook text-primary fs-4 me-2"></i>
        <h5 class="mb-0 text-primary fw-bold">Meta / Facebook Ads</h5>
    </div>
    
    <div class="card-body p-4">
        {{-- Alertas de Sucesso/Erro --}}
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @error('integration_error')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $message }}
            </div>
        @enderror

        <form wire:submit="save">
            <div class="row g-3">
                
                {{-- Pixel ID --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pixel ID</label>
                    <input type="text" class="form-control @error('pixelId') is-invalid @enderror" 
                           wire:model="pixelId" placeholder="Ex: 1234567890">
                    @error('pixelId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Ad Account ID --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ID da Conta de Anúncios</label>
                    <input type="text" class="form-control @error('adAccountId') is-invalid @enderror" 
                           wire:model="adAccountId" placeholder="Ex: act_123456">
                    @error('adAccountId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Access Token --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Token de Acesso (API Conversões)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control @error('accessToken') is-invalid @enderror" 
                               wire:model="accessToken" placeholder="EAAB...">
                    </div>
                    <div class="form-text text-muted">
                        Gerado no Gerenciador de Negócios > Fontes de Dados > Configurações.
                    </div>
                    @error('accessToken') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Ativar Integração --}}
                <div class="col-12 mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               id="activeSwitch" wire:model="isActive">
                        <label class="form-check-label fw-bold" for="activeSwitch">
                            Ativar Integração e Sincronização de Eventos
                        </label>
                    </div>
                </div>

            </div>

            {{-- Footer com Loading --}}
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="bi bi-save me-1"></i> Salvar Configurações
                    </span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        Salvando...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
