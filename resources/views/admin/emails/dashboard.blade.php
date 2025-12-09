@extends('layouts.admin')

@section('title', 'Dashboard de Emails')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gerenciador de Emails & Templates</h1>
    </div>

    <div class="row">
        <!-- Transactional Emails -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-gear-wide-connected me-2"></i>Emails Transacionais (Sistema)</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.emails.preview.type', 'welcome') }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-person-plus-fill me-2 text-success"></i> Boas-vindas (Conta)
                                <small class="d-block text-muted">Enviado ao criar conta.</small>
                            </div>
                            <span class="badge bg-light text-dark">Preview</span>
                        </a>
                        <a href="{{ route('admin.emails.preview.type', 'reset') }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-key-fill me-2 text-warning"></i> Recuperação de Senha
                                <small class="d-block text-muted">Solicitação de reset.</small>
                            </div>
                            <span class="badge bg-light text-dark">Preview</span>
                        </a>
                        <a href="{{ route('admin.emails.preview.type', 'reset-confirmation') }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-check-circle-fill me-2 text-success"></i> Confirmação de Senha
                                <small class="d-block text-muted">Aviso de alteração com sucesso.</small>
                            </div>
                            <span class="badge bg-light text-dark">Preview</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketing Emails -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-danger text-white">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-megaphone-fill me-2"></i>Marketing & Newsletter</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.emails.preview.type', 'newsletter-welcome') }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-envelope-heart-fill me-2 text-danger"></i> Boas-vindas (Newsletter)
                                <small class="d-block text-muted">Cupom de entrada.</small>
                            </div>
                            <span class="badge bg-light text-dark">Preview</span>
                        </a>
                        <a href="{{ route('admin.emails.preview.type', 'highlights') }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-star-fill me-2 text-warning"></i> Destaques da Semana
                                <small class="d-block text-muted">Template de vitrine de produtos.</small>
                            </div>
                            <span class="badge bg-light text-dark">Preview</span>
                        </a>
                        <a href="{{ route('admin.emails.preview.type', 'unsubscribe') }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-slash-circle-fill me-2 text-secondary"></i> Tela de Unsubscribe
                                <small class="d-block text-muted">Página de cancelamento de inscrição.</small>
                            </div>
                            <span class="badge bg-light text-dark">Preview</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Design System -->
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-palette-fill me-2"></i>Design System</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.emails.preview.type', 'cards') }}" target="_blank" class="btn btn-outline-dark w-100 p-4 text-start">
                                <h5 class="fw-bold"><i class="bi bi-person-badge-fill me-2"></i>Galeria de Digital Cards</h5>
                                <p class="mb-0 text-muted">Visualize todos os cards de assinatura cadastrados e como eles aparecem nos emails.</p>
                            </a>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <a href="{{ route('admin.emails.preview.type', 'reply') }}" target="_blank" class="btn btn-outline-dark w-100 p-4 text-start">
                                <h5 class="fw-bold"><i class="bi bi-reply-fill me-2"></i>Simulação de Resposta</h5>
                                <p class="mb-0 text-muted">Teste como o cliente vê sua resposta (Texto + Assinatura).</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
