@props(['data' => []])
<div {{ $attributes->merge(['class' => 'card h-100 border-0 d-flex align-items-center justify-content-center p-4 position-relative overflow-hidden shadow-sm ' . ($data['bg_color'] ?? 'bg-light') . ' ' . ($data['text_color'] ?? 'text-dark')]) }}>
    @php
        $imageStyle = $data['image_style'] ?? 'background';
    @endphp

    @if(isset($data['image']) && $data['image'])
        @if($imageStyle === 'background')
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>
        @else
            <div class="w-100 flex-shrink-0">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($data['image']) }}" class="card-img-top object-fit-cover" style="height: 150px;">
            </div>
        @endif
    @endif
    <div class="w-100 p-3 position-relative" style="z-index: 2;">
        <div class="text-center mb-3">
            <h5 class="fw-bold mb-2">
                {{ $data['title'] ?? '📧 Newsletter' }}
            </h5>
            <div class="small lh-sm">
                @if(isset($data['text']) && !empty($data['text']))
                    {!! $data['text'] !!}
                @else
                    Ganhe <strong class="text-danger">15% OFF</strong> na 1ª compra!
                @endif
            </div>
        </div>

        @if(session()->has('newsletter_message'))
            <div class="alert alert-success small mb-0 p-2 text-center lh-1">
                {{ session('newsletter_message') }}
            </div>
        @else
            <form wire:submit.prevent="newsletterSubscribe({{ $data['campaign_id'] ?? 'null' }})" class="d-flex flex-column gap-2">
                <input type="email" wire:model="newsletterEmail" class="form-control form-control-sm bg-white border border-secondary text-center" placeholder="seu@email.com" required>
                <button class="btn {{ $data['btn_color'] ?? 'btn-danger' }} btn-sm fw-bold w-100 text-uppercase" type="submit">
                    {{ $data['button_text'] ?? 'QUERO DESCONTO' }}
                </button>
            </form>
            @error('newsletterEmail') <div class="text-danger small mt-1 text-center">{{ $message }}</div> @enderror
        @endif
    </div>
</div>
