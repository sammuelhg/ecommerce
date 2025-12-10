<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-ui-checks"></i> Construtor de Formulários</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label fw-bold">Título da Campanha</label>
                    <input type="text" wire:model="title" class="form-control form-control-lg" placeholder="Ex: Lead Magnet Ebook 2024">
                    @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <hr>

                <h6 class="mb-3 fw-bold text-secondary">Campos do Formulário</h6>
                
                <div class="list-group mb-4">
                    @foreach($fields as $index => $field)
                        <div class="list-group-item bg-light border-0 mb-2 rounded p-3">
                            <div class="row align-items-end g-2">
                                <div class="col-md-5">
                                    <label class="small text-muted">Label</label>
                                    <input type="text" wire:model="fields.{{ $index }}.label" class="form-control" placeholder="Pergunta">
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Tipo</label>
                                    <select wire:model="fields.{{ $index }}.type" class="form-select">
                                        <option value="text">Texto</option>
                                        <option value="email">Email</option>
                                        <option value="tel">Telefone</option>
                                        <option value="textarea">Área de Texto</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Nome do Campo (Sistema)</label>
                                    <input type="text" wire:model="fields.{{ $index }}.name" class="form-control" placeholder="variable_name">
                                </div>
                                <div class="col-md-1 text-end">
                                    <button wire:click="removeField({{ $index }})" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button wire:click="addField" class="btn btn-outline-primary mb-3">
                    <i class="bi bi-plus-lg"></i> Adicionar Campo
                </button>

                <div class="d-grid">
                    <button wire:click="save" class="btn btn-primary btn-lg">
                        <i class="bi bi-save"></i> Salvar Formulário
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
