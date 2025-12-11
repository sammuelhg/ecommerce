<div class="d-flex flex-column h-100 bg-white">
    <!-- 1. Toolbar (Responsive) -->
    <div class="px-3 py-2 px-md-4 py-md-3 border-bottom d-flex justify-content-between align-items-center bg-white sticky-top shadow-sm" style="z-index: 1020;">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded p-2 me-2 me-md-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; width: 40px; height: 40px;">
                <i class="bi bi-palette-fill fs-6 fs-md-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold text-dark fs-6 fs-md-5">Builder</h5>
                <small class="text-muted d-none d-sm-block">Editando campanha</small>
            </div>
        </div>
        
        <!-- Desktop Toolbar -->
        <div class="d-none d-lg-flex gap-2">
            <a href="{{ route('admin.newsletter.campaigns') }}" class="btn btn-light border btn-sm d-flex align-items-center rounded-3 shadow-sm hover-shadow">
                <i class="bi bi-arrow-left me-2"></i> Voltar
            </a>
            
            <a href="{{ route('newsletter.email.preview', $activeEmailId) }}" target="_blank" class="btn btn-white border btn-sm d-flex align-items-center rounded-3 shadow-sm hover-shadow text-secondary">
                <i class="bi bi-eye me-2"></i> Web Preview
            </a>

            <button wire:click="openTemplateModal" class="btn btn-white border btn-sm d-flex align-items-center rounded-3 shadow-sm hover-shadow text-secondary">
                <i class="bi bi-download me-2"></i> Modelos
            </button>



            <button wire:click="openSettingsModal" class="btn btn-white border btn-sm d-flex align-items-center rounded-3 shadow-sm hover-shadow text-dark fw-medium">
                <i class="bi bi-sliders me-2"></i> Configurações
            </button>

            <button wire:click="save" class="btn btn-dark btn-sm d-flex align-items-center rounded-3 shadow hover-scale">
                <span wire:loading.remove wire:target="save"><i class="bi bi-check2-circle me-2"></i>Salvar</span>
                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
            </button>
        </div>

        <!-- Mobile Toolbar (Dropdown) -->
        <div class="d-flex d-lg-none gap-2">
             <button wire:click="save" class="btn btn-dark btn-sm rounded-3 shadow">
                <i class="bi bi-check2-circle"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-light border btn-sm rounded-3 shadow-sm" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                    <li><a class="dropdown-item rounded-2 mb-1" href="{{ route('admin.newsletter.campaigns') }}"><i class="bi bi-arrow-left me-2"></i> Voltar</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><button wire:click="openSettingsModal" class="dropdown-item rounded-2 mb-1"><i class="bi bi-sliders me-2"></i> Configurações</button></li>
                    <li><button wire:click="openTemplateModal" class="dropdown-item rounded-2 mb-1"><i class="bi bi-download me-2"></i> Modelos</button></li>
                    <li><a class="dropdown-item rounded-2 mb-1" href="{{ route('newsletter.email.preview', $activeEmailId) }}" target="_blank"><i class="bi bi-eye me-2"></i> Web Preview</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2. Sequence Nav (Responsive Scroll) -->
    <div class="px-3 py-2 px-md-4 py-md-3 bg-light border-bottom overflow-auto d-flex align-items-center custom-scrollbar" style="white-space: nowrap;">
        <span class="text-secondary fw-bold me-2 me-md-3 d-none d-sm-inline" style="font-size: 0.75rem; letter-spacing: 0.05em;">SEQUÊNCIA</span>
        
        <div class="d-flex align-items-center gap-2">
            @foreach($steps as $step)
                <div class="btn-group btn-group-sm shadow-sm" role="group">
                    <button wire:click="setActiveEmail({{ $step->id }})" 
                        class="btn {{ $activeEmailId === $step->id ? 'btn-primary text-white' : 'btn-white border hover-bg-light' }} d-flex align-items-center px-2 px-md-3"
                        style="transition: all 0.2s;">
                        <i class="bi bi-envelope{{ $activeEmailId === $step->id ? '-open' : '' }} me-1 me-md-2"></i> 
                        <span class="fw-medium d-none d-sm-inline">Passo {{ $loop->iteration }}</span>
                        <span class="fw-medium d-inline d-sm-none">{{ $loop->iteration }}</span>
                    </button>
                    
                    @if($loop->count > 1)
                        <button wire:click="deleteStep({{ $step->id }})" 
                            class="btn {{ $activeEmailId === $step->id ? 'btn-primary border-start border-white-50' : 'btn-white border border-start-0 text-danger' }} px-2"
                            title="Remover passo"
                            onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    @endif
                </div>
            @endforeach
            
            <button wire:click="addStep" class="btn btn-sm btn-light border border-dashed text-muted px-3 hover-shadow" title="Adicionar Novo Passo">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>

    <!-- 3. Workspace (Subject + Main Content) -->
    <div class="flex-grow-1 overflow-auto custom-scrollbar p-3 p-md-5 bg-secondary-subtle">
        <div class="container-fluid p-0" style="max-width: 1400px;">
            
            <!-- Header: Subject & Toggles -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div class="input-group input-group-lg shadow-sm w-100 w-md-50">
                    <span class="input-group-text bg-white border-0 text-muted ps-3"><i class="bi bi-chat-quote"></i></span>
                    <input wire:model.live.debounce.500ms="subject" type="text" class="form-control border-0 ps-2 text-dark fw-bold" placeholder="Assunto do Email...">
                </div>

                <div class="bg-white p-1 rounded-pill shadow-sm d-flex align-self-center align-self-md-auto">
                     <button wire:click="setViewMode('preview')" class="btn btn-sm rounded-pill px-3 fw-bold {{ $viewMode === 'preview' ? 'btn-dark' : 'btn-white text-muted' }}" title="Mobile">
                        <i class="bi bi-phone me-1 me-md-2"></i> <span class="d-none d-md-inline">Mobile</span>
                    </button>
                    <button wire:click="setViewMode('desktop')" class="btn btn-sm rounded-pill px-3 fw-bold {{ $viewMode === 'desktop' ? 'btn-dark' : 'btn-white text-muted' }}" title="Desktop">
                        <i class="bi bi-display me-1 me-md-2"></i> <span class="d-none d-md-inline">Desktop</span>
                    </button>
                    <button wire:click="setViewMode('code')" class="btn btn-sm rounded-pill px-3 fw-bold {{ $viewMode === 'code' ? 'btn-dark' : 'btn-white text-muted' }}" title="Código HTML">
                        <i class="bi bi-code-slash me-1 me-md-2"></i> <span class="d-none d-md-inline">Code</span>
                    </button>
                </div>
            </div>

            <!-- View Area -->
            <div class="row justify-content-center">
                
                <!-- MOBILE PREVIEW MODE -->
                @if($viewMode === 'preview')
                    <div class="col-auto fade-in-up w-100 d-flex justify-content-center">
                        <!-- Use responsive scaling for small screens -->
                        <div class="position-relative bg-white shadow-lg d-none d-sm-block" 
                            style="width: 375px; height: 812px; border-radius: 40px; border: 12px solid #2d3748; overflow: hidden; transform: scale(0.95); transform-origin: top center;">
                            
                            <!-- Notch / Camera -->
                            <div class="position-absolute top-0 start-50 translate-middle-x bg-dark rounded-bottom-4 shadow-sm" style="width: 150px; height: 25px; z-index: 10;"></div>
                            
                            <!-- Status Bar Mock -->
                            <div class="d-flex justify-content-between align-items-center px-4 pt-2 pb-1 text-dark bg-white border-bottom border-light" style="font-size: 12px; font-weight: 600;">
                                <span>9:41</span>
                                <div class="d-flex gap-2">
                                    <i class="bi bi-Reception-4"></i><i class="bi bi-wifi"></i><i class="bi bi-battery-full"></i>
                                </div>
                            </div>
                            
                            <!-- Email Content -->
                            <div class="w-100 h-100 overflow-y-auto custom-scrollbar bg-white" style="padding-bottom: 80px;">
                                @if($previewHtml)
                                    <div class="fade-in">{!! $previewHtml !!}</div>
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted p-4 text-center">
                                        <div class="bg-light rounded-circle p-4 mb-3"><i class="bi bi-palette fs-1 text-secondary"></i></div>
                                        <h6 class="fw-bold text-dark">Área de Visualização</h6>
                                        <p class="small mb-0">Edite o código para ver o resultado aqui.</p>
                                    </div>
                                @endif
                            </div>
                            <!-- Home Indicator -->
                            <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 bg-dark rounded-pill" style="width: 120px; height: 4px; opacity: 0.2;"></div>
                        </div>

                        <!-- Full Width Mobile Version for tiny screens (editing on mobile) -->
                        <div class="d-block d-sm-none w-100 bg-white shadow-sm border rounded-3 overflow-hidden" style="height: 70vh;">
                             <div class="d-flex justify-content-between align-items-center px-3 py-2 text-dark bg-white border-bottom border-light semi-bold small">
                                <span>Mobile Preview</span>
                            </div>
                             <div class="w-100 h-100 overflow-y-auto custom-scrollbar bg-white">
                                  @if($previewHtml)
                                    <div class="fade-in">{!! $previewHtml !!}</div>
                                @else
                                    <div class="p-4 text-center text-muted">Preview load...</div>
                                @endif
                             </div>
                        </div>
                    </div>
                @endif

                <!-- DESKTOP PREVIEW MODE -->
                @if($viewMode === 'desktop')
                    <div class="col-12 fade-in-up">
                        <div class="bg-white shadow-sm mx-auto overflow-hidden border rounded-3" style="max-width: 1000px; height: 800px;">
                             <!-- Browser Header Mock -->
                             <div class="bg-light border-bottom px-3 py-2 d-flex align-items-center gap-2">
                                 <div class="d-flex gap-1 me-2">
                                     <div class="rounded-circle bg-danger" style="width: 10px; height: 10px;"></div>
                                     <div class="rounded-circle bg-warning" style="width: 10px; height: 10px;"></div>
                                     <div class="rounded-circle bg-success" style="width: 10px; height: 10px;"></div>
                                 </div>
                                 <div class="bg-white border rounded px-3 py-1 text-muted small flex-grow-1 text-center">
                                     <i class="bi bi-lock-fill me-1"></i> secure-mail-client.com
                                 </div>
                             </div>
                             
                             <!-- Body -->
                             <div class="w-100 h-100 overflow-y-auto custom-scrollbar bg-secondary-subtle p-4">
                                @if($previewHtml)
                                    <div class="fade-in bg-white shadow-sm mx-auto" style="max-width: 600px; min-height: 100%;">
                                        {!! $previewHtml !!}
                                    </div>
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted p-4 text-center">
                                        <div class="bg-light rounded-circle p-4 mb-3"><i class="bi bi-palette fs-1 text-secondary"></i></div>
                                        <h6 class="fw-bold text-dark">Desktop Preview</h6>
                                    </div>
                                @endif
                             </div>
                        </div>
                    </div>
                @endif

                <!-- CODE MODE -->
                @if($viewMode === 'code')
                    <div class="col-md-10 fade-in">
                        <div class="card border-0 shadow-lg h-100">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-2">
                                <span class="small font-monospace"><i class="bi bi-code-square me-2"></i>HTML Source Editor</span>
                                <small class="text-white-50">Variáveis: <code>@{{ $user->name }}</code></small>
                            </div>
                            <div class="card-body p-0">
                                <textarea wire:model.live.debounce.1000ms="body" 
                                    class="form-control border-0 font-monospace p-4 text-secondary bg-light" 
                                    style="min-height: 600px; font-size: 0.9rem; line-height: 1.6; resize: none;"
                                    placeholder="<h1>Seu código HTML aqui...</h1>"></textarea>
                            </div>
                            <div class="card-footer bg-white border-top small text-muted">
                                <i class="bi bi-info-circle me-1"></i> Alterações são salvas automaticamente no preview. O layout global (Logo, Rodapé) é aplicado automaticamente.
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>


    <!-- 4. Settings Modal -->
    @if($showSettingsModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Configurações do Passo</h5>
                    <button wire:click="closeSettingsModal" type="button" class="btn-close"></button>
                </div>
                <div class="modal-body pt-3 pb-4">
                    
                    <!-- Delay -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Envio</label>
                        <div class="bg-light p-3 rounded-3 border">
                            <label class="form-label small fw-bold mb-1">Atraso (Horas)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-hourglass-split"></i></span>
                                <input wire:model.live="delay" type="number" min="0" class="form-control border-start-0" placeholder="0">
                                <span class="input-group-text bg-white">h</span>
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">0 = Envio imediato após passo anterior.</small>
                        </div>
                    </div>

                    <!-- Signature -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Identidade</label>
                        <div class="bg-light p-3 rounded-3 border">
                            <label class="form-label small fw-bold mb-1">Cartão de Assinatura</label>
                            <select wire:model.live="selectedCard" class="form-select shadow-sm">
                                <option value="">Padrão (LosFit Team)</option>
                                @foreach($this->emailCards as $card)
                                    <option value="{{ $card->id }}">{{ $card->sender_name }} ({{ $card->sender_role }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Produtos</label>
                        <div class="bg-light p-3 rounded-3 border">
                            @if(count($selectedProducts) > 0)
                                <div class="d-flex flex-column gap-2 mb-3">
                                    @foreach($selectedProducts as $prodId)
                                        @php $prod = \App\Models\Product::find($prodId); @endphp
                                        @if($prod)
                                            <div class="d-flex align-items-center bg-white p-2 rounded border shadow-sm">
                                                <img src="{{ $prod->image_url }}" class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                                <div class="flex-grow-1 lh-1">
                                                    <div class="small fw-bold text-truncate" style="max-width: 150px;">{{ $prod->name }}</div>
                                                </div>
                                                <button wire:click="toggleProduct({{ $prod->id }})" class="btn btn-link text-danger p-0 ms-2">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            <button wire:click="openProductModal" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-plus-lg me-1"></i> Selecionar Produtos
                            </button>
                        </div>
                    </div>

                    <!-- Promo Image -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Capa (Grid)</label>
                        <div class="bg-light p-3 rounded-3 border">
                            <div class="mb-3">
                                <input wire:model="promoImage" type="file" class="form-control form-control-sm">
                                @if($promoImageUrl && !$promoImage)
                                    <div class="mt-2 text-center bg-white p-2 rounded border">
                                        <img src="{{ $promoImageUrl }}" class="img-fluid rounded" style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                            <div class="form-check form-switch">
                                <input wire:model="showPromoImageInEmail" class="form-check-input" type="checkbox" id="showPromoImageConfig">
                                <label class="form-check-label small" for="showPromoImageConfig">Mostrar no Email</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button wire:click="closeSettingsModal" type="button" class="btn btn-dark w-100 rounded-3">Concluído</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Product Picker Modal -->
    @if($showProductModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5); z-index: 1060;" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Selecionar Produtos</h5>
                    <button wire:click="closeProductModal" type="button" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input wire:model.live.debounce.300ms="productSearch" type="text" class="form-control border-start-0" placeholder="Buscar produto...">
                    </div>

                    <div class="list-group list-group-flush custom-scrollbar" style="max-height: 400px; overflow-y: auto;">
                        @forelse($this->availableProducts as $product)
                            <button wire:click="toggleProduct({{ $product->id }})" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $product->image_url }}" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold mb-0">{{ $product->name }}</div>
                                        <small class="text-muted">R$ {{ number_format($product->price, 2, ',', '.') }}</small>
                                    </div>
                                </div>
                                <div>
                                    @if(in_array($product->id, $selectedProducts))
                                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                    @else
                                        <i class="bi bi-circle text-muted fs-4"></i>
                                    @endif
                                </div>
                            </button>
                        @empty
                            <div class="text-center py-4 text-muted">
                                Nenhum produto encontrado.
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button wire:click="closeProductModal" type="button" class="btn btn-dark">Concluído</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Template Import Modal -->
    @if($showTemplateModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5); z-index: 1060;" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Importar Modelo</h5>
                    <button wire:click="closeTemplateModal" type="button" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input wire:model.live.debounce.300ms="templateSearch" type="text" class="form-control border-start-0" placeholder="Buscar modelo...">
                    </div>

                    <div class="list-group list-group-flush custom-scrollbar" style="max-height: 400px; overflow-y: auto;">
                        @forelse($this->templates as $template)
                            <button wire:click="importTemplate({{ $template->id }})" class="list-group-item list-group-item-action" onclick="return confirm('Isso substituirá o conteúdo atual. Continuar?') || event.stopImmediatePropagation()">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">{{ $template->name }}</div>
                                        <small class="text-muted">{{ $template->subject }}</small>
                                    </div>
                                    <span class="badge bg-light text-secondary">{{ $template->category }}</span>
                                </div>
                            </button>
                        @empty
                            <div class="text-center py-4 text-muted">
                                Nenhum modelo encontrado.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.1);
        border-radius: 20px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
    }

    /* Animations */
    .fade-in {
        animation: fadeIn 0.4s ease-in-out;
    }
    .fade-in-up {
        animation: fadeInUp 0.4s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Utility */
    .hover-scale:hover {
        transform: scale(1.02);
        transition: transform 0.2s;
    }
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: box-shadow 0.2s;
    }
    .bg-secondary-subtle {
        background-color: #f3f4f6 !important;
    }
    input::placeholder, textarea::placeholder {
        color: #adb5bd !important;
        font-weight: 300;
    }
    </style>
</div>
