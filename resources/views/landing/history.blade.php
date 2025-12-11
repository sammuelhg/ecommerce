@extends('layouts.minimal')

@section('title', 'Minha História | LosFit')

@section('content')
<style>
    /* Custom overrides for this landing page only, enabling the Dark/Gold theme */
    .bg-black-custom { background-color: #050505; }
    .text-gold { color: #ffc107 !important; } /* Fallback to standard warning color or custom hex */
    
    .parallax-section {
        position: relative;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .parallax-section {
            background-attachment: scroll;
            min-height: 80vh;
        }
    }

    .glass-card {
        background: rgba(20, 20, 20, 0.85);
        backdrop-filter: blur(10px);
    }
    
    /* Hero Background */
    .bg-hero {
        background-image: url('{{ asset("1001019228.jpg") }}');
        background-position: center top; 
    }
    
    /* About Background */
    .bg-about {
        background-image: url('{{ asset("uploads/parallax.jpg") }}');
        background-position: center top; 
    }
    
    /* Overlay */
    .overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.95));
        z-index: 1;
    }
    
    .content-layer {
        position: relative;
        z-index: 2;
    }

    /* DIGITAL CARD STYLES (Copied from /card) */
    :root {
      --brand-primary: #000000; 
      --text-color-dark: #1a1a1a;
      --text-color-light: #555555;
    }
    .custom-card {
      background-color: #ffffff;
      width: 340px;
      height: 200px;
      border-radius: 16px;
      border-top: 5px solid var(--brand-primary);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin: 0 auto; /* Center it */
    }
    .custom-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .card-main-content {
      display: flex;
      flex-direction: row;
      flex: 1;
      position: relative;
    }
    .card-image-section {
      width: 120px;
      background-color: #f9f9f9;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .card-image-section img.photo {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .card-image-section img.logo {
      max-width: 100px;
      height: auto;
    }
    .card-logo-corner {
      position: absolute;
      bottom: 10px;
      right: 10px;
      width: 52px;
      opacity: 0.9;
    }
    .card-text-section {
      flex: 1;
      padding: 12px 14px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .card-title {
      font-size: 14px;
      font-weight: 800;
      text-transform: uppercase;
      margin: 0 0 2px 0;
      color: var(--brand-primary);
      line-height: 1.2;
    }
    .card-subtitle {
      font-size: 9px;
      color: var(--text-color-light);
      text-transform: uppercase;
      margin: 0 0 10px 0;
    }
    .contact-list {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .contact-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .contact-item img {
      width: 16px;
      height: 16px;
    }
    .contact-link {
      font-size: 11px;
      font-weight: 600;
      color: var(--text-color-dark);
      text-decoration: none;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .card-footer {
      background-color: var(--brand-primary);
      color: #ffffff;
      padding: 6px;
      text-align: center;
      font-size: 10px;
      font-style: italic;
    }
</style>

<!-- 1. HERO SECTION -->
<section class="position-relative py-5 bg-dark d-flex align-items-center" style="min-height: 80vh;">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-6 text-start mb-5 mb-lg-0">
                
                <span class="badge bg-light text-dark mb-4 px-3 py-2 rounded-0 text-uppercase fw-bold ls-2">
                    Nova Coleção
                </span>
                
                <h1 class="display-3 fw-bold mb-4 text-white">
                    A Evolução da<br>
                    <span class="text-warning">LosFit</span> chegou.
                </h1>
                
                <p class="lead text-light opacity-75 mb-5" style="max-width: 600px;">
                    Saúde, Foco e Resultado. Uma marca pensada para mulheres que buscam performance e estilo em cada movimento.
                </p>

                <div class="d-flex justify-content-start gap-3 flex-wrap">
                    <a href="#sobre-parallax" class="btn btn-warning btn-lg rounded-0 fw-bold px-4">
                        <i class="bi bi-play-circle me-2"></i> Conheça a História
                    </a>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-light btn-lg rounded-0 px-4">
                        Ver Loja
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ asset('uploads/jacqueline_signature.webp') }}" 
                         alt="Jaqueline - CEO LosFit" 
                         class="img-fluid w-100 shadow-lg" 
                         style="object-fit: cover; min-height: 500px; border-radius: 4px;">
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- 2. A MARCA -->
<section id="loja" class="py-5 bg-black text-white">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-4 text-center text-lg-start">
                <span class="text-warning text-uppercase small fw-bold ls-1">Nossa Essência</span>
                <h2 class="display-5 fw-bold mt-2">Muito mais que roupa fitness</h2>
            </div>
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 border border-secondary border-opacity-25 h-100">
                            <i class="bi bi-heart-pulse fs-1 text-warning mb-3 d-block"></i>
                            <h4 class="h5">Cuidado e Conforto</h4>
                            <p class="text-secondary small mb-0">Peças desenvolvidas para abraçar seu corpo e potencializar seus treinos.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 border border-secondary border-opacity-25 h-100">
                            <i class="bi bi-box-seam fs-1 text-warning mb-3 d-block"></i>
                            <h4 class="h5">Entrega em Todo Brasil</h4>
                            <p class="text-secondary small mb-0">Receba seus looks favoritos com rapidez e segurança onde estiver.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. SOBRE / HISTÓRIA -->
<section class="parallax-section bg-about" id="sobre-parallax" style="background-image: url('{{ asset('uploads/parallax.jpg') }}');">
    <img src="{{ asset('uploads/parallax.jpg') }}" style="display:none;" onerror="document.getElementById('sobre-parallax').style.backgroundImage = 'url(https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1888&auto=format&fit=crop)'">

    <div class="overlay" style="background: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 50%, rgba(0,0,0,0.2) 100%);"></div>

    <div class="container content-layer py-5">
        <div class="row">
            <div class="col-lg-6">
                <div class="glass-card p-5 border-start border-4 border-warning text-white">
                    <span class="text-warning text-uppercase fw-bold small mb-2 d-block">CEO & Fundadora</span>
                    <h2 class="display-4 fw-bold mb-4">A Jornada LosFit.</h2>
                    
                    <div x-data="{ expanded: false }">
                        <p class="lead mb-4">
                            &quot;A LosFit nasceu de um desejo genuíno de transformar a relação das mulheres com o exercício físico. Eu queria criar algo que unisse estilo, funcionalidade e autoestima.&quot;
                        </p>
                        
                        <div x-show="expanded" x-transition>
                            <p class="text-light opacity-75">
                                Nossa missão é proporcionar peças que inspirem confiança. Cada detalhe, do tecido ao design, é pensado para que você se sinta poderosa enquanto cuida de si mesma. 
                                A LosFit não é apenas sobre roupas, é sobre um estilo de vida focado em saúde e resultados.
                            </p>
                        </div>

                        <button @click="expanded = !expanded" class="btn btn-link text-white p-0 text-decoration-none mt-2">
                            <span x-text="expanded ? 'Ler menos' : 'Ler história completa'"></span> 
                            <i class="bi" :class="expanded ? 'bi-arrow-up' : 'bi-arrow-down'"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. VALIDAÇÃO DE PRODUTOS -->
<section id="produtos" class="py-5 bg-black text-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nossas Coleções</h2>
            <p class="text-secondary">Descubra o que preparamos para você.</p>
        </div>

        <div class="row g-4">
            <!-- Item 1: Linha Power (ModaFit) -->
            <div class="col-md-4">
                <div class="card h-100 text-center py-5 px-4 bg-dark border-secondary">
                    <div class="mb-4">
                        <span class="btn btn-outline-warning btn-icon-shape rounded-circle" style="width: 80px; height: 80px; font-size: 2rem; cursor: default;">
                            <i class="bi bi-lightning-charge"></i>
                        </span>
                    </div>
                    <h4 class="mb-3 text-white">Linha Power</h4>
                    <p class="text-secondary small mb-4">Alta compressão e tecnologia para seus treinos mais intensos.</p>
                    <a href="{{ route('shop.category', 'fit') }}" class="btn btn-outline-light btn-sm w-100 rounded-0">
                        Ver Coleção
                    </a>
                </div>
            </div>

            <!-- Item 2: Suplementos (LosfitNutri) -->
            <div class="col-md-4">
                <div class="card h-100 text-center py-5 px-4 bg-dark border-secondary">
                    <div class="mb-4">
                        <span class="btn btn-outline-warning btn-icon-shape rounded-circle" style="width: 80px; height: 80px; font-size: 2rem; cursor: default;">
                            <i class="bi bi-capsule"></i>
                        </span>
                    </div>
                    <h4 class="mb-3 text-white">Suplementos</h4>
                    <p class="text-secondary small mb-4">
                        <strong class="text-warning">LosfitNutri</strong>: Potencialize seus resultados com nossa linha exclusiva.
                    </p>
                    <a href="{{ route('shop.category', 'suplementos') }}" class="btn btn-outline-light btn-sm w-100 rounded-0">
                        Ver Produtos
                    </a>
                </div>
            </div>

            <!-- Item 3: Acessórios -->
            <div class="col-md-4">
                <div class="card h-100 text-center py-5 px-4 bg-dark border-secondary">
                    <div class="mb-4">
                        <span class="btn btn-outline-warning btn-icon-shape rounded-circle" style="width: 80px; height: 80px; font-size: 2rem; cursor: default;">
                            <i class="bi bi-gem"></i>
                        </span>
                    </div>
                    <h4 class="mb-3 text-white">Acessórios</h4>
                    <p class="text-secondary small mb-4">Os detalhes essenciais para completar seu look.</p>
                    <a href="{{ route('shop.category', 'acessorios') }}" class="btn btn-outline-light btn-sm w-100 rounded-0">
                        Ver Coleção
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. CEO & ORIGEM -->
<section class="py-5 bg-dark text-white border-top border-secondary border-opacity-10">
    <div class="container py-5">
        <div class="row align-items-center gx-5">
            <!-- Left: Story -->
            <div class="col-lg-7 mb-5 mb-lg-0">
                <span class="text-warning text-uppercase fw-bold ls-1 small mb-2 d-block">A Origem</span>
                <h2 class="display-5 fw-bold mb-4">Por que LosFit?</h2>
                <p class="lead text-white fs-4 mb-4">
                    "A ideia de abrir essa loja maravilhosa não foi por acaso. Ela nasceu de uma necessidade real aqui no <strong>Bairro Vitória</strong>."
                </p>
                <p class="text-white fs-5 mb-4" style="line-height: 1.8;">
                    Eu percebia uma grande demanda das mulheres da nossa região por moda fitness que unisse qualidade, beleza e sofisticação. 
                    Muitas vezes, pessoas de bom gosto precisavam ir longe para encontrar peças que realmente valessem a pena.<br><br>
                    Foi pensando nisso que decidi trazer para perto de você o que há de melhor. A LosFit é a resposta para quem não abre mão de treinar com estilo e conforto, sem precisar sair do nosso bairro.
                    Aqui, o bom gosto mora ao lado.
                </p>
            </div>

            <!-- Right: CEO Card -->
            <div class="col-lg-5">
                @php
                    $ceoCard = \App\Models\EmailCard::active()->first();
                @endphp
                
                @if($ceoCard)
                    <x-email.digital-card :card="$ceoCard" />
                @else
                    <div class="alert alert-warning">Card não encontrado. Configure em Admin > Email Cards.</div>
                @endif
            </div>
        </div>

        <!-- Centralized Logo -->
        <div class="text-center mt-5 pt-4">
             <img src="{{ asset('logo.svg') }}" alt="LosFit" style="height: 70px; width: auto;">
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-5 text-center bg-black border-top border-secondary border-opacity-10">
    <div class="container">
        <h2 class="h4 fw-bold text-white mb-3">Seja sua melhor versão.</h2>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="https://wa.me/55999999999" class="btn btn-warning rounded-0 fw-bold px-4">WhatsApp da Loja</a>
        </div>
        <p class="mt-5 text-secondary small">&copy; {{ date('Y') }} LosFit. Todos os direitos reservados.</p>
    </div>
</footer>
@endsection
