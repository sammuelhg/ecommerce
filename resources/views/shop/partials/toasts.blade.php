<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11000;">
    <!-- Success Toast -->
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i>
                <span id="successMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <!-- Error Toast -->
    <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-circle me-2"></i>
                <span id="errorMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <!-- Info Toast -->
    <div id="infoToast" class="toast align-items-center text-white bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-info-circle me-2"></i>
                <span id="infoMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
// Toast helper function
window.showToast = function(type, message) {
    const toastEl = document.getElementById(type + 'Toast');
    const messageEl = document.getElementById(type + 'Message');
    
    if (toastEl && messageEl) {
        messageEl.textContent = message;
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    }
};

// Listen for custom events
window.addEventListener('toast-success', (e) => {
    showToast('success', e.detail.message || e.detail);
});

window.addEventListener('toast-error', (e) => {
    showToast('error', e.detail.message || e.detail);
});

window.addEventListener('toast-info', (e) => {
    showToast('info', e.detail.message || e.detail);
});
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('success', "{{ session('success') }}");
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('error', "{{ session('error') }}");
    });
</script>
@endif

@if(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('info', "{{ session('info') }}");
    });
</script>
@endif
