@section('title', 'Páginas do Site')

<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Páginas</h1>
            <p class="mb-0 text-muted">Gerencie as páginas do seu site / loja.</p>
        </div>
        <a href="{{ route('admin.cms.pages.builder') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i> Nova Página
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body text-center py-5">
            <div class="mb-3">
                <i class="bi bi-layout-text-window-reverse display-1 text-gray-300"></i>
            </div>
            <h4>Nenhuma página encontrada</h4>
            <p class="text-muted mb-4">Comece criando sua primeira página personalizada.</p>
            <a href="{{ route('admin.cms.pages.builder') }}" class="btn btn-outline-primary">
                Criar Página
            </a>
        </div>
    </div>
</div>
