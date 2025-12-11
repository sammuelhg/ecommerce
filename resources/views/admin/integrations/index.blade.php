@extends('layouts.admin')

@section('title', 'Integrações')

@section('content')
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">Central de Integrações</h1>
        {{-- Botão Global removido conforme pedido --}}
    </div>

    @php
        $activeTab = request()->get('tab', 'meta');
    @endphp

    <!-- Abas de Navegação -->
    <ul class="nav nav-tabs mb-4" id="integrationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'meta' ? 'active' : '' }}" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta" type="button" role="tab" aria-controls="meta" aria-selected="{{ $activeTab === 'meta' ? 'true' : 'false' }}">
                <i class="bi bi-facebook me-1"></i> Meta Ads
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'google' ? 'active' : '' }}" id="google-tab" data-bs-toggle="tab" data-bs-target="#google" type="button" role="tab" aria-controls="google" aria-selected="{{ $activeTab === 'google' ? 'true' : 'false' }}">
                <i class="bi bi-google me-1"></i> Google Ads
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'tiktok' ? 'active' : '' }}" id="tiktok-tab" data-bs-toggle="tab" data-bs-target="#tiktok" type="button" role="tab" aria-controls="tiktok" aria-selected="{{ $activeTab === 'tiktok' ? 'true' : 'false' }}">
                <i class="bi bi-tiktok me-1"></i> TikTok Ads
            </button>
        </li>
    </ul>

    <!-- Conteúdo das Abas -->
    <div class="tab-content" id="integrationTabsContent">
        
        <!-- Tab: META ADS -->
        <div class="tab-pane fade {{ $activeTab === 'meta' ? 'show active' : '' }}" id="meta" role="tabpanel" aria-labelledby="meta-tab">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                        <div>
                            Configure sua conexão com o <strong>Meta Ads (Facebook/Instagram)</strong> para sincronizar Leads e Eventos via API (Server-Side).
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    {{-- Componente Livewire do Meta --}}
                    <livewire:integrations.meta-settings />
                </div>
                <div class="col-lg-4">
                    {{-- Card de Ajuda Rápida META --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Status da Integração</h6>
                            <p class="small text-muted mb-3">
                                A API de Conversões (CAPI) garante que seus eventos sejam recebidos pelo Facebook mesmo com bloqueadores de anúncios ativos no navegador do cliente.
                            </p>
                            <hr>
                            <div class="d-grid">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#metaDocsModal">
                                    <i class="bi bi-book me-1"></i> Ver Manual Meta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: GOOGLE ADS -->
        <div class="tab-pane fade {{ $activeTab === 'google' ? 'show active' : '' }}" id="google" role="tabpanel" aria-labelledby="google-tab">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="alert alert-light border shadow-sm d-flex align-items-center" role="alert">
                        <i class="bi bi-google me-2 fs-4 text-danger"></i>
                        <div>
                             Conecte suas campanhas de <strong>Performance Max e Search</strong> para otimizar conversões offline.
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <livewire:integrations.google-settings />
                </div>

                <div class="col-lg-4">
                    {{-- Card de Ajuda Rápida GOOGLE --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">API do Google Ads</h6>
                            <p class="small text-muted mb-3">
                                Utilize o <strong>Customer ID</strong> e o <strong>Developer Token</strong> para permitir que o sistema envie conversões diretamente para sua conta.
                            </p>
                            <hr>
                            <div class="d-grid">
                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#googleDocsModal">
                                    <i class="bi bi-book me-1"></i> Ver Manual Google
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: TIKTOK ADS -->
        <div class="tab-pane fade {{ $activeTab === 'tiktok' ? 'show active' : '' }}" id="tiktok" role="tabpanel" aria-labelledby="tiktok-tab">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="alert alert-dark border-0 shadow-sm d-flex align-items-center" role="alert">
                        <i class="bi bi-tiktok me-2 fs-4"></i>
                        <div>
                             Integre o <strong>TikTok Events API</strong> para rastrear ViewContent, AddToCart e Purchase mesmo no iOS 14+.
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <livewire:integrations.tiktok-settings />
                </div>

                <div class="col-lg-4">
                    {{-- Card de Ajuda Rápida TIKTOK --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Status da Integração</h6>
                            <p class="small text-muted mb-3">
                                A Events API do TikTok permite medir o ROI de anúncios em vídeos curtos com precisão.
                            </p>
                            <hr>
                            <div class="d-grid">
                                <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#tiktokDocsModal">
                                    <i class="bi bi-book me-1"></i> Ver Manual TikTok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL DE DOCUMENTAÇÃO: META -->
    <div class="modal fade" id="metaDocsModal" tabindex="-1" aria-labelledby="metaDocsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="metaDocsModalLabel">
                        <i class="bi bi-facebook me-2 text-primary"></i>Guia de Configuração: Meta Ads
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="container-fluid py-4">
                        <div class="row">
                            {{-- SIDEBAR DE NAVEGAÇÃO --}}
                            <div class="col-md-3 d-none d-md-block">
                                <div class="sticky-top" style="top: 0rem; z-index: 1000;">
                                    <div class="card border-0 shadow-sm bg-light">
                                        <div class="card-header bg-transparent fw-bold text-primary border-0">
                                            <i class="bi bi-list-ul me-2"></i> Índice
                                        </div>
                                        <div class="list-group list-group-flush bg-transparent">
                                            <a href="#meta-intro" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('meta-intro').scrollIntoView({behavior: 'smooth'})">Visão Geral</a>
                                            <a href="#meta-step1" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('meta-step1').scrollIntoView({behavior: 'smooth'})">1. Pixel ID</a>
                                            <a href="#meta-step2" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('meta-step2').scrollIntoView({behavior: 'smooth'})">2. Access Token</a>
                                            <a href="#meta-step3" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('meta-step3').scrollIntoView({behavior: 'smooth'})">3. Ad Account ID</a>
                                            <a href="#meta-security" class="list-group-item list-group-item-action bg-transparent border-0 small py-2 text-success fw-bold" onclick="document.getElementById('meta-security').scrollIntoView({behavior: 'smooth'})">Segurança</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CONTEÚDO PRINCIPAL --}}
                            <div class="col-md-9">
                                
                                {{-- CABEÇALHO --}}
                                <div class="d-flex align-items-center mb-4" id="meta-intro">
                                    <div class="bg-primary text-white rounded p-3 me-3">
                                        <i class="bi bi-facebook fs-2"></i>
                                    </div>
                                    <div>
                                        <h1 class="h3 mb-0 fw-bold">Guia de Integração: Meta Ads</h1>
                                        <p class="text-muted mb-0">Configuração da API de Conversões (CAPI) para Facebook e Instagram.</p>
                                    </div>
                                </div>

                                {{-- INTRODUÇÃO --}}
                                <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center mb-5" role="alert">
                                    <i class="bi bi-lightbulb-fill fs-4 me-3"></i>
                                    <div>
                                        <strong>Server-Side Tracking:</strong>
                                        Esta configuração ativa o envio de eventos (Leads) diretamente do servidor, garantindo maior precisão na mensuração de anúncios e evitando perdas por bloqueios de cookies.
                                    </div>
                                </div>

                                {{-- PASSO 1: PIXEL ID --}}
                                <div class="card shadow-sm border-0 mb-5" id="meta-step1">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-primary">1. Localizando o Pixel ID</h5>
                                    </div>
                                    <div class="card-body">
                                        <ol class="list-group list-group-numbered mb-3">
                                            <li class="list-group-item border-0">Acesse o <a href="https://business.facebook.com/events_manager2" target="_blank" class="fw-bold text-decoration-none">Gerenciador de Eventos</a> da Meta.</li>
                                            <li class="list-group-item border-0">No menu lateral esquerdo, clique em <strong>Fontes de Dados</strong> (ícone de triângulo).</li>
                                            <li class="list-group-item border-0">Selecione o Pixel que deseja utilizar.</li>
                                            <li class="list-group-item border-0">Vá para a aba <strong>Configurações</strong>.</li>
                                            <li class="list-group-item border-0">No topo da página, copie o código <strong>Identificação do conjunto de dados</strong> (Este é o seu Pixel ID).</li>
                                        </ol>
                                    </div>
                                </div>

                                {{-- PASSO 2: ACCESS TOKEN --}}
                                <div class="card shadow-sm border-0 mb-5" id="meta-step2">
                                    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold">2. Gerando o Token de Acesso</h5>
                                        <span class="badge bg-light text-primary fw-bold">Crítico</span>
                                    </div>
                                    <div class="card-body">
                                        <p>O token permite que nosso sistema "assine" os eventos enviados.</p>
                                        
                                        <div class="accordion" id="metaTokenMethods">
                                            <!-- Método Fácil -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#metaMethodAuto" aria-expanded="true">
                                                        Método Rápido (Pixel Settings)
                                                    </button>
                                                </h2>
                                                <div id="metaMethodAuto" class="accordion-collapse collapse show" data-bs-parent="#metaTokenMethods">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled">
                                                            <li class="mb-2">1. Nas <strong>Configurações</strong> do Pixel, role até <strong>API de Conversões</strong>.</li>
                                                            <li class="mb-2">2. Clique em <strong>Gerar token de acesso</strong> (link azul).</li>
                                                            <li>3. Copie o token enorme imediatamente.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Método Robusto -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#metaMethodSystem" aria-expanded="false">
                                                        Método Profissional (Usuário do Sistema)
                                                    </button>
                                                </h2>
                                                <div id="metaMethodSystem" class="accordion-collapse collapse" data-bs-parent="#metaTokenMethods">
                                                    <div class="accordion-body">
                                                        <small class="text-muted d-block mb-2">Recomendado para evitar expiração do token.</small>
                                                        <ol>
                                                            <li>Vá em <strong>Configurações do Negócio > Usuários > Usuários do Sistema</strong>.</li>
                                                            <li>Crie um usuário e clique em <strong>Gerar Novo Token</strong>.</li>
                                                            <li>Selecione as permissões <code>ads_management</code> e <code>ads_read</code>.</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PASSO 3: AD ACCOUNT ID --}}
                                <div class="card shadow-sm border-0 mb-5" id="meta-step3">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-primary">3. Ad Account ID (Conta de Anúncios)</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Necessário para vincular os dados offline à conta correta.</p>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h6 class="fw-bold">Onde encontrar:</h6>
                                                <ul>
                                                    <li>Acesse as <a href="https://business.facebook.com/settings/ad-accounts" target="_blank">Configurações do Negócio</a>.</li>
                                                    <li>Clique em <strong>Contas > Contas de Anúncios</strong>.</li>
                                                    <li>O ID estará visível no topo, geralmente no formato <code>act_123456789</code> ou apenas os números.</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <div class="border rounded p-3 bg-light">
                                                    <small class="d-block text-muted mb-1">Na URL do navegador:</small>
                                                    <code>...&act=<strong>1015792...</strong>&...</code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- NOTA DE SEGURANÇA --}}
                                <div class="card border-success border-2 mb-4" id="meta-security">
                                    <div class="card-body">
                                        <h5 class="card-title text-success fw-bold">
                                            <i class="bi bi-shield-lock-fill me-2"></i>
                                            Segurança Garantida
                                        </h5>
                                        <p class="card-text">
                                            Seus dados estão protegidos pela arquitetura <strong>The Gem Standard</strong>.
                                        </p>
                                        <ul class="mb-0 text-muted">
                                            <li>O Access Token é criptografado com chave AES-256 no banco de dados.</li>
                                            <li>Nenhum funcionário tem acesso visual ao seu token após salvo.</li>
                                            <li>A comunicação com a Meta é feita exclusivamente via HTTPS/TLS.</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE DOCUMENTAÇÃO: GOOGLE -->
    <div class="modal fade" id="googleDocsModal" tabindex="-1" aria-labelledby="googleDocsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="googleDocsModalLabel">
                        <i class="bi bi-google me-2 text-danger"></i>Guia Técnico: Google Ads API
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="container-fluid py-4">
                        <div class="row">
                            {{-- SIDEBAR DE NAVEGAÇÃO --}}
                            <div class="col-md-3 d-none d-md-block">
                                <div class="sticky-top" style="top: 0rem; z-index: 1000;">
                                    <div class="card border-0 shadow-sm bg-light">
                                        <div class="card-header bg-transparent fw-bold border-0" style="color: #DB4437;">
                                            <i class="bi bi-list-ul me-2"></i> Índice
                                        </div>
                                        <div class="list-group list-group-flush bg-transparent">
                                            <a href="#google-intro" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('google-intro').scrollIntoView({behavior: 'smooth'})">Visão Geral</a>
                                            <a href="#google-req-zero" class="list-group-item list-group-item-action bg-transparent border-0 small py-2 fw-bold text-danger" onclick="document.getElementById('google-req-zero').scrollIntoView({behavior: 'smooth'})">0. Pré-requisito Vital</a>
                                            <a href="#google-step1" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('google-step1').scrollIntoView({behavior: 'smooth'})">1. Customer ID</a>
                                            <a href="#google-step2" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('google-step2').scrollIntoView({behavior: 'smooth'})">2. Conversion Action</a>
                                            <a href="#google-step3" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('google-step3').scrollIntoView({behavior: 'smooth'})">3. Developer Token</a>
                                            <a href="#google-script" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('google-script').scrollIntoView({behavior: 'smooth'})">4. O Script</a>
                                            <a href="#google-gclid" class="list-group-item list-group-item-action bg-transparent border-0 small py-2 text-dark fw-bold" onclick="document.getElementById('google-gclid').scrollIntoView({behavior: 'smooth'})">Entendendo o Fluxo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CONTEÚDO PRINCIPAL --}}
                            <div class="col-md-9">
                                
                                {{-- CABEÇALHO --}}
                                <div class="d-flex align-items-center mb-4" id="google-intro">
                                    <div class="bg-white border rounded p-3 me-3">
                                        <i class="bi bi-google fs-2" style="background: -webkit-linear-gradient(45deg, #4285F4, #DB4437, #F4B400, #0F9D58); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                    </div>
                                    <div>
                                        <h1 class="h3 mb-0 fw-bold">Guia de Integração: Google Ads</h1>
                                        <p class="text-muted mb-0">Configuração de Conversões Offline (Offline Conversions API).</p>
                                    </div>
                                </div>

                                {{-- INTRODUÇÃO --}}
                                <div class="alert alert-light border shadow-sm d-flex align-items-center mb-5" role="alert">
                                    <i class="bi bi-graph-up-arrow fs-4 me-3 text-success"></i>
                                    <div>
                                        <strong>Otimização de ROAS:</strong>
                                        Ao enviar os Leads qualificados de volta para o Google, você ensina o algoritmo a buscar pessoas reais, e não apenas cliques curiosos.
                                    </div>
                                </div>

                                {{-- PASSO 0: AUTO TAGGING --}}
                                <div class="card border-danger border-2 mb-5" id="google-req-zero">
                                    <div class="card-header bg-danger text-white fw-bold">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> 0. Pré-requisito Obrigatório
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            Para que nosso sistema consiga rastrear a origem do Lead, você <strong>DEVE</strong> ativar a "Marcação Automática" no Google Ads. Sem isso, o parâmetro <code>GCLID</code> nunca será gerado.
                                        </p>
                                        <ol class="mb-0">
                                            <li>No menu esquerdo, clique em <strong>Configurações</strong> > <strong>Configurações da Conta</strong>.</li>
                                            <li>Abra a seção <strong>Marcação automática (Auto-tagging)</strong>.</li>
                                            <li>Marque a caixa "Marcar o URL em que as pessoas clicam no meu anúncio".</li>
                                            <li>Salve.</li>
                                        </ol>
                                    </div>
                                </div>

                                {{-- PASSO 1: CUSTOMER ID --}}
                                <div class="card shadow-sm border-0 mb-5" id="google-step1">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-dark">1. Customer ID (ID do Cliente)</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Este é o número que identifica sua conta onde os anúncios estão rodando.</p>
                                        <div class="row align-items-center">
                                            <div class="col-md-7">
                                                <ol class="list-group list-group-numbered list-group-flush">
                                                    <li class="list-group-item border-0">Faça login no <a href="https://ads.google.com" target="_blank" class="fw-bold text-decoration-none">Google Ads</a>.</li>
                                                    <li class="list-group-item border-0">Olhe para o canto superior direito da tela.</li>
                                                    <li class="list-group-item border-0">Você verá um número no formato: <code>123-456-7890</code>.</li>
                                                    <li class="list-group-item border-0">Copie apenas os números (sem traços).</li>
                                                </ol>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="alert alert-warning small">
                                                    <i class="bi bi-exclamation-circle-fill me-1"></i> <strong>Atenção:</strong> Se você usa uma MCC (Minha Central de Clientes), certifique-se de pegar o ID da <em>conta final</em> onde o anúncio roda, não o da MCC.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PASSO 2: CONVERSION ACTION --}}
                                <div class="card shadow-sm border-0 mb-5" id="google-step2">
                                    <div class="card-header bg-primary text-white py-3">
                                        <h5 class="mb-0 fw-bold">2. Criando a Ação de Conversão</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Precisamos dizer ao Google o que estamos enviando (ex: "Lead Qualificado" ou "Compra").</p>
                                        
                                        <div class="accordion" id="accordionConversion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#convStep1">
                                                        Passo a Passo no Painel
                                                    </button>
                                                </h2>
                                                <div id="convStep1" class="accordion-collapse collapse show" data-bs-parent="#accordionConversion">
                                                    <div class="accordion-body">
                                                        <ol>
                                                            <li>No Google Ads, clique em <strong>Metas (Goals)</strong> > <strong>Conversões</strong> > <strong>Resumo</strong>.</li>
                                                            <li>Clique no botão azul <strong>+ Nova ação de conversão</strong>.</li>
                                                            <li>Selecione a opção <strong>Importar</strong>.</li>
                                                            <li>Escolha <strong>CRMs, arquivos ou outras fontes de dados</strong> > <strong>Rastrear conversões de cliques</strong>.</li>
                                                            <li>Na seção "Fonte de Dados", pule a conexão direta e clique em "Pular esta etapa" (faremos via API).</li>
                                                            <li>Dê um nome (ex: "Lead Site") e salve.</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 p-3 bg-light rounded border">
                                            <h6 class="fw-bold"><i class="bi bi-search me-1"></i> Onde achar o Conversion Action ID?</h6>
                                            <p class="small mb-0">
                                                Infelizmente o Google esconde isso. O jeito mais fácil é: entre na conversão criada, olhe a <strong>URL do navegador</strong>. Procure por <code>ctId=123456789</code>. Esse número é o ID.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- PASSO 3: DEVELOPER TOKEN --}}
                                <div class="card shadow-sm border-0 mb-5" id="google-step3">
                                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold text-dark">3. Developer Token & API</h5>
                                        <span class="badge bg-secondary">Avançado</span>
                                    </div>
                                    <div class="card-body">
                                        <p>Para automação via API, é necessário um Token de Desenvolvedor da MCC.</p>
                                        <div class="alert alert-info">
                                            <strong>Nota:</strong> Se sua conta ainda não tem acesso à API, você pode usar o token de teste, mas as conversões não serão contabilizadas de verdade. Para produção, solicite o "Basic Access".
                                        </div>
                                        
                                        <h6 class="fw-bold mt-4">Manual de Refresh Token:</h6>
                                        <p>O Google exige OAuth2. Para gerar seu Refresh Token sem front-end (Server-to-Server):</p>
                                        <ol>
                                            <li>Acesse o <a href="https://developers.google.com/oauthplayground" target="_blank">OAuth 2.0 Playground</a>.</li>
                                            <li>Configure com suas credenciais de GCP (Client ID/Secret).</li>
                                            <li>Autorize o escopo <code>https://www.googleapis.com/auth/adwords</code>.</li>
                                            <li>Troque o código pelo token (Exchange Authorization Code).</li>
                                        </ol>
                                    </div>
                                </div>

                                {{-- PASSO 4: O SCRIPT --}}
                                <div class="card shadow-sm border-0 mb-5" id="google-script">
                                    <div class="card-header bg-dark text-white py-3">
                                        <h5 class="mb-0 fw-bold"><i class="bi bi-code-slash me-2"></i>4. Instalação do Script</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>O sistema precisa capturar o <code>gclid</code> da URL e salvá-lo no Cookie. Adicione este código no <code>&lt;head&gt;</code> do seu site:</p>

                                        <div class="position-relative">
