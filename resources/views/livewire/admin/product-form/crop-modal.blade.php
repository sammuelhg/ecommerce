<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">
                    <i class="bi bi-crop"></i> Cortar Imagem (1:1)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Selecione a área que deseja usar (formato quadrado 1:1)
                    </small>
                </div>
                <div style="max-height: 500px; overflow: hidden;">
                    <img id="imageToCrop" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="cropImageBtn">
                    <i class="bi bi-check-circle"></i> Confirmar e Próxima
                </button>
            </div>
        </div>
    </div>
</div>
