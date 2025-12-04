<div class="container py-4">
    <div class="row">
        <!-- Sidebar Navigation -->
        <x-account-sidebar />

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i> Editar Perfil</h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="save" x-data="profileForm()">
                        <div class="row g-4">
                            <!-- Avatar Upload Section -->
                            <div class="col-12 d-flex align-items-center mb-2">
                                <div class="position-relative me-4">
                                    <img :src="avatarPreview || '{{ $currentAvatar }}'"
                                         class="rounded-circle img-thumbnail" width="100" height="100" alt="Avatar"
                                         style="object-fit: cover;">
                                    <label class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1 cursor-pointer shadow-sm" 
                                           style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <i class="bi bi-camera-fill small"></i>
                                        <input type="file" wire:model="avatar" accept="image/*" class="d-none"
                                               @change="handleAvatar($event)">
                                    </label>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Foto de Perfil</h6>
                                    <p class="text-muted small mb-0">Formatos: JPG, PNG. Max: 2MB</p>
                                    <div wire:loading wire:target="avatar" class="text-primary small mt-1">Carregando...</div>
                                    @error('avatar') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nome Completo</label>
                                <input type="text" wire:model.live="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">E-mail</label>
                                <input type="email" wire:model.live="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Telefone</label>
                                <input type="text" x-mask="(99) 99999-9999" wire:model.live="phone"
                                       class="form-control @error('phone') is-invalid @enderror" placeholder="(99) 99999-9999">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">CPF</label>
                                <input type="text" x-mask="999.999.999-99" wire:model.live="taxvat"
                                       class="form-control @error('taxvat') is-invalid @enderror" placeholder="000.000.000-00">
                                @error('taxvat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <h6 class="fw-bold border-bottom pb-2 mb-3">Alterar Senha</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nova Senha</label>
                                <div class="input-group">
                                    <input :type="showPass ? 'text' : 'password'" wire:model="password" class="form-control @error('password') is-invalid @enderror">
                                    <button type="button" class="btn btn-outline-secondary" @click="showPass = !showPass">
                                        <i :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <small class="text-muted">Deixe em branco para manter a atual.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Confirmar Senha</label>
                                <input type="password" wire:model="password_confirmation" class="form-control">
                            </div>

                            <div class="col-12 mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4 fw-bold" wire:loading.attr="disabled">
                                    <span wire:loading.remove>SALVAR ALTERAÇÕES</span>
                                    <span wire:loading>SALVANDO...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function profileForm() {
    return {
        avatarPreview: null,
        showPass: false,

        handleAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                this.avatarPreview = URL.createObjectURL(file);
            }
        }
    }
}

// Toast global (SweetAlert2)
document.addEventListener('livewire:init', () => {
    Livewire.on('toast', (data) => {
        // Handle array or object
        const toastData = Array.isArray(data) ? data[0] : data;
        
        Swal.fire({
            icon: toastData.icon || 'success',
            title: toastData.title,
            text: toastData.text,
            timer: 3000,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
        });
    });
});
</script>