<pre class="bg-light p-3 rounded border"><code>&lt;script&gt;
(function() {
    // 1. Tenta capturar o GCLID da URL
    const urlParams = new URLSearchParams(window.location.search);
    const gclid = urlParams.get('gclid');

    // 2. Se existir, salva no LocalStorage/Cookie por 90 dias
    if (gclid) {
        const expiryDate = new Date();
        expiryDate.setDate(expiryDate.getDate() + 90);
        document.cookie = "gclid=" + gclid + "; expires=" + expiryDate.toUTCString() + "; path=/";
        localStorage.setItem('gclid', gclid);
    }
})();
&lt;/script&gt;</code></pre>
                                        </div>
                                    </div>
                                </div>

                                {{-- O SEGREDO DO GCLID --}}
                                <div class="card border-primary border-2 mb-4" id="google-gclid">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary fw-bold">
                                            <i class="bi bi-lightning-charge-fill me-2"></i>
                                            Entendendo o Fluxo de Dados
                                        </h5>
                                        
                                        <div class="row mt-4 g-3">
                                            <div class="col-md-4">
                                                <div class="d-flex">
                                                    <div class="me-3 display-6 text-muted">1</div>
                                                    <div>
                                                        <strong>O Clique:</strong><br>
                                                        Usuário clica no anúncio. Google adiciona <code>?gclid=...</code> na URL.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex">
                                                    <div class="me-3 display-6 text-muted">2</div>
                                                    <div>
                                                        <strong>O Lead:</strong><br>
                                                        Usuário preenche o form no site.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex">
                                                    <div class="me-3 display-6 text-muted">3</div>
                                                    <div>
                                                        <strong>A Sincronização:</strong><br>
                                                        O sistema envia o GCLID + Evento para a API do Google.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE DOCUMENTAÇÃO: TIKTOK -->
    <div class="modal fade" id="tiktokDocsModal" tabindex="-1" aria-labelledby="tiktokDocsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="tiktokDocsModalLabel">
                        <i class="bi bi-tiktok me-2 text-dark"></i>Guia de Configuração: TikTok Ads
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="container-fluid py-4">
                        <div class="row">
                            {{-- SIDEBAR DE NAVEGAÇÃO RÁPIDA --}}
                            <div class="col-md-3 d-none d-md-block">
                                <div class="sticky-top" style="top: 0rem; z-index: 1000;">
                                    <div class="card border-0 shadow-sm bg-light">
                                        <div class="card-header bg-transparent fw-bold border-0">
                                            <i class="bi bi-list-ul me-2"></i> Índice
                                        </div>
                                        <div class="list-group list-group-flush bg-transparent">
                                            <a href="#intro" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('intro').scrollIntoView({behavior: 'smooth'})">Visão Geral</a>
                                            <a href="#step1" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('step1').scrollIntoView({behavior: 'smooth'})">1. Advertiser ID</a>
                                            <a href="#step2" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('step2').scrollIntoView({behavior: 'smooth'})">2. Pixel ID</a>
                                            <a href="#step3" class="list-group-item list-group-item-action bg-transparent border-0 small py-2" onclick="document.getElementById('step3').scrollIntoView({behavior: 'smooth'})">3. Access Token</a>
                                            <a href="#security" class="list-group-item list-group-item-action bg-transparent border-0 small py-2 text-success fw-bold" onclick="document.getElementById('security').scrollIntoView({behavior: 'smooth'})">Segurança & Dados</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CONTEÚDO PRINCIPAL --}}
                            <div class="col-md-9">
                                
                                {{-- CABEÇALHO --}}
                                <div class="d-flex align-items-center mb-4" id="intro">
                                    <div class="bg-dark text-white rounded p-3 me-3">
                                        <i class="bi bi-tiktok fs-2"></i>
                                    </div>
                                    <div>
                                        <h1 class="h3 mb-0 fw-bold">Guia de Integração: TikTok Ads</h1>
                                        <p class="text-muted mb-0">Como configurar a API de Conversões (Server-Side) do TikTok.</p>
                                    </div>
                                </div>

                                {{-- INTRODUÇÃO --}}
                                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-5" role="alert">
                                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                                    <div>
                                        <strong>Por que integrar?</strong>
                                        Esta integração permite enviar eventos (Leads, Compras) diretamente do nosso servidor para o TikTok, contornando bloqueadores de anúncios (AdBlockers) e as restrições do iOS 14+.
                                    </div>
                                </div>

                                {{-- PASSO 1: ADVERTISER ID --}}
                                <div class="card shadow-sm border-0 mb-5" id="step1">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-dark">1. Obtendo o Advertiser ID</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>O <strong>Advertiser ID</strong> é o identificador único da sua conta de anúncios.</p>
                                        <ol class="list-group list-group-numbered mb-3">
                                            <li class="list-group-item border-0">Acesse o <a href="https://ads.tiktok.com/" target="_blank" class="fw-bold text-decoration-none">TikTok Ads Manager</a>.</li>
                                            <li class="list-group-item border-0">Faça login na sua conta.</li>
                                            <li class="list-group-item border-0">Olhe para a barra superior (Header) ou verifique a URL do navegador.</li>
                                            <li class="list-group-item border-0">O ID geralmente começa com <code>adv-</code> ou é uma sequência numérica longa.</li>
                                        </ol>
                                        <div class="alert alert-light border">
                                            <small class="text-muted text-uppercase fw-bold">Exemplo de Formato:</small><br>
                                            <code>728192837192837</code>
                                        </div>
                                    </div>
                                </div>

                                {{-- PASSO 2: PIXEL ID --}}
                                <div class="card shadow-sm border-0 mb-5" id="step2">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 fw-bold text-dark">2. Obtendo o Pixel ID</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Precisamos vincular os eventos a um Pixel Web existente.</p>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Passo a Passo:</h6>
                                                <ol>
                                                    <li>No Ads Manager, vá em <strong>Assets</strong> > <strong>Events</strong>.</li>
                                                    <li>Clique em <strong>Web Events</strong>.</li>
                                                    <li>Selecione o Pixel que deseja usar ou crie um novo.</li>
                                                    <li>Copie o código numérico exibido abaixo do nome do Pixel (ID).</li>
                                                </ol>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bg-light p-3 rounded h-100 d-flex align-items-center justify-content-center text-center">
                                                    <div>
                                                        <i class="bi bi-code-slash fs-1 text-muted mb-2"></i>
                                                        <p class="small text-muted">Certifique-se de que o Pixel está configurado como "Developer Mode" ou "Events API" se solicitado.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PASSO 3: ACCESS TOKEN --}}
                                <div class="card shadow-sm border-0 mb-5" id="step3">
                                    <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold">3. Gerando o Access Token</h5>
                                        <span class="badge bg-warning text-dark">Avançado</span>
                                    </div>
                                    <div class="card-body">
                                        <p>O Token é a chave secreta que autoriza nosso sistema a falar com o TikTok.</p>
                                        
                                        <div class="accordion" id="accordionToken">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#method1">
                                                        Método Rápido (Pixel Settings)
                                                    </button>
                                                </h2>
                                                <div id="method1" class="accordion-collapse collapse show" data-bs-parent="#accordionToken">
                                                    <div class="accordion-body">
                                                        <ol>
                                                            <li>Nas configurações do seu Pixel (Web Events), vá na aba <strong>Settings</strong>.</li>
                                                            <li>Role até encontrar a seção <strong>Events API</strong>.</li>
                                                            <li>Clique em <strong>Generate Access Token</strong>.</li>
                                                            <li>Copie o código longo imediatamente. Ele não será mostrado novamente.</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#method2">
                                                        Método Desenvolvedor (App)
                                                    </button>
                                                </h2>
                                                <div id="method2" class="accordion-collapse collapse" data-bs-parent="#accordionToken">
                                                    <div class="accordion-body">
                                                        Se você tem um app no <a href="https://ads.tiktok.com/marketing_api/" target="_blank">TikTok for Business Developers</a>, gere o token através do fluxo OAuth2 no painel do desenvolvedor.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- NOTA DE SEGURANÇA --}}
                                <div class="card border-success border-2 mb-4" id="security">
                                    <div class="card-body">
                                        <h5 class="card-title text-success fw-bold">
                                            <i class="bi bi-shield-lock-fill me-2"></i>
                                            Segurança dos Dados
                                        </h5>
                                        <p class="card-text">
                                            Não se preocupe em colar seu Access Token aqui. Nosso sistema utiliza a arquitetura <strong>The Gem Standard</strong>:
                                        </p>
                                        <ul class="mb-0">
                                            <li>O Token é criptografado <strong>antes</strong> de ser salvo no banco de dados (`encrypted cast`).</li>
                                            <li>Em caso de vazamento do banco de dados, o token é ilegível.</li>
                                            <li>Apenas o servidor pode descriptografar para enviar os eventos.</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendi</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ativar aba baseada no hash da URL (ex: #google)
        var hash = window.location.hash;
        if (hash) {
            var triggerEl = document.querySelector('#integrationTabs button[data-bs-target="' + hash + '"]');
            if (triggerEl) {
                var tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }
        
        // Atualizar hash ao clicar
        var tabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabButtons.forEach(function(btn) {
            btn.addEventListener('shown.bs.tab', function (event) {
                var target = event.target.getAttribute('data-bs-target');
                history.replaceState(null, null, target);
            });
        });
    });
</script>
@endpush
