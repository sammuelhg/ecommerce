<!-- Offcanvas User/Login -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUser">
    <div class="offcanvas-header bg-primary text-white border-bottom">
        <h5 class="offcanvas-title fw-bold">
            <i class="bi bi-person-circle me-2"></i>
            @auth
                Minha Conta
            @else
                Entre ou Cadastre-se
            @endauth
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <!-- 1. BLOCO DE STORY (Condicional) -->
        @if(isset($storyStatus) && $storyStatus->hasActiveStories)
            <div class="p-3">
                <div class="story-card p-4 d-flex align-items-center justify-content-between shadow-sm" 
                     data-bs-toggle="modal" 
                     data-bs-target="#storyViewerModal"
                     style="cursor: pointer;">
                    <div>
                        <span class="badge bg-white text-dark mb-2 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Novidades</span>
                        <h4 class="fw-bold mb-0 lh-sm text-white">Ver Stories<br>da Loja</h4>
                    </div>
                    
                    <!-- Play Button with Pulse Effect -->
                    <div class="play-icon-wrapper rounded-circle bg-white d-flex align-items-center justify-content-center shadow" style="width: 48px; height: 48px;">
                        <i class="bi bi-play-fill fs-2" style="color: #d300c5; margin-left: 3px;"></i>
                    </div>
                </div>
                <style>
                    .story-card {
                        /* Faithful Instagram Gradient */
                        background: linear-gradient(45deg, #FFD600 0%, #FF7A00 25%, #FF0069 50%, #D300C5 75%, #833AB4 100%);
                        color: white;
                        border-radius: 16px;
                        transition: all 0.3s ease;
                        position: relative;
                        overflow: hidden;
                    }
                    .story-card:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
                    }
                    .story-card:active {
                        transform: scale(0.98);
                    }
                    .play-icon-wrapper {
                        transition: transform 0.3s ease;
                    }
                    .story-card:hover .play-icon-wrapper {
                        transform: scale(1.1);
                    }
                </style>
            </div>
        @endif
        @auth
            <!-- Usuário Logado -->
            <div class="p-4 border-bottom bg-light">
                <div class="d-flex align-items-center mb-3">
                    
                    <!-- Avatar Trigger Wrapper -->
                    <div class="position-relative me-3" 
                         @if(isset($storyStatus) && $storyStatus->hasActiveStories)
                             style="cursor: pointer;"
                             data-bs-toggle="modal" 
                             data-bs-target="#storyViewerModal"
                         @endif
                    >
                        <!-- Story Ring for Offcanvas (Active if stories exist) -->
                        @if(isset($storyStatus) && $storyStatus->hasActiveStories)
                            <div class="offcanvas-story-ring"></div>
                        @endif

                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center overflow-hidden position-relative"
                             style="width: 60px; height: 60px; font-size: 24px; z-index: 2; @if(isset($storyStatus) && $storyStatus->hasActiveStories) background-color: #1a1a1a !important; @endif">
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-100 h-100 object-fit-cover">
                        </div>
                    </div>

                    <div>
                        <h6 class="mb-0 fw-bold">{{ Auth::user()->name }}</h6>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                </div>
            </div>

            <!-- Styles for Offcanvas Ring -->
            <style>
                .offcanvas-story-ring {
                    position: absolute;
                    top: 50%; left: 50%;
                    transform: translate(-50%, -50%);
                    /* Avatar 60px. Gap 2px (start 58px). Ring 3px. */
                    /* Width = 60 + (2*2) + (3*2) ?? No, similar proprotion. */
                    /* Let's aim for 70px outer size to wrap 60px nicely */
                    width: 68px;
                    height: 68px;
                    border-radius: 50%;
                    background: linear-gradient(45deg, #FFD600 0%, #FF7A00 25%, #FF0069 50%, #D300C5 75%, #833AB4 100%);
                    z-index: 1;
                    /* Mask: 60px avatar. Ring starts at 60px? No "gap" inside. */
                    /* Let's do the "tuck under" trick again for seamless look */
                    /* Avatar 60px (R30). Mask start 28px (56px). */
                    /* Ring 68px (R34). 28/34 = 82% */
                    -webkit-mask: radial-gradient(farthest-side, transparent 82%, black 84%);
                    mask: radial-gradient(farthest-side, transparent 82%, black 84%);
                }
            </style>

            <!-- Menu do Usuário -->
            <div class="list-group list-group-flush">
                <a href="{{ route('customer.account.profile.edit') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-person me-2 text-primary"></i> Meu Perfil
                </a>
                <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-box-seam me-2 text-primary"></i> Meus Pedidos
                </a>
                <a href="#" class="list-group-item list-group-item-action"
                   data-bs-toggle="offcanvas"
                   data-bs-target="#offcanvasWishlist">
                    <i class="bi bi-heart me-2 text-danger"></i>
                    Lista de Desejos
                </a>
                <a href="{{ route('user.addresses') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-geo-alt me-2 text-primary"></i> Endereços
                </a>
                <a href="{{ route('user.payments') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-credit-card me-2 text-primary"></i> Formas de Pagamento
                </a>
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i> Admin
                </a>
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="list-group-item list-group-item-action text-danger border-top">
                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                    </button>
                </form>
            </div>
        @else
            <!-- Usuário NÃO Logado -->
            <div class="p-4">
                <div class="text-center mb-4">
                    @if(isset($storeSettings['profile_logo']))
                        <img src="{{ $storeSettings['profile_logo'] }}" alt="Logo Perfil" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <i class="bi bi-person-circle text-muted" style="font-size: 64px;"></i>
                    @endif
                    <p class="text-muted mt-3">Faça login para acessar sua conta e aproveitar todos os benefícios.</p>
                </div>

                <!-- Social Login Buttons (Above Tabs) -->
                <div class="d-flex gap-2 mb-4">
                    <a href="{{ route('social.redirect', 'google') }}" class="btn btn-light border flex-fill d-flex align-items-center justify-content-center" style="height: 40px;">
                        <img src="{{ asset('google.svg') }}" alt="Google" style="width: 20px; height: 20px;">
                    </a>
                    <a href="{{ route('social.redirect', 'facebook') }}" class="btn btn-primary flex-fill d-flex align-items-center justify-content-center" style="height: 40px; background-color: #1877F2; border-color: #1877F2;">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <hr class="flex-grow-1 my-0">
                    <span class="mx-2 text-muted small">ou</span>
                    <hr class="flex-grow-1 my-0">
                </div>

                <!-- Tabs Login/Registro -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link active w-100" id="login-tab" data-bs-toggle="tab"
                                data-bs-target="#login" type="button" role="tab">
                            Entrar
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="register-tab" data-bs-toggle="tab"
                                data-bs-target="#register" type="button" role="tab">
                            Cadastrar
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab Login -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control bg-white" id="email" name="email"
                                       placeholder="seu@email.com" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control bg-white" id="password" name="password"
                                       placeholder="••••••••" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Lembrar-me</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-semibold mb-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                            </button>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="btn btn-link w-100 text-center">
                                    Esqueci minha senha
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Tab Registro -->
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="reg_name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control bg-white" id="reg_name" name="name"
                                       placeholder="Seu nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg_email" class="form-label">E-mail</label>
                                <input type="email" class="form-control bg-white" id="reg_email" name="email"
                                       placeholder="seu@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg_password" class="form-label">Senha</label>
                                <input type="password" class="form-control bg-white" id="reg_password" name="password"
                                       placeholder="••••••••" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg_password_confirmation" class="form-label">Confirmar Senha</label>
                                <input type="password" class="form-control bg-white" id="reg_password_confirmation"
                                       name="password_confirmation" placeholder="••••••••" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Aceito os <a href="#">termos e condições</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-secondary w-100 fw-semibold">
                                <i class="bi bi-person-plus me-1"></i> Criar Conta
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Benefícios de Criar Conta -->
            <div class="bg-light p-3 border-top">
                <h6 class="fw-bold mb-3">Vantagens de ter uma conta:</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Acompanhe seus pedidos</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Acesso rápido ao carrinho</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Ofertas exclusivas</li>
                    <li class="mb-0"><i class="bi bi-check-circle-fill text-success me-2"></i> Checkout mais rápido</li>
                </ul>
            </div>
        @endguest
    </div>
</div>
