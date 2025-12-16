<div class="h-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-kanban me-2"></i>Funil de Vendas</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.funnel.automations') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-gear-wide-connected me-1"></i> Regras de Automação
            </a>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-list-ul me-1"></i> Ver Lista
            </a>
        </div>
    </div>

    <div class="row flex-nowrap overflow-auto pb-4" style="min-height: 70vh;">
        @foreach($columns as $status => $column)
            <div class="col-md-3 col-lg-2 me-3" style="min-width: 280px;">
                <div class="card h-100 bg-light border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center py-3">
                        <span>{{ $column['title'] }}</span>
                        <span class="badge bg-secondary rounded-pill">{{ count($column['leads']) }}</span>
                    </div>
                    <div class="card-body p-2" 
                         ondragover="allowDrop(event)" 
                         ondrop="drop(event, '{{ $status }}')">
                        
                        @foreach($column['leads'] as $lead)
                            <div class="card mb-2 shadow-sm cursor-grab border-start border-4 border-{{ $status === 'hot' ? 'danger' : ($status === 'new' ? 'primary' : 'success') }}" 
                                 draggable="true" 
                                 ondragstart="drag(event, {{ $lead->id }})">
                                <div class="card-body p-3">
                                    <h6 class="card-title fw-bold mb-1 text-truncate">{{ $lead->name ?? $lead->email }}</h6>
                                    <p class="card-text small text-muted mb-2">{{ $lead->email }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-xs text-muted">{{ $lead->created_at->format('d/m') }}</small>
                                        @if($lead->utm_source)
                                            <span class="badge bg-light text-dark border">{{ $lead->utm_source }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Confirmation Modal -->
    @if($confirmingStatusChange)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Automação de Email</h5>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-envelope-paper-heart fs-1 text-primary"></i>
                        </div>
                        <p class="h5 mb-3">Deseja enviar o email automático desta fase?</p>
                        <p class="text-muted small">
                            Status: <span class="fw-bold">{{ ucfirst($pendingStatus) }}</span>
                        </p>
                        
                        <div class="form-check form-switch d-inline-block text-start bg-light p-3 rounded">
                            <input class="form-check-input" type="checkbox" id="sendEmailSwitch" wire:model="shouldSendEmail">
                            <label class="form-check-label fw-bold" for="sendEmailSwitch">Enviar Email Automático</label>
                            <div class="small text-muted mt-1">
                                @if($pendingStatus === 'hot')
                                    Template: "Vimos que você gostou..."
                                @elseif($pendingStatus === 'recovery')
                                    Template: "Cupom de Retorno"
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelUpdate">Cancelar</button>
                        <button type="button" class="btn btn-primary" wire:click="confirmUpdate">
                            Confirmar Mudança
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev, leadId) {
            ev.dataTransfer.setData("leadId", leadId);
        }

        function drop(ev, newStatus) {
            ev.preventDefault();
            var leadId = ev.dataTransfer.getData("leadId");
            @this.updateStatus(leadId, newStatus);
        }
    </script>

    <style>
        .cursor-grab { cursor: grab; }
        .cursor-grab:active { cursor: grabbing; }
    </style>
</div>
