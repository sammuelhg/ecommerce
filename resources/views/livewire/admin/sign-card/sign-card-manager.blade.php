<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-person-badge me-2"></i>Gerenciador de Identidades (Sign Cards)</h1>
        @if(!$isEditing)
            <button wire:click="create" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Nova Identidade
            </button>
        @endif
    </div>

    @if($isEditing)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">{{ $cardId ? 'Editar Identidade' : 'Nova Identidade' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <form wire:submit.prevent="save">
                            <div class="row g-3">
                                <!-- Name & Role -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nome *</label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="Ex: Dra. Jacqueline">
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Cargo / Descrição</label>
                                    <input type="text" wire:model="role" class="form-control" placeholder="Ex: CEO - Loja losfit.com.br">
                                    @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <!-- Photo and Instagram -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Foto Pessoal (3:4)</label>
                                    <div class="d-flex gap-2 align-items-center">
                                         <input type="file" wire:model="avatar" class="form-control form-control-sm">
                                         @if($existingAvatarUrl || $avatar)
                                            <button type="button" wire:click="$set('existingAvatarUrl', null); $set('avatar', null)" class="btn btn-outline-danger btn-sm">Remover</button>
                                         @endif
                                    </div>
                                    <div class="form-text small">Deixe vazio para usar a logo.</div>
                                    @error('avatar') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">@</span>
                                        <input type="text" wire:model="instagram" class="form-control border-start-0 ps-0" placeholder="losfit1000">
                                    </div>
                                </div>
                                
                                <!-- WhastApp & Website -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">+55</span>
                                        <input type="text" wire:model="whatsapp" class="form-control" placeholder="11999999999">
                                    </div>
                                    <div class="form-text small">Apenas números (DDD + número)</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Website</label>
                                    <input type="text" wire:model="website" class="form-control" placeholder="www.losfit.com.br">
                                </div>

                                <!-- Slogan -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Slogan</label>
                                    <input type="text" wire:model="slogan" class="form-control" placeholder="Saúde • Foco • Resultado">
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-end gap-2 border-top pt-3">
                                <button type="button" wire:click="cancel" class="btn btn-secondary">Cancelar</button>
                                <button type="submit" class="btn btn-dark fw-bold">
                                    <i class="bi bi-check-lg"></i> Salvar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Live Preview -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body text-center p-4">
                                <h6 class="text-uppercase text-muted small fw-bold mb-4">Preview em Tempo Real</h6>
                                
                                <!-- Unified Component for Preview -->
                                @php
                                    $previewAvatar = null;
                                    if ($avatar) {
                                        try {
                                            $previewAvatar = $avatar->temporaryUrl();
                                        } catch (\Exception $e) {
                                            $previewAvatar = null;
                                        }
                                    } elseif ($existingAvatarUrl) {
                                        $previewAvatar = $existingAvatarUrl;
                                    }
                                @endphp

                                <x-email.digital-card 
                                    :senderName="$name ?: 'Seu Nome'"
                                    :senderRole="$role ?: 'Seu Cargo'"
                                    :photo="$previewAvatar"
                                    :instagram="$instagram"
                                    :whatsapp="$whatsapp"
                                    :website="$website"
                                    :slogan="$slogan ?: 'Seu Slogan'"
                                />
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="cards-grid">
            @forelse($cards as $card)
                <div style="margin-bottom: 2rem;">
                    <!-- Unified Component for List Item -->
                    <x-email.digital-card :card="$card" />

                    <!-- Actions outside the card -->
                    <div class="d-flex justify-content-center gap-2 mt-2">
                         <button wire:click="edit({{ $card->id }})" class="btn btn-sm btn-outline-secondary rounded-circle p-2" title="Editar" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-pencil"></i>
                        </button>
                         <button wire:confirm="Tem certeza que deseja apagar?" wire:click="delete({{ $card->id }})" class="btn btn-sm btn-outline-danger rounded-circle p-2" title="Excluir" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 w-100">
                    <p class="text-muted">Nenhum cartão cadastrado.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>

