<div class="card border-0 shadow-sm mb-4">
    <div class="card-header">
        <h5 class="mb-0">{{ $sizeId ? 'Editar Tamanho' : 'Novo Tamanho' }}</h5>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Nome</label>
                    <input type="text" wire:model.live="name" class="form-control bg-white @error('name') is-invalid @enderror" placeholder="Ex: P, M, G, 38, 1kg">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Código (máx 10 caracteres)</label>
                    <input type="text" wire:model.live="code" maxlength="10" class="form-control bg-white @error('code') is-invalid @enderror" style="text-transform: uppercase;">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitchSize">
                        <label class="form-check-label" for="isActiveSwitchSize">Ativo</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" wire:click="$dispatch('sizeSaved')" class="btn btn-light">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>
