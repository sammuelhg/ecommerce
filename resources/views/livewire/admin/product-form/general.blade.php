<div class="row">
    <!-- Attributes -->
    <div class="col-12">
        <div class="card bg-light border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title mb-3 text-muted"><i class="bi bi-tags"></i> Definição de Atributos</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Categoria *</label>
                        <select wire:model.lazy="category_id" class="form-select bg-white @error('category_id') is-invalid @enderror">
                            <option value="">Selecione...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo</label>
                        <select wire:model.lazy="product_type_id" class="form-select bg-white">
                            <option value="">Selecione...</option>
                            @foreach($types as $t) <option value="{{ $t->id }}">{{ $t->name }}</option> @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Modelo</label>
                        <select wire:model.lazy="product_model_id" class="form-select bg-white">
                            <option value="">Selecione...</option>
                            @foreach($models as $m) <option value="{{ $m->id }}">{{ $m->name }}</option> @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Material</label>
                        <select wire:model.lazy="product_material_id" class="form-select bg-white">
                            <option value="">Selecione...</option>
                            @foreach($materials as $mat) <option value="{{ $mat->id }}">{{ $mat->name }}</option> @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">
                            @if($category_id && isset($categories) && str_contains(strtolower($categories->firstWhere('id', $category_id)->name ?? ''), 'suplemento'))
                                Sabor
                            @else
                                Cor
                            @endif
                        </label>
                        <select wire:model.lazy="product_color_id" class="form-select bg-white">
                            <option value="">Selecione...</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">
                                    {{ $color->name }} 
                                    @if($color->hex_code)
                                        <span style="color: {{ $color->hex_code }}">●</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tamanho</label>
                        <select wire:model.lazy="product_size_id" class="form-select bg-white">
                            <option value="">Selecione...</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Atributo Genérico</label>
                        <input type="text" wire:model.lazy="attribute" class="form-control bg-white" placeholder="Ex: Manga Longa">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kit Management (if applicable) -->
    @if($isKit)
    <div class="col-12">
        <div class="card border-info mb-4">
            <div class="card-header bg-info bg-opacity-10">
                <strong><i class="bi bi-box-seam"></i> Composição do Kit</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Adicionar Produtos ao Kit</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="productSearch" class="form-control bg-white" placeholder="Buscar produto por nome...">
                    </div>

                    @if($kitProducts && $kitProducts->count() > 0)
                        <div class="table-responsive border rounded mb-3" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Produto</th>
                                        <th class="text-end">Preço</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kitProducts as $product)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       wire:click="toggleBundleItem({{ $product->id }})"
                                                       @if($this->isInBundle($product->id)) checked @endif>
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td class="text-end">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $kitProducts->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="alert alert-info py-2">
                            <i class="bi bi-info-circle me-2"></i> Nenhum produto encontrado para adicionar.
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
