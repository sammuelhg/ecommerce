<div>
    <div class="row g-4 mb-5">
        <!-- Card 1: Total Subscribers -->
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-primary h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Total de Inscritos</h6>
                    <h2 class="mb-0 text-primary fw-bold">{{ number_format($totalSubscribers) }}</h2>
                    <small class="text-success fw-bold">
                        <i class="bi bi-arrow-up"></i> {{ $newSubscribersToday }} hoje
                    </small>
                </div>
            </div>
        </div>

        <!-- Card 2: Open Rate -->
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-success h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Taxa de Abertura</h6>
                    <h2 class="mb-0 text-success fw-bold">{{ number_format($openRate, 1) }}%</h2>
                    <small class="text-muted">Global</small>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Opens -->
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-warning h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Total de Aberturas</h6>
                    <h2 class="mb-0 text-warning fw-bold">{{ number_format($totalOpens) }}</h2>
                </div>
            </div>
        </div>

        <!-- Card 4: Campaigns -->
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-info h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Campanhas Ativas</h6>
                    <h2 class="mb-0 text-info fw-bold">3</h2> <!-- Mock number -->
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN LAUNCHPAD NAVIGATION -->
    <h5 class="mb-4 text-secondary border-bottom pb-2">
        <i class="bi bi-grid-fill me-2"></i>Menu de Ações
    </h5>

    <div class="row g-4 mb-5">
        <!-- Inscritos -->
        <div class="col-md-4">
            <a href="{{ route('admin.newsletter.subscribers') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-primary-subtle">
                    <div class="card-body d-flex flex-column justify-content-center py-5">
                        <i class="bi bi-people-fill fs-1 mb-3 text-primary"></i>
                        <h4 class="card-title fw-bold mb-0 text-dark">Inscritos</h4>
                        <p class="text-muted small mt-2 mb-0">Gerenciar base de leads</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Nova Campanha -->
        <div class="col-md-4">
            <a href="{{ route('admin.newsletter.campaigns') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-success-subtle">
                    <div class="card-body d-flex flex-column justify-content-center py-5">
                        <i class="bi bi-send-fill fs-1 mb-3 text-success"></i>
                        <h4 class="card-title fw-bold mb-0 text-dark">Minhas Campanhas</h4>
                        <p class="text-muted small mt-2 mb-0">Criar e enviar emails</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Email Previews -->
        <div class="col-md-4">
            <a href="{{ route('admin.emails.preview.dashboard') }}" class="text-decoration-none">
                <div class="card text-center h-100 shadow-sm hover-card border-warning-subtle">
                    <div class="card-body d-flex flex-column justify-content-center py-5">
                        <i class="bi bi-envelope-paper-heart-fill fs-1 mb-3 text-warning"></i>
                        <h4 class="card-title fw-bold mb-0 text-dark">Templates</h4>
                        <p class="text-muted small mt-2 mb-0">Visualizar modelos de email</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Analytics Chart Section -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 card-title fw-bold"><i class="bi bi-bar-chart-line me-2"></i>Performance Recente</h5>
        </div>
        <div class="card-body">
            @if(empty($chartData))
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bar-chart display-4 text-light-emphasis"></i>
                    <p class="mt-2">Sem dados suficientes para exibir o gráfico.</p>
                </div>
            @else
                <div class="d-flex align-items-end justify-content-around" style="height: 250px;">
                    @foreach($chartData as $date => $count)
                        <div class="text-center w-100 group">
                            <div class="d-flex justify-content-center h-100 align-items-end mb-2">
                                <div class="bg-primary rounded-top position-relative" 
                                     style="width: 40px; height: {{ max(5, ($count / (max($chartData) ?: 1)) * 100) }}%; transition: height 0.3s; opacity: 0.8;">
                                     <div class="position-absolute bottom-100 start-50 translate-middle-x mb-2 badge bg-dark opacity-0 group-hover-opacity-100 transition">
                                        {{ $count }}
                                     </div>
                                </div>
                            </div>
                            <small class="d-block text-muted fw-bold" style="font-size: 0.75rem;">
                                {{ \Carbon\Carbon::parse($date)->format('d/m') }}
                            </small>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        </div>
    </div>

    <!-- Campaign Performance Table -->
    <div class="card shadow-sm border-0 mt-5">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 card-title fw-bold"><i class="bi bi-list-check me-2"></i>Campanhas Recentes</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4" style="width: 35%;">Campanha</th>
                        <th class="text-center" style="width: 15%;">Inscritos</th>
                        <th style="width: 50%;">Performance por Email</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($recentCampaigns as $campaign)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark d-block">{{ $campaign->subject }}</span>
                                <small class="text-muted">{{ $campaign->created_at->format('d/m/Y H:i') }}</small>
                                <div class="mt-1">
                                    @if($campaign->status->value === 'sent')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Ativa</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">{{ $campaign->status->label() }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="h5 fw-bold mb-0">{{ $campaign->subscribers_count }}</span>
                            </td>
                            <td>
                                @if($campaign->emails->isEmpty())
                                    <span class="text-muted small fst-italic">Sem emails configurados.</span>
                                @else
                                    <div class="d-flex flex-column gap-2 py-2">
                                        @foreach($campaign->emails as $email)
                                            <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light border">
                                                <div class="d-flex align-items-center overflow-hidden">
                                                    <span class="badge bg-primary me-2 rounded-pill">{{ $email->sort_order + 1 }}</span>
                                                    <div class="text-truncate" style="max-width: 200px;">
                                                        <span class="small fw-semibold text-dark">{{ $email->subject }}</span>
                                                        <div class="text-muted" style="font-size: 0.7rem;">+{{ $email->delay_in_hours }}h monitoradas</div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-envelope-open text-muted"></i>
                                                        <span class="fw-bold">{{ $email->opens_count }}</span>
                                                    </div>
                                                    <!-- Optional: Calculate specific rate if we knew exactly how many reached this step -->
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                Nenhuma campanha recente encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
    </style>
</div>
