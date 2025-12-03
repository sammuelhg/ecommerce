<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $typeId ? 'Editar' : 'Novo' }} Tipo</h5>
        <button type="button" class="btn-close" wire:click="$dispatch('typeSaved')"></button>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="mb-3">
                <label class="form-label">Nome *</label>
                <input type="text" wire:model="name" class="form-control bg-white @error('name') is-invalid @enderror" placeholder="Ex: Tênis, Camisa">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Código (3 letras) *</label>
                <input type="text" wire:model="code" class="form-control bg-white @error('code') is-invalid @enderror" placeholder="Ex: TEN, CAM" maxlength="3">
                @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Código de 3 letras para uso no SKU</small>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" wire:model="is_active" class="form-check-input" id="typeActive">
                <label class="form-check-label" for="typeActive">Ativo</label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ $typeId ? 'Atualizar' : 'Salvar' }}
                </button>
                <button type="button" class="btn btn-secondary" wire:click="$dispatch('typeSaved')">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
