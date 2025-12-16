@if($success)
    <div class="py-4">
        <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
        <h4 class="fw-bold">{{ $form->settings['success_title'] ?? 'Sucesso!' }}</h4>
        <p class="text-muted">{{ $form->settings['success_message'] ?? 'Seus dados foram enviados.' }}</p>
    </div>
@else
    <h3 class="fw-bold mb-1">{{ $form->title }}</h3>
    <p class="mb-3" style="font-size: 0.8rem; opacity: 0.9; line-height: 1.4;">{{ $form->description }}</p>

    <form wire:submit.prevent="submit" class="d-flex flex-column flex-grow-1">
        <div class="mb-2 text-start">
            <input type="email" wire:model="email" class="form-control form-control-sm" style="font-size: 0.75rem;" required placeholder="seu@email.com">
            @error('email') <span class="text-danger" style="font-size: 0.7rem;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-2 text-start">
            <input type="text" wire:model="name" class="form-control form-control-sm" style="font-size: 0.75rem;" placeholder="Seu Nome">
        </div>

        <div class="mt-auto w-100">
            <button type="submit" class="btn btn-dark w-100 fw-bold btn-sm text-uppercase" style="border-radius: 4px; padding-top: 0.4rem; padding-bottom: 0.4rem;">
                <span wire:loading.remove>{{ $form->settings['button_text'] ?? 'Enviar' }}</span>
                <span wire:loading>...</span>
            </button>
        </div>
    </form>
@endif
