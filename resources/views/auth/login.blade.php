@extends('layouts.shop')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">Bem-vindo(a)</h2>
                <p class="text-muted">Acesse sua conta para continuar</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <!-- Tabs Login/Registro -->
                    <ul class="nav nav-pills nav-fill mb-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="login-tab" data-bs-toggle="tab"
                                    data-bs-target="#login" type="button" role="tab">
                                Entrar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="register-tab" data-bs-toggle="tab"
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
                                    <label for="login_email" class="form-label text-muted small fw-bold">E-MAIL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control bg-light border-start-0 ps-0" id="login_email" name="email"
                                               placeholder="seu@email.com" required autofocus autocomplete="username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label for="login_password" class="form-label text-muted small fw-bold">SENHA</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="small text-decoration-none">Esqueceu?</a>
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control bg-light border-start-0 ps-0" id="login_password" name="password"
                                               placeholder="••••••••" required autocomplete="current-password">
                                    </div>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label small" for="remember">Lembrar de mim</label>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">
                                    ENTRAR
                                </button>
                            </form>
                        </div>

                        <!-- Tab Registro -->
                        <div class="tab-pane fade" id="register" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="reg_name" class="form-label text-muted small fw-bold">NOME COMPLETO</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control bg-light border-start-0 ps-0" id="reg_name" name="name"
                                               placeholder="Seu nome" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg_email" class="form-label text-muted small fw-bold">E-MAIL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control bg-light border-start-0 ps-0" id="reg_email" name="email"
                                               placeholder="seu@email.com" required autocomplete="username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg_password" class="form-label text-muted small fw-bold">SENHA</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control bg-light border-start-0 ps-0" id="reg_password" name="password"
                                               placeholder="••••••••" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg_password_confirmation" class="form-label text-muted small fw-bold">CONFIRMAR SENHA</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control bg-light border-start-0 ps-0" id="reg_password_confirmation"
                                               name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label small" for="terms">
                                        Li e aceito os <a href="#">Termos de Uso</a>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-secondary w-100 fw-bold py-2">
                                    CRIAR CONTA
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Social Login -->
                    <div class="position-relative my-4 text-center">
                        <hr class="position-absolute w-100 top-50 my-0" style="z-index:1">
                        <span class="position-relative bg-white px-3 text-muted small" style="z-index:2">ou continue com</span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('social.redirect', 'google') }}" class="btn btn-outline-secondary flex-fill d-flex align-items-center justify-content-center">
                            <img src="{{ asset('google.svg') }}" alt="Google" style="width: 20px; height: 20px;" class="me-2">
                            Google
                        </a>
                        <a href="{{ route('social.redirect', 'facebook') }}" class="btn btn-outline-primary flex-fill d-flex align-items-center justify-content-center">
                            <i class="bi bi-facebook me-2"></i> Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
