<div x-data="emailCardForm()">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Cards de Email</h4>
        <div>
            <a href="{{ url('/card') }}" target="_blank" class="btn btn-outline-secondary me-2">
                <i class="bi bi-eye me-2"></i>Ver Cards
            </a>
            <button wire:click="openCreateModal" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Novo Card
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Cards List -->
    <div class="d-flex flex-wrap gap-4 justify-content-center">
        @forelse($cards as $card)
        <div class="position-relative">
            <!-- Card Preview -->
            <div style="width: 340px; height: 200px; background: #fff; border-radius: 16px; border-top: 5px solid #000; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column;">
                <div style="display: flex; position: relative; flex: 1;">
                    <!-- Image Section (Left) -->
                    <div style="width: 120px; background: #f9f9f9; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($card->photo)
                            <img src="{{ asset($card->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('email-assets/logo.png') }}" style="max-width: 100px;">
                        @endif
                    </div>
                    
                    <!-- Text Section (Right) -->
                    <div style="flex: 1; padding: 12px 14px; display: flex; flex-direction: column; justify-content: center;">
                        <h5 style="font-size: 14px; font-weight: 800; text-transform: uppercase; margin: 0 0 2px 0; line-height: 1.2;">{{ $card->sender_name }}</h5>
                        <p style="font-size: 9px; color: #555; text-transform: uppercase; margin: 0 0 10px 0;">{{ $card->sender_role }}</p>
                        
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            @if($card->instagram)
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <img src="{{ asset('Instagram_logo.svg') }}" style="width: 16px; height: 16px;">
                                <span style="font-size: 11px; font-weight: 600;">{{ '@' . $card->instagram }}</span>
                            </div>
                            @endif

                            @if($card->whatsapp)
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <img src="{{ asset('WhatsApp.svg') }}" style="width: 16px; height: 16px;">
                                <span style="font-size: 11px; font-weight: 600;">{{ $card->whatsapp }}</span>
                            </div>
                            @endif
                            
                            @if($card->website)
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <img src="{{ asset('globe.svg') }}" style="width: 16px; height: 16px;">
                                <span style="font-size: 11px; font-weight: 600;">{{ $card->website }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Logo bottom right (only if has photo) -->
                    @if($card->photo)
                    <img src="{{ asset('email-assets/logo.png') }}" style="position: absolute; bottom: 10px; right: 10px; width: 52px; opacity: 0.9;">
                    @endif
                </div>
                
                <!-- Footer -->
                <div style="background: #000; color: #fff; padding: 8px; text-align: center; font-size: 11px; font-style: italic;">
                    {{ $card->slogan ?? 'Saúde • Foco • Resultado' }}
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex justify-content-center gap-2 mt-2">
                <button wire:click="openEditModal({{ $card->id }})" class="btn btn-sm btn-outline-secondary" title="Editar">
                    <i class="bi bi-pencil"></i>
                </button>
                @if(!$card->is_default)
                <button wire:click="setAsDefault({{ $card->id }})" class="btn btn-sm btn-outline-primary" title="Definir como padrão">
                    <i class="bi bi-star"></i>
                </button>
                <button wire:click="delete({{ $card->id }})" wire:confirm="Excluir este card?" class="btn btn-sm btn-outline-danger" title="Excluir">
                    <i class="bi bi-trash"></i>
                </button>
                @else
                <span class="badge bg-primary">Padrão</span>
                @endif
            </div>
        </div>
        @empty
        <div class="alert alert-info text-center w-100">
            <i class="bi bi-info-circle me-2"></i>Nenhum card cadastrado.
        </div>
        @endforelse
    </div>

    <!-- Form Modal -->
    @if($showModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editMode ? 'Editar Card' : 'Novo Card' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome *</label>
                                <input type="text" class="form-control" wire:model="sender_name" placeholder="Nome completo ou Loja X">
                                @error('sender_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Cargo / Descrição</label>
                                <input type="text" class="form-control" wire:model="sender_role" placeholder="Ex: CEO, Moda Fitness">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Foto Pessoal (3:4)</label>
                                <input type="file" class="form-control" accept="image/*" @change="handlePhotoSelect($event)">
                                
                                @if($existingPhoto)
                                <div class="mt-2 d-flex align-items-center">
                                    <img src="{{ asset($existingPhoto) }}" class="rounded me-2" width="45" height="60" style="object-fit: cover;">
                                    <button type="button" wire:click="removePhoto" class="btn btn-sm btn-outline-danger">Remover</button>
                                </div>
                                @endif

                                <template x-if="photoPreview">
                                    <div class="mt-2">
                                        <img :src="photoPreview" class="rounded" width="45" height="60" style="object-fit: cover;">
                                        <span class="text-success small ms-2">Nova foto selecionada</span>
                                    </div>
                                </template>
                                
                                <div class="form-text">Deixe vazio para usar a logo.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" wire:model="instagram" placeholder="username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text">+55</span>
                                    <input type="text" class="form-control" wire:model="whatsapp" placeholder="11999999999">
                                </div>
                                <div class="form-text">Apenas números (DDD + número)</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Website</label>
                                <input type="text" class="form-control" wire:model="website" placeholder="www.exemplo.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Slogan</label>
                                <input type="text" class="form-control" wire:model="slogan" placeholder="Frase do rodapé">
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" wire:model="is_active">
                                    <label class="form-check-label" for="is_active">Card ativo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Cropper Modal -->
    <div class="modal fade" id="photoCropperModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Recortar Foto (3:4)</h5>
                    <button type="button" class="btn-close" @click="closeCropper()"></button>
                </div>
                <div class="modal-body text-center">
                    <div style="max-height: 400px; overflow: hidden;">
                        <img id="photoToCrop" src="" style="max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeCropper()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="cropPhoto()" :disabled="isCropping">
                        <span x-show="!isCropping"><i class="bi bi-crop me-2"></i>Recortar e Usar</span>
                        <span x-show="isCropping"><i class="bi bi-hourglass-split me-2"></i>Processando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @once
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @endonce

<script>
function emailCardForm() {
    return {
        cropper: null,
        cropperModal: null,
        selectedFile: null,
        photoPreview: null,
        isCropping: false,

        handlePhotoSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            this.selectedFile = file;
            const imageUrl = URL.createObjectURL(file);
            this.openCropper(imageUrl);
        },

        openCropper(imageUrl) {
            const modalEl = document.getElementById('photoCropperModal');
            const imageElement = document.getElementById('photoToCrop');
            
            imageElement.src = imageUrl;
            
            if (!this.cropperModal) {
                this.cropperModal = new bootstrap.Modal(modalEl);
            }
            
            // Destroy existing cropper
            if (this.cropper) {
                this.cropper.destroy();
                this.cropper = null;
            }
            
            // Initialize cropper after modal is shown
            modalEl.addEventListener('shown.bs.modal', () => {
                this.cropper = new Cropper(imageElement, {
                    aspectRatio: 3/4,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    zoomable: true,
                });
            }, { once: true });
            
            // Cleanup on modal hide
            modalEl.addEventListener('hidden.bs.modal', () => {
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
                imageElement.src = '';
            }, { once: true });
            
            this.cropperModal.show();
        },

        cropPhoto() {
            if (!this.cropper) return;
            
            this.isCropping = true;
            
            const canvas = this.cropper.getCroppedCanvas({
                width: 150,
                height: 200, // 3:4 ratio
            });
            
            canvas.toBlob((blob) => {
                const croppedFile = new File([blob], this.selectedFile.name, {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });
                
                this.photoPreview = URL.createObjectURL(croppedFile);
                
                @this.upload('photo', croppedFile, () => {
                    this.cropperModal.hide();
                    this.isCropping = false;
                }, () => {
                    this.isCropping = false;
                    alert('Erro no upload da imagem.');
                });
            }, 'image/jpeg', 0.9);
        },

        closeCropper() {
            if (this.cropperModal) {
                this.cropperModal.hide();
            }
        }
    }
}
</script>
</div>
