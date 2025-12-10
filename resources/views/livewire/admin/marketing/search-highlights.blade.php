<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Marketing / Itens de Pesquisa (Destaques)</h4>
            
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Selecione o Contexto (Categoria)</label>
                            <select class="form-select" wire:model.live="selectedCategory">
                                <option value="global">🌐 Destaques Globais (Padrão)</option>
                                <option disabled>------------------------</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                Escolha os produtos que aparecerão como sugestão quando esta categoria for selecionada (ou padrão global em buscas vazias).
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <!-- Left: Current Highlights -->
                        <div class="col-md-7 border-end">
                            <h5 class="card-title">Itens Selecionados</h5>
                            <p class="small text-muted mb-3">Estes produtos aparecerão na busca vazia. (Min: 3)</p>

                            @if($highlights->count() < 3)
                                <div class="alert alert-warning py-2 small">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    Recomendado selecionar pelo menos 3 itens.
                                </div>
                            @endif

                            <div class="list-group">
                                @forelse($highlights as $highlight)
                                    <div class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 50px; height: 50px; background-color: #f1f1f1; border-radius: 4px; background-image: url('{{ $highlight->product->image }}'); background-size: cover; background-position: center;" class="me-3"></div>
                                            <div>
                                                <h6 class="mb-0">{{ $highlight->product->name }}</h6>
                                                <small class="text-muted">R$ {{ number_format($highlight->product->price, 2, ',', '.') }}</small>
                                            </div>
                                        </div>
                                        <button wire:click="removeHighlight({{ $highlight->id }})" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-basket display-6 d-block mb-3 opacity-50"></i>
                                        Nenhum destaque selecionado para este contexto.<br>
                                        Use a busca ao lado para adicionar.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Right: Add Products -->
                        <div class="col-md-5 ps-md-4">
                            <h5 class="card-title">Adicionar Produtos</h5>
                            <div class="mb-3">
                                <input type="text" class="form-control" 
                                       placeholder="Buscar produto pelo nome..." 
                                       wire:model.live.debounce.300ms="searchProduct">
                            </div>

                            @if(strlen($searchProduct) > 2)
                                <div class="list-group shadow-sm">
                                    @forelse($searchResults as $product)
                                        <button wire:click="addProduct({{ $product->id }})" 
                                                class="list-group-item list-group-item-action d-flex align-items-center justify-content-between animate__animated animate__fadeIn">
                                            <div class="d-flex align-items-center">
                                                <div style="width: 40px; height: 40px; background-color: #f1f1f1; border-radius: 4px; background-image: url('{{ $product->image }}'); background-size: cover; background-position: center;" class="me-2"></div>
                                                <div class="text-truncate" style="max-width: 200px;">
                                                    <span class="d-block text-truncate">{{ $product->name }}</span>
                                                    <small class="text-muted">R$ {{ number_format($product->price, 2, ',', '.') }}</small>
                                                </div>
                                            </div>
                                            <i class="bi bi-plus-lg text-primary"></i>
                                        </button>
                                    @empty
                                        <div class="text-muted text-center py-3">Nenhum produto encontrado.</div>
                                    @endforelse
                                </div>
                            @elseif(strlen($searchProduct) > 0)
                                <div class="text-muted small">Digite pelo menos 3 caracteres...</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
