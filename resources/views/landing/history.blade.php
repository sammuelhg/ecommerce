@extends('layouts.minimal')

@section('title', 'Jaqueline | Moda & Propósito - Bairro Vitória')

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
        background-image: url('{{ asset("1001019203.jpg") }}');
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
                    O novo site chegou.<br>
                    <span class="text-warning">Bairro Vitória</span> também.
                </h1>
                
                <p class="lead text-light opacity-75 mb-5" style="max-width: 600px;">
                    Moda, atitude e propósito. Do consultório para o mundo, uma marca real para mulheres fortes.
                </p>

                <div class="d-flex justify-content-start gap-3 flex-wrap">
                    <a href="#sobre-parallax" class="btn btn-warning btn-lg rounded-0 fw-bold px-4">
                        <i class="bi bi-play-circle me-2"></i> Ver a História
                    </a>
                    <a href="#produtos" class="btn btn-outline-light btn-lg rounded-0 px-4">
                        Lista de Espera
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ asset('email-cards/693760a839a53_1765236904.jpg') }}" 
                         alt="Jaqueline - Bairro Vitória" 
                         class="img-fluid w-100 shadow-lg" 
                         style="object-fit: cover; min-height: 500px; border-radius: 4px;">
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- 2. A NOVA LOJA -->
<section id="loja" class="py-5 bg-black text-white">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-4 text-center text-lg-start">
                <span class="text-warning text-uppercase small fw-bold ls-1">O Ponto de Encontro</span>
                <h2 class="display-5 fw-bold mt-2">No coração do Bairro Vitória</h2>
            </div>
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 border border-secondary border-opacity-25 h-100">
                            <i class="bi bi-geo-alt fs-1 text-warning mb-3 d-block"></i>
                            <h4 class="h5">Proximidade Real</h4>
                            <p class="text-secondary small mb-0">Perto do consultório, onde a comunidade se encontra.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 border border-secondary border-opacity-25 h-100">
                            <i class="bi bi-bag-check fs-1 text-warning mb-3 d-block"></i>
                            <h4 class="h5">Retire na Loja</h4>
                            <p class="text-secondary small mb-0">Compre online, retire sem frete e tome um café conosco.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. SOBRE / HISTÓRIA -->
<section class="parallax-section bg-about" id="sobre-parallax" style="background-image: url('{{ asset('1001019203.jpg') }}');">
    <img src="{{ asset('1001019203.jpg') }}" style="display:none;" onerror="document.getElementById('sobre-parallax').style.backgroundImage = 'url(https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1888&auto=format&fit=crop)'">

    <div class="overlay" style="background: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 50%, rgba(0,0,0,0.2) 100%);"></div>

    <div class="container content-layer py-5">
        <div class="row">
            <div class="col-lg-6">
                <div class="glass-card p-5 border-start border-4 border-warning text-white">
                    <span class="text-warning text-uppercase fw-bold small mb-2 d-block">Dentista & Empreendedora</span>
                    <h2 class="display-4 fw-bold mb-4">A Virada.</h2>
                    
                    <div x-data="{ expanded: false }">
                        <p class="lead mb-4">
                            &quot;Tudo começou na academia. Eu via mulheres fortes querendo se sentir poderosas. Decidi que minha missão seria elevar essa autoestima.&quot;
                        </p>
                        
                        <div x-show="expanded" x-transition>
                            <p class="text-light opacity-75">
                                Unindo a disciplina do consultório com a paixão pela moda, criei um espaço onde cuidado e estilo andam juntos. 
                                A loja física é a materialização desse sonho.
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
            <h2 class="fw-bold">O Que Vem Por Aí</h2>
            <p class="text-secondary">Selecione seus interesses para a lista VIP.</p>
        </div>

        <div class="row g-4">
            <!-- Item 1 -->
            <div class="col-md-4" x-data="{ active: false }">
                <div class="card h-100 text-center py-5 px-4 bg-dark border-secondary" 
                     :class="active ? 'border-light' : 'border-dark'">
                    <div class="mb-4">
                        <span class="btn btn-outline-warning btn-icon-shape rounded-circle" style="width: 80px; height: 80px; font-size: 2rem; cursor: default;">
                            <i class="bi bi-lightning-charge"></i>
                        </span>
                    </div>
                    <h4 class="mb-3 text-white">Linha Power</h4>
                    <p class="text-secondary small mb-4">Alta compressão e tecnologia para treinos intensos.</p>
                    <button @click="active = !active" class="btn btn-sm w-100 rounded-0" 
                            :class="active ? 'btn-light' : 'btn-outline-light'">
                        <span x-text="active ? 'Interesse Registrado' : 'Tenho Interesse'"></span>
                    </button>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="col-md-4" x-data="{ active: false }">
                <div class="card h-100 text-center py-5 px-4 bg-dark border-secondary"
                     :class="active ? 'border-light' : 'border-dark'">
                    <div class="mb-4">
                        <span class="btn btn-outline-warning btn-icon-shape rounded-circle" style="width: 80px; height: 80px; font-size: 2rem; cursor: default;">
                            <i class="bi bi-briefcase"></i>
                        </span>
                    </div>
                    <h4 class="mb-3 text-white">Casual Chic</h4>
                    <p class="text-secondary small mb-4">Do trabalho ao happy hour. Blazers e cortes alfaiataria.</p>
                    <button @click="active = !active" class="btn btn-sm w-100 rounded-0"
                            :class="active ? 'btn-light' : 'btn-outline-light'">
                        <span x-text="active ? 'Interesse Registrado' : 'Tenho Interesse'"></span>
                    </button>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="col-md-4" x-data="{ active: false }">
                <div class="card h-100 text-center py-5 px-4 bg-dark border-secondary"
                     :class="active ? 'border-light' : 'border-dark'">
                    <div class="mb-4">
                        <span class="btn btn-outline-warning btn-icon-shape rounded-circle" style="width: 80px; height: 80px; font-size: 2rem; cursor: default;">
                            <i class="bi bi-gem"></i>
                        </span>
                    </div>
                    <h4 class="mb-3 text-white">Acessórios</h4>
                    <p class="text-secondary small mb-4">Os detalhes que transformam o look básico.</p>
                    <button @click="active = !active" class="btn btn-sm w-100 rounded-0"
                            :class="active ? 'btn-light' : 'btn-outline-light'">
                        <span x-text="active ? 'Interesse Registrado' : 'Tenho Interesse'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-5 text-center bg-black border-top border-secondary border-opacity-10">
    <div class="container">
        <h2 class="h4 fw-bold text-white mb-3">Sua nova versão começa aqui.</h2>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <button class="btn btn-warning rounded-0 fw-bold px-4">WhatsApp da Loja</button>
        </div>
        <p class="mt-5 text-secondary small">&copy; {{ date('Y') }} Jaqueline Store. Bairro Vitória.</p>
    </div>
</footer>
@endsection
