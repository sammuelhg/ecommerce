<div>
    @if(!$form)
        <!-- Form not found or inactive -->
        @if(app()->isLocal())
            <div class="alert alert-warning">Formulário '{{ $slug }}' não encontrado ou inativo.</div>
        @endif

    @else
        @php
            $displayType = $form->settings['display_type'] ?? 'inline';
            $triggerText = $form->settings['trigger_text'] ?? 'Abrir Formulário';
            $modalId = 'modal-form-' . $form->id;
        @endphp

        @if($displayType === 'modal')
            <!-- Modal Trigger -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                {{ $triggerText }}
            </button>

            <!-- Modal Structure -->
            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-body p-0">
                            <div class="card border-0 shadow-sm h-100" style="{{ $form->settings['card_style'] ?? '' }}">
                                <div class="card-header bg-transparent border-0 d-flex justify-content-end pt-3 pe-3">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="card-body p-4 pt-0 text-center">
                                    @include('livewire.cms.partials.form-content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Inline Display -->
            @if($headless)
                <div class="w-100 h-100 d-flex flex-column">
                    @include('livewire.cms.partials.form-content')
                </div>
            @else
                <div class="card border-0 shadow-sm h-100" style="{{ $form->settings['card_style'] ?? '' }}">
                    <div class="card-body p-4 text-center">
                        @include('livewire.cms.partials.form-content')
                    </div>
                </div>
            @endif
        @endif
    @endif
</div>
