<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $modelId ? 'Editar' : 'Novo' }} Modelo</h5>
        <button type="button" class="btn-close" wire:click="$dispatch('modelSaved')"></button>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="mb-3">
                <label class="form-label">Nome *</label>
                <input type="text" wire:model="name" class="form-control bg-white @error('name') is-invalid @enderror" placeholder="Ex: Glide Pro 5, Classic Fit">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Code field hidden but still exists in model -->
            <input type="hidden" wire:model="code">

            <div class="mb-3 form-check">
                <input type="checkbox" wire:model="is_active" class="form-check-input" id="modelActive">
                <label class="form-check-label" for="modelActive">Ativo</label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ $modelId ? 'Atualizar' : 'Salvar' }}
                </button>
                <button type="button" class="btn btn-secondary" wire:click="$dispatch('modelSaved')">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
