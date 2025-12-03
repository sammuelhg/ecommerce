<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Preço de Venda (R$) *</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="number" wire:model.blur="price" class="form-control form-control-lg fw-bold bg-white @error('price') is-invalid @enderror" step="0.01" min="0">
        </div>
        @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Preço "De" (Comparação)</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="number" wire:model.blur="compare_at_price" class="form-control bg-white" step="0.01" min="0">
        </div>
        <small class="text-muted">Para promoções (ex: De R$ 100 por R$ 80)</small>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Preço de Custo</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="number" wire:model.blur="cost_price" class="form-control bg-white" step="0.01" min="0">
        </div>
        <small class="text-muted">Uso interno para cálculo de lucro</small>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Estoque</label>
        <input type="number" wire:model.blur="stock" class="form-control bg-white @error('stock') is-invalid @enderror" min="0">
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">SKU (Gerado Automaticamente)</label>
        <input type="text" wire:model.blur="sku" class="form-control bg-light" readonly>
        <small class="text-muted">Gerado com base nos atributos do produto.</small>
    </div>
</div>
