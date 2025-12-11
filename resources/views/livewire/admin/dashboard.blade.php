<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dashboard</h1>
        <button wire:click="refreshStats" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-clockwise"></i> Atualizar
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total de Leads</h5>
                    <p class="card-text display-4">{{ $totalLeads }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Campanhas Ativas</h5>
                    <p class="card-text display-4">{{ $totalForms }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Últimas Conversões</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Email</th>
                        <th>Campanha</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLeads as $lead)
                    <tr wire:key="{{ $lead['id'] }}">
                        <td>{{ $lead['email'] }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $lead['form']['title'] ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($lead['created_at'])->diffForHumans() }}</td>
                        <td>
                            @if($lead['status'] === 'new')
                                <span class="badge bg-info">Novo</span>
                            @elseif($lead['status'] === 'opened')
                                <span class="badge bg-warning text-dark">Aberto</span>
                            @else
                                <span class="badge bg-secondary">{{ $lead['status'] }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-muted">Nenhum lead encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
