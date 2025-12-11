<div>
    <form wire:submit="save">
        <div class="mb-3">
            <label class="form-label">Nome *</label>
            <input type="text" wire:model="name" class="form-control bg-white @error('name') is-invalid @enderror" placeholder="Ex: Couro, Algodão, Mesh Respirável">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Status</label>
            <div class="form-check form-switch">
                <input type="checkbox" wire:model="is_active" class="form-check-input" id="materialActive" role="switch">
                <label class="form-check-label" for="materialActive">
                    <span class="badge {{ $is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $is_active ? 'Ativo' : 'Inativo' }}
                    </span>
                </label>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-light" wire:click="$dispatch('closeForm')" data-bs-dismiss="modal">
                Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> {{ $materialId ? 'Atualizar' : 'Salvar' }}
            </button>
        </div>
    </form>
</div>
