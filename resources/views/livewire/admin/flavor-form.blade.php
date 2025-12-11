<div>
    <form wire:submit="save">
        <div class="mb-3">
            <label class="form-label">Nome do Sabor</label>
            <input type="text" wire:model.live="name" class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" wire:model="slug" class="form-control bg-light @error('slug') is-invalid @enderror">
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Cor Representativa (Opcional)</label>
            <div class="input-group">
                <input type="color" class="form-control form-control-color" id="flavorColorInput" value="{{ $hex_code ?? '#ffffff' }}" title="Escolha a cor" 
                    oninput="@this.set('hex_code', this.value)">
                <input type="text" wire:model.live="hex_code" class="form-control @error('hex_code') is-invalid @enderror" placeholder="#000000">
            </div>
            <div class="form-text">Usada para ícones visuais nos cards de produto.</div>
            @error('hex_code') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="form-check form-switch mb-4">
            <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitch">
            <label class="form-check-label" for="isActiveSwitch">Ativo</label>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">
                {{ $flavorId ? 'Salvar Alterações' : 'Criar Sabor' }}
            </button>
        </div>
    </form>
</div>
