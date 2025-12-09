<div class="row justify-content-center">
    @if($success)
        <div class="col-12 text-center py-5 animate__animated animate__fadeIn">
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
            </div>
            <h3 class="fw-bold mb-3">Mensagem Enviada!</h3>
            <p class="text-muted mb-4">Obrigado pelo contato. Responderemos o mais breve possível.</p>
            <button wire:click="$set('success', false)" class="btn btn-outline-dark rounded-pill px-4">
                Enviar outra mensagem
            </button>
        </div>
    @else
        <div class="col-12 col-lg-10">
            @if($errorMessage)
                <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                    <div>
                        <strong>Ops!</strong> {{ $errorMessage }}
                    </div>
                </div>
            @endif

            <p class="text-muted text-center mb-4 small">
                Preencha os dados abaixo e entraremos em contato.
            </p>

            <form wire:submit="submit">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" wire:model.blur="name" placeholder="Seu Nome">
                    <label for="name">Nome Completo</label>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" wire:model.blur="email" placeholder="nome@exemplo.com">
                            <label for="email">E-mail</label>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" wire:model.blur="phone" placeholder="(11) 99999-9999"
                                   x-mask="(99) 99999-9999">
                            <label for="phone">Telefone / WhatsApp</label>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-4">
                    <textarea class="form-control @error('message') is-invalid @enderror" 
                              id="message" wire:model.blur="message" placeholder="Sua mensagem"
                              style="height: 120px"></textarea>
                    <label for="message">Como podemos ajudar?</label>
                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-warning btn-lg fw-bold text-uppercase"
                            wire:loading.attr="disabled" wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Enviar Mensagem</span>
                        <span wire:loading wire:target="submit">
                            <span class="spinner-border spinner-border-sm me-2"></span>Enviando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
