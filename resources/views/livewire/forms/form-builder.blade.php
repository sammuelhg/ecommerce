<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-input-cursor-text me-2"></i>Gerenciador de Formulários</h1>
        @if(!$isEditing)
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Novo Formulário
            </button>
        @endif
    </div>

    @if($isEditing)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">{{ $formId ? 'Editar Formulário' : 'Novo Formulário' }}</h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Título (Interno/Externo)</label>
                            <input type="text" wire:model="title" class="form-control" placeholder="Ex: Black Friday 2024">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Slug (ID Único)</label>
                            <input type="text" wire:model="slug" class="form-control font-monospace" placeholder="ex: black_friday">
                            <div class="form-text">Use apenas letras e underline. Será usado no shortcode.</div>
                            @error('slug') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Descrição (Aparece no topo do form)</label>
                            <textarea wire:model="description" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Texto do Botão</label>
                            <input type="text" wire:model="button_text" class="form-control" placeholder="Ex: Quero meu Desconto">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Título de Sucesso</label>
                            <input type="text" wire:model="success_title" class="form-control" placeholder="Ex: Sucesso!">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Mensagem de Sucesso</label>
                            <input type="text" wire:model="success_message" class="form-control" placeholder="Ex: Cadastro realizado.">
                        </div>
                        
                        <div class="col-12">
                            <div class="p-3 bg-light border rounded">
                                <label class="form-label fw-bold text-primary mb-2">
                                    <i class="bi bi-envelope me-1"></i> Automação de Email (Opcional)
                                </label>
                                <select wire:model="campaignId" class="form-select">
                                    <option value="">-- Não enviar email --</option>
                                    @foreach($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}">
                                            {{ $campaign->name }} 
                                            ({{ $campaign->created_at->format('d/m/Y') }})
                                            @if($campaign->signCard) - [{{ $campaign->signCard->name }}] @endif
                                        </option>
                                    @endforeach
                                </select>

                                @error('campaignId') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                                <div class="form-text mt-2">
                                    <i class="bi bi-info-circle text-primary"></i> Selecione uma <strong>Campanha de Estratégia</strong> (criada no novo Campaign Builder).
                                    <br>Campanhas antigas de newsletter não aparecem aqui.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="button" wire:click="cancel" class="btn btn-outline-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-success fw-bold">
                            <i class="bi bi-check-lg"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="row g-4">
            @forelse($forms as $form)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold text-primary">{{ $form->title }}</h5>
                                <span class="badge bg-light text-dark font-monospace">{{ $form->slug ?? 'sem-slug' }}</span>
                            </div>
                            <p class="text-muted small mb-3">{{ Str::limit($form->description, 60) }}</p>
                            
                            <div class="bg-light p-2 rounded mb-3 border">
                                <small class="text-muted d-block fw-bold mb-1">Como usar:</small>
                                <code class="user-select-all" style="font-size: 0.85rem;">
                                    &lt;livewire:cms.universal-form slug="{{ $form->slug }}" /&gt;
                                </code>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-people"></i> {{ $form->leads()->count() }} Leads</small>
                                <div class="btn-group">
                                    <button wire:click="edit({{ $form->id }})" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button wire:confirm="Apagar este formulário?" wire:click="delete({{ $form->id }})" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-clipboard-x fs-1 mb-3 d-block"></i>
                        Nenhum formulário criado ainda.
                    </div>
                </div>
            @endforelse
        </div>
    @endif
</div>
```
