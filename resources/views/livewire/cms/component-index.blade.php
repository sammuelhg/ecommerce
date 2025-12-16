@section('title', 'Meus Componentes')

<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Componentes</h1>
            <p class="mb-0 text-muted">Gerencie componentes reutilizáveis para suas páginas.</p>
        </div>
        <a href="{{ route('admin.cms.components.builder') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i> Novo Componente
        </a>
    </div>

    <div class="row g-4">
        @forelse($components as $component)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold text-primary mb-0">{{ $component->name }}</h5>
                            <span class="badge bg-light text-dark border">{{ $component->type }}</span>
                        </div>
                        <p class="text-muted small">Atualizado {{ $component->updated_at->diffForHumans() }}</p>
                        
                        <div class="d-grid">
                            <a href="{{ route('admin.cms.components.builder', ['component' => $component->id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-2"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-puzzle display-1 text-gray-300"></i>
                        </div>
                        <h4>Nenhum componente encontrado</h4>
                        <p class="text-muted mb-4">Crie componentes para reutilizar em várias páginas.</p>
                        <a href="{{ route('admin.cms.components.builder') }}" class="btn btn-outline-primary">
                            Criar Componente
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
