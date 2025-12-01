<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-{{ $isEditing ? 'pencil' : 'plus-circle' }}"></i>
            {{ $isEditing ? 'Editar Categoria' : 'Nova Categoria' }}
        </h5>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="row">
                <!-- Nome da Categoria -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome da Categoria *</label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           placeholder="Ex: Eletrônicos">
                    @error('name') 
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug (gerado automaticamente) -->
                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug (URL amigável) *</label>
                    <input type="text" 
                           wire:model="slug" 
                           class="form-control @error('slug') is-invalid @enderror" 
                           id="slug" 
                           placeholder="eletronicos">
                    @error('slug') 
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Gerado automaticamente a partir do nome</small>
                </div>

                <!-- Categoria Pai (opcional para subcategorias) -->
                <div class="col-md-6 mb-3">
                    <label for="parent_id" class="form-label">Categoria Pai (Opcional)</label>
                    <select wire:model="parent_id" class="form-select" id="parent_id">
                        <option value="">Nenhuma (Categoria Principal)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Deixe vazio para categoria principal, ou selecione uma categoria pai para criar uma subcategoria</small>
                </div>

                <!-- Descrição (para SEO) -->
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Descrição (SEO)</label>
                    <textarea wire:model="description" 
                              class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              rows="3"
                              placeholder="Descrição rica em palavras-chave para otimização de SEO..."></textarea>
                    @error('description') 
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Texto exibido na página da categoria, importante para SEO</small>
                </div>

                <!-- Status Ativo/Inativo -->
                <div class="col-12 mb-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" 
                               wire:model="is_active" 
                               class="form-check-input" 
                               id="is_active"
                               role="switch">
                        <label class="form-check-label" for="is_active">
                            <span class="badge {{ $is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </label>
                    </div>
                    <small class="text-muted">Categorias inativas não aparecem na loja</small>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="d-flex justify-content-between mt-4">
                <button type="button" 
                        wire:click="$dispatch('closeForm')" 
                        class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="submit" 
                        class="btn btn-success">
                    <i class="bi bi-check-circle"></i> {{ $isEditing ? 'Atualizar' : 'Salvar' }} Categoria
                </button>
            </div>
        </form>
    </div>
</div>
