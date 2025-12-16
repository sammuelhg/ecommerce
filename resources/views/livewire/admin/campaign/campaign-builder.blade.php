<div class="container-fluid py-4"
     x-data="{
         currentStep: @entangle('currentStep'),

         initEditor() {
             // Basic ContentEditable sync could go here if using a library like CKEditor
         }
     }"
>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Campaign Builder</h1>
            <p class="text-muted small">Crie sua estratégia em 5 passos simples.</p>
        </div>
        <div>
            @if($this->campaign && $this->campaign->exists)
                <a href="{{ route('newsletter.show', $this->campaign->id) }}" target="_blank" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-eye me-2"></i>Visualizar
                </a>
            @endif
            <button wire:click="save" class="btn btn-primary" wire:loading.attr="disabled">
                <i class="bi bi-save me-2"></i>Salvar Campanha
            </button>
        </div>
    </div>

    <!-- Wizard Progress -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between text-center">
                @foreach(['Gatilho', 'Vitrine', 'Conteúdo', 'Card', 'Revisão'] as $index => $label)
                    @php $step = $index + 1; @endphp
                    <div class="flex-fill p-3 border-bottom {{ $currentStep == $step ? 'border-primary border-3 bg-primary-subtle' : ($currentStep > $step ? 'text-success' : 'text-muted') }}"
                         style="cursor: pointer;"
                         wire:click="setStep({{ $step }})">
                        <div class="fw-bold mb-1">Passo {{ $step }}</div>
                        <div class="small">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="min-height: 500px;">
                <div class="card-body p-4">

                    <!-- STEP 1: TRIGGER (Forms) -->
                    <div x-show="currentStep === 1">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="fw-bold mb-0">1. Gatilho da Campanha</h5>
                                <p class="text-muted mb-0">Esta campanha será disparada quando um lead converter nestes formulários.</p>
                            </div>
                            <a href="{{ route('admin.crm.forms.builder') }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Novo Formulário">
                                <i class="bi bi-plus-lg"></i> Novo Formulário
                            </a>
                        </div>
                        
                        <div class="row g-3">
                            @foreach($this->availableForms as $form)
                                <div class="col-md-6" wire:key="form-{{ $form->id }}">
                                    <div class="card h-100 border hover-shadow {{ in_array($form->id, $form_ids) ? 'border-primary bg-primary-subtle' : '' }}" 
                                         style="cursor: pointer; transition: all 0.2s;"
                                         wire:click="toggleForm({{ $form->id }})">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                 <div class="rounded-circle d-flex align-items-center justify-content-center {{ in_array($form->id, $form_ids) ? 'bg-primary text-white' : 'bg-light text-muted' }}" 
                                                      style="width: 40px; height: 40px;">
                                                     <i class="bi bi-ui-checks"></i>
                                                 </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 fw-bold {{ in_array($form->id, $form_ids) ? 'text-primary' : 'text-dark' }}">
                                                    {{ $form->title }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $form->settings['description'] ?? 'Sem descrição' }}
                                                </small>
                                            </div>
                                            @if(in_array($form->id, $form_ids))
                                                <div class="ms-2">
                                                    <i class="bi bi-check-circle-fill text-primary fs-5"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                             @if($this->availableForms->isEmpty())
                                <div class="col-12">
                                    <div class="text-center py-5 bg-light rounded border border-dashed">
                                        <i class="bi bi-clipboard-x fs-1 text-muted mb-3"></i>
                                        <h6>Nenhum formulário encontrado</h6>
                                        <p class="text-muted small mb-3">Crie um formulário para começar a capturar leads.</p>
                                        <a href="{{ route('admin.crm.forms.builder') }}" target="_blank" class="btn btn-primary btn-sm">Criar Formulário</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('form_ids') <div class="text-danger mt-3">{{ $message }}</div> @enderror
                    </div>

                    <!-- STEP 2: VITRINE (Products) -->
                    <div x-show="currentStep === 2">
                        <h5 class="fw-bold mb-4">2. Vitrine de Produtos</h5>
                        <p class="text-muted mb-4">Quais produtos você quer destacar nesta campanha?</p>
                        
                        <div class="bg-light p-3 rounded mb-4">
                            <div class="input-group">
                                <span class="input-group-text border-0"><i class="bi bi-search"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="productSearch" class="form-control border-0" placeholder="Buscar produtos...">
                            </div>
                        </div>

                        <!-- Available Products -->
                        <div class="row g-2 mb-4">
                            @foreach($this->availableProducts as $product)
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center p-2 border rounded bg-white hover-bg-light" style="cursor: pointer;"
                                         wire:click="toggleProduct({{ $product->id }})">
                                        
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" 
                                                   @if(in_array($product->id, $product_ids)) checked @endif 
                                                   style="pointer-events: none;">
                                        </div>

                                        <img src="{{ $product->image_url ?? asset('email-assets/logo.png') }}" class="rounded me-3 border" width="40" height="40" style="object-fit: contain; background: #fff;">
                                        
                                        <div class="flex-grow-1">
                                            <div class="fw-bold text-dark">{{ $product->name }}</div>
                                            <small class="text-muted">R$ {{ number_format($product->price ?? 0, 2, ',', '.') }}</small>
                                        </div>
                                        
                                        @if(in_array($product->id, $product_ids))
                                            <span class="badge bg-primary">Selecionado</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('product_ids') <div class="text-danger mt-3">{{ $message }}</div> @enderror
                    </div>

                    <!-- STEP 3: CONTENT (Email Sequence) -->
                    <div x-show="currentStep === 3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="fw-bold mb-0">3. Sequência de Emails</h5>
                                <p class="text-muted mb-0">Defina os emails que serão enviados nesta campanha.</p>
                            </div>
                            <button type="button" class="btn btn-dark" wire:click="addEmail">
                                <i class="bi bi-plus-lg me-1"></i> Adicionar Email
                            </button>
                        </div>
                        
                        <div class="d-flex flex-column gap-4">
                            @foreach($emails as $index => $email)
                                <div class="card shadow-sm border" wire:key="email-block-{{ $index }}">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-secondary rounded-pill">{{ $index + 1 }}</span>
                                            <span class="fw-bold">
                                                @if($index === 0)
                                                    Email Principal (Envio Imediato)
                                                @else
                                                    Email de Follow-up
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-2">
                                            @if($index > 0)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        wire:click="removeEmail({{ $index }})" 
                                                        wire:confirm="Tem certeza que deseja remover este email?">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <!-- Configuration Row -->
                                        <div class="row g-3 mb-3">
                                            <!-- Delay Config (Only for follow-ups) -->
                                            @if($index > 0)
                                                <div class="col-md-3">
                                                    <label class="form-label small fw-bold text-muted">Atraso (Horas)</label>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                                        <input type="number" wire:model="emails.{{ $index }}.delay_hours" class="form-control" min="1">
                                                    </div>
                                                    <div class="form-text" style="font-size: 11px;">Após o anterior</div>
                                                </div>
                                            @endif

                                            <!-- Template Selector -->
                                            <div class="col-md-{{ $index > 0 ? '9' : '12' }}">
                                                <label class="form-label small fw-bold text-muted">Carregar Modelo</label>
                                                <select class="form-select form-select-sm" wire:change="applyTemplate({{ $index }}, $event.target.value)">
                                                    <option value="">Selecione um modelo para preencher...</option>
                                                    @foreach($this->templates as $tpl)
                                                        <option value="{{ $tpl->id }}">{{ $tpl->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Content Fields -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Assunto</label>
                                            <input type="text" wire:model="emails.{{ $index }}.subject" class="form-control" placeholder="Assunto do email...">
                                            @error("emails.{$index}.subject") <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="form-label fw-bold">Conteúdo</label>
                                            <textarea wire:model="emails.{{ $index }}.body" class="form-control font-monospace" rows="8" placeholder="Olá {name}..."></textarea>
                                            <div class="d-flex justify-content-between mt-1">
                                                <div class="form-text">Variáveis: <code>{name}</code>, <code>{email}</code></div>
                                                @error("emails.{$index}.body") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-center">
                            <button type="button" class="btn btn-outline-dark border-dashed w-100 py-2" wire:click="addEmail">
                                <i class="bi bi-plus-circle me-2"></i>Adicionar mais um email à sequência
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: SELECT CARD (SignCard) -->
                    <div x-show="currentStep === 4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="fw-bold mb-0">4. Definir Remetente</h5>
                                <p class="text-muted mb-0">Escolha o cartão de visita digital que assinará os emails desta campanha.</p>
                            </div>
                             <a href="{{ route('admin.sign-cards') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-person-badge me-1"></i>Gerenciar Cards
                            </a>
                        </div>
                        
                        <div class="row g-4">
                            @foreach($this->availableSignCards as $card)
                                <div class="col-md-6 col-lg-6" wire:key="card-{{ $card->id }}">
                                    <div class="position-relative {{ $sign_card_id === $card->id ? 'ring-2 ring-primary offset-2 rounded' : '' }}" 
                                         style="cursor: pointer; {{ $sign_card_id === $card->id ? 'border: 3px solid #0d6efd; border-radius: 8px; padding: 4px;' : 'border: 3px solid transparent; padding: 4px;' }} transition: all 0.2s;"
                                         wire:click="selectSignCard({{ $card->id }})">
                                        
                                        <!-- Standard Component Usage -->
                                        <x-email.digital-card :card="$card" />

                                        @if($sign_card_id === $card->id)
                                            <div class="position-absolute top-0 end-0 m-2 badge bg-primary rounded-circle p-2 shadow">
                                                <i class="bi bi-check-lg fs-5"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            @if($this->availableSignCards->isEmpty())
                                <div class="col-12">
                                    <div class="text-center py-5 bg-light rounded border border-dashed">
                                        <i class="bi bi-person-badge-fill fs-1 text-muted mb-3"></i>
                                        <h6>Nenhum Card Encontrado</h6>
                                        <p class="text-muted small mb-3">Você precisa criar um cartão de assinatura primeiro.</p>
                                        <a href="{{ route('admin.sign-cards') }}" class="btn btn-primary btn-sm">Criar Card</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('sign_card_id') <div class="text-danger mt-3 text-center fw-bold">{{ $message }}</div> @enderror
                    </div>

                    <!-- STEP 5: REVIEW -->
                    <div x-show="currentStep === 5">
                        <h5 class="fw-bold mb-4">5. Revisão & Salvar</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nome da Campanha (Interno)</label>
                            <input type="text" wire:model="name" class="form-control form-control-lg" placeholder="Ex: Campanha Black Friday 2025">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <strong>Gatilho (Forms):</strong> 
                                        @php 
                                            $forms = \App\Models\Form::whereIn('id', $form_ids)->pluck('title')->implode(', ');
                                        @endphp
                                        {{ $forms ?: 'Nenhum selecionado' }}
                                    </li>
                                    <li class="mb-2">
                                        <strong>Produtos:</strong> 
                                        <span class="badge bg-secondary">{{ count($product_ids) }} selecionados</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Remetente (Card):</strong> 
                                        {{ $this->selectedSignCard?->name ?? 'Não selecionado' }}
                                        <small class="text-muted">({{ $this->selectedSignCard?->role }})</small>
                                    </li>
                                    <li>
                                        <strong>Emails na Sequência:</strong> 
                                        <span class="badge bg-info text-dark">{{ count($emails) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer Navigation -->
                <div class="card-footer bg-white border-top p-4 d-flex justify-content-between">
                    <button wire:click="prevStep" class="btn btn-outline-secondary" {{ $currentStep === 1 ? 'disabled' : '' }}>
                        <i class="bi bi-arrow-left me-2"></i>Voltar
                    </button>
                    
                    @if($currentStep < 5)
                        <button wire:click="nextStep" class="btn btn-dark">
                            Próximo<i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    @else
                        <button wire:click="save" class="btn btn-success">
                            <i class="bi bi-check-lg me-2"></i>Finalizar e Salvar
                        </button>
                    @endif
                </div>
            </div>
            <!-- Error Display -->
            @error('general_save_error')
                <div class="alert alert-danger mt-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="col-lg-4" x-show="currentStep === 5">
    </div>
</div>
