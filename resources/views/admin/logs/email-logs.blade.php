@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Logs de Email</h1>
    <p class="text-muted">Registro de atividades de envio de email do sistema.</p>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white">
            <i class="bi bi-list-ul me-1"></i>
            Últimos Envios
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Data/Hora</th>
                            <th>Tipo</th>
                            <th>Destinatário</th>
                            <th>Detalhes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="text-nowrap small">{{ $log['date'] }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $log['type'] }}</span>
                                </td>
                                <td>{{ $log['recipient'] }}</td>
                                <td class="small text-muted">{{ Str::limit($log['details'], 100) }}</td>
                                <td>
                                    <span class="badge bg-{{ $log['class'] }}">
                                        {{ $log['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Nenhum log de email encontrado recentemente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
