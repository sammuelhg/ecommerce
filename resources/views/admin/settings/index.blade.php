@extends('layouts.admin')

@section('title', 'Configurações da Loja')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white border-bottom">
                    <h4 class="mb-0"><i class="bi bi-gear me-2"></i>Configurações da Loja</h4>
                </div>
                <div class="card-body">
                        
                    <!-- Navigation Tabs (Real Links) -->
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'identity' ? 'active' : '' }}" href="{{ route('admin.settings.index', 'identity') }}">
                                <i class="bi bi-palette me-2"></i>Identidade Visual
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'colors' ? 'active' : '' }}" href="{{ route('admin.settings.index', 'colors') }}">
                                <i class="bi bi-paint-bucket me-2"></i>Cores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'info' ? 'active' : '' }}" href="{{ route('admin.settings.index', 'info') }}">
                                <i class="bi bi-building me-2"></i>Informações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'ai' ? 'active' : '' }}" href="{{ route('admin.settings.index', 'ai') }}">
                                <i class="bi bi-stars me-2"></i>IA & Geração
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'modals' ? 'active' : '' }}" href="{{ route('admin.settings.index', 'modals') }}">
                                <i class="bi bi-window me-2"></i>Modais
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'security' ? 'active' : '' }}" href="{{ route('admin.settings.index', 'security') }}">
                                <i class="bi bi-shield-check me-2"></i>Segurança
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'email' ? 'active' : '' }}" href="{{ route('admin.settings.index', 'email') }}">
                                <i class="bi bi-envelope me-2"></i>Emails
                            </a>
                        </li>
                    </ul>

                    <!-- Content Area -->
                    <div class="tab-content">
                        
                        <!-- Helper component to start form -->
                        @php
                            $formAction = route('admin.settings.update');
                        @endphp

                        <!-- Identidade Visual -->
                        @if($activeTab == 'identity')
                        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="redirect_tab" value="identity">
                            
                            <h5 class="mb-4 text-primary border-bottom pb-2">Logo e Identidade</h5>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Logo da Loja (Principal)</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if(isset($settings['store_logo']))
                                            <div class="border p-2 rounded bg-light">
                                                <img src="{{ $settings['store_logo'] }}" alt="Logo Atual" style="height: 60px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control bg-white" name="store_logo" accept="image/*">
                                    </div>
                                    <div class="form-text">Usado no cabeçalho do site.</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Logo para Emails (Opcional)</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if(isset($settings['email_logo']))
                                            <div class="border p-2 rounded bg-light">
                                                <img src="{{ $settings['email_logo'] }}" alt="Logo Email" style="height: 60px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control bg-white" name="email_logo" accept="image/*">
                                    </div>
                                    <div class="form-text">Se vazio, usa o Logo Principal.</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Favicon (Ícone)</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if(isset($settings['favicon']))
                                            <div class="border p-2 rounded bg-light">
                                                <img src="{{ $settings['favicon'] }}" alt="Favicon" style="height: 32px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control bg-white" name="favicon" accept="image/x-icon,image/png">
                                    </div>
                                    <div class="form-text">32x32px.</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Logo do Perfil (Redonda)</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if(isset($settings['profile_logo']))
                                            <div class="border p-2 rounded bg-light">
                                                <img src="{{ $settings['profile_logo'] }}" alt="Logo Perfil" style="height: 60px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control bg-white" name="profile_logo" accept="image/*">
                                    </div>
                                    <div class="form-text">Usado no painel do usuário.</div>
                                </div>
                                <div class="col-md-3 mt-3 mt-md-0">
                                    <label class="form-label fw-bold">Logo do Rodapé (Branca)</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if(isset($settings['footer_logo']))
                                            <div class="border p-2 rounded bg-secondary">
                                                <img src="{{ $settings['footer_logo'] }}" alt="Logo Rodapé" style="height: 60px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control bg-white" name="footer_logo" accept="image/*">
                                    </div>
                                    <div class="form-text">Usado no fundo escuro do rodapé.</div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Salvar Identidade</button>
                            </div>
                        </form>
                        @endif

                        <!-- Cores -->
                        @if($activeTab == 'colors')
                        <form action="{{ $formAction }}" method="POST">
                            @csrf
                            <input type="hidden" name="redirect_tab" value="colors">

                            <h5 class="mb-4 text-primary border-bottom pb-2">Cores do Tema (Bootstrap Custom)</h5>
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cor Primária (Primary)</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color bg-white" name="color_primary" value="{{ $settings['color_primary'] ?? '#0d6efd' }}">
                                        <input type="text" class="form-control bg-white" value="{{ $settings['color_primary'] ?? '#0d6efd' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cor Secundária (Secondary)</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color bg-white" name="color_secondary" value="{{ $settings['color_secondary'] ?? '#6c757d' }}">
                                        <input type="text" class="form-control bg-white" value="{{ $settings['color_secondary'] ?? '#6c757d' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cor de Destaque (Accent)</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color bg-white" name="color_accent" value="{{ $settings['color_accent'] ?? '#ffc107' }}">
                                        <input type="text" class="form-control bg-white" value="{{ $settings['color_accent'] ?? '#ffc107' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cor de Fundo (Background)</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color bg-white" name="color_background" value="{{ $settings['color_background'] ?? '#f8f9fa' }}">
                                        <input type="text" class="form-control bg-white" value="{{ $settings['color_background'] ?? '#f8f9fa' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cor Barra Categorias</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color bg-white" name="color_category_bar" value="{{ $settings['color_category_bar'] ?? '#f0f8ff' }}">
                                        <input type="text" class="form-control bg-white" value="{{ $settings['color_category_bar'] ?? '#f0f8ff' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Salvar Cores</button>
                            </div>
                        </form>
                        @endif

                        <!-- Informações da Loja -->
                        @if($activeTab == 'info')
                        <form action="{{ $formAction }}" method="POST">
                            @csrf
                            <input type="hidden" name="redirect_tab" value="info">

                            <h5 class="mb-4 text-primary border-bottom pb-2">Dados da Empresa</h5>
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Endereço Completo</label>
                                    <textarea class="form-control bg-white" name="store_address" rows="2">{{ $settings['store_address'] ?? '' }}</textarea>
                                    <div class="form-text">Suporta múltiplas linhas</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">CNPJ</label>
                                    <input type="text" class="form-control bg-white" name="store_cnpj" value="{{ $settings['store_cnpj'] ?? '' }}" placeholder="00.000.000/0000-00">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Telefone / WhatsApp</label>
                                    <input type="text" class="form-control bg-white" name="store_phone" value="{{ $settings['store_phone'] ?? '' }}" placeholder="(00) 00000-0000">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">URL Embed Google Maps</label>
                                    <input type="text" class="form-control bg-white" name="google_maps_embed_url" value="{{ $settings['google_maps_embed_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=...">
                                    <div class="form-text">Cole a URL do src do iframe OU o código completo do iframe</div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Salvar Informações</button>
                            </div>
                        </form>
                        @endif

                        <!-- IA & Geração -->
                        @if($activeTab == 'ai')
                        <form action="{{ $formAction }}" method="POST">
                            @csrf
                            <input type="hidden" name="redirect_tab" value="ai">

                            <h5 class="mb-4 text-primary border-bottom pb-2">Template de Geração de Imagens com IA</h5>
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Prompt Template</label>
                                    <textarea class="form-control bg-white font-monospace" name="ai_image_prompt_template" rows="6" placeholder="Professional e-commerce product photography of {product_name}...">{!! $settings['ai_image_prompt_template'] ?? 'Professional e-commerce product photography of {product_name}, {category} category product, {type} type, {model} model, {size} size, {flavor} flavor, {material} packaging. Studio lighting, clean white background, product centered, front view, label visible and readable, high resolution, professional packshot, 8k quality, photorealistic' !!}</textarea>
                                    <div class="form-text">
                                        <strong>Variáveis disponíveis:</strong> 
                                        <code>{product_name}</code>, <code>{category}</code>, <code>{type}</code>, 
                                        <code>{model}</code>, <code>{size}</code>, <code>{flavor}</code>, <code>{material}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Salvar IA</button>
                            </div>
                        </form>
                        @endif

                        <!-- Modais Informativos -->
                        @if($activeTab == 'modals')
                        <form action="{{ $formAction }}" method="POST">
                            @csrf
                            <input type="hidden" name="redirect_tab" value="modals">

                            <h5 class="mb-4 text-primary border-bottom pb-2">Conteúdo dos Modais do Footer</h5>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Sobre Nós</label>
                                    <textarea class="form-control bg-white" name="modal_about" rows="5" placeholder="Conte a história da sua empresa...">{!! $settings['modal_about'] ?? '' !!}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Trabalhe Conosco</label>
                                    <textarea class="form-control bg-white" name="modal_careers" rows="5" placeholder="Informações sobre vagas...">{!! $settings['modal_careers'] ?? '' !!}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Contato</label>
                                    <textarea class="form-control bg-white" name="modal_contact" rows="5" placeholder="Formas de contato...">{!! $settings['modal_contact'] ?? '' !!}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Trocas e Devoluções</label>
                                    <textarea class="form-control bg-white" name="modal_returns" rows="5" placeholder="Política de trocas...">{!! $settings['modal_returns'] ?? '' !!}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">FAQ</label>
                                    <textarea class="form-control bg-white" name="modal_faq" rows="5" placeholder="Perguntas frequentes...">{!! $settings['modal_faq'] ?? '' !!}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Política de Privacidade</label>
                                    <textarea class="form-control bg-white" name="modal_privacy" rows="5" placeholder="Política de privacidade...">{!! $settings['modal_privacy'] ?? '' !!}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Blog (Modal)</label>
                                    <textarea class="form-control bg-white" name="modal_blog" rows="5" placeholder="Conteúdo do Blog ou Links...">{!! $settings['modal_blog'] ?? '' !!}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Rastrear Pedido (Instruções Modal)</label>
                                    <textarea class="form-control bg-white" name="modal_tracking" rows="5" placeholder="Instruções de rastreio ou iframe...">{!! $settings['modal_tracking'] ?? '' !!}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Salvar Modais</button>
                            </div>
                        </form>
                        @endif

                        <!-- Certificados de Segurança -->
                        @if($activeTab == 'security')
                        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="redirect_tab" value="security">

                            <h5 class="mb-4 text-primary border-bottom pb-2">Certificados e Selos</h5>
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Adicionar Certificados (Imagens)</label>
                                    <input type="file" class="form-control bg-white" name="security_certificates[]" multiple accept="image/*">
                                    <div class="form-text">Selos de segurança, certificados SSL, etc.</div>
                                </div>
                                
                                @if(count($certificates) > 0)
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fw-bold">Certificados Ativos:</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach($certificates as $cert)
                                                <div class="position-relative border p-2 rounded bg-white">
                                                    <img src="{{ $cert }}" style="height: 50px; width: auto;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle p-0 d-flex align-items-center justify-content-center" 
                                                            style="width: 20px; height: 20px;"
                                                            onclick="removeCertificate('{{ $cert }}')">
                                                        &times;
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>

                                @endif
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Salvar Certificados</button>
                            </div>
                        </form>
                        @endif

                        <!-- Emails -->
                        @if($activeTab == 'email')
                        <form action="{{ $formAction }}" method="POST">
                            @csrf
                            <input type="hidden" name="redirect_tab" value="email">

                            <h5 class="mb-4 text-primary border-bottom pb-2">Card de Email</h5>
                            <p class="text-muted mb-4">Selecione o card que será usado nos emails enviados pelo sistema.</p>
                            
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Card para Emails</label>
                                    <select name="email_card_id" class="form-select bg-white">
                                        @foreach(\App\Models\EmailCard::active()->get() as $card)
                                            <option value="{{ $card->id }}" {{ ($settings['email_card_id'] ?? '') == $card->id ? 'selected' : '' }}>
                                                {{ $card->name }} - {{ $card->sender_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Escolha qual card aparecerá na assinatura dos emails.</div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <a href="{{ route('admin.email-cards.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-gear me-2"></i>Gerenciar Cards
                                    </a>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Salvar Emails</button>
                            </div>
                        </form>

                        <h5 class="mb-4 text-primary border-bottom pb-2 mt-5">Visualização de Emails</h5>
                        <p class="text-muted mb-3">Visualize os modelos de email utilizados pelo sistema:</p>
                        <div class="d-grid gap-3 d-md-flex">
                            <a href="{{ route('admin.emails.preview', 'welcome') }}" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-envelope-check me-2"></i>Boas-vindas
                            </a>
                            <a href="{{ route('admin.emails.preview', 'reset') }}" target="_blank" class="btn btn-outline-danger">
                                <i class="bi bi-key me-2"></i>Redefinição de Senha
                            </a>
                            <a href="{{ route('admin.emails.preview', 'reset-confirmation') }}" target="_blank" class="btn btn-outline-success">
                                <i class="bi bi-check-circle me-2"></i>Senha Alterada
                            </a>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden Form for Certificate Removal (Outside the tabs, but needs to work) --}}
{{-- Wait, the certificate tab is now its own form. The remove functionality uses a JS helper that submits a hidden form. --}}
{{-- I should make sure this hidden form exists in the Layout OR just inside the Security tab or global footer. --}}
{{-- Placing it at the end of content section is safe. --}}

<form id="remove-cert-form" action="{{ route('admin.settings.remove-certificate') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="path" id="remove-cert-path">
</form>

@push('scripts')
<script>
    function removeCertificate(path) {
        if(confirm('Tem certeza que deseja remover este certificado?')) {
            document.getElementById('remove-cert-path').value = path;
            document.getElementById('remove-cert-form').submit();
        }
    }
</script>
@endpush
@endsection
