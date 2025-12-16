@section('title', 'Construtor de Componentes')

<div>
    {{-- Top Toolbar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Editor de Componente</h1>
            <p class="mb-0 text-muted">Personalize o bloco <strong>Blog Grid</strong>.</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.components.index') }}" class="btn btn-outline-secondary me-2">
                Cancelar
            </a>
            <button wire:click="save" class="btn btn-primary">
                <i class="bi bi-save me-2"></i> Salvar Componente
            </button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Left Sidebar: Controls --}}
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Configurações</h6>
                </div>
                <div class="card-body">
                    
                    {{-- Basic Info --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nome do Componente</label>
                        <input type="text" wire:model.live="name" class="form-control">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="accordion" id="configAccordion">
                        
                        {{-- Typography Group --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#typography">
                                    Tipografia & Cores
                                </button>
                            </h2>
                            <div id="typography" class="accordion-collapse collapse show" data-bs-parent="#configAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Título</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <select wire:model.live="titleSize" class="form-select form-select-sm">
                                                    <option value="h1">H1 (Gigante)</option>
                                                    <option value="h2">H2 (Grande)</option>
                                                    <option value="h3">H3 (Médio)</option>
                                                    <option value="h4">H4 (Normal)</option>
                                                    <option value="h5">H5 (Pequeno)</option>
                                                    <option value="h6">H6 (Mínimo)</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select wire:model.live="titleColor" class="form-select form-select-sm">
                                                    <option value="text-dark">Escuro</option>
                                                    <option value="text-primary">Primário (Azul)</option>
                                                    <option value="text-danger">Vermelho</option>
                                                    <option value="text-success">Verde</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Subtítulo / Resumo</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <select wire:model.live="subtitleSize" class="form-select form-select-sm">
                                                    <option value="lead">Lead (Destaque)</option>
                                                    <option value="small">Small (Pequeno)</option>
                                                    <option value="">Normal</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select wire:model.live="subtitleColor" class="form-select form-select-sm">
                                                    <option value="text-muted">Muted (Cinza)</option>
                                                    <option value="text-dark">Escuro</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Metadata Group --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#metadata">
                                    Metadados (Autor/Data)
                                </button>
                            </h2>
                            <div id="metadata" class="accordion-collapse collapse" data-bs-parent="#configAccordion">
                                <div class="accordion-body">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" wire:model.live="showAvatar" id="showAvatar">
                                        <label class="form-check-label" for="showAvatar">Mostrar Avatar do Autor</label>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Formato da Data</label>
                                        <select wire:model.live="dateFormat" class="form-select form-select-sm">
                                            <option value="human">Relativo (ex: há 2 dias)</option>
                                            <option value="date">Absoluto (ex: 12/12/2024)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Layout Group --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#layout">
                                    Layout & Grid
                                </button>
                            </h2>
                            <div id="layout" class="accordion-collapse collapse" data-bs-parent="#configAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Colunas (Desktop)</label>
                                        <input type="range" class="form-range" min="1" max="4" step="1" wire:model.live="colsDesktop">
                                        <div class="text-center small fw-bold">{{ $colsDesktop }} Colunas</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Colunas (Mobile)</label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="colsMobile" id="mob1" value="1" wire:model.live="colsMobile">
                                            <label class="btn btn-outline-secondary btn-sm" for="mob1">1 Coluna</label>

                                            <input type="radio" class="btn-check" name="colsMobile" id="mob2" value="2" wire:model.live="colsMobile">
                                            <label class="btn btn-outline-secondary btn-sm" for="mob2">2 Colunas</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Limite de Posts</label>
                                        <input type="number" class="form-control form-control-sm" Wire:model.live="limit" min="1" max="12">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side: Live Preview --}}
        <div class="col-md-8">
            <div class="card shadow sticky-top" style="top: 20px; z-index: 100;">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-eye me-2"></i> Live Preview</h6>
                    <span class="badge bg-light text-dark border">Blog Grid Block</span>
                </div>
                <div class="card-body p-0 bg-light overflow-hidden position-relative start-0">
                    {{-- Render the Block Component --}}
                    <div class="p-3 border-bottom bg-white text-center text-muted small">
                        Visualização simulada. Os dados são reais do banco.
                    </div>
                    
                    <div style="transform: scale(0.95); transform-origin: top center;">
                       <x-blocks.blog-grid :data="$this->previewConfig" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
