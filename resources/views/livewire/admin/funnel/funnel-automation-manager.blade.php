<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">🤖 Inteligência de Funil</h2>
        <button wire:click="create" class="btn btn-primary">
            + Nova Regra
        </button>
    </div>

    {{-- Create Form --}}
    @if($isCreating)
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">Nova Automação</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nome da Regra</label>
                    <input type="text" wire:model="name" class="form-control" placeholder="Ex: Mover compradores para Clientes">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Gatilho (SE...)</label>
                    <select wire:model="trigger_event" class="form-select">
                        @foreach($triggers as $trigger)
                            <option value="{{ $trigger->value }}">{{ $trigger->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-flex align-items-center justify-content-center pt-4">
                    <strong>➡️ ENTÃO</strong>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Ação (Mover para...)</label>
                    <select wire:model="target_status" class="form-select">
                        @foreach($leadStatuses as $status)
                            <option value="{{ $status->value }}">{{ $status->name }} ({{ $status->value }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button wire:click="cancel" class="btn btn-secondary me-2">Cancelar</button>
            <button wire:click="save" class="btn btn-success">Salvar Regra</button>
        </div>
    </div>
    @endif

    {{-- Rules List --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Regra</th>
                        <th>Gatilho</th>
                        <th>Ação</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rules as $rule)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $rule->name }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ \App\Enums\FunnelTriggerEnum::tryFrom($rule->trigger_event)?->label() ?? $rule->trigger_event }}
                            </span>
                        </td>
                        <td>
                            Mover para 
                            <span class="badge bg-warning text-dark">
                                {{ strtoupper($rule->action_payload['target_status'] ?? 'N/A') }}
                            </span>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:click="toggle({{ $rule->id }})" {{ $rule->is_active ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <button wire:click="delete({{ $rule->id }})" class="btn btn-sm btn-outline-danger" onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()">
                                🗑️
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Nenhuma regra de automação criada ainda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
