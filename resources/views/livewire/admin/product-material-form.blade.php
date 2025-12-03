<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $materialId ? 'Editar' : 'Novo' }} Material</h5>
        <button type="button" class="btn-close" wire:click="$dispatch('materialSaved')"></button>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="mb-3">
                <label class="form-label">Nome *</label>
                <input type="text" wire:model="name" class="form-control bg-white @error('name') is-invalid @enderror" placeholder="Ex: Couro, Algodão, Mesh Respirável">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" wire:model="is_active" class="form-check-input" id="materialActive">
                <label class="form-check-label" for="materialActive">Ativo</label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ $materialId ? 'Atualizar' : 'Salvar' }}
                </button>
                <button type="button" class="btn btn-secondary" wire:click="$dispatch('materialSaved')">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
