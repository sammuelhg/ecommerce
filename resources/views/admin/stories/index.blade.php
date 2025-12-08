@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-white">Gerenciar Stories</h1>
        <button type="button" class="btn btn-warning rounded-pill" data-bs-toggle="modal" data-bs-target="#createStoryModal">
            <i class="bi bi-plus-lg me-2"></i>Novo Story
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($stories as $story)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100 bg-dark border-secondary">
                <div class="position-relative {{ !$story->is_active ? 'opacity-50' : '' }}" style="height: 480px;">
                    <img src="{{ $story->image_path }}" class="card-img-top h-100 w-100 {{ !$story->is_active ? 'grayscale' : '' }}" style="object-fit: cover;" alt="Story Image">
                    
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 end-0 p-3">
                        @if($story->is_active && $story->expires_at->isFuture())
                            <span class="badge bg-success">Ativo</span>
                        @elseif($story->is_active && $story->expires_at->isPast())
                            <span class="badge bg-warning text-dark">Expirado</span>
                        @else
                            <span class="badge bg-secondary">Inativo</span>
                        @endif
                    </div>

                    <!-- Overlay Info like Instagram -->
                    <div class="position-absolute bottom-0 start-0 check w-100 p-3 bg-gradient-to-t from-black via-black/50 to-transparent">
                        @if($story->title)
                            <h5 class="text-white mb-1 fw-bold">{{ $story->title }}</h5>
                        @endif
                        @if($story->subtitle)
                            <p class="text-white-50 mb-0 small">{{ $story->subtitle }}</p>
                        @endif
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <span class="badge bg-white text-dark">
                                <i class="bi bi-clock me-1"></i>
                                {{ $story->expires_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-secondary d-flex justify-content-between align-items-center py-3">
                    <!-- Toggle Status Form -->
                    <form action="{{ route('admin.stories.toggle', $story->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $story->is_active ? 'btn-outline-warning' : 'btn-success' }}" 
                                title="{{ $story->is_active ? 'Desativar' : 'Ativar e Renovar por 24h' }}">
                            <i class="bi {{ $story->is_active ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                        </button>
                    </form>

                    <!-- Edit Button -->
                    <button type="button" class="btn btn-sm btn-outline-info" 
                            title="Editar"
                            onclick="openEditModal({{ json_encode($story) }})">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este story?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-secondary mb-3">
                <i class="bi bi-images fs-1 opacity-50"></i>
            </div>
            <h4 class="text-white">Nenhum story ativo</h4>
            <p class="text-secondary">Clique em "Novo Story" para adicionar conteúdo.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Create Story -->
<div class="modal fade" id="createStoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Novo Story</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Imagem (Ratio 9:16 recomendado)</label>
                        <input type="file" name="image" class="form-control bg-black text-white border-secondary" required accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título (Opcional)</label>
                        <input type="text" name="title" class="form-control bg-black text-white border-secondary" placeholder="Ex: Promoção Relâmpago">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtítulo (Opcional)</label>
                        <input type="text" name="subtitle" class="form-control bg-black text-white border-secondary" placeholder="Ex: Só hoje, aproveite!">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link (CTA) (Opcional)</label>
                        <input type="text" name="link_url" class="form-control bg-black text-white border-secondary" placeholder="https://... ou #modal-about">
                    </div>
                    <div class="form-text text-secondary">
                        <i class="bi bi-info-circle me-1"></i> O story expirará automaticamente em 24 horas.
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Publicar Story</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Story -->
<div class="modal fade" id="editStoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Editar Story</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStoryForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Current Image Preview -->
                    <div class="mb-3 text-center">
                        <img id="editStoryPreview" src="" alt="Story Preview" class="img-fluid rounded" style="max-height: 200px; border: 1px solid #444;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trocar Imagem (Opcional)</label>
                        <input type="file" name="image" class="form-control bg-black text-white border-secondary" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título (Opcional)</label>
                        <input type="text" id="editStoryTitle" name="title" class="form-control bg-black text-white border-secondary">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtítulo (Opcional)</label>
                        <input type="text" id="editStorySubtitle" name="subtitle" class="form-control bg-black text-white border-secondary">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link (CTA) (Opcional)</label>
                        <input type="text" id="editStoryLink" name="link_url" class="form-control bg-black text-white border-secondary" placeholder="https://... ou #modal-about">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-dark fw-bold">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(story) {
        // Populate Form
        document.getElementById('editStoryForm').action = `/admin/stories/${story.id}`;
        document.getElementById('editStoryTitle').value = story.title || '';
        document.getElementById('editStorySubtitle').value = story.subtitle || '';
        document.getElementById('editStoryLink').value = story.link_url || '';
        document.getElementById('editStoryPreview').src = story.image_path;
        
        // Show Modal
        new bootstrap.Modal(document.getElementById('editStoryModal')).show();
    }
</script>

@endsection

@push('styles')
<style>
    .grayscale {
        filter: grayscale(100%);
    }
</style>
@endpush
