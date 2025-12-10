<div class="container-fluid">
    <!-- Header & Filter -->
    <div class="row mb-4 align-items-end">
        <div class="col-md-6">
            <h1 class="h3">Relatório Financeiro & CRM</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <form class="d-flex justify-content-end gap-2 align-items-end">
                <div>
                     <label class="small text-muted">Início</label>
                     <input type="date" wire:model.live="startDate" class="form-control">
                </div>
                <div>
                     <label class="small text-muted">Fim</label>
                     <input type="date" wire:model.live="endDate" class="form-control">
                </div>
            </form>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-4">
        <!-- CAC -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase small">C.A.C (Custo de Aquisição)</h6>
                    <h2 class="display-6 fw-bold {{ $cac > 50 ? 'text-danger' : 'text-success' }}">
                        R$ {{ number_format($cac, 2, ',', '.') }}
                    </h2>
                    <small class="text-muted">Investimento / {{ $newCustomers }} Novos Clientes</small>
                </div>
            </div>
        </div>
        <!-- LTV -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase small">L.T.V (Lifetime Value)</h6>
                    <h2 class="display-6 fw-bold text-primary">
                        R$ {{ number_format($ltv, 2, ',', '.') }}
                    </h2>
                    <small class="text-muted">Receita Média Vitalícia</small>
                </div>
            </div>
        </div>
        <!-- Ratio -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase small">LTV / CAC Ratio</h6>
                    @php $ratio = $cac > 0 ? $ltv / $cac : 0; @endphp
                    <h2 class="display-6 fw-bold {{ $ratio >= 3 ? 'text-success' : 'text-warning' }}">
                        {{ number_format($ratio, 1) }}x
                    </h2>
                    <small class="text-muted">Ideal > 3.0x</small>
                </div>
            </div>
        </div>
    </div>

    <!-- DRE & Best Sellers -->
    <div class="row g-4">
        <!-- DRE -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white">
                     <h5 class="mb-0">DRE Simplificado (Marketing)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-bold ps-4">Receita Bruta</td>
                                <td class="text-end fw-bold text-success">+ R$ {{ number_format($revenue, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="ps-4 text-muted">(-) Custos de Produto (CMV)</td>
                                <td class="text-end text-danger">- R$ {{ number_format($cogs, 2, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td class="fw-bold ps-4">Margem Bruta</td>
                                <td class="text-end fw-bold">R$ {{ number_format($grossMargin, 2, ',', '.') }}</td>
                            </tr>
                             <tr>
                                <td class="ps-4 text-muted">(-) Despesas de Marketing</td>
                                <td class="text-end text-danger">- R$ {{ number_format($marketingCost, 2, ',', '.') }}</td>
                            </tr>
                            <tr class="table-{{ $netProfit >= 0 ? 'success' : 'danger' }}">
                                <td class="fw-bold ps-4 fs-5">Resultado Operacional</td>
                                <td class="text-end fw-bold fs-5">R$ {{ number_format($netProfit, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Best Sellers -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                     <h5 class="mb-0">Top 5 Produtos (No Período)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Qtd</th>
                                <th class="text-end">Receita</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bestSellers as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                            @endif
                                            <span class="text-truncate" style="max-width: 200px;">{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold">{{ $item->total_qty }}</td>
                                    <td class="text-end text-success">R$ {{ number_format($item->total_revenue, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Nenhum produto vendido no período.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
