@section('title', 'Construtor de Páginas')

<div class="container-fluid">
    <form wire:submit.prevent="save">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">
                    @if($page) Editar Página: {{ $page->title }} @else Nova Página @endif
                </h1>
                <p class="mb-0 text-muted">Gerencie o conteúdo e a estrutura da página.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.cms.pages.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i> Salvar Página
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar: Page Settings -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Configurações da Página</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Título da Página</label>
                            <input type="text" class="form-control" wire:model.live="title" placeholder="Ex: Sobre Nós">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug (URL)</label>
                            <input type="text" class="form-control" wire:model="slug" placeholder="ex: sobre-nos">
                            @error('slug') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="isActiveSwitch" wire:model="is_active">
                            <label class="form-check-label" for="isActiveSwitch">Página Ativa</label>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-secondary">SEO & Meta Dados</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Meta Título</label>
                            <input type="text" class="form-control" wire:model="meta_title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Descrição</label>
                            <textarea class="form-control" wire:model="meta_description" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Blocks -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Conteúdo (Blocos)</h6>
                        
                        <div class="dropdown">
                            <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-plus-lg me-1"></i> Adicionar Bloco
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button type="button" class="dropdown-item" wire:click="addBlock('hero')"><i class="bi bi-image me-2"></i> Banner Hero</button></li>
                                <li><button type="button" class="dropdown-item" wire:click="addBlock('text')"><i class="bi bi-card-text me-2"></i> Texto & Conteúdo</button></li>
                                <li><button type="button" class="dropdown-item" wire:click="addBlock('faq')"><i class="bi bi-question-circle me-2"></i> FAQ</button></li>
                                <li><button type="button" class="dropdown-item" wire:click="addBlock('contact')"><i class="bi bi-envelope me-2"></i> Contato</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body bg-light p-3">
                        
                        @if(empty($blocks))
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-layout-text-window-reverse fs-1 d-block mb-3"></i>
                                <p>Nenhum bloco adicionado. Comece adicionando conteúdo à sua página.</p>
                            </div>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach($blocks as $index => $block)
                                    <div class="card border-0 shadow-sm" wire:key="block-{{ $index }}">
                                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-secondary text-uppercase" style="font-size: 0.65rem;">{{ $block['type'] }}</span>
                                                <span class="fw-bold small text-muted">Bloco #{{ $index + 1 }}</span>
                                            </div>
                                            <div>
                                                @if($index > 0)
                                                    <button type="button" class="btn btn-light btn-sm btn-xs" wire:click="updateBlockOrder([{{ $index }}, {{ $index - 1 }}])" title="Mover para Cima">
                                                        <i class="bi bi-arrow-up"></i>
                                                    </button>
                                                @endif
                                                
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-xs ms-2" wire:click="removeBlock({{ $index }})" title="Remover">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            
                                            <!-- Hero Block Fields -->
                                            @if($block['type'] === 'hero')
                                                <div class="row g-2">
                                                    <div class="col-md-12">
                                                        <label class="small text-muted">Título</label>
                                                        <input type="text" class="form-control form-control-sm" wire:model="blocks.{{ $index }}.data.title">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small text-muted">Subtítulo</label>
                                                        <input type="text" class="form-control form-control-sm" wire:model="blocks.{{ $index }}.data.subtitle">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="small text-muted">URL da Imagem</label>
                                                        <input type="text" class="form-control form-control-sm" wire:model="blocks.{{ $index }}.data.image">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="small text-muted">Alinhamento</label>
                                                        <select class="form-select form-select-sm" wire:model="blocks.{{ $index }}.data.layout">
                                                            <option value="center">Centralizado</option>
                                                            <option value="left">Esquerda</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            <!-- Text Block Fields -->
                                            @elseif($block['type'] === 'text')
                                                <div class="row g-2">
                                                    <div class="col-md-8">
                                                        <label class="small text-muted">Título (Opcional)</label>
                                                        <input type="text" class="form-control form-control-sm" wire:model="blocks.{{ $index }}.data.title">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="small text-muted">Alinhamento</label>
                                                        <select class="form-select form-select-sm" wire:model="blocks.{{ $index }}.data.alignment">
                                                            <option value="left">Esquerda</option>
                                                            <option value="center">Centralizado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small text-muted">Conteúdo HTML</label>
                                                        <textarea class="form-control form-control-sm font-monospace" rows="5" wire:model="blocks.{{ $index }}.data.content"></textarea>
                                                        <div class="form-text x-small">Aceita HTML básico.</div>
                                                    </div>
                                                </div>

                                            <!-- FAQ Block Fields -->
                                            @elseif($block['type'] === 'faq')
                                                <div class="mb-2">
                                                    <label class="small text-muted">Título da Seção</label>
                                                    <input type="text" class="form-control form-control-sm" wire:model="blocks.{{ $index }}.data.title">
                                                </div>
                                                <div class="alert alert-secondary p-2 mb-0 small">
                                                    <i class="bi bi-info-circle me-1"></i> Os itens do FAQ são gerenciados via JSON diretamente por enquanto.
                                                </div>

                                            <!-- Contact Block Fields -->
                                            @elseif($block['type'] === 'contact')
                                                <div class="row g-2">
                                                    <div class="col-md-8">
                                                        <label class="small text-muted">Email de Contato</label>
                                                        <input type="email" class="form-control form-control-sm" wire:model="blocks.{{ $index }}.data.email">
                                                    </div>
                                                    <div class="col-md-4 pt-4">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" wire:model="blocks.{{ $index }}.data.show_form">
                                                            <label class="form-check-label small">Exibir Formulário</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-muted">Arraste para reordenar (Em breve)</small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
