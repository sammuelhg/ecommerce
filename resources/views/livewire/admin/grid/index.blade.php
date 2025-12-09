<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Gerenciador de Layout do Grid</h5>
                <button wire:click="create" class="btn btn-primary">
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
                                        <button wire:click="edit({{ $rule->id }})" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </button>
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

    {{-- Modal --}}
    @if($showModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1"
         x-data="{
             type: @entangle('type'),
             title: @entangle('config_title'),
             text: @entangle('config_text'),
             link: @entangle('config_link'),
             btn_text: @entangle('config_button_text'),
             bg_color: @entangle('config_bg_color'),
             text_color: @entangle('config_text_color'),
             btn_color: @entangle('config_btn_color'),
             btn_color: @entangle('config_btn_color'),
             badge_type: @entangle('config_badge_type'),
             image_style: @entangle('config_image_style'),
             
             // Badge Logic Helpers
             getBadgeLabel() {
                const labels = {
                    'best_buy': 'Melhor Compra',
                    'editor_choice': 'Escolha do Editor',
                    'big_discount': 'Super Desconto',
                    'limited': 'Oferta Limitada'
                };
                return labels[this.badge_type] || 'Especial';
             },
             getBadgeIcon() {
                 const icons = {
                    'best_buy': 'bi-stars',
                    'editor_choice': 'bi-award-fill',
                    'big_discount': 'bi-percent',
                    'limited': 'bi-stopwatch-fill'
                 };
                 return icons[this.badge_type] || 'bi-tag-fill';
             },
             getBadgeColor() {
                 const colors = {
                    'best_buy': 'bg-warning text-dark',
                    'editor_choice': 'bg-primary text-white',
                    'big_discount': 'bg-danger text-white',
                    'limited': 'bg-dark text-white'
                 };
                 return colors[this.badge_type] || 'bg-secondary text-white';
             }
         }"
    >
        <div class="modal-dialog modal-xl"> {{-- Expanded to XL --}}
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editingRuleId ? 'Editar Regra' : 'Nova Regra de Grid' }}</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body p-0"> {{-- Removed default padding to handle split --}}
                    <div class="row g-0 h-100">
                        {{-- Left Column: Config Form --}}
                        <div class="col-lg-7 p-4" style="max-height: 80vh; overflow-y: auto;">
                            {{-- Tabs --}}
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <button class="nav-link {{ $activeTab === 'content' ? 'active' : '' }}" 
                                            wire:click="setTab('content')">Conteúdo</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link {{ $activeTab === 'design' ? 'active' : '' }}" 
                                            wire:click="setTab('design')">Design & Estilo</button>
                                </li>
                            </ul>
        
                            {{-- Tab Content (Inputs) --}}
                            @if($activeTab === 'content')
                                <div class="animate__animated animate__fadeIn">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Posição (1 = Primeiro)</label>
                                            <input type="number" wire:model="position" class="form-control" placeholder="Ex: 3">
                                            @error('position') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tipo de Card</label>
                                            <select wire:model.live="type" x-model="type" class="form-select"> {{-- Sync Type --}}
                                                <option value="marketing_banner">Banner de Marketing</option>
                                                <option value="card.product_highlight">Produto Destaque (Card Padrão)</option>
                                                <option value="card.product_special">Produto Especial (Badge/Oferta)</option>
                                                <option value="card.newsletter_form">Inscrição Newsletter</option>
                                            </select>
                                        </div>
                                    </div>
        
                                    {{-- Product Selection --}}
                                    @if(Str::contains($type, 'product'))
                                        <div class="mb-3 border p-3 rounded bg-light">
                                            <label class="form-label fw-bold">Selecionar Produto</label>
                                            @if($selectedProduct)
                                                <div class="alert alert-success d-flex justify-content-between align-items-center mb-0">
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
        
                                        @if($type === 'card.product_special')
                                            <div class="mb-3">
                                                <label class="form-label">Badge / Tipo de Oferta</label>
                                                <select wire:model="config_badge_type" x-model="badge_type" class="form-select">
                                                    <option value="best_buy">Melhor Compra (Ícone ✨)</option>
                                                    <option value="editor_choice">Escolha do Editor (Ícone ⭐)</option>
                                                    <option value="big_discount">Super Desconto (Ícone %)</option>
                                                    <option value="limited">Tempo Limitado (Ícone ⏰)</option>
                                                </select>
                                            </div>
                                        @endif
                                    @endif
        
                                    {{-- Text Content Inputs --}}
                                    @if($type === 'marketing_banner' || $type === 'card.newsletter_form')
                                        @if($type === 'marketing_banner')
                                            <div class="mb-3">
                                                <label class="form-label">Link de Destino</label>
                                                <input type="text" wire:model="config_link" x-model="link" class="form-control" placeholder="https://...">
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label">Largura (Colunas)</label>
                                            <select wire:model="col_span" class="form-select">
                                                <option value="1">1 Coluna</option>
                                                <option value="2">2 Colunas</option>
                                                <option value="3">3 Colunas</option>
                                                <option value="4">4 Colunas</option>
                                                <option value="5">Tela Inteira (5 Colunas)</option>
                                            </select>
                                        </div>
        
                                        @if($type === 'card.newsletter_form')
                                            <div class="mb-3">
                                                <label class="form-label">Campanha Vinculada</label>
                                                <select wire:model="config_campaign_id" class="form-select">
                                                    <option value="">Selecione...</option>
                                                    @foreach($this->campaigns as $campaign)
                                                        <option value="{{ $campaign->id }}">{{ $campaign->subject }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
        
                                        <div class="mb-3">
                                            <label class="form-label">Título</label>
                                            <input type="text" wire:model="config_title" x-model="title" class="form-control" placeholder="Ex: Super Oferta">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Texto / Subtítulo (HTML Permitido)</label>
                                            <textarea wire:model="config_text" x-model="text" class="form-control" rows="3" placeholder="Use <strong>bold</strong> ou <br>"></textarea>
                                        </div>
        
                                        <div class="mb-3">
                                            <label class="form-label">Texto do Botão</label>
                                            <input type="text" wire:model="config_button_text" x-model="btn_text" class="form-control" placeholder="Ex: Ver Oferta">
                                        </div>
                                    @endif
                                </div>
                            @endif
        
                            {{-- Design Tab Content --}}
                            @if($activeTab === 'design')
                                <div class="animate__animated animate__fadeIn">
                                    @if($type === 'marketing_banner' || $type === 'card.newsletter_form')
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Imagem de Fundo / Principal</label>
                                            <input type="file" wire:model="config_image" class="form-control mb-2">
                                            @if($config_image)
                                                <div class="p-2 border rounded bg-light text-center mb-2">
                                                    <img src="{{ $config_image->temporaryUrl() }}" class="img-fluid" style="max-height: 150px;">
                                                </div>
                                            @endif
                                            
                                            <label class="form-label fw-bold d-block mt-3">Estilo da Imagem</label>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" name="img_style" id="style_bg" value="background" wire:model="config_image_style" x-model="image_style">
                                                <label class="btn btn-outline-secondary" for="style_bg">Fundo Cheio (Cover)</label>
                                        
                                                <input type="radio" class="btn-check" name="img_style" id="style_top" value="top" wire:model="config_image_style" x-model="image_style">
                                                <label class="btn btn-outline-secondary" for="style_top">Topo do Card</label>
                                            </div>
                                        </div>
                                    @endif
        
                                    {{-- Colors (Synced with Alpine) --}}
                                    <div class="mb-4">
                                        <label class="form-label fw-bold d-block">Cor do Texto</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach(['text-dark', 'text-white', 'text-primary', 'text-danger', 'text-success', 'text-warning'] as $color)
                                                <button type="button" 
                                                    class="btn btn-sm rounded-circle border shadow-sm {{ $config_text_color === $color ? 'ring-2 ring-primary' : '' }}" 
                                                    style="width: 30px; height: 30px; background-color: var(--bs-{{ str_replace('text-', '', $color) }});"
                                                    wire:click="$set('config_text_color', '{{ $color }}')"
                                                    @click="text_color = '{{ $color }}'" {{-- Update Alpine --}}
                                                    title="{{ $color }}">
                                                    @if($config_text_color === $color) <i class="bi bi-check text-white mix-blend-difference"></i> @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
        
                                    <div class="mb-4">
                                        <label class="form-label fw-bold d-block">Cor de Fundo</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach(['bg-white', 'bg-light', 'bg-dark', 'bg-primary', 'bg-danger', 'bg-success', 'bg-warning'] as $color)
                                                <button type="button" 
                                                    class="btn btn-sm rounded-circle border shadow-sm {{ $config_bg_color === $color ? 'ring-2 ring-primary' : '' }}" 
                                                    style="width: 30px; height: 30px; background-color: var(--bs-{{ str_replace('bg-', '', $color) }});"
                                                    wire:click="$set('config_bg_color', '{{ $color }}')"
                                                    @click="bg_color = '{{ $color }}'" {{-- Update Alpine --}}
                                                    title="{{ $color }}">
                                                    @if($config_bg_color === $color) <i class="bi bi-check {{ str_contains($color, 'dark') || str_contains($color, 'primary') || str_contains($color, 'danger') ? 'text-white' : 'text-dark' }}"></i> @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                     <div class="mb-4">
                                        <label class="form-label fw-bold d-block">Cor do Botão</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach(['btn-primary', 'btn-dark', 'btn-danger', 'btn-success', 'btn-warning', 'btn-outline-dark', 'btn-outline-light'] as $color)
                                                <button type="button" 
                                                    class="btn btn-sm {{ $color }} {{ $config_btn_color === $color ? 'border-2 border-dark' : '' }}" 
                                                    wire:click="$set('config_btn_color', '{{ $color }}')"
                                                    @click="btn_color = '{{ $color }}'">
                                                    Botão
                                                    @if($config_btn_color === $color) <i class="bi bi-check ms-1"></i> @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
        
                        {{-- Right Column: Preview --}}
                        <div class="col-lg-5 bg-light border-start p-4 d-flex flex-column align-items-center justify-content-center position-relative">
                            <div class="sticky-top w-100" style="top: 2rem;">
                                <h6 class="text-uppercase fw-bold text-muted mb-4 small text-center">Pré-visualização (Tempo Real)</h6>
                                
                                {{-- Marketing Banner Preview --}}
                                <template x-if="type == 'marketing_banner'">
                                    <div class="card h-100 border-0 overflow-hidden position-relative shadow-sm"
                                         :class="[bg_color, text_color]" style="min-height: 300px;">
                                        
                                        @if($config_image)
                                            <!-- Background Style -->
                                            <div x-show="image_style == 'background'" 
                                                 class="position-absolute top-0 start-0 w-100 h-100" 
                                                 style="background-image: url('{{ $config_image->temporaryUrl() }}'); background-size: cover; background-position: center;">
                                                 <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.3;"></div> 
                                            </div>

                                            <!-- Top Style -->
                                            <div x-show="image_style == 'top'" class="w-100 flex-shrink-0">
                                                <img src="{{ $config_image->temporaryUrl() }}" class="card-img-top object-fit-cover" style="height: 200px;">
                                            </div>
                                        @endif
        
                                        <div class="card-body d-flex flex-column justify-content-center align-items-start p-4 position-relative" style="z-index: 2;">
                                            <h3 class="card-title fw-bold mb-2" x-text="title || 'Título'"></h3>
                                            <p class="card-text mb-4 fs-5" x-html="text || 'Descrição...'"></p>
                                            <a href="#" class="btn fw-bold px-4 rounded-pill" 
                                               :class="btn_color" 
                                               x-text="btn_text || 'Ver Oferta'"></a>
                                        </div>
                                    </div>
                                </template>
        
                                {{-- Newsletter Preview --}}
                                <template x-if="type == 'card.newsletter_form'">
                                    <div class="card h-100 border-0 d-flex align-items-center justify-content-center p-4 position-relative overflow-hidden shadow-sm"
                                         :class="[bg_color, text_color]" style="min-height: 250px;">
                                        
                                        @if($config_image)
                                            <div x-show="image_style == 'background'" class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ $config_image->temporaryUrl() }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>
                                            
                                            <div x-show="image_style == 'top'" class="w-100 flex-shrink-0">
                                                <img src="{{ $config_image->temporaryUrl() }}" class="card-img-top object-fit-cover" style="height: 150px;">
                                            </div>
                                        @endif
        
                                        <div class="w-100 p-3 position-relative" style="z-index: 2;">
                                            <div class="text-center mb-3">
                                                <h5 class="fw-bold mb-2" x-text="title || '📧 Newsletter'"></h5>
                                                <div class="small lh-sm">
                                                    <span x-show="text" x-html="text"></span>
                                                    <span x-show="!text">Ganhe <strong class="text-danger">15% OFF</strong> na 1ª compra!</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <input type="email" class="form-control form-control-sm bg-white border border-secondary text-center" placeholder="seu@email.com" disabled>
                                                <button class="btn btn-sm fw-bold w-100 text-uppercase" 
                                                        :class="btn_color" 
                                                        x-text="btn_text || 'QUERO DESCONTO'"></button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
        
                                {{-- Product Special Preview (Simplified) --}}
                                <template x-if="type == 'card.product_special'">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative bg-white text-center" style="min-height: 350px;">
                                         <div class="position-absolute top-0 start-0 w-100 p-2 d-flex justify-content-between align-items-start z-2">
                                            <span class="badge d-flex align-items-center gap-1 shadow-sm px-3 py-2 rounded-pill" :class="getBadgeColor()">
                                                <i class="bi fs-6" :class="getBadgeIcon()"></i>
                                                <span class="fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;" x-text="getBadgeLabel()"></span>
                                            </span>
                                        </div>
                                        <div class="position-relative bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-image fs-1 text-muted"></i>
                                            <span class="ms-2 text-muted small">Imagem do Produto</span>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold text-dark mb-1">Nome do Produto</h5>
                                            <span class="fw-bold text-dark fs-4">R$ 199,90</span>
                                            <button class="btn w-100 rounded-pill fw-bold mt-3" :class="badge_type == 'big_discount' ? 'btn-danger' : 'btn-dark'">
                                                <i class="bi bi-cart-plus me-1"></i> Adicionar
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="save">{{ $editingRuleId ? 'Atualizar' : 'Salvar' }}</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
