<div>
    <form wire:submit="save">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Nome *</label>
                <input type="text" wire:model.live="name" class="form-control bg-white @error('name') is-invalid @enderror" placeholder="Ex: P, M, G, 38, 1kg">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Código (máx 10 caracteres) *</label>
                <input type="text" wire:model.live="code" maxlength="10" class="form-control bg-white @error('code') is-invalid @enderror" style="text-transform: uppercase;" placeholder="TAM-M">
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label d-block">Status</label>
                <div class="form-check form-switch custom-switch">
                    <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitchSize" role="switch">
                    <label class="form-check-label" for="isActiveSwitchSize">
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
                <i class="bi bi-check-circle"></i> {{ $sizeId ? 'Atualizar' : 'Salvar' }}
            </button>
        </div>
    </form>
</div>
