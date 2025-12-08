<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Gerenciador de Layout do Grid</h5>
                <button wire:click="$set('showModal', true)" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Nova Regra
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Posição</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Span</th>
                                <th scope="col">Conteúdo</th>
                                <th scope="col" class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rules as $rule)
                                <tr>
                                    <td><span class="badge bg-secondary fs-6">{{ $rule->position + 1 }}</span></td>
                                    <td>
                                        @if($rule->type == 'marketing_banner')
                                            <span class="badge bg-info text-dark">Banner</span>
                                        @elseif($rule->type == 'product_highlight' || $rule->type == 'card.product_highlight')
                                            <span class="badge bg-warning text-dark">Destaque</span>
                                        @elseif($rule->type == 'card.newsletter_form')
                                            <span class="badge bg-success text-white">Newsletter</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ $rule->type }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $rule->col_span }} col(s)</td>
                                    <td>
                                        <small class="d-block text-muted">Título: {{ $rule->configuration['title'] ?? '-' }}</small>
                                        <small class="d-block text-muted">Texto: {{ Str::limit($rule->configuration['text'] ?? '-', 30) }}</small>
                                    </td>
                                    <td class="text-end">
                                        <button wire:click="delete({{ $rule->id }})" class="btn btn-sm btn-outline-danger" onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Nenhuma regra definida. O grid seguirá a ordem natural dos produtos.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Simple Modal (Inline for now or use Bootstrap Modal) --}}
    @if($showModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Regra de Grid</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Posição no Grid (1 = Primeiro)</label>
                        <input type="number" wire:model="position" class="form-control" placeholder="Ex: 3">
                        @error('position') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tipo de Card</label>
                        <select wire:model="type" class="form-select">
                            <option value="marketing_banner">Banner de Marketing</option>
                            <option value="card.product_highlight">Produto Destaque (Card Especial)</option>
                            <option value="card.newsletter_form">Inscrição Newsletter</option>
                        </select>
                    </div>

                    @if($type == 'card.product_highlight')
                        <div class="mb-3 border p-3 rounded bg-light">
                            <label class="form-label fw-bold">Selecionar Produto</label>
                            
                            @if($selectedProduct)
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $selectedProduct->name }}</strong><br>
                                        <small class="text-muted">R$ {{ number_format($selectedProduct->price, 2, ',', '.') }}</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" wire:click="$set('selectedProduct', null)">Alterar</button>
                                </div>
                            @else
                                <div class="position-relative">
                                    <input type="text" wire:model.live.debounce.300ms="productSearch" class="form-control" placeholder="Buscar produto...">
                                    @if(count($foundProducts) > 0)
                                        <div class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; top: 100%;">
                                            @foreach($foundProducts as $prod)
                                                <button type="button" class="list-group-item list-group-item-action" wire:click="selectProduct({{ $prod->id }})">
                                                    {{ $prod->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($type == 'card.newsletter_form')
                        <div class="mb-3">
                            <label class="form-label">Imagem do Card (Opcional)</label>
                            <input type="file" wire:model="config_image" class="form-control">
                            <div class="form-text">Faça upload de uma imagem para ilustrar o card.</div>
                            @error('config_image') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    @if($type == 'marketing_banner')

                    <div class="mb-3">
                        <label class="form-label">Largura (Colunas)</label>
                        <select wire:model="col_span" class="form-select">
                            <option value="1">1 Coluna</option>
                            <option value="2">2 Colunas</option>
                            <option value="3">3 Colunas</option>
                            <option value="4">4 Colunas</option>
                            <option value="5">5 Colunas (Tela inteira)</option>
                        </select>
                    </div>

                    <hr>
                    <h6>Configuração do Banner</h6>
                    
                    <div class="mb-2">
                        <label class="form-label">Título</label>
                        <input type="text" wire:model="config_title" class="form-control">
                    </div>
                    
                    <div class="mb-2">
                        <label class="form-label">Texto</label>
                        <textarea wire:model="config_text" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-2">
                        <label class="form-label">Cor de Fundo (Classe CSS)</label>
                        <input type="text" wire:model="config_bg_class" class="form-control" placeholder="bg-primary text-white">
                        <div class="form-text">Ex: bg-primary, bg-dark, bg-warning</div>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
