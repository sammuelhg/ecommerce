@props(['colors', 'label' => 'Cor', 'wireModel' => 'product_color_id', 'selectedColorId' => null, 'dropup' => false])

<div x-data="{ 
         open: false, 
         selectedId: @entangle($wireModel).live,
         get selectedName() {
             let color = this.colors.find(c => c.id == this.selectedId);
             return color ? color.name : 'Selecione...';
         },
         get selectedHex() {
             let color = this.colors.find(c => c.id == this.selectedId);
             return color ? color.hex_code : null;
         },
         colors: @js($colors)
     }"
     @click.away="open = false"
     class="position-relative w-100 {{ $dropup ? 'dropup' : '' }}">
    
    @if($label)
        <label class="form-label">{{ $label }}</label>
    @endif
    
    <button type="button" 
            class="form-select bg-white d-flex align-items-center justify-content-between text-start" 
            @click="open = !open">
        <span class="d-flex align-items-center gap-2">
            <template x-if="selectedHex">
                <span class="d-inline-block rounded-circle" 
                      :style="'width: 16px; height: 16px; background-color: ' + selectedHex + '; border: 1px solid #000;'"></span>
            </template>
            <span x-text="selectedName"></span>
        </span>
    </button>

    <style>
        .custom-dropup {
            bottom: 100%;
            margin-bottom: 0.25rem;
            margin-top: 0;
            top: auto;
        }
    </style>

    <div x-show="open" 
         x-transition
         class="position-absolute w-100 bg-white border rounded shadow {{ $dropup ? 'custom-dropup' : 'mt-1' }}" 
         style="max-height: 200px; overflow-y: auto; z-index: 1050;">
        
        <div class="p-2 border-bottom hover-bg-light cursor-pointer text-muted small"
             @click="selectedId = null; open = false">
            Selecione...
        </div>

        <template x-for="color in colors" :key="color.id">
            <div class="d-flex align-items-center gap-2 p-2 hover-bg-light cursor-pointer border-bottom-0"
                 :class="{ 'bg-light': selectedId == color.id }"
                 @click="selectedId = color.id; open = false">
                <span class="d-inline-block rounded-circle flex-shrink-0" 
                      :style="'width: 18px; height: 18px; background-color: ' + color.hex_code + '; border: 1px solid #000;'"></span>
                <span x-text="color.name" class="text-truncate"></span>
                <span class="text-muted small ms-auto" x-text="color.code || color.slug"></span>
            </div>
        </template>
    </div>

    <style>
        .hover-bg-light:hover { background-color: #f8f9fa; cursor: pointer; }
    </style>
</div>
