<div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Configurações da Página -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <i class="bi bi-gear me-2"></i>Configurações da Página
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Título Principal</label>
                    <input type="text" class="form-control" wire:model.defer="pageTitle">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Subtítulo</label>
                    <input type="text" class="form-control" wire:model.defer="pageSubtitle">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button wire:click="savePageSettings" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i>Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Links -->
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span><i class="bi bi-link-45deg me-2"></i>Links Cadastrados</span>
            <div>
                <a href="{{ route('links') }}" target="_blank" class="btn btn-sm btn-outline-light me-2">
                    <i class="bi bi-eye me-1"></i>Ver Página
                </a>
                <button wire:click="openCreateModal" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-lg me-1"></i>Novo Link
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="80">Ordem</th>
                        <th width="50">Ícone</th>
                        <th>Título</th>
                        <th>URL</th>
                        <th width="100">Cor</th>
                        <th width="80">Status</th>
                        <th width="100">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($links as $link)
                    <tr>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button wire:click="moveUp({{ $link->id }})" class="btn btn-outline-secondary" {{ $loop->first ? 'disabled' : '' }}>
                                    <i class="bi bi-chevron-up"></i>
                                </button>
                                <button wire:click="moveDown({{ $link->id }})" class="btn btn-outline-secondary" {{ $loop->last ? 'disabled' : '' }}>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            @if($link->icon)
                                <span class="fs-5">{!! $link->icon !!}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $link->title }}</td>
                        <td>
                            <a href="{{ $link->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;">
                                {{ $link->url }}
                            </a>
                        </td>
                        <td>
                            <span class="badge" style="{{ $link->color_style }} border: 1px solid #333;">
                                {{ $colorOptions[$link->color]['label'] ?? $link->color }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $link->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $link->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td>
                            <button wire:click="openEditModal({{ $link->id }})" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button wire:click="delete({{ $link->id }})" wire:confirm="Excluir?" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Nenhum link cadastrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="modal-backdrop fade show"></div>
    <div class="modal fade show d-block" tabindex="-1" x-data="{
        formTitle: @js($title),
        formUrl: @js($url),
        formIcon: @js($icon),
        formColor: @js($color),
        formActive: @js($is_active)
    }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editMode ? 'Editar Link' : 'Novo Link' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <!-- Título -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título *</label>
                        <input type="text" class="form-control" x-model="formTitle">
                    </div>
                    
                    <!-- URL -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">URL *</label>
                        <input type="text" class="form-control" x-model="formUrl">
                    </div>
                    
                    <!-- Ícone -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ícone</label>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @foreach($iconOptions as $iconName => $iconLabel)
                            <button type="button" 
                                @click="formIcon = '<i class=\'bi bi-{{ $iconName }}\'></i>'"
                                :class="formIcon === '<i class=\'bi bi-{{ $iconName }}\'></i>' ? 'btn-primary' : 'btn-outline-secondary'"
                                class="btn btn-sm" title="{{ $iconLabel }}">
                                <i class="bi bi-{{ $iconName }}"></i>
                            </button>
                            @endforeach
                            <button type="button" @click="formIcon = ''" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control form-control-sm" x-model="formIcon" placeholder="Ou cole o código do ícone">
                        <div class="mt-1" x-show="formIcon">
                            <small class="text-muted">Preview:</small> <span class="fs-4" x-html="formIcon"></span>
                        </div>
                    </div>
                    
                    <!-- Cor -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cor do Botão</label>
                        <div class="d-flex flex-wrap gap-2 mb-1">
                            @foreach($colorOptions as $key => $option)
                            <button type="button" 
                                @click="formColor = '{{ $key }}'"
                                class="rounded-circle p-0" 
                                :style="'width: 36px; height: 36px; {{ $option['style'] }} border: 3px solid ' + (formColor === '{{ $key }}' ? '#0d6efd' : '#ccc')"
                                title="{{ $option['label'] }}">
                            </button>
                            @endforeach
                        </div>
                        <small class="text-muted">
                            @foreach($colorOptions as $key => $option)
                            <span x-show="formColor === '{{ $key }}'">{{ $option['label'] }}</span>
                            @endforeach
                        </small>
                    </div>
                    
                    <!-- Ativo -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formActive" x-model="formActive">
                        <label class="form-check-label" for="formActive">Link ativo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancelar</button>
                    <button type="button" class="btn btn-primary" 
                        @click="$wire.set('title', formTitle); $wire.set('url', formUrl); $wire.set('icon', formIcon); $wire.set('color', formColor); $wire.set('is_active', formActive); $wire.save();">
                        <i class="bi bi-check-lg me-1"></i>Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
