@extends('emails.layout')

@section('content')
    <!-- Título -->
    <h1 style="margin: 0; color: #000000; font-size: 24px; font-weight: 800; text-transform: uppercase; letter-spacing: -0.5px; line-height: 1.2;">
        Bem-vindo(a)!
    </h1>
    <p style="margin: 5px 0 20px 0; color: #555555; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">
        {{ $user->name }}
    </p>

    <div style="border-top: 1px solid #e0e0e0; margin-bottom: 20px; width: 100%;"></div>

    <p style="color: #333; font-size: 15px; line-height: 1.6;">
        Sua conta foi criada com sucesso! Aproveite nossas ofertas exclusivas.
    </p>

    <!-- Credenciais -->
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 3px solid #000;">
        <p style="margin: 5px 0; font-size: 13px; color: #555;"><strong>EMAIL</strong></p>
        <p style="margin: 0 0 10px 0; font-size: 15px; font-weight: 600;">{{ $user->email }}</p>
        
        @if($password)
        <p style="margin: 5px 0; font-size: 13px; color: #555;"><strong>SENHA</strong></p>
        <p style="margin: 0; font-size: 15px; font-weight: 600;">{{ $password }}</p>
        @endif
    </div>

    <div style="text-align: center; margin: 25px 0;">
        <a href="{{ $loginUrl }}" class="btn-primary">Acessar Loja</a>
    </div>
@endsection

