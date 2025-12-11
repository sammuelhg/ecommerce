<div>
    <h1 class="mb-4">Criar Nova Campanha</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form wire:submit="save">
                <div class="mb-3">
                    <label class="form-label">Título da Campanha</label>
                    <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Configuração (JSON)</label>
                    <textarea wire:model="structureJson" class="form-control @error('structureJson') is-invalid @enderror" rows="10"></textarea>
                    <div class="form-text">Defina os campos do formulário em formato JSON.</div>
                    @error('structureJson') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Salvar Campanha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
