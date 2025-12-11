<div>
    <form wire:submit="save">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome *</label>
                <input type="text" wire:model.live="name" class="form-control bg-white @error('name') is-invalid @enderror" placeholder="Ex: Azul Marinho">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label">Código (3 letras) *</label>
                <input type="text" wire:model.live="code" maxlength="3" class="form-control bg-white @error('code') is-invalid @enderror" style="text-transform: uppercase;" placeholder="AZM">
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Cor (Hex) *</label>
                <div class="input-group">
                    <input type="color" wire:model.live="hex_code" class="form-control form-control-color bg-white" title="Escolha a cor">
                    <input type="text" wire:model.live="hex_code" class="form-control bg-white @error('hex_code') is-invalid @enderror" placeholder="#000000">
                </div>
                @error('hex_code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label d-block">Status</label>
                <div class="form-check form-switch custom-switch">
                    <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitch" role="switch">
                    <label class="form-check-label" for="isActiveSwitch">
                        <span class="badge {{ $is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" wire:click="$dispatch('closeForm')" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> {{ $colorId ? 'Atualizar' : 'Salvar' }}
            </button>
        </div>
    </form>
</div>
