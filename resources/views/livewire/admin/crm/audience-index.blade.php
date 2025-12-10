<div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-people-fill text-primary me-2"></i> Audiência Unificada
                </h1>
                <div class="d-flex gap-2" style="width: 300px;">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0" placeholder="Buscar por email ou nome...">
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <!-- Tabs / Filters could go here -->
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Identidade</th>
                                    <th>Relacionamento</th>
                                    <th>Última Atividade</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($audience as $person)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 text-secondary fw-bold" 
                                                     style="width: 40px; height: 40px; font-size: 1.2rem;">
                                                    {{ strtoupper(substr($person['name'], 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $person['name'] }}</div>
                                                    <div class="text-muted small">{{ $person['email'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 flex-wrap">
                                                @if($person['is_customer'])
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                                        <i class="bi bi-bag-check-fill me-1"></i> Cliente
                                                    </span>
                                                @elseif($person['is_user'])
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3">
                                                        <i class="bi bi-person me-1"></i> Usuário
                                                    </span>
                                                @endif
                                                
                                                @if($person['is_lead'])
                                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-3">
                                                        <i class="bi bi-envelope-paper-fill me-1"></i> Lead
                                                    </span>
                                                @endif

                                                @if($person['contact_count'] > 0)
                                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3">
                                                        <i class="bi bi-chat-left-text-fill me-1"></i> Contato ({{ $person['contact_count'] }})
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted small" title="{{ $person['joined_at'] }}">
                                                {{ \Carbon\Carbon::parse($person['joined_at'])->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#profileModal{{ md5($person['email']) }}">
                                                Ver Perfil
                                            </button>

                                            <!-- Profile Modal -->
                                            <div class="modal fade" id="profileModal{{ md5($person['email']) }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content text-start">
                                                        <div class="modal-header bg-light">
                                                            <h5 class="modal-title">Perfil Unificado</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <!-- Header Info -->
                                                            <div class="p-4 bg-white border-bottom text-center">
                                                                <div class="d-inline-flex rounded-circle bg-primary text-white align-items-center justify-content-center mb-3 shadow-sm" 
                                                                     style="width: 80px; height: 80px; font-size: 2rem;">
                                                                    {{ strtoupper(substr($person['name'], 0, 1)) }}
                                                                </div>
                                                                <h3 class="h4 mb-1">{{ $person['name'] }}</h3>
                                                                <p class="text-muted mb-3">{{ $person['email'] }}</p>
                                                                
                                                                <div class="d-flex justify-content-center gap-2">
                                                                    @if($person['user'])
                                                                        <a href="{{ route('admin.users.index') }}?search={{ $person['email'] }}" class="btn btn-sm btn-outline-primary">
                                                                            <i class="bi bi-box-arrow-up-right"></i> Ver Cliente
                                                                        </a>
                                                                    @endif
                                                                    <a href="mailto:{{ $person['email'] }}" class="btn btn-sm btn-outline-secondary">
                                                                        <i class="bi bi-envelope"></i> Enviar Email
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <!-- Data Sections -->
                                                            <div class="row g-0">
                                                                <!-- Left Column: Attributes -->
                                                                <div class="col-md-4 bg-light p-4 border-end">
                                                                    <h6 class="text-uppercase text-muted fw-bold small mb-3">Dados Cadastrais</h6>
                                                                    
                                                                    @if($person['user'])
                                                                        <div class="mb-3">
                                                                            <label class="small text-muted d-block">Cliente Desde</label>
                                                                            <span class="fw-medium">{{ $person['user']->created_at->format('d/m/Y') }}</span>
                                                                        </div>
                                                                    @endif

                                                                    @if($person['lead'])
                                                                        <div class="mb-3">
                                                                            <label class="small text-muted d-block">Lead Desde</label>
                                                                            <span class="fw-medium">{{ $person['lead']->created_at->format('d/m/Y') }}</span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="small text-muted d-block">Status do Lead</label>
                                                                            <span class="badge bg-secondary">{{ $person['lead']->status ?? 'Ativo' }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <!-- Right Column: Interactions -->
                                                                <div class="col-md-8 p-4">
                                                                    <h6 class="text-uppercase text-muted fw-bold small mb-3">Histórico de Mensagens</h6>
                                                                    
                                                                    @if($person['contacts']->count() > 0)
                                                                        <ul class="list-group list-group-flush">
                                                                            @foreach($person['contacts'] as $contact)
                                                                                <li class="list-group-item px-0 py-3">
                                                                                    <div class="d-flex justify-content-between mb-1">
                                                                                        <small class="fw-bold text-dark">Formulário de Contato</small>
                                                                                        <small class="text-muted">{{ $contact->created_at->format('d/m/Y H:i') }}</small>
                                                                                    </div>
                                                                                    <p class="mb-0 text-muted small bg-light p-2 rounded">
                                                                                        {{ $contact->message }}
                                                                                    </p>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <p class="text-muted small">Nenhuma mensagem direta enviada.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            Nenhum registro encontrado na audiência.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    {{ $paginator->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
