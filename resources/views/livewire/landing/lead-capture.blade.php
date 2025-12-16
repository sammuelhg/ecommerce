<div class="py-5 bg-black-custom text-white border-top border-secondary border-opacity-10">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                @if($success)
                    <div class="p-5 border border-warning rounded bg-dark">
                        <i class="bi bi-check-circle-fill text-warning fs-1 mb-3"></i>
                        <h2 class="fw-bold mb-3">Bem-vinda ao Clube!</h2>
                        <p class="lead mb-4">
                            Seu cupom de <strong>10% OFF</strong> já está a caminho do seu e-mail.
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn btn-warning rounded-0 px-4 fw-bold">
                            Ir para a Loja
                        </a>
                    </div>
                @else
                    <span class="text-warning text-uppercase fw-bold ls-2 mb-3 d-block">Exclusive Access</span>
                    <h2 class="display-5 fw-bold mb-4">Faça parte do Clube LosFit</h2>
                    <p class="lead text-secondary mb-5 px-md-5">
                        Junte-se a nós e receba novidades exclusivas, dicas de performance e um presente especial: 
                        <strong class="text-white">10% OFF na sua primeira compra</strong>.
                    </p>

                    <form wire:submit.prevent="submit" class="p-4 p-md-5 bg-dark rounded border border-secondary border-opacity-25" style="max-width: 600px; margin: 0 auto;">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating text-dark">
                                    <input type="text" wire:model="name" class="form-control bg-light border-0" id="nameInput" placeholder="Seu Nome">
                                    <label for="nameInput">Seu Nome (Opcional)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating text-dark">
                                    <input type="email" wire:model="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" id="emailInput" placeholder="seu@email.com" required>
                                    <label for="emailInput">Seu Melhor E-mail</label>
                                </div>
                                @error('email') <span class="text-danger small text-start d-block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-uppercase ls-1">
                                    <span wire:loading.remove>Quero meu Desconto</span>
                                    <span wire:loading>Enviando...</span>
                                </button>
                            </div>
                            <div class="col-12">
                                <small class="text-secondary" style="font-size: 0.75rem;">
                                    Respeitamos sua privacidade. Zero spam.
                                </small>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
