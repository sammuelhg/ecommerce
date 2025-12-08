@props(['data' => []])
<div class="card h-100 bg-light border-0 d-flex align-items-center justify-content-center p-4 position-relative overflow-hidden">
    @if(isset($data['image']))
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>
    @endif
    <div class="w-100 p-3 position-relative" style="z-index: 2;">
        <div class="text-center mb-3">
            <h5 class="text-dark fw-bold mb-2">📧 Newsletter</h5>
            <p class="text-dark small lh-sm">
                Ganhe <strong class="text-danger">15% OFF</strong> na 1ª compra!
            </p>
        </div>

        @if(session()->has('newsletter_message'))
            <div class="alert alert-success small mb-0 p-2 text-center lh-1">
                {{ session('newsletter_message') }}
            </div>
        @else
            <form wire:submit.prevent="newsletterSubscribe" class="d-flex flex-column gap-2">
                <input type="email" wire:model="newsletterEmail" class="form-control form-control-sm bg-white border border-secondary text-center" placeholder="seu@email.com" required>
                <button class="btn btn-danger btn-sm text-white fw-bold w-100" type="submit">
                    QUERO DESCONTO
                </button>
            </form>
            @error('newsletterEmail') <div class="text-danger small mt-1 text-center">{{ $message }}</div> @enderror
        @endif
    </div>
</div>
