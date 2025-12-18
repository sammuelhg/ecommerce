<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small text-uppercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.marketing.dashboard') }}">Marketing</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Relatório</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-0 text-dark">{{ $campaign->subject }}</h2>
            <p class="text-muted">Enviado em {{ $campaign->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.marketing.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
             <div class="card h-100 shadow-sm border-primary-subtle">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Total de Envios</h6>
                    <h3 class="mb-0 text-primary">{{ $campaign->subscribers_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
             <div class="card h-100 shadow-sm border-success-subtle">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Aberturas Únicas</h6>
                    <!-- Estimating unique opens roughly or using opens count -->
                    <h3 class="mb-0 text-success">{{ $campaign->emails->sum('opens_count') }}</h3>
                </div>
            </div>
        </div>
         <div class="col-md-4">
             <div class="card h-100 shadow-sm border-info-subtle">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Status</h6>
                    <span class="badge bg-info text-dark fs-6">{{ $campaign->status->label() ?? $campaign->status }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Opens Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 card-title fw-bold"><i class="bi bi-eye me-2"></i>Quem Abriu</h5>
            <span class="badge bg-light text-dark border">{{ $opens->total() }} registros</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4">Lead / Email</th>
                        <th>IP / Device</th>
                        <th>Email Específico</th>
                        <th class="text-end pe-4">Aberto em</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($opens as $open)
                        <tr>
                            <td class="ps-4">
                                @if($open->lead)
                                    <div class="fw-bold text-dark">{{ $open->lead->name }}</div>
                                    <div class="small text-muted">{{ $open->lead->email }}</div>
                                @else
                                    <span class="text-muted fst-italic">Lead Removido ou Desconhecido</span>
                                    <div class="small text-muted">ID: {{ $open->lead_id }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="small font-monospace text-muted">{{ $open->ip_address ?? 'N/A' }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 200px;" title="{{ $open->user_agent }}">
                                    {{ Str::limit($open->user_agent ?? 'N/A', 30) }}
                                </div>
                            </td>
                            <td>
                                <!-- If we tracked which email step it was -->
                                <span class="badge bg-light text-dark border">
                                    {{ $open->step_order ?? 'Geral' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="text-dark fw-bold">{{ $open->created_at->format('d/m/Y') }}</span>
                                <small class="text-muted d-block">{{ $open->created_at->format('H:i:s') }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 text-light-emphasis"></i>
                                <p class="mt-2">Nenhuma abertura registrada para esta campanha ainda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $opens->links() }}
        </div>
    </div>
</div>
