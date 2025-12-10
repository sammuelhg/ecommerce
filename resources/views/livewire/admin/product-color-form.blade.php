<div class="card border-0 shadow-sm mb-4">
    <div class="card-header">
        <h5 class="mb-0">{{ $colorId ? 'Editar Cor' : 'Nova Cor' }}</h5>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nome</label>
                    <input type="text" wire:model.live="name" class="form-control bg-white @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Código (3 letras)</label>
                    <input type="text" wire:model.live="code" maxlength="3" class="form-control bg-white @error('code') is-invalid @enderror" style="text-transform: uppercase;">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Cor (Hex)</label>
                    <div class="input-group">
                        <input type="color" wire:model.live="hex_code" class="form-control form-control-color bg-white" title="Escolha a cor">
                        <input type="text" wire:model.live="hex_code" class="form-control bg-white @error('hex_code') is-invalid @enderror">
                    </div>
                    @error('hex_code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitch">
                        <label class="form-check-label" for="isActiveSwitch">Ativo</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" wire:click="$dispatch('colorSaved')" class="btn btn-light">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>
