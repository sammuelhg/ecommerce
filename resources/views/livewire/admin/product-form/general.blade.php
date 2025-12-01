                <!-- TAB: GERAL -->
                
                <!-- 1. Title (Auto-generated) -->
                <div class="mb-4">
                    <label for="name" class="form-label text-muted small text-uppercase fw-bold">Título do Produto (Gerado Automaticamente)</label>
                    <input type="text" wire:model.blur="name" class="form-control form-control-lg bg-white fw-bold text-primary" id="name" placeholder="Preencha os atributos abaixo..." readonly>
                    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <!-- 2. Note -->
                <div class="alert alert-info mb-4">
                    <i class="bi bi-magic"></i> <strong>Geração Automática:</strong> O título acima é formado pela combinação dos atributos selecionados abaixo.
                </div>

                <!-- 3. Attributes -->
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3 text-muted"><i class="bi bi-tags"></i> Definição de Atributos</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Categoria *</label>
                                <select wire:model.live="category_id" class="form-select bg-white @error('category_id') is-invalid @enderror">
                                    <option value="">Selecione...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->display_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tipo</label>
                                <select wire:model.live="product_type_id" class="form-select bg-white">
                                    <option value="">Selecione...</option>
                                    @foreach($types as $t) <option value="{{ $t->id }}">{{ $t->name }}</option> @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Modelo</label>
                                <select wire:model.live="product_model_id" class="form-select bg-white">
                                    <option value="">Selecione...</option>
                                    @foreach($models as $m) <option value="{{ $m->id }}">{{ $m->name }}</option> @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Material</label>
                                <select wire:model.live="product_material_id" class="form-select bg-white">
                                    <option value="">Selecione...</option>
                                    @foreach($materials as $mat) <option value="{{ $mat->id }}">{{ $mat->name }}</option> @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor</label>
                                <input type="text" wire:model.blur="color" class="form-control bg-white" placeholder="Ex: Preto">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tamanho</label>
                                <input type="text" wire:model.blur="size" class="form-control bg-white" placeholder="Ex: 42">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Atributo Extra</label>
                                <input type="text" wire:model.blur="attribute" class="form-control bg-white" placeholder="Ex: Manga Longa">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active" role="switch">
                            <label class="form-check-label" for="is_active">
                                <span class="badge {{ $is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Kit Management (if applicable) -->
                    @if($isKit)
                    <div class="col-12 mt-3">
                        <div class="card border-info">
                            <div class="card-header bg-info bg-opacity-10">
                                <strong><i class="bi bi-box-seam"></i> Composição do Kit</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 position-relative">
                                    <label class="form-label">Adicionar Produtos ao Kit</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                        <input type="text" wire:model.live.debounce.300ms="productSearch" class="form-control bg-white" placeholder="Buscar produto...">
                                    </div>
                                    @if(!empty($searchResults))
                                        <div class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                            @foreach($searchResults as $result)
                                                <button type="button" wire:click="addToBundle({{ $result->id }}, '{{ addslashes($result->name) }}', {{ $result->price }})" class="list-group-item list-group-item-action d-flex justify-content-between">
                                                    <span>{{ $result->name }}</span>
                                                    <span class="badge bg-secondary">R$ {{ number_format($result->price, 2, ',', '.') }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                @if(count($bundleItems) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr><th>Produto</th><th style="width: 100px;">Qtd</th><th style="width: 50px;"></th></tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bundleItems as $index => $item)
                                                    <tr>
                                                        <td>{{ $item['name'] }}</td>
                                                        <td><input type="number" value="{{ $item['quantity'] }}" wire:change="updateBundleQuantity({{ $index }}, $event.target.value)" class="form-control form-control-sm bg-white" min="1"></td>
                                                        <td><button type="button" wire:click="removeFromBundle({{ $index }})" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0 fs-6 py-2">Nenhum item no kit.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
