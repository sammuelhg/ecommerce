<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
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
                                        @if($rule->type === 'card.newsletter_form')
                                            <small class="d-block text-success fw-bold">Formulário: {{ $rule->form->title ?? 'N/A' }}</small>
                                        @else
                                            <small class="d-block text-muted">Título: {{ $rule->configuration['title'] ?? '-' }}</small>
                                            <small class="d-block text-muted">Texto: {{ Str::limit($rule->configuration['text'] ?? '-', 30) }}</small>
                                        @endif
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
             badge_type: @entangle('config_badge_type'),
             image_style: @entangle('config_image_style'),
             
             // Form Selection Logic
             form_id: @entangle('config_form_id'),
             forms: {{ json_encode($availableForms) }},

             // Tab Logic (Client-side)
             activeTab: 'content',

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
             },
             
             loadFormData(id) {
                if (!id) return;
                const form = this.forms.find(f => f.id == id);
                if (form) {
                    this.title = form.title;
                    this.text = form.description;
                    if (form.settings) {
                        let settings = form.settings;
                        if (typeof settings === 'string') {
                            try { settings = JSON.parse(settings); } catch(e) {}
                        }
                        this.btn_text = settings.button_text || 'Enviar';
                    }
                }
             },

             init() {
                if (this.form_id) {
                    this.loadFormData(this.form_id);
                }

                this.$watch('form_id', (value) => {
                    this.loadFormData(value);
                });
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
                                    <button class="nav-link" :class="{ 'active': activeTab === 'content' }" 
                                            @click.prevent="activeTab = 'content'">Conteúdo</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" :class="{ 'active': activeTab === 'design' }" 
                                            @click.prevent="activeTab = 'design'">Design & Estilo</button>
                                </li>
                            </ul>
        
                            {{-- Tab Content (Inputs) --}}
                            <div x-show="activeTab === 'content'">
                                <div class="animate__animated animate__fadeIn">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Posição (1 = Primeiro)</label>
                                            <input type="number" wire:model="position" class="form-control" placeholder="Ex: 3">
                                            @error('position') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tipo de Card</label>
                                            {{-- Removed wire:model.live to prevent server requests --}}
                                            <select x-model="type" class="form-select">
                                                <option value="marketing_banner">Banner de Marketing</option>
                                                <option value="card.product_highlight">Produto Destaque (Card Padrão)</option>
                                                <option value="card.product_special">Produto Especial (Badge/Oferta)</option>
                                                <option value="card.newsletter_form">Inscrição Newsletter</option>
                                            </select>
                                        </div>
                                    </div>
        
                                    {{-- Product Selection --}}
                                    <div x-show="type.includes('product')">
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
                                                <div class="position-relative" x-data="{ search: @entangle('productSearch').live.debounce.300ms }">
                                                    {{-- Search still needs livewire to find products --}}
                                                    <input type="text" x-model="search" class="form-control" placeholder="Buscar produto...">
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
        
                                        <div x-show="type === 'card.product_special'" class="mb-3">
                                            <label class="form-label">Badge / Tipo de Oferta</label>
                                            <select x-model="badge_type" class="form-select">
                                                <option value="best_buy">Melhor Compra (Ícone ✨)</option>
                                                <option value="editor_choice">Escolha do Editor (Ícone ⭐)</option>
                                                <option value="big_discount">Super Desconto (Ícone %)</option>
                                                <option value="limited">Tempo Limitado (Ícone ⏰)</option>
                                            </select>
                                        </div>
                                    </div>
        
                                    {{-- Text Content Inputs --}}
                                    <div x-show="['marketing_banner', 'card.newsletter_form'].includes(type)">
                                        
                                        <div x-show="type === 'marketing_banner'" class="mb-3">
                                            <label class="form-label">Link de Destino</label>
                                            <input type="text" x-model="link" class="form-control" placeholder="https://...">
                                        </div>

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
        
                                        <div x-show="type === 'card.newsletter_form'" class="mb-3">
                                            <label class="form-label">Formulário de Captura</label>
                                            <select x-model="form_id" class="form-select">
                                                <option value="">Selecione...</option>
                                                @foreach($availableForms as $form)
                                                    <option value="{{ $form->id }}">{{ $form->title }} ({{ $form->campaign->name ?? 'Sem Campanha' }})</option>
                                                @endforeach
                                            </select>
                                            @error('config_form_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div x-show="type !== 'card.newsletter_form'" class="mb-3">
                                            <label class="form-label">Título</label>
                                            <input type="text" x-model="title" class="form-control" placeholder="Ex: Super Oferta">
                                        </div>

                                        <div x-show="type === 'marketing_banner'" class="mb-3">
                                            <label class="form-label">Texto / Subtítulo</label>
                                            <div class="border rounded bg-white" 
                                                 x-data="{
                                                      exec(command, value = null) {
                                                          document.execCommand(command, false, value);
                                                          this.$refs.editor.focus();
                                                          text = this.$refs.editor.innerHTML;
                                                      },
                                                      insertBadge() {
                                                          const selection = window.getSelection();
                                                          if (!selection.rangeCount) return;
                                                          const range = selection.getRangeAt(0);
                                                          const span = document.createElement('span');
                                                          span.style.cssText = 'background-color: #FFD700; color: #000; padding: 2px 6px; border-radius: 4px; font-weight: bold;';
                                                          span.textContent = selection.toString() || 'NOVO';
                                                          range.deleteContents();
                                                          range.insertNode(span);
                                                          text = this.$refs.editor.innerHTML;
                                                      },
                                                      init() {
                                                          this.$refs.editor.innerHTML = text || '';
                                                          this.$watch('text', value => {
                                                              if (document.activeElement !== this.$refs.editor) {
                                                                  this.$refs.editor.innerHTML = value || '';
                                                              }
                                                          });
                                                      }
                                                  }"
                                                 wire:ignore>
                                                
                                                <!-- Toolbar -->
                                                <div class="d-flex gap-1 p-2 border-bottom bg-light rounded-top">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="exec('bold')" title="Negrito">
                                                        <i class="bi bi-type-bold"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="exec('removeFormat')" title="Limpar Formatação">
                                                        <i class="bi bi-eraser"></i>
                                                    </button>
                                                    
                                                    <div class="vr mx-1"></div>
                                                    
                                                    <!-- Color Picker -->
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            <i class="bi bi-palette"></i>
                                                        </button>
                                                        <ul class="dropdown-menu p-2" style="min-width: 150px;">
                                                            <li><h6 class="dropdown-header">Cor do Texto</h6></li>
                                                            <li><div class="d-flex gap-1 flex-wrap">
                                                                <button type="button" class="btn btn-sm rounded-circle border" style="width:24px;height:24px;bg:#D42426;" @click="exec('foreColor', '#D42426')"></button>
                                                                <button type="button" class="btn btn-sm rounded-circle border bg-primary" style="width:24px;height:24px;" @click="exec('foreColor', '#0d6efd')"></button>
                                                                <button type="button" class="btn btn-sm rounded-circle border bg-success" style="width:24px;height:24px;" @click="exec('foreColor', '#198754')"></button>
                                                                <button type="button" class="btn btn-sm rounded-circle border bg-dark" style="width:24px;height:24px;" @click="exec('foreColor', '#000000')"></button>
                                                            </div></li>
                                                        </ul>
                                                    </div>

                                                    <!-- Badge Button -->
                                                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1" @click="insertBadge()" title="Inserir Destaque (Badge)">
                                                        <i class="bi bi-patch-check-fill"></i> <span class="small d-none d-md-inline">Badge</span>
                                                    </button>
                                                </div>

                                                <!-- Editor Area -->
                                                <div x-ref="editor"
                                                     class="form-control border-0 shadow-none"
                                                     contenteditable="true"
                                                     style="min-height: 100px; max-height: 200px; overflow-y: auto;"
                                                     @input="text = $el.innerHTML"
                                                     @blur="@this.set('config_text', text)">
                                                </div>
                                            </div>
                                        </div>
        
                                        <div x-show="type === 'marketing_banner'" class="mb-3">
                                            <label class="form-label">Texto do Botão</label>
                                            <input type="text" x-model="btn_text" class="form-control" placeholder="Ex: Ver Oferta">
                                        </div>

                                    </div>
                                </div>
                            </div>
        
                            {{-- Design Tab Content --}}
                            <div x-show="activeTab === 'design'">
                                <div class="animate__animated animate__fadeIn">
                                    <div x-show="['marketing_banner', 'card.newsletter_form'].includes(type)">
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
                                                <input type="radio" class="btn-check" name="img_style" id="style_bg" value="background" x-model="image_style">
                                                <label class="btn btn-outline-secondary" for="style_bg">Fundo Cheio (Cover)</label>
                                        
                                                <input type="radio" class="btn-check" name="img_style" id="style_top" value="top" x-model="image_style">
                                                <label class="btn btn-outline-secondary" for="style_top">Topo do Card</label>
                                            </div>
                                        </div>
                                    </div>
        
                                    {{-- Colors (Synced with Alpine) --}}
                                    <div class="mb-4">
                                        <label class="form-label fw-bold d-block">Cor do Texto</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach(['text-dark', 'text-white', 'text-primary', 'text-danger', 'text-success', 'text-warning'] as $color)
                                                <button type="button" 
                                                    class="btn btn-sm rounded-circle border shadow-sm" 
                                                    :class="{ 'ring-2 ring-primary': text_color === '{{ $color }}' }"
                                                    style="width: 30px; height: 30px; background-color: var(--bs-{{ str_replace('text-', '', $color) }});"
                                                    @click="text_color = '{{ $color }}'" 
                                                    title="{{ $color }}">
                                                    <i x-show="text_color === '{{ $color }}'" class="bi bi-check text-white mix-blend-difference"></i>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
        
                                    <div class="mb-4">
                                        <label class="form-label fw-bold d-block">Cor de Fundo</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach(['bg-white', 'bg-light', 'bg-dark', 'bg-primary', 'bg-danger', 'bg-success', 'bg-warning'] as $color)
                                                <button type="button" 
                                                    class="btn btn-sm rounded-circle border shadow-sm" 
                                                    :class="{ 'ring-2 ring-primary': bg_color === '{{ $color }}' }"
                                                    style="width: 30px; height: 30px; background-color: var(--bs-{{ str_replace('bg-', '', $color) }});"
                                                    @click="bg_color = '{{ $color }}'"
                                                    title="{{ $color }}">
                                                    <i x-show="bg_color === '{{ $color }}'" class="bi bi-check {{ str_contains($color, 'dark') || str_contains($color, 'primary') || str_contains($color, 'danger') ? 'text-white' : 'text-dark' }}"></i>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                     <div class="mb-4">
                                        <label class="form-label fw-bold d-block">Cor do Botão</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach(['btn-primary', 'btn-dark', 'btn-danger', 'btn-success', 'btn-warning', 'btn-outline-dark', 'btn-outline-light'] as $color)
                                                <button type="button" 
                                                    class="btn btn-sm {{ $color }}" 
                                                    :class="{ 'border-2 border-dark': btn_color === '{{ $color }}' }"
                                                    @click="btn_color = '{{ $color }}'">
                                                    Botão
                                                    <i x-show="btn_color === '{{ $color }}'" class="bi bi-check ms-1"></i>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        {{-- Right Column: Preview --}}
                        <div class="col-lg-5 bg-light border-start p-4 d-flex flex-column align-items-center justify-content-start position-relative" style="overflow-y: auto;">
                            <div class="sticky-top w-100" style="top: 0; max-width: 300px;"> {{-- Simulate Column Width --}}
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
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative d-flex flex-column"
                                         :class="[bg_color, text_color]"
                                         style="min-height: 400px; border: 1px solid #e0e0e0;">
                                        
                                        @if($config_image || $existingImage)
                                            <!-- Background Style -->
                                            <div x-show="image_style == 'background'" 
                                                 class="position-absolute top-0 start-0 w-100 h-100" 
                                                 :style="`background-image: url('${ '{{ $config_image ? $config_image->temporaryUrl() : ($existingImage ? asset('storage/' . $existingImage) : '') }}' }'); background-size: cover; background-position: center;`">
                                                 <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.3;"></div> 
                                            </div>

                                            <!-- Top Style -->
                                            <div x-show="image_style == 'top'" class="w-100 flex-shrink-0">
                                                <img src="{{ $config_image ? $config_image->temporaryUrl() : ($existingImage ? asset('storage/' . $existingImage) : '') }}" class="w-100 object-fit-cover" style="aspect-ratio: 1/1; width: 100%; height: auto; display: block;">
                                            </div>
                                        @endif
        
                                        <div class="card-body d-flex flex-column p-3 text-start h-100 position-relative" style="z-index: 2;">
                                            <h3 class="fw-bold mb-1" :style="text_color ? '' : 'color: #1a1a1a;'" x-text="title || 'Título do Formulário'"></h3>
                                            <p class="small mb-3" :style="text_color ? '' : 'color: #1a1a1a; opacity: 0.8;'" style="line-height: 1.4;" x-text="text || 'Descrição do formulário...'"></p>
                                            
                                            <div class="d-flex flex-column gap-2 mb-3">
                                                <div>
                                                    <input type="email" class="form-control form-control-sm bg-white border-secondary-subtle" placeholder="seu@email.com" disabled>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control form-control-sm bg-white border-secondary-subtle" placeholder="Seu Nome" disabled>
                                                </div>
                                            </div>

                                            <div class="mt-auto w-100">
                                                <button class="btn btn-sm w-100 fw-bold text-uppercase" 
                                                        :class="btn_color" 
                                                        style="border-radius: 4px; padding-top: 0.4rem; padding-bottom: 0.4rem;" 
                                                        x-text="btn_text || 'ENVIAR'"></button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
        
                                {{-- Product Special Preview (Simplified) --}}
                                <template x-if="type == 'card.product_special'">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative bg-white text-center d-flex flex-column" style="min-height: 350px;">
                                         <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-start z-2">
                                            <span class="badge d-flex align-items-center gap-1 shadow-sm px-3 py-2 rounded-end-pill rounded-start-0" :class="getBadgeColor()">
                                                <i class="bi fs-6" :class="getBadgeIcon()"></i>
                                                <span class="fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;" x-text="getBadgeLabel()"></span>
                                            </span>
                                        </div>
                                        <div class="position-relative w-100" style="aspect-ratio: 1/1; background-color: #f8f9fa;">
                                            {{-- Placeholder Image --}}
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                 <div class="text-center">
                                                    <i class="bi bi-image fs-1 d-block mb-1"></i>
                                                    <small>Imagem do Produto</small>
                                                 </div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column p-3 text-start">
                                            <div class="card-title fw-bold h3 mb-1" style="color: #000000; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.6rem; line-height: 1.3;">
                                                Blusa Tradicional Em Algodão Natural Elegante – Preto Tamanho P
                                            </div>
                                            <span class="fw-bold fs-5 mb-3" style="color: #1a1a1a;">R$ 150,00</span>
                                            
                                            <div class="mt-auto w-100">
                                                <button class="btn btn-sm w-100 fw-bold text-uppercase" 
                                                        :class="badge_type == 'big_discount' ? 'btn-danger' : 'btn-dark'"
                                                        style="border-radius: 4px; padding-top: 0.4rem; padding-bottom: 0.4rem;"> 
                                                    <i class="bi bi-cart-plus me-1"></i> Adicionar
                                                </button>
                                            </div>
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
