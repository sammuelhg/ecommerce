                <!-- TAB: IMAGENS -->
                <div class="row">
                    <div class="col-12">
                        <!-- Upload Area -->
                        <div class="mb-4 p-4 border border-2 border-dashed rounded text-center bg-light">
                            <i class="bi bi-cloud-upload fs-1 text-primary"></i>
                            <h5 class="mt-3">Adicionar Imagens ao Produto</h5>
                            <div class="mt-3">
                                <label for="images" class="btn btn-primary btn-lg">
                                    <i class="bi bi-plus-lg"></i> Selecionar Imagens
                                </label>
                                <input type="file" wire:model="images" id="images" style="display: none;" multiple accept="image/*">
                            </div>
                            <small class="text-muted d-block mt-3">
                                <i class="bi bi-info-circle"></i> JPG, PNG, WebP • Máximo 20MB por arquivo
                            </small>
                        </div>

                        <!-- Loading -->
                        <div wire:loading wire:target="images" class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <span>Processando imagens...</span>
                            </div>
                        </div>

                        <!-- Upload Success Message -->
                        @if (!empty($images))
                            <div class="alert alert-success">
                                <h6 class="mb-0">
                                    <i class="bi bi-check-circle"></i> 
                                    {{ is_countable($images) ? count($images) : 1 }} nova(s) imagem(ns) selecionada(s)
                                </h6>
                                <small>Clique em "Salvar Produto" para confirmar o upload</small>
                            </div>
                            
                            <!-- Preview Grid -->
                            <div class="row row-cols-3 row-cols-md-6 g-3 mb-4">
                                @foreach($images as $key => $img)
                                    <div class="col" wire:key="new-{{ $key }}">
                                        <div class="card border-success">
                                            @try
                                                <img src="{{ $img->temporaryUrl() }}" class="card-img-top" style="aspect-ratio: 1; object-fit: cover;" alt="Preview">
                                            @catch(\Exception $e)
                                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="aspect-ratio: 1;">
                                                    <i class="bi bi-image text-white fs-1"></i>
                                                </div>
                                            @endtry
                                            <div class="card-body p-1 text-center bg-success text-white">
                                                <small><i class="bi bi-check"></i> Nova</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Existing Gallery -->
                        @if($isEditing && isset($existingImages) && count($existingImages) > 0)
                            <h6 class="text-muted border-bottom pb-2 mb-3">
                                <i class="bi bi-images"></i> Galeria Atual ({{ count($existingImages) }} {{ count($existingImages) > 1 ? 'imagens' : 'imagem' }})
                            </h6>
                            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
                                @foreach($existingImages as $image)
                                    <div class="col" wire:key="existing-{{ $image->id }}">
                                        <div class="card h-100 {{ $image->is_main ? 'border-primary border-3 shadow' : 'border' }} image-card">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" style="aspect-ratio: 1; object-fit: cover;" alt="Imagem do produto">
                                                
                                                @if($image->is_main)
                                                    <span class="position-absolute top-0 start-0 m-2 badge bg-primary">
                                                        <i class="bi bi-star-fill"></i> Capa
                                                    </span>
                                                @endif
                                                
                                                <!-- Actions Overlay -->
                                                <div class="image-actions">
                                                    @if(!$image->is_main)
                                                        <button type="button" wire:click="setMainImage({{ $image->id }})" class="btn btn-sm btn-warning" title="Definir como Capa">
                                                            <i class="bi bi-star"></i>
                                                        </button>
                                                    @endif
                                                    <button type="button" wire:click="deleteImage({{ $image->id }})" wire:confirm="Tem certeza que deseja excluir esta imagem?" class="btn btn-sm btn-danger" title="Excluir">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($isEditing)
                            <div class="alert alert-secondary text-center py-5">
                                <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
                                <p class="mb-0">Nenhuma imagem na galeria. Adicione imagens usando o botão acima.</p>
                            </div>
                        @endif

                        <!-- Debug Info (remover em produção) -->
                        @if(config('app.debug'))
                            <div class="mt-3 p-2 bg-light border rounded">
                                <small class="text-muted">
                                    <strong>Debug:</strong> 
                                    Images count: {{ is_countable($images) ? count($images) : (empty($images) ? 0 : 1) }} | 
                                    Existing: {{ isset($existingImages) ? count($existingImages) : 0 }} |
                                    Library: {{ isset($mediaLibrary) ? count($mediaLibrary) : 0 }}
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

                @push('styles')
                <style>
                    .image-card {
                        transition: transform 0.2s, box-shadow 0.2s;
                    }
                    
                    .image-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    }
                    
                    .image-actions {
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        padding: 8px;
                        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
                        display: flex;
                        justify-content: center;
                        gap: 8px;
                        opacity: 1;
                    }
                    
                    @media (min-width: 768px) {
                        .image-actions {
                            opacity: 0;
                            transition: opacity 0.3s;
                        }
                        
                        .image-card:hover .image-actions {
                            opacity: 1;
                        }
                    }
                </style>
                @endpush
