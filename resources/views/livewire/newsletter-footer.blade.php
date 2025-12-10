<div class="w-100" style="max-width: 400px;">
    <h5 class="text-dark mb-3 fw-bold">📧 Newsletter</h5>
    <p class="text-dark small mb-3">Receba ofertas exclusivas e ganhe <strong class="text-danger fw-bold">15% OFF</strong> na primeira compra!</p>
    
    @if($success)
        <div class="alert alert-success small mb-0">
            {{ session('message') }}
        </div>
    @else
        <form class="d-flex" wire:submit.prevent="subscribe">
            <input type="email" wire:model="email" class="form-control bg-white border border-secondary" placeholder="seu@email.com" required>
            <button class="btn btn-danger text-white fw-bold px-4 ms-2" type="submit">
                Inscrever
            </button>
        </form>
        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
    @endif
</div>
