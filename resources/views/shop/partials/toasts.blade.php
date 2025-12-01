<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11000;">
    <!-- Success Toast -->
    <div class="toast align-items-center text-white bg-success border-0" 
         role="alert" 
         aria-live="assertive" 
         aria-atomic="true"
         x-data="{ show: false, message: '' }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @toast-success.window="message = $event.detail.message || $event.detail; show = true; setTimeout(() => show = false, 3000)"
         style="display: none;">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i>
                <span x-text="message"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="show = false"></button>
        </div>
    </div>

    <!-- Error Toast -->
    <div class="toast align-items-center text-white bg-danger border-0" 
         role="alert" 
         aria-live="assertive" 
         aria-atomic="true"
         x-data="{ show: false, message: '' }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @toast-error.window="message = $event.detail.message || $event.detail; show = true; setTimeout(() => show = false, 3000)"
         style="display: none;">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-circle me-2"></i>
                <span x-text="message"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="show = false"></button>
        </div>
    </div>

    <!-- Info Toast -->
    <div class="toast align-items-center text-white bg-info border-0" 
         role="alert" 
         aria-live="assertive" 
         aria-atomic="true"
         x-data="{ show: false, message: '' }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @toast-info.window="message = $event.detail.message || $event.detail; show = true; setTimeout(() => show = false, 3000)"
         style="display: none;">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-info-circle me-2"></i>
                <span x-text="message"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="show = false"></button>
        </div>
    </div>
</div>
